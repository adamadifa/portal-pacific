<div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA DO TOKO
          <small>Data DO Toko</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" action="" autocomplete="off">
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">chrome_reader_mode</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $nodo; ?>" id="nodo" name="nodo" class="form-control" placeholder="No DO" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $tgl_do; ?>" id="tgl_do" name="tgl_do" class="datepicker form-control date" placeholder="Tanggal DO" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
                    <option value="">--Semua Departemen--</option>
                    <?php foreach($dept as $d){ ?>
                      <option <?php if($departemen == $d->kode_dept){ echo "selected"; } ?> value="<?php echo $d->kode_dept; ?>"><?php echo $d->nama_dept; ?></option>
                    <?php }  ?>
                  </select>
                </div>
              </div>
              <br>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control show-tick" id="supplier" name="supplier" data-error=".errorTxt1" data-live-search="true">
                    <option value="">--Semua Supplier--</option>
                    <?php foreach($supp as $d){ ?>
                      <option  value="<?php echo $d->kode_supplier; ?>"><?php echo $d->nama_supplier; ?></option>
                    <?php }  ?>
                  </select>
                </div>
              </div>
              <br>
              <div class="form-group" >
                <div class="col-md-offset-10">
                  <input type="submit" name="submit" class="btn bg-blue  waves-effect" value="CARI DATA">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <a href="<?php echo base_url(); ?>pembelian/inputdotoko" class="btn btn-danger">Tambah Data</a>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>No DO</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Dept</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sno  = $row+1;
                    foreach ($result as $d){
                      $nodo = str_replace("/",".",$d['no_do']);
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['no_do']; ?></td>
                      <td><?php echo $d['tgl_do']; ?></td>
                      <td><?php echo $d['nama_supplier']; ?></td>
                      <td><?php echo $d['kode_dept']; ?></td>
                      <td>
                        <a href="#" data-nodo="<?php echo $d['no_do']; ?>" class="btn btn-xs btn-primary detail">Detail</a>
                        <a href="<?php echo base_url(); ?>pembelian/cetakdo/<?php echo $nodo; ?>" class="btn btn-xs btn-primary">Cetak</a>
                        <a href="<?php echo base_url(); ?>pembelian/editdotoko/<?php echo $nodo; ?>" class="btn btn-xs bg-teal editpembelian">Update</a>
                        <a href="#" data-href="<?php echo base_url(); ?>pembelian/hapusdotoko/<?php echo $nodo; ?>" class="btn btn-xs btn-danger hapus">Hapus</a>
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
<div class="modal fade" id="detailpembelian" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Detail Pembelian
            <small>Detail Pembelian</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="loaddetailpembelian"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="inputpajak" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Input No Faktur Pajak
            <small>Input No Faktur Pajak</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div id="loadinputfakturpajak"></div>
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
    $('.detail').click(function(e){
      var nobukti  = $(this).attr('data-nobukti');
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url(); ?>pembelian/detail_pembelian',
        data    : {nobukti:nobukti},
        cache   : false,
        success : function(respond){
          $("#loaddetailpembelian").html(respond);
          $("#detailpembelian").modal("show");
        }
      });
    });
  $(".hapus").click(function(){
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

  $(".inputnopajak").click(function(e){
    var nobukti = $(this).attr('data-nobukti');
    var nopajak = $(this).attr('data-nopajak');
    $.ajax({
      type  : 'POST',
      url   : '<?php echo base_url(); ?>pembelian/inputnopajak',
      data  : {nobukti:nobukti,nopajak:nopajak},
      cache : false,
      success : function(respond)
      {
        $("#inputpajak").modal("show");
        $("#loadinputfakturpajak").html(respond);
      }
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
