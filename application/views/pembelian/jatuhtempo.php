<div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA JATUH TEMPO PEMBAYARAN
          <small>Data Jatuh Tempo Pembayaran</small>
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
                  <input type="text" value="<?php echo $nobukti; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti Pembelian" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $dari; ?>" id="dari" name="dari" class="datepicker form-control date" placeholder="Dari" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $sampai; ?>" id="sampai" name="sampai" class="datepicker form-control date" placeholder="Sampai" data-error=".errorTxt19" />
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
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>No Bukti</th>
                    <th>Jatuh Tempo</th>
                    <th>Supplier</th>
                    <th>Dept</th>
                    <th>PPn</th>
                    <th>Total</th>
                    <th>Ket</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sno  = $row+1;
                    foreach ($result as $d){
                      $nobukti = str_replace("/",".",$d['nobukti_pembelian']);
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['nobukti_pembelian']; ?></td>
                      <td><?php echo DateToIndo2($d['tgl_jatuhtempo']); ?></td>
                      <td><?php echo $d['nama_supplier']; ?></td>
                      <td><?php echo $d['kode_dept']; ?></td>
                      <td>
                        <?php
                          if(!empty($d['ppn']))
                          {
                            echo '<i class="material-icons">check_box</i>';
                          }
                        ?>
                      </td>
                      <td align="Right"><?php echo number_format($d['harga'],'0','','.'); ?></td>
                      <td>
                        <?php
                          $totalharga = $d['harga'];
                            //echo $totalharga."-".$d['jmlbayar'];
                          if($totalharga == $d['jmlbayar']){
                            echo "<span class='badge bg-green'>Lunas</span>";
                          }else{
                            echo "<span class='badge bg-red'>Belum Lunas</span>";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          $totalharga = $d['harga'];
                            //echo $totalharga."-".$d['jmlbayar'];
                          if($totalharga != $d['jmlbayar']){
                          ?>
                            <a href="<?php echo base_url(); ?>pembelian/inputkontrabon/<?php echo $nobukti; ?>" class="btn btn-xs btn-primary">Buat Kontrabon</a>
                          <?php
                          }
                        ?>
                        <a href="#" data-nobukti="<?php echo $d['nobukti_pembelian']; ?>" class="btn btn-xs btn-primary detail">Detail</a>
                      </td>
                    </tr>
                    <?php
                      $sno++;
                    }
                    ?>
                </tbody>
              </table>
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
