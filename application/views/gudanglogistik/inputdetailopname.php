<?php
$bulans = $opname['bulan'];
$bulan = $opname['bulan'];
if ($bulan == "01") {
  $bulan = "Januari";
} elseif ($bulan == "02") {
  $bulan = "Februari";
} elseif ($bulan == "03") {
  $bulan = "Maret";
} elseif ($bulan == "04") {
  $bulan = "April";
} elseif ($bulan == "05") {
  $bulan = "Mei";
} elseif ($bulan == "06") {
  $bulan = "Juni";
} elseif ($bulan == "07") {
  $bulan = "Juli";
} elseif ($bulan == "08") {
  $bulan = "Agustus";
} elseif ($bulan == "09") {
  $bulan = "September";
} elseif ($bulan == "10") {
  $bulan = "Oktober";
} elseif ($bulan == "11") {
  $bulan = "November";
} elseif ($bulan == "12") {
  $bulan = "Desember";
} ?>
<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>gudanglogistik/input_opname">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Input Data Opname
          </h2>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-10">
          <!-- Content here -->
          <div class="row">
            <div class="col-md-5 col-xs-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Input Data Opname</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $opname['kode_opname_gl']; ?>" id="kode_opname_gl" name="kode_opname_gl" class="form-control" placeholder="Kode Opname Awal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $bulan; ?>"  class="form-control" data-error=".errorTxt19" />
                      <input type="hidden" readonly value="<?php echo $bulans; ?>" id="bulan" name="bulan" class="form-control" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $opname['tahun']; ?>" id="tahun" name="tahun" class="form-control" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="hidden" readonly value="<?php echo $opname['kode_kategori']; ?>" id="kode_kategori" name="kode_kategori" class="form-control" data-error=".errorTxt19" />
                      <input type="text" readonly value="<?php echo $opname['kategori']; ?>" class="form-control" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $opname['tanggal']; ?>" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7 col-xs-12">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th><a href="#" class="btn btn-sm bg-blue waves-effect" id="barang">Barang</a></th>
                            <th id="kode_opname_gl2"></th>
                            <th hidden=""><input type="text" name="kode_barang" id="kode_barang" class="form-control" placeholder="Kode Barang"></th>
                            <th hidden=""><input type="text" name="kode_edit" id="kode_edit" class="form-control" placeholder="Kode Edit"></th>
                            <th>
                              <h5 id="kode_barang2"></h5>
                            </th>
                            <th>
                              <h5 id="nama_barang"></h5>
                            </th>
                            <th><input type="text" name="qty" id="qty" class="form-control" placeholder="Qty"></th>
                            <th><a href="#" id="getopname" class="btn btn-sm bg-green  waves-effect">GET</a> | <a href="#" class="btn btn-sm bg-blue waves-effect simpan">Ok</a></th>
                          </tr>
                        </thead>
                        <thead>
                          <tr>
                            <th style="text-align:left">No</th>
                            <th style="text-align:left;width: 150px">Kode opname</th>
                            <th style="text-align:left;width: 150px">Kode Barang</th>
                            <th style="text-align:left">Nama Barang</th>
                            <th style="text-align:left;width: 150px">Qty</th>
                            <th style="text-align:left;width: 150px">Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="loaddetailopname">

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <?php $this->load->view('menu/menu_gudanglogistik_administrator.php'); ?>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="modal modal-blur fade" id="databarang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Barang</h5>
      </div>
      <div class="modal-body">
        <div id="tabelbarang"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tgl_pengeluaran'), {});
  flatpickr(document.getElementById('jatuhtempo'), {});
</script>

<script type="text/javascript">
  $(function() {
    $("#qty").focus();

    // $("#getopname").click(function(e){
    //   e.preventDefault();
    //   loaddetailopname();
    // });

    function loaddetailopname() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var kode_barang = $("#kode_barang").val();
      var kode_kategori = $("#kode_kategori").val();
      var thn = tahun.substr(2, 2);
      if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi !", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi !", "warning");
        return false;
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>gudanglogistik/gethasildetailopname',
          data: {
            bulan: bulan,
            tahun: tahun,
            kode_kategori: kode_kategori,
            kode_barang: kode_barang
          },
          cache: false,
          success: function(respond) {
            $("#qty").val(respond);
          }
        });
      }
    }

    $("#getopname").click(function(e) {
      e.preventDefault();
      loaddetailopname();
    });


    loaddetailopname();

    function loaddetailopname() {
      var kode_opname_gl = $("#kode_opname_gl").val();
      var tahun = $("#tahun").val();
      var bulan = $("#bulan").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudanglogistik/getdetailopname',
        data: {
          kode_opname_gl: kode_opname_gl,
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailopname").html(respond);
        }
      });
    }

    function simpanopname() {
      var kode_opname_gl = $("#kode_opname_gl").val();
      var qty = $("#qty").val();
      var harga = $("#harga").val();
      var kode_barang = $("#kode_barang").val();
      var kode_edit = $("#kode_edit").val();

      if (kode_barang == "") {
        swal(
          'Peringatan',
          'Silahkan pilih dulu barang seblum isi opname',
          'warning'
        );

      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>gudanglogistik/simpanopname',
          data: {
            kode_opname_gl: kode_opname_gl,
            kode_edit: kode_edit,
            harga: harga,
            qty: qty,
            kode_barang: kode_barang
          },
          cache: false,
          success: function(respond) {
            loaddetailopname();
            $("#loaddetailopname").html(respond);
            $("#kode_barang").val("");
            $("#kode_barang2").html("");
            $("#kode_opname_gl2").html("");
            $("#nama_barang").html("");
            $("#harga").val("");
            $("#qty").val("");
            $("#kode_edit").val("");
          }
        });
      }
    }

    $("#barang").click(function() {
      var kode_kategori = $("#kode_kategori").val();
      var tahun = $("#tahun").val();
      var bulan = $("#bulan").val();
      // alert(kode_kategori);

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudanglogistik/tabelbarangopname',
        data: {
          kode_kategori: kode_kategori,
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          $("#tabelbarang").html(respond);
          $("#databarang").modal("show");
        }
      });
    });

    $(".simpan").click(function(e) {
      e.preventDefault();
      simpanopname();
    });

  });
</script>