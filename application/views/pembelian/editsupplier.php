<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          EDIT DATA SUPPLIER
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"> EDIT DATA SUPPLIER </h4>
            </div>
            <div class="card-body">
              <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/update_supplier">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" value="<?php echo $supplier['kode_supplier']; ?>" id="kodesupplier" name="kodesupplier" class="form-control" placeholder="Kode Supplier" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input type="text" value="<?php echo $supplier['nama_supplier']; ?>" readonly id="namasupplier" name="namasupplier" class="form-control" placeholder="Nama Supplier" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input type="text" value="<?php echo $supplier['contact_supplier'] ?>" id="cp" name="cp" class="form-control" placeholder="Contact Person" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-phone"></i>
                    </span>
                    <input type="text" value="<?php echo $supplier['nohp_supplier']; ?>" id="nohp" name="nohp" class="form-control" placeholder="No HP" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-map-o"></i>
                    </span>
                    <input type="text" value="<?php echo $supplier['alamat_supplier']; ?>" id="alamat" name="alamat" class="form-control" placeholder="Alamat" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-envelope-o"></i>
                    </span>
                    <input type="text" value="<?php echo $supplier['email']; ?>" id="email" name="email" class="form-control" placeholder="Email" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-file-o"></i>
                    </span>
                    <input type="text" value="<?php echo $supplier['norekening']; ?>" id="norek" name="norek" class="form-control" placeholder="No Rekening" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                  <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_pembelian_administrator'); ?>
    </div>
  </div>
</div>