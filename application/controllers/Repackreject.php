<?php

class Repackreject extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_repackreject', 'Model_cabang', 'Model_oman', 'Model_sales'));
  }


  function repack($rowno = 0)
  {
    // Search text
    $nomutasi    = "";
    $tgl_mutasi  = "";
    if ($this->input->post('submit') != NULL) {
      $nomutasi   = $this->input->post('no_mutasi');
      $tgl_mutasi = $this->input->post('tgl_mutasi');
      $data   = array(
        'nomutasi'     => $nomutasi,
        'tgl_mutasi'  => $tgl_mutasi
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nomutasi') != NULL) {
        $nomutasi = $this->session->userdata('nomutasi');
      }
      if ($this->session->userdata('tgl_mutasi') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordRepackCount($nomutasi, $tgl_mutasi);
    // Get records
    $users_record = $this->Model_repackreject->getDataRepack($rowno, $rowperpage, $nomutasi, $tgl_mutasi);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'repackreject/repack';
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
    $data['pagination'] = $this->pagination->create_links();
    $data['result']     = $users_record;
    $data['row']         = $rowno;
    $data['nomutasi']   = $nomutasi;
    $data['tgl_mutasi']  = $tgl_mutasi;
    // Load view
    $this->template->load('template/template', 'repackreject/repack', $data);
  }


  function insert_detailrepacktemp()
  {
    $cek   = $this->Model_repackreject->cek_detailrepacktemp()->num_rows();
    if ($cek == 1) {
      echo "1";
    } else {
      $this->Model_repackreject->insert_detailrepacktemp();
    }
  }

  function view_detail_repack_temp()
  {
    $data['detail']  = $this->Model_repackreject->view_detail_repack_temp()->result();
    $this->load->view('repackreject/view_detail_repack_temp', $data);
  }

  function hapus_detail_repack_temp()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->Model_repackreject->hapus_detail_repack_temp($kode_produk);
  }

  function buat_nomor_repack()
  {
    $tgl_repack     = $this->input->post('tgl_repack');
    $repack         = $this->Model_repackreject->getNoRepackLast($tgl_repack)->row_array();
    $tanggal         = explode("-", $tgl_repack);
    $hari           = $tanggal[2];
    $bulan           = $tanggal[1];
    $tahun           = $tanggal[0];
    $tgl             = "." . $hari . "." . $bulan . "." . $tahun;
    $nomor_terakhir  = $repack['no_repack'];
    $no_repack       = buatkode($nomor_terakhir, "RP", 2) . $tgl;
    echo $no_repack;
  }


  function cekdetailrepacktemp()
  {
    $cek = $this->db->get('detail_repack_temp')->num_rows();
    if ($cek != 0) {
      echo "1";
    }
  }

  function input_repack()
  {
    $this->Model_repackreject->insert_repack();
  }

  function hapus_repack()
  {
    $no_repack = $this->uri->segment(3);
    $this->Model_repackreject->hapusrepack($no_repack);
  }

  function detail_mutasi()
  {
    $nomutasi             = $this->input->post('nomutasi');
    $data['jenis_mutasi']  = $this->input->post('jenis_mutasi');
    $data['mutasi']        = $this->Model_repackreject->getMutasi($nomutasi)->row_array();
    $data['detail']        = $this->Model_repackreject->detail_mutasi($nomutasi)->result();
    $this->load->view('repackreject/detail_mutasi', $data);
  }

  function reject($rowno = 0)
  {
    // Search text
    $nomutasi    = "";
    $tgl_mutasi  = "";
    if ($this->input->post('submit') != NULL) {
      $nomutasi   = $this->input->post('no_mutasi');
      $tgl_mutasi = $this->input->post('tgl_mutasi');
      $data   = array(
        'nomutasi'     => $nomutasi,
        'tgl_mutasi'  => $tgl_mutasi
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nomutasi') != NULL) {
        $nomutasi = $this->session->userdata('nomutasi');
      }
      if ($this->session->userdata('tgl_mutasi') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordRejectCount($nomutasi, $tgl_mutasi);
    // Get records
    $users_record = $this->Model_repackreject->getDataReject($rowno, $rowperpage, $nomutasi, $tgl_mutasi);

    // Pagination Configuration
    $config['base_url']         = base_url() . 'repackreject/reject';
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

    $data['pagination'] = $this->pagination->create_links();
    $data['result']   = $users_record;
    $data['row']     = $rowno;
    $data['nomutasi']   = $nomutasi;
    $data['tgl_mutasi']  = $tgl_mutasi;

    // Load view

    $this->template->load('template/template', 'repackreject/reject', $data);
  }



  function lainlain($rowno = 0)
  {
    // Search text
    $nomutasi    = "";
    $tgl_mutasi  = "";
    if ($this->input->post('submit') != NULL) {
      $nomutasi   = $this->input->post('no_mutasi');
      $tgl_mutasi = $this->input->post('tgl_mutasi');
      $data   = array(
        'nomutasi'     => $nomutasi,
        'tgl_mutasi'  => $tgl_mutasi
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nomutasi') != NULL) {
        $nomutasi = $this->session->userdata('nomutasi');
      }
      if ($this->session->userdata('tgl_mutasi') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordLainlainCount($nomutasi, $tgl_mutasi);
    // Get records
    $users_record = $this->Model_repackreject->getDataLainlain($rowno, $rowperpage, $nomutasi, $tgl_mutasi);

    // Pagination Configuration
    $config['base_url']         = base_url() . 'repackreject/reject';
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

    $data['pagination'] = $this->pagination->create_links();
    $data['result']   = $users_record;
    $data['row']     = $rowno;
    $data['nomutasi']   = $nomutasi;
    $data['tgl_mutasi']  = $tgl_mutasi;

    // Load view

    $this->template->load('template/template', 'repackreject/lainlain', $data);
  }

  function view_detail_lainlain_temp()
  {
    $data['detail']  = $this->Model_repackreject->view_detail_lainlain_temp()->result();
    $this->load->view('repackreject/view_detail_lainlain_temp', $data);
  }

  function view_detail_reject_temp()
  {
    $data['detail']  = $this->Model_repackreject->view_detail_reject_temp()->result();
    $this->load->view('repackreject/view_detail_reject_temp', $data);
  }


  function cekdetailrejecttemp()
  {
    $cek = $this->db->get('detail_reject_temp')->num_rows();
    if ($cek != 0) {
      echo "1";
    }
  }

  function cekdetaillainlaintemp()
  {
    $cek = $this->db->get('detail_lainlain_temp')->num_rows();
    if ($cek != 0) {
      echo "1";
    }
  }


  function insert_detailrejecttemp()
  {
    $cek   = $this->Model_repackreject->cek_detailrejecttemp()->num_rows();
    if ($cek == 1) {
      echo "1";
    } else {
      $this->Model_repackreject->insert_detailrejecttemp();
    }
  }

  function insert_detaillainlaintemp()
  {
    $cek   = $this->Model_repackreject->cek_detaillainlaintemp()->num_rows();
    if ($cek == 1) {
      echo "1";
    } else {
      $this->Model_repackreject->insert_detaillainlaintemp();
    }
  }


  function hapus_detail_reject_temp()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->Model_repackreject->hapus_detail_reject_temp($kode_produk);
  }

  function hapus_detail_lainlain_temp()
  {
    $kode_produk = $this->input->post('kode_produk');
    $this->Model_repackreject->hapus_detail_lainlain_temp($kode_produk);
  }

  function input_lainlain()
  {
    $this->Model_repackreject->insert_lainlain();
  }

  function hapuslainlain()
  {
    $no_lainlain = $this->uri->segment(3);
    $delete = $this->db->delete('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_lainlain));
    if ($delete) {
      $this->db->delete('detail_mutasi_gudang', array('no_mutasi_gudang' => $no_lainlain));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
      </div>'
      );
      redirect('repackreject/lainlain');
    }
  }

  function buat_nomor_reject()
  {
    $tgl_reject     = $this->input->post('tgl_reject');
    $reject         = $this->Model_repackreject->getNoRejectLast($tgl_reject)->row_array();
    $tanggal         = explode("-", $tgl_reject);
    $hari           = $tanggal[2];
    $bulan           = $tanggal[1];
    $tahun           = $tanggal[0];
    $tgl             = "." . $hari . "." . $bulan . "." . $tahun;
    $nomor_terakhir  = $reject['no_reject'];
    $no_reject       = buatkode($nomor_terakhir, "RJ", 2) . $tgl;
    echo $no_reject;
  }

  function buat_nomor_lainlain()
  {
    $tgl_mutasi_lainlain     = $this->input->post('tgl_mutasi_lainlain');
    $lainlain         = $this->Model_repackreject->getNoLainlainLast($tgl_mutasi_lainlain)->row_array();
    $tanggal         = explode("-", $tgl_mutasi_lainlain);
    $hari           = $tanggal[2];
    $bulan           = $tanggal[1];
    $tahun           = $tanggal[0];
    $tgl             = "." . $hari . "." . $bulan . "." . $tahun;
    $nomor_terakhir  = $lainlain['no_lainlain'];
    $no_lainlain       = buatkode($nomor_terakhir, "ML", 2) . $tgl;
    echo $no_lainlain;
  }


  function input_reject()
  {
    $this->Model_repackreject->insert_reject();
  }

  function hapusreject($no_reject)
  {
    $delete = $this->db->delete('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_reject));
    if ($delete) {
      $this->db->delete('detail_mutasi_gudang', array('no_mutasi_gudang' => $no_reject));
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
      </div>'
      );
      redirect('repackreject/reject');
    }
  }

  function hapus_detailbrg()
  {
    $kode_produk = $this->input->post('kode_produk');
    $kode_cabang = $this->input->post('cabang');
    $this->Model_repackreject->hapus_detailbrg($kode_produk, $kode_cabang);
  }

  function detail_mutasi_cab()
  {
    $nomutasi             = $this->input->post('nomutasi');
    $data['jenis_mutasi']  = $this->input->post('jenis_mutasi');
    $data['mutasi']        = $this->Model_repackreject->getMutasiCab($nomutasi)->row_array();
    $data['detail']        = $this->Model_repackreject->detail_mutasiCab($nomutasi)->result();
    $this->load->view('repackreject/detail_mutasi_cab', $data);
  }


  function reject_gudang($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
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
    $allcount     = $this->Model_repackreject->getrecordRJGCount($tanggal, $cabang);
    // Get records
    $users_record = $this->Model_repackreject->getDataRJG($rowno, $rowperpage, $tanggal, $cabang);
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
    $this->template->load('template/template', 'repackreject/rejectgudang', $data);
  }

  function inputrejectgudang()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/inputrejectgudang', $data);
  }
  function getNomutasiRJP()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'REJECT PASAR' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "RJP" . $nodpb, 2);
    echo $no_mutasi;
  }

  function getNomutasiRJG()
  {

    $tgl_sj           = $this->input->post('tgl_sj');
    $tanggal           = explode("-", $tgl_sj);
    $thn               = $tanggal[0];
    $tahun             = substr($thn, 2, 2);
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'REJECT GUDANG' AND YEAR(tgl_mutasi_gudang_cabang)='$thn'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                        ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "RJG" . $tahun, 5);
    echo $no_mutasi;
  }

  function jsonsj()
  {
    header('Content-Type: application/json');
    echo $this->Model_repackreject->jsonsj();
  }
  function input_rejectgudang()
  {
    $this->Model_repackreject->insert_rejectgudang();
  }

  function detail_rejectgudang()
  {
    $nomutasi                = $this->input->post('nomutasi');
    $data['mutasi']          = $this->Model_repackreject->getMutasiPersediaan($nomutasi)->row_array();
    $data['detailmutasi']    = $this->Model_repackreject->detailMutasiPersediaan($nomutasi)->result();
    $this->load->view('repackreject/detail_persediaan', $data);
  }

  function updaterejectgudang()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_repackreject->getMutasiPersediaan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'repackreject/updaterejectgudang', $data);
  }

  function hapusrejectgudang()
  {
    $no_rejectgudang = $this->uri->segment(3);
    $hal              = $this->uri->segment(5);
    $cabang          = $this->uri->segment(4);
    $this->Model_repackreject->hapusrejectgudang($no_rejectgudang, $cabang, $hal);
  }



  function penyesuaian($rowno = 0)
  {
    // Search text
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }

    if ($this->input->post('submit') != NULL) {
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');

      $data   = array(

        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,

      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordPNYCount($tanggal, $cabang);
    // Get records
    $users_record = $this->Model_repackreject->getDataPNY($rowno, $rowperpage, $tanggal, $cabang);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'repackreject/penyesuaian';
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
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/penyesuaian', $data);
  }

  function updatepenyesuaian()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_repackreject->getMutasiPersediaan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'repackreject/updatepenyesuaian', $data);
  }

  function updatepenyesuaianbad()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_repackreject->getMutasiPersediaan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'repackreject/updatepenyesuaianbad', $data);
  }

  function update_penyesuaian()
  {
    $this->Model_repackreject->update_penyesuaian();
  }

  function update_penyesuaianbad()
  {
    $this->Model_repackreject->update_penyesuaianbad();
  }

  function inputpenyesuaian()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/inputpenyesuaian', $data);
  }

  function getNomutasiPG()
  {

    $tgl               = $this->input->post('tanggal');
    $tanggal           = explode("-", $tgl);
    $thn               = $tanggal[0];
    $tahun             = substr($thn, 2, 2);
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'PENYESUAIAN' AND kondisi='GOOD' AND YEAR(tgl_mutasi_gudang_cabang)='$thn'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                        ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "PYG" . $tahun, 5);
    echo $no_mutasi;
  }

  function input_penyesuaian()
  {
    $this->Model_repackreject->insert_penyesuaian();
  }

  function hapuspenyesuaian()
  {
    $no_penyesuaian = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_repackreject->hapuspenyesuaian($no_penyesuaian, $cabang);
  }

  function hapuspenyesuaianbad()
  {
    $no_penyesuaian = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_repackreject->hapuspenyesuaianbad($no_penyesuaian, $cabang);
  }


  function so_good($rowno = 0)
  {
    $status        = "GOOD";
    $tgl_mutasi    = "";
    if ($this->input->post('submit') != NULL) {
      $tgl_mutasi = $this->input->post('tgl_mutasi');
      $data = array(
        'tgl_mutasi'  => $tgl_mutasi
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('tgl_mutasi') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordSoGJCount($status, $tgl_mutasi);
    // Get records
    $users_record = $this->Model_repackreject->getDataSoGJ($rowno, $rowperpage, $status, $tgl_mutasi);
    // Pagination Configuration
    $config['base_url']         = base_url() . 'repackreject/so_good';
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
    $data['tgl_mutasi']          = $tgl_mutasi;
    // Load view
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['cb']                 = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/so_good', $data);
  }


  function view_detailstok()
  {
    $kode_produk    = $this->uri->segment(4);
    $data['produk'] = $this->Model_repackreject->getProduk($kode_produk)->row_array();
    $data['stok']   = $this->uri->segment(3);
    $this->load->view('repackreject/view_detailstok', $data);
  }

  function insert_detailsogoodtemp()
  {
    $this->Model_repackreject->insert_detailsogoodtemp();
  }


  function cekdetailsogoodtemp()
  {
    $cabang   = $this->input->post('cabang');
    $id_admin  = $this->session->userdata('id_user');
    $cek     = $this->db->get_where('detailsogood_temp', array('kode_cabang' => $cabang, 'id_admin' => $id_admin))->num_rows();
    if ($cek != 0) {

      echo "1";
    }
  }


  function view_detailsogoodtemp()
  {
    $data['detail'] = $this->Model_repackreject->view_detailsogoodtemp()->result();
    $this->load->view('repackreject/view_detailsogoodtemp', $data);
  }

  function hapus_detailbrgsogoodtemp()
  {
    $kode_produk = $this->input->post('kode_produk');
    $kode_cabang = $this->input->post('cabang');
    $this->Model_repackreject->hapus_detailbrgsogoodtemp($kode_produk, $kode_cabang);
  }

  function input_sogood()
  {
    $this->Model_repackreject->insert_sogood();
  }


  function detail_so()
  {
    $nomutasi           = $this->input->post('nomutasi');
    $data['mutasi']      = $this->Model_repackreject->getSOGJ($nomutasi)->row_array();
    $data['detail']      = $this->Model_repackreject->detail_sogj($nomutasi)->result();
    $this->load->view('repackreject/detail_so_gj', $data);
  }

  function hapus_so()
  {
    $no_so  = $this->uri->segment(3);
    $status = $this->uri->segment(4);
    $this->Model_repackreject->hapus_so($no_so, $status);
  }


  function so_bad($rowno = 0)
  {

    $status      = "BAD";
    $tgl_mutasi  = "";
    if ($this->input->post('submit') != NULL) {
      $tgl_mutasi = $this->input->post('tgl_mutasi');
      $data = array(
        'tgl_mutasi'  => $tgl_mutasi
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('tgl_mutasi') != NULL) {
        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }

    // All records count
    $allcount     = $this->Model_repackreject->getrecordSoGJCount($status, $tgl_mutasi);
    // Get records
    $users_record = $this->Model_repackreject->getDataSoGJ($rowno, $rowperpage, $status, $tgl_mutasi);

    // Pagination Configuration
    $config['base_url']       = base_url() . 'repackreject/so_bad';
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
    $data['tgl_mutasi']          = $tgl_mutasi;
    // Load view
    $data['cabang']             = $this->Model_cabang->view_cabang()->result();
    $data['cb']                 = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/so_bad', $data);
  }

  function update_rejectgudang()
  {
    $this->Model_repackreject->update_rejectgudang();
  }

  function penyesuaianbad($rowno = 0)
  {
    // Search text

    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }

    if ($this->input->post('submit') != NULL) {

      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');

      $data   = array(

        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,

      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordPYBCount($tanggal, $cabang);
    // Get records
    $users_record = $this->Model_repackreject->getDataPYB($rowno, $rowperpage, $tanggal, $cabang);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'repackreject/penyesuaianbad';
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
    $data['tanggal']              = $tanggal;

    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/penyesuaianbad', $data);
  }

  function inputpenyesuaianbad()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/inputpenyesuaianbad', $data);
  }

  function getNomutasiPB()
  {

    $tgl               = $this->input->post('tanggal');
    $tanggal           = explode("-", $tgl);
    $thn               = $tanggal[0];
    $tahun             = substr($thn, 2, 2);
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'PENYESUAIAN BAD' AND YEAR(tgl_mutasi_gudang_cabang)='$thn'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                        ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "PYB" . $tahun, 5);
    echo $no_mutasi;
  }

  function input_penyesuaianbad()
  {
    $this->Model_repackreject->insert_penyesuaianbad();
  }


  function repackcab($rowno = 0)
  {
    // Search text
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    if ($this->input->post('submit') != NULL) {
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $data   = array(
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordRepackcabCount($tanggal, $cabang);
    // Get records
    $users_record = $this->Model_repackreject->getDataRepackCab($rowno, $rowperpage, $tanggal, $cabang);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'repackreject/repackcab';
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
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/repackcab', $data);
  }

  function inputrepackcab()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/inputrepackcab', $data);
  }

  function getNomutasiRepack()
  {
    $tgl               = $this->input->post('tanggal');
    $tanggal           = explode("-", $tgl);
    $thn               = $tanggal[0];
    $tahun             = substr($thn, 2, 2);
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'REPACK' AND YEAR(tgl_mutasi_gudang_cabang)='$thn'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                        ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "RPC" . $tahun, 5);
    echo $no_mutasi;
  }

  function input_repackcab()
  {
    $this->Model_repackreject->insert_repackcab();
  }
  function updaterepackcab()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_repackreject->getMutasiPersediaan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'repackreject/updaterepackcab', $data);
  }

  function hapusrepackcab()
  {
    $norepack        = $this->uri->segment(3);
    $hal              = $this->uri->segment(5);
    $cabang           = $this->uri->segment(6);
    $this->Model_repackreject->hapusrepackcab($norepack, $cabang, $hal);
  }

  function update_repackcab()
  {
    $this->Model_repackreject->update_repackcab();
  }

  function kirimpusat($rowno = 0)
  {
    // Search text
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    if ($this->input->post('submit') != NULL) {
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $data   = array(
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_repackreject->getrecordKirimPusatCount($tanggal, $cabang);
    // Get records
    $users_record = $this->Model_repackreject->getDataKirimPusat($rowno, $rowperpage, $tanggal, $cabang);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'repackreject/repackcab';
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
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/kirimpusat', $data);
  }

  function inputkirimpusat()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'repackreject/inputkirimpusat', $data);
  }

  function getNomutasiKirimPusat()
  {
    $tgl               = $this->input->post('tanggal');
    $tanggal           = explode("-", $tgl);
    $thn               = $tanggal[0];
    $tahun             = substr($thn, 2, 2);
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'KIRIM PUSAT' AND YEAR(tgl_mutasi_gudang_cabang)='$thn'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                        ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "KPT" . $tahun, 5);
    echo $no_mutasi;
  }

  function input_kirimpusat()
  {
    $this->Model_repackreject->insert_kirimpusat();
  }
  function updatekirimpusat()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_repackreject->getMutasiPersediaan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'repackreject/updatekirimpusat', $data);
  }

  function hapuskirimpusat()
  {
    $nokirimpusat    = $this->uri->segment(3);
    $hal              = $this->uri->segment(5);
    $cabang          = $this->uri->segment(4);
    $this->Model_repackreject->hapuskirimpusat($nokirimpusat, $cabang, $hal);
  }

  function update_kirimpusat()
  {
    $this->Model_repackreject->update_kirimpusat();
  }
}
