<?php

function uang($nilai)
{
  return number_format($nilai, '2', ',', '.');
}

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">


  <?php
  if ($cabang != "") {
    echo "PACIFIC CABANG " . strtoupper($cabang);
  } else {
    echo "PACIFIC ALL CABANG";
  }
  ?>
  <br>
  REKAP PENJUALAN BERDASARKAN KENDARAAN<br>
  NO POLISI : <?php echo $kendaraan; ?>
  <br>PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>

</b>
<br>
<br>

<table class="datatable3">
  <thead bgcolor="#295ea9" style="color:white; font-size:16;">
    <tr bgcolor="#295ea9" style="color:white; font-size:16;">
      <td rowspan="2" align="center">KODE PRODUK</td>
      <td rowspan="2" align="center">PENGAMBILAN</td>
      <td colspan="5" align="center" style="background-color: #166511ab;">BARANG KELUAR</td>
      <td rowspan="2" align="center" style="background-color: #166511ab;">TOTAL</td>
      <td rowspan="2" align="center" style="background-color: #ef2121cf;">SISA</td>
    </tr>
    <tr style="background-color: #166511ab;">
      <td align="center">PENJUALAN</td>
      <td align="center">GANTI BARANG</td>
      <td align="center">PROMOSI</td>
      <td align="center">TTR</td>
      <td align="center">PL HUTANG KIRIM</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rekapkendaraan as $d) {
      $totalbarangkeluar = ($d->jmlpenjualan + $d->jmlgantibarang + $d->jmlpromosi + $d->jmlttr + $d->jmlplhk) / $d->isipcsdus;
      $sisa = $d->jml_pengambilan - $totalbarangkeluar;

    ?>
      <tr style="font-size: 14px;">
        <td><?php echo $d->kode_produk; ?></td>
        <td style="text-align:right"><?php echo uang($d->jml_pengambilan); ?></td>
        <td style="text-align:right"><?php if (!empty($d->jmlpenjualan)) {
                                        echo uang($d->jmlpenjualan / $d->isipcsdus);
                                      } ?></td>
        <td style="text-align:right"><?php if ($d->jmlgantibarang > 0) {
                                        echo uang($d->jmlgantibarang / $d->isipcsdus);
                                      } ?></td>
        <td style="text-align:right"><?php if ($d->jmlpromosi > 0) {
                                        echo uang($d->jmlpromosi / $d->isipcsdus);
                                      } ?></td>
        <td style="text-align:right"><?php if ($d->jmlttr > 0) {
                                        echo uang($d->jmlttr / $d->isipcsdus);
                                      } ?></td>
        <td style="text-align:right"><?php if ($d->jmlplhk > 0) {
                                        echo uang($d->jmlplhk / $d->isipcsdus);
                                      } ?></td>
        <td style="text-align:right"><?php if ($totalbarangkeluar > 0) {
                                        echo uang($totalbarangkeluar);
                                      } ?></td>
        <td style="text-align:right"><?php if ($sisa > 0) {
                                        echo uang($sisa);
                                      } ?></td>

      </tr>
    <?php } ?>
  </tbody>
</table>