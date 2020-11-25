<?php

class Diskon extends CI_Controller{

	function __construct(){
		parent::__construct();

		$this->load->model('Model_diskon');
	}
	function view_diskon(){
		$id 				 = $this->uri->segment(3);
		$data['getdiskon']	 = $this->Model_diskon->getDiskon($id)->row_array();
		$data['diskon']  	 = $this->Model_diskon->view_diskon();
		$this->template->load('template/template','diskon/view_diskon',$data);
	}

	function insert_diskon(){

		$this->Model_diskon->insertdiskon();
		$this->session->set_flashdata('msg',
	        '<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
	          </div>');
	       redirect('diskon/view_diskon');

	}

	function hapus(){

		$id = $this->uri->segment(3);
		$this->Model_diskon->hapus($id);
		$this->session->set_flashdata('msg',
	        '<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
	          </div>');
	       redirect('diskon/view_diskon');

	}



}