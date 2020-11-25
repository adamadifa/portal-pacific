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
        $no = 1;
        foreach ($produk as $p) {
        ?>

            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $p->kode_produk; ?></td>
                <td><?php echo $p->nama_barang; ?></td>
                <td>
                    <a href="#" data-kodebrg="<?php echo $p->kode_produk; ?>" data-namabrg="<?php echo $p->nama_barang; ?>" class="btn btn-danger btn-sm pilibarang">Pilih</a>
                </td>
            </tr>

        <?php
        }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    $(function() {

        function ladFsthp() {
            var kode_produk = $("#kodebarang").val();
            $("#loadfsthp").load('<?php echo base_url(); ?>fsthp/view_detailfsthp_temp/' + kode_produk);
        }

        $('.pilibarang').click(function(e) {

            e.preventDefault();
            var tgl_fsthp = $("#tgl_fsthp").val();
            var kode_produk = $(this).attr("data-kodebrg");
            $.ajax({

                type: 'POST',
                url: '<?php echo base_url(); ?>fsthp/buat_nomor_fsthp',
                data: {
                    tgl_fsthp: tgl_fsthp,
                    kode_produk: kode_produk
                },
                cache: false,
                success: function(respond) {

                    console.log(respond);
                    $("#no_fsthp").val(respond);
                    ladFsthp();
                }

            });

            $("#kodebarang").val($(this).attr("data-kodebrg"));
            $("#barang").val($(this).attr("data-namabrg"));
            $("#databarang").modal("hide");




        });



    });

    $('.js-exportable').DataTable({

        bLengthChange: false,
    });
</script>