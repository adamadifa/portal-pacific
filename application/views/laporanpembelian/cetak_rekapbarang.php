<?php
error_reporting(0);
function uang($nilai)
{
  return number_format($nilai, '2', ',', '.');
}
function angka($nilai)
{
  return number_format($nilai, '2', ',', '.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
  REKAP BAHAN DAN KEMASAN PER SUPPLIER <b style="color:red"><?php echo strtoupper($barang['nama_barang']); ?></b> <br>
  PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
</b>
<br>
<br>
<table class="datatable3" style="width:70%" border="1">
  <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
      <td>NO</td>
      <td>NO BUKTI</td>
      <td>TANGGAL</td>
      <td>KODE SUPPLIER</td>
      <td>NAMA SUPPLIER</td>
      <td>NAMA BARANG</td>
      <td>QTY</td>
      <td>HARGA</td>
      <td>SUBTOTAL</td>
      <td>PENYESUAIAN</td>
      <td>TOTAL</td>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $totalqty = 0;
    $totalsubtotal = 0;
    $grandtotal = 0;
    $totalpenyesuaian = 0;

    $totalqtysub = 0;
    $totalsubtotalsub = 0;
    $grandtotalsub = 0;
    $totalpenyesuaiansub = 0;
    foreach ($pmb as $key => $d) {
      $totalqty = $totalqty + $d->qty;
      $totalsubtotal = $totalsubtotal + ($d->qty * $d->harga);
      $grandtotal = $grandtotal + ($d->qty * $d->harga) + $d->penyesuaian;
      $totalpenyesuaian = $totalpenyesuaian + $d->penyesuaian;

      $totalqtysub = $totalqtysub + $d->qty;
      $totalsubtotalsub = $totalsubtotalsub + ($d->qty * $d->harga);
      $grandtotalsub = $grandtotalsub + ($d->qty * $d->harga) + $d->penyesuaian;
      $totalpenyesuaiansub = $totalpenyesuaiansub + $d->penyesuaian;
      $supplier  = @$pmb[$key + 1]->kode_supplier;
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->nobukti_pembelian; ?></td>
        <td><?php echo $d->tgl_pembelian; ?></td>
        <td><?php echo $d->kode_supplier; ?></td>
        <td><?php echo $d->nama_supplier; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td align="right"><?php echo uang($d->qty); ?></td>
        <td align="right"><?php echo uang($d->harga); ?></td>
        <td align="right"><?php echo uang($d->harga * $d->qty); ?></td>
        <td align="right"><?php echo uang($d->penyesuaian); ?></td>
        <td align="right"><?php echo uang(($d->harga * $d->qty) + $d->penyesuaian); ?></td>
      </tr>
      <?php
      if ($supplier != $d->kode_supplier) {
        echo '
						<tr bgcolor="#199291" style="color:white; font-weight:bold">
              <td colspan="6">TOTAL</td>
              <td align="right">' . uang($totalqtysub) . '</td>
              <td></td>
              <td align="right">' . uang($totalsubtotalsub) . '</td>
              <td align="right">' . uang($totalpenyesuaiansub) . '</td>
              <td align="right">' . uang($grandtotalsub) . '</td>
						</tr>';
        $totalqtysub    = 0;
        $totalsubtotalsub    = 0;
        $totalpenyesuaiansub  = 0;
        $grandtotalsub = 0;
      }

      ?>
    <?php $no++;
    }
    ?>
  </tbody>
  <tfooter bgcolor="#024a75" style="color:white; font-size:12;">
    <tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
      <td colspan="6">TOTAL</td>
      <td align="right"><?php echo uang($totalqty); ?></td>
      <td></td>
      <td align="right"><?php echo uang($totalsubtotal); ?></td>
      <td align="right"><?php echo uang($totalpenyesuaian); ?></td>
      <td align="right"><?php echo uang($grandtotal); ?></td>
    </tr>
  </tfooter>
</table>