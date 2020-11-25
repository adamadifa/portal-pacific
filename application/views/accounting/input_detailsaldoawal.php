<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>accounting/insert_saldoawal">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            INPUT SALDO AWAL
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
                  <h4 class="card-title">INPUT SALDO AWAL</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-barcode"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $saldo['kode_saldoawal_bb']; ?>" id="kode_saldoawal" name="kode_saldoawal" class="form-control" placeholder="Kode Saldo Awal" data-error=".errorTxt19" />
                      <input type="hidden" readonly value="0" id="kode_edit" name="kode_edit" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $saldo['tanggal']; ?>" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $saldo['bulan']; ?>" id="bulan" name="bulan" class="form-control " placeholder="Bulan" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar-o"></i>
                      </span>
                      <input type="text" readonly value="<?php echo $saldo['tahun']; ?>" id="tahun" name="tahun" class="form-control " placeholder="Tahun" data-error=".errorTxt19" />
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
                <div class="card-header">
                  <h4 class="card-title">DETAIL SALDO AWAL</h4>
                </div>
                <div class="card-body">
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th style="width: 15%;"><input class="form-control" value="<?php echo $saldo['kode_saldoawal_bb']; ?>" readonly id="kodesaldoawal" placeholder="Kode Saldo Awal"></th>
                        <th style="width: 15%;" colspan="2">
                          <select class="form-control " style="color:black" id="kode_akun" name="kode_akun">
                            <option value="">PILIH AKUN</option>
                            <?php foreach ($coa as $key => $d) { ?>
                              <option value="<?php echo $d->kode_akun; ?>"><?php echo $d->kode_akun; ?> | <?php echo $d->nama_akun; ?></option>
                            <?php } ?>
                          </select>
                        </th>
                        <th style="width: 15%;"><input class="form-control" id="jumlah" style="text-align:right;color:black" placeholder="Jumlah"></th>
                        <th style="width: 5%;"><a href="#" id="insertdetail" class="btn btn-primary">Simpan</a></th>
                        <th style="width: 5%;"><a href="#" id="clear" class="btn btn-danger">Clear</a></th>
                      </tr>
                      <tr>
                        <th style="width: 15%;">Kode Saldo Awal</th>
                        <th style="width: 15%;">Kode Akun</th>
                        <th>Nama Akun</th>
                        <th colspan="2" style="width: 15%;text-align:right">Jumlah</th>
                        <th style="width: 10%;text-align:right">Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="loaddetailsaldoawal">

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
  </div>
</form>

<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script type="text/javascript">
  var jumlah = document.getElementById('jumlah');
  jumlah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    jumlah.value = formatRupiah(this.value, '');
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
</script>
<script type="text/javascript">
  $(function() {

    $('.selectoption').selectize({});

    tampiltemp();

    function tampiltemp() {
      var kode_saldoawal = $("#kode_saldoawal").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_detailsaldoawal',
        data: {
          kode_saldoawal: kode_saldoawal
        },
        cache: false,
        success: function(html) {

          $("#loaddetailsaldoawal").html(html);

        }

      });
    }


    $("#insertdetail").click(function(e) {
      var kode_saldoawal = $("#kode_saldoawal").val();
      var jumlah = $("#jumlah").val();
      var kode_akun = $("#kode_akun").val();
      var kode_edit = $("#kode_edit").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/insert_detailsaldoawal',
        data: {
          kode_saldoawal: kode_saldoawal,
          kode_akun: kode_akun,
          kode_edit: kode_edit,
          jumlah: jumlah
        },
        cache: false,
        success: function(respond) {
          tampiltemp();

          $('#jumlah').val("");
          $('#kode_edit').val(0);
          var $select = $('#kode_akun').selectize();
          var control = $select[0].selectize;
          control.clear();
        }
      });
    });

    $("#clear").click(function(e) {
      $('#jumlah').val("");
      $('#kode_akun').val("");
      var $select = $('#kode_akun').selectize();
      var control = $select[0].selectize;
      control.clear();
      $("#kode_akun")[0].selectize.destroy();
    });

    $("#kode_akun").click(function(e) {
      $('#kode_akun').selectize();
    });

    // function loaddetailsaldo() {
    //   var bulan = $("#bulan").val();
    //   var tahun = $("#tahun").val();
    //   var kode_saldoawal = $("#kode_saldoawal").val();
    //   var thn = tahun.substr(2, 2);
    //   if (bulan == "") {
    //     swal("Oops!", "Bulan Harus Diisi !", "warning");
    //     return false;
    //   } else if (tahun == "") {
    //     swal("Oops!", "Tahun Harus Diisi !", "warning");
    //     return false;
    //   } else if (tanggal == "") {
    //     swal("Oops!", "Tanggal Harus Diisi !", "warning");
    //     return false;
    //   } else if (kode_saldoawal == "") {
    //     swal("Oops!", "Kode Harus Diisi !", "warning");
    //     return false;
    //   } else {
    //     $.ajax({
    //       type: 'POST',
    //       url: '<?php echo base_url(); ?>accounting/insert_salodawal',
    //       data: {
    //         bulan: bulan,
    //         tahun: tahun,
    //         kode_saldoawal: kode_saldoawal
    //       },
    //       cache: false,
    //       success: function(respond) {
    //         if (respond == 1) {
    //           $("#getsa").val(0);
    //           swal("Oops!", "Saldo Bulan Sebelumnya Belum Diset! Atau Saldo Bulan Tersebut Sudah Ada", "warning");
    //         } else {
    //           $("#getsa").val(1);
    //           $("#loaddetailsaldo").html(respond);
    //         }
    //       }
    //     });
    //   }
    // }

    $("#getsaldo").click(function(e) {
      e.preventDefault();
      loaddetailsaldo();
    });

    $(".formValidate").submit(function() {
      var kode_saldoawal = $("#kode_saldoawal").val();
      var kode_saldoawal = $("#kode_saldoawal").val();
      var cabang = $("#cabang").val();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var tanggal = $("#tanggal").val();
      var getsa = $("#getsa").val();
      if (kode_saldoawal == "") {
        swal("Oops!", "Saldo Awal Harus Diisi!", "warning");
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi !", "warning");
        return false;
      } else if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi !", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi !", "warning");
        return false;
      } else if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi !", "warning");
        $("#tanggal").focus();
        return false;
      }
    });

    // $('#mytable tbody').on('click', 'a', function() {
    //   $("#no_sj").val($(this).attr("data-nosj"));
    //   $("#datasj").modal("hide");
    //   loadNoMutasi();
    // });

  });
</script>