<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr style="font-weight:bold">
      <th>Tanggal Approve</th>
      <th>NO Bukti</th>
      <th>Supplier</th>
      <th>Jenis Retur</th>
    </tr>
    <tr>
      <td><?php echo DateToIndo2($data['tgl_retur']); ?></td>
      <td><?php echo $data['nobukti_retur']; ?></td>
      <td><?php echo $data['nama_supplier']; ?></td>
      <td><?php echo $data['jenis_retur']; ?></td>
    </tr>
  </thead>
</table>
<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Ket</th>
      <th>Qty</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no     = 1;
    $total  = 0;
    foreach ($detail->result() as $d) {
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo number_format($d->qty); ?></td>
      </tr>
    <?php $no++;
    }  ?>
  </tbody>
</table>