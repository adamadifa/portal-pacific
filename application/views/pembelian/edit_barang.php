<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/update_barang">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" value="<?php echo $brg['kode_barang']; ?>" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input type="text" value="<?php echo $brg['nama_barang']; ?>" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input type="text" value="<?php echo $brg['satuan']; ?>" id="satuan" name="satuan" class="form-control" placeholder="satuan" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="jenis_barang" name="jenis_barang" data-error=".errorTxt1">
      <option value="">PILIH JENIS BARANG</option>
      <option <?php if ($brg['jenis_barang'] == 'BAHAN BAKU') {
                echo "selected";
              } ?> value="BAHAN BAKU">BAHAN BAKU</option>
      <option <?php if ($brg['jenis_barang'] == 'BAHAN PEMBANTU') {
                echo "selected";
              } ?> value="BAHAN PEMBANTU">BAHAN PEMBANTU</option>
      <option <?php if ($brg['jenis_barang'] == 'Bahan Tambahan') {
                echo "selected";
              } ?> value="Bahan Tambahan">BAHAN TAMBAHAN</option>
      <option <?php if ($brg['jenis_barang'] == 'KEMASAN') {
                echo "selected";
              } ?> value="KEMASAN">KEMASAN</option>
      <option <?php if ($brg['jenis_barang'] == 'LAINNYA') {
                echo "selected";
              } ?> value="LAINNYA">LAINNYA</option>
    </select>
    </select>
  </div>
  <?php if (empty($departemen)) { ?>
    <div class="form-group  mb-3">
      <select class="form-select show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
        <option value="">PILIH DEPARTEMEN</option>
        <?php foreach ($dept as $d) { ?>
          <option <?php if ($d->kode_dept == $brg['kode_dept']) {
                    echo "selected";
                  } ?> value="<?php echo $d->kode_dept; ?>"><?php echo $d->nama_dept; ?></option>
        <?php }  ?>
      </select>
    </div>
  <?php } else { ?>
    <input type="hidden" name="departemen" id="departemen" value="<?php echo $departemen; ?>">
  <?php } ?>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="kode_kategori" name="kode_kategori" data-error=".errorTxt1">
      <option value="">PILIH KATEGORI</option>
      <?php foreach ($kategori as $d) { ?>
        <option <?php if ($d->kode_kategori == $brg['kode_kategori']) {
                  echo "selected";
                } ?> value="<?php echo $d->kode_kategori; ?>"><?php echo $d->kategori; ?></option>
      <?php }  ?>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="status" name="status" data-error=".errorTxt1">
      <option value="">PILIH STATUS</option>
      <option <?php if ($brg['status'] == "Aktif") {
                echo "selected";
              } ?> value="Aktif">Aktif</option>
      <option <?php if ($brg['status'] == "Tidak Aktif") {
                echo "selected";
              } ?> value="Tidak Aktif">Tidak Aktif</option>
    </select>
  </div>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
  </div>
</form>
<script type="text/javascript">
  $(function() {

    $("#formValidate").submit(function() {
      var kodebarang = $("#kodebarang").val();
      var namabarang = $("#nama_barang").val();
      var jenisbarang = $("#jenis_barang").val();
      var departemen = $("#departemen").val();
      if (kodebarang == "") {
        swal("Oops!", "Kode Barang Harus Diisi !", "warning");
        return false;
      } else if (namabarang == "") {
        swal("Oops!", "Nama Barang Harus Diisi !", "warning");
        return false;
      } else if (jenis_barang == "") {
        swal("Oops!", "Jenis Barang Harus Diisi !", "warning");
        return false;
      } else if (departemen == "") {
        swal("Oops!", "Departemen Harus Diisi !", "warning");
        return false;
      } else {
        return true;
      }
    });

  });
</script>