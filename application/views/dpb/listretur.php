 <div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          Data Retur Penjualan
          <small>List Data Retur Penjualan</small>
        </h2>
      </div>
      <div class="body">
        <div class="row clearfix">
          <div class="col-sm-12">
            <form class="" method="post" action="" autocomplete="off">
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">chrome_reader_mode</i>
                </span>
                <div class="form-line">
                  <input type="text"  value="" id="no_dpb" name="no_dpb" class="form-control" placeholder="No DPB" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="text" value="" id="tgl_penjualan" name="tgl_penjualan" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
                </div>
              </div>
              <?php if($cb == 'pusat'){ ?>
              <div class="form-group" >
                <div class="form-line">
                  <select class="form-control" id="cabang" name="cabang">
                    <option value="">Pilih Cabang</option>
                    <?php foreach($cabang as $c){ ?>
                      <option  value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
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
                    <option value=""></option>
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
          <div class="col-sm-12">
            <div class="table-responsive">
             <table class="table table-bordered table-striped table-hover" id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>No. Retur</th>
                    <th>Tgl. Retur</th>
                    <th>No. Faktur</th>
                    <th>Kode Pel.</th>
                    <th>Nama Pelanggan</th>
                    <th>Cabang</th>
                    <th>Jenis Retur</th>
                    <th>No DPB</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $sno                = $row+1;
                  $totalgb            = 0;
                  $totalpf            = 0;
                  $total              = 0;
                  foreach($result as $data){
                    $totalgb = $totalgb + $data['subtotal_gb'];
                    $totalpf = $totalpf + $data['subtotal_pf'];
                    $total  = $total + $data['total'];
                ?>
                  <tr>
                    <td><?php echo $sno; ?></td>
                    <td><a href="<?php echo base_url(); ?>penjualan/detailretur/<?php echo $data['no_retur_penj']; ?>/<?php echo $data['no_fak_penj']; ?>"><?php echo $data['no_retur_penj']; ?></a></td>
                    <td><?php echo $data['tglretur']; ?></td>
                    <td><?php echo $data['no_fak_penj']; ?></td>
                    <td><?php echo $data['kode_pelanggan']; ?></td>
                    <td><?php echo $data['nama_pelanggan']; ?></td>
                    <td><?php echo $data['kode_cabang']; ?></td>

                    <td align="center">
                      <?php
                        if(empty($data['total'])){
                          echo "RETUR GB";
                        }else{
                          echo "RETUR PF";
                        }
                      ?>
                    </td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-xs btn-primary">Input No DPB</a>
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
<div class="modal fade" id="konfirmasi_batal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <b>Anda yakin ingin Membatalkan data Transaksi Ini..! ?</b><br><br>
        <small>Dengan Menmbatalkan Transaksi Ini.. Semua Proses Transaksi Untuk No Retur  Ini Akan Di Batalkan ! </small><br><br>
        <a class="btn bg-green waves-effect btn-ok"> Proses</a>
        <a class="btn bg-blue waves-effect" data-dismiss="modal"> Batal </a>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
    $(function(){
      $('#konfirmasi_batal').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });
    });
</script>
