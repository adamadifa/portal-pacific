<?php

class Setting extends CI_Controller{
	function __construct(){
		parent::__construct();
		check_login();
		$this->load->model(array('Model_setting'));
	}
	function ubah_password(){

		if(isset($_POST['submit'])){
			$this->load->model('Model_auth');
			$id_user=$this->session->userdata('id_user');
			$this->Model_auth->update_password($id_user);
		}else{
			$this->template->load('template/template','setting/ubah_password');
		}		
	}

	function tutuplaporan($rowno=0){
		// Search text
		$tahun = date("Y");
		if($this->input->post('submit') != NULL ){
			$tahun 		= $this->input->post('tahun');
			$data 	= array(
				'tahun'	 => $tahun
			);
			$this->session->set_userdata($data);
		}else{
			if($this->session->userdata('tahun') != NULL){
				$tahun = $this->session->userdata('tahun');
			}
		}
		$data['tahun'] = $tahun;
		$data['bulan'] = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$data['tutuplaporan'] = $this->Model_setting->getDataTutupLaporan($tahun)->result();
		$this->template->load('template/template','setting/tutuplaporan',$data);
	}

	function input_tutuplaporan()
	{
		$data['bulan']		= array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$this->load->view('setting/input_tutuplaporan',$data);
	}

	function inserttutuplaporan()
	{
		$this->Model_setting->inserttutuplaporan();
	}

	function bukalaporan()
	{
		$kodelaporan = $this->uri->segment(3);
		$this->Model_setting->bukalaporan($kodelaporan);
	}

	function tutup()
	{
		$kodelaporan = $this->uri->segment(3);
		$this->Model_setting->tutuplaporan($kodelaporan);
	}

	function cektutuplaporan()
	{
		$tanggal = $this->input->post('tanggal');
		$jenis = $this->input->post('jenis');
		$cek = $this->Model_setting->cektutuplaporan($tanggal,$jenis)->num_rows();
		echo $cek;

	}


}