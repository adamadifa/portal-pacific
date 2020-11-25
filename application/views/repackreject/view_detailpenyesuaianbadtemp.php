<?php
	$total = 0;
	foreach($detail as $d){


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
		<td><?php echo $d->kode_produk; ?></td>
		<td><?php echo $d->nama_barang; ?></td>
		<td align="center"><?php echo $jmldus; ?></td>
		<td align="center"><?php echo $jmlpack; ?></td>
		<td align="center"><?php echo $jmlpcs; ?></td>
		<td align="right"><a href="#" data-id="<?php echo $d->kode_produk; ?>" data-salesman="<?php echo $d->id_karyawan; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
	</tr>
<?php } ?>

<script type="text/javascript">

	$(function(){
		function loadDetail(){
			var salesman = $("#salesman").val();
			$("#loadDetail").load("<?php echo base_url();?>repackreject/view_detailpenyesuaianbadtemp/"+salesman);
		}

		function cekdetail(){
			var salesman  = $("#salesman").val();
			$.ajax({
				type    : 'POST',
				url     : '<?php echo base_url(); ?>repackreject/cekdetailpenyesuaianbadtemp',
				data    : {salesman:salesman},
				cache   :false,
				success : function(respond){
					console.log(cabang);
					$("#cekdetailpenyesuaiantemp").val(respond);
				}

			});
		}

		$(".hapus").click(function(e){
			var id 			= $(this).attr("data-id");
			var salesman 	= $(this).attr("data-salesman");
			e.preventDefault();
			$.ajax({

				type		: 'POST',
				url 		: '<?php echo base_url(); ?>repackreject/hapus_detailbrgpenyesuaianbad',
				data 		: {kode_produk:id,salesman:salesman},
				cache		: false,
				success 	: function(respond){

					 cekdetail();
					loadDetail();

				}
			});

		});







	});
</script>
