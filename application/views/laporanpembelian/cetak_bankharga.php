<?php
	error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}

  function angka($nilai){
		return number_format($nilai,'2',',','.');
	}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
  BANK HARGA <br>
  PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
  <?php
		if($brg != ""){
			echo "BARANG : ". strtoupper($barang['nama_barang']);
		}else{
			//echo "ALL SUPPLIER";
		}
	?>
</b>
<br>
<br>
<table class="datatable3" style="width:50%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
      <td>NO</td>
      <td>TGL</td>
			<td>SUPPLIER</td>
      <td>KODE BARANG</td>
      <td>NAMA BARANG</td>
			<td>HARGA</td>
    </tr>
  </thead>
  <tbody>
		<?php $no =1; foreach($pmb as $b){ ?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo DateToIndo2($b->tgl_pembelian); ?></td>
				<td><?php echo $b->nama_supplier; ?></td>
				<td><?php echo $b->kode_barang; ?></td>
				<td><?php echo $b->nama_barang; ?></td>
				<td style="text-align:right"><?php echo number_format($b->harga,'0','','.'); ?></td>
			</tr>
		<?php $no++; } ?>
	</tbody>
</table>
