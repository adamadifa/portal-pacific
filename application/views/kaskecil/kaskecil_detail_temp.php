<?php $no = 1;
foreach ($temp as $t) { ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $t->keterangan; ?></td>
    <td><?php echo number_format($t->jumlah, '0', '', '.'); ?></td>
    <td><?php echo $t->kode_akun . " - " . $t->nama_akun; ?></td>
    <td>
      <?php
      if ($t->status_dk == "D") {
        $inout = "OUT";
        $color = "red";
      } else {
        $inout = "IN";
        $color = "green";
      } ?>
      <label class="badge bg-<?php echo $color; ?>"><?php echo $inout; ?></label>
    </td>
    <?php if ($this->session->userdata('cabang') == "pusat") { ?>
      <td><?php echo $t->peruntukan; ?></td>
    <?php } ?>
    <td>
      <a href="#" class="btn btn-sm btn-danger hapus" data-id="<?php echo $t->id; ?>"><i class="fa fa-trash-o"></i></a>
    </td>
  </tr>
<?php $no++;
} ?>
<script>
  $(function() {
    function loadtampilkaskeciltemp() {
      var nobukti = $("#nobukti_input").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/tampilkaskeciltemp',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#tampilkaskeciltemp").html(respond);
        }
      });
    }

    function cekkaskeciltemp() {
      var nobukti = $("#nobukti_input").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/cekkaskeciltemp',
        data: {
          nobukti: nobukti
        },
        cache: false,
        success: function(respond) {
          $("#cekkaskeciltemp").val(respond);
        }
      });
    }
    $(".hapus").click(function(e) {
      e.preventDefault();
      var id = $(this).attr("data-id");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>kaskecil/hapuskaskeciltemp',
        data: {
          id: id
        },
        cache: false,
        success: function(respond) {
          loadtampilkaskeciltemp();
          cekkaskeciltemp();
        }
      });
    });
  });
</script>