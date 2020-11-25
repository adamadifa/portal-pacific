<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA TRANSIT IN / OUT
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">DATA TRANSIT IN / OUT </h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>oman/transit_in" autocomplete="off">
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
                      <th>Transit OUT</th>
                      <th>Transit IN</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno  = $row + 1;
                    foreach ($result as $d) {
                      $tanggal        = explode("-", $d['tgl_mutasi_gudang_cabang']);
                      $hari           = $tanggal[2];
                      $bulan          = $tanggal[1];
                      $tahun          = $tanggal[0];
                      $tgl_to         = $hari . "/" . $bulan . "/" . substr($tahun, 2, 2);
                      $transit_in     = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $d['no_suratjalan'], 'jenis_mutasi' => 'TRANSIT IN'));
                      $cek_transit_in = $transit_in->num_rows();
                      if ($cek_transit_in != 0) {
                        $t_in           = $transit_in->row_array();
                        $tgl_tin        = explode("-", $t_in['tgl_mutasi_gudang_cabang']);
                        $hari_tin       = $tgl_tin[2];
                        $bulan_tin      = $tgl_tin[1];
                        $tahun_tin      = $tgl_tin[0];
                        $tgl_transit_in = $hari_tin . "/" . $bulan_tin . "/" . substr($tahun_tin, 2, 2);
                      } else {
                        $tgl_transit_in = "";
                      }
                    ?>
                      <tr>
                        <td><?php echo $sno; ?></td>
                        <td>
                          <a href="#" data-sj="<?php echo $d['no_suratjalan']; ?>" class="detailsj">
                            <?php echo $d['no_suratjalan']; ?>
                          </a>
                        </td>
                        <td><span class="badge bg-blue"><?php echo $tgl_to; ?></td>
                        <td>
                          <?php if ($cek_transit_in != 0) { ?>
                            <span class="badge bg-green"><?php echo $tgl_transit_in; ?>
                            <?php } ?>
                        </td>
                        <td>
                          <?php if ($cek_transit_in == 0) { ?>
                            <a href="#" data-sj="<?php echo $d['no_suratjalan']; ?>" data-to="<?php echo $d['no_mutasi_gudang_cabang']; ?>" class="btn btn-green btn-sm approve">Approve</a>
                          <?php } else { ?>
                            <a href="<?php echo base_url(); ?>oman/cancel_transit_in/<?php echo $d['no_suratjalan']; ?>" class="btn btn-red btn-sm">Batalkan</a>
                          <?php } ?>
                        </td>
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
    </div>
    <div class="col-md-2">
      <?php
      $level = $this->session->userdata('level_user');
      if ($level == "Administrator") {
        $this->load->view('menu/menu_gudangcabang_administrator');
      } else if ($level == "admin gudang") {
        $this->load->view('menu/menu_transaksi_admingudang');
      }
      ?>
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
        var no_to = $(this).attr('data-to');
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>oman/input_transit_in',
          data: {
            no_sj: no_sj,
            no_to: no_to
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