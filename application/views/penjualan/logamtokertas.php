<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Ganti Logam Ke Kertas
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Ganti Logam Ke Kertas</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="<?php echo base_url() ?>penjualan/logamtokertas" autocomplete="off">
            <?php if ($sess_cab == 'pusat') { ?>
              <div class="mb-3">
                <select name="cabang" id="cabang" class="form-select">
                  <option value="">-- Pilih Cabang --</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option <?php if ($cbg == $c->kode_cabang) {
                              echo "selected";
                            } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else { ?>
              <input type="hidden" name="cabang" id="cabang" value="<?php echo $sess_cab; ?>">
            <?php } ?>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-icon">
                    <input id="dari" type="date" value="<?php echo $dari; ?>" placeholder="Dari" class="form-control" name="dari" />
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

                <div class="col-md-6">
                  <div class="input-icon">
                    <input id="sampai" type="date" value="<?php echo $sampai; ?>" placeholder="Sampai" class="form-control" name="sampai" />
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
            </div>
            <div class="mb-3">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <hr>
          <a href="#" class="btn btn-danger mb-3" id="inputlogamtokertas"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
          <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Cabang</th>
                <th>Jumlah</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (empty($result)) {
              ?>
                <tr>
                  <td colspan="5">
                    <div class="alert alert-warning" role="alert">
                      Data Tidak Ditemukan / Silahkan Pilih Periode Tanggal & Cabang Terlebih Dahulu !
                    </div>
                  </td>
                </tr>
                <?php
              } else {
                $sno  = 1;
                foreach ($result as $d) {
                  $tanggal  = explode("-", $d['tgl_logamtokertas']);
                  $tahun    = $tanggal[0];
                  $bulan    = $tanggal[1];
                  $hari     = $tanggal[2];
                  $thn      = substr($tahun, 2, 2);
                  $tgl      = $hari . "/" . $bulan . "/" . $thn;
                ?>
                  <tr>
                    <td><?php echo $sno; ?></td>
                    <td><?php echo $tgl; ?></td>
                    <td><?php echo $d['kode_cabang']; ?></td>
                    <td style="font-weight:bold; text-align:right"><?php echo number_format($d['jumlah_logamtokertas'], '0', '', '.'); ?></td>
                    <td>
                      <a href="#" data-kodelogamtokertas="<?php echo $d['kode_logamtokertas'] ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
                      <a href="#" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url(); ?>penjualan/hapus_logamtokertas/<?php echo $d['kode_logamtokertas']; ?>/<?php echo $d['kode_cabang']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                    </td>
                  </tr>
              <?php $sno++;
                }
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_kasbesar_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="forminputlogamtokertas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Ganti Logam Ke Kertas</h5>
      </div>
      <div class="modal-body">
        <div id="loadforminput"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="formeditlogamtokertas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Ganti Logam Ke Kertas</h5>
      </div>
      <div class="modal-body">
        <div id="loadformedit"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-title">
          Yakin Untuk Di Hapus ?
        </div>
        <div>Jika Di Hapus, Kamu Akan Kehilangan Data Ini !</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete">Yes, Hapus !</a>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      flatpickr(document.getElementById('dari'), {});
      flatpickr(document.getElementById('sampai'), {});
    });
  </script>
  <script>
    $(function() {
      $("#inputlogamtokertas").click(function(e) {
        e.preventDefault();
        $("#forminputlogamtokertas").modal({
          backdrop: "static", //remove ability to close modal with click
          keyboard: false, //remove option to close with keyboard
          show: true //Display loader!
        });
        $("#loadforminput").load("<?php echo base_url(); ?>penjualan/inputlogamtokertas");
      });

      $(".edit").click(function(e) {
        e.preventDefault();
        var kodelogamtokertas = $(this).attr("data-kodelogamtokertas");
        //alert(kodesetoran);
        $("#formeditlogamtokertas").modal({
          backdrop: "static", //remove ability to close modal with click
          keyboard: false, //remove option to close with keyboard
          show: true //Display loader!
        });
        $("#loadformedit").load("<?php echo base_url(); ?>penjualan/editlogamtokertas/" + kodelogamtokertas);
      });

      $(".hapus").click(function() {
        var href = $(this).attr("data-href");
        //alert(href);
        $("#hapusdata").modal({
          backdrop: "static", //remove ability to close modal with click
          keyboard: false, //remove option to close with keyboard
          show: true //Display loader!
        });
        $(".delete").attr("href", href);
      });
    })
  </script>