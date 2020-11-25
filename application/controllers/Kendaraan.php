<?php

class Kendaraan extends CI_Controller{
	function __construct(){
		parent::__construct();
		 check_login();
		$this->load->model(array('Model_kendaraan','Model_cabang'));
	}

	function index(){
		$data['leveluser']		= $this->session->userdata('level_user');
		$data['kendaraan'] 		= $this->Model_kendaraan->view_kendaraan()->result();
		$this->template->load('template/template','kendaraan/view_kendaraan',$data);
	}

	function input_kendaraan(){
		if(isset($_POST['submit'])){
			$this->Model_kendaraan->insert_kendaraan();
			$this->session->set_flashdata('msg',
	        '<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
	          </div>');
	       redirect('kendaraan');
		}else{
			$data['cabang'] = $this->Model_cabang->view_cabang()->result();
			$this->template->load('template/template','kendaraan/input_kendaraan',$data);
		}
	}

	function edit_kendaraan()
	{
		$id 			= $this->uri->segment(3);
		if (isset($_POST['submit'])) {
			$this->Model_kendaraan->insert_kendaraan();
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
	          </div>'
			);
			redirect('kendaraan');
		} else {
			$data['getdata'] = $this->Model_kendaraan->get_kendaraan($id)->row_array();
			$data['cabang'] = $this->Model_cabang->view_cabang()->result();
			$this->template->load('template/template', 'kendaraan/edit_kendaraan', $data);
		}
	}

	function detail_kendaraan(){
		$id                 = $this->uri->segment(3);
		$data['getdata']    = $this->Model_kendaraan->get_kendaraan($id)->row_array();
		$data['cabang']     = $this->Model_cabang->view_cabang()->result();
		$this->load->view('kendaraan/detail_kendaraan',$data);

	}

	function hapus(){

		$kodekendaraan = $this->uri->segment(3);
		$this->Model_kendaraan->hapus($kodekendaraan);
		$this->session->set_flashdata('msg',
	        '<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
	          </div>');
	       redirect('kendaraan');

	}

	function view_kendaraancab_gj(){
		$kodecabang           = $this->input->post('kodecabang');
		$data['kendaraan']    = $this->Model_kendaraan->view_kendaraancab($kodecabang)->result();
		$this->load->view('penjualan/view_kendaraancab_gj',$data);
	}

	function view_kendaraancab_gjbs(){
		$kodecabang           = $this->input->post('kodecabang');
		$data['kendaraan']    = $this->Model_kendaraan->view_kendaraancab($kodecabang)->result();
		$this->load->view('repackreject/view_kendaraancab_gj',$data);
	}


}
