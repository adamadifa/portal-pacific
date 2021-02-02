<<<<<<< HEAD
<?php
$level = $this->session->userdata('level_user');
if ($level == "Administrator" || $level == "admin gudang" || $level == "kepala admin" || $level == "spv cabang") {
?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Saldo Awal
      </a>
      <a href="<?php echo base_url(); ?>dpb/saldoawalgs" class="list-group-item list-group-item-action">
        <i class="fa   fa-bookmark-o mr-2"></i>Saldo Awal Good Stok
      </a>
      <a href="<?php echo base_url(); ?>dpb/saldoawalbs" class="list-group-item list-group-item-action">
        <i class="fa   fa-bookmark-o mr-2"></i>Saldo Awal Bad Stok
      </a>
    </div>
  </div>
  <?php if ($this->session->userdata('cabang') == 'TSM') { ?>
    <div class="card">
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
          Permintaan Pengiriman
        </a>
        <a href="<?php echo base_url(); ?>oman/permintaan_pengiriman" class="list-group-item list-group-item-action">
          <i class="fa  fa-truck mr-2"></i>Permintaan Pengiriman
        </a>
      </div>
    </div>
  <?php } ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Perincian Barang (DPB)
      </a>
      <a href="<?php echo base_url(); ?>dpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>DPB
      </a>
    </div>
  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI IN
      </a>
      <a href="<?php echo base_url(); ?>oman/suratjalan_gjcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Surat Jalan
      </a>
      <a href="<?php echo base_url(); ?>oman/transit_in" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Transit IN
      </a>
      <a href="<?php echo base_url(); ?>dpb/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-history mr-2"></i>Retur
      </a>
      <a href="<?php echo base_url(); ?>dpb/hutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/plttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Pelunasan TTR
      </a>
      <a href="<?php echo base_url(); ?>repackreject/repackcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Repack
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI OUT
      </a>
      <a href="<?php echo base_url(); ?>dpb/penjualan" class="list-group-item list-group-item-action">
        <i class="fa  fa-shopping-cart mr-2"></i>Penjualan
      </a>
      <a href="<?php echo base_url(); ?>dpb/gantibarang" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Ganti Barang
      </a>
      <a href="<?php echo base_url(); ?>repackreject/reject_gudang" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Gudang
      </a>
      <a href="<?php echo base_url(); ?>dpb/rejectpasar" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Pasar
      </a>
      <a href="<?php echo base_url(); ?>dpb/plhutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Pelunasan Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/ttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>TTR
      </a>
      <a href="<?php echo base_url(); ?>dpb/promosi" class="list-group-item list-group-item-action">
        <i class="fa fa-credit-card mr-2"></i>Promosi
      </a>
      <a href="<?php echo base_url(); ?>repackreject/kirimpusat" class="list-group-item list-group-item-action">
        <i class="fa fa-truck mr-2"></i>Kirim Pusat
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        PENYESUAIAN
      </a>
      <a href="<?php echo base_url(); ?>repackreject/penyesuaian" class="list-group-item list-group-item-action">
        <i class="fa  fa-balance-scale mr-2"></i>Penyesuaian Good Stok
      </a>
      <a href="<?php echo base_url(); ?>repackreject/penyesuaianbad" class="list-group-item list-group-item-action">
        <i class="fa  fa-balance-scale mr-2"></i>Penyesuaian Bad Stok
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappersediaancabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbadstok" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Bad Stok
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbjcabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/mutasidpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Mutasi DPB
      </a>
    </div>
  </div>
<?php } else if (
  $level == "audit" || $level == "emf1" || $level == "general manager" || $level == "kepala cabang" || $level == "manager accounting" || $level == "manager marketing"
  || $level == "spv accounting"
) { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Perincian Barang (DPB)
      </a>
      <a href="<?php echo base_url(); ?>dpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>DPB
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI IN
      </a>
      <a href="<?php echo base_url(); ?>oman/suratjalan_gjcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Surat Jalan
      </a>
      <a href="<?php echo base_url(); ?>oman/transit_in" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Transit IN
      </a>
      <a href="<?php echo base_url(); ?>dpb/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-history mr-2"></i>Retur
      </a>
      <a href="<?php echo base_url(); ?>dpb/hutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/plttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Pelunasan TTR
      </a>
      <a href="<?php echo base_url(); ?>repackreject/repackcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Repack
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI OUT
      </a>
      <a href="<?php echo base_url(); ?>dpb/penjualan" class="list-group-item list-group-item-action">
        <i class="fa  fa-shopping-cart mr-2"></i>Penjualan
      </a>
      <a href="<?php echo base_url(); ?>dpb/gantibarang" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Ganti Barang
      </a>
      <a href="<?php echo base_url(); ?>repackreject/reject_gudang" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Gudang
      </a>
      <a href="<?php echo base_url(); ?>dpb/rejectpasar" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Pasar
      </a>
      <a href="<?php echo base_url(); ?>dpb/plhutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Pelunasan Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/ttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>TTR
      </a>
      <a href="<?php echo base_url(); ?>dpb/promosi" class="list-group-item list-group-item-action">
        <i class="fa fa-credit-card mr-2"></i>Promosi
      </a>
      <a href="<?php echo base_url(); ?>repackreject/kirimpusat" class="list-group-item list-group-item-action">
        <i class="fa fa-truck mr-2"></i>Kirim Pusat
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappersediaancabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbadstok" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Bad Stok
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbjcabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/mutasidpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Mutasi DPB
      </a>
    </div>
  </div>
=======
<?php
$level = $this->session->userdata('level_user');
if ($level == "Administrator" || $level == "admin gudang" || $level == "kepala admin" || $level == "spv cabang") {
?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Saldo Awal
      </a>
      <a href="<?php echo base_url(); ?>dpb/saldoawalgs" class="list-group-item list-group-item-action">
        <i class="fa   fa-bookmark-o mr-2"></i>Saldo Awal Good Stok
      </a>
      <a href="<?php echo base_url(); ?>dpb/saldoawalbs" class="list-group-item list-group-item-action">
        <i class="fa   fa-bookmark-o mr-2"></i>Saldo Awal Bad Stok
      </a>
    </div>
  </div>
  <?php if ($this->session->userdata('cabang') == 'TSM') { ?>
    <div class="card">
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
          Permintaan Pengiriman
        </a>
        <a href="<?php echo base_url(); ?>oman/permintaan_pengiriman" class="list-group-item list-group-item-action">
          <i class="fa  fa-truck mr-2"></i>Permintaan Pengiriman
        </a>
      </div>
    </div>
  <?php } ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Perincian Barang (DPB)
      </a>
      <a href="<?php echo base_url(); ?>dpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>DPB
      </a>
    </div>
  </div>

  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI IN
      </a>
      <a href="<?php echo base_url(); ?>oman/suratjalan_gjcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Surat Jalan
      </a>
      <a href="<?php echo base_url(); ?>oman/transit_in" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Transit IN
      </a>
      <a href="<?php echo base_url(); ?>dpb/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-history mr-2"></i>Retur
      </a>
      <a href="<?php echo base_url(); ?>dpb/hutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/plttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Pelunasan TTR
      </a>
      <a href="<?php echo base_url(); ?>repackreject/repackcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Repack
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI OUT
      </a>
      <a href="<?php echo base_url(); ?>dpb/penjualan" class="list-group-item list-group-item-action">
        <i class="fa  fa-shopping-cart mr-2"></i>Penjualan
      </a>
      <a href="<?php echo base_url(); ?>dpb/gantibarang" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Ganti Barang
      </a>
      <a href="<?php echo base_url(); ?>repackreject/reject_gudang" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Gudang
      </a>
      <a href="<?php echo base_url(); ?>dpb/rejectpasar" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Pasar
      </a>
      <a href="<?php echo base_url(); ?>dpb/plhutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Pelunasan Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/ttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>TTR
      </a>
      <a href="<?php echo base_url(); ?>dpb/promosi" class="list-group-item list-group-item-action">
        <i class="fa fa-credit-card mr-2"></i>Promosi
      </a>
      <a href="<?php echo base_url(); ?>repackreject/kirimpusat" class="list-group-item list-group-item-action">
        <i class="fa fa-truck mr-2"></i>Kirim Pusat
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        PENYESUAIAN
      </a>
      <a href="<?php echo base_url(); ?>repackreject/penyesuaian" class="list-group-item list-group-item-action">
        <i class="fa  fa-balance-scale mr-2"></i>Penyesuaian Good Stok
      </a>
      <a href="<?php echo base_url(); ?>repackreject/penyesuaianbad" class="list-group-item list-group-item-action">
        <i class="fa  fa-balance-scale mr-2"></i>Penyesuaian Bad Stok
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappersediaancabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbadstok" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Bad Stok
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbjcabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/mutasidpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Mutasi DPB
      </a>
    </div>
  </div>
<?php } else if (
  $level == "audit" || $level == "emf1" || $level == "general manager" || $level == "kepala cabang" || $level == "manager accounting" || $level == "manager marketing"
  || $level == "spv accounting"
) { ?>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        Data Perincian Barang (DPB)
      </a>
      <a href="<?php echo base_url(); ?>dpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text mr-2"></i>DPB
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI IN
      </a>
      <a href="<?php echo base_url(); ?>oman/suratjalan_gjcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Surat Jalan
      </a>
      <a href="<?php echo base_url(); ?>oman/transit_in" class="list-group-item list-group-item-action">
        <i class="fa  fa-truck mr-2"></i>Transit IN
      </a>
      <a href="<?php echo base_url(); ?>dpb/retur" class="list-group-item list-group-item-action">
        <i class="fa  fa-history mr-2"></i>Retur
      </a>
      <a href="<?php echo base_url(); ?>dpb/hutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/plttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>Pelunasan TTR
      </a>
      <a href="<?php echo base_url(); ?>repackreject/repackcab" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Repack
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        TRANSAKSI OUT
      </a>
      <a href="<?php echo base_url(); ?>dpb/penjualan" class="list-group-item list-group-item-action">
        <i class="fa  fa-shopping-cart mr-2"></i>Penjualan
      </a>
      <a href="<?php echo base_url(); ?>dpb/gantibarang" class="list-group-item list-group-item-action">
        <i class="fa  fa-refresh mr-2"></i>Ganti Barang
      </a>
      <a href="<?php echo base_url(); ?>repackreject/reject_gudang" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Gudang
      </a>
      <a href="<?php echo base_url(); ?>dpb/rejectpasar" class="list-group-item list-group-item-action">
        <i class="fa fa-sign-out mr-2"></i>Reject Pasar
      </a>
      <a href="<?php echo base_url(); ?>dpb/plhutangkirim" class="list-group-item list-group-item-action">
        <i class="fa  fa-car mr-2"></i>Pelunasan Hutang Kirim
      </a>
      <a href="<?php echo base_url(); ?>dpb/ttr" class="list-group-item list-group-item-action">
        <i class="fa  fa-copy mr-2"></i>TTR
      </a>
      <a href="<?php echo base_url(); ?>dpb/promosi" class="list-group-item list-group-item-action">
        <i class="fa fa-credit-card mr-2"></i>Promosi
      </a>
      <a href="<?php echo base_url(); ?>repackreject/kirimpusat" class="list-group-item list-group-item-action">
        <i class="fa fa-truck mr-2"></i>Kirim Pusat
      </a>
    </div>
  </div>
  <div class="card">
    <div class="list-group">
      <a href="#" class="list-group-item list-group-item-action active">
        LAPORAN
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekappersediaancabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Persediaan BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbadstok" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Bad Stok
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/rekapbjcabang" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Rekap BJ
      </a>
      <a href="<?php echo base_url(); ?>laporangudangjadi/mutasidpb" class="list-group-item list-group-item-action">
        <i class="fa  fa-file-text-o mr-2"></i>Mutasi DPB
      </a>
    </div>
  </div>
>>>>>>> f4071a7733d12169fd675d17b78b9e52bafe4802
<?php } ?>