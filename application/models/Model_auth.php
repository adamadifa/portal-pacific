<?php

class Model_auth extends CI_Model{

    function cek_user($username=null,$password=null){

      $this->db->where(array('username'=>$username,'password'=>$password));
      return $this->db->get('users');

    }
    function update_password($id_user){
    	$password_lama=$this->input->post('passwordlama');
    	$password_baru=$this->input->post('passwordbaru');
    	$cek=$this->db->get_where('users',array('id_user'=> $id_user,'password'=> md5($password_lama)))->num_rows();
    	if ($cek!=0){

    		$data=array(
    			'password'=>md5($password_baru)
    		);
    		$this->db->update('users',$data,array('id_user'=>$id_user));
    		$this->session->set_flashdata('msg',

	        '<div class="alert bg-green alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Password Berhasil Di Ubah !

	          </div>');
    		redirect('setting/ubah_password');
    	}

    }
}
