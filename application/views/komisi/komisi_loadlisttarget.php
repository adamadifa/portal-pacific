<?php foreach ($salesman as $s) { ?>
  <tr>
    <td style="width:10%"><?php echo $s->id_karyawan; ?></td>
    <td style="width:10%"><?php echo $s->nama_karyawan; ?></td>
    <?php foreach ($produk as $p) {
      $cekvaluetarget = $this->db->get_where('komisi_target_qty_detail', array('kode_target' => $kodetarget, 'id_karyawan' => $s->id_karyawan, 'kode_produk' => $p->kode_produk))->row_array();
      if ($cekvaluetarget['jumlah_target'] > 0) {
        $bgcolor = "#d1ff7a";
      } else {
        $bgcolor = "";
      }
    ?>
      <td>
        <input type="text" style="background-color: <?php echo $bgcolor; ?>;" class="form-control settargetproduksales" value="<?php echo $cekvaluetarget['jumlah_target']; ?>" data-salesman="<?php echo $s->id_karyawan; ?>" data-produk="<?php echo $p->kode_produk; ?>">
      </td>
    <?php } ?>
  </tr>
<?php } ?>
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
    $(".settargetproduksales").on('change', function() {
      var salesman = $(this).attr("data-salesman");
      var produk = $(this).attr("data-produk");
      var jmltarget = $(this).val();
      var kodetarget = $("#kodetarget").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/simpantarget',
        data: {
          kodetarget: kodetarget,
          salesman: salesman,
          produk: produk,
          jmltarget: jmltarget
        },
        cache: false,
        success: function(respond) {
          loadlisttarget();
        }
      });
    });
  });
</script>