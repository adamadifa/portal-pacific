<div class="row">
  <div class="col-md-12">
    <div class="col-md-4">
      <div class="info-box hover-zoom-effect">
        <div class="icon bg-blue">
          <i class="material-icons">supervisor_account</i>
        </div>
        <div class="content">
          <div class="text">DATA PELANGGAN</div>
          <div class="number"><?php echo $jmlPelanggan['totalpelanggan']; ?></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="info-box hover-zoom-effect">
        <div class="icon bg-green">
          <i class="material-icons">supervisor_account</i>
        </div>
        <div class="content">
          <div class="text">DATA SALESMAN</div>
          <div class="number"><?php echo $jmlSales['totalsales']; ?></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="info-box hover-zoom-effect">
        <div class="icon bg-red">
          <i class="material-icons">storage</i>
        </div>
        <div class="content">
          <div class="text">DATA BARANG</div>
          <div class="number"><?php echo $jmlBrg['totalbrg']; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="col-md-6">
       <div class="card">
        <div class="header bg-green" >
          <h2>
            DATA PERSEDIAAN GOOD STOK GUDANG CABANG
            <small>Data Persediaan Good Stok Gudang Cabang</small>
          </h2>
        </div>
        <div class="body">
          <?php if($cb == 'pusat'){ ?>
          <div class="form-group" >
            <div class="form-line">
              <select class="form-control" id="cabang" name="cabang">
                <?php foreach($cabang as $c){ ?>
                  <option <?php if($cb==$c->kode_cabang){echo "selected"; } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                 <?php } ?>
              </select>
            </div>
          </div>
          <?php }else{ ?>
            <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang"  />
          <?php } ?>
          <div id="loadsaldo">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
       <div class="card">
        <div class="header bg-red" >
          <h2>
            DATA PERSEDIAAN BAD STOK GUDANG CABANG
            <small>Data Persediaan Bad Stok Gudang Cabang</small>
          </h2>
        </div>
        <div class="body">
          <?php if($cb == 'pusat'){ ?>
          <div class="form-group" >
            <div class="form-line">
              <select class="form-control" id="cabang" name="cabang">
                <?php foreach($cabang as $c){ ?>
                  <option <?php if($cb==$c->kode_cabang){echo "selected"; } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                 <?php } ?>
              </select>
            </div>
          </div>
          <?php }else{ ?>
            <input type="hidden" readonly id="cabangbs" name="cabangbs" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang"  />
          <?php } ?>
          <div id="loadsaldobs">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function(){
    function loadsaldo()
    {
      var kodecabang = $("#cabang").val();
      var status     = 'GS';
      $.ajax({
        type  : 'POST',
        url   : '<?php echo base_url(); ?>dashboard/loadsaldo',
        data  : {kodecabang:kodecabang,status:status},
        cache : false,
        success: function(respond)
        {
          $("#loadsaldo").html(respond);
        }
      });
    }
    function loadsaldobs()
    {
      var kodecabang = $("#cabangbs").val();
      var status     = 'BS';
      $.ajax({
        type  : 'POST',
        url   : '<?php echo base_url(); ?>dashboard/loadsaldobs',
        data  : {kodecabang:kodecabang,status:status},
        cache : false,
        success: function(respond)
        {
          $("#loadsaldobs").html(respond);
        }
      });
    }
    loadsaldo();
    loadsaldobs();
  });
</script>
