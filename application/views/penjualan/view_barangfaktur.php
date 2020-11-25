<?php
$no = 1;
foreach ($barang as $d) {

    $cekretur   = $this->db->query("SELECT sum(jumlah) as jumlah from detailretur 
                  INNER JOIN penjualan ON detailretur.no_fak_penj = penjualan.no_fak_penj
                  WHERE kode_pelanggan = '$d->kode_pelanggan' AND kode_barang = '$d->kode_barang' GROUP BY kode_barang");
    $retur      = $cekretur->row_array();
    $jmlretur   = $retur['jumlah'];
    $stok       = $jmlretur;
    $jmldus     = floor(($d->jumlah - $jmlretur) / $d->isipcsdus);
    $sisadus    = ($d->jumlah - $jmlretur)  % $d->isipcsdus;

    if ($d->isipack == 0) {
        $jmlpack    = 0;
        $sisapack   = $sisadus;
    } else {

        $jmlpack    = floor($sisadus / $d->isipcs);
        $sisapack   = $sisadus % $d->isipcs;
    }

    $jmlpcs = $sisapack;
    $stok   = ($d->jumlah - $jmlretur);
?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $d->kode_barang; ?></td>
        <td><?php echo $d->nama_barang; ?></td>
        <td><?php echo $d->kategori; ?></td>
        <td><?php echo $d->satuan; ?></td>
        <td align="center"><?php echo $jmldus; ?></td>

        <td align="center"><?php echo $jmlpack; ?></td>

        <td align="center"><?php echo $jmlpcs; ?></td>
        <?php if ($jenisretur == "pf") { ?>
            <td>
                <a href="#" data-kodebrg="<?php echo $d->kode_barang; ?>" data-namabrg="<?php echo $d->nama_barang; ?>" data-hargadus="<?php echo $d->harga_returdus; ?>" data-hargapack="<?php echo $d->harga_returpack; ?>" data-hargapcs="<?php echo $d->harga_returpcs; ?>" data-stokdus="<?php echo $jmldus; ?>" data-stokpack="<?php echo $jmlpack; ?>" data-stokpcs="<?php echo $jmlpcs; ?>" data-stok="<?php echo $stok; ?>" data-isipcsdus="<?php echo $d->isipcsdus; ?>" data-isipcspack="<?php echo $d->isipcs; ?>" data-promo="<?php echo $d->promo; ?>" class="btn btn-primary  btn-sm pilibarang">Pilih</a>
            </td>
        <?php } else { ?>
            <td>
                <a href="#" data-kodebrg="<?php echo $d->kode_barang; ?>" data-namabrg="<?php echo $d->nama_barang; ?>" data-hargadus="<?php echo $d->harga_dus; ?>" data-hargapack="<?php echo $d->harga_pack; ?>" data-hargapcs="<?php echo $d->harga_pcs; ?>" data-stokdus="<?php echo $jmldus; ?>" data-stokpack="<?php echo $jmlpack; ?>" data-stokpcs="<?php echo $jmlpcs; ?>" data-stok="<?php echo $stok; ?>" data-isipcsdus="<?php echo $d->isipcsdus; ?>" data-isipcspack="<?php echo $d->isipcs; ?>" data-promo="<?php echo $d->promo; ?>" class="btn btn-primary  btn-sm pilibarang">Pilih</a>
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