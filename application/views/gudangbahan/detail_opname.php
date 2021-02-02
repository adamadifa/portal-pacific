<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr style="font-weight:bold">
      <th>Tanggal Input</th>
      <th>Kode Opname</th>
    </tr>
    <tr>
      <td><?php echo DateToIndo2($data['tanggal']); ?></td>
      <td><?php echo $data['kode_opname_gb']; ?></td>
    </tr>
  </thead>
</table>
<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Kategori Barang</th>
      <th>Qty Berat</th>
      <th>Qty Unit</th>
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
        <td><?php echo $d->jenis_barang; ?></td>
        <td align="center"><?php echo number_format($d->qty_unit); ?></td>
        <td align="center"><?php echo number_format($d->qty_berat, '2', ',', '.'); ?></td>
      </tr>
    <?php $no++;
    }  ?>
  </tbody>
</table>