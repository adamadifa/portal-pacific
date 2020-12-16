<?php
error_reporting(0);
function uang($nilai)
{
  return number_format($nilai, '2', ',', '.');
}

function angka($nilai)
{
  return number_format($nilai, '2', ',', '.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
  JURNAL KOREKSI <br>
  PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
</b>
<br>
<table class="datatable3" style="width:100%" border="1">
  <thead>
    <tr>
      <th width="20px" bgcolor="#024a75" style="color:white; font-size:12;">No</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">TGL</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">No Bukti</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Supplier</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Nama Barang</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Keterangan</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Kode Akun</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Nama Akun</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Qty</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Harga</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Total</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Debet</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Kredit</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $total       = 0;
    $totalkredit = 0;
    $totaldebet  = 0;
    foreach ($jurnalkoreksi as $j) {
      $total       = $total + $j->harga * $j->qty;
      if ($j->status_dk == 'D') {
        $totalkredit =  $totalkredit + $j->harga * $j->qty;
      }
      if ($j->status_dk == 'K') {
        $totaldebet =  $totaldebet + $j->harga * $j->qty;
      }
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $j->tgl_jurnalkoreksi; ?></td>
        <td><?php echo $j->nobukti_pembelian; ?></td>
        <td><?php echo $j->nama_supplier; ?></td>
        <td><?php echo $j->nama_barang; ?></td>
        <td><?php echo $j->keterangan; ?></td>
        <td><?php echo $j->kode_akun; ?></td>
        <td><?php echo $j->nama_akun; ?></td>
        <td align="right"><?php echo  number_format($j->qty, '2', ',', '.'); ?></td>
        <td align="right"><?php echo  number_format($j->harga, '2', ',', '.'); ?></td>
        <td align="right"><?php echo  number_format($j->harga * $j->qty, '2', ',', '.'); ?></td>
        <td align="right">
          <?php
          if ($j->status_dk == 'D') {
            echo  number_format($j->harga * $j->qty, '2', ',', '.');
          }
          ?>
        </td>
        <td align="right">
          <?php
          if ($j->status_dk == 'K') {
            echo  number_format($j->harga * $j->qty, '2', ',', '.');
          }
          ?>
        </td>
      </tr>

    <?php
      $no++;
    }
    ?>
    <tr>
      <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="10" align="center">Total</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;" align="right"><?php echo  number_format($total, '2', ',', '.'); ?></th>
      <th bgcolor="#024a75" style="color:white; font-size:12;" align="right"><?php echo  number_format($totaldebet, '2', ',', '.'); ?></th>
      <th bgcolor="#024a75" style="color:white; font-size:12;" align="right"><?php echo  number_format($totalkredit, '2', ',', '.'); ?></th>
    </tr>
  </tbody>
</table>

<br>