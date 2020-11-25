<table class="table table-bordered table-hover">
  <thead class="thead-dark">
    <tr>
      <th colspan="9"><b>Detail Penjualan</b></th>
    </tr>
    <tr>
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>Jml Dus</th>
      <th>Harga Dus</th>
      <th>Jml Pack</th>
      <th>Harga Pack</th>
      <th>Jml Pcs</th>
      <th>Harga Pcs</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total = 0;
    foreach ($detail as $b) {
      $jmldus     = floor($b->jumlah / $b->isipcsdus);
      $sisadus    = $b->jumlah % $b->isipcsdus;
      if ($b->isipack == 0) {
        $jmlpack    = 0;
        $sisapack   = $sisadus;
      } else {
        $jmlpack    = floor($sisadus / $b->isipcs);
        $sisapack   = $sisadus % $b->isipcs;
      }
      $jmlpcs = $sisapack;
      $total = $total + $b->subtotal;
    ?>
      <tr>
        <td><?php echo $b->kode_barang; ?></td>
        <td><?php echo $b->nama_barang; ?></td>
        <td align="center"><?php echo $jmldus; ?></td>
        <td align="right"><?php echo  number_format($b->harga_dus, '0', '', '.'); ?></td>
        <td align="center"><?php echo $jmlpack; ?></td>
        <td align="right"><?php echo  number_format($b->harga_pack, '0', '', '.'); ?></td>
        <td align="center"><?php echo $jmlpcs; ?></td>
        <td align="right"><?php echo  number_format($b->harga_pcs, '0', '', '.'); ?></td>
        <td align="right"><?php echo  number_format($b->subtotal, '0', '', '.'); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="8"><b>SUB TOTAL</b></td>
      <td align="right"><b><?php echo  number_format($total, '0', '', '.'); ?></b></td>
    </tr>
    <tr>
      <td colspan="8"><b>POTONGAN</b></td>
      <td align="right"><b><?php echo  number_format($faktur['potongan'], '0', '', '.'); ?></b></td>
    </tr>
    <tr>
      <td colspan="8"><b>POTONGAN ISTIMEWA</b></td>
      <td align="right"><b><?php echo  number_format($faktur['potistimewa'], '0', '', '.'); ?></b></td>
    </tr>
    <tr>
      <td colspan="8"><b>PENYESUAIAN</b></td>
      <td align="right"><b><?php echo  number_format($faktur['penyharga'], '0', '', '.'); ?></b></td>
    </tr>
    <tr>
      <td colspan="8"><b>GRAND TOTAL</b></td>
      <td align="right"><b><?php echo  number_format($faktur['total'], '0', '', '.'); ?></b></td>
    </tr>
  </tbody>
</table>