<?php
	//error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:20px; font-family:Calibri">
    RINCIAN PENJUALAN SALES
    <br>
    <?php 
		if($cb['nama_cabang'] != ""){
			echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
		}else{
			echo "PACIFIC ALL CABANG";
    }
      
	?> 
    <br>
    PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
</b>
<br>
<table class="datatable3"  border="1" style="width:60%">
  	<thead>
	      <tr style=" background-color:#31869b; color:white; font-size:12;" >
          <th colspan="4"><?php echo $salesman['nama_karyawan']; ?></th>
        </tr>
        <tr>
          <th>TGL LHP</th>
          <th>TUNAI</th>
          <th>TAGIHAN</th>
          <th>TOTAL</th>
          
        </tr>
    </thead>
    <tbody>
    <?php
        $totaltunai     = 0;
        $totaltagihan   = 0;
        $totalall       = 0;
        foreach($setoran as $s){

          $total        = $s->lhp_tunai + $s->lhp_tagihan;
          $totaltunai   = $totaltunai + $s->lhp_tunai;
          $totaltagihan = $totaltagihan + $s->lhp_tagihan;
          $totalall     = $totalall + $total;
    ?>
          <tr style="font-size:12">
            <td><?php echo DateToIndo2($s->tgl_lhp); ?></td>
            <td align="right" style="font-weight:bold;"><?php if(!empty($s->lhp_tunai)){echo uang($s->lhp_tunai);} ?></td>
            <td align="right" style="font-weight:bold;"><?php if(!empty($s->lhp_tagihan)){echo uang($s->lhp_tagihan);} ?></td>
            <td align="right" style="font-weight:bold;"><?php if(!empty($total)){echo uang($total);} ?></td>
          </tr>
    <?php 
        }
    ?>
    </tbody>
    </tfoot>
          <tr style=" background-color:#31869b; color:white; font-size:12;">
            <td>TOTAL</td>
            <td align="right" style="font-weight:bold;"><?php if(!empty($totaltunai)){echo uang($totaltunai);} ?></td>
            <td align="right" style="font-weight:bold;"><?php if(!empty($totaltagihan)){echo uang($totaltagihan);} ?></td>
            <td align="right" style="font-weight:bold;"><?php if(!empty($totalall)){echo uang($totalall);} ?></td>
          </tr>
    </tfoot>
</table>
