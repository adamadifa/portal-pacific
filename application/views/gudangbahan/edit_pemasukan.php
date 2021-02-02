<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>gudangbahan/update_pemasukan">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Edit Data Pemasukan
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
                  <h4 class="card-title">Edit Data Pemasukan</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="hidden" value="" id="cekdata" name="cekdata" />
                      <input type="text" id="nobukti" name="nobukti" value="<?php echo $edit['nobukti_pemasukan']; ?>" class="form-control" placeholder="No Bukti" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" value="<?php echo $edit['tgl_pemasukan']; ?>" id="tgl_pemasukan" name="tgl_pemasukan" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <select class="form-control show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
                        <option <?php if ($edit['departemen'] == "Pembelian") {
                                  echo "selected";
                                } ?> value="Pembelian">Pembelian</option>
                        <option <?php if ($edit['departemen'] == "Lainnya") {
                                  echo "selected";
                                } ?> value="Lainnya">Lainnya</option>
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
                        <tbody id="loadpemasukanbarang">

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
  flatpickr(document.getElementById('tgl_pemasukan'), {});
</script>

<script>
  $(function() {


    function formatAngka(angka) {
      if (typeof(angka) != 'string') angka = angka.toString();
      var reg = new RegExp('([0-9]+)([0-9]{3})');
      while (reg.test(angka)) angka = angka.replace(reg, '$1,$2');
      return angka;
    }

    tampiltemp();

    $("#barang").click(function() {

      $("#tabelbarang").load("<?php echo base_url(); ?>gudangbahan/tabelbarang/");
      $("#databarang").modal("show");

    });

    function tampiltemp() {

      var nobukti = $('#nobukti').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudangbahan/view_detaileditpemasukan',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(html) {

          $("#loadpemasukanbarang").html(html);

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

      var nobukti = $('#nobukti').val();
      var kodebarang = $('#kodebarang').val();
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
          url: '<?php echo base_url(); ?>gudangbahan/inputeditpemasukan',
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

            tampiltemp();
            $('#barang').focus();

          }

        });

      }
    });

    $("#simpan").click(function() {

      var nobukti = $('#nobukti').val();
      var tgl_pemasukan = $('#tgl_pemasukan').val();

      if (nobukti == 0) {

        swal("Oops!", "No Bukti Harus Diisi!", "warning");
        return false;

      } else if (tgl_pemasukan == 0) {

        swal("Oops!", "Tanggal Harus Diisi!", "warning");
        return false;

      } else {

        return true;

      }

    });


  });
</script>