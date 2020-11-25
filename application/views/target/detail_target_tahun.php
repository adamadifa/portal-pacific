<input type="hidden" id="tahun" value="<?php echo $tahun; ?>">
<input type="hidden" id="cabang" value="<?php echo $cabang; ?>">
<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
	<thead>
		<tr>
			<th>Kode Produk</th>
			<th>Target</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 

			foreach($detail as $d){
		?>
				<tr>
					<td><?php echo $d->kode_produk; ?></td>
					<td style="text-align:right; font-weight:bold"><?php echo number_format($d->target_tahun,'0','','.'); ?></td>
					<td><a href="<?php echo base_url(); ?>target/hapus_target_produk_tahun/<?php echo $d->id_targettahun; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
				</tr>

		<?php 
			}
		?>
	</tbody>
</table>


