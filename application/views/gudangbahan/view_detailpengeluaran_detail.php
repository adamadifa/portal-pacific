<?php
$no = 1;
foreach ($data->result() as $d) {
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td><?php echo number_format($d->qty_unit); ?></td>
    <td><?php echo number_format($d->qty_berat, 2); ?></td>
    <td><?php echo number_format($d->qty_lebih, 2); ?></td>
    <td align="left"><a href="#" data-nobukti="<?php echo $d->nobukti_pengeluaran; ?>" data-kodebarang="<?php echo $d->kode_barang; ?>" data-ket="<?php echo $d->keterangan; ?>" class="btn btn-danger btn-sm hapus">Hapus</a> <a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-ket="<?php echo $d->keterangan; ?>" data-jenis="<?php echo $d->jenis_barang; ?>" data-lebih="<?php echo $d->qty_lebih; ?>" data-berat="<?php echo $d->qty_berat; ?>" data-unit="<?php echo $d->qty_unit; ?>" class="btn btn-warning btn-sm edit">Edit</a></td>
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

    function tampildetail() {

      var nobukti = $('#nobukti').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudangbahan/view_detailpengeluaran_detail',
        data: {
          nobukti: nobukti,
        },
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
      var nobukti = $(this).attr("data-nobukti");
      var ket = $(this).attr("data-ket");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudangbahan/hapus_detailpengeluaran_detail',
        data: {
          nobukti: nobukti,
          kodebarang: kodebarang,
          ket: ket
        },
        cache: false,
        success: function(respond) {

          tampildetail();

        }
      });
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var kodebarang = $(this).attr("data-kodebarang");
      var unit = $(this).attr("data-unit");
      var berat = $(this).attr("data-berat");
      var lebih = $(this).attr("data-lebih");
      var nama = $(this).attr("data-nama");
      var jenis = $(this).attr("data-jenis");
      var ket = $(this).attr("data-ket");
      $('#kodebarang').val(kodebarang);
      $('#qty_unit').val(unit);
      $('#qty_berat').val(berat);
      $('#qty_lebih').val(lebih);
      $('#keterangan').val(ket);
      $('#jenisbarang').val(jenis);
      $('#barang').val(nama);
      $('#kode_edit').val(1);
    });


  });
</script>