<?php 
	$total = 0;
	foreach($targettahuntemp as $d){ 
?>
	<tr>
		<td><?php echo $d->kode_produk; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="right"><?php echo number_format($d->target_tahun,'0','','.'); ?></td>
		<td align="right">
			<a href="#" data-kodebarang="<?php echo $d->kode_produk; ?>" data-cabang="<?php echo $d->kode_cabang; ?>" data-tahun="<?php echo $d->tahun; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a>
			
		</td>
		
	</tr>
<?php } ?>
	
	<script type="text/javascript">
		
		$(function(){
			function loadtargettahun(){
			  var cabang = $("#cabang").val();
			  var  tahun = $("#tahun").val();
			  $("#loadtargettahun").load("<?php echo base_url();?>target/view_targettahuntemp/"+cabang+"/"+tahun);
			}
			
			function cek_targettahuntemp(){
				var  tahun = $("#tahun").val();
				var cabang = $("#cabang").val();
				$.ajax({

					type    : 'POST',
					url     : '<?php echo base_url(); ?>target/cek_targettahuntemp',
					data    : {cabang:cabang,tahun:tahun},
					cache   : false,
					success : function(respond){

						$("#cek_targettahuntemp").val(respond);
					}

				});
			}

			$(".hapus").click(function(e){
				var kodebarang 	= $(this).attr("data-kodebarang");
				var cabang 		= $(this).attr("data-cabang");
				var tahun 		= $(this).attr("data-tahun");
				e.preventDefault();
				$.ajax({

					type		: 'POST',
					url 		: '<?php echo base_url(); ?>target/hapus_targettahuntemp',
					data 		: {kodebarang:kodebarang,cabang:cabang,tahun:tahun},
					cache		: false,
					success 	: function(respond){
						console.log(respond);
						loadtargettahun();
						cek_targettahuntemp();
						
						
					}
				});

			});


			


		});
	</script>

	