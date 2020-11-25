<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA PERINCIAN BARANG (DPB)
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
            <h4 class="card-title">DATA PERINCIAN BARANG (DPB) </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>setting/tutuplaporan" autocomplete="off">
              <div class="form-group mb-3">
                <select class="form-select show-tick" id="tahun" name="tahun" data-error=".errorTxt1">
                  <?php
                  $tahunmulai = 2018;
                  for ($thn = $tahunmulai; $thn <= date('Y'); $thn++) {
                  ?>
                    <option <?php if ($tahun == $thn) {
                              echo "Selected";
                            } ?> value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3 d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
              </div>
            </form>
            <a href="#" class="btn btn-danger mt-2" id="tambah"> Tambah Data </a>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th width="10px">No</th>
                    <th>Kode Laporan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Jenis Laporan</th>
                    <th>Tanggal Penutupan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no   = 1;
                  foreach ($tutuplaporan as $d) {
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $d->kode_tutuplaporan; ?></td>
                      <td><?php echo $bulan[$d->bulan]; ?></td>
                      <td><?php echo $d->tahun; ?></td>
                      <td><?php echo strtoupper($d->jenis_laporan); ?></td>
                      <td><?php echo DateToIndo2($d->tgl_penutupan); ?></td>
                      <td>
                        <?php
                        if ($d->status == '1') {
                        ?>
                          <label class="badge bg-red">Laporan Ditutup</label>
                        <?php } else { ?>
                          <label class="badge bg-green">Laporan Dibuka</label>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        if ($d->status == '1') {
                        ?>
                          <a href="<?php echo base_url(); ?>setting/bukalaporan/<?php echo $d->kode_tutuplaporan; ?>" class="btn btn-sm btn-success">Buka Laporan</a>
                        <?php } else { ?>
                          <a href="<?php echo base_url(); ?>setting/tutup/<?php echo $d->kode_tutuplaporan; ?>" class="btn btn-sm btn-danger">Tutup Laporan</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php
                    $no++;
                  }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="inputtutuplaporan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Tutup Laporan</h5>
      </div>
      <div class="modal-body">
        <div id="loadtutuplaporan"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $("#tambah").click(function() {
      $("#inputtutuplaporan").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>setting/input_tutuplaporan',
        cache: false,
        success: function(respond) {
          $('#loadtutuplaporan').html(respond);
        }
      });
    });
  });
</script>