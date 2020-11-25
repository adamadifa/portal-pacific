<?php
	//error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:20px; font-family:Calibri">
  POSISI UANG LOGAM
  <br>
  <?php
	if($cb['nama_cabang'] != ""){
		echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
	}else{
		echo "PACIFIC ALL CABANG";
  }
  $saldoawal = $saldoawal;
?>
	<br>
	PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
</b>
<br>
<table class="datatable3"  border="1">
	<thead style=" background-color:#31869b; color:white; font-size:12;">
    <tr  style=" background-color:#31869b; color:white; font-size:12;">
      <th>TGL</th>
      <th>PENERIMAAN LHP</th>
      <th>PENGELUARAN</th>
      <th>SALDO</th>
    </tr>
    <tr style=" background-color:orange; color:white; font-size:12;" >
      <th colspan="3">SALDO AWAL</th>
      <th><?php if(!empty($saldoawal)){echo uang($saldoawal);} ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
      $saldo       = $saldoawal;
      $totalterima = 0;
      $totalkeluar = 0;
      while (strtotime($dari) <= strtotime($sampai)) {
        $qpengeluaran    = "SELECT SUM(uang_logam) as totalsetoranpusat FROM setoran_pusat WHERE tgl_setoranpusat ='$dari' AND kode_cabang='$cb[kode_cabang]' GROUP BY tgl_setoranpusat";
        $pengeluaran     = $this->db->query($qpengeluaran)->row_array();
        $qpenerimaan     = "SELECT SUM(setoran_logam) as totalsetoranlhp FROM setoran_penjualan WHERE tgl_lhp ='$dari' AND kode_cabang='$cb[kode_cabang]' GROUP BY tgl_lhp";
        $penerimaan      = $this->db->query($qpenerimaan)->row_array();
        $qkl_kb          = "SELECT SUM(uang_kertas) as klkertas, SUM(uang_logam) as kllogam FROM kuranglebihsetor WHERE tgl_kl='$dari' AND kode_cabang='$cb[kode_cabang]' AND pembayaran='1' GROUP BY tgl_kl";
        $kl_kb           = $this->db->query($qkl_kb)->row_array();
        $qkl_lb          = "SELECT SUM(uang_kertas) as klkertas, SUM(uang_logam) as kllogam FROM kuranglebihsetor WHERE tgl_kl='$dari' AND kode_cabang='$cb[kode_cabang]' AND pembayaran='2' GROUP BY tgl_kl";
        $kl_lb           = $this->db->query($qkl_lb)->row_array();
        $qgl             = "SELECT SUM(jumlah_logamtokertas) as jmlgantilogam FROM logamtokertas WHERE tgl_logamtokertas='$dari' AND kode_cabang='$cb[kode_cabang]' GROUP BY tgl_logamtokertas";
        $gl              = $this->db->query($qgl)->row_array();
        $lhp             = $penerimaan['totalsetoranlhp'] + $kl_kb['kllogam']-$kl_lb['kllogam'];
        $setoranpusat    = $pengeluaran['totalsetoranpusat']+$gl['jmlgantilogam'];
        $saldo           = $saldo+($lhp-$setoranpusat);
        $totalterima     = $totalterima + $lhp;
        $totalkeluar     = $totalkeluar + $setoranpusat;
      ?>
      <tr>
        <td><?php echo DateToIndo2($dari); ?></td>
        <td align="right" style="font-weight:bold; color:green"><?php if(!empty($lhp)){echo uang($lhp);} ?></td>
        <td align="right" style="font-weight:bold; color:red"><?php if(!empty($setoranpusat)){echo uang($setoranpusat);} ?></td>
        <td align="right" style="font-weight:bold;"><?php if(!empty($saldo)){echo uang($saldo);} ?></td>
      </tr>
      <?php
        $dari = date ("Y-m-d", strtotime("+1 day", strtotime($dari)));//looping tambah 1 date
      }
    ?>
	</tbody>
  <tfoot>
    <tr style=" background-color:#31869b; font-weight:bold; color:white; font-size:12;">
      <td>TOTAL</td>
      <td align="right"><?php echo uang($totalterima); ?></td>
      <td align="right"><?php echo uang($totalkeluar); ?></td>
      <td align="right"><?php echo uang($saldo); ?></td>
    </tr>
  </tfoot>
</table>
