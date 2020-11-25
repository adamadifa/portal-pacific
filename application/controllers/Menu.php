<?php

class Menu extends CI_Controller{

	function __construct(){
		parent::__construct();
		check_login();
		$this->load->model('Model_menu');
	}

	function index(){
		$id 			 = $this->uri->segment(3);
		$data['getmenu'] = $this->Model_menu->get_menu($id)->row_array();
		$data['parent']  = $this->Model_menu->get_Menuparent()->result();
		$data['menu'] 	 = $this->Model_menu->view_menu()->result();
		
		$this->template->load('template/template','menu/view_menu',$data);

	}

	function hapus(){

		$id 	= $this->uri->segment(3);
		$hapus  = $this->Model_menu->hapus($id);
		$this->session->set_flashdata('msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
          </div>');
       redirect('menu');
	}


	function insert_menu(){

		$this->Model_menu->insert_menu();
		$this->session->set_flashdata('msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
          </div>');
       redirect('menu');



	}



}