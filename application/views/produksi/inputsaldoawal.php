<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>produksi/input_saldoawal">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Input Saldo Awal
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
                  <h4 class="card-title">Input Saldo Awal</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="hidden" value="" id="cekdata" name="cekdata" />
                      <input type="text" readonly value="" id="kode_saldoawal" name="kode_saldoawal" class="form-control" placeholder="Kode Saldo Awal" data-error=".errorTxt19" />
                      <input type="hidden" readonly id="getsa" name="getsa" value="0" class="form-control" />
                      <input type="hidden" name="jumlahproduk" id="jumlahproduk">
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-list"></i>
                      </span>
                      <select class="form-control" id="bulan" name="bulan">
                        <option value="">Bulan</option>
                        <?php for ($a = 1; $a <= 12; $a++) { ?>
                          <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-list"></i>
                      </span>
                      <select class="form-control" id="tahun" name="tahun">
                        <option value="">Tahun</option>
                        <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                          <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3" align="right">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                      </span>
                      <a href="#" id="getsaldo" class="btn btn-xm bg-green  waves-effect">GET SALDO</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="row">


              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                  <hr>
                  <table class="table table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th rowspan="3" align="">No</th>
                        <th rowspan="3" style="text-align:center">Kode Barang</th>
                        <th rowspan="3" style="text-align:center">Nama Barang</th>
                      </tr>
                      <tr>
                        <th style="text-align:center">QTY</th>
                      </tr>
                    </thead>
                    <tbody id="loaddetailsaldo">

                    </tbody>
                  </table>
                  <div class="mt-3 d-flex justify-content-end">
                    <input type="submit" name="submit" class="btn btn-xm btn-primary  waves-effect" value="SIMPAN">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <?php $this->load->view('menu/menu_produksi_administrator'); ?>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>

<script>
  $(function() {

    function loadNoMutasi() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var kategori = $("#kategori").val();
      var status = "GB";
      var thn = tahun.substr(2, 2);
      if (parseInt(bulan.length) == 1) {
        var bln = "0" + bulan;
      } else {
        var bln = bulan;
      }
      var kode = status + bln + thn;
      $("#kode_saldoawal").val(kode);
    }

    function loaddetailsaldo() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var thn = tahun.substr(2, 2);
      if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi !", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi !", "warning");
        return false;
      } else if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi !", "warning");
        return false;
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>produksi/getdetailsaldo',
          data: {
            bulan: bulan,
            tahun: tahun
          },
          cache: false,
          success: function(respond) {
            if (respond == 1) {
              $("#getsa").val(0);
              swal("Oops!", "Saldo Bulan Sebelumnya Belum Diset! Atau Saldo Bulan Tersebut Sudah Ada", "warning");
            } else {
              $("#getsa").val(1);
              $("#loaddetailsaldo").html(respond);
            }
          }
        });
      }
    }
    $("#getsaldo").click(function(e) {
      e.preventDefault();
      loaddetailsaldo();
    });
    $("#bulan").change(function() {
      loadNoMutasi();
    });
    // $("#kategori").change(function(){
    //   loadNoMutasi();
    // });

    $("#tahun").change(function() {
      loadNoMutasi();
    });

    $(".formValidate").submit(function() {
      var kode_saldoawal = $("#kode_saldoawal").val();
      var cabang = $("#cabang").val();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var tanggal = $("#tanggal").val();
      var getsa = $("#getsa").val();
      if (kode_saldoawal == "") {
        swal("Oops!", "Saldo Awal Harus Diisi!", "warning");
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi !", "warning");
        return false;
      } else if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi !", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi !", "warning");
        return false;
      } else if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi !", "warning");
        $("#tanggal").focus();
        return false;
      } else if (getsa == 0) {
        swal("Oops!", "Lakukan Get Saldo Terlebih Dahulu !", "warning");
        return false;
      }
    });

    $('#mytable tbody').on('click', 'a', function() {
      $("#no_sj").val($(this).attr("data-nosj"));
      $("#datasj").modal("hide");
      loadNoMutasi();
    });

  });
</script>