<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>accounting/insert_saldoawal">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            INPUT JURNAL UMUM
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
                  <h4 class="card-title">INPUT JURNAL UMUM</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-book"></i>
                      </span>
                      <input type="text" id="ket" name="ket" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Content here -->
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                  <table class="table table-hover" style="zoom:90%">
                    <thead class="thead-dark">
                      <tr>
                        <th style="width: 15%;" colspan="2">
                          <select class="form-control " style="color:black" id="kode_akun" name="kode_akun">
                            <option value="">PILIH AKUN</option>
                            <?php foreach ($coa as $key => $d) { ?>
                              <option value="<?php echo $d->kode_akun; ?>"><?php echo $d->kode_akun; ?> | <?php echo $d->nama_akun; ?></option>
                            <?php } ?>
                          </select>
                        </th>
                        <th hidden style="width: 20%;" colspan="2"><input class="form-control" id="keterangan" style="text-align:left;color:black" placeholder="Keterangan"></th>
                        <th style="width: 10%;">
                          <select class="form-control " style="color:black" id="jenis_jurnal" name="jenis_jurnal">
                            <!-- <option value="">Pilih Jenis Jurnal</option> -->
                            <option value="D">Debet</option>
                            <option value="K">Kredit</option>
                          </select>
                        </th>
                        <th style="width: 9%;"><input class="form-control" id="jumlah" style="text-align:right;color:black" placeholder="Jumlah"></th>
                        <th style="width: 7%;"><a href="#" id="insertjurnalumumtemp" class="btn btn-primary">Simpan</a><a href="#" id="clear" class="btn btn-danger">Clear</a></th>
                      </tr>
                      <tr>
                        <th style="width: 8%;">Kode Akun</th>
                        <th style="width: 15%;">Nama Akun</th>
                        <!-- <th colspan="2">Keterangan</th> -->
                        <th style="width: 10%;text-align:right">Debet</th>
                        <th style="width: 10%;text-align:right">Kredit</th>
                        <th style="width: 7%;text-align:right">Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="loadjurnalumum">

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="form-group mb-3">
              <div class="input-icon" align="right">
                <a href="#" id="insertjurnalumum" class="btn btn-primary btn-block">Simpan</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <?php $this->load->view('menu/menu_accounting_administrator'); ?>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>

<script type="text/javascript">
  var jumlah = document.getElementById('jumlah');
  jumlah.addEventListener('keyup', function(e) {
    jumlah.value = formatRupiah(this.value, '');
  });


  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
  }
</script>

<script type="text/javascript">
  $(function() {

    $('.selectoption').selectize({});

    tampiltemp();

    function tampiltemp() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_jurnal_umum_temp',
        data: '',
        cache: false,
        success: function(html) {

          $("#loadjurnalumum").html(html);

        }
      });
    }

    $("#insertjurnalumumtemp").click(function(e) {
      var jumlah = $("#jumlah").val();
      var kode_akun = $("#kode_akun").val();
      var keterangan = $("#keterangan").val();
      var jenis_jurnal = $("#jenis_jurnal").val();
      if (jumlah == "") {
        swal("Oops!", "Jumlah Harus Diisi !", "warning");
      } else if (kode_akun == "") {
        swal("Oops!", "Akun Harus Dipilih !", "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/insert_jurnal_umum_temp',
          data: {
            kode_akun: kode_akun,
            keterangan: keterangan,
            jenis_jurnal: jenis_jurnal,
            jumlah: jumlah
          },
          cache: false,
          success: function(respond) {
            tampiltemp();

            $('#jumlah').val("");
            $('#keterangan').val("");
            var $select = $('#kode_akun').selectize();
            var control = $select[0].selectize;
            control.clear();
            $("#kode_akun")[0].selectize.destroy();
            $('#kode_akun').focus();
          }
        });
      }
    });

    $("#insertjurnalumum").click(function(e) {
      var tanggal = $("#tanggal").val();
      if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi !", "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/insert_jurnal_umum',
          data: {
            tanggal: tanggal,
            ket: ket
          },
          cache: false,
          success: function(respond) {
            tampiltemp();

            $('#jumlah').val("");
            $('#keterangan').val("");
            var $select = $('#kode_akun').selectize();
            var control = $select[0].selectize;
            control.clear();
            $("#kode_akun")[0].selectize.destroy();
            $('#kode_akun').focus();
          }
        });
      }
    });

    $("#clear").click(function(e) {
      $('#jumlah').val("");
      $('#keterangan').val("");
      var $select = $('#kode_akun').selectize();
      var control = $select[0].selectize;
      control.clear();
      $("#kode_akun")[0].selectize.destroy();
      $('#kode_akun').val("");
    });

    $("#kode_akun").click(function(e) {
      $('#kode_akun').selectize();
    });

  });
</script>