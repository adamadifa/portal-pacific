<?php
	//error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:20px; font-family:Calibri">
LAPORAN OMSET PENJUALAN SALES
<br>
<?php 
if($cb['nama_cabang'] != ""){
  echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
}else{
  echo "PACIFIC ALL CABANG";
}
?>
<br>
PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br><br>
<table class="datatable3"  border="1">
  	<thead style=" background-color:#31869b; color:white; font-size:14px;">
	      <tr  style=" background-color:#31869b; color:white; font-size:14px;">
          <th>NO</th>
          <th>SALES</th>
          <th>TOTAL OMSET</th>
          <th>GIRO JATUH TEMPO</th>
          <th>GIRO PERIODE LALU <br> SUDAH JATUH TEMPO</th>
          <th>GIRO BULAN BERJALAN <br> BELUM JATUH TEMPO</th>
        </tr>
    </thead>
    <tbody>
        <?php
          $no = 1;
          $totalallomset      = 0;
          $totalgirojt        = 0;
          $totalgirolalujt    = 0;
          $totalgirobelumjt   = 0;
          $totalbelumtransfer = 0;
          foreach($omset as $o){
            $totalallomset      = $totalallomset + $o->total_omset;
            $totalgirojt        = $totalgirojt + $o->giro_jt;
            $totalgirolalujt    = $totalgirolalujt + $o->girolalu_jt;
            $totalgirobelumjt   = $totalgirobelumjt + $o->giro_belumjt;
            $totalbelumtransfer  = $totalbelumtransfer + $o->belumtransfer;
        ?>
            <tr style="font-size:14px">
                <td style=" background-color:#31869b; color:white; font-size:14px; font-weight:bold"><?php echo $no; ?></td>
                <td style=" background-color:#31869b; color:white; font-size:14px; font-weight:bold"><?php echo $o->nama_karyawan; ?></td>
                <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($o->total_omset)){echo uang($o->total_omset);} ?></td>
                <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($o->giro_jt)){echo uang($o->giro_jt);} ?></td>
                <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($o->girolalu_jt)){echo uang($o->girolalu_jt);} ?></td>
                <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($o->giro_belumjt)){echo uang($o->giro_belumjt);} ?></td>
                
            </tr>
        <?php 
            $no++;
          }
        ?>
    </tbody>
    <tfoot>
        <tr style=" background-color:#31869b; color:white; font-size:14px;">
            <td colspan="2"><b>TOTAL</b></td>
            <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($totalallomset)){echo uang($totalallomset);} ?></td>
            <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($totalgirojt)){echo uang($totalgirojt);} ?></td>
            <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($totalgirolalujt)){echo uang($totalgirolalujt);} ?></td>
            <td align="right" style="font-weight:bold; font-size:14px;"><?php if(!empty($totalgirobelumjt)){echo uang($totalgirobelumjt);} ?></td>
        </tr>
    </tfoot>
</table>
<br>
<?php 

      $omset = ($totalallomset - $totalgirobelumjt) + $totalgirolalujt ; 

?>
<table>
    <tr>
      <td><b>TOTAL OMSET</b></td>
      <td>:</td>
      <td align="right" style="font-weight:bold; font-size:16px;"><?php if(!empty($totalallomset)){echo uang($totalallomset);} ?></td>
    </tr>
    <tr>
      <td><b>GIRO BELUM JATUH TEMPO</b></td>
      <td>:</td>
      <td align="right" style="font-weight:bold; font-size:16px;"><?php if(!empty($totalgirobelumjt)){echo uang($totalgirobelumjt);} ?></td>
    </tr>
    <tr>
      <td><b>GIRO SUDAH JATUH TEMPO</b></td>
      <td>:</td>
      <td align="right" style="font-weight:bold; font-size:16px;"><?php if(!empty($totalgirolalujt)){echo uang($totalgirolalujt);} ?></td>
    </tr>
    <tr>
      <td><b>UANG BELUM SETOR</b></td>
      <td>:</td>
      <td align="right" style="font-weight:bold; font-size:16px;"><?php if(!empty($totalbelumtransfer)){echo uang($totalbelumtransfer);} ?></td>
    </tr>
    <tr>
      <td><b>OMSET</b></td>
      <td>:</td>
      <td align="right" style="font-weight:bold; font-size:16px; border-top:1px solid #000000"><?php if(!empty($omset)){echo uang($omset);} ?></td>
    </tr>
</table>