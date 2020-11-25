<?php 
	$total = 0;
	foreach($detail as $d){ 
	
	if($d->jumlah != 0){
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
	}else{

		$jmldus   = 0;
		$jmlpack  = 0;
		$jmlpcs   = 0;
	}
	
	
	if($d->jumlah_stok != 0){
		$jmldus_stok     = floor($d->jumlah_stok / $d->isipcsdus);
		$sisadus_stok    = $d->jumlah_stok % $d->isipcsdus;

		if($d->isipack == 0){
			$jmlpack_stok    = 0;
			$sisapack_stok   = $sisadus_stok;   
		}else{

			$jmlpack_stok    = floor($sisadus_stok / $d->isipcs);  
			$sisapack_stok   = $sisadus_stok % $d->isipcs;  
		}

		$jmlpcs_stok = $sisapack_stok;
	}else{

		$jmldus_stok   = 0;
		$jmlpack_stok  = 0;
		$jmlpcs_stok   = 0;
	}	
	
?>
	<tr>
		<td><?php echo $d->kode_produk; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="center"><?php echo $jmldus_stok; ?></td>
		<td align="center"><?php echo $jmlpack_stok; ?></td>
		<td align="center"><?php echo $jmlpcs_stok; ?></td>
		<td align="center"><?php echo $jmldus; ?></td>
		<td align="center"><?php echo $jmlpack; ?></td>
		<td align="center"><?php echo $jmlpcs; ?></td>
		<td><?php echo $d->keterangan; ?></td>
		<td align="right"><a href="#" data-id="<?php echo $d->kode_produk; ?>" data-cabang="<?php echo $d->kode_cabang; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
	</tr>
<?php } ?>
	
	<script type="text/javascript">
		
		$(function(){
			function loadDetail(){
	          var cabang = $("#cabang").val();
	          $("#loadDetail").load("<?php echo base_url();?>repackreject/view_detailsogoodtemp/"+cabang);
	        }

	        

	        function cekdetail(){
	            var cabang  = $("#cabang").val();
	            $.ajax({

	                type    : 'POST',
	                url     : '<?php echo base_url(); ?>repackreject/cekdetailsogoodtemp',
	                data    : {cabang:cabang},
	                cache   :false,
	                success : function(respond){
	                    console.log(cabang);
	                    $("#cekdetailsogoodtemp").val(respond);
	                }

	            });
	        }

			$(".hapus").click(function(e){
				var id 		= $(this).attr("data-id");
				var cabang 	= $(this).attr("data-cabang");
				e.preventDefault();
				$.ajax({

					type		: 'POST',
					url 		: '<?php echo base_url(); ?>repackreject/hapus_detailbrgsogoodtemp',
					data 		: {kode_produk:id,cabang:cabang},
					cache		: false,
					success 	: function(respond){

						 cekdetail();
        				 loadDetail();
						
					}
				});

			});

		


			


		});
	</script>

	