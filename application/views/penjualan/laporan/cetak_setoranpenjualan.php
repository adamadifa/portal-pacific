<?php
	//error_reporting(0);
	function uang($nilai){
		return number_format($nilai,'0','','.');
	}

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css">
<b style="font-size:20px; font-family:Calibri">
    REKAP HARIAN KAS BESAR LAPORAN HARIAN PENJUALAN
    <br>
    CABANG <?php echo strtoupper($cb['nama_cabang']); ?>
    <br>
    PERIODE <?php echo DateToIndo2($dari)." s/d ".DateToIndo2($sampai); ?><br>
</b>
<br>
<table class="datatable3"  border="1">
  	<thead style=" background-color:#dce6f1; font-size:12;">
	  <tr  style=" background-color:#dce6f1; font-size:12;">
          <th rowspan="2" style="color:red">TGL LHP</th>
          <th rowspan="2">SALES</th>
          <th rowspan="2">PENJUALAN TUNAI</th>
          <th rowspan="2">TAGIHAN</th>
          <th rowspan="2" style="color:red">TOTAL LHP</th>
          <th colspan="4">SETORAN</th>
          <th rowspan="2" style="color:red">TOTAL SETORAN</th>
          <th rowspan="2" style="background-color:red; color:white">SELISIH</th>
          <th rowspan="2">KETERANGAN</th>
      </tr>
      <tr style=" background-color:#dce6f1; font-size:12;">
          <th>U.KERTAS</th>
          <th>U.LOGAM</th>
					<th>TRANSFER</th>
          <th>BG/CEK</th>
      </tr>
      <tr style=" background-color:#31869b;">
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
					<th></th>
      </tr>
    </thead>
    <tbody>
        <?php
            $total_lhptunai     = 0;
            $total_lhptagihan   = 0;
            $totalall_lhp       = 0;
            $total_setorankertas= 0;
            $total_setoranlogam = 0;
            $total_setoranbg    = 0;
						$total_setorantrf 	= 0;
            $totalall_setoran   = 0;
            $totalselisih       = 0;
          	foreach ($setoran as $key => $s){
              $tgl          = @$setoran[$key+1]->tgl_lhp;
              $totallhp     = $s->lhp_tunai + $s->lhp_tagihan;
              $kl           = $this->db->get_where('kuranglebihsetor',array('tgl_kl'=>$s->tgl_lhp,'id_karyawan'=>$s->id_karyawan))->row_array();
              $cekkl        = $this->db->get_where('kuranglebihsetor',array('tgl_kl'=>$s->tgl_lhp,'id_karyawan'=>$s->id_karyawan))->num_rows();

                if($kl['pembayaran']=="1"){
                  $uk = $kl['uang_kertas'];
                  $ul = $kl['uang_logam'];
                  $op = "+";
                  $ket= "DITAMBAH PEMBAYARAN KURANG SETOR ".$kl['keterangan']. " Uang Kertas : <b>".$kl['uang_kertas']."</b> Uang Logam : <b>". $kl['uang_logam']."</b>";
                }else if($kl['pembayaran']=="2"){
                  $uk = -$kl['uang_kertas'];
                  $ul = -$kl['uang_logam'];
                  $op = "-";
                  $ket= "DIKURANGI PEMBAYARAN LEBIH SETOR ".$kl['keterangan']. " Uang Kertas : <b>".$kl['uang_kertas']."</b> Uang Logam : <b>". $kl['uang_logam']."</b>";
                }else{
                  $uk = -$kl['uang_kertas'];
                  $ul = -$kl['uang_logam'];
                  $op = "-";
                  $ket= "";
                }

              $totalsetoran         = $s->setoran_kertas + $uk + $s->setoran_logam + $ul + $s->setoran_lainnya + $s->setoran_bg + $s->setoran_transfer;
              $selisih              = $totalsetoran-$totallhp;

              $total_lhptunai       = $total_lhptunai + $s->lhp_tunai;
              $total_lhptagihan     = $total_lhptagihan + $s->lhp_tagihan;
              $totalall_lhp         = $totalall_lhp + $totallhp;

              $total_setorankertas  = $total_setorankertas + ($s->setoran_kertas + $uk);
              $total_setoranlogam   = $total_setoranlogam + ($s->setoran_logam  + $ul);
              $total_setoranbg      = $total_setoranbg + $s->setoran_bg;
							$total_setorantrf 		= $total_setorantrf + $s->setoran_transfer;
              $totalall_setoran     = $totalall_setoran + $totalsetoran;


              $totalselisih         = $totalselisih + $selisih;
              if(!empty($s->keterangan) OR !empty($cekkl)){
                  $color = "yellow";
              }else{
                  $color =  "";
              }
        ?>
            <tr style="font-size:12">
			    <td style=" background-color:red; font-size:12; color:white"><?php echo DateToIndo2($s->tgl_lhp);?></td>
                <td><?php echo $s->nama_karyawan;?></td>
                <td align="right"><?php echo uang($s->lhp_tunai);?></td>
                <td align="right"><?php echo uang($s->lhp_tagihan);?></td>
                <td align="right"><?php echo uang($totallhp);?></td>
                <td align="right"><?php echo uang($s->setoran_kertas + $uk);?></td>
                <td align="right"><?php echo uang($s->setoran_logam  + $ul);?></td>
               
								<td align="right"><?php echo uang($s->setoran_transfer);?></td>
                <td align="right"><?php echo uang($s->setoran_bg);?></td>
                <td align="right"><?php echo uang($totalsetoran);?></td>
                <td align="right"><?php echo uang($selisih);?></td>
                <td style="background-color:<?php echo $color; ?>"><?php echo $s->keterangan. "|". $ket; ?></td>
            </tr>

        <?php

              if ($tgl != $s->tgl_lhp) {
                echo '
                    <tr bgcolor="#31869b" style="color:white; font-weight:bold">
                        <td colspan="12" ></td>
                    </tr>';
              }
              $tgl = $s->tgl_lhp;
            }
        ?>
    </tbody>
    <tfoot bgcolor="#024a75" style="color:white; font-weight:bold">
        <tr bgcolor="#024a75" style="color:white; font-weight:bold">
            <td colspan="2">TOTAL</td>
            <td align="right"><?php echo uang($total_lhptunai);?></td>
            <td align="right"><?php echo uang($total_lhptagihan);?></td>
            <td align="right"><?php echo uang($totalall_lhp);?></td>
            <td align="right"><?php echo uang($total_setorankertas);?></td>
            <td align="right"><?php echo uang($total_setoranlogam);?></td>
            <td align="right"><?php echo uang($total_setorantrf);?></td>
            <td align="right"><?php echo uang($total_setoranbg);?></td>
					
            <td align="right"><?php echo uang($totalall_setoran);?></td>
            <td align="right"><?php echo uang($totalselisih);?></td>
            <td></td>
        </tr>
    </tfoot>
</table>
