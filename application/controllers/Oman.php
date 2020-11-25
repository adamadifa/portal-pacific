<?php

class Oman extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_oman', 'Model_cabang'));
  }

  function index()
  {
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(

        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }

    $data['tahun']      = date("Y");
    $data['bulan']      = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']        = $bulan;
    $data['thn']        = $tahun;
    $data['oman']  = $this->Model_oman->view_oman($bulan, $tahun)->result();
    $this->template->load('template/template', 'oman/view_oman', $data);
  }
  // function index()
  // {
  //   $data['oman']  = $this->Model_oman->view_oman()->result();
  //   $this->template->load('template/template', 'oman/view_oman', $data);
  // }

  function omancabang()
  {
    $bulan            = "";
    $tahun            = "";
    $cbg              = "";
    if ($this->input->post('submit') != NULL) {
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $cbg       = $this->input->post('cabang');
      $data   = array(
        'cbg'     => $cbg,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
    }

    $data['tahun']      = date("Y");
    $data['bulan']      = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']        = $bulan;
    $data['thn']        = $tahun;
    $data['cbg']        = $cbg;
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['oman']  = $this->Model_oman->view_oman_cabang($bulan, $tahun, $cbg)->result();
    $this->template->load('template/template', 'oman/view_oman_cabang', $data);
  }
  function input_oman()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->insert_oman();
    } else {
      $data['produk']   = $this->Model_oman->listproduk()->result();
      $this->template->load('template/template', 'oman/input_oman', $data);
    }
  }

  function input_oman_cabang()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->insert_oman_cabang();
    } else {
      $data['cabang'] = $this->Model_cabang->view_cabang()->result();
      $data['produk']   = $this->Model_oman->listproduk()->result();
      $this->template->load('template/template', 'oman/input_oman_cabang', $data);
    }
  }

  function loadformoman()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;
    $data['produk']   = $this->Model_oman->listproduk()->result();
    $this->load->view('oman/loadformoman', $data);
  }

  function edit_oman()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->update_oman();
    } else {
      $no_order       = $this->uri->segment(3);
      $data['oman']    = $this->Model_oman->getOman($no_order)->row_array();
      $data['produk']   = $this->Model_oman->listproduk()->result();
      $this->template->load('template/template', 'oman/edit_oman', $data);
    }
  }

  function edit_omancabang()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->update_omancabang();
    } else {
      $no_order = $this->uri->segment(3);
      $data['oman'] = $this->Model_oman->getOmanCabang($no_order)->row_array();
      $data['cabang'] = $this->Model_cabang->view_cabang()->result();
      $data['produk'] = $this->Model_oman->listproduk()->result();
      $this->template->load('template/template', 'oman/edit_oman_cabang', $data);
    }
  }
  function cek_oman()
  {
    $tahun     = $this->input->post('tahun');
    $bulan     = $this->input->post('bulan');
    $cek_oman = $this->Model_oman->cek_oman($bulan, $tahun)->num_rows();
    echo $cek_oman;
  }

  function cek_oman_cabang()
  {
    $tahun     = $this->input->post('tahun');
    $bulan     = $this->input->post('bulan');
    $cabang    = $this->input->post('cabang');
    $cek_oman = $this->Model_oman->cek_oman_cabang($bulan, $tahun, $cabang)->num_rows();
    echo $cek_oman;
  }

  function detail_oman()
  {
    $no_order       = $this->input->post('no_order');
    $data['oman']    = $this->Model_oman->getOman($no_order)->row_array();
    $data['produk'] = $this->Model_oman->listproduk()->result();
    $this->load->view('oman/detail_oman', $data);
  }

  function detail_oman_cabang()
  {
    $no_order       = $this->input->post('no_order');
    $data['oman']    = $this->Model_oman->getOmanCabang($no_order)->row_array();
    $data['produk'] = $this->Model_oman->listproduk()->result();
    $this->load->view('oman/detail_oman_cabang', $data);
  }

  function hapus()
  {
    $no_order = $this->uri->segment(3);
    $this->Model_oman->hapus($no_order);
  }

  function hapusomancabang()
  {
    $no_order = $this->uri->segment(3);
    $this->Model_oman->hapusomancabang($no_order);
  }

  function view_omanmkt()
  {
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(

        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }

    $data['tahun']      = date("Y");
    $data['bulan']      = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']        = $bulan;
    $data['thn']        = $tahun;
    $data['oman']  = $this->Model_oman->view_oman($bulan, $tahun)->result();
    $this->template->load('template/template', 'oman/view_omanmkt', $data);
  }

  function input_permintaan()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->insert_permintaan();
    } else {
      $data['no_order']        = $this->uri->segment(3);
      $oman                    = $this->Model_oman->getOman($data['no_order'])->row_array();
      $data['oman']            = $oman;
      $permintaan             = $this->Model_oman->cek_nopermintaan()->row_array();
      $no_terakhir             = $permintaan['no_permintaan'];
      $tahun                   = date('y');
      if ($oman['bulan'] > 9) {
        $bulan = $oman['bulan'];
      } else {
        $bulan = "0" . $oman['bulan'];
      }
      $no_permintaan           = buatkode($no_terakhir, 'PP' . $bulan . $tahun, 3);
      $data['no_permintaan']  = $no_permintaan;
      $data['produk']         = $this->Model_oman->listproduk()->result();
      $this->template->load('template/template', 'oman/input_permintaan', $data);
    }
  }

  function detail_permintaan()
  {
    $no_order           = $this->input->post('no_order');
    $oman                = $this->Model_oman->getOman($no_order)->row_array();
    $data['oman']        = $oman;
    $permintaan          = $this->Model_oman->get_permintaan($no_order)->row_array();
    $data['permintaan']  = $permintaan;
    $data['detail']     = $this->Model_oman->detail_permintaan($permintaan['no_permintaan'])->result();
    $this->load->view('oman/detail_permintaan', $data);
  }

  function permintaan_produksi()
  {
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(

        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }

    $data['tahun']      = date("Y");
    $data['bulan']      = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']        = $bulan;
    $data['thn']        = $tahun;
    $data['permintaan'] = $this->Model_oman->view_permintaanproduksi($bulan, $tahun)->result();
    $this->template->load('template/template', 'oman/view_permintaanproduksi', $data);
  }


  function hapus_permintaan()
  {
    $no_permintaan = $this->uri->segment(3);
    $no_order      = $this->uri->segment(4);
    $this->Model_oman->hapus_permintaan($no_permintaan, $no_order);
  }


  function permintaan_produksi_acc()
  {

    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(

        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }

    $data['tahun']      = date("Y");
    $data['bulan']      = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']        = $bulan;
    $data['thn']        = $tahun;
    $data['permintaan'] = $this->Model_oman->view_permintaanproduksi($bulan, $tahun)->result();
    $this->template->load('template/template', 'oman/view_permintaanproduksi_acc', $data);
  }


  function approve_permintaan()
  {
    $no_permintaan = $this->uri->segment(3);
    $no_oman        = $this->uri->segment(4);
    $this->Model_oman->approve_permintaan($no_permintaan, $no_oman);
  }

  function cancel_permintaan()
  {
    $no_permintaan = $this->uri->segment(3);
    $no_oman         = $this->uri->segment(4);
    $this->Model_oman->cancel_permintaan($no_permintaan, $no_oman);
  }



  function permintaan_pengiriman($rowno = 0)
  {
    // Search text
    $no_permintaan    = "";
    $tgl_permintaan  = "";
    if ($this->input->post('submit') != NULL) {
      $no_permintaan     = $this->input->post('no_permintaan');
      $tgl_permintaan   = $this->input->post('tgl_permintaan');
      $data   = array(
        'no_permintaan'     => $no_permintaan,
        'tgl_permintaan'  => $tgl_permintaan
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_permintaan') != NULL) {
        $nomutasi = $this->session->userdata('no_permintaan');
      }
      if ($this->session->userdata('tgl_permintaan') != NULL) {
        $tgl_permintaan = $this->session->userdata('tgl_permintaan');
      }
    }

    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_oman->getrecordPermintaanPengirimanCount($no_permintaan, $tgl_permintaan);
    // Get records
    $users_record = $this->Model_oman->getDataPermintaanPengiriman($rowno, $rowperpage, $no_permintaan, $tgl_permintaan);


    // Pagination Configuration
    $config['base_url']         = base_url() . 'oman/permintaan_pengiriman';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']         = $this->pagination->create_links();
    $data['result']             = $users_record;
    $data['row']                 = $rowno;
    $data['no_permintaan']       = $no_permintaan;
    $data['tgl_permintaan']      = $tgl_permintaan;
    // Load view
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'oman/permintaan_pengiriman', $data);
  }

  function buat_nomor_permintaan()
  {
    $tgl_permintaan = $this->input->post('tgl_permintaan');
    $cabang          = $this->input->post('cabang');
    $permintaan     = $this->Model_oman->getNoPermintaanLast($cabang, $tgl_permintaan)->row_array();
    $b               = array("", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
    $tanggal         = explode("-", $tgl_permintaan);
    $hari           = $tanggal[2];
    $bulan           = $tanggal[1];
    if ($bulan > 9) {
      $bl = $bulan;
    } else {
      $bl = substr($bulan, 1, 1);
    }
    //echo $bl;
    $tahun           = $tanggal[0];
    $tgl             = "." . $hari . "." . $bl . "." . $tahun;
    $nomor_terakhir  = $permintaan['no_permintaan_pengiriman'];
    $no_permintaan   = buatkode($nomor_terakhir, "OR" . $cabang, 2) . $tgl;
    echo $no_permintaan;
  }

  function view_barang()
  {
    $data['produk'] = $this->Model_oman->listproduk()->result();
    $this->load->view('oman/view_barang', $data);
  }


  function insert_detailpermintaantmp()
  {
    $cek   = $this->Model_oman->cek_detailpermintaantmp()->num_rows();
    if ($cek == 1) {
      echo "1";
    } else {
      $this->Model_oman->insert_detailpermintaanpengirimantmp();
    }
  }


  function view_detail_permintaan_pengiriman_temp()
  {
    $data['detail']  = $this->Model_oman->view_detail_permintaan_pengiriman_temp()->result();
    $this->load->view('oman/view_detail_permintaan_pengiriman_temp', $data);
  }

  function hapus_detail_permintaan_pengiriman()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->Model_oman->hapus_detail_permintaan_pengiriman($kode_produk);
  }

  function cek_detailpermintaanpengiriman()
  {
    $cek = $this->db->get('detail_permintaan_pengiriman_temp')->num_rows();
    if ($cek != 0) {
      echo "1";
    }
  }

  function input_permintaan_pengiriman()
  {
    $this->Model_oman->insert_permintaan_pengiriman();
  }


  function detail_permintaan_pengiriman()
  {
    $no_permintaan     = $this->input->post('no_permintaan');
    $data['pp']        = $this->Model_oman->getPermintaanpengiriman($no_permintaan)->row_array();
    $sj                = $this->Model_oman->getSuratJalanPP($no_permintaan)->row_array();
    $data['sj']        = $sj;
    $data['detail']   = $this->Model_oman->detailsuratjalan($sj['no_mutasi_gudang'])->result();
    $this->load->view('oman/detail_permintaan_pengiriman', $data);
  }

  function detail_permintaan_pengiriman_gj()
  {
    $no_permintaan     = $this->input->post('no_permintaan');
    $data['pp']        = $this->Model_oman->getPermintaanpengiriman($no_permintaan)->row_array();
    $this->load->view('oman/detail_permintaan_pengiriman_gj', $data);
  }

  function detailpp()
  {
    $no_permintaan     = $this->uri->segment(3);
    $data['detail']    = $this->Model_oman->detailpp($no_permintaan)->result();
    $this->load->view('oman/detail_pp', $data);
  }

  function detailpp_gj()
  {
    $no_permintaan     = $this->uri->segment(3);
    $data['detail']    = $this->Model_oman->detailpp($no_permintaan)->result();
    $this->load->view('oman/detail_pp_gj', $data);
  }


  function update_detailpermintaan()
  {
    $no_permintaan   = $this->input->post('no_permintaan');
    $kode_produk     = $this->input->post('kode_produk');
    $this->Model_oman->update_detailpermintaan($no_permintaan, $kode_produk);
  }

  function deletedetail()
  {
    $no_permintaan   = $this->input->post('no_permintaan');
    $kode_produk     = $this->input->post('kode_produk');
    $this->Model_oman->deletedetail($no_permintaan, $kode_produk);
  }

  function view_dbarang()
  {
    $data['produk'] = $this->Model_oman->listproduk()->result();
    $this->load->view('oman/view_dbarang', $data);
  }
  function hapus_permintaanpengiriman()
  {
    $no_permintaan = $this->uri->segment(3);
    $hal            = $this->uri->segment(4);
    $this->Model_oman->hapus_permintaanpengiriman($no_permintaan, $hal);
  }

  function view_suratjalan($rowno = 0)
  {
    // Search text
    $sess_cab           = $this->session->userdata('cabang');
    if ($sess_cab == 'pusat') {
      $cbg   = "";
    } else {
      $cbg   = $sess_cab;
    }
    $no_permintaan    = "";
    $tgl_permintaan  = "";
    if ($this->input->post('submit') != NULL) {
      $no_permintaan   = $this->input->post('no_permintaan');
      $tgl_permintaan = $this->input->post('tgl_permintaan');
      $cbg            = $this->input->post('cabang');
      $data = array(
        'no_permintaan'     => $no_permintaan,
        'tgl_permintaan'  => $tgl_permintaan,
        'cbg'              => $cbg
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_permintaan') != NULL) {
        $nomutasi = $this->session->userdata('no_permintaan');
      }
      if ($this->session->userdata('tgl_permintaan') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_permintaan');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cbg = $this->session->userdata('cbg');
      }
    }

    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_oman->getrecordPermintaanPengirimanCount($no_permintaan, $tgl_permintaan, $cbg);
    // Get records
    $users_record = $this->Model_oman->getDataPermintaanPengiriman($rowno, $rowperpage, $no_permintaan, $tgl_permintaan, $cbg);

    // Pagination Configuration
    $config['base_url']           = base_url() . 'oman/view_suratjalan';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']         = $allcount;
    $config['per_page']           = $rowperpage;
    $config['first_link']         = 'First';
    $config['last_link']          = 'Last';
    $config['next_link']          = 'Next';
    $config['prev_link']          = 'Prev';
    $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']     = '</ul></nav></div>';
    $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']      = '</span></li>';
    $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']    = '</span>Next</li>';
    $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close']   = '</span></li>';
    $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']    = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_permintaan']         = $no_permintaan;
    $data['tgl_permintaan']        = $tgl_permintaan;
    $data['cbg']                = $cbg;
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    // Load view
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'oman/surat_jalan', $data);
  }

  function input_suratjalan()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->insert_suratjalan();
    } else {
      $no_permintaan     = $this->input->post('no_permintaan');
      $data['produk']    = $this->Model_oman->listproduk()->result();
      $data['pp']        = $this->Model_oman->getPermintaanpengiriman($no_permintaan)->row_array();
      $this->load->view('oman/input_suratjalan', $data);
    }
  }

  function insert_detailsuratjalantemp()
  {
    $this->Model_oman->insert_detailsuratjalantemp();
  }

  function detailsjtemp()
  {
    $no_permintaan     = $this->uri->segment(3);
    $data['detail']    = $this->Model_oman->detailsjtemp($no_permintaan)->result();
    $this->load->view('oman/detailsjtemp', $data);
  }

  function deletedetailsjtemp()
  {
    $no_permintaan   = $this->input->post('no_permintaan');
    $kode_produk     = $this->input->post('kode_produk');
    $this->Model_oman->deletedetailsjtemp($no_permintaan, $kode_produk);
  }


  function buat_nomor_sj()
  {
    $tgl_sj     = $this->input->post('tgl_sj');
    $cabang      = $this->input->post('cabang');
    $sj         = $this->Model_oman->getNoSJLast($cabang, $tgl_sj)->row_array();
    $b           = array("", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
    $tanggal     = explode("-", $tgl_sj);
    $hari       = $tanggal[2];
    $bulan       = $tanggal[1];
    if ($bulan > 9) {
      $bl = $bulan;
    } else {
      $bl = substr($bulan, 1, 1);
    }
    //echo $bl;
    $tahun           = $tanggal[0];
    $tgl             = "." . $hari . "." . $bl . "." . $tahun;
    $nomor_terakhir  = $sj['no_suratjalan'];
    $no_sj           = buatkode($nomor_terakhir, "SJ" . $cabang, 2) . $tgl;
    echo $no_sj;
  }


  function cek_detailsuratjalan()
  {
    $cek = $this->db->get('detail_mutasi_gudang_temp')->num_rows();
    if ($cek != 0) {
      echo "1";
    }
  }
  function detail_sj()
  {
    $no_sj           = $this->input->post('no_sj');
    $data['sj']      = $this->Model_oman->getSuratJalan($no_sj)->row_array();
    $data['detail'] = $this->Model_oman->detailsuratjalan($no_sj)->result();
    $this->load->view('oman/detail_suratjalan', $data);
  }

  function detail_sjcab()
  {
    $no_sj           = $this->input->post('no_sj');
    $data['sj']      = $this->Model_oman->getSuratJalan($no_sj)->row_array();
    $data['detail'] = $this->Model_oman->detailsuratjalan($no_sj)->result();
    $this->load->view('oman/detail_suratjalancab', $data);
  }

  function hapus_sj()
  {
    $no_permintaan = $this->uri->segment(4);
    $no_sj           = $this->uri->segment(3);
    $hal            = $this->uri->segment(5);
    $this->Model_oman->hapus_sj($no_permintaan, $no_sj, $hal);
  }


  function suratjalan($rowno = 0)
  {
    error_reporting(0);
    // Search text
    $no_sj   = "";
    $tgl_sj  = "";
    $cabang  = "";
    if ($this->input->post('submit') != NULL) {
      $no_sj     = $this->input->post('no_sj');
      $tgl_sj   = $this->input->post('tgl_sj');
      $cabang   = $this->input->post('cabang');
      $data     = array(
        'no_sj'     => $no_sj,
        'tgl_sj'  => $tgl_sj,
        'cbg'     => $cabang
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_sj') != NULL) {
        $no_sj = $this->session->userdata('no_sj');
      }
      if ($this->session->userdata('tgl_sj') != NULL) {
        $tgl_sj = $this->session->userdata('tgl_sj');
      }

      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
    }

    // Row per page
    $rowperpage = 20;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_oman->getrecordSuratJalanCount($no_sj, $tgl_sj, $cabang);
    // Get records
    $users_record = $this->Model_oman->getDataSuratjalan($rowno, $rowperpage, $no_sj, $tgl_sj, $cabang);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'oman/suratjalan';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']   = $this->pagination->create_links();
    $data['result']       = $users_record;
    $data['row']           = $rowno;
    $data['no_sj']         = $no_sj;
    $data['tgl_sj']        = $tgl_sj;
    $data['cabang']       = $cabang;
    $data['cbg']           = $this->Model_cabang->view_cabang()->result();
    // Load view
    $this->template->load('template/template', 'oman/surat_jalan_gj', $data);
  }

  function suratjalan_gjcab($rowno = 0)
  {
    error_reporting(0);
    // Search text
    $no_sj   = "";
    $tgl_sj  = "";
    if ($this->input->post('submit') != NULL) {
      $no_sj     = $this->input->post('no_sj');
      $tgl_sj   = $this->input->post('tgl_sj');
      $data   = array(
        'no_sj'     => $no_sj,
        'tgl_sj'  => $tgl_sj
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_sj') != NULL) {
        $no_sj = $this->session->userdata('no_sj');
      }
      if ($this->session->userdata('tgl_sj') != NULL) {
        $tgl_sj = $this->session->userdata('tgl_sj');
      }
    }

    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_oman->getrecordSuratJalanCount($no_sj, $tgl_sj);
    // Get records
    $users_record = $this->Model_oman->getDataSuratjalan($rowno, $rowperpage, $no_sj, $tgl_sj);

    // Pagination Configuration
    $config['base_url']         = base_url() . 'oman/suratjalan_gjcab';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;

    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']         = $this->pagination->create_links();
    $data['result']             = $users_record;
    $data['row']                 = $rowno;
    $data['no_sj']               = $no_sj;
    $data['tgl_sj']              = $tgl_sj;

    // Load view
    $this->template->load('template/template', 'oman/suratjalan_gjcab', $data);
  }


  function input_suratjalanacc()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->input_suratjalanacc();
    } else {
      $no_sj               = $this->input->post('no_sj');
      $data['sj']          = $this->Model_oman->getSuratJalan($no_sj)->row_array();
      $data['detail']     = $this->Model_oman->detailsuratjalan($no_sj)->result();
      $this->load->view('oman/input_suratjalanacc', $data);
    }
  }


  function cancel_suratjalan_gjcab()
  {
    $no_mutasi_gudang = $this->uri->segment(3);
    $hal               = $this->uri->segment(4);
    $to               = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $no_mutasi_gudang, 'jenis_mutasi' => 'TRANSIT OUT'))->row_array();
    $tin               = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $no_mutasi_gudang, 'jenis_mutasi' => 'TRANSIT IN'))->row_array();
    $no_to             = $to['no_mutasi_gudang_cabang'];
    $no_tin           = $tin['no_mutasi_gudang_cabang'];
    $this->Model_oman->cancel_suratjalan_gjcab($no_mutasi_gudang, $no_to, $no_tin, $hal);
  }


  function transit_in($rowno = 0)
  {
    // Search text
    $no_sj   = "";
    $tgl_sj  = "";
    if ($this->input->post('submit') != NULL) {
      $no_sj     = $this->input->post('no_sj');
      $tgl_sj   = $this->input->post('tgl_sj');
      $data     = array(
        'no_sj'     => $no_sj,
        'tgl_sj'  => $tgl_sj
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_sj') != NULL) {
        $no_sj = $this->session->userdata('no_sj');
      }
      if ($this->session->userdata('tgl_permintaan') != NULL) {
        $tgl_sj = $this->session->userdata('tgl_sj');
      }
    }

    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_oman->getrecordTOCount($no_sj, $tgl_sj);
    // Get records
    $users_record = $this->Model_oman->getDataTO($rowno, $rowperpage, $no_sj, $tgl_sj);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'oman/transit_in';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']         = $this->pagination->create_links();
    $data['result']             = $users_record;
    $data['row']                 = $rowno;
    $data['no_sj']               = $no_sj;
    $data['tgl_sj']              = $tgl_sj;
    // Load view
    $this->template->load('template/template', 'oman/transit_in', $data);
  }


  function input_transit_in()
  {
    if (isset($_POST['submit'])) {
      $this->Model_oman->insert_transit_in();
    } else {
      $no_sj             = $this->input->post('no_sj');
      $no_to             = $this->input->post('no_to');
      $data['no_to']    = $no_to;
      $data['sj']        = $this->Model_oman->getSuratJalan($no_sj)->row_array();
      $data['detail']   = $this->Model_oman->detailsuratjalan($no_sj)->result();
      $this->load->view('oman/input_transit_in', $data);
    }
  }

  function cancel_transit_in()
  {
    $no_mutasi_gudang = $this->uri->segment(3);
    $tin               = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $no_mutasi_gudang, 'jenis_mutasi' => 'TRANSIT IN'))->row_array();
    $no_tin           = $tin['no_mutasi_gudang_cabang'];
    $this->Model_oman->cancel_transit_in($no_mutasi_gudang, $no_tin);
  }

  function cek_stokgudang()
  {
    $kodeproduk       = $this->input->post('kodeproduk');
    $cek_stokgudang    = $this->Model_oman->cek_stokgudang($kodeproduk)->row_array();
    echo $cek_stokgudang['stokakhir'];
  }

  function cek_stokgudangcabang()
  {
    $kodeproduk       = $this->input->post('kodeproduk');
    $cek_stokgudang    = $this->Model_oman->cek_stokgudangcabang($kodeproduk)->row_array();
    echo $cek_stokgudang['stokakhir'];
  }


  function cek_stokgudangcabangbs()
  {
    $kodeproduk       = $this->input->post('kodeproduk');
    $cek_stokgudang    = $this->Model_oman->cek_stokgudangcabangbs($kodeproduk)->row_array();
    echo $cek_stokgudang['stokakhir'];
  }

  function cetak_suratjalan()
  {
    $no_suratjalan       = $this->uri->segment(3);
    $data['sj']            = $this->Model_oman->get_suratjalan($no_suratjalan)->row_array();
    $data['detail']      = $this->Model_oman->get_detailsuratjalan($no_suratjalan)->result();
    $this->load->view('oman/cetak_suratjalan', $data);
  }

  function targetpengiriman($rowno = 0)
  {
    $cabang    = "";
    $tahun     = "";
    $bulan      = "";
    if ($this->input->post('submit') != NULL) {
      $cabang = $this->input->post('cabang');
      $tahun   = $this->input->post('tahun');
      $bulan   = $this->input->post('bulan');
      $data   = array(
        'cabang_filter'  => $cabang,
        'tahun'          => $tahun,
        'bulan'          => $bulan
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('cabang_filter') != NULL) {
        $cabang = $this->session->userdata('cabang_filter');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_oman->getrecordTargetbulanCount($cabang, $tahun, $bulan);
    // Get records
    $users_record = $this->Model_oman->getDataTargetbulan($rowno, $rowperpage, $cabang, $tahun, $bulan);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'target/targetbulan';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']         = $rowperpage;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']         = $this->pagination->create_links();
    $data['result']             = $users_record;
    $data['row']                 = $rowno;
    $data['cb']                 = $cabang;
    $data['tahun']              = $tahun;
    $data['bl']                  = $bulan;
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'oman/view_targetpengiriman', $data);
  }

  function insert_targetbulantemp()
  {
    $this->Model_oman->insert_targetbulantemp();
  }

  function view_targetpengirimantemp()
  {
    $data['targetbulantemp'] = $this->Model_oman->view_targetbulantemp()->result();
    $this->load->view('target/view_targetbulantemp', $data);
  }

  function cek_targetbulantemp()
  {
    $cabang    = $this->input->post('cabang');
    $bulan     = $this->input->post('bulan');
    $tahun     = $this->input->post('tahun');
    $cek       = $this->db->get_where('target_pengirimantemp', array('kode_cabang' => $cabang, 'tahun' => $tahun, 'bulan' => $bulan));
    echo $cek->num_rows();
  }

  function hapus_targetbulantemp()
  {
    $kodebarang = $this->input->post('kodebarang');
    $cabang     = $this->input->post('cabang');
    $tahun       = $this->input->post('tahun');
    $bulan       = $this->input->post('bulan');
    echo $kodebarang;
    $this->Model_oman->hapus_targetbulantemp($kodebarang, $cabang, $tahun, $bulan);
  }

  function insert_targetbulan()
  {
    $this->Model_oman->insert_targetbulan();
  }


  function detail_target_bulan()
  {
    $tahun           = $this->input->post('tahun');
    $bulan           = $this->input->post('bulan');
    $cabang          = $this->input->post('cabang');
    $data['tahun']  = $tahun;
    $data['bulan']  = $bulan;
    $data['cabang'] = $cabang;
    $data['detail'] = $this->Model_oman->detail_target_bulan($tahun, $cabang, $bulan)->result();
    $this->load->view('oman/detail_target_bulan', $data);
  }

  function hapus_all_targettahun()
  {
    $tahun   = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_oman->hapus_all_targetbulan($tahun, $cabang);
  }

  function hapus_target_produk_bulan()
  {
    $id = $this->uri->segment(3);
    $this->Model_oman->hapus_target_produk_bulan($id);
  }

  function bufferstokcabang($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cabang           = "";
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_oman->getrecordBufferstokCount($tanggal, $cabang);
    // Get records
    $users_record = $this->Model_oman->getDataBufferstok($rowno, $rowperpage, $tanggal, $cabang);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'repackreject/reject_gudang';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']         = $allcount;
    $config['per_page']           = $rowperpage;
    $config['first_link']         = 'First';
    $config['last_link']          = 'Last';
    $config['next_link']          = 'Next';
    $config['prev_link']          = 'Prev';
    $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']     = '</ul></nav></div>';
    $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']      = '</span></li>';
    $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']    = '</span>Next</li>';
    $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close']   = '</span></li>';
    $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']    = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $this->template->load('template/template', 'oman/bufferstokcabang', $data);
  }

  function inputbuffer()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'oman/inputbuffer', $data);
  }

  function getKodeBuffer()
  {
    $cabang = $this->input->post('kodecabang');
    $query            = "SELECT kode_bufferstok
                        FROM buffer_stok
                        WHERE kode_cabang = '$cabang'
                        ORDER BY kode_bufferstok DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['kode_bufferstok'];
    $no_mutasi        = buatkode($nomor_terakhir, "BF" . $cabang, 2);
    echo $no_mutasi;
  }

  function input_bufferstok()
  {
    $this->Model_oman->insert_bufferstok();
  }

  function detail_bufferstok()
  {
    $kodebuffer           = $this->input->post('kodebuffer');
    $data['buffer']       = $this->Model_oman->getBufferstok($kodebuffer)->row_array();
    $data['detailbuffer'] = $this->Model_oman->detailBufferstok($kodebuffer)->result();
    $this->load->view('oman/detail_buffer', $data);
  }

  function updatebuffer()
  {
    $kodebuffer         = $this->uri->segment(3);
    $data['buffer']     = $this->Model_oman->getBufferstok($kodebuffer)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'oman/updatebuffer', $data);
  }

  function update_buffer()
  {
    $this->Model_oman->update_buffer();
  }

  function hapusbuffer()
  {
    $kodebuffer      = $this->uri->segment(3);
    $hal              = $this->uri->segment(4);
    $this->Model_oman->hapusbuffer($kodebuffer, $hal);
  }
}
