<?php

function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}
error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  MAKMUR PERMATA<br>
  REKAPITULASI PERSEDIAAN PRODUKSI<br>
  <?php if ($bulan == "01") {
    $bulan = "Januari";
  } elseif ($bulan == "02") {
    $bulan = "Februari";
  } elseif ($bulan == "03") {
    $bulan = "Maret";
  } elseif ($bulan == "04") {
    $bulan = "April";
  } elseif ($bulan == "05") {
    $bulan = "Mei";
  } elseif ($bulan == "06") {
    $bulan = "Juni";
  } elseif ($bulan == "07") {
    $bulan = "Juli";
  } elseif ($bulan == "08") {
    $bulan = "Agustus";
  } elseif ($bulan == "09") {
    $bulan = "September";
  } elseif ($bulan == "10") {
    $bulan = "Oktober";
  } elseif ($bulan == "11") {
    $bulan = "November";
  } elseif ($bulan == "12") {
    $bulan = "Desember";
  } ?>
  BULAN <?php echo strtoupper($bulan); ?><br>
  TAHUN <?php echo $tahun; ?><br>
</b>
<br>
<table class="datatable3" style="width:100%" border="1">
  <thead>
    <tr bgcolor="#024a75">
      <th rowspan="3" style="color:white; font-size:14;">NO</th>
      <th rowspan="3" style="color:white; font-size:14;">KODE BARANG</th>
      <th rowspan="3" style="color:white; font-size:14;">NAMA BARANG</th>
      <th rowspan="3" style="color:white; font-size:14;">KATEGORI BARANG</th>
      <th rowspan="3" style="color:white; font-size:14;">SATUAN</th>
      <th rowspan="3" style="color:white; font-size:14;">SALDO AWAL</th>
    </tr>
    <tr bgcolor="#024a75">
      <th colspan="3" style="color:white; font-size:14;">PEMASUKAN</th>
      <th colspan="3" style="color:white; font-size:14;">PENGELUARAN</th>
      <th rowspan="3" style="color:white; font-size:14;">SALDO AKHIR</th>
      <th rowspan="3" style="color:white; font-size:14;">OPNAME</th>
      <th rowspan="3" style="color:white; font-size:14;">SELISIH</th>
    </tr>
    <tr bgcolor="#024a75">
      <th style="color:white; font-size:14;">GUDANG</th>
      <th style="color:white; font-size:14;">SEASONING</th>
      <th style="color:white; font-size:14;">TRIAL</th>
      <th style="color:white; font-size:14;">PEMAKAIAN</th>
      <th style="color:white; font-size:14;">RETUR OUT</th>
      <th style="color:white; font-size:14;">LAINNYA</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no               = 1;
    $totalsaldoawal   = 0;
    $totalgudang      = 0;
    $totalseasoning   = 0;
    $totaltrial       = 0;
    $totalpemakaian   = 0;
    $totalretur       = 0;
    $totallainnya     = 0;
    $totalsaldoakhir  = 0;
    $totalopname      = 0;
    foreach ($data as $key => $d) {
      $saldoakhir         = $d->saldoawal + $d->gudang + $d->seasoning + $d->trial - $d->pemakaian - $d->retur - $d->lainnya;
      $totalsaldoawal     += $d->saldoawal;
      $totalgudang        += $d->gudang;
      $totalseasoning     += $d->seasoning;
      $totaltrial         += $d->trial;
      $totalpemakaian     += $d->pemakaian;
      $totalretur         += $d->retur;
      $totallainnya       += $d->lainnya;
      $totalsaldoakhir    += $saldoakhir;
      $totalopname        += $d->opname;

      $kode_kategori      = $d->kode_kategori;
      if ($kode_kategori == "SRG") {
        $kode_kategori = "SAUS REGULER";
        $gbcolor       = 'green';
      } elseif ($kode_kategori == "SDP") {
        $kode_kategori = "SAUS DP";
      } elseif ($kode_kategori == "SST") {
        $kode_kategori = "SAUS STIK";
      } elseif ($kode_kategori == "KCP") {
        $kode_kategori = "KECAP";
      } elseif ($kode_kategori == "BBB") {
        $kode_kategori = "BUMBU BUBUR BAWANG";
      } elseif ($kode_kategori == "LAIN") {
        $kode_kategori = "LAINNYA";
      } elseif ($kode_kategori == "BHN") {
        $kode_kategori = "BAHAN";
      } elseif ($kode_kategori == "KMS") {
        $kode_kategori = "KEMASAN";
      }
    ?>
      <tr style="font-size: 14">
        <td><?php echo $no++; ?></td>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td bgcolor="<?php echo $bgcolor; ?>"><?php echo $kode_kategori; ?></td>
        <td align="center"><?php echo $d->satuan; ?></td>
        <td align="center"><?php if ($d->saldoawal != "0" and $d->saldoawal != "") {
                              echo number_format($d->saldoawal, 2);
                            }; ?></td>
        <td align="center"><?php if ($d->gudang != "0" and $d->gudang != "") {
                              echo number_format($d->gudang, 2);
                            }; ?></td>
        <td align="center"><?php if ($d->seasoning != "0" and $d->seasoning != "") {
                              echo number_format($d->seasoning, 2);
                            }; ?></td>
        <td align="center"><?php if ($d->trial != "0" and $d->trial != "") {
                              echo number_format($d->trial, 2);
                            }; ?></td>
        <td align="center"><?php if ($d->pemakaian != "0" and $d->pemakaian != "") {
                              echo number_format($d->pemakaian, 2);
                            }; ?></td>
        <td align="center"><?php if ($d->retur != "0" and $d->retur != "") {
                              echo number_format($d->retur, 2);
                            }; ?></td>
        <td align="center"><?php if ($d->lainnya != "0" and $d->lainnya != "") {
                              echo number_format($d->lainnya, 2);
                            }; ?></td>
        <td align="center"><?php if ($saldoakhir != "0" and $saldoakhir != "") {
                              echo number_format($saldoakhir, 2);
                            }; ?></td>
        <td align="center"><?php if ($d->opname != "0" and $d->opname != "") {
                              echo number_format($d->opname, 2);
                            }; ?></td>
        <td align="center"><?php if ($saldoakhir - $d->opname != "0") {
                              echo number_format($saldoakhir - $d->opname, 2);
                            }; ?></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
  <tfoot>
    <tr bgcolor="#024a75" style="color:white; font-size:14;">
      <th align="center" colspan="5">TOTAL</th>
      <th align="center"><?php echo number_format($totalsaldoawal, 2); ?></th>
      <th align="center"><?php echo number_format($totalgudang, 2); ?></th>
      <th align="center"><?php echo number_format($totalseasoning, 2); ?></th>
      <th align="center"><?php echo number_format($totaltrial, 2); ?></th>
      <th align="center"><?php echo number_format($totalpemakaian, 2); ?></th>
      <th align="center"><?php echo number_format($totalretur, 2); ?></th>
      <th align="center"><?php echo number_format($totallainnya, 2); ?></th>
      <th align="center"><?php echo number_format($totalsaldoakhir, 2); ?></th>
      <th align="center"><?php echo number_format($totalopname, 2); ?></th>
      <th align="center"><?php echo number_format($totalsaldoakhir - $totalopname, 2); ?></th>

    </tr>
  </tfoot>
</table>