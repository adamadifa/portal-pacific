<?php
	error_reporting(0);
	function uang($nilai){

		return number_format($nilai,'2',',','.');
	}

?>

<?php

	if($dari < '2018-01-01'){
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
	REKAPITULASI PENJUALAN PELANGGAN<br>
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
<table class="datatable3" style="width:150%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td rowspan="2">No</td>
			<td rowspan="2">Kode Pel.</td>
			<td rowspan="2">Nama Pelanggan</td>
			<td colspan="10">Produk</td>
		</tr>
		<tr>
			<td>AIDA BESAR 500 GR</td>
			<td>AIDA KECIL SACHET</td>
			<td>AIDA BESAR 250 GR</td>
			<td>SAOS BAWANG BALL</td>
			<td>CABE GILING KG</td>
			<td>CABE GILING MURAH</td>
			<td>SAOS BAWANG DUS</td>
			<td>SAUS EXTRA PEDAS</td>
			<td>KECAP DUS</td>
			<td>SAUS STICK</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			$totalAB 	= 0;
			$totalAR 	= 0;
			$totalASE 	= 0;
			$totalBB 	= 0;
			$totalCG 	= 0;
			$totalCGG 	= 0;
			$totalDB 	= 0;
			$totalDEP 	= 0;
			$totalDK 	= 0;
			$totalDS 	= 0;

			foreach ($rekap as $p){

			$totalAB 	= $totalAB + $p->AB;
			$totalAR 	= $totalAR + $p->AR;
			$totalASE 	= $totalASE + $p->ASE;
			$totalBB 	= $totalBB + $p->BB;
			$totalCG 	= $totalCG + $p->CG;
			$totalCGG	= $totalCGG + $p->CGG;
			$totalDB 	= $totalDB + $p->DB;
			$totalDEP 	= $totalDEP + $p->DEP;
			$totalDK 	= $totalDK + $p->DK;
			$totalDS 	= $totalDS + $p->DS;

		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $p->kode_pelanggan; ?></td>
				<td><?php echo $p->nama_pelanggan; ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->AB)){echo uang($p->AB);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->AR)){echo uang($p->AR);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->ASE)){echo uang($p->ASE);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->BB)){echo uang($p->BB);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->CG)){echo uang($p->CG);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->CGG)){echo uang($p->CGG);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->DB)){echo uang($p->DB);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->DEP)){echo uang($p->DEP);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->DK)){echo uang($p->DK);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->DS)){echo uang($p->DS);} ?></td>

			</tr>

		<?php
			$no++;
		 } ?>
	</tbody>
	<tfoot>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td style="text-align:center; font-weight:bold" colspan="3">TOTAL</td>
			<td align="right"><?php if (!empty($totalAB)){echo uang($totalAB);} ?></td>
			<td align="right"><?php if (!empty($totalAR)){echo uang($totalAR);} ?></td>
			<td align="right"><?php if (!empty($totalASE)){echo uang($totalASE);} ?></td>
			<td align="right"><?php if (!empty($totalBB)){echo uang($totalBB);} ?></td>
			<td align="right"><?php if (!empty($totalCG)){echo uang($totalCG);} ?></td>
			<td align="right"><?php if (!empty($totalCGG)){echo uang($totalCGG);} ?></td>
			<td align="right"><?php if (!empty($totalDB)){echo uang($totalDB);} ?></td>
			<td align="right"><?php if (!empty($totalDEP)){echo uang($totalDEP);} ?></td>
			<td align="right"><?php if (!empty($totalDK)){echo uang($totalDK);} ?></td>
			<td align="right"><?php if (!empty($totalDS)){echo uang($totalDS);} ?></td>

		</tr>
	</tfoot>
</table>
<?php  } ?>
