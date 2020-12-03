<?php
error_reporting(0);
function uang($nilai)
{
	return number_format($nilai, '2', ',', '.');
}

function angka($nilai)
{
	return number_format($nilai, '2', ',', '.');
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
	TRANSAKSI PEMBELIAN <br>
	PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br>
	<?php
	if ($dept != "") {
		echo "DEPARTEMEN : " . strtoupper($dept);
	} else {
		echo "ALL DEPARTEMEN";
	}
	?>
	<br>
	<?php
	if ($supplier != "") {
		echo "SUPPLIER : " . strtoupper($supp['nama_supplier']);
	} else {
		echo "ALL SUPPLIER";
	}
	?>
	<br>
	<?php
	if ($ppn != "") {
		if ($ppn == '0') {
			echo "NON PPN";
		} else if ($ppn == '1') {
			echo "PPN";
		}
	}
	?>
</b>
<br>
<style>
	.str {
		mso-number-format: \@;
	}
</style>
<table class="datatable3" style="width:100%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
			<td>NO</td>
			<td>TGL</td>
			<td>NO BUKTI</td>
			<td>SUPPLIER</td>
			<td>NAMA BARANG</td>
			<td>KETERANGAN</td>
			<td>JURNAL</td>
			<td>AKUN</td>
			<td>PPN</td>
			<td>QTY</td>
			<td>HARGA</td>
			<td>SUBTOTAL</td>
			<td>PENYESUAIAN</td>
			<td>TOTAL</td>
			<td>DEBET</td>
			<td>KREDIT</td>
			<td>TANGGAL INPUT</td>
			<td>TANGGAL UPDATE</td>
		</tr>
	</thead>
	<tbody>
		<?php
		// $subtotal 			= 0;
		$totaldk				= 0;
		$totalppn 			= 0;
		$no 						= 1;
		$grandtotall   	= 0;
		$totaldebet 		= 0;
		$totalkredit    = 0;
		foreach ($pmb as $key => $d) {
			$nobukti  	= @$pmb[$key + 1]->nobukti_pembelian;
			$totalharga =  ($d->qty * $d->harga) + $d->penyesuaian;
			$subtotalharga = $d->qty * $d->harga;
			if ($d->kode_dept != "GDB") {
				$akun     = "2-1300";
				$namaakun  = "Hutang Lainnya";
			} else {
				$akun     = "2-1200";
				$namaakun = "Hutang Dagang";
			}
			if ($d->ppn == '1') {
				$cekppn  =  "&#10004;";
				$bgcolor = "#ececc8";
				$dpp     = (100 / 110) * $totalharga;
				$ppn     = 10 / 100 * $dpp;
			} else {
				$bgcolor = "";
				$cekppn  = "";
				$dpp     = "";
				$ppn     = "";
			}
			if ($d->status == 'PNJ') {
				$totharga 	= -$totalharga;
				$debet 			= "";
				$kredit   	= $totalharga;
				$namabarang = $d->ket_penjualan;
			} else {
				$totharga 	= $totalharga;
				$debet 			= $totalharga;
				$kredit   	= "";
				$namabarang = $d->nama_barang;
			}
			$grandtotall 	= $grandtotall + $totalharga;
			$grandtotal 	= $totharga;
			$totaldebet 	= $totaldebet + $debet;
			$totalkredit  = $totalkredit + $kredit;
			$totaldk 			= $totaldk + $grandtotal;
			// $totalppn 		= $totalppn + $ppn;

		?><tr style="background-color:<?php echo $bgcolor; ?>">
				<td><?php echo $no; ?></td>
				<td><?php echo $d->tgl_pembelian; ?></td>
				<td><?php echo $d->nobukti_pembelian; ?></td>
				<td><?php echo $d->nama_supplier; ?></td>
				<td><?php echo $namabarang; ?></td>
				<td><?php echo $d->keterangan; ?></td>
				<td><?php echo $d->nama_akun; ?></td>
				<td align="center" class="str"><?php echo $d->kode_akun; ?></td>
				<td align="center"><?php echo $cekppn; ?></td>
				<td align="center"><?php echo angka($d->qty); ?></td>
				<td align="right"><?php echo uang($d->harga); ?></td>
				<td align="right"><?php echo uang($subtotalharga); ?></td>
				<td align="right"><?php echo uang($d->penyesuaian); ?></td>
				<td align="right"><?php echo uang($totalharga); ?></td>
				<td align="right"><?php echo uang($debet); ?></td>
				<td align="right"><?php echo uang($kredit); ?></td>
				<?php if($d->tgl_pembelian < "2020-12-02"){ ?>
					<td><?php echo $d->date_created; ?></td>
					<td><?php echo $d->date_updated; ?></td>
				<?php }else{ ?>
					<td><?php echo $d->detaildate_created; ?></td>
					<td><?php echo $d->detaildate_updated; ?></td>
				<?php } ?>
			</tr><?php
						$subtotal = $subtotal + $grandtotal;
						if ($nobukti != $d->nobukti_pembelian) {


							echo '
					<tr bgcolor="#a7efe4" style="color:black; font-weight:bold">
						<td></td>
            <td></td>
            <td>' . $d->nobukti_pembelian . '</td>
            <td>' . $d->nama_supplier . '</td>
            <td></td>
            <td></td>
						<td>' . $namaakun . '</td>
						<td align=center>' . $akun . '</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align=right>' . uang($subtotal) . '</td>
						<td></td>
						<td></td>

					</tr>';
							$subtotal = 0;
						}

						?><?php
							$no++;
						}
							?></tbody>
	<tr>
		<td colspan="12" align="center"><b>TOTAL</b></td>
		<td align="right"><b></b></td>
		<td align="right"><b><?php echo uang($grandtotall); ?></b></td>
		<td align="right"><b><?php echo uang($totaldebet); ?></b></td>
		<td align="right"><b><?php echo uang($totalkredit + $totaldk); ?></b></td>
		<td></td>
		<td></td>
	</tr>
</table><br>