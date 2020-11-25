<?php

class laporanpembelian extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->model(array('Model_pembelian'));
	}

	function pembelian()
	{
		$data['supp']  = $this->Model_pembelian->listSupplier()->result();
		$data['dept']  = $this->Model_pembelian->getPemohon()->result();
		$this->template->load('template/template', 'laporanpembelian/pembelian.php', $data);
	}

	function pembayaran()
	{
		$data['supp']  = $this->Model_pembelian->listSupplier()->result();
		$this->template->load('template/template', 'laporanpembelian/pembayaran.php', $data);
	}

	function kartuhutang()
	{
		$data['supp']  = $this->Model_pembelian->listSupplier()->result();
		$this->template->load('template/template', 'laporanpembelian/kartuhutang.php', $data);
	}

	function supplier()
	{
		$this->template->load('template/template', 'laporanpembelian/supplier.php');
	}

	function rekappembelian()
	{
		$this->template->load('template/template', 'laporanpembelian/rekappembelian.php');
	}

	function rekapperakun()
	{
		$this->template->load('template/template', 'laporanpembelian/rekapperakun.php');
	}

	function bahandankemasan()
	{
		$this->template->load('template/template', 'laporanpembelian/bahankemasan.php');
	}


	function jurnalkoreksi()
	{
		$this->template->load('template/template', 'laporanpembelian/jurnalkoreksi.php');
	}

	function auh()
	{
		$this->template->load('template/template', 'laporanpembelian/auh.php');
	}
	function cetak_pembelian()
	{
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['dept']			= $this->input->post('departemen');
		$data['supplier']	= $this->input->post('supplier');
		$data['ppn']			= $this->input->post('ppn');
		$data['supp']			= $this->Model_pembelian->getSupplier($data['supplier'])->row_array();
		$data['pmb']			= $this->Model_pembelian->cetak_pembelian($data['dari'], $data['sampai'], $data['dept'], $data['supplier'], $data['ppn'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Laporan Pembelian.xls");
		}
		$this->load->view('laporanpembelian/cetak_pembelian', $data);
	}

	function cetak_jurnalkoreksi()
	{
		$data['dari']               = $this->input->post('dari');
		$data['sampai']             = $this->input->post('sampai');
		$data['jurnalkoreksi']      = $this->Model_pembelian->jurnalkoreksi($data['dari'], $data['sampai'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Laporan Jurnal Koreksi.xls");
		}
		$this->load->view('laporanpembelian/cetak_jurnalkoreksi', $data);
	}

	function cetak_pembayaran()
	{
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['supplier']	= $this->input->post('supplier');
		$data['supp']			= $this->Model_pembelian->getSupplier($data['supplier'])->row_array();
		$data['pmb']			= $this->Model_pembelian->cetak_pembayaran($data['dari'], $data['sampai'], $data['supplier'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Laporan Pembayaran.xls");
		}
		$this->load->view('laporanpembelian/cetak_pembayaran', $data);
	}

	function cetak_supplier()
	{
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['pmb']			= $this->Model_pembelian->cetak_supplier($data['dari'], $data['sampai'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Supplier.xls");
		}
		$this->load->view('laporanpembelian/cetak_supplier', $data);
	}

	function cetak_rekappembelian()
	{
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['jenis']		= $this->input->post('jenis_barang');
		$data['pmb']			= $this->Model_pembelian->cetak_rekappembelian($data['dari'], $data['sampai'], $data['jenis'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Pembelian.xls");
		}
		$this->load->view('laporanpembelian/cetak_rekappembelian', $data);
	}


	function cetak_rekapperakun()
	{
		$data['dari']     = $this->input->post('dari');
		$data['sampai']   = $this->input->post('sampai');
		$data['pmb']      = $this->Model_pembelian->cetak_rekapperakun($data['dari'], $data['sampai'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Pembelian Per-Akun.xls");
		}
		$this->load->view('laporanpembelian/cetak_rekapperakun', $data);
	}

	function cetak_bahankemasan()
	{
		$jenis_barang     = $this->input->post('jenis_barang');
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['jenis']		= $this->input->post('jenis_barang');
		$data['pmb']			= $this->Model_pembelian->cetak_bahankemasan($data['dari'], $data['sampai'], $data['jenis'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			if ($jenis_barang == "BAHAN") {
				header("Content-Disposition: attachment; filename=Rekap Bahan.xls");
			} elseif ($jenis_barang == "KEMASAN") {
				header("Content-Disposition: attachment; filename=Rekap Kemasan.xls");
			} elseif ($jenis_barang == "") {
				header("Content-Disposition: attachment; filename=Rekap Bahan Kemasan.xls");
			}
		}
		$this->load->view('laporanpembelian/cetak_bahankemasan', $data);
	}


	function cetak_kartuhutang()
	{
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['supplier']	= $this->input->post('supplier');
		$data['jenis']		= $this->input->post('jenishutang');
		$data['supp']			= $this->Model_pembelian->getSupplier($data['supplier'])->row_array();
		$data['pmb']			= $this->Model_pembelian->cetak_kartuhutang($data['dari'], $data['sampai'], $data['supplier'], $data['jenis'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Kartu Hutang.xls");
		}
		$this->load->view('laporanpembelian/cetak_kartuhutang', $data);
	}

	function cetak_auh()
	{
		$data['sampai'] 	= $this->input->post('sampai');
		$data['pmb']			= $this->Model_pembelian->cetak_auh($data['sampai'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=AUH.xls");
		}
		$this->load->view('laporanpembelian/cetak_auh', $data);
	}

	function bankharga()
	{
		$data['barang']  = $this->Model_pembelian->listBarang()->result();
		$this->template->load('template/template', 'laporanpembelian/bankharga.php', $data);
	}

	function cetak_bankharga()
	{
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['brg']			= $this->input->post('barang');
		$data['barang']	  = $this->Model_pembelian->getBarang($data['brg'])->row_array();
		$data['pmb']			= $this->Model_pembelian->cetak_bankharga($data['dari'], $data['sampai'], $data['brg'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Bank Harga.xls");
		}
		$this->load->view('laporanpembelian/cetak_bankharga', $data);
	}

	function rekapproduk()
	{
		$data['barang'] = $this->Model_pembelian->getBarangKategori1()->result();
		$data['supp']  = $this->Model_pembelian->listSupplier()->result();
		$this->template->load('template/template', 'laporanpembelian/rekapproduk.php', $data);
	}

	function cetakrekapbarang()
	{
		$data['dari'] 		=	$this->input->post('dari');
		$data['sampai'] 	= $this->input->post('sampai');
		$data['brg']			= $this->input->post('brg');
		$data['supplier'] = $this->input->post('supplier');

		$data['barang']	  = $this->Model_pembelian->getBarang($data['brg'])->row_array();
		$data['pmb']			= $this->Model_pembelian->getDetailPMB($data['dari'], $data['sampai'], $data['brg'], $data['supplier'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Bank Harga.xls");
		}
		$this->load->view('laporanpembelian/cetak_rekapbarang', $data);
	}
}
