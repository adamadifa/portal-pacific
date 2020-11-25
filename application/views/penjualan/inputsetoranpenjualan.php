<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/inputsetoranpenjualan">
  <input type="hidden" id="ceksetoran" name="ceksetoran" class="form-control">
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Tanggal</label>
      <div class="input-icon">
        <input type="date" id="tgllhpkb" name="tgllhpkb" class="form-control" placeholder="Tanggal LHP" />
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
  <div class="row mb-3">
    <?php if ($sess_cab == 'pusat') { ?>
      <label class="form-label">Cabang</label>
      <div class="form-group">
        <select name="cabangkb" id="cabangkb" class="form-select">
          <option value="">-- Pilih Cabang --</option>
          <?php foreach ($cabang as $c) { ?>
            <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
          <?php } ?>
        </select>
      </div>
    <?php } else { ?>
      <input type="hidden" name="cabangkb" id="cabangkb" value="<?php echo $sess_cab; ?>">
    <?php } ?>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Salesman</label>
      <div class="form-group">
        <select id="salesmankb" name="salesmankb" class="form-select">
          <option value="">-- Pilih Salesman -- </option>
        </select>
      </div>
    </div>
  </div>
  <h4 style="color:#1ab394">LHP</h4>

  <table class="table">
    <tr>
      <td style="font-weight: bold;">Tunai</td>
      <td>
        <input type="text" style="text-align:right; font-weight:bold" id="tunai" name="tunai" class="form-control" placeholder="Tunai">
        <div id="terbilang" style="float:right; font-weight:bold; color:#1ab394"></div>
      </td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Tagihan</td>
      <td>
        <input type="hidden" style="text-align:right; font-weight:bold" id="tagihan" name="tagihan" class="form-control" placeholder="Tagihan">
        <div id="terbilangtagihan" style="float:right; font-weight:bold; color:#1ab394"></div>
      </td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Total</td>
      <td>
        <input type="hidden" readonly style="text-align:right; font-weight:bold" id="totallhp" name="totallhp" class="form-control" placeholder="Total LHP">
        <a id="detaillhp" href="#" target="_blank">
          <div id="terbilangtotallhp" style="float:right; font-weight:bold; color:#1ab394"></div>
        </a>
      </td>
    </tr>
  </table>
  <h4 style="color:#dc3545">SETORAN</h4>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Uang Kertas</label>
        <div class="input-icon">
          <input type="text" value="0" onkeyup="calc()" style="text-align:right; font-weight:bold; color:#dc3545" id="uangkertas" name="uangkertas" class="form-control" placeholder="Uang Kertas" />
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Uang Logam</label>
        <div class="input-icon">
          <input type="text" value="0" onkeyup="calc()" style="text-align:right; font-weight:bold; color:#dc3545" id="uanglogam" name="uanglogam" class="form-control" placeholder="Uang Logam" />
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div id="kuranglebih">
    <div class="col-md-4  form-control-label">
      <label>Bayar Kurang Setor</label>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <div class="form-line">
          <input type="text" value="0" onkeyup="calc()" style="text-align:right" id="kurangsetor" name="kurangsetor" class="form-control" placeholder="Bayar Kurang Setor" data-error=".errorTxt11">
        </div>
        <div id="terbilangkurangsetor" style="float:right;"></div>
      </div>
    </div>
    <div class="col-md-4  form-control-label">
      <label>Bayar Lebih Setor</label>
    </div>
    <div class="col-md-8">
      <div class="form-group">
        <div class="form-line">
          <input type="text" value="0" onkeyup="calc()" style="text-align:right" id="lebihsetor" name="lebihsetor" class="form-control" placeholder="Bayar Lebih Setor" data-error=".errorTxt11">
        </div>
        <div id="terbilanglebihsetor" style="float:right;"></div>
      </div>
    </div>
    <label style="margin-bottom:2px !important">Lainnya</label>
    <div class="form-group">
      <div class="form-line">
        <input type="text" value="0" onkeyup="calc()" style="text-align:right; font-weight:bold; color:#dc3545" id="lainnya" name="lainnya" class="form-control" placeholder="Lainnya" data-error=".errorTxt11">
      </div>
      <div id="terbilanglainnya" style="float:right; color:#dc3545"></div>
    </div>
  </div>
  <table class="table mt-3">
    <tr>
      <td style="font-weight:bold;">BG/CEK</td>
      <td>
        <input type="hidden" value="0" onkeyup="calc()" style="text-align:right; color:#dc3545" id="bgcek" name="bgcek" class="form-control" placeholder="BG / CEK">
        <div id="terbilangbg" style="float:right; font-weight:bold; color:#dc3545"></div>
      </td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Transfer</td>
      <td>
        <input type="hidden" value="0" onkeyup="calc()" style="text-align:right; color:#dc3545" id="transfer" name="transfer" class="form-control" placeholder="TRANSFER">
        <div id="terbilangtrf" style="float:right; font-weight:bold; color:#dc3545"></div>
      </td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Total Setoran</td>
      <td>
        <input type="hidden" readonly style="text-align:right;" id="totalsetoran" name="totalsetoran" class="form-control" placeholder="Total Setoran">
        <div id="terbilangtotalsetoran" style="float:right; font-weight:bold; color:#dc3545"></div>
      </td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Selisih</td>
      <td>
        <input type="hidden" id="selisih" name="selisih" class="form-control" placeholder="Selisih">
        <div id="terbilangselisih" style="float:right; font-weight:bold; color:#dc3545"></div>
      </td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Ganti Giro Ke Cash</td>
      <td>
        <input type="hidden" id="girotocash" name="girotocash" class="form-control" placeholder="Ganti Giro Ke Cash">
        <div id="terbilanggirotocash" style="float:right; color:#f8ac59"></div>
      </td>
    </tr>
  </table>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Keterangan</label>
        <div class="input-icon">
          <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" />
          <span class="input-icon-addon">
            <i class="fa fa-file"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="simpan" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
      </div>
    </div>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tgllhpkb'), {});
</script>
<script type="text/javascript">
  var uk = document.getElementById('uangkertas');
  var ul = document.getElementById('uanglogam');
  var l = document.getElementById('lainnya');
  uk.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

    uk.value = formatRupiah(this.value, '');
  });

  ul.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

    ul.value = formatRupiah(this.value, '');
  });

  l.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

    l.value = formatRupiah(this.value, '');
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
    uangkertasrupiah = document.getElementById("uangkertas").value;
    uangkertas = uangkertasrupiah.replace(/\./g, '');
    lainnyarupiah = document.getElementById("lainnya").value;
    lainnya = lainnyarupiah.replace(/\./g, '');
    bgcek = document.getElementById("bgcek").value;
    transfer = document.getElementById("transfer").value;
    kurangsetor = document.getElementById("kurangsetor").value;
    lebihsetor = document.getElementById("lebihsetor").value;
    uanglogamrupiah = document.getElementById("uanglogam").value;
    uanglogam = uanglogamrupiah.replace(/\./g, '');
    totallhp = document.getElementById("totallhp").value;

    if (uangkertas == "") {

      uangkertas = 0;
    }

    if (lainnya == "") {

      lainnya = 0;
    }

    if (bgcek == "") {

      bgcek = 0;
    }

    if (transfer == "") {

      transfer = 0;
    }

    if (kurangsetor == "") {

      kurangsetor = 0;
    }


    if (lebihsetor == "") {

      lebihsetor = 0;
    }

    if (uanglogam == "") {

      uanglogam = 0;
    }
    var result = parseInt(uangkertas) + parseInt(uanglogam) + parseInt(lainnya) + parseInt(bgcek) + parseInt(transfer) + parseInt(kurangsetor) - parseInt(lebihsetor);
    var selisih = parseInt(result) - parseInt(totallhp);
    if (!isNaN(result)) {
      totalsetoran = document.getElementById('totalsetoran').value = result;
      document.getElementById("terbilangtotalsetoran").innerHTML = convertToRupiah(totalsetoran);
    }

    if (!isNaN(selisih)) {
      totalselisih = document.getElementById('selisih').value = selisih;
      document.getElementById("terbilangselisih").innerHTML = convertToRupiah(totalselisih);
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
    $("#tunai").hide();

    function ceksetoran() {
      var tgllhp = $("#tgllhpkb").val();
      var salesman = $("#salesmankb").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/ceksetoran',
        data: {
          tgllhp: tgllhp,
          salesman: salesman
        },
        cache: false,
        success: function(respond) {
          $("#ceksetoran").val(respond);
        }
      });
    }

    function hidekuranglebih() {
      $("#kuranglebih").hide();
    }

    function showlhp() {
      var tanggallhp = $("#tgllhpkb").val();
      var salesman = $("#salesmankb").val();
      var cabang = $("#cabangkb").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/get_setoran',
        data: {
          tanggallhp: tanggallhp,
          salesman: salesman
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          datasetoran = respond.split("|");
          totallhp = parseInt(datasetoran[0]) + parseInt(datasetoran[1]);
          totalsetoran = parseInt(datasetoran[2] + parseInt(datasetoran[4]));
          $("#tunai").val(datasetoran[0]);
          $("#tagihan").val(datasetoran[1]);
          $("#bgcek").val(datasetoran[2]);
          $("#totalsetoran").val(datasetoran[5]);
          $("#girotocash").val(datasetoran[3]);
          $("#transfer").val(datasetoran[4]);
          $("#totallhp").val(totallhp);
          terbilang(datasetoran[0], 'tunai');
          terbilang(datasetoran[1], 'tagihan');
          terbilang(totallhp, 'totallhp');
          terbilang(datasetoran[2], 'bgcek');
          terbilang(datasetoran[4], 'transfer');
          terbilang(datasetoran[5], 'totalsetoran');
          terbilang(datasetoran[3], 'girotocash');
          $("#detaillhp").attr('href', '<?php echo base_url(); ?>laporanpenjualan/cekkasbesar/' + cabang + '/' + tanggallhp + '/' + salesman);
          ceksetoran();
        }
      });
    }

    function terbilang(angka, jenis) {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/terbilang',
        data: {
          angka: angka
        },
        cache: false,
        success: function(respond) {
          if (jenis == 'tunai') {
            $("#terbilang").html(respond);
          } else if (jenis == 'tagihan') {
            $("#terbilangtagihan").html(respond);
          } else if (jenis == 'totallhp') {
            $("#terbilangtotallhp").html(respond);
          } else if (jenis == 'uangkertaslogam') {
            // $("#terbilanguangkertaslogam").html(respond);
          } else if (jenis == 'bgcek') {
            $("#terbilangbg").html(respond);
          } else if (jenis == 'transfer') {
            $("#terbilangtrf").html(respond);
          } else if (jenis == 'uanglogam') {
            //$("#terbilanguanglogam").html(respond);
          } else if (jenis == 'kurangsetor') {
            //$("#terbilangkurangsetor").html(respond);
          } else if (jenis == 'lebihsetor') {
            //$("#terbilanglebihsetor").html(respond);
          } else if (jenis == 'lainnya') {
            //$("#terbilanglainnya").html(respond);
          } else if (jenis == 'totalsetoran') {
            $("#terbilangtotalsetoran").html(respond);
          } else if (jenis == 'girotocash') {
            $("#terbilanggirotocash").html(respond);
          }
        }
      });

    }

    function loadSalesman() {
      var cabang = $("#cabangkb").val();
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/get_salesman2',
        data: {
          cabang: cabang
        },
        cache: false,
        success: function(respond) {

          $("#salesmankb").html(respond);
          //$("#salesmankb").selectpicker("refresh");

        }

      });
    }

    loadSalesman();
    ceksetoran();
    hidekuranglebih();

    $("#detailtunai").click(function(e) {
      $("#panel").slideToggle("slow");
    });

    $("#tgllhpkb").change(function() {
      ceksetoran();
      showlhp();
    });

    $("#cabangkb").change(function() {
      var tgllhp = $("#tgllhpkb").val();
      var cabang = $("#cabangkb").val();

      if (tgllhp != "") {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>laporanpenjualan/get_salesman2',
          data: {
            cabang: cabang
          },
          cache: false,
          success: function(respond) {

            $("#salesmankb").html(respond);
            // $("#salesmankb").selectpicker("refresh");

          }
        });
      } else {
        $('#cabangkb').prop('selectedIndex', 0);
        //$("#cabangkb").selectpicker("refresh");
        swal("Oops!", "Silahkan Isi Tanggal LHP Dulu.. !", "warning");
      }
    });

    $("#salesmankb").change(function(e) {
      e.preventDefault();
      showlhp();
    });

    $("#uangkertas").on('keyup keydown change', function() {

      var uangkertas = $("#uangkertas").val();
      terbilang(uangkertas, 'uangkertaslogam');

    });

    $("#uanglogam").on('keyup keydown change', function() {

      var uanglogam = $("#uanglogam").val();
      terbilang(uanglogam, 'uanglogam');

    });
    $("#kurangsetor").on('keyup keydown change', function() {

      var kurangsetor = $("#kurangsetor").val();
      terbilang(kurangsetor, 'kurangsetor');

    });

    $("#lebihsetor").on('keyup keydown change', function() {

      var lebihsetor = $("#lebihsetor").val();
      terbilang(lebihsetor, 'lebihsetor');

    });

    $("#lainnya").on('keyup keydown change', function() {

      var lebihsetor = $("#lainnya").val();
      terbilang(lebihsetor, 'lainnya');

    });

    $("#totalsetoran").on('keyup keydown change', function() {

      var totalsetoran = $("#totalsetoran").val();
      terbilang(totalsetoran, 'totalsetoran');

    });

    $("#formValidate").submit(function() {

      var tgllhp = $("#tgllhpkb").val();
      var cabang = $("#cabangkb").val();
      var salesman = $("#salesmankb").val();
      var ceksetoran = $("#ceksetoran").val();
      var totallhp = $("#totallhp").val();
      if (tgllhp == "") {
        swal("Oops!", "Tanggal LHP Harus Diisi.. !", "warning");
        $("#tgllhpkb").focus();
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi!", "warning");
        return false;
      } else if (totallhp == 0) {
        swal("Oops!", "LHP Untuk Sales Pada Tanggal Ini Tidak Ada!", "warning");
        return false;
      } else if (salesman == "") {
        swal("Oops!", "Salesman Harus Diisi!", "warning");
        return false;
      } else if (ceksetoran > 0) {
        swal("Oops!", "Data ini Sudah Ada!", "warning");
        return false;
      } else {

        return true;
      }

    });


  })
</script>