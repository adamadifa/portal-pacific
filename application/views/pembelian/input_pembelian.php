<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/insert_pembelian">
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
                  <h4 class="card-title">Data Pembelian</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="text" value="" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-users"></i>
                      </span>
                      <input type="hidden" value="" id="kodesupplier" name="kodesupplier" class="form-control" placeholder="Kode Supplier" data-error=".errorTxt19" />
                      <input type="text" value="" id="supplier" name="supplier" class="form-control" placeholder="Supplier" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" value="" id="tgl_pembelian" name="tgl_pembelian" class="form-control datepicker date" placeholder="Tanggal Pembelian" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <select class="form-select show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
                      <option value="">--Pilih Departemen--</option>
                      <?php foreach ($pemohon as $d) { ?>
                        <option value="<?php echo $d->kode_dept; ?>"><?php echo $d->nama_dept; ?></option>
                      <?php }  ?>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" value="<?php echo date("Y-m-d"); ?>" id="jatuhtempo" name="jatuhtempo" class="form-control datepicker date" placeholder="Tanggal Jatuh Tempo" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <select class="form-select show-tick" id="jenistransaksi" name="jenistransaksi" data-error=".errorTxt1">
                      <option value="">--Jenis Transaksi--</option>
                      <option value="tunai">Tunai</option>
                      <option value="kredit">Kredit</option>
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
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-barcode"></i>
                            </span>
                            <input type="hidden" value="" id="nobpb" name="nobpb" class="form-control" placeholder="No BPB" data-error=".errorTxt19" />
                            <input type="hidden" value="" id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt19" />
                            <input type="text" readonly value="" id="barang" name="barang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-file-o"></i>
                            </span>
                            <input type="text" value="" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-inbox"></i>
                            </span>
                            <input type="text" readonly value="" id="jenisbarang" name="jenisbarang" class="form-control" placeholder="Jenis Barang" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-balance-scale"></i>
                            </span>
                            <input type="text" style="text-align:right" value="" id="jumlah" name="jumlah" class="form-control" placeholder="Qty" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <label class="form-check form-switch">
                            <input class="form-check-input cabang" type="checkbox" name="girotocash" value="1">
                            <span class="form-check-label"><b>Cabang ?</b></span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-money"></i>
                            </span>
                            <input type="text" style="text-align:right" value="" id="harga" name="harga" class="form-control" placeholder="Harga" style="text-align:right" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group">
                          <select name="cbg" id="cbg" class="form-select">
                            <option value="">-- Pilih Cabang --</option>
                            <?php foreach ($cabang as $c) { ?>
                              <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-money"></i>
                          </span>
                          <input type="text" style="text-align:right" value="" id="penyharga" name="penyharga" class="form-control" placeholder="Penyesuaian Harga" style="text-align:right" data-error=".errorTxt19" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-barcode"></i>
                            </span>
                            <input type="text" style="text-align:right" value="" id="kodeakun" name="kodeakun" class="form-control" placeholder="Kode Akun" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-file-o"></i>
                            </span>
                            <input type="text" readonly style="text-align:right" value="" id="namaakun" name="namaakun" class="form-control" placeholder="Nama Akun" data-error=".errorTxt19" />
                          </div>
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
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                          <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Keterangan</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Penyesuaian</th>
                            <th>Total</th>
                            <th>Kode Akun</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="loadpembelianbarang">
                        </tbody>
                      </table>
                      <div class="row mt-3">
                        <div class="form-group">
                          <label class="form-check form-switch">
                            <input class="form-check-input ppn" type="checkbox" name="ppn" value="1">
                            <span class="form-check-label">PPN ?</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
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
<div class="modal modal-blur fade" id="databarang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Barang</h5>
      </div>
      <div class="modal-body">
        <div id="tabelbarang"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="dataakun" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Akun</h5>
      </div>
      <div class="modal-body">
        <div id="tabelakun"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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
<script>
  flatpickr(document.getElementById('tgl_pembelian'), {});
  flatpickr(document.getElementById('jatuhtempo'), {});
</script>
<script>
  var h = document.getElementById('harga');
  h.addEventListener('keyup', function(e) {
    h.value = formatRupiah(this.value, '');
    //alert(b);
  });

  var p = document.getElementById('penyharga');
  p.addEventListener('keyup', function(e) {
    p.value = formatRupiah(this.value, '');
    //alert(b);
  });
  /* Fungsi formatRupiah */
  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d-]/g, '').toString(),
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
      var tgltransaksi = $("#tgl_pembelian").val();
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
              $("#tgl_pembelian").val("");
            }
          }
        });
      }
    }
    cektutuplaporan();
    $("#tgl_pembelian").change(function() {
      cektutuplaporan();
    });

    $("#cbg").hide();
    $('.cabang').change(function() {
      //alert('test');
      if (this.checked) {
        // var returnVal = confirm("Apakah Benar Barang Ini Merupakan Kebutuhan Cabang ?");
        // $(this).prop("checked", returnVal);
        $("#cbg").show();
      } else {
        $("#cbg").hide();
      }

    });
    $(".formValidate").submit(function() {
      var nobukti = $("#nobukti").val();
      var supplier = $("#supplier").val();
      var tglpembelian = $("#tgl_pembelian").val();
      var departemen = $("#departemen").val();

      var grandtot = $("#grandtot").val();
      var jenistransaksi = $("#jenistransaksi").val();

      if (nobukti == "") {
        swal("Oops!", "NO Bukti Harus Diisi !", "warning");
        return false;
      } else if (supplier == "") {
        swal("Oops!", "Supplier Harus Diisi !", "warning");
        return false;
      } else if (tglpembelian == "") {
        swal("Oops!", "Tanggal Pembelian Harus Diisi !", "warning");
        return false;
      } else if (departemen == "") {
        swal("Oops!", "Departemen Harus Diisi !", "warning");
        return false;
      } else if (jenistransaksi == "") {
        swal("Oops!", "Jenis Transaksi Harus Diisi !", "warning");
        return false;
      } else if (grandtot == "" || grandtot == 0) {
        swal("Oops!", "Data Barang Masih Kosong !", "warning");
        return false;
      } else {
        return true;
      }
    });

    function loadNobukti() {
      var kodedept = $("#departemen").val();
      var tglpembelian = $("#tgl_pembelian").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/getNoBukti',
        data: {
          kodedept: kodedept,
          tglpembelian: tglpembelian
        },
        cache: false,
        success: function(respond) {
          //$("#nobukti").val(respond);
        }
      });
    }

    function loadjmldata() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/getjmldatapmb',
        cache: false,
        success: function(respond) {
          console.log(respond);
        }
      });
    }
    $("#departemen").change(function() {
      loadNobukti();
    });
    $("#tgl_pembelian").change(function() {
      loadNobukti();
    });

    function loadtabelbarang() {
      var departemen = $("#departemen").val();
      $("#tabelbarang").load("<?php echo base_url(); ?>pembelian/tabelbarangpembelian/" + departemen);
    }

    function loadtabelsupplier() {
      $("#tabelsupplier").load("<?php echo base_url(); ?>pembelian/tabelsupplier");
    }

    function loadpembelianbarang() {
      var departemen = $("#departemen").val();
      $("#loadpembelianbarang").load('<?php echo base_url(); ?>pembelian/view_detailpembelian_temp/' + departemen);
    }

    loadpembelianbarang();
    loadtabelsupplier();
    //loadjmldata();
    $("#departemen").change(function() {
      loadpembelianbarang();
    });
    $("#barang").click(function() {
      var departemen = $("#departemen").val();
      if (departemen == "") {
        swal("Oops!", "Departemen Harus Diisi !", "warning");
      } else {
        loadtabelbarang();
        $("#databarang").modal("show");
      }

    });

    $("#supplier").click(function() {
      $("#datasupplier").modal("show");
    });

    function loadakun() {
      $("#tabelakun").load("<?php echo base_url(); ?>pembelian/tabelakunpembelian");
    }

    function resetBrg() {
      $("#kodebarang").val("");
      $("#barang").val("");
      $("#jumlah").val("");
      $("#keterangan").val("");
      $("#jenisbarang").val("");
      $("#jumlahpengajuan").val("");
      $("#kodeakun").val("");
      $("#namaakun").val("");
      $("#harga").val("");
      $("#penyharga").val("");

      $("#cbg").hide();
    }
    $("#kodeakun").click(function() {
      loadakun();
      $("#dataakun").modal("show");
    });

    $("#tambahbarang").click(function(e) {
      e.preventDefault();

      var kodebarang = $("#kodebarang").val();
      var barang = $("#barang").val();
      var jumlah = $("#jumlah").val();
      var keterangan = $("#keterangan").val();
      var harga = $("#harga").val();
      var penyharga = $("#penyharga").val();
      var kodeakun = $("#kodeakun").val();
      var kodedept = $("#departemen").val();
      //var cabang = $(".cabang").val();
      var isChecked = $(".cabang").is(":checked");
      if (isChecked) {
        var cabang = 1;
      } else {
        cabang = "";
      }
      var cbg = $("#cbg").val();

      //alert(cabang);



      if (barang == "") {
        swal("Oops!", "Nama Barang Harus Diisi !", "warning");
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Tidak Boleh Kosong!", "warning");
      } else if (harga == "") {
        swal("Oops!", "Harga Harus Diisi!", "warning");
      } else if (kodeakun == "") {
        swal("Oops!", "Kode Akun Harus Diisi!", "warning");
      } else if (isChecked && cbg == "") {
        swal("Oops!", "Cabang Harus Diisi!", "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>pembelian/insertdetailpembelian_temp',
          data: {
            kodebarang: kodebarang,
            kodedept: kodedept,
            jumlah: jumlah,
            harga: harga,
            penyharga: penyharga,
            kodeakun: kodeakun,
            keterangan: keterangan,
            cabang: cabang,
            cbg: cbg
          },
          cache: false,
          success: function(respond) {
            if (respond == 1) {
              swal("Oops!", "Data Sudah Di Inputkan!", "warning");
            }
            loadpembelianbarang();
            //loadjmldata();
            resetBrg();
            $('.cabang').prop('checked', false);
          }
        });
      }
    });

  });
</script>