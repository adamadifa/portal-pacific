<?php
function uang($nilai)
{
  return number_format($nilai, '2', ',', '.');
}
?>
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
          <h4 class="card-title"> Data Kriteria Komisi</h4>
        </div>
        <div class="card-body">
          <form action="<?php echo base_url(); ?>komisi/kriteriakomisi" method="POST">
            <?php
            if ($bln < 10) {
              $nol = 0;
            } else {
              $nol = "";
            }
            ?>
            <input type="hidden" name="cbg" id="cbg" value="<?php echo $cbg; ?>">
            <input type="hidden" name="kode_setkriteria" id="kode_setkriteria" value="KR<?php echo $cbg . $nol . $bln . substr($thn, 2, 2); ?>">
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
                <input type="submit" name="submit" class="btn btn-primary btn-md" value="SET KRITERIA">
              </div>
            </div>

          </form>
          <div class="col-sm-12">

            <div class="table-responsive">
              <table class="table table-bordered" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th style="text-align:center !important">KRITERIA</th>
                    <th style="text-align:center !important">POIN</th>
                    <th style="text-align:center !important">%MINIMAL</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  foreach ($kriteria as $d) {

                  ?>
                    <tr style="text-align:center">
                      <td><?php echo $d->nama_kriteria; ?></td>
                      <td>
                        <div class="form-group divpoin mb-3">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" kode_kriteria="<?php echo $d->kode_kriteria; ?>" class="form-control poin" value="<?php echo $d->poin; ?>" maxlength="3" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="form-group divpersentase_min mb-3">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" kode_kriteria="<?php echo $d->kode_kriteria; ?>" class="form-control persentase_min" value="<?php echo $d->persentase_min; ?>" persentase_min" maxlength="3" placeholder="" data-error=".errorTxt11">
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
                  <input type="submit" id="reset" name="submit" class="btn btn-primary btn-md" value="RESET">
                </div>
              </div>
            </div>
            <small style="color:red"><b>Keterangan:</b><br>Untuk Mengisi Kriteria Harus di Set Kriteria Terlebih Dahulu !</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_marketing_administrator'); ?>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
  $(function() {



    $("#reset").click(function(e) {
      var kode_setkriteria = $("#kode_setkriteria").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/resetsetkriteria',
        data: {
          kode_setkriteria: kode_setkriteria
        },
        cache: false,
        success: function(respond) {
          location.reload();
        }
      })

    })

    $(".poin").on('keyup keydown change', function() {
      var kode_setkriteria = $("#kode_setkriteria").val();
      var poin = $(this).val();
      var kode_kriteria = $(this).attr("kode_kriteria");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updatepoinkriteria',
        data: {
          kode_setkriteria: kode_setkriteria,
          kode_kriteria: kode_kriteria,
          poin: poin

        },
        cache: false,
        success: function(respond) {
          if (respond == 0) {
            swal("Opps", "Kriteria Bulan ini Belum di set", "warning");
          }
        }
      })
    });

    $(".persentase_min").on('keyup keydown change', function() {
      var kode_setkriteria = $("#kode_setkriteria").val();
      var persentase_min = $(this).val();
      var kode_kriteria = $(this).attr("kode_kriteria");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updatepersentasekriteria',
        data: {
          kode_setkriteria: kode_setkriteria,
          kode_kriteria: kode_kriteria,
          persentase_min: persentase_min

        },
        cache: false,
        success: function(respond) {
          if (respond == 0) {
            swal("Opps", "Kriteria Bulan ini Belum di set", "warning");
          }
        }
      })
    });

    //
    function loadrasio() {
      var cabang = $("#cabang").val();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      //alert(cabang);
      if (cabang == "" || bulan == "" || tahun == "") {
        $(".divpoin").hide();
        $(".divpersentase_min").hide();
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