<div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA REKAP REJECT PASAR DPB
          <small>DATA REKAP REJECT PASAR</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
        <div class="col-md-12">
            <form class="" method="post" action="" autocomplete="off">
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">chrome_reader_mode</i>
                </span>
                <div class="form-line">
                  <input type="text"  value="<?php echo $no_dpb; ?>" id="no_dpb" name="no_dpb" class="form-control" placeholder="No DPB" data-error=".errorTxt19" />
                </div>
              </div>

              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $tanggal; ?>" id="tanggal" name="tanggal" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
                </div>
              </div>
              <?php if($cb == 'pusat'){ ?>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control" id="cabang" name="cabang">
                    <option value="">Pilih Cabang</option>
                    <?php foreach($cabang as $c){ ?>
                      <option <?php if($cbg==$c->kode_cabang){echo "selected"; } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                     <?php } ?>
                  </select>
                </div>
              </div>
              <?php }else{ ?>
                <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang"  />
              <?php } ?>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control show-tick" id="salesman" name="salesman" data-error=".errorTxt1">
                    <option value="<?php echo $salesman; ?>"><?php echo $sales['nama_karyawan']; ?></option>
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
            <a href="<?php echo base_url();?>dpb/inputrejectpasar" class="btn btn-danger">Tambah Data</a>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>No DPB</th>
                    <th>Tanggal</th>
                    <th>Nama Salesman</th>
                    <th>Nama Cabang</th>
                    <th>Tujuan</th>
                    <th>No Kendaraan</th>
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
                      <td><?php echo $d['no_dpb']; ?></td>
                      <td><?php echo DateToIndo2($d['tgl_mutasi_gudang_cabang']); ?></td>
                      <td><?php echo $d['nama_karyawan']; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td><?php echo $d['tujuan']; ?></td>
                      <td><?php echo $d['no_kendaraan']; ?></td>
                      <td>
                        <a href="#" class="btn btn-xs btn-info detail" data-nomutasi="<?php echo $d['no_mutasi_gudang_cabang']; ?>">Detail</a>
                        <a href="<?php echo base_url(); ?>dpb/updaterejectpasar/<?php echo $d['no_mutasi_gudang_cabang']; ?>" class="btn btn-xs bg-blue">Update</a>
                        <a data-href="<?php echo base_url(); ?>dpb/hapusrejectpasar/<?php echo $d['no_mutasi_gudang_cabang']; ?>" class="btn btn-xs btn-danger hapus">Hapus</a>
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
            DATA REJECT PASAR DPB
            <small>Data Reject Pasar</small>
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
     var nomutasi = $(this).attr('data-nomutasi');
     $.ajax({
       type    : 'POST',
       url     : '<?php echo base_url(); ?>dpb/detail_penjualandpb',
       data    : {nomutasi:nomutasi},
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
