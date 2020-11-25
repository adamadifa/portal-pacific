<?php

	function uang($nilai){

		return number_format($nilai,'0','','.');
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
	LAPORAN LEBIH 1 FAKTUR<br>


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

	<?php
			echo "TANGGAL : ". DateToIndo2($tanggal);
	?>

</b>

<br>
<br>

<table class="datatable3" style="width:50%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td>Tanggal Penjualan</td>
			<td>No Faktur</td>
			<td>Kode Pelanggan</td>
			<td>Nama Pelanggan</td>
			<td>Pasar / Daerah</td>
			<td>Saldo Piutang</td>
			<td style="width:5%">Jumlah</td>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			$totalsisabayar = 0;
			$totalfaktur 	= 0;
			$grandtotal 	= 0;
			$kode_pelanggan = "";
			foreach($lebihsatufaktur as $key => $lb){
				$pel  = @$lebihsatufaktur[$key+1]->kode_pelanggan;
				if($kode_pelanggan != $lb->kode_pelanggan){
					$totalfaktur 		= 0;
					$totalsisabayar 	= 0;

				}
				//echo $pel."<br>";
				$totalsisabayar = $totalsisabayar + $lb->sisabayar;
				$totalfaktur 	= $totalfaktur + $lb->jmlfaktur;
				//$grandtotal 	= $grandtotal + $lb->sisabayar;
		?>

		<?php


		?>

				<tr>
					<td><?php echo $lb->tgltransaksi; ?></td>
					<td><?php echo $lb->no_fak_penj; ?></td>
					<td><?php echo $lb->kode_pelanggan; ?></td>
					<td><?php echo $lb->nama_pelanggan; ?></td>
					<td><?php echo $lb->pasar; ?></td>
					<td align="right"><?php echo uang($lb->sisabayar); ?></td>
					<td></td>
				</tr>

		<?php

				if($pel != $lb->kode_pelanggan ){
					if($totalfaktur>1){

						$grandtotal = $grandtotal + $totalsisabayar;
					}
					echo '
						<tr bgcolor="#199291" style="color:white; font-weight:bold">

							<td colspan="5" >Jumlah Faktur</td>
							<td align=right>'.uang($totalsisabayar).'</td>
							<td>'.$totalfaktur.'</td>
						</tr>';
					$totalfaktur    = 0;
					$totalsisabayar = 0;


				}

				$kode_pelanggan = $lb->kode_pelanggan;

			}
		?>



	</tbody>
	<tfoot>
		<tr bgcolor="#199291" style="color:white; font-weight:bold">
			<td colspan="5" >GRAND TOTAL LEBIH SATU FAKTUR</td>
			<td align="right"><?php echo uang($grandtotal); ?></td>
			<td></td>
		</tr>
	</tfoot>
</table>
