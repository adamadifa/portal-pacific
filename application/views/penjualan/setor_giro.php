<form autocomplete="off" class="formValidate" id="setorgiroform" method="POST" action="<?php echo base_url(); ?>penjualan/setorgiro">
  <input type="hidden" name="no_giro" value="<?php echo $giro['no_giro']; ?>">
  <input type="text" id="statusgiro" name="statusgiro" value="<?php echo $status; ?>">
  <input type="hidden" id="tglbayar" name="tglbayar" value="<?php echo $tglbayar; ?>">
  <input type="hidden" name="tgl_giro" value="<?php echo $giro['tgl_giro']; ?>">
  <input type="hidden" name="pelanggan" value="<?php echo $giro['nama_pelanggan']; ?>">
  <input type="hidden" name="cabang" value="<?php echo $giro['kode_cabang']; ?>">
  <input type="hidden" name="omset_bulan" value="<?php echo $giro['omset_bulan']; ?>">
  <input type="hidden" name="omset_tahun" value="<?php echo $giro['omset_tahun']; ?>">
  <input type="hidden" name="page" value="<?php echo $page; ?>">
  <table class="table">
    <tr>
      <td><b>Nama Pelanggan</b></td>
      <td>:</td>
      <td><?php echo $giro['nama_pelanggan']; ?></td>
    </tr>
    <tr>
      <td><b>No Giro</b></td>
      <td>:</td>
      <td><?php echo $giro['no_giro']; ?></td>
    </tr>
    <tr>
      <td><b>Nama Bank</b></td>
      <td>:</td>
      <td><?php echo $giro['namabank']; ?></td>
    </tr>
    <tr>
      <td><b>Jumlah</b></td>
      <td>:</td>
      <td><?php echo number_format($giro['jumlah'], '0', '', '.'); ?></td>
    </tr>
    <tr>
      <td><b>Jatuh Tempo</b></td>
      <td>:</td>
      <td><?php echo DateToIndo2($giro['tglcair']); ?></td>
    </tr>
  </table>
  <div class="row mb-3">
    <div class="col-md-12">
      <label class="form-label">Tanggal</label>
      <div class="input-icon">
        <input type="text" id="tglsetor" name="tglsetor" class="datepicker form-control date" placeholder="Tanggal Cair" data-error=".errorTxt1" />
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

  <div class="form-group mb-3">
    <label>Bank Penerima</label>
    <select class="form-select" id="bank_penerima" name="bank_penerima">
      <option value="">-- Pilih Bank --</option>
      <?php foreach ($bank as $b) { ?>
        <option value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
      <?php } ?>
    </select>
    <div class="errorTxt5"></div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="form-group">
        <label class="form-label">Jumlah</label>
        <div class="input-icon">
          <input type="text" value="<?php echo $giro['jumlah']; ?>" style="text-align:right" readonly id="jmlbayar" name="jmlbayar" class="form-control" placeholder="Jumlah Bayar" data-error=".errorTxt2" />
          <span class="input-icon-addon">
            <i class="fa fa-money"></i>
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
  flatpickr(document.getElementById('tglsetor'), {});
</script>
<script>
  $(function() {
    $("#setorgiroform").submit(function() {
      var tgl_setoran = $("#tglsetor").val();
      var bank_penerima = $("#bank_penerima").val();
      if (tgl_setoran == "") {
        swal("Oops!", "Tanggal Setoran Harus Diisi.. !", "warning");
        return false;
      } else if (bank_penerima == "") {
        swal("Oops!", "Bank Penerima Harus Diisi!", "warning");
        return false;
      } else {
        return true;
      }
    });
  })
</script>