<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          BPBJ
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
              <h4 class="card-title"> INPUT MUTASI LAIN LAIN </h4>
            </div>
            <div class="card-body">
              <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>bpbj/input_lainlain">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly id="no_mutasi" name="no_mutasi" class="form-control" placeholder="No Mutasi" data-error=".errorTxt1" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="date" value="" id="tgl_mutasi" name="tgl_mutasi" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
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
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-file"></i>
                    </span>
                    <input type="text" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt1" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <input name="inout" type="radio" value="IN" id="radio_1" class="inout" />
                  <label for="radio_1">IN</label>
                  <input name="inout" type="radio" value="OUT" id="radio_2" class="inout" />
                  <label for="radio_2">OUT</label>
                </div>
                <div class="form-group">
                  <div class="d-flex justify-content-end">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"> DATA BUKTI MUTASI LAIN LAIN </h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>bpbj/lainlain" autocomplete="off">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" id="no_mutasi" value="<?php echo $nomutasi; ?>" name="no_mutasi" class="form-control" placeholder="No BPBJ" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="date" value="<?php echo $tgl_mutasi; ?>" id="tgl_mutasi2" name="tgl_mutasi" class="form-control datepicker" placeholder="Tanggal" />
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
                      <th>No. Mutasi</th>
                      <th>Tanggal</th>
                      <th>IN/OUT</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno  = $row + 1;
                    foreach ($result as $d) {
                    ?>
                      <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $d['no_mutasi_produksi']; ?></td>
                        <td><?php echo DateToIndo2($d['tgl_mutasi_produksi']); ?></td>
                        <td><span class="badge bg-green"><?php echo $d['inout']; ?></span></td>
                        <td>
                          <a href="#" data-nomutasi="<?php echo $d['no_mutasi_produksi']; ?>" class="btn btn-sm btn-primary detail"><i class="fa fa-eye"></i></a>
                          <a href="#" data-href="<?php echo base_url(); ?>bpbj/hapus_lainlain/<?php echo $d['no_mutasi_produksi']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>

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
  flatpickr(document.getElementById('tgl_mutasi'), {});
  flatpickr(document.getElementById('tgl_mutasi2'), {});
</script>

<script type="text/javascript">
  $(function() {

    $('.detail').click(function(e) {
      e.preventDefault();
      var nomutasi = $(this).attr('data-nomutasi');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>bpbj/detail_mutasilainlain',
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


    $("#barang").click(function() {
      var tgl_mutasi = $("#tgl_mutasi").val();
      if (tgl_mutasi == "") {

        swal("Oops!", "Isi Tanggal Terlebih Dahulu!", "warning");

      } else {
        $("#databarang").modal("show");
        $.ajax({

          type: 'POST',
          url: '<?php echo base_url(); ?>bpbj/view_baranglainlain',
          cache: false,
          success: function(respond) {
            //alert(kodecabang);
            $("#loadBarang").html(respond);

          }

        });
      }

    });

    $("#tgl_mutasi").change(function() {

      var tgl_mutasi = $("#tgl_mutasi").val();
      var kode_produk = $("#kodebarang").val();
      if (kode_produk != "") {
        $.ajax({

          type: 'POST',
          url: '<?php echo base_url(); ?>bpbj/buat_nomor_lainlain',
          data: {
            tgl_mutasi: tgl_mutasi,
            kode_produk: kode_produk
          },
          cache: false,
          success: function(respond) {

            console.log(respond);
            $("#no_mutasi").val("");
            $("#no_mutasi").val(respond);
          }

        });
      }
    });

    $("#formValidate").submit(function() {

      var no_mutasi = $("#no_mutasi").val();
      var tgl_mutasi = $("#tgl_mutasi").val();
      var kodebarang = $("#kodebarang").val();
      var jumlah = $("#jumlah").val();

      if (no_mutasi == "") {
        swal("Oops!", "No Mutasi Masih Kosong!", "warning");
        return false;
      } else if (tgl_mutasi == "") {
        swal("Oops!", "Tanggal Mutasi Masih Kosong!", "warning");
        return false;
      } else if (kodebarang == "") {
        swal("Oops!", "Barang Masih Kosong!", "warning");
        return false;
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Masih Kosong!", "warning");
        return false;
      } else {
        if ($(".inout").is(':checked')) {
          return true;
        } else {
          swal("Oops!", "Pilih IN / OUT!", "warning");
          return false;
        }
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