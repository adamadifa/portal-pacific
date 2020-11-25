<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          FSTHP
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">INPUT BUKTI SERAH TERIMA HASIL PRODUKSI (FSTHP) </h4>
            </div>
            <div class="card-body">
              <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>fsthp/input_fsthp">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" id="no_fsthp" name="no_fsthp" class="form-control" placeholder="No FSTHP" data-error=".errorTxt1" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="date" value="" id="tgl_fsthp" name="tgl_fsthp" class="form-control" placeholder="Tanggal" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang" />
                    <input type="text" readonly id="barang" name="barang" class="form-control" placeholder="Barang" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <select class="form-select" name="unit" id="unit">
                    <option value="">-- Pilih Unit --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <select class="form-select" name="shift" id="shift">
                        <option value="">Shift</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-3">
                      <div class="input-icon">
                        <span class="input-icon-addon">
                          <i class="fa fa-file"></i>
                        </span>
                        <input type="text" style="text-align:right" value="" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt19" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <a href="#" id="tambahbarang" class="btn btn-primary">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover" id="detailbarang">
                    <thead class="thead-dark">
                      <tr>
                        <th>Kode Produk</th>
                        <th>Nama Barang</th>
                        <th>Shift</th>
                        <th>Jml</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="loadfsthp">
                    </tbody>
                  </table>
                </div>
                <div class="form-group">
                  <div class="d-flex justify-content-end">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-send mr-2"></i>SIMPAN</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"> DATA BUKTI SERAH TERIMA HASIL PRODUKSI (FSTHP) </h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>fsthp/view_fsthp" autocomplete="off">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" id="no_mutasi" value="<?php echo $nomutasi; ?>" name="no_mutasi" class="form-control" placeholder="No FSTHP" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="date" value="<?php echo $tgl_mutasi; ?>" id="tgl_mutasi" name="tgl_mutasi" class="form-control datepicker" placeholder="Tanggal" />
                  </div>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                  <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
                </div>
              </form>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="mytable">
                  <thead class="thead-dark">
                    <tr>
                      <th width="10px">No</th>
                      <th>No. FSTHP</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Unit</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno  = $row + 1;
                    foreach ($result as $d) {
                      if ($d['status'] == 0 or $d['status'] == "") {
                        $color  = "bg-orange";
                        $status = "Pending";
                      } else {
                        $color  = "bg-green";
                        $status = "Diterima Gudang";
                      }
                      $tanggal = explode("-", $d['tgl_mutasi_produksi']);
                      $hari    = $tanggal[2];
                      $bulan   = $tanggal[1];
                      $tahun   = $tanggal[0];
                      $tgl     = $hari . "/" . $bulan . "/" . substr($tahun, 2, 2);
                    ?>
                      <tr>
                        <td><?php echo $sno; ?></td>
                        <td>
                          <a href="#" data-nomutasi="<?php echo $d['no_mutasi_produksi']; ?>" class="detail">
                            <?php echo $d['no_mutasi_produksi']; ?>
                          </a>
                        </td>
                        <td><?php echo $tgl; ?></td>
                        <td><span class="badge <?php echo $color; ?>"><?php echo $status; ?></span></td>
                        <td><?php echo $d['unit']; ?></td>
                        <td>
                          <?php if ($d['status'] == 0) { ?>
                            <a href="#" data-href="<?php echo base_url(); ?>fsthp/hapus/<?php echo $d['no_mutasi_produksi']; ?>/<?php echo $this->uri->segment(3); ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                          <?php } ?>
                        </td>
                      </tr>
                    <?php
                      $sno++;
                    }
                    ?>
                  </tbody>
                </table>
                <div style='margin-top: 10px;'>
                  <?php echo $pagination; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_produksi_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="databarang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Data Barang</h5>
      </div>
      <div class="modal-body">
        <div id="loadBarang"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailmutasi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetailmutasi"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-title">
          Yakin Untuk Di Hapus ?
        </div>
        <div>Jika Di Hapus, Kamu Akan Kehilangan Data Ini !</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete">Yes, Hapus !</a>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tgl_fsthp'), {});
  flatpickr(document.getElementById('tgl_mutasi'), {});
</script>
<script type="text/javascript">
  $(function() {
    $('.detail').click(function(e) {
      e.preventDefault();
      var nomutasi = $(this).attr('data-nomutasi');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>fsthp/detail_mutasi',
        data: {
          nomutasi: nomutasi
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailmutasi").html(respond);
        }
      });
      $("#detailmutasi").modal("show");

    });

    function ladFsthp() {
      var kode_produk = $("#kodebarang").val();
      $("#loadfsthp").load('<?php echo base_url(); ?>fsthp/view_detailfsthp_temp/' + kode_produk);
    }
    ladFsthp();

    $("#barang").click(function() {
      var tgl_fsthp = $("#tgl_fsthp").val();
      if (tgl_fsthp == "") {
        swal("Oops!", "Isi Tanggal Terlebih Dahulu!", "warning");
      } else {
        $("#databarang").modal("show");
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>fsthp/view_barang',
          cache: false,
          success: function(respond) {
            //alert(kodecabang);
            $("#loadBarang").html(respond);
          }
        });
      }
    });

    $("#tambahbarang").click(function(e) {
      e.preventDefault();
      var unit = $("#unit").val();
      var kode_produk = $("#kodebarang").val();
      var shift = $("#shift").val();
      var jumlah = $("#jumlah").val();
      var tgl_fsthp = $("#tgl_fsthp").val();
      if (tgl_fsthp == "") {
        swal("Oops!", "Isi Tanggal Terlebih Dahulu!", "warning");
      } else if (kode_produk == "") {
        swal("Oops!", "Silahkan Pilih Barang/Produk Terlebih Dahulu !", "warning");
      } else if (unit == "") {
        swal("Oops!", "Silahkan Pilih Unit  Dahulu !", "warning");
      } else if (shift == "") {
        swal("Oops!", "Silahkan Pilih Shift Terlebih Dahulu !", "warning");
      } else if (jumlah == "" || jumlah == 0) {
        swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>fsthp/insert_detailtmp',
          data: {
            kode_produk: kode_produk,
            shift: shift,
            jumlah: jumlah,
            tgl_fsthp: tgl_fsthp,
            unit: unit
          },
          cache: false,
          success: function(respond) {
            console.log(respond);
            if (respond == 1) {
              swal("Oops!", "Data Untuk Produk " + kode_produk + " Tanggal " + tgl_fsthp + " Shift " + shift + " Sudah Ada!", "warning");
            } else if (respond == 2) {
              swal("Oops!", "Data Untuk Produk " + kode_produk + " Shift " + shift + " Sudah Ada!", "warning");
            }
            ladFsthp();
          }
        });
      }
    });


    $("form").submit(function() {
      var no_bpbj = $("#no_bpbj").val();
      var tgl_bpbj = $("#tgl_bpbj").val();
      if (no_bpbj == "") {
        swal("Oops!", "No BPBJ Masih Kosong!", "warning");
        return false;
      } else if (tgl_bpbj == "") {
        swal("Oops!", "Tanggal BPBJ Masih Kosong!", "warning");
        return false;
      } else {
        return true;
      }
    });


    $("#tgl_fsthp").change(function() {
      var tgl_fsthp = $("#tgl_fsthp").val();
      var kode_produk = $("#kodebarang").val();
      if (kode_produk != "") {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>fsthp/buat_nomor_fsthp',
          data: {
            tgl_fsthp: tgl_fsthp,
            kode_produk: kode_produk
          },
          cache: false,
          success: function(respond) {

            console.log(respond);
            $("#no_fsthp").val("");
            $("#no_fsthp").val(respond);
          }

        });
      }
    });

    $(".hapus").click(function(e) {
      e.preventDefault();
      var href = $(this).attr("data-href");
      //alert(href);
      $("#hapusdata").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $(".delete").attr("href", href);
    });

  });
</script>