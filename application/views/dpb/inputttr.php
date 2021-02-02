<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          INPUT DATA REKAP TTR DPB
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="col-md-7">

          <div class="card">
            <div class="card-header">
              <h4 class="card-title">INPUT DATA REKAP TTR DPB </h4>
            </div>
            <div class="card-body">
              <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>dpb/input_ttr">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly value="" id="no_mutasi" name="no_mutasi" class="form-control" placeholder="No Mutasi TTR" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly value="" id="nodpb" name="nodpb" class="form-control" placeholder="No DPB" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="text" readonly value="" id="tgl_pengambilan" name="tgl_pengambilan" class="form-control" placeholder="Tanggal Pengambilan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-building-o"></i>
                    </span>
                    <input type="text" readonly value="" id="cabang" name="cabang" class="form-control" placeholder="Cabang" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-users"></i>
                    </span>
                    <input type="text" readonly value="" id="salesman" name="salesman" class="form-control" placeholder="Salesman" data-error=".errorTxt19" />
                    <input type="hidden" readonly value="" id="id_karyawan" name="id_karyawan" class="form-control" placeholder="ID" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-map"></i>
                    </span>
                    <input type="text" readonly value="" id="tujuan" name="tujuan" class="form-control" placeholder="Tujuan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-truck"></i>
                    </span>
                    <input type="text" readonly value="" id="nokendaraan" name="nokendaraan" class="form-control" placeholder="No Kendaraan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="text" readonly value="" id="tgl_gb" name="tanggal" class="form-control datepicker" placeholder="Tanggal TTR" data-error=".errorTxt19" />
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th rowspan="3" align="">No</th>
                      <th rowspan="3" style="text-align:center">Nama Barang</th>
                      <th colspan="6" style="text-align:center">TTR</th>
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
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($barang as $b) {
                    ?>
                      <tr>
                        <td style="width:10px"><?php echo $no; ?></td>
                        <td style="width:200px">
                          <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $b->kode_produk; ?>">
                          <input type="hidden" name="isipcsdus<?php echo $no; ?>" value="<?php echo $b->isipcsdus; ?>">
                          <input type="hidden" name="isipack<?php echo $no; ?>" value="<?php echo $b->isipack; ?>">
                          <input type="hidden" name="isipcs<?php echo $no; ?>" value="<?php echo $b->isipcs; ?>">
                          <?php echo $b->nama_barang; ?>
                        </td>
                        <td style="width:100px">
                          <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                            <div class="form-line">
                              <input type="text" style="text-align:right" value="" id="jmldus" name="jmldus<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                            </div>
                          </div>
                        </td>
                        <td style="width:50px"><?php echo $b->satuan; ?></td>
                        <td style="width:100px">
                          <?php if (!empty($b->isipack)) { ?>
                            <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                              <div class="form-line">
                                <input type="text" style="text-align:right" value="" id="jmlpack" name="jmlpack<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                              </div>
                            </div>
                          <?php } ?>
                        </td>
                        <td style="width:50px">Pack</td>
                        <td style="width:100px">
                          <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                            <div class="form-line">
                              <input type="text" style="text-align:right" value="" id="jmlpcs" name="jmlpcs<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                            </div>
                          </div>
                        </td>
                        <td style="width:50px">Pcs</td>
                      </tr>
                    <?php
                      $no++;
                      $jumproduk = $no - 1;
                    }
                    ?>
                    <input type="hidden" value="<?php echo $jumproduk; ?>" name="jumproduk">
                  </tbody>
                </table>
                <div class="mb-3 d-flex justify-content-end">
                  <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_gudangcabang_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="datadpb" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped table-hover" id="mytable">
          <thead class="thead-dark">
            <tr>
              <th width="10px">No</th>
              <th>No DPB</th>
              <th>Tanggal Pengambilan</th>
              <th>Nama Salesman</th>
              <th>Nama Cabang</th>
              <th>Tujuan</th>
              <th>No Kendaraan</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  flatpickr(document.getElementById('tgl_gb'), {});
</script>
<script type="text/javascript">
  $(function() {

    function loadNoMutasi() {
      var nodpb = $("#nodpb").val();
      $.ajax({
        url: '<?php echo base_url(); ?>dpb/getNomutasiTTR',
        type: 'POST',
        data: {
          nodpb: nodpb
        },
        cache: false,
        success: function(respond) {
          $("#no_mutasi").val(respond);
          console.log(respond);
        }
      });
    }
    $(".formValidate").submit(function() {
      var nodpb = $("#nodpb").val();
      var tanggal = $("#tgl_gb").val();
      if (nodpb == "") {
        swal("Oops!", "No DPB Harus Diisi!", "warning");
        return false;
      } else if (tanggal == "") {
        swal("Oops!", "Tanggal TTR Diisi!", "warning");
        return false;
      }
    });
    $("#nodpb").click(function() {
      $("#datadpb").modal("show");
    });

    //Datatable Dpb
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
        $('#mytable_filter input').off('.DT').on('keyup.DT', function(e) {
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
        "url": "<?php echo base_url(); ?>dpb/jsondpb",
        "type": "POST"
      },
      columns: [{
          "data": "no_dpb",
          "orderable": false
        },
        {
          "data": "no_dpb"
        },
        {
          "data": "tgl_pengambilan"
        },
        {
          "data": "nama_karyawan"
        },
        {
          "data": "kode_cabang"
        },
        {
          "data": "tujuan"
        },
        {
          "data": "no_kendaraan"
        },
        {
          "data": "view"
        }
      ],
      order: [
        [1, 'desc']
      ],
      rowCallback: function(row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        var index = page * length + (iDisplayIndex + 1);
        $('td:eq(0)', row).html(index);
      }


    });
    $('#mytable tbody').on('click', 'a', function() {
      $("#nodpb").val($(this).attr("data-nodpb"));
      $("#tgl_pengambilan").val($(this).attr("data-tglpengambilan"));
      $("#cabang").val($(this).attr("data-cabang"));
      $("#salesman").val($(this).attr("data-salesman"));
      $("#tujuan").val($(this).attr("data-tujuan"));
      $("#nokendaraan").val($(this).attr("data-nokendaraan"));
      $("#id_karyawan").val($(this).attr("data-idkaryawan"));
      $("#datadpb").modal("hide");
      loadNoMutasi();
    });

  });
</script>