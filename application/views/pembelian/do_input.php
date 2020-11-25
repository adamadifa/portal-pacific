
<div class="card">
  <div class="header bg-cyan">
    <h2>
      Data DO
      <small>Input Data DO</small>
    </h2>
  </div>
  <div class="body">
    <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>pembelian/insert_dotoko">
      <!-- <input type="text" name="jmldata" id="jmldata" value=""> -->
      <div class="row clearfix">
        <div class="col-sm-6">
          <div class="input-group demo-masked-input"  >
            <span class="input-group-addon">
              <i class="material-icons">chrome_reader_mode</i>
            </span>
            <div class="form-line">
              <input type="text" value="" id="nodo" name="nodo" class="form-control" placeholder="No DO" data-error=".errorTxt19" />
            </div>
          </div>
          <div class="input-group demo-masked-input"  >
            <span class="input-group-addon">
              <i class="material-icons">contacts</i>
            </span>
            <div class="form-line">
              <input type="hidden" value="" id="kodesupplier" name="kodesupplier" class="form-control" placeholder="Kode Supplier" data-error=".errorTxt19" />
              <input type="text" value="" id="supplier" name="supplier" class="form-control" placeholder="Supplier" data-error=".errorTxt19" />
            </div>
          </div>
          <div class="input-group demo-masked-input"  >
            <span class="input-group-addon">
              <i class="material-icons">date_range</i>
            </span>
            <div class="form-line">
              <input type="text" value="" id="tgl_do" name="tgl_do" class="form-control datepicker date" placeholder="Tanggal DO" data-error=".errorTxt19" />
            </div>
          </div>

          <div class="form-group" >
            <div class="form-line">
              <select class="form-control show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
                <option value="">--Pilih Departemen--</option>
                <?php foreach($pemohon as $d){ ?>
                  <option value="<?php echo $d->kode_dept; ?>"><?php echo $d->nama_dept; ?></option>
                <?php }  ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="info-box bg-cyan hover-zoom-effect" style="min-height:170px">
            <div class="icon" style="height:170px; padding:40px 0; width:200px">
              <i class="material-icons">shopping_cart</i>
            </div>
            <div class="content">
              <div id="grandtotal" style="padding:30px 0px 50px 0px; font-size:60px; margin-left:90px"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="body">
          <div class="col-md-3">
            <div class="input-group demo-masked-input"  >
              <span class="input-group-addon">
                <i class="material-icons">chrome_reader_mode</i>
              </span>
              <div class="form-line">
                <input type="hidden" value="" id="nobpb" name="nobpb" class="form-control" placeholder="No BPB" data-error=".errorTxt19" />
                <input type="hidden" value="" id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt19" />
                <input type="text" readonly value="" id="barang" name="barang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt19" />
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group demo-masked-input"  >
              <span class="input-group-addon">
                <i class="material-icons">chrome_reader_mode</i>
              </span>
              <div class="form-line">
                <input type="text" style="text-align:right" value="" readonly id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group demo-masked-input"  >
              <span class="input-group-addon">
                <i class="material-icons">chrome_reader_mode</i>
              </span>
              <div class="form-line">
                <input type="text" style="text-align:right" value="" id="jenisbarang" readonly name="jenisbarang" class="form-control" placeholder="Jenis Barang" data-error=".errorTxt19" />
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
                  <th>No BPB</th>
                  <th>Tgl</th>
                  <th>Nama Barang</th>
                  <th>Qty</th>
                  <th>Ket</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="loaddotoko">
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row clearfix">
        <div class="col-md-offset-10">
          <input type="submit" name="submit" class="btn btn-lg bg-teal  waves-effect" value="SIMPAN">
        </div>
      </div>
    </form>
  </div>
</div>
<!---MODAL DATA SUPPLIER-->
<div class="modal fade" id="datasupplier" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card">
      <div class="header bg-cyan">
        <h2>
          Data Supplier
          <small>Pilih Data Supplier</small>
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <div class="col-sm-12" id="tabelsupplier">
          </div>
        </div>
      </div>
			</div>
		</div>
  </div>
</div>
<!---MODAL DATA BARANG-->
<div class="modal fade" id="databarang" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" style="min-width:1300px" role="document">
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
<!---MODAL DATA AKUN-->
<div class="modal fade" id="dataakun" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
      <div class="header bg-cyan">
        <h2>
          Data Akun
          <small>Pilih Data Akun</small>
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <div class="col-sm-12" id="tabelakun">
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
      var nodo            = $("#nodo").val();
      var supplier        = $("#supplier").val();
      var tgl_do          = $("#tgl_do").val();
      var departemen      = $("#departemen").val();1

      if(nodo == "")
      {
        swal("Oops!", "NO DO Harus Diisi !", "warning");
        return false;
      }else if(supplier == "")
      {
        swal("Oops!", "Supplier Harus Diisi !", "warning");
        return false;
      }else if(tgl_do == "")
      {
        swal("Oops!", "Tanggal DO Harus Diisi !", "warning");
        return false;
      }else if(departemen == "")
      {
        swal("Oops!", "Departemen Harus Diisi !", "warning");
        return false;
      }else{
        return true;
      }
    });

    function loadNobukti()
    {
      var kodedept      = $("#departemen").val();
      var tgl_do        = $("#tgl_do").val();
      $.ajax({
        type     : 'POST',
        url      : '<?php echo base_url(); ?>pembelian/getNoDO',
        data     : {kodedept:kodedept,tgl_do:tgl_do},
        cache    : false,
        success  : function(respond){
          $("#nodo").val(respond);
        }
      });
    }

    $("#departemen").change(function(){
      loadNobukti();
    });
    $("#tgl_pembelian").change(function(){
      loadNobukti();
    });

    function loadtabelbarang()
    {
      var departemen = $("#departemen").val();
      $("#tabelbarang").load("<?php echo base_url(); ?>pembelian/tabelbarangdo/"+departemen);
    }

    function loadtabelsupplier()
    {
      $("#tabelsupplier").load("<?php echo base_url(); ?>pembelian/tabelsupplier");
    }

    function loaddotoko()
    {
      var departemen = $("#departemen").val();
      $("#loaddotoko").load('<?php echo base_url(); ?>pembelian/dodetailtemp/'+departemen);
    }

    loaddotoko();
    loadtabelsupplier();
    //loadjmldata();
    $("#departemen").change(function(){
      loaddotoko();
    });

    $("#barang").click(function(){
      var departemen = $("#departemen").val();
      if(departemen =="")
      {
        swal("Oops!", "Departemen Harus Diisi !", "warning");
      }else{
        loadtabelbarang();
        $("#databarang").modal("show");
      }

    });

    $("#supplier").click(function(){
      $("#datasupplier").modal("show");
    });



    function resetBrg()
    {
      $("#kodebarang").val("");
      $("#barang").val("");
      $("#jumlah").val("");
      $("#keterangan").val("");
      $("#satuan").val("");
    }

    $("#tambahbarang").click(function(e){
      e.preventDefault();
      var nodo        = $("#nodo").val();
      var nobpb       = $("#nobpb").val();
      var kodebarang  = $("#kodebarang").val();
      var barang      = $("#barang").val();
      var jumlah      = $("#jumlah").val();
      var keterangan  = $("#keterangan").val();
      var kodedept    = $("#departemen").val();
      if(barang ==""){
        swal("Oops!", "Nama Barang Harus Diisi !", "warning");
      }else if(jumlah ==""){
        swal("Oops!", "Jumlah Tidak Boleh Kosong!", "warning");
      }else{
        $.ajax({
          type      : 'POST',
          url       : '<?php echo base_url(); ?>pembelian/insertdetaildotemp',
          data      : {nobpb:nobpb,kodebarang:kodebarang,kodedept:kodedept,jumlah:jumlah},
          cache     : false,
          success   : function(respond){
            if(respond == 1){
            swal("Oops!", "Data Sudah Di Inputkan!", "warning");
            }
            loaddotoko();
            //loadjmldata();
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


  });
</script>
