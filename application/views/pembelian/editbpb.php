<div class="row clearfix">
  <div class="col-md-10">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
           EDIT BUKTI PERMINTAAN BARANG (BPB)
          <small>Bukti Permintaan Barang (BPB)</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>pembelian/update_bpb">
              <div class="row">
                <div class="body">
                  <div class="col-md-12">
                    <div class="input-group demo-masked-input"  >
                      <span class="input-group-addon">
                        <i class="material-icons">chrome_reader_mode</i>
                      </span>
                      <div class="form-line">
                        <input type="text" value="<?php echo $bpb['no_bpb']; ?>" id="nobpb" name="nobpb" class="form-control" placeholder="No BPB" data-error=".errorTxt19" />
                      </div>
                    </div>
                    <div class="input-group demo-masked-input"  >
                      <span class="input-group-addon">
                        <i class="material-icons">date_range</i>
                      </span>
                      <div class="form-line">
                        <input type="text" value="<?php echo $bpb['tgl_permintaan']; ?>" id="tgl_permintaan" name="tgl_permintaan" class="form-control date datepicker" placeholder="Tanggal Permintaan" data-error=".errorTxt19" />
                      </div>
                    </div>
                    <div class="input-group demo-masked-input"  >
                      <span class="input-group-addon">
                        <i class="material-icons">contacts</i>
                      </span>
                      <div class="form-line">
                        <input type="text" value="<?php echo $bpb['yangmengajukan']; ?>" id="yangmengajukan" name="yangmengajukan" class="form-control" placeholder="Yang Mengajukan" data-error=".errorTxt19" />
                      </div>
                    </div>
                    <div class="form-group" >
                      <div class="form-line">
                        <select class="form-control show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
                          <option value="">--Departemen--</option>
                          <?php foreach($pemohon as $d){ ?>
                            <option <?php if($bpb['kode_dept']==$d->kode_dept){echo "selected";} ?> value="<?php echo $d->kode_dept; ?>"><?php echo $d->nama_dept; ?></option>
                          <?php }  ?>
                        </select>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="body">
                  <div class="col-md-4">
                    <div class="input-group demo-masked-input"  >
                      <span class="input-group-addon">
                        <i class="material-icons">chrome_reader_mode</i>
                      </span>
                      <div class="form-line">
                        <input type="hidden" value="" id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt19" />
                        <input type="text" readonly value="" id="barang" name="barang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt19" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="input-group demo-masked-input"  >
                      <span class="input-group-addon">
                        <i class="material-icons">chrome_reader_mode</i>
                      </span>
                      <div class="form-line">
                        <input type="text" style="text-align:right" value="" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt19" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group demo-masked-input"  >
                      <span class="input-group-addon">
                        <i class="material-icons">chrome_reader_mode</i>
                      </span>
                      <div class="form-line">
                        <input type="text" style="text-align:right" value="" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
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
                  <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Barang</th>
                          <th>Kuantitas</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="loadpermintaanbarang">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-md-offset-10">
                  <input type="submit" name="submit" class="btn btn-sm bg-blue  waves-effect" value="SIMPAN">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">

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
		        <div class="col-sm-12" id="tabelbarang">



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


    $(".formValidate").submit(function(){
      var nobpb           = $("#nobpb").val();
      var tgl_permintaan  = $("#tgl_permintaan").val();
      var pemohon         = $("#pemohon").val();
      var departemen      = $("#departemen").val();
      var yangmengajukan  = $("#yangmengajukan").val();

      if(nobpb == "")
      {
        swal("Oops!", "NO BPB Harus Diisi !", "warning");
        return false;
      }else if(tgl_permintaan=="") {
        swal("Oops!", "Tanggal Permintaan Harus Diisi !", "warning");
        return false;
      }else if(pemohon==""){
        swal("Oops!", "Yang Mengajukan Harus Diisi !", "warning");
        return false;
      }else if(departemen==""){
        swal("Oops!", "Departemen Harus Diisi !", "warning");
        return false;
      }else if(yangmengajukan==""){
        swal("Oops!", "Yang Mengajukan Harus Diisi !", "warning");
        return false;
      }else{
        return true;
      }
    });

    function resetBrg()
    {
      $("#kodebarang").val("");
      $("#barang").val("");
      $("#jumlah").val("");
      $("#keterangan").val("");
    }
    function loadpermintaanbarang()
    {
      var no_bpb = $("#nobpb").val();
      var nobpb  = no_bpb.replace(/\//g, '.');
      //alert(nobpb);
      $("#loadpermintaanbarang").load('<?php echo base_url(); ?>pembelian/view_detailbpb/'+nobpb);
    }
    function loadtabelbarang()
    {
      var pemohon = $("#departemen").val();
      $("#tabelbarang").load("<?php echo base_url(); ?>pembelian/tabelbarang/"+pemohon);
    }
    loadpermintaanbarang();
    $("#tambahbarang").click(function(e){
      e.preventDefault();
      var nobpb       = $("#nobpb").val();
      var kodebarang  = $("#kodebarang").val();
      var barang      = $("#barang").val();
      var jumlah      = $("#jumlah").val();
      var keterangan  = $("#keterangan").val();
      if(barang ==""){
        swal("Oops!", "Nama Barang Harus Diisi !", "warning");
      }else if(jumlah ==""){
        swal("Oops!", "Jumlah Tidak Boleh Kosong!", "warning");
      }else if(jumlah ==""){
        swal("Oops!", "Keterangan Harus Diisi!", "warning");
      }else{
        $.ajax({
          type      : 'POST',
          url       : '<?php echo base_url(); ?>pembelian/insertdetailbpb',
          data      : {nobpb:nobpb,kodebarang:kodebarang,barang:barang,jumlah:jumlah,keterangan:keterangan},
          cache     : false,
          success   : function(respond){
            if(respond == 1){
             swal("Oops!", "Data Sudah Di Inputkan!", "warning");
            }
            loadpermintaanbarang();
            resetBrg();
          }
        });
      }
    });

    $('.datepicker').bootstrapMaterialDatePicker({
      format      : 'YYYY-MM-DD',
      clearButton : true,
      weekStart   : 1,
      time        : false
    });

    $("#barang").click(function(){
      var pemohon = $("#departemen").val();
      if(pemohon =="")
      {
        swal("Oops!", "Pemohon Harus Diisi !", "warning");
      }else{
        loadtabelbarang();
        $("#databarang").modal("show");
      }


    });




  });
</script>
