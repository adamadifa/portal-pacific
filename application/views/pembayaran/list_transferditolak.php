<div class="card">
  <div class="header bg-cyan">
    <h2>
      Daftar Pembayaran Giro Dan Transfer
      <small>Giro dan Transfer</small>
    </h2>

  </div>
  <div class="body">
    <div class="row clearfix">
      <div class="col-sm-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tab-nav-right">
          <li ><a href="<?php echo base_url(); ?>Pembayaran/listgiro">PEMBAYARAN GIRO</a></li>
          <li class="active"><a href="<?php echo base_url(); ?>Pembayaran/listtransfer">PEMBAYRAN TRANSFER</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tab-nav-right">
            <li><a href="<?php echo base_url(); ?>Pembayaran/listtransfer">SEMUA TRANSFER</a></li>
            <li><a href="<?php echo base_url(); ?>Pembayaran/listtransferpending">TRANSFER PENDING</a></li>
            <li><a href="<?php echo base_url(); ?>Pembayaran/listtransferditerima">TRANSFER DITERIMA</a></li>
            <li class="active"><a href="<?php echo base_url(); ?>Pembayaran/listtransferditolak">TRANSFER DITOLAK</a></li>
          </ul>
          <div class="tab-content">
            <div class="row">
              <div class="col-md-12">
                <form class="form-horizontal" method="post" action="" autocomplete="off">
                  <div class="input-group demo-masked-input"  >
    								<span class="input-group-addon">
    									<i class="material-icons">chrome_reader_mode</i>
    								</span>
    								<div class="form-line">
    									<input type="text" value="<?php echo $namapel; ?>" id="namapel" name="namapel" class="form-control" placeholder="Nama Pelanggan">
    								</div>
    							</div>
                  <div class="input-group demo-masked-input"  >
    								<span class="input-group-addon">
    									<i class="material-icons">date_range</i>
    								</span>
    								<div class="form-line">
    									<input type="text" value="<?php echo $dari; ?>" id="dari" name="dari" class="datepicker form-control" placeholder="Dari">
    								</div>
    							</div>
                  <div class="input-group demo-masked-input"  >
    								<span class="input-group-addon">
    									<i class="material-icons">date_range</i>
    								</span>
    								<div class="form-line">
    									<input type="text" value="<?php echo $sampai; ?>" id="sampai" name="sampai" class="datepicker form-control" placeholder="Sampai">
    								</div>
    							</div>
                  <div class="row clearfix">
    								<div class="col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-10">
    									<input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
    								</div>
    							</div>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover" style="width:1100px" id="mytable">
                    <thead>
                      <tr>
                        <th width="10px">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Cabang</th>
                        <th>Nama Bank</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
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
                          <td><?php echo $d['nama_pelanggan']; ?></td>
                          <td><?php echo $d['kode_cabang']; ?></td>
                          <td><?php echo $d['namabank']; ?></td>
                          <td align="right"><?php echo number_format($d['jumlah'],'0','','.'); ?></td>
                          <td><?php echo DateToIndo2($d['tglcair']); ?></td>
                          <td>
                            <?php
                              if($d['status'] == 0){
                            ?>
                              <span class="badge bg-orange">Pending</span>
                            <?php
                              }elseif($d['status'] == 1){
                            ?>
                              <span class="badge bg-green"><?php echo DateToIndo2($d['tglbayar']); ?></span>
                            <?php
                              }elseif($d['status'] == 2){
                            ?>
                              <span class="badge bg-red">Ditolak</span>
                            <?php
                              }
                            ?>
                          </td>
                          <td>
                            <a href="#" data-id = "<?php echo $d['kode_transfer'] ?>"  class="btn bg-green btn-xs edittransfer"><i class="material-icons">mode_edit</i></a>
                          </td>
                        </tr>
                        <?php  $sno++; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
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
<div class="modal fade" id="edittransfer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<script type="text/javascript">
  $(function(){
    $(".edittransfer").click(function(e){
      e.preventDefault();
      var id_transfer = $(this).attr('data-id');
      var page        = 'listtransfer';
      $("#edittransfer").modal("show");
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url();?>Pembayaran/editbayartransfer',
        data    : {id_transfer:id_transfer,page:page},
        cache   : false,
        success : function(respond){
          $(".modal-content").html(respond);
        }
      });
    });
    $('.datepicker').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      clearButton: true,
      weekStart: 1,
      time: false
    });
  });

</script>
