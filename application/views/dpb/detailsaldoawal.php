<?php
function uang($nilai)
{
	return number_format($nilai, '2', ',', '.');
}
?>
<table class="table table-bordered table-hover table-striped">
	<tr>
		<td colspan="3"><b>Kode</b></td>
		<td><?php echo $saldo['kode_saldoawal']; ?></td>
	</tr>
	<tr>
		<td colspan="3"><b>Tanggal</b></td>
		<td><?php echo DateToIndo2($saldo['tanggal']); ?></td>
	</tr>
	<tr>
		<td colspan="3"><b>Bulan</b></td>
		<td><?php echo $bulan[$saldo['bulan']]; ?></td>
	</tr>
	<tr>
		<td colspan="3"><b>Tahun</b></td>
		<td><?php echo $saldo['tahun']; ?></td>
	</tr>
	<tr>
		<td colspan="3"><b>Cabang</b></td>
		<td><?php echo $saldo['kode_cabang']; ?></td>
	</tr>
</table>
<hr>
<table class="table table-bordered table-hover table-striped">
	<thead class="thead-dark">
		<tr>
			<th rowspan="3" align="">No</th>
			<th rowspan="3" style="text-align:center">Nama Barang</th>
			<th colspan="3" style="text-align:center">Penjualan</th>
			<th rowspan="2" colspan="2" style="text-align:center">Total</th>
		</tr>
		<tr>
			<th colspan="3" style="text-align:center">Kuantitas</th>
		</tr>
		<tr>
			<th>DUS</th>
			<th>PACK</th>
			<th>PCS</th>
			<th style="text-align:center">Jumlah</th>
			<th style="text-align:center">Satuan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach ($detailsaldo as $d) {
			$jumlah = $d->jumlah / $d->isipcsdus;
			$jmldus = floor($d->jumlah / $d->isipcsdus);
			if ($d->jumlah != 0) {
				$sisadus   = $d->jumlah % $d->isipcsdus;
			} else {
				$sisadus = 0;
			}
			if ($d->isipack == 0) {
				$jmlpack    = 0;
				$sisapack   = $sisadus;
				$s          = "A";
			} else {
				$jmlpack    = floor($sisadus / $d->isipcs);
				$sisapack   = $sisadus % $d->isipcs;
				$s          = "B";
			}
			$jmlpcs = $sisapack;
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $d->nama_barang; ?></td>
				<td><?php if (!empty($jmldus)) {
							echo $jmldus;
						} ?></td>
				<td><?php if (!empty($jmlpack)) {
							echo $jmlpack;
						} ?></td>
				<td><?php if (!empty($jmlpcs)) {
							echo $jmlpcs;
						} ?></td>
				<td align="right"><?php echo uang($jumlah); ?></td>
				<td><?php echo $d->satuan; ?></td>

			</tr>
		<?php
			$no++;
		}
		?>
	</tbody>
</table>