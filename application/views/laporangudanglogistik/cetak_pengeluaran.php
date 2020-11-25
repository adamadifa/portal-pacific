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
<table class="datatable3" style="width:100%; size: A4;zoom:80%" border="1">
    <thead>
      <tr>
        <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">NO</th>
        <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">TANGGAL</th>
        <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">BUKTI</th>
        <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">DEPARTEMEN</th>
        <th colspan="7" bgcolor="#28a745" style="color:white; font-size:14;">BARANG KELUAR</th>
      </tr>
      <tr bgcolor="#024a75">
        <th style="color:white; font-size:14;">KODE BARANG</th>
        <th style="color:white; font-size:14;">NAMA BARANG</th>
        <th style="color:white; font-size:14;">SATUAN</th>
        <th style="color:white; font-size:14;">KETERANGAN</th>
        <th style="color:white; font-size:14;">QTY</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      $no    = 1;
      foreach ($data as $d) {
        $total   = $total + $d->qty * $d->harga;
        $qty    = $qty + $d->qty;
        $harga  = $harga + $d->harga;
      ?>
        <tr style="font-size: 14">
          <td><?php echo $no++; ?></td>
          <td><?php echo DateToIndo2($d->tgl_pengeluaran); ?></td>
          <td><?php echo $d->nobukti_pengeluaran; ?></td>
          <td><?php echo $d->nama_dept; ?></td>
          <td><?php echo $d->kode_barang; ?></td>
          <td><?php echo $d->nama_barang; ?></td>
          <td><?php echo $d->satuan; ?></td>
          <td><?php echo $d->keterangan; ?></td>
          <td align="center"><?php echo uang($d->qty); ?></td>
        </tr>
      <?php
      }
      ?>
      <tr bgcolor="#024a75" style="color:white; text-align: center" style="font-size: 16">
        <td colspan="8">TOTAL</td>
        <td align="center"><?php echo uang($qty); ?></td>
      </tr>
    </tbody>
  </table>