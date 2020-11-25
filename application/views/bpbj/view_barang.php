<table class="table table-striped table-hover" id="tabelbarang">
  <thead class="thead-dark">
    <tr>
      <th>No</th>
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
          <a href="#" data-kodebrg="<?php echo $p->kode_produk; ?>" data-namabrg="<?php echo $p->nama_barang; ?>" class="btn btn-danger  btn-sm  pilibarang">Pilih</a>
        </td>
      </tr>

    <?php
    }
    ?>
  </tbody>
</table>
<script type="text/javascript">
  $(function() {

    function loadBpbj() {
      var kode_produk = $("#kodebarang").val();
      $("#loadbpbj").load('<?php echo base_url(); ?>bpbj/view_detailbpbj_temp/' + kode_produk);
    }

    $('.pilibarang').click(function(e) {

      e.preventDefault();
      var tgl_bpbj = $("#tgl_bpbj").val();
      var kode_produk = $(this).attr("data-kodebrg");
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>bpbj/buat_nomor_bpbj',
        data: {
          tgl_bpbj: tgl_bpbj,
          kode_produk: kode_produk
        },
        cache: false,
        success: function(respond) {

          console.log(respond);
          $("#no_bpbj").val(respond);
          loadBpbj();
        }

      });

      $("#kodebarang").val($(this).attr("data-kodebrg"));
      $("#barang").val($(this).attr("data-namabrg"));
      $("#databarang").modal("hide");




    });



  });

  $('#tabelbarang').DataTable({

    bLengthChange: false,
  });
</script>