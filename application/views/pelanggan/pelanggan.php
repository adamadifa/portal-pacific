<div class="row clearfix">
  <div class="col-md-6">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          Laporan Pemasukan
          <small>  Laporan Pemasukan  </small>
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <div class="col-sm-12">
            <form class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pelanggan/cetak_pelanggan" target="_blank">

              <label>Cabang</label>
              <div class="form-group">
                <div class="col-md-12">
                  <div class="form-line">
                    <select class="form-control" name="cabang" id="cabang">
                      <option value="">-- SEMUA CABANG --</option>
                      <?php foreach ($cabang as $d) { ?>
                        <option value="<?php echo $d->kode_cabang;?>"><?php echo $d->nama_cabang;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

              <label>Sales</label>
              <div class="form-group">
                <div class="col-md-12">
                  <div class="form-line">
                    <select class="form-control show-tick" id="salesman" name="salesman" data-error=".errorTxt1">
                      <option value="">Semua Salesman</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group" >
                <button type="submit"  name="submit" class="btn bg-red waves-effect">
                  <i class="material-icons">print</i>
                  <span>CETAK</span>
                </button>
                <button type="submit"  name="export" class="btn bg-green waves-effect">
                  <i class="material-icons">file_download</i>
                  <span>EXPORT EXCEL</span>
                </button>
              </div>
            </form>
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

    $(".datepicker").bootstrapMaterialDatePicker({
      format: "YYYY-MM-DD",
      clearButton: true,
      weekStart: 1,
      time: false
    });

    
    function loadSalesman(){
      var cabang = $("#cabang").val();
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url();?>laporanpenjualan/get_salesman',
        data    : {cabang:cabang},
        cache   : false,
        success : function(respond){
          $("#salesman").html(respond);
          $("#salesman").selectpicker("refresh");
        }
      });
    }
    loadSalesman();
    $("#cabang").change(function(){
      var cabang = $("#cabang").val();
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url();?>laporanpenjualan/get_salesman',
        data    : {cabang:cabang},
        cache   : false,
        success : function(respond){
          $("#salesman").html(respond);
          $("#salesman").selectpicker("refresh");
        }

      });
    });

    $("#formValidate").validate({
      rules: {
        dari            :"required",
        sampai          :"required",

      },
      messages: {

        dari           :"Periode Harus Diisi",
        sampai         :"Periode Harus Diisi",

      },
      errorElement : 'div',
      errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
      }
    });

  });

</script>