<?php

class Bpbj extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Model_oman', 'Model_bpbj'));
	}

	function view_bpbj($rowno = 0)
	{
		// Search text
		$nomutasi 	= "";
		$tgl_mutasi  = "";
		if ($this->input->post('submit') != NULL) {
			$nomutasi 	= $this->input->post('no_mutasi');
			$tgl_mutasi = $this->input->post('tgl_mutasi');
			$data	= array(
				'nomutasi'	 	=> $nomutasi,
				'tgl_mutasi'	=> $tgl_mutasi
			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('nomutasi') != NULL) {
				$nomutasi = $this->session->userdata('nomutasi');
			}
			if ($this->session->userdata('tgl_mutasi') != NULL) {
				$tgl_mutasi = $this->session->userdata('tgl_mutasi');
			}
		}

		// Row per page
		$rowperpage = 10;
		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}
		// All records count
		$allcount 	  = $this->Model_bpbj->getrecordBpbjCount($nomutasi, $tgl_mutasi);
		// Get records
		$users_record = $this->Model_bpbj->getDataBpbj($rowno, $rowperpage, $nomutasi, $tgl_mutasi);
		// Pagination Configuration
		$config['base_url'] 				= base_url() . 'bpbj/view_bpbj';
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
		$data['nomutasi'] 	= $nomutasi;
		$data['tgl_mutasi']	= $tgl_mutasi;
		// Load view
		$this->template->load('template/template', 'bpbj/view_bpbj', $data);
	}


	function input_bpbj()
	{
		if (isset($_POST['submit'])) {
			$this->Model_bpbj->insert_bpbj();
		} else {
			$this->template->load('template/template', 'bpbj/input_bpbj');
		}
	}
	function view_barang()
	{
		$data['produk'] = $this->Model_oman->listproduk()->result();
		$this->load->view('bpbj/view_barang', $data);
	}
	function view_baranglainlain()
	{
		$data['produk'] = $this->Model_oman->listproduk()->result();
		$this->load->view('lainlain/view_barang', $data);
	}
	function insert_detailtmp()
	{
		$cek 	= $this->Model_bpbj->cek_detailtmpbpbj()->num_rows();
		$cek2	= $this->Model_bpbj->cek_detailtmp()->num_rows();
		if ($cek != 0) {
			echo "1";
		} else if ($cek2 != 0) {
			echo "2";
		} else {
			$this->Model_bpbj->insert_detailtmp();
		}
	}

	function view_detailbpbj_temp()
	{
		$id_admin 				= $this->session->userdata('id_user');
		$inout 						= 'IN';
		$kode_produk			= $this->uri->segment(3);
		$data['detail'] 	= $this->Model_bpbj->view_detailbpbj_temp($id_admin, $inout, $kode_produk)->result();
		$this->load->view('bpbj/view_detailbpbj_temp', $data);
	}


	function hapus_detailbpbjtmp()
	{
		$kode_produk 	= $this->input->post('kode_produk');
		$shift 				= $this->input->post('shift');
		$id_admin 		= $this->session->userdata('id_user');
		$this->Model_bpbj->hapus_detailbpbjtmp($kode_produk, $id_admin, $shift);
	}

	function buat_nomor_bpbj()
	{
		$tgl_bpbj 		= $this->input->post('tgl_bpbj');
		$kode_produk	= $this->input->post('kode_produk');
		$bpbj 				= $this->Model_bpbj->getNoBpbjLast($kode_produk, $tgl_bpbj)->row_array();
		$b 						= array("", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
		$tanggal 			= explode("-", $tgl_bpbj);
		$hari 				= $tanggal[2];
		$bulan 				= $tanggal[1];
		if ($bulan > 9) {
			$bl = $bulan;
		} else {
			$bl = substr($bulan, 1, 1);
		}
		//echo $bl;
		$tahun 					= $tanggal[0];
		$tgl 						= "/" . $hari . "/" . $b[$bl] . "/" . $tahun;
		$nomor_terakhir	= $bpbj['no_bpbj'];
		$no_bpbj 				= buatkode($nomor_terakhir, $kode_produk, 2) . $tgl;
		echo $no_bpbj;
	}


	function buat_nomor_lainlain()
	{
		$tgl_mutasi 	= $this->input->post('tgl_mutasi');
		$kode_produk	= $this->input->post('kode_produk');
		$lainlain 		= $this->Model_bpbj->getNoLainlainLast($kode_produk, $tgl_mutasi)->row_array();
		$b 						= array("", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
		$tanggal 			= explode("-", $tgl_mutasi);
		$hari 				= $tanggal[2];
		$bulan 				= $tanggal[1];
		if ($bulan > 9) {
			$bl = $bulan;
		} else {
			$bl = substr($bulan, 1, 1);
		}
		//echo $bl;
		$tahun 					= $tanggal[0];
		$tgl 						= "/" . $hari . "/" . $b[$bl] . "/" . $tahun;
		$nomor_terakhir	= $lainlain['no_mutasi'];
		$no_bpbj 				= buatkode($nomor_terakhir, "M" . $kode_produk, 2) . $tgl;
		echo $no_bpbj;
	}


	function hapus()
	{
		$no_mutasi = $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/" . $this->uri->segment(5) . "/" . $this->uri->segment(6);
		$hal 			 = $this->uri->segment(7);
		$this->Model_bpbj->hapus($no_mutasi, $hal);
	}


	function hapus_lainlain()
	{
		$no_mutasi = $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/" . $this->uri->segment(5) . "/" . $this->uri->segment(6);
		$this->Model_bpbj->hapus_lainlain($no_mutasi);
	}


	function detail_mutasi()
	{
		$nomutasi 			= $this->input->post('nomutasi');
		$data['mutasi']	= $this->Model_bpbj->getMutasi($nomutasi)->row_array();
		$data['detail']	= $this->Model_bpbj->detail_mutasi($nomutasi)->result();
		$this->load->view('bpbj/detail_mutasi', $data);
	}

	function detail_mutasilainlain()
	{
		$nomutasi 			= $this->input->post('nomutasi');
		$data['mutasi']	= $this->Model_bpbj->getMutasi($nomutasi)->row_array();
		$data['detail']	= $this->Model_bpbj->detail_mutasi($nomutasi)->result();
		$this->load->view('lainlain/detail_mutasi', $data);
	}


	function lainlain($rowno = 0)
	{
		// Search text
		$nomutasi 		= "";
		$tgl_mutasi  	= "";
		if ($this->input->post('submit') != NULL) {
			$nomutasi 		= $this->input->post('no_mutasi');
			$tgl_mutasi 	= $this->input->post('tgl_mutasi');
			$data = array(
				'nomutasi'	 	=> $nomutasi,
				'tgl_mutasi'	=> $tgl_mutasi
			);
			$this->session->set_userdata($data);
		} else {
			if ($this->session->userdata('nomutasi') != NULL) {
				$nomutasi = $this->session->userdata('nomutasi');
			}
			if ($this->session->userdata('tgl_mutasi') != NULL) {
				$tgl_mutasi = $this->session->userdata('tgl_mutasi');
			}
		}
		// Row per page
		$rowperpage = 10;
		// Row position
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}
		// All records count
		$allcount 	  = $this->Model_bpbj->getrecordLainlainCount($nomutasi, $tgl_mutasi);
		// Get records
		$users_record = $this->Model_bpbj->getDataLainlain($rowno, $rowperpage, $nomutasi, $tgl_mutasi);
		// Pagination Configuration
		$config['base_url'] 				= base_url() . 'bpbj/lainlain';
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
		$data['nomutasi'] 	= $nomutasi;
		$data['tgl_mutasi']	= $tgl_mutasi;
		// Load view
		$this->template->load('template/template', 'lainlain/lainlain', $data);
	}

	function input_lainlain()
	{
		$this->Model_bpbj->insertlainlain();
	}
}
