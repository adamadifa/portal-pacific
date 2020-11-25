<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>keuangan/updateledger">
  <input type="hidden" name="kodecr" value="<?php echo $kodecr; ?>">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" value="<?php echo $ledger['no_bukti']; ?>" readonly id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" id="tglledger" value="<?php echo $ledger['tgl_ledger']; ?>" name="tglledger" class="form-control datepicker date" placeholder="Tanggal" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" id="noref" value="<?php echo $ledger['no_ref']; ?>" name="noref" class="form-control" placeholder="No Ref" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-users"></i>
      </span>
      <input type="text" id="pelanggan" value="<?php echo $ledger['pelanggan']; ?>" name="pelanggan" class="form-control" placeholder="Pelanggan" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-users"></i>
      </span>
      <input type="text" id="keterangan" value="<?php echo $ledger['keterangan']; ?>" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt11">
    </div>
  </div>

  <div class="form-group mb-3">
    <select class="form-select show-tick " id="kodeakun" name="kodeakun">
      <?php foreach ($coa as $r) { ?>
        <option <?php if ($ledger['kode_akun'] == $r->kode_akun) {
                  echo "selected";
                } ?> value="<?php echo $r->kode_akun; ?>"><?php echo $r->kode_akun . " " . $r->nama_akun; ?>
        </option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
      <input type="text" id="jumlah" value="<?php echo number_format($ledger['jumlah'], '2', ',', '.'); ?>" style="text-align:right" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt11">
    </div>
  </div>

  <div class="form-group mb-3">
    <select class="form-select show-tick" id="lbank" name="lbank" data-error=".errorTxt1">
      <?php foreach ($lbank as $b) { ?>
        <option <?php if ($ledger['bank'] == $b->kode_bank) {
                  echo "selected";
                } ?> value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick " id="debetkredit" name="debetkredit" data-error=".errorTxt1">
      <option <?php if ($ledger['status_dk'] == 'D') {
                echo "selected";
              } ?> value="D">Debet</option>
      <option <?php if ($ledger['status_dk'] == 'K') {
                echo "selected";
              } ?> value="K">Kredit</option>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick " id="peruntukan" name="peruntukan" data-error=".errorTxt1">
      <option value="">Pilih Peruntukan</option>
      <option <?php if ($ledger['peruntukan'] == 'PC') {
                echo "selected";
              } ?> value="PC">CV. PACIFIC</option>
      <option <?php if ($ledger['peruntukan'] == 'MP') {
                echo "selected";
              } ?> value="MP">CV. MAKMUR PERMATA</option>
    </select>
  </div>
  <div class="form-group mb-3" id="ketperuntukan">
    <select class="form-select show-tick " id="ket_peruntukan" name="ket_peruntukan" data-error=".errorTxt1">
      <option value="">Pilih Cabang</option>
      <?php foreach ($cabang as $c) { ?>
        <option <?php if ($ledger['ket_peruntukan'] == $c->kode_cabang) {
                  echo "selected";
                } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo $c->nama_cabang; ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" id="simpan" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Update</button>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tglledger'), {});
</script>
<script>
  var jml = document.getElementById("jumlah");
  jml.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    jml.value = formatRupiah(this.value, "");

    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }
      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
      return prefix == undefined ? rupiah : rupiah ? rupiah : "";
    }
  });
</script>
<script>
  $(function() {
    $('#kodeakun').selectize({});

    function hideketperuntukan() {
      var peruntukan = $("#peruntukan").val();
      if (peruntukan == "MP") {
        $("#ketperuntukan").hide();
      } else {
        $("#ketperuntukan").show();
      }

    }
    hideketperuntukan();

    $("#peruntukan").change(function() {
      var peruntukan = $(this).val();
      if (peruntukan == "PC") {
        $("#ketperuntukan").show();
      } else {
        hideketperuntukan();
      }

    })
  });
</script>