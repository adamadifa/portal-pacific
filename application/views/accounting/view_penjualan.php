<?php
$no = 1;
foreach ($penjualan as $key => $d) {

  if ($d->kode_produk == "AB") {
    $kode_akun =  '4-1202';
  } elseif ($d->kode_produk == "AS") {
    $kode_akun =  '4-1203';
  } elseif ($d->kode_produk == "AR") {
    $kode_akun =  '4-1205';
  } elseif ($d->kode_produk == "BB") {
    $kode_akun =  '4-1102';
  } elseif ($d->kode_produk == "CGG") {
    $kode_akun = '4-1204';
  } elseif ($d->kode_produk == "CG") {
    $kode_akun = '4-1204';
  } elseif ($d->kode_produk == "DB") {
    $kode_akun =  '4-1101';
  } elseif ($d->kode_produk == "DEP") {
    $kode_akun =  '4-1107';
  } elseif ($d->kode_produk == "DK") {
    $kode_akun =  '4-1301';
  } elseif ($d->kode_produk == "DS") {
    $kode_akun =  '4-1105';
  }
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->tgltransaksi; ?></td>
    <td><?php echo $d->no_fak_penj; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $kode_akun; ?></td>
    <td></td>
    <td align="right"><?php echo number_format($d->subtotal, 2); ?></td>
  </tr>
<?php
  $no++;
}
?>