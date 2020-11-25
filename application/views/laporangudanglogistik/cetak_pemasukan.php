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
  REKAPITULASI BARANG MASUK<br>
  PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br><br>
</b>
<br>
<table class="datatable3" style="width:100%; size: A4;zoom:80%" border="1">
  <thead>
    <tr>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">NO</th>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">TANGGAL</th>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">SUPPLIER</th>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">BUKTI</th>
      <th colspan="8" bgcolor="#28a745" style="color:white; font-size:14;">BARANG MASUK</th>
    </tr>
    <tr bgcolor="#024a75">
      <th style="color:white; font-size:14;">NAMA BARANG</th>
      <th style="color:white; font-size:14;">SATUAN</th>
      <th style="color:white; font-size:14;">KETERANGAN</th>
      <th style="color:white; font-size:14;">AKUN</th>
      <th style="color:white; font-size:14;">HARGA</th>
      <th style="color:white; font-size:14;">QTY</th>
      <th style="color:white; font-size:14;">PENYESUAIAN</th>
      <th style="color:white; font-size:14;">SUBTOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $harga = 0;
    $qty = 0;
    foreach ($data as $key => $d) {
      $harga   = $harga + $d->qty * $d->harga + $d->penyesuaian;
      $qty     = $qty + $d->qty;
    ?>
      <tr style="font-size: 14">
        <td><?php echo $no++; ?></td>
        <td><?php echo DateToIndo2($d->tgl_pemasukan); ?></td>
        <td><?php echo $d->nama_supplier; ?></td>
        <td><?php echo $d->nobukti_pemasukan; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo $d->kode_akun; ?> <?php echo $d->nama_akun; ?></td>
        <td align="right"><?php echo uang($d->harga); ?></td>
        <td align="center"><?php echo uang($d->qty); ?></td>
        <td align="right"><?php echo uang($d->penyesuaian); ?></td>
        <td align="right"><?php echo uang($d->qty * $d->harga + $d->penyesuaian); ?></td>
      </tr>
    <?php
    }
    ?>
    <tr bgcolor="#024a75" style="color:white; text-align: center;font-size: 14">
      <td colspan="9">TOTAL</td>
      <td align="center"><?php echo uang($qty); ?></td>
      <td></td>
      <td align="right"><?php echo uang($harga); ?></td>
    </tr>
  </tbody>
</table>