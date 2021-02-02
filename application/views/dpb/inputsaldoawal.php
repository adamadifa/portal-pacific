<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          INPUT SALDO AWAL <?php echo $status; ?>
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
              <h4 class="card-title">INPUT SALDO AWAL <?php echo $status; ?> </h4>
            </div>
            <div class="card-body">
              <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>dpb/input_saldoawal">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly value="" id="kode_saldoawal" name="kode_saldoawal" class="form-control" placeholder="Kode Saldo Awal" data-error=".errorTxt19" />
                    <input type="hidden" readonly id="status" name="status" class="form-control" value="<?php echo $status; ?>" />
                    <input type="hidden" readonly id="getsa" name="getsa" value="0" class="form-control" />
                  </div>
                </div>
                <?php if ($cb == 'pusat') { ?>
                  <div class="form-group mb-3">
                    <select class="form-select" id="cabang" name="cabang">
                      <option value="">Pilih Cabang</option>
                      <?php foreach ($cabang as $c) { ?>
                        <option <?php if ($cbg == $c->kode_cabang) {
                                  echo "selected";
                                } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                <?php } else { ?>
                  <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang" />
                <?php } ?>
                <div class="form-group mb-3">
                  <select class="form-select" id="bulan" name="bulan">
                    <option value="">Bulan</option>
                    <?php for ($a = 1; $a <= 12; $a++) { ?>
                      <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <select class="form-select" id="tahun" name="tahun">
                    <option value="">Tahun</option>
                    <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                      <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                  <a href="#" id="getsaldo" class="btn btn-success"><i class="fa fa-search mr-2"></i>GET SALDO</a>
                </div>
                <hr>
                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th rowspan="3" align="">No</th>
                      <th rowspan="3" style="text-align:center">Nama Barang</th>
                      <th colspan="6" style="text-align:center">Saldo Awal <?php echo $status;  ?></th>
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
                  <tbody id="loaddetailsaldo">

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
<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script type="text/javascript">
  $(function() {

    function loadNoMutasi() {
      var bulan = $("#bulan").val();
      var cabang = $("#cabang").val();
      var tahun = $("#tahun").val();
      var status = $("#status").val();
      var thn = tahun.substr(2, 2);
      if (parseInt(bulan.length) == 1) {
        var bln = "0" + bulan;
      } else {
        var bln = bulan;
      }
      var kode = status + cabang + bln + thn;
      $("#kode_saldoawal").val(kode);
    }

    function loaddetailsaldo() {
      var bulan = $("#bulan").val();
      var cabang = $("#cabang").val();
      var tahun = $("#tahun").val();
      var status = $("#status").val();
      var thn = tahun.substr(2, 2);
      if (cabang == "") {
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
        return false;
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>dpb/getdetailsaldo',
          data: {
            bulan: bulan,
            tahun: tahun,
            cabang: cabang,
            status: status
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
    $("#cabang").change(function() {
      loadNoMutasi();
    });

    $("#bulan").change(function() {
      loadNoMutasi();
    });

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
        return false;
      } else if (getsa == 0) {
        swal("Oops!", "Lakukan Get Saldo Terlebih Dahulu !", "warning");
        return false;
      }
    });

  });
</script>