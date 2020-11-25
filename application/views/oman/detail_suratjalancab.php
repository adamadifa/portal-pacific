<table class="table  table-hover table-striped">
	<tr>
		<td><b>No Surat Jalan</b></td>
		<td>:</td>
		<td>
			<?php echo $sj['no_mutasi_gudang']; ?>
		</td>
	</tr>
	<tr>
		<td><b>Tanggal SJ</b></td>
		<td>:</td>
		<td><?php echo DateToIndo2($sj['tgl_mutasi_gudang']); ?></td>
	</tr>

	<tr>
		<td><b>Cabang</b></td>
		<td>:</td>
		<td><?php echo $sj['nama_cabang']; ?></td>
	</tr>
	<tr>
		<td><b>Keterangan</b></td>
		<td>:</td>
		<td><?php echo $sj['keterangan']; ?></td>
	</tr>
	<tr>
		<td><b>Status</b></td>
		<td>:</td>
		<td>
			<?php

			if ($sj['status_sj'] == 0) {
				$color_sj     = "bg-red";
				$status_sj    = "Belum di Terima Cabang";
				$tgl_diterima = "";
			} else if ($sj['status_sj'] == 2) {
				$color_sj       = "bg-blue";
				$status_sj      = "Transit Out";
				$tgl_sj            = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $sj['no_mutasi_gudang']))->row_array();
				$tgl_diterima   = $tgl_sj['tgl_mutasi_gudang_cabang'];
				$tgl_terima  = explode("-", $tgl_diterima);
				$harisjc = $tgl_terima[2];
				$bulansjc = $tgl_terima[1];
				$tahunsjc = $tgl_terima[0];
				$tgl_terima_sj = $harisjc . "/" . $bulansjc . "/" . substr($tahunsjc, 2, 2);
			} else if ($sj['status_sj'] == 1) {
				$color_sj  = "bg-green";
				$status_sj = "Sudah di Terima Cabang";
				$tgl_sj            = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $sj['no_mutasi_gudang']))->row_array();
				$tgl_diterima   = $tgl_sj['tgl_mutasi_gudang_cabang'];
				$tgl_terima  = explode("-", $tgl_diterima);
				$harisjc = $tgl_terima[2];
				$bulansjc = $tgl_terima[1];
				$tahunsjc = $tgl_terima[0];
				$tgl_terima_sj = $harisjc . "/" . $bulansjc . "/" . substr($tahunsjc, 2, 2);
			}


			?>
			<span class="badge <?php echo $color_sj; ?>"><?php echo $status_sj; ?></span>
		</td>
	</tr>

</table>

<table class="table table-bordered table-hover table-striped">
	<thead class="thead-dark">

		<tr>
			<th>Kode Produk</th>
			<th>Nama Barang</th>
			<th>Jumlah</th>

		</tr>
	</thead>
	<tbody id="">
		<?php foreach ($detail as $s) { ?>
			<tr>
				<td><?php echo $s->kode_produk; ?></td>
				<td><?php echo $s->nama_barang; ?></td>
				<td><?php echo $s->jumlah; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>