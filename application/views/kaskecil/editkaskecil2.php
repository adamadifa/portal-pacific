<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>kaskecil/update_kaskecil">
  <input type="hidden" id="status" name="status" value="<?php echo $status; ?>">
  <input type="hidden" id="cekdetailtmp">
  <input type="hidden" id="kodecr" name="kodecr" value="<?php echo $kodecr; ?>">
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="date" <?php echo $disabled; ?> id="tanggal" value="<?php echo $kaskecil['tgl_kaskecil'] ?>" name="tanggal" class="form-control" placeholder="Tanggal" />
        <span class="input-icon-addon">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" />
            <rect x="4" y="5" width="16" height="16" rx="2" />
            <line x1="16" y1="3" x2="16" y2="7" />
            <line x1="8" y1="3" x2="8" y2="7" />
            <line x1="4" y1="11" x2="20" y2="11" />
            <line x1="11" y1="15" x2="12" y2="15" />
            <line x1="12" y1="15" x2="12" y2="18" />
          </svg>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="text" <?php echo $readonly; ?> value="<?php echo $kaskecil['nobukti'] ?>" id="nobukti_edit" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt2" />
        <input type="hidden" value="<?php echo $kaskecil['id'] ?>" id="id" name="id" class="form-control" placeholder="No Bukti" data-error=".errorTxt2" />
        <span class="input-icon-addon">
          <i class="fa fa-barcode"></i>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="text" <?php echo $readonly; ?> value="<?php echo $kaskecil['keterangan'] ?>" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt2" />
        <span class="input-icon-addon">
          <i class="fa fa-file"></i>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="text" <?php echo $readonly; ?> value="<?php echo number_format($kaskecil['jumlah'], '0', '', '.'); ?>" style="text-align:right" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt2" />
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
          <option <?php if ($kaskecil['kode_akun'] == $r->kode_akun) {
                    echo "selected";
                  } ?> value="<?php echo $r->kode_akun; ?>"><?php echo $r->kode_akun . " " . $r->nama_akun; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="mb-3">
    <div>
      <label class="form-check form-check-inline">
        <input class="form-check-input" name="inout" value="K" type="radio" <?php if ($kaskecil['status_dk'] == 'K') {
                                                                              echo "checked";
                                                                            } ?>>
        <span class="form-check-label">IN</span>
      </label>
      <label class="form-check form-check-inline">
        <input class="form-check-input" name="inout" value="D" type="radio" <?php if ($kaskecil['status_dk'] == 'D') {
                                                                              echo "checked";
                                                                            } ?>>
        <span class="form-check-label">OUT</span>
      </label>
    </div>
  </div>

  <?php if ($this->session->userdata('cabang') == "pusat") { ?>
    <div class="mb-3">
      <div>
        <label class="form-check form-check-inline">
          <input class="form-check-input" name="peruntukan" value="PCF" type="radio" <?php if ($kaskecil['peruntukan'] == 'PCF') {
                                                                                        echo "checked";
                                                                                      } ?>>
          <span class="form-check-label">Pacific</span>
        </label>
        <label class="form-check form-check-inline">
          <input class="form-check-input" name="peruntukan" value="MP" type="radio" <?php if ($kaskecil['peruntukan'] == 'MP') {
                                                                                      echo "checked";
                                                                                    } ?>>
          <span class="form-check-label">Makmur Permata</span>
        </label>
      </div>
    </div>
  <?php } ?>
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
<script type="text/javascript">
  $(function() {

    $('.datepicker').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      clearButton: true,
      weekStart: 1,
      time: false
    });

    $("#kodeakun").selectpicker('refresh');

    $("#formValidate").submit(function() {
      var tanggal = $("#tanggal").val();
      var nobukti = $("#nobukti_edit").val();
      var keterangan = $("#keterangan").val();

      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        $("#tanggal").focus()
        return false;
      } else if (nobukti == "") {
        swal("Oops!", "No Bukti Masih Kosong!", "warning");
        $("#nobukti").focus()
        return false;
      } else if (keterangan == "") {
        swal("Oops!", "Penerima Masih Kosong!", "warning");
        $("#keterangan").focus()
        return false;
      } else {
        return true;
      }
    });
  });
</script>