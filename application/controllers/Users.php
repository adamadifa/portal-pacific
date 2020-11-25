<?php

class Users extends CI_Controller{
	function __construct(){
		parent::__construct();
   check_login();
   $this->load->model(array('Model_users','Model_cabang'));
 }
 function view_users(){
  $kodeusers 		= $this->uri->segment(3);
  $data['getusers']	= $this->Model_users->get_users($kodeusers)->row_array();
  $data['users'] 	= $this->Model_users->view_users()->result();
  $data['cabang'] 	= $this->Model_cabang->view_cabang()->result();
  $this->template->load('template/template','users/view_users',$data);
}

function insert_users(){

  $this->Model_users->insert_users();
  $this->session->set_flashdata('msg',
    '<div class="alert bg-green alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
    </div>');
  redirect('users/view_users');

}

function hapus(){

  $kodeusers = $this->uri->segment(3);
  $this->Model_users->hapus($kodeusers);
  $this->session->set_flashdata('msg',
    '<div class="alert bg-green alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
    </div>');
  redirect('users/view_users');
}

}
