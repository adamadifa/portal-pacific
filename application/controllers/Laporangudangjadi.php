<?php

class Laporangudangjadi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->model(array('Model_laporangudangjadi', 'Model_cabang'));
	}

	function get_produk()
	{
		$produk = $this->Model_laporangudangjadi->listproduk()->result();
		foreach ($produk as $p) {
			echo "<option value='$p->kode_produk'>$p->nama_barang</option>";
		}
	}

	function persediaan()
	{
		$data['produk'] = $this->Model_laporangudangjadi->listproduk()->result();
		$this->template->load('template/template', 'Laporangudangjadi/mutasi.php', $data);
	}

	function rekappersediaan()
	{
		$this->template->load('template/template', 'Laporangudangjadi/rekapmutasi.php');
	}

	function rekaphasilproduksi()
	{
		$this->template->load('template/template', 'Laporangudangjadi/rekaphasilproduksi');
	}

	function rekappengeluaran()
	{
		$this->template->load('template/template', 'Laporangudangjadi/rekappengeluaran');
	}

	function realisasipengeluaran()
	{
		$this->template->load('template/template', 'Laporangudangjadi/realisasipengeluaran');
	}

	function realisasikiriman()
	{
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template', 'Laporangudangjadi/realisasikiriman', $data);
	}

	function rekappersediaancabang()
	{
		$data['cb']			= $this->session->userdata('cabang');
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template', 'Laporangudangjadi/rekappersediaancabang', $data);
	}


	function rekapbadstok()
	{
		$data['cb']			= $this->session->userdata('cabang');
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template', 'Laporangudangjadi/rekapbadstok', $data);
	}

	function rekapbjcabang()
	{
		$data['cb']			= $this->session->userdata('cabang');
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template', 'Laporangudangjadi/rekapbjcabang', $data);
	}

	function rekapbadstokcabang()
	{
		$data['cb']			= $this->session->userdata('cabang');
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template', 'Laporangudangjadi/rekapbadstokcabang', $data);
	}


	function cetak_persediaan()
	{

		$produk 						= $this->input->post('produk');
		$dari 							= $this->input->post('dari');
		$sampai     				= $this->input->post('sampai');
		$data['dari']				= $dari;
		$data['sampai']			= $sampai;
		$data['produk']			= $this->Model_laporangudangjadi->get_produk($produk)->row_array();
		$data['mutasi']			= $this->Model_laporangudangjadi->mutasi($dari, $sampai, $produk)->result();
		$ceksaldo						= $this->Model_laporangudangjadi->getSaldoAwalMutasi($dari, $sampai, $produk)->row_array();
		$data['saldoawal']	= $ceksaldo['saldo_awal'];
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");

			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Laporan Persediaan BJ.xls");
		}
		$this->load->view('Laporangudangjadi/cetak_persediaan', $data);
	}




	function cetak_rekappersediaan()
	{

		$dari 						= $this->input->post('dari');
		$sampai     			= $this->input->post('sampai');
		$data['dari']			= $dari;
		$data['sampai']		= $sampai;
		$data['mutasi']		= $this->Model_laporangudangjadi->rekapmutasi($dari, $sampai)->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Persediaan BJ.xls");
		}
		$this->load->view('Laporangudangjadi/cetak_rekappersediaan', $data);
	}


	function cetak_rekaphasilproduksi()
	{

		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['rekap'] = $this->Model_laporangudangjadi->rekaphasilproduksi($data['bulan'], $data['tahun'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");

			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Hasil Produksi.xls");
		}
		$this->load->view('Laporangudangjadi/cetak_rekaphasilproduksi', $data);
	}

	function cetak_rekappengeluaran()
	{

		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['rekap'] = $this->Model_laporangudangjadi->rekappengeluaran($data['bulan'], $data['tahun'])->result();

		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");

			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Pengeluaran Barang.xls");
		}
		$this->load->view('Laporangudangjadi/cetak_rekappengeluaran', $data);
	}

	function cetak_realisasipengeluaran()
	{

		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['rekap'] = $this->Model_laporangudangjadi->realisasipengeluaran($data['bulan'], $data['tahun'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");

			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Realisasi Pengeluaran.xls");
		}
		$this->load->view('Laporangudangjadi/cetak_realisasipengeluaran', $data);
	}



	function cetak_realisasikiriman()
	{

		$cabang 		= $this->input->post('cabang');
		$data['bulan']  = $this->input->post('bulan');
		$data['tahun']  = $this->input->post('tahun');
		$data['cb']	    = $this->Model_cabang->get_cabang($cabang)->row_array();
		$data['rekap']  = $this->Model_laporangudangjadi->realisasikiriman($cabang, $data['bulan'], $data['tahun'])->result();
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");

			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Realisasi Kiriman.xls");
		}
		$this->load->view('Laporangudangjadi/cetak_realisasikiriman', $data);
	}

	function cetak_rekappersediaancabang()
	{
		$cabang 								= $this->input->post('cabang');
		$produk 								= $this->input->post('produk');
		$dari 									= $this->input->post('dari');
		$sampai     						= $this->input->post('sampai');
		$data['dari']						= $dari;
		$data['sampai']					= $sampai;
		$data['cb']	    				= $this->Model_cabang->get_cabang($cabang)->row_array();
		$data['produk']					= $this->Model_laporangudangjadi->get_produk($produk)->row_array();
		$data['mutasi']					= $this->Model_laporangudangjadi->mutasi_cabang($cabang, $dari, $sampai, $produk)->result();
		$ceksaldo								= $this->Model_laporangudangjadi->getSaldoAwalMutasiCabang($cabang, $dari, $sampai, $produk)->row_array();
		$ceksaldosa 						= $this->Model_laporangudangjadi->getSaldoAwalMutasiCabang($cabang, $dari, $sampai, $produk)->num_rows();
		$mtsa 									= $this->Model_laporangudangjadi->getMtsa($cabang, $dari, $produk)->row_array();
		if ($mtsa['jumlah'] != 0) {
			$jmlmtsa	= $mtsa['jumlah'] / $mtsa['isipcsdus'];
		} else {
			$jmlmtsa	= 0;
		}
		if ($ceksaldo['jumlah'] != 0) {
			$data['saldoawal']	= ($ceksaldo['jumlah'] / $ceksaldo['isipcsdus']) + $jmlmtsa;
		} else {
			$data['saldoawal']	= 0  + $jmlmtsa;
		}


		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Persediaan Cabang.xls");
		}
		// if(empty($ceksaldosa)){
		// 	echo "Saldo Awal Bulan Ini Belum Diset";
		// }else{
		$this->load->view('Laporangudangjadi/cetak_rekappersediaancabang', $data);
		// }

	}


	function cetak_rekapbadstok()
	{
		$cabang 					= $this->input->post('cabang');
		$produk 					= $this->input->post('produk');
		$dari 						= $this->input->post('dari');
		$sampai     			= $this->input->post('sampai');
		$data['dari']			= $dari;
		$data['sampai']		= $sampai;
		$data['cb']	    	= $this->Model_cabang->get_cabang($cabang)->row_array();
		$data['produk']		= $this->Model_laporangudangjadi->get_produk($produk)->row_array();
		$data['mutasi']		= $this->Model_laporangudangjadi->mutasibadstok_cabang($cabang, $dari, $sampai, $produk)->result();
		$ceksaldo					= $this->Model_laporangudangjadi->getSaldoAwalMutasiBadCabang($cabang, $dari, $sampai, $produk)->row_array();
		$ceksaldosa				= $this->Model_laporangudangjadi->getSaldoAwalMutasiBadCabang($cabang, $dari, $sampai, $produk)->num_rows();
		$mtsa 						= $this->Model_laporangudangjadi->getMtsaBad($cabang, $dari, $produk)->row_array();
		if ($mtsa['jumlah'] != 0) {
			$jmlmtsa	= $mtsa['jumlah'] / $mtsa['isipcsdus'];
		} else {
			$jmlmtsa	= 0;
		}
		if ($ceksaldo['jumlah'] != 0) {
			$data['saldoawal']	= ($ceksaldo['jumlah'] / $ceksaldo['isipcsdus']) + $jmlmtsa;
		} else {
			$data['saldoawal']	= 0 + $jmlmtsa;
		}
		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Bad Stok.xls");
		}

		// if(empty($ceksaldosa)){
		// 	echo "Saldo Awal Bulan Ini Belum Diset";
		// }else{
		$this->load->view('Laporangudangjadi/cetak_rekapbadstok', $data);
		// }

	}

	function cetak_rekapbjcabang()
	{
		$cabang 					= $this->input->post('cabang');
		$dari 						= $this->input->post('dari');
		$sampai     			= $this->input->post('sampai');
		$data['dari']			= $dari;
		$data['sampai']		= $sampai;
		$data['cb']	    	= $this->Model_cabang->get_cabang($cabang)->row_array();
		$data['rekap']  	= $this->Model_laporangudangjadi->rekapbjcabang($cabang, $data['dari'], $data['sampai'])->result();

		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap BJ Cabang.xls");
		}
		$this->load->view('Laporangudangjadi/cetak_rekapbjcabang', $data);
	}

	function mutasidpb()
	{
		$data['tahun']  = date("Y");
		$data['bulan']  = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$data['cb']			= $this->session->userdata('cabang');
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template', 'Laporangudangjadi/mutasidpb', $data);
	}


	// function cetakmutasidpb(){
	//
	// 	$produk 						= $this->input->post('produk');
	// 	$dari 							= $this->input->post('dari');
	// 	$sampai     				= $this->input->post('sampai');
	// 	$data['dari']				= $dari;
	// 	$data['sampai']			= $sampai;
	// 	$data['produk']			= $this->Model_laporangudangjadi->get_produk($produk)->row_array();
	// 	$data['mutasi']			= $this->Model_laporangudangjadi->mutasi($dari,$sampai,$produk)->result();
	// 	$ceksaldo						= $this->Model_laporangudangjadi->getSaldoAwalMutasi($dari,$sampai,$produk)->row_array();
	// 	$data['saldoawal']	= $ceksaldo['saldo_awal'];
	// 	if(isset($_POST['export'])){
	// 		// Fungsi header dengan mengirimkan raw data excel
	// 		header("Content-type: application/vnd-ms-excel");
	//
	// 		// Mendefinisikan nama file ekspor "hasil-export.xls"
	// 		header("Content-Disposition: attachment; filename=Laporan Persediaan BJ.xls");
	// 	}
	// 	$this->load->view('Laporangudangjadi/cetak_persediaan',$data);
	// }

	function cetakmutasidpb()
	{
		$cabang 								= $this->input->post('cabang');
		$produk 								= $this->input->post('produk');
		$bulan 									= $this->input->post('bulan');
		$tahun     							= $this->input->post('tahun');
		$dari 									= $tahun . "-" . $bulan . "-01";
		$data['bulan'] 					= $bulan;
		$data['tahun'] 					= $tahun;
		// echo $dari;
		// die;
		$sampai 								= "";
		$data['cb']	    				= $this->Model_cabang->get_cabang($cabang)->row_array();
		$data['produk']					= $this->Model_laporangudangjadi->get_produk($produk)->row_array();
		$ceksaldo								= $this->Model_laporangudangjadi->getSaldoAwalMutasiCabang($cabang, $dari, $sampai, $produk)->row_array();
		$data['mutasi']					= $this->Model_laporangudangjadi->mutasisuratjalan($cabang, $bulan, $tahun, $produk)->result();
		$data['mutasireject']   = $this->Model_laporangudangjadi->mutasireject($cabang, $bulan, $tahun, $produk)->result();
		$data['mutasirepack']   = $this->Model_laporangudangjadi->mutasirepack($cabang, $bulan, $tahun, $produk)->result();
		$data['mutasipenyesuaian'] = $this->Model_laporangudangjadi->mutasipenyesuaian($cabang, $bulan, $tahun, $produk)->result();
		$data['mutasidpb'] 			= $this->Model_laporangudangjadi->mutasidpbpengambilan($cabang, $bulan, $tahun, $produk)->result();
		//$data['mutasidpbkembali']      = $this->Model_laporangudangjadi->mutasidpbpengembalian($cabang,$bulan,$tahun,$produk)->result();  
		$mtsa 									= $this->Model_laporangudangjadi->getMtsa($cabang, $dari, $produk)->row_array();
		if ($mtsa['jumlah'] != 0) {
			$jmlmtsa	= $mtsa['jumlah'] / $mtsa['isipcsdus'];
		} else {
			$jmlmtsa	= 0;
		}
		if ($ceksaldo['jumlah'] != 0) {
			$data['saldoawal']	= ($ceksaldo['jumlah'] / $ceksaldo['isipcsdus']) + $jmlmtsa;
		} else {
			$data['saldoawal']	= 0  + $jmlmtsa;
		}


		if (isset($_POST['export'])) {
			// Fungsi header dengan mengirimkan raw data excel
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Rekap Persediaan Cabang.xls");
		}
		// if(empty($ceksaldosa)){
		// 	echo "Saldo Awal Bulan Ini Belum Diset";
		// }else{
		$this->load->view('Laporangudangjadi/cetakmutasidpb', $data);
		// }

	}

	function realisasioman()
	{
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template', 'Laporangudangjadi/realisasioman', $data);
	}

	function cetak_realisasioman()
	{
		$data['bulan']  = $this->input->post('bulan');
		$data['tahun']  = $this->input->post('tahun');
		$data['produk'] = $this->Model_laporangudangjadi->listproduk()->result();
		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->load->view('Laporangudangjadi/cetak_realisasioman', $data);
	}
}
