<?php

	function uang($nilai){

		return number_format($nilai,'0','','.');
	}
	error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	REKAPITULASI MUTASI HASIL PRODUKSI<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br><br>

</b>
<br>
<table class="datatable3" style="width:80%" border="1">
	<thead>
		<tr>

			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">No</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">Barang/Produk</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">Saldo Awal</th>
			<th colspan="2" bgcolor="#28a745" style="color:white; font-size:12;">IN</th>
			<th colspan="2" bgcolor="#c7473a" style="color:white; font-size:12;">OUT</th>
			<th rowspan="2" rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">SALDO AKHIR</th>
		</tr>
		<tr>
			<th bgcolor="#28a745" style="color:white; font-size:12; width:200px" >BARANG HASIL PRODUKSI</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">LAINNYA</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">GUDANG</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">LAINNYA</th>
		</tr>

	</thead>
	<tbody>
		<?php

			$no=1;
			$totalsaldoawal  = 0;
			$totalbpbj		 = 0;
			$totalfsthp 	 = 0;
			$totalmutasiin   = 0;
			$totalmutasiout  = 0;
			$totalsaldoakhir = 0;
			foreach ($mutasi as $m){

			$saldoakhir 		= $m->saldoawal + ($m->jmlbpbj + $m->mutasi_in) - ($m->jmlfsthp + $m->mutasi_out);
			$totalsaldoawal		= $totalsaldoawal + $m->saldoawal;
			$totalbpbj 			= $totalbpbj + $m->jmlbpbj;
			$totalfsthp 		= $totalfsthp + $m->jmlfsthp;
			$totalmutasiin 		= $totalmutasiin + $m->mutasi_in;
			$totalmutasiout 	= $totalmutasiout + $m->mutasi_out;
			$totalsaldoakhir 	= $totalsaldoakhir + $saldoakhir;

		?>
			<tr style="font-weight: bold; font-size:11px">
				<td><?php echo $no; ?></td>
				<td><?php echo $m->nama_barang; ?></td>
				<td align="right"><?php if($m->saldoawal !=0){echo uang($m->saldoawal); } ?></td>
				<td align="right"><?php if($m->jmlbpbj !=0){echo uang($m->jmlbpbj); } ?></td>
				<td align="right"><?php if($m->mutasi_in !=0){echo uang($m->mutasi_in); } ?></td>
				<td align="right"><?php if($m->jmlfsthp !=0){echo uang($m->jmlfsthp); } ?></td>
				<td align="right"><?php if($m->mutasi_out !=0){echo uang($m->mutasi_out); } ?></td>
				<td align="right"><?php echo uang($saldoakhir);  ?></td>
			</tr>
		<?php $no++; } ?>
	</tbody>
	<tfoot bgcolor="#024a75" style="color:white; font-size:12;">
		<tr>
			<th colspan="2">TOTAL</th>
			<th style="text-align: right"><?php echo uang($totalsaldoawal); ?></th>
			<th style="text-align: right"><?php echo uang($totalbpbj); ?></th>
			<th style="text-align: right"><?php echo uang($totalmutasiin); ?></th>
			<th style="text-align: right"><?php echo uang($totalfsthp); ?></th>
			<th style="text-align: right"><?php echo uang($totalmutasiout); ?></th>
			<th style="text-align: right"><?php echo uang($totalsaldoakhir); ?></th>
		</tr>
	</tfoot>
</table>
