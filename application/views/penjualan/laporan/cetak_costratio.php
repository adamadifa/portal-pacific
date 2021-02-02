<?php
error_reporting(0);
function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:14px; font-family:Calibri">
  COST RATIO <br>
  PACIFIC-MAKMUR PERMATA <br>
  PERIODE BULAN <?php echo $bln . "TAHUN " . $tahun; ?>
</b>

<br>
<br>
<table class="datatable3" border="1">
  <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr bgcolor="#024a75" style="color:white; font-size:12;">
      <th>NO</th>
      <th>KODE AKUN</th>
      <th>NAMA AKUN</th>
      <?php
      foreach ($cabang as $c) {
      ?>
        <th bgcolor="#14b93f" style="color:white; font-size:12;"><?php echo strtoupper($c->nama_cabang); ?></th>
      <?php
      }
      ?>
      <th>JUMLAH</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $totaltsm = 0;
    $totalbdg = 0;
    $totalskb = 0;
    $totalbgr = 0;
    $totalpwt = 0;
    $totalpst = 0;
    $totalgrt = 0;
    $totalsby = 0;
    $totalsmr = 0;
    $totalbiayaall = 0;
    $no = 1;
    foreach ($biaya as $d) {
      $totaltsm = $totaltsm + $d->TSM;
      $totalbdg = $totalbdg + $d->BDG;
      $totalskb = $totalskb + $d->SKB;
      $totaltgl = $totaltgl + $d->TGL;
      $totalbgr = $totalbgr + $d->BGR;
      $totalpwt = $totalpwt + $d->PWT;
      $totalpst = $totalpst + $d->PST;
      $totalgrt = $totalgrt + $d->GRT;
      $totalsby = $totalsby + $d->SBY;
      $totalsmr = $totalsmr + $d->SMR;
      $totalbiaya = $d->TSM + $d->BDG + $d->SKB + $d->TGL + $d->BGR + $d->PWT + $d->PST + $d->GRT + $d->SBY + $d->SMR;
      $totalbiayaall = $totalbiayaall + $totalbiaya;
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo "'" . $d->kode_akun; ?></td>
        <td><?php echo $d->nama_akun; ?></td>
        <td align="right"><?php if (!empty($d->TSM)) {
                            echo uang($d->TSM);
                          } ?></td>
        <td align="right"><?php if (!empty($d->BDG)) {
                            echo uang($d->BDG);
                          } ?></td>
        <td align="right"><?php if (!empty($d->SKB)) {
                            echo uang($d->SKB);
                          } ?></td>
        <td align="right"><?php if (!empty($d->TGL)) {
                            echo uang($d->TGL);
                          } ?></td>
        <td align="right"><?php if (!empty($d->BGR)) {
                            echo uang($d->BGR);
                          } ?></td>
        <td align="right"><?php if (!empty($d->PWT)) {
                            echo uang($d->PWT);
                          } ?></td>
        <td align="right"><?php if (!empty($d->PST)) {
                            echo uang($d->PST);
                          } ?></td>
        <td align="right"><?php if (!empty($d->GRT)) {
                            echo uang($d->GRT);
                          } ?></td>
        <td align="right"><?php if (!empty($d->SBY)) {
                            echo uang($d->SBY);
                          } ?></td>
        <td align="right"><?php if (!empty($d->SMR)) {
                            echo uang($d->SMR);
                          } ?></td>
        <td align="right"><?php if (!empty($totalbiaya)) {
                            echo uang($totalbiaya);
                          } ?></td>
      </tr>
    <?php $no++;
    } ?>
  </tbody>
  <tfoot>
    <tr style="font-weight: bold;">
      <td colspan="3" align="center" bgcolor="#024a75" style="color:white; font-size:12px;">TOTAL</td>
      <td align="right"><?php if (!empty($totaltsm)) {
                          echo uang($totaltsm);
                        } ?></td>
      <td align="right"><?php if (!empty($totalbdg)) {
                          echo uang($totalbdg);
                        } ?></td>
      <td align="right"><?php if (!empty($totalskb)) {
                          echo uang($totalskb);
                        } ?></td>
      <td align="right"><?php if (!empty($totaltgl)) {
                          echo uang($totaltgl);
                        } ?></td>
      <td align="right"><?php if (!empty($totalbgr)) {
                          echo uang($totalbgr);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpwt)) {
                          echo uang($totalpwt);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpst)) {
                          echo uang($totalpst);
                        } ?></td>
      <td align="right"><?php if (!empty($totalgrt)) {
                          echo uang($totalgrt);
                        } ?></td>
      <td align="right"><?php if (!empty($totalsby)) {
                          echo uang($totalsby);
                        } ?></td>
      <td align="right"><?php if (!empty($totalsmr)) {
                          echo uang($totalsmr);
                        } ?></td>
      <td align="right"><?php if (!empty($totalbiayaall)) {
                          echo uang($totalbiayaall);
                        } ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <?php
      $nettsm = $swan['TSM'] - $returswan['TSM'];
      $netbdg = $swan['BDG'] - $returswan['BDG'];
      $netskb = $swan['SKB'] - $returswan['SKB'];
      $netbgr = $swan['BGR'] - $returswan['BGR'];
      $nettgl = $swan['TGL'] - $returswan['TGL'];
      $netpwt = $swan['PWT'] - $returswan['PWT'];
      $netpst = $swan['PST'] - $returswan['PST'];
      $netsby = $swan['SBY'] - $returswan['SBY'];
      $netsmr = $swan['SMR'] - $returswan['SMR'];

      $netaidatsm = $aida['TSM'] - $returaida['TSM'];
      $netaidabdg = $aida['BDG'] - $returaida['BDG'];
      $netaidaskb = $aida['SKB'] - $returaida['SKB'];
      $netaidabgr = $aida['BGR'] - $returaida['BGR'];
      $netaidatgl = $aida['TGL'] - $returaida['TGL'];
      $netaidapwt = $aida['PWT'] - $returaida['PWT'];
      $netaidapst = $aida['PST'] - $returaida['PST'];
      $netaidasby = $aida['SBY'] - $returaida['SBY'];
      $netaidasmr = $aida['SMR'] - $returaida['SMR'];

      $totalswan = $nettsm + $netbdg + $netskb + $netbgr + $nettgl + $netpwt + $netpst + $netsby + $netsmr;
      $totalaida = $netaidatsm + $netaidabdg + $netaidaskb + $netaidabgr + $netaidatgl + $netaidapwt + $netaidapst + $netaidasby + $netaidasmr;
      ?>
      <td colspan="2" rowspan="4" align="center" bgcolor="#024a75" style="color:white; font-size:12px;">PENJUALAN</td>
      <td bgcolor="#024a75" style="color:white; font-size:12px;">SWAN</td>
      <td align="right"><?php if (!empty($nettsm)) {
                          echo uang($nettsm);
                        } ?></td>
      <td align="right"><?php if (!empty($netbdg)) {
                          echo uang($netbdg);
                        } ?></td>
      <td align="right"><?php if (!empty($netskb)) {
                          echo uang($netskb);
                        } ?></td>
      <td align="right"><?php if (!empty($netbgr)) {
                          echo uang($netbgr);
                        } ?></td>
      <td align="right"><?php if (!empty($nettgl)) {
                          echo uang($nettgl);
                        } ?></td>
      <td align="right"><?php if (!empty($netpwt)) {
                          echo uang($netpwt);
                        } ?></td>
      <td align="right"><?php if (!empty($netpst)) {
                          echo uang($netpst);
                        } ?></td>
      <td></td>
      <td align="right"><?php if (!empty($netsby)) {
                          echo uang($netsby);
                        } ?></td>
      <td align="right"><?php if (!empty($netsmr)) {
                          echo uang($netsmr);
                        } ?></td>
      <td align="right"><?php if (!empty($totalswan)) {
                          echo uang($totalswan);
                        } ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <?php
      if ($nettsm != 0) {
        $crswantsm = ($totaltsm / $nettsm) * 100;
      } else {
        $crswantsm = 0;
      }

      if ($netbdg != 0) {
        $crswanbdg = ($totalbdg / $netbdg) * 100;
      } else {
        $crswanbdg = 0;
      }

      if ($netskb != 0) {
        $crswanskb = ($totalskb / $netskb) * 100;
      } else {
        $crswanskb = 0;
      }

      if ($nettgl != 0) {
        $crswantgl = ($totaltgl / $nettgl) * 100;
      } else {
        $crswantgl = 0;
      }

      if ($netbgr != 0) {
        $crswanbgr = ($totalbgr / $netbgr) * 100;
      } else {
        $crswanbgr = 0;
      }

      if ($netpwt != 0) {
        $crswanpwt = ($totalpwt / $netpwt) * 100;
      } else {
        $crswanpwt = 0;
      }

      if ($netpst != 0) {
        $crswanpst = ($totalpst / $netpst) * 100;
      } else {
        $crswanpst = 0;
      }

      if ($netsby != 0) {
        $crswansby = ($totalsby / $netsby) * 100;
      } else {
        $crswansby = 0;
      }

      if ($netsmr != 0) {
        $crswansmr = ($totalsmr / $netsmr) * 100;
      } else {
        $crswansmr = 0;
      }

      if ($totalswan != 0) {
        $crtotalswan = ($totalbiayaall / $totalswan) * 100;
      } else {
        $crtotalswan = 0;
      }






      ?>
      <td bgcolor="#024a75" style="color:white; font-size:12px;">COST RATIO</td>
      <td align="right"><?php echo ROUND($crswantsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswantgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($crswansby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswansmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalswan) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#024a75" style="color:white; font-size:12px;">AIDA</td>
      <td align="right"><?php if (!empty($netaidatsm)) {
                          echo uang($netaidatsm);
                        } ?></td>
      <td align="right"><?php if (!empty($netaidabdg)) {
                          echo uang($netaidabdg);
                        } ?></td>
      <td align="right"><?php if (!empty($netaidaskb)) {
                          echo uang($netaidaskb);
                        } ?></td>
      <td align="right"><?php if (!empty($netaidabgr)) {
                          echo uang($netaidabgr);
                        } ?></td>
      <td align="right"><?php if (!empty($netaidatgl)) {
                          echo uang($netaidatgl);
                        } ?></td>
      <td align="right"><?php if (!empty($netaidapwt)) {
                          echo uang($netaidapwt);
                        } ?></td>
      <td align="right"><?php if (!empty($netaidapst)) {
                          echo uang($netaidapst);
                        } ?></td>
      <td></td>
      <td align="right"><?php if (!empty($netaidasby)) {
                          echo uang($netaidasby);
                        } ?></td>
      <td align="right"><?php if (!empty($netaidasmr)) {
                          echo uang($netaidasmr);
                        } ?></td>
      <td align="right"><?php if (!empty($totalaida)) {
                          echo uang($totalaida);
                        } ?></td>

    </tr>
    <tr style="font-weight: bold;">

      <td bgcolor="#024a75" style="color:white; font-size:12px;">COST RATIO</td>
      <?php
      if ($netaidatsm != 0) {
        $craidatsm = ($totaltsm / $netaidatsm) * 100;
      } else {
        $craidatsm = 0;
      }

      if ($netaidabdg != 0) {
        $craidabdg = ($totalbdg / $netaidabdg) * 100;
      } else {
        $craidabdg = 0;
      }

      if ($netaidaskb != 0) {
        $craidaskb = ($totalskb / $netaidaskb) * 100;
      } else {
        $craidaskb = 0;
      }

      if ($netaidatgl != 0) {
        $craidatgl = ($totaltgl / $netaidatgl) * 100;
      } else {
        $craidatgl = 0;
      }

      if ($netaidabgr != 0) {
        $craidabgr = ($totalbgr / $netaidabgr) * 100;
      } else {
        $craidabgr = 0;
      }

      if ($netaidapwt != 0) {
        $craidapwt = ($totalpwt / $netaidapwt) * 100;
      } else {
        $craidapwt = 0;
      }

      if ($netaidapst != 0) {
        $craidapst = ($totalpst / $netaidapst) * 100;
      } else {
        $craidapst = 0;
      }

      if ($netaidasby != 0) {
        $craidasby = ($totalsby / $netaidasby) * 100;
      } else {
        $craidasby = 0;
      }

      if ($netaidasmr != 0) {
        $craidasmr = ($totalsmr / $netaidasmr) * 100;
      } else {
        $craidasmr = 0;
      }

      if ($totalaida != 0) {
        $crtotalaida = ($totalbiayaall / $totalaida) * 100;
      } else {
        $crtotalaida = 0;
      }
      ?>
      <td align="right"><?php echo ROUND($craidatsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidaskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidatgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($craidasby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidasmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalaida) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <?php
      $totalpenjtsm   = $nettsm + $netaidatsm;
      $totalpenjbdg   = $netbdg + $netaidabdg;
      $totalpenjskb   = $netskb + $netaidaskb;
      $totalpenjbgr   = $netbgr + $netaidabgr;
      $totalpenjtgl   = $nettgl + $netaidatgl;
      $totalpenjpwt   = $netpwt + $netaidapwt;
      $totalpenjpst   = $netpst + $netaidapst;
      $totalpenjsby   = $netsby + $netaidasby;
      $totalpenjsmr   = $netsmr + $netaidasmr;

      $totalpenjualanall = $totalpenjtsm + $totalpenjbdg + $totalpenjskb + $totalpenjtgl + $totalpenjbgr + $totalpenjpwt + $totalpenjpst + $totalpenjsby + $totalpenjsmr;


      ?>
      <td bgcolor="#024a75" style="color:white; font-size:12px;" colspan="3">TOTAL PENJUALAN</td>
      <td align="right"><?php if (!empty($totalpenjtsm)) {
                          echo uang($totalpenjtsm);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjbdg)) {
                          echo uang($totalpenjbdg);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjskb)) {
                          echo uang($totalpenjskb);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjtgl)) {
                          echo uang($totalpenjtgl);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjbgr)) {
                          echo uang($totalpenjbgr);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjpwt)) {
                          echo uang($totalpenjpwt);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjpst)) {
                          echo uang($totalpenjpst);
                        } ?></td>
      <td></td>
      <td align="right"><?php if (!empty($totalpenjsby)) {
                          echo uang($totalpenjsby);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjsmr)) {
                          echo uang($totalpenjsmr);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpenjualanall)) {
                          echo uang($totalpenjualanall);
                        } ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#024a75" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN + AIDA</td>
      <?php
      if ($totalpenjtsm != 0) {
        $crtotalpenjtsm = ($totaltsm / $totalpenjtsm) * 100;
      } else {
        $crtotalpenjtsm = 0;
      }

      if ($totalpenjbdg != 0) {
        $crtotalpenjbdg = ($totalbdg / $totalpenjbdg) * 100;
      } else {
        $crtotalpenjbdg = 0;
      }

      if ($totalpenjskb != 0) {
        $crtotalpenjskb = ($totalskb / $totalpenjskb) * 100;
      } else {
        $crtotalpenjskb = 0;
      }

      if ($totalpenjtgl != 0) {
        $crtotalpenjtgl = ($totaltgl / $totalpenjtgl) * 100;
      } else {
        $crtotalpenjtgl = 0;
      }

      if ($totalpenjbgr != 0) {
        $crtotalpenjbgr = ($totalbgr / $totalpenjbgr) * 100;
      } else {
        $crtotalpenjbgr = 0;
      }

      if ($totalpenjpwt != 0) {
        $crtotalpenjpwt = ($totalpwt / $totalpenjpwt) * 100;
      } else {
        $crtotalpenjpwt = 0;
      }

      if ($totalpenjpst != 0) {
        $crtotalpenjpst = ($totalpst / $totalpenjpst) * 100;
      } else {
        $crtotalpenjpst = 0;
      }

      if ($totalpenjsby != 0) {
        $crtotalpenjsby = ($totalsby / $totalpenjsby) * 100;
      } else {
        $crtotalpenjsby = 0;
      }

      if ($totalpenjsmr != 0) {
        $crtotalpenjsmr = ($totalsmr / $totalpenjsmr) * 100;
      } else {
        $crtotalpenjsmr = 0;
      }

      if ($totalpenjualanall != 0) {
        $crtotalpenjualanall = ($totalbiayaall / $totalpenjualanall) * 100;
      } else {
        $crtotalpenjualanall = 0;
      }
      ?>
      <td align="right"><?php echo ROUND($crtotalpenjtsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjtgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($crtotalpenjsby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjsmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjualanall) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <?php
      $totalpiutang = $piutang['TSM'] + $piutang['BDG'] + $piutang['SKB'] + $piutang['TGL'] + $piutang['BGR'] + $piutang['PWT'] + $piutang['PST'] + $piutang['SBY'] + $piutang['SMR'];

      ?>
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">PITUANG > 1 BULAN</td>
      <td align="right"><?php if (!empty($piutang['TSM'])) {
                          echo uang($piutang['TSM']);
                        } ?></td>
      <td align="right"><?php if (!empty($piutang['BDG'])) {
                          echo uang($piutang['BDG']);
                        } ?></td>
      <td align="right"><?php if (!empty($piutang['SKB'])) {
                          echo uang($piutang['SKB']);
                        } ?></td>
      <td align="right"><?php if (!empty($piutang['TGL'])) {
                          echo uang($piutang['TGL']);
                        } ?></td>
      <td align="right"><?php if (!empty($piutang['BGR'])) {
                          echo uang($piutang['BGR']);
                        } ?></td>
      <td align="right"><?php if (!empty($piutang['PWT'])) {
                          echo uang($piutang['PWT']);
                        } ?></td>
      <td align="right"><?php if (!empty($piutang['PST'])) {
                          echo uang($piutang['PST']);
                        } ?></td>
      <td></td>
      <td align="right"><?php if (!empty($piutang['SBY'])) {
                          echo uang($piutang['SBY']);
                        } ?></td>
      <td align="right"><?php if (!empty($piutang['SMR'])) {
                          echo uang($piutang['SMR']);
                        } ?></td>
      <td align="right"><?php if (!empty($totalpiutang)) {
                          echo uang($totalpiutang);
                        } ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <?php
      if ($nettsm != 0) {
        $crswanpiutangtsm = ($piutang['TSM'] / $nettsm) * 100;
      } else {
        $crswanpiutangtsm = 0;
      }

      if ($netbdg != 0) {
        $crswanpiutangbdg = ($piutang['BDG'] / $netbdg) * 100;
      } else {
        $crswanpiutangbdg = 0;
      }

      if ($netskb != 0) {
        $crswanpiutangskb = ($piutang['SKB'] / $netskb) * 100;
      } else {
        $crswanpiutangskb = 0;
      }

      if ($nettgl != 0) {
        $crswanpiutangtgl = ($piutang['TGL'] / $nettgl) * 100;
      } else {
        $crswanpiutangtgl = 0;
      }

      if ($netbgr != 0) {
        $crswanpiutangbgr = ($piutang['BGR'] / $netbgr) * 100;
      } else {
        $crswanpiutangbgr = 0;
      }

      if ($netpwt != 0) {
        $crswanpiutangpwt = ($piutang['PWT'] / $netpwt) * 100;
      } else {
        $crswanpiutangpwt = 0;
      }

      if ($netpst != 0) {
        $crswanpiutangpst = ($piutang['PST'] / $netpst) * 100;
      } else {
        $crswanpiutangpst = 0;
      }

      if ($netsby != 0) {
        $crswanpiutangsby = ($piutang['SBY'] / $netsby) * 100;
      } else {
        $crswanpiutangsby = 0;
      }

      if ($netsmr != 0) {
        $crswanpiutangsmr = ($piutang['SMR'] / $netsmr) * 100;
      } else {
        $crswanpiutangsmr = 0;
      }

      if ($totalswan != 0) {
        $crtotalpiutangswan = ($totalpiutang / $totalswan) * 100;
      } else {
        $crtotalpiutangswan = 0;
      }
      ?>
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN</td>
      <td align="right"><?php echo ROUND($crswanpiutangtsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpiutangbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpiutangskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpiutangtgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpiutangbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpiutangpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpiutangpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($crswanpiutangsby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanpiutangsmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpiutangswan) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">

      <?php
      if ($netaidatsm != 0) {
        $craidapiutangtsm = ($piutang['TSM'] / $netaidatsm) * 100;
      } else {
        $craidapiutangtsm = 0;
      }

      if ($netaidabdg != 0) {
        $craidapiutangbdg = ($piutang['BDG'] / $netaidabdg) * 100;
      } else {
        $craidapiutangbdg = 0;
      }

      if ($netaidaskb != 0) {
        $craidapiutangskb = ($piutang['SKB'] / $netaidaskb) * 100;
      } else {
        $craidapiutangskb = 0;
      }

      if ($netaidatgl != 0) {
        $craidapiutangtgl = ($piutang['TGL'] / $netaidatgl) * 100;
      } else {
        $craidapiutangtgl = 0;
      }

      if ($netaidabgr != 0) {
        $craidapiutangbgr = ($piutang['BGR'] / $netaidabgr) * 100;
      } else {
        $craidapiutangbgr = 0;
      }

      if ($netaidapwt != 0) {
        $craidapiutangpwt = ($piutang['PWT'] / $netaidapwt) * 100;
      } else {
        $craidapiutangpwt = 0;
      }

      if ($netaidapst != 0) {
        $craidapiutangpst = ($piutang['PST'] / $netaidapst) * 100;
      } else {
        $craidapiutangpst = 0;
      }

      if ($netaidasby != 0) {
        $craidapiutangsby = ($piutang['SBY'] / $netaidasby) * 100;
      } else {
        $craidapiutangsby = 0;
      }

      if ($netaidasmr != 0) {
        $craidapiutangsmr = ($piutang['SMR'] / $netaidasmr) * 100;
      } else {
        $craidapiutangsmr = 0;
      }

      if ($totalaida != 0) {
        $crtotalpiutangaida = ($totalpiutang / $totalaida) * 100;
      } else {
        $crtotalpiutangaida = 0;
      }
      ?>
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">COST RATIO AIDA</td>
      <td align="right"><?php echo ROUND($craidapiutangtsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapiutangbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapiutangskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapiutangtgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapiutangbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapiutangpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapiutangpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($craidapiutangsby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidapiutangsmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpiutangaida) . " %"; ?></td>
    </tr>
    <tr style="font-weight:bold">
      <td bgcolor="#e47a2e" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN + AIDA</td>
      <?php
      if ($totalpenjtsm != 0) {
        $crtotalpenjpiutangtsm = ($piutang['TSM'] / $totalpenjtsm) * 100;
      } else {
        $crtotalpenjpiutangtsm = 0;
      }

      if ($totalpenjbdg != 0) {
        $crtotalpenjpiutangbdg = ($piutang['BDG'] / $totalpenjbdg) * 100;
      } else {
        $crtotalpenjpiutangbdg = 0;
      }

      if ($totalpenjskb != 0) {
        $crtotalpenjpiutangskb = ($piutang['SKB'] / $totalpenjskb) * 100;
      } else {
        $crtotalpenjpiutangskb = 0;
      }

      if ($totalpenjtgl != 0) {
        $crtotalpenjpiutangtgl = ($piutang['TGL'] / $totalpenjtgl) * 100;
      } else {
        $crtotalpenjpiutangtgl = 0;
      }

      if ($totalpenjbgr != 0) {
        $crtotalpenjpiutangbgr = ($piutang['BGR'] / $totalpenjbgr) * 100;
      } else {
        $crtotalpenjpiutangbgr = 0;
      }

      if ($totalpenjpwt != 0) {
        $crtotalpenjpiutangpwt = ($piutang['PWT'] / $totalpenjpwt) * 100;
      } else {
        $crtotalpenjpiutangpwt = 0;
      }

      if ($totalpenjpst != 0) {
        $crtotalpenjpiutangpst = ($piutang['PST'] / $totalpenjpst) * 100;
      } else {
        $crtotalpenjpiutangpst = 0;
      }

      if ($totalpenjsby != 0) {
        $crtotalpenjpiutangsby = ($piutang['SBY'] / $totalpenjsby) * 100;
      } else {
        $crtotalpenjpiutangsby = 0;
      }

      if ($totalpenjsmr != 0) {
        $crtotalpenjpiutangsmr = ($piutang['SMR'] / $totalpenjsmr) * 100;
      } else {
        $crtotalpenjpiutangsmr = 0;
      }

      if ($totalpenjualanall != 0) {
        $crtotalpenjualanpiutangall = ($totalpiutang / $totalpenjualanall) * 100;
      } else {
        $crtotalpenjualanpiutangall = 0;
      }
      ?>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangtsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangtgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangsby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjpiutangsmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjualanpiutangall) . " %"; ?></td>
    </tr>
    <tr style="font-weight:bold">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">BIAYA + PIUTANG</td>
      <?php
      $biayapiutangtsm = $totaltsm + $piutang['TSM'];
      $biayapiutangbdg = $totalbdg + $piutang['BDG'];
      $biayapiutangskb = $totalskb + $piutang['SKB'];
      $biayapiutangtgl = $totaltgl + $piutang['TGL'];
      $biayapiutangbgr = $totalbgr + $piutang['BGR'];
      $biayapiutangpwt = $totalpwt + $piutang['PWT'];
      $biayapiutangpst = $totalpst + $piutang['PST'];
      $biayapiutangsby = $totasby + $piutang['SBY'];
      $biayapiutangsmr = $totalsmr + $piutang['SMR'];
      $totalbiayapiutang = $biayapiutangtsm + $biayapiutangbdg + $biayapiutangskb + $biayapiutangtgl + $biayapiutangbgr + $biayapiutangpwt + $biayapiutangpst +
        $biayapituangsby + $biayapiutangsmr;
      ?>
      <td align="right"><?php if (!empty($biayapiutangtsm)) {
                          echo uang($biayapiutangtsm);
                        } ?></td>
      <td align="right"><?php if (!empty($biayapiutangbdg)) {
                          echo uang($biayapiutangbdg);
                        } ?></td>
      <td align="right"><?php if (!empty($biayapiutangskb)) {
                          echo uang($biayapiutangskb);
                        } ?></td>
      <td align="right"><?php if (!empty($biayapiutangtgl)) {
                          echo uang($biayapiutangtgl);
                        } ?></td>
      <td align="right"><?php if (!empty($biayapiutangbgr)) {
                          echo uang($biayapiutangbgr);
                        } ?></td>
      <td align="right"><?php if (!empty($biayapiutangpwt)) {
                          echo uang($biayapiutangpwt);
                        } ?></td>
      <td align="right"><?php if (!empty($biayapiutangpst)) {
                          echo uang($biayapiutangpst);
                        } ?></td>
      <td align="right"></td>
      <td align="right"><?php if (!empty($biayapiutangsby)) {
                          echo uang($biayapiutangsby);
                        } ?></td>
      <td align="right"><?php if (!empty($biayapiutangsmr)) {
                          echo uang($biayapiutangsmr);
                        } ?></td>
      <td align="right"><?php if (!empty($totalbiayapiutang)) {
                          echo uang($totalbiayapiutang);
                        } ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN</td>
      <?php
      if ($nettsm != 0) {
        $crswanbiayapiutangtsm = ($biayapiutangtsm / $nettsm) * 100;
      } else {
        $crswanbiayapiutangtsm = 0;
      }

      if ($netbdg != 0) {
        $crswanbiayapiutangbdg = ($biayapiutangbdg / $netbdg) * 100;
      } else {
        $crswanbiayapiutangbdg = 0;
      }

      if ($netskb != 0) {
        $crswanbiayapiutangskb = ($biayapiutangskb / $netskb) * 100;
      } else {
        $crswanbiayapiutangskb = 0;
      }

      if ($nettgl != 0) {
        $crswanbiayapiutangtgl = ($biayapiutangtgl / $nettgl) * 100;
      } else {
        $crswanbiayapiutangtgl = 0;
      }

      if ($netbgr != 0) {
        $crswanbiayapiutangbgr = ($biayapiutangbgr / $netbgr) * 100;
      } else {
        $crswanbiayapiutangbgr = 0;
      }

      if ($netpwt != 0) {
        $crswanbiayapiutangpwt = ($biayapiutangpwt / $netpwt) * 100;
      } else {
        $crswanbiayapiutangpwt = 0;
      }

      if ($netpst != 0) {
        $crswanbiayapiutangpst = ($biayapiutangpst / $netpst) * 100;
      } else {
        $crswanbiayapiutangpst = 0;
      }

      if ($netsby != 0) {
        $crswanbiayapiutangsby = ($biayapiutangsby / $netsby) * 100;
      } else {
        $crswanbiayapiutangsby = 0;
      }

      if ($netsmr != 0) {
        $crswanbiayapiutangsmr = ($biayapiutangsmr / $netsmr) * 100;
      } else {
        $crswanbiayapiutangsmr = 0;
      }

      if ($totalswan != 0) {
        $crswanbiayapiutang = ($totalbiayapiutang / $totalswan) * 100;
      } else {
        $crswanbiayapiutang = 0;
      }






      ?>
      <td align="right"><?php echo ROUND($crswanbiayapiutangtsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangtgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangsby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutangsmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crswanbiayapiutang) . " %"; ?></td>
    </tr>
    <tr style="font-weight:bold">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">COST RATIO AIDA</td>
      <?php
      if ($netaidatsm != 0) {
        $craidabiayapiutangtsm = ($biayapiutangtsm / $netaidatsm) * 100;
      } else {
        $craidabiayapiutangtsm = 0;
      }

      if ($netaidabdg != 0) {
        $craidabiayapiutangbdg = ($biayapiutangbdg / $netaidabdg) * 100;
      } else {
        $craidabiayapiutangbdg = 0;
      }

      if ($netaidaskb != 0) {
        $craidabiayapiutangskb = ($biayapiutangskb / $netaidaskb) * 100;
      } else {
        $craidabiayapiutangskb = 0;
      }

      if ($netaidatgl != 0) {
        $craidabiayapiutangtgl = ($biayapiutangtgl / $netaidatgl) * 100;
      } else {
        $craidabiayapiutangtgl = 0;
      }

      if ($netaidabgr != 0) {
        $craidabiayapiutangbgr = ($biayapiutangbgr / $netaidabgr) * 100;
      } else {
        $craidabiayapiutangbgr = 0;
      }

      if ($netaidapwt != 0) {
        $craidabiayapiutangpwt = ($biayapiutangpwt / $netaidapwt) * 100;
      } else {
        $craidabiayapiutangpwt = 0;
      }

      if ($netaidapst != 0) {
        $craidabiayapiutangpst = ($biayapiutangpst / $netaidapst) * 100;
      } else {
        $craidabiayapiutangpst = 0;
      }

      if ($netaidasby != 0) {
        $craidabiayapiutangsby = ($biayapiutangsby / $netaidasby) * 100;
      } else {
        $craidabiayapiutangsby = 0;
      }

      if ($netaidasmr != 0) {
        $craidabiayapiutangsmr = ($biayapiutangsmr / $netaidasmr) * 100;
      } else {
        $craidabiayapiutangsmr = 0;
      }

      if ($totalaida != 0) {
        $craidabiayapiutang = ($totalbiayapiutang / $totalaida) * 100;
      } else {
        $craidabiayapiutang = 0;
      }
      ?>
      <td align="right"><?php echo ROUND($craidabiayapiutangtsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangtgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangsby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutangsmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($craidabiayapiutang) . " %"; ?></td>
    </tr>
    <tr style="font-weight: bold;">
      <td bgcolor="#c55d5d" style="color:white; font-size:12px;" colspan="3">COST RATIO SWAN + AIDA</td>
      <?php
      if ($totalpenjtsm != 0) {
        $crtotalpenjbiayapiutangtsm = ($biayapiutangtsm / $totalpenjtsm) * 100;
      } else {
        $crtotalpenjbiayapiutangtsm = 0;
      }

      if ($totalpenjbdg != 0) {
        $crtotalpenjbiayapiutangbdg = ($biayapiutangbdg / $totalpenjbdg) * 100;
      } else {
        $crtotalpenjbiayapiutangbdg = 0;
      }

      if ($totalpenjskb != 0) {
        $crtotalpenjbiayapiutangskb = ($biayapiutangskb / $totalpenjskb) * 100;
      } else {
        $crtotalpenjbiayapiutangskb = 0;
      }

      if ($totalpenjtgl != 0) {
        $crtotalpenjbiayapiutangtgl = ($biayapiutangtgl / $totalpenjtgl) * 100;
      } else {
        $crtotalpenjbiayapiutangtgl = 0;
      }

      if ($totalpenjbgr != 0) {
        $crtotalpenjbiayapiutangbgr = ($biayapiutangbgr / $totalpenjbgr) * 100;
      } else {
        $crtotalpenjbiayapiutangbgr = 0;
      }

      if ($totalpenjpwt != 0) {
        $crtotalpenjbiayapiutangpwt = ($biayapiutangpwt / $totalpenjpwt) * 100;
      } else {
        $crtotalpenjbiayapiutangpwt = 0;
      }

      if ($totalpenjpst != 0) {
        $crtotalpenjbiayapiutangpst = ($biayapiutangpst / $totalpenjpst) * 100;
      } else {
        $crtotalpenjbiayapiutangpst = 0;
      }

      if ($totalpenjsby != 0) {
        $crtotalpenjbiayapiutangsby = ($biayapiutangsby / $totalpenjsby) * 100;
      } else {
        $crtotalpenjbiayapiutangsby = 0;
      }

      if ($totalpenjsmr != 0) {
        $crtotalpenjbiayapiutangsmr = ($biayapiutangsmr / $totalpenjsmr) * 100;
      } else {
        $crtotalpenjbiayapiutangsmr = 0;
      }

      if ($totalpenjualanall != 0) {
        $crtotalpenjualanbiayapiutang = ($totalbiayapiutang / $totalpenjualanall) * 100;
      } else {
        $crtotalpenjualanbiayapiutang = 0;
      }
      ?>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangtsm) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangbdg) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangskb) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangtgl) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangbgr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangpwt) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangpst) . " %"; ?></td>
      <td align="right"></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangsby) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjbiayapiutangsmr) . " %"; ?></td>
      <td align="right"><?php echo ROUND($crtotalpenjualanbiayapiutang) . " %"; ?></td>
    </tr>
  </tfoot>
</table>