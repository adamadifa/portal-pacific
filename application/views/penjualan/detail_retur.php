<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <h2 class="page-title">
                    Data Retur
                </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <!-- Content here -->
                    <div class="row">
                        <div class="col-md-5 col-xs-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Data Retur</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <td><b>No Retur</b></td>
                                            <td></td>
                                            <td id="nofaktur"><?php echo $retur['no_retur_penj']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tanggal Retur</b></td>
                                            <td></td>
                                            <td id="nofaktur"><?php echo DateToIndo2($retur['tglretur']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>No Faktur</b></td>
                                            <td></td>
                                            <td id="nofaktur"><?php echo $faktur['no_fak_penj']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tgl Transaksi</b></td>
                                            <td></td>
                                            <td><?php echo DateToIndo2($faktur['tgltransaksi']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Kode Pelanggan</b></td>
                                            <td></td>
                                            <td><?php echo $faktur['kode_pelanggan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nama Pelanggan</b></td>
                                            <td></td>
                                            <td><?php echo $faktur['nama_pelanggan']; ?></td>
                                        </tr>
                                        <td><b>Pasar</b></td>
                                        <td></td>
                                        <td><?php echo $faktur['pasar']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Salesman</b></td>
                                            <td></td>
                                            <td><?php echo $faktur['nama_karyawan']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-xs-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-sm">
                                        <div class="card-body d-flex align-items-center">
                                            <span class="bg-blue text-white stamp mr-3" style="height:9rem !important; min-width:8rem !important ">
                                                <i class="fa f fa-shopping-cart" style="font-size: 4rem;"></i>
                                            </span>
                                            <div class="ml-3 lh-lg">
                                                <div class="strong" style="font-size: 3rem;" id="grandtotal">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th colspan="9"><b>Detail Retur</b></th>
                                                    </tr>
                                                    <tr>

                                                        <th>Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th>Jml Dus</th>
                                                        <th>Harga Dus</th>
                                                        <th>Jml Pack</th>
                                                        <th>Harga Pack</th>
                                                        <th>Jml Pcs</th>
                                                        <th>Harga Pcs</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $totalreturpf = 0;
                                                    foreach ($returpf as $d) {
                                                        $totalreturpf = $totalreturpf + $d->subtotal;

                                                        $jmldus     = floor($d->jumlah / $d->isipcsdus);
                                                        $sisadus    = $d->jumlah % $d->isipcsdus;

                                                        if ($d->isipack == 0) {
                                                            $jmlpack    = 0;
                                                            $sisapack   = $sisadus;
                                                        } else {

                                                            $jmlpack    = floor($sisadus / $d->isipcs);
                                                            $sisapack   = $sisadus % $d->isipcs;
                                                        }

                                                        $jmlpcs = $sisapack;
                                                    ?>
                                                        <tr>

                                                            <td><?php echo $d->kode_barang; ?></td>
                                                            <td><?php echo $d->nama_barang; ?></td>
                                                            <td align="center"><?php echo $jmldus; ?></td>
                                                            <td align="right"><?php echo number_format($d->harga_dus, '0', '', '.'); ?></td>
                                                            <td align="center"><?php echo $jmlpack; ?></td>
                                                            <td align="right"><?php echo number_format($d->harga_pack, '0', '', '.'); ?></td>
                                                            <td align="center"><?php echo $jmlpcs; ?></td>
                                                            <td align="right"> <?php echo number_format($d->harga_pcs, '0', '', '.'); ?></td>
                                                            <td align="right"><?php echo number_format($d->subtotal, '0', '', '.'); ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td colspan="8"><b>TOTAL</b></td>
                                                        <td align="right"><b><?php echo number_format($totalreturpf, '0', '', '.'); ?></b>


                                                    </tr>



                                                </tbody>

                                            </table>
                                        </div>
                                        <?php $totalretur = $totalreturpf;
                                        echo "<p id='totalreturr'>" . number_format($totalretur, '0', '', '.') . "</p>"; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
          <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#totalreturr").hide();
        $("#grandtotal").text($("#totalreturr").text());

    });
</script>