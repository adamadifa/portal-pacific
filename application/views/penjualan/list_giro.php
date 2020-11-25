<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Pembayaran Giro
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Data Pembayaran Giro</h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>penjualan/listgiro" autocomplete="off">
              <div class="mb-3">
                <input type="text" id="nogiro" value="<?php echo $nogiro; ?>" name="nogiro" class="form-control" placeholder="No Giro">
              </div>
              <div class="mb-3">
                <input id="nofaktur" value="<?php echo $nofaktur; ?>" name="nofaktur" class="form-control" placeholder="No Faktur">
              </div>
              <div class="mb-3">
                <input type="text" value="<?php echo $namapel; ?>" id="namapel" name="namapel" class="form-control" placeholder="Nama Pelanggan">
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
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th>No</th>
                    <th>No. Faktur</th>
                    <th>Nama Pelanggan</th>
                    <th>Cabang</th>
                    <th>No. Giro</th>
                    <th>Bank</th>
                    <th>Jumlah</th>
                    <th>Tgl Giro</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Ket</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result == 0) {
                  ?>
                    <tr>
                      <td colspan="11">
                        <div class="alert alert-warning" role="alert">
                          Silahkan Lakukan Pencarian Data !
                        </div>
                      </td>
                    </tr>

                    <?php
                  } else {

                    $sno  = $row + 1;
                    foreach ($result as $d) {
                    ?>
                      <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $d['no_fak_penj']; ?></td>
                        <td><?php echo $d['nama_pelanggan']; ?></td>
                        <td><?php echo $d['kode_cabang']; ?></td>
                        <td><?php echo $d['no_giro']; ?></td>
                        <td><?php echo $d['namabank']; ?></td>

                        <td align="right"><?php echo number_format($d['jumlah'], '0', '', '.'); ?></td>
                        <td>
                          <?php
                          if (!empty($d['tgl_giro'])) {

                            $tgl_giro = explode("-", $d['tgl_giro']);
                            $tglgiro  = $tgl_giro[2] . "/" . $tgl_giro[1] . "/" . $tgl_giro[0];
                            echo $tglgiro;
                          }

                          ?>
                        </td>
                        <td>
                          <?php
                          $tgl_cair = explode("-", $d['tglcair']);
                          $tglcair  = $tgl_cair[2] . "/" . $tgl_cair[1] . "/" . $tgl_cair[0];
                          echo $tglcair;
                          ?>
                        </td>

                        <td>
                          <?php
                          if ($d['status'] == 0) {
                          ?>
                            <span class="badge bg-orange">Pending</span>
                          <?php
                          } elseif ($d['status'] == 1) {
                          ?>
                            <span class="badge bg-green"><?php echo DateToIndo2($d['tglbayar']); ?></span>
                          <?php
                          } elseif ($d['status'] == 2) {

                          ?>
                            <span class="badge bg-red">Ditolak</span>
                          <?php
                          }
                          ?>
                        </td>
                        <td><?php echo $d['ket']; ?></td>

                      </tr>

                  <?php $sno++;
                    }
                  }
                  ?>
                </tbody>

              </table>
            </div>
            <div style='margin-top: 10px;'>
              <?php echo $pagination; ?>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('dari'), {});
    flatpickr(document.getElementById('sampai'), {});
  });
</script>