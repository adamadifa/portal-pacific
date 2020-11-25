<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA SALDO AWAL <?php echo $status; ?>
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="col-md-7">

          <div class="card">
            <div class="card-header">
              <h4 class="card-title">DATA SALDO AWAL <?php echo $status; ?> </h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>dpb/<?php echo $this->uri->segment(2); ?>" autocomplete="off">
                <div class="form-group mb-3">
                  <select class="form-select" id="cabang" name="cabang">
                    <option value="">Pilih Cabang</option>
                    <?php foreach ($cabang as $c) { ?>
                      <option <?php if ($cbg == $c->kode_cabang) {
                                echo "selected";
                              } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                    <?php } ?>
                  </select>
                </div>
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
              <?php
              if ($status == 'GS') {
                $link = "inputsaldoawalgs";
              } else {
                $link = "inputsaldoawalbs";
              }
              ?>
              <hr>
              <a href="<?php echo base_url(); ?>dpb/<?php echo $link; ?>" class="btn btn-danger mb-3">Tambah Data</a>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                  <thead class="thead-dark">
                    <tr>
                      <th width="10px">No</th>
                      <th>Kode</th>
                      <th>Tanggal</th>
                      <th>Bulan</th>
                      <th>Tahun</th>
                      <th>Cabang</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno  = $row + 1;
                    foreach ($result as $d) {
                    ?>
                      <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $d['kode_saldoawal']; ?></td>
                        <td><?php echo DateToIndo2($d['tanggal']); ?></td>
                        <td><?php echo $bulan[$d['bulan']]; ?></td>
                        <td><?php echo $d['tahun']; ?></td>
                        <td><?php echo $d['kode_cabang']; ?></td>
                        <td><span class="badge <?php if ($d['status'] == 'GS') {
                                                  echo 'bg-green';
                                                } else {
                                                  echo 'bg-red';
                                                } ?>"><?php echo $d['status']; ?></span></td>
                        <td>
                          <a href="#" class="btn btn-sm btn-info detail" data-kodesaldoawal="<?php echo $d['kode_saldoawal']; ?>">Detail</a>
                          <a data-href="<?php echo base_url(); ?>dpb/hapussaldoawal/<?php echo $d['kode_saldoawal']; ?>/<?php echo $d['status']; ?>" class="btn btn-sm text-white btn-danger hapus">Hapus</a>
                        </td>
                      </tr>
                    <?php
                      $sno++;
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
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_gudangcabang_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailsaldoawal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loadsaldoawal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {

    $('.detail').click(function(e) {
      e.preventDefault();
      var kode = $(this).attr('data-kodesaldoawal');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>dpb/detailsaldoawal',
        data: {
          kode: kode
        },
        cache: false,
        success: function(respond) {
          $("#loadsaldoawal").html(respond);
        }
      });
      $("#detailsaldoawal").modal("show");
    });


    $('.hapus').click(function() {
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