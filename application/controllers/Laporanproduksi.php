<?php

class Laporanproduksi extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_cabang', 'Model_laporanproduksi'));
  }



  function mutasi()
  {

    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['produk'] = $this->Model_laporanproduksi->listproduk()->result();
    $this->template->load('template/template', 'Laporanproduksi/mutasi.php', $data);
  }


  function rekapmutasi()
  {

    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'Laporanproduksi/rekapmutasi.php', $data);
  }


  function cetak_mutasi()
  {

    $produk             = $this->input->post('produk');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');
    $data['dari']        = $dari;
    $data['sampai']      = $sampai;

    $data['produk']      = $this->Model_laporanproduksi->get_produk($produk)->row_array();
    $data['mutasi']      = $this->Model_laporanproduksi->mutasi($dari, $sampai, $produk)->result();
    $ceksaldo            = $this->Model_laporanproduksi->getSaldoAwalMutasi($dari, $sampai, $produk)->row_array();
    $data['saldoawal']  = $ceksaldo['saldo_awal'];
    if (isset($_POST['export'])) {
      header("Content-type: application/vnd-ms-excel");

      header("Content-Disposition: attachment; filename=Rekap Mutasi Produksi.xls");
    }
    $this->load->view('Laporanproduksi/cetak_mutasi', $data);
  }

  function cetak_rekapmutasi()
  {

    $dari         = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    $data['dari']    = $dari;
    $data['sampai']    = $sampai;
    $data['mutasi']    = $this->Model_laporanproduksi->rekapmutasi($dari, $sampai)->result();
    if (isset($_POST['export'])) {
      header("Content-type: application/vnd-ms-excel");

      header("Content-Disposition: attachment; filename=Rekap Hasil Produksi.xls");
    }
    $this->load->view('Laporanproduksi/cetak_rekapmutasi', $data);
  }


  function persediaan()
  {

    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['kategori']  = $this->Model_laporanproduksi->getKategori()->result();
    $this->template->load('template/template', 'Laporanproduksi/persediaan.php', $data);
  }

  function cetak_persediaan()
  {

    $bulan              = $this->input->post('bulan');
    $tahun              = $this->input->post('tahun');
    $kode_kategori      = $this->input->post('kode_kategori');
    $data['tahun']      = $tahun;
    $data['bulan']      = $bulan;
    $data['kategori']   = $kode_kategori;
    $data['data']       = $this->Model_laporanproduksi->list_detailPersediaan($bulan, $tahun, $kode_kategori)->result();
    if (isset($_POST['export'])) {
      header("Content-type: application/vnd-ms-excel");

      header("Content-Disposition: attachment; filename=Laporan Persediaan Barang Gudang bahan.xls");
    }
    $this->load->view('Laporanproduksi/cetak_persediaan', $data);
  }

  function pemasukan()
  {

    $data['kategori']     = $this->Model_laporanproduksi->getKategori()->result();
    $data['barang']         = $this->Model_laporanproduksi->getbarang()->result();
    $this->template->load('template/template', 'Laporanproduksi/pemasukan.php', $data);
  }

  function cetak_pemasukan()
  {

    $dari                   = $this->input->post('dari');
    $sampai                 = $this->input->post('sampai');
    $kode_barang            = $this->input->post('kode_barang');
    $data['dari']           = $dari;
    $data['sampai']         = $sampai;
    $data['data']           = $this->Model_laporanproduksi->list_detailPemasukan($dari, $sampai, $kode_barang)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Pemasukan Gudang Bahan.xls");
    }
    $this->load->view('Laporanproduksi/cetak_pemasukan', $data);
  }

  function pengeluaran()
  {

    $data['dept']         = $this->Model_laporanproduksi->getDepartemen()->result();
    $data['kategori']     = $this->Model_laporanproduksi->getKategori()->result();
    $data['barang']         = $this->Model_laporanproduksi->getbarang()->result();
    $this->template->load('template/template', 'Laporanproduksi/pengeluaran.php', $data);
  }

  function cetak_pengeluaran()
  {

    $dari                     = $this->input->post('dari');
    $sampai                   = $this->input->post('sampai');
    $kode_dept                = $this->input->post('kode_dept');
    $kode_barang              = $this->input->post('kode_barang');
    $data['dari']             = $dari;
    $data['sampai']           = $sampai;
    $data['data']             = $this->Model_laporanproduksi->list_detailPengeluaran($dari, $sampai, $kode_dept, $kode_barang)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Pengeluaran Gudang bahan.xls");
    }
    $this->load->view('Laporanproduksi/cetak_pengeluaran', $data);
  }
}
