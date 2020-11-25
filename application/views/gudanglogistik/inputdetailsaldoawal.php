<?php
$bulan = $saldoawal['bulan'];
$bulans = $saldoawal['bulan'];
if ($bulans == "01") {
  $bulans = "Januari";
} elseif ($bulans == "02") {
  $bulans = "Februari";
} elseif ($bulans == "03") {
  $bulans = "Maret";
} elseif ($bulans == "04") {
  $bulans = "April";
} elseif ($bulans == "05") {
  $bulans = "Mei";
} elseif ($bulans == "06") {
  $bulans = "Juni";
} elseif ($bulans == "07") {
  $bulans = "Juli";
} elseif ($bulans == "08") {
  $bulans = "Agustus";
} elseif ($bulans == "09") {
  $bulans = "September";
} elseif ($bulans == "10") {
  $bulans = "Oktober";
} elseif ($bulans == "11") {
  $bulans = "November";
} elseif ($bulans == "12") {
  $bulans = "Desember";
} ?>
<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>gudanglogistik/input_saldoawal">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Input Data Saldoawal
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
                  <h4 class="card-title">Input Data Saldoawal</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $saldoawal['kode_saldoawal_gl']; ?>" id="kode_saldoawal_gl" name="kode_saldoawal_gl" class="form-control" placeholder="Kode saldoawal Awal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $bulans; ?>" class="form-control" data-error=".errorTxt19" />
                      <input type="hidden" readonly value="<?php echo $bulan; ?>" id="bulan" name="bulan" class="form-control" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $saldoawal['tahun']; ?>" id="tahun" name="tahun" class="form-control" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="hidden" readonly value="<?php echo $saldoawal['kode_kategori']; ?>" id="kode_kategori" name="kode_kategori" class="form-control" data-error=".errorTxt19" />
                      <input type="text" readonly value="<?php echo $saldoawal['kategori']; ?>" class="form-control" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $saldoawal['tanggal']; ?>" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
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
                            <th id="kode_saldoawal_gl2"></th>
                            <th hidden=""><input type="text" name="kode_barang" id="kode_barang" class="form-control" placeholder="Kode Barang"></th>
                            <th hidden=""><input type="text" name="kode_edit" id="kode_edit" class="form-control" placeholder="Kode Edit"></th>
                            <th>
                              <h5 id="kode_barang2"></h5>
                            </th>
                            <th>
                              <h5 id="nama_barang"></h5>
                            </th>
                            <th><input type="text" name="qty" id="qty" class="form-control" placeholder="Qty"></th>
                            <th><input type="text" name="harga" id="harga" class="form-control" placeholder="Harga"></th>
                            <th><a href="#" id="getsaldoawal" class="btn btn-sm bg-green  waves-effect">GET</a> | <a href="#" class="btn btn-sm bg-blue waves-effect simpan">Ok</a></th>
                          </tr>
                        </thead>
                        <thead>
                          <tr>
                            <th style="text-align:left">No</th>
                            <th style="text-align:left;width: 150px">Kode Saldoawal</th>
                            <th style="text-align:left;width: 150px">Kode Barang</th>
                            <th style="text-align:left">Nama Barang</th>
                            <th style="text-align:left;width: 150px">Qty</th>
                            <th style="text-align:left;width: 150px">Harga</th>
                            <th style="text-align:left;width: 150px">Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="loaddetailsaldoawal">

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

    // $("#getsaldoawal").click(function(e){
    //   e.preventDefault();
    //   loaddetailsaldoawal();
    // });

    function loaddetailsaldo() {
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
          url: '<?php echo base_url(); ?>gudanglogistik/gethasilhargasaldoawal',
          data: {
            bulan: bulan,
            tahun: tahun,
            kode_kategori: kode_kategori,
            kode_barang: kode_barang
          },
          cache: false,
          success: function(respond) {
            $("#harga").val(respond);
          }
        });
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>gudanglogistik/gethasilqtysaldoawal',
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

    $("#getsaldoawal").click(function(e) {
      e.preventDefault();
      loaddetailsaldo();
    });


    loaddetailsaldoawal();

    function loaddetailsaldoawal() {
      var kode_saldoawal_gl = $("#kode_saldoawal_gl").val();
      var tahun = $("#tahun").val();
      var bulan = $("#bulan").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudanglogistik/getdetailsaldo',
        data: {
          kode_saldoawal_gl: kode_saldoawal_gl,
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailsaldoawal").html(respond);
        }
      });
    }

    function simpansaldoawal() {
      var kode_saldoawal_gl = $("#kode_saldoawal_gl").val();
      var qty = $("#qty").val();
      var harga = $("#harga").val();
      var kode_barang = $("#kode_barang").val();
      var kode_edit = $("#kode_edit").val();

      if (kode_barang == "") {
        swal(
          'Peringatan',
          'Silahkan pilih dulu barang seblum isi saldoawal',
          'warning'
        );

      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>gudanglogistik/simpansaldoawal',
          data: {
            kode_saldoawal_gl: kode_saldoawal_gl,
            kode_edit: kode_edit,
            harga: harga,
            qty: qty,
            kode_barang: kode_barang
          },
          cache: false,
          success: function(respond) {
            loaddetailsaldoawal();
            $("#loaddetailsaldoawal").html(respond);
            $("#kode_barang").val("");
            $("#kode_barang2").html("");
            $("#kode_saldoawal_gl2").html("");
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
        url: '<?php echo base_url(); ?>gudanglogistik/tabelbarangsaldoawal',
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
      simpansaldoawal();
    });

  });
</script>