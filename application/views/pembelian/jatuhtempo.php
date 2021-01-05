<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA PEMBAYARAN JATUH TEMPO
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
            <h4 class="card-title">DATA PEMBAYARAN JATUH TEMPO </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>pembelian/jatuhtempo" autocomplete="off">
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <i class="fa fa-barcode"></i>
                </span>
                <input type="text" value="<?php echo $nobukti; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti Pembelian" data-error=".errorTxt19" />
              </div>
              <div class="form-group mb-3">
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="text" value="<?php echo $dari; ?>" id="dari" name="dari" class="datepicker form-control date" placeholder="Dari" data-error=".errorTxt19" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="text" value="<?php echo $sampai; ?>" id="sampai" name="sampai" class="datepicker form-control date" placeholder="Sampai" data-error=".errorTxt19" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3">
                <select class="form-select show-tick" id="departemen" name="departemen" data-error=".errorTxt1">
                  <option value="">--Semua Departemen--</option>
                  <?php foreach ($dept as $d) { ?>
                    <option <?php if ($departemen == $d->kode_dept) {
                              echo "selected";
                            } ?> value="<?php echo $d->kode_dept; ?>"><?php echo $d->nama_dept; ?></option>
                  <?php }  ?>
                </select>
              </div>
              <div class="mb-3 d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
              </div>
            </form>
            <hr>
            <div class="table-responsive">
              <?php echo $this->session->flashdata('msg'); ?>
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th width="10px">No</th>
                    <th>No Bukti</th>
                    <th>Jatuh Tempo</th>
                    <th>Supplier</th>
                    <th>Dept</th>
                    <th>PPn</th>
                    <th>Total</th>
                    <th>Ket</th>
                    <th>Kontrabon</th>
                    <th></th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sno  = $row + 1;
                  foreach ($result as $d) {
                    $nobukti = str_replace("/", ".", $d['nobukti_pembelian']);
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['nobukti_pembelian']; ?></td>
                      <td><?php echo DateToIndo2($d['tgl_jatuhtempo']); ?></td>
                      <td><?php echo $d['nama_supplier']; ?></td>
                      <td><?php echo $d['kode_dept']; ?></td>
                      <td>
                        <?php
                        if (!empty($d['ppn'])) {
                          echo '<i class="fa fa-check"></i>';
                        }
                        ?>
                      </td>
                      <td align="Right"><?php echo number_format($d['harga'], '0', '', '.'); ?></td>
                      <td>
                        <?php
                        $totalharga = $d['harga'];
                        //echo $totalharga."-".$d['jmlbayar'];
                        if ($totalharga == $d['jmlbayar']) {
                          echo "<span class='badge bg-green'>Lunas</span>";
                        } else {
                          echo "<span class='badge bg-red'>Belum Lunas</span>";
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if (!empty($d['kontrabon'])) {
                          echo '<span class="badge bg-green">' . $d['kontrabon'] . '</span>';
                        }
                        ?>
                      </td>
                      <td>
                        <?php if ($totalharga != $d['jmlbayar']) { ?>
                          <a href="<?php echo base_url(); ?>pembelian/addkontrabon/<?php echo $nobukti; ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
                        <?php } ?>
                      </td>
                      <td>
                        <a href="#" data-nobukti="<?php echo $d['nobukti_pembelian']; ?>" class="btn btn-sm btn-info detail">Detail</a>
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
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_pembelian_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailpembelian" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetailpembelian"></div>
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
    $('.detail').click(function(e) {
      var nobukti = $(this).attr('data-nobukti');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/detail_pembelian',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailpembelian").html(respond);
          $("#detailpembelian").modal("show");
        }
      });
    });

  });
</script>