<div class="row clearfix">
  <div class="col-md-12">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
          DATA HUTANG KIRIM
          <small>Data Hutang Kirim</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" method="post" action="" autocomplete="off">
              <div class="row clearfix">
                <div class="col-md-2 form-control-label">
                  <label>No Faktur</label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" id="no_faktur" value="<?php echo $no_faktur; ?>"  name="no_faktur" class="form-control" placeholder="No Faktur">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-md-2 col-sm-2 col-xs-2 form-control-label">
                  <label>Tanggal</label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" value="<?php echo $tgl_mutasi; ?>" id="tgl_mutasi" name="tgl_mutasi" class="form-control datepicker" placeholder="Tanggal">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row clearfix">
                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                  <input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover"  id="mytable">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>No. Hutang Kirim</th>
                    <th>Tanggal</th>
                    <th>No Faktur/Retur</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sno  = $row+1;
                    foreach ($result as $d){
                       $tanggal = explode("-",$d['tgl_mutasi_gudang_cabang']);
                       $hari    = $tanggal[2];
                       $bulan   = $tanggal[1];
                       $tahun   = $tanggal[0];
                       $tgl     = $hari."/".$bulan."/".substr($tahun,2,2);
                       $query   = "SELECT
                                    SUM( IF ( jenis_mutasi = 'HUTANG KIRIM' AND inout_good = 'IN', jumlah, 0 ) ) AS jumlah,
                                    SUM( IF ( jenis_mutasi = 'HUTANG KIRIM' AND inout_good = 'OUT', jumlah, 0 ) ) AS pelunasan_hk
                                  FROM
                                    detail_mutasi_gudang_cabang
                                  INNER JOIN master_barang ON detail_mutasi_gudang_cabang.kode_produk = master_barang.kode_produk
                                  INNER JOIN mutasi_gudang_cabang ON detail_mutasi_gudang_cabang.no_mutasi_gudang_cabang = mutasi_gudang_cabang.no_mutasi_gudang_cabang
                                  WHERE jenis_mutasi ='HUTANG KIRIM' AND detail_mutasi_gudang_cabang.no_fak_penj = '$d[no_fak_penj]'

                                  GROUP BY
                                      detail_mutasi_gudang_cabang.kode_produk,
                                      nama_barang,
                                      detail_mutasi_gudang_cabang.no_fak_penj
                                      HAVING
                                      SUM( IF ( jenis_mutasi = 'HUTANG KIRIM' AND inout_good = 'IN', jumlah, 0 ) ) !=  SUM( IF ( jenis_mutasi = 'HUTANG KIRIM' AND inout_good = 'OUT', jumlah, 0 ) )";
                       $pl      = $this->db->query($query);
                       $cekpl   = $pl->num_rows();
                        //echo $cekpl;
                    ?>
                    <tr>
                     <td><?php echo $sno; ?></td>
                     <td>
                        <a href="#" data-nomutasi="<?php echo $d['no_mutasi_gudang_cabang']; ?>"  class="detail">
                          <?php echo $d['no_mutasi_gudang_cabang']; ?>
                        </a>
                      </td>
                      <td><?php echo $tgl; ?></td>
                      <td>
                        <?php if(empty($d['no_retur_penj'])){ ?>
                        <a href="<?php echo base_url();?>penjualan/detailfaktur/<?php echo $d['no_fak_penj'] ?>">
                          <?php echo $d['no_fak_penj']; ?>
                        </a>
                        <?php }else{ ?>
                          <a href="<?php echo base_url();?>penjualan/detailretur/<?php echo $d['no_retur_penj'] ?>/<?php echo $d['no_fak_penj'] ?>">
                            <?php echo $d['no_retur_penj']; ?>
                          </a>
                        <?php }?>
                      </td>
                      <td><?php echo $d['kode_pelanggan']; ?></td>
                      <td><?php echo $d['nama_pelanggan']; ?></td>
                      <td>
                         <?php
                            if(!empty($cekpl)){
                              echo "<span class='badge bg-red'>Belum Lunas</span>";
                            }else{
                              echo "<span class='badge bg-green'>Lunas</span>";
                            }
                          ?>
                      </td>
                      <td>
                        <a href="#" data-nomutasi="<?php echo $d['no_mutasi_gudang_cabang']; ?>" data-nofaktur="<?php echo $d['no_fak_penj']; ?>"  class="btn bg-blue btn-xs inputpelunasan">
                          Input Pelunasan
                        </a>
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
<div class="modal fade" id="detailmutasi" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Detail Hutang Kirim
            <small>Detail Hutang Kirim</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="loadmutasi"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="inputpelunasanhk" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Input Pelunasan Hutang Kirim
            <small>InputPelunasan Hutang Kirim</small>
          </h2>
        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="loadinputpelunasan"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

     $(function(){
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });

        $('.detail').click(function(e){
            e.preventDefault();
            var nomutasi        = $(this).attr('data-nomutasi');
            var jenis_mutasi    = "HUTANG KIRIM";
            $.ajax({
                type    : 'POST',
                url     : '<?php echo base_url(); ?>repackreject/detail_mutasi_cab',
                data    : {nomutasi:nomutasi,jenis_mutasi:jenis_mutasi},
                cache   : false,
                success : function(respond){

                    $("#loadmutasi").html(respond);
                }

            });
            $("#detailmutasi").modal("show");

        });


        $('.inputpelunasan').click(function(e){
            e.preventDefault();
            var nomutasi        = $(this).attr('data-nomutasi');
            var jenis_mutasi    = "HUTANG KIRIM";
            var nofaktur        = $(this).attr('data-nofaktur');
            $.ajax({

                type    : 'POST',
                url     : '<?php echo base_url(); ?>penjualan/inputpelunasanhk',
                data    : {nomutasi:nomutasi,jenis_mutasi:jenis_mutasi,nofaktur:nofaktur},
                cache   : false,
                success : function(respond){

                    $("#loadinputpelunasan").html(respond);
                }


            });
            $("#inputpelunasanhk").modal("show");

        });



     });
</script>
