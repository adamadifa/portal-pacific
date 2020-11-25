<?php
function uang($nilai)
{
	return number_format($nilai, '2', ',', '.');
}

foreach ($data as $d) {
?>
	<tr>
		<td><?php echo $d->no_ref; ?></td>
		<td><?php echo $d->pelanggan; ?></td>
		<td align="right"><?php echo uang($d->jumlah); ?></td>
		<td><?php echo $d->kode_akun . " " . $d->nama_akun; ?></td>
		<td><?php echo $d->bank; ?></td>
		<td><?php echo $d->keterangan; ?></td>
		<td><?php echo $d->status_dk; ?></td>
		<td>
			<?php if ($d->peruntukan == "PC") {
				echo "CV. PACIFIC";
			} else {
				echo "CV. MAKMUR PERMATA";
			} ?>
		</td>
		<td><?php echo $d->ket_peruntukan; ?></td>
		<td align="center">
			<a href="#" class="btn btn-sm btn-danger hapus_temp2" data-kode="<?php echo $d->id; ?>"><i class="fa fa-trash-o"></i></a>
		</td>
	</tr>
<?php } ?>
<script type="text/javascript">
	function tampiltemp() {

		var noref = $("#noref").val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>keuangan/view_templedger',
			data: {
				noref: noref
			},
			success: function(html) {

				$("#tampiltemp").html(html);

			}
		});

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>keuangan/cekdata/',
			cache: false,
			data: {
				noref: noref
			},
			success: function(respond) {

				$("#cekdata").val(respond);

			}

		});
	}
	$('.hapus_temp2').click(function(e) {
		e.preventDefault();
		var id = $(this).attr("data-kode");
		$.ajax({

			type: 'POST',
			url: '<?php echo base_url(); ?>keuangan/hapus_templedger',
			data: {
				id: id
			},
			cache: false,
			success: function(respond) {

				tampiltemp();
				$("#nobukti").focus();

			}

		});

	});
</script>