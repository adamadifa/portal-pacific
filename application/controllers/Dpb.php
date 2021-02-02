<?php
class Dpb extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    check_login();
    $this->load->model(array('Model_cabang', 'Model_oman', 'Model_dpb', 'Model_sales', 'Model_penjualan'));
  }
  function index($rowno = 0)
  {
    // Search text
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    // Search text
    $no_dpb           = "";
    $tgl_pengambilan  = "";
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tgl_pengambilan     = $this->input->post('tgl_pengambilan');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tgl_pengambilan'       => $tgl_pengambilan,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tgl_pengambilan') != NULL) {
        $tgl_pengambilan = $this->session->userdata('tgl_pengambilan');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordDpbCount($no_dpb, $tgl_pengambilan, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataDpb($rowno, $rowperpage, $no_dpb, $tgl_pengambilan, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/index';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tgl_pengambilan']      = $tgl_pengambilan;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/dpb', $data);
  }

  function inputdpb()
  {
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputdpb', $data);
  }

  function updatedpb()
  {
    $no_dpb             = $this->uri->segment(3);
    $data['dpb']        = $this->Model_dpb->getDpb($no_dpb)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $data['salesman']   = $this->Model_sales->get_salescab($data['cb'])->result();
    $this->template->load('template/template', 'dpb/updatedpb', $data);
  }

  function input_dpb()
  {
    $this->Model_dpb->insert_dpb();
  }

  function update_dpb()
  {
    $this->Model_dpb->update_dpb();
  }

  function detail_dpb()
  {
    $no_dpb             = $this->input->post('no_dpb');
    $data['dpb']        = $this->Model_dpb->getDpb($no_dpb)->row_array();
    $data['detaildpb']  = $this->Model_dpb->detaildpb($no_dpb)->result();
    $data['mutasidpb']  = $this->Model_dpb->mutasidpb($no_dpb)->result();
    $this->load->view('dpb/detail_dpb', $data);
  }

  function detail_penjualandpb()
  {
    $nomutasi                = $this->input->post('nomutasi');
    $data['mutasi']          = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['detailmutasi']    = $this->Model_dpb->detailMutasiPenjualan($nomutasi)->result();
    $this->load->view('dpb/detail_dpbpenjualan', $data);
  }

  function detail_returdpb()
  {
    $nomutasi                = $this->input->post('nomutasi');
    $data['mutasi']          = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['detailmutasi']    = $this->Model_dpb->detailMutasiPenjualan($nomutasi)->result();
    $this->load->view('dpb/detail_dpbretur', $data);
  }


  function penjualan($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tgl_penjualan    = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tgl_penjualan       = $this->input->post('tgl_penjualan');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tgl_penjualan'         => $tgl_penjualan,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tgl_penjualan') != NULL) {
        $tgl_penjualan = $this->session->userdata('tgl_penjualan');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordPenjualanDpbCount($no_dpb, $tgl_penjualan, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataPenjualanDpb($rowno, $rowperpage, $no_dpb, $tgl_penjualan, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/penjualan';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tgl_penjualan']        = $tgl_penjualan;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/penjualan', $data);
  }

  function inputpenjualan()
  {

    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputpenjualan', $data);
  }

  function jsondpb()
  {
    header('Content-Type: application/json');
    echo $this->Model_dpb->jsondpb();
  }

  function input_penjualan()
  {
    $this->Model_dpb->insert_penjualan();
  }



  function getNomutasiPenjualan()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'PENJUALAN' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "PNJ" . $nodpb, 2);
    echo $no_mutasi;
  }

  function updatepenjualan()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updatepenjualan', $data);
  }

  function update_penjualan()
  {
    $this->Model_dpb->update_penjualan();
  }

  function hapuspenjualan()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapuspenjualan($no_mutasi, $cabang);
  }

  // function retur($rowno=0)
  // {
  //   // Search text
  //   $no_dpb 	        = "";
  //   $tgl_penjualan    = "";
  //   $cabang           = "";
  //   $salesman         = "";
  //   if($this->input->post('submit') != NULL ){
  //     $no_dpb 	           = $this->input->post('no_dpb');
  //     $tgl_penjualan       = $this->input->post('tgl_penjualan');
  //     $cabang              = $this->input->post('cabang');
  //     $salesman            = $this->input->post('salesman');
  //     $data 	= array(
  //       'no_dpb'	 	           => $no_dpb,
  //       'tgl_penjualan'	       => $tgl_penjualan,
  //       'cbg'                  => $cabang,
  //       'salesman'             => $salesman
  //     );
  //     $this->session->set_userdata($data);
  //   }else{
  //    if($this->session->userdata('no_dpb') != NULL){
  //       $no_dpb = $this->session->userdata('no_dpb');
  //     }
  //     if($this->session->userdata('tgl_penjualan') != NULL){
  //       $tgl_penjualan = $this->session->userdata('tgl_penjualan');
  //     }
  //     if($this->session->userdata('cbg') != NULL){
  //       $cabang = $this->session->userdata('cbg');
  //     }
  //     if($this->session->userdata('salesman') != NULL){
  //       $salesman = $this->session->userdata('salesman');
  //     }
  //   }
  //   $rowperpage = 10;
  //   if($rowno != 0){
  //     $rowno = ($rowno-1) * $rowperpage;
  //   }
  //   // All records count
  //   $allcount 	  = $this->Model_dpb->getrecordreturCount($no_dpb,$tgl_penjualan,$cabang,$salesman);
  //   // Get records
  //   $users_record = $this->Model_dpb->getreturData($rowno,$rowperpage,$no_dpb,$tgl_penjualan,$cabang,$salesman);
  //   // Pagination Configuration
  //   $config['base_url'] 					= base_url().'dpb/retur';
  //   $config['use_page_numbers'] 	= TRUE;
  //   $config['total_rows'] 				= $allcount;
  //   $config['per_page'] 					= $rowperpage;
  //   $config['first_link']       	= 'First';
  //   $config['last_link']      		= 'Last';
  //   $config['next_link']      		= 'Next';
  //   $config['prev_link']      		= 'Prev';
  //   $config['full_tag_open']  		= '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
  //   $config['full_tag_close'] 		= '</ul></nav></div>';
  //   $config['num_tag_open']   		= '<li class="page-item"><span class="page-link">';
  //   $config['num_tag_close']  		= '</span></li>';
  //   $config['cur_tag_open']   		= '<li class="page-item active"><span class="page-link">';
  //   $config['cur_tag_close']  		= '<span class="sr-only">(current)</span></span></li>';
  //   $config['next_tag_open']  		= '<li class="page-item"><span class="page-link">';
  //   $config['next_tagl_close']		= '<span aria-hidden="true">&raquo;</span></span></li>';
  //   $config['prev_tag_open']  		= '<li class="page-item"><span class="page-link">';
  //   $config['prev_tagl_close']		= '</span>Next</li>';
  //   $config['first_tag_open']   	= '<li class="page-item"><span class="page-link">';
  //   $config['first_tagl_close'] 	= '</span></li>';
  //   $config['last_tag_open']    	= '<li class="page-item"><span class="page-link">';
  //   $config['last_tagl_close']  	= '</span></li>';
  //   // Initialize
  //   $this->pagination->initialize($config);
  //   $data['pagination'] 					= $this->pagination->create_links();
  //   $data['result'] 							= $users_record;
  //   $data['row'] 									= $rowno;
  //   $data['no_dpb'] 	            = $no_dpb;
  //   $data['tgl_penjualan']	      = $tgl_penjualan;
  //   $data['salesman']	            = $salesman;
  //   $data['cbg']                  = $cabang;
  //   // Load view
  //   $data['cabang'] 		          = $this->Model_cabang->view_cabang()->result();
  //   $data['cb'] 				          = $this->session->userdata('cabang');
  //   $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
  // 	$this->template->load('template/template','dpb/listretur',$data);
  // }

  function retur($rowno = 0)
  {
    // Search text
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $no_dpb           = "";
    $tgl_penjualan    = "";
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tgl_penjualan       = $this->input->post('tgl_penjualan');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tgl_penjualan'         => $tgl_penjualan,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tgl_penjualan') != NULL) {
        $tgl_penjualan = $this->session->userdata('tgl_penjualan');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordReturDpbCount($no_dpb, $tgl_penjualan, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataReturDpb($rowno, $rowperpage, $no_dpb, $tgl_penjualan, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/retur';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tgl_penjualan']        = $tgl_penjualan;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/retur', $data);
  }

  function inputretur()
  {

    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputretur', $data);
  }

  function input_retur()
  {
    $this->Model_dpb->insert_retur();
  }

  function getNomutasiRetur()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'RETUR' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "RTR" . $nodpb, 2);
    echo $no_mutasi;
  }

  function updateretur()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updateretur', $data);
  }

  function update_retur()
  {
    $this->Model_dpb->update_retur();
  }

  function hapusretur()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang    = $this->uri->segment(4);
    $this->Model_dpb->hapusretur($no_mutasi, $cabang);
  }

  //Ganti BARANG

  function gantibarang($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordGBDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataGBDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/gantibarang';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/gantibarang', $data);
  }

  function inputgb()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputgb', $data);
  }

  function getNomutasiGB()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'GANTI BARANG' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "RGB" . $nodpb, 2);
    echo $no_mutasi;
  }

  function input_gb()
  {
    $this->Model_dpb->insert_gb();
  }

  function updategb()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updategb', $data);
  }

  function update_gb()
  {
    $this->Model_dpb->update_gb();
  }

  function hapusgb()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapusgb($no_mutasi, $cabang);
  }

  //REJECT MOBIL
  function rejectmobil($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'               => $no_dpb,
        'tanggal'              => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordRJMDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataRJMDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/rejectpasar';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/rejectmobil', $data);
  }

  //REJECT PASAR
  function rejectpasar($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordRJPDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataRJPDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/rejectpasar';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/rejectpasar', $data);
  }

  function inputrejectpasar()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputrejectpasar', $data);
  }

  function inputrejectmobil()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputrejectmobil', $data);
  }

  function getNomutasiRJP()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'REJECT PASAR' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "RJP" . $nodpb, 2);
    echo $no_mutasi;
  }


  function getNomutasiRJM()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'REJECT MOBIL' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "RJM" . $nodpb, 2);
    echo $no_mutasi;
  }

  function input_rejectpasar()
  {
    $this->Model_dpb->insert_rejectpasar();
  }

  function input_rejectmobil()
  {
    $this->Model_dpb->insert_rejectmobil();
  }


  function updaterejectpasar()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updaterejectpasar', $data);
  }

  function updaterejectmobil()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updaterejectmobil', $data);
  }


  function update_rejectpasar()
  {
    $this->Model_dpb->update_rejectpasar();
  }

  function update_rejectmobil()
  {
    $this->Model_dpb->update_rejectmobil();
  }

  function hapusrejectpasar()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapusrejectpasar($no_mutasi, $cabang);
  }

  function hapusrejectmobil()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapusrejectmobil($no_mutasi, $cabang);
  }

  function hutangkirim($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordHKDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataHKDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/hutangkirim';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/hutangkirim', $data);
  }

  function inputhutangkirim()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputhutangkirim', $data);
  }

  function input_hutangkirim()
  {
    echo $this->input->post('no_mutasi');
    $this->Model_dpb->insert_hutangkirim();
  }

  function updatehutangkirim()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updatehutangkirim', $data);
  }

  function update_hutangkirim()
  {
    $this->Model_dpb->update_hutangkirim();
  }

  function hapushutangkirim()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapushutangkirim($no_mutasi, $cabang);
  }

  function getNomutasiHK()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'HUTANG KIRIM' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "HK" . $nodpb, 2);
    echo $no_mutasi;
  }

  function plhutangkirim($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordPLHKDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataPLHKDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/plhutangkirim';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/plhutangkirim', $data);
  }

  function inputplhutangkirim()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputplhutangkirim', $data);
  }

  function input_plhutangkirim()
  {
    echo $this->input->post('no_mutasi');
    $this->Model_dpb->insert_plhutangkirim();
  }

  function updateplhutangkirim()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updateplhutangkirim', $data);
  }

  function update_plhutangkirim()
  {
    $this->Model_dpb->update_plhutangkirim();
  }

  function hapusplhutangkirim()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapusplhutangkirim($no_mutasi, $cabang);
  }

  function getNomutasiPLHK()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'PELUNASAN HUTANG KIRIM' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "PH" . $nodpb, 2);
    echo $no_mutasi;
  }


  function ttr($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cabang           = "";
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordTTRDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataTTRDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/ttr';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/ttr', $data);
  }


  function inputttr()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputttr', $data);
  }

  function input_ttr()
  {
    echo $this->input->post('no_mutasi');
    $this->Model_dpb->insert_ttr();
  }

  function updatettr()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updatettr', $data);
  }

  function update_ttr()
  {
    $this->Model_dpb->update_ttr();
  }

  function hapusttr()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(3);
    $this->Model_dpb->hapusttr($no_mutasi, $cabang);
  }

  function getNomutasiTTR()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'TTR' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "TR" . $nodpb, 2);
    echo $no_mutasi;
  }

  function plttr($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordplTTRDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataplTTRDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/ttr';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/plttr', $data);
  }

  function inputplttr()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputplttr', $data);
  }

  function input_plttr()
  {
    echo $this->input->post('no_mutasi');
    $this->Model_dpb->insert_plttr();
  }

  function updateplttr()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updateplttr', $data);
  }

  function update_plttr()
  {
    $this->Model_dpb->update_plttr();
  }

  function hapusplttr()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapusplttr($no_mutasi, $cabang);
  }

  function getNomutasiplTTR()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'TTR' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "PT" . $nodpb, 2);
    echo $no_mutasi;
  }

  function promosi($rowno = 0)
  {
    // Search text
    $no_dpb           = "";
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $salesman         = "";
    if ($this->input->post('submit') != NULL) {
      $no_dpb              = $this->input->post('no_dpb');
      $tanggal             = $this->input->post('tanggal');
      $cabang              = $this->input->post('cabang');
      $salesman            = $this->input->post('salesman');
      $data   = array(
        'no_dpb'                => $no_dpb,
        'tanggal'               => $tanggal,
        'cbg'                  => $cabang,
        'salesman'             => $salesman
      );
      $this->session->set_userdata($data);
    } else {
      if ($this->session->userdata('no_dpb') != NULL) {
        $no_dpb = $this->session->userdata('no_dpb');
      }
      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('salesman') != NULL) {
        $salesman = $this->session->userdata('salesman');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordPromosiDpbCount($no_dpb, $tanggal, $cabang, $salesman);
    // Get records
    $users_record = $this->Model_dpb->getDataPromosiDpb($rowno, $rowperpage, $no_dpb, $tanggal, $cabang, $salesman);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/promosi';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['no_dpb']               = $no_dpb;
    $data['tanggal']              = $tanggal;
    $data['salesman']              = $salesman;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['sales']                = $this->Model_sales->get_sales($salesman)->row_array();
    //echo $data['cb'];
    $this->template->load('template/template', 'dpb/promosi', $data);
  }

  function inputpromosi()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $this->template->load('template/template', 'dpb/inputpromosi', $data);
  }

  function input_promosi()
  {
    echo $this->input->post('no_mutasi');
    $this->Model_dpb->insert_promosi();
  }

  function updatepromosi()
  {
    $nomutasi           = $this->uri->segment(3);
    $data['mutasi']     = $this->Model_dpb->getMutasiPenjualan($nomutasi)->row_array();
    $data['barang']     = $this->Model_oman->listproduk()->result();
    $this->template->load('template/template', 'dpb/updatepromosi', $data);
  }

  function update_promosi()
  {
    $this->Model_dpb->update_promosi();
  }

  function hapuspromosi()
  {
    $no_mutasi = $this->uri->segment(3);
    $cabang = $this->uri->segment(4);
    $this->Model_dpb->hapuspromosi($no_mutasi, $cabang);
  }

  function getNomutasiPromosi()
  {
    $nodpb = $this->input->post('nodpb');
    $query            = "SELECT no_mutasi_gudang_cabang
                        FROM mutasi_gudang_cabang
                        WHERE jenis_mutasi = 'PROMOSI' AND no_dpb  ='$nodpb'
                        ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1
                         ";
    $nomor            = $this->db->query($query)->row_array();
    $nomor_terakhir   = $nomor['no_mutasi_gudang_cabang'];
    $no_mutasi        = buatkode($nomor_terakhir, "PR" . $nodpb, 2);
    echo $no_mutasi;
  }

  function saldoawalgs($rowno = 0)
  {
    // Search text
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $status           = "GS";
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $tanggal   = $this->input->post('tanggal');
      $cabang    = $this->input->post('cabang');
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(
        'tanggal'  => $tanggal,
        'cbg'     => $cabang,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordSaldoawalCount($tanggal, $cabang, $status, $bulan, $tahun);
    // Get records
    $users_record = $this->Model_dpb->getDataSaldoawal($rowno, $rowperpage, $tanggal, $cabang, $status, $bulan, $tahun);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/saldoawalgs';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['status']               = $status;
    $data['tahun']                = date("Y");
    $data['bulan']                = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']                  = $bulan;
    $data['thn']                  = $tahun;
    $this->template->load('template/template', 'dpb/saldoawal', $data);
  }

  function saldoawalbs($rowno = 0)
  {
    // Search text
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $status           = "BS";
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $tanggal   = $this->input->post('tanggal');
      $cabang    = $this->input->post('cabang');
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(
        'tanggal'  => $tanggal,
        'cbg'     => $cabang,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordSaldoawalCount($tanggal, $cabang, $status, $bulan, $tahun);
    // Get records
    $users_record = $this->Model_dpb->getDataSaldoawal($rowno, $rowperpage, $tanggal, $cabang, $status, $bulan, $tahun);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/saldoawalgs';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');
    $data['status']               = $status;
    $data['tahun']                = date("Y");
    $data['bulan']                = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']                  = $bulan;
    $data['thn']                  = $tahun;
    $this->template->load('template/template', 'dpb/saldoawal', $data);
  }

  function inputsaldoawalgs()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $data['status']    = "GS";
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->template->load('template/template', 'dpb/inputsaldoawal', $data);
  }

  function inputsaldoawalbs()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $data['status']    = "BS";
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->template->load('template/template', 'dpb/inputsaldoawal', $data);
  }

  function getdetailsaldo()
  {
    $bulan    = $this->input->post('bulan');
    $tahun    = $this->input->post('tahun');
    $cabang   = $this->input->post('cabang');
    $status   = $this->input->post('status');
    $ceksaldo = $this->Model_dpb->ceksaldo($bulan, $tahun, $cabang, $status)->num_rows();
    $cekall   = $this->Model_dpb->ceksaldoall($cabang, $status)->num_rows();
    $ceknow   = $this->Model_dpb->ceksaldoSkrg($bulan, $tahun, $cabang, $status)->num_rows();
    if (empty($ceksaldo) && !empty($cekall) || !empty($ceknow)) {
      echo "1";
    } else {
      $data['detail'] = $this->Model_dpb->getdetailsaldo($bulan, $tahun, $cabang, $status)->result();
      $this->load->view('dpb/getsaldo', $data);
    }
  }

  function input_saldoawal()
  {
    $this->Model_dpb->insert_saldoawal();
  }

  function detailsaldoawal()
  {
    $kode                    = $this->input->post('kode');
    $data['saldo']           = $this->Model_dpb->getSaldoBJ($kode)->row_array();
    $data['detailsaldo']     = $this->Model_dpb->detailSaldoBJ($kode)->result();
    $data['bulan']           = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->load->view('dpb/detailsaldoawal', $data);
  }

  function hapussaldoawal()
  {
    $kode   = $this->uri->segment(3);
    $status = $this->uri->segment(4);
    $this->Model_dpb->hapussaldoawal($kode, $status);
  }

  function hapusdpb()
  {
    $kodedpb  = $this->uri->segment(3);
    $this->Model_dpb->hapusdpb($kodedpb);
  }

  function saldoawaldpb($rowno = 0)
  {
    // Search text
    $tanggal          = "";
    $cab  = $this->session->userdata('cabang');
    if ($cab != 'pusat') {
      $cabang = $cab;
    } else {
      $cabang = "";
    }
    $bulan            = "";
    $tahun            = "";
    if ($this->input->post('submit') != NULL) {
      $tanggal   = $this->input->post('tanggal');
      $cabang    = $this->input->post('cabang');
      $bulan     = $this->input->post('bulan');
      $tahun     = $this->input->post('tahun');
      $data   = array(
        'tanggal'  => $tanggal,
        'cbg'     => $cabang,
        'bulan'   => $bulan,
        'tahun'   => $tahun
      );
      $this->session->set_userdata($data);
    } else {

      if ($this->session->userdata('tanggal') != NULL) {
        $tanggal = $this->session->userdata('tanggal');
      }
      if ($this->session->userdata('cbg') != NULL) {
        $cabang = $this->session->userdata('cbg');
      }
      if ($this->session->userdata('bulan') != NULL) {
        $bulan = $this->session->userdata('bulan');
      }
      if ($this->session->userdata('tahun') != NULL) {
        $tahun = $this->session->userdata('tahun');
      }
    }
    // Row per page
    $rowperpage = 10;
    // Row position
    if ($rowno != 0) {
      $rowno = ($rowno - 1) * $rowperpage;
    }
    // All records count
    $allcount     = $this->Model_dpb->getrecordSaldoawalDpbCount($tanggal, $cabang, $bulan, $tahun);
    // Get records
    $users_record = $this->Model_dpb->getDataSaldoawalDpb($rowno, $rowperpage, $tanggal, $cabang, $bulan, $tahun);
    // Pagination Configuration
    $config['base_url']           = base_url() . 'dpb/saldoawalgs';
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
    // Initialize
    $this->pagination->initialize($config);
    $data['pagination']           = $this->pagination->create_links();
    $data['result']               = $users_record;
    $data['row']                   = $rowno;
    $data['tanggal']              = $tanggal;
    $data['cbg']                  = $cabang;
    // Load view
    $data['cabang']               = $this->Model_cabang->view_cabang()->result();
    $data['cb']                   = $this->session->userdata('cabang');

    $data['tahun']                = date("Y");
    $data['bulan']                = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $data['bln']                  = $bulan;
    $data['thn']                  = $tahun;
    $this->template->load('template/template', 'dpb/saldoawal_dpb', $data);
  }

  function inputsaldoawaldpb()
  {
    $data['barang']    = $this->Model_oman->listproduk()->result();
    $data['cabang']     = $this->Model_cabang->view_cabang()->result();
    $data['cb']         = $this->session->userdata('cabang');
    $data['status']    = "GS";
    $data['tahun']     = date("Y");
    $data['bulan']     = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->template->load('template/template', 'dpb/inputsaldoawal_dpb', $data);
  }

  function getdetailsaldodpb()
  {
    $bulan    = $this->input->post('bulan');
    $tahun    = $this->input->post('tahun');
    $cabang   = $this->input->post('cabang');
    $ceksaldo = $this->Model_dpb->ceksaldodpb($bulan, $tahun, $cabang)->num_rows();
    $cekall   = $this->Model_dpb->ceksaldoalldpb($cabang)->num_rows();
    $ceknow   = $this->Model_dpb->ceksaldoSkrgdpb($bulan, $tahun, $cabang)->num_rows();
    if (empty($ceksaldo) && !empty($cekall) || !empty($ceknow)) {
      echo "1";
    } else {
      $data['detail'] = $this->Model_dpb->getdetailsaldodpb($bulan, $tahun, $cabang)->result();
      $this->load->view('dpb/getsaldodpb', $data);
    }
  }

  function input_saldoawaldpb()
  {
    $this->Model_dpb->insert_saldoawaldpb();
  }

  function hapussaldoawaldpb()
  {
    $kode   = $this->uri->segment(3);

    $this->Model_dpb->hapussaldoawaldpb($kode);
  }

  function detailsaldoawaldpb()
  {
    $kode                    = $this->input->post('kode');
    $data['saldo']           = $this->Model_dpb->getSaldoDPB($kode)->row_array();
    $data['detailsaldo']     = $this->Model_dpb->detailSaldoDPB($kode)->result();
    $data['bulan']           = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $this->load->view('dpb/detailsaldoawal', $data);
  }
}
