<div class="container-fluid">
	<!-- Page title -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-auto">
				<h2 class="page-title">
				</h2>
			</div>
		</div>
	</div>
	<!-- Content here -->
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Chart Of Accounting</h4>
				</div>
				<div class="card-body">
					<a href="#" class="btn btn-danger waves-effect" id="tambahcoa"> Tambah Data </a>
					<hr>
					<div class="table-responsive">
						<table class="table " id="mytable">
							<thead>
								<tr>
									<th colspan="2">Nama Akun</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($coa as $r) {
									$cek = $this->db->get_where('coa', array('sub_akun' => $r->kode_akun))->num_rows();
									//echo $cek;
								?>
									<tr>
										<td><b><?php echo $r->kode_akun; ?></b></td>
										<td>
											<b><?php echo $r->nama_akun; ?></b>
											<?php
											if ($cek != 0) {
												$subheader = $this->db->get_where('coa', array('sub_akun' => $r->kode_akun))->result();
											?>
												<table class="table">
													<?php
													foreach ($subheader as $s) {
														$cek2 = $this->db->get_where('coa', array('sub_akun' => $s->kode_akun))->num_rows();
													?>
														<tr>
															<td style="width:10%"><b><?php echo $s->kode_akun; ?></b></td>
															<td>
																<b><?php echo $s->nama_akun; ?></b>
																<?php
																if ($cek2 != 0) {
																	$subheader2 = $this->db->get_where('coa', array('sub_akun' => $s->kode_akun))->result();
																?>
																	<table class="table ">
																		<?php
																		foreach ($subheader2 as $sh) {
																			$cek3 = $this->db->get_where('coa', array('sub_akun' => $sh->kode_akun))->num_rows();

																		?>
																			<tr>
																				<td style="width:15%"><b><?php echo $sh->kode_akun; ?></b></td>
																				<td>
																					<b><?php echo $sh->nama_akun; ?></b>
																					<?php
																					if ($cek3 != 0) {
																						$subheader3 = $this->db->get_where('coa', array('sub_akun' => $sh->kode_akun))->result();
																					?>
																						<table class="table ">
																							<?php
																							foreach ($subheader3 as $shh) {

																							?>
																								<tr>
																									<td style="width:15%"><?php echo $shh->kode_akun; ?></td>
																									<td><?php echo $shh->nama_akun; ?></td>
																									<td>
																										<a href="#" class="btn btn-xs btn-danger" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url(); ?>coa/hapus/<?php echo $shh->kode_akun; ?>"><i class="fa fa-trash"> </i></a>
																									</td>
																								</tr>
																							<?php } ?>
																						</table>
																					<?php } ?>
																				</td>
																				<td>

																					<a href="#" class="btn btn-xs btn-danger" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url(); ?>coa/hapus/<?php echo $sh->kode_akun; ?>"><i class="fa fa-trash"> </i></a>
																				</td>
																			</tr>
																		<?php } ?>
																	</table>
																<?php } ?>
															</td>
															<td>

																<a href="#" class="btn btn-xs btn-danger" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url(); ?>coa/hapus/<?php echo $s->kode_akun; ?>"><i class="fa fa-trash"> </i></a>
															</td>
														</tr>
													<?php } ?>
												</table>
											<?php
											}
											?>
										</td>
										<td>

											<a href="#" class="btn btn-xs btn-danger" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url(); ?>coa/hapus/<?php echo $r->kode_akun; ?>"><i class="fa fa-trash"> </i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!--------------------------------------INPUT DATA COA---------------------------------------->
<div class="modal fade" id="inputcoa" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">


		</div>
	</div>
</div>

<script type="text/javascript">
	$("#tambahcoa").click(function() {
		$("#inputcoa").modal("show");
		$(".modal-content").load("<?php echo base_url(); ?>coa/input_coa");
	});
	$(".editakun").click(function(e) {
		var kode_akun = $(this).attr("data-kodeakun");
		// alert(totalbayar);
		e.preventDefault();
		$("#inputcoa").modal("show");
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>Coa/edit_coa',
			data: {
				kode_akun: kode_akun
			},
			cache: false,
			success: function(respond) {
				$(".modal-content").html(respond);
			}
		});

	});
</script>