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
      <th colspan="3">TARGET & REALISASI KATEGORI B (ALL AIDA)(25)</th>
      <th colspan="3">TARGET & REALISASI KATEGORI PF (PRODUCT FOCUS)(25)</th>
      <th colspan="3">TARGET & REALISASI CASHIN</th>
    </tr>
    <tr>
      <th>TARGET</th>
      <th>REALISASI</th>
      <th>REALISASI/TARGET * 50</th>
      <th>TARGET</th>
      <th>REALISASI</th>
      <th>REALISASI/TARGET * 25</th>
      <th>TARGET</th>
      <th>REALISASI</th>
      <th>REALISASI/TARGET * 25</th>
      <th>TARGET</th>
      <th>REALISASI</th>
      <th>%</th>
    </tr>
  </thead>
  <tbody style="font-size:14px !important">
    <?php
    $no = 1;
    $poinkategoriA = 50;
    $poinkategoriB = 25;
    $poinkategoriPF = 25;

    foreach ($komisi as $k) {
      if (!empty($k->targetkategoriA)) {
        $hasilkategoriA = ($k->realisasitargetA / $k->targetkategoriA) * 50;
      } else {
        $hasilkategoriA = 0;
      }

      if (!empty($k->targetkategoriB)) {
        $hasilkategoriB = ($k->realisasitargetB / $k->targetkategoriB) * 25;
      } else {
        $hasilkategoriB = 0;
      }

      if (!empty($k->targetproductfocus)) {
        $hasilkategoriPF = ($k->realisasitargetproductfocus / $k->targetproductfocus) * 25;
      } else {
        $hasilkategoriPF = 0;
      }

      if (!empty($k->jumlah_target_cashin)) {
        $hasilcashin = ($k->jml_cashin / $k->jumlah_target_cashin) * 100;
      } else {
        $hasilcashin = 0;
      }

    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $k->id_karyawan; ?></td>
        <td><?php echo $k->nama_karyawan; ?></td>
        <td align="right"><?php echo formatnumber($k->targetkategoriA); ?></td>
        <td align="right"><?php echo formatnumber($k->realisasitargetA); ?></td>
        <td align="right"><?php echo formatnumber($hasilkategoriA); ?></td>
        <td align="right"><?php echo formatnumber($k->targetkategoriB); ?></td>
        <td align="right"><?php echo formatnumber($k->realisasitargetB); ?></td>
        <td align="right"><?php echo formatnumber($hasilkategoriB); ?></td>
        <td align="right"><?php echo formatnumber($k->targetproductfocus); ?></td>
        <td align="right"><?php echo formatnumber($k->realisasitargetproductfocus); ?></td>
        <td align="right"><?php echo formatnumber($hasilkategoriPF); ?></td>
        <td align="right"><?php echo formatnumber($k->jumlah_target_cashin); ?></td>
        <td align="right"><?php echo formatnumber($k->jml_cashin); ?></td>
        <td align="right"><?php echo formatnumber($hasilcashin); ?></td>
      </tr>
    <?php $no++;
    } ?>
  </tbody>
</table>