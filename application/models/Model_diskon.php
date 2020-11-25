<?php 

class Model_diskon extends CI_Model{


	function view_diskon(){

		return $this->db->get('diskon');

	}

	function getDiskon($id){

		return $this->db->get_where('diskon',array('id'=>$id));
	}

	function insertdiskon(){
		$id 	  = $this->input->post('id');
		$kategori = $this->input->post('kategori');
		$dari 	  = $this->input->post('dari');
		$sampai   = $this->input->post('sampai');
		$diskon   = $this->input->post('diskon');

		$data = array(

			'kategori' => $kategori,
			'dari'	   => $dari,
			'sampai'   => $sampai,
			'diskon'   => $diskon

		);

		$cek_data = $this->db->get_where('diskon',array('id'=>$id));

		if($cek_data->num_rows() != 0){
			$this->db->update('diskon',$data,array('id'=>$id));
		}else{

			$this->db->insert('diskon',$data);

		}

		
	}

	function hapus($id){


		$this->db->delete('diskon',array('id'=>$id));
	}


}