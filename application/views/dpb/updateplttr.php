<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          UPDATE DATA REKAP PELUNASAN TTR
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="col-md-7">

          <div class="card">
            <div class="card-header">
              <h4 class="card-title">UPDATE DATA REKAP PELUNASAN TTR </h4>
            </div>
            <div class="card-body">
              <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>dpb/update_plttr">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['no_mutasi_gudang_cabang'] ?>" id="no_mutasi" name="no_mutasi" class="form-control" placeholder="No Mutasi Penjualan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['no_dpb']; ?>" id="nodpb" name="nodpb" class="form-control" placeholder="No DPB" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['tgl_pengambilan']; ?>" id="tgl_pengambilan" name="tgl_pengambilan" class="form-control" placeholder="Tanggal Pengambilan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-building-o"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['kode_cabang']; ?>" id="cabang" name="cabang" class="form-control" placeholder="Cabang" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-users"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['nama_karyawan']; ?>" id="salesman" name="salesman" class="form-control" placeholder="Salesman" data-error=".errorTxt19" />
                    <input type="hidden" readonly value="<?php echo $mutasi['id_karyawan']; ?>" id="id_karyawan" name="id_karyawan" class="form-control" placeholder="ID" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-map"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['tujuan']; ?>" id="tujuan" name="tujuan" class="form-control" placeholder="Tujuan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-truck"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['no_kendaraan']; ?>" id="nokendaraan" name="nokendaraan" class="form-control" placeholder="No Kendaraan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $mutasi['tgl_mutasi_gudang_cabang']; ?>" id="tgl_gb" name="tanggal" class="form-control datepicker" placeholder="Tanggal Penjualan" data-error=".errorTxt19" />
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th rowspan="3" align="">No</th>
                      <th rowspan="3" style="text-align:center">Nama Barang</th>
                      <th colspan="6" style="text-align:center">Pelunasan TTR</th>
                    </tr>
                    <tr>
                      <th colspan="6" style="text-align:center">Kuantitas</th>
                    </tr>
                    <tr>
                      <th style="text-align:center">Jumlah</th>
                      <th style="text-align:center">Satuan</th>
                      <th style="text-align:center">Jumlah</th>
                      <th style="text-align:center">Satuan</th>
                      <th style="text-align:center">Jumlah</th>
                      <th style="text-align:center">Satuan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($barang as $b) {
                      $jml = $this->db->get_where('detail_mutasi_gudang_cabang', array('no_mutasi_gudang_cabang' => $mutasi['no_mutasi_gudang_cabang'], 'kode_produk' => $b->kode_produk))->row_array();
                      //RETUR
                      $jmldus = floor($jml['jumlah'] / $b->isipcsdus);
                      if ($jml['jumlah'] != 0) {
                        $sisadus   = $jml['jumlah'] % $b->isipcsdus;
                      } else {
                        $sisadus = 0;
                      }
                      if ($b->isipack == 0) {
                        $jmlpack    = 0;
                        $sisapack   = $sisadus;
                        $s          = "A";
                      } else {
                        $jmlpack    = floor($sisadus / $b->isipcs);
                        $sisapack   = $sisadus % $b->isipcs;
                        $s          = "B";
                      }
                      $jmlpcs = $sisapack;

                      // echo $sisadus."-".$s."-".$sisapack."-".$jmlpcs."<br>";

                    ?>
                      <tr>
                        <td style="width:10px"><?php echo $no; ?></td>
                        <td style="width:200px">
                          <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $b->kode_produk; ?>">
                          <input type="hidden" name="isipcsdus<?php echo $no; ?>" value="<?php echo $b->isipcsdus; ?>">
                          <input type="hidden" name="isipack<?php echo $no; ?>" value="<?php echo $b->isipack; ?>">
                          <input type="hidden" name="isipcs<?php echo $no; ?>" value="<?php echo $b->isipcs; ?>">
                          <?php echo $b->nama_barang; ?>
                        </td>
                        <td style="width:100px">
                          <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                            <div class="form-line">
                              <input type="text" style="text-align:right" value="<?php if (!empty($jmldus)) {
                                                                                    echo $jmldus;
                                                                                  } ?>" id="jmldus" name="jmldus<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                            </div>
                          </div>
                        </td>
                        <td style="width:50px"><?php echo $b->satuan; ?></td>
                        <td style="width:100px">
                          <?php if (!empty($b->isipack)) { ?>
                            <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                              <div class="form-line">
                                <input type="text" style="text-align:right" value="<?php if (!empty($jmlpack)) {
                                                                                      echo $jmlpack;
                                                                                    } ?>" id="jmlpack" name="jmlpack<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                              </div>
                            </div>
                          <?php } ?>
                        </td>
                        <td style="width:50px">Pack</td>
                        <td style="width:100px">
                          <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                            <div class="form-line">
                              <input type="text" style="text-align:right" value="<?php if (!empty($jmlpcs)) {
                                                                                    echo $jmlpcs;
                                                                                  } ?>" id="jmlpcs" name="jmlpcs<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                            </div>
                          </div>
                        </td>
                        <td style="width:50px">Pcs</td>
                      </tr>
                    <?php
                      $no++;
                      $jumproduk = $no - 1;
                    }
                    ?>
                    <input type="hidden" value="<?php echo $jumproduk; ?>" name="jumproduk">
                  </tbody>
                </table>
                <div class="mb-3 d-flex justify-content-end">
                  <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_gudangcabang_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="datadpb" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped table-hover" id="mytable">
          <thead class="thead-dark">
            <tr>
              <th width="10px">No</th>
              <th>No DPB</th>
              <th>Tanggal Pengambilan</th>
              <th>Nama Salesman</th>
              <th>Nama Cabang</th>
              <th>Tujuan</th>
              <th>No Kendaraan</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  flatpickr(document.getElementById('tgl_gb'), {});
</script>