<?php
	error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'2',',','.');
	}

  function angka($nilai){
		return number_format($nilai,'2',',','.');
	}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
  REKAP PEMBELIAN PER-SUPPLIER <br>
  PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
</b>
<br>
<br>
<table class="datatable3" style="width:70%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
      <td>NO</td>
      <td>KODE SUPPLIER</td>
      <td>NAMA SUPPLIER</td>
      <td>DEBET</td>
			<td>KREDIT</td>
    </tr>
  </thead>
  <tbody>
		<?php
			$total  = 0;
			$no 		= 1;
			foreach ($pmb as $key => $d) {
				$total = $total + $d->jumlah;
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $d->kode_supplier; ?></td>
				<td><?php echo $d->nama_supplier; ?></td>
				<td align="right"><?php echo uang($d->jumlah); ?></td>
				<td align="right"><?php echo uang($d->jumlah); ?></td>
			</tr>
		<?php
			$no++;
		}
		?>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td colspan="3"><b>TOTAL</b></td>
			<td align="right"><b><?php echo uang($total); ?></b></td>
			<td align="right"><b><?php echo uang($total); ?></b></td>
		</tr>
	</tbody>

</table>
