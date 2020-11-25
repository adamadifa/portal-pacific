
<div class="card">
    <div class="header bg-cyan">
        <h2>
           INPUT KOREKSI PENJUALAN
            <small>INPUT KOREKSI PENJUALAN</small>
        </h2>
        
    </div>
    <div class="body">
        <form autocomplete="off" class="formValidate" id="formValidate"  method="POST" action="<?php echo base_url(); ?>penjualan/inputkoreksipenjualan">
		<input type="hidden" name="no_faktur" value="<?php echo $faktur['no_fak_penj']; ?>">
		<div class="row clearfix">
             <div class="row">
				<div class="body">
					<div class="col-md-5">
						<table class="table">
							<tr>
								<td><b>No Faktur</b></td>
								<td></td>
								<td id="nofaktur"><?php echo $faktur['no_fak_penj']; ?></td>
							</tr>
							<tr>
								<td><b>Tgl Transaksi</b></td>
								<td></td>
								<td><?php echo DateToIndo2($faktur['tgltransaksi']); ?></td>
							</tr>
							<tr>
								<td><b>Kode Pelanggan</b></td>
								<td></td>
								<td id="kodepel"><?php echo $faktur['kode_pelanggan']; ?></td>
							</tr>
							<tr>
								<td><b>Nama Pelanggan</b></td>
								<td></td>
								<td><?php echo $faktur['nama_pelanggan']; ?></td>
							</tr>
								<td><b>Pasar</b></td>
								<td></td>
								<td><?php echo $faktur['pasar']; ?></td>
							</tr>
							 <tr>
								<td><b>Salesman</b></td>
								<td></td>
								<td><?php echo $faktur['nama_karyawan']; ?></td>
							</tr> 
							 <tr>
								<td><b>Jenis Transaksi</b></td>
								<td></td>
								<td><?php echo $faktur['jenistransaksi']; ?></td>
							</tr>  
							 <tr>
								<td><b>Jenis Bayar</b></td>
								<td></td>
								<td><?php echo $faktur['jenisbayar']; ?></td>
							</tr>  
						</table>
					</div>
					<div class="col-md-7">
						<div class="info-box" style="min-height:170px">
							<div class="icon bg-cyan" style="height:170px; padding:50px 0; width:100px" >
								<i class="material-icons">shopping_cart</i>
							</div>
							<div class="content">
								<div id="grandtotal" style="padding:30px 0px 50px 0px; font-size:60px; margin-left:90px"><?php echo number_format($faktur['totalpiutang'],'0','','.'); ?></div>
							</div>
						</div>
					</div> 
				</div>
			</div>
			<div class="row">
				<div class="body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="bg-cyan">
									<td colspan="9"><b>Detail Penjualan</b></td>
								</tr>
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
								</tr>
							</thead>
							<tbody>
								<?php
									$total = 0;
									foreach($barang as $b){ 
									$jmldus     = floor($b->jumlah / $b->isipcsdus);
									$sisadus    = $b->jumlah % $b->isipcsdus;

									if($b->isipack == 0){
										$jmlpack    = 0;
										$sisapack   = $sisadus;   
									}else{

										$jmlpack    = floor($sisadus / $b->isipcs);  
										$sisapack   = $sisadus % $b->isipcs;  
									}

									$jmlpcs = $sisapack;

									$total = $total + $b->subtotal;
								?>
									<tr>
										<td><?php echo $b->kode_barang; ?></td>
										<td><?php echo $b->nama_barang; ?></td>
										<td align="center"><?php echo $jmldus; ?></td>
										<td align="right"><?php echo  number_format($b->harga_dus,'0','','.'); ?></td>
										<td align="center"><?php echo $jmlpack; ?></td>
										<td align="right"><?php echo  number_format($b->harga_pack,'0','','.'); ?></td>
										<td align="center"><?php echo $jmlpcs; ?></td>
										<td align="right"><?php echo  number_format($b->harga_pcs,'0','','.'); ?></td>
										<td align="right"><?php echo  number_format($b->subtotal,'0','','.'); ?></td>
									</tr>
								<?php } ?>
									<tr>
										 <td colspan="8"><b>SUB TOTAL</b></td>
										 <td align="right"><b><?php echo  number_format($total,'0','','.'); ?></b></td>
									</tr>
									<tr>
										 <td colspan="8"><b>POTONGAN</b></td>
										 <td align="right"><b><?php echo  number_format($faktur['potongan'],'0','','.'); ?></b></td>
									</tr>
									<tr>
										 <td colspan="8"><b>POTONGAN ISTIMEWA</b></td>
										 <td align="right"><b><?php echo  number_format($faktur['potistimewa'],'0','','.'); ?></b></td>
									</tr>
									<tr>
										 <td colspan="8"><b>PENYESUAIAN HARGA</b></td>
										 <td align="right"><b><?php echo  number_format($faktur['penyharga'],'0','','.'); ?></b></td>
									</tr>
									<tr>
										 <td colspan="8"><b>TOTAL</b></td>
										 <td align="right"><b><?php echo  number_format($faktur['total'],'0','','.'); ?></b></td>
									</tr>
									
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="bg-cyan">
									<td colspan="10"><b>Detail Retur</b></td>
								</tr>
								<tr>
									<th>Tgl Retur</th>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th>Jml Dus</th>
									<th>Harga Dus</th>
									<th>Jml Pack</th>
									<th>Harga Pack</th>
									<th>Jml Pcs</th>
									<th>Harga Pcs</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$total = 0;
									foreach($returpf as $d){ 
									$total = $total + $d->subtotal; 

									$jmldus     = floor($d->jumlah / $d->isipcsdus);
									$sisadus    = $d->jumlah % $d->isipcsdus;

									if($d->isipack == 0){
										$jmlpack    = 0;
										$sisapack   = $sisadus;   
									}else{

										$jmlpack    = floor($sisadus / $d->isipcs);  
										$sisapack   = $sisadus % $d->isipcs;  
									}

									$jmlpcs = $sisapack;
								?>
									<tr>
										<td><?php echo $d->tglretur; ?></td>
										<td><?php echo $d->kode_barang; ?></td>
										<td><?php echo $d->nama_barang; ?></td>
										<td align="center"><?php echo $jmldus; ?></td>
										<td align="right"><?php echo number_format($d->harga_dus,'0','','.'); ?></td>
										<td align="center"><?php echo $jmlpack; ?></td>
										<td align="right"><?php echo number_format($d->harga_pack,'0','','.'); ?></td>
										<td align="center"><?php echo $jmlpcs; ?></td>
										<td align="right"> <?php echo number_format($d->harga_pcs,'0','','.'); ?></td>
										<td align="right"><?php echo number_format($d->subtotal,'0','','.'); ?></td>
									  
									</tr>
								<?php } ?>
									<tr>
										<td colspan="9"><b>TOTAL</b></td>
										<td align="right"><b><?php echo number_format($total,'0','','.'); ?></b><input type="hidden"  name="subtotal" value="<?php  echo $total; ?>" onFocus="startCalc();" ></td>
									  
									</tr>


									
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="bg-cyan">
									<td colspan="10"><b>Detail Penggantian Barang</b></td>
								</tr>
								<tr>
									<th>Tgl Retur</th>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th>Jml Dus</th>
									<th>Harga Dus</th>
									<th>Jml Pack</th>
									<th>Harga Pack</th>
									<th>Jml Pcs</th>
									<th>Harga Pcs</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
							   <?php 
									$total = 0;
									foreach($returgb as $d){ 
									$total = $total + $d->subtotal; 

									$jmldus     = floor($d->jumlah / $d->isipcsdus);
									$sisadus    = $d->jumlah % $d->isipcsdus;

									if($d->isipack == 0){
										$jmlpack    = 0;
										$sisapack   = $sisadus;   
									}else{

										$jmlpack    = floor($sisadus / $d->isipcs);  
										$sisapack   = $sisadus % $d->isipcs;  
									}

									$jmlpcs = $sisapack;
									
									
								?>
									<tr>
										<td><?php echo $d->tglretur; ?></td>
										<td><?php echo $d->kode_barang; ?></td>
										<td><?php echo $d->nama_barang; ?></td>
										<td align="center"><?php echo $jmldus; ?></td>
										<td align="right"><?php echo number_format($d->harga_dus,'0','','.'); ?></td>
										<td align="center"><?php echo $jmlpack; ?></td>
										<td align="right"><?php echo number_format($d->harga_pack,'0','','.'); ?></td>
										<td align="center"><?php echo $jmlpcs; ?></td>
										<td align="right"> <?php echo number_format($d->harga_pcs,'0','','.'); ?></td>
										<td align="right"><?php echo number_format($d->subtotal,'0','','.'); ?></td>
									  
									</tr>
								<?php } ?>
									<tr>
										<td colspan="9"><b>TOTAL</b></td>
										<td align="right"><b><?php echo number_format($total,'0','','.'); ?></b><input type="hidden"  name="subtotal" value="<?php  echo $total; ?>" onFocus="startCalc();" ></td>
									  
									</tr>
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="body">
					<div class="demo-switch">
                        <div class="switch">
							<?php 
								if($faktur['status']=='1'){
									$c = "checked";
								}else{
									$c = "";
								}
							?>
                            <label><b style="color:red">KOREKSI</b><input type="checkbox" <?php echo $c; ?> name="koreksi_cf" id="koreksi_cf" value="1"><span class="lever"></span><b style="color:green">TIDAK ADA KOREKSI</b></label>
                        </div>
                    </div>
				</div>
			</div>
			<div class="row" id="inputkoreksi">
				<div class="body">
					<div class="col-md-12">
						<div class="form-group">
							<div class="form-line">
								<textarea rows="1" id="inputkoreksi_val" class="form-control no-resize auto-growth" placeholder="Input Koreksi Penjualan"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="body">
					<div class="col-md-12">
						<button class="btn btn-lg bg-blue" name="submit">Simpan</button>
					</div>
				</div>
			</div>
        </div>
		</form>
    </div>
</div>


<script type="text/javascript">
    
    $(function(){
		
		function checked(){
			
			if ($("#koreksi_cf").is(':checked')) {
				$("#inputkoreksi").hide();
			}else{
				$("#inputkoreksi").show();
			}
		}
		
		checked();
		
		$('#koreksi_cf').click(function() {
			
			if ($(this).is(':checked')) {
				$("#inputkoreksi").hide();
			}else{
				$("#inputkoreksi").show();
			}
		});
		
		$("#formValidate").submit(function(){
			var koreksi = $("#inputkoreksi_val").val();
			if (!$("#koreksi_cf").is(':checked') && koreksi=="")   {
				
				swal("Oops!", "Koreksi Harus Diisi.. !", "warning");
				return false;
			}else{
				
				return true;
			}
		
		});
		
       
	});
</script>


  
 


  
