<div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA PERMINTAAN BARANG
          <small>Data Permintaan Barang</small>
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
                  <input type="text" value="<?php echo $no_bpb; ?>" id="nobpb" name="nobpb" class="form-control" placeholder="No BPB" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $tgl_permintaan; ?>" id="tgl_permintaan" name="tgl_permintaan" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
                </div>
              </div>
              <?php if(empty($departemen)){ ?>
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
              <?php }else{ ?>
                <input type="hidden" name="departemen" id="departemen" value="<?php echo $departemen; ?>">
              <?php } ?>

              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control show-tick" id="statuspesanan" name="statuspesanan" data-error=".errorTxt1">
                    <option value="">--Sudah Dipesan / Belum Dipesan--</option>
                    <option <?php if($statuspesanan=='1'){echo "selected";} ?> value="1">Sudah Dipesan</option>
                    <option <?php if($statuspesanan=='0'){echo "selected";} ?> value="0">Belum Dipesan</option>
                  </select>
                </div>
              </div>
              <br>

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

            <?php
              if($this->session->userdata('level_user')!='admin pembelian'){ ?>
              <a href="<?php echo base_url(); ?>pembelian/inputbpb" class="btn btn-danger">Tambah Data</a>
            <?php } ?>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>No BPB</th>
                    <th>Tanggal</th>
                    <th>Yang Mengajukan</th>
                    <th>Departemen</th>
                    <th>Status Pemesanan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sno  = $row+1;
                    foreach ($result as $d){
                      $nobpb = str_replace("/",".",$d['no_bpb']);
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['no_bpb']; ?></td>
                      <td><?php echo DateToIndo2($d['tgl_permintaan']); ?></td>
                      <td><?php echo $d['yangmengajukan']; ?></td>
                      <td><?php echo $d['nama_dept']; ?></td>
                      <td>
                        <?php
                          if(empty($d['tgl_pemesanan'])){
                        ?>
                          <a href="#" data-nobpb="<?php echo $d['no_bpb']; ?>"  class="btn btn-xs btn-danger statuspsn">Belum di Pesankan</a>
                        <?php
                          }else{
                        ?>
                          <a href="#" data-nobpb="<?php echo $d['no_bpb']; ?>"  class="btn btn-xs btn-success statuspsn"><?php echo DateToIndo2($d['tgl_pemesanan']); ?></a>
                        <?php
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if(empty($d['jmlpmb']))
                          {
                            echo "<span class='badge bg-red'>Belum Di Proses</span>";
                          }else {
                            echo "<span class='badge bg-green'>Sudah Di Proses</span>";
                          }

                        ?>
                      </td>
                      <td>

                        <a href="#" data-nobpb="<?php echo $d['no_bpb']; ?>" class="btn btn-xs btn-primary detail">Detail</a>

                        <?php
                          if(empty($d['jmlpmb'])){
                        ?>
                          <a href="<?php echo base_url(); ?>pembelian/editbpb/<?php echo $nobpb; ?>"  class="btn btn-xs bg-teal">Update</a>
                          <a href="#" data-href="<?php echo base_url(); ?>pembelian/hapusbpb/<?php echo $nobpb; ?>" class="btn btn-xs btn-danger hapus">Hapus</a>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php
                      $sno++;
                    }
                    ?>
                </tbody>
              </table>
              <div style='margin-top: 10px;'>
                <?php echo $pagination; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="detailbpb" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" style="min-width:1300px !important" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            DATA BUKTI PERMINTAAN BARANG
            <small>Bukti Permintaan Barang</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="loadpermintaan"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalstatuspesanan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            INPUT TANGGAL PEMESANAN
            <small>Pemesanan Barang</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div id="loadpemesanan"></div>
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
     e.preventDefault();
     var nobpb = $(this).attr('data-nobpb');
     $.ajax({
       type    : 'POST',
       url     : '<?php echo base_url(); ?>pembelian/detail_bpb',
       data    : {nobpb:nobpb},
       cache   : false,
       success : function(respond){
         $("#loadpermintaan").html(respond);
       }
     });
     $("#detailbpb").modal("show");
   });

   $('.statuspsn').click(function(e){
    e.preventDefault();
    var nobpb = $(this).attr('data-nobpb');
    $.ajax({
      type    : 'POST',
      url     : '<?php echo base_url(); ?>pembelian/statuspesanan',
      data    : {nobpb:nobpb},
      cache   : false,
      success : function(respond){
        $("#loadpemesanan").html(respond);
      }
    });
    $("#modalstatuspesanan").modal("show");
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
  $('.datepicker').bootstrapMaterialDatePicker({
    format      : 'YYYY-MM-DD',
    clearButton : true,
    weekStart   : 1,
    time        : false
  });
});
</script>
