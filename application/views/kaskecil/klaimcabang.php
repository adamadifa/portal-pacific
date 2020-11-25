<div class="container-fluid">
	<!-- Page title -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-auto">
				<h2 class="page-title">
					Klaim Cabang
				</h2>
			</div>
		</div>
	</div>
	<!-- Content here -->
	<div class="row">
		<div class="col-md-10 col-xs-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Klaim Cabang</h4>
				</div>
				<div class="card-body">
					<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>kaskecil/klaimcabang" autocomplete="off">
						<div class="mb-3">
							<div class="row">
								<div class="col-md-12">
									<select class="form-select" id="cabang" name="cabang" data-error=".errorTxt1">
										<option value="">-- Semua Cabang --</option>
										<option <?php if ($cbg == "PST") {
															echo "selected";
														} ?> value="PST">PUSAT</option>
										<?php foreach ($cabang as $c) { ?>
											<option <?php if ($cbg == $c->kode_cabang) {
																echo "selected";
															} ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<div class="row">
								<div class="col-md-6">
									<div class="input-icon">
										<input id="dari" type="date" value="<?php echo $dari; ?>" placeholder="Dari" class="form-control" name="dari" />
										<span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" />
												<rect x="4" y="5" width="16" height="16" rx="2" />
												<line x1="16" y1="3" x2="16" y2="7" />
												<line x1="8" y1="3" x2="8" y2="7" />
												<line x1="4" y1="11" x2="20" y2="11" />
												<line x1="11" y1="15" x2="12" y2="15" />
												<line x1="12" y1="15" x2="12" y2="18" /></svg>
										</span>
									</div>
								</div>

								<div class="col-md-6">
									<div class="input-icon">
										<input id="sampai" type="date" value="<?php echo $sampai; ?>" placeholder="Sampai" class="form-control" name="sampai" />
										<span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" />
												<rect x="4" y="5" width="16" height="16" rx="2" />
												<line x1="16" y1="3" x2="16" y2="7" />
												<line x1="8" y1="3" x2="8" y2="7" />
												<line x1="4" y1="11" x2="20" y2="11" />
												<line x1="11" y1="15" x2="12" y2="15" />
												<line x1="12" y1="15" x2="12" y2="18" /></svg>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="mb-3 d-flex justify-content-end">
							<button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
						</div>
					</form>
					<hr>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="mytable">
							<thead class="thead-dark">
								<tr>
									<th>No</th>
									<th>Kode Klaim</th>
									<th>Tanggal</th>
									<th>Keterangan</th>
									<th>Cabang</th>
									<th>Status</th>
									<th>Tgl Proses</th>
									<th>Status Validasi</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (empty($result)) {
								?>
									<tr>
										<td colspan="9">
											<div class="alert alert-warning" role="alert">
												Data Tidak Ditemukan / Silahkan Pilih Periode Terlebih Dahulu !
											</div>
										</td>
									</tr>
									<?php
								} else {
									$sno   = 1;
									foreach ($result as $d) {
										if ($d['status'] == '0') {
											$keterangan = "Belum Di Proses";
											$color 			= "bg-red";
										} else {
											$keterangan = "Sudah di Proses";
											$color 			= "bg-green";
										}
										if ($d['status_validasi'] == '0') {
											$keterangan_valid = "Belum Di Validasi";
											$color_valid 			= "bg-red";
										} else if (empty($d['status_validasi'])) {
											$keterangan_valid = "";
											$color_valid 			= "";
										} else {
											$keterangan_valid = "Sudah di Validasi";
											$color_valid 			= "bg-green";
										}
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo $d['kode_klaim']; ?></td>
											<td><?php echo DateToIndo2($d['tgl_klaim']); ?></td>
											<td><?php echo $d['keterangan']; ?></td>
											<td><?php echo $d['kode_cabang']; ?></td>
											<td><span class="badge <?php echo $color; ?>"><?php echo $keterangan; ?></span></td>
											<td>
												<?php
												if ($d['status'] != '0') {
													echo DateToIndo2($d['tgl_ledger']);
												}
												?>
											</td>
											<td><span class="badge <?php echo $color_valid; ?>"><?php echo $keterangan_valid; ?></span></td>
											<td>
												<a href="#" data-id="<?php echo $d['kode_klaim'] ?>" data-tglklaim="<?php echo $d['tgl_klaim'] ?>" data-cabang="<?php echo $d['kode_cabang'] ?>" class="btn btn-primary btn-sm detail"><i class="fa fa-print"></i></a>
												<?php if ($d['status'] == '0') { ?>
													<a href="#" data-id="<?php echo $d['kode_klaim'] ?>" data-tglklaim="<?php echo $d['tgl_klaim'] ?>" data-cabang="<?php echo $d['kode_cabang'] ?>" class="btn btn-success btn-sm prosesklaim"><i class="fa fa-send"></i></a>
													<?php } else {
													if (empty($d['status_validasi'])) {
													?>
														<a href="<?php echo base_url(); ?>kaskecil/batal_klaim/<?php echo $d['kode_klaim']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-close"></i></a>
												<?php
													}
												} ?>
											</td>
										</tr>
								<?php
										$sno++;
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<?php $this->load->view('menu/menu_keuangan_administrator'); ?>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" id="detail" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">Detail Klaim</h5>
			</div>
			<div class="modal-body">
				<div id="loaddetail"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" id="prosesklaim" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">Detail Klaim</h5>
			</div>
			<div class="modal-body">
				<div id="loadprosesklaim"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		flatpickr(document.getElementById('dari'), {});
		flatpickr(document.getElementById('sampai'), {});
	});
</script>
<script type="text/javascript">
	$(function() {
		$('.hapus').on('click', function() {
			var getLink = $(this).attr('href');
			swal({
				title: 'Batalkan Klaim ?',
				text: 'Apakah Anda Yakin Ingin Membatalkan Klaim ini ?',
				html: true,
				confirmButtonColor: '#d9534f',
				showCancelButton: true,
			}, function() {
				window.location.href = getLink
			});
			return false;
		});
		$(".detail").click(function(e) {
			e.preventDefault();
			var kode_klaim = $(this).attr('data-id');
			var tgl_klaim = $(this).attr('data-tglklaim');
			var cabang = $(this).attr('data-cabang');
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>kaskecil/detailklaim',
				data: {
					kode_klaim: kode_klaim,
					tgl_klaim: tgl_klaim,
					cabang: cabang
				},
				cache: false,
				success: function(respond) {
					$("#detail").modal({
						backdrop: "static", //remove ability to close modal with click
						keyboard: false, //remove option to close with keyboard
						show: true //Display loader!
					});
					$("#loaddetail").html(respond);
				}
			});
		});

		$(".prosesklaim").click(function(e) {
			e.preventDefault();
			var kode_klaim = $(this).attr('data-id');
			var tgl_klaim = $(this).attr('data-tglklaim');
			var cabang = $(this).attr('data-cabang');
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>kaskecil/prosesklaim',
				data: {
					kode_klaim: kode_klaim,
					tgl_klaim: tgl_klaim,
					cabang: cabang
				},
				cache: false,
				success: function(respond) {
					$("#prosesklaim").modal({
						backdrop: "static", //remove ability to close modal with click
						keyboard: false, //remove option to close with keyboard
						show: true //Display loader!
					});
					$("#loadprosesklaim").html(respond);
				}
			});
		});

	});
</script>