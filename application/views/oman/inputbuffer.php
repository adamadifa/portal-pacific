
<div class="row clearfix">
  <div class="col-md-8">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
           INPUT BUFFER STOK CABANG
          <small>Input Data Buffer Stok Cabang</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>oman/input_bufferstok">
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">chrome_reader_mode</i>
                </span>
                <div class="form-line">
                  <input type="text" readonly value="" id="kodebuffer" name="kodebuffer" class="form-control" placeholder="Kode Buffer Stok" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control" id="cabang" name="cabang">
                    <option value="">Pilih Cabang</option>
                    <?php foreach($cabang as $c){ ?>
                      <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                     <?php } ?>
                  </select>
                </div>
              </div>

              <hr>
              <table class="table table-bordered table-striped">
                <thead class = "" >
                  <tr>
                    <th rowspan="3" align="">No</th>
                    <th rowspan="3" style="text-align:center">Nama Barang</th>
                    <th colspan="6" style="text-align:center">Buffer Stok Cabang</th>
                  </tr>
                  <tr>
                    <th colspan="2" style="text-align:center">Kuantitas</th>
                  </tr>
                  <tr>
                    <th style="text-align:center">Jumlah</th>
                    <th style="text-align:center">Satuan</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 1;
                    foreach ($barang as $b) {
                  ?>
                    <tr>
                      <td style="width:10px"><?php echo $no; ?></td>
                      <td style="width:200px">
                        <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $b->kode_produk;?>">
                        <input type="hidden" name="isipcsdus<?php echo $no; ?>" value="<?php echo $b->isipcsdus;?>">
                        <input type="hidden" name="isipack<?php echo $no; ?>" value="<?php echo $b->isipack;?>">
                        <input type="hidden" name="isipcs<?php echo $no; ?>" value="<?php echo $b->isipcs;?>">
                        <?php echo $b->nama_barang; ?>
                      </td>
                      <td style="width:100px">
                        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
                          <div class="form-line">
                            <input type="text" style="text-align:right" value="" id="jmldus" name="jmldus<?php echo $no; ?>" class="form-control"  data-error=".errorTxt19" />
                          </div>
                        </div>
                      </td>
                      <td style="width:50px" align="center"><?php echo $b->satuan; ?></td>

                    </tr>
                  <?php
                      $no++;
                      $jumproduk = $no-1;
                    }
                  ?>
                  <input type="hidden" value ="<?php echo $jumproduk; ?>" name="jumproduk">
                </tbody>
              </table>
              <div class="row clearfix">
                <div class="col-md-offset-10">
                  <input type="submit" name="submit" class="btn btn-sm bg-blue  waves-effect" value="SIMPAN">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  $(function(){

    function loadNoMutasi()
    {
      var kodecabang     = $("#cabang").val();
      $.ajax({
        url     : '<?php echo base_url(); ?>oman/getKodeBuffer',
        type    :'POST',
        data    : {kodecabang:kodecabang},
        cache   : false,
        success : function(respond)
        {
          $("#kodebuffer").val(respond);
          console.log(respond);
        }
      });
    }

    $("#cabang").change(function(){
      loadNoMutasi();
    });
    $(".formValidate").submit(function(){
      var cabang           = $("#cabang").val();

      if(cabang == ""){
        swal("Oops!", "Cabang Harus Diisi!", "warning");
        return false;
      }
    });

  });
</script>
