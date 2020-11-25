<?php

	function uang($nilai){

		return number_format($nilai,'2',',','.');
	}
	error_reporting(0);
	$namabulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");


?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<br>
<b style="font-size:16px; font-family:Calibri">
	PACIFIC CABANG <?php echo strtoupper($cb['nama_cabang']); ?><br>
	REKAPITULASI PERSEDIAAN BARANG<br>
	BULAN <?php echo strtoupper($namabulan[$bulan]); ?> TAHUN <?php echo $tahun; ?>
	<table>
		<tr>
			<td><b>KODE PRODUK</b></td>
			<td>:</td>
			<td><b><?php echo $produk['kode_produk']; ?></b></td>
		</tr>
		<tr>
			<td><b>PRODUK</b></td>
			<td>:</td>
			<td><b><?php echo $produk['nama_barang']; ?></b></td>
		</tr>
	</table>
</b>
<br>
<table style="width:120%">
  <tr>
    <td valign="top">
      <table class="datatable3" border="1" style="width:100%">
      	<thead>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="4">PENERIMAAN PUSAT</th>
          </tr>
      		<tr>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">JUMLAH</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">KETERANGAN</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total = 0;
            foreach($mutasi as $m){
              $jumlah = $m->jumlah / $m->isipcsdus;
              if($m->inout_good=='IN'){
      					$color_sa = "#28a745";
                $operator = "";
      				}else{
      					$color_sa= "#c7473a";
                $operator = "-";
      				}

              $jml = $operator.$jumlah;

              $total = $total + $jml;
          ?>
            <tr>
              <td><?php echo DateToIndo2($m->tgl_mutasi_gudang_cabang); ?></td>
              <td><?php echo $m->no_mutasi_gudang_cabang; ?></td>
              <td  style="text-align:right; background-color:<?php echo $color_sa; ?>"><?php echo uang($jumlah); ?></td>
              <td>
                <?php
                  if($m->jenis_mutasi !="SURAT JALAN"){
                    echo $m->jenis_mutasi." ".$m->no_suratjalan;
                  }
                ?>
              </td>
            </tr>
         <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2">TOTAL</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($total); ?></th>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2"></th>
          </tr>
        </tfoot>
      </table>
    </td>

    <td valign="top">
      <table class="datatable3" border="1" style="width:100%">
      	<thead>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="8">MUTASI DPB</th>
          </tr>
      		<tr>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">NO DPB</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">SALESMAN</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">TUJUAN</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">NO KENDARAAN</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL PENGAMBILAN</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">JUMLAH PENGAMBILAN</th>
            <th bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL PENGEMBALIAN</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">JUMLAH PENGEMBALIAN</th>
      			
          </tr>
        </thead>
        <tbody>
          <?php
            $jmlpengambilan = 0;
            $jmlpengembalian = 0;
            foreach($mutasidpb as $m){
              $jmlpengambilan = $jmlpengambilan + $m->jml_pengambilan;
              $jmlpengembalian = $jmlpengembalian + $m->jml_pengembalian;
          ?>
            <tr>
              <td><?php echo $m->no_dpb; ?></td>
              <td><?php echo $m->nama_karyawan; ?></td>
              <td><?php echo $m->tujuan; ?></td>
              <td><?php echo $m->no_kendaraan; ?></td>
              <td><?php echo DateToIndo2($m->tgl_pengambilan); ?></td>
              <td style="text-align:right; background-color:#c7473a"><?php echo uang($m->jml_pengambilan); ?></td>
              <td><?php echo DateToIndo2($m->tgl_pengembalian); ?></td>
              <td style="text-align:right; background-color:#28a745"><?php echo uang($m->jml_pengembalian); ?></td>
             
         <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="5">TOTAL</th>
            <th style="text-align:right; background-color:#c7473a"><?php echo uang($jmlpengambilan); ?></th>
            <th></th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($jmlpengembalian); ?></th>
            
          </tr>
        </tfoot>
      </table>
    </td>

    
    <td valign="top">
      <table class="datatable3" border="1" style="width:100%">
        <thead>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="4">REJECT</th>
          </tr>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL</th>
            <th bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
            <th bgcolor="#024a75" style="color:white; font-size:12;">JUMLAH</th>
            <th bgcolor="#024a75" style="color:white; font-size:12;">KETERANGAN</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $totalreject = 0;
            foreach($mutasireject as $m){
              $jumlah = $m->jumlah / $m->isipcsdus;
              


              $totalreject = $totalreject + $jumlah;
          ?>
            <tr>
              <td><?php echo DateToIndo2($m->tgl_mutasi_gudang_cabang); ?></td>
              <td><?php echo $m->no_mutasi_gudang_cabang; ?></td>
              <td  style="text-align:right; background-color:#c7473a"><?php echo uang($jumlah); ?></td>
              <td>
                <?php
                  echo $m->jenis_mutasi;
                ?>
              </td>
            </tr>
         <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2">TOTAL</th>
            <th style="text-align:right; background-color:#c7473a"><?php echo uang($totalreject); ?></th>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2"></th>
          </tr>
        </tfoot>
      </table>
    </td>

    <td valign="top">
      <table class="datatable3" border="1" style="width:100%">
        <thead>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="4">REPACK</th>
          </tr>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL</th>
            <th bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
            <th bgcolor="#024a75" style="color:white; font-size:12;">JUMLAH</th>
            <th bgcolor="#024a75" style="color:white; font-size:12;">KETERANGAN</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $totalrepack = 0;
            foreach($mutasirepack as $m){
              $jumlah = $m->jumlah / $m->isipcsdus;
              

              $totalrepack = $totalrepack + $jumlah;
          ?>
            <tr>
              <td><?php echo DateToIndo2($m->tgl_mutasi_gudang_cabang); ?></td>
              <td><?php echo $m->no_mutasi_gudang_cabang; ?></td>
              <td  style="text-align:right; background-color:#28a745"><?php echo uang($jumlah); ?></td>
              <td>
                <?php
                  echo $m->jenis_mutasi;
                ?>
              </td>
            </tr>
         <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2">TOTAL</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($totalrepack); ?></th>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2"></th>
          </tr>
        </tfoot>
      </table>
    </td>
    <td valign="top">
      <table class="datatable3" border="1" style="width:100%">
      	<thead>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="4">PENYESUAIN</th>
          </tr>
      		<tr>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">TANGGAL</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">BUKTI</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">JUMLAH</th>
      			<th bgcolor="#024a75" style="color:white; font-size:12;">KETERANGAN</th>
          </tr>
        </thead>
        <tbody>
          <?php
          
            $totalpenyesuaian = 0;
            foreach($mutasipenyesuaian as $m){
              $jumlah = $m->jumlah / $m->isipcsdus;
              if($m->inout_good=='IN'){
      					$color_sa = "#28a745";
                $operator = "";
      				}else{
      					$color_sa= "#c7473a";
                $operator = "-";
      				}

              $jml = $operator.$jumlah;

              $totalpenyesuaian = $totalpenyesuaian + $jml;
          ?>
            <tr>
              <td><?php echo DateToIndo2($m->tgl_mutasi_gudang_cabang); ?></td>
              <td><?php echo $m->no_mutasi_gudang_cabang; ?></td>
              <td  style="text-align:right; background-color:<?php echo $color_sa; ?>"><?php echo uang($jumlah); ?></td>
              <td>
                <?php
                
                  echo $m->jenis_mutasi;
                  
                ?>
              </td>
            </tr>
         <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2">TOTAL</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($totalpenyesuaian); ?></th>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2"></th>
          </tr>
        </tfoot>
      </table>
    </td>
    <td valign="top">
      <table class="datatable3" border="1" style="width:100%">
      	<thead>
          <tr>
            <th bgcolor="#024a75" style="color:white; font-size:12;" colspan="2">REKAP</th>
          </tr>
          <tr>
            <th>SALDO AWAL</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($saldoawal); ?></th>
          </tr>
          <tr>
            <th>PENERIMAAN PUSAT</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($total); ?></th>
          </tr>
          <tr>
            <th>PENGAMBILAN DPB</th>
            <th style="text-align:right; background-color:#c7473a"><?php echo uang($jmlpengambilan); ?></th>
          </tr>
          <tr>
          
          <tr>
            <th>PENGEMBALIAN</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($jmlpengembalian); ?></th>
          </tr>
          <tr>
            <th>REJECT</th>
            <th style="text-align:right; background-color:#c7473a"><?php echo uang($totalreject); ?></th>
          </tr>
          <tr>
            <th>REPACK</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($totalrepack); ?></th>
          </tr>
          <tr>
            <th>PENYESUAIAN</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($totalpenyesuaian); ?></th>
          </tr>
          <tr>
            <th>SISA STOK</th>
            <th style="text-align:right; background-color:#28a745"><?php echo uang($saldoawal + $total - $jmlpengambilan + $jmlpengembalian -$totalreject+$totalrepack+$totalpenyesuaian); ?></th>
          </tr>
        </thead>
      </table>
    </td>
  </tr>
</table>
