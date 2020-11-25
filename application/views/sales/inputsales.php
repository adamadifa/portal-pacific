<form autocomplete="off" id="salesForm" method="POST" action="<?php echo base_url(); ?>sales/insert_sales">
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">Kode Sales</label>
      <div class="form-group">
        <input type="text" <?php if(!empty($getsales['id_karyawan'])){ echo "readonly"; } ?> value="<?php echo $getsales['id_karyawan']; ?>" id="kodesales" name="kodesales" class="form-control" placeholder="Kode Sales">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">Nama Sales</label>
      <div class="form-group">
        <input type="text" value="<?php echo $getsales['nama_karyawan']; ?>" id="namasales" name="namasales" class="form-control" placeholder="Nama Sales">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">Alamat Sales</label>
      <div class="form-group">
        <input type="text" value="<?php echo $getsales['alamat_karyawan']; ?>" id="alamatsales" name="alamatsales" class="form-control" placeholder="Alamat Sales">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">No HP</label>
      <div class="form-group">
        <input type="text" value="<?php echo $getsales['no_hp']; ?>" id="no_hp" name="no_hp" class="form-control" placeholder="No HP">
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Cabang</label>
      <div class="form-group">
        <select id="cabang" name="cabang" class="form-select">
          <option value="">-- Pilih Cabang -- </option>
          <?php foreach ($cabang as $c) { ?>
            <option <?php if ($getsales['kode_cabang']==$c->kode_cabang){ echo "selected";} ?>  value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  <div class="row ">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="simpan" class="btn btn-primary" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
      </div>
    </div>
  </div>
</form>

<script>
  $(function() {
    $('#salesForm').bootstrapValidator({
      message: 'This value is not valid',
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        kodesales: {

          validators: {
            notEmpty: {
              message: 'Kode Sales Harus Diisi !'
            }


          }
        },

        namasales: {
          validators: {
            notEmpty: {
              message: 'Nama Sales Harus Diisi !'
            }


          }
        },

        alamatsales: {
          validators: {
            notEmpty: {
              message: 'Alamat Sales Harus Diisi !'
            }


          }
        },

        no_hp: {
          validators: {
            notEmpty: {
              message: 'No HP Harus Diisi !'
            }


          }
        },

        cabang: {
          validators: {
            notEmpty: {
              message: 'Cabang Harus Diisi !'
            }


          }
        },




      }
    });
  });
</script>