<?php

class Laporankaskecil extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_cabang', 'Model_laporankaskecil', 'Model_kaskecil', 'Model_keuangan'));
  }
  function kaskecil()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'laporankaskecil/kaskecil', $data);
  }

  function mutasibank()
  {
    $cabang       = $this->session->userdata('cabang');
    if ($cabang == 'pusat') {
      $cb = 'PST';
    } else {
      $cb = $cabang;
    }
    //echo $cabang;
    $data['lbank']      = $this->Model_keuangan->getBank($cabang)->result();
    $this->template->load('template/template', 'laporankaskecil/mutasibank', $data);
  }


  function cetak_kaskecil()
  {
    $cabang             = $this->input->post('cabang');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');
    $data['dari']        = $dari;
    $data['sampai']      = $sampai;
    $data['saldoawal']  = $this->Model_kaskecil->getSaldoAwal($dari, $sampai, $cabang)->row_array();
    $data['kaskecil']   = $this->Model_laporankaskecil->kaskecil($cabang, $dari, $sampai)->result();
    $data['rekap']      = $this->Model_laporankaskecil->rekapkaskecil($cabang, $dari, $sampai)->result();
    $data['cb']          = $this->Model_cabang->get_cabang($cabang)->row_array();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Kas Kecil.xls");
    }
    $this->load->view('laporankaskecil/cetak_laporankaskecil', $data);
  }

  function cetak_mutasibank()
  {
    $bank               = $this->input->post('bank');
    // echo $cabang;
    // die;
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');
    $data['bank']       = $bank;
    $data['dari']        = $dari;
    $data['sampai']      = $sampai;
    $data['saldo']       = $this->Model_keuangan->getSaldoAwalledger($bank, $dari)->row_array();
    $data['mutasibank'] = $this->Model_keuangan->ledger($bank, $dari, $sampai)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Kas Kecil.xls");
    }
    $this->load->view('laporankaskecil/cetak_mutasibank', $data);
  }
}
