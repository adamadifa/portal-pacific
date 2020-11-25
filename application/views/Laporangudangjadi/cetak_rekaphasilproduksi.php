<?php
	
	function uang($nilai){

		return number_format($nilai,'0','','.');
	}
	
	 $namabulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	REKAPITULASI PENERIMAAN HASIL PRODUKSI<br>
	PERIODE <?php echo strtoupper($namabulan[$bulan])." ". $tahun; ?><br><br>
	
</b>
<br>

<table class="datatable3" style="width:80%" border="1">
	<thead >
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th>NO</th>
			<th>JENIS PRODUK</th>
			<th style="text-align: center">MINGGU 1 <br> TGL 01 - 07</th>
			<th style="text-align: center">MINGGU 2 <br> TGL 08 - 14</th>
			<th style="text-align: center">MINGGU 3 <br> TGL 15 - 21</th>
			<th style="text-align: center">MINGGU 4 <br> TGL 22 - 31</th>
			<th>TOTAL</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no=1;
			foreach($rekap as $r){

				$total = $r->minggu1 + $r->minggu2 + $r->minggu3 + $r->minggu4;
		?>
			<tr style=" background-color: #91d7d7; font-weight: bold; font-size:11px">
				<td><?php echo $no; ?></td>
				<td><?php echo $r->nama_barang; ?></td>
				<td align="right"><?php if($r->minggu1 !=0){echo uang($r->minggu1); } ?></td>
				<td align="right"><?php if($r->minggu2 !=0){echo uang($r->minggu2); } ?></td>
				<td align="right"><?php if($r->minggu3 !=0){echo uang($r->minggu3); } ?></td>
				<td align="right"><?php if($r->minggu4 !=0){echo uang($r->minggu4); } ?></td>
				<td align="right"><?php echo uang($total);  ?></td>
			</tr>
		<?php 
			$no++;
			}
		?>
	</tbody>
</table>	