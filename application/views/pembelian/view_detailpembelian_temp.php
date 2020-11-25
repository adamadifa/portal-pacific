<?php
$no = 1;
$grandtotal = 0;
foreach ($pmb as $d) {
  $total        = ($d->harga * $d->qty) + $d->penyesuaian;
  $grandtotal   = $grandtotal + $total;
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->keterangan . " (Cabang " . $d->kode_cabang . ")"; ?></td>
    <td><?php echo $d->qty; ?></td>
    <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
    <td align="right"><?php echo number_format($d->harga * $d->qty, '2', ',', '.'); ?></td>
    <td align="right"><?php echo number_format($d->penyesuaian, '2', ',', '.'); ?></td>
    <td align="right"><?php echo number_format($total, '2', ',', '.'); ?></td>
    <td><?php echo $d->kode_akun; ?></td>
    <td align="center"><a href="#" data-kodebarang="<?php echo $d->id; ?>" data-idadmin="<?php echo $d->id_admin; ?>" class="btn btn-sm btn-danger text-white hapus"><i class="fa fa-trash-o"></i></a></td>
  </tr>
<?php $no++;
} ?>
<tr>
  <td colspan="8"><b>TOTAL</b></td>
  <td align="right">
    <b><?php echo number_format($grandtotal, '2', ',', '.'); ?></b>
    <input type="hidden" id="grandtot" name="grandtot" value="<?php echo number_format($grandtotal, '2', ',', '.'); ?>">
  </td>
  <td></td>
  <td></td>
</tr>
<script type="text/javascript">
  $(function() {

    function loadgrandtotal() {
      var grandtot = $("#grandtot").val();
      $("#grandtotal").text(grandtot);
    }

    function loadpembelianbarang() {
      var departemen = $("#departemen").val();
      $("#loadpembelianbarang").load('<?php echo base_url(); ?>pembelian/view_detailpembelian_temp/' + departemen);
    }

    loadgrandtotal();

    $(".hapus").click(function(e) {
      var kodebarang = $(this).attr("data-kodebarang");
      var id_admin = $(this).attr("data-idadmin");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/hapus_detailpembelian_temp',
        data: {
          kodebarang: kodebarang,
          idadmin: id_admin
        },
        cache: false,
        success: function(respond) {
          loadpembelianbarang();
        }
      });
    });
  });
</script>