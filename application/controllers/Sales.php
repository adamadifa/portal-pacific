<?php

class Sales extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->model(array('Model_sales', 'Model_cabang'));
	}

	function view_sales()
	{
		$id_karyawan 		= $this->uri->segment(3);
		$data['getsales']	= $this->Model_sales->get_sales($id_karyawan)->row_array();
		$data['cabang'] 	= $this->Model_cabang->view_cabang()->result();
		$data['sales']  	= $this->Model_sales->view_sales()->result();
		$this->template->load('template/template', 'sales/view_sales', $data);
	}

	function insert_sales()
	{

		$this->Model_sales->insert_sales();
		$this->session->set_flashdata(
			'msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
	          </div>'
		);
		redirect('sales/view_sales');
	}

	function hapus()
	{

		$id_karyawan = $this->uri->segment(3);
		$this->Model_sales->hapus($id_karyawan);
		$this->session->set_flashdata(
			'msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
	          </div>'
		);
		redirect('sales/view_sales');
	}

	function inputsales()
	{
		$id_karyawan 			= $this->uri->segment(3);
		$data['getsales']	= $this->Model_sales->get_sales($id_karyawan)->row_array();
		$data['cabang'] 	= $this->Model_cabang->view_cabang()->result();
		$this->load->view('sales/inputsales',$data);
	}
}
