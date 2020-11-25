<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/updatedetailkb">
  <input type="hidden" name="nokontrabon" value="<?php echo $bayar['no_kontrabon']; ?>">
  <input type="hidden" name="nobukti" value="<?php echo $bayar['nobukti_pembelian']; ?>">
  <div class="form-group mb-3">
    <div class="input-icon">
      <input type="text" style="text-align:right" value="<?php echo number_format($bayar['jmlbayar'], '2', ',', '.'); ?>" id="jmlbayar" name="jmlbayar" class="form-control" placeholder="Jumlah Bayar" data-error=".errorTxt19" />
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
    </div>
  </div>

  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Update</button>
  </div>

</form>
<script>
  var h = document.getElementById('jmlbayar');
  h.addEventListener('keyup', function(e) {
    h.value = formatRupiah(this.value, '');
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

  function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++)
      if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
  }
</script>