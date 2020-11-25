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
  <!-- Content here -->
  <div class="row">
    <div class="col-4">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h4 class="card-title">DATA PERSEDIAAN GOOD STOK GUDANG CABANG</h4>
        </div>
        <div class="card-body">
          <?php if ($cb == 'pusat') { ?>
            <div class="form-group mb-3">
              <select class="form-select" id="cabang" name="cabang">
                <?php foreach ($cabang as $c) { ?>
                  <option <?php if ($cb == $c->kode_cabang) {
                            echo "selected";
                          } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                <?php } ?>
              </select>
            </div>
          <?php } else { ?>
            <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang" />
          <?php } ?>
          <div id="loadsaldo">
          </div>
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
    // $(document).ajaxStart(function() {
    //   $("#modal-large").modal({
    //     backdrop: "static", //remove ability to close modal with click
    //     keyboard: false, //remove option to close with keyboard
    //     show: true //Display loader!
    //   });
    // });
    loadrekappersediaan();

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

    loadsaldo();
    $("#cabang").change(function() {
      loadsaldo();
    });


    // $(document).ajaxComplete(function() {
    //   $("#modal-large").modal("hide");
    // });

  });
</script>