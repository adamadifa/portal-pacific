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
	REKAPITULASI PENJUALAN<br>
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
			<td rowspan="2">Nama Sales</td>
			<td colspan="10">Produk</td>
			<td rowspan="2" bgcolor="#f5ae15" >Penjualan Bruto</td>
			<td rowspan="2" bgcolor="#f5ae15" >Retur</td>
			<td rowspan="2" bgcolor="#f5ae15" >Potongan</td>
			<td rowspan="2" bgcolor="#f5ae15" >Potongan Istimewa</td>
			<td rowspan="2" bgcolor="#f5ae15" >Penyesuaian Harga</td>
			<td rowspan="2" bgcolor="#1bbb32" >Netto</td>
			<td rowspan="2" bgcolor="#1bbb32" >Penerimaan Uang</td>
			<td rowspan="2" bgcolor="#1bbb32" >Saldo Awal Piutang</td>
			<td rowspan="2" bgcolor="#1bbb32" >Saldo Akhir Piutang</td>
		</tr>
		<tr  bgcolor="#024a75" style="color:white; font-size:12;">
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
			$totalAB 					= 0;
			$totalAR 					= 0;
			$totalASE 				= 0;
			$totalBB 					= 0;
			$totalCG 					= 0;
			$totalCGG 				= 0;
			$totalDB 					= 0;
			$totalDEP 				= 0;
			$totalDK 					= 0;
			$totalDS 					= 0;
			$subtotalbruto 		= 0;
			$totalpotongan 		= 0;
			$totalpotistimewa	= 0;
			$totalpenyharga 	= 0;
			$totalnetto 			= 0;
			$totalbayar				= 0;
			$totalsapiutang 	= 0;
			$totalslpiutang 	= 0;

			$grandtotalAB 					= 0;
			$grandtotalAR 					= 0;
			$grandtotalASE 					= 0;
			$grandtotalBB 					= 0;
			$grandtotalCG 					= 0;
			$grandtotalCGG 					= 0;
			$grandtotalDB 					= 0;
			$grandtotalDEP 					= 0;
			$grandtotalDK 					= 0;
			$grandtotalDS 					= 0;
			$grandsubtotalbruto 		= 0;
			$grandtotalpotongan 		= 0;
			$grandtotalpotistimewa	= 0;
			$grandtotalpenyharga 		= 0;
			$grandtotalnetto 				= 0;
			$grndtotalsapiutang 		= 0;
			$grandtotalslpiutang 		= 0;
			foreach ($rekap as $key => $p){

			$rek  = @$rekap[$key+1]->kode_cabang;

			$totalAB 								= $totalAB + $p->AB;
			$totalAR 								= $totalAR + $p->AR;
			$totalASE 							= $totalASE + $p->ASE;
			$totalBB 								= $totalBB + $p->BB;
			$totalCG 								= $totalCG + $p->CG;
			$totalCGG								= $totalCGG + $p->CGG;
			$totalDB 								= $totalDB + $p->DB;
			$totalDEP 							= $totalDEP + $p->DEP;
			$totalDK 								= $totalDK + $p->DK;
			$totalDS 								= $totalDS + $p->DS;
			$subtotalbruto					= $subtotalbruto + $p->totalbruto;
			$totalpotongan  				= $totalpotongan + $p->totalpotongan;
			$totalretur 						= $totalretur + $p->totalretur;
			$totalpotistimewa 			= $totalpotistimewa + $p->totalpotistimewa;
			$totalpenyharga 				= $totalpenyharga + $p->totalpenyharga;
			$netto 									= $p->totalbruto - $p->totalpotongan - $p->totalretur - $p->totalpotistimewa - $p->totalpenyharga;
			$totalnetto  						= $totalnetto + $p->totalbruto - $p->totalpotongan - $p->totalretur - $p->totalpotistimewa - $p->totalpenyharga;
			$totalbayar 						= $totalbayar + $p->totalbayar;
			$totalsapiutang 				= $totalsapiutang + $p->saldoawalpiutang;
			$totalslpiutang 				= $totalslpiutang + $p->saldoakhirpiutang;
			$grandtotalAB 					= $grandtotalAB + $p->AB;
			$grandtotalAR 					= $grandtotalAR + $p->AR;
			$grandtotalASE 					= $grandtotalASE + $p->ASE;
			$grandtotalBB 					= $grandtotalBB + $p->BB;
			$grandtotalCG 					= $grandtotalCG + $p->CG;
			$grandtotalCGG					= $grandtotalCGG + $p->CGG;
			$grandtotalDB 					= $grandtotalDB + $p->DB;
			$grandtotalDEP 					= $grandtotalDEP + $p->DEP;
			$grandtotalDK 					= $grandtotalDK + $p->DK;
			$grandtotalDS 					= $grandtotalDS + $p->DS;
			$grandsubtotalbruto			= $grandsubtotalbruto + $p->totalbruto;
			$grandtotalpotongan  		= $grandtotalpotongan + $p->totalpotongan;
			$grandtotalretur 				= $grandtotalretur + $p->totalretur;
			$grandtotalpotistimewa 	= $grandtotalpotistimewa + $p->totalpotistimewa;
			$grandtotalpenyharga 		= $grandtotalpenyharga + $p->totalpenyharga;
			$grandtotalnetto  			= $grandtotalnetto + $p->totalbruto - $p->totalpotongan - $p->totalretur - $p->totalpotistimewa - $p->totalpenyharga;
			$grandtotalsapiutang 		= $grandtotalsapiutang + $p->saldoawalpiutang;
			$grandtotalslpiutang 		= $grandtotalslpiutang + $p->saldoakhirpiutang;
			$grandtotalbayar 				= $grandtotalbayar + $p->totalbayar;
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $p->nama_karyawan; ?></td>
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
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->totalbruto)){echo uang($p->totalbruto);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->totalretur)){echo uang($p->totalretur);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->totalpotongan)){echo uang($p->totalpotongan);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->totalpotistimewa)){echo uang($p->totalpotistimewa);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->totalpenyharga)){echo uang($p->totalpenyharga);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($netto)){echo uang($netto);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->totalbayar)){echo uang($p->totalbayar);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->saldoawalpiutang)){echo uang($p->saldoawalpiutang);} ?></td>
				<td style="text-align:right; font-weight:bold"><?php if (!empty($p->saldoakhirpiutang)){echo uang($p->saldoakhirpiutang);} ?></td>

			</tr>


		<?php
			 if ($rek != $p->kode_cabang) {
				echo '
				<tr bgcolor="#024a75" style="color:white; font-weight:bold">
					<td colspan="2" >TOTAL '. $p->kode_cabang.'</td>
					<td align="right" >'. uang($totalAB).'</td>
					<td align="right" >'. uang($totalAR).'</td>
					<td align="right" >'. uang($totalASE).'</td>
					<td align="right" >'. uang($totalBB).'</td>
					<td align="right" >'. uang($totalCG).'</td>
					<td align="right" >'. uang($totalCGG).'</td>
					<td align="right" >'. uang($totalDB).'</td>
					<td align="right" >'. uang($totalDEP).'</td>
					<td align="right" >'. uang($totalDK).'</td>
					<td align="right" >'. uang($totalDS).'</td>
					<td align="right" >'. uang($subtotalbruto).'</td>
					<td align="right" >'. uang($totalretur).'</td>
					<td align="right" >'. uang($totalpotongan).'</td>
					<td align="right" >'. uang($totalpotistimewa).'</td>
					<td align="right" >'. uang($totalpenyharga).'</td>
					<td align="right" >'. uang($totalnetto).'</td>
					<td align="right" >'. uang($totalbayar).'</td>
					<td align="right" >'. uang($totalsapiutang).'</td>
					<td align="right" >'. uang($totalslpiutang).'</td>
				</tr>';
				$totalAB 						= 0;
				$totalAR 						= 0;
				$totalASE 					= 0;
				$totalBB 						= 0;
				$totalCG 						= 0;
				$totalCGG 					= 0;
				$totalDB 						= 0;
				$totalDEP 					= 0;
				$totalDK 						= 0;
				$totalDS 						= 0;
				$subtotalbruto 			= 0;
				$totalretur 				= 0;
				$totalpotongan 			= 0;
				$totalpotistimewa 	= 0;
				$totalpenyharga 		= 0;
				$totalnetto 				= 0;
				$totalbayar 				= 0;
				$totalsapiutang			= 0;
				$totalslpiutang 		= 0;
			}
			$rek  = $p->kode_cabang;
			$no++;
		 } ?>
	</tbody>
	<tfoot>
		<?php
			echo '
				<tr bgcolor="#024a75" style="color:white; font-weight:bold">
					<td colspan="2" >TOTAL </td>
					<td align="right" >'. uang($grandtotalAB).'</td>
					<td align="right" >'. uang($grandtotalAR).'</td>
					<td align="right" >'. uang($grandtotalASE).'</td>
					<td align="right" >'. uang($grandtotalBB).'</td>
					<td align="right" >'. uang($grandtotalCG).'</td>
					<td align="right" >'. uang($grandtotalCGG).'</td>
					<td align="right" >'. uang($grandtotalDB).'</td>
					<td align="right" >'. uang($grandtotalDEP).'</td>
					<td align="right" >'. uang($grandtotalDK).'</td>
					<td align="right" >'. uang($grandtotalDS).'</td>
					<td align="right" >'. uang($grandsubtotalbruto).'</td>
					<td align="right" >'. uang($grandtotalretur).'</td>
					<td align="right" >'. uang($grandtotalpotongan).'</td>
					<td align="right" >'. uang($grandtotalpotistimewa).'</td>
					<td align="right" >'. uang($grandtotalpenyharga).'</td>
					<td align="right" >'. uang($grandtotalnetto).'</td>
					<td align="right" >'. uang($grandtotalbayar).'</td>
					<td align="right" >'. uang($grandtotalsapiutang).'</td>
					<td align="right" >'. uang($grandtotalslpiutang).'</td>
				</tr>';
		?>
	</tfoot>
</table>

<br>
<table class="datatable3" style="border:0px;">

		<?php
			$totalcabnetto 		= 0;
			$totalallcabnetto 	= 0;
			foreach ($rekap as $key => $r){
				$cab  = @$rekap[$key+1]->kode_cabang;
				$totalcabnetto 		= $totalcabnetto + $r->totalbruto - $r->totalpotongan - $r->totalretur - $r->totalpotistimewa - $r->totalpenyharga;
				$totalallcabnetto 	= $totalallcabnetto + $r->totalbruto - $r->totalpotongan - $r->totalretur - $r->totalpotistimewa - $r->totalpenyharga;;
				if ($cab != $r->kode_cabang) {
					echo '
					<tr bgcolor="#024a75" style="color:white; font-weight:bold; border:0px">
						<td colspan="2" style="width:200px;border:0px">'. $r->kode_cabang.'</td>
						<td align="right" style="border:0px">'. uang($totalcabnetto).'</td>
					</tr>
					';
					$totalcabnetto = 0;
				}
				$cab  = $r->kode_cabang;
			}
		?>
		<tr bgcolor="#024a75" style="color:white; font-weight:bold">
			<td style="border:0px"></td>
			<td style="border:0px">TOTAL</td>
			<td align="right" style="border:0px; border-top:1px">
				<u><?php echo uang($totalallcabnetto); ?></u>
			</td>
		</tr>
</table>

<br>
<br>

<table class="datatable3">
	<thead>
		<th bgcolor="#719ef4" colspan="4">I. JURNAL PENJUALAN PUSAT DAN CABANG </th>
	</thead>
	<tbody>
		<tr>
			<td colspan="2" style="border:0px">PIUTANG DAGANG</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalnetto); ?></b></td>
			<td style="border:0px"></td>
		</tr>
		<tr>
			<td colspan="2"  style="border:0px">POTONGAN HARGA</td>
			<td   style="border:0px" align="right"><b><?php echo uang($grandtotalpotistimewa+$grandtotalpotongan); ?></b></td>
			<td style="border:0px"></td>
		</tr>
		<tr>
			<td colspan="2"  style="border:0px">RETUR PENJUALAN</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalretur); ?></b></td>
			<td style="border:0px"></td>
		</tr>
		<tr>
			<td colspan="2"  style="border:0px">PENYESUAIAN HARGA</td>
			<td  style="border:0px" align="right"><b><?php echo uang($grandtotalpenyharga); ?></b></td>
			<td  style="border:0px"></td>
		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td  colspan="2"  style="border:0px">PENJUALAN SAOS BAWANG BALL</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalBB); ?></b></td>
		</tr>
		<tr>
			<td style="border:0px"></td>
			<td style="border:0px" colspan="2"  style="border:0px">PENJUALAN SAOS BAWANG DUS</td>
			<td style="border:0px" align="right"><b>-</b></td>
		</tr>
		<tr>
			<td style="border:0px"></td>
			<td  style="border:0px" colspan="2"  style="border:0px">PENJUALAN SAOS BAWANG EXTRA PEDAS</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalDEP); ?></b></td>

		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td colspan="2"  style="border:0px">PENJUALAN SAOS BAWANG STICK</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalDS); ?></b></td>

		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td colspan="2"  style="border:0px">PENJUALAN SAOS BAWANG SACHET</td>
			<td style="border:0px" align="right"><b>-</b></td>
		</tr>
		<tr>
			<td style="border:0px"></td>
			<td colspan="2" style="border:0px">PENJUALAN SAOS TOMAT DUS</td>
			<td style="border:0px" align="right"><b>-</b></td>
		</tr>

		<tr>
			<td  style="border:0px"></td>
			<td colspan="2"  style="border:0px">PENJUALAN AIDA RENTENG</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalAR); ?></b></td>
		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td colspan="2"  style="border:0px">PENJUALAN AIDA BESAR 500 GR</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalAB); ?></b></td>
		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td colspan="2" style="border:0px">PENJUALAN AIDA 250 GR</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalASE); ?></b></td>
		</tr>
		<tr>
			<td style="border:0px"></td>
			<td colspan="2"  style="border:0px">PENJUALAN CABE GILING MURAH</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalCG + $grandtotalCGG); ?></b></td>
		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td colspan="2"  style="border:0px">PENJUALAN KECAP DUS</td>
			<td style="border:0px" align="right"><b><?php echo uang($grandtotalDK); ?></b></td>
		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td colspan="2"  style="border:0px">PENJUALAN KECAP BOTOL</td>
			<td style="border:0px" align="right"><b>-</b></td>
		</tr>
		<tr>
			<td  style="border:0px"></td>
			<td colspan="2"  style="border:0px"></td>
			<td style="border:0px" align="right"><b><?php echo uang($grandsubtotalbruto); ?></b></td>
		</tr>
	</tbody>
</table>
<br>
<table class="datatable3">
	<thead>
		<th bgcolor="#719ef4" colspan="4">II. JURNAL PENERIMAAN UANG DI CABANG</th>
	</thead>
	<tbody>
		<tr>
			<td colspan="4" style="border:0px"><b>BANDUNG</b></td>
		</tr>
		<tr>
			<td colspan="2" style="border:0px">PIUTANG BANDUNG</td>
		</tr>
	</tbody>
</table>
<?php  } ?>
