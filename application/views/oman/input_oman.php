<form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>oman/input_oman">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            INPUT ORDER MANAGEMENT (OMAN) MARKETING
          </h2>
        </div>
      </div>
    </div>
    <!-- Content here -->
    <div class="row">
      <div class="col-md-10 col-xs-12">
        <div class="row">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">INPUT ORDER MANAGEMENT (OMAN) MARKETING </h4>
            </div>
            <div class="card-body">
              <div class="form-group mb-3">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <i class="fa fa-calendar-o"></i>
                  </span>
                  <input type="text" value="<?php echo date('Y-m-d'); ?>" id="tgl_order" name="tgl_order" class="form-control datepicker" data-error=".errorTxt4" placeholder="Tanggal Order" />
                </div>
              </div>
              <div class="form-group mb-3">
                <select class="form-select" id="bulan" name="bulan" data-error=".errorTxt9">

                  <option value="">-- Pilih Bulan -- </option>
                  <?php
                  $bulansekarang = date('m');
                  $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");

                  for ($i = 1; $i <= 12; $i++) {
                  ?>
                    <option <?php if ($i == $bulansekarang) {
                              echo "selected";
                            } ?> value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
                  <?php
                  }


                  ?>
                </select>
              </div>
              <div class="form-group mb-3">
                <select class="form-select" id="tahun" name="tahun" data-error=".errorTxt9">

                  <option value="">-- Pilih Tahun -- </option>
                  <?php
                  $tahunmulai        = 2018;
                  $tahunsekarang     = date("Y");

                  for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++) {
                  ?>
                    <option <?php if ($tahun == $tahunsekarang) {
                              echo "selected";
                            } ?> value="<?php echo $tahun; ?>"><?php echo $tahun ?></option>
                  <?php
                  }


                  ?>
                </select>
              </div>
              <div id="loadformoman">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
  $(function() {

    $('.subtotal').prop('readonly', true);

    var $tblrows = $("#mytable tbody tr");
    $tblrows.each(function(index) {
      var $tblrow = $(this);
      $tblrow.find('.jmlm1').on('input', function() {
        var jmlm1 = $tblrow.find("[id=jmlm1]").val();
        var jmlm2 = $tblrow.find("[id=jmlm2]").val();
        var jmlm3 = $tblrow.find("[id=jmlm3]").val();
        var jmlm4 = $tblrow.find("[id=jmlm4]").val();

        if (jmlm1.length === 0) {

          var jml1 = 0;

        } else {
          var jml1 = parseInt(jmlm1);
        }
        if (jmlm2.length === 0) {

          var jml2 = 0;

        } else {
          var jml2 = parseInt(jmlm2);
        }
        if (jmlm3.length === 0) {

          var jml3 = 0;

        } else {
          var jml3 = parseInt(jmlm3);
        }

        if (jmlm4.length === 0) {

          var jml4 = 0;

        } else {
          var jml4 = parseInt(jmlm4);
        }
        var subTotal = jml1 + jml2 + jml3 + jml4;


        if (!isNaN(subTotal)) {

          $tblrow.find('.subtotal').val(subTotal);
          var grandTotal = 0;
          $(".subtotal").each(function() {
            var stval = parseInt($(this).val());
            grandTotal += isNaN(stval) ? 0 : stval;
          });

          //$('.grdtot').val(grandTotal.toFixed(2));
        }

      });

      $tblrow.find('.jmlm2').on('input', function() {
        var jmlm1 = $tblrow.find("[id=jmlm1]").val();
        var jmlm2 = $tblrow.find("[id=jmlm2]").val();
        var jmlm3 = $tblrow.find("[id=jmlm3]").val();
        var jmlm4 = $tblrow.find("[id=jmlm4]").val();

        if (jmlm1.length === 0) {

          var jml1 = 0;

        } else {
          var jml1 = parseInt(jmlm1);
        }
        if (jmlm2.length === 0) {

          var jml2 = 0;

        } else {
          var jml2 = parseInt(jmlm2);
        }
        if (jmlm3.length === 0) {

          var jml3 = 0;

        } else {
          var jml3 = parseInt(jmlm3);
        }

        if (jmlm4.length === 0) {

          var jml4 = 0;

        } else {
          var jml4 = parseInt(jmlm4);
        }
        var subTotal = jml1 + jml2 + jml3 + jml4;


        if (!isNaN(subTotal)) {

          $tblrow.find('.subtotal').val(subTotal);
          var grandTotal = 0;
          $(".subtotal").each(function() {
            var stval = parseInt($(this).val());
            grandTotal += isNaN(stval) ? 0 : stval;
          });

          //$('.grdtot').val(grandTotal.toFixed(2));
        }

      });


      $tblrow.find('.jmlm3').on('input', function() {
        var jmlm1 = $tblrow.find("[id=jmlm1]").val();
        var jmlm2 = $tblrow.find("[id=jmlm2]").val();
        var jmlm3 = $tblrow.find("[id=jmlm3]").val();
        var jmlm4 = $tblrow.find("[id=jmlm4]").val();

        if (jmlm1.length === 0) {

          var jml1 = 0;

        } else {
          var jml1 = parseInt(jmlm1);
        }
        if (jmlm2.length === 0) {

          var jml2 = 0;

        } else {
          var jml2 = parseInt(jmlm2);
        }
        if (jmlm3.length === 0) {

          var jml3 = 0;

        } else {
          var jml3 = parseInt(jmlm3);
        }

        if (jmlm4.length === 0) {

          var jml4 = 0;

        } else {
          var jml4 = parseInt(jmlm4);
        }
        var subTotal = jml1 + jml2 + jml3 + jml4;


        if (!isNaN(subTotal)) {

          $tblrow.find('.subtotal').val(subTotal);
          var grandTotal = 0;
          $(".subtotal").each(function() {
            var stval = parseInt($(this).val());
            grandTotal += isNaN(stval) ? 0 : stval;
          });

          //$('.grdtot').val(grandTotal.toFixed(2));
        }

      });


      $tblrow.find('.jmlm4').on('input', function() {
        var jmlm1 = $tblrow.find("[id=jmlm1]").val();
        var jmlm2 = $tblrow.find("[id=jmlm2]").val();
        var jmlm3 = $tblrow.find("[id=jmlm3]").val();
        var jmlm4 = $tblrow.find("[id=jmlm4]").val();

        if (jmlm1.length === 0) {

          var jml1 = 0;

        } else {
          var jml1 = parseInt(jmlm1);
        }
        if (jmlm2.length === 0) {

          var jml2 = 0;

        } else {
          var jml2 = parseInt(jmlm2);
        }
        if (jmlm3.length === 0) {

          var jml3 = 0;

        } else {
          var jml3 = parseInt(jmlm3);
        }

        if (jmlm4.length === 0) {

          var jml4 = 0;

        } else {
          var jml4 = parseInt(jmlm4);
        }
        var subTotal = jml1 + jml2 + jml3 + jml4;


        if (!isNaN(subTotal)) {

          $tblrow.find('.subtotal').val(subTotal);
          var grandTotal = 0;
          $(".subtotal").each(function() {
            var stval = parseInt($(this).val());
            grandTotal += isNaN(stval) ? 0 : stval;
          });

          //$('.grdtot').val(grandTotal.toFixed(2));
        }

      });



    });


    function loadStatus() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>oman/cek_oman',
        data: {
          tahun: tahun,
          bulan: bulan
        },
        cache: false,
        success: function(respond) {

          $("#status").val(respond);
        }



      });

    }


    function loadformoman() {
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>oman/loadformoman',
        data: {
          tahun: tahun,
          bulan: bulan
        },
        cache: false,
        success: function(respond) {

          $("#loadformoman").html(respond);
        }



      });

    }




    $("#bulan").change(function() {

      loadStatus();
      loadformoman();

    });

    $("#tahun").change(function() {

      loadStatus();
      loadformoman();
    });

    loadStatus();
    loadformoman();
    $("form").submit(function() {


      var darim1 = $("#darim1").val();
      var darim2 = $("#darim2").val();
      var darim3 = $("#darim3").val();
      var darim4 = $("#darim4").val();


      var sampai1 = $("#sampaim1").val();
      var sampai2 = $("#sampaim2").val();
      var sampai3 = $("#sampaim3").val();
      var sampai4 = $("#sampaim4").val();

      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();

      var status = $("#status").val();





      if (status == 1) {
        swal("Oops!", "Data Oman Bulan " + bulan + "Tahun " + tahun + " Sudah Ada !", "warning");
        return false;

      } else if (darim1 == "" || sampai1 == "") {
        swal("Oops!", "Tanggal di Minggu Ke 1 Masih Kosong !", "warning");
        return false;

      } else if (darim2 == "" || sampai2 == "") {
        swal("Oops!", "Tanggal di Minggu Ke 2 Masih Kosong !", "warning");
        return false;

      } else if (darim3 == "" || sampai3 == "") {
        swal("Oops!", "Tanggal di Minggu Ke 3 Masih Kosong !", "warning");
        return false;

      } else if (darim4 == "" || sampai4 == "") {
        swal("Oops!", "Tanggal di Minggu Ke 4 Masih Kosong !", "warning");
        return false;

      } else {
        return true;
      }




    });



  });
</script>