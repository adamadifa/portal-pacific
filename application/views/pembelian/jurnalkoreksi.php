<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Jurnal Koreksi
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
            <h4 class="card-title">Jurnal Koreksi </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>pembelian/jurnalkoreksi" autocomplete="off">
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
                <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-gear mr-2"></i>Set Periode</button>
              </div>
            </form>
            <a href="#" class="btn btn-danger mt-3" id="tambahjurnal"> Tambah Data </a>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="mytable" style="font-size:12px !important; ">
                <thead class="thead-dark">
                  <tr>
                    <th width="10px">No</th>
                    <th>TGL</th>
                    <th>No Bukti</th>
                    <th>Supplier</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th>Akun</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $totalkredit = 0;
                  $totaldebet  = 0;
                  foreach ($jurnalkoreksi as $j) {
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $j->tgl_jurnalkoreksi; ?></td>
                      <td><?php echo $j->nobukti_pembelian; ?></td>
                      <td><?php echo $j->nama_supplier; ?></td>
                      <td><?php echo $j->nama_barang; ?></td>
                      <td><?php echo $j->keterangan; ?></td>
                      <td><?php echo $j->kode_akun; ?></td>
                      <td align="right"><?php echo $j->qty; ?></td>
                      <td align="right"><?php echo  number_format($j->harga, '2', ',', '.'); ?></td>
                      <td align="right"><?php echo  number_format($j->harga * $j->qty, '2', ',', '.'); ?></td>
                      <td align="right">
                        <?php
                        if ($j->status_dk == 'D') {
                          echo  number_format($j->harga * $j->qty, '2', ',', '.');
                        }
                        ?>
                      </td>
                      <td align="right">
                        <?php
                        if ($j->status_dk == 'K') {
                          echo  number_format($j->harga * $j->qty, '2', ',', '.');
                        }
                        ?>
                      </td>
                      <td>
                        <a href="#" data-href="<?php echo base_url(); ?>pembelian/hapusjurnalkoreksi/<?php echo $j->kode_jk; ?>" class="btn btn-sm btn-danger hapus"><i class="fa fa-trash-o"></i></a>
                      </td>
                    </tr>

                  <?php
                    $no++;
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
      <?php $this->load->view('menu/menu_pembelian_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="jurnalkoreksi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Jurnal Koreksi</h5>
      </div>
      <div class="modal-body">
        <div id="loadinputjurnalkoreksi"></div>
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
<script type="text/javascript">
  $(function() {
    $("#tambahjurnal").click(function() {
      var dari = $("#dari").val();
      var sampai = $("#sampai").val();
      if (dari != "" && sampai != "") {
        $("#jurnalkoreksi").modal("show");
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>pembelian/inputjurnalkoreksi',
          cache: false,
          success: function(respond) {
            $('#loadinputjurnalkoreksi').html(respond);
          }
        });
      } else {
        swal("Oops!", "Periode Harus Diisi Terlebih Dahulu !", "warning");
      }

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
  });
</script>