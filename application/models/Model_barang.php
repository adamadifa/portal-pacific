<?php

class Model_barang extends CI_Model
{

	function view_barang()
	{

		$cabang = $this->session->userdata('cabang');

		if ($cabang != "pusat") {

			$this->db->where('barang.kode_cabang', $cabang);
		}
		$this->db->select('kode_barang,nama_barang,kategori,satuan,harga_dus,harga_pack,harga_pcs,harga_returdus,harga_returpack,harga_returpcs,stok,isipcsdus,isipack,isipcs,nama_cabang');
		$this->db->from('barang');
		$this->db->join('cabang', 'barang.kode_cabang=cabang.kode_cabang');
		return $this->db->get();
	}

	function view_barangcab($kodecabang)
	{

		$this->db->order_by('kode_produk', 'ASC');
		return $this->db->get_where('barang', array('kode_cabang' => $kodecabang));
	}


	function get_barang($kodebarang)
	{
		$this->db->where('kode_barang', $kodebarang);
		return $this->db->get('barang');
	}


	function insert_barang()
	{

		$kodebarang 	= $this->input->post('kodebarang');
		$namabarang 	= $this->input->post('namabarang');
		$kategori 		= $this->input->post('kategori');
		$satuan 		 = $this->input->post('satuan');
		$hargadus 		= $this->input->post('hargadus');
		$hargapack 		= $this->input->post('hargapack');
		$hargapcs 		= $this->input->post('hargapcs');
		$hargareturdus 	= $this->input->post('hargareturdus');
		$hargareturpack = $this->input->post('hargareturpack');
		$hargareturpcs  = $this->input->post('hargareturpcs');
		$stokdus 		= $this->input->post('stokdus');
		$stokpack 		= $this->input->post('stokpack');
		$stokpcs 		= $this->input->post('stokpcs');

		$jmlpcsdus 		= $this->input->post('jmlpcsdus');
		$jmlpackdus 	= $this->input->post('jmlpackdus');
		$jmlpcspack     = $this->input->post('jmlpcspack');
		$cabang 		= $this->input->post('cabang');
		$stok 			= ($stokdus * $jmlpcsdus) + ($stokpack * $jmlpcspack) + $stokpcs;


		$data 			= array(


			'kode_barang' 		=> $kodebarang,
			'nama_barang' 		=> $namabarang,
			'kategori'    		=> $kategori,
			'satuan' 	  		=> $satuan,
			'harga_dus'   		=> $hargadus,
			'harga_pack'  		=> $hargapack,
			'harga_pcs'  		=> $hargapcs,
			'harga_returdus'	=> $hargareturdus,
			'harga_returpack' 	=> $hargareturpack,
			'harga_returpcs' 	=> $hargareturpcs,
			'isipcsdus' 		=> $jmlpcsdus,
			'isipack' 			=> $jmlpackdus,
			'isipcs' 			=> $jmlpcspack,
			'stok' 				=> $stok,
			'kode_cabang'		=> $cabang


		);

		$cek_data = $this->db->get_where('barang', array('kode_barang' => $kodebarang));
		if ($cek_data->num_rows() != 0) {
			$this->db->update('barang', $data, array('kode_barang' => $kodebarang));
		} else {

			$this->db->insert('barang', $data);
		}
	}


	function hapus($id)
	{
		$this->db->delete('barang', array('kode_barang' => $id));
	}

	function getMasterproduk()
	{
		return $this->db->get('master_barang');
	}
}
