<?php
	error_reporting(0);
	function uang($nilai){

		return number_format($nilai,'2',',','.');
	}
	
	function uangs($nilai){

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
	REKAPITULASI PENJUALAN<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
	<br>
	<br>
	


<table class="datatable3">
	<thead>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th rowspan="2">No</th>
			<th rowspan="2">Nama Produk</th>
			<th colspan="9">Cabang</th>
			<th rowspan="2">Total</th>
		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th>Bandung</th>
			<th>Bogor</th>
			<th>Sukabumi</th>
			<th>Purwokerto</th>
			<th>Tegal</th>
			<th>Tasik</th>
			<th>Semarang</th>
			<th>Surabaya</th>
			<th>Pusat</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
			$no=1; foreach($rekap as $r){
				
				$bandung 	= $r->BDG / $r->isipcsdus;
				$bogor 		= $r->BGR / $r->isipcsdus;
				$sukabumi 	= $r->SKB / $r->isipcsdus;
				$purwokerto = $r->PWT / $r->isipcsdus;
				$tegal 		= $r->TGL / $r->isipcsdus;
				$tasik 		= $r->TSM / $r->isipcsdus;
				$semarang 	= $r->SMR / $r->isipcsdus;
				$surabaya 	= $r->SBY / $r->isipcsdus;
				$pusat 		= $r->PST / $r->isipcsdus;
				$totalqty 	= $r->totalqty / $r->isipcsdus;
				
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $r->nama_barang; ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($bandung)){echo uang($bandung);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($bogor)){echo uang($bogor);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($sukabumi)){echo uang($sukabumi);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($purwokerto)){echo uang($purwokerto);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($tegal)){echo uang($tegal);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($tasik)){echo uang($tasik);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($semarang)){echo uang($semarang);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($surabaya)){echo uang($surabaya);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($pusat)){echo uang($pusat);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($totalqty)){echo uang($totalqty);} ?></td>
			</tr>
			<?php $no++; } ?>
	</tbody>
</table>
<br>
<br>
<table class="datatable3">
	<thead>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th rowspan="2">No</th>
			<th rowspan="2">Nama Produk</th>
			<th colspan="9">Cabang</th>
			<th rowspan="2">Total</th>
		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th>Bandung</th>
			<th>Bogor</th>
			<th>Sukabumi</th>
			<th>Purwokerto</th>
			<th>Tegal</th>
			<th>Tasik</th>
			<th>Semarang</th>
			<th>Surabaya</th>
			<th>Pusat</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
			$no=1; foreach($rekap as $r){
				
				
				if(!empty($r->BDG)){
					
					$bandung 	= $r->JML_BDG/($r->BDG / $r->isipcsdus);
				}else{
					$bandung = 0;
				}
				
				if(!empty($r->BGR)){
					
					$bogor 		= $r->JML_BGR/($r->BGR / $r->isipcsdus);
				}else{
					$bogor = 0;
				}
				
				if(!empty($r->SKB)){
					
					$sukabumi 	= $r->JML_SKB/($r->SKB / $r->isipcsdus);
				}else{
					$sukabumi = 0;
				}
				
				if(!empty($r->PWT)){
					
					$purwokerto = $r->JML_PWT/($r->PWT / $r->isipcsdus);
				}else{
					$purwokerto = 0;
				}
				
				if(!empty($r->TGL)){
					
					$tegal 		= $r->JML_TGL/($r->TGL / $r->isipcsdus);
				}else{
					$tegal = 0;
				}
				
				if(!empty($r->TSM)){
					
					$tasik 		= $r->JML_TSM/($r->TSM / $r->isipcsdus);
				}else{
					$tasik 		= 0;
				}
				
				if(!empty($r->SMR)){
					
					$semarang 		= $r->JML_SMR/($r->SMR / $r->isipcsdus);
				}else{
					$semarang 		= 0;
				}
				
				if(!empty($r->SBY)){
					
					$surabaya 		= $r->JML_SBY/($r->SBY / $r->isipcsdus);
				}else{
					$surabaya 		= 0;
				}
				
				if(!empty($r->PST)){
					
					$pusat 		= $r->JML_PST/($r->PST / $r->isipcsdus);
				}else{
					$pusat 		= 0;
				}
				
				
				$totalqty 	= ($bandung+$bogor+$sukabumi+$purwokerto+$tegal+$tasik+$semarang+$surabaya+$pusat)/9;
				
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $r->nama_barang; ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->BDG)){echo uangs($bandung);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->BGR)){echo uangs($bogor);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->SKB)){echo uangs($sukabumi);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->PWT)){echo uangs($purwokerto);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->TGL)){echo uangs($tegal);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->TSM)){echo uangs($tasik);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->TSM)){echo uangs($semarang);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->TSM)){echo uangs($surabaya);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($r->PST)){echo uangs($pusat);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($totalqty)){echo uangs($totalqty);} ?></td>
			</tr>
			<?php $no++; } ?>
	</tbody>
</table>

<?php } ?>