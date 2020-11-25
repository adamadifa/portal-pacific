<table class="table table-bordered table-hover table-striped">
	<thead class="thead-dark">
		<tr>
			<th>Tgl Retur</th>
			<th>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Jml Dus</th>
			<th>Jml Pack</th>
			<th>Jml Pcs</th>
			<th>Sub Total</th>
			<th>No Faktur</th>
			<th>Jenis Faktur</th>
		</tr>
	</thead>
	<?php
	$total = 0;
	foreach ($detail as $d) {
		$total = $total + $d->subtotal;

		$jmldus     = floor($d->jumlah / $d->isipcsdus);
		$sisadus    = $d->jumlah % $d->isipcsdus;

		if ($d->isipack == 0) {
			$jmlpack    = 0;
			$sisapack   = $sisadus;
		} else {

			$jmlpack    = floor($sisadus / $d->isipcs);
			$sisapack   = $sisadus % $d->isipcs;
		}

		$jmlpcs = $sisapack;
	?>
		<tr>
			<td><?php echo $d->tglretur; ?></td>
			<td><?php echo $d->kode_barang; ?></td>
			<td><?php echo $d->nama_barang; ?></td>
			<td align="center"><?php echo $jmldus; ?></td>
			<td align="center"><?php echo $jmlpack; ?></td>
			<td align="center"><?php echo $jmlpcs; ?></td>
			<td align="right"><?php echo number_format($d->subtotal, '0', '', '.'); ?></td>
			<td><?php echo $d->no_fak_penj; ?></td>
			<td align="right"><?php echo strtoupper($d->jenis_retur); ?></td>

		</tr>
	<?php } ?>


</table>