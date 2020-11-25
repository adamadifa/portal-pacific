<?php

class Model_target extends CI_Model{

	function loadbarang($kode_cabang){
		$this->db->where('kode_cabang',$kode_cabang);
		$this->db->order_by('kode_produk','ASC');
		return $this->db->get('barang');
	}


	function insert_targettahun(){
		$tahun 		= $this->input->post('tahun');
		$cabang		= $this->input->post('cabang');
		$cektemp 	= $this->db->get_where('target_pertahuncabangtemp',array('kode_cabang'=>$cabang,'tahun'=>$tahun))->result();
		foreach($cektemp as $r){
			$data = array(
				'tahun' 		=> $r->tahun,
				'kode_produk'	=> $r->kode_produk,
				'kode_cabang' 	=> $r->kode_cabang,
				'target_tahun' 	=> $r->target_tahun
			);
			$this->db->insert('target_pertahuncabang',$data);
		}
		$this->db->delete('target_pertahuncabangtemp',array('kode_cabang'=>$cabang,'tahun'=>$tahun));
		$this->session->set_flashdata('msg',
		'<div class="alert bg-green alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
		  </div>');
	   redirect('target/targettahun');
	}



	function insert_targetbulan(){

		$tahun 		= $this->input->post('tahun');
		$bulan 		= $this->input->post('bulan');
		$cabang		= $this->input->post('cabang');
		$cektemp 	= $this->db->get_where('target_bulancabangtemp',array('kode_cabang'=>$cabang,'tahun'=>$tahun,'bulan'=>$bulan))->result();
		foreach($cektemp as $r){
			$data = array(
				'tahun' 		=> $r->tahun,
				'bulan'			=> $r->bulan,
				'kode_produk'	=> $r->kode_produk,
				'kode_cabang' 	=> $r->kode_cabang,
				'target_bulan' 	=> $r->target_bulan
			);
			$this->db->insert('target_bulancabang',$data);
		}
		$this->db->delete('target_bulancabangtemp',array('kode_cabang'=>$cabang,'tahun'=>$tahun,'bulan'=>$bulan));
		$this->session->set_flashdata('msg',
		'<div class="alert bg-green alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Simpan !
		  </div>');
	   redirect('target/targetbulan');
	}



	function insert_targettahuntemp(){
		$tahun 		 = $this->input->post('tahun');
		$kode_barang = $this->input->post('kode_barang');
		$cabang 	 = $this->input->post('cabang');
		$jumlah      = $this->input->post('jumlah');
		$id_admin    = $this->session->userdata('id_user');
		$data = array(
			'tahun' 	  => $tahun,
			'kode_produk' => $kode_barang,
			'kode_cabang' => $cabang,
			'target_tahun'=> $jumlah,
			'id_admin' 	  => $id_admin

		);

		$cektemp = $this->db->get_where('target_pertahuncabangtemp',array('kode_produk'=>$kode_barang,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		$cek	 = $this->db->get_where('target_pertahuncabang',array('kode_produk'=>$kode_barang,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		if(!empty($cektemp) OR !empty($cek)){
			echo "1";
		}else{
			$this->db->insert('target_pertahuncabangtemp',$data);
		}
	}

	function insert_targetbulantemp(){
		$tahun 		 		= $this->input->post('tahun');
		$bulan 		 		= $this->input->post('bulan');
		$kode_barang 	= $this->input->post('kode_barang');
		$cabang 	 		= $this->input->post('cabang');
		$jumlah      	= $this->input->post('jumlah');
		$id_admin    	= $this->session->userdata('id_user');
		$data = array(
			'tahun' 	  	=> $tahun,
			'bulan'		  	=> $bulan,
			'kode_produk' => $kode_barang,
			'kode_cabang' => $cabang,
			'target_bulan'=> $jumlah,
			'id_admin' 	  => $id_admin
		);
		$cektemp 	= $this->db->get_where('target_bulancabangtemp',array('kode_produk'=>$kode_barang,'tahun'=>$tahun,'bulan'=>$bulan,'kode_cabang'=>$cabang))->num_rows();
		$cek	 		= $this->db->get_where('target_bulancabang',array('kode_produk'=>$kode_barang,'tahun'=>$tahun,'bulan'=>$bulan,'kode_cabang'=>$cabang))->num_rows();
		if(!empty($cektemp) OR !empty($cek)){
			echo "1";
		}else{
			$this->db->insert('target_bulancabangtemp',$data);
		}
	}

	function view_targettahuntemp(){
		$cabang = $this->uri->segment(3);
		$tahun  = $this->uri->segment(4);
		$this->db->join('master_barang','target_pertahuncabangtemp.kode_produk = master_barang.kode_produk');
		return $this->db->get_where('target_pertahuncabangtemp',array('target_pertahuncabangtemp.kode_cabang'=>$cabang,'tahun'=>$tahun));
	}

	function view_targetbulantemp(){
		$cabang = $this->uri->segment(3);
		$bulan  = $this->uri->segment(4);
		$tahun  = $this->uri->segment(5);
		$this->db->join('master_barang','target_bulancabangtemp.kode_produk = master_barang.kode_produk');
		return $this->db->get_where('target_bulancabangtemp',array('target_bulancabangtemp.kode_cabang'=>$cabang,'bulan'=>$bulan,'tahun'=>$tahun));
	}

	function hapus_targettahuntemp($kodebarang,$cabang,$tahun){
		$this->db->delete('target_pertahuncabangtemp',array('kode_produk'=>$kodebarang,'kode_cabang'=>$cabang,'tahun'=>$tahun));
	}

	function hapus_targetbulantemp($kodebarang,$cabang,$tahun,$bulan){
		$this->db->delete('target_pengirimantemp',array('kode_produk'=>$kodebarang,'kode_cabang'=>$cabang,'tahun'=>$tahun,'bulan'=>$bulan));
	}

	public function getDataTargettahun($rowno,$rowperpage,$cabang = "",$tahun = "") {
    $this->db->select('tahun,kode_cabang');
    $this->db->from('target_pertahuncabang');
 	  $this->db->join('master_barang','target_pertahuncabang.kode_produk = master_barang.kode_produk');
    $this->db->group_by('tahun,kode_cabang');
    if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }
    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
   }

  // Select total records
  public function getrecordTargettahunCount($cabang = "" ,$tahun="") {
	  if($cabang 	!= ""){
			$cabang = "AND kode_cabang = '".$cabang."' ";
		}
		if($tahun 	!= ""){
			$tahun = "AND tahun = '".$tahun."' ";
		}
	  $query = "SELECT COUNT(*) as allcount FROM
	    			 ( SELECT tahun,kode_cabang FROM target_pertahuncabang
		 				 INNER JOIN master_barang ON target_pertahuncabang.kode_produk = master_barang.kode_produk
		 			 	 WHERE tahun !=''"
		 			 	.$cabang
		 				.$tahun
		 				."
		 				GROUP BY tahun,kode_cabang
		) as t";
    $query  = $this->db->query($query);
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


	public function getDataTargetbulan($rowno,$rowperpage,$cabang = "",$tahun = "",$bulan="") {
  	$this->db->select('tahun,bulan,kode_cabang');
    $this->db->from('target_bulancabang');
	  $this->db->join('master_barang','target_bulancabang.kode_produk = master_barang.kode_produk');
	  $this->db->group_by('tahun,bulan,kode_cabang');
    if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }
    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
	  if($bulan != ''){
      $this->db->where('bulan', $bulan);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

    // Select total records
  public function getrecordTargetbulanCount($cabang = "" ,$tahun="",$bulan="") {

    if($cabang 	!= ""){
			$cabang = "AND kode_cabang = '".$cabang."' ";
		}
		if($tahun 	!= ""){
			$tahun = "AND tahun = '".$tahun."' ";
		}
		if($bulan 	!= ""){
			$bulan = "AND bulan = '".$bulan."' ";
		}

   $query = "SELECT COUNT(*) as allcount FROM
				    ( SELECT tahun,bulan,kode_cabang FROM target_bulancabang
					 INNER JOIN master_barang ON target_bulancabang.kode_produk = master_barang.kode_produk
					 WHERE tahun !=''"
					 .$cabang
					 .$tahun
					 .$bulan
					 ."
					 GROUP BY tahun,kode_cabang,bulan
					) as t";

    $query  = $this->db->query($query);
    $result = $query->result_array();
    return $result[0]['allcount'];
  }
	function hapus_all_targettahun($tahun,$cabang){
		$hapus = $this->db->delete('target_pertahuncabang',array('tahun'=>$tahun,'kode_cabang'=>$cabang));
		if($hapus){
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
			  </div>');
			redirect('target/targettahun');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Di Hapus !
			  </div>');
			redirect('target/targettahun');
		}
	}


	function detail_target_tahun($tahun,$cabang){
		$this->db->where('tahun',$tahun);
		$this->db->where('kode_cabang',$cabang);
		$this->db->order_by('target_pertahuncabang.kode_produk','ASC');
		$this->db->select('id_targettahun,target_pertahuncabang.kode_produk,nama_barang,target_tahun');
		$this->db->from('target_pertahuncabang');
		$this->db->join('master_barang','target_pertahuncabang.kode_produk = master_barang.kode_produk');
		return $this->db->get();
	}

	function detail_target_bulan($tahun,$cabang,$bulan){
		$this->db->where('tahun',$tahun);
		$this->db->where('bulan',$bulan);
		$this->db->where('kode_cabang',$cabang);
		$this->db->order_by('target_bulancabang.kode_produk','ASC');
		$this->db->select('id_targetbulan,target_bulancabang.kode_produk,nama_barang,target_bulan');
		$this->db->from('target_bulancabang');
		$this->db->join('master_barang','target_bulancabang.kode_produk = master_barang.kode_produk');
		return $this->db->get();
	}

	function hapus_target_produk_tahun($id){
		$hapus = $this->db->delete('target_pertahuncabang',array('id_targettahun'=>$id));
		if($hapus){
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
			  </div>');
			redirect('target/targettahun');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Di Hapus !
			  </div>');
			redirect('target/targettahun');
		}
	}

	function hapus_target_produk_bulan($id){
		$hapus = $this->db->delete('target_bulancabang',array('id_targetbulan'=>$id));
		if($hapus){
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
			  </div>');
			redirect('target/targetbulan');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Di Hapus !
			  </div>');
			redirect('target/targetbulan');
		}
	}

	function view_targetbulan(){
		$this->db->select('id_targetbulan,tahun,bulan,target_bulancabang.kode_barang,kode_produk,nama_barang,target_bulan,kode_cabang');
		$this->db->from('target_bulancabang');
		$this->db->join('barang','target_bulancabang.kode_barang = barang.kode_barang');
		return $this->db->get();
	}


}
