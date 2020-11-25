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
		<td style="text-align: right"><?php echo number($b->jumlah); ?></td>
		<td>
			<a href="#" data-id="<?php echo $b->kode_produk; ?>" class="btn btn-red btn-sm hapus"><i class="fa fa-trash-o"></i></a>
		</td>
	</tr>

<?php
}
?>

<script type="text/javascript">
	$(function() {
		function loadPermintaan() {

			$("#loaddetailpermintaan").load('<?php echo base_url(); ?>oman/view_detail_permintaan_pengiriman_temp/');
		}

		function cek_detailpermintaanpengiriman() {

			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>oman/cek_detailpermintaanpengiriman',
				cache: false,
				success: function(respond) {

					$("#cekdetailpermintaanpengiriman").val(respond);
				}

			});
		}
		$(".hapus").click(function(e) {
			var id = $(this).attr("data-id");
			e.preventDefault();
			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>oman/hapus_detail_permintaan_pengiriman',
				data: {
					kode_produk: id
				},
				cache: false,
				success: function(respond) {

					loadPermintaan();
					cek_detailpermintaanpengiriman();


				}
			});

		});



	});
</script>