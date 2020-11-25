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
<b style="font-size:14px; font-family:Calibri">
	<?php
		if($cb['nama_cabang'] != ""){
			echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
		}else{
			echo "PACIFIC ALL CABANG";
		}

	?>
	<br>
	REKAP PENJUALAN PELANGGAN<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
	<?php
		if($salesman['nama_karyawan'] != ""){
			echo "NAMA SALES : ". strtoupper($salesman['nama_karyawan']);
		}else{
			echo "ALL SALES";
		}
	?>
	<br>
	<?php
		if($pelanggan['nama_pelanggan'] != ""){
			echo "NAMA PELANGGAN : ". strtoupper($pelanggan['nama_pelanggan']);
		}
	?>
</b>
<br>
<br>
<table class="datatable3" style="width:100%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td>No</td>
			<td>Kode Pel.</td>
			<td>Nama Pelanggan</td>
			<td>Nama Sales</td>
			<td>Pasar/Daerah</td>
			<td>Hari</td>
			<td>Total</td>
			<td>Potongan</td>
			<td>Potongan Istimewa</td>
			<td>Penyesuaian</td>
			<td>Penjualan Netto</td>
			<td>Total Retur</td>
			<td>Grand Total</td>
			<td>Rata-Rata</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$totalpenjualan 	= 0;
			$totalpotongan  	= 0;
			$totalpotistimewa = 0;
			$totalpenyharga 	= 0;
			$totalnetto 		  = 0;
			$totalretur 			= 0;
			$grandtotalall		= 0;
			$no = 1;
			foreach($penjualan as $p){

				$totalpenjualan 	= $totalpenjualan + $p->totalpenjualan;
				$totalpotongan  	= $totalpotongan + $p->totalpotongan;
				$totalpotistimewa	= $totalpotistimewa + $p->totalpotistimewa;
				$totalpenyharga   = $totalpenyharga + $p->totalpenyharga;
				$totalnetto 			= $totalnetto + $p->totalpenjualannetto;
				$totalrata2 			= $totalrata2 + $rata2;
				$grandtotal 			= $p->totalpenjualannetto - $p->totalretur;
				$totalretur 			= $totalretur + $p->totalretur;
				$grandtotalall 		= $grandtotalall + $grandtotal;
				$pembagi 				  = substr($sampai,5,2);;
				$rata2 				    = $grandtotal/$pembagi;
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $p->kode_pelanggan; ?></td>
				<td><?php echo $p->nama_pelanggan; ?></td>
				<td><?php echo $p->nama_karyawan; ?></td>
				<td><?php echo $p->pasar; ?></td>
				<td><?php echo $p->hari; ?></td>
				<td align="right"><?php echo uang($p->totalpenjualan); ?></td>
				<td align="right"><?php echo uang($p->totalpotongan); ?></td>
				<td align="right"><?php echo uang($p->totalpotistimewa); ?></td>
				<td align="right"><?php echo uang($p->totalpenyharga); ?></td>
				<td align="right"><?php echo uang($p->totalpenjualannetto); ?></td>
				<td align="right"><?php echo uang($p->totalretur); ?></td>
				<td align="right"><?php echo uang($grandtotal); ?></td>
				<td align="right">
					<?php
						echo uang($rata2);
					?>
				</td>
			</tr>
		<?php
				$no++;
			}
		?>
	</tbody>
	<tr bgcolor="#024a75" style="color:white; font-weight:bold">
		<td colspan="6">TOTAL</td>
		<td align="right"><?php echo uang($totalpenjualan); ?></td>
		<td align="right"><?php echo uang($totalpotongan); ?></td>
		<td align="right"><?php echo uang($totalpotistimewa); ?></td>
		<td align="right"><?php echo uang($totalpenyharga); ?></td>
		<td align="right"><?php echo uang($totalnetto); ?></td>
		<td align="right"><?php echo uang($totalretur); ?></td>
		<td align="right"><?php echo uang($grandtotalall); ?></td>
		<td align="right"><?php echo uang($totalrata2); ?></td>
	</tr>
</table>
<?php  } ?>
