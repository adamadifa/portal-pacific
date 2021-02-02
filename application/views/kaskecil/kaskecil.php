<div class="container-fluid">
	<!-- Page title -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-auto">
				<h2 class="page-title">
					Kas Kecil
				</h2>
			</div>
		</div>
	</div>
	<!-- Content here -->
	<div class="row">
		<div class="col-md-10 col-xs-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Kas Kecil</h4>
				</div>
				<div class="card-body">
					<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>kaskecil" autocomplete="off">
						<div class="mb-3">
							<input ype="text" id="nobukti" name="nobukti" value="<?php echo $nobukti; ?>" class="form-control" placeholder="No Bukti" />
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
												<line x1="12" y1="15" x2="12" y2="18" />
											</svg>
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
												<line x1="12" y1="15" x2="12" y2="18" />
											</svg>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="mb-3 d-flex justify-content-end">
							<button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
						</div>
					</form>
					<a href="#" class="btn btn-danger" id="tambahkaskecil"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
					<?php if ($ceksaldoawal < 1) { ?>
						<a href="#" class="btn btn-success" id="inputsaldoawal">Input Saldo Awal</a>
					<?php } ?>
					<hr>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" style="font-size:11px">
							<thead class="thead-dark">
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>No Bukti</th>
									<th>Keterangan</th>
									<th>Akun</th>
									<th>Penerimaan</th>
									<th>Pengeluaran</th>
									<th>Saldo</th>
									<?php if ($this->session->userdata('cabang') == "pusat") { ?>
										<th>Peruntukan</th>
									<?php } ?>
									<th>CR</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="7"><b>SALDO AWAL</b>L</td>
									<td align="right" style="font-weight:bold"><?php if (!empty($saldoawal['saldo_awal'])) {
																																echo number_format($saldoawal['saldo_awal'], '0', '', '.');
																															} ?></td>
									<td></td>
									<td></td>
								</tr>
								<?php
								$saldo 						= $saldoawal['saldo_awal'];
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

									$saldo = $saldo + $s;

									$totalpenerimaan 	= $totalpenerimaan + $penerimaan;
									$totalpengeluaran	= $totalpengeluaran + $pengeluaran;
									if ($d['no_ref'] != "") {
										$color = "#6db5c3";
										$text = "white";
									} else {
										$color = "";
										$text = "";
									}
								?>
									<tr style="background-color:<?php echo $color;  ?>; color:<?php echo $text; ?>">
										<td><?php echo $sno; ?></td>
										<td><?php echo DateToIndo2($d['tgl_kaskecil']); ?></td>
										<td><?php echo $d['nobukti']; ?></td>
										<td>
											<?php echo $d['keterangan']; ?>
										</td>
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
										<?php if ($this->session->userdata('cabang') == "pusat") { ?>
											<td><?php echo $d['peruntukan']; ?></td>
										<?php } ?>
										<td>
											<?php if (!empty($d['kode_cr'])) { ?>
												<span class="badge bg-green">CR</span>
											<?php } ?>
										</td>
										<td>
											<?php if (empty($d['kode_klaim']) and $d['keterangan'] != 'Penerimaan Kas Kecil') {
												if (empty($d['no_ref'])) {
											?>
													<a href="#" data-status="0" data-id="<?php echo $d['id'] ?>" data-kodecr="<?php echo $d['kode_cr']; ?>" class="btn btn-success btn-sm edit"><i class="fa fa-pencil"></i></a>
													<a href="#" data-href="<?php echo base_url(); ?>kaskecil/hapus_kaskkecil/<?php echo $d['id']; ?>/<?php echo $d['kode_cr']; ?>" class="btn btn-danger btn-sm hapuskk"><i class="fa fa-trash-o"></i></a>
												<?php
												}
											} else {
												?>
												<a href="#" data-status="1" data-id="<?php echo $d['id'] ?>" data-kodecr="<?php echo $d['kode_cr']; ?>" class="btn btn-success btn-sm edit"><i class="fa fa-pencil"></i></a>
											<?php } ?>
										</td>
									</tr>
								<?php
									$sno++;
								}
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
									<td></td>
								</tr>
							</tfooter>
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
<div class="modal modal-blur fade" id="inputkaskecil" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">Input Kas Kecil</h5>
			</div>
			<div class="modal-body">
				<div id="loadinputkaskecil"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" id="editkaskecil" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">Edit Kas Kecil</h5>
			</div>
			<div class="modal-body">
				<div id="loadeditkaskecil"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-title">
					Yakin Untuk Di Hapus ?
				</div>
				<div>Jika Di Hapus, Kamu Akan Kehilangan Data Ini !</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger delete">Yes, Hapus !</a>
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

<script>
	$(function() {
		$("#tambahkaskecil").click(function() {
			$("#inputkaskecil").modal({
				backdrop: "static", //remove ability to close modal with click
				keyboard: false, //remove option to close with keyboard
				show: true //Display loader!
			});
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>kaskecil/inputkaskecil',
				cache: false,
				success: function(respond) {
					$('#loadinputkaskecil').html(respond);
				}
			});
		});

		$(".hapuskk").click(function(e) {
			e.preventDefault();
			var href = $(this).attr("data-href");
			//alert(href);
			$("#hapusdata").modal({
				backdrop: "static", //remove ability to close modal with click
				keyboard: false, //remove option to close with keyboard
				show: true //Display loader!
			});
			$(".delete").attr("href", href);
		});

		$(".edit").click(function(e) {
			e.preventDefault();
			var id = $(this).attr("data-id");
			var kodecr = $(this).attr("data-kodecr");
			var status = $(this).attr("data-status");
			$("#editkaskecil").modal({
				backdrop: "static", //remove ability to close modal with click
				keyboard: false, //remove option to close with keyboard
				show: true //Display loader!
			});
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>kaskecil/editkaskecil',
				data: {
					id: id,
					status: status,
					kodecr: kodecr
				},
				cache: false,
				success: function(respond) {
					//console.log(respond);
					$('#loadeditkaskecil').html(respond);

				}
			});
		});
	})
</script>