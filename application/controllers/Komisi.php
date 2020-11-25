<?php 
class Komisi extends CI_Controller{
	function __construct(){
		parent::__construct();
		 check_login();
		 $this->load->Model(array('Model_cabang','Model_komisi','Model_sales'));
  }

  function penerimakomisi()
  {
    $cbg="";
    if($this->input->post('submit') != NULL ){
      $cbg      = $this->input->post('cabang');
      $data     = array('cbg'=> $cbg);
      $this->session->set_userdata($data);
    }else{
      if($this->session->userdata('cbg') != NULL){
        $cbg = $this->session->userdata('cbg');
      }
    }

    $data['cbg'] = $cbg;
    $data['penerima'] = $this->Model_komisi->getPenerimakomisi($cbg)->result();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $this->template->load('template/template','komisi/komisi_penerima',$data);
  }

  function inputpenerima()
  {
    if(isset($_POST['submit'])){
      $this->Model_komisi->inputpenerima();
    }else{
      
      $data['jabatan'] = $this->Model_komisi->getJabatan()->result();
      $data['cabang'] = $this->Model_cabang->view_cabang()->result();
      $data['cbg'] = $this->input->post('cabang');
      $data['sales'] = $this->Model_sales->get_salescab($data['cbg'])->result();
      $data['nik'] = $this->Model_komisi->getLastnik($data['cbg']);
      $this->load->view('komisi/komisi_penerima_input',$data);
    }
    
  }

  function editpenerima()
  {
    if(isset($_POST['submit'])){
      $this->Model_komisi->updatepenerima();
    }else{
      $nik = $this->input->post('nik');
      $data['jabatan'] = $this->Model_komisi->getJabatan()->result();
      $data['cabang'] = $this->Model_cabang->view_cabang()->result();
      $data['penerima'] = $this->Model_komisi->getPenerimaID($nik)->row_array();
      $data['sales'] = $this->Model_sales->get_salescab($data['penerima']['kode_cabang'])->result();
      $this->load->view('komisi/komisi_penerima_edit',$data);
    }
    
  }

  function hapuspenerima()
  {
    $nik = $this->uri->segment(3);
    $this->Model_komisi->hapuspenerima($nik);
  }

  function targetkomisi()
  {
    $cbg="";
    $bln="";
    $thn="";
    if($this->input->post('submit') != NULL ){
      $cbg      = $this->input->post('cabang');
      $bln      = $this->input->post('bulan');
      $thn      = $this->input->post('tahun');
      $data     = array('cbg'=> $cbg,'bln'=>$bln,'thn'=>$thn);
      $this->session->set_userdata($data);
    }else{
      if($this->session->userdata('cbg') != NULL){
        $cbg = $this->session->userdata('cbg');
      }

      if($this->session->userdata('bln') != NULL){
        $bln = $this->session->userdata('bln');
      }

      if($this->session->userdata('thn') != NULL){
        $thn = $this->session->userdata('thn');
      }
    }

    $data['cbg'] = $cbg;
    $data['penerima'] = $this->Model_komisi->getTargetPerBulan($cbg,$bln,$thn)->result();
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['bulan'] = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['bln'] = $bln;
    $data['thn'] = $thn;
    $data['tahun'] = date("Y");
    $this->template->load('template/template','komisi/komisi_target',$data);
  }

  function updatetarget()
  {
    $this->Model_komisi->updatetarget();
  }

  function rangekomisi()
  {
    $cbg="";
    $bln="";
    $thn="";
    $kode="";
    if($this->input->post('submit') != NULL ){
      $this->Model_komisi->simpanrange();
      $cbg      = $this->input->post('cabang');
      $bln      = $this->input->post('bulan');
      $thn      = $this->input->post('tahun');
      $kode     = $this->input->post('kode_range');
      $data     = array('cbg'=> $cbg,'bln'=>$bln,'thn'=>$thn,'kode'=>$kode);
      $this->session->set_userdata($data);
    }else{
      if($this->session->userdata('cbg') != NULL){
        $cbg = $this->session->userdata('cbg');
      }

      if($this->session->userdata('bln') != NULL){
        $bln = $this->session->userdata('bln');
      }

      if($this->session->userdata('thn') != NULL){
        $thn = $this->session->userdata('thn');
      }

      if($this->session->userdata('kode') != NULL){
        $kode = $this->session->userdata('kode');
      }
    }

    $data['cbg'] = $cbg;
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['bulan'] = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['bln'] = $bln;
    $data['thn'] = $thn;
    $data['tahun'] = date("Y");
    $this->template->load('template/template','komisi/komisi_range',$data);
  }

  function updaterasiokacab()
  {
    $this->Model_komisi->updaterasiokacab();
  }

  function updaterasiospv()
  {
    $this->Model_komisi->updaterasiospv();
  }

  function updaterasiosales()
  {
    $this->Model_komisi->updaterasiosales();
  }

  function updaterasiodriverhelper()
  {
    $this->Model_komisi->updaterasiodriverhelper();
  }

  function updaterasiokepalagudang()
  {
    $this->Model_komisi->updaterasiokepalagudang();
  }

  function updaterasiogudang()
  {
    $this->Model_komisi->updaterasiogudang();
  }

  function resetrasio(){
    $kode_range = $this->input->post('kode_range');
    $this->Model_komisi->resetrasio($kode_range);
  }

  function kriteriakomisi()
  {
    $cbg="";
    $bln="";
    $thn="";
    $kode="";
    if($this->input->post('submit') != NULL ){
      $this->Model_komisi->simpankriteriakomisi();
      $cbg      = $this->input->post('cabang');
      $bln      = $this->input->post('bulan');
      $thn      = $this->input->post('tahun');
      $kode     = $this->input->post('kode_range');
      $data     = array('cbg'=> $cbg,'bln'=>$bln,'thn'=>$thn,'kode'=>$kode);
      $this->session->set_userdata($data);
    }else{
      if($this->session->userdata('cbg') != NULL){
        $cbg = $this->session->userdata('cbg');
      }

      if($this->session->userdata('bln') != NULL){
        $bln = $this->session->userdata('bln');
      }

      if($this->session->userdata('thn') != NULL){
        $thn = $this->session->userdata('thn');
      }

      if($this->session->userdata('kode') != NULL){
        $kode = $this->session->userdata('kode');
      }
    }

    $data['cbg'] = $cbg;
    $data['cabang'] = $this->Model_cabang->view_cabang()->result();
    $data['kriteria'] = $this->Model_komisi->getKriteria($cbg,$bln,$thn)->result();
    $data['bulan'] = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $data['bln'] = $bln;
    $data['thn'] = $thn;
    $data['tahun'] = date("Y");
    $this->template->load('template/template','komisi/komisi_kriteria',$data);
  }

  function updatepoinkriteria()
  {
    $updatepoin = $this->Model_komisi->updatepoinkriteria();
    echo $updatepoin;
  }

  function updatepersentasekriteria()
  {
    $updatepersentasekriteria = $this->Model_komisi->updatepersentasekriteria();
    echo $updatepersentasekriteria;
  }

  function resetsetkriteria(){
    $kode_setkriteria = $this->input->post('kode_setkriteria');
    $this->Model_komisi->resetsetkriteria($kode_setkriteria);
  }
  
}