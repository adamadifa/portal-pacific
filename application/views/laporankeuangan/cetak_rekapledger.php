<?php
function uang($nilai){
  return number_format($nilai,'2',',','.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  PACIFIC<br>
  DETAIL LEDGER BANK <?php echo $bank['nama_bank']; ?><br>
  PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br><br>
</b>
<br>
<table class="datatable3">
  <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr>
      <th>Kode Akun</th>
      <th>Nama Akun</th>
      <th>Debet</th>
      <th>Kredit</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $totaldebet = 0;
    $totalkredit= 0;
    foreach($rekap as $r){
      $totaldebet = $totaldebet + $r->debet;
      $totalkredit = $totalkredit + $r->kredit;
      ?>
      <tr>
        <td><?php echo $r->kode_akun; ?></td>
        <td><?php echo $r->nama_akun; ?></td>
        <td align="right"><?php if($r->debet!=0){echo uang($r->debet);}?></td>
        <td align="right"><?php if($r->kredit!=0){echo uang($r->kredit);}?></td>
      </tr>
      <?php

    }
    ?>
    <tr bgcolor="#024a75" style="color:white; font-size:12;">
      <th colspan='2'>TOTAL</th>
      <th style='text-align:right'><?php if($totaldebet!=0){echo uang($totaldebet);}?></th>
      <th style='text-align:right'><?php if($totalkredit!=0){echo uang($totalkredit);}?></th>    </tr>
    </tbody>
  </table>
