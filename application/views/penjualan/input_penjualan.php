<form name="autoSumForm" autocomplete="off" class="formValidate form-horizontal" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/input_penjualan">
	<input type="hidden" id="cekbarang">
	<input type="hidden" id="ttr">
	<div class="container-fluid">
		<!-- Page title -->
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col-auto">
					<h2 class="page-title">
						Data Penjualan
					</h2>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-10">
					<!-- Content here -->
					<div class="row">
						<div class="col-md-5 col-xs-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Data Penjualan</h4>
								</div>
								<div class="card-body">
									<div class="form-group mb-3">
										<div class="input-icon">
											<span class="input-icon-addon">
												<i class="fa fa-barcode"></i>
											</span>
											<input id="nofaktur" name="nofaktur" class="form-control" placeholder="No Faktur">
										</div>
									</div>
									<div class="form-group mb-3">
										<div class="input-icon">
											<span class="input-icon-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<input type="date" value="<?php echo date('Y-m-d'); ?>" id="tgltransaksi" name="tgltransaksi" class="form-control" placeholder="Tanggal Transaksi">
										</div>
									</div>
									<div class="form-group mb-3">
										<div class="input-icon">
											<span class="input-icon-addon">
												<i class="fa fa-user"></i>
											</span>
											<input type="hidden" readonly id="kodepelanggan" name="kodepelanggan" class="form-control" />
											<input type="text" readonly id="pelanggan" name="pelanggan" class="form-control" placeholder="Pelanggan">
										</div>
									</div>
									<div class="form-group mb-3">
										<div class="input-icon">
											<span class="input-icon-addon">
												<i class="fa fa-users"></i>
											</span>
											<input type="hidden" id="kodesales" name="kodesales" class="form-control" />
											<input type="text" id="salesman" disabled name="salesman" class="form-control" placeholder="Salesman">
										</div>
									</div>
									<div class="form-group mb-3">
										<div class="input-icon">
											<span class="input-icon-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" readonly id="limitpelanggan" name="limitpelanggan" class="form-control" placeholder="Limit Pelanggan">
										</div>
									</div>
									<div class="form-group mb-3">
										<div class="input-icon">
											<span class="input-icon-addon">
												<i class="fa fa-hourglass-start"></i>
											</span>
											<input ype="text" readonly id="sisapiutang" name="sisapiutang" class="form-control" placeholder="Piutang Pelanggan">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-7 col-xs-12">
							<div class="row">
								<div class="col-md-12">
									<div class="card card-sm">
										<div class="card-body d-flex align-items-center">
											<span class="bg-blue text-white stamp mr-3" style="height:9rem !important; min-width:8rem !important ">
												<i class="fa f fa-shopping-cart" style="font-size: 4rem;"></i>
											</span>
											<div class="ml-3 lh-lg">
												<div class="strong" style="font-size: 3rem;" id="grandtotal">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="card" style="height:220px" id="loadfoto">
									</div>
								</div>
								<div class="col-md-9">
									<div class="card" style="height:220px">
										<div id="loaddatapelanggan">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-icon">
													<span class="input-icon-addon">
														<i class="fa fa-barcode"></i>
													</span>
													<input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang" />
													<input type="text" style="min-height:5rem !important" readonly id="barang" name="barang" class="form-control" placeholder="Barang">
													<input type="hidden" readonly id="kodecabang" name="kodecabang" class="form-control" placeholder="Kode Cabang" />
													<input type="hidden" readonly id="stok" name="stok" class="form-control" placeholder="Stok" />
													<input type="hidden" readonly id="cekttrpel" name="cekttrpel" class="form-control" placeholder="Stok" />
													<input type="hidden" readonly id="cekttrjml" name="cekttrjml" class="form-control" placeholder="Stok" />
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row mb-2">
												<div class="form-group">
													<div class="input-icon">
														<span class="input-icon-addon">
															<i class="fa fa-balance-scale"></i>
														</span>
														<input type="text" style="text-align:center" value="0" id="jmldus" name="jmldus" class="form-control" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<div class="input-icon">
														<span class="input-icon-addon">
															<i class="fa fa-dollar"></i>
														</span>
														<input style="text-align:right; font-weight: bold" type="text" id="hargadus" name="hargadus" class="form-control" placeholder="Harga" />
													</div>
												</div>
											</div>
											<input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcsdus" name="isipcsdus" class="form-control" />
											<input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcspack" name="isipcspack" class="form-control" />
										</div>
										<div class="col-md-2" id="pack">
											<div class="row mb-2">
												<div class="form-group">
													<div class="input-icon">
														<span class="input-icon-addon">
															<i class="fa fa-balance-scale"></i>
														</span>
														<input type="text" style="text-align:center" value="0" id="jmlpack" name="jmlpack" class="form-control" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<div class="input-icon">
														<span class="input-icon-addon">
															<i class="fa fa-dollar"></i>
														</span>
														<input style="text-align:right; font-weight: bold" type="text" id="hargapack" name="hargapack" class="form-control" placeholder="Harga / Pack" />
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row mb-2">
												<div class="form-group">
													<div class="input-icon">
														<span class="input-icon-addon">
															<i class="fa fa-balance-scale"></i>
														</span>
														<input type="text" style="text-align:center" value="0" id="jmlpcs" name="jmlpcs" class="form-control" placeholder="Jumlah Pcs" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="form-group">
													<div class="input-icon">
														<span class="input-icon-addon">
															<i class="fa fa-dollar"></i>
														</span>
														<input style="text-align:right; font-weight: bold" type="text" id="hargapcs" name="hargapcs" class="form-control" placeholder="Harga / Pcs" />
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="row mb-3">
												<div class="form-group">
													<input class="form-check-input" type="checkbox" id="promo" name="promo" value="1">
													<span class="form-check-label">Promo</span>
												</div>
											</div>
											<div class="row">
												<a href="#" id="tambahbarang" class="btn btn-primary">
													<i class="fa  fa-cart-plus mr-2"></i>
													Tambah
												</a>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="table-responsive">
											<table class="table table-bordered table-striped table-hover" id="detailbarang">
												<thead class="thead-dark">
													<tr>
														<th>Kode Barang</th>
														<th>Nama Barang</th>
														<th>Jml Dus</th>
														<th>Harga Dus</th>
														<th>Jml Pack</th>
														<th>Harga Pack</th>
														<th>Jml Pcs</th>
														<th>Harga Pcs</th>
														<th>Subtotal</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody id="loadpnjtmp">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-xs-12 ">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Potongan</h4>
								</div>
								<div class="card-body">
									<div class="input-group mb-2">
										<span class="input-group-text">
											AIDA
										</span>
										<input type="text" class="form-control text-right" id="potaida" name="potaida" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
									<!-- <label class="form-label col-5 col-form-label">SWAN</label> -->
									<div class="input-group mb-2">
										<span class="input-group-text">
											SWAN
										</span>
										<input type="text" class="form-control text-right" id="potswan" name="potswan" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
									<!-- <label class="form-label col-5 col-form-label">STICK</label> -->
									<div class="input-group mb-2">
										<span class="input-group-text">
											STICK
										</span>
										<input type="text" class="form-control text-right" id="potstick" name="potstick" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-xs-12 ">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Potongan Istimewa</h4>
								</div>
								<div class="card-body">
									<!-- <label class="form-label col-5 col-form-label">AIDA</label> -->
									<div class="input-group mb-2">
										<span class="input-group-text">
											AIDA
										</span>
										<input type="text" class="form-control text-right" id="potisaida" name="potisaida" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
									<!-- <label class="form-label col-5 col-form-label">SWAN</label> -->
									<div class="input-group mb-2">
										<span class="input-group-text">
											SWAN
										</span>
										<input type="text" class="form-control text-right" id="potisswan" name="potisswan" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
									<!-- <label class="form-label col-5 col-form-label">STICK</label> -->
									<div class="input-group mb-2">
										<span class="input-group-text">
											STICK
										</span>
										<input type="text" class="form-control text-right" id="potisstick" name="potisstick" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-xs-12 ">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Penyesuaian Harga</h4>
								</div>
								<div class="card-body">
									<div class="input-group mb-2">
										<span class="input-group-text">
											AIDA
										</span>
										<input type="text" class="form-control text-right" id="penyaida" name="penyaida" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
									<!-- <label class="form-label col-5 col-form-label">SWAN</label> -->
									<div class="input-group mb-2">
										<span class="input-group-text">
											SWAN
										</span>
										<input type="text" class="form-control text-right" id="penyswan" name="penyswan" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>
									<!-- <label class="form-label col-5 col-form-label">STICK</label> -->
									<div class="input-group mb-2">
										<span class="input-group-text">
											STICK
										</span>
										<input type="text" class="form-control text-right" id="penystick" name="penystick" value="0">
										<span class="input-group-text">
											<i class="fa fa-money"></i>
										</span>
									</div>

								</div>
							</div>
						</div>
						<div class="col-md-3 col-xs-12 ">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Total & Pembayaran</h4>
								</div>
								<div class="card-body">
									<div class="row mb-3">
										<div class="col-md-12">
											<div class="form-group">
												<select id="jenistransaksi" name="jenistransaksi" class="form-select">
													<option value="">-- Pilih Jenis Transaksi --</option>
													<option value="tunai">Tunai</option>
													<option value="kredit">Kredit</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-md-12">
											<div class="form-group">
												<select id="jenisbayar" name="jenisbayar" class="form-select">
													<option value="">-- Pilih Jenis Pembayaran --</option>
												</select>
											</div>
										</div>
									</div>



									<!-- <label class="form-label col-4 col-form-label">Total</label> -->
									<div class="row mb-2">
										<div class="form-group col">
											<div class="input-icon">
												<span class="input-icon-addon">
													<i class="fa fa-money"></i>
												</span>
												<input type="text" readonly style="text-align:right; font-weight: bold" id="totalbayar" name="totalbayar" value="0" class="form-control" onkeyup="calc()" placeholder="Total">
											</div>
										</div>
									</div>
									<div id="Bjatuhtempo">
										<!-- <label class="form-label col-4 col-form-label">Jatuh Tempo</label> -->
										<div class="row mb-2">
											<div class="form-group col">
												<div class="input-icon">
													<span class="input-icon-addon">
														<i class="fa fa-calendar"></i>
													</span>
													<input type="text" style="text-align:right" id="jatuhtempo" name="jatuhtempo" class="datepicker form-control date" placeholder="Jatuh Tempo">
												</div>
											</div>
										</div>
									</div>
									<div id="Btitipan">
										<!-- <label class="form-label col-4 col-form-label">Titipan</label> -->
										<div class="row mb-2">
											<div class="form-group col">
												<div class="input-icon">
													<span class="input-icon-addon">
														<i class="fa fa-money"></i>
													</span>
													<input type="text" value="0" style="text-align:right" id="titipan" name="titipan" class=" form-control" placeholder="Titipan">
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<div class="form-group d-flex justify-content-end">
							<button type="submit" name="submit" class="btn btn-block btn-primary"><i class="fa fa-send-o mr-2"></i> SIMPAN</button>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<?php $this->load->view('menu/menu_penjualan_administrator'); ?>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="modal modal-blur fade" id="datapelanggan" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">Data Pelanggan</h5>
			</div>
			<div class="modal-body">

				<table class="table table-bordered table-striped table-hover" style="width:100% !important" id="mytable">
					<thead class="thead-dark">
						<tr>
							<th>No</th>
							<th>Kode Pelanggan</th>
							<th>Nama Pelanggan</th>
							<th>No HP</th>
							<th>Pasar</th>
							<th>Cabang</th>
							<th>Salesman</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-blur fade" id="databarang" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title">Data Barang</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<div id="loadBarang"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		$('#potaida,#potswan,#potstick,#potisaida,#potisswan,#potisstick,#penyaida,#penystick,#penyswan').maskMoney();

		$('#angka3').maskMoney({
			thousands: '.',
			decimal: ',',
			precision: 0,
			allowNegative: true,

		});
		//LoadForm
		kosong();
		loadDataTmp();
		hitungjatuhtempo();
		hitungdiskon();
		//terbilangtotalbayar();
		//loadDatagbTmp();
		cekbarang();
		//Load Foto Pelanggan
		function loadfoto() {
			var kodepelanggan = $("#kodepelanggan").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/loadfoto',
				data: {
					kodepelanggan: kodepelanggan
				},
				cache: false,
				success: function(respond) {
					$("#loadfoto").html(respond);
				}
			});
		}

		// Load Data Pelanggan
		function loaddatapelanggan() {
			var kodepelanggan = $("#kodepelanggan").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/loaddatapelanggan',
				data: {
					kodepelanggan: kodepelanggan
				},
				cache: false,
				success: function(respond) {
					$("#loaddatapelanggan").html(respond);
				}
			});
		}

		function loadDataTmp() {
			$("#loadpnjtmp").load("<?php echo base_url(); ?>penjualan/view_detailtmp");
		}
		//Show Data Pelanggan
		$("#pelanggan").click(function() {
			$("#datapelanggan").modal({
				backdrop: "static", //remove ability to close modal with click
				keyboard: false, //remove option to close with keyboard
				show: true //Display loader!
			});
		});
		//Menentukan Jatuh Tempo
		function hitungjatuhtempo() {
			var tgltransaksi = $("#tgltransaksi").val();
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url(); ?>penjualan/hitungjatuhtempo",
				data: {
					tgltransaksi: tgltransaksi
				},
				cache: false,
				success: function(respond) {
					$("#jatuhtempo").val(respond);
				}
			});
		}
		// Menghitung diskon
		function hitungdiskon() {
			var nofaktur = $("#nofaktur").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/hitungdiskon',
				data: {
					nofaktur: nofaktur
				},
				cache: false,
				success: function(respond) {
					var result = respond.split("|");
					$("#potaida").val(result[1]);
					$("#potswan").val(result[0]);
				}
			});
		}
		// Cek Barang Penjualan
		function cekbarang() {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/cekbarangpenjualan',
				cache: false,
				success: function(respond) {
					console.log(respond);
					$("#cekbarang").val(respond);
				}
			});
		}

		// Reset Form
		function kosong() {
			$("#Bjatuhtempo").hide();
			$("#Btitipan").hide();
		}

		function showTitipan() {
			$("#Bjatuhtempo").show();
			$("#Btitipan").show();
		}


		function showTunai() {
			$("#Bbayar").hide();
			$("#Bjatuhtempo").hide();
			$("#Btitipan").hide();
		}

		function ResetBrg() {
			$("#kodebarang").val("");
			$("#barang").val("");
			$("#hargadus").val("");
			$("#hargapack").val("");
			$("#hargapcs").val("");
			$("#stokdus").val("");
			$("#stokpcs").val("");
			$("#stok").val("");
			$("#isipcsdus").val("");
			$("#isipcspack").val("");
			$("#stokpack").val("");
			$("#jmlpcs").val(0);
			$("#jmlpack").val(0);
			$("#jmldus").val(0);
		}

		// Hitung Jatuh Tempo Dari Tanggal Transaksi
		$("#tgltransaksi").change(function() {
			hitungjatuhtempo();
		});

		// Cek Jenis Transaksi
		$("#jenistransaksi").change(function() {
			var jt = $("#jenistransaksi").val();

			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/jenistransaksi',
				data: {
					jt: jt
				},
				cache: false,
				success: function(respond) {
					console.log(respond);
					kosong();
					$("#jenisbayar").html(respond);
				}
			});
		});

		$("#jenisbayar").change(function() {
			var jenisbayar = $("#jenisbayar").val();
			var jenistransaksi = $("#jenistransaksi").val();
			if (jenisbayar == "titipan") {
				showTitipan();
			} else if (jenisbayar == "giro") {
				showGiro();
				if (jenistransaksi == "tunai") {
					$("#jml").val($("#totalbayar").val());
					//terbilangjml();
				} else {
					$("#jml").val(0);
					//terbilangjml();
				}
			} else if (jenisbayar == "transfer") {
				showTransfer();
				if (jenistransaksi == "tunai") {
					$("#jml").val($("#totalbayar").val());
					//terbilangjml();
				} else {
					$("#jml").val(0);
					//terbilangjml();
				}
			} else if (jenisbayar == "tunai") {
				showTunai();
			} else {
				kosong();
			}
		});

		//Pilih Barang
		$("#barang").click(function() {
			var limit = $("#limitpelanggan").val();
			var sisapiutang = $("#sisapiutang").val();
			var kodecabang = $("#kodecabang").val();
			var pelanggan = $("#pelanggan").val();
			//alert(limit);
			if (pelanggan == "") {
				swal("Oops!", "Nama Pelanggan Harus Diisi Terlebih Dahulu !", "warning");
				$("#pelanggan").focus();
			} else {
				$("#databarang").modal("show");
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>barang/view_barangcab',
					data: {
						kodecabang: kodecabang
					},
					cache: false,
					success: function(respond) {
						//alert(kodecabang);
						$("#loadBarang").html(respond);
					}
				});
			}
		});


		//Cek Punya Satuan Pack
		$("#kodebarang").change(function() {
			var id = $("#kodebarang").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/get_barang',
				data: {
					kodebarang: id
				},
				cache: false,
				success: function(respond) {
					data = respond.split("|");
					$("#satuan").val(data[0]);
					$("#hargadus").val(data[1]);
					$("#hargapack").val(data[2]);
					$("#hargapcs").val(data[3]);
					var hargapack = $("#hargapack").val();
					if (hargapack == 0) {
						$("#pack").hide();
					} else {
						$("#pack").show();
					}
				}
			});
		});

		//Tambah Detail Barang
		$("#tambahbarang").click(function(e) {
			var kodebarang = $("#kodebarang").val();
			var jmldus = $("#jmldus").val();
			var hargadus = $("#hargadus").val();
			var jmlpack = $("#jmlpack").val();
			var hargapack = $("#hargapack").val();
			var jmlpcs = $("#jmlpcs").val();
			var hargapcs = $("#hargapcs").val();
			var isipcsdus = $("#isipcsdus").val();
			var isipcspack = $("#isipcspack").val();
			var stok = $("#stok").val();
			var pelanggan = $("#pelanggan").val();
			if (stok != "") {
				stok = $("#stok").val();
			} else {
				stok = 0;
			}
			if ($('#promo').is(":checked")) {
				var promo = $("#promo").val();
			} else {
				var promo = '';
			}
			var jumlahpcs = (jmldus * isipcsdus) + (jmlpack * isipcspack) + (jmlpcs * 1);
			e.preventDefault();
			if (kodebarang == "") {
				swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
			} else if (jmldus == 0 && jmlpack == 0 && jmlpcs == 0) {
				swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
			} else {
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>penjualan/insert_detailtmp',
					data: {
						kodebarang: kodebarang,
						jmldus: jmldus,
						hargadus: hargadus,
						jmlpack: jmlpack,
						hargapack: hargapack,
						jmlpcs: jmlpcs,
						hargapcs: hargapcs,
						promo: promo,
						pelanggan: pelanggan

					},
					cache: false,
					success: function(respond) {
						console.log(respond);
						ResetBrg();
						loadDataTmp();
						hitungdiskon();
						cekbarang();
						//loadttr();
						//cekttrjml();
					}
				});
			}
		});

		// CEK NO FAKTU YANG SAMA

		$("#nofaktur").on('keyup keydown change', function(e) {
			if (e.keyCode == 32) return false;
			var nofaktur = $("#nofaktur").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/ceknofaktur',
				data: {
					nofaktur: nofaktur
				},
				cache: false,
				success: function(respond) {
					var status = respond;
					if (status != 0) {
						swal("Oops!", "No Faktur " + nofaktur + " Sudah Digunakan !", "warning");
						$("#nofaktur").val("");
					}
				}
			});
		});


		//CekTutupLaporan

		function cektutuplaporan() {
			var tgltransaksi = $("#tgltransaksi").val();
			var jenis = 'penjualan';
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>setting/cektutuplaporan',
				data: {
					tanggal: tgltransaksi,
					jenis: jenis
				},
				cache: false,
				success: function(respond) {
					console.log(respond);
					var status = respond;
					if (status != 0) {
						swal("Oops!", "Laporan Untuk Periode Ini Sudah Di Tutup !", "warning");
						$("#tgltransaksi").val("");
					}
				}
			});
		}

		cektutuplaporan();

		$("#tgltransaksi").change(function() {
			cektutuplaporan();
		});

		$("form").submit(function() {
			//e.preventDefault();
			var nofaktur = $("#nofaktur").val();
			var tgltransaksi = $("#tgltransaksi").val();
			var pelanggan = $("#kodepelanggan").val();
			var jenistransaksi = $("#jenistransaksi").val();
			var jenisbayar = $("#jenisbayar").val();
			var nogiro = $("#nogiro").val();
			var materai = $("#materai").val();
			var namabank = $("#namabank").val();
			var tglcair = $("#tglcair").val();
			var jml = $("#jml").val();
			var totalbayar = $("#totalbayar").val();
			var titipan = $("#titipan").val();
			var cekttrpel = $("#cekttrpel").val();
			var datattr = $("#datattr").val();
			var pelanggan = $("#pelanggan").val();
			var cekbarang = $("#cekbarang").val();
			var ttr = $("#ttr").val();
			var cekttrjml = $("#cekttrjml").val();
			var tglgiro = $("#tglgiro").val();
			var limit = $("#limitpelanggan").val();
			var sisapiutang = $("#sisapiutang").val();
			var total = totalbayar.replace(/\./g, '');
			var totalpiutang = parseInt(sisapiutang) + parseInt(total);
			//alert(totalpiutang);
			//return false;
			if (nofaktur == "") {
				swal("Oops!", "No Faktur Harus Diisi !", "warning");
				//$("#nofaktur").focus();
				return false;
			}
			// else if(limit==0 && jenistransaksi=='kredit'){
			// 	swal("Oops!", "Limit Kedit Pelanggan Belum Diisi !, Silahkan Hubungi Tim Pusat", "warning");
			// 	return false;
			// }else if(totalpiutang>=limit  && jenistransaksi=='kredit')
			// {
			// 	swal("Oops!", "Pelanggan Melebihi Batas Limit Kredit  ! Limit Kredit :"+limit +" Piutang : "+sisapiutang, "warning");
			// 	return false;
			// }
			else if (tgltransaksi == "") {
				swal("Oops!", "Tanggal Transaksi Harus Diisi !", "warning");
				return false;
			} else if (pelanggan == "") {
				swal("Oops!", "Pelanggan Harus Diisi !", "warning");
				return false;
			} else if (jenistransaksi == "") {
				swal("Oops!", "Jenis Transaksi Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "") {
				swal("Oops!", "Jenis Bayar Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "giro" && nogiro == "") {
				swal("Oops!", "No Giro Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "giro" && tglgiro == "") {
				swal("Oops!", "Tanggal Penerimaan Giro Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "giro" && materai == "") {
				swal("Oops!", "Materai Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "giro" && namabank == "") {
				swal("Oops!", "Bank Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "giro" && tglcair == "") {
				swal("Oops!", "Tanggal Jatuh Tempo Harus Diisi !", "warning");
				return false;
			} else if (jenistransaksi == "tunai" && jenisbayar == "giro" && jml != totalbayar) {
				swal("Oops!", "Jumlah Tidak Sama Dengan Total Bayar Silahkan Klik Form Jumlah Agar Jumlah Menyesuaikan dengan Total Bayar !", "warning");
				return false;
			} else if (jenisbayar == "transfer" && namabank == "") {
				swal("Oops!", "Bank Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "transfer" && tglgiro == "") {
				swal("Oops!", "Tanggal Penerimaan Harus Diisi !", "warning");
				return false;
			} else if (jenisbayar == "transfer" && tglcair == "") {
				swal("Oops!", "Tanggal Jatuh Tempo Harus Diisi !", "warning");
				return false;
			} else if (jenistransaksi == "tunai" && jenisbayar == "transfer" && jml != totalbayar) {
				swal("Oops!", "Jumlah Tidak Sama Dengan Total Bayar Silahkan Klik Form Jumlah Agar Jumlah Menyesuaikan dengan Total Bayar !", "warning");
				return false;
			} else if (jenistransaksi == "kredit" && jenisbayar == "titipan" && (titipan * 1) > (totalbayar * 1)) {
				swal("Oops!", "Jumlah titipan Melebihi Total Bayar !", "warning");
				return false;
			} else if (jenistransaksi == "kredit" && jenisbayar == "giro" && (jml * 1) > (totalbayar * 1)) {
				swal("Oops!", "Jumlah Bayar Melebihi Total Bayar !", "warning");
				return false;
			} else if (jenistransaksi == "kredit" && jenisbayar == "transfer" && (jml * 1) > (totalbayar * 1)) {
				swal("Oops!", "Jumlah Bayar Melebihi Total Bayar !", "warning");
				return false;
			} else if (cekttrpel > 0 && datattr == "") {
				swal("Oops!", "Anda Memiliki TTR Yang Belum Difakturkan !", "warning");
				return false;
			} else if (cekbarang < 1 && pelanggan != "BATAL") {
				swal("Oops!", "Data Barang Masih Kosong !", "warning");
				return false;
			} else if (ttr == 1) {
				swal("Oops!", "Jumlah Penjualan Tidak Sesuai Mohon Cek Kembali!", "warning");
				return false;
			} else if (cekttrjml == 1) {
				swal("Oops!", "Jumlah Penjualan Kurang Dari TTR!", "warning");
				return false;
			} else {
				return true;
			}

		});

		//Datatables Pelanggan
		$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};

		var t = $("#mytable").dataTable({
			initComplete: function() {
				var api = this.api();
				$('#mytable_filter input').off('.DT').on('keyup.DT', function(e) {
					if (e.keyCode == 13) {
						api.search(this.value).draw();
					}
				});
			},
			oLanguage: {
				sProcessing: "loading..."
			},
			processing: true,
			serverSide: true,
			bLengthChange: false,
			ajax: {
				"url": "<?php echo base_url(); ?>penjualan/jsonPelanggan",
				"type": "POST"
			},
			columns: [{
					"data": "kode_pelanggan",
					"orderable": false
				},
				{
					"data": "kode_pelanggan"
				},
				{
					"data": "nama_pelanggan"
				},
				{
					"data": "no_hp"
				},
				{
					"data": "pasar"
				},
				{
					"data": "nama_cabang"
				},
				{
					"data": "nama_karyawan"
				},
				{
					"data": "view"
				}
			],
			order: [
				[1, 'desc']
			],
			rowCallback: function(row, data, iDisplayIndex) {
				var info = this.fnPagingInfo();
				var page = info.iPage;
				var length = info.iLength;
				var index = page * length + (iDisplayIndex + 1);
				$('td:eq(0)', row).html(index);
			}


		});

		$('#mytable tbody').on('click', 'a', function() {
			$("#kodepelanggan").val($(this).attr("data-kodepel"));
			$("#pelanggan").val($(this).attr("data-namapel"));
			$("#kodesales").val($(this).attr("data-kodesales"));
			$("#salesman").val($(this).attr("data-namasales"));
			$("#kodecabang").val($(this).attr("data-cabang"));
			$("#limitpelanggan").val($(this).attr("data-limit"));
			$("#datapelanggan").modal("hide");
			loadfoto();
			loaddatapelanggan();
			var pelanggan = $(this).attr("data-kodepel");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>penjualan/cekpiutangpelanggan',
				data: {
					pelanggan: pelanggan
				},
				cache: false,
				success: function(respond) {
					console.log(respond);
					$("#sisapiutang").val(respond);
				}
			});
		});
	});
</script>
<script type="text/javascript">
	startCalc();

	function startCalc() {
		interval = setInterval("calc()", 1)
	}
	// var pot = document.getElementById('potongan');
	// var potis = document.getElementById('potistimewa');
	// var peny = document.getElementById('penyharga');

	// var pot_aida = document.getElementById('potaida');
	// var pot_swan = document.getElementById('potswan');
	// var pot_stick = document.getElementById('potstick');

	// var potis_aida = document.getElementById('potisaida');
	// var potis_swan = document.getElementById('potisswan');
	// var potis_stick = document.getElementById('potisstick');


	// var peny_aida = document.getElementById('penyaida');
	// var peny_swan = document.getElementById('penyswan');
	// var peny_stick = document.getElementById('penystick');

	// var titip = document.getElementById('titipan');


	// //Potongan
	// pot_aida.addEventListener('keyup', function(e) {
	// 	pot_aida.value = formatRupiah(this.value, '');
	// });
	// pot_swan.addEventListener('keyup', function(e) {
	// 	pot_swan.value = formatRupiah(this.value, '');
	// });
	// pot_stick.addEventListener('keyup', function(e) {
	// 	pot_stick.value = formatRupiah(this.value, '');
	// });

	// potis_aida.addEventListener('keyup', function(e) {
	// 	potis_aida.value = formatRupiah(this.value, '');
	// });
	// potis_swan.addEventListener('keyup', function(e) {
	// 	potis_swan.value = formatRupiah(this.value, '');
	// });
	// potis_stick.addEventListener('keyup', function(e) {
	// 	potis_stick.value = formatRupiah(this.value, '');
	// });

	// peny_aida.addEventListener('keyup', function(e) {
	// 	peny_aida.value = formatRupiah(this.value, '');
	// });
	// peny_swan.addEventListener('keyup', function(e) {
	// 	peny_swan.value = formatRupiah(this.value, '');
	// });
	// peny_stick.addEventListener('keyup', function(e) {
	// 	peny_stick.value = formatRupiah(this.value, '');
	// });

	// // pot.addEventListener('keyup', function(e) {
	// // 	pot.value = formatRupiah(this.value, '');
	// // });
	// // potis.addEventListener('keyup', function(e) {
	// // 	potis.value = formatRupiah(this.value, '');
	// // });
	// // peny.addEventListener('keyup', function(e){
	// //   peny.value = formatRupiah(this.value, '');
	// // });
	// titipan.addEventListener('keyup', function(e) {
	// 	titipan.value = formatRupiah(this.value, '');
	// });
	// /* Fungsi formatRupiah */
	// function formatRupiah(angka, prefix) {
	// 	var number_string = angka.replace(/[^-,\d]/g, '').toString(),
	// 		split = number_string.split(','),
	// 		sisa = split[0].length % 3,
	// 		rupiah = split[0].substr(0, sisa),
	// 		ribuan = split[0].substr(sisa).match(/\d{3}/gi);
	// 	//tambahkan titik jika yang di input sudah menjadi angka ribuan
	// 	if (ribuan) {
	// 		separator = sisa ? '.' : '';
	// 		rupiah += separator + ribuan.join('.');
	// 	}
	// 	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	// 	return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
	// }

	function calc() {
		// potongan = document.getElementById("potongan").value;
		// uangpot = potongan.replace(/\./g, '');
		// potistimewa = document.getElementById("potistimewa").value;
		// uangpotis = potistimewa.replace(/\./g, '');
		// penyesuaian = document.getElementById("penyharga").value;
		// uangpeny = penyesuaian.replace(/\./g, '');

		//Potongan
		potaida = document.getElementById('potaida').value;
		uangpotaida = potaida.replace(/\./g, '');
		potswan = document.getElementById('potswan').value;
		uangpotswan = potswan.replace(/\./g, '');
		potstick = document.getElementById('potstick').value;
		uangpotstick = potstick.replace(/\./g, '');

		//Potongan Istimewa
		potisaida = document.getElementById('potisaida').value;
		uangpotisaida = potisaida.replace(/\./g, '');
		potisswan = document.getElementById('potisswan').value;
		uangpotisswan = potisswan.replace(/\./g, '');
		potisstick = document.getElementById('potisstick').value;
		uangpotisstick = potisstick.replace(/\./g, '');

		//Penyesuaian
		penyaida = document.getElementById('penyaida').value;
		uangpenyaida = penyaida.replace(/\./g, '');
		penyswan = document.getElementById('penyswan').value;
		uangpenyswan = penyswan.replace(/\./g, '');
		penystick = document.getElementById('penystick').value;
		uangpenystick = penystick.replace(/\./g, '');

		grandtotal = document.getElementById("tot").value;

		//Potongan
		if (uangpotaida == "") {
			uangpotaida = 0;
		}
		if (uangpotswan == "") {
			uangpotswan = 0;
		}
		if (uangpotstick == "") {
			uangpotstick = 0;
		}

		//Potongan Istimewa
		if (uangpotisaida == "") {
			uangpotisaida = 0;
		}
		if (uangpotisswan == "") {
			uangpotisswan = 0;
		}
		if (uangpotisstick == "") {
			uangpotisstick = 0;
		}


		//Penyesuaian Harga
		if (uangpenyaida == "") {
			uangpenyaida = 0;
		}
		if (uangpenyswan == "") {
			uangpenyswan = 0;
		}
		if (uangpenystick == "") {
			uangpenystick = 0;
		}
		if (grandtotal == "") {
			grandtotal = 0;
		}
		var potongan = parseInt(uangpotaida) + parseInt(uangpotswan) + parseInt(uangpotstick);
		var potistimewa = parseInt(uangpotisaida) + parseInt(uangpotisswan) + parseInt(uangpotisstick);
		var penyesuaian = parseInt(uangpenyaida) + parseInt(uangpenyswan) + parseInt(uangpenystick);
		// uangpot = potongan.replace(/\./g, '');
		// potistimewa = document.getElementById("potistimewa").value;
		// uangpotis = potistimewa.replace(/\./g, '');
		// penyesuaian = document.getElementById("penyharga").value;
		// uangpeny = penyesuaian.replace(/\./g, '');

		var result = parseInt(grandtotal) - parseInt(potongan) - parseInt(potistimewa) - parseInt(penyesuaian);
		if (!isNaN(result)) {
			totalpenjualan = document.getElementById('totalbayar').value = convertToRupiah(result);
			// document.getElementById("totalbayar").innerHTML=convertToRupiah(totalsetoran);
		}
	}

	function convertToRupiah(angka) {
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for (var i = 0; i < angkarev.length; i++)
			if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
		return rupiah.split('', rupiah.length - 1).reverse().join('');
	}
</script>
<script>
	flatpickr(document.getElementById('tgltransaksi'), {});
</script>