<?php
	error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'2',',','.');
	}
	$namabulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	PACIFIC CABANG <?php echo strtoupper($cb['nama_cabang']); ?><br>
	REKAPITULASI PERSEDIAAN BARANG RUSAK<br>
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
<table class="datatable3" style="width:100%" border="1">
	<thead>
		<tr>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL</th>
			<th colspan="2" bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">KETERANGAN</th>
			<th colspan="3" bgcolor="#28a745" style="color:white; font-size:12;">PENERIMAAN</th>
			<th colspan="3" bgcolor="#c7473a" style="color:white; font-size:12;">PENGELUARAN</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">SALDO AKHIR</th>
			<th rowspan="3" bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL INPUT</th>
			<th rowspan="3" bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL UPDATE</th>
		</tr>
		<tr>
			<th bgcolor="#024a75" style="color:white; font-size:12;">REPACK/REJECT</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">LAIN LAIN</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">REJECT PASAR</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">REJECT GUDANG</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">PENYESUAIAN/LAINLAIN</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">KIRIM KE PUSAT</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">REPACK</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">PENYESUAIAN/LAINLAIN</th>
		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="3"></th>
			<th>SALDO AWAL</th>
			<th colspan="6"></th>
			<th style="text-align: right"><?php echo uang($saldoawal); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$saldoakhir 	 			= $saldoawal;
			$total_repack       = 0;
			$totalrejectpasar   = 0;
			$totalrejectgudang  = 0;
			$totalkirimpusat    = 0;
			$totalpeny_in 			= 0;
			$totalpeny 					= 0;
			foreach($mutasi as $m){
				if($m->jenis_mutasi == "REJECT GUDANG"){
					$no_reject     = $m->no_mutasi_gudang_cabang;
					$no_lainlain   = "";
					$jml_kirimpusat= "";
					$jmlrj_gudang  = $m->jumlah/$m->isipcsdus;
					$jmlrj_pasar   = "";
					$jml_repack    = "";
					$ket 		   		 = "REJECT GUDANG";
					$jml_penybad	 = "";
					$jml_penybad_in = "";
				}else if($m->jenis_mutasi == "REJECT PASAR"){
					$no_reject      = $m->no_mutasi_gudang_cabang;
					$no_lainlain    = $m->no_dpb;
					$jmlrj_gudang   = "";
					$jml_kirimpusat = "";
					$jmlrj_pasar    = $m->jumlah/$m->isipcsdus;
					$jml_repack     = "";
					$ket 		   		  = "REJECT PASAR";
					$jml_penybad	  = "";
					$jml_penybad_in = "";
				}else if($m->jenis_mutasi == "REPACK"){
					$no_reject     = $m->no_mutasi_gudang_cabang;
					$no_lainlain   = "";
					$jml_kirimpusat= "";
					$jmlrj_gudang  = "";
					$jmlrj_pasar   = "";
					$jml_repack    = $m->jumlah/$m->isipcsdus;
					$jml_penybad	 = "";
					$jml_penybad_in = "";
					$ket 		   		 = "REPACK";
				}else if($m->jenis_mutasi == "KIRIM PUSAT"){
					$no_reject     = "";
					$no_lainlain   = $m->no_mutasi_gudang_cabang;
					$jml_kirimpusat= $m->jumlah/$m->isipcsdus;
					$jmlrj_gudang  = "";
					$jmlrj_pasar   = "";
					$jml_repack    = "";
					$jml_penybad	 = "";
					$jml_penybad_in = "";
					$ket 		  		 = "PENYERAHAN BS KE PUSAT";
				}else if($m->jenis_mutasi == "PENYESUAIAN BAD"){
					$no_reject     = "";
					$no_lainlain   = $m->no_mutasi_gudang_cabang;
					$jml_kirimpusat= "";
					if($m->inout_bad =="OUT"){
						$jml_penybad 	 	= $m->jumlah/$m->isipcsdus;
						$jml_penybad_in = "";
					}else{
						$jml_penybad 	 	= "";
						$jml_penybad_in = $m->jumlah/$m->isipcsdus;
					}

					$jmlrj_gudang  = "";
					$jmlrj_pasar   = "";
					$jml_repack    = "";
					$ket 		  		 = "PENYESUAIAN BAD STOK";
				}else{
					$no_reject     = "";
					$no_lainlain   = "";
					$jml_kirimpusat= "";
					$jmlrj_gudang  = "";
					$jmlrj_pasar   = "";
					$jml_repack    = "";
					$ket 		   		 = "";
				}

				if($m->inout_bad=='IN'){
					$jumlah  = ($m->jumlah / $m->isipcsdus);
					$color_sa= "#28a745";
				}else{
					$jumlah  = -($m->jumlah / $m->isipcsdus);
					$color_sa= "#c7473a";
				}

				$saldoakhir 	 			= $saldoakhir + $jumlah;
				$total_repack				= $total_repack + $jml_repack;
				$totalrejectpasar   = $totalrejectpasar + $jmlrj_pasar;
				$totalrejectgudang  = $totalrejectgudang + $jmlrj_gudang;
				$totalkirimpusat    = $totalkirimpusat + $jml_kirimpusat;
				$totalpeny_in 			= $totalpeny_in + $jml_penybad_in;
				$totalpeny 					= $totalpeny + $jml_penybad;
		?>
			<tr style="font-weight: bold; font-size:11px">
				<td><?php echo DateToIndo2($m->tgl_mutasi_gudang_cabang); ?></td>
				<td><?php echo $no_reject; ?></td>
				<td><?php echo $no_lainlain; ?></td>
				<td><?php echo $ket; ?></td>
				<td align="right" ><?php echo uang($jmlrj_pasar); ?></td>
				<td align="right" ><?php echo uang($jmlrj_gudang); ?></td>
				<td align="right" ><?php echo uang($jml_penybad_in); ?></td>
				<td align="right" ><?php echo uang($jml_kirimpusat); ?></td>
				<td align="right" ><?php echo uang($jml_repack); ?></td>
				<td align="right" ><?php echo uang($jml_penybad); ?></td>
				<td align="right" bgcolor="<?php echo $color_sa; ?>"><?php echo uang($saldoakhir); ?></td>
				<td align="right" bgcolor="<?php echo $color_sa; ?>"><?php echo $m->date_created; ?></td>
				<td align="right" bgcolor="<?php echo $color_sa; ?>"><?php echo $m->date_updated; ?></td>



			</tr>
		<?php
		}
		?>
	<tfoot>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="4">TOTAL</th>
			<th style="text-align: right"><?php echo uang($totalrejectpasar); ?></th>
			<th style="text-align: right"><?php echo uang($totalrejectgudang); ?></th>
			<th style="text-align: right"><?php echo uang($totalpeny_in); ?></th>
			<th style="text-align: right"><?php echo uang($totalkirimpusat); ?></th>
			<th style="text-align: right"><?php echo uang($total_repack); ?></th>
			<th style="text-align: right"><?php echo uang($totalpeny); ?></th>
			<th style="text-align: right"><?php echo uang($saldoakhir); ?></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
</table>
