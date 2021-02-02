<form autocomplete="off" class="limitForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>accounting/updatecostratiobiaya">
  <input type="hidden" name="kodecr" value="<?php echo $cr['kode_cr']; ?>">
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Tanggal</label>
      <div class="input-icon">
        <input type="date" id="tgl_transaksi" value="<?php echo $cr['tgl_transaksi']; ?>" name="tgl_transaksi" class="form-control" placeholder="Ex: 2018-07-16" />
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
    <label class="form-label">Cabang</label>
    <div class="form-group">
      <select name="cabang" id="cabang2" class="form-select">
        <option value="">-- Pilih Cabang --</option>
        <?php foreach ($cabang as $c) { ?>
          <option <?php if ($cr['kode_cabang'] == $c->kode_cabang) {
                    echo "selected";
                  } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <label class="form-label">Akun</label>
    <div class="form-group">
      <select class="form-select show-tick " id="kodeakun" name="kodeakun">
        <?php foreach ($coa as $r) { ?>
          <option <?php if ($cr['kode_akun'] == $r->kode_akun) {
                    echo "selected";
                  } ?> value="<?php echo $r->kode_akun; ?>"><?php echo $r->kode_akun . " " . $r->nama_akun; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <label class="form-label">Jumlah</label>
    <div class="form-group">
      <input type="text" value="<?php echo number_format($cr['jumlah'], '0', '', '.'); ?>" style="text-align:right" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" />
    </div>
  </div>
  <div class="row mb-3">
    <label class="form-label">Keterangan</label>
    <div class="form-group">
      <input type="text" value="<?php echo $cr['keterangan']; ?>" id=" keterangan" name="keterangan" class="form-control" placeholder="Keterangan" />
    </div>
  </div>
  <div class="row mb-3">
    <label class="form-label">Sumber</label>
    <div class="form-group">
      <select name="sumber" id="sumber" class="form-select">
        <option value="">-- Pilih Sumber --</option>
        <?php foreach ($sumber as $s) { ?>
          <option <?php if ($cr['id_sumber_costratio'] == $s->id_sumber_costratio) {
                    echo "selected";
                  } ?> value="<?php echo $s->id_sumber_costratio; ?>"><?php echo strtoupper($s->nama_sumber); ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <div class="d-flex justify-content-end">
      <button type="submit" name="simpan" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
    </div>
  </div>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tgl_transaksi'), {});
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

    $("#formValidate").submit(function() {
      var tanggal = $("#tgl_transaksi").val();
      var cabang = $("#cabang2").val();
      var kodeakun = $("#kodeakun").val();
      var jumlah = $("#jumlah").val();
      var sumber = $("#sumber").val();
      var keterangan = $("#keterangan").val();
      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        $("#tanggal").focus()
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Masih Kosong!", "warning");
        return false;
      } else if (kodeakun == "") {
        swal("Oops!", "Kode Akun Masih Kosong!", "warning");
        return false;
      } else if (sumber == "") {
        swal("Oops!", "Sumber  Masih Kosong!", "warning");
        return false;
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan  Masih Kosong!", "warning");
        return false;
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Masih Kosong!", "warning");
        $("#jumlah").focus()
        return false;
      } else {
        return true;
      }
    });
  })
</script>