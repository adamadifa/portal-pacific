<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>gudangbahan/update_pengeluaran">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Input Data Pengeluaran
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
                  <h4 class="card-title">Edit Data Pengeluaran</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="hidden" value="" id="cekdata" name="cekdata" />
                      <input type="text" value="<?php echo $edit['nobukti_pengeluaran']; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" value="<?php echo $edit['tgl_pengeluaran']; ?>" id="tgl_pengeluaran" name="tgl_pengeluaran" class="form-control datepicker date" placeholder="Tanggal Pengeluaran" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <select class="form-control show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
                        <option value="">--Pilih Penerima--</option>
                        <option <?php if ($edit['kode_dept'] == "Produksi") {
                                  echo "selected";
                                } ?> value="Produksi">Produksi</option>
                        <option <?php if ($edit['kode_dept'] == "Seasoning") {
                                  echo "selected";
                                } ?> value="Seasoning">Seasoning</option>
                        <option <?php if ($edit['kode_dept'] == "PDQC") {
                                  echo "selected";
                                } ?> value="PDQC">PDQC</option>
                        <option <?php if ($edit['kode_dept'] == "Susut") {
                                  echo "selected";
                                } ?> value="Susut">Susut</option>
                        <option <?php if ($edit['kode_dept'] == "Cabang") {
                                  echo "selected";
                                } ?> value="Cabang">Cabang</option>
                        <option <?php if ($edit['kode_dept'] == "Lainnya") {
                                  echo "selected";
                                } ?> value="Lainnya">Lain-Lain</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-3" id="unitproduksi">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <select class="form-control show-tick" id="unit" name="unit" data-error=".errorTxt1">
                        <option value="">--Pilih Unit--</option>
                        <option <?php if ($edit['unit'] == "1") {
                                  echo "selected";
                                } ?> value="1">Unit 1</option>
                        <option <?php if ($edit['unit'] == "2") {
                                  echo "selected";
                                } ?> value="2">Unit 2</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-3" id="sembunyikancabang">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
                        <option value="">--Pilih Cabang--</option>
                        <option <?php if ($edit['unit'] == "Pusat") {
                                  echo "selected";
                                } ?> value="Pusat">Pusat</option>
                        <option <?php if ($edit['unit'] == "Tasikmalaya") {
                                  echo "selected";
                                } ?> value="Tasikmalaya">Tasikmalaya</option>
                        <option <?php if ($edit['unit'] == "Bandung") {
                                  echo "selected";
                                } ?> value="Bandung">Bandung</option>
                        <option <?php if ($edit['unit'] == "Surabaya") {
                                  echo "selected";
                                } ?> value="Surabaya">Surabaya</option>
                        <option <?php if ($edit['unit'] == "Tegal") {
                                  echo "selected";
                                } ?> value="Tegal">Tegal</option>
                        <option <?php if ($edit['unit'] == "Bogor") {
                                  echo "selected";
                                } ?> value="Bogor">Bogor</option>
                        <option <?php if ($edit['unit'] == "Garut") {
                                  echo "selected";
                                } ?> value="Garut">Garut</option>
                        <option <?php if ($edit['unit'] == "Semarang") {
                                  echo "selected";
                                } ?> value="Semarang">Semarang</option>
                        <option <?php if ($edit['unit'] == "Purwokerto") {
                                  echo "selected";
                                } ?> value="Purwokerto">Purwokerto</option>
                        <option <?php if ($edit['unit'] == "Sukabumi") {
                                  echo "selected";
                                } ?> value="Sukabumi">Sukabumi</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="row">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="row mb-2">
                        <div class="form-group">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-barcode"></i>
                            </span>
                            <input type="hidden" value="" id="kode_edit" name="kode_edit" class="form-control" data-error=".errorTxt19" />
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
                            <input type="text" readonly value="" id="jenisbarang" name="jenisbarang" class="form-control" placeholder="Jenis Barang" data-error=".errorTxt19" />
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
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-balance-scale"></i>
                          </span>
                          <input type="text" style="text-align:right" value="" id="qty_unit" name="qty_unit" class="form-control" placeholder="QTY Unit" data-error=".errorTxt19" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-balance-scale"></i>
                          </span>
                          <input type="text" style="text-align:right" value="" id="qty_berat" name="qty_berat" class="form-control" placeholder="QTY Berat (Kg)" style="text-align:right" data-error=".errorTxt19" />
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
                            <input type="text" style="text-align:right" value="" id="qty_lebih" name="qty_lebih" class="form-control" placeholder="QTY Lebih" style="text-align:right" data-error=".errorTxt19" />
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
                            <th>Qty Unit</th>
                            <th>Qty Berat</th>
                            <th>Qty Lebih</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="loadpengeluaranbarang">

                        </tbody>
                      </table>
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
          <?php $this->load->view('menu/menu_gudangbahan_administrator'); ?>
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

<script>
  flatpickr(document.getElementById('tgl_pengeluaran'), {});
</script>

<script>
  $(function() {

    function formatAngka(angka) {
      if (typeof(angka) != 'string') angka = angka.toString();
      var reg = new RegExp('([0-9]+)([0-9]{3})');
      while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
      return angka;
    }

    tampildetail();

    var departemen = $('#departemen').val();
    if (departemen == 'Produksi') {
      $("#sembunyikancabang").hide();
      $("#unitproduksi").show();

    } else if (departemen == 'Cabang') {

      $("#sembunyikancabang").show();
      $("#unitproduksi").hide();
    } else {
      $("#sembunyikancabang").hide();
      $("#unitproduksi").hide();
    }

    $("#departemen").change(function() {

      var departemen = $('#departemen').val();
      if (departemen == 'Produksi') {
        $("#unitproduksi").show();
      } else {
        $("#unitproduksi").hide();
      }

    });

    $("#departemen").change(function() {

      var departemen = $('#departemen').val();
      if (departemen == 'Cabang') {
        $("#sembunyikancabang").show();
      } else {
        $("#sembunyikancabang").hide();
      }

    });

    $("#barang").click(function() {

      $("#tabelbarang").load("<?php echo base_url(); ?>gudangbahan/tabelbarang/");
      $("#databarang").modal("show");

    });

    function tampildetail() {

      var nobukti = $('#nobukti').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudangbahan/view_detailpengeluaran_detail',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(html) {

          $("#loadpengeluaranbarang").html(html);

          $('#barang').val("");
          $('#kodeakun').val("");
          $('#kodebarang').val("");
          $('#namaakun').val("");
          $('#qty_unit').val("");
          $('#qty_berat').val("");
          $('#qty_lebih').val("");
          $('#keterangan').val("");
          $('#jenisbarang').val("");
          $('#kode_edit').val("");
          $('#barang').focus();

        }

      });
    }

    $("#tambahbarang").click(function(e) {
      e.preventDefault();

      var kodebarang = $('#kodebarang').val();
      var nobukti = $('#nobukti').val();
      var qty_unit = $('#qty_unit').val();
      var qty_berat = $('#qty_berat').val();
      var qty_lebih = $('#qty_lebih').val();
      var kodeakun = $('#kodeakun').val();
      var keterangan = $('#keterangan').val();
      var kode_edit = $('#kode_edit').val();

      if (kodebarang == 0) {

        swal("Oops!", "Nama Barang Harus Diisi !", "warning");

      } else if (qty_unit == "") {

        swal("Oops!", "Qty Unit Harus Diisi!", "warning");

      } else if (qty_berat == "") {

        swal("Oops!", "Qty Berat Harus Diisi!", "warning");

      } else if (kodeakun == 0) {

        swal("Oops!", "Kode Akun Harus Diisi!", "warning");

      } else {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>gudangbahan/insert_detail_pengeluaran',
          data: {
            nobukti: nobukti,
            kodebarang: kodebarang,
            kode_edit: kode_edit,
            qty_unit: qty_unit,
            qty_berat: qty_berat,
            qty_lebih: qty_lebih,
            keterangan: keterangan
          },
          cache: false,
          success: function(respond) {

            if (respond == 1) {
              swal("Oops!", "Data Sudah Di Inputkan!", "warning");
            }

            tampildetail();
            $('#barang').focus();

          }

        });

      }
    });

    $("#simpan").click(function() {

      var nobukti = $('#nobukti').val();
      var tgl_pengeluaran = $('#tgl_pengeluaran').val();

      if (nobukti == 0) {

        swal("Oops!", "No Bukti Harus Diisi!", "warning");
        return false;

      } else if (tgl_pengeluaran == 0) {

        swal("Oops!", "Tanggal Harus Diisi!", "warning");
        return false;

      } else {

        return true;

      }

    });

  });
</script>