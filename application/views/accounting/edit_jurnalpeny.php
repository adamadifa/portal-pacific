<input type="hidden" name="kodeakun" id="kodeakun" value="<?php echo $peny['kode_akun']; ?>">
<input type="hidden" name="nobukti" id="nobukti" value="<?php echo $peny['no_bukti']; ?>">
<div class="form-group mb-3">
  <div class="input-icon">
    <input type="text" value="<?php echo $peny['tanggal']; ?>" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal" data-error=".errorTxt19" />
  </div>
</div>
<div class="form-group mb-3">
  <div class="input-icon">
    <input class="form-control" type="text" value="<?php echo $peny['keterangan']; ?>" id="keterangan" placeholder="Keterangan">
  </div>
</div>
<div class="form-group mb-3">
  <div class="input-icon">
    <?php if (!empty($peny['debet'])) {
      $jumlah = $peny['debet'];
    } else {
      $jumlah = $peny['kredit'];
    } ?>
    <input class="form-control" value="<?php echo $jumlah; ?>" type="text" id="jumlah" placeholder="Jumlah" style="text-align:right">
  </div>
</div>
<div class="form-group mb-3">
  <select name="debetkredit" id="debetkredit" class="form-select">
    <option value="">Debet/Kredit</option>
    <option <?php if (!empty($peny['debet'])) {
              echo "selected";
            } ?> value="D">Debet</option>
    <option <?php if (!empty($peny['kredit'])) {
              echo "selected";
            } ?> value="K">Kredit</option>
  </select>
</div>
<div class="form-group mb-3">
  <div class="input-icon">
    <a class="btn btn-primary btn-block" id="updatepeny" style="color:white">Update</a>
  </div>
</div>

<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>

<script>
  $(function() {

    function loadPenyesuaian() {
      var bulan = $('#bulan').val();
      var tahun = $('#tahun').val();
      var kode_akun = $('#kodeakun').val();
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

    $("#updatepeny").click(function(e) {
      e.preventDefault();
      var tanggal = $('#tanggal').val();
      var keterangan = $("#keterangan").val();
      var debetkredit = $('#debetkredit').val();
      var jumlah = $('#jumlah').val();
      var nobukti = $("#nobukti").val();

      if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi", "warning");
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan Harus Diisi", "warning");
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan Harus Diisi", "warning");
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan Harus Diisi", "warning");
      } else if (debetkredit == "") {
        swal("Oops!", "Debet Kredit Harus Diisi", "warning");
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Harus Diisi", "warning");
      } else {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>accounting/update_penyesuaian',
          data: {
            nobukti: nobukti,
            tanggal: tanggal,
            keterangan: keterangan,
            debetkredit: debetkredit,
            jumlah: jumlah,

          },
          cache: false,
          success: function(respond) {
            $("#editpenyesuaian").modal("hide");
            loadPenyesuaian();
            // $("#loadledger").html(respond);
          }
        });

      }
    });


  });
</script>