<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Uang Belum Disetorkan
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Data Uang Belum Disetorkan</h4>
        </div>
        <div class="card-body">
          <form method="post" action="<?php echo base_url(); ?>penjualan/belumsetor" autocomplete="off">
            <?php if ($cb == 'pusat') { ?>
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
            <?php } else { ?>
              <input type="hidden" name="cabang" id="cabang" value="<?php echo $cbg; ?>">
            <?php } ?>
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
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <a href="#" class="btn btn-danger mb-3" id="setbelumsetor"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
          <hr>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead class="thead-dark">
                <tr>
                  <th width="10px">No</th>
                  <th>Tanggal</th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th>Cab</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($result)) {
                ?>
                  <tr>
                    <td colspan="6">
                      <div class="alert alert-warning" role="alert">
                        Data Tidak Ditemukan / Silahkan Lakukan Pencarian Data Terlebih Dahulu !
                      </div>
                    </td>
                  </tr>
                  <?php
                } else {
                  $sno  = 1;
                  foreach ($result as $d) {
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo DateToIndo2($d['tanggal']); ?></td>
                      <td><?php echo $bulan[$d['bulan']]; ?></td>
                      <td><?php echo $d['tahun']; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td>
                        <a data-href="<?php echo base_url(); ?>penjualan/hapusbelumsetorsales/<?php echo $d['kode_saldobs']; ?>" class="btn btn-danger btn-sm text-white hapus"><i class="fa fa-trash-o"></i></a>
                        <a data-href="#" class="btn btn-primary btn-sm text-white detail" data-id="<?php echo $d['kode_saldobs'] ?>"><i class="fa fa-list"></i></a>
                      </td>
                    </tr>
                <?php
                    $sno++;
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_kasbesar_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="forminput" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Uang Belum Disetorkan</h5>
      </div>
      <div class="modal-body">
        <div id="loadforminput"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
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
<script>
  $(function() {
    $('#setbelumsetor').click(function(e) {
      e.preventDefault();
      $("#forminput").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loadforminput").load('<?php echo base_url(); ?>penjualan/inputbelumsetorsales');
    });

    $(".detail").click(function(e) {
      e.preventDefault();
      var id = $(this).attr("data-id");
      $("#detail").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loaddetail").load('<?php echo base_url(); ?>penjualan/getdetailbelumsetorsales/' + id);
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

  })
</script>