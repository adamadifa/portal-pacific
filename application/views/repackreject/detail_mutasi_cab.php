<table class="table table-bordered table-hover table-striped">
	<tr>
		<td>
			<?php if($jenis_mutasi == "REPACK"){ ?>
				<b>No Repack</b>
			<?php }else if($jenis_mutasi == "REJECT GUDANG"){ ?>
				<b>No Reject</b>
			<?php }else if($jenis_mutasi == "REJECT PASAR"){ ?>
				<b>No Reject</b>
			<?php }else if($jenis_mutasi == "KIRIM PUSAT"){ ?>
				<b>No Pengiriman</b>
			<?php }else if($jenis_mutasi == "HUTANG KIRIM"){ ?>
				<b>No Hutan Kirim</b>
			<?php }else if($jenis_mutasi == "TTR"){ ?>
				<b>No TTR</b>
			<?php }else if($jenis_mutasi == "PENYESUAIAN"){ ?>
				<b>No DPB</b>
			<?php } ?> 
		</td>
		<td>:</td>
		<td>
			<?php 
				if($jenis_mutasi == "PENYESUAIAN"){

					echo $mutasi['no_dpb'];
				}else{
					echo $mutasi['no_mutasi_gudang_cabang']; 
				}
			
			?>
				
		</td>
	</tr>
	<tr>
		<td><b>Tanggal</b></td>
		<td>:</td>
		<td><?php echo DateToIndo2($mutasi['tgl_mutasi_gudang_cabang']); ?></td>
	</tr>

</table>
<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th rowspan="2">Kode Produk</th>
			<th rowspan="2">Nama Barang</th>
			<th colspan="3" style="text-align: center">Jumlah</th>
		</tr>
		<tr>
			<th>DUS</th>
			<th>PACK</th>
			<th>PCS</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($detail as $d){

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
				<td><?php echo $d->kode_produk;?></td>
				<td><?php echo $d->nama_barang;?></td>
				<td align="right"><?php echo number_format($jmldus,'0','','.');?></td>
				<td align="right"> <?php echo number_format($jmlpack,'0','','.');?></td>
				<td align="right"><?php echo number_format($jmlpcs,'0','','.');?></td>
			</tr>
		<?php 
		}
		?>
	</tbody>
</table>