<?php

class Laporankeuangan extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_keuangan'));
  }

  function ledger()
  {
    $cabang       = $this->session->userdata('cabang');
    $cbg = $cabang;
    if ($cabang == 'pusat') {
      $cabang = "";
    } else {
      $cabang = $cabang;
    }
    $data['bank'] = $this->Model_keuangan->getBank($cabang)->result();
    if ($cbg == "pusat") {
      $this->template->load('template/template', 'laporankeuangan/ledger.php', $data);
    } else {
      $this->template->load('template/template', 'laporankaskecil/mutasibank', $data);
    }
  }

  function cetak_ledger()
  {
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Ledger.xls");
    }
    $bank             = $this->input->post('bank');
    $dari             = $this->input->post('dari');
    $sampai           = $this->input->post('sampai');
    $jl               = $this->input->post('jenislaporan');
    $data['dari']     = $dari;
    $data['sampai']   = $sampai;
    $data['saldo']     = $this->Model_keuangan->getSaldoAwalledger($bank, $dari)->row_array();
    $data['bank']     = $this->Model_keuangan->getWhereBank($bank)->row_array();
    if ($jl == 'detail') {
      $data['ledger'] = $this->Model_keuangan->ledger($bank, $dari, $sampai)->result();
      $this->load->view('laporankeuangan/cetak_ledger', $data);
    } else if ($jl == 'rekap') {
      $data['rekap'] = $this->Model_keuangan->rekapledger($bank, $dari, $sampai)->result();
      $this->load->view('laporankeuangan/cetak_rekapledger', $data);
    }
  }
}
