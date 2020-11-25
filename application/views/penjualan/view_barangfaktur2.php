<?php

$no = 1;
foreach ($barang as $d) {


?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->kategori; ?></td>
        <td><?php echo $d->satuan; ?></td>

        <?php if ($jenisretur == "pf") { ?>
            <td align="center"><?php echo number_format($d->harga_returdus, '0', '', '.'); ?></td>
            <td align="center"><?php echo number_format($d->harga_returpack, '0', '', '.'); ?></td>
            <td align="center"><?php echo number_format($d->harga_returpcs, '0', '', '.'); ?></td>
            <td>
                <a href="#" data-kodebrg="<?php echo $d->kode_barang; ?>" data-namabrg="<?php echo $d->nama_barang; ?>" data-hargadus="<?php echo $d->harga_returdus; ?>" data-hargapack="<?php echo $d->harga_returpack; ?>" data-hargapcs="<?php echo $d->harga_returpcs; ?>" class="btn btn-primary  btn-sm  pilibarang">Pilih</a>
            </td>
        <?php } else { ?>
            <td align="center"><?php echo number_format($d->harga_dus, '0', '', '.'); ?></td>
            <td align="center"><?php echo number_format($d->harga_pack, '0', '', '.'); ?></td>
            <td align="center"><?php echo number_format($d->harga_pcs, '0', '', '.'); ?></td>
            <td>
                <a href="#" data-kodebrg="<?php echo $d->kode_barang; ?>" data-namabrg="<?php echo $d->nama_barang; ?>" data-hargadus="<?php echo $d->harga_dus; ?>" data-hargapack="<?php echo $d->harga_pack; ?>" data-hargapcs="<?php echo $d->harga_pcs; ?>" class="btn btn-primary  btn-sm  pilibarang">Pilih</a>
            </td>

        <?php } ?>
    </tr>
<?php $no++;
} ?>




<script type="text/javascript">
    $(function() {



        $('.pilibarang').click(function(e) {
            e.preventDefault();

            if ($(this).attr("data-promo") == 1) {
                swal("Oops!", "Barang Promo Tidak Dapat Di Retur !", "warning");
            } else {

                $("#kodebarang").val($(this).attr("data-kodebrg"));
                $("#barang").val($(this).attr("data-namabrg"));
                $("#hargadus").val($(this).attr("data-hargadus"));
                $("#hargapack").val($(this).attr("data-hargapack"));
                $("#hargapcs").val($(this).attr("data-hargapcs"));
                $("#stokdus").val($(this).attr("data-stokdus"));
                $("#stokpack").val($(this).attr("data-stokpack"));
                $("#stokpcs").val($(this).attr("data-stokpcs"));
                $("#stok").val($(this).attr("data-stok"));
                $("#isipcsdus").val($(this).attr("data-isipcsdus"));
                $("#isipcspack").val($(this).attr("data-isipcspack"));

                $("#databarang").modal("hide");

                var hargapack = $("#hargapack").val();

                if (hargapack == 0) {

                    $("#pack").hide();
                } else {
                    $("#pack").show();
                }
            }



        });



    });
</script>