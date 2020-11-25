<table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
  <thead class="thead-dark">
    <tr>
      <th width="10px">No</th>
      <th>No Bukti</th>
      <th>Tanggal</th>
      <th>Supplier</th>
      <th>Departemen</th>
      <th>PPn</th>
      <th>Total</th>
      <th>JT</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    foreach ($pmb as $p) : ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $p->nobukti_pembelian; ?></td>
        <td><?php echo DateToIndo2($p->tgl_pembelian); ?></td>
        <td><?php echo $p->nama_supplier; ?></td>
        <td><?php echo $p->nama_dept; ?></td>
        <td>
          <?php
          if (!empty($p->ppn)) {
            echo '<i class="material-icons">check_box</i>';
          }
          ?>
        </td>
        <td align="right"><?php echo number_format($p->harga, '2', ',', '.'); ?></td>
        <td><?php echo $p->jenistransaksi; ?></td>
        <td>
          <a href="#" data-kode="<?php echo $p->nobukti_pembelian ?>" data-total="<?php echo number_format($p->harga, '2', ',', '.'); ?>" class="btn btn-sm btn-danger pilih">Pilih</a>
        </td>
      </tr>
    <?php $no++;
    endforeach; ?>
  </tbody>
</table>
<script type="text/javascript">
  $(function() {
    $(".pilih").click(function() {
      var nobukti = $(this).attr('data-kode');
      var totalharga = $(this).attr('data-total');
      $("#nobukti").val(nobukti);
      $("#totalharga").val(totalharga);
      $("#datapembelian").modal('hide');
    });

    $("#mytable").DataTable();
  });
</script>