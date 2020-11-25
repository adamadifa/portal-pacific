<?php
	$total = 0;
	foreach($detail as $d){


	$jmldus     = floor($d->jumlah / $d->isipcsdus);
    $sisadus    = $d->jumlah % $d->isipcsdus;

    if($d->isipack == 0){
        $jmlpack    = 0;
        $sisapack   = $sisadus;
    }else{

        $jmlpack    = floor($sisadus / $d->isipcs);
        $sisapack   = $sisadus % $d->isipcs;
    }

    $jmlpcs = $sisapack;

    $subtotal = ($jmldus * $d->harga_dus) + ($jmlpack * $d->harga_pack) + ($jmlpcs * $d->harga_pcs);
    $total 	  = $total + $subtotal;
?>
	<tr <?php if($d->jenis_mutasi =="HUTANG KIRIM"){?> style="background-color:yellow" <?php } ?>>
		<td><?php echo $d->kode_barang; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="center"><?php echo $jmldus; ?></td>
		<td align="right"><?php echo number_format($d->harga_dus,'0','','.'); ?></td>
		<td align="center"><?php echo $jmlpack; ?></td>
		<td align="right"><?php echo number_format($d->harga_pack,'0','','.'); ?></td>
		<td align="center"><?php echo $jmlpcs; ?></td>
		<td align="right"> <?php echo number_format($d->harga_pcs,'0','','.'); ?></td>
		<td align="right"><?php echo number_format($subtotal,'0','','.'); ?></td>
		<td align="right"><a href="#"  data-id="<?php echo $d->kode_barang; ?>" data-jenismutasi="<?php echo $d->jenis_mutasi; ?>"  class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="8"><b>TOTAL</b></td>
		<td align="right"><b id="total"><?php echo number_format($total,'0','','.'); ?></b></td>
		<td></td>
	</tr>


	<script type="text/javascript">

		$(function(){

			function loadDatagbTmp(){
				var kodepelanggan = $("#kodepelanggan").val();
				$("#loadpnjgbtmp").load("<?php echo base_url();?>penjualan/view_detailgbtmp/"+kodepelanggan);
			}
			function loadDataHutangkirim(){
				$("#loaddatahutangkirim").load("<?php echo base_url();?>penjualan/view_datahutangkirim");
			}
			function loadttr(){
				var kodepelanggan = $("#kodepelanggan").val();
				$.ajax({

					type  	: 'POST',
					url 	: '<?php echo base_url(); ?>penjualan/cek_jml_ttr',
					data 	: {kodepelanggan:kodepelanggan},
					cache   : false,
					success : function(respond){

						$("#ttr").val(respond);
					}

				});
			}
			function cekttrjml(){
				var kodepelanggan = $("#kodepelanggan").val();
				$.ajax({
					type    : 'POST',
					url     : '<?php echo base_url(); ?>penjualan/cekttrjml',
					data    : {kodepelanggan:kodepelanggan},
					cache   : false,
					success : function (respond){
						$("#cekttrjml").val(respond);
					}
				});
			}
			$(".hapus").click(function(e){
				var id 				= $(this).attr("data-id");
				var jenis_mutasi	= $(this).attr("data-jenismutasi")

				e.preventDefault();
				$.ajax({

					type		: 'POST',
					url 		: '<?php echo base_url(); ?>penjualan/hapus_detailbrggb',
					data 		: {kodebarang:id,jenis_mutasi:jenis_mutasi},
					cache		: false,
					success 	: function(respond){

						loadDatagbTmp();
						loadDataHutangkirim();
						loadttr();
						cekttrjml();

					}
				});

			});





		});
	</script>
