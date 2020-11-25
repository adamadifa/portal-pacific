<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/editlogamtokertas">
  <input type="hidden" value="<?php echo $lg['kode_logamtokertas']; ?>" name="kode_logamtokertas" class="form-control">
  <h3>Saldo : <b id="printsaldo"></b></h3>
  <input type="hidden" id="saldo">
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Tanggal</label>
      <div class="input-icon">
        <input type="text" id="tanggal" readonly value="<?php echo $lg['tgl_logamtokertas']; ?>" name="tanggal" class="form-control datepicker date" placeholder="Tanggal" data-error=".errorTxt11">
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
    <label>Cabang</label>
    <div class="form-group mb-3">
      <div class="form-line">
        <input type="text" readonly value="<?php echo $lg['kode_cabang']; ?>" id="cabangkb" name="cabangkb" class="form-control" placeholder="Cabang" data-error=".errorTxt11">
      </div>
    </div>
  <?php } else { ?>
    <input type="hidden" name="cabangkb" id="cabangkb" value="<?php echo $lg['kode_cabang']; ?>">
  <?php } ?>
  <div class="row">
    <div class="col-md-12 mb-3">
      <div class="form-group">
        <label class="form-label">Jumlah</label>
        <div class="input-icon">
          <input type="text" value="<?php echo number_format($lg['jumlah_logamtokertas'], '0', '', '.'); ?>" style="text-align:right" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" />
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-3">
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
<script>
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
  var j = document.getElementById('jumlah');
  j.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    j.value = formatRupiah(this.value, '');
  });
</script>
<script>
  $(function() {
    function loadSaldoLogam() {
      var cabang = $("#cabangkb").val();
      var tanggal = $("#tanggal").val();
      //alert(tanggal);
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/get_saldoawallogam',
        data: {
          cabang: cabang,
          tanggal: tanggal
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          var data = respond.split("|");
          $("#printsaldo").text(data[1]);
          $("#saldo").val(data[0]);
        }
      });
    }

    loadSaldoLogam();
    $("#cabangkb").change(function() {

      loadSaldoLogam();
    });
    $("#tanggal").change(function() {
      loadSaldoLogam();
    });

    $("#formValidate").submit(function() {
      var tanggal = $("#tanggal").val();
      var cabang = $("#cabangkb").val();
      var jumlah = $("#jumlah").val();
      var saldo = $("#saldo").val();
      var jml = jumlah.replace(".", "");
      if (tanggal == "") {
        swal("Oops!", "TanggalHarus Diisi.. !", "warning");
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi!", "warning");
        return false;
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Harus Diisi!", "warning");
        return false;
      } else if (parseInt(jml) > parseInt(saldo)) {
        swal("Oops!", "Saldo Tidak Mencukupi!", "warning");
        return false;
      } else {
        return true;
      }
    });
  })
</script>