<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>keuangan/insertsaldoawalledger">
  <input type="hidden" id="ceksetoran" name="ceksetoran" class="form-control">
  <input type="hidden" readonly id="getsa" name="getsa" value="0" class="form-control" />
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" id="kode_saldoawal" name="kode_saldoawal" class="form-control" placeholder="Kode Saldo Awal" data-error=".errorTxt11">
    </div>
  </div>
  <div class="form-group mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" id="tanggal" name="tanggal" class="form-control tanggal" placeholder="Tanggal Saldo Awal" data-error=".errorTxt11">
    </div>
  </div>

  <div class="form-group">
    <select class="form-select show-tick bank" id="bank2" name="bank2" data-error=".errorTxt1">
      <option value="">BANK</option>
      <?php $no = 1;
      foreach ($lbank as $b) { ?>
        <option data-id="<?php echo $no;  ?>" value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
      <?php $no++;
      } ?>
    </select>
  </div>
  <div class="form-group">
    <select class="form-select bulan" id="bulan2" name="bulan">
      <option value="">Bulan</option>
      <?php for ($a = 1; $a <= 12; $a++) { ?>
        <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <select class="form-select tahun" id="tahun2" name="tahun">
      <option value="">Tahun</option>
      <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
        <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
      <?php } ?>
    </select>
  </div>
  <hr>
  <div class="d-flex justify-content-end">
    <a href="#" id="getsaldo" class="btn btn-success"><i class="fa fa-search mr-2"></i>GET SALDO</a>
  </div>

  <hr>
  <div class="form-group mb-3">
    <div class="input-icon">
      <input type="text" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" style="text-align:right" data-error=".errorTxt11">
      <span class="input-icon-addon">
        <i class="fa fa-money"></i>
      </span>
    </div>
  </div>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>SIMPAN</button>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script type="text/javascript">
  var jml = document.getElementById('jumlah');

  jml.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    jml.value = formatRupiah(this.value, '');
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
<script type="text/javascript">
  $(function() {

    function loadNoMutasi() {
      var bulan = $("#bulan2").val();
      // var bank    = $(this).attr('data-id');
      var tahun = $("#tahun2").val();
      var thn = tahun.substr(2, 2);
      var x = Math.floor((Math.random() * 100) + 1);
      // alert(bulan);
      if (parseInt(bulan.length) == 1) {
        var bln = "0" + bulan;
      } else {
        var bln = bulan;
      }
      var kode = "SA" + bln + thn + x;
      $("#kode_saldoawal").val(kode);
    }


    function loaddetailsaldo() {
      var bulan = $("#bulan2").val();
      var bank = $("#bank2").val();
      var tahun = $("#tahun2").val();
      var thn = tahun.substr(2, 2);
      if (bank == "") {
        swal("Oops!", "Bank Harus Diisi !", "warning");
        return false;
      } else if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi !", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi !", "warning");
        return false;
      } else if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi !", "warning");
        return false;
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>keuangan/getdetailsaldo',
          data: {
            bulan: bulan,
            tahun: tahun,
            bank: bank
          },
          cache: false,
          success: function(respond) {
            if (respond == 1) {
              $("#getsa").val(0);
              swal("Oops!", "Saldo Bulan Sebelumnya Belum Diset! Atau Saldo Bulan Tersebut Sudah Ada", "warning");
            } else {
              $("#getsa").val(1);
              $("#jumlah").val(respond);
            }
            console.log(respond);
          }
        });
      }

    }

    $("#getsaldo").click(function(e) {
      e.preventDefault();
      loaddetailsaldo();
    });

    $(".bank").change(function() {
      loadNoMutasi();
    });

    $(".bulan").change(function() {
      loadNoMutasi();
    });

    $(".tahun").change(function() {
      loadNoMutasi();
    });

    $("#formValidate").submit(function() {
      var tanggal = $(".tanggal").val();
      var bank = $("#bank2").val();
      var bulan = $("#bulan2").val();
      var tahun = $("#tahun2").val();
      var jumlah = $("#jumlah").val();

      if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi.. !", "warning");
        return false;
      } else if (bank == "") {
        swal("Oops!", "Bank Harus Diisi.. !", "warning");
        return false;
      } else if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi.. !", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi.. !", "warning");
        return false;
      } else if (jumlah == "") {
        swal("Oops!", "Saldo Harus Diisi.. !", "warning");
        return false;
      } else if (getsa == 0) {
        swal("Oops!", "Lakukan Get Saldo Terlebih Dahulu !", "warning");
        return false;
      } else {
        return true;
      }
    });



  });
</script>