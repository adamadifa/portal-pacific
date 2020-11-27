<div class="container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Penjualan
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
                  <h4 class="card-title">Data Penjualan</h4>
                </div>
                <div class="card-body">
                  <table class="table table-striped">
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
                      <td id="kodepel"><?php echo $faktur['kode_pelanggan']; ?></td>
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
                    <tr>
                      <td><b>Jenis Transaksi</b></td>
                      <td></td>
                      <td><?php echo strtoupper($faktur['jenistransaksi']); ?></td>
                    </tr>
                    <tr>
                      <td><b>Jenis Bayar</b></td>
                      <td></td>
                      <td><?php echo strtoupper($faktur['jenisbayar']); ?></td>
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
              <div class="row">
                <div class="col-md-3">
                  <div class="card" style="height:220px" id="loadfoto">
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="card" style="height:220px">
                    <div id="loaddatapelanggan">
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
                  <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th colspan="11"><b>Data Penjualan</b></th>
                      </tr>
                      <tr>
                        <th>Piutang</th>
                        <th>Potongan</th>
                        <th>Pot.Istimewa</th>
                        <th>Peny. Harga</th>
                        <th>Retur PF</th>
                        <th>Retur GB</th>
                        <th>Total Retur</th>
                        <th>Total</th>
                        <th>Jml Bayar</th>
                        <th>Sisa Bayar</th>
                        <th>Ket</th>
                      </tr>
                    </thead>
                    <tr>
                      <?php
                      if ($faktur['sisabayar'] == 0) {
                        $color = "bg-green";
                        $ket   = "LUNAS";
                      } else {
                        $color = "bg-red";
                        $ket   = "BELUM LUNAS";
                      }
                      ?>
                      <td align="right"><?php echo  number_format($faktur['subtotal'], '0', '', '.'); ?></td>
                      <td align="right"><?php echo  number_format($faktur['potongan'], '0', '', '.'); ?></td>
                      <td align="right"><?php echo  number_format($faktur['potistimewa'], '0', '', '.'); ?></td>
                      <td align="right"><?php echo  number_format($faktur['penyharga'], '0', '', '.'); ?></td>
                      <td align="right"><?php echo  number_format($faktur['totalpf'], '0', '', '.'); ?></td>
                      <td align="right"><?php echo  number_format($faktur['totalgb'], '0', '', '.'); ?></td>
                      <td align="right"><?php echo  number_format($faktur['totalretur'], '0', '', '.'); ?></td>
                      <td align="right" id="totalpiutang">
                        <input type="hidden" name="totpiutang" id="totpiutang" value="<?php echo $faktur['totalpiutang']; ?>">
                        <?php echo  number_format($faktur['totalpiutang'], '0', '', '.'); ?>
                      </td>
                      <td align="right">
                        <input type="hidden" name="totalbayar" id="totalbayar" value="<?php echo $faktur['totalbayar']; ?>">
                        <?php echo  number_format($faktur['totalbayar'], '0', '', '.'); ?>
                      </td>
                      <td align="right"><?php echo  number_format($faktur['sisabayar'], '0', '', '.'); ?></td>
                      <td>
                        <span class="badge <?php echo $color; ?>"><?php echo $ket; ?></span>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th colspan="9"><b>Detail Penjualan</b></th>
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
                      $total = 0;
                      foreach ($barang as $b) {
                        $jmldus     = floor($b->jumlah / $b->isipcsdus);
                        $sisadus    = $b->jumlah % $b->isipcsdus;
                        if ($b->isipack == 0) {
                          $jmlpack    = 0;
                          $sisapack   = $sisadus;
                        } else {
                          $jmlpack    = floor($sisadus / $b->isipcs);
                          $sisapack   = $sisadus % $b->isipcs;
                        }
                        $jmlpcs = $sisapack;
                        $total = $total + $b->subtotal;
                      ?>
                        <tr>
                          <td><?php echo $b->kode_barang; ?></td>
                          <td><?php echo $b->nama_barang; ?></td>
                          <td align="center"><?php echo $jmldus; ?></td>
                          <td align="right"><?php echo  number_format($b->harga_dus, '0', '', '.'); ?></td>
                          <td align="center"><?php echo $jmlpack; ?></td>
                          <td align="right"><?php echo  number_format($b->harga_pack, '0', '', '.'); ?></td>
                          <td align="center"><?php echo $jmlpcs; ?></td>
                          <td align="right"><?php echo  number_format($b->harga_pcs, '0', '', '.'); ?></td>
                          <td align="right"><?php echo  number_format($b->subtotal, '0', '', '.'); ?></td>
                        </tr>
                      <?php } ?>
                      <tr>
                        <td colspan="8"><b>TOTAL</b></td>
                        <td align="right"><b><?php echo  number_format($total, '0', '', '.'); ?></b></td>
                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th colspan="10"><b>Detail Retur</b></th>
                      </tr>
                      <tr>
                        <th>Tgl Retur</th>
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
                      $total = 0;
                      foreach ($returpf as $d) {
                        $total = $total + $d->subtotal;
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
                          <td><?php echo $d->tglretur; ?></td>
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
                        <td colspan="9"><b>TOTAL</b></td>
                        <td align="right"><b><?php echo number_format($total, '0', '', '.'); ?></b><input type="hidden" name="subtotal" value="<?php echo $total; ?>" onFocus="startCalc();"></td>
                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th colspan="10"><b>Detail Retur Ganti Barang</b></th>
                      </tr>
                      <tr>
                        <th>Tgl Retur</th>
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
                      $total = 0;
                      foreach ($returgb as $d) {
                        $total = $total + $d->subtotal;

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
                          <td><?php echo $d->tglretur; ?></td>
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
                        <td colspan="9"><b>TOTAL</b></td>
                        <td align="right"><b><?php echo number_format($total, '0', '', '.'); ?></b><input type="hidden" name="subtotal" value="<?php echo $total; ?>" onFocus="startCalc();"></td>

                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Histori Pembayaran</h4>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <?php if ($faktur['sisabayar'] != 0) { ?>
                    <a href="#" class="btn btn-primary" id="bayar"> <i class="fa fa-money mr-2"></i> Bayar</a>
                  <?php } else { ?>
                    <a href="#" class="btn btn-success" id="">LUNAS</a>
                  <?php } ?>
                </div>

                <table class="table table-bordered table-striped table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th>No Bukti</th>
                      <th>Tgl Bayar</th>
                      <th>Jenis Bayar</th>
                      <th>Jumlah Bayar</th>
                      <th>Keterangan</th>
                      <th>Salesman/Penagih</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $total = 0;
                    foreach ($bayar as $y) {
                      $total = $total + $y->bayar; ?>
                      <tr>
                        <td><?php echo $y->nobukti; ?></td>
                        <td><?php echo DateToIndo2($y->tglbayar); ?></td>
                        <td><?php echo ucwords($y->jenisbayar); ?></td>
                        <td align="right"><?php echo  number_format($y->bayar, '0', '', '.'); ?></td>
                        <td>
                          <?php
                          if ($y->girotocash == "1") {
                            echo "<span class='badge bg-green'>Penggantian Giro Ke Cash " . $y->no_giro . " </span>";
                          } else if ($y->status_bayar == "voucher") {
                            echo "<span class='badge bg-green'>" . $y->status_bayar . "</span>";
                          }
                          ?>
                        </td>
                        <td><?php if (empty($y->nama_karyawan)) {
                              echo $faktur['nama_karyawan'];
                            } else {
                              echo ucwords($y->nama_karyawan);
                            } ?></td>
                        <td>
                          <?php
                          if ($faktur['jenistransaksi'] != "tunai") {
                            if ($y->jenisbayar == "giro" or $y->jenisbayar == "transfer") {
                          ?>
                              <a href="#" data-nobukti="<?php echo $y->nobukti; ?>" class="btn btn-green btn-sm editbayar"><i class="fa fa-pencil"></i></a>
                              <a href="#" class="btn btn-red btn-sm hapus" data-href="<?php echo base_url(); ?>Pembayaran/hapus/<?php echo $y->nobukti; ?>/<?php echo $y->no_fak_penj; ?>"><i class="fa fa-trash-o"></i></a>
                            <?php
                            } else {
                            ?>
                              <a href="#" data-nobukti="<?php echo $y->nobukti; ?>" class="btn btn-green btn-sm editbayar"><i class="fa fa-pencil"></i></a>
                              <a href="#" class="btn btn-red btn-sm hapus" data-href="<?php echo base_url(); ?>Pembayaran/hapus/<?php echo $y->nobukti; ?>/<?php echo $y->no_fak_penj; ?>">
                                <i class="fa fa-trash-o"></i></a>
                          <?php }
                          } ?>
                        </td>
                      </tr>

                    <?php } ?>
                    <tr>
                      <td colspan="3"><b>TOTAL</b></td>
                      <td align="right"><?php echo  number_format($total, '0', '', '.'); ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <th colspan="7" style="text-align:center">Histori Pembayaran Lain Lain</th>
                    </tr>
                    <tr>
                      <th colspan="2">Tanggal</th>
                      <th colspan="2">Jumlah</th>
                      <th colspan="3">Aksi</th>
                    </tr>
                    <?php
                    foreach ($lainlain as $l) {
                    ?>
                      <tr>
                        <td colspan="2"><?php echo DateToIndo2($l->tgl_bayar); ?></td>
                        <td colspan="2"><?php echo number_format($l->jml_pot_lainlain, '0', '', '.'); ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>pembayaran/hapuspotlainlain/<?php echo $l->id; ?>/<?php echo $l->no_fak_penj; ?>" class="btn bg-red btn-xs"><i class="material-icons">delete</i></a>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Histori Pembayaran GIRO</h4>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <?php if ($faktur['sisabayar'] != 0) { ?>
                    <a href="#" class="btn btn-blue" id="inputgiro">Input Giro</a>
                  <?php } else { ?>
                    <a href="#" class="btn btn-green" id="">LUNAS</a>
                  <?php } ?>
                </div>

                <table class="table table-bordered table-striped table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th>Tgl Giro</th>
                      <th>No Giro</th>
                      <th>Nama Bank</th>
                      <th>Jumlah</th>
                      <th>Jatuh Tempo</th>
                      <th>Status</th>
                      <th>Ket</th>
                      <th>Salesman/Penagih</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($giro as $g) { ?>
                      <tr>
                        <td><?php if ($g->tgl_giro != "") {
                              echo DateToIndo2($g->tgl_giro);
                            } ?></td>
                        <td><?php echo $g->no_giro; ?></td>
                        <td><?php echo $g->namabank; ?></td>

                        <td align="right"><?php echo  number_format($g->jumlah, '0', '', '.'); ?></td>
                        <td><?php echo DateToIndo2($g->tglcair); ?></td>
                        <td>
                          <?php
                          if ($g->status == 0) {
                          ?>
                            <span class="badge bg-orange">Pending</span>
                          <?php
                          } elseif ($g->status == 1) {
                          ?>
                            <span class="badge bg-green">Diterima <?php echo $g->tglbayar; ?></span>
                          <?php
                          } elseif ($g->status == 2) {
                          ?>
                            <span class="badge bg-red">Ditolak</span>
                          <?php
                          }
                          ?>
                        </td>

                        <td><?php echo $g->ket; ?></td>
                        <td><?php if (empty($g->nama_karyawan)) {
                              echo $faktur['nama_karyawan'];
                            } else {
                              echo ucwords($g->nama_karyawan);
                            } ?></td>
                        <td>
                          <?php
                          if ($g->status == 0) {
                          ?>
                            <a href="#" data-id="<?php echo $g->id_giro; ?>" class="btn btn-primary btn-sm editgiro"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url(); ?>pembayaran/hapusgiro/<?php echo $g->id_giro; ?>/<?php echo $g->no_fak_penj; ?>"><i class="fa fa-trash-o"></i></a>
                          <?php
                          } elseif ($g->status == 2 and $g->ket == "") {
                          ?>
                            <a href="#" data-id="<?php echo $g->id_giro; ?>" class="btn btn-primary btn-sm editgiro"><i class="fa fa-pencil"></i></a>
                          <?php
                          } else {
                          ?>
                            <a href="#" data-id="<?php echo $g->id_giro; ?>" class="btn btn-primary btn-sm editgiro"><i class="fa fa-pencil"></i></a>
                          <?php
                          }
                          ?>
                        </td>
                      </tr>
                    <?php } ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Histori Pembayaran TRANSFER</h4>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <?php if ($faktur['sisabayar'] != 0) { ?>
                    <a href="#" class="btn btn-blue" id="inputtransfer">Input Transfer</a>
                  <?php } else { ?>
                    <a href="#" class="btn btn-green" id="">LUNAS</a>
                  <?php } ?>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Tanggal</th>
                        <th>Nama Bank</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Ket</th>
                        <th>Salesman/Penagih</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($transfer as $t) { ?>
                        <tr>
                          <td><?php if ($t->tgl_transfer != "") {
                                echo DateToIndo2($t->tgl_transfer);
                              } ?></td>
                          <td><?php echo $t->namabank; ?></td>
                          <td align="right"><?php echo  number_format($t->jumlah, '0', '', '.'); ?></td>
                          <td><?php echo DateToIndo2($t->tglcair); ?></td>
                          <td>
                            <?php
                            if ($t->status == 0) {
                            ?>
                              <span class="badge bg-orange">Pending</span>

                            <?php
                            } elseif ($t->status == 1) {

                            ?>
                              <span class="badge bg-green">Diterima <?php echo $t->tglbayar; ?></span>
                            <?php
                            } elseif ($t->status == 2) {
                            ?>
                              <span class="badge bg-red">Ditolak</span>
                            <?php
                            } elseif ($t->status == 3) {
                            ?>
                              <span class="badge bg-pink">Di Undur</span>
                            <?php
                            }
                            ?>
                          </td>
                          <td> <?php echo $t->ket; ?></td>
                          <td><?php if (empty($t->nama_karyawan)) {
                                echo $faktur['nama_karyawan'];
                              } else {
                                echo ucwords($t->nama_karyawan);
                              } ?></td>
                          <td>
                            <?php
                            if ($t->status == 0) {
                            ?>
                              <a href="#" data-id="<?php echo $t->id_transfer; ?>" class="btn btn-primary btn-sm edittransfer"><i class="fa fa-pencil"></i></a>
                              <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url(); ?>pembayaran/hapustransfer/<?php echo $t->id_transfer; ?>/<?php echo $t->no_fak_penj; ?>"><i class="fa fa-trash-o"></i></a>
                            <?php
                            } elseif ($t->status == 2 and $t->ket == "") {
                            ?>
                              <a href="#" data-id="<?php echo $t->id_transfer; ?>" class="btn bg-green btn-xs edittransfertolak"><i class="fa fa-pencil"></i></a>
                            <?php
                            } else {
                            ?>
                              <a href="#" data-id="<?php echo $t->id_transfer; ?>" class="btn bg-green btn-xs edittransfer"><i class="fa fa-pencil"></i></a>
                            <?php
                            }
                            ?>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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
<div class="modal modal-blur fade" id="inputbayar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">BAYAR</h5>
      </div>
      <div class="modal-body">
        <div class="loadformbayar"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-title">
          Yakin Untuk Di Hapus ?
        </div>
        <div>Jika Di Hapus, Kamu Akan Kehilangan Data Ini !</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete">Yes, Hapus !</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    function loadfoto() {
      var kodepelanggan = "<?php echo $faktur['kode_pelanggan']; ?>";
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/loadfoto',
        data: {
          kodepelanggan: kodepelanggan
        },
        cache: false,
        success: function(respond) {
          $("#loadfoto").html(respond);
        }
      });
    }

    // Load Data Pelanggan
    function loaddatapelanggan() {
      var kodepelanggan = "<?php echo $faktur['kode_pelanggan']; ?>";
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/loaddatapelanggan',
        data: {
          kodepelanggan: kodepelanggan
        },
        cache: false,
        success: function(respond) {
          $("#loaddatapelanggan").html(respond);
        }
      });
    }

    loaddatapelanggan();
    loadfoto();

    function loadTotal() {
      $("#grandtotal").text($("#totalpiutang").text());
    }

    loadTotal();

    $("#bayar").click(function(e) {
      var nofaktur = $("#nofaktur").text();
      var totalbayar = $("#totalbayar").val();
      var totalpiutang = $("#totpiutang").val();

      // alert(totalbayar);
      e.preventDefault();
      $("#inputbayar").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/inputbayar',
        data: {
          nofaktur: nofaktur,
          totalbayar: totalbayar,
          totalpiutang: totalpiutang
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }
      });

    });

    $("#inputgiro").click(function(e) {
      var nofaktur = $("#nofaktur").text();
      var totalbayar = $("#totalbayar").val();
      var totalpiutang = $("#totpiutang").val();

      // alert(totalbayar);
      e.preventDefault();
      $("#inputbayar").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/inputgiro',
        data: {
          nofaktur: nofaktur,
          totalbayar: totalbayar,
          totalpiutang: totalpiutang
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }
      });

    });

    $("#inputtransfer").click(function(e) {
      var nofaktur = $("#nofaktur").text();
      var totalbayar = $("#totalbayar").val();
      var totalpiutang = $("#totpiutang").val();
      var kodepel = $("#kodepel").text();
      // alert(totalbayar);
      e.preventDefault();
      $("#inputbayar").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/inputtransfer',
        data: {
          nofaktur: nofaktur,
          totalbayar: totalbayar,
          totalpiutang: totalpiutang,
          kodepel: kodepel
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }
      });

    });

    $(".editbayar").click(function(e) {
      var nofaktur = $("#nofaktur").text();
      var totalbayar = $("#totalbayar").val();
      var totalpiutang = $("#totpiutang").val();
      var nobukti = $(this).attr("data-nobukti");

      // alert(totalbayar);
      e.preventDefault();
      $("#inputbayar").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/editbayar',
        data: {
          nofaktur: nofaktur,
          totalbayar: totalbayar,
          totalpiutang: totalpiutang,
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }
      });

    });

    $(".editgiro").click(function(e) {
      var nofaktur = $("#nofaktur").text();
      var totalbayar = $("#totalbayar").val();
      var totalpiutang = $("#totpiutang").val();
      var id_giro = $(this).attr("data-id");

      // alert(totalbayar);
      e.preventDefault();
      $("#inputbayar").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/editgiro',
        data: {
          nofaktur: nofaktur,
          totalbayar: totalbayar,
          totalpiutang: totalpiutang,
          id_giro: id_giro
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }
      });

    });


    $(".edittransfer").click(function(e) {
      var nofaktur = $("#nofaktur").text();
      var totalbayar = $("#totalbayar").val();
      var totalpiutang = $("#totpiutang").val();
      var id_transfer = $(this).attr("data-id");

      // alert(totalbayar);
      e.preventDefault();
      $("#inputbayar").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/edittransfer',
        data: {
          nofaktur: nofaktur,
          totalbayar: totalbayar,
          totalpiutang: totalpiutang,
          id_transfer: id_transfer
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }
      });

    });

    $(".editgirotolak").click(function(e) {
      e.preventDefault();
      var id_giro = $(this).attr('data-id');
      var page = 'listgiro';
      $("#inputbayar").modal("show");
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/editgirotolak',
        data: {
          id_giro: id_giro,
          page: page
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }
      });
    });


    $(".edittransfertolak").click(function(e) {
      e.preventDefault();
      var id_transfer = $(this).attr('data-id');
      var page = 'listtransfer';
      $("#inputbayar").modal("show");
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/edittransfertolak',
        data: {
          id_transfer: id_transfer,
          page: page
        },
        cache: false,
        success: function(respond) {
          $(".loadformbayar").html(respond);
        }

      });
    });

    $(".hapus").click(function(e) {
      e.preventDefault();
      var href = $(this).attr("data-href");
      //alert(href);
      $("#hapusdata").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $(".delete").attr("href", href);
    });
  });
</script>