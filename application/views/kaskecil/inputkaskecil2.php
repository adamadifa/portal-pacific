<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>kaskecil/insert_kaskecil2">
  <input type="hidden" id="cekkaskeciltemp" value="">
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="date" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal" />
        <span class="input-icon-addon">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" />
            <rect x="4" y="5" width="16" height="16" rx="2" />
            <line x1="16" y1="3" x2="16" y2="7" />
            <line x1="8" y1="3" x2="8" y2="7" />
            <line x1="4" y1="11" x2="20" y2="11" />
            <line x1="11" y1="15" x2="12" y2="15" />
            <line x1="12" y1="15" x2="12" y2="18" /></svg>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="text" id="nobukti_input" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt2" />
        <span class="input-icon-addon">
          <i class="fa fa-barcode"></i>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt2" />
        <span class="input-icon-addon">
          <i class="fa fa-file"></i>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="text" style="text-align:right" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" />
        <div id="terbilang" style="float:right;"></div>
        <span class="input-icon-addon">
          <i class="fa fa-money"></i>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <select class="form-select show-tick " id="kodeakun" name="kodeakun">
        <?php foreach ($coa as $r) { ?>
          <option value="<?php echo $r->kode_akun; ?>"><?php echo $r->kode_akun . " " . $r->nama_akun; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="custom-controls-stacked">
        <label class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="inout" value="K" checked>
          <span class="custom-control-label">IN</span>
        </label>
        <label class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="inout" value="D">
          <span class="custom-control-label">OUT</span>
        </label>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-end mb-3">
    <a href="#" id="simpantemp" class="btn btn-sm btn-danger">
      <i class="fa fa-plus mr-2"></i> Tambah
    </a>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Keterangan</th>
          <th>Jumlah</th>
          <th>IN/OUT</th>
          <th>Akun</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="tampilkaskeciltemp">

      </tbody>
    </table>
  </div>
  <div class="row mt-6">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
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
<script>
  $(function() {
    $('#kodeakun').selectize({});

    function cektutuplaporan() {
      var tgltransaksi = $("#tanggal").val();
      var jenis = 'kaskecil';
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
            $("#tanggal").val("");
          }
        }
      });
    }

    $("#tanggal").change(function() {
      cektutuplaporan();
    });



    function loadtampilkaskeciltemp() {
      var nobukti = $("#nobukti_input").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/tampilkaskeciltemp',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#tampilkaskeciltemp").html(respond);
        }
      });
    }

    function cekkaskeciltemp() {
      var nobukti = $("#nobukti_input").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/cekkaskeciltemp',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#cekkaskeciltemp").val(respond);
        }
      });
    }

    cekkaskeciltemp();
    $("#nobukti_input").on('keyup keydown change', function() {
      loadtampilkaskeciltemp();
      cekkaskeciltemp();
    });
    $("#simpantemp").click(function(e) {
      e.preventDefault();
      var tanggal = $("#tanggal").val();
      var nobukti = $("#nobukti_input").val();
      var keterangan = $("#keterangan").val();
      var jumlah = $("#jumlah").val();
      var kodeakun = $("#kodeakun").val();
      var inout = $("input[name='inout']:checked").val();

      //alert(inout);
      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        $("#tanggal").focus()
      } else if (nobukti == "") {
        swal("Oops!", "No Bukti Masih Kosong!", "warning");
        $("#nobukti").focus()
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan Masih Kosong!", "warning");
        $("#penerima").focus()
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Masih Kosong!", "warning");
        $("#jumlah").focus()
      } else if (kodeakun == "") {
        swal("Oops!", "Akun Masih Kosong!", "warning");
        $("#kodeakun").focus()
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>kaskecil/insert_kaskecil_temp',
          data: {
            tanggal: tanggal,
            keterangan: keterangan,
            nobukti: nobukti,
            jumlah: jumlah,
            kodeakun: kodeakun,
            inout: inout
          },
          cache: false,
          success: function(respond) {
            loadtampilkaskeciltemp();
            cekkaskeciltemp();
          }
        });
      }
    });
    $("#formValidate").submit(function() {
      var tanggal = $("#tanggal").val();
      var nobukti = $("#nobukti_input").val();

      var cekkaskeciltemp = $("#cekkaskeciltemp").val();
      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        return false;
      } else if (nobukti == "") {
        swal("Oops!", "No Bukti Masih Kosong!", "warning");
        return false;
      } else if (cekkaskeciltemp == 0 || cekkaskeciltemp == "") {
        swal("Oops!", "Data Masih Kosong!", "warning");
        return false;
      } else {
        return true;
      }
    });
  })
</script>