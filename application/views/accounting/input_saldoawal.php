<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>accounting/insert_saldoawal">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            INPUT SALDO AWAL
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
                  <h4 class="card-title">INPUT SALDO AWAL</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="text" readonly value="" id="kode_saldoawal" name="kode_saldoawal" class="form-control" placeholder="Kode Saldo Awal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
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
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <select class="form-control" id="tahun" name="tahun">
                        <option value="">Tahun</option>
                        <?php for ($t = 2020; $t <= $tahun; $t++) { ?>
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
                  <div class="form-group mb-3">
                    <div class="input-icon" align="right">
                      <input type="submit" name="submit" class="btn btn-md btn-primary" value="SIMPAN">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <?php $this->load->view('menu/menu_accounting_administrator'); ?>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script type="text/javascript">
  $(function() {

    function loadNoMutasi() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var status = "AC";
      var thn = tahun.substr(2, 2);
      var kode_saldoawal = $("#kode_saldoawal").val();
      if (parseInt(bulan.length) == 1) {
        var bln = "0" + bulan;
      } else {
        var bln = bulan;
      }
      var kode = status + bln + thn;
      $("#kode_saldoawal").val(kode);
    }

    $("#bulan").change(function() {
      loadNoMutasi();
    });
    $("#kode_saldoawal").change(function() {
      loadNoMutasi();
    });

    $("#tahun").change(function() {
      loadNoMutasi();
    });

    $(".formValidate").submit(function() {
      var kode_saldoawal = $("#kode_saldoawal").val();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var tanggal = $("#tanggal").val();
      if (kode_saldoawal == "") {
        swal("Oops!", "Saldo Awal Harus Diisi!", "warning");
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
      }
    });

    $('#mytable tbody').on('click', 'a', function() {
      $("#no_sj").val($(this).attr("data-nosj"));
      $("#datasj").modal("hide");
      loadNoMutasi();
    });

  });
</script>