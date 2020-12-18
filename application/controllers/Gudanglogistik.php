<?php

class Gudanglogistik extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_gudanglogistik', 'Model_cabang'));
  }

  function pembelian($rowno = 0)
  {
    // Search text
    $nobukti           = "";
    $tgl_pembelian    = "";
    $departemen       = "";
    $supplier         = "";
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
    if ($this->input->post('submit') != NULL) {
      $nobukti                = $this->input->post('nobukti');
      $tgl_pembelian         = $this->input->post('tgl_pembelian');
      $departemen            = $this->input->post('departemen');
      $supplier              = $this->input->post('supplier');
      $ppn                   = $this->input->post('ppn');
      $ln                    = $this->input->post('ln');
      $data   = array(
        'nobukti'                => $nobukti,
        'tgl_pembelian'         => $tgl_pembelian,
        'departemen'           => $departemen,
        'supplier'             => $supplier,
        'ppn'                  => $ppn,
        'ln'                   => $ln
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
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_gudanglogistik->getrecordPembelianCount($nobukti, $tgl_pembelian, $departemen, $ppn, $ln, $supplier);
    // Get records
    $users_record = $this->Model_gudanglogistik->getDataPembelian($rowno, $rowperpage, $nobukti, $tgl_pembelian, $departemen, $ppn, $ln, $supplier);
    // Pagination Configuration
    $config['base_url']       = base_url() . 'gudanglogistik/pembelian';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']       = $allcount;
    $config['per_page']       = $rowperpage;
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
    $data['pagination']             = $this->pagination->create_links();
    $data['result']             = $users_record;
    $data['row']               = $rowno;
    $data['nobukti']               = $nobukti;
    $data['tgl_pembelian']          = $tgl_pembelian;
    $data['departemen']              = $departemen;
    $data['ppn']                    = $ppn;
    $data['ln']                     = $ln;
    $data['dept']                   = $this->Model_gudanglogistik->getPemohon()->result();
    $data['supp']                   = $this->Model_gudanglogistik->listSupplier()->result();
    $data['supplier']               = $supplier;
    //echo $data['cb'];
    $this->template->load('template/template', 'gudanglogistik/pembelian', $data);
  }

  function detail_pembelian()
  {
    $nobukti            = $this->input->post('nobukti');
    $data['pmb']        = $this->Model_gudanglogistik->getPembelian($nobukti)->row_array();
    $data['detail']     = $this->Model_gudanglogistik->getDetailPembelian($nobukti)->result();
    $pmbpnj             = $this->Model_gudanglogistik->getDetailPnjPembelian($nobukti);
    $data['cekpnj']     = $pmbpnj->num_rows();
    $data['pmbpnj']     = $pmbpnj->result();
    $data['kb']         = $this->Model_gudanglogistik->listKontraBonPMB($nobukti)->result();

    $this->load->view('gudanglogistik/detail_pembelian', $data);
  }

  function hapus_detaileditpengeluaran()
  {

    $this->Model_gudanglogistik->hapus_detaileditpengeluaran();
  }

  function inputsaldoawal()
  {

    $data['barang']    = $this->Model_gudanglogistik->listproduk()->result();
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['kategori']  = $this->Model_gudanglogistik->getKategori()->result();
    $this->template->load('template/template', 'gudanglogistik/inputsaldoawal', $data);
  }


  function inputopname()
  {

    $data['barang']    = $this->Model_gudanglogistik->listproduk()->result();
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['kategori']  = $this->Model_gudanglogistik->getKategori()->result();
    $this->template->load('template/template', 'gudanglogistik/inputopname', $data);
  }


  function inputdetailopname()
  {

    $data['opname']    = $this->Model_gudanglogistik->getinputopnamedetail()->row_array();
    $this->template->load('template/template', 'gudanglogistik/inputdetailopname', $data);
  }

  function inputdetailsaldoawal()
  {

    $data['saldoawal']    = $this->Model_gudanglogistik->getinputsaldoawaldetail()->row_array();
    $this->template->load('template/template', 'gudanglogistik/inputdetailsaldoawal', $data);
  }

  function getdetailopname()
  {

    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $kode_opname_gl = $this->input->post('kode_opname_gl');
    $kode_kategori  = $this->input->post('kode_kategori');
    $kode_barang    = $this->input->post('kode_barang');
    $data['detail'] = $this->Model_gudanglogistik->getdetailopname($bulan, $tahun, $kode_opname_gl, $kode_kategori, $kode_barang)->result();
    $this->load->view('gudanglogistik/getopname', $data);
  }

  function getsaldoawal()
  {

    $bulan             = $this->input->post('bulan');
    $tahun             = $this->input->post('tahun');
    $kode_kategori     = $this->input->post('kode_kategori');
    $kode_saldoawal_gl = $this->input->post('kode_saldoawal_gl');
    $data['detail']    = $this->Model_gudanglogistik->getsaldo($bulan, $tahun, $kode_kategori, $kode_saldoawal_gl)->result();
    $this->load->view('gudanglogistik/getsaldoawal', $data);
  }

  function getopnamestok()
  {

    $bulan             = $this->input->post('bulan');
    $tahun             = $this->input->post('tahun');
    $kode_kategori     = $this->input->post('kode_kategori');
    $kode_opname_gl = $this->input->post('kode_opname_gl');
    $data['detail']    = $this->Model_gudanglogistik->getopnamestok($bulan, $tahun, $kode_kategori, $kode_opname_gl)->result();
    $this->load->view('gudanglogistik/getopnamestok', $data);
  }

  function getdetailsaldo()
  {

    $bulan             = $this->input->post('bulan');
    $tahun             = $this->input->post('tahun');
    $kode_saldoawal_gl = $this->input->post('kode_saldoawal_gl');
    $kode_kategori     = $this->input->post('kode_kategori');
    $data['detail']    = $this->Model_gudanglogistik->getdetailsaldo($bulan, $tahun, $kode_saldoawal_gl, $kode_kategori)->result();
    $this->load->view('gudanglogistik/getsaldo', $data);
  }

  function gethasildetailopname()
  {

    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $kode_kategori  = $this->input->post('kode_kategori');
    $kode_barang    = $this->input->post('kode_barang');
    $data['detail']    = $this->Model_gudanglogistik->gethasildetailsaldo($bulan, $tahun, $kode_kategori, $kode_barang)->result();
    $this->load->view('gudanglogistik/hasildetailopname', $data);
  }

  function gethasilqtysaldoawal()
  {

    $bulan             = $this->input->post('bulan');
    $tahun             = $this->input->post('tahun');
    $kode_kategori     = $this->input->post('kode_kategori');
    $kode_barang       = $this->input->post('kode_barang');
    $data              = $this->Model_gudanglogistik->gethasildetailsaldo($bulan, $tahun, $kode_kategori, $kode_barang)->row_array();
    $qtysaldoawal      = $data['qtysaldoawal'];
    $qtypemasukan      = $data['qtypemasukan'];
    $qtypengeluaran    = $data['qtypengeluaran'];
    $hasilqty          = $qtysaldoawal + $qtypemasukan - $qtypengeluaran;
    echo $hasilqty;
  }

  function gethasilhargasaldoawal()
  {

    $bulan                = $this->input->post('bulan');
    $tahun                = $this->input->post('tahun');
    $kode_kategori        = $this->input->post('kode_kategori');
    $kode_barang          = $this->input->post('kode_barang');
    $data                 = $this->Model_gudanglogistik->gethasildetailsaldo($bulan, $tahun, $kode_kategori, $kode_barang)->row_array();

    $qtyrata          = $data['qtysaldoawal'] + $data['qtypemasukan'];
    if ($qtyrata != "") {
      $qtyrata        = $data['qtysaldoawal'] + $data['qtypemasukan'];
    } else {
      $qtyrata        = 1;
    }

    if ($data['hargasaldoawal'] == "" and $data['hargasaldoawal'] == "0") {
      $hasilharga      = $data['hargapemasukan'];
    } elseif ($data['hargapemasukan'] == "" and $data['hargapemasukan'] == "0") {
      $hasilharga      = $data['hargapemasukan'];
    } else {
      $hasilharga      = (($data['totalsa'] * 1) + ($data['totalpemasukan'] * 1)) / $qtyrata;
    }
    echo round($hasilharga, 2);
  }

  function input_saldoawal()
  {

    $this->Model_gudanglogistik->insert_saldoawal();
  }

  function input_opname()
  {

    $this->Model_gudanglogistik->insert_opname();
  }

  function simpanopname()
  {

    $this->Model_gudanglogistik->insert_detail_opname();
  }


  function simpansaldoawal()
  {

    $this->Model_gudanglogistik->insert_detail_saldoawal();
  }


  function prosessaldoawal()
  {

    $this->Model_gudanglogistik->insert_prosessaldoawal();
  }

  function prosesopname()
  {

    $this->Model_gudanglogistik->insert_prosesopname();
  }


  function opname($rowno = 0)
  {

    $kode_opname_gl         = "";
    $tanggal                = "";

    if ($this->input->post('submit') != NULL) {
      $kode_opname_gl          = $this->input->post('kode_opname_gl');
      $tanggal                 = $this->input->post('tanggal');
      $data   = array(
        'kode_opname_gl'        => $kode_opname_gl,
        'tanggal'               => $tanggal,
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('kode_opname_gl') != NULL) {
        $kode_opname_gl = $this->session->userdata('kode_opname_gl');
      }

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
    }
    $rowperpage = 10;
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudanglogistik->getrecordopnameCount($kode_opname_gl, $tanggal);
    $users_record                 = $this->Model_gudanglogistik->getDataopname($rowno, $rowperpage, $kode_opname_gl, $tanggal);
    $config['base_url']           = base_url() . 'gudanglogistik/pemasukan';
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
    $data['row']                   = $rowno;
    $data['kode_opname_gl']      = $kode_opname_gl;
    $data['tanggal']              = $tanggal;
    $this->template->load('template/template', 'gudanglogistik/opname', $data);
  }

  function saldoawal($rowno = 0)
  {

    $kode_saldoawal_gl      = "";
    $tanggal                = "";
    $kode_kategori          = "";

    if ($this->input->post('submit') != NULL) {
      $kode_saldoawal_gl       = $this->input->post('kode_saldoawal_gl');
      $tanggal                 = $this->input->post('tanggal');
      $kode_kategori           = $this->input->post('kode_kategori');
      $data   = array(
        'kode_saldoawal_gl'    => $kode_saldoawal_gl,
        'tanggal'              => $tanggal,
        'kode_kategori'        => $kode_kategori,
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('kode_saldoawal_gl') != NULL) {
        $kode_saldoawal_gl = $this->session->userdata('kode_saldoawal_gl');
      }

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }

      if ($this->session->userdata('kode_kategori') != NULL) {
        $kode_kategori = $this->session->userdata('kode_kategori');
      }
    }
    $rowperpage = 10;
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudanglogistik->getrecordSaldoawalnCount($kode_saldoawal_gl, $tanggal, $kode_kategori);
    $users_record                 = $this->Model_gudanglogistik->getDataSaldoawal($rowno, $rowperpage, $kode_saldoawal_gl, $tanggal, $kode_kategori);
    $config['base_url']           = base_url() . 'gudanglogistik/pemasukan';
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
    $data['kode_saldoawal_gl']    = $kode_saldoawal_gl;
    $data['tanggal']              = $tanggal;
    $data['kategori']             = $this->Model_gudanglogistik->getKategori()->result();
    $this->template->load('template/template', 'gudanglogistik/saldoawal', $data);
  }


  function pemasukan($rowno = 0)
  {

    $nobukti          = "";
    $tgl_pemasukan    = "";

    if ($this->input->post('submit') != NULL) {
      $nobukti                 = $this->input->post('nobukti');
      $tgl_pemasukan           = $this->input->post('tgl_pemasukan');
      $data   = array(
        'nobukti'              => $nobukti,
        'tgl_pemasukan'        => $tgl_pemasukan,
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('nobukti') != NULL) {
        $nobukti = $this->session->userdata('nobukti');
      }

      if ($this->session->userdata('tgl_pemasukan') != NULL) {
        $tgl_pemasukan = $this->session->userdata('tgl_pemasukan');
      }
    }
    $rowperpage = 10;
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudanglogistik->getrecordPemasukanCount($nobukti, $tgl_pemasukan);
    $users_record                 = $this->Model_gudanglogistik->getDataPemasukan($rowno, $rowperpage, $nobukti, $tgl_pemasukan);
    $config['base_url']           = base_url() . 'gudanglogistik/pemasukan';
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
    $data['tgl_pemasukan']        = $tgl_pemasukan;
    $this->template->load('template/template', 'gudanglogistik/pemasukan', $data);
  }

  function pengeluaran($rowno = 0)
  {

    $nobukti           = "";
    $tgl_pengeluaran  = "";
    $kode_dept        = "";

    if ($this->input->post('submit') != NULL) {

      $nobukti                   = $this->input->post('nobukti');
      $tgl_pengeluaran         = $this->input->post('tgl_pengeluaran');
      $kode_dept                = $this->input->post('kode_dept');

      $data   = array(
        'nobukti'                => $nobukti,
        'tgl_pengeluaran'      => $tgl_pengeluaran,
        'kode_dept'             => $kode_dept,
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('nobukti') != NULL) {
        $nobukti = $this->session->userdata('nobukti');
      }

      if ($this->session->userdata('tgl_pengeluaran') != NULL) {
        $tgl_pengeluaran = $this->session->userdata('tgl_pengeluaran');
      }

      if ($this->session->userdata('kode_dept') != NULL) {
        $kode_dept = $this->session->userdata('kode_dept');
      }
    }
    $rowperpage = 10;
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudanglogistik->getrecordPengeluaranCount($nobukti, $tgl_pengeluaran, $kode_dept);
    $users_record                 = $this->Model_gudanglogistik->getDataPengeluaran($rowno, $rowperpage, $nobukti, $tgl_pengeluaran, $kode_dept);
    $config['base_url']           = base_url() . 'gudanglogistik/pengeluaran';
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
    $data['row']                   = $rowno;
    $data['kode_dept']             = $kode_dept;
    $data['nobukti']               = $nobukti;
    $data['tgl_pengeluaran']      = $tgl_pengeluaran;
    $data['dept']                 = $this->Model_gudanglogistik->getDept()->result();
    $this->template->load('template/template', 'gudanglogistik/pengeluaran', $data);
  }

  function input_pemasukan()
  {
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->template->load('template/template', 'gudanglogistik/input_pemasukan', $data);
  }

  function tabelakun()
  {

    $this->load->view('gudanglogistik/tabelakun');
  }

  function tabelbarang()
  {

    $this->load->view('gudanglogistik/tabelbarang');
  }

  function hapus_detal_opname()
  {

    $kode_barang    = $this->input->post('kode_barang');
    $kode_opname_gl = $this->input->post('kode_opname_gl');
    $this->db->query("DELETE FROM opname_gl_detail WHERE kode_opname_gl = '$kode_opname_gl' AND kode_barang = '$kode_barang' ");
  }

  function hapus_detal_saldoawal()
  {

    $kode_barang        = $this->input->post('kode_barang');
    $kode_saldoawal_gl  = $this->input->post('kode_saldoawal_gl');
    $this->db->query("DELETE FROM saldoawal_gl_detail WHERE kode_saldoawal_gl = '$kode_saldoawal_gl' AND kode_barang = '$kode_barang' ");
  }

  function tabelbarangopname()
  {
    $data['kode_kategori']  = $this->input->post('kode_kategori');
    $data['bulan']          = $this->input->post('bulan');
    $data['tahun']          = $this->input->post('tahun');
    $this->load->view('gudanglogistik/tabelbarangopname', $data);
  }


  function tabelbarangsaldoawal()
  {
    $data['kode_kategori']  = $this->input->post('kode_kategori');
    $data['bulan']          = $this->input->post('bulan');
    $data['tahun']          = $this->input->post('tahun');
    $this->load->view('gudanglogistik/tabelbarangsaldoawal', $data);
  }

  function detail_pemasukan()
  {

    $data['data']    = $this->Model_gudanglogistik->getPemasukan()->row_array();
    $data['detail']  = $this->Model_gudanglogistik->getDetailPemasukan();
    $this->load->view('gudanglogistik/detail_pemasukan', $data);
  }

  function detail_saldoawal()
  {

    $data['data']    = $this->Model_gudanglogistik->getSaldoawal()->row_array();
    $data['detail']  = $this->Model_gudanglogistik->getDetailSaldoAwal();
    $this->load->view('gudanglogistik/detail_saldoawal', $data);
  }

  function detail_opname()
  {

    $data['data']    = $this->Model_gudanglogistik->getOpname()->row_array();
    $data['detail']  = $this->Model_gudanglogistik->getDetailopnamestok();
    $this->load->view('gudanglogistik/detail_opname', $data);
  }

  function insert_pembelian()
  {

    $this->Model_gudanglogistik->insert_pembelian();
  }

  function detail_pengeluaran()
  {

    $data['data']    = $this->Model_gudanglogistik->getPengeluaran()->row_array();
    $data['detail']  = $this->Model_gudanglogistik->getDetailPengeluaran();
    $this->load->view('gudanglogistik/detail_pengeluaran', $data);
  }

  function view_detailpemasukan_temp()
  {

    $data['data']  = $this->Model_gudanglogistik->getPemasukantemp();
    $this->load->view('gudanglogistik/view_detailpemasukan_temp', $data);
  }

  function hapuspengeluaran()
  {

    $this->Model_gudanglogistik->hapuspengeluaran();
    redirect('gudanglogistik/pengeluaran');
  }

  function hapuspemasukan()
  {

    $this->Model_gudanglogistik->hapuspemasukan();
    redirect('gudanglogistik/pemasukan');
  }

  function hapussaldoawal()
  {

    $this->Model_gudanglogistik->hapussaldoawal();
    redirect('gudanglogistik/saldoawal');
  }

  function hapusopname()
  {

    $this->Model_gudanglogistik->hapusopname();
    redirect('gudanglogistik/opname');
  }

  function insert_pemasukan()
  {

    $this->Model_gudanglogistik->insert_pemasukan();
  }

  function hapus_detailpemasukan_temp()
  {

    $this->Model_gudanglogistik->hapus_detailpemasukan_temp();
  }

  function inputpemasukan_temp()
  {

    $this->Model_gudanglogistik->insertpemasukan_temp();
  }

  function view_pengeluaran()
  {

    $this->template->load('template/template', 'gudanglogistik/view_pengeluaran');
  }

  function input_pengeluaran()
  {

    $data['dept']     = $this->Model_gudanglogistik->getDept()->result();
    $data['cabang']   = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'gudanglogistik/input_pengeluaran', $data);
  }

  function edit_pengeluaran()
  {

    $data['edit']    = $this->Model_gudanglogistik->geteditpengeluaran()->row_array();
    $data['dept']    = $this->Model_gudanglogistik->getDept()->result();
    $data['cabang']   = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'gudanglogistik/edit_pengeluaran', $data);
  }

  function view_detailpengeluaran_temp()
  {

    $data['data']  = $this->Model_gudanglogistik->getPengeluarantemp();
    $this->load->view('gudanglogistik/view_detailpengeluaran_temp', $data);
  }


  function view_detaileditpengeluaran()
  {

    $data['data']  = $this->Model_gudanglogistik->getdetaileditPengeluaran();
    $data['cabang']   = $this->Model_cabang->view_cabang()->result();
    $this->load->view('gudanglogistik/view_detaileditpengeluaran', $data);
  }

  function insert_pengeluaran()
  {

    $this->Model_gudanglogistik->insert_pengeluaran();
  }

  function hapus_detailpengeluaran_temp()
  {

    $this->Model_gudanglogistik->hapus_detailpengeluaran_temp();
  }

  function inputpengeluaran_temp()
  {

    $this->Model_gudanglogistik->insertpengeluaran_temp();
  }

  function update_pengeluaran()
  {

    $this->Model_gudanglogistik->update_pengeluaran();
  }

  function updatedetailpengeluaran()
  {

    $this->Model_gudanglogistik->updatedetailpengeluaran();
  }

  function jsonPilihBarang()
  {

    header('Content-Type: application/json');
    echo $this->Model_gudanglogistik->jsonPilihBarang();
  }

  function jsonPilihBarangSaldoawal()
  {

    header('Content-Type: application/json');
    echo $this->Model_gudanglogistik->jsonPilihBarangSaldoawal();
  }

  function jsonPilihBarangOpname()
  {

    header('Content-Type: application/json');
    echo $this->Model_gudanglogistik->jsonPilihBarangOpname();
  }

  function jsonPilihAkun()
  {

    header('Content-Type: application/json');
    echo $this->Model_gudanglogistik->jsonPilihAkun();
  }

  function barang()
  {
    $this->template->load('template/template', 'gudanglogistik/view_barang');
  }
}
