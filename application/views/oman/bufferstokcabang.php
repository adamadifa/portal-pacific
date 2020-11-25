<div class="row clearfix">
  <div class="col-md-8">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA BUFFER STOK CABANG
          <small>DATA BUFFER STOK CABANG</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <form class="" method="post" action="" autocomplete="off">
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control" id="cabang" name="cabang">
                    <option value="">Semua Cabang</option>
                    <?php foreach($cabang as $c){ ?>
                      <option <?php if($cbg==$c->kode_cabang){echo "selected"; } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                     <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-md-offset-10">
                  <input type="submit" name="submit" class="btn bg-blue  waves-effect" value="CARI DATA">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <a href="<?php echo base_url();?>oman/inputbuffer" class="btn btn-danger">Tambah Data</a>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>Kode Buffer</th>
                    <th>Cabang</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sno  = $row+1;
                    foreach ($result as $d){
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['kode_bufferstok']; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td>
                        <a href="#" class="btn btn-xs btn-info detail" data-kodebuffer="<?php echo $d['kode_bufferstok']; ?>">Detail</a>
                        <a href="<?php echo base_url(); ?>oman/updatebuffer/<?php echo $d['kode_bufferstok']; ?>" class="btn btn-xs bg-blue">Update</a>
                        <a data-href="<?php echo base_url(); ?>oman/hapusbuffer/<?php echo $d['kode_bufferstok']; ?>" class="btn btn-xs btn-danger hapus">Hapus</a>
                      </td>
                    </tr>
                    <?php
                      $sno++;
                    }
                    ?>
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
<div class="modal fade" id="detaildpbpenjualan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            DATA BUFFER STOK
            <small>Data Buffer Stok</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="loaddpbpenjualan"></div>
              </div>
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
    function loadsalesman()
    {
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

    loadsalesman();
    $('.detail').click(function(e){
     e.preventDefault();
     var kodebuffer = $(this).attr('data-kodebuffer');
     $.ajax({
       type    : 'POST',
       url     : '<?php echo base_url(); ?>oman/detail_bufferstok',
       data    : {kodebuffer:kodebuffer},
       cache   : false,
       success : function(respond){
         $("#loaddpbpenjualan").html(respond);
       }
     });
     $("#detaildpbpenjualan").modal("show");
   });

   $("#cabang").change(function(e){
     e.preventDefault();
     loadsalesman();
   });

   $('.hapus').click(function(){
    var getLink = $(this).attr('data-href');
    swal({
      title               : 'Alert',
      text                : 'Hapus Data ?',
      html                : true,
      confirmButtonColor  : '#d43737',
      showCancelButton    : true,
    },function(){
      window.location.href = getLink
    });
   });

   $('.datepicker').bootstrapMaterialDatePicker({
     format      : 'YYYY-MM-DD',
     clearButton : true,
     weekStart   : 1,
     time        : false
   });
  });
</script>
