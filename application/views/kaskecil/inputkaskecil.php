<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>kaskecil/insert_kaskecil">
  <input type="hidden" id="cekdetailtmp">
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
  <div class="row mb-3">
    <input type="text" id="nobukti_input" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt2" />
  </div>
</form>
<script>
  flatpickr(document.getElementById('tanggal'), {});
</script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  var jumlah = document.getElementById("jumlah");
  jumlah.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    jumlah.value = formatRupiah(this.value, "");
  });

  /* Fungsi formatRupiah */
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
</script>
<script type="text/javascript">
  $(function() {
    function loaddetailkaskeciltemp() {
      $("#loaddetailkaskeciltemp").load(
        "<?php echo base_url(); ?>kaskecil/view_detailkaskeciltemp"
      );
    }

    function reset() {
      $("#keterangan").val("");
      $("#jumlah").val("");
    }

    function cekdetailtmp() {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>kaskecil/cek_detailtmp",
        cache: false,
        success: function(respond) {
          console.log(respond);
          $("#cekdetailtmp").val(respond);
        }
      });
    }
    loaddetailkaskeciltemp();
    $(".datepicker").bootstrapMaterialDatePicker({
      format: "YYYY-MM-DD",
      clearButton: true,
      weekStart: 1,
      time: false
    });

    $("#kodeakun").click(function(e) {
      $("#coa").modal("show");
    });

    $("#kodeakun").selectpicker("refresh");

    $("#add").click(function(e) {
      var keterangan = $("#keterangan").val();
      var jumlah = $("#jumlah").val();
      var kodeakun = $("#kodeakun").val();
      var debetkredit = "D";
      if (keterangan == "") {
        swal("Oops!", "Keterangan Diisi!", "warning");
      } else if (jumlah == "") {
        swal("Oops!", "Jumlah Harus Diisi!", "warning");
      } else if (kodeakun == "") {
        swal("Oops!", "Kode Akun harus Diisi!", "warning");
      } else {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>kaskecil/insert_detailkaskeciltemp",
          data: {
            keterangan: keterangan,
            jumlah: jumlah,
            kodeakun: kodeakun,
            debetkredit
          },
          cache: false,
          success: function(respond) {
            loaddetailkaskeciltemp();
            reset();
            cekdetailtmp();
          }
        });
      }
    });
    $("#formValidate").submit(function() {
      var tanggal = $("#tanggal").val();
      var nobukti = $("#nobukti_input").val();
      var penerima = $("#penerima").val();
      var cekdetailtmp = $("#cekdetailtmp").val();
      if (tanggal == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        $("#tanggal").focus();
        return false;
      } else if (nobukti == "") {
        swal("Oops!", "No Bukti Masih Kosong!", "warning");
        $("#nobukti").focus();
        return false;
      } else if (penerima == "") {
        swal("Oops!", "Penerima Masih Kosong!", "warning");
        $("#penerima").focus();
        return false;
      } else if (cekdetailtmp < 1) {
        swal("Oops!", "Data Masih Kosong!", "warning");
      } else {
        return true;
      }
    });
  });
</script>