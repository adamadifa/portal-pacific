<table class="table table-bordered table-hover table-striped">
  <tr>
    <td><b>NO Permintaan</b></td>
    <td>:</td>
    <td>
      <?php echo $pp['no_permintaan_pengiriman']; ?>
      <input type="hidden" id="nopermintaan" value="<?php echo $pp['no_permintaan_pengiriman']; ?>">
    </td>
  </tr>
  <tr>
    <td><b>Tanggal</b></td>
    <td>:</td>
    <td><?php echo DateToIndo2($pp['tgl_permintaan_pengiriman']); ?></td>
  </tr>
  <tr>
    <td><b>Cabang</b></td>
    <td>:</td>
    <td><?php echo $pp['nama_cabang']; ?></td>
  </tr>
  <tr>
    <td><b>Keterangan</b></td>
    <td>:</td>
    <td><?php echo $pp['keterangan']; ?></td>
  </tr>
  <tr>
    <td><b>Status</b></td>
    <td>:</td>
    <td>
      <?php

      if ($pp['status'] == 0) {
        $color = "bg-red";
        $status = "Belum di Proses";
      } else {
        $color  = "bg-green";
        $status = "Sudah di Proses";
      }


      ?>
      <span class="badge <?php echo $color; ?>"><?php echo $status; ?></span>
    </td>
  </tr>

</table>
<?php if ($pp['status'] == 0) { ?>
  <div class="row">

    <div class="body">
      <div class="col-md-6">
        <label>Barang</label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="material-icons">chrome_reader_mode</i>
          </span>
          <div class="form-line">
            <input type="hidden" readonly id="kodeproduk" name="kodeproduk" class="form-control" placeholder="Barang" />
            <input type="text" readonly id="produk" name="produk" class="form-control" placeholder="Barang" />
          </div>

        </div>
      </div>
      <div class="col-md-4">
        <label>Jumlah</label>
        <div class="input-group">
          <div class="form-line">
            <input type="text" id="jml" name="jml" class="form-control" placeholder="Jumlah" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <a href="#" id="updatebarang" class="btn bg-teal waves-effect">
          <i class="material-icons">update</i>

        </a>
      </div>
    </div>

  </div>
<?php } ?>
<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr>
      <th>Kode Produk</th>
      <th>Nama Barang</th>
      <th>Jumlah</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody id="loaddetailpp">

  </tbody>
</table>
<?php if ($pp['status'] != 0) { ?>
  <table class="table table-bordered table-hover table-striped">
    <tr>
      <td><b>No Surat Jalan</b></td>
      <td>:</td>
      <td>
        <?php echo $sj['no_permintaan_pengiriman']; ?>
      </td>
    </tr>
    <tr>
      <td><b>Tanggal SJ</b></td>
      <td>:</td>
      <td><?php echo DateToIndo2($sj['tgl_mutasi_gudang']); ?></td>
    </tr>
    <tr>
      <td><b>Status</b></td>
      <td>:</td>
      <td>
        <?php

        if ($sj['status_sj'] == 0) {
          $color = "bg-red";
          $status = "Belum di Terima Cabang";
        } else {
          $color  = "bg-green";
          $status = "Sudah di Terima Cabang";
        }


        ?>
        <span class="badge <?php echo $color; ?>"><?php echo $status; ?></span>
      </td>
    </tr>

  </table>
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th colspan="4">Realisasi Permintaan</th>
      </tr>
      <tr>
        <th>Kode Produk</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody id="">
      <?php


      foreach ($detail as $ds) {

      ?>
        <tr>
          <td><?php echo $ds->kode_produk; ?></td>
          <td><?php echo $ds->nama_barang; ?></td>
          <td><?php echo $ds->jumlah; ?></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
<?php } ?>
<div class="modal fade" id="dbarang" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card">
        <div class="header bg-cyan">
          <h2>
            Data Barang
            <small>Pilih Data Barang</small>
          </h2>

        </div>
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="loaddBarang"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {

    function loaddetailpp() {
      var no_permintaan = $("#nopermintaan").val();
      $("#loaddetailpp").load('<?php echo base_url(); ?>/oman/detailpp/' + no_permintaan);
    }

    function resetbarang() {

      $("#kodeproduk").val("");
      $("#jml").val("");
      $("#produk").val("");
    }
    loaddetailpp();


    $("#produk").click(function() {

      $("#dbarang").modal("show");
      $.ajax({

        type: 'POST',
        url: '<?php echo base_url(); ?>oman/view_dbarang',
        cache: false,
        success: function(respond) {
          //alert(kodecabang);
          $("#loaddBarang").html(respond);

        }

      });


    });
    $("#updatebarang").click(function(e) {
      e.preventDefault();
      var no_permintaan = $("#nopermintaan").val();
      var kode_produk = $("#kodeproduk").val();
      var jumlah = $("#jml").val();

      if (jumlah == "") {

        swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");

      } else {
        $.ajax({

          type: 'POST',
          url: '<?php echo base_url(); ?>oman/update_detailpermintaan',
          data: {
            no_permintaan: no_permintaan,
            kode_produk: kode_produk,
            jumlah: jumlah
          },
          cache: false,
          success: function(respond) {
            loaddetailpp();
            resetbarang();

          }



        });
      }


    });
  });
</script>