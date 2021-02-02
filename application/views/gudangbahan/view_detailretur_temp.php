<?php
$no = 1;
$grandtotal = 0;
foreach ($data->result() as $d) {
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td><?php echo number_format($d->qty, 2); ?></td>
    <td align="left">
      <a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-ket="<?php echo $d->keterangan; ?>" data-idadmin="<?php echo $d->id_admin; ?>" class="btn btn-danger btn-sm hapus">Hapus</a> 
      <a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-ket="<?php echo $d->keterangan; ?>" data-jenis="<?php echo $d->jenis_barang; ?>" data-qty="<?php echo $d->qty; ?>" class="btn btn-warning btn-sm edit">Edit</a>
    </td>
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
        url: '<?php echo base_url(); ?>gudangbahan/view_detailretur_temp',
        data: '',
        cache: false,
        success: function(html) {

          $("#loadreturbarang").html(html);

          $('#barang').val("");
          $('#kodeakun').val("");
          $('#kodebarang').val("");
          $('#namaakun').val("");
          $('#jumlah').val("");
          $('#qty').val("");
          $('#keterangan').val("");
          $('#jenisbarang').val("");
          $('#kode_edit').val("");

        }

      });
    }

    $(".hapus").click(function(e) {
      var kodebarang = $(this).attr("data-kodebarang");
      var id_admin = $(this).attr("data-idadmin");
      var ket = $(this).attr("data-ket");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudangbahan/hapus_detailretur_temp',
        data: {
          kodebarang: kodebarang,
          ket: ket,
          idadmin: id_admin
        },
        cache: false,
        success: function(respond) {

          tampiltemp();

        }
      });
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var kodebarang = $(this).attr("data-kodebarang");
      var qty = $(this).attr("data-qty");
      var nama = $(this).attr("data-nama");
      var jenis = $(this).attr("data-jenis");
      var ket = $(this).attr("data-ket");
      $('#kodebarang').val(kodebarang);
      $('#qty').val(qty);
      $('#keterangan').val(ket);
      $('#jenisbarang').val(jenis);
      $('#barang').val(nama);
      $('#kode_edit').val(1);
    });

  });
</script>