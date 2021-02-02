<?php
$level = $this->session->userdata('level_user');
if ($level == "Administrator" || $level == "admin gudang pusat") {
?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Surat Jalan Penjualan
      </a>
      <a href="<?php echo base_url(); ?>penjualan/suratjalan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Cek Surat Jalan
      </a>
    </div>

  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Order Management (OMAN)
      </a>
      <a href="<?php echo base_url(); ?>oman/view_omanmkt" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Order Management
      </a>
      <a href="<?php echo base_url(); ?>oman/permintaan_produksi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Permintaan Produksi
      </a>
      <a href="<?php echo base_url(); ?>oman/permintaan_pengiriman" class="list-group-item list-group-item-action">
        <i class="fa  fa-rocket mr-2"></i>Input Permintaan Pengiriman
      </a>
      <a href="<?php echo base_url(); ?>oman/view_suratjalan" class="list-group-item list-group-item-action">
        <i class="fa  fa-rocket mr-2"></i>Permintaan Pengiriman
      </a>
    </div>

  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Mutasi Gudang
      </a>
      <a href="<?php echo base_url(); ?>fsthp/view_fsthp_gj" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>FSTHP
      </a>
      <a href="<?php echo base_url(); ?>oman/suratjalan" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Surat Jalan
      </a>
      <a href="<?php echo base_url(); ?>repackreject/repack" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Repack
      </a>
      <a href="<?php echo base_url(); ?>repackreject/reject" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Reject
      </a>
      <a href="<?php echo base_url(); ?>repackreject/lainlain" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>Lainnya
      </a>
    </div>

  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan Barang
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappersediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Persediaan
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekaphasilproduksi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Hasil Produksi
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Pengeluaran
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/realisasikiriman" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Realiasasi Kiriman
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/realisasioman" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Realiasasi Oman
      </a>
    </div>

  </div>
<?php } else if (
  $level == "audit" || $level == "emf1" || $level == "general manager" || $level == "manager accounting" || $level == "manager marketing"
  || $level == "spv accounting"
) { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan Barang
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappersediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Persediaan
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekaphasilproduksi" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Hasil Produksi
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap Pengeluaran
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/realisasikiriman" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Realiasasi Kiriman
      </a>
    </div>

  </div>
<?php } ?>


<?php if ($level == 'admin gudang pusat') { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan Gudang Bahan
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Persediaan Barang
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Pemasukan
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Pengeluaran
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Returs
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/detail_retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Detail Retur
      </a>
    </div>
  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporangudanglogistik/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Persedian
      </a>
      <a href="<?php echo base_url(); ?>laporangudanglogistik/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PEMASUKAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudanglogistik/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PENGELUARAN
      </a>
    </div>
  </div>
<?php } ?>