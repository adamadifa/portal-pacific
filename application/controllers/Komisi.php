<?php
class Komisi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->Model(array('Model_cabang', 'Model_komisi', 'Model_sales'));
  }

  function targetkomisi()
  {
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->template->load('template/template', 'komisi/komisi_target', $data);
  }

  function settarget()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $thn = substr($tahun, 2, 2);
    $data = [
      'kode_target' => "TR" . $bulan . $thn,
      'bulan' => $bulan,
      'tahun' => $tahun
    ];
    $settarget = $this->Model_komisi->settarget($data);
    echo $settarget;
  }

  function loadtarget()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['target'] = $this->Model_komisi->loadtarget($bulan, $tahun)->result();
    $this->load->view('komisi/komisi_loadtarget', $data);
  }
}
