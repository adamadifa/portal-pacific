<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Setoran Giro
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Setoran Giro</h4>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>penjualan/setorangiro" autocomplete="off">
            <div class="mb-3">
              <input type="text" id="nogiro" value="<?php echo $nogiro; ?>" name="nogiro" class="form-control" placeholder="No Giro">
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
            <div class="mb-3">
              <div class="form-group">
                <select class="form-select" id="status2" name="status2" data-error=".errorTxt1">
                  <option value="">-- Semua Status --</option>
                  <option <?php if ($status == "0") {
                            echo "selected";
                          } ?> value="0">Pending</option>
                  <option <?php if ($status == "1") {
                            echo "selected";
                          } ?> value="1">Diterima</option>
                  <option <?php if ($status == "2") {
                            echo "selected";
                          } ?> value="2">Ditolak</option>
                </select>
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
                  <th>No. Giro</th>
                  <th>Nama Pelanggan</th>
                  <th>Cabang</th>
                  <th>Nama Bank</th>
                  <th>Jumlah</th>
                  <th>Jatuh Tempo</th>
                  <th>Disetorkan</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($jmldata == 0) {
                ?>
                  <tr>
                    <td colspan="11">
                      <div class="alert alert-warning" role="alert">
                        Silahkan Lakukan Pencarian Data ! Periode Pencarian Harus Diisi !
                      </div>
                    </td>
                  </tr>

                  <?php
                } else {
                  $sno  = $row + 1;
                  foreach ($result as $d) {
                  ?>
                    <tr>
                      <td><?php echo $d['no_giro']; ?></td>
                      <td><?php echo $d['nama_pelanggan']; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td><?php echo $d['namabank']; ?></td>
                      <td align="right"><b><?php echo number_format($d['jumlah'], '0', '', '.'); ?></b></td>
                      <td><?php echo DateToIndo2($d['tglcair']); ?></td>
                      <td><?php if (!empty($d['tgl_setoranpusat'])) {
                            echo DateToIndo2($d['tgl_setoranpusat']);
                          } ?></td>
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
                      <td>
                        <?php if (empty($d['kode_setoranpusat'])) { ?>
                          <a href="#" data-id="<?php echo $d['no_giro']; ?>" class="btn btn-primary btn-sm detail"><i class="fa fa-list"></i></a>
                          <a href="#" data-id="<?php echo $d['no_giro']; ?>" data-tglbayar="<?php echo $d['tglbayar']; ?>" data-status="<?php echo $d['status']; ?>" class="btn btn-danger btn-sm setorgiro">Setorkan</a>

                          <?php } else {
                          if ($d['status'] == 0) {
                          ?>
                            <a href="#" data-id="<?php echo $d['no_giro']; ?>" class="btn btn-primary btn-sm detail"><i class="fa fa-list"></i></a>
                            <a href="<?php echo base_url(); ?>penjualan/batalkansetorangiro/<?php echo $d['no_giro'] ?>" class="btn btn-green btn-sm batalkan">Batalkan</a>
                        <?php
                          }
                        } ?>
                      </td>
                    </tr>
                <?php $sno++;
                  }
                } ?>
              </tbody>
            </table>
            <div style='margin-top: 10px;'>
              <?php echo $pagination; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_kasbesar_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailgiro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail giro</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetailgiro"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="setorgiro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Setorkan Giro</h5>
      </div>
      <div class="modal-body">
        <div id="loadsetorgiro"></div>
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
<script>
  $(function() {
    $(".detail").click(function(e) {
      e.preventDefault();
      var no_giro = $(this).attr('data-id');
      $("#detailgiro").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/detailgiro',
        data: {
          no_giro: no_giro
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailgiro").html(respond);
        }
      });
    });

    $(".setorgiro").click(function(e) {
      e.preventDefault();
      var no_giro = $(this).attr('data-id');
      var status = $(this).attr('data-status');
      var tglbayar = $(this).attr("data-tglbayar");
      var page = 'setorangiro';
      $("#setorgiro").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/setorgiro',
        data: {
          no_giro: no_giro,
          page: page,
          status: status,
          tglbayar: tglbayar
        },
        cache: false,
        success: function(respond) {
          $("#loadsetorgiro").html(respond);
        }
      });
    });
  })
</script>