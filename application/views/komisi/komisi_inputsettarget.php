<div class="row mb-3">
  <input type="hidden" id="kodetarget" value="<?php echo $kodetarget; ?>">
  <div class="form-group mb-3">
    <select name="cabang" id="cabang" class="form-select">
      <option value="">Pilih Cabang</option>
      <?php foreach ($cabang as $c) { ?>
        <option value="<?php echo $c->kode_cabang; ?>"><?php echo $c->nama_cabang; ?></option>
      <?php } ?>
    </select>
  </div>
</div>
<div class="row mb-3">
  <table class="table table-bordered table-striped">
    <thead class="thead-dark" style="text-align:center;">
      <tr>
        <th rowspan="2">ID Sales</th>
        <th rowspan="2">Nama Sales</th>
        <th colspan="<?php echo $jmlproduk; ?>">Target Quantity</th>
      </tr>
      <tr>
        <?php foreach ($produk as $p) { ?>
          <th><?php echo $p->kode_produk; ?></th>
        <?php } ?>
      </tr>
    </thead>
    <tbody id="loadlisttarget">

    </tbody>
  </table>
</div>
<script>
  $(function() {

    function loadlisttarget() {
      var kodetarget = $("#kodetarget").val();
      var cabang = $("#cabang").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/loadlisttarget',
        data: {
          cabang: cabang,
          kodetarget: kodetarget
        },
        cache: false,
        success: function(respond) {
          $("#loadlisttarget").html(respond);
        }
      });
    }

    $("#cabang").change(function(e) {
      loadlisttarget();
    });
  });
</script>