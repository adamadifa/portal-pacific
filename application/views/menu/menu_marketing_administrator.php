<?php
$level = $this->session->userdata('level_user');
if ($level == "Administrator" || $level == "manager marketing") {
?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Order Management (OMAN)
      </a>

      <a href="<?php echo base_url(); ?>oman" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Order Management (OMAN)
      </a>
      <a href="<?php echo base_url(); ?>oman/omancabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Order Management Cabang
      </a>
      <a href="<?php echo base_url(); ?>oman/permintaan_pengiriman" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Permintaan Pengiriman
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Komisi
      </a>

      <a href="<?php echo base_url(); ?>komisi/targetqty" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Target Quantiy
      </a>
      <a href="<?php echo base_url(); ?>komisi/targetcashin" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Target Cash IN
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>

      <a href="<?php echo base_url(); ?>laporanpenjualan/costratio" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Cost Rasio
      </a>
    </div>
  </div>
<?php
} else if ($level == "admin gudang pusat") {
  $this->load->view('menu/menu_gudangpusat_administrator');
} else if ($level == "admin gudang") {
  $this->load->view('menu/menu_gudangcabang_administrator');
}
?>