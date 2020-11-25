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
        $jmlpcs       = $sisapack;
        $jmlduspl     = floor($d->pelunasan_hk / $d->isipcsdus);
        $sisaduspl    = $d->pelunasan_hk % $d->isipcsdus;

        if($d->isipack == 0){
            $jmlpackpl    = 0;
            $sisapackpl   = $sisaduspl;
        }else{

            $jmlpackpl    = floor($sisaduspl / $d->isipcs);
            $sisapackpl   = $sisaduspl % $d->isipcs;
        }
        $jmlpcspl = $sisapackpl;
?>
    <tr>
        <td><?php echo $d->kode_produk;?></td>
        <td><?php echo $d->nama_barang;?></td>
        <td align="right"><?php if(!empty($jmldus)){echo number_format($jmldus,'0','','.');}?></td>
        <td align="right"><?php if(!empty($jmlpack)){echo number_format($jmlpack,'0','','.');}?></td>
        <td align="right"><?php if(!empty($jmlpcs)){echo number_format($jmlpcs,'0','','.');}?></td>
        <td align="right"><?php if(!empty($jmlduspl)){echo number_format($jmlduspl,'0','','.');}?></td>
        <td align="right"><?php if(!empty($jmlpackpl)){echo number_format($jmlpackpl,'0','','.');}?></td>
        <td align="right"><?php if(!empty($jmlpcspl)){echo number_format($jmlpcspl,'0','','.');}?></td>
        <?php
          if($d->jumlah == $d->pelunasan_hk){
        ?>
                <td><a href="#"><span class="badge bg-green">Sudah Lunas</span></a></td>
        <?php
            }else{
        ?>
                <td><a href="#" data-nofaktur ="<?php echo $d->no_fak_penj; ?>" data-jumlah="<?php echo $d->jumlah; ?>" data-kode="<?php echo $d->kode_produk; ?>" data-produk="<?php echo $d->nama_barang; ?>" data-hargadus ="<?php echo $d->harga_dus; ?>" data-hargapack ="<?php echo $d->harga_pack; ?>" data-hargapcs ="<?php echo $d->harga_pcs; ?>" data-isipcsdus="<?php echo $d->isipcsdus; ?>" data-isipcspack="<?php echo $d->isipcs; ?>" class="pilihbarang"><span class="badge bg-red">Pilih</span></a></td>
        <?php } ?>
    </tr>
<?php
}
?>

<script>

    $(function(){



      $(".pilihbarang").click(function(e){
  			e.preventDefault();
  			var kodeproduk     = $(this).attr("data-kode");
  			var namaproduk     = $(this).attr("data-produk");
        var nofaktur       = $(this).attr("data-nofaktur");
        $.ajax({
          type    : 'POST',
          url     : '<?php echo base_url(); ?>penjualan/cekplhk',
          data    : {nofaktur:nofaktur,kodeproduk:kodeproduk},
          cache   : false,
          success : function(respond){
            console.log(respond);
            var data = respond.split("|");
            $("#cekplhk").val(data[0]);
            $("#jmlhk").val(data[1]);
          }

        });
  			$("#kodebarang").val(kodeproduk);
  			$("#barang").val(namaproduk);
  			$("#hargadus").val($(this).attr("data-hargadus"));
  			$("#hargapack").val($(this).attr("data-hargapack"));
  			$("#hargapcs").val($(this).attr("data-hargapcs"));
  			$("#isipcsdus").val($(this).attr("data-isipcsdus"));
  			$("#isipcspack").val($(this).attr("data-isipcspack"));

	    });



    });

</script>
