
<div class="row clearfix">
  <div class="col-md-8">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
           INPUT SALDO AWAL DPB
          <small>Input Saldo Awal DPB </small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>dpb/input_saldoawaldpb">
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">chrome_reader_mode</i>
                </span>
                <div class="form-line">
                  <input type="text" readonly value="" id="kode_saldoawal" name="kode_saldoawal" class="form-control" placeholder="Kode Saldo Awal" data-error=".errorTxt19" />
                  <input type="hidden" readonly  id="status" name="status" class="form-control" value="<?php echo $status; ?>" />
                  <input type="hidden" readonly  id="getsa" name="getsa" value="0" class="form-control" />
                </div>
              </div>
              <?php if($cb == 'pusat'){ ?>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control" id="cabang" name="cabang">
                    <option value="">Pilih Cabang</option>
                    <?php foreach($cabang as $c){ ?>
                      <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                     <?php } ?>
                  </select>
                </div>
              </div>
              <?php }else{ ?>
                <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang"  />
              <?php } ?>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control" id="bulan" name="bulan">
                    <option value="">Bulan</option>
                    <?php for($a=1; $a<=12; $a++){ ?>
                      <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
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
                  <a href="#" id="getsaldo" class="btn btn-sm bg-green  waves-effect">GET SALDO</a>
                </div>
              </div>
              <hr>
              <table class="table table-bordered">
                <thead class = "" >
                  <tr>
                    <th rowspan="3" align="">No</th>
                    <th rowspan="3" style="text-align:center">Nama Barang</th>
                    <th colspan="6" style="text-align:center">Saldo Awal <?php echo $status;  ?></th>
                  </tr>
                  <tr>
                    <th colspan="6" style="text-align:center">Kuantitas</th>
                  </tr>
                  <tr>
                    <th style="text-align:center">Jumlah</th>
                    <th style="text-align:center">Satuan</th>
                    <th style="text-align:center">Jumlah</th>
                    <th style="text-align:center">Satuan</th>
                    <th style="text-align:center">Jumlah</th>
                    <th style="text-align:center">Satuan</th>
                  </tr>
                </thead>
                <tbody id="loaddetailsaldo">

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
      var bulan   = $("#bulan").val();
      var cabang  = $("#cabang").val();
      var tahun   = $("#tahun").val();
      var status  = $("#status").val();
      var thn     = tahun.substr(2,2);
      if(parseInt(bulan.length)==1){
        var bln = "0"+bulan;
      }else{
        var bln = bulan;
      }
      var kode    = "GJ"+cabang+bln+thn;
      $("#kode_saldoawal").val(kode);
    }

    function loaddetailsaldo()
    {
      var bulan          = $("#bulan").val();
      var cabang         = $("#cabang").val();
      var tahun          = $("#tahun").val();
      var thn            = tahun.substr(2,2);
      if(cabang == ""){
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
        return false;
      }else{
        $.ajax({
          type    : 'POST',
          url     : '<?php echo base_url(); ?>dpb/getdetailsaldodpb',
          data    : {bulan:bulan,tahun:tahun,cabang:cabang},
          cache   : false,
          success : function(respond)
          {
            if(respond==1)
            {
              $("#getsa").val(0);
              swal("Oops!", "Saldo Bulan Sebelumnya Belum Diset! Atau Saldo Bulan Tersebut Sudah Ada", "warning");
            }else{
              $("#getsa").val(1);
              $("#loaddetailsaldo").html(respond);
            }
          }
        });
      }
    }
    $("#getsaldo").click(function(e){
      e.preventDefault();
      loaddetailsaldo();
    });
    $("#cabang").change(function(){
      loadNoMutasi();
    });

    $("#bulan").change(function(){
      loadNoMutasi();
    });

    $("#tahun").change(function(){
      loadNoMutasi();
    });

    $(".formValidate").submit(function(){
      var kode_saldoawal   = $("#kode_saldoawal").val();
      var cabang           = $("#cabang").val();
      var bulan            = $("#bulan").val();
      var tahun            = $("#tahun").val();
      var tanggal          = $("#tanggal").val();
      var getsa            = $("#getsa").val();
      if(kode_saldoawal == ""){
        swal("Oops!", "Saldo Awal Harus Diisi!", "warning");
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
        return false;
      }else if(getsa == 0){
        swal("Oops!", "Lakukan Get Saldo Terlebih Dahulu !", "warning");
        return false;
      }
    });


    //Datatable Dpb
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
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
	    processing		: true,
	    serverSide		: true,
	    bLengthChange	: false,
	    ajax					: {"url": "<?php echo base_url();?>repackreject/jsonsj", "type": "POST"},
	    columns				: [
						            {
					                "data": "no_mutasi_gudang_cabang",
					                "orderable": false
						            },
						            {"data": "no_mutasi_gudang_cabang"},
						            {"data": "tgl_mutasi_gudang_cabang"},
						            {"data": "kode_cabang"},
						            {"data": "view"}
							        ],
	    order				: [[1, 'desc']],
	    rowCallback	: function(row, data, iDisplayIndex) {
	      var info 		= this.fnPagingInfo();
	      var page 		= info.iPage;
	      var length 	= info.iLength;
	      var index 	= page * length + (iDisplayIndex + 1);
	      $('td:eq(0)', row).html(index);
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
