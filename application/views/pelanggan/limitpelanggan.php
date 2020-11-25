<div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA LIMIT PELANGGAN
          <small>Data Limit Pelanggan</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
        <div class="col-md-12">
          <div class="body">
            <form method="POST" action="" autocomplete="off">
              <?php if ($cb == 'pusat'){ ?>
                <div class="form-group">
                  <div class="form-line">
                    <select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
                      <option value="">-- Semua Cabang --</option>
                      <?php foreach($cabang as $c){ ?>
                        <option <?php if($cbg==$c->kode_cabang){echo "selected";} ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="errorTxt1"></div>
                </div>
              <?php }else{ ?>
                <input type="hidden" name="cabang" id="cabang" value="<?php echo $cb; ?>" >
              <?php } ?>
              <div class="form-group">
                <div class="form-line">
                  <select class="form-control show-tick" id="salesman" name="salesman" data-error=".errorTxt1">
                    <option value="">Semua Salesman</option>
                  </select>
                </div>
                <div class="errorTxt1"></div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-10">
                  <input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
                </div>
              </div>
            </form>
          </div>
        </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Salesman</th>
                    <th>Limit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sno  = $row+1;
                    foreach ($result as $d){
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['kode_pelanggan']; ?></td>
                      <td><?php echo $d['nama_pelanggan']; ?></td>
                      <td><?php echo $d['nama_karyawan']; ?></td>
                      <td align="right"><?php echo number_format($d['limitpel'],'0','','.'); ?></td>
                    </tr>
                  <?php $sno++; } ?>
                </tbody>
              </table>
            </div>
            <div style='margin-top: 10px;'>
              <?php echo $pagination; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  $(function(){
    function loadSalesman(){
      var cabang = $("#cabang").val();
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url();?>laporanpenjualan/get_salesman',
        data    : {cabang:cabang},
        cache   : false,
        success : function(respond){
          $("#salesman").html(respond);
          $("#salesman").selectpicker("refresh");
        }
      });
    }
    loadSalesman();
    $("#cabang").change(function(){
      var cabang = $("#cabang").val();
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url();?>laporanpenjualan/get_salesman',
        data    : {cabang:cabang},
        cache   : false,
        success : function(respond){
          $("#salesman").html(respond);
          $("#salesman").selectpicker("refresh");
        }

      });
    });
  });
</script>
