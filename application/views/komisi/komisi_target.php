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
    <div class="col-md-6 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Target</h4>
        </div>
        <div class="card-body">

          <form action="<?php echo base_url(); ?>komisi/targetkomisi" method="POST">
            <div class="form-group mb-3">
              <select name="bulan" id="bulan" class="form-select">
                <?php
                $bulanini = date("m");
                for ($i = 1; $i < count($bulan); $i++) {
                ?>
                  <option <?php if ($bulanini == $i) {
                            echo "selected";
                          } ?> value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="form-group mb-3">
              <select name="tahun" class="form-select" id="tahun" name="tahun">
                <?php
                $tahunmulai = 2020;

                for ($thn = $tahunmulai; $thn <= date('Y'); $thn++) {
                ?>
                  <option <?php if (date('Y') == $thn) {
                            echo "Selected";
                          } ?> value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                <?php
                }
                ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <a href="#" class="btn btn-primary" id="showtarget"><i class="fa fa-gears mr-2"></i>Buat Target</a>
            </div>
          </form>
          <div class="row clearfix">
            <div class="col-sm-12">
              <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>Kode Target</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="loadtarget">

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_marketing_administrator'); ?>
    </div>
  </div>
</div>
<script>
  $(function() {


    function loadtarget() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/loadtarget',
        data: {
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          $("#loadtarget").html(respond);
        }
      });
    }
    loadtarget();
    $("#showtarget").click(function(e) {
      e.preventDefault();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/settarget',
        data: {
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          if (respond == 2) {
            swal("Success", "Target Berhasil Di Buat !", "success");
          } else {
            swal("Opps", "Target Sudah Ada !", "warning");
          }
          console.log(respond);
        }
      });
    });

  });
</script>