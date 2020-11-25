<?php
error_reporting(0);
function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:14px; font-family:Calibri">
  COST RATIO <br>
  CABANG <?php echo $cabang; ?>
</b>

<br>
<br>
<table class="datatable3" border="1">
  <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr bgcolor="#024a75" style="color:white; font-size:12;">
      <th>NO</th>
      <th>KODE AKUN</th>
      <th>NAMA AKUN</th>
      <th>JUMLAH</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $totalbiaya = 0;
    foreach ($biaya as $b) {
      $totalbiaya = $totalbiaya + $b->jumlahbiaya;
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $b->kode_akun ?></td>
        <td><?php echo $b->nama_akun ?></td>
        <td align="right"><?php echo uang($b->jumlahbiaya); ?></td>
      </tr>
    <?php $no++;
    } ?>
    <tr>
      <?php
      $penjswan = $swan['netpenjualan'] - $returswan['netretur'];
      $penjaida = $aida['netpenjualan'] - $returaida['netretur'];
      $crswan = ($totalbiaya / $penjswan) * 100;
      $craida = ($totalbiaya / $penjaida) * 100;
      $totalpenjualan = $penjswan + $penjaida;
      $crpenjualan = ($totalbiaya / $totalpenjualan) * 100;
      $piutanglebihsatubulan = $piutang['jumlah'];
      $crpiutangswan = ($piutanglebihsatubulan / $penjswan) * 100;
      $crpiutangaida = ($piutanglebihsatubulan / $penjaida) * 100;
      $crpiutang = ($piutanglebihsatubulan / $totalpenjualan) * 100;
      $biayadanpiutang = $totalbiaya + $piutanglebihsatubulan;
      $crbpswan = ($biayadanpiutang / $penjswan) * 100;
      $crbpaida = ($biayadanpiutang / $penjaida) * 100;
      $crbp = ($biayadanpiutang / $totalpenjualan) * 100;
      ?>
      <td bgcolor="#024a75" style="color:white; font-size:12; font-weight:bold" align="center" colspan="3">TOTAL</td>
      <td align="right" style="font-weight: bold;"><?php echo uang($totalbiaya); ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td colspan="2" rowspan="4" align="center" bgcolor="#024a75" style="color:white; font-size:12px;">PENJUALAN</td>
      <td bgcolor="#024a75" style="color:white; font-size:12px;">SWAN</td>
      <td align="right" style="font-weight: bold;"><?php echo uang($penjswan); ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#024a75" style="color:white; font-size:12px;">COST RATIO</td>
      <td align="right"><?php echo ROUND($crswan) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#024a75" style="color:white; font-size:12px;">AIDA</td>
      <td align="right" style="font-weight: bold;"><?php echo uang($penjaida); ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#024a75" style="color:white; font-size:12px;">COST RATIO</td>
      <td align="right"><?php echo ROUND($craida) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#024a75" style="color:white; font-size:12px;" colspan="3">TOTAL PENJUALAN</td>
      <td align="right" style="font-weight: bold;"><?php echo uang($totalpenjualan); ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#024a75" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN + AIDA</td>
      <td align="right"><?php echo ROUND($crpenjualan) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">PITUANG > 1 BULAN</td>
      <td align="right" style="font-weight: bold;"><?php echo uang($piutanglebihsatubulan); ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN</td>
      <td align="right"><?php echo ROUND($crpiutangswan) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">COST RATIO AIDA</td>
      <td align="right"><?php echo ROUND($crpiutangaida) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN + AIDA</td>
      <td align="right"><?php echo ROUND($crpiutangaida) . " %"; ?></td>
    </tr>
    <tr style="font-weight:bold">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">BIAYA + PIUTANG</td>
      <td align="right" style="font-weight: bold;"><?php echo uang($biayadanpiutang); ?></td>
    </tr>
    <tr style="font-weight:bold">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN</td>
      <td align="right"><?php echo ROUND($crbpswan) . " %"; ?></td>
    </tr>
    <tr style="font-weight:bold">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">COST RATIO AIDA</td>
      <td align="right"><?php echo ROUND($crbpaida) . " %"; ?></td>
    </tr>
    <tr style="font-weight:bold">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN + AIDA</td>
      <td align="right"><?php echo ROUND($crbp) . " %"; ?></td>
    </tr>
  </tbody>
</table>