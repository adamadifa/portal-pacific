<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">EDIT JURNAL UMUM</h4>
      </div>
      <div class="card-body">
        <div class="form-group mb-3">
          <div class="input-icon">
            <input type="text" value="<?php echo $getJurnal['no_bukti']; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-icon">
            <input type="text" value="<?php echo $getJurnal['tanggal']; ?>" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Tanggal" data-error=".errorTxt19" />
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-icon">
            <input type="text" value="<?php echo $getJurnal['keterangan']; ?>" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-icon">
            <select class="selectoption" id="kode_akuns">
              <option value="">AKUN</option>
              <?php foreach ($coa as $key => $d) { ?>
                <option <?php if ($getJurnal['kode_akun'] == $d->kode_akun) {
                          echo "selected";
                        } ?> value="<?php echo $d->kode_akun; ?>"><?php echo $d->kode_akun; ?> | <?php echo $d->nama_akun; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-icon">
            <input type="text" style="text-align: right;" value="<?php echo number_format($getJurnal['debet']); ?>" id="debet" name="debet" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
          </div>
        </div>
        <div class="form-group mb-3">
          <div class="input-icon">
            <input type="text" style="text-align: right;" value="<?php echo number_format($getJurnal['kredit']); ?>" id="kredit" name="kredit" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
          </div>
        </div>
        <div class="form-group mb-3">
          <a href="#" id="simpandata" class="btn btn-block btn-primary">Simpan</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('.selectoption').selectize({});
  });
</script>


<script type="text/javascript">
  var debet = document.getElementById('debet');
  debet.addEventListener('keyup', function(e) {
    debet.value = formatRupiah(this.value, '');
  });

  var kredit = document.getElementById('kredit');
  kredit.addEventListener('keyup', function(e) {
    kredit.value = formatRupiah(this.value, '');
  });

  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

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

    $('#simpandata').click(function(e) {
      e.preventDefault();
      var nobukti = $("#nobukti").val();
      var tanggal = $("#tanggal").val();
      var kredit = $("#kredit").val();
      var debet = $("#debet").val();
      var keterangan = $("#keterangan").val();
      var kode_akun = $("#kode_akuns").val();

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/update_jurnal_umum',
        data: {
          nobukti: nobukti,
          tanggal: tanggal,
          kredit: kredit,
          debet: debet,
          keterangan: keterangan,
          kode_akun: kode_akun
        },
        cache: false,
        success: function(respond) {
          $("#editjurnalumum").modal("hide");
          location.href = "<?php echo base_url(); ?>accounting/view_jurnal_umum"
        }
      });
    });

  });
</script>