<?php
$level = $this->session->userdata('level_user');
if ($level == "Administrator") {
?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Setoran
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setoranpenjualan" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Penjualan
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setoranpusat" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Pusat
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setorangiro" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Giro
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setorantransfer" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Transfer
      </a>
      <a href="<?php echo base_url(); ?>penjualan/logamtokertas" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Ganti Logam ke Kertas
      </a>
      <a href="<?php echo base_url(); ?>penjualan/kuranglebihsetor" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Kurang / Lebih Setor
      </a>
      <a href="<?php echo base_url(); ?>penjualan/belumsetor" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Uang Belum Disetorkan
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Saldo Awal
      </a>
      <a href="<?php echo base_url(); ?>penjualan/saldoawalkb" class="list-group-item list-group-item-action">
        <i class="fa fa-gears mr-2"></i>Saldo Awal Kas Besar
      </a>
      <a href="<?php echo base_url(); ?>penjualan/saldokurlebsetor" class="list-group-item list-group-item-action">
        <i class="fa fa-gears mr-2"></i>Saldo Awal Kurang Lebih Setor
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/saldokasbesar" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Saldo Kas Besar
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/penjualankasbesar" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Laporan Penjualan
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/uanglogam" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Uang Logam
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/rekapbg" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Rekap BG
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/lpu" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>LPU
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/omset" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Omsets
      </a>
    </div>
  </div>
<?php } else if ($level == "kasir" || $level == "kepala admin" || $level == "spv cabang") { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Setoran
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setoranpenjualan" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Penjualan
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setoranpusat" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Pusat
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setorangiro" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Giro
      </a>
      <a href="<?php echo base_url(); ?>penjualan/setorantransfer" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Setoran Transfer
      </a>
      <a href="<?php echo base_url(); ?>penjualan/logamtokertas" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Ganti Logam ke Kertas
      </a>
      <a href="<?php echo base_url(); ?>penjualan/kuranglebihsetor" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Kurang / Lebih Setor
      </a>
      <a href="<?php echo base_url(); ?>penjualan/belumsetor" class="list-group-item list-group-item-action">
        <i class="fa fa-money mr-2"></i>Uang Belum Disetorkan
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Saldo Awal
      </a>

      <a href="<?php echo base_url(); ?>penjualan/saldokurlebsetor" class="list-group-item list-group-item-action">
        <i class="fa fa-gears mr-2"></i>Saldo Awal Kurang Lebih Setor
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Laporan
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/saldokasbesar" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Saldo Kas Besar
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/penjualankasbesar" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Laporan Penjualan
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/uanglogam" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Uang Logam
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/rekapbg" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Rekap BG
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/lpu" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>LPU
      </a>
      <a href="<?php echo base_url(); ?>laporanpenjualan/omset" class="list-group-item list-group-item-action">
        <i class="fa fa-file-pdf-o mr-2"></i>Omsets
      </a>
    </div>
  <?php } else if (
  $level == "audit" || $level == "general manager" || $level == "kepala cabang" || $level == "manager accounting" || $level == "manager marketing"
  || $level == "spv accounting"
) { ?>
    <div class="card">
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
          Laporan
        </a>
        <a href="<?php echo base_url(); ?>penjualan/setoranpenjualan" class="list-group-item list-group-item-action">
          <i class="fa fa-file-pdf-o mr-2"></i>Setoran Penjualan
        </a>
        <a href="<?php echo base_url(); ?>laporanpenjualan/saldokasbesar" class="list-group-item list-group-item-action">
          <i class="fa fa-file-pdf-o mr-2"></i>Saldo Kas Besar
        </a>
        <a href="<?php echo base_url(); ?>laporanpenjualan/penjualankasbesar" class="list-group-item list-group-item-action">
          <i class="fa fa-file-pdf-o mr-2"></i>Laporan Penjualan
        </a>
        <a href="<?php echo base_url(); ?>laporanpenjualan/uanglogam" class="list-group-item list-group-item-action">
          <i class="fa fa-file-pdf-o mr-2"></i>Uang Logam
        </a>
        <a href="<?php echo base_url(); ?>laporanpenjualan/rekapbg" class="list-group-item list-group-item-action">
          <i class="fa fa-file-pdf-o mr-2"></i>Rekap BG
        </a>
        <a href="<?php echo base_url(); ?>laporanpenjualan/lpu" class="list-group-item list-group-item-action">
          <i class="fa fa-file-pdf-o mr-2"></i>LPU
        </a>
        <a href="<?php echo base_url(); ?>laporanpenjualan/omset" class="list-group-item list-group-item-action">
          <i class="fa fa-file-pdf-o mr-2"></i>Omsets
        </a>
      </div>
    </div>
  <?php } else if ($level == "keuangan") {
  $this->load->view('menu/menu_keuangan_administrator'); ?>
  <?php } ?>