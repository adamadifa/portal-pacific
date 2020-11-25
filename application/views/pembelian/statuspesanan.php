<form name="autoSumForm" autocomplete="off" class="" id="formPesanan"  method="POST" action="<?php echo base_url(); ?>pembelian/update_pemesanan">
  <div class="row">
    <div class="body">
      <input type="hidden" value="<?php echo $bpb['no_bpb']; ?>" id="nobpb" name="nobpb" class="form-control" placeholder="No BPB" data-error=".errorTxt19" />
      <div class="col-md-12">
        <div class="input-group demo-masked-input">
          <span class="input-group-addon">
            <i class="material-icons">date_range</i>
          </span>
          <div class="form-line">
            <input type="text" id="tgl_pemesanan" value="<?php echo $bpb['tgl_pemesanan']; ?>" name="tgl_pemesanan" class="form-control date datepicker" placeholder="Tanggal Pemesanan" data-error=".errorTxt19" />
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-offset-10">
            <input type="submit" name="submit" class="btn btn-sm bg-blue  waves-effect" value="SIMPAN">
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  $(function(){
    // $("#formPesanan").submit(function(){
    //   var tglpesan = $("#tgl_pemesanan").val();
    //   if(tglpesan == "")
    //   {
    //     swal("Oops!", "Tanggal Pemesanan Harus Diisi !", "warning");
    //     return false;
    //   }else if(supplier == ""){
    //     return true;
    //   }
    // });

    $('.datepicker').bootstrapMaterialDatePicker({
      format      : 'YYYY-MM-DD',
      clearButton : true,
      weekStart   : 1,
      time        : false
    });

  });
</script>
