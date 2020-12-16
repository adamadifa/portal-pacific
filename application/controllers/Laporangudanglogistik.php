<?php

class Laporangudanglogistik extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_laporanlogistik', 'Model_cabang'));
  }

  function persediaan()
  {

    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['kategori']  = $this->Model_laporanlogistik->getKategori()->result();
    $this->template->load('template/template', 'laporangudanglogistik/persediaan.php', $data);
  }

  function cetak_persediaan_opname()
  {

    $tahun              = $this->input->post('tahun');
    $kode_kategori      = $this->input->post('kode_kategori');
    $bulan              = $this->input->post('bulan');
    $opname             = 1;
    $data['opname']     = $opname;
    $data['tahun']      = $tahun;
    $data['bulan']      = $bulan;
    $data['kategori']   = $kode_kategori;
    $data['data']       = $this->Model_laporanlogistik->list_detailPersediaan($bulan, $tahun, $kode_kategori)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Persediaan Barang Gudang Logistik.xls");
    }
    $this->load->view('laporangudanglogistik/cetak_persediaan_opname', $data);
  }

  function cetak_persediaan()
  {

    $bulan              = $this->input->post('bulan');
    $tahun              = $this->input->post('tahun');
    $kode_kategori      = $this->input->post('kode_kategori');
    $data['bulan']      = $bulan;
    $data['tahun']      = $tahun;
    $data['kategori']   = $kode_kategori;
    $data['data']       = $this->Model_laporanlogistik->list_detailPersediaan($bulan, $tahun, $kode_kategori)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Persediaan Barang Gudang Logistik.xls");
    }
    $this->load->view('laporangudanglogistik/cetak_persediaan', $data);
  }

  function pemasukan()
  {

    $data['kategori']     = $this->Model_laporanlogistik->getKategori()->result();
    $data['barang']       = $this->Model_laporanlogistik->getbarang()->result();
    $this->template->load('template/template', 'laporangudanglogistik/pemasukan.php', $data);
  }

  function cetak_pemasukan()
  {

    $dari                   = $this->input->post('dari');
    $sampai                 = $this->input->post('sampai');
    $kode_kategori          = $this->input->post('kode_kategori');
    $kode_barang            = $this->input->post('kode_barang');
    $data['dari']           = $dari;
    $data['sampai']         = $sampai;
    $data['data']           = $this->Model_laporanlogistik->list_detailPemasukan($dari, $sampai, $kode_kategori, $kode_barang)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Pemasukan Gudang Logistik.xls");
    }
    $this->load->view('laporangudanglogistik/cetak_pemasukan', $data);
  }

  function pengeluaran()
  {

    $data['dept']         = $this->Model_laporanlogistik->getDepartemen()->result();
    $data['kategori']     = $this->Model_laporanlogistik->getKategori()->result();
    $data['barang']       = $this->Model_laporanlogistik->getbarang()->result();
    $data['cabang']       = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'laporangudanglogistik/pengeluaran.php', $data);
  }

  function cetak_pengeluaran()
  {

    $dari                     = $this->input->post('dari');
    $sampai                   = $this->input->post('sampai');
    $kode_kategori            = $this->input->post('kode_kategori');
    $kode_dept                = $this->input->post('kode_dept');
    $kode_barang              = $this->input->post('kode_barang');
    $kode_cabang              = $this->input->post('cbg');
    $data['dari']             = $dari;
    $data['sampai']           = $sampai;
    $data['data']             = $this->Model_laporanlogistik->list_detailPengeluaran($dari, $sampai, $kode_dept, $kode_kategori, $kode_barang, $kode_cabang)->result();
    $data['dept']             = $this->Model_laporanlogistik->getDepartemen()->result();
    $data['kategori']         = $this->Model_laporanlogistik->getKategori()->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Pengeluaran Gudang Logistik.xls");
    }
    $this->load->view('laporangudanglogistik/cetak_pengeluaran', $data);
  }
}
