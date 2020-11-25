<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr style="font-weight:bold">
      <th>Tanggal Input</th>
      <th>Kode Saldo Awal</th>
    </tr>
    <tr>
      <td><?php echo DateToIndo2($data['tanggal']); ?></td>
      <td><?php echo $data['kode_saldoawal_gl']; ?></td>
    </tr>
  </thead>
</table>
<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Kategori Barang</th>
      <th>Qty</th>
      <th>Harga</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no     = 1;
    $total  = 0;
    foreach ($detail->result() as $d) {
      $total = $total + ($d->qty * $d->harga);
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->kategori; ?></td>
        <td><?php echo $d->qty; ?></td>
        <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format($d->qty * $d->harga, '2', ',', '.'); ?></td>
      </tr>
    <?php $no++;
    }  ?>
    <tr>
      <th colspan="5">TOTAL SALDO AWAL</th>
      <td align="right"><b> <?php echo number_format($total, '2', ',', '.'); ?></b></td>
    </tr>
  </tbody>
</table>