<?php
	
	function uang($nilai){

		return number_format($nilai,'2',',','.');
	}

	if(!empty($sales)){

		$qsales = "AND id_karyawan = '$sales'";
	}else{

		$qsales ="";
	}

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:18px; font-family:Calibri">
<?php 
    if($cb['nama_cabang'] != ""){
        echo "PACIFIC CABANG ". strtoupper($cb['nama_cabang']);
    }else{
        echo "PACIFIC ALL CABANG";
    }
        
?>
<br>
RENCANA DAN EVALUASI PENGEMBANGAN OUTLET
<br>
PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>

<?php 
    if($salesman['nama_karyawan'] != ""){
        echo "NAMA SALES : ". strtoupper($salesman['nama_karyawan']);
    }else{
        echo "ALL SALES";
    }
        
?>
<br>
<br>
<table class="datatable3"  border="1">
  	<thead style=" background-color:#31869b; color:white; font-size:14px;">
	      <tr  style=" background-color:#31869b; color:white; font-size:14px;">
          <th>KODE PRODUK</th>
          <th>NAMA PRODUK</th>
          <th>OUTLET TERGARAP</th>
          <th>EFFECTIVE OUTLET</th>
          <th>SALES (QTY)</th>
          <th style="background-color:#024a75">NEW OUTLET</th>
          <th style="background-color:#024a75">SALES (QTY)</th>
          <th>OUTLET BERTRANSAKSI BULAN INI</th>
          <th>SALES (QTY)</th>
          <th>TOTAL OUTLET TERGARAP</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($repo as $r){

                $outletbertransaksi         = $r->efektifoutlet + $r->newoutlet;
                $totaloutletbertransaksi    = $r->totalpenjualaneo + $r->totalpenjualanno;
                $totaloutlettergarap        = $r->outlettergarap + $r->efektifoutlet + $r->newoutlet;

                //echo $outletbertransaksi;
        ?>
            <tr style="font-size:14px;">
                <td><b><?php echo $r->kode_produk; ?></b></td>
                <td><b><?php echo $r->nama_barang; ?></b></td>
                <td align="right"><b><?php if(!empty($r->outlettergarap)){echo uang($r->outlettergarap);} ?></b></td>
                <td align="right"><b><?php if(!empty($r->efektifoutlet)){echo uang($r->efektifoutlet);} ?></b></td>
                <td align="right"><b><?php if(!empty($r->totalpenjualaneo/$r->isipcsdus)){echo uang($r->totalpenjualaneo/$r->isipcsdus);} ?></b></td>
                <td align="right"><b><?php if(!empty($r->newoutlet)){echo uang($r->newoutlet);} ?></b></td>
                <td align="right"><b><?php if(!empty($r->totalpenjualanno/$r->isipcsdus)){echo uang($r->totalpenjualanno/$r->isipcsdus);} ?></b></td>
                <td align="right"><b><?php if(!empty($outletbertransaksi)){echo uang($outletbertransaksi);} ?></b></td>
                <td align="right"><b><?php if(!empty($totaloutletbertransaksi/$r->isipcsdus)){echo uang($totaloutletbertransaksi/$r->isipcsdus);} ?></b></td>
                <td align="right"><b><?php if(!empty($totaloutlettergarap)){echo uang($totaloutlettergarap);} ?></b></td>
            </tr>
            </tr>
        <?php 
            }
        ?>
    </tbody>
</table>