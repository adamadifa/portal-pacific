<?php
	$total = 0;
	foreach($targetbulantemp as $d){
?>
	<tr>
		<td><?php echo $d->kode_produk; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="right"><?php echo number_format($d->target_bulan,'0','','.'); ?></td>
		<td align="right">
			<a href="#" data-kodebarang="<?php echo $d->kode_produk; ?>" data-cabang="<?php echo $d->kode_cabang; ?>" data-tahun="<?php echo $d->tahun; ?>" data-bulan="<?php echo $d->bulan; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a>

		</td>

	</tr>
<?php } ?>

	<script type="text/javascript">

		$(function(){
			function loadtargetbulan(){
			  var  cabang = $("#cabang").val();
			  var  tahun  = $("#tahun").val();
			  var  bulan  = $("#bulan").val();
			  $("#loadtargetbulan").load("<?php echo base_url();?>oman/view_targetbulantemp/"+cabang+"/"+bulan+"/"+tahun);
			}

			function cek_targetbulantemp(){
				var  tahun  = $("#tahun").val();
				var  cabang = $("#cabang").val();
				var  bulan  = $("#bulan").val();
				$.ajax({
					type    : 'POST',
					url     : '<?php echo base_url(); ?>oman/cek_targetbulantemp',
					data    : {cabang:cabang,tahun:tahun,bulan:bulan},
					cache   : false,
					success : function(respond){
						$("#cek_targetbulantemp").val(respond);
					}
				});
			}

			$(".hapus").click(function(e){
				var kodebarang 	= $(this).attr("data-kodebarang");
				var cabang 			= $(this).attr("data-cabang");
				var tahun 			= $(this).attr("data-tahun");
				var  bulan  		= $(this).attr("data-bulan");
				e.preventDefault();
				$.ajax({
					type		: 'POST',
					url 		: '<?php echo base_url(); ?>oman/hapus_targetbulantemp',
					data 		: {kodebarang:kodebarang,cabang:cabang,tahun:tahun,bulan:bulan},
					cache		: false,
					success 	: function(respond){
						console.log(respond);
						loadtargetbulan();
						cek_targetbulantemp();
					}
				});

			});





		});
	</script>
