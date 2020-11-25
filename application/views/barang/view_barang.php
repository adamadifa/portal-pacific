<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Barang
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <a href="#" class="btn bg-red waves-effect" id="tambahbarang"> Tambah Data </a>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Barang</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="mytable" style="font-size:12px">
              <thead class="thead-dark">
                <tr>
                  <th width="10px">No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Kategori</th>
                  <th>Satuan</th>
                  <th>Harga/Dus</th>
                  <th>Harga/Pack</th>
                  <th>Harga/Pcs</th>
                  <?php if ($leveluser == "Administrator") { ?>
                    <th>Aksi</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($barang as $b) {
                ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $b->kode_barang; ?></td>
                    <td><a href="#" data-kode="<?php echo $b->kode_barang; ?>" class="detailbrg"><?php echo $b->nama_barang; ?></a></td>
                    <td><?php echo $b->kategori; ?></td>
                    <td><?php echo $b->satuan; ?></td>
                    <td align="right"><?php echo number_format($b->harga_dus, '0', '', '.'); ?></td>
                    <td align="right"><?php echo number_format($b->harga_pack, '0', '', '.'); ?></td>
                    <td align="right"><?php echo number_format($b->harga_pcs, '0', '', '.'); ?></td>
                    <?php if ($leveluser == "Administrator") { ?>
                      <td>
                        <a href="#" data-id="<?php echo $b->kode_barang; ?>" class="btn btn-warning  btn-sm waves-effect edit">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm waves-effect" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url("barang/hapus/" . $b->kode_barang); ?>">Hapus</a>
                      </td>
                    <?php } ?>
                  </tr>
                <?php $no++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-xs-12">
      <?php $this->load->view('menu/menu_masterpenjualan'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="inputbarang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div class="modal-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
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
        <div>Data Akan Terhapus !</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete">Yes, delete</a>
      </div>
    </div>
  </div>
</div>
<script>
  $(function() {

    $("#tambahbarang").click(function() {
      $("#inputbarang").modal("show");
      $(".modal-content").load("<?php echo base_url(); ?>barang/input_barang");
    });

    $(".edit").click(function() {
      $id = $(this).attr('data-id');
      $("#inputbarang").modal("show");
      $(".modal-content").load("<?php echo base_url(); ?>barang/edit_barang/" + $id);
    });

    $(".detailbrg").click(function() {
      $id = $(this).attr('data-kode');
      $("#inputbarang").modal("show");
      $(".modal-content").load("<?php echo base_url(); ?>barang/detail_barang/" + $id);
    });


  });
</script>