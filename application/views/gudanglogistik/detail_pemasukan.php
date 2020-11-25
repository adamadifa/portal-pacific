<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr style="font-weight:bold">
      <th>Tanggal Pembelian</th>
      <th>Tanggal Approve</th>
      <th>NO Bukti</th>
    </tr>
    <tr>
      <?php if ($data['tgl_pembelian'] != 0) { ?>
        <td><?php echo DateToIndo2($data['tgl_pembelian']); ?></td>
      <?php } else { ?>
        <td>-</td>
      <?php } ?>
      <td><?php echo DateToIndo2($data['tgl_pemasukan']); ?></td>
      <td><?php echo $data['nobukti_pemasukan']; ?></td>
    </tr>
  </thead>
</table>
<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr>
      <th>No</th>
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>Ket</th>
      <th>Qty</th>
      <th>Harga</th>
      <th>Total</th>
      <th>Akun</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no     = 1;
    $total  = 0;
    foreach ($detail->result() as $d) {
        $total = $total + ($d->qty * $d->harga + $d->penyesuaian);
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo $d->qty; ?></td>
        <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format($d->qty * $d->harga + $d->penyesuaian, '2', ',', '.'); ?></td>
        <td><?php echo $d->kode_akun; ?> <?php echo $d->nama_akun; ?></td>
      </tr>
    <?php $no++;
    }  ?>
    <tr>
      <th colspan="6">TOTAL PEMBELIAN</th>
      <td align="right"><b> <?php echo number_format($total, '2', ',', '.'); ?></b></td>
    </tr>
  </tbody>
</table>