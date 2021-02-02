<?php
$no = 1;
foreach ($data->result() as $d) {
?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d->kode_akun; ?></td>
        <td><?php echo $d->nama_akun; ?></td>
        <td align="right"><?php echo number_format($d->jumlah, 2); ?></td>
        <td><?php echo $d->nama_cabang; ?></td>
        <td>
            <a href="#" class="btn btn-danger btn-sm hapus" data-id="<?php echo $d->id;?>">Hapus</a>
        </td>
    </tr>
<?php
}
?>


<script>
  $(function() {

    function tampiltemp() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/view_tempcostratio',
        data: '',
        cache: false,
        success: function(html) {

          $("#loadtempcostratio").html(html);

        }
      });
    }

    $(".hapus").click(function(e) {
      e.preventDefault();
      var id = $(this).attr("data-id");
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>accounting/hapus_costratiotemp",
        cache: false,
        data: {
          id: id

        },
        success: function(respond) {
         tampiltemp();
        }
      });
    });


   
  });
</script>