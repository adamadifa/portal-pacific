<div class="row clearfix">
	<div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          Data Master Barang
          <small>List Data Master Barang</small>
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <div class="col-sm-12">
            <a href="#" class="btn bg-red waves-effect" id="tambahbarang"> Tambah Data </a>

            <table class="table table-bordered table-striped table-hover" id="mytable">
              <thead>
                <tr>
                  <th width="10px">No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jenis Barang</th>
                  <th>Status</th>
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
<!--INPUT DATA Barang--->
<div class="modal fade" id="inputbarang" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function(){
    $("#tambahbarang").click(function(){
      $("#inputbarang").modal("show");
      $(".modal-content").load("<?php echo base_url();?>produksi/input_barang");
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
        $('#mytable_filter input')
        .off('.DT')
        .on('keyup.DT', function(e){
          if (e.keyCode == 13) {
            api.search(this.value).draw();
          }
        });
      },
      oLanguage: {
        sProcessing: "loading..."
      },
      processing    : true,
      serverSide    : true,
      bLengthChange : false,
      ajax          : {"url"  : "<?php echo base_url();?>produksi/jsonBarang/", "type": "POST"},
      columns       : [
      {
        "data"      : "kode_barang",
        "orderable" : false
      },
      {"data": "kode_barang"},
      {"data": "nama_barang"},
      {"data": "satuan"},
      {"data": "jenis_barang"},
      {"data": "status"},
      {"data": "view"}
      ],
      order       : [[1, 'asc']],
      rowCallback : function(row, data, iDisplayIndex) {
        var info    = this.fnPagingInfo();
        var page    = info.iPage;
        var length  = info.iLength;
        var index   = page * length + (iDisplayIndex + 1);
        $('td:eq(0)', row).html(index);
      }
    });

    $('#mytable tbody').on('click', '.hapus', function () {
     var getLink = $(this).attr('data-href');
     swal({
       title               : 'Alert',
       text                : 'Hapus Data ?',
       html                : true,
       confirmButtonColor  : '#d43737',
       showCancelButton    : true,
     },function(){
       window.location.href = getLink
     });
   });

    $('#mytable tbody').on('click', '.edit', function () {
      var kodebarang = $(this).attr('data-kode');
      $.ajax({
        type   :'POST',
        url    : '<?php echo base_url();?>produksi/edit_barang',
        data   : {kodebarang:kodebarang},
        cache  : false,
        success: function(respond){
          $("#inputbarang").modal("show");
          $(".modal-content").html(respond);
        }
      });
    });
  });
</script>
