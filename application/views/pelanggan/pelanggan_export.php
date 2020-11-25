
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">
	DATA PELANGGAN
</b>
<br>
<br>
<table class="datatable3">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12;">
			<th width="10px">No</th>
			<th>Kode Pelanggan</th>
			<th>NIK</th>
			<th>NO KK</th>
			<th>Nama Pelanggan</th>
			<th>Tgl Lahir</th>
			<th>HP</th>
			<th>Kecamatan</th>
			<th>Kelurahan</th>
			<th>Alamat</th>
			<th>Pasar</th>
			<th>Hari</th>
			<th>Cabang</th>
			<th>Salesman</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th>Limit</th>
		</tr>
	</thead>
	<tbody>
			<?php
				$no = 1;
				foreach($pelanggan as $d){
			?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $d->kode_pelanggan; ?></td>
					<td><?php echo $d->nik; ?></td>
					<td><?php echo $d->no_kk; ?></td>
					<td><?php echo $d->nama_pelanggan; ?></td>
					<td><?php echo $d->tgl_lahir; ?></td>
					<td><?php echo $d->no_hp; ?></td>
					<td><?php echo $d->kecamatan; ?></td>
					<td><?php echo $d->kelurahan; ?></td>
					<td><?php echo $d->alamat_pelanggan; ?></td>
					<td><?php echo $d->pasar; ?></td>
					<td><?php echo $d->hari; ?></td>
					<td><?php echo $d->kode_cabang; ?></td>
					<td><?php echo $d->nama_karyawan; ?></td>
					<td><?php echo $d->latitude; ?></td>
					<td><?php echo $d->longitude; ?></td>
					<td><?php echo number_format($d->limitpel,'0','','.'); ?></td>
				</tr>
			<?php
					$no++; 
				}
			?>
	</tbody>
</table>
