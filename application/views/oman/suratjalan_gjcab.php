<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA SURAT JALAN
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
            <h4 class="card-title"> DATA SURAT JALAN </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>oman/suratjalan_gjcab" autocomplete="off">
              <div class="form-group mb-3">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <i class="fa fa-barcode"></i>
                  </span>
                  <input type="text" value="<?php echo $no_sj; ?>" name="no_sj" class="form-control" placeholder="No Surat Jalan" />
                </div>
              </div>
              <div class="form-group mb-3">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <i class="fa fa-calendar-o"></i>
                  </span>
                  <input type="text" value="<?php echo $tgl_sj; ?>" name="tgl_sj" id="tgl_sj" class="form-control datepicker" placeholder="Tanggal" />
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
                    <th width="10px">No</th>
                    <th>No. Surat Jalan</th>
                    <th>Tanggal</th>
                    <th>Status SJ</th>
                    <th>Tgl Diterima / Transit Out</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno  = $row + 1;
                  foreach ($result as $d) {
                    if ($d['status_sj'] == 0) {
                      $color_sj       = "bg-red";
                      $status_sj      = "Belum di Terima Cabang";
                      $tgl_terima_sj  = "";
                    } else if ($d['status_sj'] == 2) {
                      $color_sj       = "bg-blue";
                      $status_sj      = "Transit Out";
                      $tgl_sj         = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $d['no_mutasi_gudang']))->row_array();
                      $tgl_diterima   = $tgl_sj['tgl_mutasi_gudang_cabang'];
                      $tgl_terima     = explode("-", $tgl_diterima);
                      $harisjc        = $tgl_terima[2];
                      $bulansjc       = $tgl_terima[1];
                      $tahunsjc       = $tgl_terima[0];
                      $tgl_terima_sj  = $harisjc . "/" . $bulansjc . "/" . substr($tahunsjc, 2, 2);
                    } else if ($d['status_sj'] == 1) {
                      $color_sj       = "bg-green";
                      $status_sj      = "Sudah di Terima Cabang";
                      $cek_sj         = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $d['no_mutasi_gudang'], 'jenis_mutasi' => 'TRANSIT IN'))->num_rows();
                      if ($cek_sj != 0) {
                        $tgl_sj  = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $d['no_mutasi_gudang'], 'jenis_mutasi' => 'TRANSIT IN'))->row_array();
                      } else {
                        $tgl_sj  = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $d['no_mutasi_gudang']))->row_array();
                      }
                      $tgl_diterima   = $tgl_sj['tgl_mutasi_gudang_cabang'];
                      $tgl_terima     = explode("-", $tgl_diterima);
                      $harisjc        = $tgl_terima[2];
                      $bulansjc       = $tgl_terima[1];
                      $tahunsjc       = $tgl_terima[0];
                      $tgl_terima_sj  = $harisjc . "/" . $bulansjc . "/" . substr($tahunsjc, 2, 2);
                    }
                    $tanggal = explode("-", $d['tgl_mutasi_gudang']);
                    $hari    = $tanggal[2];
                    $bulan   = $tanggal[1];
                    $tahun   = $tanggal[0];
                    $tgl     = $hari . "/" . $bulan . "/" . substr($tahun, 2, 2);

                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td>
                        <a href="#" data-sj="<?php echo $d['no_mutasi_gudang']; ?>" class="detailsj">
                          <?php echo $d['no_mutasi_gudang']; ?>
                        </a>
                      </td>
                      <td><?php echo $tgl; ?></td>
                      <?php if ($d['tgl_mutasi_gudang'] < '2019-09-30') { ?>
                        <td><span class="badge bg-blue">Reset</span></td>
                        <td><span class="badge bg-blue">Reset</span></td>
                        <td><span class="badge bg-blue">Reset</span></td>
                      <?php } else { ?>
                        <td><span class="badge <?php echo $color_sj; ?>"><?php echo $status_sj; ?></span></td>
                        <td><span class="badge <?php echo $color_sj; ?>"><?php echo $tgl_terima_sj; ?></td>
                        <td>
                          <?php if ($d['status_sj'] == 0) { ?>
                            <a href="#" data-sj="<?php echo $d['no_mutasi_gudang']; ?>" class="btn btn-success btn-sm approve">Approve</a>
                          <?php } else { ?>
                            <a href="<?php echo base_url(); ?>oman/cancel_suratjalan_gjcab/<?php echo $d['no_mutasi_gudang']; ?>/<?php echo $this->uri->segment(3); ?>" class="btn btn-danger btn-sm">Batalkan</a>
                          <?php } ?>
                        </td>
                      <?php } ?>
                    </tr>
                  <?php
                    $sno++;
                  }
                  ?>
                </tbody>
              </table>
              <div style='margin-top: 10px;'>
                <?php echo $pagination; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_gudangcabang_administrator'); ?>
    </div>
  </div>
  <div class="modal modal-blur fade" id="detailsj" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title">Detail</h5>
        </div>
        <div class="modal-body">
          <div id="loaddetailsj"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="inputsuratjalan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title">Approve Surat Jalan</h5>
        </div>
        <div class="modal-body">
          <div id="loadinputsuratjalan"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    flatpickr(document.getElementById('tgl_sj'), {});
  </script>
  <script type="text/javascript">
    $(function() {
      $('.detailsj').click(function(e) {
        e.preventDefault();
        var no_sj = $(this).attr('data-sj');
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>oman/detail_sjcab',
          data: {
            no_sj: no_sj
          },
          cache: false,
          success: function(respond) {
            $("#loaddetailsj").html(respond);
          }
        });
        $("#detailsj").modal("show");
      });

      $('.approve').click(function(e) {
        e.preventDefault();
        var no_sj = $(this).attr('data-sj');
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>oman/input_suratjalanacc',
          data: {
            no_sj: no_sj
          },
          cache: false,
          success: function(respond) {
            $("#loadinputsuratjalan").html(respond);
          }
        });
        $("#inputsuratjalan").modal("show");
      });
    });
  </script>