<?php

class Model_sales extends CI_Model{


	function view_sales(){

		$cabang = $this->session->userdata('cabang');
    if($cabang != "pusat"){
      $this->db->where('karyawan.kode_cabang',$cabang);
    }
		$this->db->select('id_karyawan,nama_karyawan,alamat_karyawan,no_hp,nama_cabang');
		$this->db->from('karyawan');
		$this->db->join('cabang','karyawan.kode_cabang = cabang.kode_cabang');
		$this->db->where('nama_karyawan !=','-');
		return $this->db->get();

	}


	function get_salescab($kode_cabang){

		$this->db->where('kode_cabang',$kode_cabang);
		return $this->db->get('karyawan');

	}

	function get_sales($id_karyawan){

		$this->db->where('id_karyawan',$id_karyawan);
		return $this->db->get('karyawan');
	}



	function insert_sales(){


		$kodesales 		= $this->input->post('kodesales');
		$namasales		= $this->input->post('namasales');
		$alamatsales 	= $this->input->post('alamatsales');
		$no_hp 			= $this->input->post('no_hp');
		$cabang 		= $this->input->post('cabang');


		$data 			= array(


			'id_karyawan' 		=> $kodesales,
			'nama_karyawan'		=> $namasales,
			'alamat_karyawan'	=> $alamatsales,
			'no_hp' 			=> $no_hp,
			'kode_cabang' 		=> $cabang



		);

		$cek_data = $this->db->get_where('karyawan',array('id_karyawan'=>$kodesales));
		if($cek_data->num_rows() != 0){
			$this->db->update('karyawan',$data,array('id_karyawan'=>$kodesales));
		}else{

			$this->db->insert('karyawan',$data);

		}



	}

	function hapus($id){

		$this->db->delete('karyawan',array('id_karyawan'=>$id));


	}


}
