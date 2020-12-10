<?php
$no = 1;
foreach ($detail as $d) {
?>
  <tr>
    <td style="width: 15%;"><?php echo $d->kode_akun; ?></td>
    <td><?php echo $d->nama_akun; ?></td>
    <td colspan="2"><?php echo $d->keterangan; ?></td>
    <td style="width: 15%;text-align:right"><?php echo number_format($d->debet); ?></td>
    <td style="width: 15%;text-align:right"><?php echo number_format($d->kredit); ?></td>
    <td style="width: 5%;text-align:right">
      <a href="#" data-akun="<?php echo $d->kode_akun; ?>" class="btn btn-danger btn-sm hapus">Hapus</a>
      <a href="#" data-akun="<?php echo $d->kode_akun; ?>" data-jenis_jurnal="<?php echo $d->jenis_jurnal; ?>" data-keterangan="<?php echo $d->keterangan; ?>" data-kredit="<?php echo $d->kredit; ?>" data-debet="<?php echo $d->debet; ?>" class="btn btn-warning btn-sm edit">Edit</a>
    </td>
  </tr>
<?php $no++;
} ?>

<script type="text/javascript">
  $(function() {


    function tampiltemp() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_jurnal_umum_temp',
        data: '',
        cache: false,
        success: function(html) {

          $("#loadjurnalumum").html(html);

        }
      });
    }


    $(".hapus").click(function(e) {
      var kode_akun = $(this).attr("data-akun");
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/hapus_jurnal_umum_temp',
        data: {
          kode_akun: kode_akun
        },
        cache: false,
        success: function(respond) {

          tampiltemp();

          $('#jumlah').val("");
          $('#keterangan').val("");
          $('#jenis_jurnal').val("");
          var $select = $('#kode_akun').selectize();
          var control = $select[0].selectize;
          control.clear();
          $("#kode_akun")[0].selectize.destroy();
          $('#kode_akun').val("");
        }
      });
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var akun = $(this).attr("data-akun");
      var kredit = $(this).attr("data-kredit");
      var debet = $(this).attr("data-debet");
      var keterangan = $(this).attr("data-keterangan");
      var jenis_jurnal = $(this).attr("data-jenis_jurnal");
      if (kredit != "0") {
        $('#jumlah').val(formatRupiah(kredit));
      } else {
        $('#jumlah').val(formatRupiah(debet));
      }
      $('#kode_edit').val(1);
      // $("#kode_akun")[0].selectize.destroy();
      $('#kode_akun').val(akun);
      $('#keterangan').val(keterangan);
      $('#jenis_jurnal').val(jenis_jurnal);
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