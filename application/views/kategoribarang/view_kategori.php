<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Kategori Barang
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-4 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Input Cabang</h4>
        </div>
        <div class="card-body">
          <form autocomplete="off" class="cabangForm" method="POST" action="<?php echo base_url(); ?>kategoribarang/insert_kategori">
            <div class="row">
              <div class="col-md-12">
                <label class="form-label">Kode Kategori</label>
                <div class="form-group">
                  <input type="text" value="<?php echo $getkategori['kode_kategori']; ?>" id="kode_kategori" name="kode_kategori" class="form-control" data-error=".errorTxt4" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="form-label">Nama Kategori</label>
                <div class="form-group">
                  <input type="text" value="<?php echo $getkategori['kategori']; ?>" id="kategori" name="kategori" class="form-control" data-error=".errorTxt4" />
                </div>
              </div>
            </div>
            <label class="form-label"></label></label>
            <div class="row ">
              <div class="col-md-3">
                <div class="form-group">
                  <div class="d-flex justify-content-end">
                    <a href="<?php base_url(); ?>view_kategori" class="btn btn-danger"><i class="fa fa-share mr-2"></i>Batal</a>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="d-flex justify-content-end">
                    <button type="submit" name="simpan" class="btn btn-primary" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Data Kategori Barang</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead class="thead-dark">
                <tr>
                  <th>Kode</th>
                  <th>Kategori</th>
                  <th width="120px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kategori->result() as $d) { ?>
                  <tr>
                    <td><?php echo $d->kode_kategori; ?></td>
                    <td><?php echo $d->kategori; ?></td>
                    <td>
                      <a href="<?php echo base_url('kategoribarang/view_kategori/' . $d->kode_kategori); ?>" class="btn bg-green  btn-sm waves-effect edit">Edit</a>
                      <a href="#" class="btn bg-red  btn-sm waves-effect" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url("kategoribarang/hapus/" . $d->kode_kategori); ?>">Hapus</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-xs-12">
      <?php $this->load->view('menu/menu_gudanglogistik_administrator.php'); ?>
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

  });
</script>