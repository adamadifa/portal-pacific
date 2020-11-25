<?php
  
    function uang($nilai){

      return number_format($nilai,'0','','.');
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
             <div class="card">
                <div class="header bg-cyan">
                    <h2>
                       KOREKSI PENJUALAN <small>Input Koreksi Penjualan</small>
                    </h2>
                </div>
               

             
                <div class="body">
                  <div class="row">
                  <div class="col-md-12">
						<form class="" method="post" action="" autocomplete="off">
							<label>No Faktur</label>          
							<div class="input-group" >
								<span class="input-group-addon">
									<i class="material-icons">confirmation_number</i>
								</span>
								 <div class="form-line">
									<input type="text"   id="nofaktur" value="<?php echo $nofaktur; ?>" name="nofaktur" class="form-control" placeholder="No Faktur" data-error=".errorTxt2" />
								 </div>
								 <div class="errorTxt2"></div>
							 </div>
							 <label>Cabang</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="cabang" name="cabang" data-error=".errorTxt1">
                                    
                                       <option value="">Pilih Cabang</option>
                                       <?php  foreach($cabang as $c){ ?>
                                            <option <?php if(strtoupper($cb) == $c->kode_cabang){ echo "selected";} ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="errorTxt1"></div>
                            </div>
							 <label>Salesman</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="salesman" name="salesman" data-error=".errorTxt1">
                                        <option value="">Semua Salesman</option>
                                    </select>
                                </div>
                                <div class="errorTxt1"></div>
                            </div>
							<label>Periode</label>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <input type="text" id="dari" value="<?php echo $dari; ?>" name="dari" class="form-control datepicker date" placeholder="Dari" data-error=".errorTxt11">
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <input type="text" id="sampai" value="<?php echo $sampai; ?>" name="sampai" class="form-control datepicker date" placeholder="Sampai" data-error=".errorTxt11">
                                    </div>
                                </div>   
                            </div>
							<div class="form-group" >
								<input type="submit" name="submit" class="btn bg-blue m-2-15 waves-effect" value="CARI DATA">
							</div>
						</form>
                    </div>
                  </div>
                  <div class="row">
                  <div class="body">
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover" id="datatable">
                          <thead>
                              <tr>
                                <th>No</th>
								<th>Tanggal</th>
                                <th>No Faktur</th>
								<th>Kode Pelanggan</th>
                                <th>Nama Pelanggan</th>
								<th>Salesman</th>
                                <th>Total Penjualan Netto</th>
                                <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                               <?php 
								if($dari != "" OR $sampai !=""){
								    $sno  = $row+1;
                                    foreach ($result as $d){ 
									if($d['status']=='1'){
										
										$bgcolor = "bg-green";
										
									}else if($d['status']=='2'){
										
										$bgcolor = "bg-yellow";
										
									}else{
										$bgcolor = "";
									}
							   ?>
									<tr class="<?php echo $bgcolor; ?>">
										<td><?php echo $sno; ?></td>
										<td><?php echo DatetoIndo2($d['tgltransaksi']); ?></td>
										<td><?php echo $d['no_fak_penj']; ?></td>
										<td><?php echo $d['kode_pelanggan']; ?></td>
										<td><?php echo $d['nama_pelanggan']; ?></td>
										<td><?php echo $d['nama_karyawan']; ?></td>
										<td align="right"><?php echo uang($d['total']); ?></td>
										<td><a href="#"  id="" data-nofaktur = "<?php echo $d['no_fak_penj']; ?>" class="btn btn-xs bg-blue koreksi">Koreksi</a></td>
									</tr>
							   <?php 
									$sno++;
								}
								
								}else{
								?>
									<tr>
										<td style="color:red" colspan="8"><i>Silahkan Pilih Periode Tanggal Terlebih Dahulu </i></td>
									</tr>
								<?php } ?>
                          </tbody>
                     </table>
                      
                  </div>
                  </div>
                  </div>
                </div>
            </div>
        </div>
       
    </div>

</div>
<!--------------------------------------INPUT KOREKSI-------------------------------------->
<div class="modal fade" id="koreksi" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
           
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
	$(function(){
		
		function showSalesman(){
			
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
		
		showSalesman();
		
		$(".koreksi").click(function(e){
            e.preventDefault();
            var nofaktur = $(this).attr("data-nofaktur");
            //alert(kodesetoran);
            $("#koreksi").modal("show");
            $(".modal-content").load("<?php echo base_url();?>penjualan/inputkoreksipenjualan/"+nofaktur);
        });
		
		
		$("#cabang").change(function(){
			
            showSalesman();
        });
		$('.datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });
	});
</script>