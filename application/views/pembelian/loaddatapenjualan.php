<?php
$no = 1;
$grandtotal = 0;
foreach ($pnj as $d) {
  $total        = $d->harga * $d->qty;
  $grandtotal   = $grandtotal + $total;
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->ket_penjualan; ?></td>
    <td><?php echo $d->kode_akun; ?></td>
    <td><?php echo $d->qty; ?></td>
    <td align="right"><?php echo number_format($d->harga, '0', '', '.'); ?></td>
    <td align="right"><?php echo number_format($total, '0', '', '.'); ?></td>
    <td align="center"><a href="#" data-nobukti="<?php echo $d->nobukti_pembelian; ?>" data-kodebarang="<?php echo $d->kode_barang; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a></td>
  </tr>
<?php $no++;
} ?>
<tr>
  <td colspan="5"><b>TOTAL</b></td>
  <td align="right">
    <b><?php echo number_format($grandtotal, '0', '', '.'); ?></b>
    <input type="hidden" id="grandtotpenj" name="grandtotpenj" value="<?php echo number_format($grandtotal, '0', '', '.'); ?>">
  </td>
  <td></td>
</tr>
<script type="text/javascript">
  $(function() {

    // function loadgrandtotal()
    // {
    //   var grandtot = $("#grandtot").val();
    //   $("#grandtotal").text(grandtot);
    // }
    //  loadgrandtotal();
    function loaddatapenjualan() {
      var nobukti = $("#nobukti").val();

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/loaddatapenjualan',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#loaddatapenjualan").html(respond);
        }
      });
    }
    $(".hapus").click(function(e) {
      var nobukti = $(this).attr("data-nobukti");
      var kodebarang = $(this).attr("data-kodebarang");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/hapus_detailpenjpmb',
        data: {
          nobukti: nobukti,
          kodebarang: kodebarang
        },
        cache: false,
        success: function(respond) {
          loaddatapenjualan();
        }
      });
    });
  });
</script>