<?php

class Model_penjualan extends CI_Model{

	function insert_detailtmp(){

		$kodebarang = $this->input->post('kodebarang');
		$jmldus		= $this->input->post('jmldus');
		$jmlpack	= $this->input->post('jmlpack');
		$jmlpcs		= $this->input->post('jmlpcs');
		$promo 		= $this->input->post('promo');
		$pelanggan 	= $this->input->post('pelanggan');

		echo $promo;
	


		if($promo !=1){
			$hargadus   = $this->input->post('hargadus');
			$hargapack	= $this->input->post('hargapack');
			$hargapcs	= $this->input->post('hargapcs');
		}else{
			$hargadus 	= 0;
			$hargapack  = 0;
			$hargapcs 	= 0;
		}

		
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 	= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 	= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs; 
		$brgtmp 	= $this->db->get_where('detailpenjualan_temp',array('kode_barang'=>$kodebarang,'promo'=>$promo));
			
		$cektmp 	= $brgtmp->num_rows();
		$brgold 	= $brgtmp->row_array();

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
				'jumlah' 	  => $jumlah,
				'harga_dus'   => $hargadus,
				'harga_pack'  => $hargapack,
				'harga_pcs'   => $hargapcs,
				'subtotal'    => $subtotal,
				'promo'		  => $promo,
				'id_admin'	  => $id_admin
			);
		    
		    if($pelanggan != 'BATAL'){
		    	$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
		    	$this->db->query($query);
		    }
		   
			$this->db->insert('detailpenjualan_temp',$data);

	    }else{

	    	 $data  		= array (

				'kode_barang' => $kodebarang,
				'jumlah' 	  => $jumlahnew,
				'harga_dus'   => $hargadus,
				'harga_pack'  => $hargapack,
				'harga_pcs'   => $hargapcs,
				'subtotal'    => $subtotalnew,
				'promo'		  => $promo,
				'id_admin'	  => $id_admin
			);
	    	 if($pelanggan != 'BATAL'){
		    	$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
		    	$this->db->query($query);
		    }
			$this->db->update('detailpenjualan_temp',$data,array('kode_barang'=> $kodebarang,'promo'=>$promo));

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


	function hapus_detailbrg($kodebarang,$jumlah,$promo){
		$query = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
		
		$this->db->query($query);
		
		$this->db->delete('detailpenjualan_temp',array('kode_barang'=>$kodebarang,'promo'=>$promo));
	}



	function json(){
		$url = base_url();
		$cabang = $this->session->userdata('cabang');

        if($cabang != "pusat"){

            $this->datatables->where('pelanggan.kode_cabang',$cabang);
        }
		$this->datatables->select('kode_pelanggan,nama_pelanggan,alamat_pelanggan,pelanggan.no_hp,pasar,hari,pelanggan.kode_cabang,nama_cabang,id_sales,nama_karyawan');
        $this->datatables->from('pelanggan');
        $this->datatables->join('cabang','pelanggan.kode_cabang = cabang.kode_cabang');
        $this->datatables->join('karyawan','pelanggan.id_sales = karyawan.id_karyawan');

        $this->datatables->add_column('view', '<a href="#" data-kodepel="$1" data-namapel="$2" data-kodesales="$3" data-namasales="$4" data-cabang="$5" class="btn bg-red btn-xs waves-effect pilihpel">Pilih</a>', 'kode_pelanggan,nama_pelanggan,id_sales,nama_karyawan,kode_cabang');
        return $this->datatables->generate();


	}


	function insert_penjualan(){

		$nofaktur 		= $this->input->post('nofaktur');
		$tgltransaksi	= $this->input->post('tgltransaksi');
		$kode_pelanggan = $this->input->post('kodepelanggan');
		$kodesales 		= $this->input->post('kodesales');
		$jenistransaksi = $this->input->post('jenistransaksi');
		$jenisbayar 	= $this->input->post('jenisbayar');
		$subtotal 		= $this->input->post('subtotal');
		$potongan  		= $this->input->post('potongan');
		$potistimewa  	= $this->input->post('potistimewa');
		$penyharga 		= $this->input->post('penyharga');
		$totalbayar 	= $this->input->post('totalbayar');
		$nogiro 		= $this->input->post('nogiro');
		$jml 			= $this->input->post('jml');
		$materai 		= $this->input->post('materai');
		$namabank 		= $this->input->post('namabank');
		$tglcair 		= $this->input->post('tglcair');
		$jatuhtempo 	= $this->input->post('jatuhtempo');
		$titipan 		= $this->input->post('titipan');
		$cabang 		= $this->input->post('kodecabang');
		$id_admin 		= $this->session->userdata('id_user');
		$hariini 		= date('ymd');
		$this->db->order_by('nobukti','DESC');
		$ceknolast 		= $this->db->get('historibayar')->row_array();
		$nobuktilast 	= $ceknolast['nobukti'];
		$nobukti 		= buatkode($nobuktilast,$cabang.$hariini,3);
		
		if($jenisbayar == "tunai"){

			$jt = "";

		}else{
			$jt = $jatuhtempo;
		}

		$data = array(

			'no_fak_penj' 		=> $nofaktur,
			'tgltransaksi'		=> $tgltransaksi,
			'kode_pelanggan' 	=> $kode_pelanggan,
			'id_karyawan'		=> $kodesales,
			'subtotal'			=> $subtotal,
			'potongan' 			=> $potongan,
			'potistimewa' 		=> $potistimewa,
			'penyharga'  		=> $penyharga,
			'total'				=> $totalbayar,
			'jenistransaksi' 	=> $jenistransaksi,
			'jenisbayar' 		=> $jenisbayar,
			'jatuhtempo'		=> $jt,
			'id_admin' 			=> $id_admin

		);
		$penjualan = $this->db->insert('penjualan',$data);
		if($penjualan){
			$tmp = $this->db->get_where('detailpenjualan_temp',array('id_admin'=>$id_admin))->result();
			foreach($tmp as $t){
				$dtmp = array(
					'no_fak_penj' => $nofaktur,
					'kode_barang' => $t->kode_barang,
					'harga_dus'   => $t->harga_dus,
					'harga_pack'  => $t->harga_pack,
					'harga_pcs'   => $t->harga_pcs,
					'jumlah' 	  => $t->jumlah,
					'subtotal' 	  => $t->subtotal,
					'promo' 	  => $t->promo,
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
				'jenistransaksi'	=> $jenistransaksi,
				'jenisbayar'		=> $jenisbayar,
				'bayar'				=> $totalbayar,
				'id_admin'			=> $id_admin

			);

			$this->db->insert('historibayar',$dbayar);
			redirect('penjualan/input_penjualan');

		}elseif($jenisbayar == "titipan"){	

			if($titipan != 0){

				$dbayar = array(
				
				'nobukti' 			=> $nobukti,
				'no_fak_penj'		=> $nofaktur,
				'tglbayar'			=> $tgltransaksi,
				'jenistransaksi'	=> $jenistransaksi,
				'jenisbayar'		=> $jenisbayar,
				'bayar'				=> $titipan,
				'id_admin'			=> $id_admin

				);

			$this->db->insert('historibayar',$dbayar);
			redirect('penjualan/input_penjualan');


			}else{

				redirect('penjualan/input_penjualan');

			}

		}elseif($jenisbayar == "giro"){

			$dgiro = array(
				
				'no_fak_penj' 		=> $nofaktur,
				'no_giro'			=> $nogiro,
				'materai'			=> $materai,
				'namabank'			=> $namabank,
				'jumlah'			=> $jml,
				'tglcair'			=> $tglcair,
				'status'			=> 0,
				

			);
			
			$this->db->insert('giro',$dgiro);
			redirect('penjualan/input_penjualan');

		}elseif($jenisbayar == "transfer"){

			$dtransfer = array(
				
				'no_fak_penj' 		=> $nofaktur,
				'namabank'			=> $namabank,
				'jumlah'			=> $jml,
				'tglcair'			=> $tglcair,
				'status'			=> 0,
				

			);
			
			$this->db->insert('transfer',$dtransfer);
			redirect('penjualan/input_penjualan');

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
		$jmldus		= $this->input->post('jmldus');
		$hargadus   = $this->input->post('hargadus');
		$jmlpack	= $this->input->post('jmlpack');
		$hargapack	= $this->input->post('hargapack');
		$jmlpcs		= $this->input->post('jmlpcs');
		$hargapcs	= $this->input->post('hargapcs');
		$kodepel 	= $this->input->post('kodepelanggan');
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 	= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 	= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs; 
		$brgtmp 	= $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));
		$brgpnj 	= $this->db->query("SELECT SUM(jumlah) as jumlah FROM detailpenjualan
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

			$cektmp 	= $brgtmp->num_rows();
			$brgold 	= $brgtmp->row_array();

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

					'kode_barang' 			=> $kodebarang,
					'jumlah' 	  			=> $jumlah,
					'harga_dus'   			=> $hargadus,
					'harga_pack'  			=> $hargapack,
					'harga_pcs'   			=> $hargapcs,
					'subtotal'    			=> $subtotal,
					'kode_pelanggan' 		=> $kodepel,
					'id_admin'	 			 => $id_admin
				);
			  
				$this->db->insert('detailretur_temp',$data);

		    }else{

		    	 $data  		= array (

					'kode_barang' 		=> $kodebarang,
					'jumlah' 	  		=> $jumlahnew,
					'harga_dus'   		=> $hargadus,
					'harga_pack'  		=> $hargapack,
					'harga_pcs'   		=> $hargapcs,
					'subtotal'    		=> $subtotalnew,
					'kode_pelanggan' 	=> $kodepel,
					'id_admin'	 		=> $id_admin
				);
		    	
				$this->db->update('detailretur_temp',$data,array('kode_barang'=> $kodebarang,'kode_pelanggan'=>$kodepel));

		    }
		}



		
	}

	function insert_detailreturtmp2(){

		$kodebarang = $this->input->post('kodebarang');
		$jmldus		= $this->input->post('jmldus');
		$hargadus   = $this->input->post('hargadus');
		$jmlpack	= $this->input->post('jmlpack');
		$hargapack	= $this->input->post('hargapack');
		$jmlpcs		= $this->input->post('jmlpcs');
		$hargapcs	= $this->input->post('hargapcs');
		$kodepel 	= $this->input->post('kodepelanggan');
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 	= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 	= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs; 
		$brgtmp 	= $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));
		$brgpnj 	= $this->db->query("SELECT SUM(jumlah) as jumlah FROM detailpenjualan
										INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
										WHERE kode_pelanggan = '$kodepel' AND kode_barang ='$kodebarang' ");
		//$brgrtr 	= $this->db->get_where('detailretur',array('no_fak_penj'=>$nofaktur,'kode_barang'=>$kodebarang));
		//$cekbrgrtr	= $brgrtr->row_array();
		$cekjmlpnj	= $brgpnj->row_array();
		$cekjmlrtr  = $brgtmp->row_array();
		$totjumlah 	= $cekjmlrtr['jumlah'] + $jumlah;


		


			$cektmp 	= $brgtmp->num_rows();
			$brgold 	= $brgtmp->row_array();

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

					'kode_barang' 			=> $kodebarang,
					'jumlah' 	  			=> $jumlah,
					'harga_dus'   			=> $hargadus,
					'harga_pack'  			=> $hargapack,
					'harga_pcs'   			=> $hargapcs,
					'subtotal'    			=> $subtotal,
					'kode_pelanggan' 		=> $kodepel,
					'id_admin'	 			 => $id_admin
				);
			  
				$this->db->insert('detailretur_temp',$data);

		    }else{

		    	 $data  		= array (

					'kode_barang' 		=> $kodebarang,
					'jumlah' 	  		=> $jumlahnew,
					'harga_dus'   		=> $hargadus,
					'harga_pack'  		=> $hargapack,
					'harga_pcs'   		=> $hargapcs,
					'subtotal'    		=> $subtotalnew,
					'kode_pelanggan' 	=> $kodepel,
					'id_admin'	 		=> $id_admin
				);
		    	
				$this->db->update('detailretur_temp',$data,array('kode_barang'=> $kodebarang,'kode_pelanggan'=>$kodepel));

		    }
		



		
	}


	function insert_detailreturgbtmp(){

		$kodebarang = $this->input->post('kodebarang');
		$jmldus		= $this->input->post('jmldus');
		$hargadus   = $this->input->post('hargadus');
		$jmlpack	= $this->input->post('jmlpack');
		$hargapack	= $this->input->post('hargapack');
		$jmlpcs		= $this->input->post('jmlpcs');
		$hargapcs	= $this->input->post('hargapcs');
		$kodepel 	= $this->input->post('kodepelanggan');
		$subtotal 	= ($jmldus * $hargadus) + ($jmlpack * $hargapack) + ($jmlpcs * $hargapcs);
		$id_admin 	= $this->session->userdata('id_user');
		$cekbrg 	= $this->db->get_where('barang',array('kode_barang'=>$kodebarang))->row_array();
		$isipcsdus 	= $cekbrg['isipcsdus'];
		$isipackdus	= $cekbrg['isipack'];
		$isipcspack = $cekbrg['isipcs'];
		$jumlah 	= ($jmldus * $isipcsdus) + ($jmlpack * $isipcspack) + $jmlpcs; 
		$brgtmp 	= $this->db->get_where('detailreturgb_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));
		$brgrtrtmp 	= $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepel,'kode_barang'=>$kodebarang));

		$cekjmlgb 	= $brgtmp->row_array();
		$cekjmlrtr 	= $brgrtrtmp->row_array();
		$totjumlah 	= $cekjmlgb['jumlah'] + $jumlah;

		if($totjumlah > $cekjmlrtr['jumlah']){

			echo "1";
		}elseif($totjumlah < $cekjmlrtr['jumlah']){

			echo "2";
		}else{

			$cektmp 	= $brgtmp->num_rows();
			$brgold 	= $brgtmp->row_array();

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

					'kode_barang' 	 => $kodebarang,
					'jumlah' 	 	 => $jumlah,
					'harga_dus'  	 => $hargadus,
					'harga_pack'     => $hargapack,
					'harga_pcs'   	 => $hargapcs,
					'subtotal'    	 => $subtotal,
					'kode_pelanggan' => $kodepel,
					'id_admin'	  	 => $id_admin
				);
			  	$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
			    $this->db->query($query);
				$this->db->insert('detailreturgb_temp',$data);

		    }else{

		    	 $data  		= array (

					'kode_barang' 	 => $kodebarang,
					'jumlah' 	  	 => $jumlahnew,
					'harga_dus'   	 => $hargadus,
					'harga_pack'  	 => $hargapack,
					'harga_pcs'   	 => $hargapcs,
					'subtotal'    	 => $subtotalnew,
					'kode_pelanggan' => $kodepel,
					'id_admin'	   	 => $id_admin
				);
		    	$query = "UPDATE barang SET stok = stok-$jumlah WHERE kode_barang = '$kodebarang'";
			    $this->db->query($query);
				$this->db->update('detailreturgb_temp',$data,array('kode_barang'=> $kodebarang,'kode_pelanggan'=>$kodepel));

		    }
		}

		
	}


	function hapus_detailreturbrg($kodebarang,$kodepelanggan){
		
		$this->db->delete('detailretur_temp',array('kode_barang'=>$kodebarang,'kode_pelanggan'=>$kodepelanggan));
	}

	function hapus_detailreturgbbrg($kodebarang,$kodepelanggan,$jumlah){
		$query = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kodebarang'";
		$this->db->query($query);
		$this->db->delete('detailreturgb_temp',array('kode_barang'=>$kodebarang,'kode_pelanggan'=>$kodepelanggan));
	}



	function retur_penjualan(){
		$kodepelanggan 	= $this->input->post('kodepelanggan');
		$nofaktur 		= $this->input->post('nofaktur');
		$tglretur 		= $this->input->post('tglretur');
		$jenisretur		= $this->input->post('jenisretur');
		if($jenisretur == "pf"){

			$subtotal_pf 	= $this->input->post('subtotal');
			$subtotal_gb	= 0;
			$total 			= $subtotal_pf + $subtotal_gb;
			$cekfak 		= $this->db->get_where('penjualan',array('no_fak_penj'=>$nofaktur))->row_array();
			if($cekfak['jenistransaksi'] == 'tunai' AND $cekfak['jenisbayar']=='tunai'){

				$updatebayar = $this->db->query("UPDATE historibayar SET bayar= bayar-$total WHERE no_fak_penj = '$nofaktur'");
			}
		}else{

			$subtotal_pf 	= $this->input->post('subtotal');
			$subtotal_gb	= $this->input->post('subtotalgb');
			$total 			= $subtotal_pf - $subtotal_gb;

		}
		
		$id_admin 		= $this->session->userdata('id_user');
		
		$hariini 		= date('ymd');
		$this->db->limit(1);
		$this->db->order_by('no_retur_penj','DESC');
        $ceknolast    = $this->db->get('retur')->row_array();
        $nobuktilast  = $ceknolast['no_retur_penj'];
        $noretur      = buatkode($nobuktilast,'R'.$hariini,3);

        $data = array(
        	'no_retur_penj' => $noretur,
        	'no_fak_penj'	=> $nofaktur,
        	'tglretur'		=> $tglretur,
        	'subtotal_gb'	=> $subtotal_gb,
        	'subtotal_pf'	=> $subtotal_pf,
        	'total'			=> $total,
        	'jenis_retur'	=> $jenisretur,
        	'id_admin'		=> $id_admin
        );

        $retur = $this->db->insert('retur',$data);
        if($retur){

        	$tmp = $this->db->get_where('detailretur_temp',array('id_admin'=>$id_admin,'kode_pelanggan'=>$kodepelanggan))->result();
        	$tmp2 = $this->db->get_where('detailreturgb_temp',array('id_admin'=>$id_admin,'kode_pelanggan'=>$kodepelanggan))->result();
			foreach($tmp as $t){
				$dtmp = array(
					'no_retur_penj'	=>$noretur,
					'no_fak_penj' 	=> $nofaktur,
					'kode_barang' 	=> $t->kode_barang,
					'harga_dus'   	=> $t->harga_dus,
					'harga_pack'  	=> $t->harga_pack,
					'harga_pcs'   	=> $t->harga_pcs,
					'jumlah' 	  	=> $t->jumlah,
					'subtotal' 	  	=> $t->subtotal,
					'id_admin'    	=> $id_admin
				);
				$this->db->insert('detailretur',$dtmp);
			}

			foreach($tmp2 as $t2){
				$dtmp2 = array(
					'no_retur_penj'	=>$noretur,
					'no_fak_penj' 	=> $nofaktur,
					'kode_barang' 	=> $t2->kode_barang,
					'harga_dus'   	=> $t2->harga_dus,
					'harga_pack'  	=> $t2->harga_pack,
					'harga_pcs'   	=> $t2->harga_pcs,
					'jumlah' 	  	=> $t2->jumlah,
					'subtotal' 	  	=> $t2->subtotal,
					'id_admin'    	=> $id_admin
				);
				$this->db->insert('detailreturgb',$dtmp2);
			}
			
			// Hapus Tabel Temporrary
			$this->db->delete('detailretur_temp',array('id_admin'=>$id_admin,'kode_pelanggan'=>$kodepelanggan));
			$this->db->delete('detailreturgb_temp',array('id_admin'=>$id_admin,'kode_pelanggan'=>$kodepelanggan));
        }
	}

	function cekretur($kodepelanggan){

		return $this->db->get_where('detailretur_temp',array('kode_pelanggan'=>$kodepelanggan));

	}

	function cekreturgb($kodepelanggan){

		return $this->db->get_where('detailreturgb_temp',array('kode_pelanggan'=>$kodepelanggan));

	}

	function get_detailpenjualan($nofaktur){

		$this->db->select('no_fak_penj,detailpenjualan.kode_barang,nama_barang,kategori,satuan,stok,harga_returdus,harga_returpack,harga_returpcs,isipcsdus,isipack,isipcs,jumlah,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs,subtotal,promo,id_admin');
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
		$this->db->delete('historibayar',array('no_fak_penj'=>$nofaktur));
		
		

		
	}


	function batalretur($no_retur){

		$detailreturgb = $this->db->get_where('detailreturgb',array('no_retur_penj'=>$no_retur))->result();
    	foreach($detailreturgb as $d){
    		$this->db->query("UPDATE barang SET stok = stok + $d->jumlah WHERE kode_barang = '$d->kode_barang'");
    	}


		$this->db->delete('retur',array('no_retur_penj'=>$no_retur));
		$this->db->delete('detailretur',array('no_retur_penj'=>$no_retur));
		$this->db->delete('detailreturgb',array('no_retur_penj'=>$no_retur));
		$this->db->delete('historibayar',array('no_fak_penj'=>$nofaktur));
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
		
		return $this->db->get_where('barang',array('kode_cabang'=>$kodecabang));
	}

	function editfaktur($nofaktur){

		$no_faktur 			= $this->input->post('no_faktur');
		$tgltransaksi		= $this->input->post('tgltransaksi');
		$sales 				= $this->input->post('sales');
		$jenistransaksi 	= $this->input->post('jenistransaksi');

		$data = array(

			'no_fak_penj' 		=> $no_faktur,
			'tgltransaksi'		=> $tgltransaksi,
			'id_karyawan'		=> $sales,
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




}