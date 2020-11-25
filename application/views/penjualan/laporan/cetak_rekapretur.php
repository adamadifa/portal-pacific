<?php
error_reporting(0);
function uang($nilai){

  return number_format($nilai,'0','','.');
}

function qty($nilai){

  return number_format($nilai,'2',',','.');
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
   REKAPITULASI RETUR<br>
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
 <table class="datatable3" style="width:150%" border="1">
   <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr bgcolor="#024a75" style="color:white; font-size:12;">
     <td rowspan="3">No</td>
     <td rowspan="3">Nama Sales</td>
     <td colspan="20">Produk</td>
     <td rowspan="3" bgcolor="#f5ae15" >Total Retur</td>
     <td rowspan="3" bgcolor="#f5ae15" >Penyeseuaian</td>
     <td rowspan="3" bgcolor="#f5ae15" >Total Retur Netto</td>
   </tr>
   <tr  bgcolor="#024a75" style="color:white; font-size:12;">
     <td colspan="2">AIDA BESAR 500 GR</td>
     <td colspan="2">AIDA KECIL SACHET</td>
     <td colspan="2">AIDA BESAR 250 GR</td>
     <td colspan="2">SAOS BAWANG BALL</td>
     <td colspan="2">CABE GILING KG</td>
     <td colspan="2">CABE GILING MURAH</td>
     <td colspan="2">SAOS BAWANG DUS</td>
     <td colspan="2">SAUS EXTRA PEDAS</td>
     <td colspan="2">KECAP DUS</td>
     <td colspan="2">SAUS STICK</td>
   </tr>
   <tr  bgcolor="#024a75" style="color:white; font-size:12;">
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
     <td>Qty</td>
     <td>Rp</td>
   </tr>
 </thead>
 <tbody>
  <?php
  $no 					= 1;
  $qtytotalAB 			= 0;
  $qtytotalAR 			= 0;
  $qtytotalASE 			= 0;
  $qtytotalBB 			= 0;
  $qtytotalCG 			= 0;
  $qtytotalCGG 			= 0;
  $qtytotalDB 			= 0;
  $qtytotalDEP 			= 0;
  $qtytotalDK 			= 0;
  $qtytotalDS 			= 0;
  
  $grandtytotalAB 		= 0;
  $grandtytotalAR 		= 0;
  $grandtytotalASE 		= 0;
  $grandtytotalBB 		= 0;
  $grandtytotalCG 		= 0;
  $grandtytotalCGG 		= 0;
  $grandtytotalDB 		= 0;
  $grandtytotalDEP 		= 0;
  $grandtytotalDK 		= 0;
  $grandtytotalDS 		= 0;
  
  
  
  $totalAB 				= 0;
  $totalAR 				= 0;
  $totalASE 				= 0;
  $totalBB 				= 0;
  $totalCG 				= 0;
  $totalCGG 				= 0;
  $totalDB 				= 0;
  $totalDEP 				= 0;
  $totalDK 				= 0;
  $totalDS 				= 0;
  
  $grandtotalAB 			= 0;
  $grandtotalAR 			= 0;
  $grandtotalASE 			= 0;
  $grandtotalBB 			= 0;
  $grandtotalCG 			= 0;
  $grandtotalCGG 			= 0;
  $grandtotalDB 			= 0;
  $grandtotalDEP 			= 0;
  $grandtotalDK 			= 0;
  $grandtotalDS 			= 0;
  
  
  $totalretur 			= 0;
  $totalpenyesuaian 		= 0;
  $totalreturnetto 		= 0;
  $grandtotalreturnetto   = 0;
  $grandtotalretur		= 0;
  $grandtotalpenyesuaian  = 0;
  $grandtotalallreturnetto=0;
  foreach ($rekap as $key => $p){ 
   
    $rek  = @$rekap[$key+1]->kode_cabang;
    $qtytotalAB 			= $qtytotalAB + $p->JML_AB;
    $qtytotalAR 			= $qtytotalAR + $p->JML_AR;
    $qtytotalASE 			= $qtytotalASE + $p->JML_ASE;
    $qtytotalBB 			= $qtytotalBB + $p->JML_BB;
    $qtytotalCG 			= $qtytotalCG + $p->JML_CG;
    $qtytotalCGG 			= $qtytotalCGG + $p->JML_CGG;
    $qtytotalDB 			= $qtytotalDB + $p->JML_DB;
    $qtytotalDEP 			= $qtytotalDEP + $p->JML_DEP;
    $qtytotalDK 			= $qtytotalDK + $p->JML_DK;
    $qtytotalDS 			= $qtytotalDS + $p->JML_DS;
    
    $grandtytotalAB 		= $grandtytotalAB + $p->JML_AB;
    $grandtytotalAR 		= $grandtytotalAR + $p->JML_AR;
    $grandtytotalASE 		= $grandtytotalASE + $p->JML_ASE;
    $grandtytotalBB 		= $grandtytotalBB + $p->JML_BB;
    $grandtytotalCG 		= $grandtytotalCG + $p->JML_CG;
    $grandtytotalCGG 		= $grandtytotalCGG + $p->JML_CGG;
    $grandtytotalDB 		= $grandtytotalDB + $p->JML_DB;
    $grandtytotalDEP 		= $grandtytotalDEP + $p->JML_DEP;
    $grandtytotalDK 		= $grandtytotalDK + $p->JML_DK;
    $grandtytotalDS 		= $grandtytotalDS + $p->JML_DS;
    
    
    $totalAB 				= $totalAB + $p->AB;
    $totalAR 				= $totalAR + $p->AR;
    $totalASE 				= $totalASE + $p->ASE;
    $totalBB 				= $totalBB + $p->BB;
    $totalCG 				= $totalCG + $p->CG;
    $totalCGG				= $totalCGG + $p->CGG;
    $totalDB 				= $totalDB + $p->DB;
    $totalDEP 				= $totalDEP + $p->DEP;
    $totalDK 				= $totalDK + $p->DK;
    $totalDS 				= $totalDS + $p->DS;
    
    $grandtotalAB 			= $grandtotalAB + $p->AB;
    $grandtotalAR 			= $grandtotalAR + $p->AR;
    $grandtotalASE 			= $grandtotalASE + $p->ASE;
    $grandtotalBB 			= $grandtotalBB + $p->BB;
    $grandtotalCG 			= $grandtotalCG + $p->CG;
    $grandtotalCGG			= $grandtotalCGG + $p->CGG;
    $grandtotalDB 			= $grandtotalDB + $p->DB;
    $grandtotalDEP 			= $grandtotalDEP + $p->DEP;
    $grandtotalDK 			= $grandtotalDK + $p->DK;
    $grandtotalDS 			= $grandtotalDS + $p->DS;
    
    $totalretur				= $totalretur + $p->totalretur;
    $grandtotalretur 		= $grandtotalretur + $p->totalretur;
    $totalpenyesuaian 		= $totalpenyesuaian + $p->total_gb;
    $grandtotalpenyesuaian 	= $grandtotalpenyesuaian + $p->total_gb;
    $totalreturnetto 		= $p->totalretur - $p->total_gb;
    $grandtotalreturnetto 	= $grandtotalreturnetto + $totalreturnetto;
    $grandtotalallreturnetto= $grandtotalallreturnetto + $totalreturnetto;
    ?>
    <tr>
     <td><?php echo $no; ?></td>
     <td><?php echo $p->nama_karyawan; ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_AB)){echo qty($p->JML_AB);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->AB)){echo uang($p->AB);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_AR)){echo qty($p->JML_AR);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->AR)){echo uang($p->AR);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_ASE)){echo qty($p->JML_ASE);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->ASE)){echo uang($p->ASE);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_BB)){echo qty($p->JML_BB);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->BB)){echo uang($p->BB);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_CG)){echo qty($p->JML_CG);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->CG)){echo uang($p->CG);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_CGG)){echo qty($p->JML_CGG);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->CGG)){echo uang($p->CGG);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_DB)){echo qty($p->JML_DB);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->DB)){echo uang($p->DB);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_DEP)){echo qty($p->JML_DEP);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->DEP)){echo uang($p->DEP);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_DK)){echo qty($p->JML_DK);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->DK)){echo uang($p->DK);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->JML_DS)){echo qty($p->JML_DS);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->DS)){echo uang($p->DS);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->totalretur)){echo uang($p->totalretur);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($p->total_gb)){echo uang($p->total_gb);} ?></td>
     <td style="text-align:right; font-weight:bold"><?php if (!empty($totalreturnetto)){echo uang($totalreturnetto);} ?></td>
   </tr>
   <?php

   if ($rek != $p->kode_cabang) {
     echo '
     <tr bgcolor="#024a75" style="color:white; font-weight:bold">
     <td colspan="2" >TOTAL '. $p->kode_cabang.'</td>
     <td align="right" >'. qty($qtytotalAB).'</td>
     <td align="right" >'. uang($totalAB).'</td>
     <td align="right" >'. qty($qtytotalAR).'</td>
     <td align="right" >'. uang($totalAR).'</td>
     <td align="right" >'. qty($qtytotalASE).'</td>
     <td align="right" >'. uang($totalASE).'</td>
     <td align="right" >'. qty($qtytotalBB).'</td>
     <td align="right" >'. uang($totalBB).'</td>
     <td align="right" >'. qty($qtytotalCG).'</td>
     <td align="right" >'. uang($totalCG).'</td>
     <td align="right" >'. qty($qtytotalCGG).'</td>
     <td align="right" >'. uang($totalCGG).'</td>
     <td align="right" >'. qty($qtytotalDB).'</td>
     <td align="right" >'. uang($totalDB).'</td>
     <td align="right" >'. qty($qtytotalDEP).'</td>
     <td align="right" >'. uang($totalDEP).'</td>
     <td align="right" >'. qty($qtytotalDK).'</td>
     <td align="right" >'. uang($totalDK).'</td>
     <td align="right" >'. qty($qtytotalDS).'</td>
     <td align="right" >'. uang($totalDS).'</td>
     <td align="right" >'. uang($totalretur).'</td>
     <td align="right" >'. uang($totalpenyesuaian).'</td>
     <td align="right" >'. uang($grandtotalreturnetto).'</td>
     </tr>';
     $qtytotalAB 			= 0;
     $qtytotalAR 			= 0;
     $qtytotalASE 			= 0;
     $qtytotalBB 			= 0;
     $qtytotalCG 			= 0;
     $qtytotalCGG 			= 0;
     $qtytotalDB 			= 0;
     $qtytotalDEP 			= 0;
     $qtytotalDK 			= 0;
     $qtytotalDS 			= 0;
     
     
     $totalAB 				= 0;
     $totalAR 				= 0;
     $totalASE 				= 0;
     $totalBB 				= 0;
     $totalCG 				= 0;
     $totalCGG 				= 0;
     $totalDB 				= 0;
     $totalDEP 				= 0;
     $totalDK 				= 0;
     $totalDS 				= 0;
     
     $totalretur 			= 0;
     $totalpenyesuaian 		= 0;
     $grandtotalreturnetto 	= 0;
   }
   $rek  = $p->kode_cabang;	
   $no++;
 }
 ?>
</tbody>
<tfoot>
  <tr bgcolor="#ec8585" style="font-weight:bold">
   <td colspan="2">TOTAL RETUR</td>
   <td align="right"><?php echo qty($grandtytotalAB); ?></td>
   <td align="right"><?php echo uang($grandtotalAB); ?></td>
   <td align="right"><?php echo qty($grandtytotalAR); ?></td>
   <td align="right"><?php echo uang($grandtotalAR); ?></td>
   <td align="right"><?php echo qty($grandtytotalASE); ?></td>
   <td align="right"><?php echo uang($grandtotalASE); ?></td>
   <td align="right"><?php echo qty($grandtytotalBB); ?></td>
   <td align="right"><?php echo uang($grandtotalBB); ?></td>
   <td align="right"><?php echo qty($grandtytotalCG); ?></td>
   <td align="right"><?php echo uang($grandtotalCG); ?></td>
   <td align="right"><?php echo qty($grandtytotalCGG); ?></td>
   <td align="right"><?php echo uang($grandtotalCGG); ?></td>
   <td align="right"><?php echo qty($grandtytotalDB); ?></td>
   <td align="right"><?php echo uang($grandtotalDB); ?></td>
   <td align="right"><?php echo qty($grandtytotalDEP); ?></td>
   <td align="right"><?php echo uang($grandtotalDEP); ?></td>
   <td align="right"><?php echo qty($grandtytotalDK); ?></td>
   <td align="right"><?php echo uang($grandtotalDK); ?></td>
   <td align="right"><?php echo qty($grandtytotalDS); ?></td>
   <td align="right"><?php echo uang($grandtotalDS); ?></td>
   <td align="right"><?php echo uang($grandtotalretur); ?></td>
   <td align="right"><?php echo uang($grandtotalpenyesuaian); ?></td>
   <td align="right"><?php echo uang($grandtotalallreturnetto); ?></td>
 </tr>
</tfoot>
</table>	
<br>
<br>
<?php 
$totalqtyretur  = $grandtytotalAB + $grandtytotalAR  + $grandtytotalASE  + $grandtytotalBB  + $grandtytotalCG + $grandtytotalCGG  + $grandtytotalDB + $grandtytotalDEP + $grandtytotalDK + $grandtytotalDS   ;
$average 		= $grandtotalpenyesuaian / $totalqtyretur;
$avgAB 			= $grandtytotalAB * $average;
$avgAR 			= $grandtytotalAR * $average;
$avgASE 		= $grandtytotalASE * $average;
$avgBB 			= $grandtytotalBB * $average;
$avgCG 			= $grandtytotalCG * $average;
$avgCGG 		= $grandtytotalCGG * $average;
$avgDB 			= $grandtytotalDB * $average;
$avgDEP 		= $grandtytotalDEP * $average;
$avgDK 			= $grandtytotalDK * $average;
$avgDS 			= $grandtytotalDS * $average;

?>
<table class="datatable3" style="width:120%">
	<thead>
		<tr bgcolor="#ec8585">
			<th style="text-align:right; font-weight:bold" colspan="2">PENYESUAIAN RETUR</th>
			<th >AIDA BESAR 500 GR</th>
			<th >AIDA KECIL SACHET</th>
			<th >AIDA BESAR 250 GR</th>
			<th >SAOS BAWANG BALL</th>
			<th >CABE GILING KG</th>
			<th >CABE GILING MURAH</th>
			<th >SAOS BAWANG DUS</th>
			<th >SAUS EXTRA PEDAS</th>
			<th >KECAP DUS</th>
			<th >SAUS STICK</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>TOTAL QTY RETUR</td>
			<td style="text-align:right; font-weight:bold"><?php if (!empty($totalqtyretur)){echo qty($totalqtyretur);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgAB)){echo  uang($avgAB);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgAR)){echo  uang($avgAR);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgASE)){echo uang($avgASE);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgBB)){echo  uang($avgBB);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgCG)){echo  uang($avgCG);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgCGG)){echo uang($avgCGG);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgDB)){echo  uang($avgDB);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgDEP)){echo uang($avgDEP);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgDK)){echo  uang($avgDK);} ?></td>
			<td style="text-align:right; font-weight:bold" rowspan="3"><?php if (!empty($avgDS)){echo  uang($avgDS);} ?></td>
			
		</tr>
		<tr>
			<td>PENYESUAIAN HARGA RETUR</td>
			<td style="text-align:right; font-weight:bold"><?php if (!empty($grandtotalpenyesuaian)){echo qty($grandtotalpenyesuaian);} ?></td>
		</tr>
		<tr>
			<td>AVERAGE</td>
			<td style="text-align:right; font-weight:bold"><?php if (!empty($average)){echo uang($average);} ?></td>
			
		</tr>
	</tbody>

</table>

<?php  } ?>