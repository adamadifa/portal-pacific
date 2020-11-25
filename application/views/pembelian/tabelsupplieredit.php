<table class="table table-bordered table-striped table-hover" style="width:100%"  id="tsupplier">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Supplier</th>
      <th>Nama Supplier</th>
      <th>Aksi</th>
    </tr>
  </thead>
</table>
<script type="text/javascript">
  $(function(){
    function loadkontrabon()
    {
      var supplier = $("#kodesupplier").val();
      $("#loadkontrabon").load('<?php echo base_url(); ?>pembelian/view_detailkontrabon_temp/'+supplier);
    }
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
    var t = $("#tsupplier").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#tsupplier_filter input')
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
      ajax          : {"url"  : "<?php echo base_url();?>pembelian/jsonPilihSupplier", "type": "POST"},
      columns       : [
                        {
                          "data"      : "kode_supplier",
                          "orderable" : false
                        },
                        {"data": "kode_supplier"},
                        {"data": "nama_supplier"},
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


  $('#tsupplier tbody').on('click', '.pilih', function () {
    var kodesupplier = $(this).attr('data-kode');
    var supplier     = $(this).attr('data-nama');
    $("#kodesupplier").val(kodesupplier);
    $("#supplier").val(supplier);
    $("#datasupplier").modal('hide');
    // $("#nobukti").val("");
    loadkontrabon();
  });
  })
</script>
