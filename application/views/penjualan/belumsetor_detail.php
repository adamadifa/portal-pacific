<table class="table">
  <tr>
    <th>Kode Belum Setor</th>
    <td><?php echo $belumsetor['kode_saldobs']; ?></td>
  </tr>
  <tr>
    <th>Tanggal</th>
    <td><?php echo DateToIndo2($belumsetor['tanggal']); ?></td>
  </tr>
  <tr>
    <th>Bulan</th>
    <td><?php echo $belumsetor['bulan']; ?></td>
  </tr>
  <tr>
    <th>Tahun</th>
    <td><?php echo $belumsetor['tahun']; ?></td>
  </tr>
  <tr>
    <th>Tahun</th>
    <td><?php echo $belumsetor['kode_cabang']; ?></td>
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
  foreach ($detailbelumsetor as $d) {
  ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $d->nama_karyawan; ?></td>
      <td><?php echo number_format($d->jumlah, '0', '', '.'); ?></td>
    </tr>
  <?php
    $no++;
  }
  ?>

</table>