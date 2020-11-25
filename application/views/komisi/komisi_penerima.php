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
          <h4 class="card-title">Data Penerima Komisi</h4>
        </div>
        <div class="card-body">

          <form action="<?php echo base_url(); ?>komisi/penerimakomisi" method="POST">
            <input type="hidden" name="cbg" id="cbg" value="<?php echo $cbg; ?>">
            <div class="form-group mb-3">
              <div class="form-line">
                <select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
                  <option value="">-- Semua Cabang --</option>
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
                <input type="submit" name="submit" class="btn btn btn-info waves-effect" value="CARI DATA">
              </div>
            </div>
          </form>
          <hr>
          <div class="row clearfix">
            <div class="col-sm-12">
              <a href="#" class="btn btn-primary waves-effect" id="tambah"> Tambah Data </a>
              <br>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="mytable">
                  <thead>
                    <tr>
                      <th width="10px">No</th>
                      <th>NIK</th>
                      <th>Nama Karyawan</th>
                      <th>Jabatan</th>
                      <th>Cabang</th>
                      <th>Aksi</th>
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
                        <td>
                          <a href="#" data-nik="<?php echo $d->nik; ?>" class="btn btn-primary btn-xs edit">Edit</a>
                          <a href="#" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="hapuspenerima/<?php echo $d->nik; ?>" class="btn btn-danger btn-xs">Hapus</a>
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
    $("#tambah").click(function(e) {
      var cabang = $("#cbg").val();
      if (cabang == "") {
        swal("Oops", "Pilh Cabang Terlebih Dahulu !", "warning");
      } else {
        $("#penerimakomisi").modal("show");
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>komisi/inputpenerima',
          data: {
            cabang: cabang
          },
          cache: false,
          success: function(respond) {
            $(".modal-content").html(respond);
          }
        })
      }
    })

    $(".edit").click(function(e) {
      e.preventDefault();
      var nik = $(this).attr("data-nik");
      $("#penerimakomisi").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/editpenerima',
        data: {
          nik: nik
        },
        cache: false,
        success: function(respond) {
          $(".modal-content").html(respond);
        }
      })
    })

    $("#cabang").selectize();

  });
</script>