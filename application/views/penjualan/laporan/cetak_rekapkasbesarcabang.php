<?php
	error_reporting(0);
	function uang($nilai){

		return number_format($nilai,'0','','.');
	}

?>

<?php 

	if($dari < '2018-09-01'){
	?>

	<div class="alert alert-danger">
        <strong>Sorry Bro!</strong> Maaf Untuk Data Penjualan Kurang Dari Bulan September 2018 Tidak Dapat Ditampilkan.!
    </div>
<?php
	

	}else{
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
REKAP KAS BESAR ALL CABANG
<br>
PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
</b>
<br>
<br>
<table class="datatable3" style="width:40%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th>CABANG</th>
			<th>TOTAL KAS BESAR</th>
		</tr>
	</thead>
	<tbody>
		<?php $total = 0 ; foreach($rekapkasbesarcabang as $r){ $total= $total+ $r->totalkasbesar; ?>
			<tr style="font-size:12">
				<td style="font-weight:bold"><?php echo strtoUpper($r->nama_cabang); ?></td>
				<td style="text-align:right; font-weight:bold"><?php echo uang($r->totalkasbesar); ?></td>
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
			<tr bgcolor="#024a75" style="color:white; font-size:12;">
				<td style="font-weight:bold">TOTAL</td>
				<td style="text-align:right; font-weight:bold"><?php echo uang($total); ?></td>
			</tr>
	</tfoot>
<?php } ?>