<table class="table table-bordered table-striped table-hover" style="width:100%"  id="akun">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Akun</th>
      <th>Nama Akun</th>
      <th>Aksi</th>
    </tr>
  </thead>
</table>
<script type="text/javascript">
  $(function(){
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
    var t = $("#akun").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#akun_filter input')
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
      ajax          : {"url"  : "<?php echo base_url();?>produksi/jsonPilihAkun", "type": "POST"},
      columns       : [
      {
        "data"      : "kode_akun",
        "orderable" : false
      },
      {"data": "kode_akun"},
      {"data": "nama_akun"},
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


    $('#akun tbody').on('click', '.pilih', function () {
      var kodeakun = $(this).attr('data-kode');
      var namaakun = $(this).attr('data-nama');
      $("#kodeakun").val(kodeakun);
      $("#namaakun").val(namaakun);
      $("#dataakun").modal('hide');
    });
  })
</script>
