<?php

function uang($nilai){

	return number_format($nilai,'0','','.');
}

error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	PACIFIC<br>
	REKAPITULASI LIMIT KREDIT <?php if($cabang == ""){
    echo "SEMUA CABANG";
  }else{
    echo "$cabang";
  }
  ?><br>
  SALES : <?php if($sales == ""){
    echo "SEMUA SALES";
  }else{
    echo "$sales";
  }
  ?><br>
</b>
<br>
<table class="datatable3" style="width:100%" border="1">
	<thead>
		<tr>
			<th bgcolor="#024a75" style="color:white; font-size:12;">No</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Kode Pelanggan</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Nama Pelanggan</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">No HP</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Pasar</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Hari</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Cabang</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Salesman</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Latitude</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Longitude</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;text-align: right;">Limit Kredit</th>
      <th bgcolor="#024a75" style="color:white; font-size:12;">Tanggal Pengajuan</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1;
    foreach ($data as $d) {
      ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d->kode_pelanggan; ?></td>
        <td><?php echo $d->nama_pelanggan; ?></td>
        <td><?php echo $d->no_hp; ?></td>
        <td><?php echo $d->pasar; ?></td>
        <td><?php echo $d->hari; ?></td>
        <td><?php echo $d->nama_cabang; ?></td>
        <td><?php echo $d->nama_karyawan; ?></td>
        <td><?php echo $d->latitude; ?></td>
        <td><?php echo $d->longitude; ?></td>
        <td style="text-align: right;"><?php echo uang($d->jumlah); ?></td>
        <td><?php echo $d->tgl_pengajuan; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
