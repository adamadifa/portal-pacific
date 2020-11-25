<?php
//error_reporting(0);
function uang($nilai)
{
  return number_format($nilai, '0', '', '.');
}

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:20px; font-family:Calibri">
  POSISI SALDO KAS BESAR
  <br>
  <?php
  if ($cb['nama_cabang'] != "") {
    echo "PACIFIC CABANG " . strtoupper($cb['nama_cabang']);
  } else {
    echo "PACIFIC ALL CABANG";
  }

  ?>
  <br>
  PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
</b>
<br>
<table class="datatable3" border="1" style="width:160%">
  <thead style=" background-color:#31869b; color:white; font-size:12;">
    <tr style=" background-color:orange; color:white; font-size:12;">
      <th colspan="5">PENERIMAAN LHP</th>
      <th>TOTAL</th>
      <th colspan="4">SETORAN KE BANK</th>
      <th>TOTAL</th>
      <th>SALDO</th>
      <th style="border:none; background-color:white; width:100px"></th>
      <th colspan="7">RINCIAN UANG PADA KAS BESAR</th>
    </tr>
    <tr style=" background-color:#31869b; color:white; font-size:12;">
      <th>TGL</th>
      <th>UANG KERTAS</th>
      <th>LOGAM</th>
      <th>GIRO</th>
      <th>TRANSFER</th>
      <th>PENERIMAAN</th>
      <th>UANG KERTAS</th>
      <th>LOGAM</th>
      <th>GIRO</th>
      <th>TRANSFER</th>
      <th>SETORAN KE BANK</th>
      <th>KAS BESAR</th>
      <th style="border:none; background-color:white; width:100px"></th>
      <th>UANG KERTAS</th>
      <th>LOGAM</th>
      <th>GIRO</th>
      <th>TRANSFER</th>
      <th>TOTAL UANG FISIK</th>
      <th style="width:8%">PENUKARAN LOGAM JADI KERTAS</th>
      <th style="width:8%">PENUKARAN GIRO JADI KERTAS</th>
    </tr>
    <tr style=" background-color:white; color:black; font-size:12;">
      <th colspan="11">SALDO AWAL</th>
      <th><?php if (!empty($sa)) {
            echo uang($sa);
          } ?></th>
      <th style="border:none; background-color:white;"></th>
      <th style=" text-align:right; background-color:orange; color:white; font-size:12;"><?php if (!empty($kertas)) {
                                                                                            echo uang($kertas);
                                                                                          } ?></th>
      <th style=" text-align:right; background-color:orange; color:white; font-size:12;"><?php if (!empty($logam)) {
                                                                                            echo uang($logam);
                                                                                          } ?></th>
      <th style=" text-align:right; background-color:orange; color:white; font-size:12;"><?php if (!empty($giro)) {
                                                                                            echo uang($giro);
                                                                                          } ?></th>
      <th style=" text-align:right; background-color:orange; color:white; font-size:12;"><?php if (!empty($transfer)) {
                                                                                            echo uang($transfer);
                                                                                          } ?></th>

      <th style=" text-align:right; background-color:orange; color:white; font-size:12;"></th>
      <th style=" text-align:right; background-color:orange; color:white; font-size:12;"></th>
      <th style=" text-align:right; background-color:orange; color:white; font-size:12;"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $saldo                    = $sa;
    $totalterimakertas        = 0;
    $totalterimalogam         = 0;
    $totalterimagiro          = 0;
    $totalterimatransfer      = 0;
    $totalkeluarkertas        = 0;
    $totalkeluarlogam         = 0;
    $totalkeluargiro          = 0;
    $totalkeluartransfer      = 0;
    $totalallpenerimaan       = 0;
    $totalallpengeluaran      = 0;
    $totalrinciankertas       = $kertas;
    $totalrincianlogam        = $logam;
    $totalrinciangiro         = $giro;
    $totalrinciantrf          = $transfer;

    while (strtotime($dari) <= strtotime($sampai)) {
      $qpengeluaran           = "SELECT SUM(uang_logam) as setoranlogam,SUM(uang_kertas) as setorankertas,SUM(giro) as setorangiro,SUM(transfer) as setorantransfer FROM setoran_pusat WHERE tgl_setoranpusat ='$dari' AND kode_cabang='$cb[kode_cabang]' AND status='1' AND omset_bulan ='$bulan' AND omset_tahun='$tahun' GROUP BY tgl_setoranpusat";
      $pengeluaran            = $this->db->query($qpengeluaran)->row_array();

      $qpenerimaan            = "SELECT SUM(setoran_logam) as lhplogam, SUM(setoran_kertas) as lhpkertas, SUM(setoran_bg) as lhpgiro,SUM(setoran_transfer) as lhptransfer,SUM(girotocash) as lhpgirotocash FROM setoran_penjualan WHERE tgl_lhp ='$dari' AND tgl_lhp <= '$tglakhirpenerimaan' AND kode_cabang='$cb[kode_cabang]' GROUP BY tgl_lhp";
      $penerimaan             = $this->db->query($qpenerimaan)->row_array();

      $qkl_kb                 = "SELECT SUM(uang_kertas) as klkertas, SUM(uang_logam) as kllogam FROM kuranglebihsetor WHERE tgl_kl='$dari' AND tgl_kl <= '$tglakhirpenerimaan' AND kode_cabang='$cb[kode_cabang]' AND pembayaran='1' GROUP BY tgl_kl";
      $kl_kb                  = $this->db->query($qkl_kb)->row_array();

      $qkl_lb                 = "SELECT SUM(uang_kertas) as klkertas, SUM(uang_logam) as kllogam FROM kuranglebihsetor WHERE tgl_kl='$dari' AND tgl_kl <= '$tglakhirpenerimaan' AND kode_cabang='$cb[kode_cabang]' AND pembayaran='2' GROUP BY tgl_kl";
      $kl_lb                  = $this->db->query($qkl_lb)->row_array();

      $qgl                    = "SELECT SUM(jumlah_logamtokertas) as jmlgantikertas FROM logamtokertas WHERE tgl_logamtokertas='$dari' AND tgl_logamtokertas <= '$tglakhirpenerimaan' AND kode_cabang='$cb[kode_cabang]' GROUP BY tgl_logamtokertas";
      $gl                     = $this->db->query($qgl)->row_array();

      $lhpkertas              = $penerimaan['lhpkertas'] + $kl_kb['klkertas'] - $kl_lb['klkertas'];
      $lhplogam               = $penerimaan['lhplogam'] + $kl_kb['kllogam'] - $kl_lb['kllogam'];
      $totallhp               = $lhpkertas + $lhplogam + $penerimaan['lhpgiro'] + $penerimaan['lhptransfer'];
      $totalsetoranbank       = $pengeluaran['setorankertas'] + $pengeluaran['setoranlogam'] + $pengeluaran['setorangiro'] + $pengeluaran['setorantransfer'];
      $kasbesar               = $totallhp - $totalsetoranbank;

      $totalterimakertas      = $totalterimakertas + $lhpkertas;
      $totalterimalogam       = $totalterimalogam + $lhplogam;
      $totalterimatransfer    = $totalterimatransfer + $penerimaan['lhptransfer'];
      $totalterimagiro        = $totalterimagiro + $penerimaan['lhpgiro'];

      $totalkeluarkertas      = $totalkeluarkertas + $pengeluaran['setorankertas'];
      $totalkeluarlogam       = $totalkeluarlogam + $pengeluaran['setoranlogam'];
      $totalkeluargiro        = $totalkeluargiro + $pengeluaran['setorangiro'];
      $totalkeluartransfer    = $totalkeluartransfer + $pengeluaran['setorantransfer'];

      $totalallpenerimaan     = $totalallpenerimaan + $totallhp;
      $totalallpengeluaran    = $totalallpengeluaran + $totalsetoranbank;
      $saldo                  = $saldo + $kasbesar;

      $rinciankertas          = ($lhpkertas - $pengeluaran['setorankertas']) + $gl['jmlgantikertas'] + $penerimaan['lhpgirotocash'];
      $rincianlogam           = ($lhplogam - $pengeluaran['setoranlogam']) - $gl['jmlgantikertas'];
      $rinciangiro            = ($penerimaan['lhpgiro'] - $pengeluaran['setorangiro']) - $penerimaan['lhpgirotocash'];
      $rinciantransfer        = $penerimaan['lhptransfer'] - $pengeluaran['setorantransfer'];
      $totalrinciankertas     = $totalrinciankertas + $rinciankertas;
      $totalrincianlogam      = $totalrincianlogam  + $rincianlogam;
      $totalrinciangiro       = $totalrinciangiro + $rinciangiro;
      $totalrinciantrf        = $totalrinciantrf + $rinciantransfer;
      $totalrincianfisik      = $totalrinciankertas + $totalrincianlogam + $totalrinciangiro + $totalrinciantrf;
    ?>
      <tr>
        <td bgcolor="#ba0e0e" style="color:white"><?php echo DateToIndo2($dari); ?></td>
        <td align="right" style="font-weight:bold; color:green"><?php if (!empty($lhpkertas)) {
                                                                  echo uang($lhpkertas);
                                                                } ?></td>
        <td align="right" style="font-weight:bold; color:green"><?php if (!empty($lhplogam)) {
                                                                  echo uang($lhplogam);
                                                                } ?></td>
        <td align="right" style="font-weight:bold; color:green"><?php if (!empty($penerimaan['lhpgiro'])) {
                                                                  echo uang($penerimaan['lhpgiro']);
                                                                } ?></td>
        <td align="right" style="font-weight:bold; color:green"><?php if (!empty($penerimaan['lhptransfer'])) {
                                                                  echo uang($penerimaan['lhptransfer']);
                                                                } ?></td>
        <td align="right" style="font-weight:bold; color:green"><?php if (!empty($totallhp)) {
                                                                  echo uang($totallhp);
                                                                } ?></td>
        <td align="right" style="font-weight:bold; color:red"><?php if (!empty($pengeluaran['setorankertas'])) {
                                                                echo uang($pengeluaran['setorankertas']);
                                                              } ?></td>
        <td align="right" style="font-weight:bold; color:red"><?php if (!empty($pengeluaran['setoranlogam'])) {
                                                                echo uang($pengeluaran['setoranlogam']);
                                                              } ?></td>
        <td align="right" style="font-weight:bold; color:red"><?php if (!empty($pengeluaran['setorangiro'])) {
                                                                echo uang($pengeluaran['setorangiro']);
                                                              } ?></td>
        <td align="right" style="font-weight:bold; color:red"><?php if (!empty($pengeluaran['setorantransfer'])) {
                                                                echo uang($pengeluaran['setorantransfer']);
                                                              } ?></td>

        <td align="right" style="font-weight:bold; color:red"><?php if (!empty($totalsetoranbank)) {
                                                                echo uang($totalsetoranbank);
                                                              } ?></td>
        <td align="right" style="font-weight:bold; color:black; color:blue"><?php if (!empty($saldo)) {
                                                                              echo uang($saldo);
                                                                            } ?></td>
        <td style="border:none; background-color:white;"></td>
        <td align="right" style="font-weight:bold;"><?php if (!empty($totalrinciankertas)) {
                                                      echo uang($totalrinciankertas);
                                                    } ?></td>
        <td align="right" style="font-weight:bold;"><?php if (!empty($totalrincianlogam)) {
                                                      echo uang($totalrincianlogam);
                                                    } ?></td>

        <td align="right" style="font-weight:bold;"><?php if (!empty($totalrinciangiro)) {
                                                      echo uang($totalrinciangiro);
                                                    } ?></td>
        <td align="right" style="font-weight:bold;"><?php if (!empty($totalrinciantrf)) {
                                                      echo uang($totalrinciantrf);
                                                    } ?></td>
        <td align="right" style="font-weight:bold; color:blue"><?php if (!empty($totalrincianfisik)) {
                                                                  echo uang($totalrincianfisik);
                                                                } ?></td>
        <td align="right" style="font-weight:bold;"><?php if (!empty($gl['jmlgantikertas'])) {
                                                      echo uang($gl['jmlgantikertas']);
                                                    } ?></td>
        <td align="right" style="font-weight:bold;"><?php if (!empty($penerimaan['lhpgirotocash'])) {
                                                      echo uang($penerimaan['lhpgirotocash']);
                                                    } ?></td>

      </tr>
    <?php
      $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari))); //looping tambah 1 date
    }
    ?>
  </tbody>
  <tfoot>
    <tr style=" background-color:#31869b; font-weight:bold; color:white; font-size:12;">
      <td>TOTAL</td>
      <td align="right"><?php echo uang($totalterimakertas); ?></td>
      <td align="right"><?php echo uang($totalterimalogam); ?></td>
      <td align="right"><?php echo uang($totalterimagiro); ?></td>
      <td align="right"><?php echo uang($totalterimatransfer); ?></td>
      <td align="right"><?php echo uang($totalallpenerimaan); ?></td>
      <td align="right"><?php echo uang($totalkeluarkertas); ?></td>
      <td align="right"><?php echo uang($totalkeluarlogam); ?></td>
      <td align="right"><?php echo uang($totalkeluargiro); ?></td>
      <td align="right"><?php echo uang($totalkeluartransfer); ?></td>
      <td align="right"><?php echo uang($totalallpengeluaran); ?></td>
      <td align="right"><?php echo uang($saldo); ?></td>
      <td style="border:none; background-color:white;"></td>
    </tr>
  </tfoot>
</table>