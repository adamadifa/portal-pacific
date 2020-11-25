<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
    <tr style="font-weight:bold">
      <th>Tanggal Input</th>
      <th>Kode Saldo Awal</th>
    </tr>
    <tr>
      <td><?php echo DateToIndo2($data['tanggal']); ?></td>
      <td><?php echo $data['kode_saldoawal_gb']; ?></td>
    </tr>
    <tr>
      <td hidden=""><input type="text" id="kodesaldoawal" value="<?php echo $data['kode_saldoawal_gb']; ?>" class="form-control"></td>
      <td hidden=""><input type="text" id="kode_barang" class="form-control"></td>
      <td>
        <h5 id="kode_barang2"></h5>
      </td>
      <td>
        <h5 id="nama_barang"></h5>
      </td>
      <td>
        <h5 id="jenis_barang"></h5>
      </td>
      <td><input type="text" id="qty_unit" class="form-control"></td>
      <td><input type="text" id="qty_berat" class="form-control"></td>
      <td>
        <a href="#" class="btn bg-blue btn-sm" id="simpan">OK</a>
      </td>
    </tr>
  </thead>
</table>
<table class="table table-bordered table-hover table-striped">
  <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Kategori Barang</th>
        <th>Qty Unit</th>
        <th>Qty Berat</th>
      </tr>
    </thead>
  <tbody id="viewdetail">

  </tbody>
</table>

<script type="text/javascript">
  $(function() {

    tampildetail();

    function tampildetail() {

      var kode_saldoawal_gb = $('#kodesaldoawal').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>gudangbahan/view_detail_saldoawal',
        data: {
          kode_saldoawal_gb: kode_saldoawal_gb
        },
        cache: false,
        success: function(html) {

          $("#viewdetail").html(html);

          $('#kode_barang2').html("");
          $('#kode_barang').val("");
          $('#qty_unit').val("");
          $('#qty_berat').val("");
          $('#jenis_barang').html("");
          $('#nama_barang').html("");

        }

      });
    }

    $("#simpan").click(function(e) {
      e.preventDefault();

      var kodebarang = $('#kode_barang').val();
      var kodesaldoawal = $('#kodesaldoawal').val();
      var qty_unit = $('#qty_unit').val();
      var qty_berat = $('#qty_berat').val();

      if (kodebarang == 0) {

        swal("Oops!", "Nama Barang Harus Diisi !", "warning");

      } else if (qty_unit == "") {

        swal("Oops!", "Qty Unit Harus Diisi!", "warning");

      } else if (qty_berat == "") {

        swal("Oops!", "Qty Berat Harus Diisi!", "warning");

      } else {

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>gudangbahan/editdetailsaldoawal',
          data: {
            kodesaldoawal: kodesaldoawal,
            kodebarang: kodebarang,
            qty_unit: qty_unit,
            qty_berat: qty_berat
          },
          cache: false,
          success: function(respond) {

            if (respond == 1) {
              swal("Oops!", "Data Sudah Di Inputkan!", "warning");
            }
            tampildetail();

          }

        });

      }
    });


  });
</script>