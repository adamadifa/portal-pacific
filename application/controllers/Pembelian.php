<?php
class Pembelian extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_pembelian', 'Model_cabang', 'Model_gudangbahan'));
  }
  function permintaanbarang($rowno = 0)
  {
    // Search text
    $no_bpb           = "";
    $tgl_permintaan   = "";
    $kode_dept        = $this->session->userdata('dept');
    if (empty($kode_dept)) {
      $departemen = "";
    } else {
      $departemen = $kode_dept;
    }

    $statuspesanan    = "";
    $statuspembelian  = "";

    if ($this->input->post('submit') != NULL) {
      $no_bpb                = $this->input->post('nobpb');
      $tgl_permintaan        = $this->input->post('tgl_permintaan');
      $departemen            = $this->input->post('departemen');
      $statuspesanan         = $this->input->post('statuspesanan');
      $statuspembelian       = $this->input->post('statuspembelian');
      $data   = array(
        'no_bpb'                => $no_bpb,
        'tgl_permintaan'       => $tgl_permintaan,
        'departemen'           => $departemen,
        'statuspesanan'        => $statuspesanan,
        'statuspembelian'      => $statuspembelian
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_bpb') != NULL) {
        $no_bpb = $this->session->userdata('no_bpb');
      }
      if ($this->session->userdata('tgl_permintaan') != NULL) {
        $tgl_permintaan = $this->session->userdata('tgl_permintaan');
      }
      if ($this->session->userdata('departemen') != NULL) {
        $departemen = $this->session->userdata('departemen');
      }
      if ($this->session->userdata('statuspesanan') != NULL) {
        $statuspesanan = $this->session->userdata('statuspesanan');
      }

      if ($this->session->userdata('statuspembelian') != NULL) {
        $statuspembelian = $this->session->userdata('statuspembelian');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_pembelian->getrecordBpbCount($no_bpb, $tgl_permintaan, $departemen, $statuspesanan, $statuspembelian);
    // Get records
    $users_record = $this->Model_pembelian->getDataBpb($rowno, $rowperpage, $no_bpb, $tgl_permintaan, $departemen, $statuspesanan, $statuspembelian);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'pembelian/permintaanbarang';
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
    $data['no_bpb']               = $no_bpb;
    $data['tgl_permintaan']        = $tgl_permintaan;
    $data['departemen']            = $departemen;
    $data['statuspesanan']        = $statuspesanan;
    $data['statuspembelian']      = $statuspembelian;
    $data['dept']                 = $this->Model_pembelian->getPemohon()->result();

    //echo $data['cb'];
    $this->template->load('template/template', 'pembelian/permintaanbarang', $data);
  }


  function inputbpb()
  {
    $data['dept']        = $this->Model_pembelian->getDept()->result();
    $data['pemohon']     = $this->Model_pembelian->getPemohon()->result();
    $data['departemen']  = $this->session->userdata('dept');
    $this->template->load('template/template', 'pembelian/inputbpb', $data);
  }

  function insert_bpb()
  {
    $this->Model_pembelian->insert_bpb();
  }

  function insertdetailbpb_temp()
  {
    $this->Model_pembelian->insertdetailbpb_temp();
  }

  function insertdetailpembelian_temp()
  {
    $this->Model_pembelian->insertdetailpembelian_temp();
  }

  function insertdetailkontrabon_temp()
  {
    $this->Model_pembelian->insertdetailkontrabon_temp();
  }

  function insertdetailbpb()
  {
    $this->Model_pembelian->insertdetailbpb();
  }

  function view_detailbpb_temp()
  {
    $data['bpbtemp'] = $this->Model_pembelian->getBPBtemp()->result();
    $this->load->view('pembelian/view_detailbpb_temp', $data);
  }

  function view_detailpembelian_temp()
  {
    $departemen  = $this->uri->segment(3);
    $data['pmb'] = $this->Model_pembelian->getPembeliantemp($departemen)->result();
    $this->load->view('pembelian/view_detailpembelian_temp', $data);
  }

  function view_detailkontrabon_temp()
  {
    $supplier    = $this->uri->segment(3);
    $data['kb']   = $this->Model_pembelian->getKontrabontemp($supplier)->result();
    $this->load->view('pembelian/view_detailkontrabon_temp', $data);
  }


  function hapus_detailbpb_temp()
  {
    $this->Model_pembelian->hapus_detailbpb_temp();
  }

  function hapus_detailpembelian_temp()
  {
    $this->Model_pembelian->hapus_detailpembelian_temp();
  }

  function hapus_detailpembelian()
  {
    $this->Model_pembelian->hapus_detailpembelian();
  }

  function hapus_detailkontrabon_temp()
  {
    $this->Model_pembelian->hapus_detailkontrabon_temp();
  }
  function barang()
  {
    $this->template->load('template/template', 'pembelian/view_barang');
  }

  function jsonBarang()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonBarang();
  }

  function jsonPilihBarang()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonPilihBarang();
  }

  function jsonPilihSupplier()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonPilihSupplier();
  }

  function jsonPilihBarangpembelian()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonPilihBarangpembelian();
  }

  function jsonPilihAkun()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonPilihAkun();
  }

  function jsonPilihPembelian()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonPilihPembelian();
  }

  function jsonPIlihBarangDO()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonPIlihBarangDO();
  }
  function input_barang()
  {
    $data['kategori'] = $this->Model_pembelian->getKategori()->result();
    $data['pemohon']     = $this->Model_pembelian->getPemohon()->result();
    $data['departemen']  = $this->session->userdata('dept');
    $this->load->view('pembelian/input_barang', $data);
  }

  function insert_barang()
  {
    $this->Model_pembelian->insert_barang();
  }

  function hapusbarang()
  {
    $kodebarang = $this->uri->segment(3);
    $hapus = $this->db->delete('master_barang_pembelian', array('kode_barang' => $kodebarang));
    if ($hapus) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
      </div>'
      );
      redirect('pembelian/barang');
    }
  }

  function edit_Barang()
  {
    $kodebarang       = $this->input->post('kodebarang');
    $data['brg']      = $this->Model_pembelian->getBarang($kodebarang)->row_array();
    $data['dept']     = $this->Model_pembelian->getDepts()->result();
    $data['kategori'] = $this->Model_pembelian->getKategori()->result();
    $this->load->view('pembelian/edit_barang', $data);
  }

  function update_barang()
  {
    $this->Model_pembelian->update_barang();
  }

  function tabelbarang()
  {
    $data['kode_dept'] = $this->uri->segment(3);
    $this->load->view('pembelian/tabelbarang', $data);
  }

  function tabelbarangpembelian()
  {
    $data['kode_dept'] = $this->uri->segment(3);
    $this->load->view('pembelian/tabelbarangpembelian', $data);
  }
  function tabelbarangdo()
  {
    $data['kode_dept'] = $this->uri->segment(3);
    $this->load->view('pembelian/do_tabelbarang', $data);
  }
  function tabelpembelian()
  {
    $supplier     = $this->uri->segment(3);
    $data['pmb']  = $this->Model_pembelian->jsonPilihPembelian($supplier)->result();
    $this->load->view('pembelian/tabelpembelian', $data);
  }


  function tabelsupplier()
  {
    $this->load->view('pembelian/tabelsupplier');
  }

  function tabelsupplieredit()
  {
    $this->load->view('pembelian/tabelsupplieredit');
  }

  function tabelakunpembelian()
  {
    $this->load->view('pembelian/tabelakunpembelian');
  }

  function detail_bpb()
  {
    $nobpb            = $this->input->post('nobpb');
    $data['bpb']      = $this->Model_pembelian->getBPB($nobpb)->row_array();
    $data['detail']   = $this->Model_pembelian->getDetailBpb($nobpb)->result();
    $this->load->view('pembelian/detail_bpb', $data);
  }

  function detail_pembelian()
  {
    $nobukti            = $this->input->post('nobukti');
    $data['pmb']        = $this->Model_pembelian->getPembelian($nobukti)->row_array();
    $data['detail']     = $this->Model_pembelian->getDetailPembelian($nobukti)->result();
    $pmbpnj             = $this->Model_pembelian->getDetailPnjPembelian($nobukti);
    $data['cekpnj']     = $pmbpnj->num_rows();
    $data['pmbpnj']     = $pmbpnj->result();
    $data['kb']         = $this->Model_pembelian->listKontraBonPMB($nobukti)->result();

    $this->load->view('pembelian/detail_pembelian', $data);
  }

  function editbpb()
  {
    $nobpb           = str_replace(".", "/", $this->uri->segment(3));
    $data['bpb']     = $this->Model_pembelian->getBPB($nobpb)->row_array();
    $data['dept']    = $this->Model_pembelian->getDept()->result();
    $data['pemohon'] = $this->Model_pembelian->getPemohon()->result();
    $this->template->load('template/template', 'pembelian/editbpb', $data);
  }

  function view_detailbpb()
  {
    $nobpb            = str_replace(".", "/", $this->uri->segment(3));
    $data['detail']   = $this->Model_pembelian->getDetailBpb($nobpb)->result();
    $this->load->view('pembelian/view_detailbpb', $data);
  }

  function hapus_detailbpb()
  {
    $this->Model_pembelian->hapus_detailbpb();
  }

  function update_bpb()
  {
    $this->Model_pembelian->update_bpb();
  }

  function hapusbpb()
  {
    $this->Model_pembelian->hapusbpb();
  }

  function supplier()
  {
    $this->template->load('template/template', 'pembelian/supplier');
  }

  function inputsupplier()
  {
    $getKodeSupplier        = $this->Model_pembelian->getKodeSupplier()->row_array();
    $nomor_terakhir         = $getKodeSupplier['kode_supplier'];
    $data['kode_supplier']  = buatkode($nomor_terakhir, "SP", 4);
    $this->template->load('template/template', 'pembelian/inputsupplier', $data);
  }

  function editsupplier()
  {
    $kodesupplier       = $this->uri->segment(3);
    $data['supplier']   = $this->Model_pembelian->getSupplier($kodesupplier)->row_array();
    $this->template->load('template/template', 'pembelian/editsupplier', $data);
  }

  function insert_supplier()
  {
    $this->Model_pembelian->insert_supplier();
  }

  function jsonSupplier()
  {
    header('Content-Type: application/json');
    echo $this->Model_pembelian->jsonSupplier();
  }

  function update_supplier()
  {
    $this->Model_pembelian->update_supplier();
  }

  function hapussupplier()
  {
    $kode_supplier = $this->uri->segment(3);
    $this->Model_pembelian->hapussupplier($kode_supplier);
  }

  function inputpembelian()
  {
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['pemohon']     = $this->Model_pembelian->getPemohon()->result();
    $this->template->load('template/template', 'pembelian/input_pembelian', $data);
  }

  function inputkontrabon()
  {
    $nobukti      = str_replace(".", "/", $this->uri->segment(3));
    $data['pmb']  = $this->Model_pembelian->getPMBKB($nobukti)->row_array();
    $this->template->load('template/template', 'pembelian/input_kontrabon', $data);
  }

  function editkontrabon()
  {
    $nokontrabon    = str_replace(".", "/", $this->uri->segment(3));
    $data['kb']     = $this->Model_pembelian->getKontrabon($nokontrabon)->row_array();
    $data['detail'] = $this->Model_pembelian->getDetailKontrabon($nokontrabon)->result();
    $this->template->load('template/template', 'pembelian/edit_kontrabon', $data);
  }

  function getNoBukti()
  {
    error_reporting(0);
    $kodedept       = $this->input->post('kodedept');
    $tglpembelian   = $this->input->post('tglpembelian');
    $tgl            = explode("-", $tglpembelian);
    $bulan          = $tgl[1];
    $pmb            = $this->Model_pembelian->getNoBukti($bulan)->row_array();
    $nomor_terakhir = $pmb['nobukti_pembelian'];
    $nobukti        = buatkode($nomor_terakhir, $kodedept, 3) . "/" . $bulan . "/" . $tgl[0];
    if (!empty($tglpembelian) && !empty($kodedept)) {
      echo $nobukti;
    }
  }
  function getNoDO()
  {
    error_reporting(0);
    $kodedept       = $this->input->post('kodedept');
    $tgl_do         = $this->input->post('tgl_do');
    $tgl            = explode("-", $tgl_do);
    $bulan          = $tgl[1];
    $tahun          = $tgl[0];
    $do             = $this->Model_pembelian->getNoDO($bulan, $tahun)->row_array();
    $nomor_terakhir = $do['no_do'];
    $nobukti        = buatkode($nomor_terakhir, "DO", 3) . "/" . $bulan . "/" . $tgl[0];
    if (!empty($tgl_do) && !empty($kodedept)) {
      echo $nobukti;
    }
  }
  function getNoBPB()
  {
    error_reporting(0);
    $kodedept         = $this->input->post('kodedept');
    $tgl_permintaan   = $this->input->post('tgl_permintaan');
    $tgl              = explode("-", $tgl_permintaan);
    $bulan            = $tgl[1];
    $pmb              = $this->Model_pembelian->getNoBPB($bulan, $kodedept)->row_array();
    $nomor_terakhir   = $pmb['no_bpb'];
    $nobukti          = buatkode($nomor_terakhir, "BPB/" . $kodedept, 3) . "/" . $bulan . "/" . $tgl[0];
    if (!empty($tgl_permintaan) && !empty($kodedept)) {
      echo $nobukti;
    }
  }

  function getNoKB()
  {
    error_reporting(0);
    $tgl_kontrabon  = $this->input->post('tgl_kontrabon');
    $status         = $this->input->post('status');
    $tgl            = explode("-", $tgl_kontrabon);
    $bulan          = $tgl[1];
    $kb             = $this->Model_pembelian->getNoKB($bulan, $tgl[0], $status)->row_array();
    $nomor_terakhir = $kb['no_kontrabon'];
    $nobukti        = buatkode($nomor_terakhir, $status, 3) . "/" . $bulan . "/" . $tgl[0];
    if (!empty($tgl_kontrabon)) {
      echo $nobukti;
    }
  }

  function insert_pembelian()
  {
    $this->Model_pembelian->insert_pembelian();
  }

  function insert_kontrabon()
  {
    $this->Model_pembelian->insert_kontrabon();
  }

  function update_kontrabon()
  {
    $this->Model_pembelian->update_kontrabon();
  }
  function index($rowno = 0)
  {
    // Search text
    $nobukti           = "";
    $tgl_pembelian    = "";
    $departemen       = "";
    $supplier         = "";
    $tunaikredit      = "";
    $role = $this->session->userdata('level_user');
    if ($role == 'admin pajak') {
      $ppn = "1";
    } else {
      $ppn = "";
    }

    // echo $ppn;
    //
    // die;
    $ln               = "";
    $tunaikredit      = "";
    if ($this->input->post('submit') != NULL) {
      $nobukti                = $this->input->post('nobukti');
      $tgl_pembelian         = $this->input->post('tgl_pembelian');
      $departemen            = $this->input->post('departemen');
      $supplier              = $this->input->post('supplier');
      $ppn                   = $this->input->post('ppn');
      $ln                    = $this->input->post('ln');
      $tunaikredit           = $this->input->post('tunaikredit');
      $data   = array(
        'nobukti'                => $nobukti,
        'tgl_pembelian'         => $tgl_pembelian,
        'departemen'           => $departemen,
        'supplier'             => $supplier,
        'ppn'                  => $ppn,
        'ln'                   => $ln,
        'tunaikredit'          => $tunaikredit
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nobukti') != NULL) {
        $nobukti = $this->session->userdata('nobukti');
      }
      if ($this->session->userdata('tgl_pembelian') != NULL) {
        $tgl_pembelian = $this->session->userdata('tgl_pembelian');
      }
      if ($this->session->userdata('departemen') != NULL) {
        $departemen = $this->session->userdata('departemen');
      }

      if ($this->session->userdata('supplier') != NULL) {
        $supplier = $this->session->userdata('supplier');
      }
      if ($this->session->userdata('ppn') != NULL) {
        $ppn = $this->session->userdata('ppn');
      }

      if ($this->session->userdata('ln') != NULL) {
        $ln = $this->session->userdata('ln');
      }

      if ($this->session->userdata('tunaikredit') != NULL) {
        $tunaikredit = $this->session->userdata('tunaikredit');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_pembelian->getrecordPembelianCount($nobukti, $tgl_pembelian, $departemen, $ppn, $ln, $supplier, $tunaikredit);
    // Get records
    $users_record = $this->Model_pembelian->getDataPembelian($rowno, $rowperpage, $nobukti, $tgl_pembelian, $departemen, $ppn, $ln, $supplier, $tunaikredit);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'pembelian/index';
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
    $data['nobukti']               = $nobukti;
    $data['tgl_pembelian']        = $tgl_pembelian;
    $data['departemen']            = $departemen;
    $data['ppn']                  = $ppn;
    $data['ln']                   = $ln;
    $data['tunaikredit']          = $tunaikredit;
    $data['dept']                 = $this->Model_pembelian->getPemohon()->result();
    $data['supp']                 = $this->Model_pembelian->listSupplier()->result();
    $data['supplier']             = $supplier;
    //echo $data['cb'];
    $this->template->load('template/template', 'pembelian/pembelian', $data);
  }

  function hapuspembelian()
  {
    $nobukti    = str_replace(".", "/", $this->uri->segment(3));
    $ref_tunai  = $this->uri->segment(4);
    $this->Model_pembelian->hapuspembelian($nobukti, $ref_tunai);
  }

  function hapuskontrabon()
  {
    $nokontrabon    = str_replace(".", "/", $this->uri->segment(3));
    $this->Model_pembelian->hapuskontrabon($nokontrabon);
  }

  function kontrabonkeuangan($rowno = 0)
  {
    // Search text
    $nokontrabon       = "";
    $tgl_kontrabon    = "";
    $supplier         = "";
    $status           = "";
    $kategori         = "";
    if ($this->input->post('submit') != NULL) {
      $nokontrabon          = $this->input->post('nokontrabon');
      $tgl_kontrabon       = $this->input->post('tgl_kontrabon');
      $supplier            = $this->input->post('supplier');
      $status              = $this->input->post('status');
      $kategori            = $this->input->post('kategori');
      $data   = array(
        'nokontrabon'          => $nokontrabon,
        'tgl_kontrabon'       => $tgl_kontrabon,
        'supplier'           => $supplier,
        'status'             => $status,
        'kategori'           => $kategori
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nokontrabon') != NULL) {
        $nokontrabon = $this->session->userdata('nokontrabon');
      }
      if ($this->session->userdata('tgl_kontrabon') != NULL) {
        $tgl_kontrabon = $this->session->userdata('tgl_kontrabon');
      }
      if ($this->session->userdata('supplier') != NULL) {
        $supplier = $this->session->userdata('supplier');
      }

      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }

      if ($this->session->userdata('kategori') != NULL) {
        $kategori = $this->session->userdata('kategori');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_pembelian->getrecordKontraBonCount($nokontrabon, $tgl_kontrabon, $supplier, $status, $kategori);
    // Get records
    $users_record = $this->Model_pembelian->getDataKontraBon($rowno, $rowperpage, $nokontrabon, $tgl_kontrabon, $supplier, $status, $kategori);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'pembelian/kontrabonkeuangan';
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
    $data['nokontrabon']           = $nokontrabon;
    $data['tgl_kontrabon']        = $tgl_kontrabon;
    $data['supplier']              = $supplier;
    $data['status']               = $status;
    $data['kategori']             = $kategori;
    $data['all']                  = $allcount;
    $data['supp']                 = $this->Model_pembelian->listSupplier()->result();
    //echo $data['cb'];
    $this->template->load('template/template', 'pembelian/kontrabonkeuangan', $data);
  }

  function kontrabon($rowno = 0)
  {
    // Search text
    $nokontrabon       = "";
    $tgl_kontrabon    = "";
    $supplier         = "";
    $status           = "";
    $kategori         = "";
    if ($this->input->post('submit') != NULL) {
      $nokontrabon          = $this->input->post('nokontrabon');
      $tgl_kontrabon       = $this->input->post('tgl_kontrabon');
      $supplier            = $this->input->post('supplier');
      $status              = $this->input->post('status');
      $kategori            = $this->input->post('kategori');
      $data   = array(
        'nokontrabon'          => $nokontrabon,
        'tgl_kontrabon'       => $tgl_kontrabon,
        'supplier'           => $supplier,
        'status'             => $status,
        'kategori'           => $kategori
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nokontrabon') != NULL) {
        $nokontrabon = $this->session->userdata('nokontrabon');
      }
      if ($this->session->userdata('tgl_kontrabon') != NULL) {
        $tgl_kontrabon = $this->session->userdata('tgl_kontrabon');
      }
      if ($this->session->userdata('supplier') != NULL) {
        $supplier = $this->session->userdata('supplier');
      }

      if ($this->session->userdata('status') != NULL) {
        $status = $this->session->userdata('status');
      }

      if ($this->session->userdata('kategori') != NULL) {
        $kategori = $this->session->userdata('kategori');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_pembelian->getrecordKontraBonCount($nokontrabon, $tgl_kontrabon, $supplier, $status, $kategori);
    // Get records
    $users_record = $this->Model_pembelian->getDataKontraBon($rowno, $rowperpage, $nokontrabon, $tgl_kontrabon, $supplier, $status, $kategori);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'pembelian/kontrabon';
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
    $data['nokontrabon']           = $nokontrabon;
    $data['tgl_kontrabon']        = $tgl_kontrabon;
    $data['supplier']              = $supplier;
    $data['status']               = $status;
    $data['kategori']             = $kategori;
    $data['supp']                 = $this->Model_pembelian->listSupplier()->result();
    //echo $data['cb'];
    $this->template->load('template/template', 'pembelian/kontrabon', $data);
  }

  function detail_kontrabon()
  {
    $nokontrabon            = $this->input->post('nokontrabon');
    $data['kb']             = $this->Model_pembelian->getKontrabon($nokontrabon)->row_array();
    $data['detail']         = $this->Model_pembelian->getDetailKontrabon($nokontrabon)->result();
    $this->load->view('pembelian/detail_kontrabon', $data);
  }

  function proseskontrabon()
  {
    $nokontrabon            = $this->input->post('nokontrabon');
    $data['kb']             = $this->Model_pembelian->getKontrabon($nokontrabon)->row_array();
    $data['detail']         = $this->Model_pembelian->getDetailKontrabon($nokontrabon)->result();
    $data['bank']           = $this->Model_pembelian->getBank()->result();
    $this->load->view('pembelian/proses_kontrabon', $data);
  }

  function proses_kontrabon()
  {
    $this->Model_pembelian->proses_kontrabon();
  }

  function hapusbayar()
  {
    $nokontrabon = str_replace(".", "/", $this->uri->segment(3));
    $this->Model_pembelian->hapusbayar($nokontrabon);
  }

  function edit_detailkb()
  {
    $nokontrabon    = $this->input->post('nokontrabon');
    $nobukti        = $this->input->post('nobukti');
    $data['bayar']  = $this->Model_pembelian->getBayarKB($nokontrabon, $nobukti)->row_array();
    $this->load->view('pembelian/edit_detailkb', $data);
  }

  function updatedetailkb()
  {
    $this->Model_pembelian->updatedetailkb();
  }

  function inputnopajak()
  {
    $data['nobukti'] = $this->input->post('nobukti');
    $data['nopajak'] = $this->input->post('nopajak');
    $this->load->view('pembelian/inputnopajak', $data);
  }

  function update_fakturpajak()
  {
    $this->Model_pembelian->update_fakturpajak();
  }

  function editpembelian()
  {
    $nobukti            = str_replace(".", "/", $this->uri->segment(3));
    $data['pmb']        = $this->Model_pembelian->getPembelian($nobukti)->row_array();
    $data['detail']     = $this->Model_pembelian->getTotalPembelian($nobukti)->row_array();
    $data['cekkb']      = $this->Model_pembelian->cekKB($nobukti)->num_rows();
    $data['pemohon']    = $this->Model_pembelian->getPemohon()->result();
    $this->template->load('template/template', 'pembelian/edit_pembelian', $data);
  }

  function view_detailpembelian()
  {
    $nobukti             = $this->input->post('nobukti');
    $data['detailpmb']   = $this->Model_pembelian->getDetailPembelian($nobukti)->result();
    $this->load->view('pembelian/view_detailpembelian', $data);
  }

  function update_pembelian()
  {
    $this->Model_pembelian->update_pembelian();
  }

  function insertdetailpembelian()
  {
    $this->Model_pembelian->insertdetailpembelian();
  }

  function detailpembeliankb()
  {
    $nobukti         = $this->input->post('nobukti');
    $data['detail']  = $this->Model_pembelian->getDetailPembelian($nobukti)->result();
    $pmbpnj          = $this->Model_pembelian->getDetailPnjPembelian($nobukti);
    $data['cekpnj']  = $pmbpnj->num_rows();
    $data['pmbpnj']  = $pmbpnj->result();
    $this->load->view('pembelian/detail_pembeliankb', $data);
  }

  function statuspesanan()
  {
    $nobpb = $this->input->post('nobpb');
    $data['bpb'] = $this->Model_pembelian->getBPB($nobpb)->row_array();
    // var_dump($data['bpb']);
    // die;
    $this->load->view('pembelian/statuspesanan', $data);
  }

  function update_pemesanan()
  {
    $this->Model_pembelian->update_pemesanan();
  }

  function inputpenjualan()
  {
    $data['nobukti'] = $this->input->post('nobukti');
    $data['jenistransaksi'] = $this->input->post('jenistransaksi');
    $data['akun']    = $this->Model_pembelian->getAkunPembelian()->result();
    $this->load->view('pembelian/inputpenjualan', $data);
  }

  function insert_penjualan()
  {
    $this->Model_pembelian->insert_penjualan();
  }

  function loaddatapenjualan()
  {
    $nobukti    = $this->input->post('nobukti');
    $data['pnj'] = $this->Model_pembelian->loaddatapenjualan($nobukti)->result();
    $this->load->view('pembelian/loaddatapenjualan', $data);
  }

  function hapus_detailpenjpmb()
  {
    $this->Model_pembelian->hapus_detailpenjpmb();
  }

  function jatuhtempo($rowno = 0)
  {
    // Search text
    $nobukti      = "";
    $dari         = "";
    $sampai       = "";
    $departemen   = "";

    if ($this->input->post('submit') != NULL) {
      $nobukti       = $this->input->post('nobukti');
      $dari         = $this->input->post('dari');
      $sampai       = $this->input->post('sampai');
      $departemen   = $this->input->post('departemen');
      $data   = array(
        'nobukti'        => $nobukti,
        'dari'         => $dari,
        'sampai'       => $sampai,
        'departemen'   => $departemen
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nobukti') != NULL) {
        $nobukti = $this->session->userdata('nobukti');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $dari = $this->session->userdata('sampai');
      }
      if ($this->session->userdata('departemen') != NULL) {
        $departemen = $this->session->userdata('departemen');
      }
    }
    // Row per page
    $rowperpage = 100;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_pembelian->getrecordJatuhtempoCount($nobukti, $dari, $sampai, $departemen);
    // Get records
    $users_record = $this->Model_pembelian->getDataJatuhtempo($rowno, $rowperpage, $nobukti, $dari, $sampai, $departemen);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'pembelian/jatuhtempo';
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
    $data['nobukti']               = $nobukti;
    $data['dari']                  = $dari;
    $data['sampai']               = $sampai;
    $data['departemen']            = $departemen;
    $data['dept']                 = $this->Model_pembelian->getPemohon()->result();
    //echo $data['cb'];
    $this->template->load('template/template', 'pembelian/jatuhtempo', $data);
  }

  function getjmldatapmb()
  {
    $cekjmldatapmb = $this->Model_pembelian->getjmldatapmb()->num_rows();
    echo $cekjmldatapmb;
  }

  function cetakkontrabon()
  {
    $nokontrabon = str_replace(".", "/", $this->uri->segment(3));
    // echo $nokontrabon;
    // die;
    $data['kontrabon'] = $this->Model_pembelian->getKontrabon($nokontrabon)->row_array();
    $data['detail']    = $this->Model_pembelian->getDetailKontrabon($nokontrabon)->result();
    $this->load->view('pembelian/cetak_kontrabon', $data);
  }

  function cetakbppb()
  {
    $nobukti = str_replace(".", "/", $this->uri->segment(3));
    // echo $nokontrabon;
    // die;
    $data['pmb']      = $this->Model_pembelian->getPembelian($nobukti)->row_array();
    $data['detail']   = $this->Model_pembelian->getDetailPembelian($nobukti)->result();
    $this->load->view('pembelian/cetak_bppb', $data);
  }


  function retur($rowno = 0)
  {

    $nobukti          = "";
    $tgl_retur        = "";

    if ($this->input->post('submit') != NULL) {
      $nobukti                 = $this->input->post('nobukti');
      $tgl_retur               = $this->input->post('tgl_retur');
      $data   = array(
        'nobukti'               => $nobukti,
        'tgl_retur'             => $tgl_retur,
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('nobukti') != NULL) {
        $nobukti = $this->session->userdata('nobukti');
      }

      if ($this->session->userdata('tgl_retur') != NULL) {
        $tgl_retur = $this->session->userdata('tgl_retur');
      }
    }
    $rowperpage = 10;
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudangbahan->getrecordreturCount($nobukti, $tgl_retur);
    $users_record                 = $this->Model_gudangbahan->getDataretur($rowno, $rowperpage, $nobukti, $tgl_retur);
    $config['base_url']           = base_url() . 'gudangbahan/retur';
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
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                  = $rowno;
    $data['nobukti']              = $nobukti;
    $data['tgl_retur']            = $tgl_retur;
    $this->template->load('template/template', 'gudangbahan/retur', $data);
  }


  function dotoko($rowno = 0)
  {
    // Search text
    $nodo        = "";
    $tgl_do      = "";
    $departemen  = "";
    $supplier    = "";
    if ($this->input->post('submit') != NULL) {
      $nodo           = $this->input->post('nodo');
      $tgl_do         = $this->input->post('tgl_do');
      $departemen     = $this->input->post('departemen');
      $supplier       = $this->input->post('supplier');
      $data   = array(
        'nodo'            => $nodo,
        'tgl_do'         => $tgl_do,
        'departemen'     => $departemen,
        'supplier'       => $supplier
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('nodo') != NULL) {
        $nodo = $this->session->userdata('nodo');
      }
      if ($this->session->userdata('tgl_do') != NULL) {
        $tgl_do = $this->session->userdata('tgl_do');
      }
      if ($this->session->userdata('departemen') != NULL) {
        $departemen = $this->session->userdata('departemen');
      }

      if ($this->session->userdata('supplier') != NULL) {
        $supplier = $this->session->userdata('supplier');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_pembelian->getrecordDOToko($nodo, $tgl_do, $departemen, $supplier);
    // Get records
    $users_record = $this->Model_pembelian->getDataDOToko($rowno, $rowperpage, $nodo, $tgl_do, $departemen, $supplier);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'pembelian/dotoko';
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
    $data['nodo']                 = $nodo;
    $data['tgl_do']                = $tgl_do;
    $data['departemen']            = $departemen;
    $data['supplier']             = $supplier;
    $data['dept']                 = $this->Model_pembelian->getPemohon()->result();
    $data['supp']                 = $this->Model_pembelian->listSupplier()->result();
    //echo $data['cb'];
    $this->template->load('template/template', 'pembelian/dotoko', $data);
  }

  function inputdotoko()
  {
    $data['pemohon']     = $this->Model_pembelian->getPemohon()->result();
    $this->template->load('template/template', 'pembelian/do_input', $data);
  }

  function dodetailtemp()
  {
    $departemen   = $this->uri->segment(3);
    $data['do']   = $this->Model_pembelian->getDOdetailtemp($departemen)->result();
    $this->load->view('pembelian/do_detailtemp', $data);
  }

  function insertdetaildotemp()
  {
    $this->Model_pembelian->insertdetaildotemp();
  }

  function hapus_detaildo_temp()
  {
    $this->Model_pembelian->hapus_detaildo_temp();
  }

  function insert_dotoko()
  {
    $this->Model_pembelian->insert_dotoko();
  }

  function cekdatabpb()
  {
    $cekdata = $this->Model_pembelian->cekdatabpb()->num_rows();
    echo $cekdata;
  }

  function editbarang()
  {
    $nobukti      = $this->input->post('nobukti');
    $kodebarang   = $this->input->post('kodebarang');
    $keterangan    = $this->input->post('keterangan');
    $data['tglpembelian'] = $this->input->post('tglpembelian');
    $data['brg']  = $this->Model_pembelian->getDetailBarang($nobukti, $kodebarang, $keterangan)->row_array();
    $data['coa']  = $this->Model_pembelian->getCOA()->result();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('pembelian/edit_detailbarang', $data);
  }

  function update_detailbarang()
  {
    $this->Model_pembelian->update_detailbarang();
  }

  function jurnalkoreksi($rowno = 0)
  {
    // Search text
    $dari           = "";
    $sampai         = "";

    if ($this->input->post('submit') != NULL) {
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');


      $data   = array(
        'dari'         => $dari,
        'sampai'       => $sampai,
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }

      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }


    $data['jurnalkoreksi']     = $this->Model_pembelian->jurnalkoreksi($dari, $sampai)->result();
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $this->template->load('template/template', 'pembelian/jurnalkoreksi', $data);
  }

  function inputjurnalkoreksi()
  {
    $data['supp'] = $this->Model_pembelian->listSupplier()->result();
    $data['coa']  = $this->Model_pembelian->getCOA()->result();
    $this->load->view('pembelian/jurnalkoreksi_input', $data);
  }

  function get_pembelian()
  {
    $supplier = $this->input->post('supplier');
    $pembelian = $this->Model_pembelian->jsonPilihPembelian($supplier)->result();
    echo "<option value=''>Pilih No Bukti Pembelian</option>";
    foreach ($pembelian as $p) {
      echo "<option value='$p->nobukti_pembelian'>$p->nobukti_pembelian</option>";
    }
  }

  function get_barangpembelian()
  {
    $nobukti = $this->input->post('nobuktipembelian');
    $barang = $this->Model_pembelian->getBarangpembelian($nobukti)->result();
    echo "<option value=''>Pilih Barang</option>";
    foreach ($barang as $p) {
      echo "<option value='$p->kode_barang'>$p->nama_barang</option>";
    }
  }

  function insertjurnalkoreksi()
  {
    $this->Model_pembelian->insertjurnalkoreksi();
  }

  function hapusjurnalkoreksi()
  {
    $this->Model_pembelian->hapusjurnalkoreksi();
  }
}
