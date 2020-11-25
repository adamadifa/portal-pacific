<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Pelanggan
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Pelanggan</h4>
        </div>
        <div class="card-body">

          <form method="POST" action="<?php echo base_url(); ?>pelanggan/view_pelanggan" autocomplete="off" class="mb-4">
            <?php if ($sess_cab == 'pusat') { ?>
              <div class="mb-3">
                <select name="cabang" id="cabang" class="form-select">
                  <option value="">-- Semua Cabang --</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option <?php if ($cbg == $c->kode_cabang) {
                              echo "selected";
                            } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else { ?>
              <input name="cabang" id="cabang" type="hidden" value="<?php echo $sess_cab; ?>" />
            <?php } ?>
            <div class="mb-3">
              <select name="salesman" id="salesman" class="form-select">
                <option value="">-- Semua Salesman --</option>
              </select>
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" value="<?php echo $kodepel; ?>" name="kodepel" placeholder="Kode Pelanggan">
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" value="<?php echo $namapel; ?>" name="namapel" placeholder="Nama Pelanggan">
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
            <div class="mb-3 d-flex justify-content-end">
              <button type="submit" name="submit" class="btn btn-primary mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
              <button type="submit" name="export" class="btn btn-success" value="2"><i class="fa fa-download mr-2"></i> EXPORT EXCEL</button>
            </div>
          </form>
          <a href="#" class="btn btn-danger mb-2" id="tambahpel"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>

          <p>
            Jumlah Data : <b><?php echo $allcount; ?></b> <br>
          </p>


          <div class="table-responsive">
            <table class="table  table-striped table-hover" id="">
              <thead class="thead-dark">
                <tr>
                  <th width="10px">No</th>
                  <th>Kode Pelanggan</th>
                  <th>Nama Pelanggan</th>
                  <th>HP</th>
                  <th>Pasar</th>
                  <th>Jatuh Tempo</th>
                  <th>Limit</th>
                  <th>Cabang</th>
                  <th>Salesman</th>
                  <th>Foto</th>
                  <th>Koordinat</th>
                  <th>Tanggal Input</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sno  = $row + 1;
                foreach ($result as $d) {
                ?>
                  <tr>
                    <td><?php echo $sno; ?></td>
                    <td><?php echo $d['kode_pelanggan']; ?></td>
                    <td><?php echo $d['nama_pelanggan']; ?></td>
                    <td><?php echo $d['no_hp']; ?></td>
                    <td><?php echo $d['pasar']; ?></td>
                    <td align="right">
                      <?php
                      if ($d['jatuhtempo'] == 14) {
                        $lama = "14 Hari";
                      } else if ($d['jatuhtempo'] == 30) {
                        $lama = "30 Hari";
                      } else if ($d['jatuhtempo'] == 45) {
                        $lama = "45 Hari";
                      } else if ($d['jatuhtempo'] == 60) {
                        $lama = "2 Bulan";
                      } else if ($d['jatuhtempo'] == 90) {
                        $lama = "3 Bulan";
                      } else if ($d['jatuhtempo'] == "180") {
                        $lama = "6 Bulan";
                      } else if ($d['jatuhtempo'] == 360) {
                        $lama = "1 Tahun";
                      } else {
                        $lama = "";
                      }
                      echo $lama;
                      ?>
                    </td>
                    <td><?php echo number_format($d['limitpel'],'0','','.'); ?></td>
                    <td><?php echo $d['nama_cabang']; ?></td>
                    <td><?php echo $d['nama_karyawan']; ?></td>
                    <td>
                      <?php
                      if (!empty($d['foto'])) {
                        $foto = $d['foto'];
                      } else {
                        $foto = "default.jpg";
                      }
                      //echo $d['foto'];
                      ?>
                      <img src="<?php echo base_url(); ?>upload/toko/<?php echo $foto; ?>" width="50px" height="50px" alt="">
                    </td>
                    <td><?php echo $d['longitude']; ?></td>
                    <td><?php echo $d['time_stamps']; ?></td>
                    <td>
                      <a href="<?php echo base_url(); ?>pelanggan/edit_pelanggan/<?php echo $d['kode_pelanggan'] ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                    </td>
                  </tr>
                <?php
                  $sno++;
                }
                ?>
              </tbody>
            </table>
          </div>
          <div style='margin-top: 10px;'>
            <?php echo $pagination; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-xs-12">
      <?php $this->load->view('menu/menu_masterpenjualan'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="inputpelanggan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Data Pelanggan</h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
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
  $(document).ready(function() {



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
    loadSalesman();
    $("#cabang").change(function() {
      loadSalesman();
    });

    $("#tambahpel").click(function() {
      $("#inputpelanggan").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $(".modal-body").load("<?php echo base_url(); ?>pelanggan/input_pelanggan");
    });
  });
</script>