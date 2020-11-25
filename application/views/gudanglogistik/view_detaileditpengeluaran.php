<?php
$no=1;
foreach($data->result() as $d){
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->keterangan; ?></td>
    <td><?php echo $d->qty; ?></td>
    <td align="right"><a href="#"  data-kodebarang="<?php echo $d->kode_barang; ?>" class="btn btn-danger btn-sm hapus">Hapus</a>
      <a href="#"  data-kodebarang="<?php echo $d->kode_barang; ?>" data-nama="<?php echo $d->nama_barang; ?>"  data-ket="<?php echo $d->keterangan; ?>" data-jenis="<?php echo $d->jenis_barang; ?>" data-qty="<?php echo $d->qty; ?>" class="btn btn-warning btn-sm edit">Edit</a></td>
    </td>
  </tr>
  <?php $no++;
} ?>
<script type="text/javascript">

  $(function(){

   function tampiltemp(){

    var nobukti     = $('#nobukti').val();
    $.ajax({
      type    : 'POST',
      url     : '<?php echo base_url();?>gudanglogistik/view_detaileditpengeluaran',
      data    : 
      {
        nobukti : nobukti
      },
      cache   : false,
      success : function(html){

        $("#loadpengeluaranbarang").html(html);

        $('#barang').val("");
        $('#kodeakun').val("");
        $('#kodebarang').val("");
        $('#namaakun').val("");
        $('#jumlah').val("");
        $('#harga').val("");
        $('#keterangan').val("");
        $('#jenisbarang').val("");

      }

    });
  }

  $(".hapus").click(function(e){
    var kodebarang  = $(this).attr("data-kodebarang");
    var ket         = $(this).attr("data-ket");
    var nobukti     = $('#nobukti').val();
    e.preventDefault();
    $.ajax({
      type    : 'POST',
      url     : '<?php echo base_url(); ?>gudanglogistik/hapus_detaileditpengeluaran',
      data    : {
        kodebarang  : kodebarang,
        ket         : ket,
        nobukti     : nobukti
      },
      cache   : false,
      success   : function(respond){

        tampiltemp();

      }
    });
  });


  $(".edit").click(function(e){
    e.preventDefault();
    var kodebarang  = $(this).attr("data-kodebarang");
    var qty       = $(this).attr("data-qty");
    var nama        = $(this).attr("data-nama");
    var jenis       = $(this).attr("data-jenis");
    var ket         = $(this).attr("data-ket");
    $('#kodebarang').val(kodebarang);
    $('#jumlah').val(qty);
    $('#keterangan').val(ket);
    $('#jenisbarang').val(jenis);
    $('#barang').val(nama);
    $('#kode_edit').val(1);
  });

});
</script>
