<?php 
$no=1;
foreach($barang as $b){ 

    $jmldus     = floor($b->stok / $b->isipcsdus);
    $sisadus    = $b->stok % $b->isipcsdus;

    if($b->isipack == 0){
        $jmlpack    = 0;
        $sisapack   = $sisadus;   
    }else{

        $jmlpack    = floor($sisadus / $b->isipcs);  
        $sisapack   = $sisadus % $b->isipcs;  
    }

    $jmlpcs = $sisapack;
?>
    <tr>
        <td><?php echo $no; ?></td>    
        <td><?php echo $b->kode_barang; ?></td>
        <td><?php echo $b->nama_barang; ?></td>
        <td><?php echo $b->kategori; ?></td>
        <td><?php echo $b->satuan; ?></td>
        <td align="center"><?php echo $jmldus; ?></td>
        
        <td align="center"><?php echo $jmlpack; ?></td>
        
        <td align="center"><?php echo $jmlpcs; ?></td>
         <td>
             <a href="#" data-kodebrg="<?php echo $b->kode_barang; ?>" data-namabrg ="<?php echo $b->nama_barang; ?>"  data-hargadus ="<?php echo $b->harga_dus; ?>" data-hargapack ="<?php echo $b->harga_pack; ?>" data-hargapcs ="<?php echo $b->harga_pcs; ?>" data-stokdus ="<?php echo $jmldus; ?>" data-stokpack ="<?php echo $jmlpack; ?>" data-stokpcs ="<?php echo $jmlpcs; ?>" data-stok="<?php echo $b->stok; ?>" data-isipcsdus="<?php echo $b->isipcsdus; ?>" data-isipcspack="<?php echo $b->isipcs; ?>" data-promo="<?php echo $b->promo; ?>"  class="btn bg-red  btn-xs waves-effect pilibarang">Pilih</a>
        </td>

      
    </tr>
<?php $no++; } ?>


    

<script type="text/javascript">
    
    $(function(){

           
          
            $('.pilibarang').click(function(e){
                e.preventDefault();
                $("#kodebaranggb").val($(this).attr("data-kodebrg"));
                $("#baranggb").val($(this).attr("data-namabrg"));
                $("#hargadusgb").val($(this).attr("data-hargadus"));
                $("#hargapackgb").val($(this).attr("data-hargapack"));
                $("#hargapcsgb").val($(this).attr("data-hargapcs"));
                $("#stokdusgb").val($(this).attr("data-stokdus"));
                $("#stokpackgb").val($(this).attr("data-stokpack"));
                $("#stokpcsgb").val($(this).attr("data-stokpcs"));
                $("#stokgb").val($(this).attr("data-stok"));
                $("#isipcsdusgb").val($(this).attr("data-isipcsdus"));
                $("#isipcspackgb").val($(this).attr("data-isipcspack"));
               
                $("#databarang").modal("hide");
                var hargapack =  $("#hargapackgb").val();

                if(hargapack == 0){

                    $("#packgb").hide();
                }else{
                    $("#packgb").show();
                }
              

            });



    });


</script>