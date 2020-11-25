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
  <b style="font-size:16px; font-family:Calibri">
    REKAP PENJUALAN ALL CABANG
    <br>
    PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
  </b>
  <br>
  <br>
  <table class="datatable3" style="width:60%" border="1">
   <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr bgcolor="#024a75" style="color:white; font-size:12;">
     <th>CABANG</th>
     <th>TOTAL BRUTO</th>
     <th>TOTAL RETUR</th>
     <th>PENYESUAIAN</th>
     <th>POTONGAN</th>
     <th>POTONGAN ISTIMEWA</th>
     <th>TOTAL NETTO</th>
   </tr>
 </thead>
 <tbody>
  <?php 
  
  $totalbruto 		= 0;
  $totalretur 		= 0;
  $totalpenyharga 	= 0;
  $totalpotongan		= 0;
  $totalpotistimewa	= 0;
  $grandnetto 		= 0;
  
  
  foreach($rekappenjualancabang as $r){ 
   $totalbruto 		= $totalbruto + $r->totalbruto; 
   $totalretur 		= $totalretur + $r->totalretur;
   $totalpenyharga 	= $totalpenyharga + $r->totalpenyharga;
   $totalpotongan 		= $totalpotongan + $r->totalpotongan;
   $totalpotistimewa 	= $totalpotistimewa + $r->totalpotistimewa;
   
   $totalnetto 		= $r->totalbruto-$r->totalretur-$r->totalpenyharga-$r->totalpotongan-$r->totalpotistimewa;
   $grandnetto 		= $grandnetto + $totalnetto;
   
   ?>
   <tr style="font-size:12">
    <td style="font-weight:bold"><?php echo strtoUpper($r->nama_cabang); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo uang($r->totalbruto); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo uang($r->totalretur); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo uang($r->totalpenyharga); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo uang($r->totalpotongan); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo uang($r->totalpotistimewa); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo uang($totalnetto); ?></td>
  </tr>
<?php } ?>
</tbody>
<tfoot>
 <tr bgcolor="#024a75" style="color:white; font-size:12;">
  <td style="font-weight:bold">TOTAL</td>
  <td style="text-align:right; font-weight:bold"><?php echo uang($totalbruto); ?></td>
  <td style="text-align:right; font-weight:bold"><?php echo uang($totalretur); ?></td>
  <td style="text-align:right; font-weight:bold"><?php echo uang($totalpenyharga); ?></td>
  <td style="text-align:right; font-weight:bold"><?php echo uang($totalpotongan); ?></td>
  <td style="text-align:right; font-weight:bold"><?php echo uang($totalpotistimewa); ?></td>
  <td style="text-align:right; font-weight:bold"><?php echo uang($grandnetto); ?></td>
</tr>
</tfoot>
<?php } ?>