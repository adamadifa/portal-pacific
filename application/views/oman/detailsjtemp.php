<?php
foreach ($detail as $d) {
?>
	<tr>
		<td><?php echo $d->kode_produk; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td><?php echo $d->jumlah; ?></td>
		<td>
			<a href="#" data-nopermintaan="<?php echo $d->no_permintaan_pengiriman; ?>" data-produk="<?php echo $d->kode_produk; ?>" class="btn btn-sm btn-danger deletedetail">
				<i class="fa fa-trash-o"></i>
			</a>
		</td>
	</tr>
<?php
}
?>


<script type="text/javascript">
	$(function() {

		function loaddetailsj() {
			var no_permintaan = $("#nopermintaan").val();
			$("#loaddetailsuratjalan").load('<?php echo base_url(); ?>/oman/detailsjtemp/' + no_permintaan);
		}

		function cek_detailsuratjalan() {

			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>oman/cek_detailsuratjalan',
				cache: false,
				success: function(respond) {

					$("#cekdetailsuratjalan").val(respond);
				}

			});
		}
		$('.deletedetail').click(function(e) {
			e.preventDefault();
			var no_permintaan = $(this).attr('data-nopermintaan');
			var kode_produk = $(this).attr('data-produk');

			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>oman/deletedetailsjtemp',
				data: {
					no_permintaan: no_permintaan,
					kode_produk: kode_produk
				},
				cache: false,
				success: function(respond) {
					loaddetailsj();
					cek_detailsuratjalan();
				}


			});


		});


	});
</script>