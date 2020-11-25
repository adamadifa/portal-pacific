<style>
	#container {
    display: block;
    position:relative
	}
	.ui-autocomplete {
	  position: absolute;
	}
</style>
<form name="autoSumForm" autocomplete="off" class="formValidate form-horizontal" id="formValidate"  method="POST" action="<?php echo base_url(); ?>penjualan/retur_penjualangb">
	<div class="col-md-12">
		<div class="card">
	    <div class="header bg-cyan">
        <h2>
          Data Transaksi Retur Penjualan
          <small>Input Data Transaksi Retur Penjualan</small>
        </h2>
	    </div>
	    <div class="body">
        <div class="row clearfix">
        	<div class="row">
        		<div class="body">
	            <div class="col-md-4">
                <div class="input-group" >
                	<span class="input-group-addon">
                    <i class="material-icons">person</i>
                  </span>
                    <div class="form-line">
                    	<input type="hidden"  id="jenisretur" name="jenisretur" class="form-control" placeholder="Jenis Retur" value="gb" />
                    	 <input type="hidden"  id="cekretur" name="cekretur" class="form-control" />
                    	 <input type="hidden"  id="cekreturgb" name="cekreturgb" class="form-control" />
                    	<input type="text" readonly  id="kodepelanggan" name="kodepelanggan" class="form-control" placeholder="Kode Pelanggan" data-error=".errorTxt22"  />
                    </div>
                    <div class="errorTxt22"></div>
                </div>
                <div class="input-group" >
      						<span class="input-group-addon">
                    <i class="material-icons">person</i>
                	</span>
                  <div class="form-line">
                     <input type="text" readonly  id="pelanggan" name="pelanggan" class="form-control" placeholder="Pelanggan" disabled  data-error=".errorTxt2" />
                  </div>
                </div>
                <div class="input-group" >
      						<span class="input-group-addon">
                    <i class="material-icons">person</i>
                	</span>
                  <div class="form-line">
                		<input type="hidden"  id="kodesales" name="kodesales" class="form-control"/>
                    <input type="text"    id="salesman"  disabled name="salesman" class="form-control" placeholder="Salesman" data-error=".errorTxt3" />
                  </div>
                  <div class="errorTxt3"></div>
                </div>
                <div class="input-group demo-masked-input"  >
                	<span class="input-group-addon">
                    <i class="material-icons">date_range</i>
                  </span>
                  <div class="form-line">
                    <input type="text"  id="tglretur" name="tglretur" class="datepicker form-control date" placeholder="Tanggal Retur" data-error=".errorTxt11" />
                  </div>
                  <div class="errorTxt11"></div>
                </div>
	            </div>
	            <div class="col-md-7">
	              <div class="info-box" style="min-height:170px">
                  <div class="icon bg-cyan" style="height:170px; padding:40px 0; width:200px" >
                    <i class="material-icons">shopping_cart</i>
                  </div>
                  <div class="content">
                    <div id="grandtotal" style="padding:30px 0px 50px 0px; font-size:60px; margin-left:90px"></div>
                  </div>
	              </div>
	            </div>
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="body">
		        	<div class="col-md-12  table-responsive" >
		        		<table class="table table-bordered table-striped table-hover"  id="detailbarang">
					    		<thead class="bg-cyan">
					    			<tr>
					    				<th colspan="11">Histori  Penjualan</th>
					    			</tr>
					    			<tr>
					    				<th>Kode Barang</th>
					    				<th>Nama Barang</th>
					    				<th>Jml Dus</th>
					    				<th>Jml Pack</th>
					    				<th>Jml Pcs</th>
					    			</tr>
					    		</thead>
					    		<tbody id="loadhistoriPenjualan">
					    		</tbody>
				    		</table>
		        	</div>
	          </div>
	        </div>
	        <div class="row">
	        	<div class="body">
		        	<div class="col-md-12  table-responsive" >
		        		<table class="table table-bordered table-striped table-hover"  id="detailbarang">
					    		<thead class="bg-cyan">
					    			<tr>
					    				<th colspan="5">Histori Retur Penjualan</th>
					    			</tr>
					    			<tr>
					    				<th>Kode Barang</th>
					    				<th>Nama Barang</th>
					    				<th>Jml Dus</th>
					    				<th>Jml Pack</th>
					    				<th>Jml Pcs</th>
					    			</tr>
					    		</thead>
					    		<tbody id="loadhistoriretur">
					    		</tbody>
				    		</table>
		        	</div>
	          </div>
	        </div>
		      <div class="row">
		       	<div class="body">
		        	<div class="col-md-3">
                <label>Barang</label>
                <div class="input-group" >
	                <span class="input-group-addon">
	                  <i class="material-icons">chrome_reader_mode</i>
	                </span>
                  <div class="form-line">
                		<input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang" data-error=".errorTxt1" />
                    <input type="text" readonly id="barang" name="barang" class="form-control" placeholder="Barang" data-error=".errorTxt1" />
                    <input type="hidden" readonly id="kodecabang" name="kodecabang" class="form-control" placeholder="Kode Cabang" data-error=".errorTxt1" />
                    <input type="hidden" readonly id="stok" name="stok" class="form-control" placeholder="Stok" data-error=".errorTxt1" />
                  </div>
			          </div>
              </div>
              <div class="col-md-2">
              	<label>Jumlah</label>
                  <div class="form-group form-float">
                    <div class="form-line">
                      <input type="text" style="text-align:center" value="0"  id="jmldus" name="jmldus" class="form-control" data-error=".errorTxt1" />
                    </div>
                    <div class="form-line">
                      <input style="text-align:right; font-weight: bold" readonly type="text" id="hargadus" name="hargadus" class="form-control"  data-error=".errorTxt1" placeholder="Harga" />
                    </div>
                  </div>
              </div>
              <div class="col-md-2" id="pack">
            		<label>Jumlah Pack</label>
                <div class="form-group form-float">
                  <div class="form-line">
                    <input type="text" style="text-align:center" value="0"  id="jmlpack" name="jmlpack" class="form-control"  data-error=".errorTxt1" />
                  </div>
                  <div class="form-line">
                    <input style="text-align:right; font-weight: bold" type="text" id="hargapack" name="hargapack" class="form-control" readonly  data-error=".errorTxt1"  placeholder="Harga / Pack"/>
                  </div>
                </div>
              </div>
              <div class="col-md-2" >
            		<label>Jumlah Pcs</label>
                <div class="form-group form-float">
                  <div class="form-line">
                    <input type="text"  style="text-align:center" value="0"  id="jmlpcs" name="jmlpcs" class="form-control" placeholder="Jumlah Pcs" data-error=".errorTxt1" />
                  </div>
                  <div class="form-line">
                    <input style="text-align:right; font-weight: bold"  type="text" id="hargapcs" name="hargapcs" class="form-control" readonly placeholder="Harga / Pcs" data-error=".errorTxt1" />
                  </div>
                </div>
              </div>
              <div class="col-md-2">
              	<a href="#" id="tambahbarang" class="btn bg-blue waves-effect">
	              	<i class="material-icons">add_shopping_cart</i>
	              	<span>Tambah</span>
          			</a>
              </div>
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="body">
		        	<div class="col-md-12  table-responsive" >
		        		<table class="table table-bordered table-striped table-hover" id="detailbarang">
					    		<thead class="bg-cyan">
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
					    		<tbody id="loadreturtmp">
					    		</tbody>
					    	</table>
		        	</div>
	          </div>
	        </div>
					<div class="row">
						<div class="body">
							<div id="gantibarang">
								<div class="row">
									<div class="body">
										<div class="col-md-3">
											<label>Barang</label>
											<div class="input-group" >
												<span class="input-group-addon">
													<i class="material-icons">chrome_reader_mode</i>
												</span>
												<div class="form-line">
													<input type="hidden" readonly id="kodebaranggb" name="kodebaranggb" class="form-control" placeholder="Barang" />
													<input type="text" readonly id="baranggb" name="baranggb" class="form-control" placeholder="Barang"/>
													<input type="hidden" readonly id="kodecabanggb" name="kodecabanggb" class="form-control" placeholder="Kode Cabang" />
													<input type="hidden" readonly id="stokgb" name="stokgb" class="form-control" placeholder="Stok"/>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<label>Jumlah</label>
											<div class="form-group form-float">
												<div class="form-line">
													 <input type="text" style="text-align:center" value="0"  id="jmldusgb" name="jmldusgb" class="form-control" />
												</div>
												<div class="form-line">
													  <input style="text-align:right; font-weight: bold" readonly type="text" id="hargadusgb" name="hargadusgb" class="form-control"  data-error=".errorTxt1" placeholder="Harga" />												   												</div>
												<div class="form-line">
													  <input style="text-align:right; font-weight: bold" readonly type="hidden" id="stokdusgb" name="stokdusgb" class="form-control"  data-error=".errorTxt1" placeholder="Stok Dus" />
												</div>
												<div class="form-line">
													  <input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcsdusgb" name="isipcsdusgb" class="form-control"  />
												</div>
												 <div class="form-line">
													  <input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcspackgb" name="isipcspackgb" class="form-control"   />
												</div>
											</div>
										</div>
										<div class="col-md-2" id="packgb">
											<label>Jumlah Pack</label>
											<div class="form-group form-float">
												<div class="form-line">
													<input type="text" style="text-align:center" value="0"  id="jmlpackgb" name="jmlpackgb" class="form-control"  />
												</div>
												<div class="form-line">
													<input style="text-align:right; font-weight: bold" type="text" id="hargapackgb" name="hargapackgb" class="form-control" readonly   placeholder="Harga / Pack"/>
												</div>
												<div class="form-line">
													<input style="text-align:right; font-weight: bold" readonly type="hidden" id="stokpackgb" name="stokpackgb" class="form-control"  placeholder="Stok pack" />
												</div>
											</div>
										</div>
										<div class="col-md-2" >
											<label>Jumlah Pcs</label>
											<div class="form-group form-float">
												<div class="form-line">
													 <input type="text"  style="text-align:center" value="0"  id="jmlpcsgb" name="jmlpcsgb" class="form-control" placeholder="Jumlah Pcs"  />
												</div>
												<div class="form-line">
													<input style="text-align:right; font-weight: bold"  type="text" id="hargapcsgb" name="hargapcsgb" class="form-control" readonly placeholder="Harga / Pcs" />
												</div>
												<div class="form-line">
													  <input style="text-align:right; font-weight: bold" readonly type="hidden" id="stokpcsgb" name="stokpcsgb" class="form-control"   placeholder="Stok Pcs" />
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="demo-radio-button">
												<input name="inout" type="radio" checked value="HUTANG KIRIM" id="radio_1" class="inout"  />
												<label for="radio_1"><b>HUTANG KIRIM</b></label>
											</div>
										</div>
										<div class="col-md-2">
											<a href="#" id="tambahbaranggb" class="btn bg-red waves-effect">
												<i class="material-icons">add_shopping_cart</i>
												<span>Tambah</span>
											</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="body">
										<div class="col-md-12  table-responsive" >
											<table class="table table-bordered table-striped table-hover" id="detailbarang">
												<thead class="bg-teal">
													<tr>
														<th colspan="10">Data Hutang Kirim</th>
													</tr>
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
												<tbody id="loaddatahutangkirim">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
	        <div class="row">
	        	<div class="col-md-6">
	        	</div>
	        	<div class="col-md-6">
	        	 	<div class="form-group">
                <div class="col-md-4  form-control-label">
                  <label>No Faktur</label>
                </div>
            		<div class="col-md-8">
                  <select class="form-control show-tick" data-live-search="true" id="loadfaktur" name="nofaktur">
                  	<option value="">-- Pilih No Faktur --</option>
                  </select>
                </div>
              </div>
           </div>
	        </div>
         	<div class="row">
       			<div style="margin-left:30px">
	 						<button type="submit" name="submit" style=" font-size:16px" class="btn btn-lg bg-blue"><span>SIMPAN</span> <i class="material-icons">send</i></button>
	 						<button type="reset" style=" font-size:16px" class="btn btn-lg bg-red"><span>BATAL</span> <i class="material-icons">cancel</i></button>
						</div>
         	</div>
	      </div>
	    </div>
		</div>
	</div>
</form>

<!--MODAL DATA PELANGGAN-->
<div class="modal fade" id="datapelanggan" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card">
			  <div class="header bg-cyan">
	        <h2>
	          Data Pelanggan
	          <small>Pilih Data Pelanggan</small>
	        </h2>
			  </div>
			  <div class="body">
	        <div class="row clearfix">
            <div class="col-sm-12">
            	<div class="table-responsive">
               	<table class="table table-bordered table-striped table-hover" style="font-size:12px" id="mytable" style="width:1330px">
                	<thead>
                    <tr>
                      <th width="10px">No</th>
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
            </div>
	        </div>
			  </div>
			</div>
		</div>
  </div>
</div>
<!---MODAL DATA BARANG-->
<div class="modal fade" id="databarang" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card">
			  <div class="header bg-cyan">
	        <h2>
            Data Barang
            <small>Pilih Data Barang</small>
	        </h2>
			  </div>
		    <div class="body">
	      	<div class="row clearfix">
	        	<div class="col-sm-12">
	            <div class="table-responsive">
               	<table class="table table-bordered table-striped table-hover dataTable js-exportable" id="tabelbarang" style="width:850px; font-size:12px">
                  <thead>
                    <tr>
                      <th width="10px">No</th>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Kategori</th>
                      <th>Satuan</th>
                      <th>Harga Dus</th>
                      <th>Harga Pack</th>
                      <th>Harga Pcs</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="loadBarang">
                  </tbody>
                </table>
              </div>
	          </div>
	        </div>
		    </div>
			</div>
		</div>
  </div>
</div>
<div class="modal fade" id="detailretur" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card">
	    	<div class="header bg-cyan">
	        <h2>
            Data Retur
            <small>Detail Retur</small>
	        </h2>
	    	</div>
	     <div class="body">
	        <div class="row clearfix">
	          <div class="col-sm-12" id="loadDetailRetur"></div>
	        </div>
	    	</div>
			</div>
		</div>
	</div>
</div>
<!-- Select Plugin Js -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">

		$(function(){

			function loadhistoriPenjualan(){
				var kodepelanggan = $("#kodepelanggan").val();
				$("#loadhistoriPenjualan").load("<?php echo base_url();?>penjualan/view_detailpenjualan/"+kodepelanggan);
			}

			function loadreturTmp(){
				var kodepelanggan = $("#kodepelanggan").val();
				$("#loadreturtmp").load("<?php echo base_url();?>penjualan/view_detailreturtmp/"+kodepelanggan);
			}

			function loadreturgbTmp(){
				var kodepelanggan = $("#kodepelanggan").val();
				$("#loadreturgbtmp").load("<?php echo base_url();?>penjualan/view_detailreturgbtmp/"+kodepelanggan);
			}

			function loadhistoriretur(){
				var kodepelanggan = $("#kodepelanggan").val();
				$("#loadhistoriretur").load("<?php echo base_url();?>penjualan/view_detailretur/"+kodepelanggan);
			}

			function cekretur(){
				var kodepelanggan = $("#kodepelanggan").val();
          $.ajax({
          	type		: 'POST',
          	url 		: '<?php echo base_url(); ?>penjualan/cekbarangretur',
          	data 		: {kodepelanggan:kodepelanggan},
          	cache		: false,
          	success : function(respond){
          						data 						= respond.split("|");
											var cekretur 		= data[0];
											var cekreturgb	= data[1];
											$("#cekretur").val(cekretur);
											$("#cekreturgb").val(cekreturgb);
          					}

         	});
			}
			function loadfaktur(){
				var kodepelanggan = $("#kodepelanggan").val();
				$.ajax({
						type 		: 'POST',
						url 		: '<?php echo base_url(); ?>penjualan/loadfaktur',
						data 		: {kodepelanggan:kodepelanggan},
						cache 	: false,
						success : function(respond){
							//alert(kodecabang);
							$("#loadfaktur").html(respond);
							$("#loadfaktur").selectpicker("refresh");
							console.log(respond);
						}
				});
			}

			function ResetBrg(){
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

			function ResetBrg2(){
				$("#kodebaranggb").val("");
				$("#baranggb").val("");
				$("#hargadusgb").val("");
				$("#hargapackgb").val("");
				$("#hargapcsgb").val("");
				$("#stokdusgb").val("");
				$("#stokpcsgb").val("");
				$("#stokgb").val("");
				$("#isipcsdusgb").val("");
				$("#isipcspackgb").val("");
				$("#stokpackgb").val("");
				$("#jmlpcsgb").val(0);
				$("#jmlpackgb").val(0);
				$("#jmldusgb").val(0);
			}

			$("#formValidate").validate({
          rules: {
            kodepelanggan       :"required",
            tglretur 	  	   		:"required",
            jenisretur 	        :"required",
          },
          //For custom messages
          messages: {
            kodepelanggan    :"Kode Pelanggan Harus Diisi !",
            tglretur 	  	   :"Tanggal Retur Harus Diisi !",
            jenisretur 	  	 : "Jenis Retur Harus Dipilih",
          },
	          errorElement 			: 'div',
	          errorPlacement		: function(error, element) {
	            var placement = $(element).data('error');
	            if (placement) {
	              $(placement).append(error)
	            } else {
	              error.insertAfter(element);
	            }
	          }
	    });

			$('.datepicker').bootstrapMaterialDatePicker({
        format			: 'YYYY-MM-DD',
        clearButton	: true,
        weekStart		: 1,
        time				: false
	    });

			$("#kodepelanggan").click(function() {
				$("#datapelanggan").modal("show");
			});

			$("#barang").click(function() {
				var kodepelanggan   = $("#kodepelanggan").val();
				var jenisretur 			= $("#jenisretur").val();
				var kodecabang 			= $("#kodecabang").val();
				if(kodepelanggan == "" || jenisretur==""){
					swal("Oops!", "Kode Pelanggan  Harus Diisi Terlebih Dahulu !", "warning");
					$("#kodepelanggan").focus();
				}else{
					$("#databarang").modal("show");
					$.ajax({
						type 		: 'POST',
						url 		: '<?php echo base_url(); ?>penjualan/view_barangfaktur',
						data 		: {kodepelanggan:kodepelanggan,jenisretur:jenisretur,kodecabang:kodecabang},
						cache 	: false,
						success : function(respond){
							//alert(kodecabang);
							$("#loadBarang").html(respond);
						}
					});
				}
			});


			$("#tambahbarang").click(function(e){
				var kodebarang 		= $("#kodebarang").val();
				var jmldus 	   		= $("#jmldus").val();
				var hargadus   		= $("#hargadus").val();
				var jmlpack    		= $("#jmlpack").val();
				var hargapack  		= $("#hargapack").val();
				var jmlpcs 	   		= $("#jmlpcs").val();
				var hargapcs   		= $("#hargapcs").val();
				var isipcsdus  		= $("#isipcsdus").val();
				var isipcspack 		= $("#isipcspack").val();
				var stok 	   			= $("#stok").val();
				var kodepelanggan = $("#kodepelanggan").val();
				var jumlahpcs  		= (jmldus * isipcsdus) + (jmlpack * isipcspack) + (jmlpcs * 1);
				e.preventDefault();
				if(kodebarang ==""){
					swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
				}else if(jmldus == 0 && jmlpack ==0 && jmlpcs== 0){
					swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
				}else{
					$.ajax({
						type  	: 'POST',
						url   	: '<?php echo base_url();?>penjualan/insert_detailreturtmp',
						data  	: {
												kodebarang:kodebarang,
												jmldus:jmldus,
												hargadus:hargadus,
												jmlpack:jmlpack,
												hargapack:hargapack,
												jmlpcs:jmlpcs,
												hargapcs:hargapcs,
												kodepelanggan:kodepelanggan
										  },
						cache 	: false,
						success : function(respond){
							var status = respond;
							console.log(status);
							if(status == 1){
								swal("Oops!", "Jumlah Retur Tidak Boleh Melebihi Jumlah Penjualan !" , "warning");
							}else{
								ResetBrg();
								loadreturTmp();
								cekretur();
							}
						}
					});
				}

			});



		 $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
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
          oLanguage		 : {
            sProcessing		: "loading..."
          },
          processing		: true,
          serverSide		: true,
          bLengthChange	: false,
          ajax					: {"url": "<?php echo base_url();?>penjualan/jsonPelanggan", "type": "POST"},
          columns				: [
						                {
					                    "data"			: "kode_pelanggan",
					                    "orderable"	: false
						                },
							                {"data": "kode_pelanggan"},
							                {"data": "nama_pelanggan"},
							                {"data": "no_hp"},
							                {"data": "pasar"},
							                {"data": "nama_cabang"},
							                {"data": "nama_karyawan"},
							                {"data": "view"}
            							],
            order				: [[1, 'desc']],
            rowCallback	: function(row, data, iDisplayIndex) {
              var info 			= this.fnPagingInfo();
              var page 			= info.iPage;
              var length 		= info.iLength;
              var index 		= page * length + (iDisplayIndex + 1);
              $('td:eq(0)', row).html(index);
            }
        });

        $('#mytable tbody').on('click', 'a', function () {
	        $("#kodepelanggan").val($(this).attr("data-kodepel"));
	        $("#pelanggan").val($(this).attr("data-namapel"));
	        $("#kodesales").val($(this).attr("data-kodesales"));
	        $("#salesman").val($(this).attr("data-namasales"));
	        $("#kodecabang").val($(this).attr("data-cabang"));
	        loadhistoriPenjualan();
	        loadreturTmp();
	        loadreturgbTmp();
	        loadhistoriretur();
	        cekretur();
	        loadfaktur();
	       	$("#datapelanggan").modal("hide");
	    	});

        $("form").submit(function(){
					var cekretur 		= $("#cekretur").val();
					var nofaktur 		= $("#loadfaktur").val();
					var cekreturgb	= $("#cekreturgb").val();
					if(cekretur == 0){
		 				swal("Oops!", "Data Barang Retur Harus Diisi  !", "warning");
         		 return false;
					}else if(nofaktur == '' ){
						 swal("Oops!", "Silahkan Pilih Faktur !", "warning");
	            return false;
					}else{
						return true;
					}
    	  });

				$("#baranggb").click(function() {
					var pelanggan  		= $("#pelanggan").val();
					var kodecabang 		= $("#kodecabang").val();
					if(pelanggan == ""){
						swal("Oops!", "Pelanggan Harus Diisi Terlebih Dahulu !", "warning");
						$("#kodepelanggan").focus();
					}else{
						$("#databaranggb").modal("show");
						$.ajax({
							type 		: 'POST',
							url 		: '<?php echo base_url(); ?>barang/view_barangcabgb',
							data 		: {kodecabang:kodecabang},
							cache 	: false,
							success : function(respond){
							  //alert(kodecabang);
								$("#loadBaranggb").html(respond);
							}

						});
					}
				});
		});

</script>
