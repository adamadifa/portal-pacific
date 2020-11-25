<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Penyelesaian Kurang / Lebih Setor Salesman
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-5 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Penyelesaian Kurang / Lebih Setor Salesman</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="<?php echo base_url() ?>penjualan/kuranglebihsetor" autocomplete="off">
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
          <a href="#" class="btn btn-danger mb-3" id="inputkuranglebihsetor"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
          <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>Tanggal</th>
                <th>Salesman</th>
                <th>Cabang</th>
                <th>Jumlah</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (empty($result)) {
              ?>
                <tr>
                  <td colspan="5">
                    <div class="alert alert-warning" role="alert">
                      Data Tidak Ditemukan / Silahkan Pilih Periode Tanggal & Cabang Terlebih Dahulu !
                    </div>
                  </td>
                </tr>
                <?php
              } else {
                $sno  = 1;
                foreach ($result as $d) {
                  $tanggal        = explode("-", $d['tgl_kl']);
                  $tahun          = $tanggal[0];
                  $bulan          = $tanggal[1];
                  $hari           = $tanggal[2];
                  $thn            = substr($tahun, 2, 2);
                  $tgl            = $hari . "/" . $bulan . "/" . $thn;
                  if ($d['pembayaran'] == "1") {
                    $color = "bg-red";
                  } else {
                    $color = "bg-green";
                  }
                  $konten = "Uang Kertas : " . number_format($d['uang_kertas'], '0', '', '.') . " Uang Logam :" . number_format($d['uang_logam'], '0', '', '.');
                ?>
                  <tr>
                    <td><?php echo $tgl; ?></td>
                    <td><?php echo $d['nama_karyawan']; ?></td>
                    <td><?php echo $d['kode_cabang']; ?></td>
                    <td style="font-weight:bold; text-align:right"><a href="#" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="left" title="Keterangan" data-content="<?php echo $konten; ?>" class="jumlah_kl"><span class="badge <?php echo $color ?>"><?php echo number_format($d['jumlah_kl'], '0', '', '.'); ?></span></a></td>
                    <td>
                      <a href="#" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="left" title="Keterangan" data-content="<?php echo $d['keterangan']; ?>" class="btn btn-warning btn-sm keterangan"><i class="fa fa-info"></i></a>
                      <a href="#" data-kodekl="<?php echo $d['kode_kl'] ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
                      <a href="#" data-target="#konfirmasi_hapus" data-toggle="modal" data-href="<?php echo base_url(); ?>penjualan/hapus_kuranglebihsetor/<?php echo $d['kode_kl']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                    </td>
                  </tr>
              <?php $sno++;
                }
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Rekap Kurang / Lebih Setor Sales</h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>Salesman</th>
                <th>Cabang</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalsaldoakhir = 0;
              foreach ($rekap as $key => $r) {
                $cabang = @$rekap[$key + 1]->kode_cabang;
                $ceksaldo = $this->db->query("SELECT id_karyawan,jumlah,bulan,tahun FROM saldoawal_kurlebsetor_detail 
                      INNER JOIN saldoawal_kurlebsetor ON saldoawal_kurlebsetor_detail.kode_saldokurleb = saldoawal_kurlebsetor.kode_saldokurleb
                      WHERE id_karyawan = '$r->id_karyawan' ORDER BY tanggal DESC LIMIT 1");

                $ceksaldoterakhir = $ceksaldo->row_array();
                $cekst = $ceksaldo->num_rows();

                $bulan = $ceksaldoterakhir['bulan'];
                $tahun = $ceksaldoterakhir['tahun'];
                $tanggal = $tahun . "-" . $bulan . "-01";
                $setoranpenjualan = $this->db->query("SELECT SUM(lhp_tunai) as terimatunai, SUM(lhp_tagihan) as terimatagihan,SUM(setoran_kertas) as uangkertas,
                      SUM(setoran_logam) as uanglogam,SUM(setoran_bg) as giro,SUM(setoran_transfer) as transfer,SUM(girotocash) as girotocash
                      FROM setoran_penjualan
                      WHERE  tgl_lhp >= '$tanggal' AND id_karyawan='$r->id_karyawan'")->row_array();

                $ksetorpenjualan   = $this->db->query("SELECT SUM(uang_kertas) as uangkertas,SUM(uang_logam) as uanglogam
                      FROM kuranglebihsetor WHERE tgl_kl >= '$tanggal'
                      AND pembayaran='1' AND id_karyawan='$r->id_karyawan'")->row_array();
                $lsetoranpenjualan = $this->db->query("SELECT SUM(uang_kertas) as uangkertas,SUM(uang_logam) as uanglogam
                      FROM kuranglebihsetor WHERE tgl_kl >= '$tanggal'
                      AND pembayaran='2' AND id_karyawan='$r->id_karyawan'")->row_array();


                $setoranpenjkertas     = $setoranpenjualan['uangkertas'];
                $setoranpenjlogam      = $setoranpenjualan['uanglogam'];
                $setoranpenjgiro        = $setoranpenjualan['giro'];
                $setoranpenjtransfer  = $setoranpenjualan['transfer'];
                $girotocash            = $setoranpenjualan['girotocash'];

                $kurangsetor = $ksetorpenjualan['uangkertas'] +  $ksetorpenjualan['uanglogam'];
                $lebihsetor = $lsetoranpenjualan['uangkertas'] + $lsetoranpenjualan['uanglogam'];

                $totalsetoran = $setoranpenjkertas + $setoranpenjlogam + $setoranpenjgiro + $setoranpenjtransfer;
                $totallhp = $setoranpenjualan['terimatunai'] + $setoranpenjualan['terimatagihan'];
                $saldoakhir = $ceksaldoterakhir['jumlah'] + ($totalsetoran - $totallhp) + $kurangsetor - $lebihsetor;

                $totalsaldoakhir = $totalsaldoakhir + $saldoakhir;
              ?>
                <tr>
                  <td><?php echo $r->nama_karyawan; ?></td>
                  <td><?php echo $r->kode_cabang; ?></td>
                  <td style="text-align:right">
                    <?php if (!empty($cekst)) {
                      if (!empty($saldoakhir)) {
                        echo number_format($saldoakhir, '0', '', '.');
                      };
                    } else {
                      echo "<span class='badge bg-red'>Saldo Awal Belum diset</span>";
                    }
                    ?>
                  </td>
                </tr>
              <?php
                if ($cabang != $r->kode_cabang) {
                  echo "
                        <tr>
                          <td colspan='3'></td>
                        
                        </tr>";
                }
              }
              ?>
            </tbody>
            <tfoot>
              <td colspan="2">
                TOTAL
              </td>
              <td align="right">
                <?php
                if (!empty($totalsaldoakhir)) {
                  echo number_format($totalsaldoakhir, '0', '', '.');
                };
                ?>
              </td>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_kasbesar_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="forminputkuranglebihsetor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Kurang Lebih Setor</h5>
      </div>
      <div class="modal-body">
        <div id="loadforminput"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="formeditkuranglebihsetor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kurang Lebih Setor</h5>
      </div>
      <div class="modal-body">
        <div id="loadformedit"></div>
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

    $('.jumlah_kl').click(function(e) {

      e.preventDefault();
    });
    $('.jumlah_kl').popover();

    $("#inputkuranglebihsetor").click(function(e) {
      e.preventDefault();
      $("#forminputkuranglebihsetor").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loadforminput").load("<?php echo base_url(); ?>penjualan/inputkuranglebihsetor");
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var kodekl = $(this).attr("data-kodekl");
      //alert(kodesetoran);
      $("#formeditkuranglebihsetor").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loadformedit").load("<?php echo base_url(); ?>penjualan/editkuranglebihsetor/" + kodekl);
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
  })
</script>