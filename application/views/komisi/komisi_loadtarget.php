<?php foreach ($target as $t) { ?>
  <tr>
    <td><?php echo $t->kode_target; ?></td>
    <td><?php echo $bulan[$t->bulan]; ?></td>
    <td><?php echo $t->tahun; ?></td>
    <td><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-gear mr-2"></i>Set Target</a></td>
  </tr>
<?php } ?>