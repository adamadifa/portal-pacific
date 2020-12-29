<?php

class Laporanaccounting extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_accounting', 'Model_keuangan', 'Model_laporanaccounting'));
  }

  function frmbukubesar()
  {
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['coa']       = $this->Model_accounting->coa()->result();
    $this->template->load('template/template', 'laporanaccounting/frmbukubesar', $data);
  }
  function cetakbukubesar()
  {
    $data['bln'] = $this->input->post('bulan');
    $data['tahun'] = $this->input->post('tahun');
    $data['kode_akun'] = $this->input->post('kode_akun');
    $data['saldoawal'] = $this->Model_laporanaccounting->getSaldoawalBB($data['bln'], $data['tahun'], $data['kode_akun'])->row_array();
    $data['bukubesar'] = $this->Model_laporanaccounting->getBukubesar($data['bln'], $data['tahun'], $data['kode_akun'])->result();
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['akun']       = $this->Model_laporanaccounting->coa($data['kode_akun'])->row_array();
    $this->load->view('laporanaccounting/cetak_bukubesar', $data);
  }

  function frmjurnalumum()
  {
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['coa']       = $this->Model_accounting->coa()->result();
    $this->template->load('template/template', 'laporanaccounting/frmjurnalumum', $data);
  }

  function cetak_jurnalumum()
  {
    $data['dari'] = $this->input->post('dari');
    $data['sampai'] = $this->input->post('sampai');
    $data['jurnalumum'] = $this->Model_laporanaccounting->getJurnalUmum($data['dari'], $data['sampai'])->result();
    $this->load->view('laporanaccounting/cetak_jurnalumum', $data);
  }
}
