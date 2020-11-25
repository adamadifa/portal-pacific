<?php

class Model_penjualan extends CI_Model{

	function insert_detailtmp(){
		$kodebarang = $this->input->post('kodebarang');
		$jmldus			= $this->input->post('jmldus');
		$jmlpack		= $this->input->post('jmlpack');
		$jmlpcs			= $this->input->post('jmlpcs');
		$promo 			= $this->input->post('promo');
		$pelanggan 	= $this->input->post('pelanggan');
		echo $promo;
		if($promo !=1){
			$hargadus   = $this->input->post('hargadus');
			$hargapack	= $this->input->post('hargapack');
			$hargapcs		= $this->input->post('hargapcs');
		}else{
			$hargadus 	= 0;
			$hargapack  = 0;
			$hargapcs 	= 0;
		}
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 		= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 		= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
		$brgtmp 		= $this->db->get_where('detailpenjualan_temp',array('kode_barang'=>$kodebarang,'promo'=>$promo,'id_admin'=>$id_admin));
		$cektmp 		= $brgtmp->num_rows();
		$brgold 		= $brgtmp->row_array();
		$jumlahnew 	= $jumlah + $brgold['jumlah'];
		$jmldusnew  = floor($jumlahnew / $isipcsdus);
	  $sisadus    = $jumlahnew % $isipcsdus;
    if($isipackdus == 0){
      $jmlpacknew = 0;
      $sisapack   = $sisadus;
    }else{
      $jmlpacknew = floor($sisadus / $isipcspack);
      $sisapack   = $sisadus % $isipcspack;
    }
  	$jmlpcsnew 		= $sisapack;
    $subtotalnew 	= ($jmldusnew * $hargadus) + ($jmlpacknew * $hargapack) + ($jmlpcsnew * $hargapcs);
    if($cektmp == 0 ){
	    $data  		= array (
										'kode_barang' => $kodebarang,
										'jumlah' 	  	=> $jumlah,
										'harga_dus'   => $hargadus,
										'harga_pack'  => $hargapack,
										'harga_pcs'   => $hargapcs,
										'subtotal'    => $subtotal,
										'promo'		  	=> $promo,
										'id_admin'	  => $id_admin
									);

	    if($pelanggan != 'BATAL'){
	    	//$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
	    	//$this->db->query($query);
	    }
			$this->db->insert('detailpenjualan_temp',$data);
    }else{
    	$data = array (
								'kode_barang' => $kodebarang,
								'jumlah' 	  	=> $jumlahnew,
								'harga_dus'   => $hargadus,
								'harga_pack'  => $hargapack,
								'harga_pcs'   => $hargapcs,
								'subtotal'    => $subtotalnew,
								'promo'		  	=> $promo,
								'id_admin'	  => $id_admin
							);
    	if($pelanggan != 'BATAL'){
	    	//$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
	    	//$this->db->query($query);
	    }
			$this->db->update('detailpenjualan_temp',$data,array('kode_barang'=> $kodebarang,'promo'=>$promo,'id_admin'=>$id_admin));
    }
	}





	function view_detailtmp(){
		$id_admin = $this->session->userdata('id_user');
		$this->db->select('detailpenjualan_temp.kode_barang,nama_barang,isipcsdus,detailpenjualan_temp.harga_dus,isipack,detailpenjualan_temp.harga_pack,isipcs,jumlah,detailpenjualan_temp.harga_pcs,subtotal,promo');
		$this->db->from('detailpenjualan_temp');
		$this->db->join('barang','detailpenjualan_temp.kode_barang = barang.kode_barang');
		$this->db->where('id_admin',$id_admin);
		return $this->db->get();
	}


	function view_detailgbtmp($kodepelanggan){
		$jenismutasi = 'TTR';
		$this->db->select('detailhutangkirimttr_temp.kode_barang,nama_barang,isipcsdus,detailhutangkirimttr_temp.harga_dus,isipack,detailhutangkirimttr_temp.harga_pack,isipcs,jumlah,detailhutangkirimttr_temp.harga_pcs,detailhutangkirimttr_temp.jenis_mutasi');
		$this->db->from('detailhutangkirimttr_temp');
		$this->db->join('barang','detailhutangkirimttr_temp.kode_barang = barang.kode_barang');
		$this->db->join('mutasi_gudang_cabang','detailhutangkirimttr_temp.no_ttr = mutasi_gudang_cabang.no_mutasi_gudang_cabang');
		$this->db->where('kode_pelanggan',$kodepelanggan);
		$this->db->where('detailhutangkirimttr_temp.jenis_mutasi',$jenismutasi);
		return $this->db->get();
	}

	function hapus_detailbrg($kodebarang,$jumlah,$promo){
		//$query 		= "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
		$id_admin 	= $this->session->userdata('id_user');
		//$this->db->query($query);
		$this->db->delete('detailpenjualan_temp',array('kode_barang'=>$kodebarang,'promo'=>$promo,'id_admin'=>$id_admin));
	}


	function hapus_detailbrggb($kodebarang,$jenis_mutasi){
		//$query 		= "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
		$id_admin 	= $this->session->userdata('id_user');
		//$this->db->query($query);
		$this->db->delete('detailhutangkirimttr_temp',array('kode_barang'=>$kodebarang,'jenis_mutasi'=>$jenis_mutasi,'id_admin'=>$id_admin));
	}

	function json(){
		$url 		= base_url();
		$cabang = $this->session->userdata('cabang');
    if($cabang != "pusat"){
      $this->datatables->where('pelanggan.kode_cabang',$cabang);
    }
		$this->datatables->select('kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,pelanggan.kode_cabang,nama_cabang,id_sales,nama_karyawan,limitpel');
    $this->datatables->from('pelanggan');
    $this->datatables->join('cabang','pelanggan.kode_cabang = cabang.kode_cabang');
    $this->datatables->join('karyawan','pelanggan.id_sales = karyawan.id_karyawan');
    $this->datatables->add_column('view', '<a href="#" data-kodepel="$1" data-namapel="$2" data-kodesales="$3" data-namasales="$4" data-cabang="$5" data-limit="$6" class="btn bg-red btn-xs waves-effect pilihpel">Pilih</a>', 'kode_pelanggan,nama_pelanggan,id_sales,nama_karyawan,kode_cabang,limitpel');
    return $this->datatables->generate();
	}


	function insert_penjualan(){

		$nofaktur 			= $this->input->post('nofaktur');
		$limitpelanggan = $this->input->post('limitpelanggan');
		$sisapiutang 		= $this->input->post('sisapiutang');
		$tgltransaksi		= $this->input->post('tgltransaksi');
		$kode_pelanggan = $this->input->post('kodepelanggan');
		$kodesales 			= $this->input->post('kodesales');
		$jenistransaksi = $this->input->post('jenistransaksi');
		// echo $jenistransaksi;
		// die;
		$jenisbayar 		= $this->input->post('jenisbayar');
		$subtotal 			= $this->input->post('subtotal');
		$potongan  			= str_replace(".","",$this->input->post('potongan'));
		$potistimewa  	= str_replace(".","",$this->input->post('potistimewa'));
		$penyharga 			= str_replace(".","",$this->input->post('penyharga'));
		$totalbayar 		= str_replace(".","",$this->input->post('totalbayar'));
		$nogiro 				= $this->input->post('nogiro');
		$jml 						= $this->input->post('jml');
		$materai 				= $this->input->post('materai');
		$namabank 			= $this->input->post('namabank');
		$tglcair 				= $this->input->post('tglcair');
		$tglgiro 				= $this->input->post('tglgiro');
		$jatuhtempo 		= $this->input->post('jatuhtempo');
		$titipan 				= str_replace(".","",$this->input->post('titipan'));
		$cabang 				= $this->input->post('kodecabang');
		$id_admin 			= $this->session->userdata('id_user');
		$hariini 				= date('ymd');
		$tahunini   		= date('y');
		$qbayar       	= "SELECT nobukti FROM historibayar WHERE LEFT(nobukti,6) ='$cabang$tahunini-'ORDER BY nobukti DESC LIMIT 1 ";
		$ceknolast    	= $this->db->query($qbayar)->row_array();
		$nobuktilast  	= $ceknolast['nobukti'];
		$nobukti     	  = buatkode($nobuktilast,$cabang.$tahunini."-",6);
		$totalpiutang 	= $sisapiutang + $totalbayar;
		if($jenisbayar == "tunai"){
			$jt = "";
		}else{
			$jt = $jatuhtempo;
		}
		$data = array(
			'no_fak_penj' 		=> $nofaktur,
			'tgltransaksi'		=> $tgltransaksi,
			'kode_pelanggan' 	=> $kode_pelanggan,
			'id_karyawan'			=> $kodesales,
			'subtotal'				=> $subtotal,
			'potongan' 				=> $potongan,
			'potistimewa' 		=> $potistimewa,
			'penyharga'  			=> $penyharga,
			'total'						=> $totalbayar,
			'jenistransaksi' 	=> $jenistransaksi,
			'jenisbayar' 			=> $jenisbayar,
			'jatuhtempo'			=> $jt,
			'id_admin' 				=> $id_admin
		);
		if(empty($limitpelanggan) AND $jenistransaksi=='kredit' OR $totalpiutang >= $limitpelanggan AND $jenistransaksi=='kredit')
		{

			// echo $jenistransaksi;
			// die;
			// echo $totalpiutang;
			// echo "Jalankan Perintah Ini";
			$penjualan_pending = $this->db->insert('penjualan_pending',$data);
			if($penjualan_pending)
			{
				$tmp = $this->db->query("SELECT detailpenjualan_temp.kode_barang,kode_produk,nama_barang,isipcsdus,
																				detailpenjualan_temp.harga_dus,isipack,detailpenjualan_temp.harga_pack,isipcs,jumlah,
																				detailpenjualan_temp.harga_pcs,subtotal,promo
																	FROM detailpenjualan_temp
																	INNER JOIN barang ON detailpenjualan_temp.kode_barang = barang.kode_barang
																	WHERE id_admin = '$id_admin'")->result();
				foreach($tmp as $t){
					$dtmp = array(
						'no_fak_penj' => $nofaktur,
						'kode_barang' => $t->kode_barang,
						'harga_dus'   => $t->harga_dus,
						'harga_pack'  => $t->harga_pack,
						'harga_pcs'   => $t->harga_pcs,
						'jumlah' 	  	=> $t->jumlah,
						'subtotal' 	  => $t->subtotal,
						'promo' 	  	=> $t->promo,
						'id_admin'    => $id_admin
					);
					$this->db->insert('detailpenjualan_pending',$dtmp);
				}
				$this->db->delete('detailpenjualan_temp',array('id_admin'=>$id_admin));
				if($jenisbayar == "titipan"){
					if($titipan != 0){
						$dbayar = array(
							'nobukti' 				=> $nobukti,
							'no_fak_penj'			=> $nofaktur,
							'tglbayar'				=> $tgltransaksi,
							'jenistransaksi'	=> $jenistransaksi,
							'jenisbayar'			=> $jenisbayar,
							'bayar'						=> $titipan,
							'id_admin'				=> $id_admin,
							'id_karyawan'			=> $kodesales
						);

						$this->db->insert('historibayar_pending',$dbayar);
						$this->session->set_flashdata('msg',
						'<div class="alert bg-yellow alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Penjualan Pending, Menunggu Approval Limit !
						</div>');
						redirect('penjualan/input_penjualan');
					}else{
						$this->session->set_flashdata('msg',
						'<div class="alert bg-yellow alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Penjualan Pending, Menunggu Approval Limit !
						</div>');
						redirect('penjualan/input_penjualan');
					}
				}
			}
		}else{
			$penjualan = $this->db->insert('penjualan',$data);
			if($penjualan){
				// $data_penjualan 	= array(
				// 	'no_mutasi_gudang_cabang'   => $nofaktur,
				// 	'tgl_mutasi_gudang_cabang'  => $tgltransaksi,
				// 	'kode_cabang'               => $cabang,
				// 	'kondisi'                   => 'GOOD',
				// 	'inout_good'                => 'OUT',
				// 	'jenis_mutasi'              => 'PENJUALAN',
				// 	'order'											=> '2',
				// 	'id_admin'                  => $id_admin

				// );
				$tmp = $this->db->query("SELECT detailpenjualan_temp.kode_barang,kode_produk,nama_barang,isipcsdus,
																				detailpenjualan_temp.harga_dus,isipack,detailpenjualan_temp.harga_pack,isipcs,jumlah,
																				detailpenjualan_temp.harga_pcs,subtotal,promo
																	FROM detailpenjualan_temp
																	INNER JOIN barang ON detailpenjualan_temp.kode_barang = barang.kode_barang
																	WHERE id_admin = '$id_admin'")->result();
				foreach($tmp as $t){
					$dtmp = array(
						'no_fak_penj' => $nofaktur,
						'kode_barang' => $t->kode_barang,
						'harga_dus'   => $t->harga_dus,
						'harga_pack'  => $t->harga_pack,
						'harga_pcs'   => $t->harga_pcs,
						'jumlah' 	  	=> $t->jumlah,
						'subtotal' 	  => $t->subtotal,
						'promo' 	  	=> $t->promo,
						'id_admin'    => $id_admin
					);
					$this->db->insert('detailpenjualan',$dtmp);
				}
				// Hapus Tabel Temporrary
				$this->db->delete('detailpenjualan_temp',array('id_admin'=>$id_admin));
				if($jenisbayar == "tunai"){
					//Input Pembayaran
					$dbayar = array(
						'nobukti' 			=> $nobukti,
						'no_fak_penj'		=> $nofaktur,
						'tglbayar'			=> $tgltransaksi,
						'jenistransaksi'=> $jenistransaksi,
						'jenisbayar'		=> $jenisbayar,
						'bayar'					=> $totalbayar,
						'id_admin'			=> $id_admin,
						'id_karyawan'		=> $kodesales
					);
					$this->db->insert('historibayar',$dbayar);
					redirect('penjualan/input_penjualan');
				}elseif($jenisbayar == "titipan"){
					if($titipan != 0){
						$dbayar = array(
							'nobukti' 				=> $nobukti,
							'no_fak_penj'			=> $nofaktur,
							'tglbayar'				=> $tgltransaksi,
							'jenistransaksi'	=> $jenistransaksi,
							'jenisbayar'			=> $jenisbayar,
							'bayar'						=> $titipan,
							'id_admin'				=> $id_admin,
							'id_karyawan'			=> $kodesales
						);

						$this->db->insert('historibayar',$dbayar);
						redirect('penjualan/input_penjualan');
					}else{
						redirect('penjualan/input_penjualan');
					}
				}elseif($jenisbayar == "giro"){
					$dgiro = array(
						'no_fak_penj' 		=> $nofaktur,
						'no_giro'					=> $nogiro,
						'tgl_giro'				=> $tglgiro,
						'materai'					=> $materai,
						'namabank'				=> $namabank,
						'jumlah'					=> $jml,
						'tglcair'					=> $tglcair,
						'status'					=> 0
					);
					$this->db->insert('giro',$dgiro);
					redirect('penjualan/input_penjualan');
				}elseif($jenisbayar == "transfer"){
					$dtransfer = array(
						'no_fak_penj' 		=> $nofaktur,
						'tgl_transfer'		=> $tglgiro,
						'namabank'				=> $namabank,
						'jumlah'					=> $jml,
						'tglcair'					=> $tglcair,
						'status'					=> 0
					);
					$this->db->insert('transfer',$dtransfer);
					redirect('penjualan/input_penjualan');
				}
			}
		}
	}


	function hapus($nofaktur){
		$this->db->delete('penjualan',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('detailpenjualan',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('retur',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('detailretur',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('detailreturgb',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('historibayar',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('giro',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('transfer',array('no_fak_penj'=>$nofaktur));
	}


	function batal($nofaktur){
		$detailpenjualan = $this->db->get_where('detailpenjualan',array('no_fak_penj'=>$nofaktur))->result();
  	foreach($detailpenjualan as $d){
  		$this->db->query("UPDATE barang SET stok = stok + $d->jumlah WHERE kode_barang = '$d->kode_barang'");
  	}
    $this->db->delete('penjualan',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('detailpenjualan',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('historibayar',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('giro',array('no_fak_penj'=>$nofaktur));
		$this->db->delete('transfer',array('no_fak_penj'=>$nofaktur));
	}


	function get_faktur($nofaktur){
		$this->db->where('no_fak_penj',$nofaktur);
		return $this->db->get('view_pembayaran');
	}

	function search_faktur($nofaktur){
		$cabang = $this->session->userdata('cabang');
    if($cabang != "pusat"){
    	$this->db->where('pelanggan.kode_cabang',$cabang);
    }
    $this->db->like('no_fak_penj', $nofaktur , 'both');
    $this->db->order_by('no_fak_penj', 'ASC');
    $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->limit(10);
    return $this->db->get('penjualan')->result();
  }

  function view_detailreturtmp($kodepelanggan){
		$id_admin = $this->session->userdata('id_user');
		$this->db->select('detailretur_temp.kode_barang,nama_barang,isipcsdus,detailretur_temp.harga_dus,isipack,detailretur_temp.harga_pack,isipcs,jumlah,detailretur_temp.harga_pcs,subtotal');
		$this->db->from('detailretur_temp');
		$this->db->join('barang','detailretur_temp.kode_barang = barang.kode_barang');
		$this->db->where(array('id_admin'=> $id_admin,'kode_pelanggan'=>$kodepelanggan));
		return $this->db->get();
	}

	function view_detailreturgbtmp($kodepelanggan){
		$id_admin = $this->session->userdata('id_user');
		$this->db->select('detailreturgb_temp.kode_barang,nama_barang,isipcsdus,detailreturgb_temp.harga_dus,isipack,detailreturgb_temp.harga_pack,isipcs,jumlah,detailreturgb_temp.harga_pcs,subtotal');
		$this->db->from('detailreturgb_temp');
		$this->db->join('barang','detailreturgb_temp.kode_barang = barang.kode_barang');
		$this->db->where(array('id_admin'=> $id_admin,'kode_pelanggan'=>$kodepelanggan));
		return $this->db->get();
	}

	function insert_detailreturtmp(){
		$kodebarang = $this->input->post('kodebarang');
		$jmldus			= $this->input->post('jmldus');
		$hargadus   = $this->input->post('hargadus');
		$jmlpack		= $this->input->post('jmlpack');
		$hargapack	= $this->input->post('hargapack');
		$jmlpcs			= $this->input->post('jmlpcs');
		$hargapcs		= $this->input->post('hargapcs');
		$kodepel 		= $this->input->post('kodepelanggan');
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 		= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 		= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
		$brgtmp 		= $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));
		$brgpnj 		= $this->db->query("SELECT SUM(jumlah) as jumlah FROM detailpenjualan
																		INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
																		WHERE kode_pelanggan = '$kodepel' AND kode_barang ='$kodebarang' ");
		//$brgrtr 	= $this->db->get_where('detailretur',array('no_fak_penj'=>$nofaktur,'kode_barang'=>$kodebarang));
		//$cekbrgrtr	= $brgrtr->row_array();
		$cekjmlpnj	= $brgpnj->row_array();
		$cekjmlrtr  = $brgtmp->row_array();
		$totjumlah 	= $cekjmlrtr['jumlah'] + $jumlah;
		if($totjumlah > $cekjmlpnj['jumlah']){
			echo "1";
		}else{

			$cektmp 		= $brgtmp->num_rows();
			$brgold 		= $brgtmp->row_array();
			$jumlahnew 	= $jumlah + $brgold['jumlah'];
			$jmldusnew  = floor($jumlahnew / $isipcsdus);
		  $sisadus  	= $jumlahnew % $isipcsdus;
	    if($isipackdus == 0){
	        $jmlpacknew = 0;
	        $sisapack   = $sisadus;
	    }else{
	        $jmlpacknew = floor($sisadus / $isipcspack);
	        $sisapack   = $sisadus % $isipcspack;
	    }

	    $jmlpcsnew 		= $sisapack;
	    $subtotalnew 	= ($jmldusnew * $hargadus) + ($jmlpacknew * $hargapack) + ($jmlpcsnew * $hargapcs);

	    if($cektmp == 0 ){
		    $data = array (
									'kode_barang' 			=> $kodebarang,
									'jumlah' 	  				=> $jumlah,
									'harga_dus'   			=> $hargadus,
									'harga_pack'  			=> $hargapack,
									'harga_pcs'   			=> $hargapcs,
									'subtotal'    			=> $subtotal,
									'kode_pelanggan' 		=> $kodepel,
									'id_admin'	 			 	=> $id_admin
								);
				$this->db->insert('detailretur_temp',$data);
	    }else{
	    	$data  = array (
									'kode_barang' 		=> $kodebarang,
									'jumlah' 	  			=> $jumlahnew,
									'harga_dus'   		=> $hargadus,
									'harga_pack'  		=> $hargapack,
									'harga_pcs'   		=> $hargapcs,
									'subtotal'    		=> $subtotalnew,
									'kode_pelanggan' 	=> $kodepel,
									'id_admin'	 			=> $id_admin
								);

				$this->db->update('detailretur_temp',$data,array('kode_barang'=> $kodebarang,'kode_pelanggan'=>$kodepel));
	    }
		}
	}

	function insert_detailreturtmp2(){
		$kodebarang = $this->input->post('kodebarang');
		$jmldus			= $this->input->post('jmldus');
		$hargadus   = $this->input->post('hargadus');
		$jmlpack		= $this->input->post('jmlpack');
		$hargapack	= $this->input->post('hargapack');
		$jmlpcs			= $this->input->post('jmlpcs');
		$hargapcs		= $this->input->post('hargapcs');
		$kodepel 		= $this->input->post('kodepelanggan');
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 		= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 		= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
		$brgtmp 		= $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));
		$brgpnj 		= $this->db->query("SELECT SUM(jumlah) as jumlah FROM detailpenjualan
																		INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
																		WHERE kode_pelanggan = '$kodepel' AND kode_barang ='$kodebarang' ");
		//$brgrtr 	= $this->db->get_where('detailretur',array('no_fak_penj'=>$nofaktur,'kode_barang'=>$kodebarang));
		//$cekbrgrtr	= $brgrtr->row_array();
		$cekjmlpnj	= $brgpnj->row_array();
		$cekjmlrtr  = $brgtmp->row_array();
		$totjumlah 	= $cekjmlrtr['jumlah'] + $jumlah;
		$cektmp 		= $brgtmp->num_rows();
		$brgold 		= $brgtmp->row_array();
		$jumlahnew 	= $jumlah + $brgold['jumlah'];
		$jmldusnew  = floor($jumlahnew / $isipcsdus);
		$sisadus    = $jumlahnew % $isipcsdus;
    if($isipackdus == 0){
      $jmlpacknew = 0;
      $sisapack   = $sisadus;
    }else{
      $jmlpacknew = floor($sisadus / $isipcspack);
      $sisapack   = $sisadus % $isipcspack;
    }
    $jmlpcsnew 		= $sisapack;
    $subtotalnew 	= ($jmldusnew * $hargadus) + ($jmlpacknew * $hargapack) + ($jmlpcsnew * $hargapcs);
    if($cektmp == 0 ){
	    $data 	= array (
								'kode_barang' 			=> $kodebarang,
								'jumlah' 	  				=> $jumlah,
								'harga_dus'   			=> $hargadus,
								'harga_pack'  			=> $hargapack,
								'harga_pcs'   			=> $hargapcs,
								'subtotal'    			=> $subtotal,
								'kode_pelanggan' 		=> $kodepel,
								'id_admin'	 			 	=> $id_admin
							);
			$this->db->insert('detailretur_temp',$data);
    }else{
    	$data 	= array (
									'kode_barang' 		=> $kodebarang,
									'jumlah' 	  			=> $jumlahnew,
									'harga_dus'   		=> $hargadus,
									'harga_pack'  		=> $hargapack,
									'harga_pcs'   		=> $hargapcs,
									'subtotal'    		=> $subtotalnew,
									'kode_pelanggan' 	=> $kodepel,
									'id_admin'	 			=> $id_admin
								);
			$this->db->update('detailretur_temp',$data,array('kode_barang'=> $kodebarang,'kode_pelanggan'=>$kodepel));
    }
	}

	function insert_detailreturgbtmp(){
		$kodebarang = $this->input->post('kodebarang');
		$jmldus			= $this->input->post('jmldus');
		$hargadus   = $this->input->post('hargadus');
		$jmlpack		= $this->input->post('jmlpack');
		$hargapack	= $this->input->post('hargapack');
		$jmlpcs			= $this->input->post('jmlpcs');
		$hargapcs		= $this->input->post('hargapcs');
		$kodepel 		= $this->input->post('kodepelanggan');
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 		= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 		= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
		$brgtmp 		= $this->db->get_where('detailreturgb_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));
		$brgrtrtmp 	= $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));
		$cekjmlgb 	= $brgtmp->row_array();
		$cekjmlrtr 	= $brgrtrtmp->row_array();
		$totjumlah 	= $cekjmlgb['jumlah'] + $jumlah;
		if($totjumlah > $cekjmlrtr['jumlah']){
			echo "1";
		}elseif($totjumlah < $cekjmlrtr['jumlah']){
			echo "2";
		}else{

			$cektmp 		= $brgtmp->num_rows();
			$brgold 		= $brgtmp->row_array();
			$jumlahnew 	= $jumlah + $brgold['jumlah'];
			$jmldusnew  = floor($jumlahnew / $isipcsdus);
			$sisadus    = $jumlahnew % $isipcsdus;
	    if($isipackdus == 0){
	      $jmlpacknew = 0;
	      $sisapack   = $sisadus;
	    }else{
	      $jmlpacknew = floor($sisadus / $isipcspack);
	      $sisapack   = $sisadus % $isipcspack;
	    }

	    $jmlpcsnew 		= $sisapack;
			$subtotalnew 	= ($jmldusnew * $hargadus) + ($jmlpacknew * $hargapack) + ($jmlpcsnew * $hargapcs);
	    if($cektmp == 0 ){
		    $data  		= array (
											'kode_barang' 	 	=> $kodebarang,
											'jumlah' 	 	 			=> $jumlah,
											'harga_dus'  	 		=> $hargadus,
											'harga_pack'     	=> $hargapack,
											'harga_pcs'   	 	=> $hargapcs,
											'subtotal'    	 	=> $subtotal,
											'kode_pelanggan' 	=> $kodepel,
											'id_admin'	  		=> $id_admin
										);
		  	//$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
		    //$this->db->query($query);
				$this->db->insert('detailreturgb_temp',$data);
	    }else{
	  	  $data = 	array (
									'kode_barang' 	 => $kodebarang,
									'jumlah' 	  	 	 => $jumlahnew,
									'harga_dus'   	 => $hargadus,
									'harga_pack'  	 => $hargapack,
									'harga_pcs'   	 => $hargapcs,
									'subtotal'    	 => $subtotalnew,
									'kode_pelanggan' => $kodepel,
									'id_admin'	   	 => $id_admin
								);
	    	//$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
		    //$this->db->query($query);
				$this->db->update('detailreturgb_temp',$data,array('kode_barang'=> $kodebarang,'kode_pelanggan'=>$kodepel));
	    }
		}
	}

	function hapus_detailreturbrg($kodebarang,$kodepelanggan){
		$this->db->delete('detailretur_temp',array('kode_barang'=>$kodebarang,'kode_pelanggan'=>$kodepelanggan));
	}

	function hapus_detailreturgbbrg($kodebarang,$kodepelanggan,$jumlah){
		//$query = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
		//$this->db->query($query);
		$this->db->delete('detailreturgb_temp',array('kode_barang'=>$kodebarang,'kode_pelanggan'=>$kodepelanggan));
	}

	function retur_penjualan(){
		$kodepelanggan 	= $this->input->post('kodepelanggan');
		$nofaktur 			= $this->input->post('nofaktur');
		$tglretur 			= $this->input->post('tglretur');
		$jenisretur			= $this->input->post('jenisretur');
		$cabang 				= $this->input->post('kodecabang');
		$nomorretur 		= $this->input->post('noretur');
		if($jenisretur == "pf"){
			$subtotal_pf 	= $this->input->post('subtotal');
			$subtotal_gb	= 0;
			$total 				= $subtotal_pf + $subtotal_gb;
			$cekfak 			= $this->db->get_where('penjualan',array('no_fak_penj'=>$nofaktur))->row_array();
			if($cekfak['jenistransaksi'] == 'tunai' AND $cekfak['jenisbayar']=='tunai'){
				$updatebayar = $this->db->query("UPDATE historibayar SET bayar= bayar-$total WHERE no_fak_penj = '$nofaktur'");
			}
		}else{
			$subtotal_pf 	= $this->input->post('subtotal');
			$subtotal_gb	= $this->input->post('subtotal');
			$total 				= $subtotal_pf - $subtotal_gb;
		}


		$id_admin 			= $this->session->userdata('id_user');
		$hariini 				= date('ymd');
		$tanggalr 			= explode("-", $tglretur);
		$tahunr 				= $tanggalr[0];
		$bulanr 				= $tanggalr[1];
		$harir 					= $tanggalr[2];
		$thnr 					= substr($tahunr,2,2);
		$tanggalretur 	= $thnr.$bulanr.$harir;
		$this->db->limit(1);
		$this->db->order_by('no_retur_penj','DESC');
    $ceknolast    	= $this->db->query("SELECT no_retur_penj FROM retur WHERE tglretur ='$tglretur' AND LEFT(no_retur_penj,1)='R' ORDER BY no_retur_penj DESC LIMIT 1")->row_array();
    $nobuktilast  	= $ceknolast['no_retur_penj'];
		$noretur      	= buatkode($nobuktilast,'R'.$tanggalretur,3);
    $data 					= array(
												'no_retur_penj' => $noretur,
												'no_ref'				=> $nomorretur,
									    	'no_fak_penj'		=> $nofaktur,
									    	'tglretur'			=> $tglretur,
									    	'subtotal_gb'		=> $subtotal_gb,
									    	'subtotal_pf'		=> $subtotal_pf,
									    	'total'					=> $total,
									    	'jenis_retur'		=> $jenisretur,
									    	'id_admin'			=> $id_admin
	    								);
    $retur 					= $this->db->insert('retur',$data);
    if($retur){
			$tmp 						= $this->db->select('detailretur_temp.kode_barang,kode_produk,jumlah,detailretur_temp.harga_dus,detailretur_temp.harga_pack,detailretur_temp.harga_pcs,subtotal,kode_pelanggan,id_admin');
			$tmp 						= $this->db->from('detailretur_temp');
			$tmp  					= $this->db->join('barang','detailretur_temp.kode_barang = barang.kode_barang');
    	$tmp  					= $this->db->where('id_admin',$id_admin);
			$tmp 						= $this->db->where('kode_pelanggan',$kodepelanggan);
			$tmp 						= $this->db->get()->result();

			foreach($tmp as $t){
				$dtmp = array(
					'no_retur_penj'	=>$noretur,
					'no_fak_penj' 	=> $nofaktur,
					'kode_barang' 	=> $t->kode_barang,
					'harga_dus'   	=> $t->harga_dus,
					'harga_pack'  	=> $t->harga_pack,
					'harga_pcs'   	=> $t->harga_pcs,
					'jumlah' 	  		=> $t->jumlah,
					'subtotal' 	  	=> $t->subtotal,
					'id_admin'    	=> $id_admin
				);
				$this->db->insert('detailretur',$dtmp);
				if($jenisretur != "pf"){
					$this->db->insert('detailreturgb',$dtmp);
				}
			}
			// Hapus Tabel Temporrary
			$this->db->delete('detailretur_temp',array('id_admin'=>$id_admin,'kode_pelanggan'=>$kodepelanggan));
			//$this->db->delete('detailreturgb_temp',array('id_admin'=>$id_admin,'kode_pelanggan'=>$kodepelanggan));
    }
	}

	function cekretur($kodepelanggan){
		return $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepelanggan));
	}

	function cekreturgb($kodepelanggan){
		return $this->db->get_where('detailreturgb_temp',array('kode_pelanggan'=>$kodepelanggan));
	}

	function get_detailpenjualan($nofaktur){
		$this->db->select('detailpenjualan.no_fak_penj,detailpenjualan.kode_barang,nama_barang,kategori,satuan,stok,harga_returdus,harga_returpack,harga_returpcs,isipcsdus,isipack,isipcs,jumlah,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs,subtotal,promo,id_admin');
		$this->db->from('detailpenjualan');
		$this->db->join('barang','detailpenjualan.kode_barang = barang.kode_barang');
		$this->db->where('no_fak_penj',$nofaktur);
		return $this->db->get();
	}

	function view_detailretur2($kodepelanggan,$kodebarang){
		$this->db->select('tglretur,detailretur.kode_barang,nama_barang,isipcsdus,detailretur.harga_dus,isipack,detailretur.harga_pack,isipcs,jumlah,detailretur.harga_pcs,detailretur.subtotal,jenis_retur,retur.no_fak_penj');
		$this->db->from('detailretur');
		$this->db->join('retur','detailretur.no_retur_penj = retur.no_retur_penj');
		$this->db->join('penjualan','retur.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('barang','detailretur.kode_barang = barang.kode_barang');
		$this->db->where('penjualan.kode_pelanggan',$kodepelanggan);
		$this->db->where('detailretur.kode_barang',$kodebarang);
		return $this->db->get();
	}

	function view_detailretur($kodepelanggan){
		$this->db->select('kode_pelanggan,detailretur.kode_barang,nama_barang,isipcsdus,isipack,isipcs,SUM(jumlah) as jumlah');
		$this->db->from('detailretur');
		$this->db->join('retur','detailretur.no_retur_penj = retur.no_retur_penj');
		$this->db->join('penjualan','retur.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('barang','detailretur.kode_barang = barang.kode_barang');
		$this->db->where('penjualan.kode_pelanggan',$kodepelanggan);
		$this->db->group_by('kode_pelanggan,detailretur.kode_barang,nama_barang,isipcsdus,isipack,isipcs');
		return $this->db->get();
	}
	function view_detailreturpf($nofaktur){
		$this->db->select('tglretur,detailretur.kode_barang,nama_barang,isipcsdus,detailretur.harga_dus,isipack,detailretur.harga_pack,isipcs,jumlah,detailretur.harga_pcs,detailretur.subtotal,jenis_retur,retur.no_fak_penj');
		$this->db->from('detailretur');
		$this->db->join('retur','detailretur.no_retur_penj = retur.no_retur_penj');
		$this->db->join('barang','detailretur.kode_barang = barang.kode_barang');
		$this->db->where('retur.no_fak_penj',$nofaktur);
		return $this->db->get();
	}

	function view_detailreturgb($nofaktur){
		$this->db->select('tglretur,detailreturgb.kode_barang,nama_barang,isipcsdus,detailreturgb.harga_dus,isipack,detailreturgb.harga_pack,isipcs,jumlah,detailreturgb.harga_pcs,subtotal,jenis_retur');
		$this->db->from('detailreturgb');
		$this->db->join('retur','detailreturgb.no_retur_penj = retur.no_retur_penj');
		$this->db->join('barang','detailreturgb.kode_barang = barang.kode_barang');
		$this->db->where('retur.no_fak_penj',$nofaktur);
		return $this->db->get();
	}

	function ceknofaktur($nofaktur){
		return $this->db->get_where('penjualan',array('no_fak_penj'=>$nofaktur));
	}

	public function getreturData($rowno,$rowperpage,$search="",$nofaktur="") {
 		$cabang = $this->session->userdata('cabang');
    if($cabang != "pusat"){
      $this->db->where('kode_cabang',$cabang);
    }
 		$this->db->select('no_retur_penj,retur.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,kode_cabang,tglretur,subtotal_gb,subtotal_pf,retur.total');
  	$this->db->from('retur');
  	$this->db->join('penjualan','retur.no_fak_penj = penjualan.no_fak_penj');
  	$this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
  	$this->db->order_by('no_retur_penj','desc');
  	if($search != ''){
    	$this->db->like('nama_pelanggan', $search);
  	}
  	if($nofaktur != ''){
      $this->db->where('retur.no_fak_penj', $nofaktur);
    }
 		$this->db->limit($rowperpage, $rowno);
  	$query = $this->db->get();
    return $query->result_array();
 	}

	  // Select total records
  public function getrecordreturCount($search = '',$nofaktur='') {
  	$cabang = $this->session->userdata('cabang');
    if($cabang != "pusat"){
      $this->db->where('kode_cabang',$cabang);
    }
   	$this->db->select('count(*) as allcount');
  	$this->db->from('retur');
  	$this->db->join('penjualan','retur.no_fak_penj = penjualan.no_fak_penj');
  	$this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    if($search != ''){
      $this->db->like('nama_pelanggan', $search);
    }
    if($nofaktur != ''){
      $this->db->where('retur.no_fak_penj', $nofaktur);
    }
    $query 	= $this->db->get();
    $result = $query->result_array();
 		return $result[0]['allcount'];
	}



	function hapusretur($no_retur){
		$this->db->delete('retur',array('no_retur_penj'=>$no_retur));
		$this->db->delete('detailretur',array('no_retur_penj'=>$no_retur));
		$this->db->delete('detailreturgb',array('no_retur_penj'=>$no_retur));
	}

	function batalretur($no_retur){
		$detailreturgb = $this->db->get_where('detailreturgb',array('no_retur_penj'=>$no_retur))->result();
  	foreach($detailreturgb as $d){
  		$this->db->query("UPDATE barang SET stok = stok + $d->jumlah WHERE kode_barang = '$d->kode_barang'");
  	}
		$this->db->delete('retur',array('no_retur_penj'=>$no_retur));
		$this->db->delete('detailretur',array('no_retur_penj'=>$no_retur));
		$this->db->delete('detailreturgb',array('no_retur_penj'=>$no_retur));
	}

	function get_retur($no_retur){
		return $this->db->get_where('retur',array('no_retur_penj'=>$no_retur));
	}

	function view_detailretur_r($no_retur){
		$this->db->select('detailretur.no_retur_penj,tglretur,detailretur.kode_barang,nama_barang,isipcsdus,detailretur.harga_dus,isipack,detailretur.harga_pack,isipcs,jumlah,detailretur.harga_pcs,subtotal,jenis_retur');
		$this->db->from('detailretur');
		$this->db->join('retur','detailretur.no_retur_penj = retur.no_retur_penj');
		$this->db->join('barang','detailretur.kode_barang = barang.kode_barang');
		$this->db->where('retur.no_retur_penj',$no_retur);
		return $this->db->get();
	}

	function view_detailreturgb_r($no_retur){
		$this->db->select('detailreturgb.no_retur_penj,tglretur,detailreturgb.kode_barang,nama_barang,isipcsdus,detailreturgb.harga_dus,isipack,detailreturgb.harga_pack,isipcs,jumlah,detailreturgb.harga_pcs,subtotal,jenis_retur');
		$this->db->from('detailreturgb');
		$this->db->join('retur','detailreturgb.no_retur_penj = retur.no_retur_penj');
		$this->db->join('barang','detailreturgb.kode_barang = barang.kode_barang');
		$this->db->where('retur.no_retur_penj',$no_retur);
		return $this->db->get();
	}

	function hitungkatproduk($kategori,$id_admin){
		$this->db->select("detailpenjualan_temp.kode_barang,isipcsdus,isipack,isipcs,kategori,SUM(jumlah) as jumlah");
		$this->db->from('detailpenjualan_temp');
		$this->db->join('barang','detailpenjualan_temp.kode_barang = barang.kode_barang');
		$this->db->where('kategori',$kategori);
		$this->db->where('id_admin',$id_admin);
		$this->db->where('promo !=',1);
		$this->db->group_by('kategori,kode_barang');
		return $this->db->get();
	}

	function hitungdiskon($kategori,$jmldus){
		$query = "SELECT diskon FROM diskon WHERE '$jmldus' >= dari AND '$jmldus' <= sampai AND kategori ='$kategori'";
		return $this->db->query($query);
	}

	function view_detailpenjualan($kodepelanggan){
		$this->db->select('kode_pelanggan,detailpenjualan.kode_barang,nama_barang,SUM(jumlah) as jumlah,promo,isipcsdus,isipack,isipcs,kategori,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs,harga_returdus,harga_returpack,harga_returpcs,satuan,stok');
		$this->db->from('detailpenjualan');
		$this->db->join('penjualan','detailpenjualan.no_fak_penj = penjualan.no_fak_penj');
		$this->db->join('barang','detailpenjualan.kode_barang = barang.kode_barang');
		$this->db->where('penjualan.kode_pelanggan',$kodepelanggan);
		$this->db->group_by('detailpenjualan.kode_barang,nama_barang,promo,isipcsdus,isipack,isipcs,kategori,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs,harga_returdus,harga_returpack,harga_returpcs,satuan,stok');
		return $this->db->get();
	}

	function view_detailpenjualan2($kodecabang){
		$this->db->order_by('nama_barang');
		return $this->db->get_where('barang',array('kode_cabang'=>$kodecabang));
	}

	function editfaktur($nofaktur){
		$no_faktur 			= $this->input->post('no_faktur');
		$tgltransaksi		= $this->input->post('tgltransaksi');
		$sales 					= $this->input->post('sales');
		$jenistransaksi = $this->input->post('jenistransaksi');
		$data = array(
							'no_fak_penj' 		=> $no_faktur,
							'tgltransaksi'		=> $tgltransaksi,
							'id_karyawan'			=> $sales,
							'jenistransaksi'	=> $jenistransaksi
						);

		$updatepenjualan = $this->db->update('penjualan',$data,array('no_fak_penj'=>$nofaktur));
		if($updatepenjualan){
			$this->db->query("UPDATE detailpenjualan SET no_fak_penj = '$no_faktur' WHERE no_fak_penj = '$nofaktur'");
			$this->db->query("UPDATE detailretur SET no_fak_penj = '$no_faktur' WHERE no_fak_penj = '$nofaktur'");
			$this->db->query("UPDATE detailreturgb SET no_fak_penj = '$no_faktur' WHERE no_fak_penj = '$nofaktur'");
			$this->db->query("UPDATE giro SET no_fak_penj = '$no_faktur' WHERE no_fak_penj = '$nofaktur'");
			$this->db->query("UPDATE historibayar SET no_fak_penj = '$no_faktur',jenistransaksi='$jenistransaksi' WHERE no_fak_penj = '$nofaktur'");
			$this->db->query("UPDATE retur SET no_fak_penj = '$no_faktur' WHERE no_fak_penj = '$nofaktur'");
			$this->db->query("UPDATE transfer SET no_fak_penj = '$no_faktur' WHERE no_fak_penj = '$nofaktur'");
		}
	}

	public function getDataHutangkirim($rowno,$rowperpage,$no_faktur="",$tglmutasi="") {
		$cabang = $this->session->userdata('cabang');
		if($cabang != "pusat"){
			$this->db->where('mutasi_gudang_cabang.kode_cabang',$cabang);
		}
	  $this->db->where('jenis_mutasi','HUTANG KIRIM');
    $this->db->where('inout_good','IN');
    $this->db->select('*');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('penjualan','mutasi_gudang_cabang.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->order_by('tgl_mutasi_gudang_cabang,time_stamp','desc');
	  if($no_faktur != ''){
	    $this->db->where('mutasi_gudang_cabang.no_fak_penj', $no_faktur);
	  }
    if($tglmutasi != ''){
      $this->db->where('tgl_mutasi_gudang_cabang', $tglmutasi);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
   }

    // Select total records
  public function getrecordHutangkirimCount($no_faktur = "" ,$tglmutasi="") {
		$cabang = $this->session->userdata('cabang');
		if($cabang != "pusat"){
			$this->db->where('mutasi_gudang_cabang.kode_cabang',$cabang);
		}
    $this->db->where('jenis_mutasi','HUTANG KIRIM');
    $this->db->where('inout_good','IN');
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('penjualan','mutasi_gudang_cabang.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    if($no_faktur != ''){
      $this->db->where('mutasi_gudang_cabang.no_fak_penj', $no_faktur);
    }

    if($tglmutasi != ''){
      $this->db->where('tgl_mutasi_gudang_cabang', $tglmutasi);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }


  function getMutasiCab($nomutasi){
    $this->db->where('no_mutasi_gudang_cabang',$nomutasi);
    $this->db->join('penjualan','mutasi_gudang_cabang.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    return $this->db->get('mutasi_gudang_cabang');
  }

  function detail_mutasiCab($nofaktur){
  	$query = "SELECT
								detail_mutasi_gudang_cabang.no_fak_penj,
								detail_mutasi_gudang_cabang.kode_produk,
								nama_barang,
								isipcsdus,
								isipack,
								isipcs,
								harga_dus,
								harga_pack,
								harga_pcs,
								SUM( IF ( jenis_mutasi = 'HUTANG KIRIM' AND inout_good = 'IN', jumlah, 0 ) ) AS jumlah,
								SUM( IF ( jenis_mutasi = 'HUTANG KIRIM' AND inout_good = 'OUT', jumlah, 0 ) ) AS pelunasan_hk
							FROM
								detail_mutasi_gudang_cabang
							INNER JOIN master_barang ON detail_mutasi_gudang_cabang.kode_produk = master_barang.kode_produk
							INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
							WHERE jenis_mutasi ='HUTANG KIRIM' AND detail_mutasi_gudang_cabang.no_fak_penj = '$nofaktur'
							GROUP BY
								detail_mutasi_gudang_cabang.no_fak_penj,
								detail_mutasi_gudang_cabang.kode_produk,
								nama_barang,
								isipcsdus,
								isipack,
								isipcs,
								harga_dus,
								harga_pack,
								harga_pcs";
							return $this->db->query($query);
  }


  function insert_pelunasanhk(){
  	$no_hutangkirim 	= $this->input->post('no_hutangkirim');
  	$trans 						= $this->db->get_where('mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_hutangkirim))->row_array();
  	$tgltransaksi 		= $this->input->post('tglpelunasan');
  	$nofaktur 				= $trans['no_fak_penj'];
  	$cabang 					= $trans['kode_cabang'];
  	$id_admin 				= $this->session->userdata('id_user');
  	$qhk 							= "SELECT LEFT(no_mutasi_gudang_cabang,7) as no_hk
	                				FROM mutasi_gudang_cabang
	                				WHERE tgl_mutasi_gudang_cabang = '$tgltransaksi' AND jenis_mutasi='HUTANG KIRIM'  AND inout_good ='OUT'
	                				AND MID(no_mutasi_gudang_cabang,3,3) = '$cabang' ORDER by LEFT(no_mutasi_gudang_cabang,7) DESC";
    $hk  							= $this->db->query($qhk)->row_array();
    $tanggal      		= explode("-",$tgltransaksi);
    $hari         		= $tanggal[2];
    $bulan          	= $tanggal[1];
    $tahun          	= $tanggal[0];
    $tgl            	= ".".$hari.".".$bulan.".".$tahun;
    $nomor_terakhir 	= $hk['no_hk'];
    $no_hk 						= buatkode($nomor_terakhir,"PL".$cabang,2).$tgl;
    $data_hk 					= array(
						        		  'no_mutasi_gudang_cabang'   	=> $no_hk,
							            'tgl_mutasi_gudang_cabang'  => $tgltransaksi,
							            'no_fak_penj'								=> $nofaktur,
							            'no_hutangkirim'						=> $no_hutangkirim,
							            'kode_cabang'               => $cabang,
							            'kondisi'                   => 'GOOD',
							            'inout_good'                => 'OUT',
							            'jenis_mutasi'              => 'HUTANG KIRIM',
													'order'											=> 5,
							            'id_admin'                  => $id_admin
    										);

    $insert_hk 			= $this->db->insert('mutasi_gudang_cabang',$data_hk);
    if($insert_hk){
    	$qhutangkirim = "SELECT * FROM detailplhutangkirim_temp WHERE no_fak_penj ='$nofaktur' AND id_admin ='$id_admin'";
			$hutangkirim  = $this->db->query($qhutangkirim)->result();
			foreach($hutangkirim as $h){
				$data_detailhk = array(
			                    'no_mutasi_gudang_cabang' => $no_hk,
			                    'no_fak_penj'			  			=> $nofaktur,
													'no_retur_penj'						=> $h->no_retur_penj,
			                    'kode_produk'             => $h->kode_produk,
			                    'harga_dus'               => $h->harga_dus,
			                    'harga_pack'              => $h->harga_pack,
			                    'harga_pcs'               => $h->harga_pcs,
			                    'jumlah'                  => $h->jumlah
            						);

				$insert_detailhk = $this->db->insert('detail_mutasi_gudang_cabang',$data_detailhk);
			}
			$hapus_detailhk = "DELETE FROM detailplhutangkirim_temp WHERE no_fak_penj ='$nofaktur' AND id_admin ='$id_admin'";
			$this->db->query($hapus_detailhk);
			$this->session->set_flashdata('msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
        </div>');
    	redirect('penjualan/hutangkirim');
    }
  }



  function hapus_plhk($no_hutangkirim){
  	$hapushk = $this->db->delete('mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_hutangkirim));
  	if($hapushk){
  		$this->db->delete('detail_mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_hutangkirim));
  		$this->session->set_flashdata('msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil DiHapus !
      </div>');

    	redirect('penjualan/hutangkirim');
  	}
  }


  public function getDataTTR($rowno,$rowperpage,$namapel="",$tglmutasi="") {
    $cabang = $this->session->userdata('cabang');
   	if($cabang != 'pusat'){
			$this->db->where('mutasi_gudang_cabang.kode_cabang',$cabang);
   	}
    $this->db->where('jenis_mutasi','TTR');
    $this->db->where('inout_good','OUT');
    $this->db->select('*');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->order_by('tgl_mutasi_gudang_cabang,time_stamp','desc');
    $this->db->join('pelanggan','mutasi_gudang_cabang.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan','pelanggan.id_Sales = karyawan.id_karyawan');
		if($namapel != ''){
		  $this->db->like('nama_pelanggan', $namapel);
	  }
    if($tglmutasi != ''){
	  	$this->db->where('tgl_mutasi_gudang_cabang', $tglmutasi);
    }
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
 	}

    // Select total records
  public function getrecordTTRCount($namapel = "" ,$tglmutasi="") {
    $cabang = $this->session->userdata('cabang');
		if($cabang != 'pusat'){
			$this->db->where('mutasi_gudang_cabang.kode_cabang',$cabang);
		}
		$this->db->where('jenis_mutasi','TTR');
    $this->db->where('inout_good','OUT');
    $this->db->select('count(*) as allcount');
    $this->db->from('mutasi_gudang_cabang');
    $this->db->join('pelanggan','mutasi_gudang_cabang.kode_pelanggan = pelanggan.kode_pelanggan');
 		$this->db->join('karyawan','pelanggan.id_Sales = karyawan.id_karyawan');
    if($namapel != ''){
      $this->db->like('nama_pelanggan', $namapel);
    }
    if($tglmutasi != ''){
      $this->db->where('tgl_mutasi_gudang_cabang', $tglmutasi);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  function view_detailttrtemp(){
    $id_admin 	= $this->session->userdata('id_user');
    $this->db->select('detailttr_temp.kode_produk,nama_barang,isipcsdus,detailttr_temp.harga_dus,isipack,detailttr_temp.harga_pack,isipcs,jumlah,detailttr_temp.harga_pcs');
    $this->db->from('detailttr_temp');
    $this->db->join('master_barang','detailttr_temp.kode_produk = master_barang.kode_produk');
    $this->db->where('id_admin',$id_admin);
    return $this->db->get();
  }

	function insert_detailttrtemp(){
    $kode_produk  = $this->input->post('kode_produk');
    $jmldus       = $this->input->post('jmldus');
    $jmlpack      = $this->input->post('jmlpack');
    $jmlpcs       = $this->input->post('jmlpcs');
    $hargadus     = $this->input->post('hargadus');
    $hargapack    = $this->input->post('hargapack');
    $hargapcs     = $this->input->post('hargapcs');
    $cabang       = $this->input->post('cabang');
    $isipcsdus    = $this->input->post('isipcsdus');
    $isipcspack   = $this->input->post('isipcspack');
    $id_admin     = $this->session->userdata('id_user');
    $jumlah       = ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
    $brgtmp       = $this->db->get_where('detailttr_temp',array('kode_produk'=>$kode_produk,'id_admin'=>$id_admin));
    $cektmp       = $brgtmp->num_rows();
    if($cektmp != 0){
      echo "1";
    }else{
    	$data   = array (
                'kode_produk' => $kode_produk,
                'jumlah'      => $jumlah,
                'harga_dus'   => $hargadus,
                'harga_pack'  => $hargapack,
                'harga_pcs'   => $hargapcs,
                'id_admin'    => $id_admin
            	);
      $this->db->insert('detailttr_temp',$data);
	  }
	}

  function hapus_detailbrgttr($kode_produk){
    //$query    = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
    $id_admin   = $this->session->userdata('id_user');
    //$this->db->query($query);
    $this->db->delete('detailttr_temp',array('kode_produk'=>$kode_produk,'id_admin'=>$id_admin));
  }


  function insert_ttr(){
    $tgl_ttr 				= $this->input->post('tgl_ttr');
    $cabang         = $this->input->post('kodecabang');
    $id_admin       = $this->session->userdata('id_user');
    $kodepelanggan  = $this->input->post('kodepelanggan');
    $query          = "SELECT LEFT(no_mutasi_gudang_cabang,7) as no_ttr
                       FROM mutasi_gudang_cabang
                       WHERE tgl_mutasi_gudang_cabang = '$tgl_ttr' AND jenis_mutasi='TTR'
                       AND MID(no_mutasi_gudang_cabang,3,3) = '$cabang' ORDER by LEFT(no_mutasi_gudang_cabang,7) DESC";
    $ttr    				= $this->db->query($query)->row_array();
    $tanggal        = explode("-",$tgl_ttr);
    $hari           = $tanggal[2];
    $bulan          = $tanggal[1];
    $tahun          = $tanggal[0];
    $tgl            = ".".$hari.".".$bulan.".".$tahun;
    $nomor_terakhir = $ttr['no_ttr'];

    $no_ttr					= buatkode($nomor_terakhir,"TR".$cabang,2).$tgl;
    $data_ttr 			= array(
						          'no_mutasi_gudang_cabang'   => $no_ttr,
						          'tgl_mutasi_gudang_cabang'  => $tgl_ttr,
						          'kode_pelanggan'						=> $kodepelanggan,
						          'kode_cabang'               => $cabang,
						          'kondisi'                   => 'GOOD',
						          'inout_good'                => 'OUT',
						          'jenis_mutasi'              => 'TTR',
											'order'											=> 6,
						          'id_admin'                  => $id_admin
    								);
    $insert_ttr 	= $this->db->insert('mutasi_gudang_cabang',$data_ttr);
    if($insert_ttr){
      $detail = $this->db->get_where('detailttr_temp',array('id_admin'=>$id_admin))->result();
      foreach($detail as $d){
    		$data_detail = array(
	        'no_mutasi_gudang_cabang' => $no_ttr,
	        'kode_produk'             => $d->kode_produk,
	        'harga_dus'               => $d->harga_dus,
	        'harga_pack'              => $d->harga_pack,
	        'harga_pcs'               => $d->harga_pcs,
	        'jumlah'                  => $d->jumlah
    		);
        $this->db->insert('detail_mutasi_gudang_cabang',$data_detail);
    	}

      $hapus_detail = $this->db->delete('detailttr_temp',array('id_admin'=>$id_admin));
      $this->session->set_flashdata('msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
          </div>');
      redirect('penjualan/ttr');
    }
  }


  function hapusttr($no_ttr){
    $delete = $this->db->delete('mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_ttr));
    if($delete){
      $this->db->delete('detail_mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$no_ttr));
      $this->session->set_flashdata('msg',
      '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Di Hapus !
        </div>');

    	redirect('penjualan/ttr');
    }
  }

  function cek_ttr($pelanggan){
  	//echo $pelanggan;
  	$query = "SELECT * FROM mutasi_gudang_cabang WHERE kode_pelanggan ='$pelanggan' AND jenis_mutasi='TTR' AND no_fak_penj IS NULL OR kode_pelanggan ='$pelanggan' AND jenis_mutasi='TTR' AND no_fak_penj =''";
  	return $this->db->query($query);
  }
  function insert_detailttrtemp2($id_ttr=null){
  	$cabang    = $this->input->post('cabang');
		$cek 	   	 = $this->db->get_where('detailhutangkirimttr_temp',array('no_ttr'=>$id_ttr))->num_rows();
		if(empty($cek)){
			$detailttr = $this->db->get_where('detail_mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$id_ttr));
			$id_admin  = $this->session->userdata('id_user');
			foreach($detailttr->result() as $d ){
				$brg 	     	 = $this->db->get_where('barang',array('kode_cabang'=>$cabang,'kode_produk'=>$d->kode_produk))->row_array();
				$kode_barang = $brg['kode_barang'];
				$data_detail = array(
												'no_ttr'				=> $d->no_mutasi_gudang_cabang,
												'kode_barang' 	=> $kode_barang,
												'jumlah'	  		=> $d->jumlah,
												'harga_dus'	  	=> $d->harga_dus,
												'harga_pack'  	=> $d->harga_pack,
												'harga_pcs'	  	=> $d->harga_pcs,
												'jenis_mutasi' 	=> 'TTR',
												'id_admin'	  	=> $id_admin
											);
				$this->db->insert('detailhutangkirimttr_temp',$data_detail);
			}
		}else{
			echo "1";
		}
	}

	public function getdataGiro($rowno,$rowperpage,$namapel="",$nofaktur="",$nogiro="",$status="",$dari="",$sampai="") {
 	  $cabang = $this->session->userdata('cabang');
    if($cabang != "pusat"){
      $this->datatables->where('kode_cabang',$cabang);
    }
    $this->db->select('giro.id_giro,tgl_giro,giro.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,kode_cabang,no_giro,materai,namabank,jumlah,tglcair,giro.status,ket,tglbayar');
    $this->db->from('giro');
		$this->db->join('historibayar','giro.id_giro = historibayar.id_giro','left');
    $this->db->join('penjualan','giro.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->order_by('tglcair','desc');
    if($namapel != ''){
      $this->db->like('nama_pelanggan', $namapel);
    }
    if($nofaktur != ''){
      $this->db->where('giro.no_fak_penj', $nofaktur);
    }
    if($nogiro != ''){
      $this->db->where('giro.no_giro', $nogiro);
    }
    if($status !==''){
      $this->db->where('giro.status', $status);
    }
    if($dari !=  ''){
      $this->db->where('tgl_giro >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_giro <=', $sampai);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    //echo $sampai;
    return $query->result_array();
   }

    // Select total records
  public function getrecordGiro($namapel = "", $nofaktur="",$nogiro="",$status="",$dari="",$sampai="") {

    $this->db->select('count(giro.id_giro) as allcount');
    $this->db->from('giro');
		$this->db->join('historibayar','giro.id_giro = historibayar.id_giro','left');
    $this->db->join('penjualan','giro.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->order_by('tglcair','desc');
    $cabang = $this->session->userdata('cabang');
   	if($cabang != "pusat"){
    	$this->datatables->where('pelanggan.kode_cabang',$cabang);
  	}
    if($namapel != ''){
      $this->db->like('nama_pelanggan', $namapel);
    }
    if($nofaktur != ''){
      $this->db->where('giro.no_fak_penj', $nofaktur);
    }
    if($nogiro != ''){
      $this->db->where('giro.no_giro', $nogiro);
    }
    if($status !==  ''){
      $this->db->where('giro.status', $status);
    }
    if($dari !=  ''){
      $this->db->where('tgl_giro >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_giro <=', $sampai);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

  public function getdataTransfer($rowno,$rowperpage,$namapel="",$nofaktur="",$dari="",$sampai="",$status="") {
	  $this->db->select('transfer.id_transfer,tgl_transfer,transfer.no_fak_penj,penjualan.kode_pelanggan,nama_pelanggan,kode_cabang,norek,namapemilikrek,namabank,jumlah,tglcair,transfer.status,ket,tglbayar');
	  $this->db->from('transfer');
		$this->db->join('historibayar','transfer.id_transfer = historibayar.id_transfer','left');
	  $this->db->join('penjualan','transfer.no_fak_penj = penjualan.no_fak_penj');
	  $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
	  $this->db->order_by('tglcair','desc');
	  $cabang = $this->session->userdata('cabang');
   	if($cabang != "pusat"){
      $this->datatables->where('pelanggan.kode_cabang',$cabang);
   	}
	  if($namapel != ''){
	    $this->db->like('nama_pelanggan', $namapel);
	  }
	  if($nofaktur != ''){
	    $this->db->where('transfer.no_fak_penj', $nofaktur);
	  }
	  if($dari !=  ''){
	    $this->db->where('tgl_transfer >=', $dari);
	  }
	  if($sampai !=  ''){
	    $this->db->where('tgl_transfer <=', $sampai);
	  }
	  if($status !==''){
	    $this->db->where('transfer.status', $status);
	  }
	  $this->db->limit($rowperpage, $rowno);
	  $query = $this->db->get();
	  return $query->result_array();
	}
  // Select total records
  public function getrecordTransfer($namapel = "", $nofaktur="",$dari="",$sampai="",$status="") {
    $this->db->select('count(transfer.id_transfer) as allcount');
    $this->db->from('transfer');
		$this->db->join('historibayar','transfer.id_transfer = historibayar.id_transfer','left');
    $this->db->join('penjualan','transfer.no_fak_penj = penjualan.no_fak_penj');
    $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->order_by('tglcair','desc');
    $cabang = $this->session->userdata('cabang');
    if($cabang != "pusat"){
      $this->datatables->where('pelanggan.kode_cabang',$cabang);
    }
    if($namapel != ''){
      $this->db->like('nama_pelanggan', $namapel);
    }
    if($nofaktur != ''){
      $this->db->where('transfer.no_fak_penj', $nofaktur);
    }
    if($dari !=  ''){
      $this->db->where('tgl_transfer >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_transfer <=', $sampai);
    }
    if($status !==  ''){
      $this->db->where('status', $status);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
	}

	function get_setoran($tanggallhp,$salesman,$jenistransaksi){
		$query = "SELECT historibayar.id_karyawan,SUM(bayar) as totalsetoran
				  		FROM historibayar
				  		INNER JOIN penjualan ON historibayar.no_fak_penj = penjualan.no_fak_penj
				  		WHERE tglbayar ='$tanggallhp' AND historibayar.id_karyawan = '$salesman'
				  		AND historibayar.jenistransaksi='$jenistransaksi' AND id_giro  IS NULL  AND girotocash IS NULL AND id_transfer IS NULL AND status_bayar IS NULL
				  		GROUP BY historibayar.id_karyawan";
		return $this->db->query($query);
	}

	function get_setorangiro($tanggallhp,$salesman){
		$query = "SELECT giro.id_karyawan,SUM(jumlah) as totalsetorangiro
				  		FROM giro
				  		INNER JOIN penjualan ON giro.no_fak_penj = penjualan.no_fak_penj
				  		WHERE giro.id_karyawan ='$salesman' AND tgl_giro ='$tanggallhp'
				  		GROUP BY giro.id_karyawan";
		return $this->db->query($query);
	}

	function get_setorantransfer($tanggallhp,$salesman){
		$query = "SELECT transfer.id_karyawan,SUM(jumlah) as totalsetorantransfer
				  		FROM transfer
				  		INNER JOIN penjualan ON transfer.no_fak_penj = penjualan.no_fak_penj
				  		WHERE transfer.id_karyawan ='$salesman' AND tgl_transfer ='$tanggallhp'
				  		GROUP BY transfer.id_karyawan";
		return $this->db->query($query);
	}


	function get_girotocash($tanggallhp,$salesman,$jenistransaksi){
		$query = "SELECT historibayar.id_karyawan,SUM(bayar) as totalsetoran
				  		FROM historibayar
				  		INNER JOIN penjualan ON historibayar.no_fak_penj = penjualan.no_fak_penj
				  		WHERE tglbayar ='$tanggallhp' AND historibayar.id_karyawan = '$salesman'
				  		AND historibayar.jenistransaksi='$jenistransaksi'   AND girotocash IS NOT NULL
				  		GROUP BY historibayar.id_karyawan";
		return $this->db->query($query);
	}


	function inputsetoranpenjualan(){
		$tgllhp 				=  $this->input->post('tgllhpkb');
		$cabang 				=  $this->input->post('cabangkb');
		$salesman   		=  $this->input->post('salesmankb');
		$tunai      		=  $this->input->post('tunai');
		$tagihan  			=  $this->input->post('tagihan');
		$uangkertas 		=  str_replace(".","",$this->input->post('uangkertas'));
		$uanglogam  		=  str_replace(".","",$this->input->post('uanglogam'));
		$lainnya    		=  str_replace(".","",$this->input->post('lainnya'));
		$bgcek 					=  $this->input->post('bgcek');
		$transfer 		  =  $this->input->post('transfer');
		$girotocash 		=  $this->input->post('girotocash');
		$keterangan 		=  $this->input->post('keterangan');
		$tanggal 				= explode("-",$tgllhp);
		$hari 					= $tanggal[2];
		$bulan 					= $tanggal[1];
		$tahun 					= $tanggal[0];
		$thn 						= substr($tahun,2,2);
		$tgl 						= $hari.$bulan.$thn;
		$tahunini   		= date("y");
		$qsp 						= "SELECT kode_setoran FROM setoran_penjualan
					   			 		 WHERE LEFT(kode_setoran,4) = 'SP$tahunini' ORDER BY kode_setoran DESC LIMIT 1";
		$sp 			 			= $this->db->query($qsp)->row_array();
		$nomor_terakhir = $sp['kode_setoran'];
		$kode_setoran 	= buatkode($nomor_terakhir,'SP'.$tahunini,5);
		$data = array(
			'kode_setoran' 		=> $kode_setoran,
			'tgl_lhp' 				=> $tgllhp,
			'kode_cabang'			=> $cabang,
			'id_karyawan' 		=> $salesman,
			'lhp_tunai'				=> $tunai,
			'lhp_tagihan'			=> $tagihan,
			'setoran_kertas'	=> $uangkertas,
			'setoran_logam' 	=> $uanglogam,
			'setoran_lainnya'	=> $lainnya,
			'setoran_bg'			=> $bgcek,
			'setoran_transfer'=> $transfer,
			'girotocash'			=> $girotocash,
			'keterangan'			=> $keterangan
		);
		if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		if(empty($ceksa)){
			$ceksetoran 		= $this->db->get_where('setoran_penjualan',array('tgl_lhp'=>$tgllhp,'id_karyawan'=>$salesman))->num_rows();
			if(empty($ceksetoran)){
				$insert = $this->db->insert('setoran_penjualan',$data);
				if($insert){
					$this->session->set_flashdata('msg',
					'<div class="alert bg-green alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
					</div>');
					redirect('penjualan/setoranpenjualan');
				}else{
					$this->session->set_flashdata('msg',
					'<div class="alert bg-red alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Disimpan !
					</div>');
					redirect('penjualan/setoranpenjualan');
				}
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
				</div>');
				redirect('penjualan/setoranpenjualan');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/setoranpenjualan');
		}
	}

	function updatesetoranpenjualan(){
		$uangkertas 	=  str_replace(".","",$this->input->post('uangkertas'));
		$uanglogam  	=  str_replace(".","",$this->input->post('uanglogam'));
		$lainnya    	=  str_replace(".","",$this->input->post('lainnya'));
		$keterangan 	=  $this->input->post('keterangan');
		$kode_setoran = $this->input->post('kode_setoran');
		$tgllhp 			= $this->input->post('tgllhpkb');
		$tanggal 			= explode("-",$tgllhp);
		$hari 				= $tanggal[2];
		$bulan 				= $tanggal[1];
		$tahun 				= $tanggal[0];
		$cabang 			= $this->input->post('cabkb');
		$data = array(
			'setoran_kertas'	=> $uangkertas,
			'setoran_logam' 	=> $uanglogam,
			'setoran_lainnya'	=> $lainnya,
			'keterangan'			=> $keterangan
		);
		if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		if(empty($ceksa)){
			$update = $this->db->update('setoran_penjualan',$data,array('kode_setoran'=>$kode_setoran));
			if($update){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Update !
				</div>');
				redirect('penjualan/setoranpenjualan');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Update !
				</div>');
				redirect('penjualan/setoranpenjualan');
			}
		}else{
			$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
				</div>');
			redirect('penjualan/setoranpenjualan');
		}
	}

	public function getrecordsetoranPenjualan($cabang = "", $salesman="",$dari="",$sampai="") {
		$this->db->select('count(*) as allcount');
		$this->db->from('setoran_penjualan');
		$this->db->join('karyawan','setoran_penjualan.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tgl_lhp','desc');
		if($cabang != ""){
			$this->db->where('setoran_penjualan.kode_cabang',$cabang);
		}
	  if($salesman != ''){
			$this->db->where('setoran_penjualan.id_karyawan', $salesman);
	  }
		if($dari !=  ''){
		  $this->db->where('tgl_lhp >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgl_lhp <=', $sampai);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function getdatasetoranPenjualan($rowno,$rowperpage,$cabang="",$salesman="",$dari="",$sampai="") {
		$this->db->select('*');
		$this->db->from('setoran_penjualan');
		$this->db->join('karyawan','setoran_penjualan.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tgl_lhp','desc');
		if($cabang != ""){
			$this->db->where('setoran_penjualan.kode_cabang',$cabang);
		}
		if($salesman != ''){
		  $this->db->where('setoran_penjualan.id_karyawan', $salesman);
		}
		if($dari !=  ''){
		  $this->db->where('tgl_lhp >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgl_lhp <=', $sampai);
		}
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
	}

	function get_setoranpenjualan($kode_setoran){
		$this->db->join('karyawan','setoran_penjualan.id_karyawan = karyawan.id_karyawan');
		return $this->db->get_where('setoran_penjualan',array('kode_setoran'=>$kode_setoran));
	}
	function hapus_setoran($kode_setoran){
		$gettanggal = $this->db->get_where('setoran_penjualan',array('kode_setoran'=>$kode_setoran))->row_array();
		$tanggal = $gettanggal['tgl_lhp'];
		$tgl   = explode("-",$tanggal);
    $bulan = $tgl[1];
    $tahun = $tgl[0];
    if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$cabang = $gettanggal['kode_cabang'];
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
    if(empty($ceksa)){
			$hapus = $this->db->delete('setoran_penjualan',array('kode_setoran'=>$kode_setoran));
			if($hapus){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
				</div>');
				redirect('penjualan/setoranpenjualan');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal di Hapus !
				</div>');
				redirect('penjualan/setoranpenjualan');
			}
		}else{
			$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
				</div>');
			redirect('penjualan/setoranpenjualan');
		}
	}

	function inputlogamtokertas(){
		$tgl_logamtokertas 		= $this->input->post('tanggal');
		$cabang 		   				= $this->input->post('cabangkb');
		$jumlah_logamtokertas	= str_replace(".","",$this->input->post('jumlah'));
		$tanggal 							= explode("-",$tgl_logamtokertas);
		$hari 								= $tanggal[2];
		$bulan 								= $tanggal[1];
		$tahun 								= $tanggal[0];
		$thn 									= substr($tahun,2,2);
		$tgl 									= $hari.$bulan.$thn;
		$tahunini 						= date("y");
		$qlgtokertas 					= "SELECT kode_logamtokertas FROM logamtokertas
					   			   				 WHERE LEFT(kode_logamtokertas,4) = 'LG$tahunini'  ORDER BY kode_logamtokertas DESC LIMIT 1";
		$lgtokertas 					= $this->db->query($qlgtokertas)->row_array();
		$nomor_terakhir 			= $lgtokertas['kode_logamtokertas'];
		$kode_logamtokertas   = buatkode($nomor_terakhir,"LG".$tahunini,4);
		$data = array(
			'kode_logamtokertas' 		=> $kode_logamtokertas,
			'tgl_logamtokertas'	 		=> $tgl_logamtokertas,
			'kode_cabang'		 				=> $cabang,
			'jumlah_logamtokertas'	=> $jumlah_logamtokertas
		);

    if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		if(empty($ceksa)){
			$insert = $this->db->insert('logamtokertas',$data);
			if($insert){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
				</div>');
				redirect('penjualan/logamtokertas');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Disimpan !
				</div>');
				redirect('penjualan/logamtokertas');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/logamtokertas');
		}
	}

	public function getrecordlogamtokertas($cabang = "",$dari="",$sampai="") {
		$this->db->select('count(*) as allcount');
		$this->db->from('logamtokertas');
		$this->db->order_by('tgl_logamtokertas','desc');
		if($cabang != ""){
			$this->db->where('logamtokertas.kode_cabang',$cabang);
		}
		if($dari !=  ''){
		  $this->db->where('tgl_logamtokertas >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgl_logamtokertas <=', $sampai);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function getdatalogamtokertas($rowno,$rowperpage,$cabang="",$dari="",$sampai="") {
		$this->db->select('*');
		$this->db->from('logamtokertas');
		$this->db->order_by('tgl_logamtokertas','desc');
		if($cabang != ""){
			$this->db->where('logamtokertas.kode_cabang',$cabang);
		}
		if($dari !=  ''){
		  $this->db->where('tgl_logamtokertas >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgl_logamtokertas <=', $sampai);
		}
	  $this->db->limit($rowperpage, $rowno);
	  $query = $this->db->get();
	  return $query->result_array();
	}


	function hapus_logamtokertas($kode_logamtokertas,$cabang){
		$gettanggal = $this->db->get_where('logamtokertas',array('kode_logamtokertas'=>$kode_logamtokertas))->row_array();
		$tanggal = $gettanggal['tgl_logamtokertas'];
		$tgl   = explode("-",$tanggal);
    $bulan = $tgl[1];
    $tahun = $tgl[0];
    if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
    if(empty($ceksa)){
			$hapus = $this->db->delete('logamtokertas',array('kode_logamtokertas'=>$kode_logamtokertas));
			if($hapus){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
				</div>');
				redirect('penjualan/logamtokertas');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal di Hapus !
				</div>');
				redirect('penjualan/logamtokertas');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/logamtokertas');
		}
	}

	function get_logamtokertas($kodelogamtokertas){
		return $this->db->get_where('logamtokertas',array('kode_logamtokertas'=>$kodelogamtokertas));
	}

	function updatelogamtokertas(){
		$cabang 		   				= $this->input->post('cabangkb');
		$jumlah_logamtokertas = str_replace(".","",$this->input->post('jumlah'));
		$tanggal 							= $this->input->post('tanggal');
		$kode_logamtokertas   = $this->input->post('kode_logamtokertas');
		$tgl   = explode("-",$tanggal);
    $bulan = $tgl[1];
    $tahun = $tgl[0];
    if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$data = array(
			'tgl_logamtokertas'			=> $tanggal,
			'jumlah_logamtokertas'	=> $jumlah_logamtokertas
		);
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
    if(empty($ceksa)){
			$update = $this->db->update('logamtokertas',$data,array('kode_logamtokertas'=>$kode_logamtokertas));
			if($update){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Update !
				</div>');
				redirect('penjualan/logamtokertas');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Update !
				</div>');
				redirect('penjualan/logamtokertas');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/logamtokertas');
		}
	}

	function inputkuranglebihsetor(){
		$tglbayarkl 			= $this->input->post('tglbayarkl');
		$cabang 		   		= $this->input->post('cabangkb');
		$salesman 				= $this->input->post('salesmankb');
		$uang_kertas			= str_replace(".","",$this->input->post('uangkertas'));
		$uang_logam				= str_replace(".","",$this->input->post('uanglogam'));
		$pembayaran 			= $this->input->post('pembayaran');
		$keterangan 			= $this->input->post('keterangan');
		$tanggal 					= explode("-",$tglbayarkl);
		$hari 						= $tanggal[2];
		$bulan 						= $tanggal[1];
		$tahun 						= $tanggal[0];
		$thn 							= substr($tahun,2,2);
		$tgl 							= $hari.$bulan.$thn;
		$tahunini					= date("y");
		$qkl 							= "SELECT kode_kl FROM kuranglebihsetor
					   			   		 WHERE LEFT(kode_kl,4) = 'KL$tahunini'  ORDER BY kode_kl DESC LIMIT 1";
		$kl 							= $this->db->query($qkl)->row_array();
		$nomor_terakhir 	= $kl['kode_kl'];
		$kode_kl     			= buatkode($nomor_terakhir,"KL".$tahunini,5);
		$data = array(
			'kode_kl' 		=> $kode_kl,
			'tgl_kl'	 		=> $tglbayarkl,
			'kode_cabang'	=> $cabang,
			'id_karyawan'	=> $salesman,
			'pembayaran'	=> $pembayaran,
			'uang_kertas'	=> $uang_kertas,
			'uang_logam'	=> $uang_logam,
			'keterangan'	=> $keterangan
		);

		if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		if(empty($ceksa)){
			$insert = $this->db->insert('kuranglebihsetor',$data);
			if($insert){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
					</div>');
				redirect('penjualan/kuranglebihsetor');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Disimpan !
				</div>');
				redirect('penjualan/kuranglebihsetor');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/kuranglebihsetor');
		}
	}

	public function getrecordkuranglebihsetor($cabang = "", $salesman="",$dari="",$sampai="") {
		$this->db->select('count(*) as allcount');
		$this->db->from('kuranglebihsetor');
		$this->db->join('karyawan','kuranglebihsetor.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tgl_kl','desc');
		if($cabang != ""){
			$this->db->where('kuranglebihsetor.kode_cabang',$cabang);
		}
		if($salesman != ''){
			$this->db->where('kuranglebihsetor.id_karyawan', $salesman);
		}
		if($dari !=  ''){
		  $this->db->where('tgl_kl >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgl_kl <=', $sampai);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function getdatakuranglebihsetor($rowno,$rowperpage,$cabang="",$salesman="",$dari="",$sampai="") {
	  $this->db->select('kode_kl,tgl_kl,kuranglebihsetor.kode_cabang,kuranglebihsetor.id_karyawan,nama_karyawan,uang_kertas,uang_logam,(uang_kertas+uang_logam) as jumlah_kl,pembayaran,keterangan');
		$this->db->from('kuranglebihsetor');
		$this->db->join('karyawan','kuranglebihsetor.id_karyawan = karyawan.id_karyawan');
		$this->db->order_by('tgl_kl','desc');
		if($cabang != ""){
			$this->db->where('kuranglebihsetor.kode_cabang',$cabang);
		}
		if($salesman != ''){
		  $this->db->where('kuranglebihsetor.id_karyawan', $salesman);
		}
		if($dari !=  ''){
		  $this->db->where('tgl_kl >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgl_kl <=', $sampai);
		}
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
	}

	function hapus_kuranglebihsetor($kode_kl){
		$hapus = $this->db->delete('kuranglebihsetor',array('kode_kl'=>$kode_kl));
		if($hapus){
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
			 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			 	<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
			</div>');
			redirect('penjualan/kuranglebihsetor');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal di Hapus !
			</div>');
			redirect('penjualan/kuranglebihsetor');
		}
	}
	function get_kuranglebihsetor($kodekl){
		$this->db->join('karyawan','kuranglebihsetor.id_karyawan = karyawan.id_karyawan');
		return $this->db->get_where('kuranglebihsetor',array('kode_kl'=>$kodekl));
	}

	function updatekuranglebihsetor(){
		$kodekl 				 	= $this->input->post('kode_kl');
		$tglbayarkl 			= $this->input->post('tglbayarkl');
		$cabang 		   		= $this->input->post('cabangkb');
		$salesman 				= $this->input->post('salesmankb');
		$uang_kertas			= str_replace(".","",$this->input->post('uangkertas'));
		$uang_logam				= str_replace(".","",$this->input->post('uanglogam'));
		$pembayaran 			= $this->input->post('pembayaran');
		$keterangan 			= $this->input->post('keterangan');
		$data 						= array(
													'tgl_kl'				=> $tglbayarkl,
													'pembayaran'		=> $pembayaran,
													'uang_kertas'		=> $uang_kertas,
													'uang_logam'		=> $uang_logam,
													'keterangan'		=> $keterangan
												);

		$update 					= $this->db->update('kuranglebihsetor',$data,array('kode_kl'=>$kodekl));
		if($update){
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Update !
			</div>');
			redirect('penjualan/kuranglebihsetor');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Update !
			</div>');
			redirect('penjualan/kuranglebihsetor');
		}
	}
	function rekapkuranglebihsetor($cabang=""){
		$cb = $this->session->userdata('cabang');
		if($cb != "pusat"){
			$cabang = "AND setoran_penjualan.kode_cabang = '".$cb."' ";
		}
		$query = "SELECT
							setoran_penjualan.id_karyawan,
							nama_karyawan,
							setoran_penjualan.kode_cabang,
							SUM( ( setoran_kertas + setoran_logam + setoran_lainnya + setoran_bg ))  AS total_setoran1,
							SUM(lhp_tunai+lhp_tagihan) as totallhp,
							SUM( ( setoran_kertas + setoran_logam + setoran_lainnya + setoran_bg )-(lhp_tunai+lhp_tagihan)) AS total_setoran,
							bayarkurangsetor,
							bayarlebihsetor
						FROM
							setoran_penjualan
							INNER JOIN karyawan ON setoran_penjualan.id_karyawan = karyawan.id_karyawan
							LEFT JOIN (
						SELECT
							id_karyawan,
							SUM(IF(pembayaran = '1',uang_kertas+uang_logam,0 )) AS bayarkurangsetor,
							SUM(IF(pembayaran = '2',uang_kertas+uang_logam,0 )) AS bayarlebihsetor
						FROM
							kuranglebihsetor
						GROUP BY
							id_karyawan
							) kuranglebihsetor ON ( setoran_penjualan.id_karyawan = kuranglebihsetor.id_karyawan )
					WHERE setoran_penjualan.id_karyawan !=''"
					.$cabang
					."
					GROUP BY setoran_penjualan.id_karyawan,nama_karyawan,setoran_penjualan.kode_cabang,bayarkurangsetor,bayarlebihsetor
					ORDER BY setoran_penjualan.kode_cabang ASC
				  ";
		return $this->db->query($query);
	}

	function inputsetoranpusat(){
		$tgl_setoran 				= $this->input->post('tgl_setoran');
		$cabang 						= $this->input->post('cabangkb');
		$via 								= $this->input->post('via');
		$uangkertas 				=  str_replace(".","",$this->input->post('uangkertas'));
		$uanglogam  				=  str_replace(".","",$this->input->post('uanglogam'));
		$keterangan 				=  $this->input->post('keterangan');
		$tanggal 						= explode("-",$tgl_setoran);
		$hari 							= $tanggal[2];
		$bulan 							= $tanggal[1];
		$tahun 							= $tanggal[0];
		$thn 								= substr($tahun,2,2);
		$tgl 								= $hari.$bulan.$thn;
		$tahunini   				= date("y");
		$qsb 								= "SELECT kode_setoranpusat FROM setoran_pusat
											 		 WHERE LEFT(kode_setoranpusat,4) = 'SB$tahunini' ORDER BY kode_setoranpusat DESC LIMIT 1";
		$sb									= $this->db->query($qsb)->row_array();
		$nomor_terakhir 		= $sb['kode_setoranpusat'];
		$kode_setoranpusat 	= buatkode($nomor_terakhir,'SB'.$tahunini,5);
		$data = array(
			'kode_setoranpusat' => $kode_setoranpusat,
			'tgl_setoranpusat'	=> $tgl_setoran,
			'kode_cabang'				=> $cabang,
			'bank'							=> $via,
			'uang_kertas'				=> $uangkertas,
			'uang_logam'				=> $uanglogam,
			'keterangan'				=> $keterangan,
			'status'						=> '0'

		);
		if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		if(empty($ceksa)){
			$insert= $this->db->insert('setoran_pusat',$data);
			if($insert){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
				</div>');
				redirect('penjualan/setoranpusat');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Disimpan !
				</div>');
				redirect('penjualan/setoranpusat');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/setoranpusat');
		}

	}
	function updatesetoranpusat(){
		$tgl_setoran 				= $this->input->post('tgl_setoran');
		$cabang 						= $this->input->post('cabangkb');
		$via 								= $this->input->post('via');
		$uangkertas 				=  str_replace(".","",$this->input->post('uangkertas'));
		$uanglogam  				=  str_replace(".","",$this->input->post('uanglogam'));
		$keterangan 				= $this->input->post('keterangan');
		$kode_setoranpusat 	= $this->input->post('kode_setoranpusat');
		$tanggal 						= explode("-",$tgl_setoran);
		$hari 							= $tanggal[2];
		$bulan 							= $tanggal[1];
		$tahun 							= $tanggal[0];
		$data = array(
			'tgl_setoranpusat'	=> $tgl_setoran,
			'kode_cabang'				=> $cabang,
			'bank'							=> $via,
			'uang_kertas'				=> $uangkertas,
			'uang_logam'				=> $uanglogam,
			'keterangan'				=> $keterangan
		);
		if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
		echo $tgl_setoran;
		//die;
	
		if(empty($ceksa)){
			$update = $this->db->update('setoran_pusat',$data,array('kode_setoranpusat'=>$kode_setoranpusat));
			if($update){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Update !
				</div>');
				redirect('penjualan/setoranpusat');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Update !
				</div>');
				redirect('penjualan/setoranpusat');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/setoranpusat');
		}
	}
	public function getrecordsetoranpusat($cabang = "", $bank="",$dari="",$sampai="") {
		$this->db->select('count(*) as allcount');
		$this->db->from('setoran_pusat');
		$this->db->order_by('kode_setoranpusat,tgl_setoranpusat','desc');
		if($cabang != ""){
			$this->db->where('setoran_pusat.kode_cabang',$cabang);
		}
		if($bank != ''){
			$this->db->where('bank', $bank);
		}
		if($dari !=  ''){
			$this->db->where('tgl_setoranpusat >=', $dari);
		}
		if($sampai !=  ''){
			$this->db->where('tgl_setoranpusat <=', $sampai);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function getdatasetoranpusat($rowno,$rowperpage,$cabang="",$bank="",$dari="",$sampai="") {
		$this->db->select('*');
		$this->db->from('setoran_pusat');
		$this->db->order_by('tgl_setoranpusat','desc');
		if($cabang != ""){
			$this->db->where('setoran_pusat.kode_cabang',$cabang);
		}
		if($bank != ''){
			$this->db->where('bank', $bank);
		}
		if($dari !=  ''){
			$this->db->where('tgl_setoranpusat >=', $dari);
		}
		if($sampai !=  ''){
			$this->db->where('tgl_setoranpusat <=', $sampai);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_setoranpusat($kode_setoranpusat){
		return $this->db->get_where('setoran_pusat',array('kode_setoranpusat'=>$kode_setoranpusat));
	}

	function hapus_setoranpusat($kode_setoranpusat){
		$gettanggal = $this->db->get_where('setoran_pusat',array('kode_setoranpusat'=>$kode_setoranpusat))->row_array();
		$tanggal = $gettanggal['tgl_setoranpusat'];
		$tgl   = explode("-",$tanggal);
    $bulan = $tgl[1];
    $tahun = $tgl[0];
    if($bulan ==12){
      $bulan = 1;
      $tahun = $tahun +1;
    }else{
      $bulan = $bulan + 1;
      $tahun = $tahun;
    }
		$cabang = $gettanggal['kode_cabang'];
		$ceksa = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
    if(empty($ceksa)){
		$hapus = $this->db->delete('setoran_pusat',array('kode_setoranpusat'=>$kode_setoranpusat));
			if($hapus){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
				</div>');
				redirect('penjualan/setoranpusat');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal di Hapus !
				</div>');
				redirect('penjualan/setoranpusat');
			}
		}else{
			$this->session->set_flashdata('msg',
        '<div class="alert bg-red alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Periode Bulan Ini Sudah di Tutup !
        </div>');
      redirect('penjualan/setoranpusat');
		}
	}

	function terimasetoran($kode_setoran){
		$tanggalditerima = $this->input->post('tgl_terimapusat');
		$bank_penerima = $this->input->post('bank_penerima');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$data = array(
			'status' => 1,
			'tgl_diterimapusat' => $tanggalditerima,
			'bank' => $bank_penerima,
			'omset_bulan' => $bulan,
			'omset_tahun' => $tahun

		);



		$getsetoran 	= $this->db->get_where('setoran_pusat',array('kode_setoranpusat'=>$kode_setoran))->row_array();
		$cabang 			= $getsetoran['kode_cabang'];
		$tglsetoran 	= $getsetoran['tgl_setoranpusat'];
		$bankpenerima = $getsetoran['bank'];
		$jmlbayar 		= $getsetoran['uang_kertas'] + $getsetoran['uang_logam'];

		//Nobukti Ledger
		$tanggal        = explode("-",$tglsetoran);
		$tahun          = substr($tanggal[0],2,2);
		$qledger        = "SELECT no_bukti FROM ledger_bank WHERE LEFT(no_bukti,7) ='LR$cabang$tahun'ORDER BY no_bukti DESC LIMIT 1 ";
		$ceknolast      = $this->db->query($qledger)->row_array();
		$nobuktilast    = $ceknolast['no_bukti'];
		$no_bukti       = buatkode($nobuktilast,'LR'.$cabang.$tahun,4);

		if($cabang=='TSM')
		{
			$akun = "1-1468";
		}else if($cabang=='BDG')
		{
			$akun = "1-1402";
		}else if($cabang=='BGR')
		{
			$akun = "1-1403";
		}else if($cabang=='PWT')
		{
			$akun = "1-1404";
		}else if($cabang=='TGL')
		{
			$akun = "1-1405";
		}else if($cabang=="SKB")
		{
			$akun = "1-1407";
		}else if($cabang=="GRT")
		{
			$akun = "1-1408";
		}
		$update  		= $this->db->update('setoran_pusat',$data,array('kode_setoranpusat'=>$kode_setoran));
		if($update){
			$dataledger = array(
				'no_bukti'        			=> $no_bukti,
				'no_ref' 	  						=> $kode_setoran,
				'bank'            			=> $bankpenerima,
				'tgl_ledger'      			=> $tanggalditerima,
				'keterangan'      			=> "SETORAN CAB ".$cabang,
				'kode_akun'       			=> $akun,
				'jumlah'          			=> $jmlbayar,
				'status_dk'       			=> 'K',
				'status_validasi' 			=> 1,
				'kategori'							=> 'PNJ'
			);
			$insertledger = $this->db->insert('ledger_bank',$dataledger);
			if($insertledger)
			{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Setoran Diterima !
				</div>');
				redirect('penjualan/ceksetoranpusat');
			}

		}
	}

	function batalterimasetoran($kode_setoran){
		$data = array(
			'status' => 0,
			'tgl_diterimapusat' => NULL
		);
		$update = $this->db->update('setoran_pusat',$data,array('kode_setoranpusat'=>$kode_setoran));
		if($update){
			$deleteledger = $this->db->delete('ledger_bank',array('no_ref'=>$kode_setoran));
			if($deleteledger){
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="material-icons" style="float:left; margin-right:10px">check</i> Setoran Diterima !
				</div>');
				redirect('penjualan/ceksetoranpusat');
			}

	 	}
 	}

  function insert_detailrejectgudangtmp(){
    $kode_produk  = $this->input->post('kode_produk');
    $jmldus       = $this->input->post('jmldus');
    $jmlpack      = $this->input->post('jmlpack');
    $jmlpcs       = $this->input->post('jmlpcs');
    $hargadus     = $this->input->post('hargadus');
    $hargapack    = $this->input->post('hargapack');
    $hargapcs     = $this->input->post('hargapcs');
    $cabang       = $this->input->post('cabang');
    $isipcsdus    = $this->input->post('isipcsdus');
    $isipcspack   = $this->input->post('isipcspack');
    $id_admin     = $this->session->userdata('id_user');
    $jumlah       = ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
    $brgtmp       = $this->db->get_where('detailrejectgudang_temp',array('kode_produk'=>$kode_produk,'id_admin'=>$id_admin,'kode_cabang'=>$cabang));
    $cektmp       = $brgtmp->num_rows();
    if($cektmp != 0){
    	echo "1";
    }else{
      $data   = array (
                  'kode_produk' => $kode_produk,
                  'jumlah'      => $jumlah,
                  'harga_dus'   => $hargadus,
                  'harga_pack'  => $hargapack,
                  'harga_pcs'   => $hargapcs,
                  'id_admin'    => $id_admin,
                  'kode_cabang' => $cabang
                );
      $this->db->insert('detailrejectgudang_temp',$data);
    }
	}
	function insert_detailpelunasanhktemp(){
		$nofaktur     = $this->input->post('nofaktur');
		$noretur      = $this->input->post('noretur');
    $kode_produk  = $this->input->post('kode_produk');
    $jmldus       = $this->input->post('jmldus');
    $jmlpack      = $this->input->post('jmlpack');
    $jmlpcs       = $this->input->post('jmlpcs');
    $hargadus     = $this->input->post('hargadus');
    $hargapack    = $this->input->post('hargapack');
    $hargapcs     = $this->input->post('hargapcs');
    $isipcsdus    = $this->input->post('isipcsdus');
    $isipcspack   = $this->input->post('isipcspack');
    $id_admin     = $this->session->userdata('id_user');
    $jumlah       = ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs;
    $brgtmp       = $this->db->get_where('detailplhutangkirim_temp',array('kode_produk'=>$kode_produk,'id_admin'=>$id_admin,'no_fak_penj'=>$nofaktur));
    $cektmp       = $brgtmp->num_rows();
    if($cektmp != 0){
      echo "1";
    }else{
      $data   = array (
		  						'kode_produk' 	=> $kode_produk,
		  						'no_fak_penj'		=> $nofaktur,
									'no_retur_penj'	=> $noretur,
                  'jumlah'      	=> $jumlah,
                  'harga_dus'  	 	=> $hargadus,
                  'harga_pack'  	=> $hargapack,
                  'harga_pcs'   	=> $hargapcs,
                  'id_admin'   		=> $id_admin
              	);
      $this->db->insert('detailplhutangkirim_temp',$data);
    }
	}


	function view_detailpelunasanhktemp(){
    $nofaktur  = $this->uri->segment(3);
    $id_admin  = $this->session->userdata('id_user');
    $this->db->select('detailplhutangkirim_temp.kode_produk,nama_barang,isipcsdus,detailplhutangkirim_temp.harga_dus,isipack,detailplhutangkirim_temp.harga_pack,isipcs,jumlah,detailplhutangkirim_temp.harga_pcs,no_fak_penj');
    $this->db->from('detailplhutangkirim_temp');
    $this->db->join('master_barang','detailplhutangkirim_temp.kode_produk = master_barang.kode_produk');
		$this->db->where('id_admin',$id_admin);
		$this->db->where('no_fak_penj',$nofaktur);
    return $this->db->get();
  }


	function hapus_detailpelunasanhktemp($kode_produk,$nofaktur){
		//$query    = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
		$id_admin   = $this->session->userdata('id_user');
		//$this->db->query($query);
		$this->db->delete('detailplhutangkirim_temp',array('kode_produk'=>$kode_produk,'id_admin'=>$id_admin,'no_fak_penj'=>$nofaktur));
	}

	function detail_pl($nofaktur){
		$jenis_mutasi 	= "HUTANG KIRIM";
		$inout_good 	= "OUT";
		$this->db->where('mutasi_gudang_cabang.no_fak_penj',$nofaktur);
		$this->db->where('jenis_mutasi',$jenis_mutasi);
		$this->db->where('inout_good',$inout_good);
		return $this->db->get('mutasi_gudang_cabang');
	}

	function detail_historihk($nomutasi){
		$this->db->join('master_barang','detail_mutasi_gudang_cabang.kode_produk = master_barang.kode_produk');
		return $this->db->get_where('detail_mutasi_gudang_cabang',array('no_mutasi_gudang_cabang'=>$nomutasi));
	}

	public function getDataPenjualan($rowno,$rowperpage,$nofaktur="",$cabang="",$salesman="",$dari="",$sampai="") {
  	$this->db->select('*');
    $this->db->from('penjualan');
   	$this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
   	$this->db->join('karyawan','penjualan.id_karyawan = karyawan.id_karyawan');
    $this->db->order_by('tgltransaksi,no_fak_penj','ASC');
		if($cabang != ""){
      $this->db->where('pelanggan.kode_cabang',$cabang);
    }
		if($dari != ""){
    	$this->db->where('tgltransaksi >=',$dari);
    }
		if($sampai != ""){
      $this->db->where('tgltransaksi <=',$sampai);
    }
		if($nofaktur != ''){
			$this->db->where('no_fak_penj', $nofaktur);
		}
		if($salesman != ''){
			$this->db->where('penjualan.id_karyawan', $salesman);
		}
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

    // Select total records
  public function getrecordPenjualanCount($nofaktur="",$cabang="",$salesman="",$dari="",$sampai="") {
		 $this->db->select('count(*) as allcount');
		 $this->db->from('penjualan');
		 $this->db->join('pelanggan','penjualan.kode_pelanggan = pelanggan.kode_pelanggan');
		 $this->db->join('karyawan','penjualan.id_karyawan = karyawan.id_karyawan');
 		if($cabang != ""){
      $this->db->where('pelanggan.kode_cabang',$cabang);
  	}
		if($nofaktur != ''){
			$this->db->where('no_fak_penj', $nofaktur);
		}
		if($dari != ""){
      $this->db->where('tgltransaksi >=',$dari);
    }
		if($sampai != ""){
      $this->db->where('tgltransaksi <=',$sampai);
    }
		if($salesman != ''){
			$this->db->where('penjualan.id_karyawan', $salesman);
		}
		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
  }

	function inputkoreksipenjualan(){
		$no_faktur 	= $this->input->post('no_faktur');
		$koreksi_cf = $this->input->post('koreksi_cf');
		$koreksi    = $this->input->post('inputkoreksi_val');
		if($koreksi_cf == '1'){
			$data = array('status'=>'1');
			$this->db->update('penjualan',$data,array('no_fak_penj'=>$no_faktur));
			$this->session->set_flashdata('msg',
    	'<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Di Koreksi !
      </div>');
      redirect('penjualan/koreksipenjualan');
		}
	}

	function cekplhk(){
		$nofaktur  		= $this->input->post('nofaktur');
		$kodeproduk		= $this->input->post('kodeproduk');
		$query 		 		= "SELECT detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang,detail_mutasi_gudang_cabang.no_fak_penj,kode_produk,jumlah
									 	 FROM detail_mutasi_gudang_cabang
									 	 INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
									 	 WHERE jenis_mutasi='HUTANG KIRIM' AND inout_good='OUT' AND detail_mutasi_gudang_cabang.no_fak_penj='$nofaktur' AND kode_produk ='$kodeproduk'";
	 	return $this->db->query($query);
	}

	function cekjmlhk(){
		$nofaktur  		= $this->input->post('nofaktur');
		$kodeproduk		= $this->input->post('kodeproduk');
		$query 		 		= "SELECT detail_mutasi_gudang_cabang.no_fak_penj,kode_produk,SUM(jumlah) as jumlah
									 	 FROM detail_mutasi_gudang_cabang
									 	 INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
									 	 WHERE jenis_mutasi='HUTANG KIRIM' AND inout_good='IN' AND detail_mutasi_gudang_cabang.no_fak_penj='$nofaktur' AND kode_produk ='$kodeproduk'
										 GROUP BY detail_mutasi_gudang_cabang.no_fak_penj,kode_produk ";
	 	return $this->db->query($query);
	}

	public function getDataSaldoawal($rowno,$rowperpage,$tanggal="",$cabang="",$bulan="",$tahun="")
  {
    $this->db->select('kode_saldoawalkb,tanggal,bulan,tahun,uang_logam,uang_kertas,giro,transfer,kode_cabang');
    $this->db->from('saldoawal_kasbesar');
    $this->db->order_by('tanggal','desc');
    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }
    if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }

    if($bulan != ''){
      $this->db->where('bulan', $bulan);
    }

    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

    // Select total records
  public function getrecordSaldoawalCount($tanggal="",$cabang="",$bulan="",$tahun="")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_kasbesar');
    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }
		if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }
    if($bulan != ''){
      $this->db->where('bulan', $bulan);
    }
    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
  }

	function insertsaldoawalkb()
	{
		$kodesaldo  = $this->input->post('kode_saldoawal');
		$tanggal 		= $this->input->post('tanggal');
		$cabang 		= $this->input->post('cabang');
		$bulan 			= $this->input->post('bulan');
		$tahun 			= $this->input->post('tahun');
		$uk 				= str_replace(".","",$this->input->post('uangkertas'));
		$ul 				= str_replace(".","",$this->input->post('uanglogam'));
		$giro 			= str_replace(".","",$this->input->post('giro'));
		$trf 				= str_replace(".","",$this->input->post('transfer'));
		$id_admin   = $this->session->userdata('id_user');
		$data = array(
			'kode_saldoawalkb' => $kodesaldo,
			'tanggal'					 => $tanggal,
			'bulan'						 => $bulan,
			'tahun'						 => $tahun,
			'uang_kertas'			 => $uk,
			'uang_logam'			 => $ul,
			'giro'						 => $giro,
			'transfer'				 => $trf,
			'kode_cabang'			 => $cabang,
			'id_admin'				 => $id_admin
		);
		$cek            = $this->db->get_where('saldoawal_kasbesar',array('kode_saldoawalkb'=>$kode_saldoawal))->num_rows();
    $cekbulan       = $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->num_rows();
    if(empty($cek) && empty($cekbulan))
    {
      $simpansaldo   = $this->db->insert('saldoawal_kasbesar',$data);
      if($simpansaldo)
      {
        $this->session->set_flashdata('msg',
        '<div class="alert bg-green alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
        </div>');
      	redirect('penjualan/saldoawalkb');
      }

    }else{
      $this->session->set_flashdata('msg',
      '<div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="material-icons" style="float:left; margin-right:10px">check</i> Data Sudah Ada !
      </div>');
			redirect('penjualan/saldoawalkb');
    }
	}

	function ceksaldo($bulan,$tahun,$cabang)
  {
    if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
    return $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang));
  }

  function ceksaldoSkrg($bulan,$tahun,$cabang)
  {
    return $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang));
  }

	function ceksaldoall($cabang)
  {
    return $this->db->get_where('saldoawal_kasbesar',array('kode_cabang'=>$cabang));
  }

	function getdetailsaldo($bulan,$tahun,$cabang)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
		$saldo 	= $this->db->get_where('saldoawal_kasbesar',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang));
		return $saldo;
	}

	function getsetoranpenjualan($bulan,$tahun,$cabang)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

		$querysetpenj = "SELECT SUM(setoran_kertas) as uangkertas,
		SUM(setoran_logam) as uanglogam,SUM(setoran_bg) as giro,SUM(setoran_transfer) as transfer,SUM(girotocash) as girotocash
		FROM setoran_penjualan
		WHERE kode_cabang='$cabang' AND MONTH(tgl_lhp)='$bulan' AND YEAR(tgl_lhp)='$tahun'";
		$setpenj = $this->db->query($querysetpenj);
		return $setpenj;
	}

	function getsetoranpusat($bulan,$tahun,$cabang)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

		$querysetpusat = "SELECT SUM(uang_kertas) as uangkertas,
		SUM(uang_logam) as uanglogam,SUM(giro) as giro,SUM(transfer) as transfer
		FROM setoran_pusat
		WHERE kode_cabang='$cabang' AND MONTH(tgl_setoranpusat)='$bulan' AND YEAR(tgl_setoranpusat)='$tahun' AND status='1'" ;
		$setpusat = $this->db->query($querysetpusat);
		return $setpusat;
	}

	function getKLSetorpenjualan($bulan,$tahun,$cabang,$pembayaran)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
		$query = "SELECT SUM(uang_kertas) as uangkertas,SUM(uang_logam) as uanglogam
		FROM kuranglebihsetor WHERE kode_cabang='$cabang' AND MONTH(tgl_kl)='$bulan' AND YEAR(tgl_kl)='$tahun'
		AND pembayaran='$pembayaran'";
		return $this->db->query($query);
	}

	function getGantiLogam($bulan,$tahun,$cabang)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
		$query = "SELECT SUM(jumlah_logamtokertas) as gantikertas FROM logamtokertas
		WHERE kode_cabang='$cabang' AND MONTH(tgl_logamtokertas) ='$bulan' AND YEAR(tgl_logamtokertas)='$tahun'";
		return $this->db->query($query);
	}

	function hapussaldoawalkb($kodesaldoawal){
		$hapus = $this->db->delete('saldoawal_kasbesar',array('kode_saldoawalkb'=>$kodesaldoawal));
		if($hapus){
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
			</div>');
			redirect('penjualan/saldoawalkb');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal di Hapus !
			</div>');
			redirect('penjualan/saldoawalkb');
		}
	}

	function cekpiutangpelanggan($pelanggan)
	{

		$query = " SELECT
		penjualan.kode_pelanggan,
		SUM(IFNULL( retur.total, 0 )) AS totalretur,
		SUM(( ( IFNULL( penjualan.total, 0 ) ) - ( IFNULL( retur.total, 0 ) ) )) AS totalpiutang,
		SUM((SELECT IFNULL(SUM(bayar),0) as jmlbayar
												FROM historibayar
												INNER JOIN penjualan pj
												ON historibayar.no_fak_penj = pj.no_fak_penj
												INNER JOIN pelanggan
												ON pj.kode_pelanggan = pelanggan.kode_pelanggan
												WHERE pj.no_fak_penj = penjualan.no_fak_penj )) as jmlbayar
		FROM
			penjualan
			LEFT JOIN ( SELECT retur.no_fak_penj AS no_fak_penj, SUM( total ) AS total FROM retur GROUP BY retur.no_fak_penj ) retur ON ( penjualan.no_fak_penj = retur.no_fak_penj )
		WHERE
			penjualan.kode_pelanggan = '$pelanggan'
		GROUP BY
			penjualan.kode_pelanggan";
		return $this->db->query($query);
	}

	public function getDataLimitKredit($rowno,$rowperpage,$cbg="",$dari="",$sampai="",$salesman="",$pelanggan="",$approval="",$status="") {
		$cabang = $this->session->userdata('cabang');
		$level 	= $this->session->userdata('level_user');
		$id_admin = $this->session->userdata('id_user');
		if($cabang !="pusat"){
			$this->db->where('pelanggan.kode_cabang',$cabang);
		}else{
			if($cbg !="")
			{
				$this->db->where('pelanggan.kode_cabang',$cbg);
			}
		}

		if($level=='kepala cabang')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('kacab',$status);
			}else if($status=="-"){
				$this->db->where('kacab is null');
				//$this->db->where('kacab !=','2');
			}
			$this->db->where('jumlah >','0');
		}else if($level=='manager marketing')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('mm',$status);
			}else if($status=="-"){
				$this->db->where('mm is null');
				//$this->db->where('gm !=','2');
			}
			$this->db->where('jumlah >','10000000');
			//$this->db->where('jumlah <=','20000000');
		}else if($level=='general manager')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('gm',$status);
			}else if($status=="-"){
				$this->db->where('gm is null');
				//$this->db->where('gm !=','2');
			}
			$this->db->where('jumlah >','20000000');
			//$this->db->where('jumlah <=','75000000');
		}else if($level=='Administrator')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('dirut',$status);
			}else if($status=="-"){
				$this->db->where('dirut is null');
				//$this->db->where('dirut !=','2');
			}
			$this->db->where('jumlah >','30000000');
		}

    if($dari !=  ''){
      $this->db->where('tgl_pengajuan >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_pengajuan <=', $sampai);
    }

    if($pelanggan !=  ''){
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if($salesman !=  ''){
      $this->db->where('pelanggan.id_sales', $salesman);
    }

		$this->db->or_where('id_approval',$id_admin);
		if($cabang !="pusat"){
			$this->db->where('pelanggan.kode_cabang',$cabang);
		}else{
			if($cbg !="")
			{
				$this->db->where('pelanggan.kode_cabang',$cbg);
			}
		}

		if($level=='kepala cabang')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('kacab',$status);
			}else if($status=="-"){
				$this->db->where('kacab is null');
				//$this->db->where('kacab !=','2');
			}
			$this->db->where('jumlah >','0');
		}else if($level=='manager marketing')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('mm',$status);
			}else if($status=="-"){
				$this->db->where('mm is null');
				//$this->db->where('gm !=','2');
			}
			$this->db->where('jumlah >','10000000');
			//$this->db->where('jumlah <=','20000000');
		}else if($level=='general manager')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('gm',$status);
			}else if($status=="-"){
				$this->db->where('gm is null');
				//$this->db->where('gm !=','2');
			}
			$this->db->where('jumlah >','20000000');
			//$this->db->where('jumlah <=','75000000');
		}else if($level=='Administrator')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('dirut',$status);
			}else if($status=="-"){
				$this->db->where('dirut is null');
				//$this->db->where('dirut !=','2');
			}
			$this->db->where('jumlah >','30000000');
		}

    if($dari !=  ''){
      $this->db->where('tgl_pengajuan >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_pengajuan <=', $sampai);
    }

    if($pelanggan !=  ''){
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if($salesman !=  ''){
      $this->db->where('pelanggan.id_sales', $salesman);
    }
		$this->db->select('*');
		$this->db->from('pengajuan_limitkredit');
		$this->db->join('pelanggan','pengajuan_limitkredit.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan','pelanggan.id_sales = karyawan.id_karyawan');
		$this->db->join('users','pengajuan_limitkredit.id_approval = users.id_user','left');
		$this->db->order_by('tgl_pengajuan','DESC');

		// $this->db->where('left(kontrabon.no_kontrabon,1) !=','T');


		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
}

	// Select total records
	public function getrecordLimitKreditCount($cbg="",$dari="",$sampai="",$salesman="",$pelanggan="",$approval="",$status="") {
		$level 	= $this->session->userdata('level_user');
		$cabang = $this->session->userdata('cabang');
		if($cabang !="pusat"){
			$this->db->where('pelanggan.kode_cabang',$cabang);
		}else{
			if($cbg !="")
			{
				$this->db->where('pelanggan.kode_cabang',$cbg);
			}
		}

		if($level=='kepala cabang')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('kacab',$status);
			}else if($status=="-"){
				$this->db->where('kacab is null');
				//$this->db->where('kacab !=','2');
			}
			$this->db->where('jumlah >','0');
		}else if($level=='manager marketing')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('mm',$status);
			}else if($status=="-"){
				$this->db->where('mm is null');
				//$this->db->where('gm !=','2');
			}
			$this->db->where('jumlah >','10000000');
			//$this->db->where('jumlah <=','20000000');
		}else if($level=='general manager')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('gm',$status);
			}else if($status=="-"){
				$this->db->where('gm is null');
				//$this->db->where('gm !=','2');
			}
			$this->db->where('jumlah >','20000000');
			//$this->db->where('jumlah <=','75000000');
		}else if($level=='Administrator')
		{
			if($status !="" AND $status !="-")
			{
				$this->db->where('dirut',$status);
			}else if($status=="-"){
				$this->db->where('dirut !=','1');
				// $this->db->where('dirut !=','2');
			}
			$this->db->where('jumlah >','30000000');
		}

    if($dari !=  ''){
      $this->db->where('tgl_pengajuan >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_pengajuan <=', $sampai);
    }

    if($pelanggan !=  ''){
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if($salesman !=  ''){
      $this->db->where('pelanggan.id_sales', $salesman);
    }


		$this->db->select('count(*) as allcount');
		$this->db->from('pengajuan_limitkredit');
		$this->db->join('pelanggan','pengajuan_limitkredit.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan','pelanggan.id_sales = karyawan.id_karyawan');
		$this->db->join('users','pengajuan_limitkredit.id_approval = users.id_user','left');
		$this->db->order_by('tgl_pengajuan','DESC');

		// $this->db->where('left(kontrabon.no_kontrabon,1) !=','T');

		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	public function getDataLimitKreditadmin($rowno,$rowperpage,$cbg="",$dari="",$sampai="",$salesman="",$pelanggan="",$approval="") {
		$cabang = $this->session->userdata('cabang');
		$level 	= $this->session->userdata('level_user');
		if($cabang !="pusat"){
			$this->db->where('pelanggan.kode_cabang',$cabang);
		}else{
			if($cbg !="")
			{
				$this->db->where('pelanggan.kode_cabang',$cbg);
			}
		}

		// if($level=='kepala cabang')
		// {
		// 	$this->db->where('jumlah <=','10000000');
		// }else if($level=='manager marketing')
		// {
		// 	$this->db->where('jumlah >','10000000');
		// 	$this->db->where('jumlah <=','20000000');
		// }else if($level=='manager marketing')
		// {
		// 	$this->db->where('jumlah >','10000000');
		// 	$this->db->where('jumlah <=','20000000');
		// }else if($level=='general manager')
		// {
		// 	$this->db->where('jumlah >','20000000');
		// 	$this->db->where('jumlah <=','75000000');
		// }else if($level=='direktur')
		// {
		// 	$this->db->where('jumlah >','75000000');
		// }

   if($dari !=  ''){
      $this->db->where('tgl_pengajuan >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_pengajuan <=', $sampai);
    }

    if($pelanggan !=  ''){
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if($salesman !=  ''){
      $this->db->where('pelanggan.id_sales', $salesman);
    }

		$this->db->select('*');
		$this->db->from('pengajuan_limitkredit');
		$this->db->join('pelanggan','pengajuan_limitkredit.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan','pelanggan.id_sales = karyawan.id_karyawan');
		$this->db->join('users','pengajuan_limitkredit.id_approval = users.id_user','left');
		$this->db->order_by('tgl_pengajuan','DESC');

		// $this->db->where('left(kontrabon.no_kontrabon,1) !=','T');


		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
}

	// Select total records
	public function getrecordLimitKreditadminCount($cbg="",$dari="",$sampai="",$salesman="",$pelanggan="",$approval="") {
		$level 	= $this->session->userdata('level_user');
		$cabang = $this->session->userdata('cabang');
		if($cabang !="pusat"){
			$this->db->where('pelanggan.kode_cabang',$cabang);
		}else{
			if($cbg !="")
			{
				$this->db->where('pelanggan.kode_cabang',$cbg);
			}
		}

		// if($level=='kepala cabang')
		// {
		// 	$this->db->where('jumlah <=','10000000');
		// }else if($level=='manager marketing')
		// {
		// 	$this->db->where('jumlah >','10000000');
		// 	$this->db->where('jumlah <=','20000000');
		// }else if($level=='manager marketing')
		// {
		// 	$this->db->where('jumlah >','10000000');
		// 	$this->db->where('jumlah <=','20000000');
		// }else if($level=='general manager')
		// {
		// 	$this->db->where('jumlah >','20000000');
		// 	$this->db->where('jumlah <=','75000000');
		// }else if($level=='administrator')
		// {
		// 	$this->db->where('jumlah >','75000000');
		// }
    if($dari !=  ''){
      $this->db->where('tgl_pengajuan >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_pengajuan <=', $sampai);
    }

    if($pelanggan !=  ''){
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if($salesman !=  ''){
      $this->db->where('pelanggan.id_sales', $salesman);
    }

		$this->db->select('count(*) as allcount');
		$this->db->from('pengajuan_limitkredit');
		$this->db->join('pelanggan','pengajuan_limitkredit.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan','pelanggan.id_sales = karyawan.id_karyawan');
		$this->db->join('users','pengajuan_limitkredit.id_approval = users.id_user','left');
		$this->db->order_by('tgl_pengajuan','DESC');

		// $this->db->where('left(kontrabon.no_kontrabon,1) !=','T');

		$query  = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	function insertpengajuanlimit()
	{
		$cabang 				= $this->input->post('cabang');
		$tanggal 				= $this->input->post('tgl_pengajuan');
		$tgl 						= explode("-",$tanggal);
		$tahun 					= $tgl[0];
		$thn 						= substr($tahun,2,2);
		$ceknolast    	= $this->db->query("SELECT no_pengajuan FROM pengajuan_limitkredit
		INNER JOIN pelanggan ON pengajuan_limitkredit.kode_pelanggan = pelanggan.kode_pelanggan WHERE YEAR(tgl_pengajuan) ='$tahun' AND pelanggan.kode_cabang='$cabang' ORDER BY no_pengajuan DESC LIMIT 1")->row_array();
    $nobuktilast  	= $ceknolast['no_pengajuan'];
		$no_pengajuan   = buatkode($nobuktilast,'PLK'.$cabang.$thn,5);
		echo $no_pengajuan;
		$pelanggan 			= $this->input->post('pelanggan');
		$jumlah 				= str_replace(".","",$this->input->post('jumlah'));
		$id_admin 			= $this->session->userdata('id_user');
		$data = [
			'no_pengajuan' => $no_pengajuan,
			'tgl_pengajuan' => $tanggal,
			'kode_pelanggan' => $pelanggan,
			'jumlah'	=> $jumlah,
			'status' => 0,
			'id_admin' => $id_admin
		];

		$simpan = $this->db->insert('pengajuan_limitkredit',$data);
		if($simpan)
		{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Simpan !
			</div>');
			redirect('penjualan/limitkredit');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Gagal di Simpan !
			</div>');
			redirect('penjualan/limitkredit');
		}
	}

	function updatepengajuanlimit()
	{
		$nopengajuan 		= $this->input->post('nopengajuan');
		$status 				= $this->input->post('status');
		$kode_pelanggan = $this->input->post('kodepelanggan');
		$jumlahold 			= $this->input->post('jumlahold');
		$penyesuaian 		= str_replace(".","",$this->input->post('jumlah'));
		$jumlah 				= (($penyesuaian / 100) * $jumlahold) + $jumlahold;

	

		$data = [
			'jumlah_rekomendasi'	=> $jumlah,
		];


		$simpan = $this->db->update('pengajuan_limitkredit',$data,array('no_pengajuan'=>$nopengajuan));
		if($simpan)
		{
			if($status=='1')
			{
				$datapel = [
					'limitpel' => $jumlah
				];
				$updatelimit = $this->db->update('pelanggan',$datapel,array('kode_pelanggan'=>$kode_pelanggan));
			}
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Simpan !
			</div>');
			redirect('penjualan/approvallimit');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Gagal di Simpan !
			</div>');
			redirect('penjualan/approvallimit');
		}
	}

	function hapuspengajuanlimit($id)
	{
		$hapus = $this->db->delete('pengajuan_limitkredit',array('no_pengajuan'=>$id));
		if($hapus)
		{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
			</div>');
			redirect('penjualan/limitkredit');
		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Gagal di Hapus !
			</div>');
			redirect('penjualan/limitkredit');
		}
	}

	function approvelimitproses($id)
	{
		$pengajuan = $this->db->get_where('pengajuan_limitkredit',array('no_pengajuan'=>$id))->row_array();
		$kode_pelanggan = $pengajuan['kode_pelanggan'];
		$jumlah = $pengajuan['jumlah'];
		$jumlah_rekomendasi = $pengajuan['jumlah_rekomendasi'];
		$id_admin = $this->session->userdata('id_user');
		$level = $this->session->userdata('level_user');
		
		if(empty($jumlah_rekomendasi)){
			$data = [
				'limitpel' => $jumlah
			];
		}else{
			$data = [
				'limitpel' => $jumlah_rekomendasi
			];
		}

		if($level=='kepala cabang'){
			$lv = 'kacab';
			if($jumlah <=10000000)
			{
				$status = 1;
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$status = 0;
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
		}else if($level == 'manager marketing'){
			$lv = 'mm';
			if($jumlah > 10000000 OR $jumlah <=20000000)
			{
				$status = 1;
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$status = 0;
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
		}else if($level == 'general manager'){
			$lv = 'gm';
			if($jumlah > 20000000 OR $jumlah <=30000000)
			{
				$status = 1;
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$status = 0;
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
		}else if($level == 'Administrator'){
			if($jumlah > 30000000)
			{
				$status = 1;
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$status = 0;
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
			$lv = 'dirut';
		}
		// echo $updatelimit;
		// die;



		// if($level=='kepala cabang')
		// {
		// 	$this->db->where('jumlah <=','10000000');
		// }else if($level=='manager marketing')
		// {
		// 	$this->db->where('jumlah >','10000000');
		// 	$this->db->where('jumlah <=','20000000');
		// }else if($level=='manager marketing')
		// {
		// 	$this->db->where('jumlah >','10000000');
		// 	$this->db->where('jumlah <=','20000000');
		// }else if($level=='general manager')
		// {
		// 	$this->db->where('jumlah >','20000000');
		// 	$this->db->where('jumlah <=','75000000');
		// }else if($level=='Administrator')
		// {
		// 	$this->db->where('jumlah >','75000000');
		// }


		if($updatelimit)
		{
			$datastatus = [
				'status' => $status,
				 $lv => 1,
				'id_approval' => $id_admin
			];
			$updatestatus = $this->db->update('pengajuan_limitkredit',$datastatus,array('no_pengajuan'=>$id));
			if($updatestatus)
			{
				$ceklimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan))->row_array();
				//$getpenjualanpending  = $this->db->join('karyawan','penjualan_pending.id_karyawan = karyawan.id_karyawan');
				$querypenjualanpend = "SELECT * FROM penjualan_pending
				INNER JOIN karyawan ON penjualan_pending.id_karyawan = karyawan.id_karyawan
				WHERE kode_pelanggan ='$kode_pelanggan' AND no_fak_penj NOT IN (SELECT no_fak_penj FROM penjualan WHERE kode_pelanggan ='$kode_pelanggan')
				";
				$getpenjualanpending  = $this->db->query($querypenjualanpend)->result();

				foreach($getpenjualanpending as $d)
				{
					$query = " SELECT
					penjualan.kode_pelanggan,
					SUM(IFNULL( retur.total, 0 )) AS totalretur,
					SUM(( ( IFNULL( penjualan.total, 0 ) ) - ( IFNULL( retur.total, 0 ) ) )) AS totalpiutang,
					SUM((SELECT IFNULL(SUM(bayar),0) as jmlbayar
						FROM historibayar
						INNER JOIN penjualan pj
						ON historibayar.no_fak_penj = pj.no_fak_penj
						INNER JOIN pelanggan
						ON pj.kode_pelanggan = pelanggan.kode_pelanggan
						WHERE pj.no_fak_penj = penjualan.no_fak_penj )) as jmlbayar
					FROM
						penjualan
						LEFT JOIN ( SELECT retur.no_fak_penj AS no_fak_penj, SUM( total ) AS total FROM retur GROUP BY retur.no_fak_penj ) retur ON ( penjualan.no_fak_penj = retur.no_fak_penj )
					WHERE
						penjualan.kode_pelanggan = '$kode_pelanggan'
					GROUP BY
						penjualan.kode_pelanggan";
					$ceksisapiutang = $this->db->query($query)->row_array();
					$piutang = $ceksisapiutang['totalpiutang']-$ceksisapiutang['jmlbayar'];



					$totalpiutang = $piutang + $d->total;

					//echo $ceklimit['limitpel'];
					if($totalpiutang <= $ceklimit['limitpel'])
					{
						$datapenjualan = [
							'no_fak_penj' => $d->no_fak_penj,
							'tgltransaksi' => $d->tgltransaksi,
							'kode_pelanggan' => $d->kode_pelanggan,
							'id_karyawan' => $d->id_karyawan,
							'subtotal' => $d->subtotal,
							'potongan' => $d->potongan,
							'potistimewa' => $d->potistimewa,
							'penyharga' => $d->penyharga,
							'total' => $d->total,
							'jenistransaksi' => $d->jenistransaksi,
							'jenisbayar' => $d->jenisbayar,
							'jatuhtempo' => $d->jatuhtempo,
							'id_admin' => $id_admin
						];

						$simpanpenjualan = $this->db->insert('penjualan',$datapenjualan);
						//echo $totalpiutang;
						if($simpanpenjualan)
						{
							$detailpenjpending = $this->db->get_where('detailpenjualan_pending',array('no_fak_penj'=>$d->no_fak_penj))->result();
							$hbpending = $this->db->get_where('historibayar_pending',array('no_fak_penj'=>$d->no_fak_penj))->result();
							//var_dump($detailpenjpending);
							//echo $detailpenjpending;
							foreach($detailpenjpending as $dp)
							{
								$datadetail = [
									'no_fak_penj' => $dp->no_fak_penj,
									'kode_barang' => $dp->kode_barang,
									'harga_dus' => $dp->harga_dus,
									'harga_pack' => $dp->harga_pack,
									'harga_pcs' => $dp->harga_pcs,
									'jumlah' => $dp->jumlah,
									'subtotal' => $dp->subtotal,
									'promo' => $dp->promo,
									'id_admin' => $dp->id_admin
								];

								$simpandetailpending = $this->db->insert('detailpenjualan',$datadetail);
							}
							$cabang 				= $d->kode_cabang;
							$tahunini   		= date('y');
							$qbayar       	= "SELECT nobukti FROM historibayar WHERE LEFT(nobukti,6) ='$cabang$tahunini-'ORDER BY nobukti DESC LIMIT 1 ";
							$ceknolast    	= $this->db->query($qbayar)->row_array();
							$nobuktilast  	= $ceknolast['nobukti'];
							$nobukti     	  = buatkode($nobuktilast,$cabang.$tahunini."-",6);
							foreach($hbpending as $h)
							{
								$databayar = [
									'nobukti' => $nobukti,
									'no_fak_penj' => $h->no_fak_penj,
									'tglbayar' => $h->tglbayar,
									'jenistransaksi' => $h->jenistransaksi,
									'jenisbayar' => $h->jenisbayar,
									'status_bayar' => $h->status_bayar,
									'bayar' => $h->bayar,
									'id_karyawan' => $h->id_karyawan,
									'id_admin' => $h->id_admin,
								];

								$simpanbayar = $this->db->insert('historibayar',$databayar);
							}
						}
					}
				}

				// die;
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Simpan !
				</div>');
				redirect('penjualan/approvallimit');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Gagal di Simpan !
				</div>');
				redirect('penjualan/approvallimit');
			}
		}

	}

	function declinelimitproses($id)
	{
		$pengajuan = $this->db->get_where('pengajuan_limitkredit',array('no_pengajuan'=>$id))->row_array();
		$kode_pelanggan = $pengajuan['kode_pelanggan'];
		$tgl_pengajuan = $pengajuan['tgl_pengajuan'];
		$id_admin = $this->session->userdata('id_user');
		$level = $this->session->userdata('level_user');
		$cek_pengajuan = $this->db->query("SELECT * FROM pengajuan_limitkredit WHERE kode_pelanggan = '$kode_pelanggan' AND tgl_pengajuan < '$tgl_pengajuan' ORDER BY tgl_pengajuan DESC LIMIT 1");
		$cekpj = $cek_pengajuan->row_array();
		if($cek_pengajuan->num_rows() !=0)
		{
			$jumlah = $cekpj['jumlah'];
		}else{
			$jumlah = 0;
		}

		$data = [
			'limitpel' => $jumlah
		];
		if($level=='kepala cabang'){
			$lv = 'kacab';
			if($jumlah <=10000000)
			{
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
		}else if($level == 'manager marketing'){
			$lv = 'mm';
			if($jumlah > 10000000 OR $jumlah <=20000000)
			{
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
		}else if($level == 'general manager'){
			$lv = 'gm';
			if($jumlah > 20000000 OR $jumlah <=30000000)
			{
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
		}else if($level == 'Administrator'){
			if($jumlah > 30000000)
			{
				$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
			}else{
				$updatelimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan));
			}
			$lv = 'dirut';
		}

		echo $jumlah;
		//$updatelimit = $this->db->update('pelanggan',$data,array('kode_pelanggan'=>$kode_pelanggan));
		if($updatelimit)
		{
			$datastatus = [
				'status' => 2,
				 $lv => 2,
				'id_approval' => $id_admin
			];
			$updatestatus = $this->db->update('pengajuan_limitkredit',$datastatus,array('no_pengajuan'=>$id));
			echo "statusupdate";
			if($updatestatus)
			{
				echo "update";
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Simpan !
				</div>');
				redirect('penjualan/approvallimit');
			}else{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-red alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i> Gagal di Simpan !
				</div>');
				redirect('penjualan/approvallimit');
			}
		}

	}

	function getPengajuanLimitkredit($id)
	{
		return $this->db->get_where('pengajuan_limitkredit',array('no_pengajuan'=>$id));
	}

	public function getDataPenjualanpend($rowno,$rowperpage,$cbg="",$salesman="",$dari="",$sampai="",$status="") {
		if($cbg != ""){
			$this->db->where('karyawan.kode_cabang',$cbg);
		}
		if($salesman != ''){
		  $this->db->where('penjualan_pending.id_karyawan', $salesman);
		}
		if($dari !=  ''){
		  $this->db->where('tgltransaksi >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgltransaksi <=', $sampai);
		}
		if($status=="1")
		{
			$this->db->where('(SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) =','1');
		}else if($status=="2")
		{
			$this->db->where('(SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) !=','1');
		}
		$this->db->select("no_fak_penj,tgltransaksi,penjualan_pending.kode_pelanggan,nama_pelanggan,penjualan_pending.id_karyawan,nama_karyawan,
		total,jenistransaksi,(SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) as status");
		$this->db->from('penjualan_pending');
		$this->db->join('pelanggan','penjualan_pending.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan','penjualan_pending.id_karyawan = karyawan.id_karyawan');
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
   }

    // Select total records
  public function getrecordPenjualanpendCount($cbg="",$salesman="",$dari="",$sampai="",$status="") {
		if($cbg != ""){
			$this->db->where('karyawan.kode_cabang',$cbg);
		}
		if($salesman != ''){
		  $this->db->where('penjualan_pending.id_karyawan', $salesman);
		}
		if($dari !=  ''){
		  $this->db->where('tgltransaksi >=', $dari);
		}
		if($sampai !=  ''){
		  $this->db->where('tgltransaksi <=', $sampai);
		}
		if($status=="1")
		{
			$this->db->where('(SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) =','1');
		}else if($status=="2")
		{
			$this->db->where('(SELECT count(no_fak_penj) FROM penjualan WHERE penjualan.no_fak_penj = penjualan_pending.no_fak_penj) !=','1');
		}
		$this->db->select("count(*) as allcount");
		$this->db->from('penjualan_pending');
		$this->db->join('pelanggan','penjualan_pending.kode_pelanggan = pelanggan.kode_pelanggan');
		$this->db->join('karyawan','penjualan_pending.id_karyawan = karyawan.id_karyawan');
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
	}

	function getDetailpenjualanpending($nofaktur){
		$this->db->select('no_fak_penj,detailpenjualan_pending.kode_barang,nama_barang,kategori,satuan,stok,harga_returdus,harga_returpack,harga_returpcs,isipcsdus,isipack,isipcs,jumlah,detailpenjualan_pending.harga_dus,detailpenjualan_pending.harga_pack,detailpenjualan_pending.harga_pcs,subtotal,promo,id_admin');
		$this->db->from('detailpenjualan_pending');
		$this->db->join('barang','detailpenjualan_pending.kode_barang = barang.kode_barang');
		$this->db->where('no_fak_penj',$nofaktur);
		return $this->db->get();
	}

	function hapuspenjualanpending($nofaktur){
		$hapus = $this->db->delete('penjualan_pending',array('no_fak_penj'=>$nofaktur));
		if($hapus)
		{
			$hapusdetail = $this->db->delete('detailpenjualan_pending',array('no_fak_penj'=>$nofaktur));
			$hapushistoribayar = $this->db->delete('historibayar_pending',array('no_fak_penj'=>$nofaktur));
			if($hapusdetail && $hapushistoribayar)
			{
				$this->session->set_flashdata('msg',
				'<div class="alert bg-green alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<i class="material-icons" style="float:left; margin-right:10px">check</i>Data Berhasil di Hapus !
				</div>');
				redirect('penjualan/penjualanpend');
			}
		}
	}

	function getPenjualanpending($nofaktur)
	{
		return $this->db->get_where('penjualan_pending',array('no_fak_penj'=>$nofaktur));
	}

	function updatepenjualanpending($kode_pelanggan,$nofaktur)
	{
		
		$ceklimit = $this->db->get_where('pelanggan',array('kode_pelanggan'=>$kode_pelanggan))->row_array();
		
		//$getpenjualanpending  = $this->db->join('karyawan','penjualan_pending.id_karyawan = karyawan.id_karyawan');
		$querypenjualanpend = "SELECT * FROM penjualan_pending
		INNER JOIN karyawan ON penjualan_pending.id_karyawan = karyawan.id_karyawan
		WHERE kode_pelanggan ='$kode_pelanggan' AND no_fak_penj ='$nofaktur'
		";
		$getpenjualanpending  = $this->db->query($querypenjualanpend)->result();

		foreach($getpenjualanpending as $d)
		{
			$query = " SELECT
			penjualan.kode_pelanggan,
			SUM(IFNULL( retur.total, 0 )) AS totalretur,
			SUM(( ( IFNULL( penjualan.total, 0 ) ) - ( IFNULL( retur.total, 0 ) ) )) AS totalpiutang,
			SUM((SELECT IFNULL(SUM(bayar),0) as jmlbayar
				FROM historibayar
				INNER JOIN penjualan pj
				ON historibayar.no_fak_penj = pj.no_fak_penj
				INNER JOIN pelanggan
				ON pj.kode_pelanggan = pelanggan.kode_pelanggan
				WHERE pj.no_fak_penj = penjualan.no_fak_penj )) as jmlbayar
			FROM
				penjualan
				LEFT JOIN ( SELECT retur.no_fak_penj AS no_fak_penj, SUM( total ) AS total FROM retur GROUP BY retur.no_fak_penj ) retur ON ( penjualan.no_fak_penj = retur.no_fak_penj )
			WHERE
				penjualan.kode_pelanggan = '$kode_pelanggan'
			GROUP BY
				penjualan.kode_pelanggan";
			$ceksisapiutang = $this->db->query($query)->row_array();
			$piutang = $ceksisapiutang['totalpiutang']-$ceksisapiutang['jmlbayar'];



			$totalpiutang = $piutang + $d->total;

			//echo $ceklimit['limitpel'];
			if($totalpiutang <= $ceklimit['limitpel'])
			{
				$datapenjualan = [
					'no_fak_penj' => $d->no_fak_penj,
					'tgltransaksi' => $d->tgltransaksi,
					'kode_pelanggan' => $d->kode_pelanggan,
					'id_karyawan' => $d->id_karyawan,
					'subtotal' => $d->subtotal,
					'potongan' => $d->potongan,
					'potistimewa' => $d->potistimewa,
					'penyharga' => $d->penyharga,
					'total' => $d->total,
					'jenistransaksi' => $d->jenistransaksi,
					'jenisbayar' => $d->jenisbayar,
					'jatuhtempo' => $d->jatuhtempo,
					'id_admin' => $id_admin
				];

				$simpanpenjualan = $this->db->insert('penjualan',$datapenjualan);
				//echo $totalpiutang;
				if($simpanpenjualan)
				{
					$detailpenjpending = $this->db->get_where('detailpenjualan_pending',array('no_fak_penj'=>$d->no_fak_penj))->result();
					$hbpending = $this->db->get_where('historibayar_pending',array('no_fak_penj'=>$d->no_fak_penj))->result();
					//var_dump($detailpenjpending);
					//echo $detailpenjpending;
					foreach($detailpenjpending as $dp)
					{
						$datadetail = [
							'no_fak_penj' => $dp->no_fak_penj,
							'kode_barang' => $dp->kode_barang,
							'harga_dus' => $dp->harga_dus,
							'harga_pack' => $dp->harga_pack,
							'harga_pcs' => $dp->harga_pcs,
							'jumlah' => $dp->jumlah,
							'subtotal' => $dp->subtotal,
							'promo' => $dp->promo,
							'id_admin' => $dp->id_admin
						];

						$simpandetailpending = $this->db->insert('detailpenjualan',$datadetail);
					}
					$cabang 				= $d->kode_cabang;
					$tahunini   		= date('y');
					$qbayar       	= "SELECT nobukti FROM historibayar WHERE LEFT(nobukti,6) ='$cabang$tahunini-'ORDER BY nobukti DESC LIMIT 1 ";
					$ceknolast    	= $this->db->query($qbayar)->row_array();
					$nobuktilast  	= $ceknolast['nobukti'];
					$nobukti     	  = buatkode($nobuktilast,$cabang.$tahunini."-",6);
					foreach($hbpending as $h)
					{
						$databayar = [
							'nobukti' => $nobukti,
							'no_fak_penj' => $h->no_fak_penj,
							'tglbayar' => $h->tglbayar,
							'jenistransaksi' => $h->jenistransaksi,
							'jenisbayar' => $h->jenisbayar,
							'status_bayar' => $h->status_bayar,
							'bayar' => $h->bayar,
							'id_karyawan' => $h->id_karyawan,
							'id_admin' => $h->id_admin,
						];

						$simpanbayar = $this->db->insert('historibayar',$databayar);
					}
				}
			}
		}

		// die;
		$this->session->set_flashdata('msg',
		'<div class="alert bg-green alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Simpan !
		</div>');
		redirect('penjualan/penjualanpend');
	}

	function inputsetorangiro()
	{
			$no_giro = $this->input->post('no_giro');
			$tglsetor = $this->input->post('tglsetor');
			$cabang = $this->input->post('cabang');
			$bankpenerima = $this->input->post('bank_penerima');
			$jmlbayar = $this->input->post('jmlbayar');
			$pelanggan = $this->input->post('pelanggan');
			$tahunini = date("y");
			$status = $this->input->post('statusgiro');
			$tglbayar = $this->input->post('tglbayar');

			$qsb 						    = "SELECT kode_setoranpusat FROM setoran_pusat
                            WHERE LEFT(kode_setoranpusat,4) = 'SB$tahunini' ORDER BY kode_setoranpusat DESC LIMIT 1";
      $sb							    = $this->db->query($qsb)->row_array();
      $nomor_terakhir 		= $sb['kode_setoranpusat'];
			$kode_setoranpusat 	= buatkode($nomor_terakhir,'SB'.$tahunini,5);
			
			$data = array(
        'kode_setoranpusat' => $kode_setoranpusat,
        'tgl_setoranpusat'	=> $tglsetor,
        'kode_cabang'				=> $cabang,
        'bank'							=> $bankpenerima,
        'no_ref'				    => $no_giro,
        'giro'				      => $jmlbayar,
        'keterangan'				=> "SETOR GIRO PELANGGAN ".$pelanggan,
        'status'						=> '0'

			);
			

			$insert = $this->db->insert('setoran_pusat',$data);
			if($insert)
			{
				$dataditerima = array(
					'status' => 1,
					'tgl_diterimapusat' => $tglbayar
				);

				$dataditolak = array(
					'status' => 2,
					'tgl_diterimapusat' => NULL
				);

				if($status == 1)
				{
					$this->db->update('setoran_pusat',$dataditerima,array('no_ref'=>$no_giro));
				}else{
					$this->db->update('setoran_pusat',$dataditolak,array('no_ref'=>$no_giro));
				}
			}

	}

	function hapussetorangirotransfer($noref)
	{
		$hapus = $this->db->delete('setoran_pusat',array('no_ref'=>$noref));
		if($hapus)
		{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Setoran di Batalkan !
			</div>');
			redirect('penjualan/setorangiro');
		}
	}
	

	function hapussetorantrf($noref)
	{
		$hapus = $this->db->delete('setoran_pusat',array('no_ref'=>$noref));
		if($hapus)
		{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Setoran di Batalkan !
			</div>');
			redirect('penjualan/setorantransfer');
		}
	}


	function inputsetorantransfer()
	{
			$id_transfer = $this->input->post('id_transfer');
			$tglsetor = $this->input->post('tglsetor');
			$cabang = $this->input->post('cabang');
			$bankpenerima = $this->input->post('bank_penerima');
			$jmlbayar = $this->input->post('jmlbayar');
			$pelanggan = $this->input->post('pelanggan');
			$tahunini = date("y");
			$status = $this->input->post('statustransfer');
			$tglbayar = $this->input->post('tglbayar');

			$qsb 						    = "SELECT kode_setoranpusat FROM setoran_pusat
                            WHERE LEFT(kode_setoranpusat,4) = 'SB$tahunini' ORDER BY kode_setoranpusat DESC LIMIT 1";
      $sb							    = $this->db->query($qsb)->row_array();
      $nomor_terakhir 		= $sb['kode_setoranpusat'];
			$kode_setoranpusat 	= buatkode($nomor_terakhir,'SB'.$tahunini,5);
			
			$data = array(
        'kode_setoranpusat' => $kode_setoranpusat,
        'tgl_setoranpusat'	=> $tglsetor,
        'kode_cabang'				=> $cabang,
        'bank'							=> $bankpenerima,
        'no_ref'				    => $id_transfer,
        'transfer'				  => $jmlbayar,
        'keterangan'				=> "TRANSFER PELANGGAN ".$pelanggan,
        'status'						=> '0'
			);
			
			$insert = $this->db->insert('setoran_pusat',$data);
			if($insert)
			{
				$dataditerima = array(
					'status' => 1,
					'tgl_diterimapusat' => $tglbayar
				);

				$dataditolak = array(
					'status' => 2,
					'tgl_diterimapusat' => NULL
				);

				if($status == 1)
				{
					$this->db->update('setoran_pusat',$dataditerima,array('no_ref'=>$id_transfer));
				}else{
					$this->db->update('setoran_pusat',$dataditolak,array('no_ref'=>$id_transfer));
				}
			}

	}

  public function notifikasilimit($cbg="",$dari="",$sampai="",$salesman="",$pelanggan="",$approval="",$status="-") {
    $cabang = $this->session->userdata('cabang');
    $level  = $this->session->userdata('level_user');
    $id_admin = $this->session->userdata('id_user');
    if($cabang !="pusat"){
      $this->db->where('pelanggan.kode_cabang',$cabang);
    }else{
      if($cbg !="")
      {
        $this->db->where('pelanggan.kode_cabang',$cbg);
      }
    }

    if($level=='kepala cabang')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('kacab',$status);
      }else if($status=="-"){
        $this->db->where('kacab is null');
        //$this->db->where('kacab !=','2');
      }
      $this->db->where('jumlah >','0');
    }else if($level=='manager marketing')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('mm',$status);
      }else if($status=="-"){
        $this->db->where('mm is null');
        //$this->db->where('gm !=','2');
      }
      $this->db->where('jumlah >','10000000');
      //$this->db->where('jumlah <=','20000000');
    }else if($level=='general manager')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('gm',$status);
      }else if($status=="-"){
        $this->db->where('gm is null');
        //$this->db->where('gm !=','2');
      }
      $this->db->where('jumlah >','20000000');
      //$this->db->where('jumlah <=','75000000');
    }else if($level=='Administrator')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('dirut',$status);
      }else if($status=="-"){
        $this->db->where('dirut is null');
        //$this->db->where('dirut !=','2');
      }
      $this->db->where('jumlah >','30000000');
    }

    if($dari !=  ''){
      $this->db->where('tgl_pengajuan >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_pengajuan <=', $sampai);
    }

    if($pelanggan !=  ''){
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if($salesman !=  ''){
      $this->db->where('pelanggan.id_sales', $salesman);
    }

    $this->db->or_where('id_approval',$id_admin);
    if($cabang !="pusat"){
      $this->db->where('pelanggan.kode_cabang',$cabang);
    }else{
      if($cbg !="")
      {
        $this->db->where('pelanggan.kode_cabang',$cbg);
      }
    }

    if($level=='kepala cabang')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('kacab',$status);
      }else if($status=="-"){
        $this->db->where('kacab is null');
        //$this->db->where('kacab !=','2');
      }
      $this->db->where('jumlah >','0');
    }else if($level=='manager marketing')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('mm',$status);
      }else if($status=="-"){
        $this->db->where('mm is null');
        //$this->db->where('gm !=','2');
      }
      $this->db->where('jumlah >','10000000');
      //$this->db->where('jumlah <=','20000000');
    }else if($level=='general manager')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('gm',$status);
      }else if($status=="-"){
        $this->db->where('gm is null');
        //$this->db->where('gm !=','2');
      }
      $this->db->where('jumlah >','20000000');
      //$this->db->where('jumlah <=','75000000');
    }else if($level=='Administrator')
    {
      if($status !="" AND $status !="-")
      {
        $this->db->where('dirut',$status);
      }else if($status=="-"){
        $this->db->where('dirut is null');
        //$this->db->where('dirut !=','2');
      }
      $this->db->where('jumlah >','30000000');
    }

    if($dari !=  ''){
      $this->db->where('tgl_pengajuan >=', $dari);
    }
    if($sampai !=  ''){
      $this->db->where('tgl_pengajuan <=', $sampai);
    }

    if($pelanggan !=  ''){
      $this->db->like('nama_pelanggan', $pelanggan);
    }

    if($salesman !=  ''){
      $this->db->where('pelanggan.id_sales', $salesman);
    }
    $this->db->select('*');
    $this->db->from('pengajuan_limitkredit');
    $this->db->join('pelanggan','pengajuan_limitkredit.kode_pelanggan = pelanggan.kode_pelanggan');
    $this->db->join('karyawan','pelanggan.id_sales = karyawan.id_karyawan');
    $this->db->join('users','pengajuan_limitkredit.id_approval = users.id_user','left');
    $this->db->order_by('tgl_pengajuan','DESC');

    // $this->db->where('left(kontrabon.no_kontrabon,1) !=','T');


   
    $query = $this->db->get();
    return $query->num_rows();
	}
	public function getDataSaldoawalkurleb($rowno,$rowperpage,$tanggal="",$cabang="",$bulan="",$tahun="")
  {
    $this->db->select('kode_saldokurleb,tanggal,bulan,tahun,kode_cabang');
    $this->db->from('saldoawal_kurlebsetor');
    $this->db->order_by('tanggal','desc');
    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }
    if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }

    if($bulan != ''){
      $this->db->where('bulan', $bulan);
    }

    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

    // Select total records
  public function getrecordSaldoawalkurlebCount($tanggal="",$cabang="",$bulan="",$tahun="")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('saldoawal_kurlebsetor');
    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }
		if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }
    if($bulan != ''){
      $this->db->where('bulan', $bulan);
    }
    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
	}
	
	function getsaldosalestemp($bulan,$tahun,$cabang)
	{
		$this->db->where('bulan',$bulan);
    $this->db->where('tahun',$tahun);
		$this->db->where('kode_cabang',$cabang);
		$this->db->join('karyawan','saldoawal_kurlebsetor_temp.id_karyawan = karyawan.id_karyawan');
    return $this->db->get('saldoawal_kurlebsetor_temp');
	}

	function getsaldokurleb($id)
	{
		return $this->db->get_where('saldoawal_kurlebsetor',array('kode_saldokurleb'=>$id));
	}

	function getdetailsaldosaleskurleb($id)
	{
		$this->db->join('karyawan','saldoawal_kurlebsetor_detail.id_karyawan = karyawan.id_karyawan');
		return $this->db->get_where('saldoawal_kurlebsetor_detail',array('kode_saldokurleb'=>$id));
	}

	function ceksaldokurleb($bulan,$tahun,$cabang)
  {
    if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
		}
		$this->db->join('saldoawal_kurlebsetor','saldoawal_kurlebsetor_detail.kode_saldokurleb = saldoawal_kurlebsetor.kode_saldokurleb');
    return $this->db->get_where('saldoawal_kurlebsetor_detail',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang));
  }

	function ceksaldoSkrgkurleb($bulan,$tahun,$cabang)
  {
		$this->db->join('saldoawal_kurlebsetor','saldoawal_kurlebsetor_detail.kode_saldokurleb = saldoawal_kurlebsetor.kode_saldokurleb');
    return $this->db->get_where('saldoawal_kurlebsetor_detail',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang));
	}
	
	function ceksaldoallkurleb($cabang)
  {
    $this->db->join('saldoawal_kurlebsetor','saldoawal_kurlebsetor_detail.kode_saldokurleb = saldoawal_kurlebsetor.kode_saldokurleb');
    return $this->db->get_where('saldoawal_kurlebsetor_detail',array('kode_cabang'=>$cabang));
	}
	
	function getdetailsaldokurleb($bulan,$tahun,$cabang,$salesman)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
		$this->db->join('saldoawal_kurlebsetor','saldoawal_kurlebsetor_detail.kode_saldokurleb = saldoawal_kurlebsetor.kode_saldokurleb');
    return $this->db->get_where('saldoawal_kurlebsetor_detail',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang,'id_karyawan'=>$salesman));
		
	}

	function getsetoranpenjualankurleb($bulan,$tahun,$cabang,$salesman)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }

		$querysetpenj = "SELECT SUM(lhp_tunai) as terimatunai, SUM(lhp_tagihan) as terimatagihan,SUM(setoran_kertas) as uangkertas,
		SUM(setoran_logam) as uanglogam,SUM(setoran_bg) as giro,SUM(setoran_transfer) as transfer,SUM(girotocash) as girotocash
		FROM setoran_penjualan
		WHERE kode_cabang='$cabang' AND MONTH(tgl_lhp)='$bulan' AND YEAR(tgl_lhp)='$tahun' AND id_karyawan='$salesman'";
		$setpenj = $this->db->query($querysetpenj);
		return $setpenj;
	}

	function getKLSetorpenjualankurleb($bulan,$tahun,$cabang,$pembayaran,$salesman)
	{
		if($bulan == 1){
      $bulan = 12;
      $tahun = $tahun - 1;
    }else{
      $bulan = $bulan - 1;
      $tahun = $tahun;
    }
		$query = "SELECT SUM(uang_kertas) as uangkertas,SUM(uang_logam) as uanglogam
		FROM kuranglebihsetor WHERE kode_cabang='$cabang' AND MONTH(tgl_kl)='$bulan' AND YEAR(tgl_kl)='$tahun'
		AND pembayaran='$pembayaran' AND id_karyawan='$salesman'";
		return $this->db->query($query);
	}

	function hapussaldosalestemp($id)
	{
		$this->db->delete('saldoawal_kurlebsetor_temp',array('id'=>$id));
	}

	function simpansaldosalestemp()
	{
		$bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $salesman = $this->input->post('salesman');
    $jumlah = str_replace(".","",$this->input->post('jumlah'));
		
		$data = [
			'bulan' => $bulan,
			'tahun' => $tahun,
			'id_karyawan' => $salesman,
			'jumlah' => $jumlah
		];
		$cek = $this->db->get_where('saldoawal_kurlebsetor_temp',array('bulan'=>$bulan,'tahun'=>$tahun,'id_karyawan'=>$salesman))->num_rows();
		if(!empty($cek))
		{
			return 1;
		}else{
			$this->db->insert('saldoawal_kurlebsetor_temp',$data);
			return 0;
		}
		
	}

	function insertsaldoawalkurleb()
	{
		$kodesaldoawal = $this->input->post('kode_saldoawal');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$tanggal = $this->input->post('tanggal');
		$cabang = $this->input->post('cabang2');
		$id_admin = $this->session->userdata('id_user');

		$data = [
			'kode_saldokurleb' => $kodesaldoawal,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kode_cabang' => $cabang,
			'tanggal' => $tanggal,
			'id_admin' => $id_admin
		];

		$simpan = $this->db->insert('saldoawal_kurlebsetor',$data);
		if($simpan)
		{
			$this->db->join('karyawan','saldoawal_kurlebsetor_temp.id_karyawan = karyawan.id_karyawan');
			$cektemp = $this->db->get_where('saldoawal_kurlebsetor_temp',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->result();
			foreach($cektemp as $d)
			{
				$datadetail = [
					'kode_saldokurleb' => $kodesaldoawal,
					'id_karyawan' => $d->id_karyawan,
					'jumlah' => $d->jumlah
				];

				$simpandetail = $this->db->insert('saldoawal_kurlebsetor_detail',$datadetail);
				if($simpandetail)
				{
					$hapustemp = $this->db->delete('saldoawal_kurlebsetor_temp',array('id_karyawan'=>$d->id_karyawan,'bulan'=>$bulan,'tahun'=>$tahun));
				}
			}
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
			</div>');
			redirect('penjualan/saldokurlebsetor');

		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Disimpan !
			</div>');
			redirect('penjualan/saldokurlebsetor');
		}


	}

	public function getDataBelumsetor($rowno,$rowperpage,$tanggal="",$cabang="",$bulan="",$tahun="")
  {
    $this->db->select('kode_saldobs,tanggal,bulan,tahun,kode_cabang');
    $this->db->from('belumsetor');
    $this->db->order_by('tanggal','desc');
    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }
    if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }

    if($bulan != ''){
      $this->db->where('bulan', $bulan);
    }

    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
    $this->db->limit($rowperpage, $rowno);
    $query = $this->db->get();
    return $query->result_array();
  }

    // Select total records
  public function getrecordBelumsetorCount($tanggal="",$cabang="",$bulan="",$tahun="")
  {
    $this->db->select('count(*) as allcount');
    $this->db->from('belumsetor');
    if($tanggal != ''){
      $this->db->where('tanggal', $tanggal);
    }
		if($cabang != ''){
      $this->db->where('kode_cabang', $cabang);
    }
    if($bulan != ''){
      $this->db->where('bulan', $bulan);
    }
    if($tahun != ''){
      $this->db->where('tahun', $tahun);
    }
    $query  = $this->db->get();
    $result = $query->result_array();
    return $result[0]['allcount'];
	}

	function getbelumsetortemp($bulan,$tahun,$cabang)
	{
		$this->db->where('bulan',$bulan);
    $this->db->where('tahun',$tahun);
		$this->db->where('kode_cabang',$cabang);
		$this->db->join('karyawan','belumsetor_temp.id_karyawan = karyawan.id_karyawan');
    return $this->db->get('belumsetor_temp');
	}

	function simpanbelumsetortemp()
	{
		$bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $salesman = $this->input->post('salesman');
    $jumlah = str_replace(".","",$this->input->post('jumlah'));
		
		$data = [
			'bulan' => $bulan,
			'tahun' => $tahun,
			'id_karyawan' => $salesman,
			'jumlah' => $jumlah
		];
		$cek = $this->db->get_where('belumsetor_temp',array('bulan'=>$bulan,'tahun'=>$tahun,'id_karyawan'=>$salesman))->num_rows();
		if(!empty($cek))
		{
			return 1;
		}else{
			$this->db->insert('belumsetor_temp',$data);
			return 0;
		}
		
	}

	function hapusbelumsetortemp($id)
	{
		$this->db->delete('belumsetor_temp',array('id'=>$id));
	}

	function insertbelumsetorsales()
	{
		$kodebelumsetor = $this->input->post('kodebelumsetor');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$tanggal = $this->input->post('tanggal');
		$cabang = $this->input->post('cabang2');
		$id_admin = $this->session->userdata('id_user');

		$data = [
			'kode_saldobs' => $kodebelumsetor,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kode_cabang' => $cabang,
			'tanggal' => $tanggal,
			'id_admin' => $id_admin
		];

		$simpan = $this->db->insert('belumsetor',$data);
		if($simpan)
		{
			$this->db->join('karyawan','belumsetor_temp.id_karyawan = karyawan.id_karyawan');
			$cektemp = $this->db->get_where('belumsetor_temp',array('bulan'=>$bulan,'tahun'=>$tahun,'kode_cabang'=>$cabang))->result();
			foreach($cektemp as $d)
			{
				$datadetail = [
					'kode_saldobs' => $kodebelumsetor,
					'id_karyawan' => $d->id_karyawan,
					'jumlah' => $d->jumlah
				];

				$simpandetail = $this->db->insert('belumsetor_detail',$datadetail);
				if($simpandetail)
				{
					$hapustemp = $this->db->delete('belumsetor_temp',array('id_karyawan'=>$d->id_karyawan,'bulan'=>$bulan,'tahun'=>$tahun));
				}
			}
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil Disimpan !
			</div>');
			redirect('penjualan/belumsetor');

		}else{
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal Disimpan !
			</div>');
			redirect('penjualan/belumsetor');
		}


	}

	function getSaldobelumsetor($id)
	{
		return $this->db->get_where('belumsetor',array('kode_saldobs'=>$id));
	}

	function getdetailbelumsetor($id)
	{
		$this->db->join('karyawan','belumsetor_detail.id_karyawan = karyawan.id_karyawan');
		return $this->db->get_where('belumsetor_detail',array('kode_saldobs'=>$id));
	}

	function hapussaldoawalkurleb($id)
	{
		$hapus = $this->db->delete('saldoawal_kurlebsetor',array('kode_saldokurleb'=>$id));
		if($hapus)
		{
			$hapusdetail = $this->db->delete('saldoawal_kurlebsetor_detail',array('kode_saldokurleb'=>$id));
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
			</div>');
			redirect('penjualan/saldokurlebsetor');
		}else{
			$hapusdetail = $this->db->delete('saldoawal_kurlebsetor_detail',array('kode_saldokurleb',$id));
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal dihapus !
			</div>');
			redirect('penjualan/saldokurlebsetor');
		}
	}

	

	function hapusbelumsetorsales($id)
	{
		$hapus = $this->db->delete('belumsetor',array('kode_saldobs'=>$id));
		if($hapus)
		{
			$hapusdetail = $this->db->delete('belumsetor_detail',array('kode_saldobs'=>$id));
			$this->session->set_flashdata('msg',
			'<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Berhasil di Hapus !
			</div>');
			redirect('penjualan/belumsetor');
		}else{
			$hapusdetail = $this->db->delete('saldoawal_kurlebsetor_detail',array('kode_saldokurleb',$id));
			$this->session->set_flashdata('msg',
			'<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<i class="material-icons" style="float:left; margin-right:10px">check</i> Data Gagal dihapus !
			</div>');
			redirect('penjualan/belumsetor');
		}
	}

}
