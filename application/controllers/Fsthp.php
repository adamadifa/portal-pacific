<?php

class Fsthp extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model(array('Model_oman','Model_fsthp'));
	}


	function view_fsthp($rowno=0){
		// Search text
	    $nomutasi 	 = "";
	    $tgl_mutasi  = "";
	    if($this->input->post('submit') != NULL ){
	      $nomutasi 		= $this->input->post('no_mutasi');
	      $tgl_mutasi 	= $this->input->post('tgl_mutasi');
	      $data 				= array(
										      		'nomutasi'	 	=> $nomutasi,
										      		'tgl_mutasi'	=> $tgl_mutasi

	      										);
	     $this->session->set_userdata($data);
	    }else{
	     if($this->session->userdata('nomutasi') != NULL){
	        $nomutasi = $this->session->userdata('nomutasi');
	      }
	      if($this->session->userdata('tgl_mutasi') != NULL){
	        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
	      }
	    }

	    // Row per page
	    $rowperpage = 10;
	    // Row position
	    if($rowno != 0){
	      $rowno 	= ($rowno-1) * $rowperpage;
	    }

	    // All records count
	    $allcount 	  = $this->Model_fsthp->getrecordFsthpCount($nomutasi,$tgl_mutasi);


	    // Get records
	    $users_record = $this->Model_fsthp->getDataFsthp($rowno,$rowperpage,$nomutasi,$tgl_mutasi);


	    // Pagination Configuration
	    $config['base_url'] 				= base_url().'fsthp/view_fsthp';
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
	    $data['nomutasi'] 					= $nomutasi;
	    $data['tgl_mutasi']					= $tgl_mutasi;
	    // Load view
		 $this->template->load('template/template','fsthp/view_fsthp',$data);

	}

	function input_fsthp(){
		if(isset($_POST['submit'])){
			$this->Model_fsthp->insert_fsthp();
		}else{
			$this->template->load('template/template','fsthp/input_fsthp');
		}
	}



	function view_barang(){
		$data['produk'] = $this->Model_oman->listproduk()->result();
		$this->load->view('fsthp/view_barang',$data);
	}

	function view_detailfsthp_temp(){

		$id_admin 			= $this->session->userdata('id_user');
		$inout 				= 'OUT';
		$kode_produk		= $this->uri->segment(3);
		$data['detail'] 	= $this->Model_fsthp->view_detailfsthp_temp($id_admin,$inout,$kode_produk)->result();
		$this->load->view('fsthp/view_detailfsthp_temp',$data);
	}

	function insert_detailtmp(){
		$cek 	= $this->Model_fsthp->cek_detailtmpfsthp()->num_rows();
		$cek2	= $this->Model_fsthp->cek_detailtmp()->num_rows();
		if($cek !=0){
			echo "1";
		}else if($cek2 !=0){
			echo "2";
		}else{
			$this->Model_fsthp->insert_detailtmp();
		}
	}



	function buat_nomor_fsthp(){
		$tgl_fsthp 		= $this->input->post('tgl_fsthp');
		$kode_produk	= $this->input->post('kode_produk');
		$fsthp 				= $this->Model_fsthp->getNoFsthpLast($kode_produk,$tgl_fsthp)->row_array();
		$b 						= array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
		$tanggal 			= explode("-",$tgl_fsthp);
		$hari 				= $tanggal[2];
		$bulan 				= $tanggal[1];

		if($bulan>9){
			$bl = $bulan;
		}else{
			$bl = substr($bulan,1,1);
		}

		//echo $bl;

		$tahun 			= $tanggal[0];
		$tgl 				= "/".$hari."/".$b[$bl]."/".$tahun;
		$nomor_terakhir	= $fsthp['no_fsthp'];
		$no_bpbj 		= buatkode($nomor_terakhir,"F".$kode_produk,2).$tgl;
		echo $no_bpbj;



	}


	function detail_mutasi(){

		$nomutasi 			= $this->input->post('nomutasi');
		$data['mutasi']	= $this->Model_fsthp->getMutasi($nomutasi)->row_array();
		$data['detail']	= $this->Model_fsthp->detail_mutasi($nomutasi)->result();
		$this->load->view('fsthp/detail_mutasi',$data);
	}


	function view_fsthp_gj($rowno=0){

		// Search text
	    $nomutasi 	 = "";
	    $tgl_mutasi  = "";
	    if($this->input->post('submit') != NULL ){
	      $nomutasi 		= $this->input->post('no_mutasi');
	      $tgl_mutasi 	= $this->input->post('tgl_mutasi');
	      $data 				= array(
							      		'nomutasi'	 	=> $nomutasi,
							      		'tgl_mutasi'	=> $tgl_mutasi
	      							);
	     $this->session->set_userdata($data);
	    }else{
	     if($this->session->userdata('nomutasi') != NULL){
	        $nomutasi = $this->session->userdata('nomutasi');
	      }

	      if($this->session->userdata('tgl_mutasi') != NULL){
	        $tgl_mutasi = $this->session->userdata('tgl_mutasi');
	      }


	    }

	    // Row per page
	    $rowperpage = 10;

	    // Row position
	    if($rowno != 0){
	      $rowno = ($rowno-1) * $rowperpage;
	    }

	    // All records count
	    $allcount 	  = $this->Model_fsthp->getrecordFsthpCount($nomutasi,$tgl_mutasi);

	    // Get records
	    $users_record = $this->Model_fsthp->getDataFsthp($rowno,$rowperpage,$nomutasi,$tgl_mutasi);



	    // Pagination Configuration
	    $config['base_url'] 		= base_url().'fsthp/view_fsthp_gj';
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
	    $data['nomutasi'] 	= $nomutasi;
	    $data['tgl_mutasi']	= $tgl_mutasi;

	    // Load view

		$this->template->load('template/template','fsthp/view_fsthp_gj',$data);

	}


	function hapus(){

		$no_mutasi = $this->uri->segment(3)."/".$this->uri->segment(4)."/".$this->uri->segment(5)."/".$this->uri->segment(6);
		$hal 			 = $this->uri->segment(7);
		$this->Model_fsthp->hapus($no_mutasi,$hal);
	}

	function approve_fsthp(){

		$no_fsthp = $this->uri->segment(3)."/".$this->uri->segment(4)."/".$this->uri->segment(5)."/".$this->uri->segment(6);
		$this->Model_fsthp->approve_fsthp($no_fsthp);

	}

	function cancel_fsthp(){

		$no_fsthp = $this->uri->segment(3)."/".$this->uri->segment(4)."/".$this->uri->segment(5)."/".$this->uri->segment(6);
		$hal 			= $this->uri->segment(7);
		echo $hal;
		//die;
		$this->Model_fsthp->cancel_fsthp($no_fsthp,$hal);
	}

	function hapus_detailfsthptmp(){

		$kode_produk 	= $this->input->post('kode_produk');
		$shift 			= $this->input->post('shift');
		$id_admin 		= $this->session->userdata('id_user');
		$this->Model_fsthp->hapus_detailfsthptmp($kode_produk,$id_admin,$shift);
	}
}
