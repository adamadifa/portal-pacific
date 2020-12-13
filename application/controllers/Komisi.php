<?php
class Komisi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->Model(array('Model_cabang', 'Model_komisi', 'Model_sales', 'Model_barang', 'Model_laporanpenjualan'));
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
      'kode_target' => "TK" . $bulan . $thn,
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

  function inputsettarget()
  {
    $kodetarget = $this->input->post('kodetarget');
    $data['kodetarget'] = $kodetarget;
    $data['produk']  = $this->Model_barang->getMasterproduk()->result();
    $data['jmlproduk']  = $this->Model_barang->getMasterproduk()->num_rows();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('komisi/komisi_inputsettarget', $data);
  }

  function inputsettargetcashin()
  {
    $kodetarget = $this->input->post('kodetarget');
    $data['kodetarget'] = $kodetarget;
    $data['produk']  = $this->Model_barang->getMasterproduk()->result();
    $data['jmlproduk']  = $this->Model_barang->getMasterproduk()->num_rows();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->load->view('komisi/komisi_inputsettargetcashin', $data);
  }


  function loadlisttarget()
  {
    $kodetarget = $this->input->post('kodetarget');
    $cabang = $this->input->post('cabang');
    $data['kodetarget'] = $kodetarget;
    $data['produk']  = $this->Model_barang->getMasterproduk()->result();
    $data['salesman'] = $this->Model_laporanpenjualan->get_salesman($cabang)->result();
    $this->load->view('komisi/komisi_loadlisttarget', $data);
  }

  function loadlisttargetcashin()
  {
    $kodetarget = $this->input->post('kodetarget');
    $cabang = $this->input->post('cabang');
    $data['kodetarget'] = $kodetarget;
    $data['salesman'] = $this->Model_laporanpenjualan->get_salesman($cabang)->result();
    $this->load->view('komisi/komisi_loadlisttargetcashin', $data);
  }

  function simpantarget()
  {
    $kodetarget = $this->input->post('kodetarget');
    $salesman = $this->input->post('salesman');
    $produk = $this->input->post('produk');
    $jmltarget = $this->input->post('jmltarget');
    $data = [
      'kode_target' => $kodetarget,
      'id_karyawan' => $salesman,
      'kode_produk' => $produk,
      'jumlah_target' => $jmltarget
    ];

    $simpan = $this->Model_komisi->simpantarget($data);
  }

  function simpantargetcashin()
  {
    $kodetarget = $this->input->post('kodetarget');
    $salesman = $this->input->post('salesman');
    $jmltarget = $this->input->post('jmltarget');
    $data = [
      'kode_target' => $kodetarget,
      'id_karyawan' => $salesman,
      'jumlah_target_cashin' => $jmltarget
    ];

    $simpan = $this->Model_komisi->simpantargetcashin($data);
  }

  function targetcashin()
  {
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->template->load('template/template', 'komisi/komisi_targetcashin', $data);
  }

  function kategoripoinqty()
  {
    $data['kategoripoin'] = $this->Model_komisi->getKategoripoin()->result();
    $this->template->load('template/template', 'komisi/komisi_kategoripoinqty', $data);
  }
}
