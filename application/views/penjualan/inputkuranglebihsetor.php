<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/inputkuranglebihsetor">
  <input type="hidden" id="ceksetoranpenjualan">
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Tanggal</label>
      <div class="input-icon">
        <input type="text" id="tglbayarkl" name="tglbayarkl" class="form-control datepicker date" placeholder="Tanggal Pembayaran" data-error=".errorTxt11">
        <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
  <?php if ($sess_cab == 'pusat') { ?>
    <div class="form-group mb-3">
      <select class="form-select" id="cabangkb" name="cabangkb" data-error=".errorTxt1">
        <option value="">-- Pilih Cabang --</option>
        <?php foreach ($cabang as $c) { ?>
          <option <?php if ($cbg == $c->kode_cabang) {
                    echo "selected";
                  } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
        <?php } ?>
      </select>
      <div class="errorTxt1"></div>
    </div>
  <?php } else { ?>
    <input type="hidden" name="cabangkb" id="cabangkb" value="<?php echo $sess_cab; ?>">
  <?php } ?>
  <div class="mb-3">
    <select id="salesmankb" name="salesmankb" class="form-select">
      <option value="">-- Semua Salesman --</option>
    </select>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Uang Kertas</label>
        <div class="input-icon">
          <input type="text" value="0" onkeyup="calc()" style="text-align:right; font-weight:bold; color:#dc3545" id="uangkertas" name="uangkertas" class="form-control" placeholder="Uang Kertas" />
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Uang Logam</label>
        <div class="input-icon">
          <input type="text" value="0" onkeyup="calc()" style="text-align:right; font-weight:bold; color:#dc3545" id="uanglogam" name="uanglogam" class="form-control" placeholder="Uang Logam" />
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Jumlah</label>
        <div class="input-icon">
          <input type="text" readonly style="text-align:right; font-weight:bold" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt11">
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <label class="form-label">Pembayaran</label>
  <div class="form-group">
    <select class="form-select" id="pembayaran" name="pembayaran" data-error=".errorTxt1">
      <option value="">Pilih Pembayaran</option>
      <option value="1">Kurang Setor</option>
      <option value="2">Lebih Setor</option>
    </select>
  </div>
  <label class="form-label">Keterangan</label>
  <div class="form-group">
    <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt11">
  </div>
  <div class="row mt-3">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
      </div>
    </div>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tglbayarkl'), {});
</script>
<script>
  var uk = document.getElementById('uangkertas');
  var ul = document.getElementById('uanglogam');
  uk.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    uk.value = formatRupiah(this.value, '');
  });
  ul.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    ul.value = formatRupiah(this.value, '');
  });

  function calc() {
    uangkertasrupiah = document.getElementById("uangkertas").value;
    uangkertas = uangkertasrupiah.replace(/\./g, '');
    uanglogamrupiah = document.getElementById("uanglogam").value;
    uanglogam = uanglogamrupiah.replace(/\./g, '');

    if (uangkertas == "") {
      uangkertas = 0;
    }
    if (uanglogam == "") {
      uanglogam = 0;
    }
    var result = parseInt(uangkertas) + parseInt(uanglogam);
    if (!isNaN(result)) {
      totalsetoran = document.getElementById('jumlah').value = result;
      document.getElementById("jumlah").value = convertToRupiah(totalsetoran);
    }
  }

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

<script>
  $(function() {
    function loadSalesman() {
      var cabang = $("#cabangkb").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/get_salesman2',
        data: {
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $("#salesmankb").html(respond);
        }
      });
    }

    function cek_setoranpenjualan() {
      var tgl = $("#tglbayarkl").val();
      var salesman = $("#salesmankb").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/cek_setoranpenjualan',
        data: {
          tgl: tgl,
          salesman: salesman
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          $("#ceksetoranpenjualan").val(respond);
        }
      });
    }
    cek_setoranpenjualan();
    loadSalesman();

    $("#cabangkb").change(function() {
      loadSalesman();
    });

    $("#tglbayarkl").change(function(e) {
      e.preventDefault();
      cek_setoranpenjualan();
    });

    $("#salesmankb").change(function(e) {
      e.preventDefault();
      cek_setoranpenjualan();
    });

    $("#formValidate").submit(function() {
      var tgl = $("#tglbayarkl").val();
      var cabang = $("#cabangkb").val();
      var salesman = $("#salesmankb").val();
      var jumlah = $("#jumlah").val();
      var ceksetoran = $("#ceksetoranpenjualan").val();
      var keterangan = $("#keterangan").val();
      var pembayaran = $("#pembayaran").val();
      if (tgl == "") {
        swal("Oops!", "Tanggal Harus Diisi.. !", "warning");
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi!", "warning");
        return false;
      } else if (salesman == "") {
        swal("Oops!", "Salesman Harus Diisi!", "warning");
        return false;
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Harus Diisi!", "warning");
        return false;
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan Harus Diisi!", "warning");
        return false;
      } else if (keterangan == "") {
        swal("Oops!", "Jenis Pembayaran Harus Diisi!", "warning");
        return false;
      } else if (ceksetoran == 0) {
        swal("Oops!", "Belum Ada Setoran Sales Pada Tanggal Tersebut!", "warning");
        return false;
      } else {
        return true;
      }
    });
  })
</script>