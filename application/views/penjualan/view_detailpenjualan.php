<?php

foreach ($detail as $d) {


  $jmldus     = floor($d->jumlah / $d->isipcsdus);
  $sisadus    = $d->jumlah % $d->isipcsdus;
  if ($d->isipack == 0) {
    $jmlpack    = 0;
    $sisapack   = $sisadus;
  } else {

    $jmlpack    = floor($sisadus / $d->isipcs);
    $sisapack   = $sisadus % $d->isipcs;
  }

  $jmlpcs = $sisapack;
?>
  <tr>

    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td align="center"><?php echo $jmldus; ?></td>

    <td align="center"><?php echo $jmlpack; ?></td>

    <td align="center"><?php echo $jmlpcs; ?></td>

  </tr>
<?php } ?>