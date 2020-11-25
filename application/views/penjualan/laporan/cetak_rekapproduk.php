<?php
	//error_reporting(0);
	function uang($nilai){

		return number_format($nilai,'0',',','.');
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
<b style="font-size:20px; font-family:Calibri">
	
	
	<?php 
		if($cb['nama_cabang'] != ""){
			echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
		}else{
			echo "PACIFIC ALL CABANG";
		}
		 
	?>
	<br>
	PENJUALAN PRODUK<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
	
	<?php 
		if($salesman['nama_karyawan'] != ""){
			echo "NAMA SALES : ". strtoupper($salesman['nama_karyawan']);
		}else{
			echo "ALL SALES";
		}
		 
	?>
	<br>
	
</b>
<br>
<br>
<table border="0">
	<thead>
		<tr>
			<th align="left">PENJUALAN</th>
			<th align="right">JUMLAH</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$kategori  				= "";
		$jumlahperkategori		= 0;
		$jumlahall				= 0;
		foreach($rekap as $key => $r){
			$kat = @$rekap[$key+1]->kategori_jenisproduk;
			if($kategori != $r->kategori_jenisproduk){
				
				echo "<tr><td colspan='2'><b><i>$r->kategori_jenisproduk</i></b></td></tr>";
			}
			
			$jumlahperkategori = $jumlahperkategori + $r->jumlah;
			$jumlahall 		   = $jumlahall + $r->jumlah;
		?>
			<tr>
				<td style="width:300px; text-align:left" ><?php echo $r->nama_barang; ?></td>
				<td align="right"><?php echo uang($r->jumlah);  ?></td>
			</tr>
		<?php 
			$kategori  = $r->kategori_jenisproduk;
			
			if($kat != $r->kategori_jenisproduk){
			?>
				<tr>
					<td><b><i>JUMLAH</i></b></td>
					<td align="right"><b><i><?php echo uang($jumlahperkategori); ?></i></b></td>
				</tr>
			<?php 
				$jumlahperkategori = 0;
				echo "<tr style='height:20px'><td colspan='2'></tr>";
			}
		} 
		
		?>
	</tbody>
	<tfoot>
		<?php 
		
			if($cb['kode_cabang'] 	!= ""){
				$cabang = "AND pelanggan.kode_cabang = '".$cb['kode_cabang']."' ";
			}else{
				$cabang = "";
			}

			if($salesman['id_karyawan'] != ""){
				$sales = "AND penjualan.id_karyawan = '".$salesman['id_karyawan']."' ";
			}else{
				$sales = "";
			}
			$qpenjualan = "SELECT SUM(potongan) as potongan,SUM(potistimewa) as potistimewa, SUM(penyharga) as penyharga 
							FROM penjualan
							INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
							WHERE tgltransaksi BETWEEN '$dari' AND '$sampai'"
							.$cabang
							.$sales;
							
			$qretur = "SELECT SUM(retur.total) as totalretur
							FROM retur
							INNER JOIN penjualan ON retur.no_fak_penj = penjualan.no_fak_penj
							INNER JOIN pelanggan ON penjualan.kode_pelanggan = pelanggan.kode_pelanggan
							
							WHERE tglretur BETWEEN '$dari' AND '$sampai'"
							.$cabang
							.$sales;
			$penjualan = $this->db->query($qpenjualan)->row_array();
			$retur 	   = $this->db->query($qretur)->row_array();
							
		?>
		<tr>
			<td>POTONGAN</td>
			<td align="right"><b><i><?php echo uang($penjualan['potongan']); ?></i></b></td>
		</tr>
		<tr>
			<td>POTONGAN ISTIMEWA</td>
			<td align="right"><b><i><?php echo uang($penjualan['potistimewa']); ?></i></b></td>
		</tr>
		<tr>
			<td>PENYESUAIAN</td>
			<td align="right"><b><i><?php echo uang($penjualan['penyharga']); ?></i></b></td>
		</tr>
		<tr>
			<td>RETUR</td>
			<td align="right"><b><i><?php echo uang($retur['totalretur']); ?></i></b></td>
		</tr>
		<tr>
			<td></td>
			
		</tr>
		<tr>
			<td><b>PENJUALAN BERSIH</b></td>
			<?php 
				$totalnetto = $jumlahall - $penjualan['potongan'] - $penjualan['potistimewa'] - $penjualan['penyharga'] - $retur['totalretur'];
			?>
			<td align="right"><b><i><?php echo uang($totalnetto); ?></i></b></td>
		</tr>
	</tfoot>
</table>
<?php  } ?>