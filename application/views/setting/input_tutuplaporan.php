<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>setting/inserttutuplaporan">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-calendar-o"></i>
      </span>
      <input type="text" id="tanggal" name="tgl_penutupan" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt1" />
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="bulan" name="bulan" data-error=".errorTxt1">
      <option value="">Bulan</option>
      <?php
      for ($i = 1; $i < count($bulan); $i++) {
      ?>
        <option value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
      <?php
      }
      ?>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="tahun2" name="tahun" data-error=".errorTxt1">
      <?php
      $tahunmulai = 2018;
      for ($thn = $tahunmulai; $thn <= date('Y'); $thn++) {
      ?>
        <option <?php if (date('Y') == $thn) {
                  echo "Selected";
                } ?> value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
      <?php
      }
      ?>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="jenis_laporan" name="jenis_laporan" data-error=".errorTxt1">
      <option value="">Jenis Laporan</option>
      <option value="penjualan">PENJUALAN</option>
      <option value="kaskecil">KAS KECIL</option>
      <option value="pembelian">PEMBELIAN</option>
    </select>
  </div>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script type="text/javascript">
  $(function() {
    $("#formValidate").submit(function() {
      var tanggal = $("#tanggal").val();
      var bulan = $("#bulan").val();
      var tahun = $("#tahun").val();
      var jenis_laporan = $("#jenis_laporan").val();
      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        $("#tanggal").focus()
        return false;
      } else if (bulan == "") {
        swal("Oops!", "Bulan Masih Kosong!", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Masih Kosong!", "warning");
        return false;
      } else if (jenis_laporan == "") {
        swal("Oops!", "Jenis Laporan Masih Kosong!", "warning");
        return false;
      } else {
        return true;
      }
    });
  });
</script>