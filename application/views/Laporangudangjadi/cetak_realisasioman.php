<?php

function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}

$namabulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$awal = $tahun . "-" . $bulan . "-01";
$akhir = $tahun . "-" . $bulan . "-31";
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  REALISASI OMAN
  PERIODE <?php echo strtoupper($namabulan[$bulan]) . " " . $tahun; ?><br><br>
</b>
<br>

<?php
foreach ($produk as $p) {
?>
  <table class="datatable3">
    <tr bgcolor="#024a75" style="color:white; font-size:12;">
      <td colspan="6"><?php echo $p->nama_barang; ?></td>
    </tr>
    <tr bgcolor="#024a75" style="color:white; font-size:12;">
      <td>No</td>
      <td>Cabang</td>
      <td>OMAN</td>
      <td>Realisasi</td>
      <td>Sisa</td>
      <td>%</td>
    </tr>
    <?php $no = 1;
    foreach ($cabang as $c) {
      $q_oman = "SELECT detail_oman_cabang.kode_produk,SUM(jumlah) as jumlah 
      FROM detail_oman_cabang
      INNER JOIN oman_cabang ON detail_oman_cabang.no_order = oman_cabang.no_order
      WHERE oman_cabang.kode_cabang = '$c->kode_cabang' AND detail_oman_cabang.kode_produk = '$p->kode_produk' AND bulan ='$bulan' AND tahun='$tahun'
      GROUP BY detail_oman_cabang.kode_produk,kode_cabang
      ";
      $q_realisasi = "SELECT detail_mutasi_gudang.kode_produk,SUM(jumlah) as jumlah
      FROM detail_mutasi_gudang
      INNER JOIN mutasi_gudang_jadi ON detail_mutasi_gudang.no_mutasi_gudang = mutasi_gudang_jadi.no_mutasi_gudang
      INNER JOIN permintaan_pengiriman ON mutasi_gudang_jadi.no_permintaan_pengiriman = permintaan_pengiriman.no_permintaan_pengiriman
      WHERE kode_cabang ='$c->kode_cabang' AND detail_mutasi_gudang.kode_produk = '$p->kode_produk'
      AND tgl_mutasi_gudang BETWEEN '$awal' AND '$akhir'
      GROUP BY kode_cabang,detail_mutasi_gudang.kode_produk
      ";

      $realisasi = $this->db->query($q_realisasi)->row_array();
      $oman = $this->db->query($q_oman)->row_array();
      $sisa = $oman['jumlah'] - $realisasi['jumlah'];
      if (!empty($oman['jumlah'])) {
        $persen = $realisasi['jumlah'] / $oman['jumlah'] * 100;
      } else {
        $persen = $realisasi['jumlah'] / 100 * 100;
      }
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $c->nama_cabang; ?></td>
        <td align="right"><?php if (!empty($oman['jumlah'])) {
                            echo uang($oman['jumlah']);
                          } ?></td>
        <td align="right"><?php if (!empty($realisasi['jumlah'])) {
                            echo uang($realisasi['jumlah']);
                          } ?></td>
        <td align="right"><?php if ($sisa < 0) {
                            echo str_replace("-", "> ", $sisa);
                          } else {
                            echo uang($sisa);
                          } ?></td>

        <td><?php echo $persen . " %" ?></td>
      </tr>
    <?php $no++;
    }
    ?>
  </table>
<?php } ?>