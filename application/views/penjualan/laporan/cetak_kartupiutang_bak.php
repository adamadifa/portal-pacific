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
	KARTU PIUTANG<br>
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

		$b 		= explode("-", $dari);
		$bulan	= $b[1];


	?>

</b>
<br>
<br>
<table class="datatable3" style="width:160%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td>No</td>
			<td>Tanggal</td>
			<td>No Faktur</td>
			<td>Kode Pel.</td>
			<td>Nama Pelanggan</td>
			<td>Nama Sales</td>
			<td>Cabang</td>
			<td>Pasar/Daerah</td>
			<td>Hari</td>
			<td>Jatuh Tempo</td>
			<th>Saldo Awal</th>
			<th>Penjualan Bruto</th>
			<th>Pembelian Botol/Peti</th>
			<th>Penyesuaian Harga</th>
			<th>Potongan Harga</th>
			<th>Potongan Istimewa</th>
			<th>Retur Penjualan</th>
			<th>Penjualan Netto</th>
			<th>Pembayaran</th>
			<th>Saldo Akhir</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			$totalsaldoawal 	= 0;
			$totalbruto			= 0;
			$totalpeny 			= 0;
			$totalpot 			= 0;
			$totalpotis 		= 0;
			$totalretur 		= 0;
			$netto 				= 0;
			$totalpmb 			= 0;
			$totalsaldoakkhir	= 0;

			foreach ($kartupiutang as $k ){ 


				if($k->totalpiutang != $k->bayarsebelumbulanini OR !empty($k->bayarbulanini)){


					if(empty($k->bayarsebelumbulanini)){
						if($dari > $k->tgltransaksi){
							$saldoawal = $k->totalpiutang - $k->bayarsebelumbulanini;
						}else{	
							$saldoawal = 0;
						}
					}else{
						$saldoawal = $k->totalpiutang - $k->bayarsebelumbulanini;
					}

					if($k->piutangbulanini < 0){
						$piutangbulanini = 0;
					}else{
						$piutangbulanini =$k->piutangbulanini;
					}
					$saldoakhir = $saldoawal + $piutangbulanini- $k->bayarbulanini;

					$totalsaldoawal 	= $totalsaldoawal + $saldoawal;
					$totalbruto 		= $totalbruto + $k->subtotal;
					$totalpeny 			= $totalpeny + $k->penyharga;
					$totalpot			= $totalpot + $k->potongan;
					$totalpotis			= $totalpotis + $k->potistimewa;
					$totalretur 		= $totalretur + $k->totalretur;
					$netto 				= $netto + $piutangbulanini;
					$totalpmb 			= $totalpmb + $k->bayarbulanini;
					$totalsaldoakkhir	= $totalsaldoakkhir + $saldoakhir;
		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo DateToIndo2($k->tgltransaksi); ?></td>
				<td><?php echo $k->no_fak_penj;?></td>
				<td><?php echo $k->kode_pelanggan;?></td>
				<td><?php echo $k->nama_pelanggan;?></td>
				<td><?php echo $k->nama_karyawan;?></td>
				<td><?php echo $k->kode_cabang;?></td>
				<td><?php echo $k->pasar;?></td>
				<td><?php echo $k->hari;?></td>
				<td>
					<?php if($k->jatuhtempo != "0000-00-00"){echo DateToIndo2($k->jatuhtempo);} ?>

					
				</td>
				<td style="text-align:right"><?php echo number_format($saldoawal,'0','','.'); ?></td>
				<td style="text-align:right"><?php echo number_format($k->subtotal,'0','','.'); ?></td>
				<td></td>
				<td style="text-align:right"><?php echo number_format($k->penyharga,'0','','.'); ?></td>
				<td style="text-align:right"><?php echo number_format($k->potongan,'0','','.'); ?></td>
				<td style="text-align:right"><?php echo number_format($k->potistimewa,'0','','.'); ?></td>
				<td style="text-align:right"><?php echo number_format($k->totalretur,'0','','.'); ?></td>
				<td style="text-align:right"><?php echo number_format($piutangbulanini,'0','','.'); ?></td>
				<td style="text-align:right"><?php echo number_format($k->bayarbulanini,'0','','.'); ?></td>
				<td style="text-align:right"><?php echo number_format($saldoakhir,'0','','.'); ?></td>

				
			</tr>
		<?php
			}
			$no++;
			
			}
		?>
	</tbody>
	<tr bgcolor="#024a75" style="color:white; font-size:12;">
		<td colspan="10">TOTAL</td>
		<td style="text-align:right"><?php echo number_format($totalsaldoawal,'0','','.'); ?></td>
		<td style="text-align:right"><?php echo number_format($totalbruto,'0','','.'); ?></td>
		
		<td></td>
		<td style="text-align:right"><?php echo number_format($totalpeny,'0','','.'); ?></td>
		<td style="text-align:right"><?php echo number_format($totalpot,'0','','.'); ?></td>
		<td style="text-align:right"><?php echo number_format($totalpotis,'0','','.'); ?></td>
		<td style="text-align:right"><?php echo number_format($totalretur,'0','','.'); ?></td>
		<td style="text-align:right"><?php echo number_format($netto,'0','','.'); ?></td>
		<td style="text-align:right"><?php echo number_format($totalpmb,'0','','.'); ?></td>
		<td style="text-align:right"><?php echo number_format($totalsaldoakkhir,'0','','.'); ?></td>
	</tr>
</table>
<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>