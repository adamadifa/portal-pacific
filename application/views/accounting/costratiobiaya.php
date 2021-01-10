<?php

function uang($nilai)
{
  return number_format($nilai, '0', '', '.');
}

?>
<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Cost Ratio Biaya
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Cost Ratio Biaya</h4>
        </div>
        <div class="card-body">

          <form method="POST" action="<?php echo base_url() ?>accounting/costratiobiaya" autocomplete="off">
            <?php if ($cb == 'pusat') { ?>
              <div class="mb-3">
                <select name="cabang" id="cabang" class="form-select">
                  <option value="">-- Semua Cabang --</option>
                  <?php foreach ($cabang as $c) { ?>
                    <option value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } else { ?>
              <input type="hidden" name="cabang" id="cabang" value="<?php echo $cb; ?>">
            <?php } ?>
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
                        <line x1="12" y1="15" x2="12" y2="18" />
                      </svg>
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
                        <line x1="12" y1="15" x2="12" y2="18" />
                      </svg>
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
          <?php
          $level = $this->session->userdata('level_user');
          if ($level == "Administrator" || $level == "manager accounting" || $level == "spv accounting") {
          ?>
            <div class="d-flex justify-content-between">
              <div>
                <a href="#" class="btn btn-danger mb-3" id="inputcostratiobiaya"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
              </div>
            </div>
          <?php } ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <th>No</th>
                <th>Tgl Transaksi</th>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Sumber</th>
                <th>Cabang</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <?php
                if (empty($jmldata)) {
                ?>
                  <tr>
                    <td colspan="9">
                      <div class="alert alert-warning" role="alert">
                        Silahkan Pilih Periode Tanggal & Cabang Terlebih Dahulu !
                      </div>
                    </td>
                  </tr>
                  <?php
                } else {
                  $no = 1;
                  foreach ($result as $key => $d) {

                    $sumber = $d['id_sumber_costratio'];
                    if ($sumber == 1) {
                      $color = "#bbf5e0";
                    } else if ($sumber == 2) {
                      $color = "#a1e9ef";
                    } else {
                      $color = "";
                    }
                  ?>
                    <tr style="background-color:<?php echo $color; ?>">
                      <td><?php echo $no; ?></td>
                      <td><?php echo DateToIndo2($d['tgl_transaksi']); ?></td>
                      <td><?php echo $d['kode_akun'] ?></td>
                      <td><?php echo $d['nama_akun'] ?></td>
                      <td><?php echo $d['keterangan'] ?></td>
                      <td align="right"><?php echo uang($d['jumlah']) ?></td>
                      <td><?php echo $d['nama_sumber'] ?></td>
                      <td><?php echo $d['kode_cabang'] ?></td>
                      <td>
                        <?php if ($sumber == 1 or $sumber == 2) {
                        } else { ?>
                          <a href="#" data-kodecr="<?php echo $d['kode_cr']; ?>" class="btn btn-sm btn-primary editcostratio"><i class="fa fa-pencil"></i></a>
                          <a href="#" data-href="<?php echo base_url(); ?>accounting/hapuscostratiobiaya/<?php echo $d['kode_cr']; ?>" class="btn btn-sm btn-danger hapus"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                      </td>
                    </tr>
                <?php
                    $no++;
                  }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_accounting_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="inputcostratio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Cost Ratio</h5>
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

<div class="modal modal-blur fade" id="edit-costratio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Cost Ratio</h5>
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

    $("#inputcostratiobiaya").click(function(e) {
      e.preventDefault();
      $("#inputcostratio").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#content").load("<?php echo base_url(); ?>accounting/costratiobiayainput");
    });

    $(".editcostratio").click(function(e) {
      e.preventDefault();
      var kodecr = $(this).attr("data-kodecr");
      //alert(kodesetoran);
      $("#edit-costratio").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loadeditform").load("<?php echo base_url(); ?>accounting/costratiobiayaedit/" + kodecr);
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