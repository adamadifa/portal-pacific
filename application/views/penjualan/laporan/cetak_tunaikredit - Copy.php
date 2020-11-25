<?php
	
	function uang($nilai){

		return number_format($nilai,'0','','.');
	}

	if(!empty($sales)){

		$qsales = "AND id_karyawan = '$sales'";
	}else{

		$qsales ="";
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
			$totaldust	= 0;
			$totalpackt	= 0;
			$totalpcst	= 0;
			$totalt 	= 0;

			$totaldusk	= 0;
			$totalpackk	= 0;
			$totalpcsk	= 0;
			$totalk 	= 0;

			$totaldusall  = 0;
			$totalpackall = 0;
			$totalpcsall  = 0;
			$totalall 	  = 0;

			$qreturt = "SELECT jenistransaksi,SUM(retur.total) as totalretur FROM retur
						INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
						INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
						WHERE tglretur BETWEEN '$dari' AND '$sampai' AND jenistransaksi='tunai' AND kode_cabang='$cb[kode_cabang]' ".$qsales." 
						GROUP BY jenistransaksi"; 
			$returt  = $this->db->query($qreturt)->row_array();

			$qreturk = "SELECT jenistransaksi,SUM(retur.total) as totalretur FROM retur
						INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
						INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
						WHERE tglretur BETWEEN '$dari' AND '$sampai' AND jenistransaksi='kredit' AND kode_cabang='$cb[kode_cabang]' ".$qsales." 
						GROUP BY jenistransaksi"; 
			$returk  = $this->db->query($qreturk)->row_array();


			$qpott 	 = "SELECT SUM(penyharga) as totpenyharga, SUM(potongan) as totpotongan,
						SUM(potistimewa) as totpotistimewa,SUM(totalpiutang) as totalall
						FROM view_pembayaran WHERE tgltransaksi BETWEEN '$dari' AND '$sampai' AND jenistransaksi ='tunai' AND kode_cabang='$cb[kode_cabang]' ".$qsales." 
						GROUP BY jenistransaksi"; 
			$pott 	 = $this->db->query($qpott)->row_array();


			$qpotk 	 = "SELECT SUM(penyharga) as totpenyharga, SUM(potongan) as totpotongan,
						SUM(potistimewa) as totpotistimewa,SUM(totalpiutang) as totalall
						FROM view_pembayaran WHERE tgltransaksi BETWEEN '$dari' AND '$sampai' AND jenistransaksi ='kredit' AND kode_cabang='$cb[kode_cabang]' ".$qsales." 
						GROUP BY jenistransaksi"; 
			$potk 	 = $this->db->query($qpotk)->row_array();


			foreach ($tunaikredit as $t){
				
				//Tunai
				$qdpt 	= "SELECT detailpenjualan.kode_barang,isipcsdus,isipack,isipcs,jenistransaksi,
						   SUM(detailpenjualan.subtotal) as totaljual,SUM(jumlah) as jumlah 
						   FROM detailpenjualan 
						   INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj   
						   INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang   
						   WHERE detailpenjualan.kode_barang = '$t->kode_barang' AND jenistransaksi='tunai' AND  tgltransaksi  BETWEEN '$dari' AND '$sampai' AND promo !='1' ".$qsales." 
						   GROUP BY detailpenjualan.kode_barang,jenistransaksi";
				$dpt 	= $this->db->query($qdpt)->row_array();

				if($dpt['jumlah'] !=0){
					$jmldust    = floor($dpt['jumlah'] / $dpt['isipcsdus']);
				    $sisadus   = $dpt['jumlah'] % $dpt['isipcsdus'];
				    if($dpt['isipack'] == 0){
				        $jmlpackt    = 0;
				        $sisapack   = $sisadus;   
				    }else{

				        $jmlpackt    = floor($sisadus / $dpt['isipcs']);  
				        $sisapack   = $sisadus % $dpt['isipcs'];  
				    }
				    $jmlpcst = $sisapack;
				    $subtotalt = $dpt['totaljual'];
				}else{

					$jmldust 	= 0;
					$jmlpackt	= 0;
					$jmlpcst 	= 0;
					$subtotalt  = 0;
				}




				//Kredit

				//Tunai
				$qdpk 	= "SELECT detailpenjualan.kode_barang,isipcsdus,isipack,isipcs,jenistransaksi,
						   SUM(detailpenjualan.subtotal) as totaljual,SUM(jumlah) as jumlah 
						   FROM detailpenjualan 
						   INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj   
						   INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang   
						   WHERE detailpenjualan.kode_barang = '$t->kode_barang' AND jenistransaksi='kredit' AND  tgltransaksi  
						   BETWEEN '$dari' AND '$sampai' AND promo !='1' ".$qsales." 
						   GROUP BY detailpenjualan.kode_barang,jenistransaksi";
				$dpk 	= $this->db->query($qdpk)->row_array();


				if($dpk['jumlah'] !=0){
					$jmldusk    = floor($dpk['jumlah'] / $dpk['isipcsdus']);
				    $sisadus   = $dpk['jumlah'] % $dpk['isipcsdus'];
				    if($dpk['isipack'] == 0){
				        $jmlpackk    = 0;
				        $sisapack   = $sisadus;   
				    }else{

				        $jmlpackk    = floor($sisadus / $dpk['isipcs']);  
				        $sisapack   = $sisadus % $dpk['isipcs'];  
				    }
				    $jmlpcsk = $sisapack;
				    $subtotalk = $dpk['totaljual'];
				}else{

					$jmldusk 	= 0;
					$jmlpackk	= 0;
					$jmlpcsk 	= 0;
					$subtotalk  = 0;
				}


				$qdpall 	= "SELECT detailpenjualan.kode_barang,isipcsdus,isipack,isipcs,
						   SUM(detailpenjualan.subtotal) as totaljual,SUM(jumlah) as jumlah 
						   FROM detailpenjualan 
						   INNER JOIN penjualan ON detailpenjualan.no_fak_penj = penjualan.no_fak_penj   
						   INNER JOIN barang ON detailpenjualan.kode_barang = barang.kode_barang   
						   WHERE detailpenjualan.kode_barang = '$t->kode_barang' AND  tgltransaksi  
						   BETWEEN '$dari' AND '$sampai' AND promo !='1' ".$qsales." 
						   GROUP BY detailpenjualan.kode_barang";
				$dpall 	= $this->db->query($qdpall)->row_array();


				if($dpall['jumlah'] !=0){
					$jmldusall    = floor($dpall['jumlah'] / $dpall['isipcsdus']);
				    $sisadus   	  = $dpall['jumlah'] % $dpall['isipcsdus'];
				    if($dpall['isipack'] == 0){
				        $jmlpackall    = 0;
				        $sisapack      = $sisadus;   
				    }else{

				        $jmlpackall    = floor($sisadus / $dpall['isipcs']);  
				        $sisapack   	= $sisadus % $dpall['isipcs'];  
				    }
				    $jmlpcsall 	= $sisapack;
				    $subtotalall = $dpall['totaljual'];
				}else{

					$jmldusall 	= 0;
					$jmlpackall	= 0;
					$jmlpcsall 	= 0;
					$subtotalall  = 0;
				}


				


				$totaldust 	= $totaldust + $jmldust;
				$totalpackt	= $totalpackt + $jmlpackt;
				$totalpcst 	= $totalpcst + $jmlpcst;
				$totalt 	= $totalt + $subtotalt;


				$totaldusk 	= $totaldusk+ $jmldusk;
				$totalpackk	= $totalpackk + $jmlpackk;
				$totalpcsk 	= $totalpcsk + $jmlpcsk;
				$totalk 	= $totalk + $subtotalk;

				$totaldusall  = $totaldusall + $jmldusall; 
				$totalpackall = $totalpackall + $jmlpackall;
				$totalpcsall  = $totalpcsall + $jmlpcsall;
				$totalall 	  = $totalall + $subtotalall;
		?>	
			<tr>
				<td><?php echo $t->kode_barang; ?></td>
				<td><?php echo $t->nama_barang; ?></td>
				<td align="center"><?php if($jmldust !=0){ echo $jmldust;}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpackt !=0){ echo $jmlpackt;}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpcst !=0){ echo $jmlpcst;}else{echo "";} ?></td>
				<td align="right"><?php echo uang($subtotalt); ?></td>
				<td align="center"><?php if($jmldusk !=0){ echo $jmldusk;}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpackk !=0){ echo $jmlpackk;}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpcsk !=0){ echo $jmlpcsk;}else{echo "";} ?></td>
				<td align="right"><?php echo uang($subtotalk); ?></td>
				<td align="center"><?php if($jmldusall !=0){ echo $jmldusall;}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpackall !=0){ echo $jmlpackall;}else{echo "";} ?></td>
				<td align="center"><?php if($jmlpcsall !=0){ echo $jmlpcsall;}else{echo "";} ?></td>
				<td align="right"><?php echo uang($subtotalall); ?></td>
			</tr>
				
		<?php
		}

		$totalallretur 		 = $returt['totalretur']+$returk['totalretur'];
		$totalallpenyharga   = $pott['totpenyharga']+$potk['totpenyharga'];
		$totalallpotongan    = $pott['totpotongan']+$potk['totpotongan'];
		$totalallpotistimewa = $pott['totpotistimewa']+$potk['totpotistimewa'];

		$totalallt 		     = $totalt-$returt['totalretur'] - $pott['totpenyharga'] - $pott['totpotongan'] - 
							   $pott['totpotistimewa'];

		$totalallk 			 = $totalk-$returk['totalretur'] - $potk['totpenyharga'] - $potk['totpotongan'] - 
							   $potk['totpotistimewa'];

		?>
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
			<tr>
				<td colspan="5">Retur Penjualan</td>
				<td align="right"><?php echo uang($returt['totalretur']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($returk['totalretur']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallretur); ?></td>
			</tr>
			<tr>
				<td colspan="5">Penyesuaian Harga</td>
				<td align="right"><?php echo uang($pott['totpenyharga']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($potk['totpenyharga']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallpenyharga); ?></td>
			</tr>
			<tr>
				<td colspan="5">Potongan Harga</td>
				<td align="right"><?php echo uang($pott['totpotongan']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($potk['totpotongan']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($totalallpotongan); ?></td>
			</tr>
			<tr>
				<td colspan="5">Potongan Isitimwa</td>
				<td align="right"><?php echo uang($pott['totpotistimewa']); ?></td>
				<td colspan="3"></td>
				<td align="right"><?php echo uang($potk['totpotistimewa']); ?></td>
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