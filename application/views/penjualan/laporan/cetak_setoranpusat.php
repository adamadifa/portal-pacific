<?php
	//error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:20px; font-family:Calibri">
    RINCIAN SETORAN KAS BESAR PADA BANK/ PUSAT
    <br>
    CABANG <?php echo strtoupper($cb['nama_cabang']); ?>
    <br>
    PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
</b>
<br>
<table class="datatable3"  border="1">
  	<thead style=" background-color:#31869b; font-size:12;">
	    <tr  style=" background-color:#31869b; color:white; font-size:12;">
        <th style="padding:10px !important!;">TANGGAL</th>
        <th>KETERANGAN</th>
        <th>BANK</th>
        <th>KERTAS</th>
        <th>LOGAM</th>
				<th>TRANSFER</th>
        <th>GIRO</th>
        <th>JUMLAH SETOR</th>
        <th>TGL DITERIMA PUSAT</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $total_uangkertas = 0;
        $total_uanglogam  = 0;
        $total_giro       = 0;
				$total_transfer 	= 0;
        $total_setoran    = 0;
        foreach ($setoran as $s){

          $jumlahsetor = $s->uang_kertas + $s->uang_logam + $s->giro + $s->transfer;

          $total_uangkertas = $total_uangkertas + $s->uang_kertas;
          $total_uanglogam  = $total_uanglogam + $s->uang_logam;
          $total_giro       = $total_giro + $s->giro;
					$total_transfer 	=$total_transfer + $s->transfer;
          $total_setoran    = $total_setoran + $jumlahsetor;

      ?>
        <tr>
          <td><?php echo DateToIndo2($s->tgl_setoranpusat); ?></td>
          <td><?php echo $s->keterangan; ?></td>
          <td><?php echo $s->bank; ?></td>
          <td align="right"><?php if(!empty($s->uang_kertas)){echo uang($s->uang_kertas);}?></td>
          <td align="right"><?php if(!empty($s->uang_logam)){echo uang($s->uang_logam);}?></td>
					<td align="right"><?php if(!empty($s->transfer)){echo uang($s->transfer);}?></td>
          <td align="right"><?php if(!empty($s->giro)){echo uang($s->giro);}?></td>
          <td align="right"><?php echo uang($jumlahsetor);?></td>
          <td align="right"><?php if(!empty($s->tgl_diterimapusat)){echo DateToIndo2($s->tgl_diterimapusat);}?></td>
        </tr>
      <?php
        }
      ?>
      <tr bgcolor="#024a75" style="color:white; font-weight:bold">
        <td colspan="3">TOTAL</td>
        <td align="right"><?php echo uang($total_uangkertas);?></td>
        <td align="right"><?php echo uang($total_uanglogam);?></td>
				<td align="right"><?php echo uang($total_transfer);?></td>
        <td align="right"><?php echo uang($total_giro);?></td>
        <td align="right"><?php echo uang($total_setoran);?></td>
        <td></td>
      </tr>
    </tbody>
</table>
<br>
<br>
<table class="datatable3"  border="1">
  	<thead>
	    <tr style=" background-color:orange; color:black; font-size:12;">
        <th colspan="5" style="text-align:left">SUMMARY</th>
      </tr>
      <tr  style=" background-color:#31869b; color:white; font-size:12;">
        <th>BANK</th>
        <th>UANG KERTAS</th>
        <th>UANG LOGAM</th>
				<th>TRANSFER</th>
        <th>GIRO</th>
      </th>
    </thead>
    <tbody>
    <?php
      foreach ($rekap as $r){
    ?>
        <tr>
          <td><?php echo $r->bank; ?></td>
          <td align="right"><?php echo uang($r->uang_kertas);?></td>
          <td align="right"><?php echo uang($r->uang_logam);?></td>
					<td align="right"><?php echo uang($r->transfer);?></td>
          <td align="right"><?php echo uang($r->giro);?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
