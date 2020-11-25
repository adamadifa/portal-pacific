<table class="table table-bordered table-hover table-striped">
  <tr style="font-weight:bold">
    <td>Tanggal</td>
    <td>NO BPB</td>
    <td>Yang Mengajukan</td>
    <td>Bagian</td>
  </tr>
  <tr>
    <td><?php echo DateToIndo2($bpb['tgl_permintaan']); ?></td>
    <td><?php echo $bpb['no_bpb']; ?></td>
    <td><?php echo $bpb['yangmengajukan']; ?></td>
    <td><?php echo $bpb['nama_dept']; ?></td>
  </tr>
</table>
<table class="table table-bordered table-hover table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Satuan</th>
      <th>Kuantitas</th>
      <th>Realisasi</th>
      <th>%</th>
      <th>Keterangan</th>
      <th>No Bukti</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $jmlpersen = 0;
      $no = 1; foreach($detail as $d){
      $presentase = round($d->qty / $d->jumlah,2)*100;
      $jmlpersen  = $jmlpersen + $presentase;
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td><?php echo number_format($d->jumlah,'0','','.'); ?></td>
        <td><?php echo number_format($d->qty,'0','','.'); ?></td>
        <td align="center">
          <?php
            echo $presentase."%";
           ?>

        </td>
        <td><?php echo $d->keterangan; ?></td>
        <td><?php echo $d->nobukti_pembelian; ?></td>
      </tr>
    <?php $no++; }
    $jumlah       = $no-1;
    $ratapersen   = round($jmlpersen/$jumlah,2);
    ?>
  </tbody>
  <tr>
    <td colspan="4"><b>TOTAL</b></td>
    <td align="center"><?php echo $ratapersen; ?>%</td>
  </tr>
</table>
