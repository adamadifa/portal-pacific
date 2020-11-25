<table class="table table-striped table-hover dataTable js-exportable" id="tabelbarang">
  <thead class="thead-dark">
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
          <a href="#" data-kodebrg="<?php echo $p->kode_produk; ?>" data-namabrg="<?php echo $p->nama_barang; ?>" class="btn btn-sm btn-danger pilibarang">Pilih</a>
        </td>
      </tr>

    <?php
      $no++;
    }
    ?>
  </tbody>
</table>
<script type="text/javascript">
  $(function() {
    $('.pilibarang').click(function(e) {
      e.preventDefault();
      var kodeproduk = $(this).attr("data-kodebrg");
      var nama_barang = $(this).attr("data-namabrg");
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>oman/cek_stokgudang',
        data: {
          kodeproduk: kodeproduk
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          $("#kodebarang").val(kodeproduk);
          $("#barang").val(nama_barang);
          $("#stok").val(respond);
          $("#databarang").modal("hide");
        }
      });








    });



  });

  $('.js-exportable').DataTable({
    bLengthChange: false,
  });
</script>