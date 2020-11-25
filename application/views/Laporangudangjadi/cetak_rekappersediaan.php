<?php

function uang($nilai)
{

	return number_format($nilai, '0', '', '.');
}
error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	REKAPITULASI PERSEDIAAN GUDANG BARANG JADI<br>
	PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br><br>

</b>
<br>
<table class="datatable3" style="width:80%" border="1">
	<thead>
		<tr>

			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">No</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">Barang/Produk</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">Saldo Awal</th>
			<th colspan="3" bgcolor="#28a745" style="color:white; font-size:12;">PENERIMAAN</th>
			<th colspan="3" bgcolor="#c7473a" style="color:white; font-size:12;">PENGELUARAN</th>
			<th rowspan="2" rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">SALDO AKHIR</th>
		</tr>
		<tr>
			<th bgcolor="#28a745" style="color:white; font-size:12;">PRODUKSI</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">REPACK</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">LAIN LAIN</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">KIRIM KE CABANG</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">REJECT</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">LAIN LAIN</th>
		</tr>

	</thead>
	<tbody>
		<?php

		$no = 1;
		$totalsaldoawal  = 0;
		$totalsuratjalan = 0;
		$totalfsthp 	 = 0;
		$totlarepack     = 0;
		$totallainlain_in     = 0;
		$totalreject  	 = 0;
		$totallainlain_out  	 = 0;
		$totalsaldoakhir = 0;
		foreach ($mutasi as $m) {

			$saldoakhir 		= $m->saldoawal + ($m->jmlfsthp + $m->jmlrepack + $m->jmllainlain_in) - ($m->jmlsuratjalan + $m->jmlreject + $m->jmllainlain_out);
			$totalsaldoawal		= $totalsaldoawal + $m->saldoawal;
			$totalsuratjalan 	= $totalsuratjalan + $m->jmlsuratjalan;
			$totalfsthp 		= $totalfsthp + $m->jmlfsthp;
			$totlarepack 		= $totlarepack + $m->jmlrepack;
			$totallainlain_in 		= $totallainlain_in + $m->jmllainlain_in;
			$totallainlain_out 		= $totallainlain_out + $m->jmllainlain_out;
			$totalreject 		= $totalreject + $m->jmlreject;
			$totalsaldoakhir 	= $totalsaldoakhir + $saldoakhir;

		?>
			<tr style="font-weight: bold; font-size:11px">
				<td><?php echo $no; ?></td>
				<td><?php echo $m->nama_barang; ?></td>
				<td align="right"><?php if ($m->saldoawal != 0) {
														echo uang($m->saldoawal);
													} ?></td>
				<td align="right"><?php if ($m->jmlfsthp != 0) {
														echo uang($m->jmlfsthp);
													} ?></td>
				<td align="right"><?php if ($m->jmlrepack != 0) {
														echo uang($m->jmlrepack);
													} ?></td>
				<td align="right"><?php if ($m->jmllainlain_in != 0) {
														echo uang($m->jmllainlain_in);
													} ?></td>
				<td align="right"><?php if ($m->jmlsuratjalan != 0) {
														echo uang($m->jmlsuratjalan);
													} ?></td>
				<td align="right"><?php if ($m->jmlreject != 0) {
														echo uang($m->jmlreject);
													} ?></td>
				<td align="right"><?php if ($m->jmllainlain_out != 0) {
														echo uang($m->jmllainlain_out);
													} ?></td>
				<td align="right"><?php echo uang($saldoakhir);  ?></td>
			</tr>
		<?php $no++;
		} ?>
	</tbody>
	<tfoot bgcolor="#024a75" style="color:white; font-size:12;">
		<tr>
			<th colspan="2">TOTAL</th>
			<th style="text-align: right"><?php echo uang($totalsaldoawal); ?></th>
			<th style="text-align: right"><?php echo uang($totalfsthp); ?></th>
			<th style="text-align: right"><?php echo uang($totlarepack); ?></th>
			<th style="text-align: right"><?php echo uang($totallainlain_in); ?></th>
			<th style="text-align: right"><?php echo uang($totalsuratjalan); ?></th>
			<th style="text-align: right"><?php echo uang($totalreject); ?></th>
			<th style="text-align: right"><?php echo uang($totallainlain_out); ?></th>
			<th style="text-align: right"><?php echo uang($totalsaldoakhir); ?></th>
		</tr>
	</tfoot>
</table>