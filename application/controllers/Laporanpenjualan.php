<?php

class Laporanpenjualan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_cabang', 'Model_laporanpenjualan', 'Model_sales', 'Model_cabang', 'Model_pelanggan', 'Model_pembayaran'));
  }

  function penjualan()
  {
    $data['lvl']    = $this->session->userdata('level_user');
    $data['cb']     = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/penjualan.php', $data);
  }

  function retur_khusus()
  {
    $data['lvl']    = $this->session->userdata('level_user');
    $data['cb']     = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/retur_khusus.php', $data);
  }

  function penjualanpending()
  {
    if ($this->session->userdata('cabang') == 'pusat') {
      $data['lvl']    = $this->session->userdata('level_user');
      $data['cb']     = $this->session->userdata('cabang');
      $data['cabang'] = $this->Model_cabang->view_cabang()->result();
      $this->template->load('template/template', 'penjualan/laporan/penjualanpending.php', $data);
    } else {
      redirect('dashboard');
    }
  }


  function kasbesar()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/kasbesar.php', $data);
  }

  function kartupiutang()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/kartupiutang.php', $data);
  }


  function aup()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/aup.php', $data);
  }

  function tunaikredit()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/tunaikredit.php', $data);
  }

  function lebihsatufaktur()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/lebihsatufaktur.php', $data);
  }

  function lapproduk()
  {

    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/produk.php', $data);
  }


  function rekappenjualan()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/rekappenjualan.php', $data);
  }

  function rekapproduk()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/produk.php', $data);
  }


  function get_salesman()
  {
    $cabang = $this->input->post('cabang');
    $sales   = $this->Model_laporanpenjualan->get_salesman($cabang)->result();
    $idsales = $this->session->userdata('salesman');
    echo "<option value='' selected>Semua Salesman</option>";
    foreach ($sales as $s) {
      if ($idsales == $s->id_karyawan && !empty($idsales)) {

        $select = "selected";
      } else {
        $select = "";
      }
      echo "<option $select  value='$s->id_karyawan'>$s->nama_karyawan</option>";
    }
  }

  function get_kendaraan()
  {
    $cabang = $this->input->post('cabang');
    $kendaraaan   = $this->Model_laporanpenjualan->get_kendaraan($cabang)->result();
    echo "<option value='' selected>Semua Kendaraan</option>";
    foreach ($kendaraaan as $s) {
      echo "<option value='$s->no_polisi'>$s->no_polisi || $s->type</option>";
    }
  }

  function get_salesman2()
  {
    $cabang = $this->input->post('cabang');
    $sales   = $this->Model_laporanpenjualan->get_salesman($cabang)->result();
    $idsales = $this->session->userdata('salesman');
    echo "<option value=''>Pilih Salesman</option>";
    foreach ($sales as $s) {

      echo "<option   value='$s->id_karyawan'>$s->nama_karyawan</option>";
    }
  }


  function get_pelanggan()
  {
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->Model_laporanpenjualan->get_pelanggan($salesman)->result();
    echo "<option value=''>Semua Pelanggan</option>";
    foreach ($pelanggan as $p) {

      echo "<option value='$p->kode_pelanggan'>$p->kode_pelanggan" . " - " . "$p->nama_pelanggan</option>";
    }
  }

  function get_pelanggancabang()
  {
    $cabang       = $this->input->post('cabang');
    $pelanggan      = $this->Model_laporanpenjualan->get_pelanggancabang($cabang)->result();
    echo "<option value=''>Semua Pelanggan</option>";
    foreach ($pelanggan as $p) {

      echo "<option value='$p->kode_pelanggan'>$p->kode_pelanggan" . " - " . "$p->nama_pelanggan</option>";
    }
  }


  function lapdppp()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/dppp', $data);
  }

  function cetak_lappenjualan()
  {

    $cabang         = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari           = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    $jt              = $this->input->post('jenistransaksi');
    $jl             = $this->input->post('jenislaporan');
    $data['dari']    = $dari;
    $data['sampai']  = $sampai;
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Penjualan.xls");
    }
    if (!empty($cabang)) {
      $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
      $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();
      //print_r($data['cabang']);
      //die;
      $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
      if ($jl == "rekap") {
        $data['penjualan']  = $this->Model_laporanpenjualan->list_penjualanpelanggan($dari, $sampai, $cabang, $salesman, $pelanggan, $jt)->result();
        $this->load->view('penjualan/laporan/cetak_penjualanpelanggan', $data);
      } else {
        $data['penjualan']  = $this->Model_laporanpenjualan->list_penjualan($dari, $sampai, $cabang, $salesman, $pelanggan, $jt)->result();
        $this->load->view('penjualan/laporan/cetak_penjualan', $data);
      }
    } else {
      $data['rekappenjualancabang'] = $this->Model_laporanpenjualan->rekappenjualancabang($dari, $sampai, $jt)->result();
      $this->load->view('penjualan/laporan/cetak_rekappenjualancabang', $data);
    }
  }

  function loadrekappenjualan()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $data['rekappenjualancabang'] = $this->Model_laporanpenjualan->loadrekappenjualan($bulan, $tahun)->result();
    $this->load->view('penjualan/laporan/loadrekappenjualan', $data);
  }

  function cetak_lappenjualanpending()
  {

    $cabang         = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari           = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    $jt             = $this->input->post('jenistransaksi');
    $jl             = $this->input->post('jenislaporan');
    $status         = $this->input->post('status');
    $data['dari']   = $dari;
    $data['status'] = $status;
    $data['sampai'] = $sampai;
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Penjualan.xls");
    }
    if (!empty($cabang)) {
      $data['salesman'] = $this->Model_sales->get_sales($salesman)->row_array();
      $data['cb']     = $this->Model_cabang->get_cabang($cabang)->row_array();
      //print_r($data['cabang']);
      //die;
      $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
      if ($jl == "rekap") {
        $data['penjualan']  = $this->Model_laporanpenjualan->list_penjualanpelangganpending($dari, $sampai, $cabang, $salesman, $pelanggan, $jt, $status)->result();
        $this->load->view('penjualan/laporan/cetak_penjualanpelangganpending', $data);
      } else {
        $data['penjualan']  = $this->Model_laporanpenjualan->list_penjualanpending($dari, $sampai, $cabang, $salesman, $pelanggan, $jt, $status)->result();
        $this->load->view('penjualan/laporan/cetak_penjualanpending', $data);
      }
    } else {
      $data['rekappenjualancabang'] = $this->Model_laporanpenjualan->rekappenjualancabangpending($dari, $sampai, $jt, $status)->result();
      $this->load->view('penjualan/laporan/cetak_rekappenjualancabangpending', $data);
    }
  }

  function cetak_retur_khusus()
  {
    $cabang       = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari         = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']    = $dari;
    $data['sampai']    = $sampai;
    $data['retur']    = $this->Model_laporanpenjualan->list_retur_khusus($dari, $sampai, $cabang, $salesman, $pelanggan)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Retur Penjualan.xls");
    }
    $this->load->view('penjualan/laporan/cetak_retur_khusus', $data);
  }

  function cetak_retur()
  {
    $cabang       = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari         = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']    = $dari;
    $data['sampai']    = $sampai;
    $data['retur']    = $this->Model_laporanpenjualan->list_retur($dari, $sampai, $cabang, $salesman, $pelanggan)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Retur Penjualan.xls");
    }
    $this->load->view('penjualan/laporan/cetak_retur', $data);
  }


  function cetak_kasbesar()
  {
    $cabang         = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari           = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    $jenisbayar     = $this->input->post('jenisbayar');
    $jenislaporan    = $this->input->post('jenislaporan');
    $data['dari']    = $dari;
    $data['sampai']  = $sampai;


    //print_r($data['cabang']);
    //die;
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");
      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan KAS BESAR.xls");
    }
    if (!empty($cabang)) {
      if (empty($salesman) and empty($pelanggan)) {
        // echo $jenislaporan;
        // die;
        if ($jenislaporan == "rekap") {
          $data['cabang'] = $cabang;
          $data['rekapkasbesarsales'] = $this->Model_laporanpenjualan->rekapkasbesarsales($dari, $sampai, $jenisbayar, $cabang)->result();
          $this->load->view('penjualan/laporan/cetak_rekapkasbesarsales', $data);
        } else {
          $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
          $data['salesman']    = $this->Model_sales->get_sales($salesman)->row_array();
          $data['cb']          = $this->Model_cabang->get_cabang($cabang)->row_array();
          $data['kasbesar']    = $this->Model_laporanpenjualan->kasbesar($dari, $sampai, $cabang, $salesman, $pelanggan, $jenisbayar)->result();
          $statusbayar         = "voucher";
          $data['sb']          = $this->Model_laporanpenjualan->voucher($dari, $sampai, $cabang, $salesman, $pelanggan, $statusbayar)->result();
          $this->load->view('penjualan/laporan/cetak_kasbesar', $data);
        }
      } else {
        $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
        $data['salesman']    = $this->Model_sales->get_sales($salesman)->row_array();
        $data['cb']          = $this->Model_cabang->get_cabang($cabang)->row_array();
        $data['kasbesar']    = $this->Model_laporanpenjualan->kasbesar($dari, $sampai, $cabang, $salesman, $pelanggan, $jenisbayar)->result();
        $statusbayar         = "voucher";
        $data['sb']          = $this->Model_laporanpenjualan->voucher($dari, $sampai, $cabang, $salesman, $pelanggan, $statusbayar)->result();
        $this->load->view('penjualan/laporan/cetak_kasbesar', $data);
      }
    } else {
      if ($jenislaporan == "rekap") {
        $data['rekapkasbesarcabang'] = $this->Model_laporanpenjualan->rekapkasbesarcabang($dari, $sampai, $jenisbayar)->result();
        $this->load->view('penjualan/laporan/cetak_rekapkasbesarcabang', $data);
      } else {
        $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
        $data['salesman']    = $this->Model_sales->get_sales($salesman)->row_array();
        $data['cb']          = $this->Model_cabang->get_cabang($cabang)->row_array();
        $data['kasbesar']    = $this->Model_laporanpenjualan->kasbesar($dari, $sampai, $cabang, $salesman, $pelanggan, $jenisbayar)->result();
        $statusbayar         = "voucher";
        $data['sb']          = $this->Model_laporanpenjualan->voucher($dari, $sampai, $cabang, $salesman, $pelanggan, $statusbayar)->result();
        $this->load->view('penjualan/laporan/cetak_kasbesar', $data);
      }
    }
  }


  function loadrekapkasbesar()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $data['rekapkasbesarcabang'] = $this->Model_laporanpenjualan->loadrekapkasbesar($bulan, $tahun)->result();
    $this->load->view('penjualan/laporan/loadrekapkasbesar', $data);
  }


  function cekkasbesar()
  {
    $cabang         = $this->uri->segment(3);
    $salesman       = $this->uri->segment(5);
    $tanggallhp     = $this->uri->segment(4);


    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;

    $data['tanggallhp']     = $tanggallhp;
    $data['kasbesar']        = $this->Model_laporanpenjualan->cekkasbesar($tanggallhp, $cabang, $salesman)->result();
    $data['listgiro']       = $this->Model_laporanpenjualan->listgiro($tanggallhp, $cabang, $salesman)->result();
    $data['listtransfer']   = $this->Model_laporanpenjualan->listtransfer($tanggallhp, $cabang, $salesman)->result();
    $this->load->view('penjualan/laporan/cetak_cekkasbesar', $data);
  }


  function cetak_kartupiutang()
  {

    $cabang       = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari         = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']    = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']      = $dari;
    $data['sampai']      = $sampai;
    $data['kartupiutang']  = $this->Model_laporanpenjualan->kartupiutang($cabang, $salesman, $pelanggan, $dari, $sampai)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Kartu Piutang.xls");
    }
    $this->load->view('penjualan/laporan/cetak_kartupiutang', $data);




    // $a = $this->db->get('view_pembayaran');

    // foreach ( $a->result() as $b){

    // 	echo $b->kode_pelanggan."<br>";
    // }


  }




  function cetak_aup()
  {
    $cabang       = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $tanggal       = $this->input->post('tanggal');
    //$sampai     		= $this->input->post('sampai');


    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['tanggal']  = $tanggal;
    //$data['sampai']		= $sampai;
    $data['aup']      = $this->Model_laporanpenjualan->aup($cabang, $salesman, $pelanggan, $tanggal)->result();



    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan ANALISA UMUR PIUTANG.xls");
    }
    $this->load->view('penjualan/laporan/cetak_aup', $data);
  }

  function cetak_detailaup()
  {


    $cabang           = $this->uri->segment(3);
    $salesman         = $this->uri->segment(4);
    $pelanggan         = $this->uri->segment(5);
    $tanggal           = $this->uri->segment(6);
    $lama             = $this->uri->segment(7);

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['tanggal']    = $tanggal;
    $data['lama']        = $lama;
    $data['detail_aup'] = $this->Model_laporanpenjualan->detailaup($cabang, $salesman, $pelanggan, $tanggal, $lama)->result();
    $this->load->view('penjualan/laporan/cetak_detailaup', $data);
  }

  function cetak_tunaikredit()
  {

    $cabang           = $this->input->post('cabang');
    $salesman         = $this->input->post('salesman');
    $pelanggan        = $this->input->post('pelanggan');
    $dari             = $this->input->post('dari');
    $sampai           = $this->input->post('sampai');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']    = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']      = $dari;
    $data['sampai']      = $sampai;
    $data['sales']      = $salesman;
    $data['cabang']      = $cabang;
    $data['tunaikredit']  = $this->Model_laporanpenjualan->tunaikredit($cabang, $salesman, $dari, $sampai)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Tunai Kredit.xls");
    }
    $this->load->view('penjualan/laporan/cetak_tunaikredit', $data);
  }


  function cetak_lebihsatufaktur()
  {

    $cabang         = $this->input->post('cabang');
    $salesman         = $this->input->post('salesman');
    $pelanggan        = $this->input->post('pelanggan');
    $tanggal         = $this->input->post('tanggal');
    //$sampai     			= $this->input->post('sampai');
    $data['salesman']    = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']      = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['tanggal']      = $tanggal;
    //$data['sampai']			= $sampai;
    $data['sales']        = $salesman;
    $data['lebihsatufaktur']  = $this->Model_laporanpenjualan->lebihsatufaktur($cabang, $salesman, $tanggal)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Tunai Kredit.xls");
    }
    $this->load->view('penjualan/laporan/cetak_lebihsatufaktur', $data);
  }


  function cetak_lapproduk()
  {
    $cabang           = $this->input->post('cabang');
    $dari             = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');
    $data['cb']          = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['dari']        = $dari;
    $data['sampai']        = $sampai;
    $data['penjualan']      = $this->Model_laporanpenjualan->lapsales($dari, $sampai, $cabang)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Per Produk.xls");
    }
    $this->load->view('penjualan/laporan/cetak_lapproduk', $data);
  }


  function cetak_rekappenjualan()
  {

    $cabang         = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari           = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    $jenislaporan   = $this->input->post('jenislaporan');
    //$jt					= $this->input->post('jenistransaksi');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    //$data['pelanggan'] = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']     = $dari;
    $data['sampai']   = $sampai;


    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan REPO.xls");
    }

    if ($jenislaporan == 1) {
      $data['rekap']     = $this->Model_laporanpenjualan->rekapproduk($dari, $sampai, $cabang, $salesman)->result();
      $this->load->view('penjualan/laporan/cetak_rekapproduk', $data);
    } else if ($jenislaporan == 2) {
      $data['rekap']     = $this->Model_laporanpenjualan->rekappenjualan($dari, $sampai, $cabang, $salesman)->result();
      $this->load->view('penjualan/laporan/cetak_rekappenjualan', $data);
    } else if ($jenislaporan == 3) {
      $data['rekap']     = $this->Model_laporanpenjualan->rekappenjualanqty($dari, $sampai)->result();
      $this->load->view('penjualan/laporan/cetak_rekappenjualanqty', $data);
    } else if ($jenislaporan == 4) {
      $data['rekap']     = $this->Model_laporanpenjualan->rekapretur($dari, $sampai, $cabang, $salesman)->result();
      $this->load->view('penjualan/laporan/cetak_rekapretur', $data);
    } else if ($jenislaporan == 5) {
      $data['tanggal']    = $dari;
      $data['aup']     = $this->Model_laporanpenjualan->rekapaup($cabang, $salesman, $pelanggan, $dari)->result();
      $this->load->view('penjualan/laporan/cetak_rekapaup', $data);
    }
  }


  function rekappelanggan()
  {

    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/pelanggan.php', $data);
  }

  function cetak_rekappelanggan()
  {

    $cabang       = $this->input->post('cabang');
    $salesman     = $this->input->post('salesman');
    $pelanggan    = $this->input->post('pelanggan');
    $dari         = $this->input->post('dari');
    $sampai       = $this->input->post('sampai');
    //$jt					= $this->input->post('jenistransaksi');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    //$data['cb']		= $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    //$data['pelanggan'] = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']       = $dari;
    $data['sampai']     = $sampai;
    $data['rekap']     = $this->Model_laporanpenjualan->rekappelanggan($dari, $sampai, $cabang, $salesman, $pelanggan)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan REPO.xls");
    }
    $this->load->view('penjualan/laporan/cetak_rekappelanggan', $data);
  }



  function cetak_rekapproduk()
  {

    $cabang       = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    //$pelanggan  		= $this->input->post('pelanggan');
    $dari         = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    //$jt					= $this->input->post('jenistransaksi');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']    = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    //$data['pelanggan'] = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']     = $dari;
    $data['sampai']     = $sampai;
    $data['rekap']     = $this->Model_laporanpenjualan->rekapproduk($dari, $sampai, $cabang, $salesman)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Rekap Penjualan Produk.xls");
    }
    $this->load->view('penjualan/laporan/cetak_rekapproduk', $data);
  }

  function cetak_dppp()
  {

    $cabang             = $this->input->post('cabang');
    $bulan               = $this->input->post('bulan');
    $tahun               = $this->input->post('tahun');
    $tahunlalu             = $tahun - 1;

    $data['bulan']          = $bulan;
    $data['tahun']          = $tahun;
    $data['tahunlalu']        = $tahun;


    $data['cb']              = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['dppp']          = $this->Model_laporanpenjualan->dppp($cabang, $tahun, $bulan)->result();




    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan ANALISA UMUR PIUTANG.xls");
    }
    $this->load->view('penjualan/laporan/cetak_dppp', $data);
  }

  function cetak_setoranpenjualan()
  {

    $cabang           = $this->uri->segment(3);
    $salesman         = $this->uri->segment(4);
    $dari             = $this->uri->segment(5);
    $sampai           = $this->uri->segment(6);
    $cek               = $this->uri->segment(7);

    $data['dari']      = $dari;
    $data['sampai']    = $sampai;
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['setoran']   = $this->Model_laporanpenjualan->setoranpenjualan($cabang, $salesman, $dari, $sampai)->result();

    if ($cek == "download") {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Setoran Penjualan.xls");
    }
    $this->load->view('penjualan/laporan/cetak_setoranpenjualan', $data);
  }

  function cetak_setoranpusat()
  {

    $cabang           = $this->uri->segment(3);
    $bank             = $this->uri->segment(4);
    $dari             = $this->uri->segment(5);
    $sampai           = $this->uri->segment(6);
    $cek               = $this->uri->segment(7);

    $data['dari']      = $dari;
    $data['sampai']    = $sampai;
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['setoran']  = $this->Model_laporanpenjualan->setoranpusat($cabang, $bank, $dari, $sampai)->result();
    $data['rekap']    = $this->Model_laporanpenjualan->rekapbanksetoranpusat($cabang, $bank, $dari, $sampai)->result();
    if ($cek == "download") {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Setoran Penjualan.xls");
    }
    $this->load->view('penjualan/laporan/cetak_setoranpusat', $data);
  }

  function uanglogam()
  {
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/uang_logam', $data);
  }


  function cetak_uanglogam()
  {
    $cabang         = $this->input->post('cabang');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $data['bulan']    = $bulan;
    $data['tahun']    = $tahun;
    $dari             = $tahun . "-" . $bulan . "-" . "01";
    $akhir             = $tahun . "-" . $bulan . "-" . "31";
    $ceknextbulan     = $this->Model_laporanpenjualan->cekNextBulan($cabang, $bulan, $tahun)->row_array();
    $data['dari']     = $dari;
    $tglnextbulan     = $ceknextbulan['tgl_diterimapusat'];
    if (empty($tglnextbulan)) {
      $data['sampai'] = date("Y-m-t", strtotime($dari));
    } else {
      $data['sampai'] = $ceknextbulan['tgl_diterimapusat'];
    }

    $data['akhirlhp'] = $akhir;
    $saldo = $this->Model_laporanpenjualan->getSaldoAwalKasBesar($cabang, $dari)->row_array();
    $saldologam = $saldo['uang_logam'];
    $saldoawal = $saldologam;
    $data['saldoawal'] = $saldoawal;
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();
    //$data['logam']	= $this->Model_laporanpenjualan->posisilogam($cabang,$dari,$sampai)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=LOGAM.xls");
    }
    $this->load->view('penjualan/laporan/cetak_uanglogam', $data);
  }

  function saldokasbesar()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/saldokasbesar', $data);
  }

  function diskon()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/diskon', $data);
  }


  function cetak_diskon()
  {
    $cabang             = $this->input->post('cabang');
    $dari               = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');
    $data['dari']       = $dari;
    $data['sampai']     = $sampai;
    $data['cb']         = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['diskon']     = $this->Model_laporanpenjualan->listdiskon($cabang, $dari, $sampai)->result();
    //$data['logam']			= $this->Model_laporanpenjualan->posisilogam($cabang,$dari,$sampai)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Diskon.xls");
    }
    $this->load->view('penjualan/laporan/cetak_diskon', $data);
  }

  function cetak_saldokasbesar()
  {
    $cabang           = $this->input->post('cabang');
    $bulan            = $this->input->post('bulan');
    $tahun            = $this->input->post('tahun');
    $data['bulan']    = $bulan;
    $data['tahun']    = $tahun;
    $dari             = $tahun . "-" . $bulan . "-" . "01";
    $ceknextbulan     = $this->Model_laporanpenjualan->cekNextBulan($cabang, $bulan, $tahun)->row_array();
    $data['dari']     = $dari;
    $tglnextbulan     = $ceknextbulan['tgl_diterimapusat'];
    if (empty($tglnextbulan)) {
      $data['sampai'] = date("Y-m-t", strtotime($dari));
    } else {
      $data['sampai'] = $ceknextbulan['tgl_diterimapusat'];
    }

    $data['tglakhirpenerimaan'] = $tahun . "-" . $bulan . "-31";
    //echo $data['tglakhirpenerimaan'];
    //die;
    $saldo                  = $this->Model_laporanpenjualan->getSaldoAwalKasBesar($cabang, $dari)->row_array();


    $saldokertas            = $saldo['uang_kertas'];
    $saldologam             = $saldo['uang_logam'];
    $saldogiro              = $saldo['giro'];
    $saldotransfer          = $saldo['transfer'];

    $data['kertas']         = $saldokertas;
    $data['logam']          = $saldologam;
    $data['giro']           = $saldogiro;
    $data['transfer']       = $saldotransfer;
    $data['sa']             = $saldokertas + $saldologam + $saldogiro + $saldotransfer;
    $data['cb']             = $this->Model_cabang->get_cabang($cabang)->row_array();
    //$data['logam']	= $this->Model_laporanpenjualan->posisilogam($cabang,$dari,$sampai)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");
      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=SALDO KAS BESAR.xls");
    }
    $this->load->view('penjualan/laporan/cetak_saldokasbesar', $data);
  }

  function penjualankasbesar()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/penjualankasbesar.php', $data);
  }


  function cetak_penjualankasbesar()
  {
    $cabang           = $this->input->post('cabang');
    $dari             = $this->input->post('dari');
    $sampai             = $this->input->post('sampai');
    $salesman           = $this->input->post('salesman');
    $data['dari']        = $dari;
    $data['sampai']        = $sampai;
    $data['cb']          = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['salesman']      = $this->Model_sales->get_sales($salesman)->row_array();
    $data['setoran']      = $this->Model_laporanpenjualan->setoran_penjualan($cabang, $salesman, $dari, $sampai)->result();
    //$data['logam']			= $this->Model_laporanpenjualan->posisilogam($cabang,$dari,$sampai)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=SALDO KAS BESAR.xls");
    }
    $this->load->view('penjualan/laporan/cetak_penjualankasbesar', $data);
  }

  function lpu()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/lpu', $data);
  }


  function cetak_lpu()
  {
    $cabang           = $this->input->post('cabang');
    $bulan             = $this->input->post('bulan');
    $tahun             = $this->input->post('tahun');
    // $data['dari']			= $dari;
    // $data['sampai']		= $sampai;
    $dari             = $tahun . "-" . $bulan . "-" . "01";
    $ceknextbulan     = $this->Model_laporanpenjualan->cekNextBulan($cabang, $bulan, $tahun)->row_array();
    $cekbeforebulan   = $this->Model_laporanpenjualan->cekBeforeBulan($cabang, $bulan, $tahun)->row_array();
    $data['dari']     = $dari;
    $tglnextbulan     = $ceknextbulan['tgl_diterimapusat'];
    $tglbeforebulan   = $cekbeforebulan['tgl_diterimapusat'];
    if (empty($tglnextbulan)) {
      $data['sampai'] = date("Y-m-t", strtotime($dari));
    } else {
      $data['sampai'] = $ceknextbulan['tgl_diterimapusat'];
    }

    if (empty($tglbeforebulan)) {
      $data['fromlast'] = $dari;
    } else {
      $data['fromlast'] = $cekbeforebulan['tgl_diterimapusat'];
    }
    $salesman          = $this->Model_laporanpenjualan->get_salesman($cabang);
    $listbank         = $this->Model_laporanpenjualan->get_listbank($cbg = "PST");
    $data['listbank']  = $listbank->result();
    $data['salesman']  = $salesman->result();
    $data['jmlbank']  = $listbank->num_rows();
    $data['jmlsales']  = $salesman->num_rows();
    $data['cb']        = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['cbg']      = $cabang;
    //$data['logam']	= $this->Model_laporanpenjualan->posisilogam($cabang,$dari,$sampai)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=LPU.xls");
    }
    $this->load->view('penjualan/laporan/cetak_lpu', $data);
  }



  function rekapbg()
  {
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['cb']      = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/rekapbg', $data);
  }


  function cetak_rekapbg()
  {
    $cabang         = $this->input->post('cabang');
    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $dari           = $tahun . "-" . $bulan . "-01";
    $sampai         = $tahun . "-" . $bulan . "-31";
    $ceknextbulan     = $this->Model_laporanpenjualan->cekNextBulan($cabang, $bulan, $tahun)->row_array();
    $tglnextbulan     = $ceknextbulan['tgl_diterimapusat'];
    if (empty($tglnextbulan)) {
      $sampaibayar = date("Y-m-t", strtotime($dari));
    } else {
      $sampaibayar = $ceknextbulan['tgl_diterimapusat'];
    }
    $data['dari']    = $dari;
    $data['sampai']  = $sampai;
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['rekapbg'] = $this->Model_laporanpenjualan->rekapbg($cabang, $dari, $sampai, $bulan, $tahun, $sampaibayar)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=REKAP BG.xls");
    }
    $this->load->view('penjualan/laporan/cetak_rekapbg', $data);
  }

  function omset()
  {
    $data['cb']      = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/omset', $data);
  }

  function cetak_omset()
  {
    $cabang         = $this->input->post('cabang');
    $dari           = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    $data['dari']    = $dari;
    $data['sampai']  = $sampai;
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();
    $data['omset']  = $this->Model_laporanpenjualan->omset($cabang, $dari, $sampai)->result();
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=OMSET.xls");
    }
    $this->load->view('penjualan/laporan/cetak_omset', $data);
  }


  function repo()
  {

    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/repo.php', $data);
  }


  function cetak_repo()
  {

    $cabang       = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari         = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    //$data['pelanggan']		= $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']      = $dari;
    $data['sampai']      = $sampai;
    $data['sales']      = $salesman;
    $data['repo']      = $this->Model_laporanpenjualan->repo($dari, $sampai, $cabang, $salesman)->result();

    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan Tunai Kredit.xls");
    }
    $this->load->view('penjualan/laporan/cetak_repo', $data);
  }


  function dpp()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/dpp.php', $data);
  }


  function cetak_dpp()
  {
    $cabang       = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari         = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');

    $data['salesman']  = $this->Model_sales->get_sales($salesman)->row_array();
    $data['cb']      = $this->Model_cabang->get_cabang($cabang)->row_array();

    //print_r($data['cabang']);
    //die;
    $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
    $data['dari']    = $dari;
    $data['sampai']    = $sampai;
    $data['dpp']      = $this->Model_laporanpenjualan->dpp($dari, $sampai, $cabang, $salesman, $pelanggan)->result();


    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");

      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan DPP.xls");
    }
    $this->load->view('penjualan/laporan/cetak_dpp', $data);
  }

  function cetak_kasbesarlhp()
  {
    $cabang         = $this->input->post('cabang');
    $salesman       = $this->input->post('salesman');
    $pelanggan      = $this->input->post('pelanggan');
    $dari           = $this->input->post('dari');
    $sampai         = $this->input->post('sampai');
    //$jenisbayar 		= $this->input->post('jenisbayar');
    $data['dari']    = $dari;
    $data['sampai']  = $sampai;
    $jenisbayar = "";

    //print_r($data['cabang']);
    //die;
    if (isset($_POST['export'])) {
      // Fungsi header dengan mengirimkan raw data excel
      header("Content-type: application/vnd-ms-excel");
      // Mendefinisikan nama file ekspor "hasil-export.xls"
      header("Content-Disposition: attachment; filename=Laporan KAS BESAR.xls");
    }
    if (!empty($cabang)) {
      $data['pelanggan']  = $this->Model_pelanggan->get_pelanggan($pelanggan)->row_array();
      $data['salesman']    = $this->Model_sales->get_sales($salesman)->row_array();
      $data['cb']          = $this->Model_cabang->get_cabang($cabang)->row_array();
      $data['kasbesar']    = $this->Model_laporanpenjualan->kasbesarlhp($dari, $sampai, $cabang, $salesman, $pelanggan)->result();
      $data['listgiro']       = $this->Model_laporanpenjualan->listgirolhp($dari, $sampai, $cabang, $salesman)->result();
      $data['listtransfer']   = $this->Model_laporanpenjualan->listtransferlhp($dari, $sampai, $cabang, $salesman)->result();
      $statusbayar         = "voucher";
      $data['sb']          = $this->Model_laporanpenjualan->voucher($dari, $sampai, $cabang, $salesman, $pelanggan, $statusbayar)->result();
      $this->load->view('penjualan/laporan/cetak_kasbesarlhp', $data);
    } else {
      $data['rekapkasbesarcabang'] = $this->Model_laporanpenjualan->rekapkasbesarcabang($dari, $sampai, $jenisbayar)->result();
      $this->load->view('penjualan/laporan/cetak_rekapkasbesarcabang', $data);
    }
  }


  function exporthistori()
  {
    $kodepelanggan  = $this->uri->segment(3);
    $data['pel']    = $this->Model_pelanggan->get_pelanggan($kodepelanggan)->row_array();
    $data['pmb']    = $this->Model_pembayaran->listfaktur($kodepelanggan)->result();


    // Fungsi header dengan mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");

    // Mendefinisikan nama file ekspor "hasil-export.xls"
    header("Content-Disposition: attachment; filename=Histori Penjualan.xls");

    $this->load->view('penjualan/laporan/cetak_histori', $data);
  }
  function costratio()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/costratio', $data);
  }
  function cetak_costratio()
  {
    $cabang = $this->input->post('cabang');
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    if (empty($cabang)) {
      $data['biaya'] = $this->Model_laporanpenjualan->costratiobiaya($bulan, $tahun)->result();
      $data['swan'] = $this->Model_laporanpenjualan->netpenjualan($bulan, $tahun, 'SWAN')->row_array();
      $data['aida'] = $this->Model_laporanpenjualan->netpenjualan($bulan, $tahun, 'AIDA')->row_array();
      $data['returswan'] = $this->Model_laporanpenjualan->netretur($bulan, $tahun, 'SWAN')->row_array();
      $data['returaida'] = $this->Model_laporanpenjualan->netretur($bulan, $tahun, 'AIDA')->row_array();
      $data['piutang'] = $this->Model_laporanpenjualan->piutanglebihsatubulan($bulan, $tahun)->row_array();
      $data['cabang'] = $this->Model_cabang->view_cabang()->result();
      $this->load->view('penjualan/laporan/cetak_costratio', $data);
    } else {
      $data['cabang'] = $cabang;
      $data['biaya'] = $this->Model_laporanpenjualan->costratiobiayaCabang($bulan, $tahun, $cabang)->result();
      $data['swan'] = $this->Model_laporanpenjualan->netpenjualanCabang($bulan, $tahun, 'SWAN', $cabang)->row_array();
      $data['aida'] = $this->Model_laporanpenjualan->netpenjualanCabang($bulan, $tahun, 'AIDA', $cabang)->row_array();
      $data['returswan'] = $this->Model_laporanpenjualan->netreturCabang($bulan, $tahun, 'SWAN', $cabang)->row_array();
      $data['returaida'] = $this->Model_laporanpenjualan->netreturCabang($bulan, $tahun, 'AIDA', $cabang)->row_array();
      $data['piutang'] = $this->Model_laporanpenjualan->piutanglebihsatubulanCabang($bulan, $tahun, $cabang)->row_array();
      $this->load->view('penjualan/laporan/cetak_costratiocabang', $data);
    }
  }

  function rekapkendaraan()
  {
    $data['cb']    = $this->session->userdata('cabang');
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template', 'penjualan/laporan/rekapkendaraan.php', $data);
  }

  function cetak_rekapkendaraan()
  {
    $cabang = $this->input->post('cabang');
    $kendaraan = $this->input->post('kendaraan');
    $dari = $this->input->post('dari');
    $sampai = $this->input->post('sampai');
    $data['dari'] = $dari;
    $data['sampai'] = $sampai;
    $data['cabang'] = $cabang;
    $data['kendaraan'] = $kendaraan;
    $data['histori'] = $this->Model_laporanpenjualan->historikendaraan($dari, $sampai, $kendaraan)->result();
    $data['rekapkendaraan'] = $this->Model_laporanpenjualan->rekapkendaraan($dari, $sampai, $kendaraan)->result();
    $this->load->view('penjualan/laporan/cetak_rekapkendaraan', $data);
  }
}
