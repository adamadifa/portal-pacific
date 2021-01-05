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
  REKAP PEMBELIAN <?php echo $jenis; ?> <br>
  PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
</b>
<br>
<br>
<table class="datatable3" style="width:70%" border="1">
  <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
      <td>NO</td>
      <td>NO BUKTI</td>
      <td>KODE SUPPLIER</td>
      <td>NAMA SUPPLIER</td>
      <td>NAMA BARANG</td>
      <td>JENIS BARANG</td>
      <td>QTY</td>
      <td>HARGA</td>
      <td>SUBTOTAL</td>
      <td>PENYESUAIAN</td>
      <td>TOTAL</td>
    </tr>
  </thead>
  <tbody>
    <?php
    $total  = 0;
    $no     = 1;
    $subtotaljenisbarang = 0;
    foreach ($pmb as $key => $d) {
      $jenisbarang  = @$pmb[$key + 1]->jenis_barang;
      $totalharga = ($d->harga * $d->qty) + $d->penyesuaian;
      $subtotal = $d->harga * $d->qty;
      $subtotaljenisbarang = $subtotaljenisbarang + $totalharga;
      if ($d->ppn == '1') {
        $cekppn  =  "&#10004;";
        $bgcolor = "#ececc8";
        $dpp     = (100 / 110) * $totalharga;
        $ppn     = 10 / 100 * $dpp;
      } else {
        $bgcolor = "";
        $cekppn  = "";
        $dpp     = "";
        $ppn     = "";
      }

      $grandtotal   = $totalharga;
      $total         = $total + $grandtotal;
    ?>
      <tr style="background-color:<?php echo $bgcolor; ?>">
        <td><?php echo $no; ?></td>
        <td><?php echo $d->nobukti_pembelian; ?></td>
        <td><?php echo $d->kode_supplier; ?></td>
        <td><?php echo $d->nama_supplier; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->jenis_barang; ?></td>
        <td align="right"><?php echo uang($d->qty); ?></td>
        <td align="right"><?php echo uang($d->harga); ?></td>
        <td align="right"><?php echo uang($subtotal); ?></td>
        <td align="right"><?php echo uang($d->penyesuaian); ?></td>
        <td align="right"><?php echo uang($totalharga); ?></td>
      </tr>
      <?php
      if ($jenisbarang != $d->jenis_barang) {
      ?>
        <tr bgcolor="#024a75" style="color:white; font-size:12;">
          <td colspan="10">TOTAL <?php echo $d->jenis_barang; ?></td>
          <td align="right"><b><?php echo uang($subtotaljenisbarang); ?></b></td>
        </tr>
    <?php
        $subtotaljenisbarang = 0;
      }
      $no++;
    }
    ?>
    <tr bgcolor="#024a75" style="color:white; font-size:12px">
      <td colspan="10"><b>TOTAL</b></td>
      <td align="right"><b><?php echo uang($total); ?></b></td>
    </tr>
  </tbody>

</table>