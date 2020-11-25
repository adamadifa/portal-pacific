<div class="row clearfix">
  <div class="col-md-8">
    <div class="card">
      <div class="header bg-cyan">
        <h2>
           UPDATE BUFFER STOK CABANG
          <small>Update Buffer Stok Cabang</small>
        </h2>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>oman/update_buffer">
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">chrome_reader_mode</i>
                </span>
                <div class="form-line">
                  <input type="text"  readonly value="<?php echo $buffer['kode_bufferstok'] ?>" id="kodebuffer" name="kodebuffer" class="form-control" placeholder="Kode Buffer" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="input-group demo-masked-input"  >
                <span class="input-group-addon">
                  <i class="material-icons">business</i>
                </span>
                <div class="form-line">
                  <input type="text" readonly value="<?php echo $buffer['kode_cabang']; ?>" id="cabang" name="cabang" class="form-control" placeholder="Cabang" data-error=".errorTxt19" />
                </div>
              </div>
              <hr>
              <table class="table table-bordered table-striped">
                <thead class = "" >
                  <tr>
                    <th rowspan="3" align="">No</th>
                    <th rowspan="3" style="text-align:center">Nama Barang</th>
                    <th colspan="6" style="text-align:center">Buffer Stok Cabang</th>
                  </tr>
                  <tr>
                    <th colspan="2" style="text-align:center">Kuantitas</th>
                  </tr>
                  <tr>
                    <th style="text-align:center">Jumlah</th>
                    <th style="text-align:center">Satuan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 1;
                    foreach ($barang as $b) {
                      $jml = $this->db->get_where('detail_bufferstok',array('kode_bufferstok'=>$buffer['kode_bufferstok'],'kode_produk'=>$b->kode_produk))->row_array();
                      //RETUR
                	    $jmldus = floor($jml['jumlah'] / $b->isipcsdus);
                	    if($jml['jumlah'] !=0 ){
                	   	 	$sisadus   = $jml['jumlah'] % $b->isipcsdus;
                			}else{
                				$sisadus = 0;
                			}
                	    if($b->isipack == 0){
                        $jmlpack    = 0;
                        $sisapack   = $sisadus;
                        $s          = "A";
                	    }else{
                        $jmlpack    = floor($sisadus / $b->isipcs);
                        $sisapack   = $sisadus % $b->isipcs;
                        $s          = "B";
                	    }
                	    $jmlpcs = $sisapack;

                      // echo $sisadus."-".$s."-".$sisapack."-".$jmlpcs."<br>";

                  ?>
                    <tr>
                      <td style="width:10px"><?php echo $no; ?></td>
                      <td style="width:200px">
                        <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $b->kode_produk;?>">
                        <input type="hidden" name="isipcsdus<?php echo $no; ?>" value="<?php echo $b->isipcsdus;?>">
                        <input type="hidden" name="isipack<?php echo $no; ?>" value="<?php echo $b->isipack;?>">
                        <input type="hidden" name="isipcs<?php echo $no; ?>" value="<?php echo $b->isipcs;?>">
                        <?php echo $b->nama_barang; ?>
                      </td>
                      <td style="width:100px">
                        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
                          <div class="form-line">
                            <input type="text" style="text-align:right" value="<?php if(!empty($jmldus)){ echo $jmldus; } ?>" id="jmldus" name="jmldus<?php echo $no; ?>" class="form-control"  data-error=".errorTxt19" />
                          </div>
                        </div>
                      </td>
                      <td style="width:50px" align="center"><?php echo $b->satuan; ?></td>

                    </tr>
                  <?php
                      $no++;
                      $jumproduk = $no-1;
                    }
                  ?>
                  <input type="hidden" value ="<?php echo $jumproduk; ?>" name="jumproduk">
                </tbody>
              </table>
              <div class="row clearfix">
                <div class="col-md-offset-9">
                  <input type="submit" name="submit" class="btn btn-lg bg-blue  waves-effect" value="SIMPAN">
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function(){
    $('.datepicker').bootstrapMaterialDatePicker({
      format      : 'YYYY-MM-DD',
      clearButton : true,
      weekStart   : 1,
      time        : false
    });
  });
</script>
