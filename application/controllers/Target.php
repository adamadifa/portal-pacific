<?php

class Target extends CI_controller{

	function __construct(){
		parent::__construct();

		$this->load->model(array('Model_cabang','Model_target'));
	}

	function targettahun($rowno = 0){
		//error_reporting(0);
		// Search text
	    $cabang 	 = "";
	    $tahun  	 = "";
	    if($this->input->post('submit') != NULL ){
	      $cabang 	= $this->input->post('cabang');
	      $tahun 	= $this->input->post('tahun');

	      $data 	= array(

	      		'cabang_filter'	 	=> $cabang,
	      		'tahun'				=> $tahun

	      );

	     $this->session->set_userdata($data);
	    }else{
	     if($this->session->userdata('cabang_filter') != NULL){
	        $cabang = $this->session->userdata('cabang_filter');
	      }

	      if($this->session->userdata('tahun') != NULL){
	        $tahun = $this->session->userdata('tahun');
	      }


	    }

	    // Row per page
	    $rowperpage = 10;

	    // Row position
	    if($rowno != 0){
	      $rowno = ($rowno-1) * $rowperpage;
	    }

	    // All records count
	    $allcount 	  = $this->Model_target->getrecordTargettahunCount($cabang,$tahun);

	    // Get records
	    $users_record = $this->Model_target->getDataTargettahun($rowno,$rowperpage,$cabang,$tahun);



	    // Pagination Configuration
	    $config['base_url'] 		= base_url().'target/targettahun';
	    $config['use_page_numbers'] = TRUE;
	    $config['total_rows'] 		= $allcount;
	    $config['per_page'] 		= $rowperpage;

	    $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
	    // Initialize
	    $this->pagination->initialize($config);

	    $data['pagination'] = $this->pagination->create_links();
	    $data['result'] 	= $users_record;
	    $data['row'] 		= $rowno;
	    $data['cb'] 		= $cabang;
	    $data['tahun']		= $tahun;

		$data['cabang'] 	= $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template','target/view_targettahun',$data);
	}

	function targetbulan($rowno = 0){
		$cabang 	 = "";
	  $tahun  	 = "";
		$bulan 		 = "";

    if($this->input->post('submit') != NULL ){
      $cabang = $this->input->post('cabang');
      $tahun 	= $this->input->post('tahun');
	  	$bulan 	= $this->input->post('bulan');
      $data 	= array(
    		'cabang_filter'	=> $cabang,
    		'tahun'					=> $tahun,
				'bulan'					=> $bulan
      );
     	$this->session->set_userdata($data);
    }else{
     	if($this->session->userdata('cabang_filter') != NULL){
        $cabang = $this->session->userdata('cabang_filter');
      }
      if($this->session->userdata('tahun') != NULL){
        $tahun = $this->session->userdata('tahun');
      }
	  	if($this->session->userdata('bulan') != NULL){
        $bulan = $this->session->userdata('bulan');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    // All records count
    $allcount 	  = $this->Model_target->getrecordTargetbulanCount($cabang,$tahun,$bulan);
    // Get records
    $users_record = $this->Model_target->getDataTargetbulan($rowno,$rowperpage,$cabang,$tahun,$bulan);
    // Pagination Configuration
    $config['base_url'] 				= base_url().'target/targetbulan';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] 			= $allcount;
    $config['per_page'] 				= $rowperpage;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination'] 				= $this->pagination->create_links();
    $data['result'] 						= $users_record;
    $data['row'] 								= $rowno;
    $data['cb'] 								= $cabang;
    $data['tahun']							= $tahun;
		$data['bl']									= $bulan;
		$data['cabang'] 						= $this->Model_cabang->view_cabang()->result();
		$this->template->load('template/template','target/view_targetbulan',$data);
	}

	function loadbarang(){
		$cabang = $this->input->post('cabang');
		$brg 		= $this->Model_target->loadbarang($cabang)->result();
		echo "<option value=''>-- Pilih Barang --</option>";
		foreach ($brg as $b){
			echo "<option value='$b->kode_produk'>$b->nama_barang</option>";
		}
	}

	function insert_targettahun(){
		$this->Model_target->insert_targettahun();
	}

	function insert_targetbulan(){
		$this->Model_target->insert_targetbulan();
	}
	function hapus(){
		$id = $this->uri->segment(3);
		$this->Model_target->hapus($id);
		$this->session->set_flashdata('msg',
    '<div class="alert bg-green alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
      </div>');
   	redirect('target/targettahun');
	}

	function hapusbulan(){
		$id = $this->uri->segment(3);
		$this->Model_target->hapusbulan($id);
		$this->session->set_flashdata('msg',
    '<div class="alert bg-green alert-dismissible" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
      </div>');
   	redirect('target/targetbulan');
	}


	function insert_targettahuntemp(){
		$this->Model_target->insert_targettahuntemp();
	}

	function insert_targetbulantemp(){
		$this->Model_target->insert_targetbulantemp();
	}

	function view_targettahuntemp(){
		$data['targettahuntemp'] = $this->Model_target->view_targettahuntemp()->result();
	  $this->load->view('target/view_targettahuntemp',$data);
	}

	function view_targetbulantemp(){
		$data['targetbulantemp'] = $this->Model_target->view_targetbulantemp()->result();
    $this->load->view('target/view_targetbulantemp',$data);
	}

	function hapus_targettahuntemp(){
		$kodebarang = $this->input->post('kodebarang');
		$cabang 		= $this->input->post('cabang');
		$tahun 			= $this->input->post('tahun');
		echo $kodebarang;
		$this->Model_target->hapus_targettahuntemp($kodebarang,$cabang,$tahun);
	}

	function hapus_targetbulantemp(){
		$kodebarang = $this->input->post('kodebarang');
		$cabang 		= $this->input->post('cabang');
		$tahun 			= $this->input->post('tahun');
		$bulan 			= $this->input->post('bulan');
		echo $kodebarang;
		$this->Model_target->hapus_targetbulantemp($kodebarang,$cabang,$tahun,$bulan);
	}

	function cek_targettahuntemp(){
		$cabang		= $this->input->post('cabang');
		$tahun 		= $this->input->post('tahun');
		$cek 			= $this->db->get_where('target_pertahuncabangtemp',array('kode_cabang'=>$cabang,'tahun'=>$tahun));
		echo $cek->num_rows();
	}

	function cek_targetbulantemp(){
		$cabang		= $this->input->post('cabang');
		$bulan 		= $this->input->post('bulan');
		$tahun 		= $this->input->post('tahun');
		$cek 			= $this->db->get_where('target_bulancabangtemp',array('kode_cabang'=>$cabang,'tahun'=>$tahun,'bulan'=>$bulan));
		echo $cek->num_rows();
	}

	function hapus_all_targettahun(){
		$tahun 	= $this->uri->segment(3);
		$cabang = $this->uri->segment(4);
		$this->Model_target->hapus_all_targettahun($tahun,$cabang);
	}

	function detail_target_tahun(){
		$tahun 					= $this->input->post('tahun');
		$cabang					= $this->input->post('cabang');
		$data['tahun']  = $tahun;
		$data['cabang'] = $cabang;
		$data['detail'] = $this->Model_target->detail_target_tahun($tahun,$cabang)->result();
		$this->load->view('target/detail_target_tahun',$data);
	}

	function detail_target_bulan(){
		$tahun 					= $this->input->post('tahun');
		$bulan 					= $this->input->post('bulan');
		$cabang					= $this->input->post('cabang');
		$data['tahun']  = $tahun;
		$data['bulan']  = $bulan;
		$data['cabang'] = $cabang;
		$data['detail'] = $this->Model_target->detail_target_bulan($tahun,$cabang,$bulan)->result();
		$this->load->view('target/detail_target_bulan',$data);
	}


	function hapus_target_produk_tahun(){
		$id = $this->uri->segment(3);
		$this->Model_target->hapus_target_produk_tahun($id);
	}

	function hapus_target_produk_bulan(){
		$id = $this->uri->segment(3);
		$this->Model_target->hapus_target_produk_bulan($id);
	}



}
