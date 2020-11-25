<?php
error_reporting(0);
?>
<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA PERMINTAAN PENGIRIMAN
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
            <h4 class="card-title">Data Permintaan Pengiriman </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>oman/view_suratjalan" autocomplete="off">
              <div class="mb-3">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <i class="fa fa-calendar-o"></i>
                  </span>
                  <input type="text" value="<?php echo $tgl_permintaan; ?>" id="tgl_permintaan" name="tgl_permintaan" class="form-control datepicker " placeholder="Tanggal" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="mb-3">
                <select class="form-select" id="cbg" name="cabang">
                  <option value="">Semua Cabang</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option <?php if ($cbg == $c->kode_cabang) {
                              echo "selected";
                            } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
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
                    <th>No. Permintaan</th>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th>Status Order</th>
                    <th>No. Surat Jalan</th>
                    <th>Tgl Surat Jalan</th>
                    <th>Status SJ</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno  = $row + 1;
                  foreach ($result as $d) {
                    if ($d['status'] == 0) {
                      $color = "bg-red";
                      $status = "Belum di Proses";
                    } else {
                      $color  = "bg-green";
                      $status = "Sudah di Proses";
                    }
                    $sj       = $this->db->get_where('mutasi_gudang_jadi', array('no_permintaan_pengiriman' => $d['no_permintaan_pengiriman']))->row_array();
                    $tanggal = explode("-", $d['tgl_permintaan_pengiriman']);
                    $hari    = $tanggal[2];
                    $bulan   = $tanggal[1];
                    $tahun   = $tanggal[0];
                    if (!empty($sj['tgl_mutasi_gudang'])) {
                      $tglsj     = explode("-", $sj['tgl_mutasi_gudang']);
                      $harisj    = $tglsj[2];
                      $bulansj   = $tglsj[1];
                      $tahunsj   = $tglsj[0];
                      $tglsj     = $harisj . "/" . $bulansj . "/" . substr($tahunsj, 2, 2);
                      if ($sj['status_sj'] == 0) {
                        $color_sj     = "bg-red";
                        $status_sj    = "Belum di Terima Cabang";
                        $tgl_diterima = "";
                      } else if ($sj['status_sj'] == 2) {
                        $color_sj       = "bg-blue";
                        $status_sj      = "Transit Out";
                        $tgl_sj         = $this->db->get_where('mutasi_gudang_cabang', array('no_suratjalan' => $sj['no_mutasi_gudang']))->row_array();
                        $tgl_diterima   = $tgl_sj['tgl_mutasi_gudang_cabang'];
                        $tgl_terima     = explode("-", $tgl_diterima);
                        $harisjc        = $tgl_terima[2];
                        $bulansjc       = $tgl_terima[1];
                        $tahunsjc       = $tgl_terima[0];
                        $tgl_terima_sj  = $harisjc . "/" . $bulansjc . "/" . substr($tahunsjc, 2, 2);
                      } else if ($sj['status_sj'] == 1) {
                        $color_sj       = "bg-green";
                        $status_sj      = "Sudah di Terima Cabang";
                        $tgl_sj         = $this->db->get_where('mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $sj['no_mutasi_gudang']))->row_array();
                        $tgl_diterima   = $tgl_sj['tgl_mutasi_gudang_cabang'];
                        $tgl_terima     = explode("-", $tgl_diterima);
                        $harisjc        = $tgl_terima[2];
                        $bulansjc       = $tgl_terima[1];
                        $tahunsjc       = $tgl_terima[0];
                        $tgl_terima_sj  = $harisjc . "/" . $bulansjc . "/" . substr($tahunsjc, 2, 2);
                      }
                    } else {
                      $tglsj     = "";
                      $color_sj  = "";
                      $status_sj = "";
                    }
                    $tgl = $hari . "/" . $bulan . "/" . substr($tahun, 2, 2);
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td>
                        <a href="#" data-nopermintaan="<?php echo $d['no_permintaan_pengiriman']; ?>" class="detail">
                          <?php echo $d['no_permintaan_pengiriman']; ?>
                        </a>
                      </td>
                      <td><?php echo $tgl; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td><span class="badge <?php echo $color; ?>"><?php echo $status; ?></span></td>
                      <td>
                        <a href="#" data-sj="<?php echo $sj['no_mutasi_gudang']; ?>" class="detailsj">
                          <?php echo $sj['no_mutasi_gudang']; ?>
                        </a>
                      </td>
                      <td><?php echo $tglsj; ?></td>
                      <td><span class="badge <?php echo $color_sj; ?>"><?php echo $status_sj; ?></span></td>
                      <td>
                        <?php if ($d['status'] == 0) { ?>
                          <a href="#" data-nopermintaan="<?php echo $d['no_permintaan_pengiriman']; ?>" class="btn btn-primary btn-sm inputsuratjalan">Buat Surat Jalan</a>
                        <?php } else if ($d['status'] == 1 and $sj['status_sj'] == 0) { ?>
                          <a href="<?php echo base_url(); ?>oman/hapus_sj/<?php echo $sj['no_mutasi_gudang']; ?>/<?php echo $d['no_permintaan_pengiriman']; ?>/<?php echo $this->uri->segment(3); ?>" class="btn btn-danger btn-sm">Batalkan</a>
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
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_gudangpusat_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailpermintaanpengiriman" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loadpermintaanpengiriman"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
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
        <h5 class="modal-title">Input Surat Jalan</h5>
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
  flatpickr(document.getElementById('tgl_permintaan'), {});
</script>
<script type="text/javascript">
  $(function() {
    $('.detail').click(function(e) {
      e.preventDefault();
      var no_permintaan = $(this).attr('data-nopermintaan');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>oman/detail_permintaan_pengiriman_gj',
        data: {
          no_permintaan: no_permintaan
        },
        cache: false,
        success: function(respond) {
          $("#loadpermintaanpengiriman").html(respond);
        }
      });
      $("#detailpermintaanpengiriman").modal("show");
    });

    $('.detailsj').click(function(e) {
      e.preventDefault();
      var no_sj = $(this).attr('data-sj');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>oman/detail_sj',
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

    $('.inputsuratjalan').click(function(e) {
      e.preventDefault();
      var no_permintaan = $(this).attr('data-nopermintaan');
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>oman/input_suratjalan',
        data: {
          no_permintaan: no_permintaan
        },
        cache: false,
        success: function(respond) {
          $("#loadinputsuratjalan").html(respond);
        }


      });
      $("#inputsuratjalan").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });

    });

  });
</script>