<?php

	function uang($nilai){

		return number_format($nilai,'0','','.');
	}

	function persentase($nilai){

		return number_format($nilai,'2',',','.');
	}
	error_reporting(0);

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

		$namabulan   = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	?>
	<br>
	LAPORAN DATA PERTUMBUHAN PRODUK<br>



</b>
<br>
<br>
<table class="datatable3" style="width:90%" >
	<thead bgcolor="#295ea9" style="color:white; font-size:12;">
		<tr>
			<td rowspan="3">Kode Barang</td>
			<td rowspan="3">Nama Barang</td>
			<td rowspan="3" align="center">Target Tahun <?php echo $tahun; ?></td>
			<td  colspan="5" align="center">Bulan <?php echo $namabulan[$bulan]; ?></td>
			<td  colspan="5" align="center">Sampai DenganBulan <?php echo $namabulan[$bulan]; ?></td>
			<td rowspan="3">Sisa Target</td>
		</tr>
		<tr>
			<td rowspan="2" align="center">Target</td>
			<td colspan="2" align="center">Realisasi</td>
			<td align="center" rowspan="2">Ach %</td>
			<td align="center" rowspan="2">Grw %</td>
			<td rowspan="2" align="center">Target</td>
			<td colspan="2" align="center">Realisasi</td>
			<td align="center" rowspan="2">Ach %</td>
			<td align="center" rowspan="2">Grw %</td>
		</tr>
		<tr>
			<td align="center">Tahun <?php echo $tahun; ?></td>
			<td align="center">Tahun <?php echo $tahun-1; ?></td>
			<td align="center">Tahun <?php echo $tahun; ?></td>
			<td align="center">Tahun <?php echo $tahun-1; ?></td>

		</tr>

	</thead>
	<tbody>
		<?php foreach($dppp as $d){

				$achbulanini 	= (($d->realisasibulanberjalan/$d->isipcsdus) / $d->target_bulan) * 100;
				$achsampaibulan	= (($d->realisasisampaibulanberjalan/$d->isipcsdus)/$d->target_sampaibulan) * 100;
				if($tahun <= 2019){
					$grwbulanini 	= ((($d->realisasibulanberjalan/$d->isipcsdus)/($d->realisasimanual/$d->isipcsdus))-1)*100;
				}else{
					$grwbulanini 	= ((($d->realisasibulanberjalan/$d->isipcsdus)/($d->realisasibulanberjalanlast/$d->isipcsdus))-1)*100;
				}

				if($tahun <= 2019){
					$grwsampaibulanini 	= ((($d->realisasisampaibulanberjalan/$d->isipcsdus)/($d->realisasimanualsampaibulanini/$d->isipcsdus))-1)*100;
				}else{
					$grwsampaibulanini 	= ((($d->realisasisampaibulanberjalan/$d->isipcsdus)/($d->realisasisampaibulanberjalanlast/$d->isipcsdus))-1)*100;
				}

			?>
			<tr style="font-size:14px; font-weight:bold">
				<td><?php echo $d->kode_produk; ?></td>
				<td><?php echo $d->nama_barang; ?></td>
				<td align="right"><?php if(!empty($d->target_tahun)){echo uang($d->target_tahun);} ?></td>
				<td align="right"><?php if(!empty($d->target_bulan)){echo uang($d->target_bulan);} ?></td>
				<td align="right"><?php if(!empty($d->realisasibulanberjalan/$d->isipcsdus)){echo persentase($d->realisasibulanberjalan/$d->isipcsdus);} ?></td>
				<td align="right">
					<?php
						if($tahun <= 2019){
							if(!empty($d->realisasimanual/$d->isipcsdus)){echo persentase($d->realisasimanual/$d->isipcsdus);}
						}else{
							if(!empty($d->realisasibulanberjalanlast/$d->isipcsdus)){echo persentase($d->realisasibulanberjalanlast/$d->isipcsdus);}
						}

					?>
				</td>
				<td align="right"><?php if(!empty($achbulanini)){echo persentase($achbulanini);} ?> %</td>
				<td align="right"><?php if(!empty($grwbulanini)){echo persentase($grwbulanini);} ?> %</td>
				<td align="right"><?php if(!empty($d->target_sampaibulan)){echo uang($d->target_sampaibulan);} ?></td>
				<td align="right"><?php if(!empty($d->realisasisampaibulanberjalan/$d->isipcsdus)){echo persentase($d->realisasisampaibulanberjalan/$d->isipcsdus);} ?></td>
				<td align="right">
					<?php
					if($tahun <= 2019){
						if(!empty($d->realisasimanualsampaibulanini/$d->isipcsdus)){echo persentase($d->realisasimanualsampaibulanini/$d->isipcsdus);}
					}else{
						if(!empty($d->realisasisampaibulanberjalanlast/$d->isipcsdus)){echo persentase($d->realisasisampaibulanberjalanlast/$d->isipcsdus);}
					}

					?>
				</td>
				<td align="right"><?php if(!empty($achsampaibulan)){echo persentase($achsampaibulan);} ?> %</td>
				<td align="right"><?php if(!empty($grwsampaibulanini)){echo persentase($grwsampaibulanini);} ?> %</td>
				<td></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
