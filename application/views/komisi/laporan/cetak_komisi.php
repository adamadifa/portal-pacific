<?php
function formatnumber($nilai)
{

  return number_format($nilai, '2', ',', '.');
}

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  LAPORAN KOMISI<br>
  PERIODE BULAN <?= $bulan[$bln]; ?> TAHUN <?= $tahun; ?><br>
  CABANG <?= $cabang; ?>
</b>

<table class="datatable3">
  <thead>
    <tr>
      <th rowspan="2">NO</th>
      <th rowspan="2">ID KARYAWAN</th>
      <th rowspan="2">NAMA KARYAWAN</th>
      <th colspan="3">TARGET & REALISASI KATEGORI A (BB)(50)</th>
    </tr>
    <tr>
      <th>TARGET</th>
      <th>REALISASI</th>
      <th>PRODUCT FOCUS</th>
    </tr>
  </thead>
  <tbody style="font-size:14px !important">
    <?php
    $no = 1;
    foreach ($komisi as $k) {
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $k->id_karyawan; ?></td>
        <td><?php echo $k->nama_karyawan; ?></td>
        <td align="right"><?php echo formatnumber($k->targetkategoriA); ?></td>
        <td align="right"><?php echo formatnumber($k->realisasitargetA); ?></td>
      </tr>
    <?php $no++;
    } ?>
  </tbody>
</table>