<form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>penjualan/inputpelunasanhk">
<input type="hidden" id="cekdetailpelunasanhk">
<div class="row">
	<div class="body">
		<div class="col-md-6">
			<table class="table table-bordered table-hover table-striped">
				<tr>
					<td>
						<?php if($jenis_mutasi == "REPACK"){ ?>
							<b>No Repack</b>
						<?php }else if($jenis_mutasi == "REJECT GUDANG"){ ?>
							<b>No Reject</b>
						<?php }else if($jenis_mutasi == "REJECT PASAR"){ ?>
							<b>No Reject</b>
						<?php }else if($jenis_mutasi == "KIRIM PUSAT"){ ?>
							<b>No Pengiriman</b>
						<?php }else if($jenis_mutasi == "HUTANG KIRIM"){ ?>
							<b>No Hutan Kirim</b>
						<?php }else if($jenis_mutasi == "TTR"){ ?>
							<b>No TTR</b>
						<?php } ?>
					</td>
					<td>:</td>
					<td>
						<?php echo $mutasi['no_mutasi_gudang_cabang']; ?>
						<input type="hidden" name="no_hutangkirim" id="no_hutangkirim" value="<?php echo $mutasi['no_mutasi_gudang_cabang']; ?>">
					</td>
				</tr>
				<tr>
					<td><b>Tanggal</b></td>
					<td>:</td>
					<td><?php echo DateToIndo2($mutasi['tgl_mutasi_gudang_cabang']); ?></td>
				</tr>
				<tr>
					<td><b>No Faktur</b></td>
					<td>:</td>
					<td>
						<?php echo $mutasi['no_fak_penj']; ?>
						<input type="hidden" value="<?php echo $mutasi['no_fak_penj']; ?>" id="nofaktur">
						<input type="hidden" value="<?php echo $mutasi['no_retur_penj']; ?>" id="noreturpenj">
					</td>
				</tr>
				<tr>
					<td><b>Kode Pelanggan</b></td>
					<td>:</td>
					<td><?php echo $mutasi['kode_pelanggan']; ?></td>
				</tr>
				<tr>
					<td><b>Pelanggan</b></td>
					<td>:</td>
					<td><?php echo $mutasi['nama_pelanggan']; ?></td>
				</tr>

			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="body">
		<div class="col-md-12">
			<table class="table table-bordered table-hover table-striped">
				<thead class="bg-cyan">
					<tr>
						<th colspan="9">Detail Hutang Kirim</th>
					</tr>
					<tr>
						<th rowspan="2" style="text-align: center; vertical-align:middle">Kode Produk</th>
						<th rowspan="2" style="text-align: center; vertical-align:middle">Nama Barang</th>
						<th colspan="3" class="bg-green">Jumlah</th>
						<th colspan="3" class="bg-red">Realisasi</th>
						<th rowspan="2">Aksi</th>
					</tr>
					<tr>
						<th class="bg-green">DUS</th>
						<th class="bg-green">PACK</th>
						<th class="bg-green">PCS</th>
						<th class="bg-red">DUS</th>
						<th class="bg-red">PACK</th>
						<th class="bg-red">PCS</th>
					</tr>
				</thead>
				<tbody id="detailhk">

				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="body">
		<div class="col-md-5">
			<table class="table table-bordered table-hover table-striped">
				<thead class="bg-green">
					<tr>
						<th colspan="7">Histori Pelunasan Hutang Kirim</th>
					</tr>
					<tr>
						<th>Tanggal</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody id="loadhistoripelunasanhk">

				</tbody>
			</table>
		</div>
		<div class="col-md-7" id="detailhistori">
			<table class="table table-bordered table-hover table-striped">
				<thead class="bg-blue">
					<tr>
						<th colspan="5" id="tglhk"></th>
					</tr>
					<tr>
						<th>Kode</th>
						<th>Nama Barang</th>
						<th>DUS</th>
						<th>PACK</th>
						<th>PCS</th>
					</tr>
				</thead>
				<tbody id="loaddetailhistorihk">

				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="body">
		<div class="col-md-4">
			<label>Barang</label>
			<div class="input-group" >
				<span class="input-group-addon">
					<i class="material-icons">chrome_reader_mode</i>
				</span>
				<div class="form-line">
					<input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang"/>
					<input type="text" readonly id="barang" name="barang" class="form-control" placeholder="Barang"  />
					<input type="hidden" readonly id="kodecabang" name="kodecabang" class="form-control" placeholder="Kode Cabang"  />
					<input type="hidden" id="jmlhk">
					<input type="hidden" id="cekplhk">
				</div>

			</div>
		</div>
		<div class="col-md-2">
			<label>Jumlah</label>
			<div class="form-group form-float">
				<div class="form-line">
						<input type="text" style="text-align:center" value="0"  id="jmldus" name="jmldus" class="form-control" />
				</div>
				<div class="form-line">
						<input style="text-align:right; font-weight: bold" readonly type="hidden" id="hargadus" name="hargadus" class="form-control"  placeholder="Harga" />
				</div>

				<div class="form-line">
						<input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcsdus" name="isipcsdus" class="form-control"  />
				</div>
					<div class="form-line">
						<input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcspack" name="isipcspack" class="form-control" />
				</div>
			</div>
		</div>
		<div class="col-md-2" id="pack">
			<label>Jumlah Pack</label>
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text" style="text-align:center" value="0"  id="jmlpack" name="jmlpack" class="form-control"  />
				</div>
				<div class="form-line">
					<input style="text-align:right; font-weight: bold" type="hidden" id="hargapack" name="hargapack" class="form-control" readonly   placeholder="Harga / Pack"/>
				</div>
			</div>
		</div>
		<div class="col-md-2" >
			<label>Jumlah Pcs</label>
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text"  style="text-align:center" value="0"  id="jmlpcs" name="jmlpcs" class="form-control" placeholder="Jumlah Pcs"  />
				</div>
				<div class="form-line">
					<input style="text-align:right; font-weight: bold"  type="hidden" id="hargapcs" name="hargapcs" class="form-control" readonly placeholder="Harga / Pcs"  />
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<a href="#" id="tambahbarang" class="btn bg-blue waves-effect">
				<i class="material-icons">add_shopping_cart</i>
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
						<th style="text-align: center; vertical-align:middle">Kode Produk</th>
						<th style="text-align: center; vertical-align:middle">Nama Produk</th>
						<th>DUS</th>
						<th>PACK</th>
						<th>PCS</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody id="loaddetailpelunasanhk">
				</tbody>
			</table>
		</div>
	</div>
</div>
<div id="tanggalditerima">
    <label>Tanggal Pelunasan</label>
    <div class="input-group demo-masked-input"  >
        <span class="input-group-addon">
            <i class="material-icons">date_range</i>
        </span>
        <div class="form-line">
            <input type="text"  id="tglpelunasan" name="tglpelunasan" class="datepicker form-control date" placeholder="Tanggal Pelunasan" data-error=".errorTxt1" />
        </div>
        <div class="errorTxt1"></div>
    </div>
</div>
 <div class="form-group" style="margin-left:10px" >
     <button type="submit"  name="submit" class="btn bg-blue waves-effect">
        <i class="material-icons">save</i>
        <span>SIMPAN</span>
    </button>
    <button type="button" data-dismiss="modal" class="btn bg-red waves-effect">
        <i class="material-icons">cancel</i>
        <span>Batal</span>
    </button>
</div>
</form>
<script type="text/javascript">
	$(function(){

		function hidedetailhistori(){
			$("#detailhistori").hide();
		}
		function loaddetailhutangkirim(){
			var nofaktur = $("#nofaktur").val();
			$("#detailhk").load("<?php echo base_url();?>penjualan/view_detailhutangkirim/"+nofaktur);
		}
		function loaddetailpelunasanhk(){
			var nofaktur = $("#nofaktur").val();
			$("#loaddetailpelunasanhk").load("<?php echo base_url();?>penjualan/view_detailpelunasanhktemp/"+nofaktur);
		}
		function loadhistoripelunasanhk(){
			var nofaktur = $("#nofaktur").val();
			$("#loadhistoripelunasanhk").load("<?php echo base_url();?>penjualan/historipelunasanhk/"+nofaktur);
		}
		function cekdetailpelunasanhk(){
        var nofaktur  = $("#nofaktur").val();
        $.ajax({

            type    : 'POST',
            url     : '<?php echo base_url(); ?>penjualan/cekdetailpelunasanhk',
            data    : {nofaktur:nofaktur},
            cache   :false,
            success : function(respond){
                console.log(nofaktur);
                $("#cekdetailpelunasanhk").val(respond);
            }

        });
		}

		cekdetailpelunasanhk();
		loaddetailpelunasanhk();
		loadhistoripelunasanhk();
		hidedetailhistori();
		loaddetailhutangkirim();
		$('.datepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
		});
		$(".formValidate").submit(function(){
        var tglpelunasan    = $("#tglpelunasan").val();
        var cek             = $("#cekdetailpelunasanhk").val();

        if(tglpelunasan == ""){
            swal("Oops!", "Tanggal Pelunasan Masih Kosong!", "warning");
            return false;
        }else if(cek == ""){
            swal("Oops!", "Data Barang Masih Kosong!", "warning");
            return false;
        }else{
            return true;
        }
     });


		$("#tambahbarang").click(function(e){
      e.preventDefault();
			var kode_produk = $("#kodebarang").val();
			var nofaktur    = $("#nofaktur").val();
			var noretur     = $("#noreturpenj").val();
      var jmldus      = $("#jmldus").val();
      var hargadus    = $("#hargadus").val();
      var jmlpack     = $("#jmlpack").val();
      var hargapack   = $("#hargapack").val();
      var jmlpcs      = $("#jmlpcs").val();
      var hargapcs    = $("#hargapcs").val();
      var isipcsdus   = $("#isipcsdus").val();
      var isipcspack  = $("#isipcspack").val();
      var jumlahpcs   = (jmldus * isipcsdus) + (jmlpack * isipcspack) + (jmlpcs * 1);
      var jmlhk 			= $("#jmlhk").val();
			var cekplhk     = $("#cekplhk").val();

            if(kode_produk ==""){
                swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
            }
            else if(jmldus == 0 && jmlpack == 0 && jmlpcs== 0){

                swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
            }else if(parseInt(jumlahpcs)>parseInt(jmlhk-cekplhk)){

                swal("Oops!", "Melebihi Jumlah Hutang Kirim!", "warning");
            }else{
              $.ajax({
                  type    : 'POST',
                  url     : '<?php echo base_url();?>penjualan/insert_detailpelunasanhktemp',
                  data    : {
                              kode_produk:kode_produk,
                              jmldus:jmldus,
                              hargadus:hargadus,
                              jmlpack:jmlpack,
                              hargapack:hargapack,
                              jmlpcs:jmlpcs,
                              hargapcs:hargapcs,
                              isipcsdus:isipcsdus,
															isipcspack:isipcspack,
															nofaktur:nofaktur,
															noretur:noretur
                          },
                  cache   : false,
                  success : function(respond){
                      console.log(respond);

                       if(respond == 1){

                          swal("Oops!", "Data Sudah Di Inputkan!", "warning");
                       }else{
												 loaddetailpelunasanhk();
												 cekdetailpelunasanhk();
				 						 }
                  }
              });
            }

        });
	});
</script>
