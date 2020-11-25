<?php
$no = 1;
$grandtotal = 0;
foreach ($kb as $d) {
  $grandtotal = $grandtotal + $d->jmlbayar;
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->nobukti_pembelian; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td align="right"><?php echo number_format($d->jmlbayar, '2', ',', '.'); ?></td>
    <td align="center"><a href="#" data-nobukti="<?php echo $d->nobukti_pembelian; ?>" data-idadmin="<?php echo $d->id_admin; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a></td>
  </tr>
<?php $no++;
} ?>
<tr>
  <td colspan="3"><b>TOTAL</b></td>
  <td align="right">
    <b><?php echo number_format($grandtotal, '2', ',', '.'); ?></b>
    <input type="hidden" id="grandtot" name="grandtot" value="<?php echo number_format($grandtotal, '2', ',', '.'); ?>">
  </td>
  <td></td>
</tr>
<script type="text/javascript">
  $(function() {

    function loadgrandtotal() {
      var grandtot = $("#grandtot").val();
      $("#grandtotal").text(grandtot);
    }

    function loadkontrabon() {
      var supplier = $("#kodesupplier").val();
      $("#loadkontrabon").load('<?php echo base_url(); ?>pembelian/view_detailkontrabon_temp/' + supplier);
    }

    loadgrandtotal();

    $(".hapus").click(function(e) {
      var nobukti = $(this).attr("data-nobukti");
      var id_admin = $(this).attr("data-idadmin");

      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/hapus_detailkontrabon_temp',
        data: {
          nobukti: nobukti,
          idadmin: id_admin
        },
        cache: false,
        success: function(respond) {
          loadkontrabon();
        }
      });
    });
  });
</script>