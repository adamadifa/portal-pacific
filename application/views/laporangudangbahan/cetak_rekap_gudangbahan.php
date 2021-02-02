<?php

function uang($nilai)
{

  return number_format($nilai, 2, ',', '.');
}
// error_reporting(0);
?>
<style>
  .besar {
    text-transform: uppercase;
  }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:20px; font-family:Calibri" class="besar">
  MAKMUR PERMATA<br>
  REKAPITULASI PERSEDIAAN <?php echo $barang['nama_barang']; ?><br>
  PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
</b>
<br>
<table class="datatable3" style="width:100%" border="1">
  <thead>
    <tr>
      <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">TANGGAL</th>
      <!-- <th rowspan="2" bgcolor="#024a75" style="color:white; font-size:14;">BTB</th> -->
      <th rowspan="1" colspan="2" bgcolor="#024a75" style="color:white; font-size:14;">UNIT</th>
      <th rowspan="1" bgcolor="#024a75" style="color:white; font-size:14;">SALDO</th>
      <th rowspan="3" bgcolor="#024a75" style="color:white; font-size:14;">KETERANGAN</th>
      <th rowspan="1" colspan="3" bgcolor="#024a75" style="color:white; font-size:14;">MASUK</th>
      <th rowspan="1" colspan="6" bgcolor="#024a75" style="color:white; font-size:14;">KELUAR</th>
      <th rowspan="1" bgcolor="#024a75" style="color:white; font-size:14;">SALDO AKHIR</th>
    </tr>
    <tr bgcolor="#024a75">
      <th style="color:white; font-size:14;">IN</th>
      <th style="color:white; font-size:14;">OUT</th>
      <th bgcolor="orange" style="color:white; font-size:14;">
        <?php if (!empty($saldoawal['qtyunitsa'])) {
          echo uang($saldoawal['qtyunitsa']);
        } ?>
      </th>
      <th style="color:white; font-size:14;">PEMBELIAN</th>
      <th style="color:white; font-size:14;">LAINNYA</th>
      <th style="color:white; font-size:14;">RETUR PENGGANTI</th>
      <th style="color:white; font-size:14;">PRODUKSI</th>
      <th style="color:white; font-size:14;">SEASONING</th>
      <th style="color:white; font-size:14;">PDQC</th>
      <th style="color:white; font-size:14;">SUSUT</th>
      <th style="color:white; font-size:14;">CABANG</th>
      <th style="color:white; font-size:14;">LAINNYA</th>
      <th bgcolor="orange" style="color:white; font-size:14;">
        <?php if (!empty($saldoawal['qtyberatsa'])) {
          echo uang($saldoawal['qtyberatsa']);
        } ?>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php
    $saldoakhirberat    = $saldoawal['qtyberatsa'];
    $saldoakhirunit     = $saldoawal['qtyunitsa'];
    $totqtypemb         = 0;
    $totqtylainnya      = 0;
    $totqtylain         = 0;
    $totqtyretur        = 0;
    $totqtypro          = 0;
    $totqtyseas         = 0;
    $totqtypdqc         = 0;
    $totqtycabang       = 0;
    $totqtysus          = 0;
    $totqtyunitmasuk    = 0;
    $totqtyunitkeluar   = 0;
    while (strtotime($dari) <= strtotime($sampai)) {

      $qmasuk           = "SELECT SUM(qty_unit) as qty_unit, 
      SUM( IF( departemen = 'Pembelian' , qty_berat ,0 )) AS qtypemb,
      SUM( IF( departemen = 'Lainnya' , qty_berat ,0 )) AS qtylainnya,
      SUM( IF( departemen = 'Retur Pengganti' , qty_berat ,0 )) AS qtyretur
      FROM pemasukan_gb 
      INNER JOIN detail_pemasukan_gb 
      ON detail_pemasukan_gb.nobukti_pemasukan=pemasukan_gb.nobukti_pemasukan 
      WHERE tgl_pemasukan ='$dari' AND detail_pemasukan_gb.kode_barang = '$kode_barang'
      GROUP BY tgl_pemasukan";
      $masuk            = $this->db->query($qmasuk)->row_array();

      $qkeluar           = "SELECT 
      SUM(qty_unit) as qty_unit,
      SUM( IF( pengeluaran_gb.kode_dept = 'Produksi' , qty_berat ,0 )) AS qtyprod,
      SUM( IF( pengeluaran_gb.kode_dept = 'Seasoning' , qty_berat ,0 )) AS qtyseas,
      SUM( IF( pengeluaran_gb.kode_dept = 'PDQC' , qty_berat ,0 )) AS qtypdqc,
      SUM( IF( pengeluaran_gb.kode_dept = 'Susut' , qty_berat ,0 )) AS qtysus,
      SUM( IF( pengeluaran_gb.kode_dept = 'Lainnya' , qty_berat ,0 )) AS qtylain,
      SUM( IF( pengeluaran_gb.kode_dept = 'Cabang' , qty_berat ,0 )) AS qtycabang
      FROM pengeluaran_gb 
      INNER JOIN detail_pengeluaran_gb 
      ON detail_pengeluaran_gb.nobukti_pengeluaran=pengeluaran_gb.nobukti_pengeluaran 
      WHERE tgl_pengeluaran ='$dari' AND detail_pengeluaran_gb.kode_barang = '$kode_barang'
      GROUP BY tgl_pengeluaran";
      $keluar            = $this->db->query($qkeluar)->row_array();

      $qtymasukberat    = $masuk['qtypemb'] + $masuk['qtylainnya'] + $masuk['qtyretur'];
      $qtykeluarberat   = $keluar['qtyprod']  + $keluar['qtyseas']  + $keluar['qtypdqc']  + $keluar['qtylain']  + $keluar['qtysus']  + $keluar['qtycabang'];
      $hasilqtyberat    = $qtymasukberat - $qtykeluarberat;
      $saldoakhirberat  = $saldoakhirberat + $hasilqtyberat;

      $saldounit        = $masuk['qty_unit'] - $keluar['qty_unit'];
      $saldoakhirunit   = $saldoakhirunit + $saldounit;

      $totqtyunitmasuk  += $masuk['qty_unit'];
      $totqtyunitkeluar += $keluar['qty_unit'];

      $totqtypemb       += $masuk['qtypemb'];
      $totqtylainnya    += $masuk['qtylainnya'];
      $totqtyretur      += $masuk['qtyretur'];

      $totqtypro        += $keluar['qtyprod'];
      $totqtyseas       += $keluar['qtyseas'];
      $totqtypdqc       += $keluar['qtypdqc'];
      $totqtylain       += $keluar['qtylain'];
      $totqtysus        += $keluar['qtysus'];
      $totqtycabang     += $keluar['qtycabang'];

    ?>
      <tr style="color:black; font-size:14;">
        <td bgcolor="red" style="color:white"><?php echo $dari; ?></td>
        <td align="right">
          <?php
          if (isset($masuk['qty_unit']) and $masuk['qty_unit'] != "0") {
            echo uang($masuk['qty_unit']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($keluar['qty_unit']) and $keluar['qty_unit'] != "0") {
            echo uang($keluar['qty_unit']);
          }
          ?>
        </td>
        <td align="right"><?php echo uang(($saldoakhirunit)); ?></td>
        <td align="right"></td>
        <td align="right">
          <?php
          if (isset($masuk['qtypemb']) and $masuk['qtypemb'] != "0") {
            echo uang($masuk['qtypemb']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($masuk['qtylainnya']) and $masuk['qtylainnya'] != "0") {
            echo uang($masuk['qtylainnya']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($masuk['qtypengganti2']) and $masuk['qtypengganti2'] != "0") {
            echo uang($masuk['qtypengganti2']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($keluar['qtyprod']) and $keluar['qtyprod'] != "0") {
            echo uang($keluar['qtyprod']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($keluar['qtyseas']) and $keluar['qtyseas'] != "0") {
            echo uang($keluar['qtyseas']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($keluar['qtypdqc']) and $keluar['qtypdqc'] != "0") {
            echo uang($keluar['qtypdqc']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($keluar['qtysus']) and $keluar['qtysus'] != "0") {
            echo uang($keluar['qtysus']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($keluar['qtycabang']) and $keluar['qtycabang'] != '0') {
            echo uang($keluar['qtycabang']);
          }
          ?>
        </td>
        <td align="right">
          <?php
          if (isset($keluar['qtylain']) and $keluar['qtylain'] != "0") {
            echo uang($keluar['qtylain']);
          }
          ?>
        </td>
        <td align="right"><?php echo uang($saldoakhirberat); ?></td>
      </tr>
    <?php
      $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari))); //looping tambah 1 date
    } ?>
  </tbody>
  <tfoot>
    <tr bgcolor="#31869b">
      <th colspan="" style="color:white; font-size:14;">TOTAL</th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtyunitmasuk); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtyunitkeluar); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($saldoakhirunit); ?></th>
      <th></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtypemb); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtylainnya); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtyretur); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtypro); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtyseas); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtypdqc); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtysus); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtycabang); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($totqtylain); ?></th>
      <th style="color:white; font-size:14;"><?php echo uang($saldoakhirberat); ?></th>
    </tr>
  </tfoot>
</table>