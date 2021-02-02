<div class="card">
  <div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active">
      Data Master
    </a>
    <a href="<?php echo base_url(); ?>pelanggan/view_pelanggan" class="list-group-item list-group-item-action">Data Pelanggan</a>
    <a href="<?php echo base_url(); ?>sales/view_sales" class="list-group-item list-group-item-action">Data Sales</a>
    <a href="<?php echo base_url(); ?>barang/view_barang" class="list-group-item list-group-item-action">Data Barang</a>
    <a href="<?php echo base_url(); ?>users/view_users" class="list-group-item list-group-item-action">Data Users</a>
    <a href="<?php echo base_url(); ?>kendaraan" class="list-group-item list-group-item-action">Data Kendaraan</a>
    <?php
    if ($this->session->userdata('level_user') == "Administrator") {
    ?>
      <a href="<?php echo base_url(); ?>cabang/view_cabang" class="list-group-item list-group-item-action">Data Cabang</a>
    <?php
    }
    ?>
  </div>
</div>