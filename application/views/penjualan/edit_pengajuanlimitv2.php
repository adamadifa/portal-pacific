V2
<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/updatepengajuanlimitv2">
  <input type="hidden" value="<?php echo $pengajuan['no_pengajuan']; ?>" name="nopengajuan">
  <input type="hidden" value="<?php echo $pengajuan['status']; ?>" name="status">
  <input type="hidden" value="<?php echo $pengajuan['jumlah']; ?>" name="jumlahold">
  <input type="hidden" value="<?php echo $pengajuan['kode_pelanggan']; ?>" name="kodepelanggan">
  <?php
  // if (!empty($pengajuan['jumlah_rekomendasi'])) {
  //   $persentase = ($pengajuan['jumlah_rekomendasi'] - $pengajuan['jumlah']) / $pengajuan['jumlah'] * 100;
  // } else {
  //   $persentase = 0;
  // }

  if (!empty($pengajuan['jumlah_rekomendasi'])) {
    $persentase = ($pengajuan['jumlah_rekomendasi'] - $pengajuan['jumlah']);
  } else {
    $persentase = 0;
  }

  if (!empty($pengajuan['jatuhtempo_rekomendasi'])) {
    $jatuhtempo = $pengajuan['jatuhtempo_rekomendasi'];
  } else {
    $jatuhtempo = $pengajuan['jatuhtempo'];
  }
  ?>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Jumlah</label>
        <div class="input-icon">
          <input type="text" style="text-align:right" id="jumlah" value="<?php echo number_format($persentase, '0', '', '.'); ?>" name="jumlah" class="form-control" placeholder="Jumlah Dalam Rupiah" />
          <div id="terbilang" style="float:right;"></div>
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>

        </div>
      </div>
      <small style="color:red">Isi Dalam Bentuk Nominal Rupiah</small>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">Jatuh Tempo</label>
      <div class="form-group">
        <select id="jatuhtempo" name="jatuhtempo" class="form-select">
          <option value="">Pilih Jatuh Tempo</option>
          <option <?php if ($jatuhtempo == '14') {
                    echo "selected";
                  } ?> value="14">14 Hari</option>
          <option <?php if ($jatuhtempo == '30') {
                    echo "selected";
                  } ?> value="30">30 Hari</option>
          <option <?php if ($jatuhtempo == '45') {
                    echo "selected";
                  } ?> value="45">45 Hari</option>
        </select>
      </div>
    </div>
  </div>
  <small style="color:red">*) Kosongkan Jika Sudah Melakukan Pengajuan Jatuh Tempo</small>
  <div class="row ">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="simpan" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
      </div>
    </div>
  </div>
</form>
<script>
$(function(){
  $("#jumlah").maskMoney();
});
</script>
<!-- <script type="text/javascript">
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
</script> -->