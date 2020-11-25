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
        <ul class="nav nav-tabs tab-nav-right">
          <li class="active"><a href="<?php echo base_url(); ?>Pembayaran/listgiro">PEMBAYARAN GIRO</a></li>
          <li><a href="<?php echo base_url(); ?>Pembayaran/listtransfer">PEMBAYRAN TRANSFER</a></li>
        </ul>
        <div class="tab-content">
          <ul class="nav nav-tabs tab-nav-right">
            <li ><a href="<?php echo base_url(); ?>Pembayaran/listgiro">SEMUA GIRO</a></li>
            <li><a href="<?php echo base_url(); ?>Pembayaran/listgiropending">GIRO PENDING</a></li>
            <li ><a href="<?php echo base_url(); ?>Pembayaran/listgiroditerima">GIRO DITERIMA</a></li>
            <li class="active"><a href="<?php echo base_url(); ?>Pembayaran/listgiroditolak">GIRO DITOLAK</a></li>
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
    									<input type="text" id="nogiro" value="<?php echo $nogiro; ?>"  name="nogiro" class="form-control" placeholder="No Giro">
    								</div>
    							</div>
                  <div class="input-group demo-masked-input"  >
    								<span class="input-group-addon">
    									<i class="material-icons">chrome_reader_mode</i>
    								</span>
    								<div class="form-line">
    									<input type="text" value="<?php echo $namapel; ?>" id="namapel" name="namapel" class="form-control" placeholder="Nama Pelanggan">
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
                  <table class="table table-bordered table-striped table-hover" id="mytable">
                    <thead>
                      <tr>
                        <th>No. Giro</th>
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
                          <td><?php echo $d['no_giro']; ?></td>
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
                              <span class="badge bg-green">Diterima</span>
                            <?php
                              }elseif($d['status'] == 2){
                            ?>
                              <span class="badge bg-red">Ditolak</span>
                            <?php
                              }
                            ?>
                          </td>

                          <td>
                            <?php if($d['ket'] == ""){ ?>
                              <a href="#" data-id = "<?php echo $d['no_giro']; ?>"  class="btn bg-green btn-xs editgiro"><i class="material-icons">mode_edit</i></a>
                            <?php } ?>
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
<div class="modal fade" id="editgiro" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function(){
    $(".editgiro").click(function(e){
      e.preventDefault();
      var no_giro = $(this).attr('data-id');
      var page    = 'listgiropending';
      $("#editgiro").modal("show");
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url();?>Pembayaran/editbayargiro',
        data    : {no_giro:no_giro,page:page},
        cache   : false,
        success : function(respond){
          $(".modal-content").html(respond);
        }
      });
    });
  });
</script>
