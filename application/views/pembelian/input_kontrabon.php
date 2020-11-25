<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/insert_kontrabon">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Data Pembelian
          </h2>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-10">
          <!-- Content here -->
          <div class="row">
            <div class="col-md-5 col-xs-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Data Kontrabon</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="text" value="" id="nokontrabon" name="nokontrabon" class="form-control" placeholder="No Kontra BON / Internal Memo" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-users"></i>
                      </span>
                      <input type="hidden" value="<?php echo $pmb['kode_supplier']; ?>" id="kodesupplier" name="kodesupplier" class="form-control" placeholder="Kode Supplier" data-error=".errorTxt19" />
                      <input type="text" value="<?php echo $pmb['nama_supplier']; ?>" id="supplier" name="supplier" class="form-control" placeholder="Supplier" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" value="" id="tgl_kontrabon" name="tgl_kontrabon" class="form-control datepicker date" placeholder="Tanggal Kontra Bon" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <select class="form-select show-tick" id="status" name="status" data-error=".errorTxt1">
                      <option value="">--Pilih Jenis Pengajuan--</option>
                      <option value="KB">Kontra BON</option>
                      <option value="IM">Internal Memo</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-file-o"></i>
                      </span>
                      <input type="text" value="" id="nodokumen" name="nodokumen" class="form-control" placeholder="No Dokumen" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <select class="form-select show-tick" id="jenisbayar" name="jenisbayar" data-error=".errorTxt1">
                      <option value="">--Pilih Jenis Bayar--</option>
                      <option value="tunai">Tunai</option>
                      <option value="transfer">Transfer</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-sm">
                    <div class="card-body d-flex align-items-center">
                      <span class="bg-blue text-white stamp mr-3" style="height:9rem !important; min-width:8rem !important ">
                        <i class="fa f fa-shopping-cart" style="font-size: 4rem;"></i>
                      </span>
                      <div class="ml-3 lh-lg">
                        <div class="strong" style="font-size: 3rem;" id="grandtotal">
                        </div>
                      </div>
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
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-barcode"></i>
                          </span>
                          <input type="text" readonly value="<?php echo $pmb['nobukti_pembelian']; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt19" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-money"></i>
                          </span>
                          <input type="text" style="text-align:right" value="<?php echo number_format($pmb['harga'], '0', '', '.'); ?>" id="totalharga" name="totalharga" class="form-control" placeholder="Total Harga" data-error=".errorTxt19" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-money"></i>
                          </span>
                          <input type="text" style="text-align:right" value="" id="jmlbayar" name="jmlbayar" class="form-control" placeholder="Jumlah Bayar" data-error=".errorTxt19" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-file-o"></i>
                          </span>
                          <input type="text" style="text-align:right" value="" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <a href="#" id="tambahbarang" class="btn btn-primary">
                          <i class="fa fa-cart-plus mr-2"></i> Tambah
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col md-12">
                      <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                          <tr>
                            <th>No</th>
                            <th>No Bukti</th>
                            <th>Keterangan</th>
                            <th>Jumlah Bayar</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="loadkontrabon">

                        </tbody>
                      </table>
                      <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <?php $this->load->view('menu/menu_pembelian_administrator'); ?>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="modal modal-blur fade" id="datasupplier" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Supplier</h5>
      </div>
      <div class="modal-body">
        <div id="tabelsupplier"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="datapembelian" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Data Pembelian</h5>
      </div>
      <div class="modal-body">
        <div id="tabelpembelian"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tgl_kontrabon'), {});
</script>
<script>
  var h = document.getElementById('jmlbayar');
  h.addEventListener('keyup', function(e) {
    h.value = formatRupiah(this.value, '');
    //alert(b);
  });
  /* Fungsi formatRupiah */
  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
  }

  function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
      if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
  }
</script>

<script type="text/javascript">
  $(function() {
    function cektutuplaporan() {
      var tgltransaksi = $("#tgl_kontrabon").val();
      var jenis = 'pembelian';
      if (tgltransaksi != "") {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>setting/cektutuplaporan',
          data: {
            tanggal: tgltransaksi,
            jenis: jenis
          },
          cache: false,
          success: function(respond) {
            console.log(respond);
            var status = respond;
            if (status != 0) {
              swal("Oops!", "Laporan Untuk Periode Ini Sudah Di Tutup !", "warning");
              $("#tgl_kontrabon").val("");
            }
          }
        });
      }
    }
    cektutuplaporan();
    $("#tgl_kontrabon").change(function() {
      cektutuplaporan();
    });
    $(".formValidate").submit(function() {
      var nokontrabon = $("#nokontrabon").val();
      var supplier = $("#supplier").val();
      var tgl_kontrabon = $("#tgl_kontrabon").val();
      var status = $("#status").val();
      var nodokumen = $("#nodokumen").val();
      if (nokontrabon == "") {
        swal("Oops!", "NO Kontra BON Harus Diisi !", "warning");
        return false;
      } else if (supplier == "") {
        swal("Oops!", "Supplier Harus Diisi !", "warning");
        return false;
      } else if (tgl_kontrabon == "") {
        swal("Oops!", "Tanggal Kontra BON Harus Diisi !", "warning");
        return false;
      } else if (status == "") {
        swal("Oops!", "Jenis Pengajuan Harus Diisi !", "warning");
        return false;
      } else if (nodokumen == "") {
        swal("Oops!", "No Dokumen Harus Diisi", "warning");
        return false;
      } else {
        return true;
      }
    });

    function loadNoKB() {
      var tgl_kontrabon = $("#tgl_kontrabon").val();
      var status = $("#status").val();
      //alert(tgl_kontrabon);
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/getNoKB',
        data: {
          tgl_kontrabon: tgl_kontrabon,
          status: status
        },
        cache: false,
        success: function(respond) {
          $("#nokontrabon").val(respond);
        }
      });
    }


    $("#tgl_kontrabon").change(function() {
      loadNoKB();
    });

    $("#status").change(function() {
      loadNoKB();
    });

    function loadtabelpembelian() {
      var supplier = $("#kodesupplier").val();
      $("#tabelpembelian").load("<?php echo base_url(); ?>pembelian/tabelpembelian/" + supplier);
    }

    function loadtabelsupplier() {
      $("#tabelsupplier").load("<?php echo base_url(); ?>pembelian/tabelsupplier");
    }

    function loadkontrabon() {
      var supplier = $("#kodesupplier").val();
      $("#loadkontrabon").load('<?php echo base_url(); ?>pembelian/view_detailkontrabon_temp/' + supplier);
    }

    loadkontrabon();
    loadtabelsupplier();

    $("#nobukti").click(function() {
      var supplier = $("#kodesupplier").val();
      if (supplier == "") {
        swal("Oops!", "Silahkan Pilih Supplier terlebih dahulu!", "warning");
      } else {
        loadtabelpembelian();
        $("#datapembelian").modal("show");
      }

    });

    $("#supplier").click(function() {
      $("#datasupplier").modal("show");
    });


    function resetBrg() {
      $("#nobukti").val("");
      $("#keterangan").val("");
      $("#jmlbayar").val("");
      $("#totalharga").val("");
    }


    $("#tambahbarang").click(function(e) {
      e.preventDefault();
      var nobukti = $("#nobukti").val();
      var keterangan = $("#keterangan").val();
      var jmlbayar = $("#jmlbayar").val();
      var supplier = $("#kodesupplier").val();
      var totalharga = $("#totalharga").val();

      var total = parseInt(totalharga.replace(/\./g, ""));
      var jmlbyr = parseInt(jmlbayar.replace(/\./g, ""));
      if (nobukti == "") {
        swal("Oops!", "Silahkan Pilih Bukti Pembelian !", "warning");
      } else if (jmlbayar == "") {
        swal("Oops!", "Jumlah Bayar Tidak Boleh Kosong!", "warning");
      } else if (jmlbyr > total) {
        swal("Oops!", "Jumlah Bayar Melebihi Total!" + total, "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>pembelian/insertdetailkontrabon_temp',
          data: {
            nobukti: nobukti,
            keterangan: keterangan,
            jmlbayar: jmlbayar,
            supplier: supplier
          },
          cache: false,
          success: function(respond) {
            if (respond == 1) {
              swal("Oops!", "Data Sudah Di Inputkan!", "warning");
            }
            loadkontrabon();
            resetBrg();
          }
        });
      }
    });
  });
</script>