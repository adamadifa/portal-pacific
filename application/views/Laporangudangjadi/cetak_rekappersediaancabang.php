<?php

	function uang($nilai){

		return number_format($nilai,'2',',','.');
	}
	error_reporting(0);
	$namabulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");


?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	PACIFIC CABANG <?php echo strtoupper($cb['nama_cabang']); ?><br>
	REKAPITULASI PERSEDIAAN BARANG<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br><br>
	<table>
		<tr>
			<td><b>KODE PRODUK</b></td>
			<td>:</td>
			<td><b><?php echo $produk['kode_produk']; ?></b></td>
		</tr>
		<tr>
			<td><b>PRODUK</b></td>
			<td>:</td>
			<td><b><?php echo $produk['nama_barang']; ?></b></td>
		</tr>
	</table>
</b>
<br>
<table class="datatable3" style="width:150%" border="1">
	<thead>
		<tr>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL</th>
			<th colspan="3" bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">SALESMAN</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">PELANGGAN</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">KETERANGAN</th>
			<th colspan="6" bgcolor="#28a745" style="color:white; font-size:12;">PENERIMAAN</th>
			<th colspan="7" bgcolor="#c7473a" style="color:white; font-size:12;">PENGELUARAN</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">SALDO AKHIR</th>
			<th rowspan="3" bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL INPUT</th>
			<th rowspan="3" bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL UPDATE</th>
		</tr>
		<tr>
			<th bgcolor="#024a75" style="color:white; font-size:12;">SURAT JALAN</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">TGL KIRIM</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">NO BUKTI</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">PUSAT</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">TRANSIT IN</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">RETUR</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">LAIN LAIN</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">REPACK</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">PENYESUAIAN</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">PENJUALAN</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">PROMOSI</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">REJECT PASAR</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">REJECT GUDANG</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">TRANSIT OUT</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">LAIN LAIN</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">PENYESUAIAN</th>
		</tr>

		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="5"></th>
			<th>SALDO AWAL</th>
			<th colspan="14"></th>
			<th style="text-align: right"><?php echo uang($saldoawal); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$saldoakhir 	 			= $saldoawal;
			$totalsuratjalan 		= 0;
			$total_tin       		= 0;
			$total_retur     		= 0;
			$total_lainlain_in  = 0;
			$total_repack       = 0;
			$totalpenjualan     = 0;
			$totalpromosi       = 0;
			$totalrejectpasar   = 0;
			$totalrejectgudang  = 0;
			$total_to           = 0;
			$total_lainlain_out = 0;
			foreach($mutasi as $m){
				if($m->jenis_mutasi == "SURAT JALAN"){
					$no_suratjalan 	=  $m->no_mutasi_gudang_cabang;
					$no_bukti     	= "";
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= "";
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= $m->jumlah / $m->isipcsdus;
					$jml_to        	= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	= "";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= $m->tgl_kirim;
					$ket 		   			= "PENERIMAAN PUSAT";
					$q_to 		   		= "SELECT * FROM detail_mutasi_gudang_cabang
													  INNER JOIN mutasi_gudang_cabang
													  ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
													  WHERE jenis_mutasi = 'TRANSIT OUT'
													  AND no_suratjalan='$no_suratjalan' AND kode_produk ='$produk[kode_produk]'
													  ";
					$to 	   	   		= $this->db->query($q_to);
					$cek_to 	   		= $to->num_rows();
					if(!empty($cek_to)){
						$color_sj = "#23a7e0";
					}
					$color_tin 	   = "";
					$color_to 	   = "";
					$color_promo   = "";
					$color_hk      = "";
					$color_lain    = "";
				}else if($m->jenis_mutasi=="TRANSIT OUT"){
					$no_suratjalan 	= $m->no_suratjalan;
					$no_bukti     	= "";
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= "";
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj   	   		= "";
					$tgl_kirimsj   	= $m->tgl_kirim;
					$jml_to 	   		= $m->jumlah / $m->isipcsdus;
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	="";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$ket 		   			= "TRANSIT OUT <b style='color:#23a7e0'>". $no_suratjalan."</b>";
					$color_sj      	= "";
					$color_to 	   	= "#23a7e0";
					$color_tin     	= "";
					$color_promo   	= "";
					$color_hk      	= "";
					$color_lain    	= "";
				}else if($m->jenis_mutasi == "TRANSIT IN"){
					$no_suratjalan 	= $m->no_suratjalan;
					$no_bukti     	= "";
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= "";
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= $m->jumlah / $m->isipcsdus;
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain    = "";
					$jmllainlain_in	="";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= $m->tgl_kirim;
					$ket 		   			= "TRANSIT IN <b style='color:#23a7e0'>". $no_suratjalan."</b>";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "#23a7e0";
					$color_promo   	="";
					$color_hk      	= "";
					$color_lain    	= "";
				}else if($m->jenis_mutasi == "PENJUALAN"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= $m->nama_karyawan;
					$jmlrj_gudang 	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan   = $m->jumlah/$m->isipcsdus;
					$jmlpromo       = "";
					$ket 		   		  = $m->jenis_mutasi;
					$color_promo    = "";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= "";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_hk      	= "";
					$color_lain    	= "";

				}else if($m->jenis_mutasi == "PROMOSI"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= $m->nama_karyawan;
					$jmlrj_gudang 	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan   = "";
					$jmlpromo       = $m->jumlah/$m->isipcsdus;
					$ket 		   		  = $m->jenis_mutasi;
					$color_promo    = "yellow";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= "";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_hk      	= "";
					$color_lain    	= "";

				}else if($m->jenis_mutasi == "RETUR"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= $m->nama_karyawan;
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= $m->jumlah/$m->isipcsdus;
					$jmllainlain    = "";
					$jmllainlain_in	="";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= "";
					$ket 		   			= "RETUR";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_promo   	="";
					$color_hk      	= "";
					$color_lain    	= "";
				}else if($m->jenis_mutasi == "GANTI BARANG"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= $m->nama_karyawan;
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain    = $m->jumlah / $m->isipcsdus;
					$jmllainlain_in	= "";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= "";
					$ket 		   			= "GANTI BARANG";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_promo   	= "";
					$color_hk      	= "";
					$color_lain    	= "";
				}else if($m->jenis_mutasi == "HUTANG KIRIM"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	    = $m->nama_karyawan;
					$jmlrj_gudang   = "";
					$jmlrj_pasar    = "";
					$jml_repack     = "";
					$pelanggan      = "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur     	= "";
					$jmllainlain   	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$jmllainlain_in	= $m->jumlah / $m->isipcsdus;
					$jmllainlain   	= "";
					$ket 		   			= "HUTANG KIRIM";
					$color_hk      	= "#ba1d1d";
					$color_lain    	= "";
					$jmlpromo      	= "";
					$tgl_kirimsj   	= "";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_promo   	= "";
				}else if($m->jenis_mutasi == "PL HUTANG KIRIM"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	    = $m->nama_karyawan;
					$jmlrj_gudang   = "";
					$jmlrj_pasar    = "";
					$jml_repack     = "";
					$pelanggan      = "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur     	= "";
					$jmllainlain   	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$jmllainlain_in	= "";
					$jmllainlain   	= $m->jumlah / $m->isipcsdus;
					$ket 		   			= "PELUNASAN HUTANG KIRIM";
					$color_hk      	= "";
					$color_lain    	= "#ba1d1d";
					$jmlpromo      		= "";
					$tgl_kirimsj   		= "";
					$color_sj      		= "";
					$color_to      		= "";
					$color_tin 	   		= "";
					$color_promo   		= "";

				}else if($m->jenis_mutasi == "PENYESUAIAN BAD"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_mutasi_gudang_cabang;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	    = "";
					$jmlrj_gudang   = "";
					$jmlrj_pasar    = "";
					$jml_repack     = "";
					$pelanggan      = "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur     	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$jmllainlain_in	= $m->jumlah / $m->isipcsdus;
					$jmllainlain   	= "";
					$ket 		   			= "PENERIMAAN LAIN LAIN DARI BAD STOK";
					$color_hk      	= "";
					$color_lain    	= "";
					$jmlpromo      	= "";
					$tgl_kirimsj   	= "";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_promo   	= "";

				}else if($m->jenis_mutasi == "TTR"){
					$no_suratjalan 	= "";
					$no_bukti				= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= $m->nama_karyawan;
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= $m->kode_pelanggan;
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmlpromo       = "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj    = "";
					$ket 		   		  = "TTR";
					$color_sj       = "";
					$color_to       = "";
					$color_tin 	    = "";
					$color_promo    ="";
					$color_hk       = "";
					$jmllainlain_in = "";
					$jmllainlain   	= $m->jumlah / $m->isipcsdus;
					$color_hk 	   	= "";
					$color_lain    	= "e59a04";
				}else if($m->jenis_mutasi == "PL TTR"){
					$no_suratjalan 	= "";
					$no_bukti				= $m->no_dpb;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= $m->nama_karyawan;
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= $m->kode_pelanggan;
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmlpromo       = "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj    = "";
					$ket 		   		  = "PELUNASAN TTR";
					$color_sj       = "";
					$color_to       = "";
					$color_tin 	    = "";
					$color_promo    ="";
					$jmllainlain_in = $m->jumlah / $m->isipcsdus;
					$jmllainlain   	= "";
					$color_hk 	   	= "e59a04";
					$color_lain    	= "";
				}else if($m->jenis_mutasi == "REJECT GUDANG"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_mutasi_gudang_cabang;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= "";
					$jmlrj_gudang  	= $m->jumlah/$m->isipcsdus;
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	="";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= "";
					$ket 		   			= "REJECT GUDANG <b style='color:#23a7e0'>". $m->no_suratjalan."</b>";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_promo   	= "";
					$color_hk      	= "";
					$color_lain    	= "";
				}else if($m->jenis_mutasi == "REJECT PASAR"){
					$no_suratjalan	 = "";
					$no_bukti     	 = $m->no_dpb;
					$no_lainlain   	 = "";
					$no_penyesuaian	 = "";
					$no_dpb 	   		 = "";
					$salesman 	   	 = $m->nama_karyawan;
					$jmlrj_gudang  	 = "";
					$jmlrj_pasar   	 = $m->jumlah/$m->isipcsdus;
					$jml_repack    	 = "";
					$pelanggan     	 = "";
					$jmlsj 		   	   = "";
					$jml_to 	   		 = "";
					$jml_tin       	 = "";
					$jmlpenjualan  	 = "";
					$jmlretur      	 = "";
					$jmllainlain   	 = "";
					$jmllainlain_in	 = "";
					$jmlpromo      	 = "";
					$jmlpeny 				 = "";
					$jmlpeny_in			 = "";
					$tgl_kirimsj   	 = "";
					$ket 		   		   = "REJECT PASAR";
					$color_sj        = "";
					$color_to        = "";
					$color_tin 	     = "";
					$color_promo     ="";
					$color_hk        = "";
					$color_lain      = "";
				}else if($m->jenis_mutasi == "REPACK"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_mutasi_gudang_cabang;
					$no_lainlain   	= "";
					$no_penyesuaian = "";
					$no_dpb 	   		= "";
					$salesman 	   	= "";
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= $m->jumlah / $m->isipcsdus;
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	="";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= "";
					$ket 		   			= "REPACK";
					$color_sj      	= "";
					$color_to      	= "";
					$color_tin 	   	= "";
					$color_promo   	="";
					$color_hk      	= "";
					$color_lain    	= "";

				}else if($m->jenis_mutasi == "PENYESUAIAN"){
					$no_suratjalan 	= "";
					$no_bukti     	= $m->no_mutasi_gudang_cabang;;
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= "";
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj 		   		= "";
					$jml_to 	   		= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	= "";
					if($m->inout_good =='OUT'){
						$jmlpeny   	= $m->jumlah / $m->isipcsdus;
						$jmlpeny_in	="";
					}else{
						$jmlpeny   	= "";
						$jmlpeny_in = $m->jumlah / $m->isipcsdus;
					}

					$jmlpromo      = "";
					$tgl_kirimsj   = "";
					$ket 		   		 = "PENYESUAIAN";
					$color_sj      = "";
					$color_to      = "";
					$color_tin 	   = "";
					$color_promo   ="";
					$color_hk      = "";
					$color_lain    = "";

				}else{

					$no_suratjalan 	= "";
					$no_bukti     	= "";
					$no_lainlain   	= "";
					$no_penyesuaian	= "";
					$no_dpb 	   		= "";
					$salesman 	   	= "";
					$jmlrj_gudang  	= "";
					$jmlrj_pasar   	= "";
					$jml_repack    	= "";
					$pelanggan     	= "";
					$jmlsj         	= "";
					$jml_to        	= "";
					$jml_tin       	= "";
					$jmlpenjualan  	= "";
					$jmlretur      	= "";
					$jmllainlain   	= "";
					$jmllainlain_in	= "";
					$jmlpromo      	= "";
					$jmlpeny 				= "";
					$jmlpeny_in			= "";
					$tgl_kirimsj   	= "";
					$ket 		   			= "";
					$color_sj 	   	= "";
					$color_to      	= "";
					$color_tin     	= "";
					$color_promo   	= "";
					$color_hk      	= "";
					$color_lain    	= "";
				}



				if($m->inout_good=='IN'){
					$jumlah  	= ($m->jumlah / $m->isipcsdus);
					$color_sa = "#28a745";
				}else{
					$jumlah = -($m->jumlah / $m->isipcsdus);
					$color_sa= "#c7473a";
				}

				$saldoakhir 	 			= $saldoakhir + $jumlah;
				$totalsuratjalan 		= $totalsuratjalan + $jmlsj;
				$total_tin       		= $total_tin + $jml_tin;
				$total_retur     		= $total_retur + $jmlretur;
				$total_lainlain_in 	= $total_lainlain_in + $jmllainlain_in;
				$total_repack				= $total_repack + $jml_repack;
				$totalpeny_in				= $totalpeny_in + $jmlpeny_in;
				$totalpeny 					= $totalpeny + $jmlpeny;
				$totalpenjualan     = $totalpenjualan + $jmlpenjualan;
				$totalpromosi       = $totalpromosi + $jmlpromo;
				$totalrejectpasar   = $totalrejectpasar + $jmlrj_pasar;
				$totalrejectgudang  = $totalrejectgudang + $jmlrj_gudang;
				$total_to           = $total_to + $jml_to;
				$total_lainlain_out = $total_lainlain_out + $jmllainlain;
		?>
			<tr style="font-weight: bold; font-size:11px">
				<td><?php echo DateToIndo2($m->tgl_mutasi_gudang_cabang); ?></td>
				<td><?php echo $no_suratjalan; ?></td>
				<td><?php if(!empty($tgl_kirimsj) OR $tgl_kirimsj != '0000-00-00'){echo DateToIndo2($tgl_kirimsj); } ?></td>
				<td><?php echo $no_bukti; ?></td>
				<td><?php echo $salesman; ?></td>
				<td><?php echo $nama_pelanggan; ?></td>
				<td><?php echo $ket; ?></td>
				<td align="right" bgcolor="<?php echo $color_sj; ?>"><?php echo uang($jmlsj); ?></td>
				<td align="right" bgcolor="<?php echo $color_tin; ?>"><?php echo uang($jml_tin); ?></td>
				<td align="right" ><?php echo uang($jmlretur); ?></td>
				<td align="right" bgcolor="<?php echo $color_hk; ?>"><?php echo uang($jmllainlain_in); ?></td>
				<td align="right" ><?php echo uang($jml_repack); ?></td>
				<td align="right" bgcolor=""><?php echo uang($jmlpeny_in); ?></td>
				<td align="right" ><?php echo uang($jmlpenjualan); ?></td>
				<td align="right" bgcolor="<?php echo $color_promo; ?>"><?php echo uang($jmlpromo); ?></td>
				<td align="right" ><?php echo uang($jmlrj_pasar); ?></td>
				<td align="right" ><?php echo uang($jmlrj_gudang); ?></td>
				<td align="right" bgcolor="<?php echo $color_to; ?>"><?php echo uang($jml_to); ?></td>
				<td align="right" bgcolor="<?php echo $color_lain; ?>" ><?php echo uang($jmllainlain); ?></td>
				<td align="right" bgcolor=""><?php echo uang($jmlpeny); ?></td>
				<td align="right" bgcolor="<?php echo $color_sa; ?>"><?php echo uang($saldoakhir); ?></td>
				<td align="right" bgcolor="<?php echo $color_sa; ?>"><?php echo $m->date_created; ?></td>
				<td align="right" bgcolor="<?php echo $color_sa; ?>"><?php echo $m->date_updated; ?></td>
			</tr>
		<?php
		}
		?>

	</tbody>
	<tfoot>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="7">TOTAL</th>
			<th style="text-align: right"><?php echo uang($totalsuratjalan); ?></th>
			<th style="text-align: right"><?php echo uang($total_tin); ?></th>
			<th style="text-align: right"><?php echo uang($total_retur); ?></th>
			<th style="text-align: right"><?php echo uang($total_lainlain_in); ?></th>
			<th style="text-align: right"><?php echo uang($total_repack); ?></th>
			<th style="text-align: right"><?php echo uang($totalpeny_in); ?></th>
			<th style="text-align: right"><?php echo uang($totalpenjualan); ?></th>
			<th style="text-align: right"><?php echo uang($totalpromosi); ?></th>
			<th style="text-align: right"><?php echo uang($totalrejectpasar); ?></th>
			<th style="text-align: right"><?php echo uang($totalrejectgudang); ?></th>
			<th style="text-align: right"><?php echo uang($total_to); ?></th>
			<th style="text-align: right"><?php echo uang($total_lainlain_out); ?></th>
			<th style="text-align: right"><?php echo uang($totalpeny); ?></th>
			<th style="text-align: right"><?php echo uang($saldoakhir); ?></th>
			<td></td>
			<td></td>
		</tr>
	</tfoot>
</table>
