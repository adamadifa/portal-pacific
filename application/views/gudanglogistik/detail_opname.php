<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr style="font-weight:bold">
      <th>Tanggal Input</th>
      <th>Kode Opname</th>
    </tr>
    <tr>
      <td><?php echo DateToIndo2($data['tanggal']); ?></td>
      <td><?php echo $data['kode_opname_gl']; ?></td>
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
        <td><?php echo $d->kategori; ?></td>
        <td><?php echo $d->qty; ?></td>
      </tr>
    <?php $no++;
    }  ?>
  </tbody>
</table>