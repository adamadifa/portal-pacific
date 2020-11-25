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
	<tr <?php if ($d->promo == 1) { ?> style="background-color:yellow" <?php } ?>>
		<td><?php echo $d->kode_barang; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="center"><?php echo $jmldus; ?></td>
		<td align="right"><?php echo number_format($d->harga_dus, '0', '', '.'); ?></td>
		<td align="center"><?php echo $jmlpack; ?></td>
		<td align="right"><?php echo number_format($d->harga_pack, '0', '', '.'); ?></td>
		<td align="center"><?php echo $jmlpcs; ?></td>
		<td align="right"> <?php echo number_format($d->harga_pcs, '0', '', '.'); ?></td>
		<td align="right"><?php echo number_format($d->subtotal, '0', '', '.'); ?></td>
		<td align="center"><a href="#" data-jumlah="<?php echo $d->jumlah; ?>" data-id="<?php echo $d->kode_barang; ?>" data-promo="<?php echo $d->promo; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a></td>
	</tr>
<?php } ?>
<tr>
	<td colspan="8"><b>TOTAL</b></td>
	<td align="right"><b id="total"><?php echo number_format($total, '0', '', '.'); ?></b><input type="hidden" id="tot" name="subtotal" value="<?php if(empty($total)){echo 0;}else{echo $total;} ?>" onkeyup="calc()"></td>
	<td></td>
</tr>


<script type="text/javascript">
	$(function() {
		function cekbarang() {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/cekbarangpenjualan',
				cache: false,
				success: function(respond) {
					console.log(respond);
					$("#cekbarang").val(respond);
				}

			});
		}

		function hitungdiskon() {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/hitungdiskon',
				cache: false,
				success: function(respond) {
					$("#potongan").val(respond);
					terbilangpotongan();
				}
			});
		}


		function terbilangpotongan() {
			var potongan = $("#potongan").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pembayaran/terbilang',
				data: {
					jmlbayar: potongan
				},
				cache: false,
				success: function(respond) {
					$("#terbilangpotongan").html(respond);
				}
			});
		}

		function terbilangtotalbayar() {
			var totalbayar = $("#totalbayar").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>pembayaran/terbilang',
				data: {
					jmlbayar: totalbayar
				},
				cache: false,
				success: function(respond) {
					$("#terbilangtotalbayar").html(respond);
				}
			});
		}

		function loadDataTmp() {
			$("#loadpnjtmp").load("<?php echo base_url(); ?>penjualan/view_detailtmp");
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
			var jumlah = $(this).attr("data-jumlah");
			var promo = $(this).attr("data-promo");
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/hapus_detailbrg',
				data: {
					kodebarang: id,
					jumlah: jumlah,
					promo: promo
				},
				cache: false,
				success: function(respond) {
					loadDataTmp();
					ResetBrg();
					hitungdiskon();
					terbilangpotongan();
					cekbarang();
					cekttrjml();
				}
			});
		});
	});
</script>