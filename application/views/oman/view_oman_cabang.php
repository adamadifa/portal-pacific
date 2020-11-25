<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA ORDER MANAGEMENT CABANG
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
            <h4 class="card-title">Data Order Management Cabang </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>oman/omancabang" autocomplete="off">
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
              <div class="mb-3">
                <select name="cabang" id="cabang" class="form-select">
                  <option value="">-- Semua Cabang --</option>
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
            <a href="<?php echo base_url(); ?>oman/input_oman_cabang" class="btn btn-danger mt-2" id="tambahpel"> Tambah Data </a>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th width="10px">No</th>
                    <th>No. Order</th>
                    <th>Cabang</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>

                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($oman as $o) {
                    if (empty($o->status)) {
                      $status = "Pending";
                      $bg     = "bg-orange";
                    } else {
                      $status = "Sudah di Proses";
                      $bg     = "bg-green";
                    }
                    $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $o->no_order; ?></td>
                      <td><?php echo $o->kode_cabang; ?></td>
                      <td><?php echo $bulan[$o->bulan]; ?></td>
                      <td><?php echo $o->tahun; ?></td>
                      <td><span class="badge <?php echo $bg; ?>"><?php echo $status; ?></span></td>
                      <td>
                        <?php
                        if (empty($o->status)) {
                        ?>
                          <a href="<?php echo base_url(); ?>oman/edit_omancabang/<?php echo $o->no_order; ?>" class="btn btn-sm btn-primary">Edit</a>
                          <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url(); ?>oman/hapusomancabang/<?php echo $o->no_order; ?>">Hapus</a>
                        <?php
                        }
                        ?>
                        <a href="#" data-noorder="<?php echo $o->no_order; ?>" class="btn btn-sm btn-pink detail">Detail Oman</a>
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
      <?php $this->load->view('menu/menu_marketing_administrator'); ?>
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
        url: '<?php echo base_url(); ?>oman/detail_oman_cabang',
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

    $(".hapus").click(function() {
      var getLink = $(this).attr('data-href');
      swal({
        title: 'Alert',
        text: 'Hapus Data ?',
        html: true,
        confirmButtonColor: '#d43737',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
    });


  });
</script>