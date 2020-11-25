<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr style="font-weight:bold">
      <th>Tanggal</th>
      <th>NO Bukti</th>
      <th>Supplier</th>
      <th>Departemen</th>
      <th>PPN</th>
    </tr>
  </thead>

  <tr>
    <td><?php echo DateToIndo2($pmb['tgl_pembelian']); ?></td>
    <td><?php echo $pmb['nobukti_pembelian']; ?></td>
    <td><?php echo $pmb['nama_supplier']; ?></td>
    <td><?php echo $pmb['nama_dept']; ?></td>
    <td>
      <?php
      if (!empty($pmb['ppn'])) {
        echo '<i class="material-icons">check_box</i>';
      }
      ?>
    </td>
  </tr>
</table>
<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Ket</th>
      <th>Qty</th>
      <th>Harga</th>
      <th>Subtotal</th>
      <th>Penyesuaian</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    $total = 0;
    foreach ($detail as $d) {
      $total = $total + (($d->qty * $d->harga) + $d->penyesuaian); ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo $d->qty; ?></td>
        <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format($d->harga * $d->qty, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format($d->penyesuaian, '2', ',', '.'); ?></td>
        <td align="right"><?php echo number_format((($d->qty * $d->harga) + $d->penyesuaian), '2', ',', '.'); ?></td>
      </tr>
    <?php $no++;
    }  ?>
    <tr>
      <th colspan="7">TOTAL PEMBELIAN</th>
      <td align="right"><b> <?php echo number_format($total, '2', ',', '.'); ?></b></td>
    </tr>
  </tbody>
</table>


<?php
if (!empty($cekpnj)) {
?>
  <table class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Keterangan</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $totalharga = 0;
      $no = 1;
      foreach ($pmbpnj as $d) {
        $totalharga = $totalharga + ($d->qty * $d->harga); ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $d->ket_penjualan; ?></td>
          <td><?php echo $d->qty; ?></td>
          <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
          <td align="right"><?php echo number_format($d->qty * $d->harga, '2', ',', '.'); ?></td>
        </tr>
      <?php $no++;
      } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4">TOTAL POTONGAN</th>
        <th style="text-align:right"><?php echo number_format($totalharga, '2', ',', '.'); ?></th>
      </tr>
      <tr>
        <th colspan="4">GRAND TOTAL</th>
        <th style="text-align:right"><?php echo number_format($total - $totalharga, '2', ',', '.'); ?></th>
      </tr>
    </tfoot>
  </table>
<?php
}
?>

<!-- <?php
      if (!empty($pmb['ppn'])) {
      ?>
<table class="table table-bordered table-hover table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>No BPB</th>
      <th>Nama Barang</th>
      <th>Ket</th>
      <th>Qty</th>
      <th>Harga DPP</th>
      <th>Total</th>
      <th>PPN</th>

    </tr>
  </thead>
  <tbody>
      <?php
        $no       = 1;
        $totaldpp = 0;
        $totalppn = 0;
        foreach ($detail as $d) {
          $dpp      = (100 / 110) * $d->harga;
          $ppn      = ($dpp * $d->qty) * (10 / 100);
          $totaldpp = $totaldpp + ($d->qty * $dpp);
          $totalppn = $totalppn + $ppn;
      ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->no_bpb; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo $d->qty; ?></td>
        <td align="right"><?php echo number_format($dpp, '0', '', '.'); ?></td>
        <td align="right"><?php echo number_format($d->qty * $dpp, '0', '', '.'); ?></td>
        <td align="right"><?php echo number_format($ppn, '0', '', '.'); ?></td>
      </tr>
    <?php $no++;
        }  ?>
    <tr>
      <td colspan="6">TOTAL</td>
      <td align="right"> <?php echo number_format($totaldpp, '0', '', '.'); ?></td>
      <td align="right"> <b><?php echo number_format($totalppn, '0', '', '.'); ?></b></td>
    </tr>
    <tr>
      <td colspan="7">GRAND TOTAL</td>
      <td align="right"><b><?php echo number_format($total + $totalppn, '0', '', '.'); ?></b></td>
    </tr>
  </tbody>
</table>
<?php
      }
?> -->
<table class="table table-bordered table-striped table-hoer">
  <thead class="thead-dark">
    <tr>
      <th colspan="6">Histori Pengajuan Pembayaran</th>
    </tr>
    <tr>
      <th>NO</th>
      <th>Tanggal</th>
      <th>No Kontra BON</th>
      <th>Jumlah</th>
      <th>Jenis Pengajuan</th>
      <th>Tgl Cair</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($kb as $k) {
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo DateToIndo2($k->tgl_kontrabon); ?></td>
        <td><?php echo $k->no_kontrabon; ?></td>
        <td align="right"><?php echo number_format($k->jmlbayar, '2', ',', '.'); ?></td>
        <td>
          <?php
          if ($k->kategori == 'TN') {
            echo "TUNAI";
          } else {
            echo $k->kategori;
          };
          ?>
        </td>
        <td>
          <?php
          if (empty($k->tglbayar)) {
            echo "<span class='badge bg-red'>Belum Transfer</span>";
          } else {
            echo "<span class='badge bg-green'>" . DateToIndo2($k->tglbayar) . "</span>";
          }
          ?>
        </td>
      </tr>
    <?php
      $no++;
    }
    ?>
  </tbody>
</table>
<!-- <?php if ($pmb['jenistransaksi'] != 'tunai') { ?> -->

<!-- <?php } else { ?>
  <table class="table table-bordered table-striped table-hoer">
    <thead>
      <tr>
        <th colspan="5">Histori Pembayaran</th>
      </tr>
      <tr>
        <th>NO</th>
        <th>Jumlah</th>
        <th>Tgl Bayar</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no = 1;
        foreach ($kb as $k) {
      ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td align="right"><?php echo number_format($k->jmlbayar, '0', '', '.'); ?></td>
          <td>
            <?php
            echo "<span class='badge bg-green'>" . DateToIndo2($k->tglbayar) . "</span>";
            ?>
          </td>
        </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
<?php } ?> -->