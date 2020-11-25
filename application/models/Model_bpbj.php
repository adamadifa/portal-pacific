<?php

class Model_bpbj extends CI_Model
{

	function insert_detailtmp()
	{

		$kode_produk 	= $this->input->post('kode_produk');
		$shift 			= $this->input->post('shift');
		$jumlah 		= $this->input->post('jumlah');
		$id_admin 		= $this->session->userdata('id_user');
		$data = array(

			'kode_produk' => $kode_produk,
			'shift'		  => $shift,
			'jumlah'	  => $jumlah,
			'inout'		  => 'IN',
			'id_admin'	  => $id_admin

		);

		$this->db->insert('detail_mutasi_produksi_temp', $data);
	}

	function view_detailbpbj_temp($id_admin, $inout, $kode_produk)
	{

		$this->db->where('id_admin', $id_admin);
		$this->db->where('inout', $inout);
		$this->db->where('detail_mutasi_produksi_temp.kode_produk', $kode_produk);
		$this->db->order_by('shift', 'ASC');
		$this->db->join('master_barang', 'detail_mutasi_produksi_temp.kode_produk=master_barang.kode_produk');
		return $this->db->get('detail_mutasi_produksi_temp');
	}

	function hapus_detailbpbjtmp($kode_produk, $id_admin, $shift)
	{

		$this->db->delete('detail_mutasi_produksi_temp', array('kode_produk' => $kode_produk, 'id_admin' => $id_admin, 'shift' => $shift, 'inout' => 'IN'));
	}

	function cek_detailtmpbpbj()
	{

		$kode_produk = $this->input->post('kode_produk');
		$shift		 	= $this->input->post('shift');
		$tgl_bpbj	 	= $this->input->post('tgl_bpbj');
		$this->db->where('jenis_mutasi', 'BPBJ');
		$this->db->where('kode_produk', $kode_produk);
		$this->db->where('shift', $shift);
		$this->db->where('tgl_mutasi_produksi', $tgl_bpbj);
		$this->db->join('mutasi_produksi', 'detail_mutasi_produksi.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi');
		return $this->db->get('detail_mutasi_produksi');
	}

	function cek_detailtmp()
	{

		$kode_produk = $this->input->post('kode_produk');
		$shift		 = $this->input->post('shift');

		$this->db->where('inout', 'IN');
		$this->db->where('kode_produk', $kode_produk);
		$this->db->where('shift', $shift);
		return $this->db->get('detail_mutasi_produksi_temp');
	}

	function insert_bpbj()
	{

		$no_bpbj 	= $this->input->post('no_bpbj');
		$tgl_bpbj	= $this->input->post('tgl_bpbj');
		$inout 		= 'IN';
		$kode_produk = $this->input->post('kodebarang');
		$id_admin	= $this->session->userdata('id_user');

		$data 	= array(

			'no_mutasi_produksi' 	=> $no_bpbj,
			'tgl_mutasi_produksi' 	=> $tgl_bpbj,
			'inout'					=> $inout,
			'id_admin'				=> $id_admin,
			'jenis_mutasi'			=> 'BPBJ'
		);

		$cek = $this->db->get_where('mutasi_produksi', array('no_mutasi_produksi' => $no_bpbj))->num_rows();

		if ($cek != 0) {

			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-red text-white alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="fa fa-info"></i> No BPBJ Sudah Digunakan !

	          </div>'
			);

			redirect('bpbj/input_bpbj');
		} else {

			$bpbj = $this->db->insert('mutasi_produksi', $data);
			if ($bpbj) {

				$detail = $this->db->get_where('detail_mutasi_produksi_temp', array('id_admin' => $id_admin, 'kode_produk' => $kode_produk, 'inout' => 'IN'))->result();
				foreach ($detail as $d) {

					$data_detail = array(
						'no_mutasi_produksi' => $no_bpbj,
						'kode_produk'		 => $d->kode_produk,
						'shift'				 => $d->shift,
						'jumlah'			 => $d->jumlah

					);

					$this->db->insert('detail_mutasi_produksi', $data_detail);
				}

				$this->db->delete('detail_mutasi_produksi_temp', array('id_admin' => $id_admin, 'kode_produk' => $kode_produk, 'inout' => 'IN'));

				$this->session->set_flashdata(
					'msg',

					'<div class="alert bg-green text-white alert-dismissible" role="alert">

		              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		                 <i class="fa fa-check"></i> Data Berhasil Disimpan !

		          </div>'
				);

				redirect('bpbj/view_bpbj');
			}
		}
	}

	function getNoBpbjLast($kode_produk, $tgl_bpbj)
	{


		$kode 			= strlen($kode_produk);
		$no_bpbj 		= $kode + 2;

		$query 			= "SELECT LEFT(no_mutasi_produksi,$no_bpbj) as no_bpbj
						  FROM mutasi_produksi WHERE LEFT(no_mutasi_produksi,$kode)='$kode_produk'
						  AND tgl_mutasi_produksi = '$tgl_bpbj' AND jenis_mutasi='BPBJ' ORDER by LEFT(no_mutasi_produksi,$no_bpbj) DESC";
		return $this->db->query($query);
	}

	function getNoLainlainLast($kode_produk, $tgl_mutasi)
	{


		$kode 			= strlen($kode_produk);
		$no_mutasi 		= $kode + 3;

		$query 			= "SELECT LEFT(no_mutasi_produksi,$no_mutasi) as no_mutasi
						  FROM mutasi_produksi WHERE LEFT(no_mutasi_produksi,$kode)='$kode_produk'
						  AND tgl_mutasi_produksi = '$tgl_mutasi' AND jenis_mutasi='Lain-lain' ORDER by LEFT(no_mutasi_produksi,$no_mutasi) DESC";
		return $this->db->query($query);
	}

	public function getDataBpbj($rowno, $rowperpage, $nomutasi = "", $tglmutasi = "")
	{
		$this->db->where('jenis_mutasi', 'BPBJ');
		$this->db->select('*');
		$this->db->from('mutasi_produksi');
		$this->db->order_by('tgl_mutasi_produksi,time_stamp', 'desc');

		if ($nomutasi != '') {
			$this->db->where('no_mutasi_produksi', $nomutasi);
		}

		if ($tglmutasi != '') {
			$this->db->where('tgl_mutasi_produksi', $tglmutasi);
		}

		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	// Select total records
	public function getrecordBpbjCount($nomutasi = "", $tglmutasi = "")
	{
		$this->db->where('jenis_mutasi', 'BPBJ');
		$this->db->where('inout', 'IN');
		$this->db->select('count(*) as allcount');
		$this->db->from('mutasi_produksi');

		if ($nomutasi != '') {
			$this->db->where('no_mutasi_produksi', $nomutasi);
		}

		if ($tglmutasi != '') {
			$this->db->where('tgl_mutasi_produksi', $tglmutasi);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}


	function hapus($nomutasi, $hal)
	{
		if (!empty($hal)) {
			$hal = $hal;
		} else {
			$hal = "";
		}
		$hapus = $this->db->delete('mutasi_produksi', array('no_mutasi_produksi' => $nomutasi));
		if ($hapus) {

			$this->db->delete('detail_mutasi_produksi', array('no_mutasi_produksi' => $nomutasi));
			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-green text-white alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="fa fa-check"></i> Data Berhasil Disimpan !

	          </div>'
			);

			redirect('bpbj/view_bpbj/' . $hal);
		}
	}


	function hapus_lainlain($nomutasi)
	{

		$hapus = $this->db->delete('mutasi_produksi', array('no_mutasi_produksi' => $nomutasi));
		if ($hapus) {

			$this->db->delete('detail_mutasi_produksi', array('no_mutasi_produksi' => $nomutasi));
			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-green alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !

	          </div>'
			);

			redirect('bpbj/lainlain');
		}
	}


	function detail_mutasi($nomutasi)
	{

		$this->db->where('no_mutasi_produksi', $nomutasi);
		$this->db->join('master_barang', 'detail_mutasi_produksi.kode_produk=master_barang.kode_produk');
		return $this->db->get('detail_mutasi_produksi');
	}


	function getMutasi($nomutasi)
	{

		$this->db->where('no_mutasi_produksi', $nomutasi);
		return $this->db->get('mutasi_produksi');
	}


	function insertlainlain()
	{


		$nomutasi 	= $this->input->post('no_mutasi');
		$tglmutasi  = $this->input->post('tgl_mutasi');
		$kodebarang = $this->input->post('kodebarang');
		$jumlah 	= $this->input->post('jumlah');
		$inout 		= $this->input->post('inout');
		$id_admin 	= $this->input->post('id_user');

		$data 	= array(

			'no_mutasi_produksi' => $nomutasi,
			'tgl_mutasi_produksi' => $tglmutasi,
			'inout'							 => $inout,
			'id_admin'			 		 => $id_admin,
			'jenis_mutasi'		 	=> 'LAIN-LAIN'


		);

		$mutasi = $this->db->insert('mutasi_produksi', $data);
		if ($mutasi) {

			$data_detail = array(
				'no_mutasi_produksi'	=> $nomutasi,
				'kode_produk' 				=> $kodebarang,
				'jumlah'							=> $jumlah
			);

			$this->db->insert('detail_mutasi_produksi', $data_detail);
			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-green alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !

	          </div>'
			);

			redirect('bpbj/lainlain');
		}
	}



	public function getDataLainlain($rowno, $rowperpage, $nomutasi = "", $tglmutasi = "")
	{
		$this->db->where('jenis_mutasi', 'LAIN-LAIN');
		$this->db->select('*');
		$this->db->from('mutasi_produksi');
		$this->db->order_by('tgl_mutasi_produksi,time_stamp', 'desc');

		if ($nomutasi != '') {
			$this->db->where('no_mutasi_produksi', $nomutasi);
		}

		if ($tglmutasi != '') {
			$this->db->where('tgl_mutasi_produksi', $tglmutasi);
		}

		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	// Select total records
	public function getrecordLainlainCount($nomutasi = "", $tglmutasi = "")
	{
		$this->db->where('jenis_mutasi', 'LAIN-LAIN');
		//$this->db->where('inout','IN');
		$this->db->select('count(*) as allcount');
		$this->db->from('mutasi_produksi');

		if ($nomutasi != '') {
			$this->db->where('no_mutasi_produksi', $nomutasi);
		}

		if ($tglmutasi != '') {
			$this->db->where('tgl_mutasi_produksi', $tglmutasi);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}
}
