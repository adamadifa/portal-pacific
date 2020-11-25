<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Retur
        </h2>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-10">
        <!-- Content here -->
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Data Retur</h4>
              </div>
              <div class="card-body">
                <div class="row mb-3">
                  <form action="<?php echo base_url(); ?>penjualan/retur" method="post" autocomplete="off">
                    <div class="mb-3">
                      <input name="nofaktur" value="<?php echo $nofaktur; ?>" type="text" class="form-control" placeholder="No Faktur">
                    </div>
                    <div class="mb-3">
                      <input name="search" value="<?php echo $search; ?>" type="text" placeholder="Nama Pelanggan" class="form-control">
                    </div>
                    <div class="mb-3">
                      <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
                    </div>
                  </form>
                </div>
                <div class="row">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="mytable">
                      <thead class="thead-dark">
                        <tr>
                          <th>No</th>
                          <th>No. Retur</th>
                          <th>Tgl. Retur</th>
                          <th>No. Faktur</th>
                          <th>Kode Pel.</th>
                          <th>Nama Pelanggan</th>
                          <th>Cabang</th>
                          <th>Retur GB</th>
                          <th>Retur PF</th>
                          <th>Total Retur</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sno                = $row + 1;
                        $totalgb            = 0;
                        $totalpf            = 0;
                        $total              = 0;
                        foreach ($result as $data) {
                          $totalgb = $totalgb + $data['subtotal_gb'];
                          $totalpf = $totalpf + $data['subtotal_pf'];
                          $total = $total + $data['total'];
                        ?>
                          <tr>
                            <td><?php echo $sno; ?></td>
                            <td>
                              <a href="<?php echo base_url(); ?>penjualan/detailretur/<?php echo $data['no_retur_penj']; ?>/<?php echo $data['no_fak_penj']; ?>"><?php echo $data['no_retur_penj']; ?></a>
                            </td>
                            <td><?php echo $data['tglretur']; ?></td>
                            <td><?php echo $data['no_fak_penj']; ?></td>
                            <td><?php echo $data['kode_pelanggan']; ?></td>
                            <td><?php echo $data['nama_pelanggan']; ?></td>
                            <td><?php echo $data['kode_cabang']; ?></td>
                            <td align="right"><?php echo number_format($data['subtotal_gb'], '0', '', '.');  ?></td>
                            <td align="right"><?php echo number_format($data['subtotal_pf'], '0', '', '.');  ?></td>
                            <td align="right"><?php echo number_format($data['total'], '0', '', '.');  ?></td>
                            <td>
                              <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url(); ?>penjualan/hapusretur/<?php echo $data['no_retur_penj']; ?>"><i class="fa fa-trash-o"></i></a>
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
      </div>
      <div class="col-md-2">
        <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-title">
          Yakin Untuk Di Hapus ?
        </div>
        <div>Jika Di Hapus, Kamu Akan Kehilangan Data Ini !</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete">Yes, Hapus !</a>
      </div>
    </div>
  </div>
</div>
<script>
  $(".hapus").click(function() {
    var href = $(this).attr("data-href");
    //alert(href);
    $("#hapusdata").modal({
      backdrop: "static", //remove ability to close modal with click
      keyboard: false, //remove option to close with keyboard
      show: true //Display loader!
    });
    $(".delete").attr("href", href);
  });
</script>