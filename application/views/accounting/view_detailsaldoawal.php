<?php
$no = 1;
foreach ($detail as $d) {
?>
  <tr>
    <td style="width: 15%;"><?php echo $d->kode_saldoawal_bb; ?></td>
    <td style="width: 15%;"><?php echo $d->kode_akun; ?></td>
    <td><?php echo $d->nama_akun; ?></td>
    <td style="width: 15%;text-align:right" colspan="2"><?php echo number_format($d->jumlah); ?></td>
    <td style="width: 5%;text-align:right">
      <a href="#" data-kode="<?php echo $d->kode_saldoawal_bb; ?>" data-akun="<?php echo $d->kode_akun; ?>" class="btn btn-danger btn-sm hapus">Hapus</a>
      <a href="#" data-kode="<?php echo $d->kode_saldoawal_bb; ?>" data-akun="<?php echo $d->kode_akun; ?>" data-jumlah="<?php echo $d->jumlah; ?>" class="btn btn-warning btn-sm edit">Edit</a>
    </td>
  </tr>
<?php $no++;
} ?>

<script type="text/javascript">
  $(function() {

    function tampiltemp() {
      var kode_saldoawal = $("#kode_saldoawal").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_detailsaldoawal',
        data: {
          kode_saldoawal: kode_saldoawal
        },
        cache: false,
        success: function(html) {

          $("#loaddetailsaldoawal").html(html);

          $('#jumlah').val("");
          $('#kode_edit').val(0);
          var $select = $('#kode_akun').selectize();
          var control = $select[0].selectize;
          control.clear();
        }

      });
    }

    $(".hapus").click(function(e) {
      var kode_saldoawal = $(this).attr("data-kode");
      var kode_akun = $(this).attr("data-akun");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/hapus_detailsaldoawal',
        data: {
          kode_saldoawal: kode_saldoawal,
          kode_akun: kode_akun
        },
        cache: false,
        success: function(respond) {

          tampiltemp();

        }
      });
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var akun = $(this).attr("data-akun");
      var jumlah = $(this).attr("data-jumlah");
      $('#jumlah').val(formatRupiah(jumlah));
      $('#kode_edit').val(1);
      // $("#kode_akun")[0].selectize.destroy();
      $('#kode_akun').val(akun);
      $('#kode_akun').selectize();
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }

  });
</script>