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
    <?php
    $totalpengambilan = 0;
    $totalpenjualan = 0;
    $totalgantibarang = 0;
    $totalpromosi  = 0;
    $totalttr = 0;
    $totalplhk = 0;
    $totalsisa = 0;
    $grandtotalbarangkeluar = 0;
    foreach ($rekapkendaraan as $d) {
      $totalbarangkeluar = ($d->jmlpenjualan + $d->jmlgantibarang + $d->jmlpromosi + $d->jmlttr + $d->jmlplhk) / $d->isipcsdus;
      $sisa = $d->jml_pengambilan - $totalbarangkeluar;
      $totalpenjualan += ($d->jmlpenjualan / $d->isipcsdus);
      $totalgantibarang += ($d->jmlgantibarang / $d->isipcsdus);
      $totalpromosi += ($d->jmlpromosi / $d->isipcsdus);
      $totalttr += ($d->jmlttr / $d->isipcsdus);
      $totalplhk += ($d->jmlttr / $d->isipcsdus);
      $totalpengambilan += $d->jml_pengambilan;
      $grandtotalbarangkeluar += $totalbarangkeluar;
      $totalsisa += $sisa;

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
    <tr bgcolor="#295ea9" style="color:white; font-size:16;">
      <td>TOTAL</td>
      <td align="right"><?php echo uang($totalpengambilan); ?></td>
      <td align="right"><?php echo uang($totalpenjualan); ?></td>
      <td align="right"><?php echo uang($totalgantibarang); ?></td>
      <td align="right"><?php echo uang($totalpromosi); ?></td>
      <td align="right"><?php echo uang($totalttr); ?></td>
      <td align="right"><?php echo uang($totalplhk); ?></td>
      <td align="right"><?php echo uang($grandtotalbarangkeluar); ?></td>
      <td align="right"><?php echo uang($totalsisa); ?></td>
    </tr>
  </tbody>
</table>
<br>
<br>
<table>
  <tr>
    <td>
      <table class="datatable3">
        <thead>
          <tr bgcolor="#295ea9" style="color:white; font-size:16;">
            <td colspan="2">HISTORI KEBERANGKATAN</td>
          </tr>
          <tr bgcolor="#295ea9" style="color:white; font-size:16;">
            <td>TANGGAL</td>
            <td>JML</td>
          </tr>
        </thead>
        <tbody>
          <?php $jmlhari = 0;
          foreach ($histori as $h) {
          ?>
            <tr style="font-size:14px">
              <td><?php echo DateToIndo2($h->tgl_pengambilan); ?></td>
              <td><?php echo $h->jmlpengambilan . " x Pengambilan" ?></td>
            </tr>
          <?php $jmlhari++;
          } ?>
        </tbody>
      </table>
    </td>
    <td valign="top">
      <table class="datatable3">
        <thead>
          <tr bgcolor="#0b6ea9" style="color:white; font-size:16;">
            <td colspan="2">RATA RATA BARANG KELUAR</td>
          </tr>
          <tr style="font-size:14">
            <td style="background-color: #0b6ea9; color:white">TOTAL BARANG KELUAR</td>
            <td align="right"><?php echo uang($grandtotalbarangkeluar); ?></td>
          </tr>
          <tr style="font-size:14">
            <td style="background-color: #0b6ea9; color:white">JUMLAH HARI</td>
            <td align="right"><?php echo $jmlhari; ?></td>
          </tr>
          <tr style="font-size:14">
            <td style="background-color: #0b6ea9; color:white">RATA RATA</td>
            <td align="right"><?php echo uang($grandtotalbarangkeluar / $jmlhari); ?></td>
          </tr>
        </thead>
      </table>
    </td>
    <td valign="top">
      <table class="datatable3">
        <thead>
          <tr bgcolor="#a94211" style="color:white; font-size:16;">
            <td colspan="2">RATA RATA PENJUALAN</td>
          </tr>
          <tr style="font-size:14">
            <td style="background-color: #a94211; color:white">TOTAL PENJUALAN</td>
            <td align="right"><?php echo uang($totalpenjualan); ?></td>
          </tr>
          <tr style="font-size:14">
            <td style="background-color: #a94211; color:white">JUMLAH HARI</td>
            <td align="right"><?php echo $jmlhari; ?></td>
          </tr>
          <tr style="font-size:14">
            <td style="background-color: #a94211; color:white">RATA RATA</td>
            <td align="right"><?php echo uang($totalpenjualan / $jmlhari); ?></td>
          </tr>
        </thead>
      </table>
    </td>
  </tr>
</table>