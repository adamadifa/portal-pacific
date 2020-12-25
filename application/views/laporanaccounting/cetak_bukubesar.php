<?php
function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  BUKU BESAR<br>
  PERIODE <?php echo strtoupper($bulan[$bln]) . " " . $tahun; ?>
  <br>
  <br>
  <table>
    <tr>
      <td><b>KODE AKUN</b></td>
      <td>:</td>
      <td><b><?php echo $kode_akun; ?></b></td>
    </tr>
    <tr>
      <td><b>NAMA AKUN</b></td>
      <td>:</td>
      <td><b><?php echo $akun['nama_akun']; ?></b></td>
    </tr>
  </table>
</b>
<table class="datatable3" style="width:90%" border="1">
  <thead>
    <tr>
      <th style="font-size:12;">TGL</th>
      <th style="font-size:12;">NO BUKTI</th>
      <th style="font-size:12;">SUMBER</th>
      <th style="font-size:12;">KETERANGAN</th>
      <th style="font-size:12;">DEBET</th>
      <th style="font-size:12;">KREDIT</th>
      <th style="font-size:12;">SALDO</th>
    </tr>
    <tr>
      <th style="font-size:12;" colspan="6">SALDO AWAL</th>
      <th style="text-align: right;"><?php echo uang($saldoawal['jumlah']); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $totaldebet = 0;
    $totalkredit = 0;
    $saldoawal = $saldoawal['jumlah'];
    $saldo = 0;
    foreach ($bukubesar as $d) {
      $totaldebet = $totaldebet + $d->debet;
      $totalkredit = $totalkredit + $d->kredit;
      $saldoawal = $saldoawal + $d->debet - $d->kredit;
    ?>
      <tr style="font-size:12">
        <td><?php echo DateToIndo2($d->tanggal); ?></td>
        <td><?php echo $d->no_bukti; ?></td>
        <td>
          <?php if ($d->sumber == "Ledger") {
            $sumber = $d->sumber . " " . $d->bank;
          } else if ($d->sumber == "Kas Kecil") {
            $sumber = $d->nama_akun;
          }
          echo $sumber;
          ?>
        </td>
        <td>
          <?php echo $d->keterangan; ?>
        </td>
        <td align="right"><?php if (!empty($d->debet)) {
                            echo  uang($d->debet);
                          } ?></td>
        <td align="right"><?php if (!empty($d->kredit)) {
                            echo  uang($d->kredit);
                          } ?></td>
        <td align="right"><?php if (!empty($saldoawal)) {
                            echo  uang($saldoawal);
                          } ?></td>
      </tr>
    <?php } ?>
    <tfooter>
      <tr>
        <th colspan="4">TOTAL</th>
        <th align="right"><?php if (!empty($totaldebet)) {
                            echo  uang($totaldebet);
                          } ?></th>
        <th align="right"><?php if (!empty($totalkredit)) {
                            echo  uang($totalkredit);
                          } ?></th>
        <th align="right"><?php if (!empty($saldoawal)) {
                            echo  uang($saldoawal);
                          } ?></th>
      </tr>
    </tfooter>
  </tbody>
</table>