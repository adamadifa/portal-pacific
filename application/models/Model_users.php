<?php

class Model_users extends CI_Model{


	function view_users(){
		$users = $this->session->userdata('users');
		if($users != ""){

			$this->db->where('id_user',$users);
		}
		return $this->db->query("SELECT * FROM users ORDER BY nama_lengkap");
	}

	function get_users($id_user){

		$this->db->where('id_user',$id_user);
		return $this->db->get('users');
	}

	function insert_users(){

		$id_user = $this->input->post('id_user');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$username 	= $this->input->post('username');
    $password   = $this->input->post('password');
    $level   = $this->input->post('level');
    $cabang   = $this->input->post('cabang');

		$data = array(

			'id_user' 	=> $id_user,
			'nama_lengkap' 	=> $nama_lengkap,
			'no_hp'	=> "",
			'username' 		=> $username,
      'password'    => $password,
      'level'    => $level,
      'cabang'    => $cabang

		);


		$cek_data = $this->db->get_where('users',array('id_user'=>$id_user));

		if($cek_data->num_rows() != 0){

			$this->db->update('users',$data,array('id_user'=>$id_user));
		}else{

			$this->db->insert('users',$data);
		}


	}


	function hapus($kodeusers){

		$this->db->delete('users',array('id_user'=>$kodeusers));
	}


}