<table class="table table-hover table-bordered">
  <thead class="thead-dark">
    <th>No</th>
    <th>No Faktur</th>
    <th>Jumlah</th>
    <th>Tanggal Terima(Admin)</th>
    <th>Tgl Input</th>
    <th>Tgl Aksi</th>
  </thead>
  <tbody>

    <?php
    $no = 1;
    foreach ($transfer->result() as $g) {
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $g->no_fak_penj; ?></td>
        <td><?php echo number_format($g->jumlah, '0', '', '.'); ?></td>
        <td><?php echo $g->tgl_transfer; ?></td>
        <td><?php echo $g->tgl_input; ?></td>
        <td><?php echo $g->tgl_aksi; ?></td>
      </tr>
    <?php $no++;
    } ?>

  </tbody>
</table>