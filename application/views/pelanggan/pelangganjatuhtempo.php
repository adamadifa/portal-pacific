<div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          Pelanggan Jatuh Tempo
          <small>List Data Pelanggan Jatuh Tempo</small>
        </h2>
      </div>
      <div class="body">
         <div class="row">
          <div class="col-md-12">
            <div class="body">
              <form method="POST" action="<?php echo base_url(); ?>pelanggan/pelangganjatuhtempo" autocomplete="off">
                <?php if ($sess_cab == 'pusat'){ ?>
                  <div class="form-group">
                    <div class="form-line">
                      <select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
                        <option value="">-- Semua Cabang --</option>
                        <?php foreach($cabang as $c){ ?>
                          <option <?php if($cbg==$c->kode_cabang){echo "selected";} ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="errorTxt1"></div>
                  </div>
                <?php }else{ ?>
                  <input type="hidden" name="cabang" id="cabang" value="<?php echo $sess_cab; ?>" >
                <?php } ?>
                <div class="form-group">
                  <div class="form-line">
                    <select class="form-control show-tick" id="salesman" name="salesman" data-error=".errorTxt1">
                      <option value="">Semua Salesman</option>
                    </select>
                  </div>
                  <div class="errorTxt1"></div>
                </div>
                <div class="form-group"  >
                  <div class="form-line">
                    <input type="text" id="namapel" value="<?php echo $namapel; ?>"  name="namapel" class="form-control" placeholder="Nama Pelanggan" />
                  </div>
                </div>
               
                <div class="row clearfix">
                  <div class="col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-10">
                    <input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
                    
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
           
            <hr>
            Jumlah Data : <b style="color:red"><?php echo $allcount; ?> Pelanggan Memiliki Faktur Yang Melebihi Jatuh tempo dan Belum Melakukan pembayaran</b> <br>
            <hr>
            <div class="table-responsive">

              <table class="table table-bordered table-striped table-hover" id="" >
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>HP</th>
                    <th>Pasar</th>
                    <th>Hari</th>
                    <th>Cabang</th>
                    <th>Salesman</th>
                    <th>Jml Faktur</th>
                    <th>Koordinat</th>
                  
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sno  = $row+1;
                    foreach ($result as $d){
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['kode_pelanggan']; ?></td>
                      <td><?php echo $d['nama_pelanggan']; ?></td>
                      <td><?php echo $d['no_hp']; ?></td>
                      <td><?php echo $d['pasar']; ?></td>
                      <td><?php echo $d['hari']; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td><?php echo $d['nama_karyawan']; ?></td>
                      <td><a href="#" class="btn bg-red btn-xs detail" data-kodepelanggan = "<?php echo $d['kode_pelanggan']; ?>"><?php echo $d['jmlfaktur']; ?></a></td>
                      <td><?php echo $d['longitude']; ?></td>
                     
                    </tr>
                  <?php
                      $sno++; 
                    }
                  ?>
                </tbody>
              </table>
              
            </div>
            <div style='margin-top: 10px;'>
              <?php echo $pagination; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--------------------------------------INPUT DATA PELANGGAN---------------------------------------->
<div class="modal fade" id="detailfaktur" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div id="showdetail">

      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
$(function() {
  $('.datepicker').bootstrapMaterialDatePicker({
    format: 'YYYY-MM-DD',
    clearButton: true,
    weekStart: 1,
    time: false
  }); 
  $("#tambahpel").click(function() {
    $("#inputpelanggan").modal("show");
    $(".modal-content").load("<?php echo base_url();?>pelanggan/input_pelanggan");
  });

  $(".detail").click(function(e){
    e.preventDefault();
    var kodepelanggan = $(this).attr("data-kodepelanggan");
    $.ajax({
      type    : 'POST',
      url     : '<?php echo base_url();?>pelanggan/detailfakturjatuhtempo',
      data    : {kodepelanggan:kodepelanggan},
      cache   : false,
      success : function(respond){
        $("#detailfaktur").modal("show");
        $("#showdetail").html(respond);
      }
    });
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
      $('#mytable_filter input')
        .off('.DT')
        .on('keyup.DT', function(e) {
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
      "url": "<?php echo base_url();?>pelanggan/json",
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
        "data": "hari"
      },
      {
        "data": "nama_cabang"
      },
      {
        "data": "nama_karyawan"
      },
      {
        "data": "latitude"
      },
      {
        "data": "longitude"
      },
      {
        "data": "view"
      }
    ],
    order: [
      [1, 'asc']
    ],
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $('td:eq(0)', row).html(index);
    }
  });
});
</script>
