<?php
function number($nilai)
{
	return number_format($nilai, '0', '', '.');
}
foreach ($detail as $b) {
?>
	<tr>
		<td><?php echo $b->kode_produk; ?></td>
		<td><?php echo $b->nama_barang; ?></td>
		<td><?php echo $b->shift; ?></td>
		<td style="text-align: right"><?php echo number($b->jumlah); ?></td>
		<td>
			<a href="#" data-id="<?php echo $b->kode_produk; ?>" data-shift="<?php echo $b->shift; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
		</td>
	</tr>

<?php
}
?>

<script type="text/javascript">
	$(function() {
		function ladFsthp() {
			var kode_produk = $("#kodebarang").val();
			$("#loadfsthp").load('<?php echo base_url(); ?>fsthp/view_detailfsthp_temp/' + kode_produk);
		}
		$(".hapus").click(function(e) {
			var id = $(this).attr("data-id");
			var shift = $(this).attr("data-shift");
			e.preventDefault();
			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>fsthp/hapus_detailfsthptmp',
				data: {
					kode_produk: id,
					shift: shift
				},
				cache: false,
				success: function(respond) {

					ladFsthp();


				}
			});

		});



	});
</script>