<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Range Komisi</h4>
        </div>
        <div class="card-body">
          <form action="<?php echo base_url(); ?>komisi/rangekomisi" method="POST">
            <?php
            if ($bln < 10) {
              $nol = 0;
            } else {
              $nol = "";
            }
            ?>
            <input type="hidden" name="cbg" id="cbg" value="<?php echo $cbg; ?>">
            <input type="hidden" name="kode_range" id="kode_range" value="RK<?php echo $cbg . $nol . $bln . substr($thn, 2, 2); ?>">
            <div class="form-group mb-3">
              <div class="form-line">
                <select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
                  <option value="">-- Pilih Cabang --</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option <?php if ($cbg == $c->kode_cabang) {
                              echo "selected";
                            } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="errorTxt1"></div>
            </div>
            <div class="form-group mb-3">
              <div class="form-line">
                <select class="form-control" id="bulan" name="bulan">
                  <option value="">Bulan</option>
                  <?php for ($a = 1; $a <= 12; $a++) { ?>
                    <option <?php if ($bln == $a) {
                              echo "selected";
                            } ?> value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="form-line">
                <select class="form-control" id="tahun" name="tahun">
                  <option value="">Tahun</option>
                  <?php for ($t = 2020; $t <= $tahun; $t++) { ?>
                    <option <?php if ($thn == $t) {
                              echo "selected";
                            } ?> value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group mb-3">
              <div style="margin-left:20px">
                <input type="submit" name="submit" class="btn btn-primary m-2-15 waves-effect" value="SET RANGE">
              </div>
            </div>

          </form>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">

            <div class="table-responsive">
              <table class="table table-bordered" id="mytable">
                <thead>
                  <tr>
                    <th style="text-align:center !important">DARI</th>
                    <th style="text-align:center !important">SAMPAI</th>
                    <th style="text-align:center !important">KACAB</th>
                    <th style="text-align:center !important">SPV</th>
                    <th style="text-align:center !important">SALES</th>
                    <th style="text-align:center !important">DRIVER/HELPER</th>
                    <th style="text-align:center !important">KEPALA GUDANG</th>
                    <th style="text-align:center !important">GUDANG</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $range = array("", "<-70", "70-75", "80-85", "86-90", "91-95", "95-100", ">-100");
                  $kode_range = "RK" . $cbg . $nol . $bln . substr($thn, 2, 2);
                  for ($i = 1; $i <= 7; $i++) {
                    $r = $range[$i];
                    $rg = explode("-", $r);
                    $dr = $this->db->get_where('komisi_range_detail', array('kode_range_komisi' => $kode_range, 'dari' => $rg[0], 'sampai' => $rg[1]))->row_array();
                  ?>
                    <tr style="text-align:center">
                      <td><?php echo $rg[0]; ?></td>
                      <td><?php echo $rg[1]; ?></td>
                      <td>
                        <div class="form-group mb-3 divkacab">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" dari="<?php echo $rg[0]; ?>" sampai="<?php echo $rg[1]; ?>" kacab="<?php echo $dr['kacab'] ?>" spv="<?php echo $dr['spv'] ?>" sales="<?php echo $dr['sales'] ?>" driverhelper="<?php echo $dr['driverhelper'] ?>" kepalagudang="<?php echo $dr['kepalagudang'] ?>" gudang="<?php echo $dr['gudang'] ?>" id="kacab" name="kacab" class="form-control kacab" maxlength="5" value="<?php echo $dr['kacab']; ?>" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="form-group mb-3 divspv">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" value="<?php echo $dr['spv']; ?>" dari="<?php echo $rg[0]; ?>" sampai="<?php echo $rg[1]; ?>" kacab="<?php echo $dr['kacab'] ?>" spv="<?php echo $dr['spv'] ?>" sales="<?php echo $dr['sales'] ?>" driverhelper="<?php echo $dr['driverhelper'] ?>" kepalagudang="<?php echo $dr['kepalagudang'] ?>" gudang="<?php echo $dr['gudang'] ?>" id="spv" name="spv" class="form-control spv" maxlength="5" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="form-group mb-3 divsales">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" dari="<?php echo $rg[0]; ?>" sampai="<?php echo $rg[1]; ?>" kacab="<?php echo $dr['kacab'] ?>" spv="<?php echo $dr['spv'] ?>" sales="<?php echo $dr['sales'] ?>" driverhelper="<?php echo $dr['driverhelper'] ?>" kepalagudang="<?php echo $dr['kepalagudang'] ?>" gudang="<?php echo $dr['gudang'] ?>" id="sales" name="sales" class="form-control sales" maxlength="5" value="<?php echo $dr['sales']; ?>" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="form-group mb-3 divdriverhelper">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" dari="<?php echo $rg[0]; ?>" sampai="<?php echo $rg[1]; ?>" kacab="<?php echo $dr['kacab'] ?>" spv="<?php echo $dr['spv'] ?>" sales="<?php echo $dr['sales'] ?>" driverhelper="<?php echo $dr['driverhelper'] ?>" kepalagudang="<?php echo $dr['kepalagudang'] ?>" gudang="<?php echo $dr['gudang'] ?>" id="driverhelper" name="driverhelper" class="form-control driverhelper" maxlength="5" value="<?php echo $dr['driverhelper']; ?>" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="form-group mb-3 divkepalagudang">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" dari="<?php echo $rg[0]; ?>" sampai="<?php echo $rg[1]; ?>" id="kepalagudang" name="kepalagudang" class="form-control kepalagudang" maxlength="5" value="<?php echo $dr['kepalagudang']; ?>" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="form-group mb-3 divgudang">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" dari="<?php echo $rg[0]; ?>" sampai="<?php echo $rg[1]; ?>" kacab="<?php echo $dr['kacab'] ?>" spv="<?php echo $dr['spv'] ?>" sales="<?php echo $dr['sales'] ?>" driverhelper="<?php echo $dr['driverhelper'] ?>" kepalagudang="<?php echo $dr['kepalagudang'] ?>" gudang="<?php echo $dr['gudang'] ?>" id="gudang" name="gudang" class="form-control gudang" maxlength="5" value="<?php echo $dr['gudang']; ?>" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>

                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <div class="form-group mb-3">
                <div style="float:right; margin-right:30px">
                  <input type="submit" id="reset" name="submit" class="btn btn-danger m-2-15 waves-effect" value="RESET">
                </div>
              </div>
            </div>
            <small style="color:red"><b>Keterangan:</b><br>Untuk Mengisi Rasio Harus di Set Range Terlebih Dahulu !</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_marketing_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal fade" id="penerimakomisi" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
  $(function() {

    $("#cabang").selectize();
    $("#bulan").selectize();
    $("#tahun").selectize();

    $(".kacab").on('keyup keydown change', function() {
      var kode_range = $("#kode_range").val();
      var kacab = $(this).val();
      var dari = $(this).attr("dari");
      var sampai = $(this).attr("sampai");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updaterasiokacab',
        data: {
          kode_range: kode_range,
          dari: dari,
          sampai: sampai,
          kacab: kacab

        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $(".spv").on('keyup keydown change', function() {
      var kode_range = $("#kode_range").val();
      var spv = $(this).val();
      var dari = $(this).attr("dari");
      var sampai = $(this).attr("sampai");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updaterasiospv',
        data: {
          kode_range: kode_range,
          dari: dari,
          sampai: sampai,
          spv: spv
        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $(".sales").on('keyup keydown change', function() {
      var kode_range = $("#kode_range").val();
      var sales = $(this).val();
      var dari = $(this).attr("dari");
      var sampai = $(this).attr("sampai");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updaterasiosales',
        data: {
          kode_range: kode_range,
          dari: dari,
          sampai: sampai,
          sales: sales
        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $(".driverhelper").on('keyup keydown change', function() {
      var kode_range = $("#kode_range").val();
      var driverhelper = $(this).val();
      var dari = $(this).attr("dari");
      var sampai = $(this).attr("sampai");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updaterasiodriverhelper',
        data: {
          kode_range: kode_range,
          dari: dari,
          sampai: sampai,
          driverhelper: driverhelper
        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $(".kepalagudang").on('keyup keydown change', function() {
      var kode_range = $("#kode_range").val();
      var kepalagudang = $(this).val();
      var dari = $(this).attr("dari");
      var sampai = $(this).attr("sampai");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updaterasiokepalagudang',
        data: {
          kode_range: kode_range,
          dari: dari,
          sampai: sampai,
          kepalagudang: kepalagudang
        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $(".gudang").on('keyup keydown change', function() {

      var kode_range = $("#kode_range").val();
      var gudang = $(this).val();
      var dari = $(this).attr("dari");
      var sampai = $(this).attr("sampai");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updaterasiogudang',
        data: {
          kode_range: kode_range,
          dari: dari,
          sampai: sampai,
          gudang: gudang
        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $("#reset").click(function(e) {
      var kode_range = $("#kode_range").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/resetrasio',
        data: {
          kode_range: kode_range
        },
        cache: false,
        success: function(respond) {
          location.reload();
        }
      })

    })



    //
    function loadrasio() {
      var cabang = $("#cabang").val();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      //alert(cabang);
      if (cabang == "" || bulan == "" || tahun == "") {
        $(".divkacab").hide();
        $(".divsales").hide();
        $(".divspv").hide();
        $(".divdriverhelper").hide();
        $(".divkepalagudang").hide();
        $(".divgudang").hide();
        $("#reset").val();
      }
    }



    loadrasio();
    $('form').submit(function() {
      var cabang = $("#cabang").val();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      if (cabang == "") {
        swal("Oops", "Cabang harus di Pilih !", "warning");
        return false;
      } else if (bulan == "") {
        swal("Oops", "Bulan harus di Pilih !", "warning");
        return false;
      } else if (Tahun == "") {
        swal("Oops", "Tahun harus di Pilih !", "warning");
        return false;
      } else {
        return true;
      }
    })
  });
</script>