<?php
	error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:20px; font-family:Calibri">
LAPORAN PENERIMAAN BG / CEK CABANG
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
  	<thead style=" background-color:#31869b; color:white; font-size:12;">
	      <tr  style=" background-color:#31869b; color:white; font-size:12;">
          <th>TGL PENERIMAAN</th>
          <th>SALES</th>
          <th>NO FAKTUR</th>
          <th>NAMA PELANGGAN</th>
          <th>NAMA BANK</th>
          <th>NO CHEQUE</th>
          <th>TGL JATUH TEMPO</th>
          <th>JUMLAH PENERIMAAN</th>
          <th>TGL PENCAIRAN</th>
          <th>SALDO GIRO BELUM CAIR</th>
        </tr>
    </thead>
    <tbody>
        <?php
          $totalgiro = 0;
          $totalgirobc = 0;
          $totalgiroall = 0;
          $totalgiroallbc = 0;
          foreach($rekapbg as $key => $r){
            $nogiro  = @$rekapbg[$key+1]->no_giro;


              if(empty($r->tgl_pencairan)){
                //Giro Belum Cair
                $girobc = $r->jumlah;
								$tglcair= "";
              }else{
                $girobc = 0;
								$tglcair=$r->tgl_pencairan;
              }

              $totalgiro    = $totalgiro + $r->jumlah;
              $totalgirobc  = $totalgirobc + $girobc;
              $totalgiroall = $totalgiroall + $r->jumlah;
              $totalgiroallbc = $totalgiroallbc + $girobc;
        ?>
          <tr style="font-size:12px">
            <td><?php echo DateToIndo2($r->tgl_giro); ?></td>
            <td><?php echo $r->nama_karyawan; ?></td>
            <td><?php echo $r->no_fak_penj; ?></td>
            <td><?php echo $r->nama_pelanggan; ?></td>
            <td><?php echo $r->namabank; ?></td>
            <td><?php echo $r->no_giro; ?></td>
            <td><?php echo DateToIndo2($r->jatuhtempo); ?></td>
            <td align="right" style="font-weight:bold"><?php if(!empty($r->jumlah)){echo uang($r->jumlah);} ?></td>
            <td><?php if(!empty($tglcair)){echo DateToIndo2($tglcair);} ?></td>
            <td align="right" style="font-weight:bold; background-color:#54bbd8"><?php if(!empty($girobc)){echo uang($girobc);} ?></td>
          </tr>
        <?php
          if($nogiro != $r->no_giro){
            echo '
						<tr bgcolor="#199291" style="color:white; font-weight:bold">
              <td colspan="7">TOTAL</td>
              <td align="right">'.uang($totalgiro).'</td>
              <td></td>
              <td align="right">'.uang($totalgirobc).'</td>
						</tr>';
            $totalgiro    = 0;
            $totalgirobc  = 0;
          }
        }
        ?>
				
    </tbody>
    <tfoot>
    <tr style="font-size:12px" bgcolor="yellow">
        <th colspan="7">TOTAL</th>
        <th style="text-align:right"><?php if(!empty($totalgiroall)){echo uang($totalgiroall);} ?></th>
        <th></th>
        <th style="text-align:right"><?php if(!empty($totalgiroallbc)){echo uang($totalgiroallbc);} ?></th>
    </tr>
    </tfoot>
</table>
