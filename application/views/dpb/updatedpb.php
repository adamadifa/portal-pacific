<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          UPDATE DATA PERINCIAN BARANG (DPB)
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"> UPDATE DATA PERINCIAN BARANG (DPB)</h4>
            </div>
            <div class="card-body">
              <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>dpb/update_dpb">
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" readonly value="<?php echo $dpb['no_dpb']; ?>" id="nodpb" name="nodpb" class="form-control" placeholder="No DPB" data-error=".errorTxt19" />
                  </div>
                </div>
                <?php if ($cb == 'pusat') { ?>
                  <div class="form-group mb-3">
                    <select class="form-select" id="cabang" name="cabang">
                      <option value="">Pilih Cabang</option>
                      <?php foreach ($cabang as $c) { ?>
                        <option <?php if ($dpb['kode_cabang'] == $c->kode_cabang) {
                                  echo "selected";
                                } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                <?php } else { ?>
                  <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $dpb['kode_cabang']; ?>" class="form-control" placeholder="Kode Cabang" />
                <?php } ?>
                <div class="form-group mb-3">
                  <select class="form-select show-tick" id="salesman" name="salesman" data-error=".errorTxt1">
                    <option value="<?php echo $dpb['id_karyawan'] ?>"><?php echo $dpb['nama_karyawan']; ?></option>
                    <?php foreach ($salesman as $s) { ?>
                      <option value="<?php echo $s->id_karyawan ?>"><?php echo $s->nama_karyawan; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-map"></i>
                    </span>
                    <input type="text" value="<?php echo $dpb['tujuan']; ?>" id="tujuan" name="tujuan" class="form-control" placeholder="Tujuan" data-error=".errorTxt19" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-truck"></i>
                    </span>
                    <input type="text" value="<?php echo $dpb['no_kendaraan'] ?>" id="nokendaraan" name="nokendaraan" class="form-control" placeholder="No Kendaraan" data-error=".errorTxt19" />
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th rowspan="4" align="">No</th>
                      <th rowspan="4" style="text-align:center">Nama Barang</th>
                      <th colspan="2" style="text-align:center">Pengambilan</th>
                      <th colspan="2" style="text-align:center">Pengembalian</th>
                      <th rowspan="4" style="text-align:center">Barang Keluar</th>

                    </tr>
                    <tr>
                      <th colspan="2" style="text-align:center">
                        <div class="form-group mb-3">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-calendar-o"></i>
                            </span>
                            <input type="text" style="text-align:center; color:black !important" value="<?php echo $dpb['tgl_pengambilan']; ?>" id="tglambil" name="tglambil" class="form-control datepicker" placeholder="Tgl Pengambilan" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </th>
                      <th colspan="2" style="text-align:center">
                        <div class="form-group mb-3">
                          <div class="input-icon">
                            <span class="input-icon-addon">
                              <i class="fa fa-calendar-o"></i>
                            </span>
                            <input type="text" style="text-align:center; color:black !important" value="<?php echo $dpb['tgl_pengembalian']; ?>" id="tglkembali" name="tglkembali" class="form-control datepicker" placeholder="Tgl Pengembalian" data-error=".errorTxt19" />
                          </div>
                        </div>
                      </th>
                    </tr>
                    <tr>
                      <th colspan="2" style="text-align:center">Kuantitas</th>
                      <th colspan="2" style="text-align:center">Kuantitas</th>
                    </tr>
                    <tr>
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
                      $jml = $this->db->get_where('detail_dpb', array('no_dpb' => $dpb['no_dpb'], 'kode_produk' => $b->kode_produk))->row_array();
                    ?>
                      <tr>
                        <td style="width:10px"><?php echo $no; ?></td>
                        <td style="width:200px">
                          <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $b->kode_produk; ?>">
                          <?php echo $b->nama_barang; ?>
                        </td>
                        <td style="width:100px">
                          <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                            <div class="form-line">
                              <input type="text" value="<?php echo $jml['jml_pengambilan']; ?>" style="text-align:right" value="" id="jmlpengambilan" name="jmlpengambilan<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                            </div>
                          </div>
                        </td>
                        <td style="width:50px"><?php echo $b->satuan; ?></td>
                        <td style="width:100px">
                          <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                            <div class="form-line">
                              <input type="text" value="<?php echo $jml['jml_pengembalian']; ?>" style="text-align:right" id="jmlpengembalian" name="jmlpengembalian<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                            </div>
                          </div>
                        </td>
                        <td style="width:50px"><?php echo $b->satuan; ?></td>
                        <td style="width:100px">
                          <div class="input-group demo-masked-input" style="margin-bottom:0px !important; ">
                            <div class="form-line">
                              <input type="text" value="<?php echo $jml['jml_penjualan']; ?>" style="text-align:right" id="jmlbrgkeluar" name="jmlbrgkeluar<?php echo $no; ?>" class="form-control" data-error=".errorTxt19" />
                            </div>
                          </div>
                        </td>
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
<script>
  flatpickr(document.getElementById('tglambil'), {});
  flatpickr(document.getElementById('tglkembali'), {});
</script>
<script type="text/javascript">
  $(function() {
    $(".formValidate").submit(function() {
      var nodpb = $("#nodpb").val();
      var cabang = $("#cabang").val();
      var salesman = $("#salesman").val();
      var tujuan = $("#tujuan").val();
      var nokendaraan = $("#nokendaraan").val();
      var tglkembali = $("#tglkembali").val();
      if (nodpb == "") {
        swal("Oops!", "No DPB Harus Diisi!", "warning");
        return false;
      } else if (cabang == "") {
        swal("Oops!", "Cabang Harus Diisi!", "warning");
        return false;
      } else if (salesman == "") {
        swal("Oops!", "Salesman Harus Diisi!", "warning");
        return false;
      } else if (tujuan == "") {
        swal("Oops!", "Tujuan Harus Diisi!", "warning");
        return false;
      } else if (nokendaraan == "") {
        swal("Oops!", "No Kendaraan Harus Diisi!", "warning");
        return false;
      } else if (tglkembali == "") {
        swal("Oops!", "Tanggal Pengembalian Harus Diisi!", "warning");
        return false;
      }
    });

    $("#cabang").change(function(e) {
      e.preventDefault();
      var cabang = $("#cabang").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>laporanpenjualan/get_salesman',
        data: {
          cabang: cabang
        },
        cache: false,
        success: function(respond) {
          $("#salesman").html(respond);
          $("#salesman").selectpicker("refresh");
        }
      });
    });



  });
</script>