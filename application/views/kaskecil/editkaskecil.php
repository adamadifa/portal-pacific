<div class="card">
  <div class="header bg-cyan">
    <h2>
      Data Kas Kecil
      <small>Input Kas Kecil</small>
    </h2>

  </div>
  <div class="body">
    <div class="row clearfix">
      <div class="col-sm-12">
        <form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>kaskecil/update_kaskecil">
          <input type="hidden" id="cekdetailtmp">
          <div class="row">
            <div class="body">
              <label>Tanggal</label>
              <div class="input-group demo-masked-input">
                <span class="input-group-addon">
                  <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $kaskecil['tgl_kaskecil']; ?>" id="tanggal" name="tanggal" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt1" />
                </div>
                <div class="errorTxt1"></div>
              </div>
              <label>No Bukti</label>
              <div class="input-group demo-masked-input">
                <span class="input-group-addon">
                  <i class="material-icons">chrome_reader_mode</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $kaskecil['nobukti']; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti" data-error=".errorTxt2" />
                  <input type="hidden" value="<?php echo $kaskecil['nobukti']; ?>" id="nobukti_old" name="nobukti_old" class="form-control" placeholder="No Bukti" data-error=".errorTxt2" />
                </div>
                <div class="errorTxt2"></div>
              </div>
              <label>Diberikan Kepada</label>
              <div class="input-group demo-masked-input">
                <span class="input-group-addon">
                  <i class="material-icons">assignment_ind</i>
                </span>
                <div class="form-line">
                  <input type="text" value="<?php echo $kaskecil['penerima']; ?>" id="penerima" name="penerima" class="form-control" placeholder="Diberikan Kepada" data-error=".errorTxt2" />
                </div>
                <div class="errorTxt2"></div>
              </div>
              <label>Keterangan</label>
              <div class="input-group demo-masked-input">
                <span class="input-group-addon">
                  <i class="material-icons">assignment</i>
                </span>
                <div class="form-line">
                  <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt2" />
                </div>
                <div class="errorTxt2"></div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="body">
              <div class="col-md-4">
                <label>Jumlah</label>
                <div class="input-group">
                  <div class="form-line">
                    <input type="text" style="text-align:right" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah" data-error=".errorTxt2" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <label>Akun</label>
                <div class="input-group">
                  <div class="form-line">
                    <select class="form-control show-tick " id="kodeakun" name="kodeakun" data-error=".errorTxt1" data-live-search="true">
                      <?php foreach ($coa as $r) { ?>
                        <option value="<?php echo $r->kode_akun; ?>"><?php echo $r->kode_akun . " " . $r->nama_akun; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2" style="margin-top:20px">
                <a href="#" id="add" class="btn bg-blue waves-effect">
                  <i class="material-icons">add_shopping_cart</i>
                </a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="body">
              <table class="table table-bordered table-striped table-hover">
                <thead class="bg-cyan">
                  <tr>
                    <th>Keterangan</th>
                    <th>Akun</th>
                    <th class="bg-red">Jumlah</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="loaddetailkaskecil">
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="body">
              <div class="form-group">
                <button type="submit" name="submit" class="btn bg-blue waves-effect">
                  <i class="material-icons">save</i>
                  <span>SIMPAN</span>
                </button>
                <a href="#" class="btn bg-red waves-effect">
                  <i class="material-icons">cancel</i>
                  <span>Hapus</span>
                </a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  var jumlah = document.getElementById('jumlah');
  jumlah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    jumlah.value = formatRupiah(this.value, '');
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
    function loaddetailkaskecil() {
      var nobukti = $("#nobukti").val();
      $("#loaddetailkaskecil").load('<?php echo base_url(); ?>kaskecil/view_detailkaskecil/' + nobukti);
    }
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
          type: 'POST',
          url: '<?php echo base_url(); ?>kaskecil/insert_detailkaskeciltemp',
          data: {
            keterangan: keterangan,
            jumlah: jumlah,
            kodeakun: kodeakun,
            debetkredit: debetkredit
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
    loaddetailkaskecil();

  });
</script>