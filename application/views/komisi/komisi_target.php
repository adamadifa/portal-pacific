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
          <h4 class="card-title">Data Target</h4>
        </div>
        <div class="card-body">

          <form action="<?php echo base_url(); ?>komisi/targetkomisi" method="POST">
            <input type="hidden" name="cbg" id="cbg" value="<?php echo $cbg; ?>">
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
                <input type="submit" name="submit" class="btn btn-primary m-2-15 waves-effect" value="SET TARGET">
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
                    <th rowspan="2" width="10px" style="text-align:center">No</th>
                    <th rowspan="2" style="text-align:center">NIK</th>
                    <th rowspan="2" style="text-align:center">Nama Karyawan</th>
                    <th rowspan="2" style="text-align:center">Jabatan</th>
                    <th rowspan="2" style="text-align:center">Cabang</th>
                    <th colspan="3" style="text-align:center">Target</th>
                  </tr>
                  <tr>
                    <th style="text-align:center">Kuantitas</th>
                    <th style="text-align:center">Cash IN</th>
                    <th style="text-align:center">Collection</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($penerima as $d) {
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $d->nik; ?></td>
                      <td><?php echo $d->nama_lengkap; ?></td>
                      <td><?php echo $d->nama_jabatan; ?></td>
                      <td><?php echo $d->kode_cabang; ?></td>
                      <td style="width:20%">
                        <div class="form-group mb-3">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" kode-kriteria="K001" data-nik="<?php echo $d->nik; ?>" value="<?php echo $d->target_kuantitas; ?>" id="kuantitas" name="kuantitas" class="form-control kuantitas" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td style="width:20%">
                        <div class="form-group mb-3">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" kode-kriteria="K002" data-nik="<?php echo $d->nik; ?>" value="<?php echo $d->target_cashin; ?>" id="cashin" name="cashin" class="form-control cashin" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td style="width:20%">
                        <div class="form-group mb-3">
                          <div class="col-sm-12" style="margin-bottom:2px !important">
                            <div class="form-line">
                              <input type="text" kode-kriteria="K003" data-nik="<?php echo $d->nik; ?>" value="<?php echo $d->target_collection; ?>" id="collection" name="collection" class="form-control collection" placeholder="" data-error=".errorTxt11">
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php
                    $no++;
                  }
                  ?>
                </tbody>
              </table>
            </div>

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

    $(".kuantitas").on('keyup keydown change', function() {
      var nik = $(this).attr("data-nik");
      var kodekriteria = $(this).attr("kode-kriteria");
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var jmltarget = $(this).val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updatetarget',
        data: {
          nik: nik,
          bulan: bulan,
          tahun: tahun,
          jmltarget: jmltarget,
          kodekriteria: kodekriteria
        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $(".cashin").on('keyup keydown change', function() {
      var nik = $(this).attr("data-nik");
      var kodekriteria = $(this).attr("kode-kriteria");
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var jmltarget = $(this).val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updatetarget',
        data: {
          nik: nik,
          bulan: bulan,
          tahun: tahun,
          jmltarget: jmltarget,
          kodekriteria: kodekriteria
        },
        cache: false,
        success: function(respond) {

        }
      })
    });

    $(".collection").on('keyup keydown change', function() {
      var nik = $(this).attr("data-nik");
      var kodekriteria = $(this).attr("kode-kriteria");
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var jmltarget = $(this).val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/updatetarget',
        data: {
          nik: nik,
          bulan: bulan,
          tahun: tahun,
          jmltarget: jmltarget,
          kodekriteria: kodekriteria
        },
        cache: false,
        success: function(respond) {

        }
      })
    });


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