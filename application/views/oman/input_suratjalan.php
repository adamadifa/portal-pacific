<form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>oman/input_suratjalan">
  <div class="mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-barcode"></i>
      </span>
      <input type="text" id="no_sj" name="no_sj" class="form-control" placeholder="No Surat Jalan" data-error=".errorTxt1" />
      <input type="hidden" id="cekdetailsuratjalan" name="cekdetailsuratjalan">
    </div>
  </div>
  <div class="mb-3">
    <div class="input-icon">
      <span class="input-icon-addon">
        <i class="fa fa-calendar-o"></i>
      </span>
      <input type="text" value="" id="tgl_sj" name="tgl_sj" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
    </div>
  </div>
  <table class="table table-hover table-striped">
    <tr>
      <td><b>NO Permintaan</b></td>
      <td>:</td>
      <td>
        <?php echo $pp['no_permintaan_pengiriman']; ?>
        <input type="hidden" id="nopermintaan" name="nopermintaan" value="<?php echo $pp['no_permintaan_pengiriman']; ?>">
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
      <td>
        <?php echo $pp['nama_cabang']; ?>
        <input type="hidden" id="cabang" value="<?php echo $pp['kode_cabang']; ?>">
      </td>
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
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th colspan="3">Detail Permintaan</th>
      </tr>
      <tr>
        <th>Kode Produk</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody id="loaddetailpermintaankirim">
    </tbody>
  </table>
  <div class="row mb-3">
    <div class="col-md-6">
      <select class="form-select" name="kode_produk" id="kode_produk">
        <option value="">-- Pilih Barang / Produk</option>
        <?php foreach ($produk as $p) { ?>
          <option value="<?php echo $p->kode_produk; ?>"><?php echo $p->kode_produk; ?> | <?php echo $p->nama_barang; ?></option>
        <?php } ?>
      </select>
      <input type="hidden" readonly id="stok" name="stok" class="form-control" placeholder="Stok" />
    </div>
    <div class="col-md-4">
      <div class="input-icon">
        <span class="input-icon-addon">
          <i class="fa fa-file"></i>
        </span>
        <input type="text" id="jml" name="jml" class="form-control" placeholder="Jumlah" />
      </div>
    </div>
    <div class="col-md-2">
      <a href="#" id="tambahbarang" class="btn btn-primary">
        <i class="fa fa-plus"></i>
      </a>
    </div>
  </div>
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th colspan="4">Realisasi Permintaan</th>
      </tr>
      <tr>
        <th>Kode Produk</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="loaddetailsuratjalan">

    </tbody>
  </table>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>SIMPAN</button>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tgl_sj'), {});
</script>
<script type="text/javascript">
  $(function() {
    function loaddetailpp() {
      var no_permintaan = $("#nopermintaan").val();
      $("#loaddetailpermintaankirim").load('<?php echo base_url(); ?>/oman/detailpp_gj/' + no_permintaan);
    }

    function loaddetailsj() {
      var no_permintaan = $("#nopermintaan").val();
      $("#loaddetailsuratjalan").load('<?php echo base_url(); ?>/oman/detailsjtemp/' + no_permintaan);
    }

    function cek_detailsuratjalan() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>oman/cek_detailsuratjalan',
        cache: false,
        success: function(respond) {
          $("#cekdetailsuratjalan").val(respond);
          console.log(respond);
        }
      });
    }
    cek_detailsuratjalan();
    loaddetailsj();
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
    $("#tambahbarang").click(function(e) {
      e.preventDefault();
      var no_permintaan = $("#nopermintaan").val();
      var kode_produk = $("#kode_produk").val();
      var jumlah = $("#jml").val();
      var stok = $("#stok").val();
      if (stok != "") {
        stok = $("#stok").val();
      } else {
        stok = 0;
      }
      if (jumlah == "") {
        swal("Oops!", "Jumlah Tidak Boleh 0!", "warning");
      } else if (kode_produk == "") {
        swal("Oops!", "Silahkan Pilih Barang!", "warning");
      } else if (parseInt(jumlah) > parseInt(stok)) {
        swal("Oops!", "Stok Gudang Tidak Mencukupi ! Stok Tersedia " + stok, "warning");
      } else {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>oman/insert_detailsuratjalantemp',
          data: {
            no_permintaan: no_permintaan,
            kode_produk: kode_produk,
            jumlah: jumlah
          },
          cache: false,
          success: function(respond) {
            loaddetailsj();
            cek_detailsuratjalan();
          }
        });
      }
    });



    $("#tgl_sj").change(function() {
      var tgl_sj = $("#tgl_sj").val();
      var cabang = $("#cabang").val();
      //alert(cabang);
      if (cabang != "") {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>oman/buat_nomor_sj',
          data: {
            tgl_sj: tgl_sj,
            cabang: cabang
          },
          cache: false,
          success: function(respond) {
            console.log(respond);
            $("#no_sj").val("");
            $("#no_sj").val(respond);
          }
        });
      }
    });
    $(".formValidate").submit(function() {
      var no_sj = $("#no_sj").val();
      var tgl_sj = $("#tgl_sj").val();
      var cek = $("#cekdetailsuratjalan").val();
      if (no_sj == "") {
        swal("Oops!", "No Surat Jalan Masih Kosong!", "warning");
        return false;
      } else if (tgl_sj == "") {
        swal("Oops!", "Tanggal Surat Jalan Masih Kosong!", "warning");
        return false;
      } else if (cek == "") {
        swal("Oops!", "Data Barang Masih Kosong!", "warning");
        return false;
      } else {
        return true;
      }
    });

    $("#kode_produk").change(function(e) {
      var kodeproduk = $(this).val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>oman/cek_stokgudang',
        data: {
          kodeproduk: kodeproduk
        },
        cache: false,
        success: function(respond) {
          console.log(respond);
          $("#stok").val(respond);
        }

      });
    });
  });
</script>