<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/insertbelumsetorsales">
  <input type="hidden" id="ceksetoran" name="ceksetoran" class="form-control">
  <input type="hidden" readonly id="getsa" name="getsa" value="0" class="form-control" />
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="form-group">
        <div class="input-icon">
          <input type="text" id="kodebelumsetor" name="kodebelumsetor" class="form-control" placeholder="Kode Belum Setor">
          <span class="input-icon-addon">
            <i class="fa fa-barcode"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="date" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal" />
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
  <?php if ($cb == 'pusat') { ?>
    <div class="row mb-3">
      <div class="form-group">
        <select class="form-select cbg" id="cabanginput" name="cabang2">
          <option value="">Pilih Cabang</option>
          <?php foreach ($cabang as $c) { ?>
            <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  <?php } else { ?>
    <input type="hidden" readonly id="cabanginput" name="cabang2" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang" />
  <?php } ?>
  <div class="row mb-3">
    <div class="form-group">
      <select class="form-select bulan" id="bulan2" name="bulan">
        <option value="">Bulan</option>
        <?php for ($a = 1; $a <= 12; $a++) { ?>
          <option value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="form-group">
      <select class="form-select tahun" id="tahun2" name="tahun">
        <option value="">Tahun</option>
        <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
          <option value="<?php echo $t;  ?>"><?php echo $t; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="form-group">
      <select class="form-select salesman" id="salesman2" name="salesman">
        <option value="">Pilih Salesman</option>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Jumlah</label>
        <div class="input-icon">
          <input type="text" value="0" onkeyup="calc()" style="text-align:right; font-weight:bold; color:#dc3545" id="uangkertas" name="jumlah" class="form-control" placeholder="Jumlah" />
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-end">
    <a href="#" id="tambahsaldosales" class="btn btn-success btn-sm"><i class="fa fa-plus mr-2"></i>Tambah</a>
  </div>
  <hr>
  <table class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Salesman</th>
        <th>Jumlah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="loadsalestemp">

    </tbody>
  </table>
  <div class="row mt-3">
    <div class="form-group">
      <div class="d-flex justify-content-end">
        <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
      </div>
    </div>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script type="text/javascript">
  var uk = document.getElementById('uangkertas');

  uk.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    uk.value = formatRupiah(this.value, '');
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
    function loadsales() {
      var cabang = $("#cabanginput").val();
      //alert(cabang);
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/get_salesman',
        data: {
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $("#salesman2").html(respond);
        }
      });
    }
    loadsales();

    $("#cabanginput").change(function() {
      loadsales();
    });

    function loadNoMutasi() {
      var bulan = $("#bulan2").val();
      var cabang = $("#cabanginput").val();
      var tahun = $("#tahun2").val();
      var thn = tahun.substr(2, 2);
      if (parseInt(bulan.length) == 1) {
        var bln = "0" + bulan;
      } else {
        var bln = bulan;
      }
      var kode = "SABS" + cabang + bln + thn;
      $("#kodebelumsetor").val(kode);
    }

    function loadsalestemp() {
      var bulan = $("#bulan2").val();
      var cabang = $("#cabanginput").val();
      var tahun = $("#tahun2").val();

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/getbelumsetortemp',
        data: {
          bulan: bulan,
          tahun: tahun,
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $("#loadsalestemp").html(respond);
        }
      });
    }


    $("#cabanginput").change(function() {
      loadNoMutasi();
      loadsalestemp();
    });

    $("#bulan2").change(function() {
      loadNoMutasi();
      loadsalestemp();
    });

    $("#tahun2").change(function() {
      loadNoMutasi();
      loadsalestemp();
    });

    $("#tambahsaldosales").click(function(e) {
      e.preventDefault();
      //alert('test');
      //var getsa = $("#getsa").val();
      var bulan = $("#bulan2").val();
      var tahun = $("#tahun2").val();
      var salesman = $("#salesman2").val();
      var jumlah = $("#uangkertas").val();
      if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi !", "warning");
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi !", "warning");
      } else if (salesman == "") {
        swal("Oops!", "Salesman Harus Diisi !", "warning");
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Harus Diisi !", "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>penjualan/simpanbelumsetortemp',
          data: {
            bulan: bulan,
            tahun: tahun,
            salesman: salesman,
            jumlah: jumlah
          },
          cache: false,
          success: function(respond) {
            if (respond == 1) {
              swal("Oops!", "Data Sudah Ada.. !", "warning");
            }
            loadsalestemp();
            $("#uangkertas").val("");
            $("#uangkertas").focus();

          }
        });
      }
    });
    $("#formValidate").submit(function() {
      var tanggal = $(".tanggal").val();
      var cabang = $("#cabanginput").val();
      var bulan = $("#bulan2").val();
      var tahun = $("#tahun2").val();
      var getsa = $("#getsa").val();
      if (tanggal == "") {
        swal("Oops!", "Tanggal Harus Diisi.. !", "warning");
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi.. !", "warning");
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi.. !", "warning");
        return false;
      } else if (bulan == "") {
        swal("Oops!", "Bulan Harus Diisi.. !", "warning");
        return false;
      } else if (tahun == "") {
        swal("Oops!", "Tahun Harus Diisi.. !", "warning");
        return false;
      } else {
        return true;
      }
    });
  })
</script>