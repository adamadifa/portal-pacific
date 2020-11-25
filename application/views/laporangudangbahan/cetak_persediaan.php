<?php

function uang($nilai)
{

  return number_format($nilai, 2, ',', '.');
}
// error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:20px; font-family:Calibri">
  MAKMUR PERMATA<br>
  REKAPITULASI PERSEDIAAN GUDANG
  <?php if ($kategori == 'B001') {
    echo "BAHAN";
  } else {
    echo "KEMASAN";
  } ?><br>
  BULAN <?php echo $bulan; ?><br>
  TAHUN <?php echo $tahun; ?><br>
</b>
<br>
<table class="datatable3" style="width:100%" border="1">
  <thead>
    <tr>
      <th rowspan="3" bgcolor="#024a75" style="color:white; font-size:14;">NO</th>
      <th rowspan="3" bgcolor="#024a75" style="color:white; font-size:14;">KODE BARANG</th>
      <th rowspan="3" bgcolor="#024a75" style="color:white; font-size:14;">NAMA BARANG</th>
      <th rowspan="3" bgcolor="#024a75" style="color:white; font-size:14;">SATUAN</th>
    </tr>
    <tr bgcolor="#024a75">
      <th colspan="2" style="color:white; font-size:14;">SALDO AWAL</th>
      <th colspan="3" style="color:white; font-size:14;">PEMASUKAN</th>
      <th colspan="6" style="color:white; font-size:14;">PENGELUARAN</th>
      <th colspan="2" style="color:white; font-size:14;">SALDO AKHIR</th>
    </tr>
    <tr bgcolor="#024a75">
      <th style="color:white; font-size:14;">UNIT</th>
      <th style="color:white; font-size:14;">BERAT</th>
      <th style="color:white; font-size:14;">PEMBELIAN</th>
      <th style="color:white; font-size:14;">LAINNYA</th>
      <th style="color:white; font-size:14;">RETUR PENGGANTI</th>
      <th style="color:white; font-size:14;">PRODUKSI</th>
      <th style="color:white; font-size:14;">SEASONING</th>
      <th style="color:white; font-size:14;">PDQC</th>
      <th style="color:white; font-size:14;">SUSUT</th>
      <th style="color:white; font-size:14;">CABANG</th>
      <th style="color:white; font-size:14;">LAINNYA</th>
      <th style="color:white; font-size:14;">UNIT</th>
      <th style="color:white; font-size:14;">BERAT</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no               = 1;
    $totalproduksi    = 0;
    $totalcabangpeng  = 0;
    $totalseasoning   = 0;
    $totalpdqc        = 0;
    $totalsusut       = 0;
    $totalpembelian   = 0;
    $totallainnya     = 0;
    $totalqtyunitsa   = 0;
    $totalqtyberatsa  = 0;
    $saldoakhirunit2  = 0;
    $totallainnyapeng = 0;
    $saldoakhirberat2 = 0;
    $totalretur       = 0;
    foreach ($data as $key => $d) {
      $saldoakhirberat     = $d->qtyberatsa + $d->qtypemb2 + $d->qtylainnya2 - $d->qtyprod4 - $d->qtyseas4 - $d->qtypdqc4 - $d->qtylain4 - $d->qtysus4 - $d->qtycabang4;
      $saldoakhirunit      = $d->qtyunitsa + $d->qtypemb1 + $d->qtylainnya1 - $d->qtyprod3 - $d->qtyseas3 - $d->qtypdqc3 - $d->qtylain3 - $d->qtysus3 - $d->qtycabang3;

      if ($d->satuan != 'KG') {
        $totalpembelian     += $d->qtypemb1;
      } else {
        $totalpembelian     += $d->qtypemb2;
      }

      if ($d->satuan != 'KG') {
        $totallainnya       += $d->qtylainnya1;
      } else {
        $totallainnya       += $d->qtylainnya2;
      }

      if ($d->satuan != 'KG') {
        $totalproduksi      += $d->qtyprod3;
      } else {
        $totalproduksi      += $d->qtyprod4;
      }

      if ($d->satuan != 'KG') {
        $totalseasoning     += $d->qtyseas3;
      } else {
        $totalseasoning     += $d->qtyseas4;
      }

      if ($d->satuan != 'KG') {
        $totalpdqc          += $d->qtypdqc3;
      } else {
        $totalpdqc          += $d->qtypdqc4;
      }

      if ($d->satuan != 'KG') {
        $totallainnyapeng   += $d->qtylain3;
      } else {
        $totallainnyapeng   += $d->qtylain4;
      }

      if ($d->satuan != 'KG') {
        $totalcabangpeng   += $d->qtycabang3;
      } else {
        $totalcabangpeng   += $d->qtycabang4;
      }

      if ($d->satuan != 'KG') {
        $totalsusut         += $d->qtysus3;
      } else {
        $totalsusut         += $d->qtysus4;
      }

      $totalqtyunitsa   = $totalqtyunitsa + $d->qtyunitsa;
      $totalqtyberatsa  = $totalqtyberatsa + $d->qtyberatsa;

      $saldoakhirunit2  = $saldoakhirunit2 + $saldoakhirunit;
      $saldoakhirberat2 = $saldoakhirberat2 + $saldoakhirberat;
      $totalretur       = $totalretur + $d->qtypengganti2;


    ?>
      <tr style="font-size: 14;">
        <td><?php echo $no++; ?></td>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td align="center">
          <?php if ($d->qtyunitsa != 0) {
            echo uang($d->qtyunitsa);
          } else {
            echo "";
          }
          ?>
        </td>
        <td align="center">
          <?php if ($d->qtyberatsa != 0) {
            echo uang($d->qtyberatsa, 2);
          } else {
            echo "";
          }
          ?>
        </td>

        <?php if ($d->satuan != 'KG') { ?>
          <td align="center">
            <?php if (!empty($d->qtypemb1)) {
              echo uang($d->qtypemb1, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtypemb2)) {
              echo uang($d->qtypemb2, 2);
            }
            ?>
          </td>
        <?php } ?>

        <?php if ($d->satuan != 'KG') { ?>
          <td align="center">
            <?php if (!empty($d->qtylainnya1)) {
              echo uang($d->qtylainnya1, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtylainnya2)) {
              echo uang($d->qtylainnya2, 2);
            }
            ?>
          </td>
        <?php } ?>

        <td align="center">
          <?php if (!empty($d->qtypengganti2)) {
            echo uang($d->qtypengganti2, 2);
          }
          ?>
        </td>

        <?php if ($d->satuan != 'KG') { ?>
          <td align="center">
            <?php if (!empty($d->qtyprod3)) {
              echo uang($d->qtyprod3, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtyprod4)) {
              echo uang($d->qtyprod4, 2);
            }
            ?>
          </td>
        <?php } ?>

        <?php if ($d->satuan != 'KG') { ?>
          <td align="center">
            <?php if (!empty($d->qtyseas3)) {
              echo uang($d->qtyseas3, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtyseas4)) {
              echo uang($d->qtyseas4, 2);
            }
            ?>
          </td>
        <?php } ?>

        <?php if ($d->satuan != 'KG') { ?>
          <td align="center">
            <?php if (!empty($d->qtypdqc3)) {
              echo uang($d->qtypdqc3, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtypdqc4)) {
              echo uang($d->qtypdqc4, 2);
            }
            ?>
          </td>
        <?php } ?>

        <?php if ($d->satuan != 'KG') { ?>
          <td align="center">
            <?php if (!empty($d->qtysus3)) {
              echo uang($d->qtysus3, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtysus4)) {
              echo uang($d->qtysus4, 2);
            }
            ?>
          </td>
        <?php } ?>

        <?php if ($d->satuan != 'KG') { ?>

          <td align="center">
            <?php if (!empty($d->qtycabang3)) {
              echo uang($d->qtycabang3, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtycabang4)) {
              echo uang($d->qtycabang4, 2);
            }
            ?>
          </td>
        <?php } ?>

        <?php if ($d->satuan != 'KG') { ?>

          <td align="center">
            <?php if (!empty($d->qtylain3)) {
              echo uang($d->qtylain3, 2);
            }
            ?>
          </td>
        <?php } else { ?>
          <td align="center">
            <?php if (!empty($d->qtylain4)) {
              echo uang($d->qtylain4, 2);
            }
            ?>
          </td>
        <?php } ?>

        <td align="center">
          <?php if (!empty($saldoakhirunit)) {
            echo uang($saldoakhirunit);
          }
          ?>
        </td>

        <td align="center">
          <?php if (!empty($saldoakhirberat)) {
            echo uang($saldoakhirberat, 2);
          }
          ?>
        </td>

      </tr>
    <?php
    }
    ?>
  </tbody>
  <tfoot>
    <tr bgcolor="#024a75">
      <th colspan="4" style="color:white; font-size:14;">TOTAL</th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalqtyunitsa)) {
          echo uang($totalqtyunitsa, 2);
        } else {
          echo "0";
        }
        ?>
      </th>


      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalqtyberatsa)) {
          echo uang($totalqtyberatsa, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalpembelian)) {
          echo uang($totalpembelian, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totallainnya)) {
          echo uang($totallainnya, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalretur)) {
          echo uang($totalretur, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalproduksi)) {
          echo uang($totalproduksi, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalseasoning)) {
          echo uang($totalseasoning, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalpdqc)) {
          echo uang($totalpdqc, 2);
        } else {
          echo "0";
        }
        ?>
      </th>


      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalsusut)) {
          echo uang($totalsusut, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totalcabangpeng)) {
          echo uang($totalcabangpeng, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($totallainnyapeng)) {
          echo uang($totallainnyapeng, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($saldoakhirunit2)) {
          echo uang($saldoakhirunit2, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

      <th align="center" style="color:white; font-size:14;">
        <?php if (!empty($saldoakhirberat2)) {
          echo uang($saldoakhirberat2, 2);
        } else {
          echo "0";
        }
        ?>
      </th>

    </tr>
  </tfoot>
</table>