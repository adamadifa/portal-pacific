<?php
function uang($nilai){
  return number_format($nilai,'2',',','.');
}

$hariini = date("Y-m-d");
 

?>

<table class="table">
  <thead class="">
    <tr class="text-right">
      <th class="text-left">Nama Cabang</th>
      <th>AB</th>
      <th>AR</th>
      <th>AS</th>
      <th>BB</th>
      <th>CG</th>
      <th>CGG</th>
      <th>DB</th>
      <th>DEP</th>
      <th>DK</th>
      <th>DS</th>
    </tr>
  </thead>

<?php
foreach ($saldo as $r){
  $ab = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='AB' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $ar = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='AR' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $as = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='AS' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $bb = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='BB' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $cg = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='CG' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $cgg = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='CGG' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $db = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='DB' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $dep = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='DEP' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $dk = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='DK' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $ds = $this->db->query("SELECT tanggal,kode_produk,jumlah FROM saldoawal_bj_detail saldodetail
  INNER JOIN saldoawal_bj ON saldodetail.kode_saldoawal = saldoawal_bj.kode_saldoawal 
  WHERE kode_cabang ='$r->kode_cabang' AND kode_produk='DS' AND status='GS' ORDER BY tanggal DESC LIMIT 1")->row_array();

  $mab = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$ab[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$ab[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='AB'")->row_array();

  $mar= $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$ar[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$ar[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='AR'")->row_array();

  $mas = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$as[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$as[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='AS'")->row_array();

  $mbb = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$bb[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$bb[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='BB'")->row_array();

  $mcg = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$cg[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$cg[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='CG'")->row_array();

  $mcgg = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$cgg[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$cgg[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='CGG'")->row_array();

  $mdb = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$db[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$db[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='DB'")->row_array();

  $mdep = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$dep[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$dep[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='DEP'")->row_array();

  $mdk = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$dk[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$dk[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='DK'")->row_array();

  $mds = $this->db->query("SELECT 
  SUM(IF(inout_good ='IN' AND tgl_mutasi_gudang_cabang >= '$ds[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini'  ,jumlah,0))-

  SUM(IF(inout_good ='OUT' AND tgl_mutasi_gudang_cabang >= '$ds[tanggal]' 
  AND tgl_mutasi_gudang_cabang <= '$hariini' ,jumlah,0)) 
  as sisamutasi

  FROM detail_mutasi_gudang_cabang dmgc
  INNER JOIN mutasi_gudang_cabang mgc ON dmgc.no_mutasi_gudang_cabang = mgc.no_mutasi_gudang_cabang
  WHERE kode_cabang='$r->kode_cabang' AND kode_produk='DS'")->row_array();

  $sab = $ab['jumlah'] + $mab['sisamutasi'];
  $sar = $ar['jumlah'] + $mar['sisamutasi'];
  $sas = $as['jumlah'] + $mas['sisamutasi'];
  $sbb = $bb['jumlah'] + $mbb['sisamutasi'];
  $scg  = $cg['jumlah'] + $mcg['sisamutasi'];
  $scgg = $cgg['jumlah'] + $mcgg['sisamutasi'];
  $sdb  = $db['jumlah'] + $mdb['sisamutasi'];
  $sdep = $dep['jumlah'] + $mdep['sisamutasi'];
  $sdk  = $dk['jumlah'] + $mdk['sisamutasi'];
  $sds  = $ds['jumlah'] + $mds['sisamutasi'];

  if($sab <= 0){
    $colorab = "bg-red";
  }else{
    $colorab= "bg-green";
  }

  if($sar <= 0){
    $colorar = "bg-red";
  }else{
    $colorar= "bg-green";
  }

  if($sas <= 0){
    $coloras = "bg-red";
  }else{
    $coloras= "bg-green";
  }

  if($sbb <= 0){
    $colorbb = "bg-red";
  }else{
    $colorbb= "bg-green";
  }

  if($scg <= 0){
    $colorcg = "bg-red";
  }else{
    $colorcg= "bg-green";
  }

  if($scgg <= 0){
    $colorcgg = "bg-red";
  }else{
    $colorcgg= "bg-green";
  }

  if($sdb <= 0){
    $colorsdb = "bg-red";
  }else{
    $colorsdb= "bg-green";
  }

  if($sdep <= 0){
    $colorsdep = "bg-red";
  }else{
    $colorsdep = "bg-green";
  }

  if($sdk <= 0){
    $colorsdk = "bg-red";
  }else{
    $colorsdk = "bg-green";
  }

  if($sds <= 0){
    $colorsds = "bg-red";
  }else{
    $colorsds = "bg-green";
  }
 ?>
  <tr class="text-right">
    <td class="text-left"><b><?php echo strtoupper($r->nama_cabang); ?></b></td>
    <td><span class="badge <?php echo $colorab; ?>"><?php echo number_format($sab/30,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorar; ?>"><?php echo number_format($sar/240,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $coloras; ?>"><?php echo number_format($sas/36,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorbb; ?>"><?php echo number_format($sbb/20,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorcg; ?>"><?php echo number_format($scg/10,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorcgg; ?>"><?php echo number_format($scgg/10,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorsdb; ?>"><?php echo number_format($sdb/20,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorsdep; ?>"><?php echo number_format($sdep/20,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorsdk; ?>"><?php echo number_format($sdk/30,'0',',','.'); ?></span></td>
    <td><span class="badge <?php echo $colorsds; ?>"><?php echo number_format($sds/504,'0',',','.'); ?></span></td>
  </tr>
<?php } ?>
</table>
