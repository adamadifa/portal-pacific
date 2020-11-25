<form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>oman/edit_omancabang">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            EDIT ORDER MANAGEMENT (OMAN) CABANG
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
              <h4 class="card-title">EDIT ORDER MANAGEMENT (OMAN) CABANG </h4>
            </div>
            <div class="card-body">

              <div class="form-group mb-3">
                <select class="form-select" id="bulan" name="bulan" data-error=".errorTxt9">

                  <option value="">-- Pilih Bulan -- </option>
                  <?php
                  $bulansekarang = date('m');
                  $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");

                  for ($i = 1; $i <= 12; $i++) {
                  ?>
                    <option <?php if ($i == $oman['bulan']) {
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
                    <option <?php if ($tahun == $oman['tahun']) {
                              echo "selected";
                            } ?> value="<?php echo $tahun; ?>"><?php echo $tahun ?></option>
                  <?php
                  }


                  ?>
                </select>
              </div>
              <div class="mb-3">
                <select name="cabang" id="cabang" class="form-select">
                  <option value="">-- Pilih Cabang --</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option <?php if ($oman['kode_cabang'] == $c->kode_cabang) {
                              echo "selected";
                            } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="table-responsive">
                <?php
                $qmk1   = "SELECT * FROM detail_oman_cabang 
                                               WHERE no_order = '$oman[no_order]' AND mingguke ='1'";
                $mk1    =  $this->db->query($qmk1)->row_array();

                $qmk2    = "SELECT * FROM detail_oman_cabang 
                                                WHERE no_order = '$oman[no_order]' AND mingguke ='2'";
                $mk2     =  $this->db->query($qmk2)->row_array();

                $qmk3    = "SELECT * FROM detail_oman_cabang 
                                                WHERE  no_order = '$oman[no_order]' AND mingguke ='3'";
                $mk3     =  $this->db->query($qmk3)->row_array();
                $qmk4    = "SELECT * FROM detail_oman_cabang 
                                                WHERE no_order = '$oman[no_order]'  AND mingguke ='4'";
                $mk4     =  $this->db->query($qmk4)->row_array();
                ?>
                <table class="table table-bordered table-striped table-hover" id="mytable">
                  <thead class="thead-dark">
                    <tr>
                      <th width="10px" rowspan="3" style="vertical-align: middle;">No</th>
                      <th rowspan="3" style="vertical-align: middle; text-align: center;">Produk</th>
                      <th colspan="12" style="text-align: center">Jumlah Permintaan</th>
                      <th rowspan="3" style="vertical-align: middle; width:10%">Total</th>
                    </tr>
                    <tr>
                      <th colspan="3" style="text-align:center">M1</th>
                      <th colspan="3" style="text-align:center">M2</th>
                      <th colspan="3" style="text-align:center">M3</th>
                      <th colspan="3" style="text-align:center">M4</th>
                    </tr>
                    <tr>
                      <th style="width:60px">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="darim1" maxlength="2" name="darim1" class="form-control" value="<?php echo substr($mk1['dari'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>
                        </div>
                      </th>
                      <th style="width:10px;vertical-align: middle;">
                        s/d
                      </th>
                      <th style="width:60px">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="sampaim1" maxlength="2" name="sampaim1" class="form-control" value="<?php echo substr($mk1['sampai'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>
                        </div>
                      </th>

                      <!-- Minggu Ke 2 -->
                      <th style="width:60px">
                        <div class="form-group">

                          <div class="form-line">
                            <input type="text" id="darim2" maxlength="2" name="darim2" class="form-control" value="<?php echo substr($mk2['dari'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>
                        </div>

                      </th>
                      <th style="width:10px;vertical-align: middle;">
                        s/d
                      </th>
                      <th style="width:60px">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="sampaim2" maxlength="2" name="sampaim2" class="form-control" value="<?php echo substr($mk2['sampai'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>
                        </div>
                      </th>

                      <!-- Minggu Ke 3-->
                      <th style="width:60px">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="darim3" maxlength="2" name="darim3" class="form-control" value="<?php echo substr($mk3['dari'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>
                        </div>
                      </th>
                      <th style="width:10px;vertical-align: middle;">
                        s/d
                      </th>
                      <th style="width:60px">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="sampaim3" maxlength="2" name="sampaim3" class="form-control" value="<?php echo substr($mk3['sampai'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>
                        </div>
                      </th>
                      <!-- Minggu Ke 4-->
                      <th style="width:60px">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="darim4" maxlength="2" name="darim4" class="form-control" value="<?php echo substr($mk4['dari'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>
                        </div>

                      </th>
                      <th style="width:10px;vertical-align: middle;">
                        s/d
                      </th>
                      <th style="width:60px">
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" id="sampaim4" maxlength="2" name="sampaim4" class="form-control" value="<?php echo substr($mk4['sampai'], 8, 2); ?>" data-error=".errorTxt4" />
                          </div>

                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($produk as $p) {

                      $qm1    = "SELECT * FROM detail_oman_cabang 
                                                               WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                                               AND mingguke ='1'";
                      $m1     =  $this->db->query($qm1)->row_array();

                      $qm2    = "SELECT * FROM detail_oman_cabang 
                                                                WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                                                AND mingguke ='2'";
                      $m2     =  $this->db->query($qm2)->row_array();

                      $qm3    = "SELECT * FROM detail_oman_cabang 
                                                                WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                                                AND mingguke ='3'";
                      $m3     =  $this->db->query($qm3)->row_array();

                      $qm4    = "SELECT * FROM detail_oman_cabang 
                                                                WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                                                AND mingguke ='4'";
                      $m4     =  $this->db->query($qm4)->row_array();

                      $subtotal = $m1['jumlah'] + $m2['jumlah'] + $m3['jumlah'] + $m4['jumlah'];

                    ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td>
                          <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $p->kode_produk; ?>">
                          <b><?php echo $p->nama_barang; ?></b>
                        </td>
                        <td colspan="3">

                          <div class="form-line">
                            <input type="text" id="jmlm1" name="jml<?php echo $no; ?>m1" class="form-control jmlm1" value="<?php echo $m1['jumlah']; ?>" style="text-align:right" />
                          </div>


                        </td>
                        <td colspan="3">
                          <div class="form-line">
                            <input type="text" id="jmlm2" name="jml<?php echo $no; ?>m2" class="form-control jmlm2" value="<?php echo $m2['jumlah']; ?>" style="text-align:right" />
                          </div>
                        </td>
                        <td colspan="3">
                          <div class="form-line">
                            <input type="text" id="jmlm3" name="jml<?php echo $no; ?>m3" class="form-control jmlm3" value="<?php echo $m3['jumlah']; ?>" style="text-align:right" />
                          </div>
                        </td>
                        <td colspan="3">
                          <div class="form-line">
                            <input type="text" id="jmlm4" name="jml<?php echo $no; ?>m4" class="form-control jmlm4" value="<?php echo $m4['jumlah']; ?>" style="text-align:right" />
                          </div>
                        </td>
                        <td>
                          <div class="form-line">
                            <input type="text" id="subtotal" value="<?php echo $subtotal; ?>" name="subtotal<?php echo $no; ?>" class="form-control subtotal" style="text-align:right" />
                          </div>
                        </td>

                      </tr>
                    <?php $no++;
                      $jumproduk = $no - 1;
                    } ?>
                    <input type="hidden" value="<?php echo $jumproduk; ?>" name="jumproduk">
                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="no_order" value="<?php echo $oman['no_order']; ?>">
                  </tbody>
                </table>
                <div class="mb-3 d-flex justify-content-end">
                  <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
                </div>
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


    $("#bulan").change(function() {

      loadStatus();

    });

    $("#tahun").change(function() {

      loadStatus();

    });

    loadStatus();

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





      if (darim1 == "" || sampai1 == "") {
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