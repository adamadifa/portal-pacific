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

		function loadBpbj() {
			var kode_produk = $("#kodebarang").val();
			$("#loadbpbj").load('<?php echo base_url(); ?>bpbj/view_detailbpbj_temp/' + kode_produk);
		}


		$(".hapus").click(function(e) {
			var id = $(this).attr("data-id");
			var shift = $(this).attr("data-shift");
			e.preventDefault();
			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>bpbj/hapus_detailbpbjtmp',
				data: {
					kode_produk: id,
					shift: shift
				},
				cache: false,
				success: function(respond) {

					loadBpbj();


				}
			});

		});



	});
</script>