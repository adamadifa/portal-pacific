<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Edit Kontra BON
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/update_kontrabon">
    <div class="row">

      <div class="col-md-10 col-xs-12">
        <div class="row">
          <div class="col-md-5">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Data Kontra BON</h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $kb['no_kontrabon']; ?>" id="nokontrabon" name="nokontrabon" class="form-control" placeholder="No Kontra BON" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-user"></i>
                    </span>
                    <input type="hidden" value="<?php echo $kb['kode_supplier']; ?>" id="kodesupplier" name="kodesupplier" class="form-control" placeholder="Kode Supplier" data-error=".errorTxt19" />
                    <input readonly type="text" value="<?php echo $kb['nama_supplier']; ?>" id="supplier" name="supplier" class="form-control" placeholder="Supplier" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" value="<?php echo $kb['tgl_kontrabon']; ?>" id="tgl_kontrabon" name="tgl_kontrabon" class="form-control" placeholder="Tanggal Kontra Bon" data-error=".errorTxt19" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7 col-xs-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-sm">
                  <div class="card-body d-flex align-items-center">
                    <span class="bg-blue text-white stamp mr-3" style="height:9rem !important; min-width:8rem !important ">
                      <i class="fa f fa-shopping-cart" style="font-size: 4rem;"></i>
                    </span>
                    <div class="ml-3 lh-lg">
                      <div class="strong" style="font-size: 3rem;" id="grandtotal">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Detail Kontra BON</h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th>No</th>
                      <th>No Bukti</th>
                      <th>Jumlah Bayar</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $total = 0;
                    foreach ($detail as $d) {
                      $total = $total + $d->jmlbayar;

                    ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $d->nobukti_pembelian; ?></td>
                        <td align="right"><?php echo number_format($d->jmlbayar, '2', ',', '.'); ?></td>
                        <td>
                          <a href="#" data-nokontrabon="<?php echo $d->no_kontrabon; ?>" data-nobukti="<?php echo $d->nobukti_pembelian; ?>" class="btn btn-sm btn-primary edit"><i class="fa fa-pencil"></i></a>
                        </td>
                      </tr>
                    <?php $no++;
                    }  ?>
                  </tbody>
                  <tr>
                    <th colspan="2">TOTAL</th>
                    <td align="right">
                      <b id="total"> <?php echo number_format($total, '2', ',', '.'); ?></b>
                      <input type="hidden" id="grandtot" name="grandtot" value="<?php echo number_format($total, '2', ',', '.'); ?>">
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Terbilang</th>
                    <td colspan="2" align="right"><b><?php echo strtoupper(terbilang($total)); ?></b></td>
                    <td></td>
                  </tr>
                </table>
                <div class="mb-3 d-flex justify-content-end">
                  <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Update</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-2">
        <?php $this->load->view('menu/menu_keuangan_administrator'); ?>
      </div>
    </div>
  </form>
</div>
<div class="modal modal-blur fade" id="editkontrabon" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kontrabon</h5>
      </div>
      <div class="modal-body">
        <div id="loadeditkontrabon"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tgl_kontrabon'), {});
</script>
<script type="text/javascript">
  $(function() {

    function loadgrandtotal() {
      var grandtot = $("#grandtot").val();
      $("#grandtotal").text(grandtot);
    }

    loadgrandtotal();

    $('.edit').click(function(e) {
      var nokontrabon = $(this).attr('data-nokontrabon');
      var nobukti = $(this).attr('data-nobukti');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/edit_detailkb',
        data: {
          nokontrabon: nokontrabon,
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#loadeditkontrabon").html(respond);
          $("#editkontrabon").modal("show");
        }
      });

    });
  });
</script>