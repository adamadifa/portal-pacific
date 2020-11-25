<?php
$total = 0;
foreach ($detail as $d) {

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

		<td><a href="#" data-pelanggan="<?php echo $d->kode_pelanggan; ?>" data-barang="<?php echo $d->kode_barang; ?>" class="detailretur"><?php echo $d->kode_barang; ?></a></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="center"><?php echo $jmldus; ?></td>

		<td align="center"><?php echo $jmlpack; ?></td>

		<td align="center"><?php echo $jmlpcs; ?></td>



	</tr>
<?php } ?>




<script type="text/javascript">
	$(function() {

		$(".detailretur").click(function(e) {
			var kodepelanggan = $(this).attr("data-pelanggan");
			var kodebarang = $(this).attr("data-barang");
			e.preventDefault();
			$("#detailretur").modal({
          backdrop: "static", //remove ability to close modal with click
          keyboard: false, //remove option to close with keyboard
          show: true //Display loader!
        });
			$("#loadDetailRetur").load("<?php echo base_url(); ?>penjualan/view_detailretur2/" + kodepelanggan + "/" + kodebarang);
		});

	});
</script>