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
          Data Penjualan Pending
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Penjualan Pending</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="<?php echo base_url(); ?>penjualan/penjualanpend" autocomplete="off" class="mb-4">
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
              <input type="hidden" name="cabang" id="cabang" value="<?php echo $sess_cab; ?>">
            <?php } ?>
            <div class="mb-3">
              <select name="salesman" id="salesman" class="form-select">
                <option value="">-- Semua Salesman --</option>
              </select>
            </div>
            <div class="mb-3">
              <select id="status" name="status" class="form-select">
                <option value="">-- Status --</option>
                <option value="">Status</option>
                <option <?php if ($status == "1") {
                          echo "selected";
                        } ?> value="1">Disetujui</option>
                <option <?php if ($status == "2") {
                          echo "selected";
                        } ?> value="2">Pending</option>
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
            <div class="mb-3 d-flex justify-content-end">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="datatable">
                <thead class="thead-dark">
                  <tr>
                    <th>No</th>
                    <th>No Faktur</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Salesman</th>
                    <th>Status</th>
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
                      <td><?php echo $d['no_fak_penj']; ?></td>
                      <td><?php echo $d['nama_pelanggan']; ?></td>
                      <td><?php echo $d['tgltransaksi']; ?></td>
                      <td align="right"><?php echo uang($d['total']); ?></td>
                      <td><?php echo $d['nama_karyawan']; ?></td>
                      <td>
                        <?php
                        if ($d['status'] == "1") {
                        ?>
                          <span class="badge bg-green"><i class="fa fa-check"></i></span>
                        <?php
                        } else {
                        ?>
                          <span class="badge bg-orange">Pending</span>
                        <?php } ?>
                      </td>
                      <td>
                        <a href="<?php echo base_url(); ?>penjualan/updatepenjualanpending/<?php echo $d['kode_pelanggan']; ?>/<?php echo $d['no_fak_penj']; ?>" class="btn btn-sm btn-success""><i class=" fa fa-refresh"></i></a>
                        <a href="#" class="btn btn-sm btn-primary detail" data-nofakpenj="<?php echo $d['no_fak_penj']; ?>"><i class="fa fa-list"></i></a>
                        <?php
                        if ($d['status'] != "1") {
                        ?>
                          <a href="#" class="btn btn-sm btn-info inputtransfer" data-nofakpenj="<?php echo $d['no_fak_penj']; ?>" data-total="<?php echo $d['total']; ?>" data-kodepel="<?php echo $d['kode_pelanggan']; ?>"><i class="fa fa-money mr-2"></i> Bayar</a>
                        <?php } ?>
                        <a href="<?php echo base_url(); ?>penjualan/hapuspenjualanpending/<?php echo $d['no_fak_penj']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                      </td>
                    </tr>
                  <?php
                    $sno++;
                  }
                  ?>
                </tbody>
              </table>
              <div style='margin-top: 10px;'>
                <?php echo $pagination; ?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailpenjualan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail Penjualan</h5>
      </div>
      <div class="modal-body">
        <div id="loadcontent"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
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
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('dari'), {});
    flatpickr(document.getElementById('sampai'), {});
  });
</script>
<script>
  $(document).ready(function() {
    //$('#cabang').selectize({});

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

    $(".detail").click(function(e) {
      e.preventDefault();
      var nofakpenj = $(this).attr("data-nofakpenj");
      $("#detailpenjualan").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>penjualan/detailpenjualanpending',
        data: {
          nofakpenj: nofakpenj
        },
        cache: false,
        success: function(respond) {
          $("#loadcontent").html(respond);
        }
      });
    });

    $(".inputtransfer").click(function(e) {
      var nofaktur = $(this).attr("data-nofakpenj");
      var totalpiutang = $(this).attr("data-total");
      var kodepel = $(this).attr("data-kodepel");
      var totalbayar = 0;
      // alert(totalbayar);
      e.preventDefault();
      $("#inputbayar").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Pembayaran/inputtransferpending',
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
  });
</script>