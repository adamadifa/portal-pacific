<?php 

class Model_menu extends CI_Model{

	function get_Menuparent(){

	
		return $this->db->get('menu');
	}

	function view_menu(){

		return $this->db->get('menu');
	}

	function hapus($id){

		$this->db->delete('menu',array('id'=>$id));
	}



	function insert_menu(){
		$id 			= $this->input->post('id');
		$namamenu 		= $this->input->post('namamenu');
		$link 	  		= $this->input->post('link');
		$icon	  		= $this->input->post('icon');
		$parentmenu		= $this->input->post('parentmenu');
		$role 			= $this->input->post('role');
		$status 		= $this->input->post('status');

		$data = array(

				'name' 		=> $namamenu,
				'link' 		=> $link,
				'icon' 		=> $icon,
				'is_active' => $status,
				'is_parent' => $parentmenu,
				'role'		=> $role


		);


		if(!empty($id)){
			$this->db->update('menu',$data,array('id'=>$id));
		}else{
			$this->db->insert('menu',$data);
		}

	}

	function get_menu($id){

		return $this->db->get_where('menu',array('id'=>$id));
	}


}