<table class="table table-bordered table-hover table-striped">
	<tr>
		<td><b>NO Mutasi</b></td>
		<td>:</td>
		<td><?php echo $mutasi['no_mutasi_produksi']; ?></td>
	</tr>
	<tr>
		<td><b>Tanggal</b></td>
		<td>:</td>
		<td><?php echo DateToIndo2($mutasi['tgl_mutasi_produksi']); ?></td>
	</tr>

</table>
<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th>Kode Produk</th>
			<th>Nama Barang</th>
			<th>Shift</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($detail as $d){
		?>
			<tr>
				<td><?php echo $d->kode_produk;?></td>
				<td><?php echo $d->nama_barang;?></td>
				<td><?php echo $d->shift;?></td>
				<td><?php echo $d->jumlah;?></td>
			</tr>
		<?php 
		}
		?>
	</tbody>
</table>