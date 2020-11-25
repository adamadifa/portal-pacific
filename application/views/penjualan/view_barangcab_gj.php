<table class="table table-bordered table-striped table-hover dataTable js-exportable" id="tabelbarang" style=" font-size:12px">
    <thead>
        <tr>
            <th width="10px">No</th>
            <th>Kode Produk</th>
            <th>Nama Barang</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php 

    error_reporting(0);
    $no=1; foreach($barang as $b){

        

    ?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $b->kode_produk; ?></td>
        <td><?php echo $b->nama_barang; ?></td>
      
       
        <td>
             <a href="#" data-kodecabang="<?php echo $b->kode_cabang; ?>" data-kodebrg="<?php echo $b->kode_produk; ?>" data-namabrg ="<?php echo $b->nama_barang; ?>"  data-hargadus ="<?php echo $b->harga_dus; ?>" data-hargapack ="<?php echo $b->harga_pack; ?>" data-hargapcs ="<?php echo $b->harga_pcs; ?>" data-isipcsdus="<?php echo $b->isipcsdus; ?>" data-isipcspack="<?php echo $b->isipcs; ?>" class="btn bg-red  btn-xs waves-effect pilibarang">Pilih</a>
        </td>
    </tr>

    <?php $no++; } ?>
    </tbody>
</table>
<script type="text/javascript">
    
    $(function(){

         

            $('.pilibarang').click(function(e){
                e.preventDefault();
                var kodeproduk  = $(this).attr("data-kodebrg");
                var kodecabang  = $(this).attr("data-kodecabang");
                $.ajax({

                    type    : 'POST',
                    url     : '<?php echo base_url(); ?>oman/cek_stokgudangcabang',
                    data    : {kodeproduk:kodeproduk,kodecabang:kodecabang},
                    cache   : false,
                    success : function(respond){
                        console.log(respond);
                        $("#loadStok").load("<?php echo base_url();?>repackreject/view_detailstok/"+respond+"/"+kodeproduk);
                        $("#stok").val(respond);
                        
                    }

                });
                $("#kodebarang").val($(this).attr("data-kodebrg"));
                $("#barang").val($(this).attr("data-namabrg"));
                $("#hargadus").val($(this).attr("data-hargadus"));
                $("#hargapack").val($(this).attr("data-hargapack"));
                $("#hargapcs").val($(this).attr("data-hargapcs"));
                $("#isipcsdus").val($(this).attr("data-isipcsdus"));
                $("#isipcspack").val($(this).attr("data-isipcspack"));
                $("#databarang").modal("hide");
                var hargapack =  $("#hargapack").val();

                if(hargapack == 0){

                    $("#pack").hide();
                }else{
                    $("#pack").show();
                }

              

            });



    });

    $('.js-exportable').DataTable({

         bLengthChange: false,
    });

</script>