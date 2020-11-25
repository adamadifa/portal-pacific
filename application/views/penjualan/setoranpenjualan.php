<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Setoran Penjualan
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Setoran Penjualan</h4>
        </div>
        <div class="card-body">

          <form method="POST" action="<?php echo base_url() ?>penjualan/setoranpenjualan" autocomplete="off">
            <?php if ($sess_cab == 'pusat') { ?>
              <div class="mb-3">
                <select name="cabang" id="cabang" class="form-select">
                  <option value="">-- Pilih Cabang --</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option <?php if ($cbg == $c->kode_cabang) {
                              echo "selected";
                            } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else { ?>
              <input type="hidden" name="cabang" id="cabang" value="<?php echo $sess_cab; ?>">
            <?php } ?>
            <div class="mb-3">
              <select name="salesman" id="salesman" class="form-select">
                <option value="">-- Semua Salesman --</option>
              </select>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-icon">
                    <input id="dari" type="date" value="<?php echo $dari; ?>" placeholder="Dari" class="form-control" name="dari" />
                    <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <rect x="4" y="5" width="16" height="16" rx="2" />
                        <line x1="16" y1="3" x2="16" y2="7" />
                        <line x1="8" y1="3" x2="8" y2="7" />
                        <line x1="4" y1="11" x2="20" y2="11" />
                        <line x1="11" y1="15" x2="12" y2="15" />
                        <line x1="12" y1="15" x2="12" y2="18" /></svg>
                    </span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-icon">
                    <input id="sampai" type="date" value="<?php echo $sampai; ?>" placeholder="Sampai" class="form-control" name="sampai" />
                    <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <rect x="4" y="5" width="16" height="16" rx="2" />
                        <line x1="16" y1="3" x2="16" y2="7" />
                        <line x1="8" y1="3" x2="8" y2="7" />
                        <line x1="4" y1="11" x2="20" y2="11" />
                        <line x1="11" y1="15" x2="12" y2="15" />
                        <line x1="12" y1="15" x2="12" y2="18" /></svg>
                    </span>
                  </div>
                </div>
              </div>

            </div>
            <div class="mb-3">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <hr>
          <div class="d-flex justify-content-between">
            <div>
                <a href="#" class="btn btn-danger mb-3" id="inputsetoranpenjualan"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
            </div>
            <div>
              <?php
              if (empty($cbg)) {
                $cabang = "-";
              } else {
                $cabang = $cbg;
              }

              if (empty($salesman)) {
                $sales = "-";
              } else {
                $sales = $salesman;
              }

              if (empty($dari)) {
                $dr = "-";
              } else {
                $dr = $dari;
              }

              if (empty($sampai)) {
                $sm = "-";
              } else {
                $sm = $sampai;
              }
              $url = base_url() . "laporanpenjualan/cetak_setoranpenjualan/" . $cabang . "/" . $sales . "/" . $dr . "/" . $sm;
              ?>
              <a href="<?php echo $url . "/cetak"; ?>" target="_blank" class="btn btn-primary mr-2" id="cetak_setoranpenjualan"><i class="fa fa-print"></i></a>
              <a href="<?php echo $url . "/download"; ?>" class="btn btn-success" id="download_setoranpenjualan"><i class="fa fa-download"></i></a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th rowspan="2" style="text-align:center; vertical-align:middle; background-color:#293846; color:white">Tgl LHP</th>
                  <th rowspan="2" style="text-align:center; vertical-align:middle; background-color:#293846; color:white">Sales</th>
                  <th colspan="2" style="text-align:center; vertical-align:middle; background-color:#1ab394; color:white">Penjualan</th>
                  <th rowspan="2" style="text-align:center; vertical-align:middle; background-color:#1ab394; color:white">Total LHP</th>
                  <th colspan="4" style="text-align:center; vertical-align:middle; background-color:#f8ac59; color:white">Setoran</th>
                  <th rowspan="2" style="text-align:center; vertical-align:middle; background-color:#f8ac59; color:white">Total Setoran</th>
                  <th rowspan="2" style="text-align:center; vertical-align:middle; background-color:#293846; color:white">Aksi</th>
                </tr>
                <tr>
                  <th style="text-align:center; vertical-align:middle; background-color:#1ab394; color:white">Tunai</th>
                  <th style="text-align:center; vertical-align:middle; background-color:#1ab394; color:white">Tagihan</th>
                  <th style="text-align:center; vertical-align:middle; background-color:#f8ac59; color:white">U.Kertas</th>
                  <th style="text-align:center; vertical-align:middle; background-color:#f8ac59; color:white">U.Logam</th>
                  <th style="text-align:center; vertical-align:middle; background-color:#f8ac59; color:white">BG/CEK</th>
                  <th style="text-align:center; vertical-align:middle; background-color:#f8ac59; color:white">TRANSFER</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($jmldata)) {
                ?>
                  <tr>
                    <td colspan="11">
                      <div class="alert alert-warning" role="alert">
                        Silahkan Pilih Periode Tanggal & Cabang Terlebih Dahulu !
                      </div>
                    </td>
                  </tr>
                  <?php
                } else {
                  $totaltunai = 0;
                  $totaltagihan = 0;
                  $totallhppertgl = 0;
                  $totalsetorankertas = 0;
                  $totalsetoranlogam = 0;
                  $totalsetoranbg = 0;
                  $totalsetorantransfer = 0;
                  $totalsetoranpertgl = 0;


                  foreach ($result as $key => $d) {
                    $totaltunai = $totaltunai + $d['lhp_tunai'];
                    $totaltagihan = $totaltagihan + $d['lhp_tagihan'];

                    $tglcek  = @$result[$key + 1]['tgl_lhp'];
                    $tanggal           = explode("-", $d['tgl_lhp']);
                    $tahun             = $tanggal[0];
                    $bulan             = $tanggal[1];
                    $hari              = $tanggal[2];
                    $thn               = substr($tahun, 2, 2);
                    $tgl               = $hari . "/" . $bulan . "/" . $thn;
                    $ceksetorantunai   = $d['cektunai'];
                    $setorantagihan    = $d['cekkredit'];
                    $setorangiro       = $d['ceksetorangiro'];
                    $setorantransfer   = $d['ceksetorantransfer'];
                    $setoranalltagihan = $d['cekkredit'] + $d['ceksetorangiro'] + $d['ceksetorantransfer'];

                    $girotocash        = $d['cekgirotocash'];
                    //Penyelesaian Kurang lebih Setor
                    $uk = $d['kurangsetorkertas'] - $d['lebihsetorkertas'];
                    $ul = $d['kurangsetorlogam'] - $d['lebihsetorlogam'];
                    $totallhp = $d['lhp_tunai'] + $d['lhp_tagihan'];
                    if ($uk > 0) {
                      $opkertas = "+";
                    } else {
                      $opkertas = "";
                    }

                    if ($ul > 0) {
                      $oplogam = "+";
                    } else {
                      $oplogam = "";
                    }



                    $totalsetoran   = $d['setoran_kertas'] + $uk + $d['setoran_logam'] + $ul + $d['setoran_bg'] + $d['setoran_transfer'];
                    $selisih        = $totalsetoran - $totallhp;
                    $kontenkertas   = number_format($d['setoran_kertas'], '0', '', '.') . $opkertas . number_format($uk, '0', '', '.');
                    $kontenlogam    = number_format($d['setoran_logam'], '0', '', '.') . $oplogam . number_format($ul, '0', '', '.');


                    if ($d['cektunai'] == $d['lhp_tunai']) {
                      $colorsetorantunai = "background-color:#1ab394; color:white";
                    } else {
                      $colorsetorantunai =  "background-color:#dc3545; color:white";
                    }

                    if ($setoranalltagihan == $d['lhp_tagihan']) {
                      $colorsetorantagihan = "background-color:#1ab394; color:white";
                    } else {
                      $colorsetorantagihan =  "background-color:#dc3545; color:white";
                    }

                    if ($d['cektunai'] == $d['lhp_tunai'] && $setoranalltagihan == $d['lhp_tagihan'] && $girotocash == $d['girotocash']) {
                      $colortotallhp = "background-color:#1ab394; color:white !important";
                    } else {
                      $colortotallhp = "background-color:#dc3545; color:white !important";
                    }

                    $totallhppertgl = $totallhppertgl + $totallhp;
                    $totalsetorankertas = $totalsetorankertas + ($d['setoran_kertas'] + $uk);
                    $totalsetoranlogam = $totalsetoranlogam + ($d['setoran_logam'] + $ul);
                    $totalsetoranbg = $totalsetoranbg + $d['setoran_bg'];
                    $totalsetorantransfer = $totalsetorantransfer + $d['setoran_transfer'];
                    $totalsetoranpertgl = $totalsetoranpertgl + $totalsetoran;

                  ?>
                    <tr>
                      <td><?php echo $tgl; ?></td>
                      <td><?php echo $d['nama_karyawan']; ?></td>
                      <td style="<?php echo $colorsetorantunai; ?>" align="right"><?php echo number_format($d['lhp_tunai'], '0', '', '.'); ?></td>
                      <td style="<?php echo $colorsetorantagihan; ?>" align="right"><?php echo number_format($d['lhp_tagihan'], '0', '', '.'); ?></td>
                      <td style="<?php echo $colortotallhp; ?>" align="right"><a style="color:black !important;" href="<?php echo base_url(); ?>laporanpenjualan/cekkasbesar/<?php echo $d['kode_cabang'] . "/" . $d['tgl_lhp'] . "/" . $d['id_karyawan'] ?>" target="_blank"><b><?php echo number_format($totallhp, '0', '', '.'); ?></b></a></td>
                      <td align="right"><a href="#" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="left" title="Keterangan" data-content="<?php echo $kontenkertas; ?>" class="detailkertas"><?php echo number_format($d['setoran_kertas'] + $uk, '0', '', '.'); ?></a></td>
                      <td align="right"><a href="#" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="left" title="Keterangan" data-content="<?php echo $kontenlogam; ?>" class="detaillogam"><?php echo number_format($d['setoran_logam'] + $ul, '0', '', '.'); ?></a></td>
                      <td align="right"><?php echo number_format($d['setoran_bg'], '0', '', '.'); ?></td>
                      <td align="right"><?php echo number_format($d['setoran_transfer'], '0', '', '.'); ?></td>
                      <td align="right"><b><?php echo number_format($totalsetoran, '0', '', '.'); ?></b></td>
                      <td>
                        <a href="#" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="left" title="Keterangan" data-content="<?php echo $d['keterangan']; ?>" class="btn btn-info btn-sm keterangan"><i class="fa fa-info"></i></a>
                        <a href="<?php echo base_url(); ?>penjualan/synclhp/<?php echo $d['kode_setoran']; ?>" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i></a>
                        <a href="#" data-kodesetoran="<?php echo $d['kode_setoran'] ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
                        <a href="#" data-href="<?php echo base_url(); ?>penjualan/hapus_setoran/<?php echo $d['kode_setoran']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                      </td>
                    </tr>
                <?php

                    if ($tglcek != $d['tgl_lhp']) {

                      echo "<tr style='color:black; font-weight:bold'>
                    <th colspan='2'>TOTAL</th>
                    <th style='text-align:right'>" . number_format($totaltunai, '0', '', '.') . "</th>
                    <th style='text-align:right'>" . number_format($totaltagihan, '0', '', '.') . "</th>
                    <th style='text-align:right'>" . number_format($totallhppertgl, '0', '', '.') . "</th>
                    <th style='text-align:right'>" . number_format($totalsetorankertas, '0', '', '.') . "</th>
                    <th style='text-align:right'>" . number_format($totalsetoranlogam, '0', '', '.') . "</th>
                    <th style='text-align:right'>" . number_format($totalsetoranbg, '0', '', '.') . "</th>
                    <th style='text-align:right'>" . number_format($totalsetorantransfer, '0', '', '.') . "</th>
                    <th style='text-align:right'>" . number_format($totalsetoranpertgl, '0', '', '.') . "</th>
                    <th></th>
                    </tr>";

                      $totaltunai = 0;
                      $totaltagihan = 0;
                      $totallhppertgl = 0;
                      $totalsetorankertas = 0;
                      $totalsetoranlogam = 0;
                      $totalsetoranbg = 0;
                      $totalsetorantransfer = 0;
                      $totalsetoranpertgl = 0;
                    }
                  }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_kasbesar_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="kasbesar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Setoran</h5>
      </div>
      <div class="modal-body">
        <div id="content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="editkasbesar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Setoran</h5>
      </div>
      <div class="modal-body">
        <div id="loadeditform"></div>
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
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('dari'), {});
    flatpickr(document.getElementById('sampai'), {});
  });
</script>

<script>
  $(function() {
    function loadSalesman() {
      var cabang = $("#cabang").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/get_salesman',
        data: {
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $('#salesman').selectize()[0].selectize.destroy();
          $("#salesman").html(respond);
          $('#salesman').selectize({});

        }
      });
    }
    //$('[data-toggle="popover"]').popover();
    loadSalesman();
    $("#cabang").change(function() {
      loadSalesman();
    });
    $('.keterangan').click(function(e) {
      e.preventDefault();
    });
    $('.keterangan').popover();

    $('.detailkertas').click(function(e) {
      e.preventDefault();
    });
    $('.detailkertas').popover();

    $('.detaillogam').click(function(e) {
      e.preventDefault();
    });
    $('.detaillogam').popover();

    $("#inputsetoranpenjualan").click(function(e) {
      e.preventDefault();
      $("#kasbesar").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#content").load("<?php echo base_url(); ?>penjualan/inputsetoranpenjualan");
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var kodesetoran = $(this).attr("data-kodesetoran");
      //alert(kodesetoran);
      $("#editkasbesar").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loadeditform").load("<?php echo base_url(); ?>penjualan/editsetoranpenjualan/" + kodesetoran);
    });

    $(".hapus").click(function() {
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