<?php

function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}
$tahun  = date('Y');
$b      = date('m') + 0;
$bulan  = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
?>
<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Dashboard Produksi
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <?php if ($this->session->userdata('level_user') == "Administrator") { ?>
      <div class="col-md-10 col-xs-12">
      <?php } else { ?>
        <div class="col-md-12 col-xs-12">
        <?php } ?>
        <div class="row">
          <?php if ($this->session->userdata('level_user') == "Administrator") { ?>
            <div class="col-md-5 col-xs-12">
            <?php } else { ?>
              <div class="col-md-4 col-xs-12">
              <?php } ?>
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Permintaan Produksi <?php echo $bulan[$b];  ?></h4>
                </div>
                <div class="card-body">
                  <?php if ($cek != 0) { ?>

                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-hover" style="width: 100%">
                        <tr>
                          <td><b>No Permintaan</b></td>
                          <td>:</td>
                          <td><?php echo $permintaan['no_permintaan']; ?></td>
                        </tr>
                        <tr>
                          <td><b>Tanggal Permintaan</b></td>
                          <td>:</td>
                          <td><?php echo DateToIndo2($permintaan['tgl_permintaan']); ?></td>
                        </tr>
                        <tr>
                          <td><b>No Order</b></td>
                          <td>:</td>
                          <td><?php echo $permintaan['no_order']; ?></td>
                        </tr>
                        <tr>
                          <td><b>Bulan</b></td>
                          <td>:</td>
                          <td><?php echo $bulan[$permintaan['bulan']]; ?></td>
                        </tr>
                        <tr>
                          <td><b>Tahun</b></td>
                          <td>:</td>
                          <td><?php echo $permintaan['tahun']; ?></td>
                        </tr>
                      </table>
                      <table class="table table-bordered table-striped table-hover" id="mytable">
                        <thead>
                          <tr>
                            <th width="10px" style="vertical-align: middle;">No</th>
                            <th style="vertical-align: middle; text-align: center;">Produk</th>
                            <th style="text-align:center;vertical-align: middle;">Total Permintaan</th>
                            <th style="text-align:center;vertical-align: middle;">Reliasi</th>
                            <th style="text-align:center;vertical-align: middle;">%</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          foreach ($oman as $d) {
                            $permintaan = ($d->oman_mkt - $d->stok_gudang + $d->buffer_stok);
                            $realisasi = "SELECT SUM(jumlah) as jmlproduksi FROM detail_mutasi_produksi
                                      INNER JOIN mutasi_produksi 
                                      ON detail_mutasi_produksi.no_mutasi_produksi = mutasi_produksi.no_mutasi_produksi
                                      WHERE jenis_mutasi = 'BPBJ' AND kode_produk = '$d->kode_produk' AND MONTH(tgl_mutasi_produksi)='$b'
                                      AND YEAR(tgl_mutasi_produksi)='$tahun'";
                            $r          = $this->db->query($realisasi)->row_array();
                            if ($r['jmlproduksi'] != 0) {
                              $persen     = ($r['jmlproduksi'] / $permintaan) * 100;
                            } else {
                              $persen     = 0;
                            }

                            if ($persen < 50) {

                              $color = "bg-red";
                            } else if ($persen < 90) {
                              $color = "bg-orange";
                            } else {
                              $color = "bg-green";
                            }

                          ?>
                            <tr>
                              <td><?php echo $no; ?></td>
                              <td><?php echo $d->nama_barang; ?></td>
                              <td align="right"><?php echo uang($d->oman_mkt - $d->stok_gudang + $d->buffer_stok); ?></td>
                              <td align="right"><?php if ($r['jmlproduksi'] != 0) {
                                                  echo uang($r['jmlproduksi']);
                                                } ?></td>
                              <td align="right">
                                <span class="badge <?php echo $color; ?>"><?php if ($persen != 0) {
                                                                            echo uang($persen) . "%";
                                                                          } ?></span>
                              </td>
                            </tr>
                          <?php
                            $no++;
                          }
                          ?>
                        </tbody>
                      </table>

                    </div>
                  <?php } else { ?>
                    <div class="alert alert-warning alert-dismissible">
                      Data Permintaan Produksi Untuk Bulan Ini Belum Tersedia ! atau Belum Di Proses..!
                    </div>
                  <?php }  ?>
                </div>
              </div>
              </div>
              <?php if ($this->session->userdata('level_user') == "Administrator") { ?>
                <div class="col-md-7 col-xs-12">
                <?php } else { ?>
                  <div class="col-md-8 col-xs-12">
                  <?php } ?>
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Rekap Hasil Produksi</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <select class="form-select" id="tahun" name="tahun">
                          <option value="">Tahun</option>
                          <?php for ($t = 2019; $t <= $tahun; $t++) { ?>
                            <option <?php if (date("Y") == $t) {
                                      echo "selected";
                                    } ?> value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <hr>
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <thead class="thead-dark">
                            <tr>
                              <th rowspan="2" style="text-align:center">No</th>
                              <th rowspan="2" style="text-align:center">Produk</th>
                              <th colspan='12' style="text-align:center">Bulan</th>
                            </tr>
                            <tr>
                              <th style="text-align:center">Jan</th>
                              <th style="text-align:center">Feb</th>
                              <th style="text-align:center">Mar</th>
                              <th style="text-align:center">Apr</th>
                              <th style="text-align:center">Mei</th>
                              <th style="text-align:center">Jun</th>
                              <th style="text-align:center">Jul</th>
                              <th style="text-align:center">Agu</th>
                              <th style="text-align:center">Sept</th>
                              <th style="text-align:center">Okt</th>
                              <th style="text-align:center">Nov</th>
                              <th style="text-align:center">Des</th>
                            </tr>
                          </thead>
                          <tbody id="loadrekapproduksi">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Grafik Hasil Produksi</h4>
                      </div>
                      <div class="card-body">
                        <figure class="highcharts-figure">
                          <div id="loadgrafik"></div>
                        </figure>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <?php if ($this->session->userdata('level_user') == "Administrator") { ?>
              <div class="col-md-2">
                <?php $this->load->view('menu/menu_produksi_administrator'); ?>
              </div>
            <?php } ?>
        </div>
        </div>
      </div>
      <script>
        $(function() {
          function loadrekapproduksi() {
            var tahun = $("#tahun").val();
            $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>dashboard/rekapproduksi',
              data: {
                tahun: tahun
              },
              cache: false,
              success: function(respond) {
                $("#loadrekapproduksi").html(respond);
              }
            });

          }

          function loadgrafik() {
            var tahun = $("#tahun").val();
            $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>dashboard/grafikproduksi',
              data: {
                tahun: tahun
              },
              cache: false,
              success: function(respond) {
                $("#loadgrafik").html(respond);
              }
            });
          }
          $("#tahun").change(function(e) {
            e.preventDefault();
            loadrekapproduksi();
          });
          loadgrafik();
          loadrekapproduksi();
        })
      </script>