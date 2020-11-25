<?php
$no = 1;
foreach ($saldosalestemp as $d) {
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->nama_karyawan; ?></td>
    <td><?php echo number_format($d->jumlah, '0', '', '.'); ?></td>
    <td>
      <a href="#" class="btn btn-danger btn-sm hapus" data-id="<?php echo $d->id; ?>"><i class="fa fa-trash-o"></i></a>
    </td>
  </tr>
<?php
  $no++;
}
?>

<script>
  $(function() {

    function loadsalestemp() {
      var bulan = $("#bulan2").val();
      var cabang = $("#cabanginput").val();
      var tahun = $("#tahun2").val();

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/getsaldosalestemp',
        data: {
          bulan: bulan,
          tahun: tahun,
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $("#loadsalestemp").html(respond);
        }
      });
    }
    $('.hapus').click(function(e) {
      e.preventDefault();
      var id = $(this).attr("data-id");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/hapussaldosalestemp',
        data: {
          id: id
        },
        cache: false,
        success: function(respond) {
          loadsalestemp();
        }
      });
    })

  });
</script>