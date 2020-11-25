<table class="table table-bordered table-striped table-hover" style="width:100%"  id="mytable">
  <thead>
    <tr>
      <th>No</th>
      <th>No BPB</th>
      <th>Tgl Permintaan</th>
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>Satuan</th>
      <th>Jml</th>
      <th>Dept</th>
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
      ajax          : {"url"  : "<?php echo base_url();?>pembelian/jsonPIlihBarangDO/<?php echo $kode_dept; ?>", "type": "POST"},
      columns       : [
                        {
                          "data"      : "kode_barang",
                          "orderable" : false
                        },
                        {"data": "no_bpb"},
                        {"data": "tgl_permintaan"},
                        {"data": "kode_barang"},
                        {"data": "nama_barang"},
                        {"data": "satuan"},
                        {"data": "jumlah"},
                        {"data": "kode_dept"},
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


  $('#mytable tbody').on('click', '.pilih', function () {
    var nobpb      = $(this).attr('data-nobpb');
    var kodebarang = $(this).attr('data-kode');
    var namabarang = $(this).attr('data-nama');
    var keterangan = $(this).attr('data-ket');
    var jenis      = $(this).attr('data-jenis');
    var jml        = $(this).attr('data-jml');
    $("#nobpb").val(nobpb);
    $("#kodebarang").val(kodebarang);
    $("#barang").val(namabarang);
    $("#keterangan").val(keterangan);
    $("#jenisbarang").val(jenis);
    $("#jumlah").val(jml);
    $("#databarang").modal('hide');
  });
});
</script>
