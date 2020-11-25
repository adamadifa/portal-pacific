<?php
	
	function uang($nilai){

		return number_format($nilai,'0','','.');
	}
	
	 $namabulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	REKAPITULASI REALISASI PERMINTAAN BARANG<br>
	PERIODE <?php echo strtoupper($namabulan[$bulan])." ". $tahun; ?><br><br>
	
</b>
<br>
<table class="datatable3" style="width:150%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th rowspan="3">NO</th>
			<th rowspan="3">JENIS PRODUK</th>
			<th colspan="3">MINGGU 1</th>
			<th colspan="3">MINGGU 2</th>
			<th colspan="3">MINGGU 3</th>
			<th colspan="3">MINGGU 4</th>
			<th rowspan="3">TOTAL <br> PERMINTAAN</th>
			<th rowspan="3">TOTAL <br> HASIL PRODUKSI</th>
			<th rowspan="3">TOTAL <Br> REALISASI</th>
		</tr>
		
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="3" >Tgl : 01 - 07</th>
			<th colspan="3">Tgl : 08 - 14</th>
			<th colspan="3">Tgl : 15 - 21</th>
			<th colspan="3">Tgl : 22 - 31</th>
		</tr>
		<tr style="background-color: #91d7d7; color:black;">
			
			<th style="text-align: center">PERMINTAAN </th>
			<th> HASIL PRODUKSI</th>
			<th> REALISASI</th>
			<th style="text-align: center">PERMINTAAN </th>
			<th> HASIL PRODUKSI</th>
			<th> REALISASI</th>
			<th style="text-align: center">PERMINTAAN </th>
			<th> HASIL PRODUKSI</th>
			<th> REALISASI</th>
			<th style="text-align: center">PERMINTAAN </th>
			<th> HASIL PRODUKSI</th>
			<th> REALISASI</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			$totalpermintaanm1 = 0;
			$totalpermintaanm2 = 0;
			$totalpermintaanm3 = 0;
			$totalpermintaanm4 = 0;

			$totalproduksim1   = 0;
			$totalproduksim2   = 0;
			$totalproduksim3   = 0;
			$totalproduksim4   = 0;

			$totalrealisasim1  = 0;
			$totalrealisasim2  = 0;
			$totalrealisasim3  = 0;
			$totalrealisasim4  = 0;

			$grandtotalpermintaan = 0;
			$grandtotalproduksi   = 0;
			$grandtotalrealisasi  = 0;		
			foreach($rekap as $r){

				$totalpermintaan = $r->pm1 + $r->pm2 + $r->pm3 + $r->pm4;
				$totalproduksi 	 = $r->minggu1 + $r->minggu2 + $r->minggu3 + $r->minggu4;
				$totalrealisasi  = $r->sj1 + $r->sj2 + $r->sj3 + $r->sj4;

				$totalpermintaanm1 = $totalpermintaanm1 + $r->pm1;
				$totalpermintaanm2 = $totalpermintaanm2 + $r->pm2;
				$totalpermintaanm3 = $totalpermintaanm3 + $r->pm3;
				$totalpermintaanm4 = $totalpermintaanm4 + $r->pm4;

				$totalproduksim1   = $totalproduksim1 + $r->minggu1;
				$totalproduksim2   = $totalproduksim2 + $r->minggu2;
				$totalproduksim3   = $totalproduksim3 + $r->minggu3;
				$totalproduksim4   = $totalproduksim4 + $r->minggu4;

				$totalrealisasim1  = $totalrealisasim1 + $r->sj1;
				$totalrealisasim2  = $totalrealisasim2 + $r->sj2;
				$totalrealisasim3  = $totalrealisasim3 + $r->sj3;
				$totalrealisasim4  = $totalrealisasim4 + $r->sj4;

				$grandtotalpermintaan = $grandtotalpermintaan + $totalpermintaan;
				$grandtotalproduksi   = $grandtotalproduksi + $totalproduksi;
				$grandtotalrealisasi  = $grandtotalrealisasi + $totalrealisasi;

		?>
			<tr style="font-size:11px">
				<td><?php echo $no; ?></td>
				<td><?php echo $r->nama_barang; ?></td>
				<td align="right"><?php if($r->pm1 !=0){echo uang($r->pm1); } ?></td>
				<td align="right"><?php if($r->minggu1 !=0){echo uang($r->minggu1); } ?></td>
				<td align="right"><?php if($r->sj1 !=0){echo uang($r->sj1); } ?></td>
				<td align="right"><?php if($r->pm2 !=0){echo uang($r->pm2); } ?></td>
				<td align="right"><?php if($r->minggu2 !=0){echo uang($r->minggu2); } ?></td>
				<td align="right"><?php if($r->sj2 !=0){echo uang($r->sj2); } ?></td>
				<td align="right"><?php if($r->pm3 !=0){echo uang($r->pm3); } ?></td>
				<td align="right"><?php if($r->minggu3 !=0){echo uang($r->minggu3); } ?></td>
				<td align="right"><?php if($r->sj3 !=0){echo uang($r->sj3); } ?></td>
				<td align="right"><?php if($r->pm4 !=0){echo uang($r->pm4); } ?></td>
				<td align="right"><?php if($r->minggu4 !=0){echo uang($r->minggu4); } ?></td>
				<td align="right"><?php if($r->sj4 !=0){echo uang($r->sj4); } ?></td>
				<td align="right"><?php if($totalpermintaan !=0){echo uang($totalpermintaan); } ?></td>
				<td align="right"><?php if($totalproduksi !=0){echo uang($totalproduksi); } ?></td>
				<td align="right"><?php if($totalrealisasi !=0){echo uang($totalrealisasi); } ?></td>


			</tr>		
		<?php 
		$no++;
		}
		?>
	</tbody>
	<tfoot>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="2">TOTAL</th>
			<th style="text-align:right"><?php echo uang($totalpermintaanm1); ?></th>
			<th style="text-align:right"><?php echo uang($totalproduksim1); ?></th>
			<th style="text-align:right"><?php echo uang($totalrealisasim1); ?></th>

			<th style="text-align:right"><?php echo uang($totalpermintaanm2); ?></th>
			<th style="text-align:right"><?php echo uang($totalproduksim2); ?></th>
			<th style="text-align:right"><?php echo uang($totalrealisasim2); ?></th>

			<th style="text-align:right"><?php echo uang($totalpermintaanm3); ?></th>
			<th style="text-align:right"><?php echo uang($totalproduksim3); ?></th>
			<th style="text-align:right"><?php echo uang($totalrealisasim3); ?></th>

			<th style="text-align:right"><?php echo uang($totalpermintaanm4); ?></th>
			<th style="text-align:right"><?php echo uang($totalproduksim4); ?></th>	
			<th style="text-align:right"><?php echo uang($totalrealisasim4); ?></th>


			<th style="text-align:right"><?php echo uang($grandtotalpermintaan); ?></th>
			<th style="text-align:right"><?php echo uang($grandtotalproduksi); ?></th>	
			<th style="text-align:right"><?php echo uang($grandtotalrealisasi); ?></th>
		</tr>
	</tfoot>
</table>

<br>
<table class="datatable3" style="width:150%; margin-top:50px" border="1">
	<thead >
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th rowspan="3">NO</th>
			<th rowspan="3">JENIS PRODUK</th>
			<th colspan="2">MINGGU 1</th>
			<th colspan="2">MINGGU 2</th>
			<th colspan="2">MINGGU 3</th>
			<th colspan="2">MINGGU 4</th>
			<th rowspan="3">TOTAL <br> PERMINTAAN <br> VS <br> REALISASI</th>
			<th rowspan="3">TOTAL <br> PERMINTAAN <br> VS <br> HASIL PRODUKSI</th>
			
		</tr>
		
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="2">Tgl : 01 - 07</th>
			<th colspan="2">Tgl : 08 - 14</th>
			<th colspan="2">Tgl : 15 - 21</th>
			<th colspan="2">Tgl : 22 - 31</th>
		</tr>
		<tr style="background-color: #91d7d7; color:black;">
			
			<th style="text-align: center">PERMINTAAN <br> VS <br> REALISASI </th>
			<th> PERMINTAAN <br> VS <br> HASIL PRODUKSI</th>
			<th style="text-align: center">PERMINTAAN <br> VS <br> REALISASI </th>
			<th> PERMINTAAN <br> VS <br> HASIL PRODUKSI</th>
			<th style="text-align: center">PERMINTAAN <br> VS <br> REALISASI </th>
			<th> PERMINTAAN <br> VS <br> HASIL PRODUKSI</th>
			<th style="text-align: center">PERMINTAAN <br> VS <br> REALISASI </th>
			<th> PERMINTAAN <br> VS <br> HASIL PRODUKSI</th>
			
			
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			$totalpermintaanm1 = 0;
			$totalpermintaanm2 = 0;
			$totalpermintaanm3 = 0;
			$totalpermintaanm4 = 0;

			$totalproduksim1   = 0;
			$totalproduksim2   = 0;
			$totalproduksim3   = 0;
			$totalproduksim4   = 0;

			$totalrealisasim1  = 0;
			$totalrealisasim2  = 0;
			$totalrealisasim3  = 0;
			$totalrealisasim4  = 0;

			$grandtotalpermintaan = 0;
			$grandtotalproduksi   = 0;
			$grandtotalrealisasi  = 0;		
			foreach($rekap as $r){

				$totalpermintaan = $r->pm1 + $r->pm2 + $r->pm3 + $r->pm4;
				$totalproduksi 	 = $r->minggu1 + $r->minggu2 + $r->minggu3 + $r->minggu4;
				$totalrealisasi  = $r->sj1 + $r->sj2 + $r->sj3 + $r->sj4;

				$totalpermintaanm1 = $totalpermintaanm1 + $r->pm1;
				$totalpermintaanm2 = $totalpermintaanm2 + $r->pm2;
				$totalpermintaanm3 = $totalpermintaanm3 + $r->pm3;
				$totalpermintaanm4 = $totalpermintaanm4 + $r->pm4;

				$totalproduksim1   = $totalproduksim1 + $r->minggu1;
				$totalproduksim2   = $totalproduksim2 + $r->minggu2;
				$totalproduksim3   = $totalproduksim3 + $r->minggu3;
				$totalproduksim4   = $totalproduksim4 + $r->minggu4;

				$totalrealisasim1  = $totalrealisasim1 + $r->sj1;
				$totalrealisasim2  = $totalrealisasim2 + $r->sj2;
				$totalrealisasim3  = $totalrealisasim3 + $r->sj3;
				$totalrealisasim4  = $totalrealisasim4 + $r->sj4;

				$grandtotalpermintaan = $grandtotalpermintaan + $totalpermintaan;
				$grandtotalproduksi   = $grandtotalproduksi + $totalproduksi;
				$grandtotalrealisasi  = $grandtotalrealisasi + $totalrealisasi;

				if(!empty($r->pm1)){
					$pmvsrealiasi1 = ($r->sj1 / $r->pm1) * 100; 
				}else{
					$pmvsrealiasi1 = "";
				}

				if(!empty($r->pm2)){
					$pmvsrealiasi2 = ($r->sj2 / $r->pm2) * 100; 
				}else{
					$pmvsrealiasi2 = "";
				}

				if(!empty($r->pm3)){
					$pmvsrealiasi3 = ($r->sj3 / $r->pm3) * 100; 
				}else{
					$pmvsrealiasi3 = "";
				}

				if(!empty($r->pm4)){
					$pmvsrealiasi4 = ($r->sj4 / $r->pm4) * 100; 
				}else{
					$pmvsrealiasi4 = "";
				}


				if(!empty($totalpermintaan)){
					$totalpmvsrealisasi = ($totalrealisasi / $totalpermintaan) * 100; 
				}else{
					$totalpmvsrealisasi = "";
				}

				if(!empty($r->pm1)){
					$pmvsproduksi1 = ($r->minggu1 / $r->pm1) * 100; 
				}else{
					$pmvsproduksi1 = "";
				}

				if(!empty($r->pm2)){
					$pmvsproduksi2 = ($r->minggu2 / $r->pm2) * 100; 
				}else{
					$pmvsproduksi2 = "";
				}

				if(!empty($r->pm3)){
					$pmvsproduksi3 = ($r->minggu3 / $r->pm3) * 100; 
				}else{
					$pmvsproduksi3 = "";
				}

				if(!empty($r->pm4)){
					$pmvsproduksi4 = ($r->minggu4 / $r->pm4) * 100; 
				}else{
					$pmvsproduksi4 = "";
				}

				if(!empty($totalpermintaan)){
					$totalpmvsproduksi = ($totalproduksi / $totalpermintaan) * 100; 
				}else{
					$totalpmvsproduksi = "";
				}
				

 
		?>
			<tr style="font-size:11px">
				<td><?php echo $no; ?></td>
				<td><?php echo $r->nama_barang; ?></td>
				<td align="right"><?php if($pmvsrealiasi1 !=0){echo round($pmvsrealiasi1,2)."%"; } ?></td>
				<td align="right"><?php if($pmvsproduksi1 !=0){echo round($pmvsproduksi1,2)."%"; } ?></td>
				<td align="right"><?php if($pmvsrealiasi2 !=0){echo round($pmvsrealiasi2,2)."%"; } ?></td>
				<td align="right"><?php if($pmvsproduksi2 !=0){echo round($pmvsproduksi2,2)."%"; } ?></td>
				<td align="right"><?php if($pmvsrealiasi3 !=0){echo round($pmvsrealiasi3,2)."%"; } ?></td>
				<td align="right"><?php if($pmvsproduksi3 !=0){echo round($pmvsproduksi3,2)."%"; } ?></td>
				<td align="right"><?php if($pmvsrealiasi4 !=0){echo round($pmvsrealiasi4,2)."%"; } ?></td>
				<td align="right"><?php if($pmvsproduksi4 !=0){echo round($pmvsproduksi4,2)."%"; } ?></td>
				<td align="right"><?php if($totalpmvsrealisasi !=0){echo round($totalpmvsrealisasi,2)."%"; } ?></td>
				<td align="right"><?php if($totalpmvsproduksi !=0){echo round($totalpmvsproduksi,2)."%"; } ?></td>

			</tr>
		<?php 
		$no++;
		}

		if(!empty($totalpermintaanm1)){

			$grandtotalpmvsrealisasi1 = ($totalrealisasim1 / $totalpermintaanm1) * 100;
		}else{
			$grandtotalpmvsrealisasi1 = "";
		}

		if(!empty($totalpermintaanm2)){

			$grandtotalpmvsrealisasi2 = ($totalrealisasim2 / $totalpermintaanm2) * 100;
		}else{
			$grandtotalpmvsrealisasi2 = "";
		}

		if(!empty($totalrealisasim3)){

			$grandtotalpmvsrealisasi3 = ($totalpermintaanm3 / $totalrealisasim3) * 100;
		}else{
			$grandtotalpmvsrealisasi3 = "";
		}

		if(!empty($totalpermintaanm4)){

			$grandtotalpmvsrealisasi4 = ($totalrealisasim4 / $totalrealisasim4) * 100;
		}else{
			$grandtotalpmvsrealisasi4 = "";
		}


		if(!empty($totalpermintaanm1)){

			$grandtotalpmvsproduksi1 = ($totalproduksim1 / $totalpermintaanm1) * 100;
		}else{
			$grandtotalpmvsproduksi1 = "";
		}

		if(!empty($totalpermintaanm2)){

			$grandtotalpmvsproduksi2 = ($totalproduksim2 / $totalpermintaanm2) * 100;
		}else{
			$grandtotalpmvsproduksi2 = "";
		}

		if(!empty($totalpermintaanm3)){

			$grandtotalpmvsproduksi3 = ($totalproduksim3 / $totalpermintaanm3) * 100;
		}else{
			$grandtotalpmvsproduksi3 = "";
		}

		if(!empty($totalpermintaanm4)){

			$grandtotalpmvsproduksi4 = ($totalproduksim4 / $totalpermintaanm4) * 100;
		}else{
			$grandtotalpmvsproduksi4 = "";
		}

		if(!empty($grandtotalrealisasi)){

			$grandtotalallpmvsrealisasi = ($grandtotalpermintaan / $grandtotalrealisasi) * 100;
		}else{
			$grandtotalallpmvsrealisasi = "";
		}

		if(!empty($grandtotalproduksi)){

			$grandtotalallpmvsproduksi = ($grandtotalpermintaan / $grandtotalproduksi) * 100;
		}else{
			$grandtotalallpmvsproduksi = "";
		}

		?>
	</tbody>
	<tfoot>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="2">TOTAL</th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsrealisasi1,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsproduksi1,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsrealisasi2,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsproduksi2,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsrealisasi3,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsproduksi3,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsrealisasi4,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalpmvsproduksi4,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalallpmvsrealisasi,2)."%"; ?></th>
			<th style="text-align:right"><?php echo round($grandtotalallpmvsproduksi,2)."%"; ?></th>
		</tr>
	</tfoot>
	
</table>
