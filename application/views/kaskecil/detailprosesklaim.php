
<div class="card">
    <div class="header bg-cyan">
        <h2>
            Detail Klaim
            <small>Detail Klaim</small>
        </h2>
    </div>
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
              <table class="table table-bordered table-hover">
                <tr>
                  <td>Kode Klaim</td>
                  <td>:</td>
                  <td><b><?php echo $klaim['kode_klaim']; ?></b></td>
                </tr>
                <tr>
                  <td>Tanggal Klaim</td>
                  <td>:</td>
                  <td><b><?php echo DateToIndo2($klaim['tgl_klaim']); ?></b></td>
                </tr>
                <tr>
                  <td>Keterangan</td>
                  <td>:</td>
                  <td><b><?php echo $klaim['keterangan']; ?></b></td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>:</td>
                  <td>
                    <?php
                      if($klaim['status']=='0'){
                        $keterangan = "Belum Di Proses";
                        $color 			= "bg-red";
                      }else{
                        $keterangan = "Sudah di Proses";
                        $color 			= "bg-green";
                      }
                    ?>
                    <span class="badge <?php echo $color; ?>"><?php echo $keterangan; ?></span>
                  </td>

                </tr>
              </table>
              <table class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                    <th>TGL</th>
                    <th>No Bukti</th>
                    <th>Keterangan</th>
                    <th>Penerimaan</th>
                    <th>Pengeluaran</th>
                    <th>Saldo</th>
                  </tr>
                  <tr>
                    <th>SALDO AWAL</th>
                    <th colspan="4"></th>
                    <th style="text-align:right"><?php if(!empty($saldoawal['jumlah'])){echo number_format($saldoawal['jumlah'],'0','','.');}?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $saldo            = $saldoawal['jumlah'];
                    $totalpenerimaan	= 0;
                    $totalpengeluaran = 0;
                    $totalpenerimaan2 = 0;
                    foreach($detail as $d){
                      if($d->status_dk=='K'){
                        $penerimaan   = $d->jumlah;
                        $s 						= $penerimaan;
                        $pengeluaran  = "";
                      }else{
                        $penerimaan   = "";
                        $pengeluaran  = $d->jumlah;
                        $s 						= -$pengeluaran;
                      }

                      $saldo              = $saldo + $s;
                      $totalpenerimaan 		= $totalpenerimaan + $penerimaan;
                      $totalpengeluaran		= $totalpengeluaran + $pengeluaran;
                      if($d->keterangan != 'Penerimaan Kas Kecil'){
                        $totalpenerimaan2 = $totalpenerimaan2 + $penerimaan;
                      }
                  ?>
                  <tr>
                    <td><?php echo $d->tgl_kaskecil;?></td>
                    <td><?php echo $d->nobukti;?></td>
                    <td><?php echo $d->keterangan;?></td>
                    <td align="right" style="color:green"><?php if(!empty($penerimaan)){echo number_format($penerimaan,'0','','.');}?></td>
                    <td align="right" style="color:red"><?php 	if(!empty($pengeluaran)){echo number_format($pengeluaran,'0','','.');}?></td>
                    <td align="right"><?php 	if(!empty($saldo)){echo number_format($saldo,'0','','.');}?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <tfooter>
                  <tr>
                    <th colspan="3">TOTAL</th>
                    <td align="right" style="color:green"><b><?php if(!empty($totalpenerimaan)){echo number_format($totalpenerimaan,'0','','.');}?></b></td>
                    <td align="right" style="color:red"><b><?php 	if(!empty($totalpengeluaran)){echo number_format($totalpengeluaran,'0','','.');}?></b></td>
                    <td align="right"><b><?php 	if(!empty($saldo)){echo number_format($saldo,'0','','.');}?></b></td>
                  </tr>
                  <tr>
                    <td  class="bg-green">Penggantian Kas Kecil</td>
                      <?php
                        if($klaim['kode_cabang']=='PST'){
                          $penggantian = $totalpengeluaran - $totalpenerimaan2;
                        }else{
                          $penggantian = $totalpengeluaran;
                        }
                      ?>
                    <td colspan="2" align="right"><b><?php 	if(!empty($penggantian)){echo number_format($penggantian,'0','','.');}?></b></td>
                    <td  class="bg-green">Saldo Awal</td>
                    <td colspan="2" align="right"><b><?php 	if(!empty($saldoawal['jumlah'])){echo number_format($saldoawal['jumlah'],'0','','.');}?></b></td>
                  </tr>
                  <tr>
                    <td class="bg-green">Terbilang</td>
                    <td colspan="2" align="right"><b><?php  echo ucfirst(terbilang($penggantian)); ?></b></td>
                    <td  class="bg-green">Penerimaan Pusat</td>
                    <td colspan="2" align="right" ><b><?php if(!empty($totalpenerimaan)){echo number_format($totalpenerimaan,'0','','.');}?></b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td  class="bg-green">Total</td>
                    <td colspan="2" align="right" ><b><?php if(!empty($saldoawal['jumlah']+$totalpenerimaan)){echo number_format($saldoawal['jumlah']+$totalpenerimaan,'0','','.');}?></b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td  class="bg-green">Pengeluaran Kas Kecil</td>
                    <td colspan="2" align="right"><b><?php 	if(!empty($totalpengeluaran)){echo number_format($totalpengeluaran,'0','','.');}?></b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td  class="bg-green">Saldo Akhir</td>
                    <td colspan="2" align="right"><b><?php 	if(!empty($saldo)){echo number_format($saldo,'0','','.');}?></b></td>
                  </tr>

                </tfooter>
              </table>
            </div>
        </div>
    </div>
</div>
