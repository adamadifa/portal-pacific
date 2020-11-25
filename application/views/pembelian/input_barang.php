<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/insert_barang">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" value="" id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input type="text" value="" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input type="text" value="" id="satuan" name="satuan" class="form-control" placeholder="satuan" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="jenis_barang" name="jenis_barang" data-error=".errorTxt1">
      <option value="">--Pilih Jenis Barang--</option>
      <option value="BAHAN BAKU">BAHAN BAKU</option>
      <option value="BAHAN PEMBANTU">BAHAN PEMBANTU</option>
      <option value="KEMASAN">KEMASAN</option>
      <option value="LAINNYA">LAINNYA</option>
    </select>
  </div>
  <?php if (empty($departemen)) { ?>
    <div class="form-group  mb-3">
      <select class="form-select show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
        <option value="">--Departemen--</option>
        <?php foreach ($pemohon as $d) { ?>
          <option value="<?php echo $d->kode_dept; ?>"><?php echo $d->nama_dept; ?></option>
        <?php }  ?>
      </select>
    </div>
  <?php } else { ?>
    <input type="hidden" name="departemen" id="departemen" value="<?php echo $departemen; ?>">
  <?php } ?>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="kode_kategori" name="kode_kategori" data-error=".errorTxt1">
      <option value="">--Kategori--</option>
      <?php foreach ($kategori as $d) { ?>
        <option value="<?php echo $d->kode_kategori; ?>"><?php echo $d->kategori; ?></option>
      <?php }  ?>
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
      var kode_kategori = $("#kode_kategori").val();
      if (kodebarang == "") {
        swal("Oops!", "Kode Barang Harus Diisi !", "warning");
        return false;
      } else if (namabarang == "") {
        swal("Oops!", "Nama Barang Harus Diisi !", "warning");
        return false;
      } else if (jenis_barang == "") {
        swal("Oops!", "Jenis Barang Harus Diisi !", "warning");
        return false;
      } else if (kode_kategori == "") {
        swal("Oops!", "Kategori Barang Harus Diisi !", "warning");
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