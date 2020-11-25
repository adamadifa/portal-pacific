<?php

	function uang($nilai){

		return number_format($nilai,'2',',','.');
	}
	error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">


	<?php
		echo "PACIFIC CABANG ". strtoupper($bank);
	?>
	<br>
  LAPORAN MUTASI BANK<br>
  KAS KECIL PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
  <br>
  <br>

  <table class="datatable3">
  	<thead bgcolor="#024a75" style="color:white; font-size:12;">
  		<tr bgcolor="#024a75" style="color:white; font-size:12;">
        <th>No</th>
        <th>TGL</th>
        <th>KETERANGAN</th>
				<th>KODE AKUN</th>
				<th>NAMA AKUN</th>
        <th>PENERIMAAN</th>
        <th>PENGELUARAN</th>
        <th>SALDO</th>
      </tr>
      <tr>
    </tr>
      <tr>
        <th bgcolor="orange" style="color:white; font-size:12;" colspan="7">SALDO AWAL</th>
        <th align="right"><?php if($saldo['jumlah']!=0){echo uang($saldo['jumlah']);}?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no                = 1;
        $saldo             = $saldo['jumlah'];
        $totalpenerimaan   = 0;
        $totalpengeluaran  = 0;
        foreach($mutasibank as $k){
          if($k->status_dk=='K'){
            $penerimaan   = $k->jumlah;
            $s 						= $penerimaan;
            $pengeluaran  = "";
          }else{
            $penerimaan   = "";
            $pengeluaran  = $k->jumlah;
            $s 						= -$pengeluaran;
          }

          $saldo            = $saldo + $s;
          $totalpenerimaan  = $totalpenerimaan + $penerimaan;
          $totalpengeluaran = $totalpengeluaran + $pengeluaran;
      ?>
        <tr style="font-size:12;">
          <td><?php echo $no; ?></td>
          <td><?php echo DateToIndo2($k->tgl_ledger); ?></td>
          <td><?php echo $k->keterangan; ?></td>
					<td><?php echo "<font color=white>'</font>". $k->kode_akun; ?></td>
					<td><?php echo $k->nama_akun; ?></td>
          <td align="right"><?php echo uang($penerimaan); ?></td>
          <td align="right"><?php echo uang($pengeluaran); ?></td>
          <td align="right"><?php echo uang($saldo); ?></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
    <tfooter>
      <tr bgcolor="#024a75" style="color:white; font-size:12;">
        <th colspan="5">TOTAL</th>
        <th style="text-align:right"><?php echo uang($totalpenerimaan); ?></th>
        <th style="text-align:right"><?php echo uang($totalpengeluaran); ?></th>
        <th style="text-align:right"><?php echo uang($saldo); ?></th>
      </tr>
    </tfooter>
  </table>
