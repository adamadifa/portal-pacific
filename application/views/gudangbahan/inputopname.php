
<div class="row clearfix">
  <div class="col-md-8">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
         INPUT OPNAME GUDANG BAHAN
         <small>Form Input Opname</small>
       </h2>
     </div>
     <div class="body">
      <div class="row">
        <div class="col-md-12">
          <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>gudangbahan/input_opname">
            <div class="input-group demo-masked-input"  >
              <span class="input-group-addon">
                <i class="material-icons">chrome_reader_mode</i>
              </span>
              <div class="form-line">
                <input type="text" readonly value="" id="kode_opname_gb" name="kode_opname_gb" class="form-control" placeholder="Kode opname Awal" data-error=".errorTxt19" />
                <input type="hidden" readonly  id="getsa" name="getsa" value="0" class="form-control" />
                <input type="hidden" name="jumlahproduk" id="jumlahproduk">
              </div>
            </div>
            <div class="form-group" >
              <div class="form-line">
                <select class="form-control" id="bulan" name="bulan">
                  <option value="">Bulan</option>
                  <?php for($a=1; $a<=12; $a++){ ?>
                    <option value="<?php echo $a;?>"><?php echo $bulan[$a]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group" >
              <div class="form-line">
                <select class="form-control" id="tahun" name="tahun">
                  <option value="">Tahun</option>
                  <?php for($t=2019; $t<=$tahun; $t++){ ?>
                    <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="input-group demo-masked-input"  >
              <span class="input-group-addon">
                <i class="material-icons">date_range</i>
              </span>
              <div class="form-line">
                <input type="text" readonly value="" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
              </div>
            </div>
            <div class="row clearfix">
              <div class="col-md-offset-10">
                <a href="#" id="getopname" class="btn btn-sm bg-green  waves-effect">GET opname</a>
              </div>
            </div>
            <hr>
            <table class="table table-bordered">
              <thead class = "" >
                <tr>
                  <th rowspan="3" align="">No</th>
                  <th rowspan="3" style="text-align:center">Nama Barang</th>
                </tr>
                <tr>
                  <th colspan="6" style="text-align:center">Kuantitas</th>
                </tr>
                <tr>
                  <th style="text-align:center">QTY Unit</th>
                  <th style="text-align:center">QTY Berat</th>
                </tr>
              </thead>
              <tbody id="loaddetailopname">

              </tbody>
            </table>

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

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  $(function(){

    function loadNoMutasi()
    {
      var bulan           = $("#bulan").val();
      var tahun           = $("#tahun").val();
      var status          = "GB";
      var thn             = tahun.substr(2,2);
      if(parseInt(bulan.length)==1){
        var bln = "0"+bulan;
      }else{
        var bln = bulan;
      }
      var kode    = status+bln+thn;
      $("#kode_opname_gb").val(kode);
    }

    function loaddetailopname()
    {
      var bulan                   = $("#bulan").val();
      var tahun                   = $("#tahun").val();
      var thn                     = tahun.substr(2,2);
      if(bulan == ""){
        swal("Oops!", "Bulan Harus Diisi !", "warning");
        return false;
      }else if(tahun == ""){
        swal("Oops!", "Tahun Harus Diisi !", "warning");
        return false;
      }else if(tanggal == ""){
        swal("Oops!", "Tanggal Harus Diisi !", "warning");
        return false;
      }else{
        $.ajax({
          type    : 'POST',
          url     : '<?php echo base_url(); ?>gudangbahan/getdetailopname',
          data    : {bulan:bulan,tahun:tahun},
          cache   : false,
          success : function(respond)
          {
            if(respond==1)
            {
              $("#getsa").val(0);
              swal("Oops!", "Opname Bulan Sebelumnya Belum Diset! Atau Opname Bulan Tersebut Sudah Ada", "warning");
            }else{
              $("#getsa").val(1);
              $("#loaddetailopname").html(respond);
            }
          }
        });
      }
    }
    $("#getopname").click(function(e){
      e.preventDefault();
      loaddetailopname();
    });
    $("#bulan").change(function(){
      loadNoMutasi();
    });
    $("#kode_kategori").change(function(){
      loadNoMutasi();
    });

    $("#tahun").change(function(){
      loadNoMutasi();
    });

    $(".formValidate").submit(function(){
      var kode_opname_gb   = $("#kode_opname_gb").val();
      var cabang           = $("#cabang").val();
      var bulan            = $("#bulan").val();
      var tahun            = $("#tahun").val();
      var tanggal          = $("#tanggal").val();
      var getsa            = $("#getsa").val();
      if(kode_opname_gb == ""){
        swal("Oops!", "opname Awal Harus Diisi!", "warning");
        return false;
      }else if(cabang == ""){
        swal("Oops!", "Cabang Harus Diisi !", "warning");
        return false;
      }else if(bulan == ""){
        swal("Oops!", "Bulan Harus Diisi !", "warning");
        return false;
      }else if(tahun == ""){
        swal("Oops!", "Tahun Harus Diisi !", "warning");
        return false;
      }else if(tanggal == ""){
        swal("Oops!", "Tanggal Harus Diisi !", "warning");
        $("#tanggal").focus();
        return false;
      }else if(getsa == 0){
        swal("Oops!", "Lakukan Get opname Terlebih Dahulu !", "warning");
        return false;
      }
    });

    $('#mytable tbody').on('click', 'a', function () {
     $("#no_sj").val($(this).attr("data-nosj"));
     $("#datasj").modal("hide");
     loadNoMutasi();
   });

    $('.datepicker').bootstrapMaterialDatePicker({
      format      : 'YYYY-MM-DD',
      clearButton : true,
      weekStart   : 1,
      time        : false
    });

  });
</script>
