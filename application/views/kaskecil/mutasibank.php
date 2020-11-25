<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Mutasi Bank
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Mutasi Bank</h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>kaskecil/mutasibank" autocomplete="off">
              <div class="mb-3 form-group">
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-icon">
                      <input type="text" id="dari" name="dari" value="<?php echo $dari; ?>" class="form-control datepicker date" placeholder="Dari" data-error=".errorTxt11">
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

                  <div class="col-md-6 mb-3">
                    <div class="input-icon">
                      <input type="text" id="sampai" value="<?php echo $sampai; ?>" name="sampai" class="form-control datepicker date" placeholder="Sampai" data-error=".errorTxt11">
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
                <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
              </div>
            </form>
            <a href="#" class="btn btn-danger mt-2" id="tambahmutasibank"> Tambah Data </a>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th style="width:40%">Keterangan</th>
                    <th>Akun</th>
                    <th>Penerimaan</th>
                    <th>Pengeluaran</th>

                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  if (empty($result)) {
                  ?>
                    <tr>
                      <td colspan="7">
                        <div class="alert alert-warning" role="alert">
                          Data Tidak Ditemukan / Silahkan Pilih Periode Terlebih Dahulu !
                        </div>
                      </td>
                    </tr>
                    <?php
                  } else {
                    //$saldo = $saldoawal['saldo_awal'];
                    $sno   = 1;
                    foreach ($result as $d) {
                      if ($d['status_dk'] == 'K') {
                        $penerimaan   = $d['jumlah'];
                        $s             = $penerimaan;
                        $pengeluaran  = "";
                      } else {
                        $penerimaan   = "";
                        $pengeluaran  = $d['jumlah'];
                        $s             = -$pengeluaran;
                      }

                      //$saldo = $saldo + $s;
                    ?>
                      <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo DateToIndo2($d['tgl_ledger']); ?></td>
                        <td><?php echo $d['keterangan']; ?></td>
                        <td><?php echo "<b>" . $d['kode_akun'] . "</b>" . " " . $d['nama_akun']; ?></td>
                        <td align="right" style="color:green"><?php if (!empty($penerimaan)) {
                                                                echo number_format($penerimaan, '2', ',', '.');
                                                              } ?></td>
                        <td align="right" style="color:red"><?php if (!empty($pengeluaran)) {
                                                              echo number_format($pengeluaran, '2', ',', '.');
                                                            } ?></td>
                        <td>
                          <a href="#" data-id="<?php echo $d['no_bukti'] ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
                          <a href="#" data-href="<?php echo base_url(); ?>kaskecil/hapus_mutasibank/<?php echo $d['no_bukti']; ?>" class="hapus btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                  <?php
                      $sno++;
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_keuangan_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="mutasibank" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Mutasi Bank</h5>
      </div>
      <div class="modal-body">
        <div id="loadformmutasibank"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="editmutasibank" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Mutasi Bank</h5>
      </div>
      <div class="modal-body">
        <div id="loadeditmutasibank"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('dari'), {});
  flatpickr(document.getElementById('sampai'), {});
</script>
<script type="text/javascript">
  $(function() {

    $("#tambahmutasibank").click(function() {
      $("#mutasibank").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/inputmutasibank',
        cache: false,
        success: function(respond) {
          $('#loadformmutasibank').html(respond);
        }
      });
    });
    $(".hapus").click(function() {
      var getLink = $(this).attr('data-href');
      swal({
        title: 'Alert',
        text: 'Hapus Data ?',
        html: true,
        confirmButtonColor: '#d43737',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      var id = $(this).attr("data-id");
      $("#editmutasibank").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/editmutasibank',
        data: {
          id: id
        },
        cache: false,
        success: function(respond) {
          //console.log(respond);
          $('#loadeditmutasibank').html(respond);
        }
      });
    });
  });
</script>