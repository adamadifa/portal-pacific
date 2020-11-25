<?php
//error_reporting(0);
function uang($nilai){
  return number_format($nilai,'0','','.');
}
?>

<table class="table table-striped card-table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th colspan="7">REKAP PENJUALAN</th>
    </tr>
    <tr class="text-right">
     <th class="text-left">CABANG</th>
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
  
  $totalbruto 		  = 0;
  $totalretur 		  = 0;
  $totalpenyharga 	= 0;
  $totalpotongan		= 0;
  $totalpotistimewa	= 0;
  $grandnetto 		  = 0;
  
  
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
    <td style="text-align:right; font-weight:"><?php echo uang($r->totalbruto); ?></td>
    <td style="text-align:right; font-weight:"><?php echo uang($r->totalretur); ?></td>
    <td style="text-align:right; font-weight:"><?php echo uang($r->totalpenyharga); ?></td>
    <td style="text-align:right; font-weight:"><?php echo uang($r->totalpotongan); ?></td>
    <td style="text-align:right; font-weight:"><?php echo uang($r->totalpotistimewa); ?></td>
    <td style="text-align:right; font-weight:bold"><?php echo uang($totalnetto); ?></td>
  </tr>
<?php } ?>
</tbody>
<tfoot class="thead-dark">
 <tr>
  <th style="font-weight:bold">TOTAL</th>
  <th style="text-align:right; font-weight:bold"><?php echo uang($totalbruto); ?></th>
  <th style="text-align:right; font-weight:bold"><?php echo uang($totalretur); ?></th>
  <th style="text-align:right; font-weight:bold"><?php echo uang($totalpenyharga); ?></th>
  <th style="text-align:right; font-weight:bold"><?php echo uang($totalpotongan); ?></th>
  <th style="text-align:right; font-weight:bold"><?php echo uang($totalpotistimewa); ?></th>
  <th style="text-align:right; font-weight:bold"><?php echo uang($grandnetto); ?></th>
</tr>
</tfoot>
</table>