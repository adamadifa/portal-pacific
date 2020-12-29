<?php
error_reporting(0);
function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}

?>

<?php

if ($dari < '2018-09-01') {
?>

  <div class="alert alert-danger">
    <strong>Sorry Bro!</strong> Maaf Untuk Data Penjualan Kurang Dari Bulan September 2018 Tidak Dapat Ditampilkan.!
  </div>
<?php


} else {
?>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
  <br>
  <b style="font-size:16px; font-family:Calibri">
    REKAP KAS BESAR ALL SALES
    <br>
    CABANG <?php echo $cabang; ?>
    <br>
    PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
  </b>
  <br>
  <br>
  <table class="datatable3" style="width:40%" border="1">
    <thead bgcolor="#024a75" style="color:white; font-size:12;">
      <tr bgcolor="#024a75" style="color:white; font-size:12;">
        <th>ID SALES</th>
        <th>NAMA SALES</th>
        <th>Cash IN</th>
        <th>Voucher</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalvoucher = 0;
      $totalcashin =  0;
      foreach ($rekapkasbesarsales as $r) {
        $totalcashin = $totalcashin + $r->cashin;
        $totalvoucher = $totalvoucher + $r->voucher ?>
        <tr style="font-size:12">
          <td style="font-weight:bold"><?php echo strtoUpper($r->id_karyawan); ?></td>
          <td style="font-weight:bold"><?php echo strtoUpper($r->nama_karyawan); ?></td>
          <td style="text-align:right; font-weight:bold"><?php echo uang($r->cashin); ?></td>
          <td style="text-align:right; font-weight:bold"><?php echo uang($r->voucher); ?></td>
          <td style="text-align:right; font-weight:bold"><?php echo uang($r->voucher + $r->cashin); ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr bgcolor="#024a75" style="color:white; font-size:12;">
        <td style="font-weight:bold" colspan="2">TOTAL</td>
        <td style="text-align:right; font-weight:bold"><?php echo uang($totalcashin); ?></td>
        <td style="text-align:right; font-weight:bold"><?php echo uang($totalvoucher); ?></td>
        <td style="text-align:right; font-weight:bold"><?php echo uang($totalvoucher + $totalcashin); ?></td>
      </tr>
    </tfoot>
  <?php } ?>