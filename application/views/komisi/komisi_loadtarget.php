<?php foreach ($target as $t) { ?>
  <tr>
    <td><?php echo $t->kode_target; ?></td>
    <td><?php echo $bulan[$t->bulan]; ?></td>
    <td><?php echo $t->tahun; ?></td>
    <td>
      <a href="#" data-kodetarget="<?php echo $t->kode_target; ?>" class="btn btn-primary btn-sm settarget"><i class="fa fa-gear mr-2"></i>Set Target Quantity</a>
      <a href="#" data-kodetarget="<?php echo $t->kode_target; ?>" class="btn btn-info btn-sm settargetcashin"><i class="fa fa-gear mr-2"></i>Set Target Cash IN</a>
    </td>
  </tr>
<?php } ?>
<script>
  $(function() {
    $(".settarget").click(function(e) {
      e.preventDefault();
      var kodetarget = $(this).attr("data-kodetarget");
      $("#modalsettarget").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/inputsettarget',
        data: {
          kodetarget: kodetarget
        },
        cache: false,
        success: function(respond) {
          $("#loadformsettarget").html(respond);
        }
      });
    });

    $(".settargetcashin").click(function(e) {
      e.preventDefault();
      var kodetarget = $(this).attr("data-kodetarget");
      $("#modalsettargetcashin").modal("show");
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>komisi/inputsettargetcashin',
        data: {
          kodetarget: kodetarget
        },
        cache: false,
        success: function(respond) {
          $("#loadformsettargetcashin").html(respond);
        }
      });
    });
  });
</script>