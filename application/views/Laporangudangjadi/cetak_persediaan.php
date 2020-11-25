<?php

function uang($nilai)
{

	return number_format($nilai, '0', '', '.');
}
error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	PACIFIC<br>
	REKAPITULASI PERSEDIAAN BARANG<br>
	PERIODE <?php echo DateToIndo2($dari) . " s/d " . DateToIndo2($sampai); ?><br><br>
	<table>
		<tr>
			<td><b>KODE PRODUK</b></td>
			<td>:</td>
			<td><b><?php echo $produk['kode_produk']; ?></b></td>
		</tr>
		<tr>
			<td><b>PRODUK</b></td>
			<td>:</td>
			<td><b><?php echo $produk['nama_barang']; ?></b></td>
		</tr>
	</table>
</b>
<br>
<table class="datatable3" style="width:80%" border="1">
	<thead>
		<tr>

			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">Tanggal</th>
			<th colspan="5" bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
			<th rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">KETERANGAN</th>
			<th colspan="3" bgcolor="#28a745" style="color:white; font-size:12;">PENERIMAAN</th>
			<th colspan="3" bgcolor="#c7473a" style="color:white; font-size:12;">PENGELUARAN</th>
			<th rowspan="2" rowspan="2" bgcolor="#024a75" style="color:white; font-size:12;">SALDO AKHIR</th>
		</tr>
		<tr>
			<th bgcolor="#024a75" style="color:white; font-size:12;">FSTHP</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">SURAT JALAN</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">REPACK</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">REJECT</th>
			<th bgcolor="#024a75" style="color:white; font-size:12;">LAINLAIN</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">PRODUKSI</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">REPACK</th>
			<th bgcolor="#28a745" style="color:white; font-size:12;">LAIN LAIN</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">KIRIM KE CABANG</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">REJECT</th>
			<th bgcolor="#c7473a" style="color:white; font-size:12;">LAIN LAIN</th>
		</tr>
		</tr>
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th colspan="6"></th>
			<th>SALDO AWAL</th>
			<th colspan="6"></th>
			<th style="text-align: right"><?php echo uang($saldoawal); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$totalfsthp 	 = 0;
		$totalsuratjalan = 0;
		$totalrepack 	 = 0;
		$totalreject     = 0;
		$saldoakhir      = $saldoawal;
		foreach ($mutasi as $m) {
			if ($m->jenis_mutasi == "FSTHP") {

				$no_fsthp = $m->no_mutasi_gudang;
				$jmlfsthp = $m->jumlah;
				$ket 	  = "PRODUKSI";
			} else {

				$no_fsthp = "";
				$jmlfsthp = "";
			}

			if ($m->jenis_mutasi == "SURAT JALAN") {

				$no_suratjalan = $m->no_mutasi_gudang;
				$jmlsuratjalan = $m->jumlah;
				$ket 		   = $m->kode_cabang;
			} else {
				$no_suratjalan = "";
				$jmlsuratjalan = "";
			}

			if ($m->jenis_mutasi == "REPACK") {

				$no_repack 		= $m->no_mutasi_gudang;
				$jmlrepack  	= $m->jumlah;
				$ket 		    	= "REPACK";
			} else {
				$no_repack = "";
				$jmlrepack = "";
			}

			if ($m->jenis_mutasi == "REJECT") {

				$no_reject 		= $m->no_mutasi_gudang;
				$jmlreject  	= $m->jumlah;
				$ket 		    	= "REJECT";
			} else {
				$no_reject = "";
				$jmlreject = "";
			}

			if ($m->jenis_mutasi == "LAINLAIN" and $m->inout == 'IN') {

				$no_mutasilainlain 		= $m->no_mutasi_gudang;
				$jmllainlain_in  			= $m->jumlah;
				$ket 		    					= $m->keterangan;
			} else {
				$no_mutasilainlain = "";
				$jmllainlain_in = "";
			}

			if ($m->jenis_mutasi == "LAINLAIN" and $m->inout == 'OUT') {

				$no_mutasilainlain 		= $m->no_mutasi_gudang;
				$jmllainlain_out  		= $m->jumlah;
				$ket 		    					= $m->keterangan;
			} else {
				$no_mutasilainlain = "";
				$jmllainlain_out = "";
			}

			if ($m->inout == 'IN') {
				$jumlah  = $m->jumlah;
			} else {
				$jumlah = -$m->jumlah;
			}

			$saldoakhir 		= $saldoakhir + $jumlah;
			$totalfsthp 		= $totalfsthp + $jmlfsthp;
			$totalsuratjalan 	= $totalsuratjalan + $jmlsuratjalan;
			$totalrepack 		= $totalrepack + $jmlrepack;
			$totalreject 		= $totalreject + $jmlreject;
			$totallainlain_in = $totallainlain_in + $jmllainlain_in;
			$totallainlain_out = $totallainlain_out + $jmllainlain_out;
		?>
			<tr style="font-weight: bold; font-size:11px">
				<td><?php echo DateToIndo2($m->tgl_mutasi_gudang); ?></td>
				<td><?php echo $no_fsthp; ?></td>
				<td><?php echo $no_suratjalan; ?></td>
				<td><?php echo $no_repack; ?></td>
				<td><?php echo $no_reject; ?></td>
				<td><?php echo $no_mutasilainlain; ?></td>
				<td><?php echo $ket; ?></td>
				<td align="right"><?php echo uang($jmlfsthp); ?></td>
				<td align="right"><?php echo uang($jmlrepack); ?></td>
				<td align="right"><?php echo uang($jmllainlain_in); ?></td>
				<td align="right"><?php echo uang($jmlsuratjalan); ?></td>
				<td align="right"><?php echo uang($jmlreject); ?></td>
				<td align="right"><?php echo uang($jmllainlain_out); ?></td>
				<td align="right"><?php echo uang($saldoakhir); ?></td>
			</tr>
		<?php
		}
		?>

	</tbody>
	<tfoot bgcolor="#024a75" style="color:white; font-size:12;">
		<tr>
			<th colspan="7">TOTAL</th>
			<th style="text-align: right"><?php echo uang($totalfsthp); ?></th>
			<th style="text-align: right"><?php echo uang($totalrepack); ?></th>
			<th style="text-align: right"><?php echo uang($totallainlain_in); ?></th>
			<th style="text-align: right"><?php echo uang($totalsuratjalan); ?></th>
			<th style="text-align: right"><?php echo uang($totalreject); ?></th>
			<th style="text-align: right"><?php echo uang($totallainlain_out); ?></th>
			<th style="text-align: right"><?php echo uang($saldoakhir); ?></th>
		</tr>
	</tfoot>
</table>