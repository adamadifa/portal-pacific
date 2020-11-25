<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/insertjurnalkoreksi">
  <input type="hidden" name="nobukti">
  <input type="hidden" id="cekdetailtmp">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-calendar-o"></i>
      </span>
      <input type="text" id="tanggal" name="tanggal" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt1" />
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="supplier" name="supplier" data-error=".errorTxt1" data-live-search="true">
      <option value="">--Pilih Supplier--</option>
      <?php foreach ($supp as $d) { ?>
        <option value="<?php echo $d->kode_supplier; ?>"><?php echo $d->nama_supplier; ?></option>
      <?php }  ?>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="nobuktipembelian" name="nobuktipembelian" data-error=".errorTxt1" data-live-search="true">
      <option value="">Pilih No Bukti Pembelian</option>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="barangpembelian" name="barangpembelian" data-error=".errorTxt1" data-live-search="true">
      <option value="">Pilih Barang</option>
    </select>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input type="text" style="text-align:right" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt2" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-o"></i>
      </span>
      <input type="text" style="text-align:right" id="qty" name="qty" class="form-control" onkeyup="calc()" placeholder="Qty" data-error=".errorTxt2" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
      <input type="text" style="text-align:right" id="harga" name="harga" onkeyup="calc()" class="form-control" placeholder="Harga" data-error=".errorTxt2" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
      <input type="text" readonly style="text-align:right" id="total" name="total" class="form-control" placeholder="Total" data-error=".errorTxt2" />
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="debetkredit" name="debetkredit" data-error=".errorTxt1">
      <option value="D">Debet</option>
      <option value="K">Kredit</option>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick " id="coa" name="kodeakun" data-error=".errorTxt1" data-live-search="true">
      <option value="">Pilih Akun</option>
      <?php foreach ($coa as $r) { ?>
        <option value="<?php echo $r->kode_akun; ?>"><?php echo $r->kode_akun . " " . $r->nama_akun; ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script type="text/javascript">
  var h = document.getElementById('harga');
  h.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    h.value = formatRupiah(this.value, '');
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

  function calc() {
    qtykoma = document.getElementById("qty").value;
    qty = qtykoma.replace(/\,/g, '.');
    hargarupiah = document.getElementById("harga").value;
    harga = hargarupiah.replace(/\./g, '');

    if (harga == "") {
      harga = 0;
    }

    if (qty == "") {
      qty = 0;
    }


    var result = parseFloat(harga) * parseFloat(qty);

    //var selisih = parseInt(result)-parseInt(totallhp);
    if (!isNaN(result)) {
      total = document.getElementById('total').value = result;
    }
  }
</script>
<script type="text/javascript">
  $(function() {
    $("#supplier").selectize({});
    $("#nobuktipembelian").selectize({});
    $("#barangpembelian").selectize({});
    $("#debetkredit").selectize({});
    $("#coa").selectize({});
    $("#supplier").change(function() {
      var supplier = $("#supplier").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>pembelian/get_pembelian",
        data: {
          supplier: supplier
        },
        cache: false,
        success: function(respond) {
          $('#nobuktipembelian').selectize()[0].selectize.destroy();
          $("#nobuktipembelian").html(respond);
          $('#nobuktipembelian').selectize({});
        }
      });
    });

    $("#nobuktipembelian").change(function() {
      var nobuktipembelian = $("#nobuktipembelian").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>pembelian/get_barangpembelian",
        data: {
          nobuktipembelian: nobuktipembelian
        },
        cache: false,
        success: function(respond) {
          $('#barangpembelian').selectize()[0].selectize.destroy();
          $("#barangpembelian").html(respond);
          $('#barangpembelian').selectize({});
        }
      });
    });

    $("#formValidate").submit(function() {
      var tanggal = $("#tanggal").val();
      var supplier = $("#supplier").val();
      var nobukti = $("#nobuktipembelian").val();
      var keterangan = $("#keterangan").val();
      var harga = $("#harga").val();
      var qty = $("#qty").val();
      var akun = $("#coa").val();

      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        $("#tanggal").focus()
        return false;
      } else if (supplier == "") {
        swal("Oops!", "Supplier Masih Kosong!", "warning");
        return false;
      } else if (nobukti == "") {
        swal("Oops!", "No Bukti Masih Kosong!", "warning");
        return false;
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan Masih Kosong!", "warning");
        return false;
      } else if (qty == "") {
        swal("Oops!", "Qty Masih Kosong!", "warning");
        $("#qty").focus()
        return false;
      } else if (harga == "") {
        swal("Oops!", "Harga Masih Kosong!", "warning");
        return false;
      } else if (akun == "") {
        swal("Oops!", "Akun Masih Kosong!", "warning");
        return false;
      } else {
        return true;
      }
    });
  });
</script>