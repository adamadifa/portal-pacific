<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    CEK PENERIMAAN UANG DI PUSAT
                    <small>Cek Penerimaan Uang Di Pusat</small>
                </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="body">
                            <div class="col-md-12">
                                <form method="POST" autocomplete="off">

                                    <label>Cabang</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
                                                <option value="">-- Pilih Cabang --</option>
                                                <?php foreach($cabang as $c){ ?>
                                                    <option <?php if($cbg==$c->kode_cabang){echo "selected";} ?>  value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="errorTxt1"></div>
                                    </div>


                                    <label>BANK</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="bank" name="bank" data-error=".errorTxt1">
                                                <option value="">-- Pilih --</option>
                                                <option <?php if($bank=="BCA"){ echo "selected";} ?>  value="BCA">BCA</option>
                                                <option <?php if($bank=="BCA CV"){ echo "selected";} ?> value="BCA CV">BCA CV</option>
                                                <option <?php if($bank=="BNI"){ echo "selected";} ?>   value="BNI">BNI</option>
                                                <option <?php if($bank=="BNI CV"){ echo "selected";} ?>  value="BNI CV">BNI CV</option>
                                                <option <?php if($bank=="PERMATA"){ echo "selected";} ?> value="PERMATA">PERMATA</option>
                                                <option <?php if($bank=="KAS"){ echo "selected";} ?>  value="KAS">KAS</option>
                                            </select>
                                        </div>
                                        <div class="errorTxt1"></div>
                                    </div>
                                    <label>Tanggal Setoran</label>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="form-line">
                                                <input type="text" value="<?php echo $dari; ?>"  id="dari" name="dari" class="form-control datepicker date" placeholder="Dari" data-error=".errorTxt11">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-line">
                                                <input type="text" value="<?php echo $sampai; ?>" id="sampai" name="sampai" class="form-control datepicker date" placeholder="Sampai" data-error=".errorTxt11">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="body">
                            <a href="#" class="btn bg-red waves-effect" id="inputsetoranpusat"> Tambah Data </a>
                            <hr>
                            <div style="margin-bottom:8px">
                                <?php
                                    if(empty($cbg)){
                                        $cabang = "-";
                                    }else{
                                        $cabang = $cbg;
                                    }

                                    if(empty($bank)){
                                        $bank = "-";
                                    }else{
                                        $bank = $bank;
                                    }

                                    if(empty($dari)){
                                        $dr = "-";
                                    }else{
                                        $dr = $dari;
                                    }

                                    if(empty($sampai)){
                                        $sm = "-";
                                    }else{
                                        $sm = $sampai;
                                    }
                                    $url = base_url()."laporanpenjualan/cetak_setoranpusat/".$cabang."/".$bank."/".$dr."/".$sm;
                                ?>

                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" >
                                    <thead style="background-color:#1ab394; color:white">
                                        <tr>
                                            <th>TGL</th>
                                            <th>SETORAN</th>
                                            <th>BANK</th>
                                            <th>KERTAS</th>
                                            <th>LOGAM</th>
                                            <th>TRANSFER</th>
                                            <th>GIRO</th>
                                            <th>JUMLAH</th>
                                            <th>STATUS</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($result as $d){
                                                $tanggal        = explode("-",$d['tgl_setoranpusat']);
                                                $tahun          = $tanggal[0];
                                                $bulan          = $tanggal[1];
                                                $hari           = $tanggal[2];
                                                $thn            = substr($tahun,2,2);
                                                $tgl            = $hari."/".$bulan."/".$thn;
                                                $jumlahsetoran  = $d['uang_kertas'] + $d['uang_logam'] + $d['giro'];
                                        ?>
                                            <tr>
                                                <td><?php echo $tgl; ?></td>
                                                <td><b><?php echo $d['keterangan']; ?></b></td>
                                                <td><?php echo $d['bank']; ?></td>
                                                <td align="right"><b><?php if($d['uang_kertas']!=0){echo number_format($d['uang_kertas'],'0','','.');} ?></b></td>
                                                <td align="right"><b><?php if($d['uang_logam']!=0){echo number_format($d['uang_logam'],'0','','.');} ?></b></td>
                                                <td align="right"><b><?php if($d['transfer']!=0){echo number_format($d['transfer'],'0','','.');} ?></b></td>
                                                <td align="right"><b><?php if($d['giro']!=0){echo number_format($d['giro'],'0','','.');} ?></b></td>
                                                <td align="right"><b><?php if($jumlahsetoran!=0){echo number_format($jumlahsetoran,'0','','.');} ?></b></td>
                                                <td>
                                                  <?php
                                                    if($d['status']==0){
                                                      echo "<span class='badge bg-red'>Belum Di Terima</span>";
                                                    }else{
                                                      echo "<span class='badge bg-green'>Sudah Di Terima</span>";
                                                    }
                                                  ?>
                                                </td>
                                                <td>
                                                    <?php if(empty($d['no_giro'])){
                                                         if($d['status']==0){
                                                      ?>
                                                          <a href="#" data-id="<?php echo $d['kode_setoranpusat'] ?>"  class="btn bg-green btn-xs terimasetoran"><i class="material-icons">check</i></a>
                                                        <?php
                                                         }else{
                                                      ?>
                                                          <a href="<?php echo base_url(); ?>penjualan/batalterimasetoran/<?php echo $d['kode_setoranpusat']; ?>"  class="btn bg-red btn-xs"><i class="material-icons">cancel</i></a>
                                                      <?php
                                                         }
                                                      } ?>

                                                    <a href="#" data-id = "<?php echo $d['kode_setoranpusat']; ?>"  class="btn bg-blue btn-xs detail"><i class="material-icons">remove_red_eye</i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
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
</div>
<!--------------------------------------INPUT KAS BESAR--------------------------------------->
<div class="modal fade" id="setoranpusat" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal fade" id="detailsetoranpusat" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
       <div id="loaddetail"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="terimasetoran" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
       <div id="loadterimasetoran"></div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
    $(function(){



        $("#inputsetoranpusat").click(function(e){
            e.preventDefault();
            $("#setoranpusat").modal("show");
            $(".modal-content").load("<?php echo base_url();?>penjualan/inputsetoranpusat");
        });

        $(".edit").click(function(e){
            e.preventDefault();
            var kodesetoranpusat = $(this).attr("data-kodesetoranpusat");
            //alert(kodesetoran);
            $("#setoranpusat").modal("show");
            $(".modal-content").load("<?php echo base_url();?>penjualan/editsetoranpusat/"+kodesetoranpusat);
        });

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });


        $(".detail").click(function(e){
            e.preventDefault();
            var kode_setoran = $(this).attr('data-id');
            $("#detailsetoranpusat").modal("show");
            $.ajax({
                type    : 'POST',
                url     : '<?php echo base_url();?>Pembayaran/detailsetoranpusat',
                data    : {kode_setoran:kode_setoran},
                cache   : false,
                success : function(respond){
                $("#loaddetail").html(respond);
                }
            });
        });

        $(".detail").click(function(e){
            e.preventDefault();
            var kode_setoran = $(this).attr('data-id');
            $("#detailsetoranpusat").modal("show");
            $.ajax({
                type    : 'POST',
                url     : '<?php echo base_url();?>Pembayaran/detailsetoranpusat',
                data    : {kode_setoran:kode_setoran},
                cache   : false,
                success : function(respond){
                $("#loaddetail").html(respond);
                }
            });
        });


    });
</script>
