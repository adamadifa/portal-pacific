<?php

	function uang($nilai){

		return number_format($nilai,'0','','.');
	}

	if(!empty($sales)){

		$sales = "AND penjualan.id_karyawan = '$sales'";
	}else{

		$sales ="";
	}

	if(!empty($cabang)){

		$cabang = "AND karyawan.kode_cabang = '$cabang'";
	}else{

		$cabang ="";
	}

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
	LAPORAN PENJUALAN TUNAI KREDIT<br>
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

<table class="datatable3">
	<thead bgcolor="#295ea9" style="color:white; font-size:12;">
		<tr bgcolor="#295ea9" style="color:white; font-size:12;">
			<td rowspan="3" align="center">Kode Barang</td>
			<td rowspan="3" align="center">Nama Barang</td>
			<td colspan="4" align="center">Penjualan Tunai</td>
			<td colspan="4" align="center">Penjualan Kredit</td>
			<td colspan="4">Total Penjualan Tunai Kredit</td>

		</tr>
		<tr bgcolor="#295ea9" style="color:white; font-size:12;">
			<td colspan="3" align="center">Qty</td>
			<td rowspan="2" align="center">Total</td>
			<td colspan="3" align="center">Qty</td>
			<td rowspan="2" align="center">Total</td>
			<td colspan="3" align="center">Total Qty</td>
			<td rowspan="2" align="center">Total Penjualan</td>
		</tr>
		<tr bgcolor="#295ea9" style="color:white; font-size:12;">
			<td align="center">Dus</td>
			<td align="center">Pack</td>
			<td align="center">Pcs</td>
			<td align="center">Dus</td>
			<td align="center">Pack</td>
			<td align="center">Pcs</td>
			<td align="center">Dus</td>
			<td align="center">Pack</td>
			<td align="center">Pcs</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$totaldust		= 0;
			$totalpackt		= 0;
			$totalpcst		= 0;
			$totalt 		= 0;

			$totaldusk		= 0;
			$totalpackk		= 0;
			$totalpcsk		= 0;
			$totalk 		= 0;

			$totaldusall  	= 0;
			$totalpackall 	= 0;
			$totalpcsall  	= 0;
			$totalall 	  	= 0;


			$qretur = "SELECT
						SUM( IF ( jenistransaksi ='tunai', retur.total, 0 ) ) AS totalretur_tunai,
						SUM( IF ( jenistransaksi ='kredit', retur.total, 0 ) ) AS totalretur_kredit
						FROM retur
						INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
						INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
						WHERE tglretur BETWEEN '$dari' AND '$sampai'"
						.$cabang
						.$sales;
			$retur  = $this->db->query($qretur)->row_array();


			$qpot 	= "SELECT
						SUM( IF ( jenistransaksi ='tunai', penyharga, 0 ) ) AS totpenyharga_tunai,
						SUM( IF ( jenistransaksi ='kredit', penyharga, 0 ) ) AS totpenyharga_kredit,
						SUM( IF ( jenistransaksi ='tunai', potongan, 0 ) ) AS totpotongan_tunai,
						SUM( IF ( jenistransaksi ='kredit', potongan, 0 ) ) AS totpotongan_kredit,
						SUM( IF ( jenistransaksi ='tunai', potistimewa, 0 ) ) AS totpotistimewa_tunai,
						SUM( IF ( jenistransaksi ='kredit', potistimewa, 0 ) ) AS totpotistimewa_kredit
						FROM penjualan
						INNER JOIN karyawan ON penjualan.id_karyawan = karyawan.id_karyawan
						WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
						.$cabang
						.$sales;
			$pot  = $this->db->query($qpot)->row_array();


			foreach ($tunaikredit as $t){

				if($t->jumlah_tunai !=0){
					$jmldust    = floor($t->jumlah_tunai / $t->isipcsdus);
				    $sisadus   = $t->jumlah_tunai % $t->isipcsdus;
				    if($t->isipack == 0){
				        $jmlpackt    = 0;
				        $sisapack   = $sisadus;
				    }else{

				        $jmlpackt    = floor($sisadus / $t->isipcs);
				        $sisapack   = $sisadus % $t->isipcs;
				    }
				    $jmlpcst = $sisapack;
				    $subtotalt = $t->totaljual_tunai;
				}else{

					$jmldust 	= 0;
					$jmlpackt	= 0;
					$jmlpcst 	= 0;
					$subtotalt  = 0;
				}


				if($t->jumlah_kredit !=0){
					$jmldusk    = floor($t->jumlah_kredit  / $t->isipcsdus );
				    $sisadus   = $t->jumlah_kredit % $t->isipcsdus;
				    if($t->isipack == 0){
				        $jmlpackk   = 0;
				        $sisapack   = $sisadus;
				    }else{

				        $jmlpackk   = floor($sisadus / $t->isipcs);
				        $sisapack   = $sisadus % $t->isipcs;
				    }
				    $jmlpcsk = $sisapack;
				    $subtotalk = $t->totaljual_kredit;
				}else{

					$jmldusk 	= 0;
					$jmlpackk	= 0;
					$jmlpcsk 	= 0;
					$subtotalk  = 0;
				}

				if($t->jumlah !=0){
					$jmldusall    = floor($t->jumlah / $t->isipcsdus);
				    $sisadus   	  = $t->jumlah % $t->isipcsdus;
				    if($t->isipack == 0){
				        $jmlpackall    = 0;
				        $sisapack      = $sisadus;
				    }else{

				        $jmlpackall    = floor($sisadus / $t->isipcs);
				        $sisapack   	= $sisadus % $t->isipcs;
				    }
				    $jmlpcsall 	= $sisapack;
				    $subtotalall = $t->totaljual;
				}else{

					$jmldusall 	= 0;
					$jmlpackall	= 0;
					$jmlpcsall 	= 0;
					$subtotalall  = 0;
				}

				$totaldust 			= $totaldust + $jmldust;
				$totalpackt			= $totalpackt + $jmlpackt;
				$totalpcst 			= $totalpcst + $jmlpcst;
				$totalt 			= $totalt + $subtotalt;

				$totaldusk 			= $totaldusk+ $jmldusk;
				$totalpackk			= $totalpackk + $jmlpackk;
				$totalpcsk 			= $totalpcsk + $jmlpcsk;
				$totalk 			= $totalk + $subtotalk;

				$totaldusall  		= $totaldusall + $jmldusall;
				$totalpackall 		= $totalpackall + $jmlpackall;
				$totalpcsall  		= $totalpcsall + $jmlpcsall;
				$totalall 	  			= $totalall + $subtotalall;


				$totalallretur 		 = $retur['totalretur_tunai']+$retur['totalretur_kredit'];
				$totalallpenyharga   = $pot['totpenyharga_tunai']+$pot['totpenyharga_kredit'];
				$totalallpotongan    = $pot['totpotongan_tunai']+$pot['totpotongan_kredit'];
				$totalallpotistimewa = $pot['totpotistimewa_tunai']+$pot['totpotistimewa_kredit'];

				$totalallt 		     = $totalt-$retur['totalretur_tunai'] - $pot['totpenyharga_tunai'] - $pot['totpotongan_tunai'] - $pot['totpotistimewa_tunai'];

				$totalallk 			 = $totalk-$retur['totalretur_kredit'] - $pot['totpenyharga_kredit'] - $pot['totpotongan_kredit'] - $pot['totpotistimewa_kredit'];
		?>
			<tr>
				<td><b><?php echo $t->kode_produk; ?></b></td>
				<td><b><?php echo $t->nama_barang; ?></b></td>
				<td align="center"><?php if($jmldust !=0){ echo uang($jmldust);}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpackt !=0){ echo uang($jmlpackt);}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpcst !=0){ echo uang($jmlpcst);}else{echo "";} ?></td>
				<td align="right"><?php  if($subtotalt !=0){ echo uang($subtotalt);}else{echo "";} ?></td>

				<td align="center"><?php if($jmldusk !=0){ echo uang($jmldusk);}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpackk !=0){ echo uang($jmlpackk);}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpcsk !=0){ echo uang($jmlpcsk);}else{echo "";} ?></td>
				<td align="right"><?php  if($subtotalk !=0){ echo uang($subtotalk);}else{echo "";} ?></td>

				<td align="center"><?php if($jmldusall !=0){ echo uang($jmldusall);}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpackall !=0){ echo uang($jmlpackall);}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpcsall !=0){ echo uang($jmlpcsall);}else{echo "";} ?></td>
				<td align="right"><?php if($subtotalall !=0){ echo uang($subtotalall);}else{echo "";} ?></td>
			</tr>

		<?php } ?>
			<tr bgcolor="#06b947" style="color:white; font-size:12;" >
				<td colspan="2">Penjualan Bruto</td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="right"><?php echo uang($totalt); ?></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="right"><?php echo uang($totalk); ?></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<td align="right"><?php echo uang($totalall); ?></td>
			</tr>
			<tr >
				<td colspan="5"><b>Retur Penjualan</b></td>
				<td align="right"><?php echo uang($retur['totalretur_tunai']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($retur['totalretur_kredit']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallretur); ?></td>
			</tr>
			<tr>
				<td colspan="5">Penyesuaian Harga</td>
				<td align="right"><?php echo uang($pot['totpenyharga_tunai']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($pot['totpenyharga_kredit']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallpenyharga); ?></td>
			</tr>
			<tr>
				<td colspan="5">Potongan Harga</td>
				<td align="right"><?php echo uang($pot['totpotongan_tunai']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($pot['totpotongan_kredit']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallpotongan); ?></td>
			</tr>
			<tr>
				<td colspan="5">Potongan Isitimwa</td>
				<td align="right"><?php echo uang($pot['totpotistimewa_tunai']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($pot['totpotistimewa_kredit']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallpotistimewa); ?></td>
			</tr>
			<tr bgcolor="#06b947" style="color:white; font-size:12;" >
				<td colspan="5">Penjualan Netto</td>
				<td align="right"><?php echo uang($totalallt); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallk); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallt+$totalallk); ?></td>
			</tr>
	</tbody>
</table>
