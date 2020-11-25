<?php

	function uang($nilai){

		return number_format($nilai,'0','','.');
	}

	 $namabulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	REALISASI KIRIMAN PRODUK
	<?php
		if(!empty($cb['nama_cabang'])){
	?>
		CABANG <?php echo strtoupper($cb['nama_cabang']); ?><br>
	<?php }else{ ?>
		ALL CABANG <Br>
	<?php } ?>

	PERIODE <?php echo strtoupper($namabulan[$bulan])." ". $tahun; ?><br><br>

</b>
<br>
<table class="datatable3" style="width:60%" border="1">
	<thead>
		<tr bgcolor="#eda310" style="color:white; font-size:12;">
			<th>NO</th>
			<th>JENIS PRODUK</th>
			<th>TARGET</th>
			<th>PERMINTAAN</th>
			<th>REALISASI</th>
			<th>SISA TARGET</th>
			<th>REALISASI(%)</th>
			<th>TARGET(%)</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no =1;
			foreach($rekap as $r){

				if(!empty($r->permintaan)){
					$pmvsrealisasi = ($r->realisasi / $r->permintaan) * 100;
				}else{
					$pmvsrealisasi = "";
				}

				if(!empty($r->target)){
					$targetvsrealisasi = ($r->realisasi / $r->target) * 100;
				}else{
					$targetvsrealisasi = "";
				}
		?>
			<tr style="  font-weight: bold; font-size:11px">
				<td><?php echo $no; ?></td>
				<td><?php echo $r->nama_barang; ?></td>
				<td><?php echo $r->target; ?></td>
				<td align="right"><?php if($r->permintaan !=0){echo uang($r->permintaan); } ?></td>
				<td align="right"><?php if($r->realisasi !=0){echo uang($r->realisasi); } ?></td>
				<td align="right"><?php if($r->target !=0 ){ $sisa = $r->target-$r->realisasi; if($sisa >=0){echo uang($sisa);} } ?></td>
				<td align="right"><?php if($pmvsrealisasi !=0){echo round($pmvsrealisasi,2)."%"; } ?></td>
				<td align="right"><?php if($targetvsrealisasi !=0){echo round($targetvsrealisasi,2)."%"; } ?></td>
			</tr>
		<?php
			$no++;
		 }
		?>
	</tbody>
</table>
