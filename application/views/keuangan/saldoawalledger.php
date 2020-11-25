<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Saldo Awal Ledger
        </h2>
      </div>
    </div>
  </div>

  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Saldo Awal Ledger</h4>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>keuangan/saldoledger" autocomplete="off">
            <div class="form-group mb-3">
              <select class="form-select show-tick" id="bank" name="bank" data-error=".errorTxt1">
                <option value="">PILIH BANK</option>
                <option <?php if ($bank == "ALL") {
                          echo "selected";
                        } ?> value="ALL">SEMUA BANK</option>
                <?php foreach ($lbank as $b) { ?>
                  <option <?php if ($bank == $b->kode_bank) {
                            echo "selected";
                          } ?> value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
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
          <hr>
          <a href="#" id="setsaldo" class="btn btn-danger"> <i class="fa fa-plus mr-2"></i>Tambah Data</a>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mt-3" style="width:100%" id="mytable">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th>Bank</th>
                  <th>Jumlah</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($result)) {
                ?>
                  <tr>
                    <td colspan="9">
                      <div class="alert alert-warning" role="alert">
                        Data Tidak Ditemukan / Silahkan Pilih Bank Di Pencarian !
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
                      <td><?php echo $d['nama_bank']; ?></td>
                      <td align="right"><?php echo number_format($d['jumlah'], '2', ',', '.'); ?></td>
                      <td>
                        <a data-href="<?php echo base_url(); ?>keuangan/hapussaldoawalledger/<?php echo $d['kode_saldoawalledger']; ?>" class="btn btn-sm btn-danger text-white hapus"><i class="fa fa-trash-o"></i></a>
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
      <?php $this->load->view('menu/menu_keuangan_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="inputsaldoawal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Saldo Awal Ledger</h5>
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
    $('#setsaldo').click(function(e) {
      e.preventDefault();
      $("#inputsaldoawal").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loadsaldoawal").load('<?php echo base_url(); ?>keuangan/inputsaldoawalledger');
    });


    $('.hapus').click(function() {
      var getLink = $(this).attr('data-href');
      swal({
        title: 'Hapus ?',
        text: 'Yakin Data Ini Akan Dihapus ?',
        html: true,
        confirmButtonColor: '#d43737',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
    });
  });
</script>