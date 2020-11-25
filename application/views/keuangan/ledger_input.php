<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>keuangan/insertledger">

  <input type="hidden" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt11">
  <input type="hidden" id="cekdata" name="cekdata">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" id="tglledger" name="tglledger" class="form-control datepicker date" placeholder="Tanggal" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" id="noref" name="noref" class="form-control" placeholder="No Ref" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-users"></i>
      </span>
      <input type="text" id="pelanggan" name="pelanggan" class="form-control" placeholder="Pelanggan" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file"></i>
      </span>
      <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick " id="kodeakun" name="kodeakun">
      <?php foreach ($coa as $r) { ?>
        <option value="<?php echo $r->kode_akun; ?>"><?php echo $r->kode_akun . " " . $r->nama_akun; ?>
        </option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <input type="text" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" style="text-align:right" data-error=".errorTxt11">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
    </div>
  </div>
  <div class="form-group mb-3">

    <select class="form-select show-tick" id="lbank" name="lbank" data-error=".errorTxt1">
      <?php foreach ($lbank as $b) { ?>
        <option value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
      <?php } ?>
    </select>


  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick " id="debetkredit" name="debetkredit" data-error=".errorTxt1">
      <option value="D">Debet</option>
      <option value="K">Kredit</option>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick " id="peruntukan" name="peruntukan" data-error=".errorTxt1">
      <option value="">Pilih Peruntukan</option>
      <option value="PC">CV. PACIFIC</option>
      <option value="MP">CV. MAKMUR PERMATA</option>
    </select>
  </div>
  <div class="form-group mb-3" id="ketperuntukan">
    <select class="form-select show-tick " id="ket_peruntukan" name="ket_peruntukan" data-error=".errorTxt1">
      <option value="">Pilih Cabang</option>
      <?php foreach ($cabang as $c) { ?>
        <option value="<?php echo $c->kode_cabang; ?>"><?php echo $c->nama_cabang; ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="d-flex justify-content-end"">
    <a href=" #" id="simpantemp" class="btn btn-primary">
    <i class="fa fa-plus mr-2"></i> Tambah
    </a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-hover js-basic-example dataTable">
      <thead class="thead-dark">
        <tr>
          <th>No Ref</th>
          <th>Pelanggan</th>
          <th>Jumlah</th>
          <th>Akun</th>
          <th>Bank</th>
          <th>Keterangan</th>
          <th>Status</th>
          <th>Peruntukan</th>
          <th>Ket. Peruntukan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="tampiltemp">

      </tbody>
    </table>
  </div>
  <br>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" id="simpan" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>SIMPAN</button>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tglledger'), {});
</script>
<script>
  var jml = document.getElementById("jumlah");
  jml.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    jml.value = formatRupiah(this.value, "");

    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }
      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
      return prefix == undefined ? rupiah : rupiah ? rupiah : "";
    }
  });
</script>
<script>
  $(function() {
    $('#kodeakun').selectize({});


    function hideketperuntukan() {
      $("#ketperuntukan").hide();
    }
    hideketperuntukan();

    $("#peruntukan").change(function() {
      var peruntukan = $(this).val();
      if (peruntukan == "PC") {
        $("#ketperuntukan").show();
      } else {
        hideketperuntukan();
      }

    })

    function tampiltemp() {

      var noref = $("#noref").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>keuangan/view_templedger',
        data: {
          noref: noref
        },
        success: function(html) {

          $("#tampiltemp").html(html);

        }
      });

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>keuangan/cekdata/',
        cache: false,
        data: {
          noref: noref
        },
        success: function(respond) {

          $("#cekdata").val(respond);

        }

      });
    }

    $("#noref").on('keyup keydown change', function() {

      tampiltemp();

    });


    $("#simpan").click(function() {

      var tglledger = $("#tglledger").val();
      var cekdata = $("#cekdata").val();

      if (cekdata == 0) {
        swal("Oops", "Input Data Terlebih Dahulu", "warning");
        return false;
      } else if (tglledger == "") {
        swal("Oops", "Tanggal Harus Diisi", "warning");
        return false;
      } else {
        return true;
      }

    });

    $("#simpantemp").click(function(e) {
      e.preventDefault();
      var noref = $("#noref").val();
      var pelanggan = $("#pelanggan").val();
      var tanggal = $("#tanggal").val();
      var keterangan = $("#keterangan").val();
      var jumlah = $("#jumlah").val();
      var kodeakun = $("#kodeakun").val();
      var lbank = $("#lbank").val();
      var debetkredit = $("#debetkredit").val();
      var jumlah = jumlah.replace(/[^\d]/g, "");
      var peruntukan = $("#peruntukan").val();
      var ketperuntukan = $("#ket_peruntukan").val();
      if (pelanggan == 0) {
        swal("Oops", "Pelanggan Harus Diisi", "warning");
        return false;

      } else if (keterangan == 0) {
        swal("Oops", "Keterangan Harus Diisi", "warning");
        return false;

      } else if (noref == 0) {
        swal("Oops", "No Ref Harus Diisi", "warning");
        return false;
      } else if (tglledger == 0) {
        swal("Oops", "Tanggal Harus Diisi", "warning");
        return false;
      } else if (jumlah == 0) {
        swal("Oops", "Jumlah Harus Diisi", "warning");
        return false;
      } else if (peruntukan == "") {
        swal("Oops", "Peruntukan Harus Diisi", "warning");
        return false;
      } else if (peruntukan == "PC" && ketperuntukan == "") {
        swal("Oops", "Cabang Harus Diisi", "warning");
        return false;
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>keuangan/insertledger_temp',
          data: {
            pelanggan: pelanggan,
            keterangan: keterangan,
            noref: noref,
            debetkredit: debetkredit,
            kodeakun: kodeakun,
            lbank: lbank,
            jumlah: jumlah,
            peruntukan: peruntukan,
            ketperuntukan: ketperuntukan
          },
          cache: false,
          success: function(respond) {

            tampiltemp();

            $('#pelanggan').val("");
            $('#keterangan').val("");
            $('#jumlah').val("");
            $('#pelanggan').focus();

          }

        });
      }
    });

  });
</script>