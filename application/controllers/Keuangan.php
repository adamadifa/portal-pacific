<?php

class Keuangan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_keuangan', 'Model_cabang'));
  }

  function ledger()
  {

    $bank       = "";
    $dari       = "";
    $sampai     = "";


    if ($this->input->post('submit') != NULL) {

      $bank     = $this->input->post('bank');
      $dari     = $this->input->post('dari');
      $sampai   = $this->input->post('sampai');
      $data     = array(
        'bank'       => $bank,
        'dari'       => $dari,
        'sampai'     => $sampai
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('bank') != NULL) {
        $bank = $this->session->userdata('bank');
      }
      if ($this->session->userdata('dari') != NULL) {
        $dari = $this->session->userdata('dari');
      }
      if ($this->session->userdata('sampai') != NULL) {
        $sampai = $this->session->userdata('sampai');
      }
    }
    $users_record = $this->Model_keuangan->getdataledger($bank, $dari, $sampai);
    $data['result']             = $users_record;
    $data['dari']               = $dari;
    $data['sampai']             = $sampai;
    $data['bank']               = $bank;
    $data['lbank']              = $this->Model_keuangan->getBank()->result();
    $this->template->load('template/template', 'keuangan/ledger', $data);
  }

  function ledger_input()
  {
    $data['coa']    = $this->Model_keuangan->coa()->result();
    $data['lbank']  = $this->Model_keuangan->getBank()->result();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('keuangan/ledger_input', $data);
  }

  function ledger_edit()
  {
    $nobukti        = $this->input->post('nobukti');
    $data['kodecr'] = $this->input->post('kodecr');
    $data['coa']    = $this->Model_keuangan->coa()->result();
    $data['lbank']  = $this->Model_keuangan->getBank()->result();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['ledger'] = $this->Model_keuangan->getLedger($nobukti)->row_array();
    $this->load->view('keuangan/ledger_edit', $data);
  }

  function view_templedger()
  {
    $data['data']    = $this->Model_keuangan->view_templedger()->result();
    $this->load->view('keuangan/ledger_temp', $data);
  }

  function insertledger_temp()
  {
    $this->Model_keuangan->insertledger_temp();
  }

  function insertledger()
  {
    $this->Model_keuangan->insertledger();
  }

  function updateledger()
  {
    $this->Model_keuangan->updateledger();
  }

  function hapusledger()
  {
    $nobukti = $this->uri->segment(3);
    $kodecr = $this->uri->segment(4);
    $this->Model_keuangan->hapusledger($nobukti, $kodecr);
  }

  function saldoledger()
  {
    // Search text
    $tanggal          = "";
    $bank             = "";
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $tanggal   = $this->input->post('tanggal');
      $bank      = $this->input->post('bank');
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(
        'tanggal'  => $tanggal,
        'bank'    => $bank,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('bank') != NULL) {
        $bank = $this->session->userdata('bank');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }

    $users_record = $this->Model_keuangan->getDataSaldoledger($tanggal, $bank, $bulan, $tahun);
    $data['result']               = $users_record;
    $data['tanggal']              = $tanggal;
    $data['bank']                 = $bank;
    // Load view
    //$data['cabang'] 		          = $this->Model_cabang->view_cabang()->result();
    //$data['cb'] 				          = $this->session->userdata('cabang');
    $data['lbank']                = $this->Model_keuangan->getBank()->result();
    $data['tahun']                = date("Y");
    $data['bulan']                = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']                  = $bulan;
    $data['thn']                  = $tahun;
    $this->template->load('template/template', 'keuangan/saldoawalledger', $data);
  }

  function inputsaldoawalledger()
  {
    $data['lbank']     = $this->Model_keuangan->getBank()->result();
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->load->view('keuangan/saldoawalledger_input', $data);
  }

  function getdetailsaldo()
  {
    $bulan    = $this->input->post('bulan');
    $tahun    = $this->input->post('tahun');
    $bank     = $this->input->post('bank');
    $ceksaldo = $this->Model_keuangan->ceksaldo($bulan, $tahun, $bank)->num_rows();
    $cekall   = $this->Model_keuangan->ceksaldoall($bank)->num_rows();
    $ceknow   = $this->Model_keuangan->ceksaldoSkrg($bulan, $tahun, $bank)->num_rows();
    if (empty($ceksaldo) && !empty($cekall) || !empty($ceknow)) {
      echo "1";
    } else {
      $saldo  = $this->Model_keuangan->getdetailsaldo($bulan, $tahun, $bank)->row_array();
      $mutasi = $this->Model_keuangan->getMutasi($bulan, $tahun, $bank)->row_array();
      $saldoawal = $saldo['jumlah'] + $mutasi['kredit'] - $mutasi['debet'];
      echo $saldoawal;
    }
  }

  function insertsaldoawalledger()
  {
    $this->Model_keuangan->insertsaldoawalledger();
  }

  function cekdata()
  {

    $cek = $this->Model_keuangan->cekdata()->num_rows();
    echo $cek;
  }

  function hapussaldoawalledger()
  {
    $id = $this->uri->segment(3);
    $this->Model_keuangan->hapussaldoawalledger($id);
  }

  function hapus_templedger()
  {
    $this->Model_keuangan->hapus_templedger();
  }


  function insertmutasicabang()
  {
    $this->Model_keuangan->insertmutasicabang();
  }

  function updatemutasicabang()
  {
    $this->Model_keuangan->updatemutasicabang();
  }
}
