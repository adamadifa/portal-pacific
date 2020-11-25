<form name="autoSumForm" autocomplete="off" class="returForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/retur_penjualan">
  <input type="hidden" id="cekbarang">
  <input type="hidden" id="ttr">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Retur Potong Faktur
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
                  <h4 class="card-title">Data Retur</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="text" id="noretur" name="noretur" class="form-control" placeholder="No Retur">
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="hidden" id="jenisretur" name="jenisretur" class="form-control" placeholder="Jenis Retur" value="pf" />
                      <input type="hidden" id="cekretur" name="cekretur" class="form-control" />
                      <input type="text" readonly id="kodepelanggan" name="kodepelanggan" class="form-control" placeholder="Kode Pelanggan" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-user"></i>
                      </span>
                      <input type="text" readonly id="pelanggan" name="pelanggan" class="form-control" placeholder="Pelanggan">
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-users"></i>
                      </span>
                      <input type="hidden" id="kodesales" name="kodesales" class="form-control" />
                      <input type="text" id="salesman" disabled name="salesman" class="form-control" placeholder="Salesman">
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="date" id="tglretur" name="tglretur" class="form-control" placeholder="Tanggal Retur">
                    </div>
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
            <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Histori Penjualan</h4>
                </div>
                <div class="card-body">
                  <div class="col-md-12  table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="detailbarang">
                      <thead class="thead-dark">
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jml Dus</th>
                        <th>Jml Pack</th>
                        <th>Jml Pcs</th>
                        </tr>
                      </thead>
                      <tbody id="loadhistoriPenjualan">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Histori Retur</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="detailbarang">
                      <thead class="thead-dark">
                        <tr>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Jml Dus</th>
                          <th>Jml Pack</th>
                          <th>Jml Pcs</th>
                        </tr>
                      </thead>
                      <tbody id="loadhistoriretur">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-barcode"></i>
                          </span>
                          <input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang" data-error=".errorTxt1" />
                          <input type="text" style="min-height:5rem !important" readonly id="barang" name="barang" class="form-control" placeholder="Barang" />
                          <input type="hidden" readonly id="kodecabang" name="kodecabang" class="form-control" placeholder="Kode Cabang" data-error=".errorTxt1" />
                          <input type="hidden" readonly id="stok" name="stok" class="form-control" placeholder="Stok" data-error=".errorTxt1" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-balance-scale"></i>
                            </span>
                            <input type="text" style="text-align:center" value="0" id="jmldus" name="jmldus" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-dollar"></i>
                            </span>
                            <input style="text-align:right; font-weight: bold" type="text" id="hargadus" name="hargadus" class="form-control" placeholder="Harga" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2" id="pack">
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-balance-scale"></i>
                            </span>
                            <input type="text" style="text-align:center" value="0" id="jmlpack" name="jmlpack" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-dollar"></i>
                            </span>
                            <input style="text-align:right; font-weight: bold" type="text" id="hargapack" name="hargapack" class="form-control" placeholder="Harga / Pack" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-balance-scale"></i>
                            </span>
                            <input type="text" style="text-align:center" value="0" id="jmlpcs" name="jmlpcs" class="form-control" placeholder="Jumlah Pcs" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-dollar"></i>
                            </span>
                            <input style="text-align:right; font-weight: bold" type="text" id="hargapcs" name="hargapcs" class="form-control" placeholder="Harga / Pcs" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <a href="#" id="tambahbarang" class="btn btn-primary" style="min-height:5rem !important">
                        <i class="fa  fa-cart-plus mr-2"></i>
                        Tambah
                      </a>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-hover" id="detailbarang">
                        <thead class="thead-dark">
                          <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jml Dus</th>
                            <th>Harga Dus</th>
                            <th>Jml Pack</th>
                            <th>Harga Pack</th>
                            <th>Jml Pcs</th>
                            <th>Harga Pcs</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="loadreturtmp">

                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row mt-2 ">
                    <div class="form-group d-flex justify-content-end">
                      <div class="col-md-4">
                        <select class="form-select" id="loadfaktur" name="nofaktur">
                          <option value="">-- Pilih No Faktur --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
										<div class="form-group">
											<button type="submit" name="simpan" class="btn btn-primary btn-block"><i class="fa fa-send-o mr-2"></i> SIMPAN</button>
										</div>
									</div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-md-2">
          <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="modal modal-blur fade" id="datapelanggan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Data Pelanggan</h5>
      </div>
      <div class="modal-body">

        <table class="table table-bordered table-striped table-hover" style="width:100% !important" id="mytable">
          <thead class="thead-dark">
            <tr>
              <th>No</th>
              <th>Kode Pelanggan</th>
              <th>Nama Pelanggan</th>
              <th>No HP</th>
              <th>Pasar</th>
              <th>Cabang</th>
              <th>Salesman</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="databarang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Data Barang</h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="tabelbarang">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Kategori</th>
                  <th>Satuan</th>
                  <th>Harga Dus</th>
                  <th>Harga Pack</th>
                  <th>Harga Pcs</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="loadBarang">

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailretur" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Data Retur</h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div id="loadDetailRetur">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tglretur'), {});
</script>
<script>
  $(function() {
    $('.returForm').bootstrapValidator({
      message: 'This value is not valid',
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        kodepelanggan: {
         
          validators: {
            notEmpty: {
              message: 'Kode Pelanggan Harus Diisi !'
            }


          }
        },

        tglretur: {
          validators: {
            notEmpty: {
              message: 'Tanggal Retur Harus Diisi !'
            }


          }
        },

      }
    });
    $('#loadfaktur').selectize({});

    function cektutuplaporan() {
      var tanggal = $("#tglretur").val();
      var jenis = "penjualan";
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>setting/cektutuplaporan',
        data: {
          tanggal: tanggal,
          jenis: jenis
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          var status = respond;
          if (status != 0) {
            swal("Oops!", "Laporan Untuk Periode Ini Sudah Di Tutup !", "warning");
            $("#tglretur").val("");
          }
        }
      });
    }

    //cektutuplaporan();

    $("#tglretur").change(function() {
      cektutuplaporan();
    });

    function loadhistoriPenjualan() {
      var kodepelanggan = $("#kodepelanggan").val();
      $("#loadhistoriPenjualan").load("<?php echo base_url(); ?>penjualan/view_detailpenjualan/" + kodepelanggan);

    }

    function loadreturTmp() {
      var kodepelanggan = $("#kodepelanggan").val();
      $("#loadreturtmp").load("<?php echo base_url(); ?>penjualan/view_detailreturtmp/" + kodepelanggan);
    }

    function loadhistoriretur() {
      var kodepelanggan = $("#kodepelanggan").val();
      $("#loadhistoriretur").load("<?php echo base_url(); ?>penjualan/view_detailretur/" + kodepelanggan);
    }

    function cekretur() {
      var kodepelanggan = $("#kodepelanggan").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/cekbarangretur',
        data: {
          kodepelanggan: kodepelanggan
        },
        cache: false,
        success: function(respond) {
          data = respond.split("|");
          var cekretur = data[0];
          var cekreturgb = data[1];
          $("#cekretur").val(cekretur);
          $("#cekreturgb").val(cekreturgb);
        }

      });
    }

    function loadfaktur() {
      var kodepelanggan = $("#kodepelanggan").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/loadfaktur',
        data: {
          kodepelanggan: kodepelanggan
        },
        cache: false,
        success: function(respond) {
          //alert(kodecabang);
          $('#loadfaktur').selectize()[0].selectize.destroy();
          $("#loadfaktur").html(respond);
          $('#loadfaktur').selectize({});
          
          console.log(respond);
        }
      });

    }

    function ResetBrg() {
      $("#kodebarang").val("");
      $("#barang").val("");
      $("#hargadus").val("");
      $("#hargapack").val("");
      $("#hargapcs").val("");
      $("#stokdus").val("");
      $("#stokpcs").val("");
      $("#stok").val("");
      $("#isipcsdus").val("");
      $("#isipcspack").val("");
      $("#stokpack").val("");
      $("#jmlpcs").val(0);
      $("#jmlpack").val(0);
      $("#jmldus").val(0);
    }

    $("#kodepelanggan").click(function() {
      $("#datapelanggan").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });

    });


    $("#barang").click(function() {
      var kodepelanggan = $("#kodepelanggan").val();
      var kodecabang = $("#kodecabang").val();
      var jenisretur = $("#jenisretur").val();
      if (kodepelanggan == "" || jenisretur == "") {
        swal("Oops!", "Kode Pelanggan  Harus Diisi Terlebih Dahulu !", "warning");
        $("#kodepelanggan").focus();
      } else {
        $("#databarang").modal({
          backdrop: "static", //remove ability to close modal with click
          keyboard: false, //remove option to close with keyboard
          show: true //Display loader!
        });
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>penjualan/view_barangfaktur',
          data: {
            kodepelanggan: kodepelanggan,
            jenisretur: jenisretur,
            kodecabang: kodecabang
          },
          cache: false,
          success: function(respond) {
            //alert(kodecabang);
            $("#loadBarang").html(respond);

          }
        });
      }

    });


    $("#tambahbarang").click(function(e) {
      var kodebarang = $("#kodebarang").val();
      var jmldus = $("#jmldus").val();
      var hargadus = $("#hargadus").val();
      var jmlpack = $("#jmlpack").val();
      var hargapack = $("#hargapack").val();
      var jmlpcs = $("#jmlpcs").val();
      var hargapcs = $("#hargapcs").val();
      var isipcsdus = $("#isipcsdus").val();
      var isipcspack = $("#isipcspack").val();
      var stok = $("#stok").val();
      var kodepelanggan = $("#kodepelanggan").val();
      var jumlahpcs = (jmldus * isipcsdus) + (jmlpack * isipcspack) + (jmlpcs * 1);
      e.preventDefault();
      if (kodebarang == "") {
        swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
      } else if (jmldus == 0 && jmlpack == 0 && jmlpcs == 0) {
        swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
      } else {
        $.ajax({

          type: 'POST',
          url: '<?php echo base_url(); ?>penjualan/insert_detailreturtmp',
          data: {
            kodebarang: kodebarang,
            jmldus: jmldus,
            hargadus: hargadus,
            jmlpack: jmlpack,
            hargapack: hargapack,
            jmlpcs: jmlpcs,
            hargapcs: hargapcs,
            kodepelanggan: kodepelanggan
          },
          cache: false,
          success: function(respond) {
            var status = respond;
            console.log(status);

            ResetBrg();
            loadreturTmp();
            cekretur();
          }
        });
      }
    });

    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
      return {
        "iStart": oSettings._iDisplayStart,
        "iEnd": oSettings.fnDisplayEnd(),
        "iLength": oSettings._iDisplayLength,
        "iTotal": oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
    };

    var t = $("#mytable").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#mytable_filter input').off('.DT').on('keyup.DT', function(e) {
          if (e.keyCode == 13) {
            api.search(this.value).draw();
          }
        });
      },
      oLanguage: {
        sProcessing: "loading..."
      },
      processing: true,
      serverSide: true,
      bLengthChange: false,

      ajax: {
        "url": "<?php echo base_url(); ?>penjualan/jsonPelanggan",
        "type": "POST"
      },
      columns: [{
          "data": "kode_pelanggan",
          "orderable": false
        },
        {
          "data": "kode_pelanggan"
        },
        {
          "data": "nama_pelanggan"
        },
        {
          "data": "no_hp"
        },
        {
          "data": "pasar"
        },
        {
          "data": "nama_cabang"
        },
        {
          "data": "nama_karyawan"
        },
        {
          "data": "view"
        }
      ],
      order: [
        [1, 'desc']
      ],
      rowCallback: function(row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        var index = page * length + (iDisplayIndex + 1);
        $('td:eq(0)', row).html(index);
      }


    });

    $('#mytable tbody').on('click', 'a', function() {
      $("#kodepelanggan").val($(this).attr("data-kodepel"));
      $("#pelanggan").val($(this).attr("data-namapel"));
      $("#kodesales").val($(this).attr("data-kodesales"));
      $("#salesman").val($(this).attr("data-namasales"));
      $("#kodecabang").val($(this).attr("data-cabang"));
      loadhistoriPenjualan();
      loadreturTmp();
      loadhistoriretur();
      cekretur();
      loadfaktur();
      $("#datapelanggan").modal("hide");

    });

    $("form").submit(function() {
      var cekretur = $("#cekretur").val();
      var nofaktur = $("#loadfaktur").val();
      if (cekretur == 0) {
        swal("Oops!", "Data Barang Retur Harus Diisi  !", "warning");
        return false;
      } else if (nofaktur == '') {
        swal("Oops!", "Silahkan Pilih Faktur !", "warning");
        return false;
      } else {
        return true;
      }
    });
  });
</script>