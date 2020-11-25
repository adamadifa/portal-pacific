<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">


	<?php
	if ($cb['nama_cabang'] != "") {
		echo "PACIFIC CABANG " . strtoupper($cb['nama_cabang']);
	} else {
		echo "PACIFIC ALL CABANG";
	}

	?>
	<br>
	DISKON<br>
	PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
	<br>
	<?php

	$b 		= explode("-", $dari);
	$bulan	= $b[1];

	?>

</b>
<br>
<br>
<table class="datatable3" style="width:100%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td>No Faktur</td>
			<td>Tanggal Transaksi</td>
			<td>Kode Pelanggan</td>
			<td>Nama Pelanggan</td>
			<td>Kode Sales</td>
			<td>Nama Sales</td>
			<td>Kategori</td>
			<td>Cabang</td>
			<td>Jumlah Dus</td>
			<td>Diskon Kategori</td>
			<td>Total Potongan</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach ($diskon as $k) { ?>
				<tr>
					<td><?php echo $k->no_fak_penj; ?></td>
					<td><?php echo DateToIndo2($k->tgltransaksi); ?></td>
					<td><?php echo $k->kode_pelanggan; ?></td>
					<td><?php echo $k->nama_pelanggan; ?></td>
					<td><?php echo $k->id_karyawan; ?></td>
					<td><?php echo $k->nama_karyawan; ?></td>
					<td><?php echo $k->kategori; ?></td>
					<td><?php echo $k->kode_cabang; ?></td>
					<td style="text-align:right"><?php echo number_format($k->jmldus, '0', '', '.'); ?></td>
					<td style="text-align:right"><?php echo number_format($k->diskonkategori, '0', '', '.'); ?></td>
					<td style="text-align:right"><?php echo number_format($k->totalpotongan, '0', '', '.'); ?></td>


				</tr>
		<?php
			}
			$no++;
		?>
	</tbody>
	<tr bgcolor="#024a75" style="color:white; font-size:12;">

	</tr>
</table>