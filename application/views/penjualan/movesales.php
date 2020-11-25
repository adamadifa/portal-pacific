<?php
function uang($nilai)
{
  return number_format($nilai, '0', '', '.');
}
?>
<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Pindahan Piutang Sales
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Pindahan Piutang Sales</h4>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>penjualan/movesales" autocomplete="off">
            <div class="mb-3">
              <input id="nofaktur" value="<?php echo $nofaktur; ?>" name="nofaktur" class="form-control" placeholder="No Faktur">
            </div>
            <div class="mb-3">
              <input type="text" value="<?php echo $namapel; ?>" id="namapel" name="namapel" class="form-control" placeholder="Nama Pelanggan">
            </div>
            <div class="mb-3">
              <div class="input-icon">
                <input id="dari" type="date" value="<?php echo $tanggalpindah; ?>" placeholder="Tanggal Pindah" class="form-control" name="tanggalpindah" />
                <span class="input-icon-addon"><i class="fa fa-calendar-o"></i>
                </span>
              </div>
            </div>
            <div class="mb-3 d-flex justify-content-end">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="datatable">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>No Faktur</th>
                  <th>Tanggal Pindah</th>
                  <th>Nama Pelanggan</th>
                  <th>Cabang</th>
                  <th>Salesman Lama</th>
                  <th>Salesman Baru</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result == 0) {
                ?>
                  <tr>
                    <td colspan="8">
                      <div class="alert alert-warning" role="alert">
                        Silahkan Lakukan Pencarian Data !
                      </div>
                    </td>
                  </tr>

                  <?php
                } else {
                  $sno  = $row + 1;
                  foreach ($result as $d) {
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['no_fak_penj']; ?></td>
                      <td><?php echo DateToIndo2($d['tgl_move']); ?></td>
                      <td><?php echo $d['nama_pelanggan']; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td><?php echo $d['saleslama']; ?></td>
                      <td><?php echo $d['salesbaru']; ?></td>
                      <td>
                        <a href="<?php echo base_url(); ?>penjualan/cetak_faktur/<?php echo $d['no_fak_penj']; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-print"></i></a>
                      </td>
                    </tr>
                <?php
                    $sno++;
                  }
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
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('dari'), {});
  });
</script>