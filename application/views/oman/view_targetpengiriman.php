<div class="row clearfix">
  <div class="col-md-8">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          Data Target Pengiriman Cabang Per Bulan
          <small> Data Target Pengiriman Cabang Per Bulan</small>
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <div class="col-md-12">
			      <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>oman/insert_targetbulan">
              <input type="hidden" id="cek_targetbulantemp">
              <div class="row">
    						<div class="col-md-12">
    							<div class="form-group">
    								<div class="form-line">
    									<select class="form-control" id="tahun" name="tahun" data-error=".errorTxt9">
    										 <option value="">-- Pilih Tahun -- </option>
    										  <?php $tahunnow = date('Y'); for($tahun=2019; $tahun<=$tahunnow; $tahun++){ ?>
    											<option value="<?php echo $tahun; ?>"><?php echo strtoupper($tahun); ?></option>
    										<?php } ?>
    									</select>
    								</div>
    								<div class="errorTxt9"></div>
    							</div>
    							<div class="form-group">
    								<div class="form-line">
    									<select class="form-control" id="bulan" name="bulan" data-error=".errorTxt9">
    										 <option value="">-- Pilih Bulan -- </option>
    										<?php
    										 $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Novemer","Desember");
    										 for($i=1; $i<=12; $i++){
    										 ?>
    											<option value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
    										 <?php
    										 }
    										?>
    									</select>
    								</div>
    								<div class="errorTxt9"></div>
    							</div>
    							<div class="form-group">
    								<div class="form-line">
    									<select class="form-control" id="cabang" name="cabang" data-error=".errorTxt9">
    										<option value="">-- Pilih Cabang -- </option>
    										<?php foreach($cabang as $c){ ?>
    										<option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
    										<?php } ?>
    									</select>
    								</div>
    								<div class="errorTxt9"></div>
    							</div>
    						</div>
				      </div>
        			<div class="row">
        				<div class="body">
        					<div class="col-md-6">
        						<div class="form-group">
        						<div class="form-line">
        							<select class="form-control" id="barang" name="barang" data-error=".errorTxt10">
        								 <?php if(empty($gettarget['kode_barang'])){ ?>
        									<option value="">-- Pilih Barang --</option>
        								 <?php }else{ ?>
        									<option value="<?php echo $gettarget['kode_barang']; ?>"><?php echo $gettarget['nama_barang']; ?></option>
        								 <?php } ?>
        							</select>
        						</div>
        						<div class="errorTxt10"></div>
        					</div>
        					</div>
        					<div class="col-md-2">
        						<div class="form-group form-float">
        							<div class="form-line">
        								 <input type="text" style="text-align:center" value="0"  id="jumlah" name="jumlah" class="form-control" />
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
    									<thead class="bg-cyan">
    										<tr>
    											<th>Kode Produk</th>
    											<th>Nama Produk</th>
    											<th>Jumlah</th>
    											<th>Aksi</th>
    										</tr>
    									</thead>
    									<tbody id="loadtargetbulan">
    									</tbody>
    								</table>
    							</div>
    						</div>
    					</div>
               <div class="form-group" >
                   <button type="submit"  name="submit" class="btn bg-blue waves-effect">
                    <i class="material-icons">save</i>
                    <span>SIMPAN</span>
                  </button>
                  <a href="<?php echo base_url('sales/view_targettahun'); ?>" class="btn bg-red waves-effect">
                    <i class="material-icons">cancel</i>
                    <span>Batal</span>
                  </a>
              </div>
            </form>
		      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row clearfix">
	<div class="col-md-8">
		<div class="card">
			<div class="header bg-cyan">
				<h2>
					Data Target Pengiriman  Produk Per Bulan
					<small> Data Target Pengiriman Produk Per Bulan</small>
				</h2>
			</div>
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<form class="formValidate" autocomplete="off"  method="POST" action="" >
							<label>Tahun</label>
							<div class="form-group">
								<div class="form-line">
									<select class="form-control" id="tahun" name="tahun" data-error=".errorTxt9">
										 <option value="">-- Pilih Tahun -- </option>
										<?php $tahunnow = date('Y'); for($tahun=2019; $tahun<=$tahunnow; $tahun++){ ?>
											<option <?php if($tahun == $tahun){ echo "selected"; } ?>  value="<?php echo $tahun; ?>"><?php echo strtoupper($tahun); ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="errorTxt1"></div>
							</div>
							<div class="form-group">
								<div class="form-line">
									<select class="form-control" id="bulan" name="bulan" data-error=".errorTxt9">
										 <option value="">-- Pilih Bulan -- </option>
										<?php
										 $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Novemer","Desember");
										 for($i=1; $i<=12; $i++){
										 ?>
											<option <?php if($bl == $i){ echo "selected"; } ?> value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
										 <?php
										 }
										?>
									</select>
								</div>
								<div class="errorTxt9"></div>
							</div>
							<label>Cabang</label>
							<div class="form-group">
								<div class="form-line">
									<select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
											<option value="">Pilih Cabang</option>
									   <?php foreach($cabang as $c){ ?>
											<option <?php if($cb == $c->kode_cabang){ echo "selected"; } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="errorTxt1"></div>
							</div>
							<div class="form-group errorTxt11"></div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
						   <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
								<thead>
									<tr>
										<th>Tahun</th>
										<th>Bulan</th>
										<th>Cabang</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sno  = $row+1;
										foreach ($result as $d){
											$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Novemer","Desember");
									?>
										<tr>
											<td> <?php echo $d['tahun']; ?></td>
										<td> <?php echo $bulan[$d['bulan']]; ?></td>
											<td><?php echo $d['kode_cabang']; ?></td>
											<td>
												<a href="#" data-tahun="<?php echo $d['tahun']; ?>" data-bulan="<?php echo $d['bulan']; ?>" data-cabang="<?php echo $d['kode_cabang'] ?>" class="btn bg-blue btn-xs detail"><i class="material-icons">remove_red_eye</i></a>
												<a href="<?php echo base_url(); ?>oman/hapus_all_targettahun/<?php echo $d['tahun']; ?>/<?php echo $d['kode_cabang']; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a>
											</td>
										</tr>
									<?php
										$sno++;
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			 </div>
		</div>
	</div>
</div>
<div class="modal fade" id="detailtarget" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Detail Target
            <small>Detail Target</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
		            <div id="loaddetailtarget"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  $(function(){
		function loadtargetbulan(){
      var  cabang = $("#cabang").val();
		  var  tahun  = $("#tahun").val();
		  var  bulan  = $("#bulan").val();
      $("#loadtargetbulan").load("<?php echo base_url();?>oman/view_targetpengirimantemp/"+cabang+"/"+bulan+"/"+tahun);
    }

		function cek_targetbulantemp(){
			var  tahun   = $("#tahun").val();
			var cabang   = $("#cabang").val();
			var  bulan   = $("#bulan").val();
			$.ajax({
				type    : 'POST',
				url     : '<?php echo base_url(); ?>oman/cek_targetbulantemp',
				data    : {cabang:cabang,tahun:tahun,bulan:bulan},
				cache   : false,
				success : function(respond){
					$("#cek_targetbulantemp").val(respond);
				}
			});
		}


      $("#cabang").change(function(){
        var cabang = $("#cabang").val();
        //alert(cabang);
	        $.ajax({
            type    : 'POST',
            url     : '<?php echo base_url();?>target/loadbarang',
            data    : {cabang:cabang},
            cache   : false,
            success : function(respond){
             loadtargetbulan();
	           cek_targetbulantemp();
             $("#barang").html(respond);
             $("#barang").selectpicker("refresh");
            }
        });
      });

		$("#tahun").change(function(){
			loadtargetbulan();
			cek_targetbulantemp();
		});

		$("#bulan").change(function(){
			loadtargetbulan();
			cek_targetbulantemp();
		});

		$("#tambahbarang").click(function(e){
      e.preventDefault();
      var tahun 		  = $("#tahun").val();
			var bulan  		  = $("#bulan").val();
			var kode_barang = $("#barang").val();
      var jumlah      = $("#jumlah").val();
      var cabang      = $("#cabang").val();
			if(tahun==""){
        swal("Oops!", "Tahun Harus Diisi", "warning");
      }else if(bulan ==""){
          swal("Oops!", "Silahkan Pilih Bulan Terlebih Dahulu !", "warning");
      }else if(cabang ==""){
          swal("Oops!", "Silahkan Pilih Cabang Terlebih Dahulu !", "warning");
      }else if(kode_barang ==""){
          swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
      }
      else if(jumlah==0){
        swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
      }else{
        $.ajax({
            type    : 'POST',
            url     : '<?php echo base_url();?>oman/insert_targetbulantemp',
            data    : {
                        kode_barang :kode_barang,
            						tahun			  :tahun,
            						bulan 			:bulan,
            						jumlah			:jumlah,
            						cabang			:cabang

                      },
            cache   : false,
            success : function(respond){
              console.log(respond);
              if(respond == 1){
                swal("Oops!", "Data Sudah Ada!", "warning");
              }else{
                loadtargetbulan();
                cek_targetbulantemp();
              }
            }
          });
        }

    });

		$('.detail').click(function(e){
      e.preventDefault();
			var tahun 	= $(this).attr('data-tahun');
			var bulan 	= $(this).attr('data-bulan');
			var cabang 	= $(this).attr('data-cabang');
			$.ajax({
        type    : 'POST',
        url     : '<?php echo base_url(); ?>oman/detail_target_bulan',
        data    : {tahun:tahun,cabang:cabang,bulan:bulan},
        cache   : false,
        success : function(respond){
          $("#loaddetailtarget").html(respond);
        }
			});
      $("#detailtarget").modal("show");
    });
  });
</script>
