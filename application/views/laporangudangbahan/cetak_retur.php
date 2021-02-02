<?php

function uang($nilai)
{

  return number_format($nilai, 2, ',', '.');
}


?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  MAKMUR PERMATA<br>
  REKAPITULASI RETUR GUDANG BAHAN KEMASAN <br>
  BULAN <?php echo $bulan; ?><br>
  TAHUN <?php echo $tahun; ?><br>
</b>
<br>
<table class="datatable3" style="width:100%" border="1" style="font-size: 14">
  <thead>
    <tr bgcolor="#024a75">
      <th style="color:white; font-size:14;">NO</th>
      <th style="color:white; font-size:14;">NAMA BARANG</th>
      <th style="color:white; font-size:14;">SATUAN</th>
      <th style="color:white; font-size:14;">KETERANGAN</th>
      <th style="color:white; font-size:14;">SALDO AWAL</th>
      <th style="color:white; font-size:14;">RETUR IN</th>
      <th style="color:white; font-size:14;">RETUR OUT</th>
      <th style="color:white; font-size:14;">SALDO AKHIR</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no           = 1;
    $retur_in     = 0;
    $retur_out    = 0;
    $sisa_retur   = 0;
    $qtysaldoawal = 0;
    foreach ($data as $key => $d) {
      if (!empty($d->retur_in) or !empty($d->retur_out)) {
        $retur_in        += $d->retur_in;
        $retur_out       += $d->retur_out;
        $sisa_retur      += $d->sisa_retur;
        $qtysaldoawal    += $d->qtysaldoawal;
    ?>
        <tr style="font-size: 14" <?php if ($d->sisa_retur != "" and $d->sisa_retur != "0") {
                                    echo "bgcolor='pink'";
                                  } ?>>
          <td><?php echo $no++; ?></td>
          <td><?php echo $d->nama_barang; ?></td>
          <td><?php echo $d->satuan; ?></td>
          <td><?php echo $d->keterangan; ?></td>
          <td align="center">
            <?php
            if (!empty($d->qtysaldoawal) and $d->qtysaldoawal != "0") {
              echo uang($d->qtysaldoawal, 2);
            }
            ?>
          </td>
          <td align="center">
            <?php
            if (!empty($d->retur_in) and $d->retur_in != "0") {
              echo uang($d->retur_in, 2);
            }
            ?>
          </td>
          <td align="center">
            <?php
            if (!empty($d->retur_out) and $d->retur_out != "0") {
              echo uang($d->retur_out, 2);
            }
            ?>
          </td>
          <td align="center">
            <?php
            if (!empty($d->qtysaldoawal + $d->sisa_retur) and $d->qtysaldoawal + $d->sisa_retur != "0") {
              echo uang($d->qtysaldoawal + $d->sisa_retur, 2);
            }
            ?>
          </td>
        </tr>
    <?php
      }
    }
    ?>
  </tbody>
  <tfoot bgcolor="#024a75" style="color:white; font-size:14;">
    <tr>
      <th style="color:white; font-size:14;" colspan="4">TOTAL</th>
      <th style="color:white; font-size:14;"><?php echo uang($qtysaldoawal, 2); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($retur_in, 2); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($retur_out, 2); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($sisa_retur, 2); ?></th>
    </tr>
  </tfoot>
</table>