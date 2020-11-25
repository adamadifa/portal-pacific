<?php
	//error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}
?>

<table class="table table-striped card-table table-bordered">
  <thead class="thead-dark">
		<tr>
			<th colspan="2">REKAP KAS BESAR</th>
		</tr>
		<tr>
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
	<tfoot class="thead-dark">
			<tr>
				<th style="font-weight:bold">TOTAL</th>
				<th style="text-align:right; font-weight:bold"><?php echo uang($total); ?></th>
			</tr>
	</tfoot>
</table>