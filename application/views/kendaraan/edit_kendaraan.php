<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>kendaraan/edit_kendaraan">
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
            <div class="form-group" hidden>
              <label>ID</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['id']; ?>" id="id" name="id" class="form-control" placeholder="ID" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>No Polisi</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['no_polisi']; ?>" id="no_polisi" name="no_polisi" class="form-control" placeholder="No Polisi" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Type</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['type']; ?>" id="type" name="type" class="form-control" placeholder="Type" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Model</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['model']; ?>" id="model" name="model" class="form-control" placeholder="Model" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Tahun</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['tahun']; ?>" id="tahun" name="tahun" class="form-control" placeholder="Tahun" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>No Mesin</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['no_mesin']; ?>" id="no_mesin" name="no_mesin" class="form-control" placeholder="No Mesin" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>No Rangka</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['no_rangka']; ?>" id="no_rangka" name="no_rangka" class="form-control" placeholder="No Rangka" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>No STNK</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['no_stnk']; ?>" id="no_stnk" name="no_stnk" class="form-control" placeholder="No STNK" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Pajak</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['pajak']; ?>" id="pajak" name="pajak" class="form-control" placeholder="Pajak" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Atas Nama</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['atas_nama']; ?>" id="atas_nama" name="atas_nama" class="form-control" placeholder="Atas Nama" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>KEUR</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['keur']; ?>" id="keur" name="keur" class="form-control" placeholder="KEUR" data-error=".errorTxt1" />
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
                <input type="text" value="<?php echo $getdata['no_uji']; ?>" id="no_uji" name="no_uji" class="form-control" placeholder="No Uji" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>KIR</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['kir']; ?>" id="kir" name="kir" class="form-control" placeholder="KIR" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>STNK</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['stnk']; ?>" id="stnk" name="stnk" class="form-control" placeholder="STNK" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>SIPA</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['sipa']; ?>" id="sipa" name="sipa" class="form-control" placeholder="SIPA" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Pemakai</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['pemakai']; ?>" id="pemakai" name="pemakai" class="form-control" placeholder="Pemakai" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Jabatan</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['jabatan']; ?>" id="jabatan" name="jabatan" class="form-control" placeholder="Jabatan" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <div class="form-line">
                <input type="text" value="<?php echo $getdata['keterangan']; ?>" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt1" />
              </div>
            </div>
            <div class="form-group">
              <label>Cabang</label>
              <div class="form-line">
                <select class="form-control" id="kode_cabang" name="kode_cabang" data-error=".errorTxt13">
                  <option value="">-- Pilih Cabang -- </option>
                  <?php foreach ($cabang as $c) { ?>
                    <option <?php if ($c->kode_cabang == $getdata['kode_cabang']) {
                              echo "selected";
                            } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Kategori</label>
              <div class="form-line">
                <select class="form-control" id="status" name="status" data-error=".errorTxt13">
                  <option value="">-- Pilih Kategori --</option>
                  <option <?php if ($getdata['status'] == "Operasional") {
                            echo "selected";
                          } ?> value="Operasional">Operasional</option>
                  <option <?php if ($getdata['status'] == "Non Operasional") {
                            echo "selected";
                          } ?> value="Non Operasional">Non Operasional</option>
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
