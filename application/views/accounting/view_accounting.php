<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Input Buku Besar
        </h2>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10">
      <div class="row">
        <div class="col-md-12">
          <!-- Content here -->
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-dark text-white">
                  <h4 class="card-title"> Input Buku Besar</h4>
                </div>
                <div class="card-body">
                  <form class="formValidate" id="formValidate" method="POST" action="" target="_blank">

                    <div class="mb-3">
                      <select class="form-control selectoption" id="bulan" name="bulan">
                        <option value="">Bulan</option>
                        <?php for ($a = 1; $a <= 12; $a++) { ?>
                          <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <select class="form-control selectoption" id="tahun" name="tahun">
                        <option value="">Tahun</option>
                        <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                          <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <select class="form-control selectoption" id="kode_akun" name="kode_akun">
                        <option value="">Akun</option>
                        <?php foreach ($coa as $key => $d) { ?>
                          <option value="<?php echo $d->kode_akun; ?>"><?php echo $d->kode_akun; ?> | <?php echo $d->nama_akun; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <button type="submit" name="cetak" id="getdata" class="btn btn-primary btn-block">
                            <i class="fa fa-print mr-2"></i>
                            GET
                          </button>
                        </div>
                        <div class="col-md-6">
                          <button type="submit" name="cetak" id="prosesinsert" class="btn btn-success btn-block">
                            <i class="fa fa-save mr-2"></i>
                            PROSES
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
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <a class="btn btn-primary mb-3" id="tambahpeny" style="color:white">Input Penyesuaian</a>
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th colspan="10">Ledger</th>
                  </tr>
                  <tr>
                    <th>No</th>
                    <th>TGL</th>
                    <th>No Bukti</th>
                    <th>No Ref</th>
                    <th style="width:25%">Keterangan</th>
                    <th>Kode Akun</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Ledger</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="loadledger">

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th colspan="8">Kas Kecil</th>
                  </tr>
                  <tr>
                    <th>No</th>
                    <th>Tgl</th>
                    <th>No Bukti</th>
                    <th style="width: 30% !important;">Keterangan</th>
                    <th>Kode Akun</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="loadkaskecil">

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">

              <p>
                <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                  <thead class="thead-dark">
                    <tr>
                      <th colspan="8">Jurnal Penyesuaiian</th>
                    </tr>
                    <tr>
                      <th>No</th>
                      <th>Tgl</th>
                      <th>No Bukti</th>
                      <th style="width: 25% !important;">Keterangan</th>
                      <th>Kode Akun</th>
                      <th>Debet</th>
                      <th>Kredit</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="loadpenyesuaian">

                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_accounting_administrator'); ?>
    </div>
  </div>

</div>

<div class="modal modal-blur fade" id="inputpenyesuaian" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Penyesuaian</h5>
      </div>
      <div class="modal-body">
        <div id="loadinputpenyesuaian"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="editpenyesuaian" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Penyesuaian</h5>
      </div>
      <div class="modal-body">
        <div id="loadeditpenyesuaian"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function() {

    function loadledger() {
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kode_akun').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_ledger',
        data: {
          kode_akun: kode_akun,
          tahun: tahun,
          bulan: bulan
        },
        cache: false,
        success: function(respond) {
          $("#loadledger").html(respond);
        }
      });
    }

    function loadPenyesuaian() {
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kode_akun').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_penyesuaian',
        data: {
          kode_akun: kode_akun,
          tahun: tahun,
          bulan: bulan
        },
        cache: false,
        success: function(respond) {
          //$("#loadpenyesuaian").html(respond);
        }
      });
    }

    $('#tambahpeny').click(function(e) {
      var tahun = $('#tahun').val();
      var bulan = $('#bulan').val();
      var kodeakun = $('#kode_akun').val();

      if (bulan == "") {
        swal("Oops!", "Pilih Bulan terlebih dahulu!", "warning");
      } else if (tahun == "") {
        swal("Oops!", "Pilih Tahun terlebih dahulu!", "warning");
      } else if (kodeakun == "") {
        swal("Oops!", "Pilih Kode Akun  terlebih dahulu!", "warning");
      } else {
        $("#inputpenyesuaian").modal("show");
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/input_jurnalpeny',
          data: {
            kodeakun: kodeakun,
          },
          cache: false,
          success: function(respond) {
            $("#loadinputpenyesuaian").html(respond);
          }

        });
      }
    });


    function loadkaskecil() {
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kode_akun').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_kaskecil',
        data: {
          kode_akun: kode_akun,
          tahun: tahun,
          bulan: bulan
        },
        cache: false,
        success: function(respond) {
          $("#loadkaskecil").html(respond);
        }
      });
    }
    $('.selectoption').selectize({});

    $("#prosesinsert").click(function(e) {
      e.preventDefault();

      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kode_akun').val();

      if (bulan == "") {

        swal("Oops!", "Pilih Bulan terlebih dahulu!", "warning");

      } else if (tahun == "") {

        swal("Oops!", "Pilih Tahun terlebih dahulu!", "warning");

      } else if (kode_akun == 0) {

        swal("Oops!", "Kode Akun Harus Diisi!", "warning");

      } else {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/insert_bukubesar',
          data: {
            kode_akun: kode_akun,
            tahun: tahun,
            bulan: bulan
          },
          cache: false,
          success: function(respond) {
            // $("#loadledger").html(respond);
            swal("Berhasil", "Berhasil di simpan ", "success");
            loadledger();
            loadkaskecil();
          }
        });

      }
    });

    $("#getdata").click(function(e) {
      e.preventDefault();

      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kode_akun').val();

      if (bulan == "") {

        swal("Oops!", "Pilih Bulan terlebih dahulu!", "warning");

      } else if (tahun == "") {

        swal("Oops!", "Pilih Tahun terlebih dahulu!", "warning");

      } else if (kode_akun == 0) {

        swal("Oops!", "Kode Akun Harus Diisi!", "warning");

      } else {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/view_ledger',
          data: {
            kode_akun: kode_akun,
            tahun: tahun,
            bulan: bulan
          },
          cache: false,
          success: function(respond) {
            $("#loadledger").html(respond);
          }
        });

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/view_kaskecil',
          data: {
            kode_akun: kode_akun,
            tahun: tahun,
            bulan: bulan
          },
          cache: false,
          success: function(respond) {
            $("#loadkaskecil").html(respond);
          }
        });

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/view_pembelian',
          data: {
            kode_akun: kode_akun,
            tahun: tahun,
            bulan: bulan
          },
          cache: false,
          success: function(respond) {
            $("#loadpembelian").html(respond);
          }
        });

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/view_penyesuaian',
          data: {
            kode_akun: kode_akun,
            tahun: tahun,
            bulan: bulan
          },
          cache: false,
          success: function(respond) {
            $("#loadpenyesuaian").html(respond);
          }
        });

      }
    });


  });
</script>