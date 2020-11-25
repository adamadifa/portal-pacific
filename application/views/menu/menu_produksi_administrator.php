<?php
$level = $this->session->userdata('level_user');
if ($level == "Administrator" || $level == "admin produksi") {
?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Permintaan
      </a>
      <a href="<?php echo base_url(); ?>oman/permintaan_produksi_acc" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Permintaan Produksi
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Mutasi Produksi
      </a>
      <a href="<?php echo base_url(); ?>bpbj/view_bpbj" class="list-group-item list-group-item-action">
        <i class="fa  fa-hand-pointer-o mr-2"></i>BPBJ
      </a>
      <a href="<?php echo base_url(); ?>fsthp/view_fsthp" class="list-group-item list-group-item-action">
        <i class="fa  fa-hand-o-down mr-2"></i>FSTHP
      </a>
      <a href="<?php echo base_url(); ?>bpbj/lainlain" class="list-group-item list-group-item-action">
        <i class="fa  fa-hand-peace-o mr-2"></i>
        Lain Lain
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Transaksi
      </a>
      <a href="<?php echo base_url(); ?>produksi/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-send mr-2"></i>Pemasukan
      </a>
      <a href="<?php echo base_url(); ?>produksi/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-share mr-2"></i>Pengeluaran
      </a>
      <a href="<?php echo base_url(); ?>produksi/saldoawal" class="list-group-item list-group-item-action">
        <i class="fa  fa-table mr-2"></i>Saldo Awal
      </a>
      <a href="<?php echo base_url(); ?>produksi/opname" class="list-group-item list-group-item-action">
        <i class="fa  fa-sitemap mr-2"></i>Opname
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/mutasi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Mutasi Produksi
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/rekapmutasi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Mutasi Produksi
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Pemasukan
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Pengeluaran
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan Barang
      </a>
    </div>
  </div>
<?php } else if ($level == "Admin Produksi 2") { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Mutasi Produksi
      </a>
      <a href="<?php echo base_url(); ?>fsthp/view_fsthp" class="list-group-item list-group-item-action">
        <i class="fa  fa-hand-o-down mr-2"></i>FSTHP
      </a>
    </div>
  </div>
<?php } else if ($level == "emf1" || $level == "manager accounting" || $level == "admin pembelian") { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/mutasi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Mutasi Produksi
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/rekapmutasi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Mutasi Produksi
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Pemasukan
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Pengeluaran
      </a>
      <a href="<?php echo base_url(); ?>laporanproduksi/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan Barang
      </a>
    </div>
  </div>
<?php } ?>