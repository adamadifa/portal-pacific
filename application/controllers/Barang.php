<?php

class Barang extends CI_Controller{
	function __construct(){
		parent::__construct();
		 check_login();
		$this->load->model(array('Model_barang','Model_cabang'));
	}

	function view_api(){
		$this->template->load('template/template', 'template/test');
	}

	function view_barang(){
		$data['leveluser']		= $this->session->userdata('level_user');
		$data['barang'] 		= $this->Model_barang->view_barang()->result();
		$this->template->load('template/template','barang/view_barang',$data);
	}

	function view_barangcab(){
		$kodecabang 	= $this->input->post('kodecabang');
		$data['barang'] = $this->Model_barang->view_barangcab($kodecabang)->result();
		$this->load->view('penjualan/view_barang',$data);
	}

	function view_barangcabgb(){
		$kodecabang 	= $this->input->post('kodecabang');
		$data['barang'] = $this->Model_barang->view_barangcab($kodecabang)->result();
		$this->load->view('penjualan/view_baranggb',$data);
	}

	function input_barang(){
		if(isset($_POST['submit'])){
			$this->Model_barang->insert_barang();
			$this->session->set_flashdata('msg',
	        '<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
	          </div>');
	       redirect('barang/view_barang');
		}else{
			$data['cabang'] = $this->Model_cabang->view_cabang()->result();
			$this->load->view('barang/input_barang',$data);
		}
	}


	function edit_barang(){
		$id 			= $this->uri->segment(3);
		$data['getbrg'] = $this->Model_barang->get_barang($id)->row_array();

		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->load->view('barang/edit_barang',$data);

	}

	function detail_barang(){
		$id 			= $this->uri->segment(3);
		$data['getbrg'] = $this->Model_barang->get_barang($id)->row_array();

		$data['cabang'] = $this->Model_cabang->view_cabang()->result();
		$this->load->view('barang/detail_barang',$data);

	}

	function hapus(){

		$kodebarang = $this->uri->segment(3);
		$this->Model_barang->hapus($kodebarang);
		$this->session->set_flashdata('msg',
	        '<div class="alert bg-green alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
	          </div>');
	       redirect('barang/view_barang');

	}

	function view_barangcab_gj(){
		$kodecabang 	= $this->input->post('kodecabang');
		$data['barang'] = $this->Model_barang->view_barangcab($kodecabang)->result();
		$this->load->view('penjualan/view_barangcab_gj',$data);
	}

	function view_barangcab_gjbs(){
		$kodecabang 	= $this->input->post('kodecabang');
		$data['barang'] = $this->Model_barang->view_barangcab($kodecabang)->result();
		$this->load->view('repackreject/view_barangcab_gj',$data);
	}


}
