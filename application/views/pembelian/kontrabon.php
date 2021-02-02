<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Kontra BON
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Kontra BON</h4>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>pembelian/kontrabon" autocomplete="off">
            <div class="mb-3">
              <input type="text" value="<?php echo $nokontrabon; ?>" id="nokontrabon" name="nokontrabon" class="form-control" placeholder="No Kontra BON" data-error=".errorTxt19" />
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-12">
                  <div class="input-icon">
                    <input id="tgl_kontrabon" type="date" value="<?php echo $tgl_kontrabon; ?>" placeholder="Tanggal Kontrabon" class="form-control" name="tgl_kontrabon" />
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
              <select class="form-select show-tick" id="supplier" name="supplier" data-error=".errorTxt1" data-live-search="true">
                <option value="">--Semua Supplier--</option>
                <?php foreach ($supp as $d) { ?>
                  <option <?php if ($supplier == $d->kode_supplier) {
                            echo "selected";
                          } ?> value="<?php echo $d->kode_supplier; ?>"><?php echo $d->nama_supplier; ?></option>
                <?php }  ?>
              </select>
            </div>
            <div class="mb-3">
              <select class="form-select show-tick" id="status" name="status" data-error=".errorTxt1">
                <option value="">--Semua Status--</option>
                <option <?php if ($status == 1) {
                          echo "selected";
                        } ?> value="1">Belum Di Proses</option>
                <option <?php if ($status == 2) {
                          echo "selected";
                        } ?> value="2">Sudah Di Proses</option>
              </select>
            </div>
            <div class="mb-3">
              <select class="form-select show-tick" id="kategori" name="kategori" data-error=".errorTxt1">
                <option value="">--Semua Jenis Pengajuan--</option>
                <option <?php if ($kategori == "KB") {
                          echo "selected";
                        } ?> value="KB">Kontra BON</option>
                <option <?php if ($kategori == "IM") {
                          echo "selected";
                        } ?> value="IM">Internal Memo</option>
                <option <?php if ($kategori == "TN") {
                          echo "selected";
                        } ?> value="TN">Tunai</option>
              </select>
            </div>
            <div class="mb-3 d-flex justify-content-end">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <a href="<?php echo base_url(); ?>pembelian/inputkontrabon" class="btn btn-danger mt-3">Tambah Data</a>
          <hr>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
              <thead class="thead-dark">
                <tr>
                  <th width="10px">No</th>
                  <th>No Kontra BON</th>
                  <th>No Dok</th>
                  <th>Tanggal</th>
                  <th>Kategori</th>
                  <th>Supplier</th>
                  <th>Total Bayar</th>
                  <th>Keterangan</th>
                  <th>Jenis Bayar</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sno  = $row + 1;
                foreach ($result as $d) {
                  $nokontrabon = str_replace("/", ".", $d['no_kontrabon']);
                ?>
                  <tr>
                    <td><?php echo $sno; ?></td>
                    <td><?php echo $d['no_kontrabon']; ?></td>
                    <td><?php echo $d['no_dokumen']; ?></td>
                    <td><?php echo DateToIndo2($d['tgl_kontrabon']); ?></td>
                    <td><?php echo $d['kategori']; ?></td>
                    <td><?php echo $d['nama_supplier']; ?></td>
                    <td align="right"><?php echo number_format($d['totalbayar'], '2', ',', '.'); ?></td>
                    <td>
                      <?php
                      if (empty($d['tglbayar'])) {
                        echo "<span class='badge bg-red'>Belum Bayar</span>";
                      } else {
                        echo "<span class='badge bg-green'>" . DateToIndo2($d['tglbayar']) . "</span>";
                      }
                      ?>

                    </td>
                    <td><?php echo $d['jenisbayar']; ?></td>
                    <td>
                      <?php
                      if ($d['status'] == 1) {
                        echo "<span class='badge bg-green'>Approved</span>";
                      } else {
                        echo "<span class='badge bg-orange'>Pending</span>";
                      }
                      ?>
                    </td>
                    <td>

                      <a href="#" data-nokontrabon="<?php echo $d['no_kontrabon']; ?>" class="btn btn-sm btn-primary detail">Detail</a>
                      <?php
                      if ($this->session->userdata('level_user') == "manager pembelian") {
                        if (empty($d['tglbayar'])) {
                          if ($d['status'] == 1) {
                      ?>
                            <a href="<?php echo base_url(); ?>pembelian/batalkankontrabon/<?php echo $nokontrabon; ?>" class="btn btn-sm btn-danger">Batalkan</a>
                          <?php
                          } else {
                          ?>
                            <a href="<?php echo base_url(); ?>pembelian/approvekontrabon/<?php echo $nokontrabon; ?>" class="btn btn-sm btn-success">Approve</a>
                        <?php
                          }
                        }
                      } else {
                        ?>
                        <a href="<?php echo base_url(); ?>pembelian/cetakkontrabon/<?php echo $nokontrabon; ?>" class="btn btn-sm btn-primary">Cetak</a>
                        <?php
                        if (empty($d['tglbayar']) && $d['kategori'] != 'TN') {
                        ?>
                          <a href="<?php echo base_url(); ?>pembelian/editkontrabon/<?php echo $nokontrabon; ?>" class="btn btn-sm btn-info">Edit</a>
                          <a href="#" data-href="<?php echo base_url(); ?>pembelian/hapuskontrabon/<?php echo $nokontrabon; ?>" class="btn btn-sm btn-danger hapus">Hapus</a>
                      <?php
                        }
                      }
                      ?>

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
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_pembelian_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailkontrabon" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail Kontrabon</h5>
      </div>
      <div class="modal-body">
        <div id="loadkontrabon"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('tgl_kontrabon'), {});
  });
</script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script type="text/javascript">
  $(function() {
    $('.detail').click(function(e) {
      e.preventDefault();
      var nokontrabon = $(this).attr('data-nokontrabon');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/detail_kontrabon',
        data: {
          nokontrabon: nokontrabon
        },
        cache: false,
        success: function(respond) {
          $("#loadkontrabon").html(respond);
          $("#detailkontrabon").modal("show");
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
  });
</script>