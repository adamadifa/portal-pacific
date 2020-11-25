	<?php 

		if($stok !=0){
			$jmldus     = floor($stok / $produk['isipcsdus']);
		    $sisadus    = $stok % $produk['isipcsdus'];

		    if($produk['isipack'] == 0){
		        $jmlpack    = 0;
		        $sisapack   = $sisadus;   
		    }else{

		        $jmlpack    = floor($sisadus / $produk['isipcs']);  
		        $sisapack   = $sisadus % $produk['isipcs']; 
		    }

		    $jmlpcs = $sisapack;
		}else{

			$jmldus   = 0;
			$jmlpack  = 0;
			$jmlpcs   = 0;
		}

	?>
	<tr>
		<td align="center"><b><?php echo number_format($jmldus,'0','','.'); ?></b></td>
		<td align="center"><b><?php echo number_format($jmlpack,'0','','.'); ?></b></td>
		<td align="center"><b><?php echo number_format($jmlpcs,'0','','.'); ?></b></td>
	</tr>

	<script type="text/javascript">
		
		$(function(){
			
		
		});
	</script>

	