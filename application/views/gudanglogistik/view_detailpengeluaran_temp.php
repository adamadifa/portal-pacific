<?php
$no = 1;
foreach ($data->result() as $d) {
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td><?php echo $d->qty; ?></td>
    <td align="right"><a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-idadmin="<?php echo $d->id_admin; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a></td>
  </tr>
<?php $no++;
} ?>
<script type="text/javascript">
  $(function() {

    function loadgrandtotal() {

      var grandtot = $("#grandtot").val();
      $("#grandtotal").text(grandtot);
      $("#cekdata").val(grandtot);

    }

    loadgrandtotal();

    function tampiltemp() {

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudanglogistik/view_detailpengeluaran_temp',
        data: '',
        cache: false,
        success: function(html) {

          $("#loadpengeluaranbarang").html(html);

          $('#barang').val("");
          $('#kodeakun').val("");
          $('#kodebarang').val("");
          $('#namaakun').val("");
          $('#jumlah').val("");
          $('#harga').val("");
          $('#keterangan').val("");
          $('#jenisbarang').val("");

        }

      });
    }

    $(".hapus").click(function(e) {
      var kodebarang = $(this).attr("data-kodebarang");
      var id_admin = $(this).attr("data-idadmin");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudanglogistik/hapus_detailpengeluaran_temp',
        data: {
          kodebarang: kodebarang,
          idadmin: id_admin
        },
        cache: false,
        success: function(respond) {

          tampiltemp();

        }
      });
    });

  });
</script>