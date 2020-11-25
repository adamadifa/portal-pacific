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

<table style="width:100%" class="garis5">
	<tr>
		<td  class="garis5" colspan="2" style="padding:8px; font-size:20px; text-align:center"><b>BUKTI PENGAJUAN DAN PENERIMAAN BARANG</b></td>
		<td  class="garis5" style="padding:8px">Dok.No FRM.PUR.01.01. Rev.00</td>
	</tr>
	<tr>
		<td colspan="3" class="garis5" style="padding:8px; font-size:18px; text-align:center">
			Dikeluarkan Oleh CV. MAKMUR PERMATA, Jln. Perintis Kemerdekaan Kota Tasikmalaya, Telp. (0265) 336794
		</td>
	</tr>
	<tr>
		<td class="garis5" style="padding:8px; font-size:18px;">NO. PPB : <?php echo $pmb['nobukti_pembelian']; ?> </td>
		<td class="garis5" style="padding:8px; font-size:18px;">Pemasok : <?php echo $pmb['nama_supplier']; ?></td>
		<td class="garis5" style="padding:8px; font-size:18px;">Tanggal Pengajuan : </td>
	</tr>
</table>
<table style="width:100%" class="garis6">
	<tr style="font-size:16px; text-align:center">
		<td style="padding:5px" rowspan="2">No</td>
		<td style="padding:5px" rowspan="2">Nama Barang</td>
		<td style="padding:5px" colspan="2">Jumlah</td>
		<td style="padding:5px" rowspan="2">Harga Barang</td>
		<td style="padding:5px" rowspan="2">Total</td>
		<td style="padding:5px" rowspan="2">Tanggal Terima</td>
		<td style="padding:5px" rowspan="2">Tanggal Bayar</td>
	</tr>
	<tr style="font-size:16px; text-align:center">
		<td style="padding:5px">Diajukan</td>
		<td style="padding:5px">Diterima</td>
	</tr>
	<tr style="font-size:16px; text-align:center">
		<td style="padding:5px"  colspan="6"> <b>JUMLAH</b></td>
		<td style="padding:5px"></td>
	</tr>
	<tr style="font-size:16px; text-align:center">
		<td style="padding:5px">Tembusan :</td>
		<td style="padding:5px">Mengetahui</td>
		<td style="padding:5px" colspan="3">Diterima</td>
		<td style="padding:5px" colspan="3">Diserahkan</td>
	</tr>
	<tr style="font-size:16px; text-align:left">
		<td style="padding:5px">1. Keuangan</td>
		<td style="padding:5px" rowspan="3"></td>
		<td style="padding:5px" colspan="3" rowspan="3"></td>
		<td style="padding:5px" colspan="3" rowspan="3"></td>
	</tr>
	<tr style="font-size:16px; text-align:left">
		<td style="padding:5px">2. Pemasok</td>
	</tr>
	<tr style="font-size:16px; text-align:left">
		<td style="padding:5px">3. Pembelian</td>
	</tr>
	<tr style="font-size:16px; ">
		<td style="padding:5px; text-align:left">4. Gudang </td>
		<td style="padding:5px; text-align:center">Manajer Gudang</td>
		<td style="padding:5px; text-align:center" colspan="3">Gudang</td>
		<td style="padding:5px; text-align:center" colspan="3">Pembelian</td>
	</tr>

</table>
