<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          REKAP PERSEDIAAN BARANG JADI CABANG
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
                <h4 class="card-title">REKAP PERSEDIAAN BARANG JADI CABANG</h4>
              </div>
              <div class="card-body">
                <form class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>laporangudangjadi/cetakmutasidpb" target="_blank">
                  <?php if ($cb == 'pusat') { ?>
                    <div class="form-group mb-3">
                      <select name="cabang" id="cabang" class="form-select">
                        <option value="">-- Pilih Cabang --</option>
                        <?php foreach ($cabang as $c) { ?>
                          <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } else { ?>
                    <input type="hidden" name="cabang" id="cabang" value="<?php echo $cb; ?>">
                  <?php } ?>
                  <div class="mb-3">
                    <select class="form-control show-tick" id="produk" name="produk" data-error=".errorTxt1">
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <select class="form-control" id="bulan" name="bulan" required>
                      <option value="">Bulan</option>
                      <?php for ($a = 1; $a <= 12; $a++) { ?>
                        <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="mb-3 form-group">
                    <select class="form-control" id="tahun" name="tahun" required>
                      <option value="">Tahun</option>
                      <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                        <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                      <?php } ?>
                    </select>
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
        <?php $this->load->view('menu/menu_gudangcabang_administrator'); ?>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('dari'), {});
    flatpickr(document.getElementById('sampai'), {});
  });
</script>
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
        cabang: {
          validators: {
            notEmpty: {
              message: 'Cabang Harus Diisi !'
            }
          }
        },
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



    function loadproduk() {
      var cabang = $("#cabang").val();
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>laporangudangjadi/get_produk',
        data: {
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $("#produk").html(respond);

        }

      });
    }
    $("#cabang").change(function() {
      loadproduk();

    });

    loadproduk();



  });
</script>