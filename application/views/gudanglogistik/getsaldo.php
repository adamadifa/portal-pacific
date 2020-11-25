
<?php
error_reporting(0);
$no = 1;
foreach ($detail as $b) {
  ?>
  <tr>
    <td style="width:10px"><?php echo $no; ?></td>
    <td><?php echo $b->kode_saldoawal_gl; ?></td>
    <td><?php echo $b->kode_barang; ?></td>
    <td><?php echo $b->nama_barang; ?></td>
    <td><?php echo number_format($b->qtysaldoawal,2); ?></td>
    <td><?php echo number_format($b->harga,2); ?></td>
    <td>
      <a data-kode="<?php echo $b->kode_saldoawal_gl;?>" data-id="<?php echo $b->kode_barang;?>" class="btn btn-sm btn-danger hapus">Hapus</a>
      <a data-kode="<?php echo $b->kode_saldoawal_gl;?>" data-id="<?php echo $b->kode_barang;?>" data-nama="<?php echo $b->nama_barang;?>" data-qty="<?php echo $b->qtysaldoawal;?>" data-harga="<?php echo $b->harga;?>" class="btn btn-sm btn-warning edit">Edit</a>
    </td>
  </tr>
  <?php
  $no++;
  $jumproduk = $no-1;
}
?>
<script type="text/javascript">

  $(function(){

    function loaddetailsaldoawal()
    {
      var kode_saldoawal_gl = $("#kode_saldoawal_gl").val();
      var tahun          = $("#tahun").val();
      var bulan          = $("#bulan").val();
      $.ajax({
        type    : 'POST',
        url     : '<?php echo base_url(); ?>gudanglogistik/getdetailsaldo',
        data    : 
        {
          kode_saldoawal_gl : kode_saldoawal_gl,
          bulan          : bulan,
          tahun          : tahun
        },
        cache   : false,
        success : function(respond)
        {
          $("#loaddetailsaldoawal").html(respond);
        }
      });
    }

    $(".hapus").click(function(e){
      e.preventDefault();
      var kode_barang     = $(this).attr("data-id");
      var kode_saldoawal_gl  = $(this).attr("data-kode");
      $.ajax({

        type : 'POST',
        url  : '<?php echo base_url();?>gudanglogistik/hapus_detal_saldoawal',
        data : 
        {
          kode_barang    : kode_barang,
          kode_saldoawal_gl : kode_saldoawal_gl
        },
        cache:false,
        success:function(respond){
          loaddetailsaldoawal();
        }
      });
    });

    $(".edit").click(function(e){
      e.preventDefault();
      var kode_barang     = $(this).attr("data-id");
      var kode_saldoawal_gl  = $(this).attr("data-kode");
      var nama_barang     = $(this).attr("data-nama");
      var qty             = $(this).attr("data-qty");
      var harga             = $(this).attr("data-harga");
      $("#kode_barang").val(kode_barang);
      $("#nama_barang").html(nama_barang);
      $("#kode_barang2").html(kode_barang);
      $("#kode_saldoawal_gl2").html(kode_saldoawal_gl);
      $("#qty").val(qty);
      $("#harga").val(harga);
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