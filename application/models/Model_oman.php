<?php

class Model_oman extends CI_Model
{


	function listproduk()
	{
		return $this->db->get('master_barang');
	}

	function view_oman($bulan = "", $tahun = "", $no_order = null)
	{
		if ($no_order != null) {
			$this->db->where('no_order', $no_order);
		}
		if ($bulan != "") {
			$this->db->where('bulan', $bulan);
		}

		$this->db->where('tahun', $tahun);
		$this->db->order_by('tgl_order', 'desc');
		return $this->db->get('oman');
	}

	function view_oman_cabang($bulan = "", $tahun = "", $cabang = "", $no_order = null)
	{
		if ($no_order != null) {
			$this->db->where('oman_cabang.no_order', $no_order);
		}
		if ($bulan != "") {
			$this->db->where('oman_cabang.bulan', $bulan);
		}

		if ($cabang != "") {
			$this->db->where('kode_cabang', $cabang);
		}
		$this->db->join('oman', 'oman_cabang.bulan = oman.bulan AND oman_cabang.tahun = oman.tahun', 'left');
		$this->db->where('oman_cabang.tahun', $tahun);
		$this->db->order_by('tahun,bulan', 'asc');
		$this->db->select('oman_cabang.no_order,oman_cabang.bulan,oman_cabang.tahun,oman.no_order as status,kode_cabang');
		$this->db->from('oman_cabang');
		return $this->db->get();
	}

	function getOman($no_order = null)
	{
		if ($no_order != null) {
			$this->db->where('no_order', $no_order);
		}
		$this->db->order_by('tgl_order', 'desc');
		return $this->db->get('oman');
	}

	function getOmanCabang($no_order = null)
	{
		if ($no_order != null) {
			$this->db->where('no_order', $no_order);
		}

		return $this->db->get('oman_cabang');
	}


	function insert_oman()
	{
		$tgl_order 	= $this->input->post('tgl_order');
		$bulan 			= $this->input->post('bulan');
		$tahun 			= $this->input->post('tahun');
		$no_order   = "OMAN" . $bulan . $tahun;
		$jumproduk  = $this->input->post('jumproduk');
		$data 		= array(
			'no_order' 		=> $no_order,
			'tgl_order' 	=> $tgl_order,
			'bulan'				=> $bulan,
			'tahun'				=> $tahun,
			'status'			=> 0
		);

		$this->db->where('no_order', $no_order);
		$cekoman 	= $this->db->get('oman')->num_rows();
		if ($cekoman == 0) {
			$oman = $this->db->insert('oman', $data);
			if ($oman) {
				for ($i = 1; $i <= $jumproduk; $i++) {
					$kode_produk = $this->input->post('kode_produk' . $i);
					for ($m = 1; $m <= 4; $m++) {
						$d 		= $this->input->post('darim' . $m);
						$s 		= $this->input->post('sampaim' . $m);
						$dari 	= $tahun . "-" . $bulan . "-" . $d;
						$sampai = $tahun . "-" . $bulan . "-" . $s;
						$jml    = $this->input->post('jml' . $i . "m" . $m);
						$data_oman   = array(
							'no_order' 		=> $no_order,
							'kode_produk'	=> $kode_produk,
							'mingguke'		=> $m,
							'dari'				=> $dari,
							'sampai'			=> $sampai,
							'jumlah'			=> $jml
						);
						$detail_oman = $this->db->insert('detail_oman', $data_oman);
					}
				}
			}
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Simpan !
        </div>'
			);
			redirect('oman');
		} else {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Sudah Ada !
         </div>'
			);
			redirect('oman');
		}
	}

	function insert_oman_cabang()
	{

		$bulan 			= $this->input->post('bulan');
		$tahun 			= $this->input->post('tahun');
		$cabang 		= $this->input->post('cabang');
		$no_order   = "OMAN" . $cabang . $bulan . $tahun;
		$jumproduk  = $this->input->post('jumproduk');
		$data 		= array(
			'no_order' 		=> $no_order,
			'bulan'				=> $bulan,
			'tahun'				=> $tahun,
			'kode_cabang'	=> $cabang,
		);

		$this->db->where('no_order', $no_order);
		$cekoman 	= $this->db->get('oman_cabang')->num_rows();
		if ($cekoman == 0) {
			$oman = $this->db->insert('oman_cabang', $data);
			if ($oman) {
				for ($i = 1; $i <= $jumproduk; $i++) {
					$kode_produk = $this->input->post('kode_produk' . $i);
					for ($m = 1; $m <= 4; $m++) {
						$d 		= $this->input->post('darim' . $m);
						$s 		= $this->input->post('sampaim' . $m);
						$dari 	= $tahun . "-" . $bulan . "-" . $d;
						$sampai = $tahun . "-" . $bulan . "-" . $s;
						$jml    = $this->input->post('jml' . $i . "m" . $m);
						$data_oman   = array(
							'no_order' 		=> $no_order,
							'kode_produk'	=> $kode_produk,
							'mingguke'		=> $m,
							'dari'				=> $dari,
							'sampai'			=> $sampai,
							'jumlah'			=> $jml
						);
						$detail_oman = $this->db->insert('detail_oman_cabang', $data_oman);
					}
				}
			}
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Simpan !
        </div>'
			);
			redirect('oman/omancabang');
		} else {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Sudah Ada !
         </div>'
			);
			redirect('oman/omancabang');
		}
	}


	function update_oman()
	{
		$no_order 	= $this->input->post('no_order');
		$tgl_order 	= $this->input->post('tgl_order');
		$bulan 			= $this->input->post('bulan');
		$tahun 			= $this->input->post('tahun');
		$jumproduk  = $this->input->post('jumproduk');
		$data 			= array(
			'tgl_order' 	=> $tgl_order
		);
		$oman 			= $this->db->update('oman', $data, array('no_order' => $no_order));
		if ($oman) {
			for ($i = 1; $i <= $jumproduk; $i++) {
				$kode_produk = $this->input->post('kode_produk' . $i);
				for ($m = 1; $m <= 4; $m++) {
					$d 					 = $this->input->post('darim' . $m);
					$s 					 = $this->input->post('sampaim' . $m);
					$dari 			 = $tahun . "-" . $bulan . "-" . $d;
					$sampai 		 = $tahun . "-" . $bulan . "-" . $s;
					$jml    		 = $this->input->post('jml' . $i . "m" . $m);
					$data_oman   = array(
						'dari'		=> $dari,
						'sampai'	=> $sampai,
						'jumlah'	=> $jml
					);
					$this->db->where('no_order', $no_order);
					$this->db->where('kode_produk', $kode_produk);
					$this->db->where('mingguke', $m);
					$detail_oman = $this->db->update('detail_oman', $data_oman);
				}
			}
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Simpan !
      </div>'
			);
			redirect('oman');
		}
	}

	function update_omancabang()
	{
		$no_order 	= $this->input->post('no_order');
		$cabang 		= $this->input->post('cabang');
		$bulan 			= $this->input->post('bulan');
		$tahun 			= $this->input->post('tahun');
		$no_ordernew = "OMAN" . $cabang . $bulan . $tahun;
		$jumproduk  = $this->input->post('jumproduk');
		$data 			= array(
			'no_order' => $no_ordernew,
			'bulan' 	=> $bulan,
			'tahun'	=> $tahun,
			'kode_cabang' => $cabang
		);
		$detail = array(
			'no_order' => $no_ordernew
		);
		$oman 			= $this->db->update('oman_cabang', $data, array('no_order' => $no_order));
		if ($oman) {
			for ($i = 1; $i <= $jumproduk; $i++) {
				$kode_produk = $this->input->post('kode_produk' . $i);
				for ($m = 1; $m <= 4; $m++) {
					$d 					 = $this->input->post('darim' . $m);
					$s 					 = $this->input->post('sampaim' . $m);
					$dari 			 = $tahun . "-" . $bulan . "-" . $d;
					$sampai 		 = $tahun . "-" . $bulan . "-" . $s;
					$jml    		 = $this->input->post('jml' . $i . "m" . $m);
					$data_oman   = array(
						'no_order' => $no_ordernew,
						'dari'		=> $dari,
						'sampai'	=> $sampai,
						'jumlah'	=> $jml
					);
					$this->db->where('no_order', $no_order);
					$this->db->where('kode_produk', $kode_produk);
					$this->db->where('mingguke', $m);
					$detail_oman = $this->db->update('detail_oman_cabang', $data_oman);
				}
			}
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Simpan !
      </div>'
			);
			redirect('oman/omancabang');
		}
	}

	function cek_oman($bulan, $tahun)
	{
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		return $this->db->get('oman');
	}

	function cek_oman_cabang($bulan, $tahun, $cabang)
	{
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_cabang', $cabang);
		return $this->db->get('oman_cabang');
	}

	function hapus($no_order)
	{
		$deloman = $this->db->delete('oman', array('no_order' => $no_order));
		if ($deloman) {
			$deldetail = $this->db->delete('detail_oman', array('no_order' => $no_order));
		}
		$this->session->set_flashdata(
			'msg',
			'<div class="alert bg-green text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Hapus !
      </div>'
		);
		redirect('oman');
	}

	function hapusomancabang($no_order)
	{
		$deloman = $this->db->delete('oman_cabang', array('no_order' => $no_order));
		if ($deloman) {
			$deldetail = $this->db->delete('detail_oman_cabang', array('no_order' => $no_order));
		}
		$this->session->set_flashdata(
			'msg',
			'<div class="alert bg-green text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Hapus !
      </div>'
		);
		redirect('oman/omancabang');
	}


	function cek_nopermintaan()
	{
		$query = "SELECT no_permintaan FROM permintaan_produksi ORDER BY no_permintaan DESC LIMIT 1 ";
		return $this->db->query($query);
	}


	function insert_permintaan()
	{
		$no_permintaan 		= $this->input->post('no_permintaan');
		$tgl_permintaan 	= $this->input->post('tgl_permintaan');
		$no_order 				= $this->input->post('no_order');
		$jumproduk  			= $this->input->post('jumproduk');
		$data = array(
			'no_permintaan' 	=> $no_permintaan,
			'tgl_permintaan' 	=> $tgl_permintaan,
			'no_order'				=> $no_order
		);

		$permintaan = $this->db->insert('permintaan_produksi', $data);
		if ($permintaan) {
			for ($i = 1; $i <= $jumproduk; $i++) {
				$kode_produk = $this->input->post('kode_produk' . $i);
				$oman_mkt    = $this->input->post('oman_mkt' . $i);
				$stok_gudang = $this->input->post('stok_gudang' . $i);
				$bufferstok  = $this->input->post('bufferstok' . $i);
				$data_detail = array(
					'no_permintaan' => $no_permintaan,
					'kode_produk' 	=> $kode_produk,
					'oman_mkt'	  	=> $oman_mkt,
					'stok_gudang' 	=> $stok_gudang,
					'buffer_Stok'   => $bufferstok
				);
				$this->db->insert('detail_permintaan_produksi', $data_detail);
			}
			$updateoman = "UPDATE oman SET status='1' WHERE no_order='$no_order'";
			$this->db->query($updateoman);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Simpan !
        </div>'
			);
			redirect('oman/view_omanmkt');
		}
	}


	function get_permintaan($no_order)
	{
		$this->db->where('no_order', $no_order);
		return $this->db->get('permintaan_produksi');
	}


	function detail_permintaan($no_permintaan)
	{
		$this->db->select('detail_permintaan_produksi.kode_produk,nama_barang,oman_mkt,stok_gudang,buffer_stok');
		$this->db->from('detail_permintaan_produksi');
		$this->db->join('master_barang', 'detail_permintaan_produksi.kode_produk = master_barang.kode_produk');
		$this->db->where('no_permintaan', $no_permintaan);
		return $this->db->get();
	}

	function view_permintaanproduksi($bulan, $tahun)
	{
		$this->db->order_by('tgl_permintaan', 'desc');
		$this->db->join('oman', 'permintaan_produksi.no_order = oman.no_order');
		$this->db->select('no_permintaan,tgl_permintaan,permintaan_produksi.no_order,permintaan_produksi.status');
		$this->db->from('permintaan_produksi');
		if ($bulan != "") {
			$this->db->where('bulan', $bulan);
		}

		$this->db->where('tahun', $tahun);
		return $this->db->get();
	}

	function hapus_permintaan($no_permintaan, $no_order)
	{
		$hapus_permintaan = $this->db->delete('permintaan_produksi', array('no_permintaan' => $no_permintaan));
		if ($hapus_permintaan) {
			$this->db->delete('detail_permintaan_produksi', array('no_permintaan' => $no_permintaan));
			$query = "UPDATE oman SET status='0' WHERE no_order ='$no_order'";
			$this->db->query($query);
			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Batalkan !
        </div>'
			);
			redirect('oman/permintaan_produksi');
		}
	}


	function approve_permintaan($no_permintaan, $no_oman)
	{
		$query 	= "UPDATE permintaan_produksi SET status='1' WHERE no_permintaan ='$no_permintaan'";
		$update = $this->db->query($query);
		if ($update) {
			$query2 	= "UPDATE oman SET status='2' WHERE no_order ='$no_oman'";
			$update2 	= $this->db->query($query2);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Approve !
        </div>'
			);
			redirect('oman/permintaan_produksi_acc');
		}
	}

	function cancel_permintaan($no_permintaan, $no_oman)
	{
		$query 	= "UPDATE permintaan_produksi SET status='0' WHERE no_permintaan ='$no_permintaan'";
		$update = $this->db->query($query);
		if ($update) {
			$query2 	= "UPDATE oman SET status='1' WHERE no_order ='$no_oman'";
			$update2 	= $this->db->query($query2);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Batalkan !
      </div>'
			);
			redirect('oman/permintaan_produksi_acc');
		}
	}


	function getNoPermintaanLast($kode_cabang, $tgl_permintaan)
	{
		$kode 						= strlen($kode_cabang);
		$no_permintaan 		= $kode + 4;
		$query 						= "SELECT LEFT(no_permintaan_pengiriman,$no_permintaan) as no_permintaan_pengiriman
						  				   FROM permintaan_pengiriman WHERE MID(no_permintaan_pengiriman,3,$kode)='$kode_cabang'
						  					 AND tgl_permintaan_pengiriman = '$tgl_permintaan'  ORDER by LEFT(no_permintaan_pengiriman,$no_permintaan) DESC";
		return $this->db->query($query);
	}

	function cek_detailpermintaantmp()
	{
		$kode_produk = $this->input->post('kode_produk');
		$this->db->where('kode_produk', $kode_produk);
		return $this->db->get('detail_permintaan_pengiriman_temp');
	}

	function insert_detailpermintaanpengirimantmp()
	{

		$kode_produk 	= $this->input->post('kode_produk');
		$jumlah 			= $this->input->post('jumlah');
		$data 				= array(
			'kode_produk' => $kode_produk,
			'jumlah'	  	=> $jumlah
		);

		$this->db->insert('detail_permintaan_pengiriman_temp', $data);
	}

	function view_detail_permintaan_pengiriman_temp()
	{
		$this->db->join('master_barang', 'detail_permintaan_pengiriman_temp.kode_produk = master_barang.kode_produk');
		return $this->db->get('detail_permintaan_pengiriman_temp');
	}

	function hapus_detail_permintaan_pengiriman($kode_produk)
	{
		$hapus = $this->db->delete('detail_permintaan_pengiriman_temp', array('kode_produk' => $kode_produk));
	}


	function insert_permintaan_pengiriman()
	{
		$no_permintaan 	= $this->input->post('no_permintaan');
		$tgl_permintaan = $this->input->post('tgl_permintaan');
		$cabang 				= $this->input->post('cabang');
		$ket 						= $this->input->post('keterangan');
		$id_admin 			= $this->session->userdata('id_user');
		$data = array(
			'no_permintaan_pengiriman' 	=> $no_permintaan,
			'tgl_permintaan_pengiriman' => $tgl_permintaan,
			'kode_cabang'								=> $cabang,
			'keterangan'								=> $ket,
			'status'										=> '0',
			'id_admin'									=> $id_admin
		);
		$pp = $this->db->insert('permintaan_pengiriman', $data);
		if ($pp) {
			$detail = $this->db->get('detail_permintaan_pengiriman_temp')->result();
			foreach ($detail as $d) {
				$data_detail = array(
					'no_permintaan_pengiriman'	=> $no_permintaan,
					'kode_produk' 							=> $d->kode_produk,
					'jumlah'	  								=> $d->jumlah
				);
				$this->db->insert('detail_permintaan_pengiriman', $data_detail);
			}
			$this->db->truncate('detail_permintaan_pengiriman_temp');
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Simpan !
        </div>'
			);
			redirect('oman/permintaan_pengiriman');
		}
	}


	public function getDataPermintaanPengiriman($rowno, $rowperpage, $no_permintaan = "", $tgl_permintaan = "", $cbg = "")
	{
		$this->db->select('*');
		$this->db->from('permintaan_pengiriman');
		$this->db->order_by('status', 'ASC');
		if ($no_permintaan != '') {
			$this->db->where('no_permintaan_pengiriman', $no_permintaan);
		}
		if ($tgl_permintaan != '') {
			$this->db->where('tgl_permintaan_pengiriman', $tgl_permintaan);
		}
		if ($cbg != '') {
			$this->db->where('kode_cabang', $cbg);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	// Select total records
	public function getrecordPermintaanPengirimanCount($no_permintaan = "", $tgl_permintaan = "", $cbg = "")
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('permintaan_pengiriman');
		if ($no_permintaan != '') {
			$this->db->where('no_permintaan_pengiriman', $no_permintaan);
		}
		if ($tgl_permintaan != '') {
			$this->db->where('tgl_permintaan_pengiriman', $tgl_permintaan);
		}
		if ($cbg != '') {
			$this->db->where('kode_cabang', $cbg);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	function getPermintaanpengiriman($no_permintaan)
	{
		$this->db->where('no_permintaan_pengiriman', $no_permintaan);
		$this->db->join('cabang', 'permintaan_pengiriman.kode_cabang = cabang.kode_cabang');
		return $this->db->get('permintaan_pengiriman');
	}

	function detailpp($no_permintaan)
	{
		$this->db->where('detail_permintaan_pengiriman.no_permintaan_pengiriman', $no_permintaan);
		$this->db->join('permintaan_pengiriman', 'detail_permintaan_pengiriman.no_permintaan_pengiriman = permintaan_pengiriman.no_permintaan_pengiriman');
		$this->db->join('master_barang', 'detail_permintaan_pengiriman.kode_produk = master_barang.kode_produk');
		return $this->db->get('detail_permintaan_pengiriman');
	}


	function update_detailpermintaan($no_permintaan, $kode_produk)
	{
		$cek = $this->db->get_where('detail_permintaan_pengiriman', array('no_permintaan_pengiriman' => $no_permintaan, 'kode_produk' => $kode_produk))->num_rows();
		if ($cek != 0) {
			$jumlah = $this->input->post('jumlah');
			$data = array(
				'jumlah' => $jumlah
			);
			$this->db->where('no_permintaan_pengiriman', $no_permintaan);
			$this->db->where('kode_produk', $kode_produk);
			$this->db->update('detail_permintaan_pengiriman', $data);
		} else {
			$jumlah = $this->input->post('jumlah');
			$data 	= array(
				'no_permintaan_pengiriman' => $no_permintaan,
				'kode_produk'			   		   => $kode_produk,
				'jumlah' 				   				 => $jumlah
			);
			$this->db->insert('detail_permintaan_pengiriman', $data);
		}
	}

	function deletedetail($no_permintaan, $kode_produk)
	{
		$this->db->where('no_permintaan_pengiriman', $no_permintaan);
		$this->db->where('kode_produk', $kode_produk);
		$this->db->delete('detail_permintaan_pengiriman');
	}

	function hapus_permintaanpengiriman($no_permintaan, $hal)
	{
		if (!empty($hal)) {
			$hal = $hal;
		} else {
			$hal = "";
		}
		$delete = $this->db->delete('permintaan_pengiriman', array('no_permintaan_pengiriman' => $no_permintaan));
		if ($delete) {
			$this->db->delete('detail_permintaan_pengiriman', array('no_permintaan_pengiriman' => $no_permintaan));
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Hapus !
      </div>'
			);
			redirect('oman/permintaan_pengiriman/' . $hal);
		}
	}


	function insert_detailsuratjalantemp()
	{
		$id_admin 			= $this->session->userdata('id_user');
		$kode_produk		= $this->input->post('kode_produk');
		$jumlah 				= $this->input->post('jumlah');
		$no_permintaan  = $this->input->post('no_permintaan');
		$data 	= array(
			'kode_produk' 							=> $kode_produk,
			'jumlah'	  								=> $jumlah,
			'no_permintaan_pengiriman'	=> $no_permintaan,
			'id_admin'	  							=> $id_admin
		);
		$this->db->insert('detail_mutasi_gudang_temp', $data);
	}

	function detailsjtemp($no_permintaan)
	{
		$this->db->where('detail_mutasi_gudang_temp.no_permintaan_pengiriman', $no_permintaan);
		$this->db->join('master_barang', 'detail_mutasi_gudang_temp.kode_produk = master_barang.kode_produk');
		return $this->db->get('detail_mutasi_gudang_temp');
	}


	function deletedetailsjtemp($no_permintaan, $kode_produk)
	{
		$this->db->where('no_permintaan_pengiriman', $no_permintaan);
		$this->db->where('kode_produk', $kode_produk);
		$this->db->delete('detail_mutasi_gudang_temp');
	}


	function getNoSJLast($kode_cabang, $tgl_sj)
	{
		$kode 				= strlen($kode_cabang);
		$no_sj 				= $kode + 4;
		$query 				= "SELECT LEFT(no_mutasi_gudang,$no_sj) as no_suratjalan
						  		FROM mutasi_gudang_jadi WHERE MID(no_mutasi_gudang,3,$kode)='$kode_cabang'
						  		AND tgl_mutasi_gudang = '$tgl_sj' AND jenis_mutasi = 'SURAT JALAN'  ORDER by LEFT(no_mutasi_gudang,$no_sj) DESC";
		return $this->db->query($query);
	}



	function insert_suratjalan()
	{

		$no_sj 						= $this->input->post('no_sj');
		$tgl_sj 					= $this->input->post('tgl_sj');
		$no_permintaan 		= $this->input->post('nopermintaan');
		$id_admin 				= $this->session->userdata('id_user');
		$detail 					= $this->db->get_where('detail_mutasi_gudang_temp', array('no_permintaan_pengiriman' => $no_permintaan))->result();
		$data_sj 					= array(
			'no_mutasi_gudang' 						=> $no_sj,
			'tgl_mutasi_gudang'						=> $tgl_sj,
			'no_permintaan_pengiriman'		=> $no_permintaan,
			'inout'												=> 'OUT',
			'jenis_mutasi'								=> 'SURAT JALAN',
			'status_sj'										=> '0',
			'id_admin'										=> $id_admin

		);
		$sj 							= $this->db->insert('mutasi_gudang_jadi', $data_sj);

		if ($sj) {
			foreach ($detail as $d) {
				$data_detail = array(
					'no_mutasi_gudang' 	=> $no_sj,
					'kode_produk'	   		=> $d->kode_produk,
					'jumlah'		   		  => $d->jumlah
				);
				$this->db->insert('detail_mutasi_gudang', $data_detail);
			}
			$this->db->delete('detail_mutasi_gudang_temp', array('no_permintaan_pengiriman' => $no_permintaan));
			$updatepengiriman = "UPDATE permintaan_pengiriman SET status ='1' WHERE no_permintaan_pengiriman='$no_permintaan'";
			$this->db->query($updatepengiriman);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <i class="fa fa-check"></i> Data Berhasil Di Simpan !
        </div>'
			);
			redirect('oman/view_suratjalan');
		}
	}


	function getSuratJalan($no_sj)
	{
		$this->db->where('no_mutasi_gudang', $no_sj);
		$this->db->join('permintaan_pengiriman', 'mutasi_gudang_jadi.no_permintaan_pengiriman = permintaan_pengiriman.no_permintaan_pengiriman');
		$this->db->join('cabang', 'permintaan_pengiriman.kode_cabang = cabang.kode_cabang');
		return $this->db->get('mutasi_gudang_jadi');
	}

	function detailsuratjalan($no_sj)
	{
		$this->db->where('no_mutasi_gudang', $no_sj);
		$this->db->join('master_barang', 'detail_mutasi_gudang.kode_produk = master_barang.kode_produk');
		return $this->db->get('detail_mutasi_gudang');
	}

	function hapus_sj($no_permintaan, $no_sj, $hal)
	{
		if (!empty($hal)) {
			$hal = $hal;
		} else {
			$hal = "";
		}
		$hapus_sj = $this->db->delete('mutasi_gudang_jadi', array('no_mutasi_gudang' => $no_sj));
		if ($hapus_sj) {
			$this->db->delete('detail_mutasi_gudang', array('no_mutasi_gudang' => $no_sj));
			$query = "UPDATE permintaan_pengiriman SET status ='0' WHERE no_permintaan_pengiriman='$no_permintaan'";
			$this->db->query($query);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
      	</div>'
			);
			redirect('oman/view_suratjalan/' . $hal);
		}
	}

	function getSuratJalanPP($no_permintaan)
	{
		$this->db->where('no_permintaan_pengiriman', $no_permintaan);
		return $this->db->get('mutasi_gudang_jadi');
	}


	public function getrecordSuratJalanCount($no_sj = "", $tgl_sj = "", $cbg = "")
	{
		$cabang = $this->session->userdata('cabang');
		$this->db->where('jenis_mutasi', 'SURAT JALAN');
		$this->db->select('count(*) as allcount');
		$this->db->from('mutasi_gudang_jadi');
		$this->db->join('permintaan_pengiriman', 'mutasi_gudang_jadi.no_permintaan_pengiriman = permintaan_pengiriman.no_permintaan_pengiriman');
		if ($cabang != "pusat") {
			$this->db->where('kode_cabang', $cabang);
		}

		if ($cbg != "") {
			$this->db->where('kode_cabang', $cbg);
		}

		if ($no_sj != '') {
			$this->db->where('no_mutasi_gudang', $no_sj);
		}
		if ($tgl_sj != '') {
			$this->db->where('tgl_mutasi_gudang', $tgl_sj);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function getDataSuratjalan($rowno, $rowperpage, $no_sj = "", $tgl_sj = "", $cbg = "")
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {
			$this->db->where('kode_cabang', $cabang);
		}

		if ($cbg != "") {
			$this->db->where('kode_cabang', $cbg);
		}

		$this->db->where('jenis_mutasi', 'SURAT JALAN');
		$this->db->select('*');
		$this->db->from('mutasi_gudang_jadi');
		$this->db->join('permintaan_pengiriman', 'mutasi_gudang_jadi.no_permintaan_pengiriman = permintaan_pengiriman.no_permintaan_pengiriman');
		$this->db->order_by('tgl_mutasi_gudang,mutasi_gudang_jadi.time_stamp', 'desc');
		if ($no_sj != '') {
			$this->db->where('no_mutasi_gudang', $no_sj);
		}

		if ($tgl_sj != '') {
			$this->db->where('tgl_mutasi_gudang', $tgl_sj);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}



	function input_suratjalanacc()
	{

		$no_suratjalan 	= $this->input->post('no_suratjalan');
		$tgl_kirim 			= $this->input->post('tgl_krim');
		$tglditerima 		= $this->input->post('tglditerima');
		$kode_cabang 		= $this->input->post('kode_cabang');
		$keterangan 		= $this->input->post('keterangan');
		$status 				= $this->input->post('status');
		$id_admin 			= $this->session->userdata('id_user');
		$tahunini 			= date('y');
		$qtransitout 		= "SELECT no_mutasi_gudang_cabang as no_transitout FROM mutasi_gudang_cabang
							   			WHERE kode_cabang ='$kode_cabang' AND jenis_mutasi ='TRANSIT OUT'
							   			AND  MID(no_mutasi_gudang_cabang,6,2) = '$tahunini' ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1 ";
		$transitout 			= $this->db->query($qtransitout)->row_array();
		$nomor_terakhirto	= $transitout['no_transitout'];
		$no_to 						= buatkode($nomor_terakhirto, 'TO' . $kode_cabang . $tahunini, 2);
		$detail 					= $this->db->get_where('detail_mutasi_gudang', array('no_mutasi_gudang' => $no_suratjalan))->result();
		$data_sj 					= array(
			'no_mutasi_gudang_cabang' 		=> $no_suratjalan,
			'tgl_mutasi_gudang_cabang'		=> $tglditerima,
			'tgl_kirim'										=> $tgl_kirim,
			'kode_cabang'									=> $kode_cabang,
			'kondisi'											=> 'GOOD',
			'inout_good'									=> 'IN',
			'jenis_mutasi'								=> 'SURAT JALAN',
			'order'   										=> '0',
			'id_admin'										=> $id_admin
		);

		$data_transitout 	= array(
			'no_mutasi_gudang_cabang' 		=> $no_to,
			'tgl_mutasi_gudang_cabang'		=> $tglditerima,
			'tgl_kirim'										=> $tgl_kirim,
			'no_suratjalan'								=> $no_suratjalan,
			'kode_cabang'									=> $kode_cabang,
			'kondisi'											=> 'GOOD',
			'inout_good'									=> 'OUT',
			'jenis_mutasi'								=> 'TRANSIT OUT',
			'order'   										=> '1',
			'id_admin'										=> $id_admin
		);

		$sj 							= $this->db->insert('mutasi_gudang_cabang', $data_sj);
		if ($sj) {
			foreach ($detail as $d) {
				$brg = $this->db->get_where('barang', array('kode_produk' => $d->kode_produk, 'kode_cabang' => $kode_cabang))->row_array();
				$jumlah = $d->jumlah * $brg['isipcsdus'];
				$data_detail = array(
					'no_mutasi_gudang_cabang'   => $no_suratjalan,
					'kode_produk'	   						=> $d->kode_produk,
					'jumlah'		   							=> $jumlah

				);
				$this->db->insert('detail_mutasi_gudang_cabang', $data_detail);
			}
			if ($status == 'TRANSIT OUT') {
				$sj_to = $this->db->insert('mutasi_gudang_cabang', $data_transitout);
				if ($sj_to) {
					foreach ($detail as $dto) {
						$brg_to 				= $this->db->get_where('barang', array('kode_produk' => $dto->kode_produk, 'kode_cabang' => $kode_cabang))->row_array();
						$jumlah_to 	 		= $dto->jumlah * $brg_to['isipcsdus'];
						$data_detailto 	= array(
							'no_mutasi_gudang_cabang'   => $no_to,
							'kode_produk'	   						=> $dto->kode_produk,
							'jumlah'		   							=> $jumlah_to

						);
						$this->db->insert('detail_mutasi_gudang_cabang', $data_detailto);
					}
				}
			}

			if ($status == 'TRANSIT OUT') {
				$updatesuratjalan = "UPDATE mutasi_gudang_jadi SET status_sj ='2' WHERE no_mutasi_gudang='$no_suratjalan'";
			} else {
				$updatesuratjalan = "UPDATE mutasi_gudang_jadi SET status_sj ='1' WHERE no_mutasi_gudang='$no_suratjalan'";
			}
			$this->db->query($updatesuratjalan);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Simpan !
      	</div>'
			);
			redirect('oman/suratjalan_gjcab');
		}
	}


	function cancel_suratjalan_gjcab($no_mutasi_gudang, $no_to, $no_tin, $hal)
	{
		$hapus_mutasi = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi_gudang));
		if (!empty($hal)) {
			$hal = $hal;
		} else {
			$hal = "";
		}
		if ($hapus_mutasi) {
			$hapus_detailsj 	= $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_mutasi_gudang));
			$hapus_to 			= $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_to));
			$hapus_in 			= $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_tin));
			$hapus_totin 		= $this->db->delete('mutasi_gudang_cabang', array('no_suratjalan' => $no_mutasi_gudang));
			$qupdatesj 			= "UPDATE mutasi_gudang_jadi SET status_sj = '0' WHERE no_mutasi_gudang = '$no_mutasi_gudang' ";
			$updatesj 			= $this->db->query($qupdatesj);
			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="fa fa-check"></i> Data Berhasil Di Simpan !

	          </div>'
			);

			redirect('oman/suratjalan_gjcab/' . $hal);
		}
	}

	public function getrecordTOCount($no_sj = "", $tgl_sj = "")
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {
			$this->db->where('kode_cabang', $cabang);
		}
		$this->db->where('jenis_mutasi', 'TRANSIT OUT');
		$this->db->select('count(*) as allcount');
		$this->db->from('mutasi_gudang_cabang');
		if ($no_sj != '') {
			$this->db->where('no_suratjalan', $no_sj);
		}
		if ($tgl_sj != '') {
			$this->db->where('tgl_mutasi_gudang_cabang', $tgl_sj);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function getDataTO($rowno, $rowperpage, $no_sj = "", $tgl_sj = "")
	{
		$cabang = $this->session->userdata('cabang');
		if ($cabang != "pusat") {
			$this->db->where('kode_cabang', $cabang);
		}
		$this->db->where('jenis_mutasi', 'TRANSIT OUT');
		$this->db->select('*');
		$this->db->from('mutasi_gudang_cabang');
		$this->db->order_by('tgl_mutasi_gudang_cabang,date_created', 'desc');
		if ($no_sj != '') {
			$this->db->where('no_suratjalan', $no_sj);
		}
		if ($tgl_sj != '') {
			$this->db->where('tgl_mutasi_gudang_cabang', $tgl_sj);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	function insert_transit_in()
	{
		$no_suratjalan 			= $this->input->post('no_suratjalan');
		$no_to 							= $this->input->post('no_to');
		$tgl_kirim 					= $this->input->post('tgl_krim');
		$tglditerima 				= $this->input->post('tglditerima');
		$kode_cabang 				= $this->input->post('kode_cabang');
		$id_admin 					= $this->session->userdata('id_user');
		$tahunini 					= date('y');
		$qtransitin 				= "SELECT no_mutasi_gudang_cabang as no_transit_in FROM mutasi_gudang_cabang
									   		  WHERE kode_cabang ='$kode_cabang' AND jenis_mutasi ='TRANSIT IN'
									   			AND  MID(no_mutasi_gudang_cabang,6,2) = '$tahunini' ORDER BY no_mutasi_gudang_cabang DESC LIMIT 1";
		$transit_in 				= $this->db->query($qtransitin)->row_array();
		$nomor_terakhirt_in	= $transit_in['no_transit_in'];
		$no_transit_in			= buatkode($nomor_terakhirt_in, 'TN' . $kode_cabang . $tahunini, 2);
		$detail 						= $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_to))->result();
		$data_transit_in = array(
			'no_mutasi_gudang_cabang' 		=> $no_transit_in,
			'tgl_mutasi_gudang_cabang'		=> $tglditerima,
			'tgl_kirim'										=> $tgl_kirim,
			'no_suratjalan'								=> $no_suratjalan,
			'kode_cabang'									=> $kode_cabang,
			'kondisi'											=> 'GOOD',
			'inout_good'									=> 'IN',
			'jenis_mutasi'								=> 'TRANSIT IN',
			'order'												=> '2',
			'id_admin'										=> $id_admin
		);

		$transitin = $this->db->insert('mutasi_gudang_cabang', $data_transit_in);

		if ($transitin) {
			foreach ($detail as $d) {
				$brg = $this->db->get_where('barang', array('kode_produk' => $d->kode_produk, 'kode_cabang' => $kode_cabang))->row_array();
				$jumlah = $d->jumlah;
				$data_detail = array(
					'no_mutasi_gudang_cabang'   => $no_transit_in,
					'kode_produk'	   						=> $d->kode_produk,
					'jumlah'		   							=> $jumlah

				);
				$this->db->insert('detail_mutasi_gudang_cabang', $data_detail);
			}
			$updatesuratjalan = "UPDATE mutasi_gudang_jadi SET status_sj ='1' WHERE no_mutasi_gudang='$no_suratjalan'";
			$this->db->query($updatesuratjalan);
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check"></i> Data Berhasil Di Simpan !
      </div>'
			);
			redirect('oman/transit_in');
		}
	}

	function cancel_transit_in($no_mutasi_gudang, $no_tin)
	{

		$hapus_transit_in = $this->db->delete('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_tin));
		if ($hapus_transit_in) {
			$hapus_in 			= $this->db->delete('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $no_tin));
			$qupdatesj 			= "UPDATE mutasi_gudang_jadi SET status_sj = '2' WHERE no_mutasi_gudang = '$no_mutasi_gudang' ";
			$updatesj 			= $this->db->query($qupdatesj);
			$this->session->set_flashdata(
				'msg',

				'<div class="alert bg-green text-white text-white alert-dismissible" role="alert">

	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	                 <i class="fa fa-check"></i> Data Berhasil Di Simpan !

	          </div>'
			);

			redirect('oman/transit_in');
		}
	}


	function cek_stokgudang($produk)
	{
		$this->db->where('detail_mutasi_gudang.kode_produk', $produk);
		$this->db->join('mutasi_gudang_jadi', 'detail_mutasi_gudang.no_mutasi_gudang=mutasi_gudang_jadi.no_mutasi_gudang');
		$this->db->select(
			"SUM(IF( `inout` = 'IN', jumlah, 0)) AS jml_in,
			SUM(IF( `inout` = 'OUT', jumlah, 0)) AS jml_out,
			SUM(IF( `inout` = 'IN', jumlah, 0)) -SUM(IF( `inout` = 'OUT', jumlah, 0)) as stokakhir"
		);
		$this->db->from('detail_mutasi_gudang');
		return $this->db->get();
	}


	function cek_stokgudangcabang($produk)
	{
		$cb = $this->session->userdata('cabang');
		if ($cb == 'pusat') {
			$cabang = $this->input->post('kodecabang');
		} else {
			$cabang = $cb;
		}
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('kode_cabang', $cabang);
		$this->db->where('jenis_mutasi !=', 'KIRIM PUSAT');
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->select(
			"SUM(IF( `inout_good` = 'IN', jumlah, 0)) AS jml_in,
			SUM(IF( `inout_good` = 'OUT', jumlah, 0)) AS jml_out,
			SUM(IF( `inout_good` = 'IN', jumlah, 0)) -SUM(IF( `inout_good` = 'OUT', jumlah, 0)) as stokakhir,
			isipcsdus"
		);
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function cek_stokgudangcabangbs($produk)
	{
		$cb = $this->session->userdata('cabang');
		if ($cb == 'pusat') {
			$cabang = $this->input->post('kodecabang');
		} else {
			$cabang = $cb;
		}
		$kondisi = "BAD";
		$this->db->where('kondisi', $kondisi);
		$this->db->where('detail_mutasi_gudang_cabang.kode_produk', $produk);
		$this->db->where('kode_cabang', $cabang);
		$this->db->join('mutasi_gudang_cabang', 'detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang=mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->join('master_barang', 'detail_mutasi_gudang_cabang.kode_produk=master_barang.kode_produk');
		$this->db->select(
			"SUM(IF( `inout_bad` = 'IN', jumlah, 0)) AS jml_in,
			SUM(IF( `inout_bad` = 'OUT', jumlah, 0)) AS jml_out,
			SUM(IF( `inout_bad` = 'IN', jumlah, 0)) -SUM(IF( `inout_bad` = 'OUT', jumlah, 0)) as stokakhir,
			isipcsdus"
		);
		$this->db->from('detail_mutasi_gudang_cabang');
		return $this->db->get();
	}

	function get_suratjalan($no_suratjalan)
	{
		$this->db->where('no_mutasi_gudang', $no_suratjalan);
		$this->db->join('permintaan_pengiriman', 'mutasi_gudang_jadi.no_permintaan_pengiriman = permintaan_pengiriman.no_permintaan_pengiriman');
		$this->db->join('cabang', 'permintaan_pengiriman.kode_cabang = cabang.kode_cabang');
		return $this->db->get('mutasi_gudang_jadi');
	}

	function get_detailsuratjalan($no_suratjalan)
	{
		$this->db->where('no_mutasi_gudang', $no_suratjalan);
		$this->db->join('master_barang', 'detail_mutasi_gudang.kode_produk = master_barang.kode_produk');
		return $this->db->get('detail_mutasi_gudang');
	}

	public function getDataTargetbulan($rowno, $rowperpage, $cabang = "", $tahun = "", $bulan = "")
	{
		$this->db->select('tahun,bulan,kode_cabang');
		$this->db->from('target_pengiriman');
		$this->db->join('master_barang', 'target_pengiriman.kode_produk = master_barang.kode_produk');
		$this->db->group_by('tahun,bulan,kode_cabang');
		if ($cabang != '') {
			$this->db->where('kode_cabang', $cabang);
		}
		if ($tahun != '') {
			$this->db->where('tahun', $tahun);
		}
		if ($bulan != '') {
			$this->db->where('bulan', $bulan);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	// Select total records
	public function getrecordTargetbulanCount($cabang = "", $tahun = "", $bulan = "")
	{

		if ($cabang 	!= "") {
			$cabang = "AND kode_cabang = '" . $cabang . "' ";
		}
		if ($tahun 	!= "") {
			$tahun = "AND tahun = '" . $tahun . "' ";
		}
		if ($bulan 	!= "") {
			$bulan = "AND bulan = '" . $bulan . "' ";
		}

		$query = "SELECT COUNT(*) as allcount FROM
				    ( SELECT tahun,bulan,kode_cabang FROM target_pengiriman
					 INNER JOIN master_barang ON target_pengiriman.kode_produk = master_barang.kode_produk
					 WHERE tahun !=''"
			. $cabang
			. $tahun
			. $bulan
			. "
					 GROUP BY tahun,kode_cabang,bulan
					) as t";

		$query  = $this->db->query($query);
		$result = $query->result_array();
		return $result[0]['allcount'];
	}


	function insert_targetbulantemp()
	{
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
			'target_bulan' => $jumlah,
			'id_admin' 	  => $id_admin
		);
		$cektemp 	= $this->db->get_where('target_pengirimantemp', array('kode_produk' => $kode_barang, 'tahun' => $tahun, 'bulan' => $bulan, 'kode_cabang' => $cabang))->num_rows();
		$cek	 		= $this->db->get_where('target_pengiriman', array('kode_produk' => $kode_barang, 'tahun' => $tahun, 'bulan' => $bulan, 'kode_cabang' => $cabang))->num_rows();
		if (!empty($cektemp) or !empty($cek)) {
			echo "1";
		} else {
			$this->db->insert('target_pengirimantemp', $data);
		}
	}

	function view_targetbulantemp()
	{
		$cabang = $this->uri->segment(3);
		$bulan  = $this->uri->segment(4);
		$tahun  = $this->uri->segment(5);
		$this->db->join('master_barang', 'target_pengirimantemp.kode_produk = master_barang.kode_produk');
		return $this->db->get_where('target_pengirimantemp', array('target_pengirimantemp.kode_cabang' => $cabang, 'bulan' => $bulan, 'tahun' => $tahun));
	}

	function hapus_targetbulantemp($kodebarang, $cabang, $tahun, $bulan)
	{
		$this->db->delete('target_pengirimantemp', array('kode_produk' => $kodebarang, 'kode_cabang' => $cabang, 'tahun' => $tahun, 'bulan' => $bulan));
	}

	function insert_targetbulan()
	{
		$tahun 		= $this->input->post('tahun');
		$bulan 		= $this->input->post('bulan');
		$cabang		= $this->input->post('cabang');
		$cektemp 	= $this->db->get_where('target_pengirimantemp', array('kode_cabang' => $cabang, 'tahun' => $tahun, 'bulan' => $bulan))->result();
		foreach ($cektemp as $r) {
			$data = array(
				'tahun' 				=> $r->tahun,
				'bulan'					=> $r->bulan,
				'kode_produk'		=> $r->kode_produk,
				'kode_cabang' 	=> $r->kode_cabang,
				'target_bulan' 	=> $r->target_bulan
			);
			$this->db->insert('target_pengiriman', $data);
		}
		$this->db->delete('target_pengirimantemp', array('kode_cabang' => $cabang, 'tahun' => $tahun, 'bulan' => $bulan));
		$this->session->set_flashdata(
			'msg',
			'<div class="alert bg-green text-white alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				 <i class="fa fa-check"></i> Data Berhasil Di Simpan !
		  </div>'
		);
		redirect('oman/targetpengiriman');
	}

	function detail_target_bulan($tahun, $cabang, $bulan)
	{
		$this->db->where('tahun', $tahun);
		$this->db->where('bulan', $bulan);
		$this->db->where('kode_cabang', $cabang);
		$this->db->order_by('target_pengiriman.kode_produk', 'ASC');
		$this->db->select('id_targetbulan,target_pengiriman.kode_produk,nama_barang,target_bulan');
		$this->db->from('target_pengiriman');
		$this->db->join('master_barang', 'target_pengiriman.kode_produk = master_barang.kode_produk');
		return $this->db->get();
	}

	function hapus_all_targetbulan($tahun, $cabang)
	{
		$hapus = $this->db->delete('target_pengiriman', array('tahun' => $tahun, 'kode_cabang' => $cabang));
		if ($hapus) {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="fa fa-check"></i> Data Berhasil Di Hapus !
			  </div>'
			);
			redirect('oman/targetpengiriman');
		} else {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="fa fa-check"></i> Data Gagal Di Hapus !
			  </div>'
			);
			redirect('oman/targetpengiriman');
		}
	}

	function hapus_target_produk_bulan($id)
	{
		$hapus = $this->db->delete('target_pengiriman', array('id_targetbulan' => $id));
		if ($hapus) {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="fa fa-check"></i> Data Berhasil Di Hapus !
			  </div>'
			);
			redirect('oman/targetpengiriman');
		} else {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 <i class="fa fa-check"></i> Data Gagal Di Hapus !
			  </div>'
			);
			redirect('oman/targetpengiriman');
		}
	}

	public function getDataBufferstok($rowno, $rowperpage, $tanggal = "", $cabang = "")
	{
		$this->db->select('kode_bufferstok,kode_cabang');
		$this->db->from('buffer_stok');
		$this->db->order_by('kode_cabang');
		if ($cabang != '') {
			$this->db->where('buffer_Stok.kode_cabang', $cabang);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	// Select total records
	public function getrecordBufferstokCount($tanggal = "", $cabang = "")
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('buffer_stok');
		if ($cabang != '') {
			$this->db->where('buffer_Stok.kode_cabang', $cabang);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}


	function insert_bufferstok()
	{
		$kodebuffer       = $this->input->post('kodebuffer');
		$cabang           = $this->input->post('cabang');
		$id_admin         = $this->session->userdata('id_user');
		$jumproduk        = $this->input->post('jumproduk');
		$data = array(
			'kode_bufferstok'  => $kodebuffer,
			'kode_cabang'      => $cabang,
			'id_admin'         => $id_admin
		);
		$cek  = $this->db->get_where('buffer_stok', array('kode_bufferstok' => $kodebuffer))->num_rows();
		if (empty($cek)) {
			$simpan   = $this->db->insert('buffer_stok', $data);
			if ($simpan) {
				for ($i = 1; $i <= $jumproduk; $i++) {
					$kode_produk     = $this->input->post('kode_produk' . $i);
					$jmldus          = $this->input->post('jmldus' . $i);
					$isipcsdus       = $this->input->post('isipcsdus' . $i);
					$jumlah          = ($jmldus * $isipcsdus);
					$detail_buffer   = array(
						'kode_bufferstok' => $kodebuffer,
						'kode_produk'     => $kode_produk,
						'jumlah'          => $jumlah
					);
					if (!empty($jumlah)) {
						$simpandetail = $this->db->insert('detail_bufferstok', $detail_buffer);
					}
				}
				$this->session->set_flashdata(
					'msg',
					'<div class="alert bg-green text-white alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Data Berhasil Disimpan !
          </div>'
				);
				redirect('oman/bufferstokcabang');
			}
		} else {
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-red text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Sudah Ada !
        </div>'
			);
			redirect('oman/inputbuffer');
		}
	}

	function getBufferstok($kodebuffer)
	{
		return $this->db->get_where('buffer_stok', array('kode_bufferstok' => $kodebuffer));
	}

	function detailBufferstok($kodebuffer)
	{
		$this->db->join('master_barang', 'detail_bufferstok.kode_produk = master_barang.kode_produk');
		return $this->db->get_where('detail_bufferstok', array('kode_bufferstok' => $kodebuffer));
	}

	function update_buffer()
	{
		$kodebuffer       = $this->input->post('kodebuffer');
		$id_admin         = $this->session->userdata('id_user');
		$jumproduk        = $this->input->post('jumproduk');
		$data = array(
			'id_admin'                 => $id_admin
		);

		$updatepenjualan  = $this->db->update('buffer_stok', $data, array('kode_bufferstok' => $kodebuffer));
		if ($updatepenjualan) {
			for ($i = 1; $i <= $jumproduk; $i++) {
				$kode_produk     = $this->input->post('kode_produk' . $i);
				$jmldus          = $this->input->post('jmldus' . $i);
				$isipcsdus       = $this->input->post('isipcsdus' . $i);
				$jumlah          = ($jmldus * $isipcsdus);
				$cek_detail      = $this->db->get_where('detail_bufferstok', array('kode_bufferstok' => $kodebuffer, 'kode_produk' => $kode_produk))->num_rows();


				if (empty($cek_detail) && !empty($jumlah)) {
					$proses = "A";
					$detail_mutasi   = array(
						'kode_bufferstok' 			  => $kodebuffer,
						'kode_produk'             => $kode_produk,
						'jumlah'                  => $jumlah
					);
					$this->db->insert('detail_bufferstok', $detail_mutasi);
				} else if (!empty($cek_detail) && empty($jumlah)) {
					$proses = "B";
					$this->db->delete('detail_bufferstok', array('kode_bufferstok' => $kodebuffer, 'kode_produk' => $kode_produk));
				} else if (!empty($cek_detail) && !empty($jumlah)) {
					$proses = "C";
					$detail_mutasi   = array(
						'kode_produk'             => $kode_produk,
						'jumlah'                  => $jumlah
					);
					$this->db->update('detail_bufferstok', $detail_mutasi, array('kode_bufferstok' => $kodebuffer, 'kode_produk' => $kode_produk));
				} else {
					$proses = "";
				}
				echo $kode_produk . "-" . $cek_detail . "-" . $proses . "<br>";
			}
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Disimpan !
        </div>'
			);
			redirect('oman/bufferstokcabang');
		}
	}

	function hapusbuffer($kodebuffer, $hal)
	{
		$delete = $this->db->delete('buffer_stok', array('kode_bufferstok' => $kodebuffer));
		if ($delete) {
			$this->db->delete('detail_bufferstok', array('kode_bufferstok' => $kodebuffer));
			$this->session->set_flashdata(
				'msg',
				'<div class="alert bg-green text-white alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-check"></i> Data Berhasil Di Hapus !
        </div>'
			);
			redirect('oman/bufferstokcabang/' . $hal);
		}
	}
}
