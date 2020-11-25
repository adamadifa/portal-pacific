<table class="table table-bordered table-striped table-hover dataTable" id="tabelbarang">
    <thead class="thead-dark">
        <tr>
            <th width="10px">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Harga/Dus</th>
            <th>Harga/Pack</th>
            <th>Harga/Pcs</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php

        error_reporting(0);
        $no = 1;
        foreach ($barang as $b) {

            $jmldus     = floor($b->stok / $b->isipcsdus);
            $sisadus    = $b->stok % $b->isipcsdus;

            if ($b->isipack == 0) {
                $jmlpack    = 0;
                $sisapack   = $sisadus;
            } else {

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
                <td align="right"><?php echo number_format($b->harga_dus, '0', '', '.'); ?></td>
                <td align="right"><?php echo number_format($b->harga_pack, '0', '', '.'); ?></td>
                <td align="right"><?php echo number_format($b->harga_pcs, '0', '', '.'); ?></td>

                <td>
                    <a href="#" data-kodecabang="<?php echo $b->kode_cabang; ?>" data-kodeproduk="<?php echo $b->kode_produk; ?>" data-kodebrg="<?php echo $b->kode_barang; ?>" data-namabrg="<?php echo $b->nama_barang; ?>" data-hargadus="<?php echo $b->harga_dus; ?>" data-hargapack="<?php echo $b->harga_pack; ?>" data-hargapcs="<?php echo $b->harga_pcs; ?>" data-stokdus="<?php echo $jmldus; ?>" data-stokpack="<?php echo $jmlpack; ?>" data-stokpcs="<?php echo $jmlpcs; ?>" data-isipcsdus="<?php echo $b->isipcsdus; ?>" data-isipcspack="<?php echo $b->isipcs; ?>" class="btn btn-primary  btn-sm pilibarang">Pilih</a>
                </td>
            </tr>

        <?php $no++;
        } ?>
    </tbody>
</table>
<script type="text/javascript">
    $(function() {



        $('.pilibarang').click(function(e) {
            e.preventDefault();


            var kodeproduk = $(this).attr("data-kodeproduk");
            var kodecabang = $(this).attr("data-kodecabang");
            $.ajax({

                type: 'POST',
                url: '<?php echo base_url(); ?>oman/cek_stokgudangcabang',
                data: {
                    kodeproduk: kodeproduk,
                    kodecabang: kodecabang
                },
                cache: false,
                success: function(respond) {
                    console.log(respond);

                    $("#stok").val(respond);

                }

            });
            $("#kodebarang").val($(this).attr("data-kodebrg"));
            $("#barang").val($(this).attr("data-namabrg"));
            $("#hargadus").val($(this).attr("data-hargadus"));
            $("#hargapack").val($(this).attr("data-hargapack"));
            $("#hargapcs").val($(this).attr("data-hargapcs"));
            $("#stokdus").val($(this).attr("data-stokdus"));
            $("#stokpack").val($(this).attr("data-stokpack"));
            $("#stokpcs").val($(this).attr("data-stokpcs"));
            //$("#stok").val($(this).attr("data-stok"));
            $("#isipcsdus").val($(this).attr("data-isipcsdus"));
            $("#isipcspack").val($(this).attr("data-isipcspack"));

            $("#databarang").modal("hide");
            var hargapack = $("#hargapack").val();

            if (hargapack == 0) {

                $("#pack").hide();
            } else {
                $("#pack").show();
            }



        });



    });

    $('#tabelbarang').DataTable({

        bLengthChange: false,
    });
</script>