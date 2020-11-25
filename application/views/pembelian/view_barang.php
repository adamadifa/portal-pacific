<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Master Barang
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
            <h4 class="card-title"> Data Master Barang </h4>
          </div>
          <div class="card-body">
            <a href="#" class="btn btn-danger" id="tambahbarang"> Tambah Data </a>
            <hr>
            <table class="table table-bordered table-striped table-hover" id="mytable">
              <thead class="thead-dark">
                <tr>
                  <th width="10px">No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jenis Barang</th>
                  <th>Departemen</th>
                  <th>Kategori</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php
      $level = $this->session->userdata('level_user');
      if ($level == "Administrator") {
        $this->load->view('menu/menu_pembelian_administrator');
      } else if ($level == "admin ga") {
        $this->load->view('menu/menu_master_ga');
      } else if ($level == "manager accounting") {
        $this->load->view('menu/menu_masterpenjualan');
      }

      ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="inputbarang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Barang</h5>
      </div>
      <div class="modal-body">
        <div id="loadinputbarang"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $("#tambahbarang").click(function() {
      $("#inputbarang").modal("show");
      $("#loadinputbarang").load("<?php echo base_url(); ?>pembelian/input_barang");
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
    var pemohon = $("#pemohon").val();
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
        "url": "<?php echo base_url(); ?>pembelian/jsonBarang/" + pemohon,
        "type": "POST"
      },
      columns: [{
          "data": "kode_barang",
          "orderable": false
        },
        {
          "data": "kode_barang"
        },
        {
          "data": "nama_barang"
        },
        {
          "data": "satuan"
        },
        {
          "data": "jenis_barang"
        },
        {
          "data": "nama_dept"
        },
        {
          "data": "kategori"
        },
        {
          "data": "status"
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

    $('#mytable tbody').on('click', '.edit', function() {
      var kodebarang = $(this).attr('data-kode');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/edit_barang',
        data: {
          kodebarang: kodebarang
        },
        cache: false,
        success: function(respond) {
          $("#inputbarang").modal("show");
          $("#loadinputbarang").html(respond);
        }
      });
    });
  });
</script>