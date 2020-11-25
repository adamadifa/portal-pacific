<?php

Class Model_coa extends CI_Model{

  function view_coa(){
    return $this->db->get_where('coa',array('sub_akun'=>0));
	}

  function view_coaall(){
    return $this->db->get('coa');
	}

  function insert_coa(){

    $kode_akun  = $this->input->post('kode_akun');
    $nama_akun  = $this->input->post('nama_akun');
    $sub_akun   = $this->input->post('sub_akun');

    $data = array(
      'kode_akun' => $kode_akun,
      'nama_akun' => $nama_akun,
      'sub_akun'  => $sub_akun

    );

    $simpan = $this->db->insert('coa',$data);
    if($simpan){
      $this->session->set_flashdata('msg',

          '<div class="alert bg-green alert-dismissible" role="alert">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                   <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Akun Berhasil Disimpan !

            </div>');

        redirect('coa');
    }
  }

  function hapus($id){
    $hapus = $this->db->delete('coa',array('kode_akun'=>$id));
    if($hapus){
      $this->session->set_flashdata('msg',

          '<div class="alert bg-green alert-dismissible" role="alert">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                   <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Akun Berhasil Di Hapus !

            </div>');

        redirect('coa');
    }
  }

  function get_coa($kode_akun){
    return $this->db->get_where('coa',array('kode_akun'=>$kode_akun));
  }

  function input_set_coa_cabang(){
    $cabang     = $this->input->post('cabang');
    $kodeakun   = $this->input->post('kodeakun');
    $kategori   = $this->input->post('kategori');

    $data = array(
      'kode_cabang' => $cabang,
      'kode_akun'   => $kodeakun,
      'kategori'    => $kategori
    );
    $cek = $this->db->get_where('set_coa_cabang',array('kode_cabang'=>$cabang,'kode_akun'=>$kodeakun))->num_rows();
    if($cek==0){
      $this->db->insert('set_coa_cabang',$data);
    }else{
      echo "1";
    }

  }

  function view_set_coa_cabang($cabang,$kategori){
    $this->db->select('id_setakuncabang,set_coa_cabang.kode_cabang,set_coa_cabang.kode_akun,nama_akun,kategori');
    $this->db->from('set_coa_cabang');
    $this->db->join('coa','set_coa_cabang.kode_akun=coa.kode_akun');
    $this->db->where('kode_cabang',$cabang);
    $this->db->where('kategori',$kategori);
    return $this->db->get();
  }

  function hapus_setcoa($id){
    $this->db->delete('set_coa_cabang',array('id_setakuncabang'=>$id));
  }




}
