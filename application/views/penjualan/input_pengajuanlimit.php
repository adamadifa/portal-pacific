<form autocomplete="off" class="limitForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/insertpengajuanlimit">
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Tanggal</label>
      <div class="input-icon">
        <input type="date" id="tgl_pengajuan" name="tgl_pengajuan" class="form-control" placeholder="Ex: 2018-07-16" />
        <span class="input-icon-addon">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" />
            <rect x="4" y="5" width="16" height="16" rx="2" />
            <line x1="16" y1="3" x2="16" y2="7" />
            <line x1="8" y1="3" x2="8" y2="7" />
            <line x1="4" y1="11" x2="20" y2="11" />
            <line x1="11" y1="15" x2="12" y2="15" />
            <line x1="12" y1="15" x2="12" y2="18" /></svg>
        </span>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <?php if ($cb == 'pusat') { ?>
      <label class="form-label">Cabang</label>
      <div class="form-group">
        <select name="cabang" id="cabang2" class="form-select">
          <option value="">-- Pilih Cabang --</option>
          <?php foreach ($cabang as $c) { ?>
            <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
          <?php } ?>
        </select>
      </div>
    <?php } else { ?>
      <input type="hidden" name="cabang" id="cabang2" value="<?php echo $cb; ?>">
    <?php } ?>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">Salesman</label>
      <div class="form-group">
        <select id="salesman2" name="salesman" class="form-select">
          <option value="">-- Pilih Salesman -- </option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">Pelanggan</label>
      <div class="form-group">
        <select id="pelanggan" name="pelanggan" class="form-select">
          <option value="">-- Pilih Pelanggan -- </option>

        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Jumlah</label>
        <div class="input-icon">
          <input type="text" style="text-align:right" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" />
          <div id="terbilang" style="float:right;"></div>
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="form-label">Jatuh Tempo</label>
      <div class="form-group">
        <select id="jatuhtempo" name="jatuhtempo" class="form-select">
          <option value="">Pilih Jatuh Tempo</option>
          <option value="14">14 Hari</option>
          <option value="30">30 Hari</option>
          <option value="45">45 Hari</option>
        </select>
      </div>
    </div>
  </div>
  <small style="color:red">*) Kosongkan Jika Sudah Melakukan Pengajuan Jatuh Tempo</small>
  <div class="row ">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="simpan" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
      </div>
    </div>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tgl_pengajuan'), {});
</script>
<script type="text/javascript">
  var jumlah = document.getElementById('jumlah');
  jumlah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    jumlah.value = formatRupiah(this.value, '');
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
</script>

<script>
  $(function() {

    $('#pelanggan').selectize({});

    function loadSalesman() {
      var cabang = $("#cabang2").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/get_salesman',
        data: {
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $('#salesman2').selectize()[0].selectize.destroy();
          $("#salesman2").html(respond);
          $('#salesman2').selectize({});

        }
      });
    }
    loadSalesman();
    $("#cabang2").change(function() {
      loadSalesman();
    });

    $("#salesman2").change(function() {
      var salesman = $("#salesman2").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>laporanpenjualan/get_pelanggan",
        data: {
          salesman: salesman
        },
        cache: false,
        success: function(respond) {
          $('#pelanggan').selectize()[0].selectize.destroy();
          $("#pelanggan").html(respond);
          $('#pelanggan').selectize({});
        }
      });
    });

    $("#formValidate").submit(function() {
      var tanggal = $("#tgl_pengajuan").val();
      var cabang = $("#cabang2").val();
      var salesman = $("#salesman2").val();
      var pelanggan = $("#pelanggan").val();

      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        $("#tanggal").focus()
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Masih Kosong!", "warning");
        return false;
      } else if (salesman == "") {
        swal("Oops!", "Salesman Masih Kosong!", "warning");
        return false;
      } else if (pelanggan == "") {
        swal("Oops!", "Pelanggan Masih Kosong!", "warning");
        return false;
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Masih Kosong!", "warning");
        $("#jumlah").focus()
        return false;
      } else {
        return true;
      }
    });
  })
</script>