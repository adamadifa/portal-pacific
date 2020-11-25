<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembayaran/editbayartransfer">
  <input type="hidden" name="id_transfer" value="<?php echo $transfer['kode_transfer']; ?>">
  <input type="hidden" name="tgl_transfer" value="<?php echo $transfer['tgl_transfer']; ?>">
  <input type="hidden" name="pelanggan" value="<?php echo $transfer['nama_pelanggan']; ?>">
  <input type="hidden" name="page" value="<?php echo $page; ?>">
  <table class="table">
    <tr>
      <td><b>Nama Pelanggan</b></td>
      <td>:</td>
      <td><?php echo $transfer['nama_pelanggan']; ?></td>
    </tr>
    <tr>
      <td><b>Nama Bank</b></td>
      <td>:</td>
      <td><?php echo $transfer['namabank']; ?></td>
    </tr>

    <tr>
      <td><b>Jumlah</b></td>
      <td>:</td>
      <td><?php echo number_format($transfer['jumlah'], '0', '', '.'); ?></td>
    </tr>
    <tr>
      <td><b>Jatuh Tempo</b></td>
      <td>:</td>
      <td><?php echo DateToIndo2($transfer['tglcair']); ?></td>
    </tr>
  </table>
  <div class="form-group mb-3">
    <select class="form-select" id="status" name="status">
      <option value="">-- Pilih Status --</option>
      <option value="1">Diterima</option>
      <option value="2">Ditolak</option>
      <option value="0">Pending</option>
    </select>
  </div>
  <div id="tanggalcair">
    <div class="form-group mb-3">
      <div class="input-icon">
        <input type="date" id="tglcair" name="tglcair" class="form-control" placeholder="Tanggal Diterima / Cair" />
        <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
  <div id="tanggalditolak">
    <div class="form-group mb-3">
      <div class="input-icon">
        <input type="date" id="tglditolak" name="tglditolak" class="form-control" placeholder="Tanggal Ditolak" />
        <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
  <div class="form-group mb-3" id="bank">
    <select class="form-select" id="bank_penerima" name="bank_penerima">
      <option value="">-- Pilih Bank Penerima--</option>
      <?php foreach ($bank as $b) { ?>
        <option value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
      <?php } ?>
    </select>
  </div>
  <div id="jumlahbayar">
    <div class="form-group mb-3">
      <div class="input-icon">
        <input readonly type="text" value="<?php echo number_format($transfer['jumlah'], '0', '', '.'); ?>" style="text-align:right" id="jmlbayar2" name="jmlbayar2" class="form-control" placeholder="Jumlah Bayar" />
        <input type="hidden" value="<?php echo $transfer['jumlah']; ?>" style="text-align:right" id="jmlbayar" name="jmlbayar" class="form-control" placeholder="Jumlah Bayar" />
        <div id="terbilang" style="float:right;"></div>
        <span class="input-icon-addon">
          <i class="fa fa-money"></i>
        </span>
      </div>
    </div>
  </div>
  <hr>
  <div class="form-group mb-3" id="omsetbulan">
    <label for="" class="form-label">Omset Bulan</label>
    <select required class="form-select" id="bulan" name="bulan">
      <option value="">Omset Bulan</option>
      <?php
      $bulanini = date("m");
      for ($i = 1; $i < count($bulan); $i++) {
      ?>
        <option <?php if ($bulanini == $i) {
                  echo "selected";
                } ?> value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
      <?php
      }
      ?>
    </select>
  </div>
  <div class="form-group mb-3" id="omsettahun">
    <label for="" class="form-label">Omset Tahun</label>
    <select required class="form-select" id="tahun2" name="tahun">
      <?php
      $tahunmulai = 2020;

      for ($thn = $tahunmulai; $thn <= date('Y'); $thn++) {
      ?>
        <option <?php if (date('Y') == $thn) {
                  echo "Selected";
                } ?> value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
      <?php
      }
      ?>
    </select>
  </div>
  <div class="row ">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-send mr-2"></i>SIMPAN</button>
      </div>
    </div>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tglcair'), {});
  flatpickr(document.getElementById('tglditolak'), {});
</script>
<script type="text/javascript">
  $(function() {

    function cektutuplaporan() {
      var tanggal = $("#tglcair").val();
      var jenis = "penjualan";
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>setting/cektutuplaporan',
        data: {
          tanggal: tanggal,
          jenis: jenis
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          var status = respond;
          if (status != 0) {
            swal("Oops!", "Laporan Untuk Periode Ini Sudah Di Tutup !", "warning");
            $("#tglcair").val("");
          }
        }
      });
    }

    function cektutuplaporantolak() {
      var tanggal = $("#tglditolak").val();
      var jenis = "penjualan";
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>setting/cektutuplaporan',
        data: {
          tanggal: tanggal,
          jenis: jenis
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          var status = respond;
          if (status != 0) {
            swal("Oops!", "Laporan Untuk Periode Ini Sudah Di Tutup !", "warning");
            $("#tglcair").val("");
          }
        }
      });
    }

    $("#tglcair").change(function() {
      cektutuplaporan();
    });

    $("#tglditolak").change(function() {
      cektutuplaporantolak();
    });




    function diterima() {

      $("#tanggalcair").show();
      $("#tanggalditolak").hide();
      $("#jumlahbayar").show();
      $("#bank").show();
      $("#omsetbulan").show();
      $("#omsettahun").show();
    }

    function ditolak() {
      $("#tanggalditolak").show();
      $("#tanggalcair").hide();
      $("#jumlahbayar").hide();
      $("#bank").show();
      $("#omsetbulan").hide();
      $("#omsettahun").hide();
    }

    function hidetanggal() {
      $("#tanggalditolak").hide();
      $("#tanggalcair").hide();
      $("#jumlahbayar").hide();
      $("#bank").hide();
      $("#omsetbulan").hide();
      $("#omsettahun").hide();
    }

    hidetanggal();
    $("#status").change(function() {

      var status = $("#status").val();

      if (status == 1) {

        diterima();
      } else if (status == 2) {

        ditolak();
      } else {

        hidetanggal();
      }

    });

    $("#formValidate").submit(function() {
      var status = $("#status").val();
      var tglcair = $("#tglcair").val();
      var bank_penerima = $("#bank_penerima").val();
      var tglditolak = $("#tglditolak").val();
      if (status == "") {
        swal("Oops!", "Status Harus Dipilih !", "warning");
        $("#status").focus()
        return false;
      } else if (status == "1" && tglcair == "") {
        swal("Oops!", "Tanggal Diterima / Cair Harus Diisi !", "warning");
        return false;
      } else if (status == "1" && bank_penerima == "") {
        swal("Oops!", "Bank Penerima Harus Diisi !", "warning");
        return false;
      } else if (status == "2" && tglditolak == "") {
        swal("Oops!", "Tanggal Ditolak Harus Diisi !", "warning");
        return false;
      } else if (status == "2" && bank_penerima == "") {
        swal("Oops!", "Bank Penerima Harus Diisi!", "warning");
        return false;
      } else {
        return true;
      }
    });

  });
</script>
</script>