<div class="row">
	<div class="body">
		<div class="col-md-6">
			<table class="table table-bordered table-hover table-striped">
				<tr>
					<td>
						<b>Kode Stok Opname</b>
					</td>
					<td>:</td>
					<td><?php echo $mutasi['no_so']; ?></td>
				</tr>
				<tr>
					<td><b>Tanggal</b></td>
					<td>:</td>
					<td><?php echo DateToIndo2($mutasi['tgl_so']); ?></td>
				</tr>

			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="body">
		<div class="col-md-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th rowspan="2">Kode Produk</th>
						<th rowspan="2">Nama Barang</th>
						<th colspan="3" style="text-align:center vertical-align : middle">Jumlah Stok</th>
						<th colspan="3" style="text-align:center; vertical-align: middle">Jumlah Fisik</th>
                        <th rowspan="2" style="text-align:center; vertical-align: middle">Keterangan</th>
					</tr>
					<tr>
						<th>DUS</th>
						<th>PACK</th>
						<th>PCS</th>
						<th>DUS</th>
						<th>PACK</th>
						<th>PCS</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($detail as $d){

							if($d->jumlah != 0){
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
							}else{
						
								$jmldus   = 0;
								$jmlpack  = 0;
								$jmlpcs   = 0;
							}
							
							
							if($d->jumlah_stok != 0){
								$jmldus_stok     = floor($d->jumlah_stok / $d->isipcsdus);
								$sisadus_stok    = $d->jumlah_stok % $d->isipcsdus;
						
								if($d->isipack == 0){
									$jmlpack_stok    = 0;
									$sisapack_stok   = $sisadus_stok;   
								}else{
						
									$jmlpack_stok    = floor($sisadus_stok / $d->isipcs);  
									$sisapack_stok   = $sisadus_stok % $d->isipcs;  
								}
						
								$jmlpcs_stok = $sisapack_stok;
							}else{
						
								$jmldus_stok   = 0;
								$jmlpack_stok  = 0;
								$jmlpcs_stok   = 0;
							}	
					?>
						<tr>
							<td><?php echo $d->kode_produk;?></td>
							<td><?php echo $d->nama_barang;?></td>
							<td align="right"><?php echo number_format($jmldus_stok,'0','','.');?></td>
							<td align="right"> <?php echo number_format($jmlpack_stok,'0','','.');?></td>
							<td align="right"><?php echo number_format($jmlpcs_stok,'0','','.');?></td>
							<td align="right"><?php echo number_format($jmldus,'0','','.');?></td>
							<td align="right"> <?php echo number_format($jmlpack,'0','','.');?></td>
							<td align="right"><?php echo number_format($jmlpcs,'0','','.');?></td>
							<td><?php echo $d->keterangan;?></td>
						</tr>
					<?php 
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>