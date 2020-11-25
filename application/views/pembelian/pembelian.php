<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA PEMBELIAN
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
            <h4 class="card-title">DATA PEMBELIAN </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>pembelian" autocomplete="off">
              <div class="form-group mb-3">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <i class="fa fa-barcode"></i>
                  </span>
                  <input type="text" value="<?php echo $nobukti; ?>" id="nobukti" name="nobukti" class="form-control" placeholder="No Bukti Pembelian" data-error=".errorTxt19" />
                </div>
              </div>
              <div class="form-group mb-3">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <i class="fa fa-calendar-o"></i>
                  </span>
                  <input type="text" value="<?php echo $tgl_pembelian; ?>" id="tgl_pembelian" name="tgl_pembelian" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
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
              <div class="form-group mb-3">
                <select class="form-select show-tick" id="supplier" name="supplier" data-error=".errorTxt1" data-live-search="true">
                  <option value="">--Semua Supplier--</option>
                  <?php foreach ($supp as $d) { ?>
                    <option <?php if ($supplier == $d->kode_supplier) {
                              echo "selected";
                            } ?> value="<?php echo $d->kode_supplier; ?>"><?php echo $d->nama_supplier; ?></option>
                  <?php }  ?>
                </select>
              </div>
              <div class="form-group mb-3">
                <select class="form-select show-tick" id="ppn" name="ppn" data-error=".errorTxt1">
                  <option value="">--PPN / Non PPN--</option>
                  <option <?php if ($ppn == '1') {
                            echo "selected";
                          } ?> value="1">PPN</option>
                  <option <?php if ($ppn == '0') {
                            echo "selected";
                          } ?> value="0">Non PPN</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <select class="form-select show-tick" id="tunaikredit" name="tunaikredit" data-error=".errorTxt1">
                  <option value="">--Tunai / Kredit--</option>
                  <option <?php if ($tunaikredit == 'tunai') {
                            echo "selected";
                          } ?> value="tunai">Tunai</option>
                  <option <?php if ($tunaikredit == 'kredit') {
                            echo "selected";
                          } ?> value="kredit">Kredit</option>
                </select>
              </div>
              <div class="mb-3 d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
              </div>
            </form>
            <hr>
            <a href="<?php echo base_url(); ?>pembelian/inputpembelian" class="btn btn-danger mb-3">Tambah Data</a>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="font-size:12px" id="mytable">
                <thead class="thead-dark">
                  <tr>
                    <th>No</th>
                    <th>No Bukti</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Dept</th>
                    <th>PPn</th>
                    <th>Sub Total</th>
                    <th>Peny JK</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Ket</th>
                    <?php
                    if ($this->session->userdata('level_user') == 'Administrator' || $this->session->userdata('level_user') == 'admin pembelian 2' || $this->session->userdata('level_user') == 'admin pajak' || $this->session->userdata('level_user') == 'admin pembelian') {
                    ?>
                      <th>Fak. Pajak</th>
                    <?php } ?>
                    <th>JT</th>
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
                      <td><?php echo DateToIndo2($d['tgl_pembelian']); ?></td>
                      <td style="width:10%"><?php echo $d['nama_supplier']; ?></td>
                      <td><?php echo $d['kode_dept']; ?></td>
                      <td>
                        <?php
                        if (!empty($d['ppn'])) {
                          echo '<i class="fa fa-check"></i>';
                        }
                        ?>
                      </td>
                      <td align="Right"><?php echo number_format($d['harga'], '2', ',', '.'); ?></td>
                      <td align="Right"><?php echo number_format($d['penyesuaian'], '2', ',', '.'); ?></td>
                      <td align="Right"><?php echo number_format($d['harga'] + $d['penyesuaian'], '2', ',', '.'); ?></td>
                      <td align="Right"><?php echo number_format($d['jmlbayar'], '2', ',', '.'); ?></td>
                      <td>
                        <?php
                        $totalharga = $d['harga'] + $d['penyesuaian'];
                        //echo $totalharga."-".$d['jmlbayar'];
                        if ($totalharga == $d['jmlbayar']) {
                          echo "<span class='badge bg-green' style='font-size:12px'>Lunas</span>";
                        } else {
                          echo "<span class='badge bg-red' style='font-size:10px !important'>Belum Lunas</span>";
                        }
                        ?>
                      </td>
                      <?php
                      if ($this->session->userdata('level_user') == 'Administrator' || $this->session->userdata('level_user') == 'admin pembelian' || $this->session->userdata('level_user') == 'admin pembelian 2' || $this->session->userdata('level_user') == 'admin pajak') {
                      ?>
                        <td>
                          <?php
                          if (!empty($d['ppn']) && empty($d['no_fak_pajak'])) {
                          ?>
                            <a href="#" data-nobukti="<?php echo $d['nobukti_pembelian']; ?>" data-nopajak="<?php echo $d['no_fak_pajak']; ?>" class="btn btn-sm btn-warning inputnopajak"><i class="fa fa-pencil"></i></a>
                          <?php
                          } else if (!empty($d['ppn']) && !empty($d['no_fak_pajak'])) {
                          ?>
                            <a href="#" data-nobukti="<?php echo $d['nobukti_pembelian']; ?>" data-nopajak="<?php echo $d['no_fak_pajak']; ?>" class="btn btn-sm btn-success inputnopajak"><?php echo $d['no_fak_pajak']; ?></a>
                          <?php
                          }
                          ?>
                        </td>
                      <?php } ?>
                      <td><?php echo strtoupper($d['jenistransaksi']); ?></td>
                      <td>

                        <a href="#" data-nobukti="<?php echo $d['nobukti_pembelian']; ?>" class="btn btn-sm btn-primary detail"><i class="fa fa-list"></i></a>
                        <?php
                        if ($this->session->userdata('level_user') == 'Administrator' || $this->session->userdata('level_user') == 'admin pembelian' || $this->session->userdata('level_user') == 'admin pembelian 2') {
                        ?>
                          <a href="<?php echo base_url(); ?>pembelian/cetakbppb/<?php echo $nobukti; ?>" class="btn btn-sm btn-primary"><i class="fa fa-print"></i></a>

                          <a href="<?php echo base_url(); ?>pembelian/editpembelian/<?php echo $nobukti; ?>" class="btn btn-sm btn-info editpembelian"><i class="fa fa-pencil"></i></a>

                          <?php
                          if ($totalharga == "0,00") {
                          ?>
                            <a href="#" data-href="<?php echo base_url(); ?>pembelian/hapuspembelian/<?php echo $nobukti; ?>/<?php echo $d['ref_tunai']; ?>" class="btn btn-sm btn-danger hapus">Hapus</a>
                            <?php
                          } else {
                            if ($d['jenistransaksi'] == 'tunai' and $totalharga != $d['jmlbayar']) {
                            ?>
                              <a href="#" data-href="<?php echo base_url(); ?>pembelian/hapuspembelian/<?php echo $nobukti; ?>/<?php echo $d['ref_tunai']; ?>" class="btn btn-sm btn-danger hapus"><i class="fa fa-trash-o"></i></a>
                              <?php
                            } else {
                              if (empty($d['kontrabon']) and $totalharga != $d['jmlbayar']) {
                              ?>
                                <!-- <a href="<?php echo base_url(); ?>pembelian/editpembelian/<?php echo $nobukti; ?>" class="btn btn-xs bg-teal editpembelian">Update</a> -->
                                <a href="#" data-href="<?php echo base_url(); ?>pembelian/hapuspembelian/<?php echo $nobukti; ?>/<?php echo $d['ref_tunai']; ?>" class="btn btn-sm btn-danger hapus"><i class="fa fa-trash-o"></i></a>

                        <?php
                              }
                            }
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
<div class="modal modal-blur fade" id="inputpajak" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Faktur Pajak</h5>
      </div>
      <div class="modal-body">
        <div id="loadinputfakturpajak"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tgl_pembelian'), {});
</script>
<script type="text/javascript">
  $(function() {
    $('#supplier').selectize({});
    $('.detail').click(function(e) {
      e.preventDefault();
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

    $(".inputnopajak").click(function(e) {
      var nobukti = $(this).attr('data-nobukti');
      var nopajak = $(this).attr('data-nopajak');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/inputnopajak',
        data: {
          nobukti: nobukti,
          nopajak: nopajak
        },
        cache: false,
        success: function(respond) {
          $("#inputpajak").modal("show");
          $("#loadinputfakturpajak").html(respond);
        }
      });
    });
  });
</script>