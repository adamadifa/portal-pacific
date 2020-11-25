<div class="container-fluid">
	<!-- Page title -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-auto">
				<h2 class="page-title">
					Buat Klaim
				</h2>
			</div>
		</div>
	</div>
	<!-- Content here -->
	<div class="row">
		<div class="col-md-10 col-xs-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Buat Klaim</h4>
				</div>
				<div class="card-body">
					<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>kaskecil/buatklaim" autocomplete="off">
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
					<form method="POST" autocomplete="off" id="klaim" action="<?php echo base_url(); ?>kaskecil/insert_klaim">
						<input type="hidden" name="cekprosesklaim" id="cekprosesklaim">
						<input type="hidden" name="cekvalidasi" id="cekvalidasi">
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="input-icon">
									<input type="date" id="tgl_klaim" name="tgl_klaim" class="form-control" placeholder="Tanggal Klaim" />
									<span class="input-icon-addon">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
						<div class="row mb-3">
							<div class="col-md-12">
								<div class="input-icon">
									<input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt2" />
									<span class="input-icon-addon">
										<i class="fa fa-file"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="mb-3 d-flex justify-content-end">
							<button type="submit" name="submit" class="btn btn-success btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>BUAT KLAIM</button>
						</div>
						<div class="table-responsive">
							<table class="table" style="font-size:12px">
								<thead class="thead-dark">
									<tr>
										<th>No</th>
										<th>Tanggal</th>
										<th>No Bukti</th>
										<th style="width:30%">Keterangan</th>
										<th>Akun</th>
										<th>Penerimaan</th>
										<th>Pengeluaran</th>
										<th>Saldo</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="7"><b>SALDO AWA</b>L</td>
										<td align="right" style="font-weight:bold"><?php if (!empty($saldoawal['saldo_awal'])) {
																																	echo number_format($saldoawal['saldo_awal'], '0', '', '.');
																																} ?></td>
										<td></td>
									</tr>
									<?php
									$jum 	 						= 0;
									$saldo						= $saldoawal['saldo_awal'];
									$totalpenerimaan  = 0;
									$totalpengeluaran = 0;
									$sno   = $row + 1;
									foreach ($result as $d) {
										if ($d['status_dk'] == 'K') {
											$penerimaan   = $d['jumlah'];
											$s 						= $penerimaan;
											$pengeluaran  = 0;
										} else {
											$penerimaan   = 0;
											$pengeluaran  = $d['jumlah'];
											$s 						= -$pengeluaran;
										}
										$saldo = $saldo;
										$totalpenerimaan 	= $totalpenerimaan + $penerimaan;
										$totalpengeluaran	= $totalpengeluaran + $pengeluaran;
									?>
										<tr>
											<td><?php echo $sno; ?></td>
											<td><?php echo DateToIndo2($d['tgl_kaskecil']); ?></td>
											<td><?php echo $d['nobukti']; ?></td>
											<td><?php echo $d['keterangan']; ?></td>
											<td><?php echo "<b>" . $d['kode_akun'] . "</b>" . " " . $d['nama_akun']; ?></td>
											<td align="right" style="color:green"><?php if (!empty($penerimaan)) {
																															echo number_format($penerimaan, '0', '', '.');
																														} ?></td>
											<td align="right" style="color:red"><?php if (!empty($pengeluaran)) {
																														echo number_format($pengeluaran, '0', '', '.');
																													} ?></td>
											<td align="right" style="color:black"><?php if (!empty($saldo)) {
																															echo number_format($saldo, '0', '', '.');
																														} ?></td>
											<td>
												<?php if (empty($d['kode_klaim'])) { ?>
													<label class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" value="<?php echo $d['id']; ?>" name="id[]">
														<span class="custom-control-label"></span>
													</label>
												<?php } else {
													echo "<b>" . $d['kode_klaim'] . "</b>";
												} ?>
											</td>
										</tr>
									<?php
										$sno++;
										$jum = $sno - 1;
									}
									echo "<input type='hidden' value ='$jum' name='n'>";
									?>
								</tbody>
								<tfooter>
									<tr>
										<th>TOTAL</th>
										<th colspan="4"></th>
										<td align="right" style="color:green; font-weight:bold"><?php if (!empty($totalpenerimaan)) {
																																							echo number_format($totalpenerimaan, '0', '', '.');
																																						} ?></td>
										<td align="right" style="color:red; font-weight:bold"><?php if (!empty($totalpengeluaran)) {
																																						echo number_format($totalpengeluaran, '0', '', '.');
																																					} ?></td>
										<td align="right" style="color:black; font-weight:bold"><?php if (!empty($saldo)) {
																																							echo number_format($saldo, '0', '', '.');
																																						} ?></td>
										<td></td>
									</tr>
								</tfooter>
							</table>
						</div>
						<div class="mb-3 d-flex justify-content-end">
							<button type="submit" name="submit" class="btn btn-success btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>BUAT KLAIM</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<?php $this->load->view('menu/menu_keuangan_administrator'); ?>
		</div>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		flatpickr(document.getElementById('dari'), {});
		flatpickr(document.getElementById('sampai'), {});
		flatpickr(document.getElementById('tgl_klaim'), {});
	});
</script>
<script type="text/javascript">
	$(function() {
		function cekprosesklaim() {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>kaskecil/cekprosesklaim',
				cache: false,
				success: function(respond) {
					$("#cekprosesklaim").val(respond);
				}
			});
		}

		function cekvalidasi() {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>kaskecil/cekvalidasi',
				cache: false,
				success: function(respond) {
					$("#cekvalidasi").val(respond);
				}
			});
		}
		cekprosesklaim();
		cekvalidasi();

		$("#klaim").submit(function() {
			var tgl_klaim = $("#tgl_klaim").val();
			var keterangan = $("#keterangan").val();
			var cekprosesklaim = $("#cekprosesklaim").val();
			var cekvalidasi = $("#cekvalidasi").val();
			if (tgl_klaim == "") {
				swal("Oops!", "Tanggal Klaim Masih Kosong!", "warning");
				$("#tgl_klaim").focus()
				return false;
			} else if (keterangan == "") {
				swal("Oops!", "Keterangan Masih Kosong!", "warning");
				$("#keterangan").focus()
				return false;
			} else if (cekprosesklaim == "1") {
				swal("Oops!", "Klaim Sebelumnya Belum di Proses!", "warning");
				$("#cekprosesklaim").focus()
				return false;
			} else if (cekvalidasi == "1") {
				swal("Oops!", "Klaim Sebelumnya Belum di Validasi!", "warning");
				$("#cekvalidasi").focus()
				return false;
			} else {
				return true;
			}
		});
	});
</script>