<?php
$total = 0;
foreach ($detailtemp as $d) {
  if ($d->status_dk == 'K') {
    $penerimaan   = $d->jumlah;
    $pengeluaran  = "";
  } else {
    $penerimaan   = "";
    $pengeluaran  = $d->jumlah;
  }

  $total = $total + $pengeluaran;
?>
  <tr>
    <td><?php echo $d->keterangan; ?></td>
    <td><?php echo $d->kode_akun . " " . $d->nama_akun; ?></td>
    <td align="right"><?php if (!empty($pengeluaran)) {
                        echo number_format($pengeluaran, '0', '', '.');
                      } ?></td>
    <td align="right"><a href="#" data-id="<?php echo $d->id_detailkaskeciltemp; ?>" class="btn btn-danger btn-sm"><i class="material-icons">delete</i></a></td>
  </tr>
<?php } ?>
<tr>
  <td colspan="2"><b>TOTAL</b></td>
  <td align="right"><b><?php if (!empty($total)) {
                          echo number_format($total, '0', '', '.');
                        } ?></b></td>
  <td></td>
</tr>
<tr>
  <td colspan="4"><b>TERBILANG : <i><?php if (!empty($total)) {
                                      echo strtoupper(terbilang($total));
                                    } ?></i></b></td>
</tr>
<script type="text/javascript">
  $(function() {
    function loaddetailkaskeciltemp() {
      $("#loaddetailkaskeciltemp").load('<?php echo base_url(); ?>kaskecil/view_detailkaskeciltemp');
    }

    function cekdetailtmp() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/cek_detailtmp',
        cache: false,
        success: function(respond) {
          console.log(respond);
          $("#cekdetailtmp").val(respond);
        }
      });
    }
    $('.hapus').click(function() {
      var id = $(this).attr('data-id');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/hapus_detailkaskeciltemp',
        data: {
          id: id
        },
        cache: false,
        success: function(respond) {
          loaddetailkaskeciltemp();
          cekdetailtmp();
        }
      });
    });
  });
</script>