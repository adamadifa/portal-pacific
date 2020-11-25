<form name="autoSumForm" autocomplete="off" class="" id="formPenjualan" method="POST" action="#">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="hidden" id="nobukti" value="<?php echo $nobukti; ?>" name="nobukti" class="form-control" data-error=".errorTxt19" />
      <input type="hidden" id="jenistransaksi" value="<?php echo $jenistransaksi; ?>" name="jenistransaksi" class="form-control" data-error=".errorTxt19" />
      <input type="text" id="keteranganpenj" value="" name="keteranganpenj" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-sort-numeric-asc"></i>
      </span>
      <input type="text" onkeyup="calc()" id="qtypenj" value="" name="qtypenj" class="form-control" placeholder="Qty" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
      <input type="text" onkeyup="calc()" id="hargapenj" style="text-align:right" name="hargapenj" class="form-control" placeholder="Harga" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
      <input type="text" id="totalpenj" style="text-align:right" name="totalpenj" class="form-control" placeholder="Total" readonly data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="akunpenj" name="akunpenj">
      <option value="">--Pilih Akun--</option>
      <?php foreach ($akun as $d) { ?>
        <option value="<?php echo $d->kode_akun; ?>"><?php echo $d->nama_akun; ?></option>
      <?php }  ?>
    </select>
  </div>
  <div class="mt-3 d-flex justify-content-end">
    <button type="submit" name="submit" id="addpenjualan" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-plus mr-2"></i>Tambah</button>
  </div>
</form>

<script>
  var hpenj = document.getElementById('hargapenj');
  hpenj.addEventListener('keyup', function(e) {
    hpenj.value = formatRupiah(this.value, '');
    //alert(b);
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
    hargapenj = document.getElementById("hargapenj").value;
    uanghargapenj = hargapenj.replace(/\./g, '');
    qtypenj = document.getElementById("qtypenj").value;
    if (uanghargapenj == "") {
      uanghargapenj = 0;
    }

    var result = parseInt(uanghargapenj) * parseInt(qtypenj);
    if (!isNaN(result)) {
      totalpenj = document.getElementById('totalpenj').value = convertToRupiah(result);
      // document.getElementById("totalbayar").innerHTML=convertToRupiah(totalsetoran);
    }
  }

  function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
      if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
  }
</script>
<script>
  $(function() {
    $('#akunpenj').selectize({});

    function loaddatapenjualan() {
      var nobukti = $("#nobukti").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/loaddatapenjualan',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#loaddatapenjualan").html(respond);
        }
      });
    }
    $("#addpenjualan").click(function(e) {
      e.preventDefault();
      var nobukti = $("#nobukti").val();
      var keterangan = $("#keteranganpenj").val();
      var qty = $("#qtypenj").val();
      var harga = $("#hargapenj").val();
      var akunpenj = $("#akunpenj").val();
      var jenistransaksi = $("#jenistransaksi").val();
      // alert(keterangan);
      if (keterangan == "") {
        swal("Oops!", "Keterangan Harus Diisi !", "warning");
      } else if (qty == "") {
        swal("Oops!", "Qty Harus Diisi !", "warning");
      } else if (harga == "") {
        swal("Oops!", "Harga Harus Diisi !", "warning");
      } else if (akunpenj == "") {
        swal("Oops!", "Akun Penjualan Harus Diisi !", "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>pembelian/insert_penjualan',
          data: {
            nobukti: nobukti,
            keterangan: keterangan,
            qty: qty,
            harga: harga,
            akunpenj: akunpenj,
            jenistransaksi: jenistransaksi
          },
          cache: false,
          success: function(respond) {
            loaddatapenjualan();
            console.log(respond);
            $("#datapenjualan").modal("hide");
          }
        });
      }
    });
  });
</script>