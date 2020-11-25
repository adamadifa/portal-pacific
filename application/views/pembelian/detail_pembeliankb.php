<table class="table table-bordered" style="width:100%">
  <thead class="thead-dark">
    <tr>
      <th colspan="8">Detail Pembelian</th>
    </tr>
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Ket</th>
      <th>Qty</th>
      <th>Harga</th>
      <th>Subtotal</th>
      <th>Penyesuaian</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    $total = 0;
    foreach ($detail as $d) {
      $total = $total + (($d->qty * $d->harga) + $d->penyesuaian); ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo $d->qty; ?></td>
        <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format($d->harga * $d->qty, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format($d->penyesuaian, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format((($d->qty * $d->harga) + $d->penyesuaian), '2', ',', '.'); ?></td>
      </tr>
    <?php $no++;
    }  ?>
    <tr>
      <th colspan="7">TOTAL PEMBELIAN</th>
      <td align="right"><b> <?php echo number_format($total, '2', ',', '.'); ?></b></td>
    </tr>
  </tbody>
</table>
<?php
if (!empty($cekpnj)) {
?>
  <table class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Keterangan</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalharga = 0;
      $no = 1;
      foreach ($pmbpnj as $d) {
        $totalharga = $totalharga + ($d->qty * $d->harga); ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $d->ket_penjualan; ?></td>
          <td><?php echo $d->qty; ?></td>
          <td align="right"><?php echo number_format($d->harga, '0', '', '.'); ?></td>
          <td align="right"><?php echo number_format($d->qty * $d->harga, '0', '', '.'); ?></td>
        </tr>
      <?php $no++;
      } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4">TOTAL PENJUALAN</th>
        <th style="text-align:right"><?php echo number_format($d->qty * $d->harga, '0', '', '.'); ?></th>
      </tr>
      <tr>
        <th colspan="4">GRAND TOTAL</th>
        <th style="text-align:right"><?php echo number_format($total - ($d->qty * $d->harga), '0', '', '.'); ?></th>
      </tr>
    </tfoot>
  </table>
<?php
}
?>