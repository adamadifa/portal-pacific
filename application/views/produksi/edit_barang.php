
<div class="card">
  <div class="header bg-cyan">
    <h2>
      Data Barang
      <small>Edit Data Barang</small>
    </h2>
  </div>
  <div class="body">
    <div class="row clearfix">
      <div class="col-sm-12">
        <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>produksi/update_barang">
          <div class="input-group demo-masked-input"  >
            <span class="input-group-addon">
              <i class="material-icons">chrome_reader_mode</i>
            </span>
            <div class="form-line">
              <input type="text" value="<?php echo $brg['kode_barang']; ?>" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt19" />
            </div>
          </div>
          <div class="input-group demo-masked-input"  >
            <span class="input-group-addon">
              <i class="material-icons">chrome_reader_mode</i>
            </span>
            <div class="form-line">
              <input type="text" value="<?php echo $brg['nama_barang']; ?>" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt19" />
            </div>
          </div>
          <div class="input-group demo-masked-input"  >
            <span class="input-group-addon">
              <i class="material-icons">chrome_reader_mode</i>
            </span>
            <div class="form-line">
              <input type="text" value="<?php echo $brg['satuan']; ?>" id="satuan" name="satuan" class="form-control" placeholder="satuan" data-error=".errorTxt19" />
            </div>
          </div>
          <div class="form-group" >
            <div class="form-line">
              <select class="form-control show-tick" id="kode_kategori" name="kode_kategori" data-error=".errorTxt1">
                <option value="">PILIH JENIS BARANG</option>
                <option <?php if ($brg['kode_kategori'] == 'SRG') { echo "selected"; }?> value="SRG">SAUS REGULER</option>
                <option <?php if ($brg['kode_kategori'] == 'SDP') { echo "selected"; }?> value="SDP">SAUS DP</option>
                <option <?php if ($brg['kode_kategori'] == 'SST') { echo "selected"; }?> value="SST">SAUS STIK</option>
                <option <?php if ($brg['kode_kategori'] == 'KCP') { echo "selected"; }?> value="KCP">KECAP</option>
                <option <?php if ($brg['kode_kategori'] == 'BBB') { echo "selected"; }?> value="BBB">BUMBU BUBUR BAWANG</option>
                <option <?php if ($brg['kode_kategori'] == 'LAIN') { echo "selected"; }?> value="LAIN">LAINNYA</option>
                <option <?php if ($brg['kode_kategori'] == 'BHN') { echo "selected"; }?> value="BHN">BAHAN</option>
                <option <?php if ($brg['kode_kategori'] == 'KMS') { echo "selected"; }?> value="KMS">KEMASAN</option>
              </select>
            </div>
          </div>
          <div class="form-group" >
            <div class="form-line">
              <select class="form-control show-tick" id="status" name="status" data-error=".errorTxt1">
                <option value="">PILIH STATUS</option>
                <option <?php if ($brg['status'] == "Aktif") { echo "selected"; }?> value="Aktif">Aktif</option>
                <option <?php if ($brg['status'] == "Tidak Aktif") { echo "selected"; }?> value="Tidak Aktif">Tidak Aktif</option>
              </select>
            </div>
          </div>
          <div class="form-group" >
            <button type="submit"  name="submit" class="btn bg-blue waves-effect">
              <i class="material-icons">save</i>
              <span>SIMPAN</span>
            </button>
            <button type="button" data-dismiss="modal" class="btn bg-red waves-effect">
              <i class="material-icons">cancel</i>
              <span>Batal</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/pages/forms/advanced-form-elements.js"></script>
<script type="text/javascript">
  $(function(){

    $("#formValidate").submit(function(){
      var kodebarang  = $("#kodebarang").val();
      var namabarang  = $("#nama_barang").val();
      var jenisbarang = $("#jenis_barang").val();
      var departemen  = $("#departemen").val();
      if(kodebarang=="")
      {
        swal("Oops!", "Kode Barang Harus Diisi !", "warning");
        return false;
      }else if(namabarang=="")
      {
        swal("Oops!", "Nama Barang Harus Diisi !", "warning");
        return false;
      }else if(jenis_barang=="")
      {
        swal("Oops!", "Jenis Barang Harus Diisi !", "warning");
        return false;
      }else if(departemen=="")
      {
        swal("Oops!", "Departemen Harus Diisi !", "warning");
        return false;
      }else{
        return true;
      }
    });

  });

</script>
