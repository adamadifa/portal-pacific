<?php 
	foreach ($detail as $d){
?>
	<tr>
		<td><?php echo $d->kode_produk;?></td>
		<td><?php echo $d->nama_barang;?></td>
		<td><?php echo $d->jumlah;?></td>
		<td>

			<?php if($d->status==0){ ?>
				<a href="#" data-nopermintaan="<?php echo $d->no_permintaan_pengiriman; ?>"  data-produk="<?php echo $d->kode_produk; ?>" data-namaproduk="<?php echo $d->nama_barang; ?>" data-jumlah="<?php echo $d->jumlah; ?>"   class="btn btn-xs bg-green editdetail">
					<i class="material-icons">mode_edit</i>
				</a>
				<a href="#" data-nopermintaan="<?php echo $d->no_permintaan_pengiriman; ?>"  data-produk="<?php echo $d->kode_produk; ?>" data-namaproduk="<?php echo $d->nama_barang; ?>" data-jumlah="<?php echo $d->jumlah; ?>"   class="btn btn-xs bg-red deletedetail">
					<i class="material-icons">delete</i>
				</a>
			<?php } ?>
		</td>
	</tr>
<?php 
}
?>

<div class="modal fade" id="editdetail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="header bg-cyan">
                    <h2>
                        Detail Permintaan Pengiriman
                        <small>Detail Permintaan Pengiriman</small>
                    </h2>
                    
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                        <div class="table-responsive">
                           <div id="loadeditdetail">
                           	
                           </div>
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
		function loaddetailpp(){
			var no_permintaan = $("#nopermintaan").val();
			$("#loaddetailpp").load('<?php echo base_url(); ?>/oman/detailpp/'+no_permintaan);
		}

		$('.editdetail').click(function(e){
            e.preventDefault();
            var no_permintaan = $(this).attr('data-nopermintaan');
            var kode_produk   = $(this).attr('data-produk');
     		var nama_barang   = $(this).attr('data-namaproduk');
     		var jumlah 		  = $(this).attr('data-jumlah');
            $("#kodeproduk").val(kode_produk);
            $("#produk").val(nama_barang);
            $("#jml").val(jumlah);

        });

        $('.deletedetail').click(function(e){
            e.preventDefault();
            var no_permintaan = $(this).attr('data-nopermintaan');
            var kode_produk   = $(this).attr('data-produk');
     		    var nama_barang   = $(this).attr('data-namaproduk');
     		    var jumlah 		    = $(this).attr('data-jumlah');
           	
           	$.ajax({

           		type 	: 'POST',
           		url  	: '<?php echo base_url(); ?>oman/deletedetail',
           		data 	: {no_permintaan:no_permintaan,kode_produk:kode_produk},
           		cache 	: false,
           		success : function(respond){
           			loaddetailpp();
           		}


           	});


        });

	});
</script>