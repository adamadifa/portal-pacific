<?php
function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<title>LAPORAN JURNAL UMUM</title>
<br>
<table class="" style="width:30%;font-size:16;">
  <tr align="center">
    <td><b>PERIODER</b></td>
    <td>:</td>
    <td><b><?php echo dateToIndo2($dari); ?></b></td>
    <td>-</td>
    <td><b><?php echo dateToIndo2($sampai); ?></b></td>
  </tr>
</table>
<br>
<br>
<table class="datatable3" style="width:90%;font-size:12;zoom:100%" border="1">
  <thead>
    <tr>
      <th style="width: 10%;">TGL</th>
      <th>NO BUKTI</th>
      <!-- <th>KETERANGAN</th> -->
      <th>KODE AKUN</th>
      <th>NAMA AKUN</th>
      <th>DEBET</th>
      <th>KREDIT</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $debet = 0;
    $kredit = 0;
    foreach ($jurnalumum as $key => $d) {
      $debet += $d->debet;
      $kredit += $d->kredit;
    ?>
      <tr>
        <td><?php echo dateToIndo2($d->tanggal); ?></td>
        <td><?php echo $d->no_bukti; ?></td>
        <!-- <td><?php echo $d->keterangan; ?></td> -->
        <td><?php echo $d->kode_akun; ?></td>
        <td><?php echo $d->nama_akun; ?></td>
        <td align="right"><?php echo number_format($d->debet); ?></td>
        <td align="right"><?php echo number_format($d->kredit); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td>Total</td>
      <td></td>
      <td>></td>
      <td></td>
      <td align="right"><?php echo number_format($debet); ?></td>
      <td align="right"><?php echo number_format($kredit); ?></td>
    </tr>
  </tbody>
</table>