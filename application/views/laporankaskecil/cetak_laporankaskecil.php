<?php

	function uang($nilai){

		return number_format($nilai,'0','','.');
	}
	error_reporting(0);

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">

<br>
<b style="font-size:14px; font-family:Calibri">


	<?php
		if($cb['nama_cabang'] != "pusat"){
			echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
		}else{
			echo "PACIFIC PUSAT";
		}

	?>
	<br>
  KAS KECIL<br>
  PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
  <br>
  <br>

  <table class="datatable3">
  	<thead bgcolor="#024a75" style="color:white; font-size:12;">
  		<tr bgcolor="#024a75" style="color:white; font-size:12;">
        <th>No</th>
        <th>TGL</th>
        <th>NO BUKTI</th>
        <th>KETERANGAN</th>
        <th>KODE AKUN</th>
        <th>AKUN</th>
        <th>PENERIMAAN</th>
        <th>PENGELUARAN</th>
        <th>SALDO</th>
        <th rowspan="2">TANGGAL INPUT</th>
        <th rowspan="2">TANGGAL UPDATE</th>
      </tr>
      <tr>
        <th bgcolor="orange" style="color:white; font-size:12;" colspan="8">SALDO AWAL</th>
        <th align="right"><?php echo uang($saldoawal['saldo_awal']); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no                = 1;
        $saldo             = $saldoawal['saldo_awal'];
        $totalpenerimaan   = 0;
        $totalpengeluaran  = 0;
        foreach($kaskecil as $k){
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
					$date_created = date_create($k->date_created);
					$date_updated = date_create($k->date_updated);

					if(!empty($k->date_updated))
					{
						$dateupdated = date_format($date_updated,"d M Y H:i:s");
					}else{
						$dateupdated = $date_updated;
					}

					if(!empty($k->date_created))
					{
						$datecreated = date_format($date_created,"d M Y H:i:s");
					}else{
						$datecreated = $date_created;
					}

      ?>
        <tr style="font-size:12;">
          <td><?php echo $no; ?></td>
          <td><?php echo DateToIndo2($k->tgl_kaskecil); ?></td>
          <td><?php echo $k->nobukti; ?></td>
          <td><?php echo $k->keterangan; ?></td>
          <td><?php echo "<font color=white>'</font>".$k->kode_akun; ?></td>
          <td><?php echo $k->nama_akun; ?></td>
          <td align="right"><?php echo uang($penerimaan); ?></td>
          <td align="right"><?php echo uang($pengeluaran); ?></td>
          <td align="right"><?php echo uang($saldo); ?></td>
          <td><?php echo $datecreated; ?></td>
          <td><?php echo $dateupdated; ?></td>

        </tr>
      <?php
				$no++;
      }
      ?>
    </tbody>
    <tfooter>
      <tr bgcolor="#024a75" style="color:white; font-size:12;">
        <th colspan="6">TOTAL</th>
        <th style="text-align:right"><?php echo uang($totalpenerimaan); ?></th>
        <th style="text-align:right"><?php echo uang($totalpengeluaran); ?></th>
        <th style="text-align:right"><?php echo uang($saldo); ?></th>
      </tr>
    </tfooter>
  </table>
	<br>
	<br>
  REKAP KAS KECIL<br>
  PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
  <br>
  <br>
  <table class="datatable3">
  	<thead bgcolor="#024a75" style="color:white; font-size:12;">
  		<tr bgcolor="#024a75" style="color:white; font-size:12;">
        <th>KODE AKUN</th>
        <th>AKUN</th>
        <th>PENERIMAAN</th>
        <th>PENGELUARAN</th>
      </tr>
    </thead>
    <tbody>
			<?php
				$rekappenerimaan		 = 0;
				$rekappengeluaran 	 = 0;
				foreach($rekap as $r){
					$rekappenerimaan 	= $rekappenerimaan + $r->penerimaan;
					$rekappengeluaran = $rekappengeluaran + $r->pengeluaran;
			?>
				<tr  style="font-size:12;">
					<td><?php echo $r->kode_akun; ?></td>
					<td><?php echo $r->nama_akun; ?></td>
				  <td style="text-align:right"><?php echo uang($r->penerimaan); ?></td>
				  <td style="text-align:right"><?php echo uang($r->pengeluaran); ?></td>
				</tr>
			<?php
			}
			?>
		</tbody>
		<tfooter>
      <tr bgcolor="#024a75" style="color:white; font-size:12;">
        <th colspan="2">TOTAL</th>
        <th style="text-align:right"><?php echo uang($rekappenerimaan); ?></th>
        <th style="text-align:right"><?php echo uang($rekappengeluaran); ?></th>
      </tr>
    </tfooter>
  </table>
