<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data user
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-2 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Input user</h4>
        </div>
        <div class="card-body">
          <form autocomplete="off" method="POST" action="<?php echo base_url(); ?>users/insert_users">
            <div class="row">
              <div class="col-md-12">
                <label class="form-label">ID</label>
                <div class="form-group">
                  <input type="text" <?php if (!empty($getusers['id_user'])) {
                    echo "readonly";
                  } ?> value="<?php echo $getusers['id_user']; ?>" id="id_user" name="id_user" class="form-control" placeholder="Kode user">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="form-label">Nama Lengkap</label>
                <div class="form-group">
                  <input type="text" value="<?php echo $getusers['nama_lengkap']; ?>" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="form-label">Username</label>
                <div class="form-group">
                  <input type="text" value="<?php echo $getusers['username']; ?>" id="username" name="username" class="form-control" placeholder="Username">
                </div>
              </div>
            </div>
            <div class="row mb-3" <?php if ($getusers['password'] != "") {
              echo "hidden";
            } ?>>
            <div class="col-md-12">
              <label class="form-label">Password</label>
              <div class="form-group">
                <input type="text" value="<?php echo $getusers['password']; ?>" id="password" name="password" class="form-control" placeholder="Password">
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Level</label>
              <div class="form-group">
                <input type="text" value="<?php echo $getusers['level']; ?>" id="level" name="level" class="form-control" placeholder="Level">
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Cabang</label>
              <div class="form-group">
                <select class="form-control form-control-sm" name="cabang" id="cabang">
                  <option value="">Pilih Cabang</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option value="<?php echo $c->kode_cabang; ?>"><?php echo $c->nama_cabang; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row ">
            <div class="form-group">
              <div class="d-flex justify-content-end">
                <a class="btn btn-danger" href="<?php echo base_url(); ?>users/view_users"><i class="fa fa-share mr-2"></i>BATAL</a>
                <button type="submit" name="simpan" class="btn btn-primary userForm" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-xs-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Data User</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead-dark">
              <tr>
                <th>NO</th>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Level</th>
                <th>Cabang</th>
                <th>Terakhir Login</th>
                <th>Aktif</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = "1";
              foreach ($users as $c) {
                // if($c->terakhir_login > time() - 60*5){
                //   $aktif = "Sedang Aktif";
                //   $color = "style='color:green'";
                // } else{
                 
                //   $aktif = "Tidak Aktif";
                //   $color = "style='color:red'";
                // }


                if ($c->aktif == "1") {
                  $aktif = "Sedang Aktif";
                  $color = "style='color:green'";
                } else {
                  $aktif = "Tidak Aktif";
                  $color = "style='color:red'";
                }
                ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $c->id_user; ?></td>
                  <td><?php echo $c->nama_lengkap; ?></td>
                  <td><?php echo $c->username; ?></td>
                  <td><?php echo $c->level; ?></td>
                  <td><?php echo $c->cabang; ?></td>
                  <td><?php echo $c->terakhir_login; ?></td>
                  <td <?php echo $color; ?>><?php echo $aktif; ?></td>
                  <td>
                    <a href="<?php echo base_url('users/view_users/' . $c->id_user); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                    <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url("users/hapus/" . $c->id_user); ?>"><i class="fa fa-trash-o"></i></a>
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
    <?php $this->load->view('menu/menu_masterpenjualan'); ?>
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