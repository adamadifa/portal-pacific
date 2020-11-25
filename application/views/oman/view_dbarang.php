<table class="table table-bordered table-striped table-hover dataTable js-exportable" id="tabelbarang" font-size:12px">
    <thead>
        <tr>
            <th width="10px">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no =1;
            foreach($produk as $p){
        ?>

            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $p->kode_produk; ?></td>
                <td><?php echo $p->nama_barang; ?></td>
                <td>
                    <a href="#" data-kodebrg="<?php echo $p->kode_produk; ?>" data-namabrg ="<?php echo $p->nama_barang; ?>" class="btn bg-red  btn-xs waves-effect pilibarang">Pilih</a>
                 </td>
            </tr>

        <?php
            }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    
    $(function(){

          

            $('.pilibarang').click(function(e){
                
                e.preventDefault();

                $("#kodeproduk").val($(this).attr("data-kodebrg"));
                $("#produk").val($(this).attr("data-namabrg"));
                $("#dbarang").modal("hide");
                

              

            });



    });

    $('.js-exportable').DataTable({

         bLengthChange: false,
    });

</script>