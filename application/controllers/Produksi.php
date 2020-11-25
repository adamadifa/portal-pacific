<?php

class Produksi extends CI_Controller{
	function __construct(){
		parent::__construct();
		check_login();
		$this->load->model(array('Model_produksi'));
	}

  function barang(){
    $this->template->load('template/template','produksi/view_barang');
  }

  function view_detail_saldoawal(){

    $data ['data']    = $this->Model_produksi->getSaldoawal()->row_array();
    $data ['detail']  = $this->Model_produksi->getDetailSaldoAwal();
    $this->load->view('produksi/view_detail_saldoawal',$data);

  }
  
  function editdetailsaldoawal(){

    $this->Model_produksi->editdetailsaldoawal();
  }


  function jsonBarang() {
    header('Content-Type: application/json');
    echo $this->Model_produksi->jsonBarang();
  }

  function edit_Barang()
  {
    $kodebarang       = $this->input->post('kodebarang');
    $data['brg']      = $this->Model_produksi->getBarang($kodebarang)->row_array();
    $this->load->view('produksi/edit_barang',$data);
  }

  function input_barang()
  {
    $this->load->view('produksi/input_barang');
  }

  function insert_barang()
  {
    $this->Model_produksi->insert_barang();
  }

  function update_barang()
  {
    $this->Model_produksi->update_barang();
  }


  function inputsaldoawal(){

    $data['barang']    = $this->Model_produksi->listproduk()->result();
    $data['tahun']     = date("Y");
    $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['kategori']  = $this->Model_produksi->getKategori()->result();
    $this->template->load('template/template','produksi/inputsaldoawal',$data);
  }


  function codeotomatispengeluaran(){

    $tahun    = date('y');
    $bulan    = date('m');
    $this->db->select('right(pengeluaran_gp.nobukti_pengeluaran,3) as kode ',false);
    $this->db->where('mid(nobukti_pengeluaran,6,2)',$bulan);
    $this->db->where('mid(nobukti_pengeluaran,8,2)',$tahun);
    $this->db->order_by('nobukti_pengeluaran', 'desc');
    $this->db->limit('13');
    $query    = $this->db->get('pengeluaran_gp');
    if($query->num_rows()<>0){
     $data   = $query->row();
     $kode   = intval($data->kode)+1;
   }else{
     $kode   = 1;
   }
   $kodemax  = str_pad($kode,3,"0",STR_PAD_LEFT);
   $kodejadi   = "PRDK/".$bulan."".$tahun."/".$kodemax;
   echo $kodejadi;

 } 


 function codeotomatispemasukan(){

  $tahun    = date('y');
  $bulan    = date('m');
  $this->db->select('right(pemasukan_gp.nobukti_pemasukan,3) as kode ',false);
  $this->db->where('mid(nobukti_pemasukan,6,2)',$bulan);
  $this->db->where('mid(nobukti_pemasukan,8,2)',$tahun);
  $this->db->order_by('nobukti_pemasukan', 'desc');
  $this->db->limit('13');
  $query    = $this->db->get('pemasukan_gp');
  if($query->num_rows()<>0){
    $data   = $query->row();
    $kode   = intval($data->kode)+1;
  }else{
    $kode   = 1;
  }
  $kodemax  = str_pad($kode,3,"0",STR_PAD_LEFT);
  $kodejadi   = "PRDM/".$bulan."".$tahun."/".$kodemax;
  echo $kodejadi;

} 


function inputopname(){

  $data['barang']    = $this->Model_produksi->listproduk()->result();
  $data['tahun']     = date("Y");
  $data['bulan']     = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
  $data['kategori']  = $this->Model_produksi->getKategori()->result();
  $this->template->load('template/template','produksi/inputopname',$data);
}


function getdetailsaldo(){

  $bulan          = $this->input->post('bulan');
  $tahun          = $this->input->post('tahun');
  $ceksaldo       = $this->Model_produksi->ceksaldo($bulan,$tahun)->num_rows();
  $cekall         = $this->Model_produksi->ceksaldoall()->num_rows();
  $data['cek']    = $ceksaldo;
  $ceknow         = $this->Model_produksi->ceksaldoSkrg($bulan,$tahun)->num_rows();
  if(empty($ceksaldo) && !empty($cekall) || !empty($ceknow))
  {
   echo "1";
 }else{
   $data['detail'] = $this->Model_produksi->getdetailsaldo($bulan,$tahun)->result();
			//var_dump($data);
   $this->load->view('produksi/getsaldo',$data);
 }

}

function getdetailopname(){

  $bulan          = $this->input->post('bulan');
  $tahun          = $this->input->post('tahun');
  $cekopname      = $this->Model_produksi->cekopname($bulan,$tahun)->num_rows();
  $cekall         = $this->Model_produksi->cekopnameall()->num_rows();
  $data['cek']    = $cekopname;
  $ceknow         = $this->Model_produksi->cekopnameSkrg($bulan,$tahun)->num_rows();
  if(empty($cekopname) && !empty($cekall) || !empty($ceknow))
  {
   echo "1";
 }else{
   $data['detail'] = $this->Model_produksi->getDetailopname($bulan,$tahun)->result();
   $this->load->view('produksi/getopname',$data);
 }

}

function input_saldoawal(){

  $this->Model_produksi->insert_saldoawal();
}

function input_opname(){

  $this->Model_produksi->insert_opname();
}


function opname($rowno=0){

  $kode_opname 	      = "";
  $tanggal                = "";

  if($this->input->post('submit') != NULL ){
   $kode_opname 	       = $this->input->post('kode_opname');
   $tanggal                 = $this->input->post('tanggal');
   $data 	= array(
    'kode_opname'	 	   => $kode_opname,
    'tanggal'	             => $tanggal,
  );
   $this->session->set_userdata($data);

 }else{

   if($this->session->userdata('kode_opname') != NULL){
    $kode_opname = $this->session->userdata('kode_opname');
  }

  if($this->session->userdata('tanggal') != NULL){
    $tanggal = $this->session->userdata('tanggal');
  }

}
$rowperpage = 10;
if($rowno != 0){
 $rowno = ($rowno-1) * $rowperpage;
}
$allcount 	                  = $this->Model_produksi->getrecordopnameCount($kode_opname,$tanggal);
$users_record                 = $this->Model_produksi->getDataopname($rowno,$rowperpage,$kode_opname,$tanggal);
$config['base_url'] 			    = base_url().'produksi/pemasukan';
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
$data['pagination']           	= $this->pagination->create_links();
$data['result'] 		        = $users_record;
$data['row'] 			        = $rowno;
$data['kode_opname'] 	   	= $kode_opname;
$data['tanggal']	            = $tanggal;
$this->template->load('template/template','produksi/opname',$data);

}
function saldoawal($rowno=0){

  $kode_saldoawal      = "";
  $tanggal                = "";

  if($this->input->post('submit') != NULL ){
   $kode_saldoawal       	 = $this->input->post('kode_saldoawal');
   $tanggal                 = $this->input->post('tanggal');
   $data   = array(
    'kode_saldoawal'       => $kode_saldoawal,
    'tanggal'              => $tanggal,
  );
   $this->session->set_userdata($data);

 }else{

   if($this->session->userdata('kode_saldoawal') != NULL){
    $kode_saldoawal = $this->session->userdata('kode_saldoawal');
  }

  if($this->session->userdata('tanggal') != NULL){
    $tanggal = $this->session->userdata('tanggal');
  }

}
$rowperpage = 10;
if($rowno != 0){
 $rowno = ($rowno-1) * $rowperpage;
}
$allcount                     = $this->Model_produksi->getrecordSaldoawalnCount($kode_saldoawal,$tanggal);
$users_record                 = $this->Model_produksi->getDataSaldoawal($rowno,$rowperpage,$kode_saldoawal,$tanggal);
$config['base_url']           = base_url().'produksi/pemasukan';
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
$data['kode_saldoawal']    	  = $kode_saldoawal;
$data['tanggal']              = $tanggal;
$this->template->load('template/template','produksi/saldoawal',$data);

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
$allcount                     = $this->Model_produksi->getrecordPemasukanCount($nobukti,$tgl_pemasukan);
$users_record                 = $this->Model_produksi->getDataPemasukan($rowno,$rowperpage,$nobukti,$tgl_pemasukan);
$config['base_url']           = base_url().'produksi/pemasukan';
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
$this->template->load('template/template','produksi/pemasukan',$data);

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
  $allcount 	                  = $this->Model_produksi->getrecordPengeluaranCount($nobukti,$tgl_pengeluaran,$kode_dept);
  $users_record                 = $this->Model_produksi->getDataPengeluaran($rowno,$rowperpage,$nobukti,$tgl_pengeluaran,$kode_dept);
  $config['base_url'] 			    = base_url().'produksi/pengeluaran';
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
  $data['dept']   			        = $this->Model_produksi->getDept()->result();
  $this->template->load('template/template','produksi/pengeluaran',$data);

}

function input_pemasukan(){

  $this->template->load('template/template','produksi/input_pemasukan');

}

function edit_pemasukan(){

  $data['edit']                = $this->Model_produksi->geteditpemasukan()->row_array();
  $this->template->load('template/template','produksi/edit_pemasukan',$data);

}

function edit_pengeluaran(){

  $data['edit']                = $this->Model_produksi->geteditpengeluaran()->row_array();
  $this->template->load('template/template','produksi/edit_pengeluaran',$data);

}

function tabelakun(){

  $this->load->view('produksi/tabelakun');

}

function tabelbarang(){

  $data['departemen']  = $this->input->post('departemen');
  $this->load->view('produksi/tabelbarang',$data);

}

function detail_pemasukan(){

  $data ['data']		= $this->Model_produksi->getPemasukan()->row_array();
  $data ['detail']	= $this->Model_produksi->getDetailPemasukan();
  $this->load->view('produksi/detail_pemasukan',$data);

}

function detail_saldoawal(){

  $data ['data']    = $this->Model_produksi->getSaldoawal()->row_array();
  $data ['detail']  = $this->Model_produksi->getDetailSaldoAwal();
  $this->load->view('produksi/detail_saldoawal',$data);

}

function detail_opname(){

  $data ['data']    = $this->Model_produksi->getOpname()->row_array();
  $data ['detail']  = $this->Model_produksi->getDetailopnamestok();
  $this->load->view('produksi/detail_opname',$data);

}

function insert_produksi(){

  $this->Model_produksi->insert_produksi();

}

function detail_pengeluaran(){

  $data ['data']		= $this->Model_produksi->getPengeluaran()->row_array();
  $data ['detail']	= $this->Model_produksi->getDetailPengeluaran();
  $this->load->view('produksi/detail_pengeluaran',$data);

}

function view_detailpemasukan_temp(){

  $data ['data']	= $this->Model_produksi->getPemasukantemp();
  $this->load->view('produksi/view_detailpemasukan_temp',$data);

}

function view_detaileditpemasukan(){

  $data ['data']  = $this->Model_produksi->view_detaileditpemasukan();
  $this->load->view('produksi/view_detaileditpemasukan',$data);

}

function view_detaileditpengeluaran(){

  $data ['data']  = $this->Model_produksi->view_detaileditpengeluaran();
  $this->load->view('produksi/view_detaileditpengeluaran',$data);

}

function hapuspengeluaran(){

  $this->Model_produksi->hapuspengeluaran();
  redirect('produksi/pengeluaran');

}

function hapuspemasukan(){

  $this->Model_produksi->hapuspemasukan();
  redirect('produksi/pemasukan');

}

function hapussaldoawal(){

  $this->Model_produksi->hapussaldoawal();
  redirect('produksi/saldoawal');

}

function hapusopname(){

  $this->Model_produksi->hapusopname();
  redirect('produksi/opname');

}

function insert_pemasukan(){

  $this->Model_produksi->insert_pemasukan();

}

function hapus_detailpemasukan_temp(){

  $this->Model_produksi->hapus_detailpemasukan_temp();

}

function hapus_detaileditpemasukan(){

  $this->Model_produksi->hapus_detaileditpemasukan();

}


function hapus_detaileditpengeluaran(){

  $this->Model_produksi->hapus_detaileditpengeluaran();

}

function inputpemasukan_temp(){

  $this->Model_produksi->insertpemasukan_temp();

}

function inputeditpengeluaran(){

  $this->Model_produksi->inputeditpengeluaran();

}

function inputeditpemasukan(){

  $this->Model_produksi->inputeditpemasukan();

}

function update_pemasukan(){

  $this->Model_produksi->update_pemasukan();

}

function update_pengeluaran(){

  $this->Model_produksi->update_pengeluaran();

}

function view_pengeluaran(){

  $this->template->load('template/template','produksi/view_pengeluaran');

}

function input_pengeluaran(){

  $data ['dept']   	= $this->Model_produksi->getDept()->result();
  $this->template->load('template/template','produksi/input_pengeluaran',$data);

}

function view_detailpengeluaran_temp(){

  $data ['data']	= $this->Model_produksi->getPengeluarantemp();
  $this->load->view('produksi/view_detailpengeluaran_temp',$data);

}

function insert_pengeluaran(){

  $this->Model_produksi->insert_pengeluaran();

}

function hapus_detailpengeluaran_temp(){

  $this->Model_produksi->hapus_detailpengeluaran_temp();

}

function inputpengeluaran_temp(){

  $this->Model_produksi->insertpengeluaran_temp();

}

function jsonPilihBarang() {

  header('Content-Type: application/json');
  echo $this->Model_produksi->jsonPilihBarang();

}

function jsonPilihAkun() {

  header('Content-Type: application/json');
  echo $this->Model_produksi->jsonPilihAkun();

}

}
