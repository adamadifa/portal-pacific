<?php
error_reporting(0);
function uang($nilai)
{
	return number_format($nilai, '2', ',', '.');
}
function angka($nilai)
{
	return number_format($nilai, '2', ',', '.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
	REKAP PEMBELIAN <?php echo $jenis; ?> <br>
	PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
</b>
<br>
<br>
<table class="datatable3" style="width:70%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
			<td>NO</td>
			<td>NAMA BAHAN</td>
			<td>JENIS</td>
			<td>SATUAN</td>
			<td>QTY</td>
			<td>HARGA</td>
			<td>QTY(gram)</td>
			<td>HARGA(gram)</td>
			<td>TOTAL</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$totalbahanbaku  = 0;
		$totalbahanpembantu = 0;
		$totalkemasan = 0;
		$no 		= 1;
		foreach ($pmb as $key => $d) {
			// $totalharga = ($d->harga * $d->qty) + $d->penyesuaian;
			// $subtotal = $d->harga * $d->qty;
			// if($d->ppn=='1')
			// {
			//   $cekppn  =  "&#10004;";
			//   $bgcolor = "#ececc8";
			//   $dpp     = (100/110) * $totalharga;
			//   $ppn     = 10/100*$dpp;
			// }else{
			//   $bgcolor = "";
			//   $cekppn  = "";
			//   $dpp     = "";
			//   $ppn     = "";
			// }
			//
			// $grandtotal 	= $totalharga;
			// $total 				= $total + $grandtotal;
			if ($d->jenis_barang == 'BAHAN BAKU') {
				//echo "TEST";
				$totalbahanbaku = $totalbahanbaku + $d->totalharga;
				$totalbahanpembantu = $totalbahanpembantu +  0;
				$totalkemasan = $totalkemasan + 0;
			} else if ($d->jenis_barang == 'Bahan Tambahan') {
				$totalbahanbaku = $totalbahanbaku + 0;
				$totalbahanpembantu = $totalbahanpembantu + $d->totalharga;
				$totalkemasan = $totalkemasan + 0;
			} else if ($d->jenis_barang == 'KEMASAN') {
				$totalbahanbaku = $totalbahanbaku + 0;
				$totalbahanpembantu = $totalbahanpembantu + 0;
				$totalkemasan = $totalkemasan + $d->totalharga;
			}

			//echo strlen($d->jenis_barang);
		?>
			<tr style="background-color:<?php echo $bgcolor; ?>">
				<td><?php echo $no; ?></td>
				<td><?php echo $d->nama_barang; ?></td>
				<td><?php echo $d->jenis_barang; ?></td>
				<td><?php echo $d->satuan; ?></td>
				<td align="center"><?php echo uang($d->totalqty); ?></td>
				<td align="right"><?php echo uang($d->totalharga / $d->totalqty); ?></td>
				<?php if ($d->satuan == "KG") { ?>
					<td align="center"><?php echo uang($d->totalqty * 1000); ?></td>
					<td align="center"><?php echo uang($d->totalharga / ($d->totalqty * 1000)); ?></td>
					<td align="right"><?php echo uang($d->totalharga); ?></td>
				<?php } else { ?>
					<td align="center"><?php echo uang($d->totalqty); ?></td>
					<td align="center"><?php echo uang($d->totalharga / ($d->totalqty)); ?></td>
					<td align="right"><?php echo uang($d->totalharga); ?></td>
				<?php } ?>
			</tr>
		<?php
			$no++;
		}
		?>
		<?php if ($jenis == 'BAHAN') { ?>
			<tr bgcolor="#024a75" style="color:white">
				<td colspan="8"><b>Total Bahan Baku</b></td>
				<td align="right"><b><?php echo uang($totalbahanbaku); ?></b></td>
			</tr>
			<tr bgcolor="#024a75" style="color:white">
				<td colspan="8"><b>Total Bahan Pembantu</b></td>
				<td align="right"><b><?php echo uang($totalbahanpembantu); ?></b></td>
			</tr>
		<?php } else { ?>
			<tr bgcolor="#024a75" style="color:white">
				<td colspan="8"><b>Total Bahan Kemasan</b></td>
				<td align="right"><b><?php echo uang($totalkemasan); ?></b></td>
			</tr>
		<?php } ?>
	</tbody>

</table>