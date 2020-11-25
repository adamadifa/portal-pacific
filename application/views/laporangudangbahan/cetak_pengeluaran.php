<?php
function uang($nilai)
{
  return number_format($nilai, 2, ',', '.');
}
error_reporting(0);
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  MAKMUR PERMATA<br>
  REKAPITULASI BARANG KELUAR<br>
  PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br><br>
</b>
<br>
<table class="datatable3" style="width:100%" border="1" style="font-size: 14">
  <thead>
    <tr>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">TANGGAL</th>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">BUKTI</th>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">DEPARTEMEN</th>
      <th colspan="7" bgcolor="#28a745" style="color:white; font-size:14;">BARANG KELUAR</th>
    </tr>
    <tr bgcolor="#024a75">
      <th style="color:white; font-size:14;">NAMA BARANG</th>
      <th style="color:white; font-size:14;">SATUAN</th>
      <th style="color:white; font-size:14;">KETERANGAN</th>
      <th style="color:white; font-size:14;">QTY UNIT</th>
      <th style="color:white; font-size:14;">QTY BERAT</th>
      <th style="color:white; font-size:14;">QTY LEBIH</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total = 0;
    $qty_lebih  = 0;
    $qty_berat  = 0;
    $qty_unit   = 0;
    foreach ($data as $d) {
      $qty_unit     = $qty_unit + $d->qty_unit;
      $qty_berat    = $qty_berat + $d->qty_berat;
      $qty_lebih    = $qty_lebih + $d->qty_lebih;
    ?>
      <tr style="font-size: 14;">
        <td><?php echo DateToIndo2($d->tgl_pengeluaran); ?></td>
        <td><?php echo $d->nobukti_pengeluaran; ?></td>
        <td><?php echo $d->kode_dept; ?>
          <?php if ($d->kode_dept == 'Produksi') {
            echo "Unit " . $d->unit;
          } else if ($d->kode_dept == 'Cabang') {
            echo $d->unit;
          } ?>
        </td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td align="center"><?php echo uang($d->qty_unit); ?></td>
        <td align="center"><?php echo uang($d->qty_berat, 2); ?></td>
        <td align="center"><?php echo uang($d->qty_lebih, 2); ?></td>
      </tr>
    <?php
    }
    ?>
    <tr bgcolor="#024a75" style="color:white; text-align: center;font-size: 14">
      <td colspan="6">TOTAL</td>
      <td align="center"><?php echo uang($qty_unit); ?></td>
      <td align="center"><?php echo uang($qty_berat, 2); ?></td>
      <td align="center"><?php echo uang($qty_lebih, 2); ?></td>
    </tr>
  </tbody>
</table>