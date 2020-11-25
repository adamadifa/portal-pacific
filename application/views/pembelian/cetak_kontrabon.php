<?php


?>
<style>
body {
	letter-spacing: 0px;
	font-family: Tahoma;
	font-size:14px;
}

table {
	font-family: Tahoma;
	font-size:14px;
}

.garis5
{
	border: 2px solid black;
	border-collapse:collapse;
}

.garis6, .garis6 td, .garis6 tr, .garis6 th
{
	border: 2px solid black;
	border-collapse:collapse;
}


hr.style-five
{
  width: 100%;
  border :0px;
  border-bottom: 2px dashed black;
}


</style>
<table style="width:100%">
  <tr>
    <td colspan="3" align="center"><h1>KONTRA BON</h1></td>
  </tr>
  <tr>
    <td class="garis5" style="padding:8px">
      <table style="width:100%">
        <tr>
          <td style="padding:8px; text-align:left; width:60%; font-weight: bold">TERIMA DARI</td>
          <td style="padding:8px8px; text-align:center; width:20%; font-weight: bold">TANGGAL</td>
          <td style="padding:8px; text-align:center; width:20%; font-weight: bold" >NO. KONTRA BON</td>
        </tr>
        <tr>
          <td style="padding:8px; text-align:left; width:60%; font-weight: bold"><?php echo $kontrabon['kode_supplier']."-".$kontrabon['nama_supplier']; ?></td>
          <td style="padding:8px; text-align:center; width:20%; font-weight: bold"><?php echo DateToIndo2($kontrabon['tgl_kontrabon']); ?></td>
          <td style="padding:8px; text-align:center; width:20%; font-weight: bold" ><?php echo $kontrabon['no_kontrabon']; ?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table class="garis6" style="width:100%">
	<tr style="font-weight:bold; text-align:center; font-size:16px">
		<td style="padding:10px; width:5%">No</td>
		<td style="padding:10px">No Bukti</td>
		<td style="padding:10px">Nama Barang</td>
    <td style="padding:10px">Keterangan</td>
    <td style="padding:10px">Jumlah</td>
    <td style="padding:10px">Harga</td>
    <td style="padding:10px">Jumlah</td>
	</tr>
  <?php 
  $no = 1; 
  $total=0; 
  foreach($detail as $d){  
    $total = $total + $d->qty*$d->harga;
    ?>
    <tr style="text-align:center">
      <td><?php echo $no; ?></td>
      <td><?php echo $d->nobukti_pembelian; ?></td>
      <td><?php echo $d->nama_barang; ?></td>
      <td><?php echo $d->keterangan; ?></td>
      <td align="right"><?php echo number_format($d->qty); ?></td>
      <td align="right"><?php echo number_format($d->harga); ?></td>
      <td align="right"><?php echo number_format($d->qty*$d->harga); ?></td>
    </tr>
  <?php $no++; } ?>
  <tr>
    <td colspan="6" style="text-align:center">JUMLAH</td>
    <td style="text-align:right"><?php echo number_format($total,'0','','.'); ?></td>
  </tr>
</table>
<br>
<table style="width:100%" border="0">
  <tr style="font-family:Tahoma; font-size:14px; font-weight:bold">
    <td style="width:10%">TERBILANG :</td>
    <td><i><?php echo strtoupper(terbilang($total))." RUPIAH"; ?></i></td>
  </tr>
</table>
<br>
<table style="width:100%" class="garis5">
  <tr>
    <td style="padding:8px; text-align:left; width:10%; font-weight: bold">KEMBALI TANGGAL</td>
    <td style="padding:8px8px; text-align:center; width:2%; font-weight: bold">:</td>
    <td style="padding:8px; text-align:center; width:88%; font-weight: bold" ></td>
  </tr>
  <tr>
    <td style="padding:8px; text-align:left; width:10%; font-weight: bold">DITRANSFER TANGGAL</td>
    <td style="padding:8px8px; text-align:center; width:2%; font-weight: bold">:</td>
    <td style="padding:8px; text-align:center; width:88%; font-weight: bold" ></td>
  </tr>
</table>
<br>
<table style="width:100%" border="0">
  <tr>
    <td style="padding:8px; text-align:left; width:30%; font-weight: bold" valign="top">
      Tembusan : <br>
      1. Rekanan <br>
      2. Accounting <br>
      3. Adm
    </td>
    <td>
      <table style="width:80%" class="garis6">
        <tr style="text-align:center;">
          <td style="padding:5px">DITERIMA</td>
          <td>DIBUAT</td>
          <td>DIPERIKSA</td>
        </tr>
        <tr>
          <td style="height:100px"></td>
          <td></td>
          <td></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
