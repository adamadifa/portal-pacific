<form autocomplete="off" class="formValidate" id="EditDetailBarang" method="POST" action="<?php echo base_url(); ?>pembelian/update_detailbarang">
  <input type="hidden" name="nobukti" value="<?php echo $brg['nobukti_pembelian']; ?>">
  <input type="hidden" name="kodecr" value="<?php echo $brg['kode_cr']; ?>">
  <input type="hidden" name="no_urut" value="<?php echo $brg['no_urut']; ?>">
  <input type="hidden" name="cekcbg" id="cekcbg" value="0">
  <input type="hidden" name="tgl_pembelian" value="<?php echo $tglpembelian; ?>">
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" value="<?php echo $brg['kode_barang']; ?>" readonly id="kodebarang" name="kodebarang" class="form-control" placeholder="Kode Barang" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" readonly value="<?php echo $brg['nama_barang']; ?>" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama Barang" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-text-o"></i>
      </span>
      <input type="hidden" value="<?php echo $brg['keterangan']; ?>" id="keteranganold" name="keteranganold" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
      <input type="text" value="<?php echo $brg['keterangan']; ?>" id="keteranganedit" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-file-text-o"></i>
      </span>
      <input type="text" value="<?php echo $brg['qty']; ?>" id="qtyedit" name="qty" class="form-control" placeholder="Qty" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
      <input type="text" style="text-align:right" value="<?php echo number_format($brg['harga'], '2', ',', '.'); ?>" id="hargaedit" name="harga" class="form-control" placeholder="Harga" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
      <input type="text" style="text-align:right" value="<?php echo number_format($brg['penyesuaian'], '2', ',', '.'); ?>" id="penyedit" name="penyharga" class="form-control" placeholder="Penyesuaian" data-error=".errorTxt19" />
    </div>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick " id="coa" name="kodeakun" data-error=".errorTxt1"">
      <?php foreach ($coa as $r) { ?>
        <option <?php if ($brg['kode_akun'] == $r->kode_akun) {
                  echo "selected";
                } ?> value='<?php echo $r->kode_akun; ?>'><?php echo $r->kode_akun . " " . $r->nama_akun; ?></option>
    <?php } ?>
    </select>
  </div>
  <div class=" row mb-3">
      <div class="col-md-12">
        <label class="form-check form-switch">
          <input class="form-check-input cabang" <?php if (!empty($brg['kode_cabang'])) {
                                                    echo "checked";
                                                  } ?> type="checkbox" name="girotocash" value="1">
          <span class="form-check-label"><b>Cabang ?</b></span>
        </label>
      </div>
  </div>
  <div class="row">
    <div class="form-group">
      <select name="cbg" id="cbg" class="form-select">
        <option value="">-- Pilih Cabang --</option>
        <?php foreach ($cabang as $c) { ?>
          <option <?php if ($brg['kode_cabang'] == $c->kode_cabang) {
                    echo "selected";
                  } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class=" mt-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
  </div>
</form>
<script src="<?php echo base_url(); ?>assets/js/pages/forms/advanced-form-elements.js"></script>
<script>
  var h = document.getElementById('hargaedit');
  h.addEventListener('keyup', function(e) {
    h.value = formatRupiah(this.value, '');
    //alert(b);
  });

  // var p = document.getElementById('penyhargaedit');
  // p.addEventListener('keyup', function(e){
  //   p.value = formatRupiah(this.value, '');
  //   //alert(b);
  // });
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

  function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
      if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
  }
</script>
<script type="text/javascript">
  $(function() {
    $('#coa').selectize({});
    $("#EditDetailBarang").submit(function() {
      var kodeakun = $("#coa").val();
      var keterangan = $("#keteranganedit").val();
      var qty = $("#qtyedit").val();
      var harga = $("#hargaedit").val();

      var isChecked = $(".cabang").is(":checked");
      var cbg = $("#cbg").val();
      if (kodebarang == "") {
        swal("Oops!", "Kode Barang Harus Diisi !", "warning");
        return false;
      } else if (qty == "") {
        swal("Oops!", "Qty Harus Diisi !", "warning");
        return false;
      } else if (keterangan == "") {
        swal("Oops!", "Keterangan Harus Diisi !", "warning");
        return false;
      } else if (kodeakun == "") {
        swal("Oops!", "Kode Akun Harus Diisi !", "warning");
        return false;
      } else if (harga == "") {
        swal("Oops!", "Harga Harus Diisi !", "warning");
        return false;
      } else if (isChecked && cbg == "") {
        swal("Oops!", "Cabang Harus Diisi!", "warning");
        return false;
      } else {
        return true;
      }
    });

    function loadcabang() {
      var isChecked = $(".cabang").is(":checked");
      if (isChecked) {
        $("#cbg").show();
        $("#cekcbg").val(1);
      } else {
        $("#cbg").hide();
        $("#cekcbg").val(0);
      }
    }

    loadcabang();

    $('.cabang').change(function() {
      //alert('test');
      if (this.checked) {
        $("#cekcbg").val(1);
        // var returnVal = confirm("Apakah Benar Barang Ini Merupakan Kebutuhan Cabang ?");
        // $(this).prop("checked", returnVal);
        $("#cbg").show();
      } else {
        $("#cekcbg").val(0);
        $("#cbg").hide();
      }

    });

  });
</script>