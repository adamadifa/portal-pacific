
<?php
error_reporting(0);
$no = 1;
foreach ($detail as $b) {
  ?>
  <tr>
    <td style="width:10px"><?php echo $no; ?></td>
    <td><?php echo $b->kode_opname_gl; ?></td>
    <td><?php echo $b->kode_barang; ?></td>
    <td><?php echo $b->nama_barang; ?></td>
    <td><?php echo $b->qtyopname; ?></td>
    <td>
      <a data-kode="<?php echo $b->kode_opname_gl;?>" data-id="<?php echo $b->kode_barang;?>" class="btn btn-sm btn-danger hapus">Hapus</a>
      <a data-kode="<?php echo $b->kode_opname_gl;?>" data-id="<?php echo $b->kode_barang;?>" data-nama="<?php echo $b->nama_barang;?>" data-qty="<?php echo $b->qtyopname;?>" class="btn btn-sm btn-warning edit">Edit</a>
    </td>
  </tr>
  <?php
  $no++;
  $jumproduk = $no-1;
}
?>
<script type="text/javascript">

  $(function(){

    function loaddetailOpname()
    {
      var kode_opname_gl = $("#kode_opname_gl").val();
      var tahun          = $("#tahun").val();
      var bulan          = $("#bulan").val();
      var kode_barang    = $(this).attr("data-id");
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url(); ?>gudanglogistik/getdetailopname',
        data    : 
        {
          kode_opname_gl : kode_opname_gl,
          bulan          : bulan,
          tahun          : tahun,
          kode_barang    : kode_barang
        },
        cache   : false,
        success : function(respond)
        {
          $("#loaddetailOpname").html(respond);
        }
      });
    }

    $(".hapus").click(function(e){
      e.preventDefault();
      var kode_barang     = $(this).attr("data-id");
      var kode_opname_gl  = $(this).attr("data-kode");
      $.ajax({

        type : 'POST',
        url  : '<?php echo base_url();?>gudanglogistik/hapus_detal_opname',
        data : 
        {
          kode_barang    : kode_barang,
          kode_opname_gl : kode_opname_gl
        },
        cache:false,
        success:function(respond){
          loaddetailOpname();
        }
      });
    });

    $(".edit").click(function(e){
      e.preventDefault();
      var kode_barang     = $(this).attr("data-id");
      var kode_opname_gl  = $(this).attr("data-kode");
      var nama_barang     = $(this).attr("data-nama");
      var qty             = $(this).attr("data-qty");
      $("#kode_barang").val(kode_barang);
      $("#nama_barang").html(nama_barang);
      $("#kode_barang2").html(kode_barang);
      $("#kode_opname_gl2").html(kode_opname_gl);
      $("#qty").val(qty);
      $("#kode_edit").val(1);
      $("#qty").focus();
    });

    function formatAngka(angka) {
      if (typeof(angka) != 'string') angka = angka.toString();
      var reg = new RegExp('([0-9]+)([0-9]{3})');
      while(reg.test(angka)) angka = angka.replace(reg, '$1,$2');
      return angka;
    }

  });
</script>