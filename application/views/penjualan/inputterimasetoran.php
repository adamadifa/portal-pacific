<form autocomplete="off" class="formValidate" name="autoSumForm" id="formValidate" method="POST" action="<?php echo base_url(); ?>penjualan/terimasetoran">
  <input type="hidden" value="<?php echo $setoranpusat['kode_setoranpusat']; ?>" name="kode_setoranpusat" class="form-control">
  <table class="table table-striped">
    <tr>
      <th>Tgl Setoran</th>
      <td><?php echo $setoranpusat['tgl_setoranpusat']; ?></td>
    </tr>
    <tr>
      <th>Keterangan</th>
      <td><?php echo $setoranpusat['keterangan']; ?></td>
    </tr>
    <tr>
      <th>Cabang</th>
      <td><?php echo $setoranpusat['kode_cabang']; ?></td>
    </tr>
    <tr>
      <th>Via</th>
      <td><?php echo $setoranpusat['bank']; ?></td>
    </tr>
    <?php if (empty($setoranpusat['no_ref'])) { ?>
      <tr>
        <th>Uang Kertas</th>
        <td align="right"><?php echo number_format($setoranpusat['uang_kertas'], '0', '', '.'); ?></td>
      </tr>
      <tr>
        <th>Uang Logam</th>
        <td align="right"><?php echo number_format($setoranpusat['uang_logam'], '0', '', '.'); ?></td>
      </tr>
    <?php } else { ?>
      <tr>
        <th>No Ref</th>
        <td><?php echo $setoranpusat['no_ref']; ?></td>
      </tr>
      <?php if (!empty($setoranpusat['giro'])) { ?>
        <tr>
          <th>Giro</th>
          <td align="right"><?php echo number_format($setoranpusat['giro'], '0', '', '.'); ?></td>
        </tr>
      <?php } ?>
      <?php if (!empty($setoranpusat['transfer'])) { ?>
        <tr>
          <th>Transfer</th>
          <td align="right"><?php echo number_format($setoranpusat['transfer'], '0', '', '.'); ?></td>
        </tr>
      <?php } ?>
    <?php } ?>

  </table>
  <hr>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="date" required value="<?php echo $setoranpusat['tgl_setoranpusat']; ?>" id="tgl_terimapusat" name="tgl_terimapusat" class="form-control" placeholder="Tanggal Terima Pusat" />
        <span class="input-icon-addon">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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

  <div class="form-group" id="bank">
    <label class="form-label">Bank Penerima</label>
    <select required class="form-select showtick" id="bank_penerima" name="bank_penerima">
      <option value="">-- Pilih Bank --</option>
      <?php foreach ($lbank as $b) { ?>
        <option value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
      <?php } ?>
    </select>
    <div class="errorTxt5"></div>
  </div>
  <label class="form-label">Omset Bulan</label>
  <div class="form-group">
    <div class="form-line">
      <select required class="form-select show-tick" id="bulan" name="bulan" data-error=".errorTxt1">
        <option value="">Bulan</option>
        <?php
        $bulanini = date("m");
        for ($i = 1; $i < count($bulan); $i++) {
        ?>
          <option <?php if ($bulanini == $i) {
                    echo "selected";
                  } ?> value="<?php echo $i; ?>"><?php echo $bulan[$i]; ?></option>
        <?php
        }
        ?>
      </select>
    </div>
    <div class="errorTxt1"></div>
  </div>
  <label class="form-label">Omset Tahun</label>
  <div class="form-group">
    <div class="form-line">
      <select required class="form-select show-tick" id="tahun2" name="tahun" data-error=".errorTxt1">
        <?php
        $tahunmulai = 2020;

        for ($thn = $tahunmulai; $thn <= date('Y'); $thn++) {
        ?>
          <option <?php if (date('Y') == $thn) {
                    echo "Selected";
                  } ?> value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
        <?php
        }
        ?>
      </select>
    </div>
    <div class="errorTxt1"></div>
  </div>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>SIMPAN</button>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tgl_terimapusat'), {
    position: "auto"
  });
</script>