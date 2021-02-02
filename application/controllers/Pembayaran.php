<?php

class Pembayaran extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->Model(array('Model_pembayaran', 'Model_pelanggan', 'Model_sales', 'Model_setting', 'Model_cabang'));
	}

	function index($rowno = 0)
	{
		// Search text
		$sess_cab   = $this->session->userdata('cabang');
		if ($sess_cab == 'pusat') {
			$cbg   = "";
		} else {
			$cbg   = $sess_cab;
		}

		$salesman = "";
		$namapel = "";
		$dari = "";
		$sampai = "";
		if ($this->input->post('submit') != NULL) {
			$cbg      = $this->input->post('cabang');
			$salesman = $this->input->post('salesman');
			$namapel = $this->input->post('namapel');
			$dari     = $this->input->post('dari');
			$sampai   = $this->input->post('sampai');

			$data     = array(
				'cbg'        => $cbg,
				'salesman'   => $salesman,
				'namapel'   => $namapel,
				'dari'       => $dari,
				'sampai'     => $sampai
			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('cbg') != NULL) {
				$cbg = $this->session->userdata('cbg');
			}
			if ($this->session->userdata('salesman') != NULL) {
				$salesman = $this->session->userdata('salesman');
			}

			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}

			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}
			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}
		}

		if (isset($_POST['export'])) {
			header("Content-type: application/vnd-ms-excel");
			// Mendefinisikan nama file ekspor "hasil-export.xls"
			header("Content-Disposition: attachment; filename=Data Pelanggan.xls");
			$data['pelanggan'] = $this->Model_pelanggan->Exportpelanggan($cbg, $salesman, $namapel, $dari, $sampai)->result();
			$this->load->view('pelanggan/pelanggan_export', $data);
		} else {
			// Row per page
			$rowperpage = 10;
			// Row position
			if ($rowno != 0) {
				$rowno = ($rowno - 1) * $rowperpage;
			}

			$status = 1;
			// All records count
			$allcount     = $this->Model_pelanggan->getrecordPelanggan($cbg, $salesman, $namapel, $dari, $sampai, $kodepel = "", $status);
			// Get records
			$users_record = $this->Model_pelanggan->getdataPelanggan($rowno, $rowperpage, $cbg, $salesman, $namapel, $dari, $sampai, $kodepel = "", $status);
			// Pagination Configuration
			$config['base_url']         = base_url() . 'pembayaran/index';
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = $allcount;
			$config['per_page']         = $rowperpage;

			$config['first_link']       = 'First';
			$config['last_link']        = 'Last';
			$config['next_link']        = 'Next';
			$config['prev_link']        = 'Prev';
			$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
			$config['full_tag_close']   = '</ul></nav></div>';
			$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
			$config['num_tag_close']    = '</span></li>';
			$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
			$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
			$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
			$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
			$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
			$config['prev_tagl_close']  = '</span>Next</li>';
			$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
			$config['first_tagl_close'] = '</span></li>';
			$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
			$config['last_tagl_close']  = '</span></li>';
			// Initialize
			$this->pagination->initialize($config);
			$data['pagination']         = $this->pagination->create_links();
			$data['result']             = $users_record;
			$data['allcount']           = $allcount;
			$data['row']                = $rowno;
			$data['cbg']                = $cbg;
			$data['salesman']           = $salesman;
			$data['namapel']            = $namapel;
			$data['dari']       				= $dari;
			$data['sampai']     				= $sampai;
			$data['cabang']             = $this->Model_cabang->view_cabang()->result();
			$data['sess_cab']           = $this->session->userdata('cabang');
			$this->template->load('template/template', 'pembayaran/histori_penjualan', $data);
		}
	}



	function listfaktur($rowno = 0)
	{

		$kodepelanggan 		= $this->uri->segment(3);
		$data['pel']		= $this->Model_pelanggan->get_pelanggan($kodepelanggan)->row_array();
		$data['pmb']		= $this->Model_pembayaran->listfaktur($kodepelanggan)->result();
		$this->template->load('template/template', 'pembayaran/list_faktur', $data);
	}

	function inputbayar()
	{

		if (isset($_POST['simpan'])) {
			$nofaktur = $this->input->post('nofaktur');
			$this->Model_pembayaran->inputbayar();
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$data['nofaktur'] 		= $this->input->post('nofaktur');
			$data['totalbayar']		= $this->input->post('totalbayar');
			$data['totalpiutang']	= $this->input->post('totalpiutang');
			$data['salesman'] 		= $this->Model_sales->view_sales()->result();
			$data['girotolak']		= $this->Model_pembayaran->getGiroditolak($data['nofaktur'])->result();
			$this->load->view('pembayaran/input_bayar', $data);
		}
	}

	function inputbayarenter()
	{
		$nofaktur = $this->input->post('nofaktur');
		$this->Model_pembayaran->inputbayar();
		$this->session->set_flashdata(
			'msg',
			'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
		);
		redirect('penjualan/detailfaktur/' . $nofaktur);
	}


	//function terbilang(){

	//$jmlbayar = $this->input->post('jmlbayar');
	//echo "<b><i>".ucwords(terbilang($jmlbayar))."</i></b>";

	//}

	function terbilang()
	{
		error_reporting(0);
		$jmlbayar = $this->input->post('jmlbayar');
		echo "<b><i>" . ucwords(number_format($jmlbayar, '0', '', '.')) . "</i></b>";
	}

	function hapus()
	{

		$nobukti 	= $this->uri->segment(3);
		$nofaktur 	= $this->uri->segment(4);
		$cekbayar = $this->db->get_where('historibayar', array('nobukti' => $nobukti))->row_array();
		$tanggal = $cekbayar['tglbayar'];
		$jenis = "penjualan";
		$cek = $this->Model_setting->cektutuplaporan($tanggal, $jenis)->num_rows();
		if ($cek > 0) {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Gagal Di Hapus, Periode Laporan Sudah Ditutup !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$this->Model_pembayaran->hapus($nobukti);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Dihapus !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		}
	}


	function editbayar()
	{

		if (isset($_POST['simpan'])) {
			$nobukti 	= $this->input->post('nobukti');
			$nofaktur 	= $this->input->post('nofaktur');
			$this->Model_pembayaran->updatebayar($nobukti);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$data['nofaktur'] 		= $this->input->post('nofaktur');
			$data['totalpiutang']	= $this->input->post('totalpiutang');
			$nobukti 							= $this->input->post('nobukti');
			$nofaktur 						= $this->input->post('nofaktur');
			$totalbayar 					= $this->Model_pembayaran->cekbayarlast($nobukti, $nofaktur)->row_array();
			$data['totalbayar']		= $totalbayar['totalbayar'];
			$data['bayar']				= $this->Model_pembayaran->viewbayar($nobukti)->row_array();
			$data['salesman'] 		= $this->Model_sales->view_sales()->result();
			$data['girotolak']		= $this->Model_pembayaran->getGiroditolak($data['nofaktur'])->result();
			// var_dump($data['girotolak']);
			// die;
			$this->load->view('pembayaran/edit_bayar', $data);
		}
	}

	function editbayarenter()
	{
		$nobukti 	= $this->input->post('nobukti');
		$nofaktur 	= $this->input->post('nofaktur');
		$this->Model_pembayaran->updatebayar($nobukti);
		$this->session->set_flashdata(
			'msg',
			'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
		);
		redirect('penjualan/detailfaktur/' . $nofaktur);
	}



	function inputgiro()
	{

		if (isset($_POST['simpan'])) {
			$nofaktur = $this->input->post('nofaktur');
			$this->Model_pembayaran->inputgiro();
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$data['nofaktur'] 		= $this->input->post('nofaktur');
			$data['totalbayar']		= $this->input->post('totalbayar');
			$data['totalpiutang']	= $this->input->post('totalpiutang');
			$data['salesman'] 		= $this->Model_sales->view_sales()->result();
			$this->load->view('pembayaran/input_giro', $data);
		}
	}

	function editgiro()
	{

		if (isset($_POST['simpan'])) {
			$idgiro   = $this->input->post('id_giro');
			$nofaktur = $this->input->post('nofaktur');
			$this->Model_pembayaran->updategiro($idgiro);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$data['nofaktur'] 		= $this->input->post('nofaktur');
			$data['totalbayar']		= $this->input->post('totalbayar');
			$data['totalpiutang']	= $this->input->post('totalpiutang');
			$idgiro 							= $this->input->post('id_giro');
			$data['giro']					= $this->Model_pembayaran->viewgirofaktur($idgiro)->row_array();
			$data['salesman'] 		= $this->Model_sales->view_sales()->result();
			$this->load->view('pembayaran/edit_giro', $data);
		}
	}


	function hapusgiro()
	{

		$id_giro 	= $this->uri->segment(3);
		$nofaktur 	= $this->uri->segment(4);
		$cekbayar = $this->db->get_where('giro', array('id_giro' => $id_giro))->row_array();
		$tanggal = $cekbayar['tgl_giro'];
		$jenis = "penjualan";
		$cek = $this->Model_setting->cektutuplaporan($tanggal, $jenis)->num_rows();
		if ($cek > 0) {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Gagal Dihapus, Periode Laporan Sudah Ditutup !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$this->Model_pembayaran->hapusgiro($id_giro);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Dihapus !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		}
	}


	function inputtransfer()
	{

		if (isset($_POST['simpan'])) {
			$nofaktur = $this->input->post('nofaktur');
			$this->Model_pembayaran->inputtransfer();
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$data['nofaktur'] 		= $this->input->post('nofaktur');
			$data['totalbayar']		= $this->input->post('totalbayar');
			$data['totalpiutang']	= $this->input->post('totalpiutang');
			$data['kodepel']			= $this->input->post('kodepel');
			$data['salesman'] 		= $this->Model_sales->view_sales()->result();
			$this->load->view('pembayaran/input_transfer', $data);
		}
	}

	function inputtransferpending()
	{

		if (isset($_POST['simpan'])) {
			$nofaktur = $this->input->post('nofaktur');
			$this->Model_pembayaran->inputtransfer();
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirectPreviousPage();
		} else {
			$data['nofaktur'] 		= $this->input->post('nofaktur');
			$data['totalbayar']		= $this->input->post('totalbayar');
			$data['totalpiutang']	= $this->input->post('totalpiutang');
			$data['kodepel']			= $this->input->post('kodepel');
			$data['salesman'] 		= $this->Model_sales->view_sales()->result();
			$this->load->view('pembayaran/input_transferpending', $data);
		}
	}

	function hapustransfer()
	{

		$id_transfer 	= $this->uri->segment(3);
		$nofaktur 		= $this->uri->segment(4);
		$cekbayar = $this->db->get_where('transfer', array('id_transfer' => $id_transfer))->row_array();
		$tanggal = $cekbayar['tgl_transfer'];
		$jenis = "penjualan";
		$cek = $this->Model_setting->cektutuplaporan($tanggal, $jenis)->num_rows();
		if ($cek > 0) {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Gagal Dihapus, Periode Laporan Sudah Ditutup !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$this->Model_pembayaran->hapustransfer($id_transfer);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		}
	}



	function edittransfer()
	{

		if (isset($_POST['simpan'])) {
			$idtransfer   = $this->input->post('id_transfer');
			$nofaktur 	  = $this->input->post('nofaktur');
			$this->Model_pembayaran->updatetransfer($idtransfer);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-check" style="float:left; margin-right:10px"></i> Data Berhasil Disimpan !
				</div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$data['nofaktur'] 		= $this->input->post('nofaktur');
			$data['totalbayar']		= $this->input->post('totalbayar');
			$data['totalpiutang']	= $this->input->post('totalpiutang');
			$id_transfer 					= $this->input->post('id_transfer');
			$data['kodepel']			= $this->input->post('kodepel');
			$data['transfer']			= $this->Model_pembayaran->viewtransferfaktur($id_transfer)->row_array();
			$data['salesman'] 		= $this->Model_sales->view_sales()->result();
			$this->load->view('pembayaran/edit_transfer', $data);
		}
	}



	function listgiro($rowno = 0)
	{
		// Search text
		$namapel 		= "";
		$nogiro 		= "";
		$dari 			= "";
		$sampai 		= "";
		$status 		= "";

		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');
			$nogiro 	= $this->input->post('nogiro');
			$dari 		= $this->input->post('dari');
			$sampai 	= $this->input->post('sampai');
			$status 	= $this->input->post('status2');
			$data 	= array(

				'namapel'	 => $namapel,
				'nogiro'	 => $nogiro,
				'dari'		 => $dari,
				'sampai'	 => $sampai,
				'status'	 => $status

			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}

			if ($this->session->userdata('nogiro') != NULL) {
				$nogiro = $this->session->userdata('nogiro');
			}
			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}
			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}

			if ($this->session->userdata('status') != NULL) {
				$status = $this->session->userdata('status');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordGiro($namapel, $nogiro, $status, $dari, $sampai);

		// Get records
		$users_record = $this->Model_pembayaran->getdataGiro($rowno, $rowperpage, $namapel, $nogiro, $status, $dari, $sampai);



		//echo $allcount;

		//die;
		// Pagination Configuration
		$config['base_url'] 				= base_url() . 'pembayaran/listgiro';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] 			= $allcount;
		$config['per_page'] 				= $rowperpage;

		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 		= $users_record;
		$data['row'] 				= $rowno;
		$data['namapel'] 		= $namapel;
		$data['dari']				= $dari;
		$data['sampai']			= $sampai;
		$data['nogiro']			= $nogiro;
		$data['status']			= $status;
		$this->template->load('template/template', 'pembayaran/list_giro', $data);
	}



	function listgiropending($rowno = 0)
	{
		// Search text
		$namapel 	= "";
		$nogiro 	= "";
		$status 	= 0;
		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');
			$nogiro 	= $this->input->post('nogiro');
			$data 	= array(

				'namapel'	 => $namapel,
				'nogiro'	 => $nogiro

			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}



			if ($this->session->userdata('nogiro') != NULL) {
				$nogiro = $this->session->userdata('nogiro');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordGiro($namapel, $nogiro, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataGiro($rowno, $rowperpage, $namapel, $nogiro, $status);



		// Pagination Configuration
		$config['base_url'] 		= base_url() . 'pembayaran/listgiropending';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] 		= $allcount;
		$config['per_page'] 		= $rowperpage;

		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 	= $users_record;
		$data['row'] 		= $rowno;
		$data['namapel'] 	= $namapel;
		$data['nogiro']		= $nogiro;
		$this->template->load('template/template', 'pembayaran/list_giropending', $data);
	}


	function listgiroditerima($rowno = 0)
	{
		// Search text
		$namapel 	= "";
		$nogiro 	= "";
		$status 	= 1;
		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');

			$nogiro 	= $this->input->post('nogiro');
			$data 	= array(

				'namapel'	 => $namapel,
				'nogiro'	 => $nogiro

			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}



			if ($this->session->userdata('nogiro') != NULL) {
				$nogiro = $this->session->userdata('nogiro');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordGiro($namapel, $nogiro, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataGiro($rowno, $rowperpage, $namapel, $nogiro, $status);



		// Pagination Configuration
		$config['base_url'] 		= base_url() . 'pembayaran/listgiroditerima';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] 		= $allcount;
		$config['per_page'] 		= $rowperpage;

		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 	= $users_record;
		$data['row'] 		= $rowno;
		$data['namapel'] 	= $namapel;

		$data['nogiro']		= $nogiro;
		$this->template->load('template/template', 'pembayaran/list_giroditerima', $data);
	}


	function listgiroditolak($rowno = 0)
	{
		// Search text
		$namapel 	= "";
		$nogiro 	= "";
		$status 	= 2;
		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');

			$nogiro 	= $this->input->post('nogiro');

			$data 	= array(

				'namapel'	 => $namapel,

				'nogiro'	 => $nogiro,



			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}



			if ($this->session->userdata('nogiro') != NULL) {
				$nogiro = $this->session->userdata('nogiro');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordGiro($namapel, $nogiro, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataGiro($rowno, $rowperpage, $namapel, $nogiro, $status);



		// Pagination Configuration
		$config['base_url'] 					= base_url() . 'pembayaran/listgiroditolak';
		$config['use_page_numbers'] 	= TRUE;
		$config['total_rows'] 				= $allcount;
		$config['per_page'] 					= $rowperpage;

		$config['first_link']       	= 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] 	= $this->pagination->create_links();
		$data['result'] 			= $users_record;
		$data['row'] 					= $rowno;
		$data['namapel'] 			= $namapel;

		$data['nogiro']				= $nogiro;
		$this->template->load('template/template', 'pembayaran/list_giroditolak', $data);
	}

	function listtransfer($rowno = 0)
	{
		//	error_reporting(0);
		// Search text
		$namapel 		= "";
		$dari 			= "";
		$sampai 		= "";
		$status   	= "";

		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');
			$dari 		= $this->input->post('dari');
			$sampai 	= $this->input->post('sampai');
			$status		= $this->input->post('status2');

			$data 	= array(

				'namapel'	 => $namapel,
				'dari'		 => $dari,
				'sampai'	 => $sampai,
				'status'	 => $status


			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}

			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}

			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}

			if ($this->session->userdata('status') != NULL) {
				$status = $this->session->userdata('status');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordTransfer($namapel, $dari, $sampai, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataTransfer($rowno, $rowperpage, $namapel, $dari, $sampai, $status);



		// Pagination Configuration
		$config['base_url'] 				= base_url() . 'pembayaran/listtransfer';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] 			= $allcount;
		$config['per_page'] 				= $rowperpage;

		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 		= $users_record;
		$data['row'] 				= $rowno;
		$data['namapel'] 		= $namapel;
		$data['dari']				= $dari;
		$data['sampai']			= $sampai;
		$data['status']			= $status;

		$this->template->load('template/template', 'pembayaran/list_transfer', $data);
	}


	function listtransferpending($rowno = 0)
	{
		// Search text
		error_reporting(0);
		// Search text
		$namapel 		= "";
		$dari 			= "";
		$sampai 		= "";
		$status   	= 0;

		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');
			$dari 		= $this->input->post('dari');
			$sampai 	= $this->input->post('sampai');

			$data 	= array(

				'namapel'	 => $namapel,
				'dari'		 => $dari,
				'sampai'	 => $sampai


			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}

			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}
			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordTransfer($namapel, $dari, $sampai, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataTransfer($rowno, $rowperpage, $namapel, $dari, $sampai, $status);



		// Pagination Configuration
		$config['base_url'] 				 = base_url() . 'pembayaran/listtransferpending';
		$config['use_page_numbers']  = TRUE;
		$config['total_rows'] 			 = $allcount;
		$config['per_page'] 				 = $rowperpage;

		$config['first_link']        = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 		= $users_record;
		$data['row'] 				= $rowno;
		$data['namapel'] 		= $namapel;
		$data['dari']				= $dari;
		$data['sampai']			= $sampai;
		$this->template->load('template/template', 'pembayaran/list_transferpending', $data);
	}



	function listtransferditerima($rowno = 0)
	{
		// Search text
		error_reporting(0);
		// Search text
		$namapel 		= "";
		$dari 			= "";
		$sampai 		= "";
		$status   	= 1;

		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');
			$dari 		= $this->input->post('dari');
			$sampai 	= $this->input->post('sampai');

			$data 	= array(

				'namapel'	 => $namapel,
				'dari'		 => $dari,
				'sampai'	 => $sampai


			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}

			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}
			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordTransfer($namapel, $dari, $sampai, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataTransfer($rowno, $rowperpage, $namapel, $dari, $sampai, $status);



		// Pagination Configuration
		$config['base_url'] 			  = base_url() . 'pembayaran/listtransferditerima';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] 			= $allcount;
		$config['per_page'] 				= $rowperpage;

		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 		= $users_record;
		$data['row'] 				= $rowno;
		$data['namapel'] 		= $namapel;
		$data['dari']				= $dari;
		$data['sampai']			= $sampai;
		$this->template->load('template/template', 'pembayaran/list_transferditerima', $data);
	}



	function listtransferditolak($rowno = 0)
	{
		// Search text
		error_reporting(0);
		// Search text
		$namapel 	= "";
		$dari 			= "";
		$sampai 		= "";
		$status   	= 2;

		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');
			$dari 		= $this->input->post('dari');
			$sampai 	= $this->input->post('sampai');

			$data 	= array(

				'namapel'	 => $namapel,
				'dari'		 => $dari,
				'sampai'	 => $sampai


			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}

			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}
			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordTransfer($namapel, $dari, $sampai, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataTransfer($rowno, $rowperpage, $namapel, $dari, $sampai, $status);



		// Pagination Configuration
		$config['base_url'] 			   = base_url() . 'pembayaran/listtransferditolak';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] 			 = $allcount;
		$config['per_page'] 				 = $rowperpage;

		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 		= $users_record;
		$data['row'] 				= $rowno;
		$data['namapel'] 		= $namapel;
		$data['dari']				= $dari;
		$data['sampai']			= $sampai;
		$this->template->load('template/template', 'pembayaran/list_transferditolak', $data);
	}

	function editgirotolak()
	{

		if (isset($_POST['submit'])) {
			$idgiro   = $this->input->post('id_giro');
			$nofaktur = $this->input->post('nofaktur');
			$this->Model_pembayaran->updategirotolak($idgiro);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Update !
	          </div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$idgiro 				= $this->input->post('id_giro');
			$data['giro']			= $this->Model_pembayaran->viewgiro($idgiro)->row_array();
			$this->load->view('pembayaran/edit_girotolak', $data);
		}
	}


	function editbayargiro()
	{

		if (isset($_POST['submit'])) {
			$no_giro   	= $this->input->post('no_giro');
			$page 	  	= $this->input->post('page');
			$this->Model_pembayaran->updatebayargiro($no_giro);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Update !
        </div>'
			);
			redirect('pembayaran/' . $page);
		} else {
			$no_giro 					= $this->input->post('no_giro');
			$data['status']		= $this->input->post('status');
			$data['giro']			= $this->Model_pembayaran->viewgiro($no_giro)->row_array();
			$data['bank']			= $this->Model_pembayaran->listbank()->result();
			$data['bulan'] 		= array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
			$data['page']			= $this->input->post('page');
			$this->load->view('pembayaran/edit_bayargiro', $data);
		}
	}


	function editbayartransfer()
	{

		if (isset($_POST['submit'])) {
			$idtransfer   = $this->input->post('id_transfer');
			$page 	  	  = $this->input->post('page');
			$this->Model_pembayaran->updatebayartransfer($idtransfer);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="fa fa-check"></i> Data Berhasil Di Update !
	          </div>'
			);
			redirect('pembayaran/' . $page);
		} else {
			$idtransfer 				= $this->input->post('id_transfer');
			$data['transfer']		= $this->Model_pembayaran->viewtransfer($idtransfer)->row_array();
			$data['bank']				= $this->Model_pembayaran->listbank()->result();
			$data['page']				= $this->input->post('page');
			$data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
			$this->load->view('pembayaran/edit_bayartransfer', $data);
		}
	}

	function editbayartransferpending()
	{
		if (isset($_POST['submit'])) {
			$idtransfer   = $this->input->post('id_transfer');
			$page 	  	  = $this->input->post('page');
			$simpan = $this->Model_pembayaran->updatebayartransferpending($idtransfer);
		} else {
			$idtransfer 				= $this->input->post('id_transfer');
			$data['transfer']		= $this->Model_pembayaran->viewtransferpending($idtransfer)->row_array();
			$data['bank']				= $this->Model_pembayaran->listbank()->result();
			$data['page']				= $this->input->post('page');
			$data['bulan'] = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
			$this->load->view('pembayaran/edit_bayartransferpending', $data);
		}
	}

	function edittransfertolak()
	{

		if (isset($_POST['submit'])) {
			$id_transfer   = $this->input->post('id_transfer');
			$nofaktur 	   = $this->input->post('nofaktur');
			$this->Model_pembayaran->updatetransfertolak($id_transfer);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Update !
	          </div>'
			);
			redirect('penjualan/detailfaktur/' . $nofaktur);
		} else {
			$id_transfer 				= $this->input->post('id_transfer');
			$data['transfer']			= $this->Model_pembayaran->viewtransfer($id_transfer)->row_array();
			$this->load->view('pembayaran/edit_transfertolak', $data);
		}
	}


	function listbayar($rowno = 0)
	{
		// Search text
		$nofaktur = "";
		$namapel  = "";
		$dari = "";
		$sampai = "";

		if ($this->input->post('submit') != NULL) {
			$namapel   = $this->input->post('namapel');
			$nofaktur = $this->input->post('nofaktur');
			$dari     = $this->input->post('dari');
			$sampai   = $this->input->post('sampai');
			$data = array(
				'namapel'    => $namapel,
				'nofaktur'   => $nofaktur,
				'dari' => $dari,
				'sampai' => $sampai
			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}
			if ($this->session->userdata('nofaktur') != NULL) {
				$nofaktur = $this->session->userdata('nofaktur');
			}

			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}
			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}
		}
		// Row per page
		$rowperpage = 10;
		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		if (empty($nofaktur) && empty($namapel) && empty($dari) && empty($sampai)) {
			$allcount = 0;
			$users_record = 0;
		} else {
			// All records count
			$allcount     = $this->Model_pembayaran->getDataBayarCount($nofaktur, $namapel, $dari, $sampai)->num_rows();
			// Get records
			$users_record = $this->Model_pembayaran->getDataBayar($rowno, $rowperpage, $nofaktur, $namapel, $dari, $sampai)->result_array();
		}


		// Pagination Configuration
		$config['base_url']         = base_url() . 'pembayaran/listbayar';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows']       = $allcount;
		$config['per_page']         = $rowperpage;
		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;
		$data['nofaktur'] = $nofaktur;
		$data['dari']  = $dari;
		$data['sampai'] = $sampai;
		$data['namapel'] = $namapel;
		// Load view
		$this->template->load('template/template', 'pembayaran/listbayar', $data);
	}

	function hapuspotlainlain()
	{
		$id 					= $this->uri->segment(3);
		$nofaktur 		= $this->uri->segment(4);
		$this->Model_pembayaran->hapuspotlainlain($id, $nofaktur);
	}

	function detailgiro()
	{
		$nogiro = $this->input->post('no_giro');
		$data['giro'] = $this->Model_pembayaran->getdetailgiro($nogiro);
		$this->load->view('pembayaran/detailgiro', $data);
	}

	function detailtransfer()
	{
		$kode_transfer = $this->input->post('id_transfer');
		$data['transfer'] = $this->Model_pembayaran->getdetailtransfer($kode_transfer);
		$this->load->view('pembayaran/detailtransfer', $data);
	}

	function detailtransferpending()
	{
		$kode_transfer = $this->input->post('id_transfer');
		$data['transfer'] = $this->Model_pembayaran->getdetailtransferpending($kode_transfer);
		$this->load->view('pembayaran/detailtransfer', $data);
	}

	function detailsetoranpusat()
	{
		$kodesetoranpusat = $this->input->post('kode_setoran');
		$data['setoranpusat'] = $this->Model_pembayaran->getdetailsetoranpusat($kodesetoranpusat);
		$this->load->view('pembayaran/detailsetoranpusat', $data);
	}

	function listtransferpenjpending($rowno = 0)
	{
		//	error_reporting(0);
		// Search text
		$namapel 		= "";
		$dari 			= "";
		$sampai 		= "";
		$status   	= "";

		if ($this->input->post('submit') != NULL) {
			$namapel 	= $this->input->post('namapel');
			$dari 		= $this->input->post('dari');
			$sampai 	= $this->input->post('sampai');
			$status		= $this->input->post('status2');

			$data 	= array(

				'namapel'	 => $namapel,
				'dari'		 => $dari,
				'sampai'	 => $sampai,
				'status'	 => $status


			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('namapel') != NULL) {
				$namapel = $this->session->userdata('namapel');
			}

			if ($this->session->userdata('dari') != NULL) {
				$dari = $this->session->userdata('dari');
			}

			if ($this->session->userdata('sampai') != NULL) {
				$sampai = $this->session->userdata('sampai');
			}

			if ($this->session->userdata('status') != NULL) {
				$status = $this->session->userdata('status');
			}
		}

		// Row per page
		$rowperpage = 10;

		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount 	  = $this->Model_pembayaran->getrecordTransferpenjualanpending($namapel, $dari, $sampai, $status);

		// Get records
		$users_record = $this->Model_pembayaran->getdataTransferpenjualanpending($rowno, $rowperpage, $namapel, $dari, $sampai, $status);



		// Pagination Configuration
		$config['base_url'] 				= base_url() . 'pembayaran/listtransferpenjpending';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] 			= $allcount;
		$config['per_page'] 				= $rowperpage;

		$config['first_link']       = 'First';
		$config['last_link']        = 'Last';
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		// Initialize
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['result'] 		= $users_record;
		$data['row'] 				= $rowno;
		$data['namapel'] 		= $namapel;
		$data['dari']				= $dari;
		$data['sampai']			= $sampai;
		$data['status']			= $status;

		$this->template->load('template/template', 'pembayaran/list_transferpenjpending', $data);
	}

	function updateledgerpenjualan()
	{
		$update = $this->Model_pembayaran->updateledgerpenjualan();
	}
}
