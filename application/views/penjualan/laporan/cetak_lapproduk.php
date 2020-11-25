<?php
	error_reporting(0);
	function uang($nilai){

		return number_format($nilai,'0','','.');
	}

?>

<?php 

	if($dari < '2018-09-01'){
	?>

	<div class="alert alert-danger">
        <strong>Sorry Bro!</strong> Maaf Untuk Data Penjualan Kurang Dari Bulan September 2018 Tidak Dapat Ditampilkan.!
    </div>
<?php
	

	}else{
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">
	
	
	<?php 
		if($cb['nama_cabang'] != ""){
			echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
		}else{
			echo "PACIFIC ALL CABANG";
		}
		 
	?>
	<br>
	REKAPITULASI PENJUALAN PELANGGAN<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
	
	

</b>
<br>
<br>
<table class="datatable3" style="width:150%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td rowspan="2">No</td>
			
			<td rowspan="2">Kode Sales</td>
			<td rowspan="2">Nama Sales</td>
			
			<td rowspan="2">Nama Barang</td>
			<td colspan="7" align="center">QTY</td>
			<td rowspan="2">Total</td>
			<td rowspan="2">Retur Penjualan</td>
			<td rowspan="2">Pembelian Botol/Peti</td>
			<td rowspan="2">Penyesuaian Harga</td>
			<td rowspan="2">Potongan Harga</td>
			<td rowspan="2">Potongan Istimewa</td>
			<td rowspan="2">Penjualan Netto</td>
			<td rowspan="2">TUNAI/KREDIT</td>

		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td>DUS</td>
			<td>Harga</td>
			<td>PACK</td>
			<td>Harga</td>
			<td>PCS</td>
			<td>Harga</td>
			<td>Subtotal</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no=1;
			$totaldus 					= 0;
			$totalpack 					= 0;
			$totalpcs 					= 0;
			$total 						= 0;
			$totalretur 				= 0;
			$totalpenyharga				= 0;
			$totalpotongan				= 0;
			$totalpotist				= 0;
			$netto 						= 0;
			$totaldus2 					= 0;
			$totalpack2 				= 0;
			$totalpcs2 					= 0;
			$subtotaldus				= 0;
			$subtotaldus2 				= 0;
			$subtotalpack 				= 0;
			$subtotalpack2 				= 0;
			$subtotalpcs 				= 0;
			$subtotalpcs2				= 0; 				
			$subtotal 					= 0;
			$subtotalretur 				= 0;
			$subtotalpenyharga 			= 0;
			$subtotalpotongan			= 0;
			$subtotalpotist				= 0;
			$subtotalnetto				= 0;
			$color 						= "";
			
			foreach ($penjualan as $key => $p){ 
			$pel  = @$penjualan[$key+1]->kode_pelanggan;
			$qjbarang  = "SELECT detailpenjualan.no_fak_penj FROM detailpenjualan INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj WHERE id_karyawan='$p->id_karyawan'";

			$jmlbarang = $this->db->query($qjbarang)->num_rows();

			if(empty($jmlbarang)){
				$jmlbarang = 1;
			}else{
				$jmlbarang = $jmlbarang;
			}
			$query1    = "SELECT detailpenjualan.no_fak_penj,detailpenjualan.kode_barang,nama_barang,jumlah,isipcsdus,
						  isipack,isipcs,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs
						  ,detailpenjualan.subtotal,promo
						  FROM detailpenjualan 
						  INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
						  INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
						  WHERE id_karyawan = '$p->id_karyawan' ORDER BY detailpenjualan.kode_barang ASC LIMIT 1";
			$barang1   = $this->db->query($query1)->row_array();
			$jmldus    = floor($barang1['jumlah'] / $barang1['isipcsdus']);
		    $sisadus   = $barang1['jumlah'] % $barang1['isipcsdus'];
		    if($barang1['isipack'] == 0){
		        $jmlpack    = 0;
		        $sisapack   = $sisadus;   
		    }else{

		        $jmlpack    = floor($sisadus / $barang1['isipcs']);  
		        $sisapack   = $sisadus % $barang1['isipcs'];  
		    }

		    $jmlpcs = $sisapack;


		    $totaldus 			= $totaldus + $jmldus;
		    $totalpack 			= $totalpack + $jmlpack;
		    $totalpcs 			= $totalpcs + $jmlpcs;
		    $total 				= $total + $p->subtotal;
		    $totalretur 		= $totalretur + $p->totalretur;
		    $totalpenyharga 	= $totalpenyharga + $p->penyharga;
		    $totalpotongan  	= $totalpotongan + $p->potongan;
		    $totalpotist		= $totalpotist + $p->potistimewa;
		    $netto 				= $netto + $p->totalpiutang;



		    //Subtotal
		    $subtotal  			= $subtotal + $p->total;;
		    $subtotaldus 		= $subtotaldus + $jmldus;
		    $subtotalpack 		= $subtotalpack + $jmlpack;
		    $subtotalpcs 		= $subtotalpcs + $jmlpcs;
		    $subtotalretur 		= $subtotalretur + $p->totalretur;
		    $subtotalpenyharga	= $subtotalpenyharga + $p->penyharga;
		    $subtotalpotongan	= $subtotalpotongan + $p->potongan;
		    $subtotalpotist		= $subtotalpotist + $p->potistimewa;
		    $subtotalnetto  	= $subtotalnetto + $p->totalpiutang;


		   
		?>
		<tr>
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $no;?></td>
			
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $p->id_karyawan;?></td>
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $p->nama_karyawan;?></td>
			
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?>><?php echo $barang1['nama_barang'];?></td>
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?> align="center"><?php echo $jmldus;?></td>
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?> align="right"><?php echo number_format($barang1['harga_dus'],'0','','.');?></td>
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?> align="center"><?php echo $jmlpack;?></td>
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?> align="right"><?php echo number_format($barang1['harga_pack'],'0','','.');?></td>
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?> align="center"><?php echo $jmlpcs;?></td>
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?> align="right"><?php echo number_format($barang1['harga_pcs'],'0','','.');?></td>
			<td <?php if($barang1['promo'] ==1){?> style="background-color: yellow" <?php } ?> align="right"><?php echo number_format($barang1['subtotal'],'0','','.');?></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($p->subtotal,'0','','.');?></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($p->totalretur,'0','','.');?></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($p->penyharga,'0','','.');?></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($p->potongan,'0','','.');?></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($p->potistimewa,'0','','.');?></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($p->totalpiutang,'0','','.');?></td>
			<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo strtoupper($p->jenistransaksi);?></td>
		</tr>

	<?php 
		if($jmlbarang > 1 ){			

			$query2    = "SELECT detailpenjualan.no_fak_penj,detailpenjualan.kode_barang,nama_barang,jumlah,isipcsdus,
						  isipack,isipcs,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs
						  ,detailpenjualan.subtotal,promo
						  FROM detailpenjualan 
						  INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj
						  INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
						  WHERE id_karyawan = '$p->id_karyawan' ORDER BY detailpenjualan.kode_barang ASC LIMIT 1,$jmlbarang";
			$barang2 	= $this->db->query($query2)->result();
			
			foreach($barang2 as $b2){
				$jmldus    = floor($b2->jumlah / $b2->isipcsdus);
			    $sisadus   = $b2->jumlah % $b2->isipcsdus;
			    if($b2->isipack == 0){
			        $jmlpack    = 0;
			        $sisapack   = $sisadus;   
			    }else{

			        $jmlpack    = floor($sisadus / $b2->isipcs);  
			        $sisapack   = $sisadus % $b2->isipcs;  
			    }

			    $jmlpcs = $sisapack;

			    $totaldus2 		= $totaldus2 + $jmldus;
			    $totalpack2		= $totalpack2 + $jmlpack; 
			    $totalpcs2 		= $totalpcs2 + $jmlpcs;

			    $subtotaldus2 	= $subtotaldus2 + $jmldus;
			    $subtotalpack2 	= $subtotalpack2 + $jmlpack;
			    $subtotalpcs2 	= $subtotalpcs2 + $jmlpcs;

			    if($b2->promo ==1){ $color = "background-color:yellow"; }else{$color="background-color:white";}
				echo "<tr style=$color>";
				echo "<td>$b2->nama_barang</td>";
				echo "<td align='center'>$jmldus</td>";
				echo "<td align='right'>".number_format($b2->harga_dus,'0','','.')."</td>";
				echo "<td align='center'>$jmlpack</td>";
				echo "<td align='right'>".number_format($b2->harga_pack,'0','','.')."</td>";
				echo "<td align='center'>$jmlpcs</td>";
				echo "<td align='right'>".number_format($b2->harga_pcs,'0','','.')."</td>";
				echo "<td align='right'>".number_format($b2->subtotal,'0','','.')."</td>";
				echo "</tr>";
			}

		}
		
		$no++;
	} 

	?>
	</tbody>
	<tr bgcolor="#024a75" style="color:white; font-weight:bold">
		<td colspan="6" >TOTAL</td>
		<td align="center"><?php echo $totaldus + $totaldus2; ?></td>
		<td></td>
		<td align="center"><?php echo $totalpack + $totalpack2; ?></td>
		<td></td>
		<td align="center"><?php echo $totalpcs + $totalpcs2; ?></td>
		<td></td>
		<td align="right"><?php echo number_format($total,'0','','.');?></td>
		<td align="right"><?php echo number_format($total,'0','','.');?></td>
		<td align="right"><?php echo number_format($totalretur,'0','','.');?></td>
		<td></td>
		<td align="right"><?php echo number_format($totalpenyharga,'0','','.');?></td>
		<td align="right"><?php echo number_format($totalpotongan,'0','','.');?></td>
		<td align="right"><?php echo number_format($totalpotist,'0','','.');?></td>
		<td align="right"><?php echo number_format($netto,'0','','.');?></td>
		<td></td>
	</tr>
</table>
<?php  } ?>