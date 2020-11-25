<?php

class Kategoribarang extends CI_Controller{

	function __construct(){
		parent::__construct();

		$this->load->model('Model_kategoribarang');
	}
	function view_kategori(){
		$id 				 = $this->uri->segment(3);
		$data['getkategori']	 = $this->Model_kategoribarang->getkategori($id)->row_array();
		$data['kategori']  	 	 = $this->Model_kategoribarang->view_kategori();
		$this->template->load('template/template','kategoribarang/view_kategori',$data);
	}

	function insert_kategori(){

		$this->Model_kategoribarang->insertkategori();
		$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
			</div>');
		redirect('Kategoribarang/view_kategori');

	}

	function hapus(){

		$id = $this->uri->segment(3);
		$this->Model_kategoribarang->hapus($id);
		$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
			</div>');
		redirect('Kategoribarang/view_kategori');

	}



}