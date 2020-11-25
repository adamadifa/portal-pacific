<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          FORM SERAH TERIMA HASIL PRODUKSI (FSTHP)
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
              <h4 class="card-title">FORM SERAH TERIMA HASIL PRODUKSI (FSTHP) </h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>fsthp/view_fsthp_gj" autocomplete="off">
                <div class="mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" value="<?php echo $tgl_mutasi; ?>" id="tgl_mutasi" name="tgl_mutasi" class="form-control" placeholder="Tanggal" data-error=".errorTxt1" />
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
                      <th>No. FSTHP</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno  = $row + 1;
                    foreach ($result as $d) {
                      if ($d['status'] == 0 or $d['status'] == "") {
                        $color   = "bg-orange";
                        $status = "Pending";
                      } else {
                        $color  = "bg-green";
                        $status = "Diterima Gudang";
                      }
                      $tanggal = explode("-", $d['tgl_mutasi_produksi']);
                      $hari    = $tanggal[2];
                      $bulan   = $tanggal[1];
                      $tahun   = $tanggal[0];
                      $tgl     = $hari . "/" . $bulan . "/" . substr($tahun, 2, 2);
                    ?>
                      <tr>
                        <td><?php echo $sno; ?></td>
                        <td>
                          <a href="#" data-nomutasi="<?php echo $d['no_mutasi_produksi']; ?>" class="detail">
                            <?php echo $d['no_mutasi_produksi']; ?>
                          </a>
                        </td>
                        <td><?php echo $tgl; ?></td>
                        <td><span class="badge <?php echo $color; ?>"><?php echo $status; ?></span></td>
                        <td>
                          <?php if ($d['status'] == 0) { ?>
                            <a href="<?php echo base_url(); ?>fsthp/approve_fsthp/<?php echo $d['no_mutasi_produksi']; ?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
                          <?php } else { ?>
                            <a href="<?php echo base_url(); ?>fsthp/cancel_fsthp/<?php echo $d['no_mutasi_produksi']; ?>/<?php echo $this->uri->segment(3); ?>" class="btn btn-danger btn-sm">Batalkan</a>
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
      <?php $this->load->view('menu/menu_gudangpusat_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailmutasi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetailmutasi"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tgl_mutasi'), {});
</script>
<script type="text/javascript">
  $(function() {
    $('.detail').click(function(e) {
      e.preventDefault();
      var nomutasi = $(this).attr('data-nomutasi');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>fsthp/detail_mutasi',
        data: {
          nomutasi: nomutasi
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailmutasi").html(respond);
        }
      });
      $("#detailmutasi").modal("show");

    });
    });
  </script>