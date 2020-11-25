<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA ORDER MANAGEMENT ( OMAN )
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
            <h4 class="card-title">Data Order Management (Oman) </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>oman/view_omanmkt" autocomplete="off">
              <div class="form-group mb-3">
                <select class="form-select" id="bulan" name="bulan">
                  <option value="">Bulan</option>
                  <?php for ($a = 1; $a <= 12; $a++) { ?>
                    <option <?php if ($bln == $a) {
                              echo "selected";
                            } ?> value="<?php echo $a;  ?>"><?php echo $bulan[$a]; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group mb-3">
                <select class="form-select" id="tahun" name="tahun">
                  <option value="">Tahun</option>
                  <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                    <option <?php if ($thn == $t) {
                              echo "selected";
                            } ?> value="<?php echo $t;  ?>"><?php echo $t; ?></option>
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
                    <th>No. Order</th>
                    <th>Tanggal Order</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>

                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($oman as $o) {
                    if ($o->status == '0') {
                      $status = "Pending";
                      $bg     = "bg-orange";
                    } else if ($o->status == '1') {
                      $status = "Sudah di Proses Gudang";
                      $bg     = "bg-blue";
                    } else if ($o->status == '2') {
                      $status = "Sudah di Proses oleh Produksi";
                      $bg     = "bg-green";
                    }
                    $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $o->no_order; ?></td>
                      <td><?php echo DateToIndo2($o->tgl_order); ?></td>
                      <td><?php echo $bulan[$o->bulan]; ?></td>
                      <td><?php echo $o->tahun; ?></td>
                      <td><span class="badge <?php echo $bg; ?>"><?php echo $status; ?></span></td>
                      <td>
                        <a href="#" data-noorder="<?php echo $o->no_order; ?>" class="btn btn-sm btn-danger detail">Detail Oman</a>
                        <?php if ($o->status == 0) { ?>
                          <a href="<?php echo base_url(); ?>oman/input_permintaan/<?php echo $o->no_order; ?>" class="btn btn-sm btn-success">Buat Permintaan</a>
                        <?php } else if ($o->status == '1' or $o->status == '2') { ?>
                          <a href="#" data-noorder="<?php echo $o->no_order; ?>" class="btn btn-sm btn-primary detailpermintaan">Detail Permintaan</a>
                        <?php } ?>

                      </td>
                    </tr>
                  <?php $no++;
                  } ?>
                </tbody>
              </table>
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
<div class="modal modal-blur fade" id="detailpermintaan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetailpermintaan"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailoman" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetailoman"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {

    $('.detailpermintaan').click(function() {
      var no_order = $(this).attr('data-noorder');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>oman/detail_permintaan',
        data: {
          no_order: no_order
        },
        cache: false,
        success: function(respond) {

          $("#loaddetailpermintaan").html(respond);
        }
      });
      $("#detailpermintaan").modal("show");

    });

    $('.detail').click(function() {
      var no_order = $(this).attr('data-noorder');
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>oman/detail_oman',
        data: {
          no_order: no_order
        },
        cache: false,
        success: function(respond) {

          $("#loaddetailoman").html(respond);
        }


      });
      $("#detailoman").modal("show");

    });



  });
</script>