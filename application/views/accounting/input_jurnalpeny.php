<input type="hidden" value="<?php echo $kodeakun; ?>" name="kodeakun" id="kodeakun">
<div class="form-group mb-3">
  <div class="input-icon">
    <input type="text" value="<?php echo date('Y-m-d'); ?>" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal" data-error=".errorTxt19" />
  </div>
</div>
<div class="form-group mb-3">
  <div class="input-icon">
    <input class="form-control" type="text" id="keterangan" placeholder="Keterangan">
  </div>
</div>
<div class="form-group mb-3">
  <div class="input-icon">
    <input class="form-control" type="text" id="jumlah" placeholder="Jumlah" style="text-align:right">
  </div>
</div>
<div class="form-group mb-3">
  <select name="debetkredit" id="debetkredit" class="form-select">
    <option value="">Debet/Kredit</option>
    <option value="D">Debet</option>
    <option value="K">Kredit</option>
  </select>
</div>
<div class="form-group mb-3">
  <div class="input-icon">
    <a class="btn btn-primary btn-block" id="inputpeny" style="color:white">Tambah</a>
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

    $("#inputpeny").click(function(e) {
      e.preventDefault();
      var tahun = $('#tahun').val();
      var bulan = $('#bulan').val();
      var tanggal = $('#tanggal').val();
      var keterangan = $("#keterangan").val();
      var debetkredit = $('#debetkredit').val();
      var jumlah = $('#jumlah').val();
      var kode_akun = $('#kodeakun').val();

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
          url: '<?php echo base_url(); ?>accounting/insert_penyesuaian',
          data: {
            bulan: bulan,
            tahun: tahun,
            tanggal: tanggal,
            keterangan: keterangan,
            debetkredit: debetkredit,
            jumlah: jumlah,
            kode_akun: kode_akun
          },
          cache: false,
          success: function(respond) {
            $("#inputpenyesuaian").modal("hide");
            loadPenyesuaian();
            // $("#loadledger").html(respond);
          }
        });

      }
    });

  });
</script>