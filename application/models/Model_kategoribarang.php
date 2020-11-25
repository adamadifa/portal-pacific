<?php 

class Model_kategoribarang extends CI_Model{


	function view_kategori(){
    $kodedept = $this->session->userdata('dept');
    return $this->db->get_where('kategori_barang_pembelian',array('kode_dept'=>$kodedept));

  }

  function getkategori($kode_kategori){

    return $this->db->get_where('kategori_barang_pembelian',array('kode_kategori'=>$kode_kategori));
  }

  function insertkategori(){
    $kode_kategori 	  		= $this->input->post('kode_kategori');
    $kategori 						= $this->input->post('kategori');

    $data = array(

     'kode_kategori' 	=> $kode_kategori,
     'kategori'  			=> $kategori,
     'tanggal'   			=> date('Y-m-d')

   );

    $cek_data = $this->db->get_where('kategori_barang_pembelian',array('kode_kategori'=>$kode_kategori));

    if($cek_data->num_rows() != 0){
     $this->db->update('kategori_barang_pembelian',$data,array('kode_kategori'=>$kode_kategori));
   }else{

     $this->db->insert('kategori_barang_pembelian',$data);

   }


 }

 function hapus($kode_kategori){


  $this->db->delete('kategori_barang_pembelian',array('kode_kategori'=>$kode_kategori));
}


}