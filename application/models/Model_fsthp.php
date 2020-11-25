<?php

class Model_fsthp extends CI_Model
{

	public function getDataFsthp($rowno, $rowperpage, $nomutasi = "", $tglmutasi = "")
	{
		$this->db->where('jenis_mutasi', 'FSTHP');
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
	public function getrecordFsthpCount($nomutasi = "", $tglmutasi = "")
	{
		$this->db->where('jenis_mutasi', 'FSTHP');
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


	function cek_detailtmpfsthp()
	{
		$kode_produk = $this->input->post('kode_produk');
		$shift		 	 = $this->input->post('shift');
		$tgl_fsthp	 = $this->input->post('tgl_fsthp');
		$unit 			 = $this->input->post('unit');
		$this->db->where('jenis_mutasi', 'FSTHP');
		$this->db->where('kode_produk', $kode_produk);
		$this->db->where('shift', $shift);
		$this->db->where('tgl_mutasi_produksi', $tgl_fsthp);
		$this->db->where('unit', $unit);
		$this->db->join('mutasi_produksi', 'detail_mutasi_produksi.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi');
		return $this->db->get('detail_mutasi_produksi');
	}

	function cek_detailtmp()
	{
		$kode_produk = $this->input->post('kode_produk');
		$shift		 	 = $this->input->post('shift');
		$unit 			 = $this->input->post('unit');
		$this->db->where('inout', 'OUT');
		$this->db->where('kode_produk', $kode_produk);
		$this->db->where('shift', $shift);
		$this->db->where('unit', $unit);
		return $this->db->get('detail_mutasi_produksi_temp');
	}



	function insert_detailtmp()
	{
		$kode_produk 	= $this->input->post('kode_produk');
		$shift 				= $this->input->post('shift');
		$jumlah 			= $this->input->post('jumlah');
		$id_admin 		= $this->session->userdata('id_user');
		$unit 				= $this->input->post('unit');
		$data = array(
			'kode_produk' => $kode_produk,
			'shift'		  	=> $shift,
			'jumlah'	  	=> $jumlah,
			'inout'		  	=> 'OUT',
			'unit'				=> $unit,
			'id_admin'	  => $id_admin
		);

		$this->db->insert('detail_mutasi_produksi_temp', $data);
	}


	function view_detailfsthp_temp($id_admin, $inout, $kode_produk)
	{

		$this->db->where('id_admin', $id_admin);
		$this->db->where('inout', $inout);
		$this->db->where('detail_mutasi_produksi_temp.kode_produk', $kode_produk);
		$this->db->order_by('shift', 'ASC');
		$this->db->join('master_barang', 'detail_mutasi_produksi_temp.kode_produk=master_barang.kode_produk');
		return $this->db->get('detail_mutasi_produksi_temp');
	}


	function getNoFsthpLast($kode_produk, $tgl_fsthp)
	{


		$kode 				= strlen($kode_produk);
		$no_fsthp 		= $kode + 3;
		$query 				= "SELECT LEFT(no_mutasi_produksi,$no_fsthp) as no_fsthp
						  		  FROM mutasi_produksi WHERE MID(no_mutasi_produksi,2,$kode)='$kode_produk'
						  			AND tgl_mutasi_produksi = '$tgl_fsthp' AND jenis_mutasi='FSTHP' ORDER by LEFT(no_mutasi_produksi,$no_fsthp) DESC";
		return $this->db->query($query);
	}



	function insert_fsthp()
	{

		$no_fsthp				= $this->input->post('no_fsthp');
		$tgl_fsthp			= $this->input->post('tgl_fsthp');
		$inout 					= 'OUT';
		$kode_produk		= $this->input->post('kodebarang');
		$id_admin				= $this->session->userdata('id_user');
		$unit 					= $this->input->post('unit');
		$data 					= array(
			'no_mutasi_produksi' 		=> $no_fsthp,
			'tgl_mutasi_produksi' 	=> $tgl_fsthp,
			'inout'									=> $inout,
			'id_admin'							=> $id_admin,
			'jenis_mutasi'					=> 'FSTHP',
			'unit'								  => $unit
		);

		$cek 						= $this->db->get_where('mutasi_produksi', array('no_mutasi_produksi' => $no_fsthp))->num_rows();

		if ($cek != 0) {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-info"></i> No FSTHP Sudah Digunakan !
        </div>'
			);
			redirect('fsthp/input_fsthp');
		} else {
			$fsthp = $this->db->insert('mutasi_produksi', $data);
			if ($fsthp) {
				$detail = $this->db->get_where('detail_mutasi_produksi_temp', array('id_admin' => $id_admin, 'kode_produk' => $kode_produk, 'inout' => 'OUT'))->result();
				foreach ($detail as $d) {
					$data_detail = array(
						'no_mutasi_produksi' => $no_fsthp,
						'kode_produk'		 => $d->kode_produk,
						'shift'				 => $d->shift,
						'jumlah'			 => $d->jumlah
					);
					$this->db->insert('detail_mutasi_produksi', $data_detail);
				}
				$this->db->delete('detail_mutasi_produksi_temp', array('id_admin' => $id_admin, 'kode_produk' => $kode_produk, 'inout' => 'OUT'));
				$this->session->set_flashdata(
					'msg',
					'<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Disimpan !
        </div>'
				);
				redirect('fsthp/view_fsthp');
			}
		}
	}


	function detail_mutasi($nomutasi)
	{
		$this->db->order_by('shift', 'ASC');
		$this->db->where('no_mutasi_produksi', $nomutasi);
		$this->db->join('master_barang', 'detail_mutasi_produksi.kode_produk=master_barang.kode_produk');
		return $this->db->get('detail_mutasi_produksi');
	}


	function getMutasi($nomutasi)
	{

		$this->db->where('no_mutasi_produksi', $nomutasi);
		return $this->db->get('mutasi_produksi');
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

			redirect('fsthp/view_fsthp/' . $hal);
		}
	}

	function approve_fsthp($no_fsthp)
	{

		$fsthp 			= $this->db->get_where('mutasi_produksi', array('no_mutasi_produksi' => $no_fsthp))->row_array();
		$detail_fsthp	= $this->db->get_where('detail_mutasi_produksi', array('no_mutasi_produksi' => $no_fsthp))->result();
		$cek 			= $this->db->get_where('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_fsthp))->num_rows();
		$id_admin 		= $this->session->userdata('id_user');
		if ($cek != 0) {

			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-red text-white alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                <i class="fa fa-info"></i> Data Sudah Ada !

	          </div>'
			);

			redirect('fsthp/view_fsthp_gj');
		} else {

			$data_fsthp = array(

				'no_mutasi_gudang' 	=> $fsthp['no_mutasi_produksi'],
				'tgl_mutasi_gudang' => $fsthp['tgl_mutasi_produksi'],
				'inout'				=> 'IN',
				'jenis_mutasi'		=> 'FSTHP',
				'id_admin'			=> $id_admin


			);
			$fsthp_gj = $this->db->insert('mutasi_gudang_jadi', $data_fsthp);
			if ($fsthp_gj) {

				foreach ($detail_fsthp as $f) {

					$data_detail = array(
						'no_mutasi_gudang' => $f->no_mutasi_produksi,
						'kode_produk' 	   => $f->kode_produk,
						'shift'			   => $f->shift,
						'jumlah'		   => $f->jumlah

					);

					$this->db->insert('detail_mutasi_gudang', $data_detail);
				}

				$updatefsthp = "UPDATE mutasi_produksi SET status='1' WHERE no_mutasi_produksi = '$no_fsthp'";
				$this->db->query($updatefsthp);
				$this->session->set_flashdata(
					'msg',

					'<div class="alert bg-green text-white alert-dismissible" role="alert">

		              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		                 <i class="fa fa-check"></i> Data Berhasil Disimpan !

		          </div>'
				);

				redirect('fsthp/view_fsthp_gj');
			}
		}
	}


	function cancel_fsthp($no_fsthp, $hal)
	{
		if (!empty($hal)) {
			$hal = $hal;
		} else {
			$hal = "";
		}
		$hapus = $this->db->delete('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_fsthp));
		if ($hapus) {

			$this->db->delete('detail_mutasi_gudang', array('no_mutasi_gudang' => $no_fsthp));
			$updatefsthp = "UPDATE mutasi_produksi SET status='0' WHERE no_mutasi_produksi = '$no_fsthp'";
			$this->db->query($updatefsthp);
			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-green text-white alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="fa fa-check"></i> Data Berhasil Hapus !

	          </div>'
			);

			redirect('fsthp/view_fsthp_gj/' . $hal);
		}
	}


	function hapus_detailfsthptmp($kode_produk, $id_admin, $shift)
	{
		$this->db->delete('detail_mutasi_produksi_temp', array('kode_produk' => $kode_produk, 'id_admin' => $id_admin, 'shift' => $shift, 'inout' => 'OUT'));
	}
}
