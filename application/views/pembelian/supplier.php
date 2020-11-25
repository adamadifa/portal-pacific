<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA SUPPLIER
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> DATA SUPPLIER </h4>
          </div>
          <div class="card-body">
            <a href="<?php echo base_url(); ?>pembelian/inputsupplier" class="btn btn-danger"> Tambah Data </a>
            <hr>
            <div class="table table-responsive">
              <table class="table table-bordered table-striped table-hover" id="mytable">
                <thead>
                  <tr class="thead-dark">
                    <th>No</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Contact Person</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No Rekening</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_pembelian_administrator'); ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {
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
        "url": "<?php echo base_url(); ?>pembelian/jsonSupplier/",
        "type": "POST"
      },
      columns: [{
          "data": "kode_supplier",
          "orderable": false
        },
        {
          "data": "kode_supplier"
        },
        {
          "data": "nama_supplier"
        },
        {
          "data": "contact_supplier"
        },
        {
          "data": "nohp_supplier"
        },
        {
          "data": "alamat_supplier"
        },
        {
          "data": "email"
        },
        {
          "data": "norekening"
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

    $('#mytable tbody').on('click', '.hapus', function() {
      var getLink = $(this).attr('data-href');
      swal({
        title: 'Alert',
        text: 'Hapus Data ?',
        html: true,
        confirmButtonColor: '#d43737',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
    });
  });
</script>