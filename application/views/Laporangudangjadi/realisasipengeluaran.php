
<div class="row clearfix">
    <div class="col-md-6">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    Realisasi Realisasi Permintaan Barang 
                    <small> Realisasi Realisasi Permintaan Barang   </small>
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <form class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>laporangudangjadi/cetak_realisasipengeluaran" target="_blank">
                          
                            <label>Bulan</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" id="bulan" name="bulan" data-error=".errorTxt9">
                                        
                                         <option value="">-- Pilih Bulan -- </option>
                                        <?php 
                                         $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Novemer","Desember");

                                         for($i=1; $i<=12; $i++){
                                         ?>
                                            <option value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
                                         <?php
                                         }


                                        ?>
                                    </select>
                                </div>
                                <div class="errorTxt1"></div>
                            </div>
                             <label>Tahun</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="tahun"  name="tahun" class="form-control"  data-error=".errorTxt4" />
                                   
                                </div>
                                <div class="errorTxt4"></div>
                            </div>
                             <div class="form-group errorTxt11"></div>
                           
                           
                            <div class="form-group" >
                                 <button type="submit"  name="submit" class="btn bg-red waves-effect">
                                    <i class="material-icons">print</i>
                                    <span>CETAK</span>
                                </button>
                                <button type="submit"  name="export" class="btn bg-green waves-effect">
                                    <i class="material-icons">file_download</i>
                                    <span>EXPORT EXCEL</span>
                                </button>
                            </div>
                        </form>
                     </div>       
                </div>
            </div>
        </div>
    </div>
   
</div>
<!-- Select Plugin Js -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
    
    $(function(){
         $("form").submit(function(){

            var bulan    = $("#bulan").val();
            
            if(bulan == "" ){
                 swal("Oops!", "Silahkan Pilih Bulan Terlebih Dahulu  !", "warning");
                 return false;
            }else{
                return true;
            }

       
        });

       
    });

</script>