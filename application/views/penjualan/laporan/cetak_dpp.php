<?php
//error_reporting(0);
function uang($nilai)
{
	return number_format($nilai, '2', ',', '.');
}

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:16px; font-family:Calibri">


	<?php
	if ($cb['nama_cabang'] != "") {
		echo "PACIFIC CABANG " . strtoupper($cb['nama_cabang']);
	} else {
		echo "PACIFIC ALL CABANG";
	}

	?>
	<br>
	DATA PENGAMBILAN PELANGGAN<br>
	PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>

	<?php
	if ($salesman['nama_karyawan'] != "") {
		echo "NAMA SALES : " . strtoupper($salesman['nama_karyawan']);
	} else {
		echo "ALL SALES";
	}

	?>
	<br>
	<?php
	if ($pelanggan['nama_pelanggan'] != "") {
		echo "NAMA PELANGGAN : " . strtoupper($pelanggan['nama_pelanggan']);
	}
	?>

</b>
<br>
<br>

<table class="datatable3">

	<thead>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th rowspan="2">TANGGAL</th>
			<th rowspan="2">KODE PELANGGAN</th>
			<th rowspan="2">NAMA PELANGGAN</th>
			<th rowspan="2">ALAMAT PELANGGAN</th>
			<th rowspan="2">SALESMAN</th>
			<th colspan="10">PRODUK</th>
		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th>BB</th>
			<th>AB</th>
			<th>AR</th>
			<th>AS</th>
			<th>DP</th>
			<th>DK</th>
			<th>DS</th>
			<th>DB</th>
			<th>CG</th>
			<th>CGG</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$total_bb = 0;
		$total_ab = 0;
		$total_ar = 0;
		$total_ase = 0;
		$total_dp = 0;
		$total_dk = 0;
		$total_ds = 0;
		$total_db = 0;
		$total_cg = 0;
		$total_cgg = 0;
		foreach ($dpp as $d) {
			$total_bb = $total_bb + $d->BB;
			$total_ab = $total_ab + $d->AB;
			$total_ar = $total_ar + $d->AR;
			$total_ase = $total_ase + $d->ASE;
			$total_dp = $total_dp + $d->DP;
			$total_dk = $total_dk + $d->DK;
			$total_ds = $total_ds + $d->DS;
			$total_db = $total_db + $d->DB;
			$total_cg = $total_cg + $d->CG;
			$total_cgg = $total_cgg + $d->CGG;
		?>
			<tr style="font-size:12;">
				<td><?php echo DateToIndo2($d->tgltransaksi); ?></td>
				<td><?php echo $d->kode_pelanggan; ?></td>
				<td><?php echo $d->nama_pelanggan; ?></td>
				<td><?php echo $d->alamat_pelanggan; ?></td>
				<td><?php echo $d->nama_karyawan; ?></td>
				<td align="right"><?php if ($d->BB != 0) {
														echo uang($d->BB);
													} ?></td>
				<td align="right"><?php if ($d->AB != 0) {
														echo uang($d->AB);
													} ?></td>
				<td align="right"><?php if ($d->AR != 0) {
														echo uang($d->AR);
													} ?></td>
				<td align="right"><?php if ($d->ASE != 0) {
														echo uang($d->ASE);
													} ?></td>
				<td align="right"><?php if ($d->DP != 0) {
														echo uang($d->DP);
													} ?></td>
				<td align="right"><?php if ($d->DK != 0) {
														echo uang($d->DK);
													} ?></td>
				<td align="right"><?php if ($d->DS != 0) {
														echo uang($d->DS);
													} ?></td>
				<td align="right"><?php if ($d->DB != 0) {
														echo uang($d->DB);
													} ?></td>
				<td align="right"><?php if ($d->CG != 0) {
														echo uang($d->CG);
													} ?></td>
				<td align="right"><?php if ($d->CGG != 0) {
														echo uang($d->CGG);
													} ?></td>
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<td colspan="5">TOTAL</td>
			<td><?php if ($total_bb != 0) {
						echo uang($total_bb);
					} ?></td>
			<td><?php if ($total_ab != 0) {
						echo uang($total_ab);
					} ?></td>
			<td><?php if ($total_ar != 0) {
						echo uang($total_ar);
					} ?></td>
			<td><?php if ($total_ase != 0) {
						echo uang($total_ase);
					} ?></td>
			<td><?php if ($total_dp != 0) {
						echo uang($total_dp);
					} ?></td>
			<td><?php if ($total_dk != 0) {
						echo uang($total_dk);
					} ?></td>
			<td><?php if ($total_ds != 0) {
						echo uang($total_ds);
					} ?></td>
			<td><?php if ($total_db != 0) {
						echo uang($total_db);
					} ?></td>
			<td><?php if ($total_cg != 0) {
						echo uang($total_cg);
					} ?></td>
			<td><?php if ($total_cgg != 0) {
						echo uang($total_cgg);
					} ?></td>
		</tr>

	</tfoot>

</table>