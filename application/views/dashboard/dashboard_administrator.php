<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Dashboard
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h4 class="card-title">Dashboard</h4>
        </div>
        <div class="card-body">
          <?php
          $level_user = $this->session->userdata('level_user');
          if ($level_user == "Administrator" || $level_user == "manager marketing" || $level_user == "manager accounting" || $level_user == "general manager" || $level_user == "audit" || $level_user == "koordinator kepala admin" || $level_user == "spv accounting") {
          ?>
            <div class="row mb-4">
              <div class="col-md-12">
                <div class="row sm mb-3">
                  <select name="bulan" id="bulan" class="form-select">
                    <option value="">Bulan</option>
                    <?php for ($a = 1; $a <= 12; $a++) { ?>
                      <option <?php if (date("m") == $a) {
                                echo "selected";
                              } ?> value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row sm mb-3">
                  <select name="tahun" id="tahun" class="form-select">
                    <option value="">Tahun</option>
                    <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                      <option <?php if (date("Y") == $t) {
                                echo "selected";
                              } ?> value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <a href="#" id="tampilkankasbesar" class="btn btn-primary btn-block">Tampilkan Rekap Penjualan & Kas Besar</a>
                  </div>
                  <div class="col-md-6">
                    <a href="#" id="hidekasbesar" class="btn btn-danger btn-block">Sembunyikan Rekap Penjualan & Kas Besar</a>
                  </div>
                </div>



              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="table-responsive mb-4">
                  <div id="loadrekappenjualan">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="table-responsive">
                  <div id="loadrekapkasbesar">
                  </div>
                </div>
              </div>
            </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h4 class="card-title">Data Persediaan Gudang</h4>
        </div>
        <div class="card-body">
          <?php
          foreach ($rekap as $r) {
            if ($r->saldoakhir <= 0) {
              $color = "bg-red";
            } else {
              $color = "bg-green";
            }
          ?>
            <li class="list-group-item"><b><?php echo $r->nama_barang; ?></b> <span class="badge <?php echo $color; ?>" style="float:right"><?php echo number_format($r->saldoakhir, '0', '', '.'); ?></span></li>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h4 class="card-title">Data Persediaan All Cabang (DPB)</h4>
        </div>
        <div class="card-body">
          <div id="loadrekappersediaan"></div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-body text-center">
        <img src="<?php echo base_url(); ?>assets/images/loadingemot.gif" / width="200px" height="150px">
        <div clas="loader-txt">
          <p><b>Mohon Ditunggu Gaees.. ! <br> Sedang Proses Menampilkan Data....</b></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  $(function() {
    $(document).ajaxStart(function() {
      $("#modal-large").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
    });
    $(document).ajaxComplete(function() {
      $("#modal-large").modal("hide");
    });
    $("#test").click(function(e) {
      $("#modal-large").modal("show");
    })

    function loadsaldo() {
      var kodecabang = $("#cabang").val();
      var status = 'GS';
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>dashboard/loadsaldo',
        data: {
          kodecabang: kodecabang,
          status: status
        },
        cache: false,
        success: function(respond) {
          $("#loadsaldo").html(respond);
        }
      });
    }

    function loadrekappersediaan() {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>dashboard/loadrekappersediaandpb',
        cache: false,
        success: function(respond) {
          $("#loadrekappersediaan").html(respond);
        }
      });
    }

    // function loadsaldoproduk()
    // {
    //   var produk = $("#produk").val();
    //   var data = produk.split("|");
    //   var kodeproduk = data[0];
    //   var isipcsdus = data[1];

    //   //alert(isipcsdus);
    //   var status     = 'GS';
    //   $.ajax({
    //     type  : 'POST',
    //     url   : '<?php echo base_url(); ?>dashboard/loadsaldoproduk',
    //     data  : {kodeproduk:kodeproduk,status:status,isipcsdus:isipcsdus},
    //     cache : false,
    //     success: function(respond)
    //     {
    //       $("#loadsaldoproduk").html(respond);
    //     }
    //   });
    // }

    function hidekasbesar() {
      $("#loadrekapkasbesar").hide();
      $("#loadrekappenjualan").hide();
    }

    function loadrekappenjualan() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/loadrekappenjualan',
        data: {
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          $("#loadrekappenjualan").html(respond);
        }
      });
    }

    function loadrekapkasbesar() {

      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/loadrekapkasbesar',
        data: {
          bulan: bulan,
          tahun: tahun
        },
        cache: false,
        success: function(respond) {
          $("#loadrekapkasbesar").html(respond);
        }
      });
    }

    $("#tampilkankasbesar").click(function(e) {
      e.preventDefault();
      $("#loadrekapkasbesar").show();
      $("#loadrekappenjualan").show();
    });

    $("#hidekasbesar").click(function(e) {
      e.preventDefault();
      $("#loadrekapkasbesar").hide();
      $("#loadrekappenjualan").hide();
    });




    loadrekapkasbesar();
    loadrekappenjualan();
    loadsaldo();
    //loadsaldoproduk();
    loadrekappersediaan();
    hidekasbesar();

    $("#cabang").change(function() {
      loadsaldo();
    });

    // $("#produk").change(function(){
    //   loadsaldoproduk();
    // });

    $("#bulan").change(function(e) {
      loadrekappenjualan();
      loadrekapkasbesar();
    });

    $("#tahun").change(function(e) {
      loadrekappenjualan();
      loadrekapkasbesar();
    });




  });
</script>