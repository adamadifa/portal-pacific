<table class="table">
  <tr>
    <th>Kode Saldo Awal</th>
    <td><?php echo $saldokurleb['kode_saldokurleb']; ?></td>
  </tr>
  <tr>
    <th>Tanggal</th>
    <td><?php echo DateToIndo2($saldokurleb['tanggal']); ?></td>
  </tr>
  <tr>
    <th>Bulan</th>
    <td><?php echo $saldokurleb['bulan']; ?></td>
  </tr>
  <tr>
    <th>Tahun</th>
    <td><?php echo $saldokurleb['tahun']; ?></td>
  </tr>
  <tr>
    <th>Tahun</th>
    <td><?php echo $saldokurleb['kode_cabang']; ?></td>
  </tr>
</table>
<table class="table table-bordered table-striped">
  <thead class="thead-dark">
    <tr>
      <th>No</th>
      <th>Salesman</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <?php
  $no = 1;
  foreach ($detailsaldokurleb as $d) {
  ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $d->nama_karyawan; ?></td>
      <td style="text-align:right"><?php echo number_format($d->jumlah, '0', '', '.'); ?></td>
    </tr>
  <?php
    $no++;
  }
  ?>

</table>