<?php
$level = $this->session->userdata('level_user');
if ($level == "Administrator" || $level == "admin pembelian 2" || $level == "admin pembelian" || $level == "manager pembelian") {
?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Master
      </a>
      <a href="<?php echo base_url(); ?>pembelian/barang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Data Barang
      </a>
      <a href="<?php echo base_url(); ?>pembelian/supplier" class="list-group-item list-group-item-action">
        <i class="fa  fa-users mr-2"></i>Data Supplier
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Transaksi
      </a>
      <a href="<?php echo base_url(); ?>pembelian" class="list-group-item list-group-item-action">
        <i class="fa  fa-shopping-cart mr-2"></i>Pembelian
      </a>
      <a href="<?php echo base_url(); ?>pembelian/kontrabon" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Kontra BON
      </a>
      <a href="<?php echo base_url(); ?>pembelian/jurnalkoreksi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Jurnal Koreksi
      </a>
      <a href="<?php echo base_url(); ?>pembelian/jatuhtempo" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Jatuh Tempo
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/pembelian" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Pembelian
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/pembayaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Pembayaran
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/supplier" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Rekap Pembelian Supplier
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/rekappembelian" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Rekap Pembelian
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/kartuhutang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Kartu Hutang
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/auh" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Analisa Umur Hutang (AUH)
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/bahandankemasan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Bahan dan Kemasan
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/rekapproduk" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Rekap Bahan & Kemasan / Supplier
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/jurnalkoreksi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Jurnal Koreksi
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/rekapperakun" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Rekap Per-Akun
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/rekapkontrabon" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Rekap Kontrabons
      </a>
    </div>
  </div>
<?php } else if ($level == "emf1" || $level == "manager accounting" || $level == "spv accounting") { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/pembelian" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Pembelian
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/pembayaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Pembayaran
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/supplier" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Rekap Pembelian Supplier
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/rekappembelian" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Rekap Pembelian
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/kartuhutang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Kartu Hutang
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/auh" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Analisa Umur Hutang (AUH)
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/bahandankemasan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Bahan dan Kemasan
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/rekapproduk" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Rekap Bahan & Kemasan / Supplier
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/jurnalkoreksi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Jurnal Koreksi
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/bankharga" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Bank Harga
      </a>
      <a href="<?php echo base_url(); ?>laporanpembelian/rekapperakun" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-o mr-2"></i>Laporan Rekap Per-Akun
      </a>
    </div>
  </div>
<?php } else if ($level == "keuangan") {
  $this->load->view('menu/menu_keuangan_administrator'); ?>
<?php } ?>