<?php

class Cabang extends CI_Controller{
	function __construct(){
		parent::__construct();
		 check_login();
		$this->load->model('Model_cabang');
	}
	function view_cabang(){
		$kodecabang 		= $this->uri->segment(3);
		$data['getcabang']	= $this->Model_cabang->get_cabang($kodecabang)->row_array();
		$data['cabang'] 	= $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template','cabang/view_cabang',$data);
	}

	function insert_cabang(){

		$this->Model_cabang->insert_cabang();
		$this->session->set_flashdata('msg',
		    '<div class="alert bg-green alert-dismissible" role="alert">
		          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		             <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
		      </div>');
		  redirect('cabang/view_cabang');

	}

	function hapus(){

		$kodecabang = $this->uri->segment(3);
		$this->Model_cabang->hapus($kodecabang);
		$this->session->set_flashdata('msg',
		    '<div class="alert bg-green alert-dismissible" role="alert">
		          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		             <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
		      </div>');
		  redirect('cabang/view_cabang');
	}

}
