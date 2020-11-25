<?php
	
	function uang($nilai){

		return number_format($nilai,'0','','.');
	}

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
	LAPORAN PENJUALAN<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
	
	<?php 
		if($salesman['nama_karyawan'] != ""){
			echo "NAMA SALES : ". strtoupper($salesman['nama_karyawan']);
		}else{
			echo "ALL SALES";
		}
		 
	?>
	<br>
	<?php 
		if($pelanggan['nama_pelanggan'] != ""){
			echo "NAMA PELANGGAN : ". strtoupper($pelanggan['nama_pelanggan']);
		}
	?>

</b>
<br>
<br>
<table class="datatable3" style="width:140%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td rowspan="2">No</td>
			<td rowspan="2">Tanggal</td>
			<td rowspan="2">No Faktur</td>
			<td rowspan="2">Kode Pel.</td>
			<td rowspan="2">Nama Pelanggan</td>
			<td rowspan="2">Pasar/Daerah</td>
			<td rowspan="2">Hari</td>
			<td rowspan="2">Nama Barang</td>
			<td colspan="6" align="center">QTY</td>
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
			
			foreach ($penjualan as $key => $p){ 
			$pel  = @$penjualan[$key+1]->kode_pelanggan;

			$jmlbarang = $this->db->get_where('detailpenjualan',array('no_fak_penj'=>$p->no_fak_penj))->num_rows();
			$query1    = "SELECT no_fak_penj,detailpenjualan.kode_barang,nama_barang,jumlah,isipcsdus,
						  isipack,isipcs,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs
						  ,subtotal 
						  FROM detailpenjualan 
						  INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
						  WHERE no_fak_penj = '$p->no_fak_penj' ORDER BY detailpenjualan.kode_barang ASC LIMIT 1";
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
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo DateToIndo2($p->tgltransaksi);?></td>
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $p->no_fak_penj;?></td>
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $p->kode_pelanggan;?></td>
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $p->nama_pelanggan;?></td>
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $p->pasar;?></td>
			<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $p->hari;?></td>
			<td><?php echo $barang1['nama_barang'];?></td>
			<td align="center"><?php echo $jmldus;?></td>
			<td align="right"><?php echo number_format($barang1['harga_dus'],'0','','.');?></td>
			<td align="center"><?php echo $jmlpack;?></td>
			<td align="right"><?php echo number_format($barang1['harga_pack'],'0','','.');?></td>
			<td align="center"><?php echo $jmlpcs;?></td>
			<td align="right"><?php echo number_format($barang1['harga_pcs'],'0','','.');?></td>
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

			$query2    = "SELECT no_fak_penj,detailpenjualan.kode_barang,nama_barang,jumlah,isipcsdus,
						  isipack,isipcs,detailpenjualan.harga_dus,detailpenjualan.harga_pack,detailpenjualan.harga_pcs
						  ,subtotal 
						  FROM detailpenjualan 
						  INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang
						  WHERE no_fak_penj = '$p->no_fak_penj' ORDER BY detailpenjualan.kode_barang ASC LIMIT 1,$jmlbarang";
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
				echo "<tr>";
				echo "<td>$b2->nama_barang</td>";
				echo "<td align='center'>$jmldus</td>";
				echo "<td align='right'>".number_format($b2->harga_dus,'0','','.')."</td>";
				echo "<td align='center'>$jmlpack</td>";
				echo "<td align='right'>".number_format($b2->harga_pack,'0','','.')."</td>";
				echo "<td align='center'>$jmlpcs</td>";
				echo "<td align='right'>".number_format($b2->harga_pcs,'0','','.')."</td>";
				echo "</tr>";
			}

		}

		 if ($pel != $p->kode_pelanggan) {
			echo '
			<tr bgcolor="#024a75" style="color:white; font-weight:bold">
				<td colspan="8" >SUB TOTAL</td>
				<td align="center">'.($subtotaldus+$subtotaldus2).'</td>
				<td></td>
				<td align="center">'.($subtotalpack+$subtotalpack2).'</td>
				<td></td>
				<td align="center">'.($subtotalpcs+$subtotalpcs2).'</td>
				<td></td>
				<td align="right">'.uang($subtotal).'</td>
				<td align="right">'.uang($subtotalretur).'</td>
				<td></td>
				<td align="right">'.uang($subtotalpenyharga).'</td>
				<td align="right">'.uang($subtotalpotongan).'</td>
				<td align="right">'.uang($subtotalpotist).'</td>
				<td align="right">'.uang($subtotalnetto).'</td>
				<td></td>
			</tr>';
			$subtotal 		  			= 0;
			$subtotaldus 	  			= 0;
			$subtotaldus2 	  			= 0;
			$subtotalpack 	  			= 0;
			$subtotalpack2 	 			= 0;
			$subtotalpcs 	  			= 0;
			$subtotalpcs2 	  			= 0;
			$subtotalretur 				= 0;
			$subtotalpenyharga 			= 0;
			$subtotalpotongan			= 0;
			$subtotalpotist				= 0;
			$subtotalnetto				= 0;
		}

		$pel  = $p->kode_pelanggan;	
		$no++;
	} 

	?>
	</tbody>
	<tr bgcolor="#024a75" style="color:white; font-weight:bold">
		<td colspan="8" >TOTAL</td>
		<td align="center"><?php echo $totaldus + $totaldus2; ?></td>
		<td></td>
		<td align="center"><?php echo $totalpack + $totalpack2; ?></td>
		<td></td>
		<td align="center"><?php echo $totalpcs + $totalpcs2; ?></td>
		<td></td>
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
