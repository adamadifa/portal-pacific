<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>kendaraan/input_kendaraan">
  <div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
      <div class="row align-items-center">
        <div class="col-auto">
          <h2 class="page-title">
            Data Kendaraaan
          </h2>
        </div>
      </div>
    </div>
    <!-- Content here -->
    <div class="row">
      <div class="col-md-5 col-xs-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Data Kendaraaan</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>No Polisi</label>
              <div class="form-line">
                <input type="text" id="no_polisi" name="no_polisi" class="form-control" placeholder="No Polisi" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Type</label>
              <div class="form-line">
                <input type="text" id="type" name="type" class="form-control" placeholder="Type" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Model</label>
              <div class="form-line">
                <input type="text" id="model" name="model" class="form-control" placeholder="Model" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Tahun</label>
              <div class="form-line">
                <input type="text" id="tahun" name="tahun" class="form-control" placeholder="Tahun" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>No Mesin</label>
              <div class="form-line">
                <input type="text" id="no_mesin" name="no_mesin" class="form-control" placeholder="No Mesin" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>No Rangka</label>
              <div class="form-line">
                <input type="text" id="no_rangka" name="no_rangka" class="form-control" placeholder="No Rangka" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>No STNK</label>
              <div class="form-line">
                <input type="text" id="no_stnk" name="no_stnk" class="form-control" placeholder="No STNK" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Pajak</label>
              <div class="form-line">
                <input type="text" id="pajak" name="pajak" class="form-control" placeholder="Pajak" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Atas Nama</label>
              <div class="form-line">
                <input type="text" id="atas_nama" name="atas_nama" class="form-control" placeholder="Atas Nama" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>KEUR</label>
              <div class="form-line">
                <input type="text" id="keur" name="keur" class="form-control" placeholder="KEUR" data-error=".errorTxt1" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5 col-xs-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">.</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label>No Uji</label>
              <div class="form-line">
                <input type="text" id="no_uji" name="no_uji" class="form-control" placeholder="No Uji" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>KIR</label>
              <div class="form-line">
                <input type="text" id="kir" name="kir" class="form-control" placeholder="KIR" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>STNK</label>
              <div class="form-line">
                <input type="text" id="stnk" name="stnk" class="form-control" placeholder="STNK" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>SIPA</label>
              <div class="form-line">
                <input type="text" id="sipa" name="sipa" class="form-control" placeholder="SIPA" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Pemakai</label>
              <div class="form-line">
                <input type="text" id="pemakai" name="pemakai" class="form-control" placeholder="Pemakai" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Jabatan</label>
              <div class="form-line">
                <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Jabatan" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <div class="form-line">
                <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Cabang</label>
              <div class="form-line">
                <select class="form-control" id="kode_cabang" name="kode_cabang" data-error=".errorTxt13">
                  <option value="">-- Pilih Cabang -- </option>
                  <?php foreach ($cabang as $c) { ?>
                    <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Kategori</label>
              <div class="form-line">
                <select class="form-control" id="status" name="status" data-error=".errorTxt13">
                  <option value="">-- Pilih Kategori --</option>
                  <option value="Operasional">Operasional</option>
                  <option value="Non Operasional">Non Operasional</option>
                </select>
              </div>
            </div>
            <div class="form-group" align="right">
              <label></label>
              <div class="form-line">
                <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-xs-12">
        <?php $this->load->view('menu/menu_masterpenjualan'); ?>
      </div>
    </div>
  </div>
</form>

<div class="modal modal-blur fade" id="inputkendaraan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
      </div>
      <div class="modal-body">
        <div class="modal-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-title">
          Yakin Untuk Di Hapus ?
        </div>
        <div>Data Akan Terhapus !</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete">Yes, delete</a>
      </div>
    </div>
  </div>
</div>
<script>
  $(function() {

    $("#tambahkendaraan").click(function() {
      $("#inputkendaraan").modal("show");
      $(".modal-content").load("<?php echo base_url(); ?>kendaraan/input_kendaraan");
    });

    $(".edit").click(function() {
      $id = $(this).attr('data-id');
      $("#inputkendaraan").modal("show");
      $(".modal-content").load("<?php echo base_url(); ?>kendaraan/edit_kendaraan/" + $id);
    });

    $(".detail").click(function() {
      $id = $(this).attr('data-id');
      $("#detailkendaraan").modal("show");
      $(".modal-content").load("<?php echo base_url(); ?>kendaraan/detail_kendaraan/" + $id);
    });

  });
</script>