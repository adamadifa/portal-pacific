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
  ANALISA UMUR HUTANG <br>
  SAMPAI DENGAN <?php echo DateToIndo2($sampai); ?><br>
</b>
<br>
<br>
<table class="datatable3" style="width:100%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
      <td rowspan="2">NO</td>
      <td rowspan="2">KODE SUPPLIER</td>
      <td rowspan="2">NAMA SUPPLIER</td>
      <td colspan="4">SALDO HUTANG</td>
			<td rowspan="2">TOTAL</td>
    </tr>
		<tr style="text-align:center">
			<td>BULAN BERJALAN</td>
			<td>1 BULAN</td>
			<td>2 BULAN</td>
			<td>LEBIH 3 BULAN</td>
		</tr>
  </thead>
  <tbody>
		<?php
			$no = 1;
			$totalallbulanberjalan  = 0;
			$totalallsatubulan			= 0;
			$totalallduabulan				=	0;
			$totalalllebih3bulan		= 0;
			$bulanberjalan 					= 0;
			$satubulan 							= 0;
			$duabulan 							= 0;
			$lebihtigabulan 				= 0;
			$total 									= 0;
			$supplier 							= "";
			foreach($pmb as $key => $d){
				$supp = @$pmb[$key+1]->kode_supplier;
				$bulanberjalan 	+= $d->bulanberjalan;
				$satubulan 			+= $d->satubulan;
				$duabulan 			+= $d->duabulan;
				$lebihtigabulan	+= $d->lebihtigabulan;
				$total 					= $bulanberjalan + $satubulan + $duabulan + $lebihtigabulan;
				if ($supp != $d->kode_supplier) {
 			 	$totalallbulanberjalan = $totalallbulanberjalan + $bulanberjalan;
 			 	$totalallsatubulan 	   = $totalallsatubulan + $satubulan;
 			 	$totalallduabulan 	   = $totalallduabulan + $duabulan;
 			 	$totalalllebih3bulan   = $totalalllebih3bulan + $lebihtigabulan
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $d->kode_supplier; ?></td>
			<td><?php echo $d->nama_supplier; ?></td>
			<td align="right"><?php if($bulanberjalan !=0){echo uang($bulanberjalan);} ?></td>
			<td align="right"><?php if($satubulan !=0){echo uang($satubulan);} ?></td>
			<td align="right"><?php if($duabulan !=0){echo uang($duabulan);} ?></td>
			<td align="right"><?php if($lebihtigabulan !=0){echo uang($lebihtigabulan);} ?></td>
			<td align="right"><?php echo uang($total); ?></td>
		</tr>
		<?php
				$bulanberjalan		= 0;
				$satubulan 				= 0;
				$duabulan 				= 0;
				$lebihtigabulan 	= 0;
				$total 						= 0;
			}
			$no++;
		}
		$totalall = $totalallbulanberjalan + $totalallsatubulan + $totalallduabulan + $totalalllebih3bulan;
		?>
	</tbody>
	<tr  bgcolor="#024a75" style="color:white; font-size:12;">
		<td colspan="3"><b>TOTAL</b></td>
		<td style="text-align: right"><a href="<?php echo base_url(); ?>/laporanpembelian/cetak_detailaup/<?php echo $cbg."/".$sales."/".$plg."/".$tanggal."/bulanberjalan"; ?>" target="_blank"><?php echo number_format($totalallbulanberjalan,'0','','.');  ?></a></td>
		<td style="text-align: right"><a href="<?php echo base_url(); ?>/laporanpembelianlaporanpembelian/cetak_detailaup/<?php echo $cbg."/".$sales."/".$plg."/".$tanggal."/satubulan"; ?>" target="_blank"><?php echo number_format($totalallsatubulan,'0','','.');  ?></a></td>
		<td style="text-align: right"><a href="<?php echo base_url(); ?>/laporanpembelian/cetak_detailaup/<?php echo $cbg."/".$sales."/".$plg."/".$tanggal."/duabulan"; ?>" target="_blank"><?php echo number_format($totalallduabulan,'0','','.');  ?></a></td>
		<td style="text-align: right"><a href="<?php echo base_url(); ?>/laporanpembelian/cetak_detailaup/<?php echo $cbg."/".$sales."/".$plg."/".$tanggal."/lebihtigabulan"; ?>" target="_blank"><?php echo number_format($totalalllebih3bulan,'0','','.');  ?></a></td>
		<td style="text-align: right"><?php echo number_format($totalall,'0','','.');  ?></td>
	</tr>
	<tr  bgcolor="#024a75" style="color:white; font-size:12;">
		<td colspan="3"><b>PERSENTASE</b></td>
		<td style="text-align: right"><?php echo round($totalallbulanberjalan/$totalall*100)."%";  ?></td>
		<td style="text-align: right"><?php echo round($totalallsatubulan/$totalall*100)."%"; ?></td>
		<td style="text-align: right"><?php echo round($totalallduabulan/$totalall*100)."%";  ?></td>
		<td style="text-align: right"><?php echo round($totalalllebih3bulan/$totalall*100)."%";   ?></td>
		<td style="text-align: right"></td>
	</tr>
</table>

<br>
