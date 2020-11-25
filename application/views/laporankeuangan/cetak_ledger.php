<?php
function uang($nilai){
  return number_format($nilai,'2',',','.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
  PACIFIC<br>
  REKAPITULASI LEDGER BANK <?php echo $bank['nama_bank']; ?><br>
  PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br><br>
</b>
<br>
<table class="datatable3">
  <thead bgcolor="#024a75" style="color:white; font-size:12;">
    <tr>
      <th>No</th>
      <th>TGL</th>
      <th>No Bukti</th>
      <th>No Ref</th>
      <th>TGL Penerimaan</th>
      <th>Pelanggan</th>
      <th>Keterangan</th>
      <th>Kode Akun</th>
      <th>Akun</th>
      <th>Debet</th>
      <th>Kredit</th>
      <th>Saldo</th>
      <th rowspan="2">Tanggal Input</th>
      <th rowspan="2">Tanggal Update</th>
    </tr>
    <tr>
      <th colspan='11'>SALDO AWAL</th>
      <th style= 'text-align:right'><?php if($saldo['jumlah']!=0){echo uang($saldo['jumlah']);}?></td>
      </tr>
    </thead>
    <tbody>
      <?php
      $no=1;
      $totaldebet = 0;
      $totalkredit= 0;
      $saldo = $saldo['jumlah'];
      foreach($ledger as $l){
        if($l->status_dk=='K')
        {
          $kredit = $l->jumlah;
          $debet  = 0;
          $jumlah = $l->jumlah;
        }else{
          $debet  = $l->jumlah;
          $kredit = 0;
          $jumlah = -$l->jumlah;
        }
        $saldo = $saldo + $jumlah;
        $totaldebet = $totaldebet + $debet;
        $totalkredit = $totalkredit + $kredit;

        $date_created =date_create($l->date_created);
        $date_updated =date_create($l->date_updated);

        if(!empty($l->date_updated))
        {
         $dateupdated = date_format($date_updated,"d M Y H:i:s");
       }else{
         $dateupdated = $l->date_updated;
       }

       if(!empty($l->date_created))
       {
         $datecreated = date_format($date_created,"d M Y H:i:s");
       }else{
         $datecreated = $date_created;
       }
       ?>
       <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo date_format(date_create($l->tgl_ledger),'d-M-y'); ?></td>
        <td><?php echo $l->no_bukti; ?></td>
        <td><?php echo $l->no_ref; ?></td>
        <td><?php echo $l->tgl_penerimaan; ?></td>
        <td><?php echo $l->pelanggan; ?></td>
        <td><?php echo $l->keterangan; ?></td>
        <td><?php echo "'".$l->kode_akun; ?></td>
        <td><?php echo $l->nama_akun; ?></td>
        <td align="right"><?php if($debet!=0){echo uang($debet);}?></td>
        <td align="right"><?php if($kredit!=0){echo uang($kredit);}?></td>
        <td align="right"><?php echo uang($saldo);?></td>
        <td><?php echo $datecreated; ?></td>
        <td><?php echo $l->date_updated; ?></td>
      </tr>
      <?php
      $no++;
    }
    ?>
  </tbody>
  <tr bgcolor="#024a75" style="color:white; font-size:12;">
    <th colspan="9">TOTAL</th>
    <th><?php if($totaldebet!=0){echo uang($totaldebet);}?></th>
    <th><?php if($totalkredit!=0){echo uang($totalkredit);}?></th>
    <th align="right"><?php echo uang($saldo);?></th>
    <th></th>
    <th></th>
  </tr>
</table>
