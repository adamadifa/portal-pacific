<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA PERINCIAN BARANG (DPB)
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
            <h4 class="card-title">DATA PERINCIAN BARANG (DPB) </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>dpb" autocomplete="off">
              <div class="form-group mb-3">
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <i class="fa fa-calendar-o"></i>
                  </span>
                  <input type="text" value="<?php echo $tgl_pengambilan; ?>" id="tgl_pengambilan" name="tgl_pengambilan" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
                </div>
              </div>
              <?php if ($cb == 'pusat') { ?>
                <div class="form-group mb-3">
                  <select class="form-select" id="cabang" name="cabang">
                    <option value="">Pilih Cabang</option>
                    <?php foreach ($cabang as $c) { ?>
                      <option <?php if ($cbg == $c->kode_cabang) {
                                echo "selected";
                              } ?> value="<?php echo $c->kode_cabang; ?>"><?php echo strtoupper($c->nama_cabang); ?></option>
                    <?php } ?>
                  </select>
                </div>
              <?php } else { ?>
                <input type="hidden" readonly id="cabang" name="cabang" value="<?php echo $cb; ?>" class="form-control" placeholder="Kode Cabang" />
              <?php } ?>
              <div class="form-group mb-3">
                <select class="form-select show-tick" id="salesman" name="salesman" data-error=".errorTxt1">
                  <option value="<?php echo $salesman; ?>"><?php echo $sales['nama_karyawan']; ?></option>
                </select>
              </div>
              <div class="mb-3 d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
              </div>
            </form>
            <hr>
            <a href="<?php echo base_url(); ?>dpb/inputdpb" class="btn btn-danger mb-3">Tambah Data</a>

            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" style="width:100%" id="mytable">
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
                <tbody>
                  <?php
                  $sno  = $row + 1;
                  foreach ($result as $d) {
                    if (empty($d['tgl_pengembalian'])) {
                      $bg = "pink";
                    } else {
                      $bg = "teal";
                    }
                  ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $d['no_dpb']; ?></td>
                      <td><?php echo DateToIndo2($d['tgl_pengambilan']); ?></td>
                      <td><?php echo $d['nama_karyawan']; ?></td>
                      <td><?php echo $d['kode_cabang']; ?></td>
                      <td><?php echo $d['tujuan']; ?></td>
                      <td><?php echo $d['no_kendaraan']; ?></td>
                      <td>
                        <a href="#" class="btn btn-sm btn-info detail" data-nodpb="<?php echo $d['no_dpb']; ?>">Detail</a>
                        <a href="<?php echo base_url(); ?>dpb/updatedpb/<?php echo $d['no_dpb']; ?>" class="btn btn-sm btn-<?php echo $bg; ?>">Update DPB</a>
                        <a href="<?php echo base_url(); ?>dpb/hapusdpb/<?php echo $d['no_dpb']; ?>" class="btn btn-sm btn-danger">Hapus</a>
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

      <?php $this->load->view('menu/menu_gudangcabang_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detaildpb" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loaddpb"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
  flatpickr(document.getElementById('tgl_pengambilan'), {});
</script>
<script type="text/javascript">
  $(function() {
    $('.detail').click(function(e) {
      e.preventDefault();
      var no_dpb = $(this).attr('data-nodpb');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>dpb/detail_dpb',
        data: {
          no_dpb: no_dpb
        },
        cache: false,
        success: function(respond) {
          $("#loaddpb").html(respond);
        }
      });
      $("#detaildpb").modal("show");
    });

    function loadsalesman() {
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
        }
      });
    }

    $("#cabang").change(function(e) {
      loadsalesman();
    });
    loadsalesman();

  });
</script>