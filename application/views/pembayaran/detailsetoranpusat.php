<table class="table table-hover table-bordered">
  <thead class="thead-dark">
    <th>No</th>
    <th>Tanggal Setoran</th>
    <th>Tgl Input</th>
    <th>Tgl Aksi</th>
  </thead>
  <tbody>

    <?php
    $no = 1;
    foreach ($setoranpusat->result() as $g) {
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $g->tgl_setoranpusat; ?></td>
        <td><?php echo $g->tgl_input; ?></td>
        <td><?php echo $g->tgl_aksi; ?></td>
      </tr>
    <?php $no++;
    } ?>

  </tbody>
</table>