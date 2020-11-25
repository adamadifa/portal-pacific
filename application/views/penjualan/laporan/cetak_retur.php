
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">
	
	
	<?php 
		//error_reporting(0);
		if($cb['nama_cabang'] != ""){
			echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
		}else{
			echo "PACIFIC ALL CABANG";
		}
		 
	?>
	<br>
	LAPORAN RETUR PENJUALAN<br>
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

<table class="datatable3" style="width:130%">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td rowspan="2">No</td>
			<td rowspan="2">Tanggal Retur</td>
			<td rowspan="2">No Faktur</td>
			<td rowspan="2">Kode Pel.</td>
			<td rowspan="2">Nama Pelanggan</td>
			<td rowspan="2">Pasar/Daerah</td>
			<td rowspan="2">Hari</td>
			<td rowspan="2">Nama Barang</td>
			<td colspan="7" align="center">QTY</td>
			<td rowspan="2">Retur PF</td>
			<td rowspan="2">Retur GB</td>
			<td rowspan="2">Retur Netto</td>
			<td rowspan="2">TUNAI/KREDIT</td>
			<td rowspan="2">Tanggal Input</td>
			<td rowspan="2">Tanggal Update</td>
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
			$no 				= 1; 
			$totaldus 			= 0;
			$totalpack 			= 0;
			$totalpcs 			= 0;
			$totaldus2 			= 0;
			$totalpack2 		= 0;
			$totalpcs2 			= 0;
			$returpf 			= 0;
			$returgb 			= 0;
			$netto 				= 0;
			foreach($retur as $r){
				$jmlbarang = $this->db->get_where('detailretur',array('no_retur_penj'=>$r->no_retur_penj))->num_rows();
				$query1    = "SELECT no_fak_penj,detailretur.kode_barang,nama_barang,jumlah,isipcsdus,
							  isipack,isipcs,detailretur.harga_dus,detailretur.harga_pack,detailretur.harga_pcs
							  ,subtotal 
							  FROM detailretur 
							  INNER JOIN barang ON detailretur.kode_barang = barang.kode_barang
							  WHERE no_retur_penj = '$r->no_retur_penj' ORDER BY detailretur.kode_barang ASC LIMIT 1";
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

			    $totaldus 		= $totaldus + $jmldus;
			    $totalpack 		= $totalpack + $jmlpack;
			    $totalpcs 		= $totalpcs + $jmlpcs;
			    $returpf 		= $returpf + $r->subtotal_pf;
			    $returgb 		= $returgb + $r->subtotal_gb;
			    $netto 			= $netto + $r->total;
		?>	
			<tr>
				<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $no; ?></td>
				<td rowspan="<?php echo $jmlbarang; ?>"><?php echo DateToIndo2($r->tglretur); ?></td>
				<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $r->no_fak_penj;?></td>
				<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $r->kode_pelanggan;?></td>
				<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $r->nama_pelanggan;?></td>
				<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $r->pasar;?></td>
				<td rowspan="<?php echo $jmlbarang; ?>"><?php echo $r->hari;?></td>
				

				<td><?php echo $barang1['nama_barang'];?></td>
				<td align="center">
					<?php if($jmldus !=0){ echo $jmldus; }?>
				</td>
				<td align="right">
					<?php if($jmldus !=0){ echo number_format($barang1['harga_dus'],'0','','.'); }?>
				</td>
				<td align="center">
					<?php if($jmlpack !=0){ echo $jmlpack; }?>
				</td>
				<td align="right">
					<?php if($jmlpack !=0){ echo number_format($barang1['harga_pack'],'0','','.'); }?>
				</td>
				<td align="center">
					<?php if($jmlpcs !=0){ echo $jmlpcs; }?>
				</td>
				<td align="right">
					<?php if($jmlpcs !=0){ echo number_format($barang1['harga_pcs'],'0','','.'); }?>
				</td>
				<td align="right"><?php echo number_format($barang1['subtotal'],'0','','.');?>	</td>




				<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($r->subtotal_pf,'0','','.');?></td>
				<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($r->subtotal_gb,'0','','.');?></td>
				<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo number_format($r->total,'0','','.');?></td>
				<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo strtoupper($r->jenistransaksi);?></td>
				<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo $r->date_created;?></td>
				<td align="right" rowspan="<?php echo $jmlbarang; ?>"><?php echo $r->date_updated;?></td>
			</tr>
		<?php 
		if($jmlbarang > 1 ){			

			$query2    = "SELECT no_fak_penj,detailretur.kode_barang,nama_barang,jumlah,isipcsdus,
							  isipack,isipcs,detailretur.harga_dus,detailretur.harga_pack,detailretur.harga_pcs
							  ,subtotal 
							  FROM detailretur 
							  INNER JOIN barang ON detailretur.kode_barang = barang.kode_barang
							  WHERE no_retur_penj = '$r->no_retur_penj' ORDER BY detailretur.kode_barang ASC LIMIT 1,$jmlbarang";
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
			    ?>
				<tr>
					<td><?php echo $b2->nama_barang; ?></td>
					<td align='center'><?php if($jmldus !=0){ echo $jmldus; }?></td>
					<td align='right'><?php if($jmldus !=0){ echo number_format($b2->harga_dus,'0','','.'); }?></td>
					<td align='center'><?php if($jmlpack !=0){ echo $jmlpack; }?></td>
					<td align='right'><?php if($jmlpack !=0){ echo number_format($b2->harga_pack,'0','','.'); }?></td>
					<td align='center'><?php if($jmlpcs !=0){ echo $jmlpcs; }?></td>
					<td align='right'><?php if($jmlpcs !=0){ echo number_format($b2->harga_pcs,'0','','.'); }?></td>
					<td align='right'><?php echo number_format($b2->subtotal,'0','','.'); ?></td>
				</tr>
			<?php
			}

		}
		$no++;
	} 

	?>
	<tr bgcolor="#024a75" style="color:white; font-weight:bold">
		<td colspan="8" >TOTAL</td>
		<td align="center"><?php echo $totaldus + $totaldus2; ?></td>
		<td></td>
		<td align="center"><?php echo $totalpack + $totalpack2; ?></td>
		<td></td>
		<td align="center"><?php echo $totalpcs + $totalpcs2; ?></td>
		<td></td>
		<td></td>
		<td align="right"><?php echo number_format($returpf,'0','','.');?></td>
		<td align="right"><?php echo number_format($returgb,'0','','.');?></td>
		<td align="right"><?php echo number_format($netto,'0','','.');?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	</tbody>
</table>