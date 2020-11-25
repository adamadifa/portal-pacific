<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<table class="datatable3" style="font-size:14px">
  <tr>
    <td>Kode Klaim</td>
    <td>:</td>
    <td><b><?php echo $klaim['kode_klaim']; ?></b></td>
  </tr>
  <tr>
    <td>Tanggal Klaim</td>
    <td>:</td>
    <td><b><?php echo DateToIndo2($klaim['tgl_klaim']); ?></b></td>
  </tr>
  <tr>
    <td>Keterangan</td>
    <td>:</td>
    <td><b><?php echo $klaim['keterangan']; ?></b></td>
  </tr>

</table>
<br>
<table class="datatable3" style="font-size:14px">
  <thead bgcolor="#024a75" style="color:white; font-size:14px;">
    <tr>
      <th>TGL</th>
      <th>No Bukti</th>
      <th>Keterangan</th>
      <th>Penerimaan</th>
      <th>Pengeluaran</th>
      <th>Saldo</th>
    </tr>
    <tr>
      <th>SALDO AWAL</th>
      <th colspan="4"></th>
      <th style="text-align:right"><?php if (!empty($saldoawal)) {
                                      echo number_format($saldoawal, '0', '', '.');
                                    } ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $saldo            = $saldoawal;
    $totalpenerimaan  = 0;
    $totalpengeluaran = 0;
    $totalpenerimaan2 = 0;
    foreach ($detail as $d) {
      if ($d->status_dk == 'K') {
        $penerimaan   = $d->jumlah;
        $s             = $penerimaan;
        $pengeluaran  = 0;
      } else {
        $penerimaan   = 0;
        $pengeluaran  = $d->jumlah;
        $s             = -$pengeluaran;
      }

      $saldo              = $saldo + $s;
      $totalpenerimaan     = $totalpenerimaan + $penerimaan;
      $totalpengeluaran    = $totalpengeluaran + $pengeluaran;
      if ($d->keterangan != 'Penerimaan Kas Kecil') {
        $totalpenerimaan2 = $totalpenerimaan2 + $penerimaan;
      }
    ?>
      <tr>
        <td><?php echo $d->tgl_kaskecil; ?></td>
        <td><?php echo $d->nobukti; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td align="right" style="color:green"><?php if (!empty($penerimaan)) {
                                                echo number_format($penerimaan, '0', '', '.');
                                              } ?></td>
        <td align="right" style="color:red"><?php if (!empty($pengeluaran)) {
                                              echo number_format($pengeluaran, '0', '', '.');
                                            } ?></td>
        <td align="right"><?php if (!empty($saldo)) {
                            echo number_format($saldo, '0', '', '.');
                          } ?></td>
      </tr>
    <?php } ?>
  </tbody>
  <tfooter>
    <tr>
      <th colspan="3">TOTAL</th>
      <td align="right" style="color:green"><b><?php if (!empty($totalpenerimaan)) {
                                                  echo number_format($totalpenerimaan, '0', '', '.');
                                                } ?></b></td>
      <td align="right" style="color:red"><b><?php if (!empty($totalpengeluaran)) {
                                                echo number_format($totalpengeluaran, '0', '', '.');
                                              } ?></b></td>
      <td align="right"><b><?php if (!empty($saldo)) {
                              echo number_format($saldo, '0', '', '.');
                            } ?></b></td>
    </tr>
    <tr>
      <td class="bg-blue text-white">Penggantian Kas Kecil</td>
      <?php
      if ($klaim['kode_cabang'] == 'PST') {
        $penggantian = $totalpengeluaran - $totalpenerimaan2;
      } else {
        $penggantian = $totalpengeluaran - $totalpenerimaan2;
      }
      ?>
      <td colspan="2" align="right"><b><?php if (!empty($penggantian)) {
                                          echo number_format($penggantian, '0', '', '.');
                                        } ?></b></td>

      <td class="bg-blue text-white">Saldo Awal</td>
      <td colspan="2" align="right"><b><?php if (!empty($saldoawal['jumlah'])) {
                                          echo number_format($saldoawal['jumlah'], '0', '', '.');
                                        } ?></b></td>
    </tr>
    <tr>
      <td class="bg-blue text-white">Terbilang</td>
      <td colspan="2" align="right"><b><?php echo ucfirst(terbilang($penggantian)); ?></b></td>
      <td class="bg-blue text-white">Penerimaan Pusat</td>
      <td colspan="2" align="right"><b><?php if (!empty($totalpenerimaan)) {
                                          echo number_format($totalpenerimaan, '0', '', '.');
                                        } ?></b></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2"></td>
      <td class="bg-blue text-white">Total</td>
      <td colspan="2" align="right"><b><?php if (!empty($saldoawal + $totalpenerimaan - $totalpenerimaan2)) {
                                          echo number_format($saldoawal + $totalpenerimaan - $totalpenerimaan2, '0', '', '.');
                                        } ?></b></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2"></td>
      <td class="bg-blue text-white">Pengeluaran Kas Kecil</td>
      <td colspan="2" align="right"><b><?php if (!empty($totalpengeluaran)) {
                                          echo number_format($totalpengeluaran, '0', '', '.');
                                        } ?></b></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2"></td>
      <td class="bg-blue text-white">Saldo Akhir</td>
      <td colspan="2" align="right"><b><?php if (!empty($saldo)) {
                                          echo $saldo;
                                        } ?></b></td>
    </tr>

  </tfooter>
</table>
<br>
<br>
<br>
<table border="0" style="width:64%">
  <tr style="text-align:center">
    <td>Dibuat Oleh,</td>
    <td>Mengetahui</td>
    <td>Disetujui Oleh,</td>
  </tr>
  <tr>
    <td style="height:70px"></td>
    <td></td>
    <td></td>
  </tr>
  <tr style="text-align:center">
    <td>Admin</td>
    <td>Kepala Penjualan</td>
    <td>Kepala Admin</td>
  </tr>
</table>