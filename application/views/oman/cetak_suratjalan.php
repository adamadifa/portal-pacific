<?php

		
?>
<style>
body {
	letter-spacing: 0px;
	font-family: Roman;
	font-size:13px;
}

table {
	font-family: Arial;
	font-size:13px;
}

.garis5, .garis5 td, .garis5 tr, .garis5 th
{
	border: 2px solid black;
	border-collapse:collapse;
}

.table {border:solid 1px #000000; width:100%; font-size:12px; margin:auto;}
.table th {border:1px #000000;  font-size:12px; 

font-family:Arial;}
.table td {border: solid 1px #000000; 
}

</style>
	
<table border="0" width="100%">
<tr>
	<td style="width:300px">
		<table class="garis5">
			<tr>
				<td>SURAT JALAN</td>
			</tr>
			<tr>
				<td>NOMOR <?php echo $sj['no_mutasi_gudang'] ?></td>
			
			</tr>
		</table>
	</td>
	<td colspan="6" align="left">
		<b>CV PACIFIC<br>
			Jln. Perintis Kemerdekaan No. 160 Tasikmalaya Telp. (0265) 7520864
		</b>
		
	</td>
</tr>
<tr>
	<td colspan="7" align="center"><hr></td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td width="15%">Tgl Faktur</td>
	<td width="1%">:</td>
	<td width="40%"><?php echo DatetoIndo2($sj['tgl_mutasi_gudang']); ?></td>
	<td>Nama</td>
	<td>:</td>
	<td>CV PACIFIC CABANG <?php echo strtoupper($sj['nama_cabang']); ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>No Kendaraan</td>
	<td>:</td>
	<td></td>
	<td>Alamat</td>
	<td>:</td>
	<td><?php echo $sj['alamat_cabang']; ?></td>
</tr>

<tr>
	<td colspan="7">

		<table class="garis5" width="100%">
				<thead>
					<tr>
						<th>NO</th>
						<th>KODE BARANG</th>
						<th>NAMA BARANG</th>
						<th>JUMLAH</th>
						<th>SATUAN</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1; foreach($detail as $b){ 
					?>
						<tr>
							<td align="center"><?php echo $no; ?></td>
							<td><?php echo $b->kode_produk; ?></td>
							<td><?php echo $b->nama_barang; ?></td>
							<td align="right"><?php echo number_format($b->jumlah,'0','','.'); ?></td>
							<td align="center"><?php echo $b->satuan; ?></td>
						</tr>
					<?php $no++; } ?>
						
				</tbody>

		</table>
		
	</td>
</tr>
<tr>
	<table class="garis5" width="100%">
		<tr style="font-weight:bold; text-align:center">
			<td>Bag. Gudang Jadi</td>
			<td>Diserahkan</td>
			<td>Diterima</td>
			<td>Mengetahui</td>
		</tr>
		<tr style="font-weight:bold; height:30px;">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr style="font-weight:bold; text-align:center">
			<td>Purnomo Raya</td>
			<td>Pengemudi</td>
			<td>Gudang Cabang</td>
			<td>Security</td>
		</tr>
	</table>
</tr>

</table>
