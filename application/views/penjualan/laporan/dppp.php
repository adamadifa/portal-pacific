<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Pencapaian & Pertumbuhan Produk
        </h2>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-10">
        <!-- Content here -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-dark text-white">
                <h4 class="card-title">Data Pencapaian & Pertumbuhan Produk</h4>
              </div>
              <div class="card-body">
                <form class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>laporanpenjualan/cetak_dppp" target="_blank">
                  <?php if ($cb == 'pusat') { ?>
                    <div class="mb-3">
                      <select name="cabang" id="cabang" class="form-select">
                        <option value="">-- Semua Cabang --</option>
                        <?php foreach ($cabang as $c) { ?>
                          <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } else { ?>
                    <input type="hidden" name="cabang" id="cabang" value="<?php echo $cb; ?>">
                  <?php } ?>
                  <div class="form-group mb-3">
                    <select name="bulan" id="bulan" class="form-select">
                      <option value="">-- Pilih Bulan -- </option>
                      <?php
                      $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");

                      for ($i = 1; $i <= 12; $i++) {
                      ?>
                        <option value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
                      <?php
                      }
                      ?>

                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <input type="text" class="form-control" name="tahun" placeholder="Tahun">
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <button type="submit" name="cetak" class="btn btn-primary btn-block">
                          <i class="fa fa-print mr-2"></i>
                          CETAK
                        </button>
                      </div>
                      <div class="col-md-6">
                        <button type="submit" name="export" class="btn btn-success btn-block">
                          <i class="fa fa-download mr-2"></i>
                          <span>EXPORT EXCEL</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {


    $('.formValidate').bootstrapValidator({
      message: 'This value is not valid',
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        bulan: {
          validators: {
            notEmpty: {
              message: 'Bulan Harus Diisi !'
            }
          }
        },
        tahun: {
          validators: {
            notEmpty: {
              message: 'Tahun Harus Diisi !'
            }
          }
        },
      }
    });






  });
</script>