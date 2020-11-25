<?php
$no                = 1;
foreach ($peny as $k) {
?>
  <tr style="font-size:12;background-color: <?php echo $color; ?>;">
    <td><?php echo $no; ?></td>
    <td><?php echo DateToIndo2($k->tanggal); ?></td>
    <td><?php echo $k->no_bukti; ?></td>
    <td><?php echo $k->keterangan; ?></td>
    <td><?php echo "<font color=white>'</font>" . $k->kode_akun; ?></td>
    <!-- <td><?php echo $k->nama_akun; ?></td> -->
    <td align="right"><?php if (!empty($k->debet)) {
                        echo number_format($k->debet, '0', '', '.');
                      } ?></td>
    <td align="right"><?php if (!empty($k->kredit)) {
                        echo number_format($k->kredit, '0', '', '.');
                      } ?></td>
    <td>
      <a href="#" class="btn btn-sm btn-primary edit" data-nobukti="<?php echo $k->no_bukti; ?>"><i class="fa fa-pencil"></i></a>
      <a href="#" class="btn btn-sm btn-danger hapus" data-nobukti="<?php echo $k->no_bukti; ?>"><i class="fa fa-trash-o"></i></a>
    </td>
  </tr>
<?php
  $no++;
}
?>

<script>
  $(function() {
    function loadPenyesuaian() {
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kode_akun').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_penyesuaian',
        data: {
          kode_akun: kode_akun,
          tahun: tahun,
          bulan: bulan
        },
        cache: false,
        success: function(respond) {
          $("#loadpenyesuaian").html(respond);
        }
      });
    }
    $(".edit").click(function(e) {
      e.preventDefault();
      var nobukti = $(this).attr("data-nobukti");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/editpenyesuaian',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#editpenyesuaian").modal("show");
          $("#loadeditpenyesuaian").html(respond);
        }
      });
    });
    $(".hapus").click(function(e) {
      e.preventDefault();
      var nobukti = $(this).attr("data-nobukti");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/hapus_penyesuaian',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          loadPenyesuaian();
        }
      });
    });
  });
</script>