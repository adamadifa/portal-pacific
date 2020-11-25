<?php //var_dump($bank); die; 
?>
<form autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>pembelian/proses_kontrabon">
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th>TERIMA DARI</th>
        <th>TANGGAL</th>
        <th>NO KONTRA BON</th>
      </tr>
    </thead>
    <tr>
      <td>
        <?php echo $kb['nama_supplier']; ?>
        <input type="hidden" name="supplier" value="<?php echo $kb['nama_supplier']; ?>">
      </td>
      <td><?php echo DateToIndo2($kb['tgl_kontrabon']); ?></td>
      <td>
        <?php echo $kb['no_kontrabon']; ?>
        <input type="hidden" name="nokontrabon" value="<?php echo $kb['no_kontrabon']; ?>">
      </td>
    </tr>
  </table>
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>No Bukti</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1;
      $total = 0;
      foreach ($detail as $d) {
        $total = $total + $d->jmlbayar; ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><a href="#" class="detailpmb2" data-nobukti="<?php echo $d->nobukti_pembelian; ?>"><?php echo $d->nobukti_pembelian; ?></a></td>
          <td align="right"><?php echo number_format($d->jmlbayar, '2', ',', '.'); ?></td>
        </tr>
      <?php $no++;
      }  ?>
    </tbody>
    <tr>
      <td colspan="2">TOTAL</td>
      <td align="right">
        <b> <?php echo number_format($total, '2', ',', '.'); ?></b>
        <input type="hidden" name="jmlbayar" value="<?php echo $total; ?>">
      </td>
    </tr>
    <tr>
      <td>Terbilang</td>
      <td colspan="2" align="right"><b><?php echo strtoupper(terbilang($total)); ?></b></td>
    </tr>
  </table>
  <div id="loaddetailpmb2">
  </div>
  <!-- <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th colspan="6">Detail Pembelian</th>
      </tr>
      <tr>
        <th>No</th>
        <th>No BPB</th>
        <th>Nama Barang</th>
        <th>Ket</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody id="loaddetailpmb2">
    </tbody>
  </table> -->
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="input-icon">
        <input type="date" id="tglbayar" name="tglbayar" class="form-control" placeholder="Tanggal Bayar" />
        <span class="input-icon-addon">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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


  <div class="form-group mb-3">
    <select class="form-select" id="via" name="via" data-error=".errorTxt1">
      <option value="">--VIA--</option>
      <?php foreach ($bank as $d) { ?>
        <option value="<?php echo $d->kode_bank; ?>"><?php echo $d->nama_bank; ?></option>
      <?php }  ?>
      <option value="CASH">CASH</option>
    </select>
  </div>
  <div class="form-group mb-3">
    <select class="form-select show-tick" id="kodeakun" name="kodeakun" data-error=".errorTxt1">
      <option value="">--Pilih Akun--</option>
      <option value="2-1300">Hutang Lainnya</option>
      <option value="2-1200">Hutang Dagang</option>
    </select>
  </div>
  <div class="form-group nobkk mb-3">
    <input type="text" value="" id="nobkk" name="nobkk" class="form-control" placeholder="No BKK" data-error=".errorTxt19" />
  </div>
  <div class="form-group keterangan mb-3">
    <input type="text" value="" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" data-error=".errorTxt19" />
  </div>

  <div class="form-group">
    <div class="d-flex justify-content-end">
      <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
    </div>
  </div>
</form>
<script>
  flatpickr(document.getElementById('tglbayar'), {});
</script>
<script type="text/javascript">
  $(function() {
    function cektutuplaporan() {
      var tgltransaksi = $("#tglbayar").val();
      var jenis = 'pembelian';
      if (tgltransaksi != "") {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>setting/cektutuplaporan',
          data: {
            tanggal: tgltransaksi,
            jenis: jenis
          },
          cache: false,
          success: function(respond) {
            console.log(respond);
            var status = respond;
            if (status != 0) {
              swal("Oops!", "Laporan Untuk Periode Ini Sudah Di Tutup !", "warning");
              $("#tglbayar").val("");
            }
          }
        });
      }
    }
    cektutuplaporan();
    $("#tglbayar").change(function() {
      cektutuplaporan();
    });

    function hidenobkk() {
      $(".nobkk").hide();
      $("#keterangan").val("");
      $("#nobkk").val("-");
      $(".keterangan").show();

    }

    function shownobkk() {
      $(".nobkk").show();

      $("#keterangan").val("-");
      $("#nobkk").val("");
      $(".keterangan").hide();
    }

    hidenobkk();

    //$("#via").selectpicker('refresh');
    $("#via").change(function(e) {
      var via = $(this).val();
      if (via == "KAS KECIL") {
        shownobkk();
      } else {
        hidenobkk();
      }
    });

    $(".detailpmb2").click(function(e) {
      e.preventDefault();
      var nobukti = $(this).attr("data-nobukti");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pembelian/detailpembeliankb',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailpmb2").html(respond);
        }
      });
    });

    $("#formValidate").submit(function() {
      var tglbayar = $("#tglbayar").val();
      var via = $("#via").val();
      var kodeakun = $("#kodeakun").val();
      var nobkk = $("#nobkk").val();
      var keterangan = $("#keterangan").val();

      if (tglbayar == "") {
        swal("Oops!", "Tanggal Masih Kosong!", "warning");
        return false;
      } else if (via == "") {
        swal("Oops!", "Bank Masih Kosong!", "warning");
        return false;
      } else if (kodeakun == "") {
        swal("Oops!", "Kode Akun Masih Kosong!", "warning");
        return false;
      } else if (via == "KAS KECIL" && nobkk == "") {
        swal("Oops!", "No BKK Kosong!", "warning");
        return false;
      } else if (via != "KAS KECIL" && keterangan == "") {
        swal("Oops!", "Keterangan Masih Kosong!", "warning");
        return false;
      } else {
        return true;
      }
    });

  })
</script>