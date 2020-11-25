<?php
	error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'2',',','.');
	}

  function angka($nilai){
		return number_format($nilai,'2',',','.');
	}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:14px; font-family:Calibri">
  TRANSAKSI PEMBAYARAN <br>
  PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
  <?php
		if($supplier != ""){
			echo "SUPPLIER : ". strtoupper($supp['nama_supplier']);
		}else{
			echo "ALL SUPPLIER";
		}
	?>
</b>
<br>
<br>
<table class="datatable3" style="width:100%" border="1">
	<thead bgcolor="#024a75" style="color:white; font-size:12;">
		<tr bgcolor="#024a75" style="color:white; font-size:12; text-align:center">
      <td>NO</td>
      <td>TGL</td>
      <td>NO BUKTI</td>
      <td>SUPPLIER</td>
			<td>NO KONTRABON</td>
      <td>CASH</td>
      <td>BCA</td>
      <td>BCA CV</td>
      <td>BNI MP VALLAS</td>
      <td>BNI</td>
      <td>BNI<br>CV MAKMUR PERMATA</td>
      <td>BCA<br>CV MAKMUR PERMATA</td>
      <td>KAS BESAR</td>
			<td>KAS KECIL</td>
      <td>LAIN LAIN/BANK CBG</td>
      <td>TOTAL</td>
			<td>TGL INPUT</td>
			<td>TGL UPDATE</td>
    </tr>
  </thead>
  <tbody>
		<?php
		  $cash 	 = 0;
			$bca  	 = 0;
			$bca_cv  = 0;
			$permata = 0;
			$bni 		 = 0;
			$bni_mp  = 0;
			$bca_mp  = 0;
			$kas     = 0;
			$kaskecil= 0;
			$lainlain= 0;

			$totalbayar  = 0;
      $no = 1;
      foreach ($pmb as $key => $d) {
				$cash 		= $cash + $d->cash;
				$bca  		= $bca + $d->bca;
				$bca_cv		= $bca_cv + $d->bca_cv;
				$permata  = $permata + $d->permata;
				$bni		  = $bni + $d->bni;
				$bni_mp   = $bni_mp + $d->bni_mp;
				$bca_mp   = $bca_mp + $d->bca_mp;
				$kas 			= $kas + $d->kasbesar;
				$kaskecil = $kaskecil + $d->kaskecil;
				$lainlain = $lainlain + $d->lainlain;
				$totalbayar = $totalbayar + $d->totalbayar;

		?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $d->tglbayar; ?></td>
				<td><?php echo $d->nobukti_pembelian; ?></td>
				<td><?php echo $d->nama_supplier; ?></td>
				<td><?php echo $d->no_kontrabon; ?></td>
				<td align="right"><?php if(!empty($d->cash)){echo uang($d->cash);} ?></td>
				<td align="right"><?php if(!empty($d->bca)){echo uang($d->bca);} ?></td>
				<td align="right"><?php if(!empty($d->bca_cv)){echo uang($d->bca_cv);} ?></td>
				<td align="right"><?php if(!empty($d->permata)){echo uang($d->permata);} ?></td>
				<td align="right"><?php if(!empty($d->bni)){echo uang($d->bni);} ?></td>

				<td align="right"><?php if(!empty($d->bni_mp)){echo uang($d->bni_mp);} ?></td>
				<td align="right"><?php if(!empty($d->bca_mp)){echo uang($d->bca_mp);} ?></td>
				<td align="right"><?php if(!empty($d->kasbesar)){echo uang($d->kasbesar);} ?></td>
				<td align="right"><?php if(!empty($d->kaskecil)){echo uang($d->kaskecil);} ?></td>
				<td align="right"><?php if(!empty($d->lainlain)){echo uang($d->lainlain)." (".$d->via.")";} ?></td>
				<td align="right"><?php if(!empty($d->totalbayar)){echo uang($d->totalbayar);} ?></td>
				<td><?php echo $d->log; ?></td>
				<td><?php echo $d->date_updated; ?></td>
			</tr>
		<?php $no++; } ?>
		<tr>
			<td colspan="5"><b>TOTAL</b></td>
			<td align="right"><b><?php if(!empty($cash)){echo uang($cash);} ?></b></td>
			<td align="right"><b><?php if(!empty($bca)){echo uang($bca);} ?></b></td>
			<td align="right"><b><?php if(!empty($bca_cv)){echo uang($bca_cv);} ?></b></td>
			<td align="right"><b><?php if(!empty($permata)){echo uang($permata);} ?></b></td>
			<td align="right"><b><?php if(!empty($bni)){echo uang($bni);} ?></b></td>
			<td align="right"><b><?php if(!empty($bni_mp)){echo uang($bni_mp);} ?></b></td>
			<td align="right"><b><?php if(!empty($bca_mp)){echo uang($bca_mp);} ?></b></td>
			<td align="right"><b><?php if(!empty($kas)){echo uang($kas);} ?></b></td>
			<td align="right"><b><?php if(!empty($kaskecil)){echo uang($kaskecil);} ?></b></td>
			<td align="right"><b><?php if(!empty($lainlain)){echo uang($lainlain);} ?></b></td>
			<td align="right"><b><?php if(!empty($totalbayar)){echo uang($totalbayar);} ?></b></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>

</table>

<br>
