<form name="autoSumForm" autocomplete="off" class="formValidate form-horizontal" id="formValidate"  method="POST" action="<?php echo base_url(); ?>penjualan/input_penjualan">

<div class="col-md-12">
	<div class="card">
	    <div class="header bg-cyan">
	        <h2>
	            Data Transaksi
	            <small>Input Data Transaksi</small>
	        </h2>
	        
	    </div>
	    <div class="body">
	        <div class="row clearfix">
	        	<div class="row">
	        		<div class="body">
			            <div class="col-md-4">  
			                <div class="input-group" >
			                    <span class="input-group-addon">
                                    <i class="material-icons">chrome_reader_mode</i>
                                </span>
			                    <div class="form-line">
			                        <input type="text"  id="nofaktur" name="nofaktur" class="form-control" placeholder="No Faktur" data-error=".errorTxt1" />
			                       
			                    </div>
			                    <div class="errorTxt1"></div>
			                </div>
			               
			                <div class="input-group demo-masked-input"  >
			                	<span class="input-group-addon">
                                    <i class="material-icons">date_range</i>
                                </span>
			                    <div class="form-line">
			                        <input type="text" value="<?php echo date('Y-m-d'); ?>"  id="tgltransaksi" name="tgltransaksi" class="datepicker form-control date" placeholder="Tanggal Transaksi" data-error=".errorTxt19" />
			                       
			                    </div>
			                    <div class="errorTxt19"></div>
			                </div>
			               
			                <div class="input-group" >
			                	<span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
			                    <div class="form-line">
			                    	<input type="hidden" readonly  id="kodepelanggan" name="kodepelanggan" class="form-control" />
			                        <input type="text" readonly  id="pelanggan" name="pelanggan" class="form-control" placeholder="Pelanggan" data-error=".errorTxt2" />
			                       
			                    </div>
			                    <div class="errorTxt2"></div>
			                </div>
			               
			                <div class="input-group" >
			                	<span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
			                    <div class="form-line">
			                    	<input type="hidden"  id="kodesales" name="kodesales" class="form-control"/>
			                        <input type="text"    id="salesman"  disabled name="salesman" class="form-control" placeholder="Salesman" data-error=".errorTxt3" />
			                       
			                    </div>
			                    <div class="errorTxt3"></div>
			                </div>
			             </div>  
			             <div class="col-md-7">
			                <div class="info-box" style="min-height:170px">
			                    <div class="icon bg-cyan" style="height:170px; padding:40px 0; width:200px" >
			                        <i class="material-icons">shopping_cart</i>
			                    </div>
			                    <div class="content">
			                    	
			                       	<div id="grandtotal" style="padding:30px 0px 50px 0px; font-size:60px; margin-left:90px"></div>
			                    </div>
			                </div>
			            </div> 
		        	</div>
		        </div>
		        <div class="row">
		        	<div class="body">
		        		<div class="col-md-3">
                            <label>Barang</label>
                            <div class="input-group" >
			                    <span class="input-group-addon">
                                    <i class="material-icons">chrome_reader_mode</i>
                                </span>
			                    <div class="form-line">
			                    	<input type="hidden" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Barang"/>
			                        <input type="text" readonly id="barang" name="barang" class="form-control" placeholder="Barang"  />
			                         <input type="hidden" readonly id="kodecabang" name="kodecabang" class="form-control" placeholder="Kode Cabang"  />
			                         <input type="hidden" readonly id="stok" name="stok" class="form-control" placeholder="Stok"  />
			                    </div>
			                   
			                </div>
                        </div>
                        <div class="col-md-2">
                        	<label>Jumlah</label>
                            <div class="form-group form-float">
                                <div class="form-line">
                                     <input type="text" style="text-align:center" value="0"  id="jmldus" name="jmldus" class="form-control" />
                                    
                                </div>
                                <div class="form-line">
                                      <input style="text-align:right; font-weight: bold" readonly type="text" id="hargadus" name="hargadus" class="form-control"  placeholder="Harga" />
                                   
                                </div>
                              
                                <div class="form-line">
                                      <input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcsdus" name="isipcsdus" class="form-control"  />
                                   
                                </div>
                                 <div class="form-line">
                                      <input style="text-align:right; font-weight: bold" readonly type="hidden" id="isipcspack" name="isipcspack" class="form-control" />
                                   
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-2" id="pack">
                        	<label>Jumlah Pack</label>
                            <div class="form-group form-float">
                                <div class="form-line">
                                     <input type="text" style="text-align:center" value="0"  id="jmlpack" name="jmlpack" class="form-control"  />
                                   
                                </div>
                                <div class="form-line">
                                    <input style="text-align:right; font-weight: bold" type="text" id="hargapack" name="hargapack" class="form-control" readonly   placeholder="Harga / Pack"/>
                                   
                                </div>
                                
                            </div>
                        </div>
                       
                        <div class="col-md-2" >
                        	<label>Jumlah Pcs</label>
                            <div class="form-group form-float">
                                <div class="form-line">
                                     <input type="text"  style="text-align:center" value="0"  id="jmlpcs" name="jmlpcs" class="form-control" placeholder="Jumlah Pcs"  />
                                   
                                </div>
                                <div class="form-line">
                                    <input style="text-align:right; font-weight: bold"  type="text" id="hargapcs" name="hargapcs" class="form-control" readonly placeholder="Harga / Pcs"  />
                                   
                                </div>
                               
                            </div>
                        </div>
                        <div class="col-md-2">
                        	<input type="checkbox" id="promo" name="promo" value="1" id="promo" class="filled-in">
                            <label for="promo">Promo</label>
                        </div>

                        <div class="col-md-2">
                        	<a href="#" id="tambahbarang" class="btn bg-blue waves-effect">
				                <i class="material-icons">add_shopping_cart</i>
				                <span>Tambah</span>
				            </a>
                        </div>

                       
		        	</div>
		        </div>
		        <div class="row">
		        	<div class="body">
			        	<div class="col-md-12  table-responsive" >
			        		<table class="table table-bordered table-striped table-hover" id="detailbarang">
					    		<thead class="bg-cyan">
					    			<tr>
					    				<th>Kode Barang</th>
					    				<th>Nama Barang</th>
					    				<th>Jml Dus</th>
					    				<th>Harga Dus</th>
					    				<th>Jml Pack</th>
					    				<th>Harga Pack</th>
					    				<th>Jml Pcs</th>
					    				<th>Harga Pcs</th>
					    				<th>Subtotal</th>
					    				<th>Aksi</th>
					    			</tr>
					    		</thead>
					    		<tbody id="loadpnjtmp">

					    		</tbody>
					    	</table>
			        	</div>
		            </div>
		        </div>
		        <div class="row">
		        	<div class="col-md-6" >
		        	</div>
		        	<div class="col-md-6">
		        			
	                        <div class="form-group">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Jenis Transaksi</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <select class="form-control show-tick" id="jenistransaksi" name="jenistransaksi" required> 
		                            	<option value="">-- Pilih Jenis Transaksi --</option>
		                            	<option value="tunai">Tunai</option>
		                            	<option value="kredit">Kredit</option>
		                            </select>
		                           
	                            </div>


	                           
	                        </div>
	                   		 
	                        <div class="form-group">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Jenis Bayar</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <select class="form-control" id="jenisbayar" name="jenisbayar" data-error=".errorTxt91">
		                            	<option value="">-- Pilih Jenis Pembayaran --</option>
		                            </select>
		                            <div class="errorTxt91"></div>
	                            </div>

	                        </div>
	                        <div class="form-group">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Potongan</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" value="0"  style="text-align:right" id="potongan" name="potongan" class="form-control" placeholder="Potongan" onFocus="startCalc();" >
		                            </div>
		                             <div id="terbilangpotongan" style="float:right; color:green"></div>
	                            </div>

	                        </div>

	                        <div class="form-group">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Potongan Istimewa</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" value="0" style="text-align:right" id="potistimewa" name="potistimewa" class="form-control" placeholder="Potongan Istimewa" onFocus="startCalc();">
		                            </div>
		                            <div id="terbilangpotistimewa" style="float:right; color:green"" ></div>
	                            </div>

	                        </div>

	                        <div class="form-group">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Peny. Harga</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" value="0" style="text-align:right" id="penyharga" name="penyharga" class="form-control" placeholder="Penyesuaian Harga" onFocus="startCalc();">
		                            </div>
		                            <div id="terbilangpenyharga" style="float:right; color:green"></div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Total</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text"  style="text-align:right; font-weight: bold" id="totalbayar" name="totalbayar" value="0" class="form-control" placeholder="Total" onFocus="startCalc();" >
		                            </div>
		                             <div style="float:right; color:green " ><b><i><span id="terbilangtotalbayar"></span></i></b></div>
	                            </div>
	                        </div>
	                        
	                        <div class="form-group" id="Bjatuhtempo">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Jatuh Tempo</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text"  style="text-align:right" id="jatuhtempo" name="jatuhtempo" class="datepicker form-control date" placeholder="Jatuh Tempo">
		                            </div>
	                            </div>
	                        </div>
	                        <div class="form-group" id="Btitipan">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Titipan</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" value="0" style="text-align:right" id="titipan" name="titipan" class=" form-control" placeholder="Titipan">
		                            </div>
		                            <div id="terbilangtitipan" style="float:right; color:green"></div>
	                            </div>
	                        </div>
	                        <div class="form-group" id="Bnogiro">
	                        	<div class="col-md-4  form-control-label">
			                        <label>No Giro</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" style="text-align:right" id="nogiro" name="nogiro" class=" form-control" placeholder="No Giro">
		                            </div>
	                            </div>
	                        </div>
	                        <div class="form-group" id="Bmaterai">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Materai</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" style="text-align:right" id="materai" name="materai" class=" form-control" placeholder="Materai">
		                            </div>
	                            </div>
	                        </div>
	                        <div class="form-group" id="Bnamabank">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Nama Bank</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" style="text-align:right" id="namabank" name="namabank" class=" form-control" placeholder="Nama Bank">
		                            </div>
	                            </div>
	                        </div>
	                        <div class="form-group" id="Btglcair">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Tgl Jatuh Tempo</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" style="text-align:right" id="tglcair" name="tglcair" class="datepicker form-control date" placeholder="Tanggal Jatuh Tempo">
		                            </div>
	                            </div>
	                        </div>
	                        <div class="form-group" id="Bjml">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Jumlah</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="text" style="text-align:right;font-weight: bold" id="jml" name="jml" class="form-control" placeholder="Jumlah">
		                            </div>
		                             <div id="terbilangjml" style="float:right; color:green"></div>
	                            </div>
	                        </div>
	                        <div class="form-group" id="Bbayar">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Bayar</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="number" value="0" style="text-align:right" id="bayar" name="bayar" class="form-control" placeholder="Bayar" onFocus="startCalc();">
		                            </div>
	                            </div>
	                        </div>
	                         <div class="form-group" id="Buanglebih">
	                        	<div class="col-md-4  form-control-label">
			                        <label>Uang Lebih</label>
			                    </div>
	                        	<div class="col-md-8">
		                            <div class="form-line">
		                                <input type="number" value="0" style="text-align:right" id="uanglebih" name="uanglebih" class="form-control" readonly placeholder="Bayar" onFocus="startCalc();">
		                            </div>
	                            </div>
	                        </div>
	                    </div>
	                  
                	</div>
                   	<div class="row">
                 		<div style="margin-left:30px">
	       					<button type="submit" name="submit" style=" font-size:16px" class="btn btn-lg bg-blue"><span>SIMPAN</span> <i class="material-icons">send</i></button>
	       					<button type="reset" style=" font-size:16px" class="btn btn-lg bg-red"><span>BATAL</span> <i class="material-icons">cancel</i></button>
       					</div>
                   	</div>		
		        </div>
	        </div>
	    </div>
	</div>
</div>

</form>

 <!--------------------------------------MODAL DATA PELANGGAN---------------------------------------->
<div class="modal fade" id="datapelanggan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card">
			    <div class="header bg-cyan">
			        <h2>
			            Data Pelanggan
			            <small>Pilih Data Pelanggan</small>
			        </h2>
			        
			    </div>
			    <div class="body">
			        <div class="row clearfix">
			            <div class="col-sm-12">
			            <div class="table-responsive">
                           <table class="table table-bordered table-striped table-hover" style="font-size:12px" id="mytable" style="width:1330px">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>No HP</th>
                                        <th>Pasar</th>
                                        <th>Cabang</th>
                                        <th>Salesman</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
    </div>
</div>

<!--------------------------------------MODAL DATA BARANG---------------------------------------->
<div class="modal fade" id="databarang" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card">
			    <div class="header bg-cyan">
			        <h2>
			            Data Barang
			            <small>Pilih Data Barang</small>
			        </h2>
			        
			    </div>
			    <div class="body">
			        <div class="row clearfix">
			            <div class="col-sm-12">
			            <div class="table-responsive">
                           <div id="loadBarang"></div>
                        </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
    </div>
</div>
<!-- Select Plugin Js -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
	startCalc();
	
	function startCalc(){
		interval=setInterval("calc()",1)
	}
	function calc(){
		grandtotal 	= document.getElementById("tot").value;
		potongan   	= document.getElementById("potongan").value;
		potistimewa = document.getElementById("potistimewa").value;
		penyharga 	= document.getElementById("penyharga").value;
		total 		= document.getElementById("totalbayar").value;

		bayar 		= document.getElementById("bayar").value;

		totalbayar = document.autoSumForm.totalbayar.value = (grandtotal-potongan-potistimewa-penyharga);
		var att = document.createAttribute('value');       // Create a "class" attribute
		att.value = totalbayar;
		document.autoSumForm.totalbayar.setAttributeNode(att);                           // Set the value of the class 
		document.autoSumForm.uanglebih.value  = (bayar-total);
		//terbilang();
		document.getElementById("terbilangtotalbayar").innerHTML=convertToRupiah(total);


	}
	function stopCalc(){
		clearInterval(interval)
	}


	function convertToRupiah(angka)
	{
		var rupiah = '';		
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		return rupiah.split('',rupiah.length-1).reverse().join('');

	}


	

	//terbilang();


</script>
<script type="text/javascript">
	
		$(document).ready(function () {


			$("#formValidate").validate({
            rules: {
                nofaktur      :"required",
                tgltransaksi  :"required",
                pelanggan 	  :"required",
                salesman 	  :"required",
                jenistransaksi:"required",
              //  jenisbayar 	  :"required",
                potongan 	  :{required:true,number:true},
                potistimewa   :{required:true,number:true},
                penyharga     :{required:true,number:true},


                
            },
            //For custom messages
            messages: {
                
                nofaktur      :"No Faktur Harus Diisi !",
                tgltransaksi  :"Tanggal harus Diisi",
                pelanggan 	  :"Pelanggan Harus Diisi",
                salesman 	  :"Salesman Harus Diisi",
                jenistransaksi:"Jenis Transaksi Harus Diisi !",
                //jenisbayar 	  :"Jenis Bayar Harus Diisi !",
                 potongan 	  :{required:"Potongan  Harus Disii !",number:"Hanya Disi Dengan Angka !"},
                potistimewa   :{required:"Potongan Istimewa  Harus Disii !",number:"Hanya Disi Dengan Angka !"},
                penyharga     :{required:"Penyesuaian Harga  Harus Disii !",number:"Hanya Disi Dengan Angka !"},
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
              var placement = $(element).data('error');
              if (placement) {
                $(placement).append(error)
              } else {
                error.insertAfter(element);
              }
            }
         });

			$('.datepicker').bootstrapMaterialDatePicker({
		        format: 'YYYY-MM-DD',
		        clearButton: true,
		        weekStart: 1,
		        time: false
		    });


			function loadDataTmp(){

				$("#loadpnjtmp").load("<?php echo base_url();?>penjualan/view_detailtmp");
			}

			function hitungjatuhtempo(){

	  			var tgltransaksi = $("#tgltransaksi").val();
				$.ajax({
					type	:'POST',
					url 	:"<?php echo base_url(); ?>penjualan/hitungjatuhtempo",
					data    :{tgltransaksi:tgltransaksi},
					cache	:false,
					success : function(respond){
						$("#jatuhtempo").val(respond);
					}

				});
	  		}


	  		function hitungdiskon(){

	  			var nofaktur = $("#nofaktur").val();
	  			$.ajax({

	  				type	: 'POST',
	  				url     : '<?php echo base_url();?>penjualan/hitungdiskon',
	  				data 	: {nofaktur:nofaktur},
	  				cache 	: false,
	  				success : function(respond){

	  				    $("#potongan").val(respond);
	  					terbilangpotongan();
	  					

	  				}


	  			});

	  		}

			function kosong(){

				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").hide();
				$("#Bnamabank").hide();
				$("#Btglcair").hide();
				$("#Bbayar").hide();
				$("#Buanglebih").hide();
				$("#Bnogiro").hide();
				$("#Bjml").hide();

			}

			function showTitipan(){

				$("#Bjatuhtempo").show();
				$("#Btitipan").show();
				$("#Bmaterai").hide();
				$("#Bnamabank").hide();
				$("#Btglcair").hide();
				$("#Bbayar").hide();
				$("#Buanglebih").hide();
				$("#Bnogiro").hide();
				$("#Bjml").hide();
			}

			function showGiro(){
				$("#Bbayar").hide();
				$("#Buanglebih").hide();
				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").show();
				$("#Bnamabank").show();
				$("#Btglcair").show();
				$("#Bnogiro").show();
				$("#Bjml").show();

			}

			function showTransfer(){
				$("#Bbayar").hide();
				$("#Buanglebih").hide();
				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").hide();
				$("#Bnamabank").show();
				$("#Btglcair").show();
				$("#Bnogiro").hide();
				$("#Bjml").show();
			}

			function showTunai(){

				$("#Bbayar").hide();
				$("#Buanglebih").hide();
				$("#Bjatuhtempo").hide();
				$("#Btitipan").hide();
				$("#Bmaterai").hide();
				$("#Bnamabank").hide();
				$("#Btglcair").hide();
				$("#Bnogiro").hide();
			}
			
			
			function ResetBrg(){

				$("#kodebarang").val("");
				$("#barang").val("");
				$("#hargadus").val("");
				$("#hargapack").val("");
				$("#hargapcs").val("");
				$("#stokdus").val("");
				$("#stokpcs").val("");
				$("#stok").val("");
				$("#isipcsdus").val("");
				$("#isipcspack").val("");
				$("#stokpack").val("");
				$("#jmlpcs").val(0);
				$("#jmlpack").val(0);
				$("#jmldus").val(0);


			}		
			
			
			function terbilangpotongan(){

				var potongan = $("#potongan").val();

				 $.ajax({

	                type    : 'POST',
	                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
	                data    : {jmlbayar:potongan},
	                cache   :false,
	                success : function(respond){

	                    $("#terbilangpotongan").html(respond);
	                }

	            });

			}

			function terbilangjml(){
				var jml = $("#jml").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:jml},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangjml").html(respond);
		                }

		            });
			}


			function terbilangtotalbayar(){
				var totalbayar = $("#totalbayar").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:totalbayar},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangtotalbayar").html(respond);
		                }

		            });
			}

			
			kosong();
			loadDataTmp();
			hitungjatuhtempo();
			hitungdiskon();
			terbilangtotalbayar();

			
			
			//console.log($("#totalbayar").val());	
			 $("#potongan").on('keyup keydown change',function(){

		            var potongan = $("#potongan").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:potongan},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangpotongan").html(respond);
		                    terbilangtotalbayar();
		                    $("#jml").val($("#totalbayar").val());
		                    terbilangjml();
		                }

		            });

		     });



		     $("#potistimewa").on('keyup keydown change',function(){

		            var potistimewa = $("#potistimewa").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:potistimewa},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangpotistimewa").html(respond);
		                    terbilangtotalbayar();
		                    $("#jml").val($("#totalbayar").val());
		                    terbilangjml();
		                }

		            });

		     });

		     $("#potistimewa").on('keyup keydown change',function(){

		            var potistimewa = $("#potistimewa").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:potistimewa},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangpotistimewa").html(respond);
		                    terbilangtotalbayar();
		                    $("#jml").val($("#totalbayar").val());
		                    terbilangjml();
		                }

		            });

		     });

		     $("#penyharga").on('keyup keydown change',function(){

		            var penyharga = $("#penyharga").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:penyharga},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangpenyharga").html(respond);
		                    terbilangtotalbayar();
		                    $("#jml").val($("#totalbayar").val());
		                    terbilangjml();
		                }

		            });

		     });

		     $("#titipan").on('keyup keydown change',function(){

		            var titipan = $("#titipan").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:titipan},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangtitipan").html(respond);
		                    
		                    
		                }

		            });

		     });

		     $("#jml").on('keyup keydown change',function(){

		            var jml = $("#jml").val();

		            $.ajax({

		                type    : 'POST',
		                url     : '<?php echo base_url(); ?>pembayaran/terbilang',
		                data    : {jmlbayar:jml},
		                cache   :false,
		                success : function(respond){

		                    $("#terbilangjml").html(respond);
		                    terbilangjml();
		                }

		            });

		     });

		    


			$("#bayar").change(function(){
				var totalbayar	= $("#totalbayar").val();
				var bayar 		= $("#bayar").val();

				if(bayar < totalbayar){

					swal("Oops!", "Jumlah Bayar Kurang !", "warning");

				}



			});


			$("#tgltransaksi").change(function(){

				hitungjatuhtempo();

			});

			$("#pelanggan").click(function() {

				 $("#datapelanggan").modal("show");


			});

			$("#jenistransaksi").change(function(){
				var jt = $("#jenistransaksi").val();
				terbilangtotalbayar();
				$.ajax({

					type 	: 'POST',
					url 	: '<?php echo base_url(); ?>penjualan/jenistransaksi',
					data 	: {jt:jt},
					cache 	: false,
					success : function(respond){
						console.log(respond);
						$("#jenisbayar").html(respond);
						$("#jenisbayar").selectpicker("refresh");
					}



				});


			});

			

		    
			$("#jenisbayar").change(function(){

				var jenisbayar 	   = $("#jenisbayar").val();
				var jenistransaksi = $("#jenistransaksi").val();
				if (jenisbayar == "titipan"){
					
					showTitipan();

				}else if(jenisbayar=="giro"){
					showGiro();


		        	if( jenistransaksi == "tunai"){

		        		$("#jml").val($("#totalbayar").val());
		        		terbilangjml();
		        	}else{

		        		$("#jml").val(0);
		        		terbilangjml();
		        	}
				}else if(jenisbayar=="transfer"){
					showTransfer();
					if( jenistransaksi == "tunai"){

		        		$("#jml").val($("#totalbayar").val());
		        		terbilangjml();
		        	}else{

		        		$("#jml").val(0);
		        		terbilangjml();
		        	}
				}else if(jenisbayar=="tunai"){
					showTunai();
				}else{

					kosong();
				}

			});

			$("#jenistransaksi").change(function(){
				kosong();

			});

			$("#barang").click(function() {
				var kodecabang = $("#kodecabang").val();
				var pelanggan  = $("#pelanggan").val();
				if(pelanggan == ""){

					swal("Oops!", "Nama Pelanggan Harus Diisi Terlebih Dahulu !", "warning");
					$("#pelanggan").focus();
				}else{

					$("#databarang").modal("show");
					$.ajax({

						type 	: 'POST',
						url 	: '<?php echo base_url(); ?>barang/view_barangcab',
						data 	: {kodecabang:kodecabang},
						cache 	: false,
						success : function(respond){
							//alert(kodecabang);
							$("#loadBarang").html(respond);

						}



					});
				}

			});

			

			
			$("#kodebarang").change(function(){
				var id = $("#kodebarang").val();
				$.ajax({

					type  	: 'POST',
					url   	: '<?php echo base_url();?>penjualan/get_barang',
					data  	: {kodebarang:id},
					cache 	: false,
					success	: function(respond){
						data=respond.split("|");
						$("#satuan").val(data[0]);
						$("#hargadus").val(data[1]);
						$("#hargapack").val(data[2]);
						$("#hargapcs").val(data[3]);
						var hargapack =  $("#hargapack").val();

						if(hargapack == 0){

							$("#pack").hide();
						}else{
							$("#pack").show();
						}



					}
				});



			});

			$("#tambahbarang").click(function(e){
				var kodebarang = $("#kodebarang").val();
				var jmldus 	   = $("#jmldus").val();
				var hargadus   = $("#hargadus").val();
				var jmlpack    = $("#jmlpack").val();
				var hargapack  = $("#hargapack").val();
				var jmlpcs 	   = $("#jmlpcs").val();
				var hargapcs   = $("#hargapcs").val();
				var isipcsdus  = $("#isipcsdus").val();
				var isipcspack = $("#isipcspack").val();
				var stok 	   = $("#stok").val();
				var pelanggan  = $("#pelanggan").val();

				if ($('#promo').is(":checked"))
				{
				  var promo   = $("#promo").val();
				}else{

					var promo = '';
				}
				
				var jumlahpcs  = (jmldus * isipcsdus) + (jmlpack * isipcspack) + (jmlpcs * 1);
				e.preventDefault();
				if(kodebarang ==""){
					swal("Oops!", "Silahkan Pilih Barang Terlebih Dahulu !", "warning");
				}
				else if(jmldus == 0 && jmlpack ==0 && jmlpcs== 0){

					swal("Oops!", "Jumlah Tidak Boleh 0!"+pelanggan, "warning");
			
				}else{
						$.ajax({

							type  	: 'POST',
							url   	: '<?php echo base_url();?>penjualan/insert_detailtmp',
							data  	: {
										kodebarang:kodebarang,
										jmldus:jmldus,
										hargadus:hargadus,
										jmlpack:jmlpack,
										hargapack:hargapack,
										jmlpcs:jmlpcs,
										hargapcs:hargapcs,
										promo:promo,
										pelanggan:pelanggan

								  	},
							cache 	: false,
							success : function(respond){
								console.log(respond);
								ResetBrg();
								loadDataTmp();
								hitungdiskon();
								
								
							}


						});
				}

			});

			//Datatables Pelanggan 

			 $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
	        {
	            return {
	                "iStart": oSettings._iDisplayStart,
	                "iEnd": oSettings.fnDisplayEnd(),
	                "iLength": oSettings._iDisplayLength,
	                "iTotal": oSettings.fnRecordsTotal(),
	                "iFilteredTotal": oSettings.fnRecordsDisplay(),
	                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
	                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
	            };
	        };

	        var t = $("#mytable").dataTable({
	            
	            initComplete: function() {

	                var api = this.api();
	                $('#mytable_filter input').off('.DT').on('keyup.DT', function(e) {
                            
                            if (e.keyCode == 13) {
                                api.search(this.value).draw();
			                 }
			        });
	            },
	            oLanguage: {
	                sProcessing: "loading..."
	            },
	            processing: true,
	            serverSide: true,
	            bLengthChange: false,

	            ajax: {"url": "<?php echo base_url();?>penjualan/jsonPelanggan", "type": "POST"},
	            columns: [
	                {
	                    "data": "kode_pelanggan",
	                    "orderable": false
	                },
	                {"data": "kode_pelanggan"},
	                {"data": "nama_pelanggan"},
	                {"data": "no_hp"},
	                {"data": "pasar"},
	                {"data": "nama_cabang"},
	                {"data": "nama_karyawan"},
	                {"data": "view"}
	            ],
	            order: [[1, 'desc']],
	            rowCallback: function(row, data, iDisplayIndex) {
	                var info = this.fnPagingInfo();
	                var page = info.iPage;
	                var length = info.iLength;
	                var index = page * length + (iDisplayIndex + 1);
	                $('td:eq(0)', row).html(index);

	                
	            }	


	        });

	        $('#mytable tbody').on('click', 'a', function () {
		        $("#kodepelanggan").val($(this).attr("data-kodepel"));
		        $("#pelanggan").val($(this).attr("data-namapel"));
		        $("#kodesales").val($(this).attr("data-kodesales"));
		        $("#salesman").val($(this).attr("data-namasales"));
		        $("#kodecabang").val($(this).attr("data-cabang"));
		       	$("#datapelanggan").modal("hide");	

		    });


	        $("#jml").focus(function(){

	        	var jenistransaksi = $("#jenistransaksi").val();
	        	if( jenistransaksi == "tunai"){

	        		$("#jml").val($("#totalbayar").val());
	        		terbilangjml();
	        	}else{

	        		$("#jml").val(0);
	        	}

	        });


	        $("#nofaktur").on('keyup keydown change',function(){

	        	var nofaktur = $("#nofaktur").val();
	        	$.ajax({

	        		type 	: 'POST',
	        		url 	:'<?php echo base_url();?>penjualan/ceknofaktur',
	        		data 	:{nofaktur:nofaktur},
	        		cache	:false,
	        		success	: function(respond){
	        			var status = respond;
	        			if(status !=0){
	        				swal("Oops!", "No Faktur "+nofaktur+  " Sudah Digunakan !", "warning");
	        				$("#nofaktur").val("");
	        			}
	        		}

	        	});


	        });


	         $("form").submit(function(){

	         	var jenistransaksi  = $("#jenistransaksi").val();
	         	var jenisbayar 		= $("#jenisbayar").val();
	         	var nogiro 			= $("#nogiro").val();
	            var materai 		= $("#materai").val();
	            var namabank 		= $("#namabank").val();
	            var tglcair 		= $("#tglcair").val();
	            var jml 			= $("#jml").val();
	            var totalbayar 		= $("#totalbayar").val();
	            var titipan 		= $("#titipan").val();


	           

	
            	if( jenisbayar ==""){

            		swal("Oops!", "Jenis Bayar Harus Diisi !", "warning");
	                return false;

            	}else if( jenisbayar=="giro" && nogiro == "" ){

	                swal("Oops!", "No Giro Harus Diisi !", "warning");
	                return false;
	            }else if( jenisbayar=="giro" && materai=="" ){

	                swal("Oops!", "Materai Harus Diisi !", "warning");
	                return false;
	            }else if( jenisbayar=="giro" && namabank=="" ){

	                swal("Oops!", "Bank Harus Diisi !", "warning");
	                return false;
	            }else if(jenisbayar=="giro" && tglcair=="" ){

	                swal("Oops!", "Tanggal Jatuh Tempo Harus Diisi !", "warning");
	                return false;
	            }else if(jenistransaksi == "tunai" && jenisbayar=="giro" && jml != totalbayar ){

	                swal("Oops!", "Jumlah Tidak Sama Dengan Total Bayar Silahkan Klik Form Jumlah Agar Jumlah Menyesuaikan dengan Total Bayar !", "warning");
	                return false;
	            }else if(jenisbayar=="transfer" && namabank=="" ){

	                swal("Oops!", "Bank Harus Diisi !", "warning");
	                return false;
	            }else if(jenisbayar=="transfer" && tglcair=="" ){

	                swal("Oops!", "Tanggal Jatuh Tempo Harus Diisi !", "warning");
	                return false;
	            }else if(jenistransaksi == "tunai" && jenisbayar=="transfer" && jml != totalbayar ){

	                swal("Oops!", "Jumlah Tidak Sama Dengan Total Bayar Silahkan Klik Form Jumlah Agar Jumlah Menyesuaikan dengan Total Bayar !", "warning");
	                return false;

	            }else if(jenistransaksi == "kredit" && jenisbayar=="titipan" && (titipan*1) > (totalbayar*1) ){

	                swal("Oops!", "Jumlah titipan Melebihi Total Bayar !", "warning");
	                return false;

	            }else if(jenistransaksi == "kredit" && jenisbayar=="giro" && (jml*1) > (totalbayar*1) ){

	                swal("Oops!", "Jumlah Bayar Melebihi Total Bayar !", "warning");
	                return false;

	            }else if(jenistransaksi == "kredit" && jenisbayar=="transfer" && (jml*1) > (totalbayar*1) ){

	                swal("Oops!", "Jumlah Bayar Melebihi Total Bayar !", "warning");
	                return false;

	            }else{

	                return true;
	            }

	            
           
        });

	      

		});

		(function ($) {
			$.fn.simpleMoneyFormat = function() {
				this.each(function(index, el) {		
					var elType = null; // input or other
					var value = null;
					// get value
					if($(el).is('input') || $(el).is('textarea')){
						value = $(el).val().replace(/,/g, '');
						elType = 'input';
					} else {
						value = $(el).text().replace(/,/g, '');
						elType = 'other';
					}
					// if value changes
					$(el).on('paste keyup', function(){
						value = $(el).val().replace(/,/g, '');
						formatElement(el, elType, value); // format element
					});
					formatElement(el, elType, value); // format element
				});
				function formatElement(el, elType, value){
					var result = '';
					var valueArray = value.split('');
					var resultArray = [];
					var counter = 0;
					var temp = '';
					for (var i = valueArray.length - 1; i >= 0; i--) {
						temp += valueArray[i];
						counter++
						if(counter == 3){
							resultArray.push(temp);
							counter = 0;
							temp = '';
						}
					};
					if(counter > 0){
						resultArray.push(temp);				
					}
					for (var i = resultArray.length - 1; i >= 0; i--) {
						var resTemp = resultArray[i].split('');
						for (var j = resTemp.length - 1; j >= 0; j--) {
							result += resTemp[j];
						};
						if(i > 0){
							result += ','
						}
					};
					if(elType == 'input'){
						$(el).val(result);
					} else {
						$(el).empty().text(result);
					}
				}
			};
		}(jQuery));

		$('.money').simpleMoneyFormat();

</script>