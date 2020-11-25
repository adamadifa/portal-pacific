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
		<td align="right"><a href="#" data-id="<?php echo $d->kode_produk; ?>" data-nofaktur="<?php echo $d->no_fak_penj; ?>" class="btn bg-red btn-xs hapus"><i class="material-icons">delete</i></a></td>
	</tr>
<?php } ?>

<script type="text/javascript">

    $(function(){
        function loaddetailpelunasanhk(){
				var nofaktur = $("#nofaktur").val();
				$("#loaddetailpelunasanhk").load("<?php echo base_url();?>penjualan/view_detailpelunasanhktemp/"+nofaktur);
        }

        function cekdetailpelunasanhk(){
            var nofaktur  = $("#nofaktur").val();
            $.ajax({

                type    : 'POST',
                url     : '<?php echo base_url(); ?>penjualan/cekdetailpelunasanhk',
                data    : {nofaktur:nofaktur},
                cache   :false,
                success : function(respond){
                    console.log(nofaktur);
                    $("#cekdetailpelunasanhk").val(respond);
                }

            });
		}



        $(".hapus").click(function(e){
            var id 		    = $(this).attr("data-id");
            var nofaktur    = $(this).attr("data-nofaktur");
            e.preventDefault();
            $.ajax({

                type		: 'POST',
                url 		: '<?php echo base_url(); ?>penjualan/hapus_detailpelunasanhktemp',
                data 		: {kode_produk:id,nofaktur:nofaktur},
                cache		: false,
                success 	: function(respond){

                    loaddetailpelunasanhk();
                    cekdetailpelunasanhk();

                }
            });

        });







    });
</script>
