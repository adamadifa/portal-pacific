<?php

class Coa extends CI_Controller{

  function __construct(){
    parent::__construct();
     check_login();
    $this->load->model(array('Model_coa','Model_cabang'));
  }
  function index(){
    $data['coa'] = $this->Model_coa->view_coa()->result();
    $this->template->load('template/template','coa/view_coa',$data);
  }

  function input_coa(){
    if(isset($_POST['submit'])){
      $this->Model_coa->insert_coa();
    }else{
      $data['coa'] = $this->Model_coa->view_coa()->result();
      $this->load->view('coa/input_coa',$data);
    }
  }

  function hapus(){
    $id = $this->uri->segment(3);
    $this->Model_coa->hapus($id);
  }

  function edit_coa(){
    $kode_akun    = $this->input->post('kode_akun');
    $data['coa']  = $this->Model_coa->view_coa()->result();
    $data['akun'] = $this->Model_coa->get_coa($kode_akun)->row_array();
    $this->load->view('coa/edit_coa',$data);
  }

  function setcoacabang(){
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['coa']    = $this->Model_coa->view_coaall()->result();
    $this->template->load('template/template','coa/set_coacabang',$data);
  }

  function loadsetcoa(){
    $cabang     = $this->input->post('cabang');
    $kategori   = $this->input->post('kategori');
    $data['setcoa'] = $this->Model_coa->view_set_coa_cabang($cabang,$kategori)->result();
    $this->load->view('coa/loadsetcoa',$data);
  }

  function input_set_coa_cabang(){
    $this->Model_coa->input_set_coa_cabang();
  }

  function hapus_setcoa(){
    $id = $this->input->post('id');
    $this->Model_coa->hapus_setcoa($id);
  }



}
