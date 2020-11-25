<?php
class Model_kendaraan extends CI_Model
{
	
	function view_kendaraan()
	{

		$cabang = $this->session->userdata('cabang');

		if ($cabang != "pusat") {

			$this->db->where('kendaraan.kode_cabang', $cabang);
		}
		$this->db->select('*');
		$this->db->from('kendaraan');
		$this->db->join('cabang', 'kendaraan.kode_cabang=cabang.kode_cabang');
		return $this->db->get();
	}

	function get_kendaraan($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('kendaraan');
	}


	function insert_kendaraan()
	{

		$no_polisi 	    = $this->input->post('no_polisi');
		$type 	        = $this->input->post('type');
		$model 	        = $this->input->post('model');
		$tahun 	        = $this->input->post('tahun');
		$no_mesin 	    = $this->input->post('no_mesin');
		$no_rangka 	    = $this->input->post('no_rangka');
		$no_stnk 	      = $this->input->post('no_stnk');
		$pajak 	        = $this->input->post('pajak');
		$atas_nama 	    = $this->input->post('atas_nama');
		$keur 	        = $this->input->post('keur');
		$no_uji 	      = $this->input->post('no_uji');
		$kir 	          = $this->input->post('kir');
		$stnk 	        = $this->input->post('stnk');
		$sipa 	        = $this->input->post('sipa');
    $pemakai 	      = $this->input->post('pemakai');
    $jabatan 	      = $this->input->post('jabatan');
    $keterangan 	  = $this->input->post('pemakai');
    $kode_cabang 	  = $this->input->post('kode_cabang');
    $status 	      = $this->input->post('status');

		$data 			= array(


			'no_polisi' 		  => $no_polisi,
      'type' 		        => $type,
      'model' 		      => $model,
      'tahun' 		      => $tahun,
      'no_mesin' 		    => $no_mesin,
      'no_rangka' 		  => $no_rangka,
      'no_stnk' 		    => $no_stnk,
      'pajak' 		      => $pajak,
      'atas_nama' 	    => $atas_nama,
      'keur' 		        => $keur,
      'no_uji' 		      => $no_uji,
      'kir' 		        => $kir,
      'stnk' 		        => $stnk,
      'sipa' 		        => $sipa,
      'pemakai' 		    => $pemakai,
      'jabatan' 		    => $jabatan,
      'keterangan' 	    => $keterangan,
      'kode_cabang' 	  => $kode_cabang,
      'status' 		      => $status


		);

		$cek_data = $this->db->get_where('kendaraan', array('id' => $id));
		if ($cek_data->num_rows() != 0) {
			$this->db->update('kendaraan', $data, array('id' => $id));
		} else {

			$this->db->insert('kendaraan', $data);
		}
	}


	function hapus($id)
	{
		$this->db->delete('kendaraan', array('id' => $id));
	}
}
