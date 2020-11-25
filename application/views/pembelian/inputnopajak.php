<form name="autoSumForm" autocomplete="off" class="" id="formPajak" method="POST" action="<?php echo base_url(); ?>pembelian/update_fakturpajak">
  <input type="hidden" value="<?php echo $nobukti; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti Pembelian" data-error=".errorTxt19" />
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" id="nopajak" value="<?php echo $nopajak; ?>" name="nopajak" class="form-control" placeholder="No Faktur Pajak" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
  </div>
</form>

<script>
  $(function() {
    $("#formPajak").submit(function() {
      var nopajak = $("#nopajak").val();
      if (nopajak == "") {
        swal("Oops!", "No Pajak Harus Diisi !", "warning");
        return false;
      } else if (supplier == "") {
        return true;
      }
    });
  });
</script>