<div class="row clearfix">
	<div class="col-md-12">
        <div class="card">
            <div class="header bg-cyan">
                <h2>
                    Data Pembayaran Pelanggan
                    <small>List Data Pembayaran</small>
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <form action="" method="post">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input name="search" value="<?php echo $search; ?>" type="text" class="form-control">
                                            <label class="form-label">Cari Nama Pelanggan</label>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                     <div class="form-group form-float">
                                        <input type="submit" name="submit" class="btn bg-red m-l-15 waves-effect" value="cari">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                           <table class="table table-bordered table-striped table-hover" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                         <th>Cabang</th>
                                        <th>Jml Piutang</th>
                                        <th>Jml Bayar</th>
                                        <th>Sisa Bayar</th>
                                        <th>Ket</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sno                = $row+1;
                                        $totalallpiutang    = 0;
                                        $totalallbayar      = 0;
                                        $totalallsisabayar  = 0;
                                        foreach($result as $data){

                                            $totalallpiutang    = $totalallpiutang + $data['totalpiutang'];
                                            $totalallbayar      = $totalallbayar + $data['totalbayar'];
                                            $totalallsisabayar  = $totalallsisabayar + $data['totalsisabayar'];

                                     ?>
                                        <tr>
                                            <td><?php echo $sno; ?></td>
                                            <td><?php echo $data['kode_pelanggan']; ?></td>
                                            <td><?php echo $data['nama_pelanggan']; ?></td>
                                            <td><?php echo $data['kode_cabang']; ?></td>
                                            <td align="right"><?php echo number_format($data['totalpiutang'],'0','','.'); ?></td>
                                            <td align="right"><?php echo number_format($data['totalbayar'],'0','','.');  ?></td>
                                            <td align="right"><?php echo number_format($data['totalsisabayar'],'0','','.');  ?></td>
                                            <td>
                                                <?php

                                                    if($data['totalsisabayar'] == 0){
                                                        $color ="bg-green";
                                                        $ket   ="LUNAS";
                                                    }else{

                                                        $color ="bg-red";
                                                        $ket   = "BELUM LUNAS" ;   
                                                    }
                                                       
                                                ?>
                                                <span class="badge <?php echo $color ?>"><?php echo $ket; ?>
                                            </td>
                                            <td><a href="<?php echo base_url();?>pembayaran/listfaktur/<?php echo $data['kode_pelanggan'] ?>" class="btn bg-green btn-xs waves-effect">Detail</a></td>
                                        </tr>

                                     <?php       
                                          $sno++;

                                        }

                                        if(count($result) == 0){
                                          echo "<tr>";
                                          echo "<td colspan='8'>Data Tidak Ditemukan</td>";
                                          echo "</tr>";
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="4"><b>TOTAL</b></td>
                                        <td align="right"><?php echo number_format($totalallpiutang,'0','','.');  ?></td>
                                        <td align="right"><?php echo number_format($totalallbayar,'0','','.');  ?></td>
                                        <td align="right"><?php echo number_format($totalallsisabayar,'0','','.');  ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style='margin-top: 10px;'>
                            <?php echo $pagination; ?>
                       </div>

                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
<!-------------