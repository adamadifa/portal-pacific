<?php
error_reporting(0);
function uang($nilai)
{
	return number_format($nilai, '2', ',', '.');
}

function angka($nilai)
{
	return number_format($nilai, '2', ',', '.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
	KARTU HUTANG <br>
	PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
	<?php
	if ($supplier != "") {
		echo "SUPPLIER : " . strtoupper($supp['nama_supplier']);
	} else {
		echo "ALL SUPPLIER";
	}
	?>
</b>
<br>
<br>
<table class="datatable3" style="width:100%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
			<td>NO</td>
			<td>TGL</td>
			<td>NO BUKTI</td>
			<td>SUPPLIER</td>
			<td>AKUN</td>
			<!-- <td>TOTAL HUTANG</td>
			<td>BAYAR BULAN LALU</td>
			<td>PENY BULAN LALU</td> -->
			<td>SALDO AWAL</td>
			<td>PEMBELIAN</td>
			<td>PENYESUAIAN</td>
			<td>PEMBAYARAN</td>
			<td>SALDO AKHIR</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$totalsaldoawal = 0;
		$totalsaldoakhir = 0;
		$totalpembelian = 0;
		$totalpenyesuaian = 0;
		$totalpembayaran = 0;
		$no = 1;
		foreach ($pmb as $d) {
			if ($d->tgl_pembelian < $dari) {
				$saldoawal = $d->sisapiutang;
			} else {
				$saldoawal = 0;
			}
			$saldoakhir = $d->totalhutang - $d->jmlbayarbulanlalu - $d->jmlbayarbulanini;
			$totalsaldoawal += $saldoawal;
			$totalsaldoakhir += $saldoakhir;
			$totalpembelian += $d->pmbbulanini;
			$totalpenyesuaian += $d->penyesuaianbulanini;
			$totalpembayaran += $d->jmlbayarbulanini;
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo DateToIndo2($d->tgl_pembelian); ?></td>
				<td><?php echo $d->nobukti_pembelian; ?></td>
				<td><?php echo $d->nama_supplier; ?></td>
				<td><?php echo $d->nama_akun; ?></td>
				<!-- <td><?php echo $d->totalhutang; ?></td>
				<td><?php echo $d->jmlbayarbulanlalu; ?></td>

				<td><?php echo $d->penyesuaianbulanlalu; ?></td> -->
				<td align="right"><?php if (!empty($saldoawal)) {
														echo uang($saldoawal);
													} ?></td>
				<td align="right"><?php if (!empty($d->pmbbulanini)) {
														echo uang($d->pmbbulanini);
													} ?></td>
				<td align="right"><?php if (!empty($d->penyesuaianbulanini)) {
														echo uang($d->penyesuaianbulanini);
													} ?></td>
				<td align="right"><?php if (!empty($d->jmlbayarbulanini)) {
														echo uang($d->jmlbayarbulanini);
													} ?></td>
				<td align="right"><?php if (!empty($saldoakhir)) {
														echo uang($saldoakhir);
													} ?></td>
			</tr>
		<?php $no++;
		} ?>

		<tr bgcolor="#024a75" style="color:white; font-size:12; font-weight:bold">
			<td colspan="5"><b>TOTAL</b></td>
			<td align="right"><?php if (!empty($totalsaldoawal)) {
													echo uang($totalsaldoawal);
												} ?></td>
			<td align="right"><?php if (!empty($totalpembelian)) {
													echo uang($totalpembelian);
												} ?></td>
			<td align="right"><?php if (!empty($totalpenyesuaian)) {
													echo uang($totalpenyesuaian);
												} ?></td>
			<td align="right"><?php if (!empty($totalpembayaran)) {
													echo uang($totalpembayaran);
												} ?></td>
			<td align="right"><?php if (!empty($totalsaldoakhir)) {
													echo uang($totalsaldoakhir);
												} ?></td>
		</tr>
	</tbody>

</table>

<br>