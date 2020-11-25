<?php
	
	function uang($nilai){

		return number_format($nilai,'0','','.');
	}
	error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	LAPORAN MUTASI HASIL PRODUKSI<br>
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
<table class="datatable3" style="width:80%" border="1">
	<thead>
		<tr>
			
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">Tanggal</th>
			<th colspan="3" bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
			<th colspan="2" bgcolor="#28a745" style="color:white; font-size:12;">IN</th>
			<th colspan="2" bgcolor="#c7473a" style="color:white; font-size:12;">OUT</th>
			<th rowspan="2" rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">SALDO AKHIR</th>			
		</tr>
		<tr>
			<th bgcolor="#024a75" style="color:white; font-size:12;">BPBJ</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">FSTHP</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">LAIN LAIN</th>
			<th bgcolor="#28a745" style="color:white; font-size:12; width:200px" >BARANG HASIL PRODUKSI</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">LAINNYA</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">GUDANG</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">LAINNYA</th>
		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="4">SALDO AWAL</th>
			<th colspan="4"></th>
			<th style="text-align: right"><?php echo uang($saldoawal); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$saldoakhir 	= $saldoawal;
			$totalbpbj 		= 0;
			$totalfsthp 	= 0;
			$totalmutasiin  = 0;
			$totalmutasiout = 0;
			foreach ($mutasi as $m){

				if($m->jenis_mutasi=="BPBJ"){

					$no_bpbj = $m->no_mutasi_produksi;
					$jmlbpbj = $m->jumlah;

				}else{

					$no_bpbj = "";
					$jmlbpbj = "";
				}


				if($m->jenis_mutasi=="FSTHP"){

					$no_fsthp = $m->no_mutasi_produksi;
					$jmlfsthp = $m->jumlah;
				}else{

					$no_fsthp = "";
					$jmlfsthp = "";
				}

				if($m->jenis_mutasi=="LAIN-LAIN" AND $m->inout=="IN"){

					$no_mutasi 	 	 = $m->no_mutasi_produksi;
					$jmlmutasiin 	 = $m->jumlah;
				}else if($m->jenis_mutasi=="LAIN-LAIN" AND $m->inout=="OUT"){

					$no_mutasi 		= $m->no_mutasi_produksi;
					$jmlmutasiout 	= $m->jumlah;
				}else{

					$no_mutasi     = "";
					$jmlmutasiin   = "";
					$jmlmutasiout  = "";
				}




				if($m->inout=='IN'){
					$jumlah  = $m->jumlah;
				}else{
					$jumlah = -$m->jumlah;
				}

				$saldoakhir 	= $saldoakhir + $jumlah;
				$totalbpbj		= $totalbpbj + $jmlbpbj;
				$totalfsthp 	= $totalfsthp + $jmlfsthp;
				$totalmutasiin	= $totalmutasiin + $jmlmutasiin;
				$totalmutasiout = $totalmutasiout + $jmlmutasiout;


		?>
			<tr style="font-weight: bold; font-size:11px">
				<td><?php echo DateToIndo2($m->tgl_mutasi_produksi); ?></td>
				<td><?php echo $no_bpbj; ?></td>
				<td><?php echo $no_fsthp; ?></td>
				<td><?php echo $no_mutasi; ?></td>
				<td align="right"><?php echo uang($jmlbpbj); ?></td>
				<td align="right"><?php echo uang($jmlmutasiin); ?></td>
				<td align="right"><?php echo uang($jmlfsthp); ?></td>
				<td align="right"><?php echo uang($jmlmutasiout); ?></td>
				<td align="right"><?php echo uang($saldoakhir); ?></td>
			</tr>
		<?php
			}
		?>
	</tbody>
	<tfoot bgcolor="#024a75" style="color:white; font-size:12;">
		<tr>
			<th colspan="4">TOTAL</th>
			<th style="text-align: right"><?php echo uang($totalbpbj); ?></th>
			<th style="text-align: right"><?php echo uang($totalmutasiin); ?></th>
			<th style="text-align: right"><?php echo uang($totalfsthp); ?></th>
			<th style="text-align: right"><?php echo uang($totalmutasiout); ?></th>
			<th style="text-align: right"><?php echo uang($saldoakhir); ?></th>
		</tr>
	</tfoot>
</table>