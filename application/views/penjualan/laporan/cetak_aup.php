<?php

function uang($nilai)
{

	return number_format($nilai, '0', '', '.');
}
error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">


	<?php
	if ($cb['nama_cabang'] != "") {
		echo "PACIFIC CABANG " . strtoupper($cb['nama_cabang']);
	} else {
		echo "PACIFIC ALL CABANG";
	}

	?>
	<br>
	ANALISA UMUR PIUTANG<br>


	<?php
	if ($salesman['nama_karyawan'] != "") {
		echo "NAMA SALES : " . strtoupper($salesman['nama_karyawan']);
	} else {
		echo "ALL SALES";
	}

	?>
	<br>
	<?php

	echo "TANGGAL : " . DateToIndo2($tanggal);

	?>

</b>
<br>
<br>

<!---- Inisialisasi ---->

<?php

if ($cb['kode_cabang'] != "") {

	$cbg = $cb['kode_cabang'];
} else {
	$cbg = "all";
}

if ($salesman['id_karyawan'] != "") {

	$sales = $salesman['id_karyawan'];
} else {
	$sales = "all";
}


if ($pelanggan['kode_pelanggan'] != "") {

	$plg = $pelanggan['kode_pelanggan'];
} else {
	$plg = "all";
}
?>

<table class="datatable3" style="width:110% !important">

	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">

			<th rowspan="2">Kode Pelanggan</th>
			<th rowspan="2">Nama Pelanggan</th>
			<th rowspan="2">Pasar/Daerah</th>
			<th rowspan="2">Salesman</th>
			<th rowspan="2">Jatuh Tempo</th>
			<th colspan="8">Saldo Piutang</th>
			<th rowspan="2">Total</th>
		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th> 1 s/d 15 Hari</th>
			<th> 16 Hari s/d 1 Bulan</th>
			<th> > 1 Bulan s/d 2 Bulan</th>
			<th> > 2 Bulan s/d 3 Bulan </th>
			<th> > 3 Bulan s/d 6 Bulan </th>
			<th> > 6 Bulan s/d 1 Tahun </th>
			<th> > 1 Tahun s/d 2 Tahun</th>
			<th> > 2 Tahun</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$totalallduaminggu  				= 0;
		$totalallsatubulan					= 0;
		//$totalallsatusetengahbulan 	= 0;
		$totalallduabulan						=	0;
		$totalalllebih3bulan				= 0;
		$totalallenambulan					= 0;
		$totalallduabelasbulan  		= 0;
		//$totalalldelapanbelasbulan	= 0;
		$totalallduatahun              = 0;
		$totalalllebihduatahun			= 0;

		$totalall 									= 0;
		$totalpiutang 							= 0;
		$totalbayar 								= 0;
		$totalsisabayar         		= 0;
		$duaminggu 									= 0;
		$satubulan 									= 0;
		$satusetengahbulan 					= 0;
		$duabulan 									= 0;
		$lebihtigabulan 						= 0;
		$duabelasbulan 							= 0;
		$delapanbelasbulan 					= 0;
		$enambulan 									= 0;
		$lebihduatahun							= 0;
		$total 											= 0;
		$kode_pelanggan 						= "";

		foreach ($aup as $key => $a) {
			$pel  = @$aup[$key + 1]->kode_pelanggan;

			$totalpiutang 			= $totalpiutang + $a->totalpiutang;
			$totalbayar   			= $totalbayar + $a->jmlbayar;
			$totalsisabayar 		= $totalpiutang - $totalbayar;
			$duaminggu 				+= $a->duaminggu;
			$satubulan 				+= $a->satubulan;
			//$satusetengahbulan += $a->satusetengahbulan;
			$duabulan 					+= $a->duabulan;
			$lebihtigabulan		+= $a->lebihtigabulan;
			$enambulan 				+= $a->enambulan;
			$duabelasbulan   	+= $a->duabelasbulan;
			$duatahun          += $a->duatahun;
			$lebihduatahun 		+= $a->lebihduatahun;
			$total 						= $duaminggu + $satubulan + $duabulan + $lebihtigabulan + $enambulan + $duabelasbulan
				+ $lebihduatahun + $duatahun;


			if ($pel != $a->kode_pelanggan) {
				$totalallduaminggu 					= $totalallduaminggu + $duaminggu;
				$totalallsatubulan 	   			= $totalallsatubulan + $satubulan;
				//$totalallsatusetengahbulan 	= $totalallsatusetengahbulan + $satusetengahbulan;
				$totalallduabulan 	   			= $totalallduabulan + $duabulan;
				$totalalllebih3bulan   			= $totalalllebih3bulan + $lebihtigabulan;
				$totalallenambulan 		 			= $totalallenambulan + $enambulan;
				$totalallduabelasbulan 			= $totalallduabelasbulan + $duabelasbulan;
				$totalallduatahun 	         = $totalallduatahun + $duatahun;
				$totalalllebihduatahun 			= $totalalllebihduatahun + $lebihduatahun;

		?>
				<tr>

					<td><?php echo $a->kode_pelanggan; ?></td>
					<td><?php echo $a->nama_pelanggan; ?></td>
					<td><?php echo $a->pasar; ?></td>
					<td><?php echo $a->nama_karyawan; ?></td>
					<td align="center">
						<?php
						$jatuhtempo = $a->jatuhtempo;
						if ($jatuhtempo == 14) {
							$lama = "14 Hari";
						} else if ($jatuhtempo == 30) {
							$lama = "30 Hari";
						} else if ($jatuhtempo == 45) {
							$lama = "45 Hari";
						} else if ($jatuhtempo == 60) {
							$lama = "2 Bulan";
						} else if ($jatuhtempo == 90) {
							$lama = "3 Bulan";
						} else if ($jatuhtempo == 180) {
							$lama = "6 Bulan";
						} else if ($jatuhtempo == 360) {
							$lama = "1 Tahun";
						} else {
							$lama = "";
						}
						if ($lama == "") {
							echo '<span style="color:white; background-color:red; font-weight:bold">Belum Di Ajukan</span>';
						} else {
							echo $lama;
						}
						?>
					</td>
					<td align="right"><?php if ($duaminggu != 0) {
															echo uang($duaminggu);
														} ?></td>
					<td align="right"><?php if ($satubulan != 0) {
															echo uang($satubulan);
														} ?></td>

					<td align="right"><?php if ($duabulan != 0) {
															echo uang($duabulan);
														} ?></td>
					<td align="right"><?php if ($lebihtigabulan != 0) {
															echo uang($lebihtigabulan);
														} ?></td>
					<td align="right"><?php if ($enambulan != 0) {
															echo uang($enambulan);
														} ?></td>
					<td align="right"><?php if ($duabelasbulan != 0) {
															echo uang($duabelasbulan);
														} ?></td>
					<td align="right"><?php if ($duatahun != 0) {
															echo uang($duatahun);
														} ?></td>
					<td align="right"><?php if ($lebihduatahun != 0) {
															echo uang($lebihduatahun);
														} ?></td>
					<td align="right"><?php echo uang($total); ?></td>

				</tr>
		<?php



				$totalpiutang 		= 0;
				$totalbayar 			= 0;
				$totalsisabayar 	= 0;

				$duaminggu				= 0;
				$satubulan 				= 0;
				$satusetengahbulan = 0;
				$duabulan 				= 0;
				$lebihtigabulan 	= 0;
				$enambulan 				= 0;
				$duabelasbulan 		= 0;
				$duatahun         = 0;
				$lebihduatahun 		= 0;
				$total 						= 0;
			}

			$no++;
		}

		$totalall 	= $totalallduaminggu + $totalallsatubulan  + $totalallduabulan + $totalalllebih3bulan + $totalallenambulan +
			$totalallduabelasbulan + $totalallduatahun + $totalalllebihduatahun;
		?>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td colspan="5"><b>TOTAL</b></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/duaminggu"; ?>" target="_blank"><?php echo number_format($totalallduaminggu, '0', '', '.');  ?></a></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/satubulan"; ?>" target="_blank"><?php echo number_format($totalallsatubulan, '0', '', '.');  ?></a></td>

			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/duabulan"; ?>" target="_blank"><?php echo number_format($totalallduabulan, '0', '', '.');  ?></a></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/tigabulan"; ?>" target="_blank"><?php echo number_format($totalalllebih3bulan, '0', '', '.');  ?></a></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/enambulan"; ?>" target="_blank"><?php echo number_format($totalallenambulan, '0', '', '.');  ?></a></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/duabelasbulan"; ?>" target="_blank"><?php echo number_format($totalallduabelasbulan, '0', '', '.');  ?></a></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/duatahun"; ?>" target="_blank"><?php echo number_format($totalallduatahun, '0', '', '.');  ?></a></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/lebihduatahun"; ?>" target="_blank"><?php echo number_format($totalalllebihduatahun, '0', '', '.');  ?></a></td>
			<td style="text-align: right"><a href="<?php echo base_url(); ?>laporanpenjualan/cetak_detailaup/<?php echo $cbg . "/" . $sales . "/" . $plg . "/" . $tanggal . "/all"; ?>" target="_blank"><?php echo number_format($totalall, '0', '', '.');  ?></a></td>

		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td colspan="5"><b>PERSENTASE</b></td>
			<td style="text-align: right"><?php echo round($totalallduaminggu / $totalall * 100) . "%";  ?></td>
			<td style="text-align: right"><?php echo round($totalallsatubulan / $totalall * 100) . "%"; ?></td>

			<td style="text-align: right"><?php echo round($totalallduabulan / $totalall * 100) . "%";  ?></td>
			<td style="text-align: right"><?php echo round($totalalllebih3bulan / $totalall * 100) . "%";   ?></td>
			<td style="text-align: right"><?php echo round($totalallenambulan / $totalall * 100) . "%";   ?></td>
			<td style="text-align: right"><?php echo round($totalallduabelasbulan / $totalall * 100) . "%";   ?></td>
			<td style="text-align: right"><?php echo round($totalallduatahun / $totalall * 100) . "%";   ?></td>
			<td style="text-align: right"><?php echo round($totalalllebihduatahun / $totalall * 100) . "%";   ?></td>
			<td style="text-align: right"></td>
		</tr>
	</tbody>
</table>