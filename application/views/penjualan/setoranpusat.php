<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Setoran ke Pusat
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Setoran ke Pusat</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="<?php echo base_url() ?>penjualan/setoranpusat" autocomplete="off">
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
            <div class="form-group mb-3">
              <select class="form-select" id="bank" name="bank">
                <option value="">-- Semua Bank --</option>
                <option <?php if ($bank == "BCA") {
                          echo "selected";
                        } ?> value="BCA">BCA</option>
                <option <?php if ($bank == "BCA CV") {
                          echo "selected";
                        } ?> value="BCA CV">BCA CV</option>
                <option <?php if ($bank == "BNI") {
                          echo "selected";
                        } ?> value="BNI">BNI</option>
                <option <?php if ($bank == "BNI CV") {
                          echo "selected";
                        } ?> value="BNI CV">BNI CV</option>
                <option <?php if ($bank == "PERMATA") {
                          echo "selected";
                        } ?> value="PERMATA">PERMATA</option>
                <option <?php if ($bank == "KAS") {
                          echo "selected";
                        } ?> value="KAS">KAS</option>
              </select>
            </div>
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
                        <line x1="12" y1="15" x2="12" y2="18" />
                      </svg>
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
                        <line x1="12" y1="15" x2="12" y2="18" />
                      </svg>
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
          <div class="d-flex justify-content-between">
            <div>
              <a href="#" class="btn btn-danger mb-3" id="inputsetoranpusat"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
            </div>
            <div>
              <?php
              if (empty($cbg)) {
                $cabang = "-";
              } else {
                $cabang = $cbg;
              }

              if (empty($salesman)) {
                $sales = "-";
              } else {
                $sales = $salesman;
              }

              if (empty($dari)) {
                $dr = "-";
              } else {
                $dr = $dari;
              }

              if (empty($sampai)) {
                $sm = "-";
              } else {
                $sm = $sampai;
              }
              $url = base_url() . "laporanpenjualan/cetak_setoranpusat/" . $cabang . "/" . $sales . "/" . $dr . "/" . $sm;
              ?>
              <a href="<?php echo $url . "/cetak"; ?>" target="_blank" class="btn btn-primary mr-2" id="cetak_setoranpenjualan"><i class="fa fa-print"></i></a>
              <a href="<?php echo $url . "/download"; ?>" class="btn btn-success" id="download_setoranpenjualan"><i class="fa fa-download"></i></a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead class="thead-dark">
                <tr>
                  <th>TGL</th>
                  <th style="width:40% !important">SETORAN</th>
                  <th>BANK</th>
                  <th>KERTAS</th>
                  <th>LOGAM</th>
                  <th>TRANSFER</th>
                  <th>GIRO</th>
                  <th>JUMLAH</th>
                  <th>AKSI</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($jmldata)) {
                ?>
                  <tr>
                    <td colspan="9">
                      <div class="alert alert-warning" role="alert">
                        Silahkan Pilih Periode Tanggal & Cabang Terlebih Dahulu !
                      </div>
                    </td>
                  </tr>
                  <?php
                } else {
                  foreach ($result as $d) {
                    $tanggal        = explode("-", $d['tgl_setoranpusat']);
                    $tahun          = $tanggal[0];
                    $bulan          = $tanggal[1];
                    $hari           = $tanggal[2];
                    $thn            = substr($tahun, 2, 2);
                    $tgl            = $hari . "/" . $bulan . "/" . $thn;
                    $jumlahsetoran  = $d['uang_kertas'] + $d['uang_logam'] + $d['giro'] + $d['transfer'];
                  ?>
                    <tr>
                      <td><?php echo $tgl; ?></td>
                      <td><b><?php echo strtoupper($d['keterangan']); ?></b></td>
                      <td><?php echo $d['bank']; ?></td>
                      <td align="right"><b><?php if ($d['uang_kertas'] != 0) {
                                              echo number_format($d['uang_kertas'], '0', '', '.');
                                            } ?></b></td>
                      <td align="right"><b><?php if ($d['uang_logam'] != 0) {
                                              echo number_format($d['uang_logam'], '0', '', '.');
                                            } ?></b></td>
                      <td align="right"><b><?php if ($d['transfer'] != 0) {
                                              echo number_format($d['transfer'], '0', '', '.');
                                            } ?></b></td>
                      <td align="right"><b><?php if ($d['giro'] != 0) {
                                              echo number_format($d['giro'], '0', '', '.');
                                            } ?></b></td>
                      <td align="right"><b><?php if ($jumlahsetoran != 0) {
                                              echo number_format($jumlahsetoran, '0', '', '.');
                                            } ?></b></td>
                      <td>
                        <?php
                        //echo $d['status'];
                        $level_user = $this->session->userdata('level_user');
                        //echo $level_user;
                        if ($level_user != "keuangan" or $level_user != "Administrator") {
                          if (empty($d['no_ref']) && $d['status'] != 1 || empty($d['no_ref']) && $d['status'] == 0) { ?>
                            <a href="#" data-status="0" data-kodesetoranpusat="<?php echo $d['kode_setoranpusat'] ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
                            <a href="#" data-href="<?php echo base_url(); ?>penjualan/hapus_setoranpusat/<?php echo $d['kode_setoranpusat']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                            <?php
                          } else {
                            if ($d['status'] == 1) {
                            ?>
                              <span class="badge bg-green"><?php echo DateToIndo2($d['tgl_diterimapusat']); ?></span>
                              <a href="#" data-status="1" data-kodesetoranpusat="<?php echo $d['kode_setoranpusat'] ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
                            <?php
                            } else if ($d['status'] == 2) {
                            ?>
                              <span class="badge bg-red">Ditolak</span>
                            <?php
                            } else {
                            ?>
                              <span class="badge bg-orange">Belum Diterima</span>
                              <a href="#" data-href="<?php echo base_url(); ?>penjualan/hapus_setoranpusat/<?php echo $d['kode_setoranpusat']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                          <?php
                            }
                          }
                        } else {
                          ?>
                          <a href="#" data-href="<?php echo base_url(); ?>penjualan/hapus_setoranpusat/<?php echo $d['kode_setoranpusat']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_kasbesar_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="setoranpusat" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Setoran Pusat</h5>
      </div>
      <div class="modal-body">
        <div id="content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="editsetoranpusat" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Setoran Pusat</h5>
      </div>
      <div class="modal-body">
        <div id="contentedit"></div>
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
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('dari'), {});
    flatpickr(document.getElementById('sampai'), {});
  });
</script>
<script>
  $(function() {
    $("#inputsetoranpusat").click(function(e) {
      e.preventDefault();
      $("#setoranpusat").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#content").load("<?php echo base_url(); ?>penjualan/inputsetoranpusat");
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var kodesetoranpusat = $(this).attr("data-kodesetoranpusat");
      var status = $(this).attr("data-status"); //alert(kodesetoran);
      $("#editsetoranpusat").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#contentedit").load("<?php echo base_url(); ?>penjualan/editsetoranpusat/" + kodesetoranpusat + "/" + status);
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