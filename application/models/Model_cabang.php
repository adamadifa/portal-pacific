<?php

class Model_cabang extends CI_Model{


	function view_cabang(){
		$cabang = $this->session->userdata('cabang');
		if($cabang != "pusat"){

			$this->db->where('kode_cabang',$cabang);
		}

		return $this->db->get('cabang');
	}

	function get_cabang($kode_cabang){

		$this->db->where('kode_cabang',$kode_cabang);
		return $this->db->get('cabang');
	}

	function insert_cabang(){

		$kodecabang = $this->input->post('kodecabang');
		$namacabang = $this->input->post('namacabang');
		$alamat		= $this->input->post('alamatcabang');
		$telepon 	= $this->input->post('teleponcabang');

		$data = array(

			'kode_cabang' 	=> $kodecabang,
			'nama_cabang' 	=> $namacabang,
			'alamat_cabang'	=> $alamat,
			'telepon' 		=> $telepon

		);


		$cek_data = $this->db->get_where('cabang',array('kode_cabang'=>$kodecabang));

		if($cek_data->num_rows() != 0){

			$this->db->update('cabang',$data,array('kode_cabang'=>$kodecabang));
		}else{

			$this->db->insert('cabang',$data);
		}


	}


	function hapus($id){

		$this->db->delete('cabang',array('kode_cabang'=>$id));
	}


}