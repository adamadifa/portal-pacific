<table class="table  table-hover table-striped">
	<tr>
		<td><b>NO Permintaan</b></td>
		<td>:</td>
		<td>
			<?php echo $pp['no_permintaan_pengiriman']; ?>
			<input type="hidden" id="nopermintaan" value="<?php echo $pp['no_permintaan_pengiriman']; ?>">
		</td>
	</tr>
	<tr>
		<td><b>Tanggal</b></td>
		<td>:</td>
		<td><?php echo DateToIndo2($pp['tgl_permintaan_pengiriman']); ?></td>
	</tr>
	<tr>
		<td><b>Cabang</b></td>
		<td>:</td>
		<td><?php echo $pp['nama_cabang']; ?></td>
	</tr>
	<tr>
		<td><b>Keterangan</b></td>
		<td>:</td>
		<td><?php echo $pp['keterangan']; ?></td>
	</tr>
	<tr>
		<td><b>Status</b></td>
		<td>:</td>
		<td>
			<?php

			if ($pp['status'] == 0) {
				$color = "bg-red";
				$status = "Belum di Proses";
			} else {
				$color  = "bg-green";
				$status = "Sudah di Proses";
			}


			?>
			<span class="badge <?php echo $color; ?>"><?php echo $status; ?></span>
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
	<tbody id="loaddetailpp">

	</tbody>
</table>

<script type="text/javascript">
	$(function() {

		function loaddetailpp() {
			var no_permintaan = $("#nopermintaan").val();
			$("#loaddetailpp").load('<?php echo base_url(); ?>/oman/detailpp_gj/' + no_permintaan);
		}


		loaddetailpp();


	});
</script>