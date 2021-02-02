<?php 

class Laporangudangbahan extends CI_Controller{

  function __construct(){
    parent::__construct();
    check_login();
    $this->load->model(array('Model_laporanbahan')); 
  }

  function persediaan(){

    $data['tahun']     = date("Y");
    $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['kategori']  = $this->Model_laporanbahan->getKategori()->result();
    $this->template->load('template/template','laporangudangbahan/persediaan.php',$data);
  }

  function rekapgudangbahan(){

    $data['tahun']     = date("Y");
    $kode_barang       = $this->input->post('kode_barang');
    $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['kategori']  = $this->Model_laporanbahan->getKategori()->result();
    $data['barang']    = $this->Model_laporanbahan->getbarang($kode_barang)->result();
    $this->template->load('template/template', 'laporangudangbahan/rekap_gudangbahan.php',$data);
  }

  function cetak_persediaan(){

    $bulan              = $this->input->post('bulan');
    $tahun              = $this->input->post('tahun');
    $kode_kategori      = $this->input->post('kode_kategori');
    $data['tahun']      = $tahun;
    $data['bulan']      = $bulan;
    $data['kategori']   = $kode_kategori;
    $data['data']       = $this->Model_laporanbahan->list_detailPersediaan($bulan,$tahun,$kode_kategori)->result();
    if(isset($_POST['export'])){
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Persediaan Barang Gudang Bahan & Kemasan.xls");
    }
    $this->load->view('laporangudangbahan/cetak_persediaan',$data);
  }

  function cetak_rekapgudangbahan(){

    $kode_kategori        = $this->input->post('kode_kategori');
    $kode_barang          = $this->input->post('kode_barang');
    $bulan                = $this->input->post('bulan');
    $tahun                = $this->input->post('tahun');
    $data['bulan']        = $bulan;
    $data['tahun']        = $tahun;
    $data['kategori']     = $kode_kategori;
    $data['kode_barang']  = $kode_barang;
    $dari                 = $tahun . "-" . $bulan . "-" . "01";
    $ceknextbulan         = $this->Model_laporanbahan->cekNextBulan($bulan, $tahun)->row_array();
    $data['saldoawal']    = $this->Model_laporanbahan->saldoAwal($bulan, $tahun, $kode_barang)->row_array();
    $data['barang']       = $this->Model_laporanbahan->getbarang($kode_barang)->row_array();
    $data['dari']         = $dari;
    $tglnextbulan         = $ceknextbulan['tgl_pengeluaran'];
    if (empty($tglnextbulan)) {
      $data['sampai']     = date("Y-m-t", strtotime($dari));
    } else {
      $data['sampai']     = $ceknextbulan['tgl_pengeluaran'];
    }

    $data['tglakhirpenerimaan'] = $tahun . "-" . $bulan . "-31";
    
    if(isset($_POST['export'])){
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Kartu Gudang Bahan & Kemasan.xls");
    }
    $this->load->view('laporangudangbahan/cetak_rekap_gudangbahan',$data);
  }

  function cetak_retur(){

    $bulan              = $this->input->post('bulan');
    $tahun              = $this->input->post('tahun');
    $kode_kategori      = $this->input->post('kode_kategori');
    $data['tahun']      = $tahun;
    $data['bulan']      = $bulan;
    $data['kategori']   = $kode_kategori;
    $data['data']       = $this->Model_laporanbahan->list_Retur($bulan,$tahun,$kode_kategori)->result();
    if(isset($_POST['export'])){
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Retur Barang Gudang Bahan & Kemasan.xls");
    }
    $this->load->view('laporangudangbahan/cetak_retur',$data);
  }

  function pemasukan(){

    $data['kategori']       = $this->Model_laporanbahan->getKategori()->result();
    $kode_barang       = $this->input->post('kode_barang');
    $data['barang']    = $this->Model_laporanbahan->getbarang($kode_barang)->result();

    $this->template->load('template/template','laporangudangbahan/pemasukan.php',$data);
  }

  function detail_retur(){

    $data['kategori']       = $this->Model_laporanbahan->getKategori()->result();
    $kode_barang       = $this->input->post('kode_barang');
    $data['barang']    = $this->Model_laporanbahan->getbarang($kode_barang)->result();
    $this->template->load('template/template','laporangudangbahan/detail_retur.php',$data);
  }


  function retur(){
    
    $data['tahun']     = date("Y");
    $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $kode_barang       = $this->input->post('kode_barang');
    $data['barang']    = $this->Model_laporanbahan->getbarang($kode_barang)->result();
    $this->template->load('template/template','laporangudangbahan/retur.php',$data);
  }

  function cetak_detail_retur(){

    $dari                   = $this->input->post('dari');
    $sampai                 = $this->input->post('sampai');
    $jenis_retur            = $this->input->post('jenis_retur');
    $supplier               = $this->input->post('supplier');
    $data['dari']           = $dari;
    $data['sampai']         = $sampai;
    $data['data']           = $this->Model_laporanbahan->list_detailRetur($dari,$sampai,$jenis_retur,$supplier)->result();
    if(isset($_POST['export'])){
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Detail Retur Gudang Bahan & Kemasan.xls");
    }
    $this->load->view('laporangudangbahan/cetak_detail_retur',$data);
  }

  function cetak_pemasukan(){

    $dari                   = $this->input->post('dari');
    $sampai                 = $this->input->post('sampai');
    $kode_barang            = $this->input->post('kode_barang');
    $data['dari']           = $dari;
    $data['sampai']         = $sampai;
    $data['data']           = $this->Model_laporanbahan->list_detailPemasukan($dari,$sampai,$kode_barang)->result();
    if(isset($_POST['export'])){
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Pemasukan Gudang Bahan & Kemasan.xls");
    }
    $this->load->view('laporangudangbahan/cetak_pemasukan',$data);
  }

  function pengeluaran(){

    $data['dept']         = $this->Model_laporanbahan->getDepartemen()->result();
    $data['kategori']     = $this->Model_laporanbahan->getKategori()->result();
    $kode_barang       = $this->input->post('kode_barang');
    $data['barang']    = $this->Model_laporanbahan->getbarang($kode_barang)->result();
    $this->template->load('template/template','laporangudangbahan/pengeluaran.php',$data);
  }

  function cetak_pengeluaran(){

    $dari                     = $this->input->post('dari');
    $sampai                   = $this->input->post('sampai');
    $kode_dept                = $this->input->post('kode_dept');
    $unit                     = $this->input->post('unit');
    $kode_barang              = $this->input->post('kode_barang');
    $data['dari']             = $dari;
    $data['sampai']           = $sampai;
    $data['data']             = $this->Model_laporanbahan->list_detailPengeluaran($dari,$sampai,$kode_dept,$kode_barang,$unit)->result();
    if(isset($_POST['export'])){
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Pengeluaran Gudang Bahan & Kemasan.xls");
    }
    $this->load->view('laporangudangbahan/cetak_pengeluaran',$data);
  }
}