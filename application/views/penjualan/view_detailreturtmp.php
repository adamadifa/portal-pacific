<?php
$total = 0;
foreach ($detail as $d) {
	$total = $total + $d->subtotal;

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
		<td><?php echo $d->kode_barang; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="center"><?php echo $jmldus; ?></td>
		<td align="right"><?php echo number_format($d->harga_dus, '0', '', '.'); ?></td>
		<td align="center"><?php echo $jmlpack; ?></td>
		<td align="right"><?php echo number_format($d->harga_pack, '0', '', '.'); ?></td>
		<td align="center"><?php echo $jmlpcs; ?></td>
		<td align="right"> <?php echo number_format($d->harga_pcs, '0', '', '.'); ?></td>
		<td align="right"><?php echo number_format($d->subtotal, '0', '', '.'); ?></td>
		<td align="right"><a href="#" data-jumlah="<?php echo $d->jumlah; ?>" data-id="<?php echo $d->kode_barang; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a></td>
	</tr>
<?php } ?>
<tr>
	<td colspan="8"><b>TOTAL</b></td>
	<td align="right"><b id="total"><?php echo number_format($total, '0', '', '.'); ?></b><input type="hidden" id="tot" name="subtotal" value="<?php echo $total; ?>" onFocus="startCalc();"></td>
	<td></td>
</tr>


<script type="text/javascript">
	$(function() {
		function loadreturTmp() {
			var kodepelanggan = $("#kodepelanggan").val();
			$("#loadreturtmp").load("<?php echo base_url(); ?>penjualan/view_detailreturtmp/" + kodepelanggan);
		}

		function cekretur() {

			var nofaktur = $("#nofaktur").val();

			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/cekbarangretur',
				data: {
					nofaktur: nofaktur
				},
				cache: false,
				success: function(respond) {
					data = respond.split("|");
					var cekretur = data[0];
					var cekreturgb = data[1];

					$("#cekretur").val(cekretur);
					$("#cekreturgb").val(cekreturgb);




				}

			});
		}

		function ResetBrg() {

			$("#kodebarang").val("");
			$("#barang").val("");
			$("#hargadus").val("");
			$("#hargapack").val("");
			$("#hargapcs").val("");
			$("#stokdus").val("");
			$("#stokpcs").val("");
			$("#stok").val("");
			$("#isipcsdus").val("");
			$("#isipcspack").val("");
			$("#stokpack").val("");
			$("#jmlpcs").val(0);
			$("#jmlpack").val(0);
			$("#jmldus").val(0);


		}

		$("#grandtotal").text($("#total").text());
		$("#totalbayar").val($("#tot").val());




		$(".hapus").click(function(e) {
			var id = $(this).attr("data-id");
			var kodepelanggan = $("#kodepelanggan").val();
			e.preventDefault();
			$.ajax({

				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/hapus_detailreturbrg',
				data: {
					kodebarang: id,
					kodepelanggan: kodepelanggan
				},
				cache: false,
				success: function(respond) {

					loadreturTmp();
					ResetBrg();
					cekretur();
				}
			});

		});







	});
</script>

<script type="text/javascript">
	function startCalc() {
		interval = setInterval("calc()", 1)
	}

	function calc() {
		grandtotal = document.getElementById("tot").value;
		potongan = document.getElementById("potongan").value;
		potistimewa = document.getElementById("potistimewa").value;
		penyharga = document.getElementById("penyharga").value;
		total = document.getElementById("totalbayar").value;

		bayar = document.getElementById("bayar").value;

		document.autoSumForm.totalbayar.value = (grandtotal - potongan - potistimewa - penyharga);
		document.autoSumForm.uanglebih.value = (bayar - total);
	}

	function stopCalc() {
		clearInterval(interval)
	}
</script>