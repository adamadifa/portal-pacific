<?php
function uang($nilai)
{
  return number_format($nilai, '0', '', '.');
}
?>
<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Koreksi Faktur
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Koreksi Faktur</h4>
        </div>
        <div class="card-body">
          <form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/editfaktur">
            <div class="form-group form-float">
              <div class="form-line">
                <input type="hidden" value="<?php echo $getfaktur['no_fak_penj']; ?>" id="nofaktur" name="nofaktur" class="form-control" data-error=".errorTxt1" />
                <input type="text" value="<?php echo $getfaktur['no_fak_penj']; ?>" id="no_faktur" name="no_faktur" class="form-control" data-error=".errorTxt1" />
                <label class="form-label">No Faktur</label>
              </div>
              <div class="errorTxt1"></div>
            </div>
            <div class="form-group form-float">
              <div class="form-line">
                <input type="text" value="<?php echo $getfaktur['tgltransaksi']; ?>" id="tgltransaksi" name="tgltransaksi" class="form-control" data-error=".errorTxt2" />
                <label class="form-label">Tanggal Transaksi</label>
              </div>
              <div class="errorTxt2"></div>
            </div>
            <div class="form-group form-float">
              <div class="form-line">
                <input type="text" value="<?php echo $getfaktur['kode_pelanggan']; ?>" id="kodepelanggan" name="kodepelanggan" readonly class="form-control" data-error=".errorTxt3" />
                <label class="form-label">Kode Pelanggan</label>
              </div>
              <div class="errorTxt3"></div>
            </div>
            <div class="form-group form-float">
              <div class="form-line">
                <input type="text" value="<?php echo $getfaktur['nama_pelanggan']; ?>" id="pelanggan" name="pelanggan" readonly class="form-control" data-error=".errorTxt4" />
                <label class="form-label">Pelanggan</label>
              </div>
              <div class="errorTxt4"></div>
            </div>

            <div class="form-group">
              <div class="form-line">
                <select class="form-control" id="sales" name="sales" data-error=".errorTxt9">
                  <option value="">-- Pilih Sales -- </option>
                  <?php foreach ($sales as $c) { ?>
                    <option <?php if ($getfaktur['id_karyawan'] == $c->id_karyawan) {
                              echo "selected";
                            } ?> value="<?php echo $c->id_karyawan; ?>"><?php echo strtoupper($c->nama_karyawan); ?></option>
                  <?php } ?>
                </select>
                <label class="form-label">Sales</label>
              </div>
              <div class="errorTxt9"></div>
            </div>
            <div class="form-group">
              <div class="form-line">
                <select class="form-control" id="jenistransaksi" name="jenistransaksi" data-error=".errorTxt9">
                  <option value="">-- Jenis Transaksi -- </option>
                  <option <?php if ($getfaktur['jenistransaksi'] == 'tunai') {
                            echo "selected";
                          } ?> value="tunai">Tunai</option>
                  <option <?php if ($getfaktur['jenistransaksi'] == 'kredit') {
                            echo "selected";
                          } ?> value="kredit">Kredit</option>

                </select>
                <label class="form-label">Jenis Transaksi</label>
              </div>
              <div class="errorTxt9"></div>
            </div>
            <div class="form-group">
              <div class="d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
    </div>
  </div>
</div>