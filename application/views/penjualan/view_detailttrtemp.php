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
?>
	<tr>
		<td><?php echo $d->kode_produk; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="center"><?php echo $jmldus; ?></td>
		<td align="center"><?php echo $jmlpack; ?></td>
		<td align="center"><?php echo $jmlpcs; ?></td>
		<td align="right"><a href="#" data-id="<?php echo $d->kode_produk; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
	</tr>
<?php } ?>
	
	<script type="text/javascript">
		
		$(function(){
			function loadDetail(){
	          var kodepelanggan = $("#kodepelanggan").val();
	          $("#loadDetail").load("<?php echo base_url();?>penjualan/view_detailttrtemp/");
	        }

	        function cekdetail(){
	           
	            $.ajax({

	                type    : 'POST',
	                url     : '<?php echo base_url(); ?>penjualan/cekdetailttrtemp',
	                cache   :false,
	                success : function(respond){
	           
	                    $("#cekdetailttrtemp").val(respond);
	                }

	            });
	        }

			$(".hapus").click(function(e){
				var id 		= $(this).attr("data-id");
				
				e.preventDefault();
				$.ajax({

					type		: 'POST',
					url 		: '<?php echo base_url(); ?>penjualan/hapus_detailbrgttr',
					data 		: {kode_produk:id},
					cache		: false,
					success 	: function(respond){

						 cekdetail();
        				 loadDetail();
						
					}
				});

			});

		


			


		});
	</script>

	