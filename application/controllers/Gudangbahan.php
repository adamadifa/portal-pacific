<?php

class Gudangbahan extends CI_Controller{
	function __construct(){
		parent::__construct();
		check_login();
		$this->load->model(array('Model_gudangbahan'));
	}

	function pembelian($rowno=0){
    	// Search text
		$nobukti 	        = "";
		$tgl_pembelian    = "";
		$departemen       = "";
		$supplier         = "";
		$role = $this->session->userdata('level_user');
		if($role=='admin pajak'){
			$ppn = "1";
		}else{
			$ppn = "";
		}

    	// echo $ppn;
    	//
    	// die;
		$ln               = "";
		if($this->input->post('submit') != NULL ){
			$nobukti 	             = $this->input->post('nobukti');
			$tgl_pembelian         = $this->input->post('tgl_pembelian');
			$departemen            = $this->input->post('departemen');
			$supplier              = $this->input->post('supplier');
			$ppn                   = $this->input->post('ppn');
			$ln                    = $this->input->post('ln');
			$data 	= array(
				'nobukti'	 	           => $nobukti,
				'tgl_pembelian'	       => $tgl_pembelian,
				'departemen'           => $departemen,
				'supplier'             => $supplier,
				'ppn'                  => $ppn,
				'ln'                   => $ln
			);
			$this->session->set_userdata($data);
		}else{
			if($this->session->userdata('nobukti') != NULL){
				$nobukti = $this->session->userdata('nobukti');
			}
			if($this->session->userdata('tgl_pembelian') != NULL){
				$tgl_pembelian = $this->session->userdata('tgl_pembelian');
			}
			if($this->session->userdata('departemen') != NULL){
				$departemen = $this->session->userdata('departemen');
			}

			if($this->session->userdata('supplier') != NULL){
				$supplier = $this->session->userdata('supplier');
			}
			if($this->session->userdata('ppn') != NULL){
				$ppn = $this->session->userdata('ppn');
			}

			if($this->session->userdata('ln') != NULL){
				$ln = $this->session->userdata('ln');
			}
		}
    	// Row per page
		$rowperpage = 10;
    	// Row position
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
    	// All records count
		$allcount 	  = $this->Model_gudangbahan->getrecordPembelianCount($nobukti,$tgl_pembelian,$departemen,$ppn,$ln,$supplier);
    	// Get records
		$users_record = $this->Model_gudangbahan->getDataPembelian($rowno,$rowperpage,$nobukti,$tgl_pembelian,$departemen,$ppn,$ln,$supplier);
    	// Pagination Configuration
		$config['base_url'] 			    = base_url().'gudangbahan/pembelian';
		$config['use_page_numbers'] 	= TRUE;
		$config['total_rows'] 			  = $allcount;
		$config['per_page'] 			    = $rowperpage;
		$config['first_link']       	= 'First';
		$config['last_link']        	= 'Last';
		$config['next_link']        	= 'Next';
		$config['prev_link']        	= 'Prev';
		$config['full_tag_open']    	= '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   	= '</ul></nav></div>';
		$config['num_tag_open']     	= '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    	= '</span></li>';
		$config['cur_tag_open']     	= '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    	= '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    	= '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  	= '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    	= '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  	= '</span>Next</li>';
		$config['first_tag_open']   	= '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] 	= '</span></li>';
		$config['last_tag_open']    	= '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  	= '</span></li>';
    	// Initialize
		$this->pagination->initialize($config);
		$data['pagination']           	= $this->pagination->create_links();
		$data['result'] 		      	= $users_record;
		$data['row'] 			  	  	= $rowno;
		$data['nobukti'] 	          	= $nobukti;
		$data['tgl_pembelian']	      	= $tgl_pembelian;
		$data['departemen']	          	= $departemen;
		$data['ppn']                  	= $ppn;
		$data['ln']                   	= $ln;
		$data['dept']                 	= $this->Model_gudangbahan->getPemohon()->result();
		$data['supp']                 	= $this->Model_gudangbahan->listSupplier()->result();
		$data['supplier']             	= $supplier;
    	//echo $data['cb'];
		$this->template->load('template/template','gudangbahan/pembelian',$data);
	}

	function detail_pembelian(){
		$nobukti            = $this->input->post('nobukti');
		$data['pmb']        = $this->Model_gudangbahan->getPembelian($nobukti)->row_array();
		$data['detail']     = $this->Model_gudangbahan->getDetailPembelian($nobukti)->result();
		$pmbpnj             = $this->Model_gudangbahan->getDetailPnjPembelian($nobukti);
		$data['cekpnj']     = $pmbpnj->num_rows();
		$data['pmbpnj']     = $pmbpnj->result();
		$data['kb']         = $this->Model_gudangbahan->listKontraBonPMB($nobukti)->result();

		$this->load->view('gudangbahan/detail_pembelian',$data);
	}


  function inputsaldoawal_retur(){

    $data['barang']    = $this->Model_gudangbahan->listproduk()->result();
    $data['tahun']     = date("Y");
    $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['kategori']  = $this->Model_gudangbahan->getKategori()->result();
    $this->template->load('template/template','gudangbahan/inputsaldoawal_retur',$data);
  }

  function inputsaldoawal(){

    $data['barang']    = $this->Model_gudangbahan->listproduk()->result();
    $data['tahun']     = date("Y");
    $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['kategori']  = $this->Model_gudangbahan->getKategori()->result();
    $this->template->load('template/template','gudangbahan/inputsaldoawal',$data);
  }


  function codeotomatisretur(){

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(retur_gb.nobukti_retur,3) as kode ',false);
    $this->db->where('mid(nobukti_retur,5,2)',$bulan);
    $this->db->where('mid(nobukti_retur,7,2)',$tahun);
    $this->db->order_by('nobukti_retur', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('retur_gb');
    if($query->num_rows()<>0){
      $data   = $query->row();
      $kode   = intval($data->kode)+1;
    }else{
      $kode   = 1;
    }
    $kodemax  = str_pad($kode,3,"0",STR_PAD_LEFT);
    $kodejadi   = "GBR/".$bulan."".$tahun."/".$kodemax;
    echo $kodejadi;

  } 


  function codeotomatis(){

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pengeluaran_gb.nobukti_pengeluaran,3) as kode ',false);
    $this->db->where('mid(nobukti_pengeluaran,5,2)',$bulan);
    $this->db->where('mid(nobukti_pengeluaran,7,2)',$tahun);
    $this->db->order_by('nobukti_pengeluaran', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pengeluaran_gb');
    if($query->num_rows()<>0){
      $data   = $query->row();
      $kode   = intval($data->kode)+1;
    }else{
      $kode   = 1;
    }
    $kodemax  = str_pad($kode,3,"0",STR_PAD_LEFT);
    $kodejadi   = "GBK/".$bulan."".$tahun."/".$kodemax;
    echo $kodejadi;

  } 


  function inputopname(){

    $data['barang']    = $this->Model_gudangbahan->listproduk()->result();
    $data['tahun']     = date("Y");
    $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['kategori']  = $this->Model_gudangbahan->getKategori()->result();
    $this->template->load('template/template','gudangbahan/inputopname',$data);
  }


  function getdetailsaldoretur(){

    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $ceksaldo       = $this->Model_gudangbahan->ceksaldoretur($bulan,$tahun)->num_rows();
    $cekall         = $this->Model_gudangbahan->ceksaldoallretur()->num_rows();
    $data['cek']    = $ceksaldo;
    $ceknow         = $this->Model_gudangbahan->ceksaldoSkrgretur($bulan,$tahun)->num_rows();
    if(empty($ceksaldo) && !empty($cekall) || !empty($ceknow))
    {
      echo "1";
    }else{
      $data['detail'] = $this->Model_gudangbahan->getdetailsaldoretur($bulan,$tahun)->result();
      $this->load->view('gudangbahan/getsaldo_retur',$data);
    }

  }

  function getdetailsaldo(){

    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $ceksaldo       = $this->Model_gudangbahan->ceksaldo($bulan,$tahun)->num_rows();
    $cekall         = $this->Model_gudangbahan->ceksaldoall()->num_rows();
    $data['cek']    = $ceksaldo;
    $ceknow         = $this->Model_gudangbahan->ceksaldoSkrg($bulan,$tahun)->num_rows();
    if(empty($ceksaldo) && !empty($cekall) || !empty($ceknow))
    {
      echo "1";
    }else{
      $data['detail'] = $this->Model_gudangbahan->getdetailsaldo($bulan,$tahun)->result();
      $this->load->view('gudangbahan/getsaldo',$data);
    }

  }

  function getdetailopname(){

    $bulan          = $this->input->post('bulan');
    $tahun          = $this->input->post('tahun');
    $cekopname      = $this->Model_gudangbahan->cekopname($bulan,$tahun)->num_rows();
    $cekall         = $this->Model_gudangbahan->cekopnameall()->num_rows();
    $data['cek']    = $cekopname;
    $ceknow         = $this->Model_gudangbahan->cekopnameSkrg($bulan,$tahun)->num_rows();
    if(empty($cekopname) && !empty($cekall) || !empty($ceknow))
    {
      echo "1";
    }else{
      $data['detail'] = $this->Model_gudangbahan->getDetailopname($bulan,$tahun)->result();
      $this->load->view('gudangbahan/getopname',$data);
    }

  }

  function editdetailsaldoawal_retur(){

    $this->Model_gudangbahan->editdetailsaldoawal_retur();
  }

  function editdetailsaldoawal(){

    $this->Model_gudangbahan->editdetailsaldoawal();
  }

  function input_saldoawal(){

    $this->Model_gudangbahan->insert_saldoawal();
  }

  function input_saldoawal_retur(){

    $this->Model_gudangbahan->insert_saldoawal_retur();
  }

  function input_opname(){

    $this->Model_gudangbahan->insert_opname();
  }


  function opname($rowno=0){

    $kode_opname_gb 	      = "";
    $tanggal                = "";

    if($this->input->post('submit') != NULL ){
      $kode_opname_gb 	       = $this->input->post('kode_opname_gb');
      $tanggal                 = $this->input->post('tanggal');
      $data 	= array(
        'kode_opname_gb'	 	   => $kode_opname_gb,
        'tanggal'	             => $tanggal,
      );
      $this->session->set_userdata($data);

    }else{

      if($this->session->userdata('kode_opname_gb') != NULL){
        $kode_opname_gb = $this->session->userdata('kode_opname_gb');
      }

      if($this->session->userdata('tanggal') != NULL){
        $tanggal = $this->session->userdata('tanggal');
      }

    }
    $rowperpage = 10;
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    $allcount 	                  = $this->Model_gudangbahan->getrecordopnameCount($kode_opname_gb,$tanggal);
    $users_record                 = $this->Model_gudangbahan->getDataopname($rowno,$rowperpage,$kode_opname_gb,$tanggal);
    $config['base_url'] 			    = base_url().'gudangbahan/pemasukan';
    $config['use_page_numbers'] 	= TRUE;
    $config['total_rows'] 			  = $allcount;
    $config['per_page'] 			    = $rowperpage;
    $config['first_link']       	= 'First';
    $config['last_link']        	= 'Last';
    $config['next_link']        	= 'Next';
    $config['prev_link']        	= 'Prev';
    $config['full_tag_open']    	= '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   	= '</ul></nav></div>';
    $config['num_tag_open']     	= '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    	= '</span></li>';
    $config['cur_tag_open']     	= '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    	= '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  	= '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  	= '</span>Next</li>';
    $config['first_tag_open']   	= '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] 	= '</span></li>';
    $config['last_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  	= '</span></li>';
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result'] 		          = $users_record;
    $data['row'] 			            = $rowno;
    $data['kode_opname_gb'] 	   = $kode_opname_gb;
    $data['tanggal']	            = $tanggal;
    $this->template->load('template/template','gudangbahan/opname',$data);

  }

  function saldoawal($rowno=0){

    $kode_saldoawal_gb      = "";
    $tanggal                = "";

    if($this->input->post('submit') != NULL ){
      $kode_saldoawal_gb       = $this->input->post('kode_saldoawal_gb');
      $tanggal                 = $this->input->post('tanggal');
      $data   = array(
        'kode_saldoawal_gb'    => $kode_saldoawal_gb,
        'tanggal'              => $tanggal,
      );
      $this->session->set_userdata($data);

    }else{

      if($this->session->userdata('kode_saldoawal_gb') != NULL){
        $kode_saldoawal_gb = $this->session->userdata('kode_saldoawal_gb');
      }

      if($this->session->userdata('tanggal') != NULL){
        $tanggal = $this->session->userdata('tanggal');
      }

    }
    $rowperpage = 10;
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudangbahan->getrecordSaldoawalnCount($kode_saldoawal_gb,$tanggal);
    $users_record                 = $this->Model_gudangbahan->getDataSaldoawal($rowno,$rowperpage,$kode_saldoawal_gb,$tanggal);
    $config['base_url']           = base_url().'gudangbahan/saldoawal';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']         = $allcount;
    $config['per_page']           = $rowperpage;
    $config['first_link']         = 'First';
    $config['last_link']          = 'Last';
    $config['next_link']          = 'Next';
    $config['prev_link']          = 'Prev';
    $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']     = '</ul></nav></div>';
    $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']      = '</span></li>';
    $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']    = '</span>Next</li>';
    $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close']   = '</span></li>';
    $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']    = '</span></li>';
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                  = $rowno;
    $data['kode_saldoawal_gb']    = $kode_saldoawal_gb;
    $data['tanggal']              = $tanggal;
    $this->template->load('template/template','gudangbahan/saldoawal',$data);

  }


  function saldoawal_retur($rowno=0){

    $kode_saldoawal_gb      = "";
    $tanggal                = "";

    if($this->input->post('submit') != NULL ){
      $kode_saldoawal_gb       = $this->input->post('kode_saldoawal_gb');
      $tanggal                 = $this->input->post('tanggal');
      $data   = array(
        'kode_saldoawal_gb'    => $kode_saldoawal_gb,
        'tanggal'              => $tanggal,
      );
      $this->session->set_userdata($data);

    }else{

      if($this->session->userdata('kode_saldoawal_gb') != NULL){
        $kode_saldoawal_gb = $this->session->userdata('kode_saldoawal_gb');
      }

      if($this->session->userdata('tanggal') != NULL){
        $tanggal = $this->session->userdata('tanggal');
      }

    }
    $rowperpage = 10;
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudangbahan->getrecordSaldoawalnCountRetur($kode_saldoawal_gb,$tanggal);
    $users_record                 = $this->Model_gudangbahan->getDataSaldoawalRetur($rowno,$rowperpage,$kode_saldoawal_gb,$tanggal);
    $config['base_url']           = base_url().'gudangbahan/saldoawal_retur';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']         = $allcount;
    $config['per_page']           = $rowperpage;
    $config['first_link']         = 'First';
    $config['last_link']          = 'Last';
    $config['next_link']          = 'Next';
    $config['prev_link']          = 'Prev';
    $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']     = '</ul></nav></div>';
    $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']      = '</span></li>';
    $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']    = '</span>Next</li>';
    $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close']   = '</span></li>';
    $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']    = '</span></li>';
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                  = $rowno;
    $data['kode_saldoawal_gb']    = $kode_saldoawal_gb;
    $data['tanggal']              = $tanggal;
    $this->template->load('template/template','gudangbahan/saldoawal_retur',$data);

  }


  function retur($rowno=0){

    $nobukti          = "";
    $tgl_retur        = "";

    if($this->input->post('submit') != NULL ){
      $nobukti                 = $this->input->post('nobukti');
      $tgl_retur               = $this->input->post('tgl_retur');
      $data   = array(
        'nobukti'               => $nobukti,
        'tgl_retur'             => $tgl_retur,
      );
      $this->session->set_userdata($data);

    }else{

      if($this->session->userdata('nobukti') != NULL){
        $nobukti = $this->session->userdata('nobukti');
      }

      if($this->session->userdata('tgl_retur') != NULL){
        $tgl_retur = $this->session->userdata('tgl_retur');
      }

    }
    $rowperpage = 10;
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudangbahan->getrecordreturCount($nobukti,$tgl_retur);
    $users_record                 = $this->Model_gudangbahan->getDataretur($rowno,$rowperpage,$nobukti,$tgl_retur);
    $config['base_url']           = base_url().'gudangbahan/retur';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']         = $allcount;
    $config['per_page']           = $rowperpage;
    $config['first_link']         = 'First';
    $config['last_link']          = 'Last';
    $config['next_link']          = 'Next';
    $config['prev_link']          = 'Prev';
    $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']     = '</ul></nav></div>';
    $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']      = '</span></li>';
    $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']    = '</span>Next</li>';
    $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close']   = '</span></li>';
    $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']    = '</span></li>';
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                  = $rowno;
    $data['nobukti']              = $nobukti;
    $data['tgl_retur']            = $tgl_retur;
    $this->template->load('template/template','gudangbahan/retur',$data);

  }


  function pemasukan($rowno=0){

    $nobukti          = "";
    $tgl_pemasukan    = "";

    if($this->input->post('submit') != NULL ){
      $nobukti                 = $this->input->post('nobukti');
      $tgl_pemasukan           = $this->input->post('tgl_pemasukan');
      $data   = array(
        'nobukti'              => $nobukti,
        'tgl_pemasukan'        => $tgl_pemasukan,
      );
      $this->session->set_userdata($data);

    }else{

      if($this->session->userdata('nobukti') != NULL){
        $nobukti = $this->session->userdata('nobukti');
      }

      if($this->session->userdata('tgl_pemasukan') != NULL){
        $tgl_pemasukan = $this->session->userdata('tgl_pemasukan');
      }

    }
    $rowperpage = 10;
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    $allcount                     = $this->Model_gudangbahan->getrecordPemasukanCount($nobukti,$tgl_pemasukan);
    $users_record                 = $this->Model_gudangbahan->getDataPemasukan($rowno,$rowperpage,$nobukti,$tgl_pemasukan);
    $config['base_url']           = base_url().'gudangbahan/pemasukan';
    $config['use_page_numbers']   = TRUE;
    $config['total_rows']         = $allcount;
    $config['per_page']           = $rowperpage;
    $config['first_link']         = 'First';
    $config['last_link']          = 'Last';
    $config['next_link']          = 'Next';
    $config['prev_link']          = 'Prev';
    $config['full_tag_open']      = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']     = '</ul></nav></div>';
    $config['num_tag_open']       = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']      = '</span></li>';
    $config['cur_tag_open']       = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']      = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']    = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']    = '</span>Next</li>';
    $config['first_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close']   = '</span></li>';
    $config['last_tag_open']      = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']    = '</span></li>';
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                  = $rowno;
    $data['nobukti']              = $nobukti;
    $data['tgl_pemasukan']        = $tgl_pemasukan;
    $this->template->load('template/template','gudangbahan/pemasukan',$data);

  }

  function pengeluaran($rowno=0){

    $nobukti 	        = "";
    $tgl_pengeluaran  = "";
    $kode_dept  	    = "";

    if($this->input->post('submit') != NULL ){

      $nobukti 	           	   = $this->input->post('nobukti');
      $tgl_pengeluaran         = $this->input->post('tgl_pengeluaran');
      $kode_dept         		   = $this->input->post('kode_dept');

      $data 	= array(
        'nobukti'	 	       	  => $nobukti,
        'tgl_pengeluaran'	    => $tgl_pengeluaran,
        'kode_dept'	       		=> $kode_dept,
      );
      $this->session->set_userdata($data);

    }else{

      if($this->session->userdata('nobukti') != NULL){
        $nobukti = $this->session->userdata('nobukti');
      }

      if($this->session->userdata('tgl_pengeluaran') != NULL){
        $tgl_pengeluaran = $this->session->userdata('tgl_pengeluaran');
      }

      if($this->session->userdata('kode_dept') != NULL){
        $kode_dept = $this->session->userdata('kode_dept');
      }

    }
    $rowperpage = 10;
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    $allcount 	                  = $this->Model_gudangbahan->getrecordPengeluaranCount($nobukti,$tgl_pengeluaran,$kode_dept);
    $users_record                 = $this->Model_gudangbahan->getDataPengeluaran($rowno,$rowperpage,$nobukti,$tgl_pengeluaran,$kode_dept);
    $config['base_url'] 			    = base_url().'gudangbahan/pengeluaran';
    $config['use_page_numbers'] 	= TRUE;
    $config['total_rows'] 			  = $allcount;
    $config['per_page'] 			    = $rowperpage;
    $config['first_link']       	= 'First';
    $config['last_link']        	= 'Last';
    $config['next_link']        	= 'Next';
    $config['prev_link']        	= 'Prev';
    $config['full_tag_open']    	= '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   	= '</ul></nav></div>';
    $config['num_tag_open']     	= '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    	= '</span></li>';
    $config['cur_tag_open']     	= '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    	= '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  	= '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  	= '</span>Next</li>';
    $config['first_tag_open']   	= '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] 	= '</span></li>';
    $config['last_tag_open']    	= '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  	= '</span></li>';
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result'] 		          = $users_record;
    $data['row'] 			            = $rowno;
    $data['kode_dept'] 	          = $kode_dept;
    $data['nobukti'] 	            = $nobukti;
    $data['tgl_pengeluaran']	    = $tgl_pengeluaran;
    $data['dept']   			        = $this->Model_gudangbahan->getDept()->result();
    $this->template->load('template/template','gudangbahan/pengeluaran',$data);

  }

  function input_pemasukan(){

    $this->template->load('template/template','gudangbahan/input_pemasukan');

  }

  function input_retur(){

    $this->template->load('template/template','gudangbahan/input_retur');

  }

  function edit_pemasukan(){

    $data['edit']                = $this->Model_gudangbahan->geteditpemasukan()->row_array();
    $this->template->load('template/template','gudangbahan/edit_pemasukan',$data);

  }

  function edit_pengeluaran(){

    $data['edit']                = $this->Model_gudangbahan->geteditpengeluaran()->row_array();
    $this->template->load('template/template','gudangbahan/edit_pengeluaran',$data);

  }

  function tabelakun(){

    $this->load->view('gudangbahan/tabelakun');

  }

  function tabelbarang(){

    $this->load->view('gudangbahan/tabelbarang');

  }

  function detail_pemasukan(){

    $data ['data']		= $this->Model_gudangbahan->getPemasukan()->row_array();
    $data ['detail']	= $this->Model_gudangbahan->getDetailPemasukan();
    $this->load->view('gudangbahan/detail_pemasukan',$data);

  }

  function detail_retur(){

    $data ['data']    = $this->Model_gudangbahan->getRetur()->row_array();
    $data ['detail']  = $this->Model_gudangbahan->getDetailRetur();
    $this->load->view('gudangbahan/detail_retur',$data);

  }

  function detail_saldoawal(){

    $data ['data']    = $this->Model_gudangbahan->getSaldoawal()->row_array();
    $this->load->view('gudangbahan/detail_saldoawal',$data);

  }

  function detail_saldoawal_retur(){

    $data ['data']    = $this->Model_gudangbahan->getSaldoawalRetur()->row_array();
    $this->load->view('gudangbahan/detail_saldoawal_retur',$data);

  }

  function view_detail_saldoawal_retur(){

    $data ['detail']  = $this->Model_gudangbahan->getDetailsaldoawalRetur();
    $this->load->view('gudangbahan/view_detail_saldoawal_retur',$data);

  }

  function view_detail_saldoawal(){

    $data ['detail']  = $this->Model_gudangbahan->getDetailSaldoAwal();
    $this->load->view('gudangbahan/view_detail_saldoawal',$data);

  }

  function detail_opname(){

    $data ['data']    = $this->Model_gudangbahan->getOpname()->row_array();
    $data ['detail']  = $this->Model_gudangbahan->getDetailopnamestok();
    $this->load->view('gudangbahan/detail_opname',$data);

  }

  function insert_pembelian(){

    $this->Model_gudangbahan->insert_pembelian();

  }

  function detail_pengeluaran(){

    $data ['data']		= $this->Model_gudangbahan->getPengeluaran()->row_array();
    $data ['detail']	= $this->Model_gudangbahan->getDetailPengeluaran();
    $this->load->view('gudangbahan/detail_pengeluaran',$data);

  }

  function view_detailpemasukan_temp(){

    $data ['data']	= $this->Model_gudangbahan->getPemasukantemp();
    $this->load->view('gudangbahan/view_detailpemasukan_temp',$data);

  }

  function view_detailretur_temp(){

    $data ['data']  = $this->Model_gudangbahan->getReturemp();
    $this->load->view('gudangbahan/view_detailretur_temp',$data);

  }

  function view_detaileditpemasukan(){

    $data ['data']  = $this->Model_gudangbahan->view_detaileditpemasukan();
    $this->load->view('gudangbahan/view_detaileditpemasukan',$data);

  }

  function view_detaileditpengeluaran(){

    $data ['data']  = $this->Model_gudangbahan->view_detaileditpengeluaran();
    $this->load->view('gudangbahan/view_detaileditpengeluaran',$data);

  }

  function hapuspengeluaran(){

    $this->Model_gudangbahan->hapuspengeluaran();
    redirect('gudangbahan/pengeluaran');

  }

  function hapuspemasukan(){

    $this->Model_gudangbahan->hapuspemasukan();
    redirect('gudangbahan/pemasukan');

  }

  function hapusretur(){

    $this->Model_gudangbahan->hapusretur();
    redirect('gudangbahan/retur');
  }

  function barang()
  {
    $this->template->load('template/template', 'gudangbahan/view_barang');
  }

  function hapussaldoawal(){

    $this->Model_gudangbahan->hapussaldoawal();
    redirect('gudangbahan/saldoawal');

  }

  function hapussaldoawal_retur(){

    $this->Model_gudangbahan->hapussaldoawal_retur();
    redirect('gudangbahan/saldoawal_retur');

  }
  
  function hapusopname(){

    $this->Model_gudangbahan->hapusopname();
    redirect('gudangbahan/opname');

  }

  function insert_pemasukan(){

    $this->Model_gudangbahan->insert_pemasukan();

  }

  function insert_retur(){

    $this->Model_gudangbahan->insert_retur();

  }

  function hapus_detailpemasukan_temp(){

    $this->Model_gudangbahan->hapus_detailpemasukan_temp();

  }

  function hapus_detailretur_temp(){

    $this->Model_gudangbahan->hapus_detailretur_temp();

  }

  function hapus_detaileditpemasukan(){

    $this->Model_gudangbahan->hapus_detaileditpemasukan();

  }


  function hapus_detaileditpengeluaran(){

    $this->Model_gudangbahan->hapus_detaileditpengeluaran();

  }

  function inputpemasukan_temp(){

    $this->Model_gudangbahan->insertpemasukan_temp();

  }

  function inputretur_temp(){

    $this->Model_gudangbahan->insertretur_temp();

  }

  function inputeditpengeluaran(){

    $this->Model_gudangbahan->inputeditpengeluaran();

  }

  function inputeditpemasukan(){

    $this->Model_gudangbahan->inputeditpemasukan();

  }

  function update_pemasukan(){

    $this->Model_gudangbahan->update_pemasukan();

  }

  function update_pengeluaran(){

    $this->Model_gudangbahan->update_pengeluaran();

  }

  function view_pengeluaran(){

    $this->template->load('template/template','gudangbahan/view_pengeluaran');

  }

  function input_pengeluaran(){

    $data ['dept']   	= $this->Model_gudangbahan->getDept()->result();
    $this->template->load('template/template','gudangbahan/input_pengeluaran',$data);

  }

  function view_detailpengeluaran_temp(){

    $data ['data']	= $this->Model_gudangbahan->getPengeluarantemp();
    $this->load->view('gudangbahan/view_detailpengeluaran_temp',$data);

  }

  function view_detailpengeluaran_detail()
  {

    $data['data']  = $this->Model_gudangbahan->getPengeluarandetail();
    $this->load->view('gudangbahan/view_detailpengeluaran_detail', $data);
  }
  function insert_pengeluaran(){

    $this->Model_gudangbahan->insert_pengeluaran();

  }

  function hapus_detailpengeluaran_temp(){

    $this->Model_gudangbahan->hapus_detailpengeluaran_temp();

  }
  function hapus_detailpengeluaran_detail(){

    $this->Model_gudangbahan->hapus_detailpengeluaran_detail();

  }

  function inputpengeluaran_temp(){

    $this->Model_gudangbahan->insertpengeluaran_temp();

  }
  
  function insert_detail_pengeluaran(){

    $this->Model_gudangbahan->insert_detail_pengeluaran();

  }

  function jsonPilihBarang() {

    header('Content-Type: application/json');
    echo $this->Model_gudangbahan->jsonPilihBarang();

  }

  function jsonPilihAkun() {

    header('Content-Type: application/json');
    echo $this->Model_gudangbahan->jsonPilihAkun();

  }

}
