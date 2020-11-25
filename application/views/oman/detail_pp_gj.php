<?php 
	foreach ($detail as $d){
?>
	<tr>
		<td><?php echo $d->kode_produk;?></td>
		<td><?php echo $d->nama_barang;?></td>
		<td><?php echo $d->jumlah;?></td>
	</tr>
<?php 
}
?>



