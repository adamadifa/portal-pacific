<?php
$level = $this->session->userdata('level_user');
if ($level == 'Administrator' || $level == 'admin gudang bahan') { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        DATA MASTER
      </a>
      <a href="<?php echo base_url(); ?>gudangbahan/barang" class="list-group-item list-group-item-action">
        <i class="fa  fa-list mr-2"></i>DATA BARANG
      </a>
    </div>
  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        DATA TRANSAKSI
      </a>
      <a href="<?php echo base_url(); ?>gudangbahan/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-send mr-2"></i>PEMASUKAN
      </a>
      <a href="<?php echo base_url(); ?>gudangbahan/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-share mr-2"></i>PENGELUARAN
      </a>
      <a href="<?php echo base_url(); ?>gudangbahan/saldoawal" class="list-group-item list-group-item-action">
        <i class="fa  fa-table mr-2"></i>SALDO AWAL
      </a>
      <a href="<?php echo base_url(); ?>gudangbahan/saldoawal_retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-table mr-2"></i>SALDO AWAL RETUR
      </a>
      <a href="<?php echo base_url(); ?>gudangbahan/returproduksi" class="list-group-item list-group-item-action">
        <i class="fa  fa-share mr-2"></i>RETUR PRODUKSI
      </a>
      <a href="<?php echo base_url(); ?>gudangbahan/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-share mr-2"></i>RETUR
      </a>
    </div>
  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PERSEDIAAN BARANG
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PEMASUKAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PENGELUARAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>RETUR
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/detail_retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>DETAIL RETUR
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/rekapgudangbahan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>KARTU GUDANG BAHAN/KEMASAN
      </a>
    </div>
  </div>
<?php } ?>

<?php if ($level == 'manager accounting' || $level == 'admin gudang pusat' || $level == 'emf1' || $level == 'admin pembelian' || $level == 'audit') { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/persediaan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PERSEDIAAN BARANG
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/pemasukan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PEMASUKAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/pengeluaran" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>PENGELUARAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>RETUR
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/detail_retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>DETAIL RETUR
      </a>
      <a href="<?php echo base_url(); ?>laporangudangbahan/rekapgudangbahan" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>KARTU GUDANG BAHAN/KEMASAN
      </a>
    </div>
  </div>
  <?php if ($level == 'admin pembelian') { ?>
    <div class="card">
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
          LAPORAN GUDANG LOGISTIK
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
        <a href="<?php echo base_url(); ?>laporangudangbahan/retur" class="list-group-item list-group-item-action">
          <i class="fa  fa-copy mr-2"></i>RETUR
        </a>
        <a href="<?php echo base_url(); ?>laporangudangbahan/detail_retur" class="list-group-item list-group-item-action">
          <i class="fa  fa-copy mr-2"></i>DETAIL RETUR
        </a>
        <a href="<?php echo base_url(); ?>laporangudangbahan/rekapgudangbahan" class="list-group-item list-group-item-action">
          <i class="fa  fa-copy mr-2"></i>KARTU GUDANG BAHAN/KEMASAN
        </a>
      </div>
    </div>
  <?php } ?>
<?php } ?>