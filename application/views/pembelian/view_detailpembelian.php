<?php
$no = 1;
$grandtotal = 0;
foreach ($detailpmb as $d) {
  $total        = (($d->qty * $d->harga) + $d->penyesuaian);
  $grandtotal   = $grandtotal + $total;
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td><?php echo $d->qty; ?></td>
    <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
    <td align="right"><?php echo number_format($d->harga * $d->qty, '2', ',', '.'); ?></td>
    <td align="right"><?php echo number_format($d->penyesuaian, '2', ',', '.'); ?></td>
    <td align="right"><?php echo number_format($total, '2', ',', '.'); ?></td>
    <td><?php echo $d->kode_akun; ?></td>
    <td align="center">
      <a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-nobukti="<?php echo $d->nobukti_pembelian; ?>" data-keterangan="<?php echo $d->keterangan; ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
      <a href="#" data-kodebarang="<?php echo $d->kode_barang; ?>" data-nobukti="<?php echo $d->nobukti_pembelian; ?>" data-keterangan="<?php echo $d->keterangan; ?>" data-kodecr="<?php echo $d->kode_cr; ?>" class="btn btn-red btn-sm hapusdetailpmb"><i class="fa fa-trash-o"></i></a>
    </td>
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
    function cektutuplaporan() {
      var tgltransaksi = $("#tgl_pembelian").val();
      var jenis = 'pembelian';
      if (tgltransaksi != "") {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>setting/cektutuplaporan',
          data: {
            tanggal: tgltransaksi,
            jenis: jenis
          },
          cache: false,
          success: function(respond) {
            console.log(respond);
            var status = respond;
            if (status != 0) {
              $(".edit").hide();
              $(".hapus").hide();
            }
          }
        });
      }
    }
    cektutuplaporan();

    function loadgrandtotal() {
      var grandtot = $("#grandtot").val();
      $("#grandtotal").text(grandtot);
      $("#grandtotnew").val(grandtot);
    }

    function loadpembelianbarang() {
      var nobukti = $("#nobukti").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/view_detailpembelian',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailpmb").html(respond);
        }
      });
    }

    loadgrandtotal();

    $(".hapusdetailpmb").click(function(e) {

      var kodebarang = $(this).attr("data-kodebarang");
      var nobukti = $(this).attr("data-nobukti");
      var keterangan = $(this).attr("data-keterangan");
      var kodecr = $(this).attr("data-kodecr");
      //alert(keterangan);
      // alert(kodecr);
      // return false;
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/hapus_detailpembelian',
        data: {
          kodebarang: kodebarang,
          nobukti: nobukti,
          keterangan: keterangan,
          kodecr: kodecr
        },
        cache: false,
        success: function(respond) {
          loadpembelianbarang();
        }
      });
    });


    $(".edit").click(function(e) {
      e.preventDefault();
      var nobukti = $(this).attr("data-nobukti");
      var kodebarang = $(this).attr("data-kodebarang");
      var keterangan = $(this).attr("data-keterangan");
      var tglpembelian = $("#tgl_pembelian").val();
      //alert(tglpembelian);
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/editbarang',
        data: {
          nobukti: nobukti,
          kodebarang: kodebarang,
          keterangan: keterangan,
          tglpembelian: tglpembelian
        },
        cache: false,
        success: function(respond) {
          $("#loadeditdatabarang").html(respond);
          $("#editdatabarang").modal("show");
        }
      });
    });
  });
</script>