<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Penerimaan Setoran
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Penerimaan Setoran</h4>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>penjualan/ceksetoranpusat" autocomplete="off">
            <div class="mb-3">
              <div class="row">
                <div class="col-md-12">
                  <select class="form-select" id="cabang" name="cabang" data-error=".errorTxt1">
                    <option value="">-- Semua Cabang --</option>
                    <?php foreach ($cabang as $c) { ?>
                      <option <?php if ($cbg == $c->kode_cabang) {
                                echo "selected";
                              } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-12">
                  <select class="form-select show-tick" id="bank" name="bank" data-error=".errorTxt1">
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
              </div>
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
            <div class="mb-3 d-flex justify-content-end">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <hr>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" style="font-size:13px">
              <thead class="thead-dark">
                <tr>
                  <th>TGL</th>
                  <th>SETORAN</th>
                  <th>BANK</th>
                  <th>KERTAS</th>
                  <th>LOGAM</th>
                  <th>TRANSFER</th>
                  <th>GIRO</th>
                  <th>JUMLAH</th>
                  <th>STATUS</th>
                  <th>AKSI</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($jmldata)) {
                ?>
                  <tr>
                    <td colspan="10">
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
                        if ($d['status'] == 0) {
                          echo "<span class='badge bg-orange'>Belum Di Terima</span>";
                        } else if ($d['status'] == 1) {
                          echo "<span class='badge bg-green'>$d[tgl_diterimapusat]</span>";
                        } else {
                          echo "<span class='badge bg-red'>Ditolak</span>";
                        }
                        ?>
                      </td>
                      <td>
                        <?php if (empty($d['no_ref'])) {
                          if ($d['status'] == 0) {
                        ?>
                            <a href="#" data-id="<?php echo $d['kode_setoranpusat'] ?>" class="btn btn-success btn-sm terimasetoran"><i class="fa fa-check"></i></a>
                          <?php
                          } else {
                          ?>
                            <a href="<?php echo base_url(); ?>penjualan/batalterimasetoran/<?php echo $d['kode_setoranpusat']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-close"></i></a>
                        <?php
                          }
                        }
                        ?>
                        <a href="#" data-id="<?php echo $d['kode_setoranpusat']; ?>" class="btn btn-primary btn-sm detail"><i class="fa fa-list"></i></a>
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
      <?php $this->load->view('menu/menu_keuangan_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail Setor</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetail"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="terimasetoran" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Terima Setoran</h5>
      </div>
      <div class="modal-body">
        <div id="loadterimasetoran"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
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
<script type="text/javascript">
  $(function() {
    $('.hapus').on('click', function() {
      var getLink = $(this).attr('href');
      swal({
        title: 'BatalkanSetoran ?',
        text: 'Apakah Anda Yakin Ingin Membatalkan Setoran  ini ?',
        html: true,
        confirmButtonColor: '#d9534f',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
      return false;
    });

    $(".detail").click(function(e) {
      e.preventDefault();
      var kode_setoran = $(this).attr('data-id');
      $("#detail").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/detailsetoranpusat',
        data: {
          kode_setoran: kode_setoran
        },
        cache: false,
        success: function(respond) {
          $("#loaddetail").html(respond);
        }
      });
    });

    $(".terimasetoran").click(function(e) {
      e.preventDefault();
      var kode_setoran = $(this).attr('data-id');
      $("#terimasetoran").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/inputterimasetoran',
        data: {
          kode_setoran: kode_setoran
        },
        cache: false,
        success: function(respond) {
          $("#loadterimasetoran").html(respond);
        }
      });
    });



  });
</script>