<div class="table-responsive">
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr style="font-weight:bold">
        <th>Tanggal</th>
        <th>NO Bukti</th>
        <th>Supplier</th>
        <th>Departemen</th>
      </tr>
      <tr>
        <td><?php echo DateToIndo2($pmb['tgl_pembelian']); ?></td>
        <td><?php echo $pmb['nobukti_pembelian']; ?></td>
        <td><?php echo $pmb['nama_supplier']; ?></td>
        <td><?php echo $pmb['nama_dept']; ?></td>
      </tr>
    </thead>
  </table>
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Ket</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
        <th>Akun</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no     = 1;
      $total  = 0;
      foreach ($detail as $d) {
        $total = $total + ($d->qty * $d->harga + $d->penyesuaian);
      ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $d->kode_barang; ?></td>
          <td><?php echo $d->nama_barang; ?></td>
          <td><?php echo $d->keterangan; ?></td>
          <td><?php echo $d->qty; ?></td>
          <td align="right"><?php echo number_format($d->harga, '2', ',', '.'); ?></td>
          <td align="right"><?php echo number_format($d->qty * $d->harga + $d->penyesuaian, '2', ',', '.'); ?></td>
          <td><?php echo $d->kode_akun; ?> <?php echo $d->nama_akun; ?></td>
        </tr>
      <?php
        $no++;
      }
      ?>
      <tr>
        <th colspan="6">TOTAL PEMBELIAN</th>
        <td align="right"><b> <?php echo number_format($total, '2', ',', '.'); ?></b></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="col-md-12">
  <div class="col-md-12">
    <div class="form-group">
      <div class="input-icon">
        <input id="tgl_pemasukan2" type="text" placeholder="Tanggal" class="form-control" name="tgl_pemasukan" />
        <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
  <div class="col-md-12">
    <div class="form-group">
      <div class="col-md-offset-11">
        <a href="#" data-nobukti="<?php echo $pmb['nobukti_pembelian']; ?>" class="btn btn-md btn-success approve">Approve</a>
      </div>
    </div>
  </div>
</div>

<script>
  flatpickr(document.getElementById('tgl_pemasukan2'), {});
</script>

<script type="text/javascript">
  $(function() {

    $(".approve").click(function(e) {
      e.preventDefault();

      var nobukti = $(this).attr("data-nobukti");
      var tgl_pemasukan = $('#tgl_pemasukan2').val();

      if (tgl_pemasukan == "") {

        swal("Oops!", "Silahkan Pilih Tanggal terlebih dahulu!", "warning");

      } else {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>gudanglogistik/insert_pembelian',
          data: {
            nobukti: nobukti,
            tgl_pemasukan: tgl_pemasukan
          },
          cache: false,
          success: function() {

            window.location.reload(false);

          }

        });
      }

    });
  });
</script>