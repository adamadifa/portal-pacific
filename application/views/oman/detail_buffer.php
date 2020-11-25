<?php
	function uang($nilai){
		return number_format($nilai,'2',',','.');
	}
?>
<table class="table table-bordered table-hover table-striped">
	<tr>
		<td colspan="3"><b>Kode Buffer</b></td>
		<td><?php echo $buffer['kode_bufferstok']; ?></td>
	</tr>
	<tr>
		<td colspan="3"><b>Cabang</b></td>
		<td><?php echo $buffer['kode_cabang']; ?></td>
	</tr>
</table>
<hr>
<table class="table table-bordered table-hover table-striped">
	<thead class = "" >
		<tr>
			<th rowspan="3" align="">No</th>
			<th rowspan="3" style="text-align:center">Nama Barang</th>
			<th colspan="3" style="text-align:center">Buffer Stok</th>
		</tr>
		<tr>
			<th colspan="3" style="text-align:center">Kuantitas</th>
		</tr>
		<tr>
			<th style="text-align:center">Jumlah</th>
			<th style="text-align:center">Satuan</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			foreach ($detailbuffer as $d ){
				$jumlah = $d->jumlah / $d->isipcsdus;
				$jmldus = floor($d->jumlah / $d->isipcsdus);
				if($d->jumlah !=0 ){
					$sisadus   = $d->jumlah % $d->isipcsdus;
				}else{
					$sisadus = 0;
				}
				if($d->isipack == 0){
					$jmlpack    = 0;
					$sisapack   = $sisadus;
					$s          = "A";
				}else{
					$jmlpack    = floor($sisadus / $d->isipcs);
					$sisapack   = $sisadus % $d->isipcs;
					$s          = "B";
				}
				$jmlpcs = $sisapack;
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $d->nama_barang; ?></td>
				<td align="center"><?php if(!empty($jmldus)){ echo $jmldus; } ?></td>
				<td align="center"><?php echo $d->satuan; ?></td>
			</tr>
		<?php
				$no++;
			}
		 ?>
	</tbody>
</table>
