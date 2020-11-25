<?php
$level = $this->session->userdata('level_user');
if ($level == 'Administrator' || $level == 'admin gudang logistik') { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        DATA MASTER
      </a>
      <a href="<?php echo base_url(); ?>gudanglogistik/barang" class="list-group-item list-group-item-action">
        <i class="fa  fa-list mr-2"></i>DATA BARANG
      </a>
    </div>
  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        DATA TRANSAKSI
      </a>
      <a href="<?php echo base_url(); ?>gudanglogistik/pembelian" class="list-group-item list-group-item-action">
        <i class="fa  fa-shopping-cart mr-2"></i>PEMBELIAN
      </a>
      <a href="<?php echo base_url(); ?>gudanglogistik/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-send mr-2"></i>PEMASUKAN
      </a>
      <a href="<?php echo base_url(); ?>gudanglogistik/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-share mr-2"></i>PENGELUARAN
      </a>
      <a href="<?php echo base_url(); ?>gudanglogistik/saldoawal" class="list-group-item list-group-item-action">
        <i class="fa  fa-table mr-2"></i>SALDO AWAL
      </a>
      <a href="<?php echo base_url(); ?>gudanglogistik/opname" class="list-group-item list-group-item-action">
        <i class="fa  fa-sitemap mr-2"></i>OPNAME
      </a>
    </div>
  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudanglogistik/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PERSEDIAAN BARANG
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

<?php if ($level == 'manager accounting' || $level == 'admin gudang pusat' || $level == 'emf1' || $level == 'audit')  { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudanglogistik/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PERSEDIAAN BARANG
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