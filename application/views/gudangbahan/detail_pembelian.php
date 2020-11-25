<form method="post" action="<?php echo base_url('gudangbahan/insert_pembelian'); ?>" enctype="multipart/form-data">
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
        <td hidden=""><input type="text" style="width: 50px" id="nobukti_pembelian" name="nobukti_pembelian" value="<?php echo $pmb['nobukti_pembelian']; ?>" class="form-control"></td>
      </tr>
    </thead>
  </table>
  <table class="table table-bordered table-hover table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Ket</th>
        <th>Qty</th>
        <th>Qty Unit</th>
        <th>Qty Berat</th>
        <th>Qty Lebih</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no     = 1;
      $total  = 0;
      foreach ($detail as $d) {
        $total = $total + ($d->qty * $d->harga);
      ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $d->nama_barang; ?></td>
          <td><?php echo $d->keterangan; ?></td>
          <td><?php echo $d->qty; ?></td>
          <td hidden=""><input type="text" style="width: 50px" id="kode_barang23[]" name="kode_barang23[]" value="<?php echo $d->kode_barang; ?>" class="form-control"></td>
          <td hidden=""><input type="text" style="width: 50px" id="keterangan[]" name="keterangan[]" value="<?php echo $d->keterangan; ?>" class="form-control"></td>
          <td><input type="text" style="width: 100px" id="qty_unit[]" name="qty_unit[]" class="form-control"></td>
          <td><input type="text" style="width: 100px" id="qty_berat[]" name="qty_berat[]" class="form-control"></td>
          <td><input type="text" style="width: 100px" id="qty_lebih[]" name="qty_lebih[]" class="form-control"></td>
        </tr>
      <?php
        $no++;
      }
      ?>
    </tbody>
  </table>
  <div class="form-group">
    <div class="input-group demo-masked-input">
      <span class="input-group-addon">
        <i class="material-icons">date_range</i>
      </span>
      <div class="form-line">
        <input type="text" id="tgl_pemasukan2" name="tgl_pemasukan" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
      </div>
    </div>
    <div class="col-md-offset-11">
      <button type="submit" value="Simpan" class="btn btn-sm btn-primary approve">Simpan</button>
    </div>
  </div>
</form>
<script type="text/javascript">
  $(function() {

    $('.datepicker').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      clearButton: true,
      weekStart: 1,
      time: false
    });


    $(".approsve").click(function(e) {
      e.preventDefault();

      var tgl_pemasukan = $('#tgl_pemasukan2').val();

      if (tgl_pemasukan == "") {

        swal("Oops!", "Silahkan Pilih Tanggal terlebih dahulu!", "warning");
        return false;

      } else {

        swal("Oops!", "Berhasil Disimpan", "success");
        return true;
        window.location.reload(false);

      }

    });
  });
</script>