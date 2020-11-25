<?php 
$no     = 1; 
$total  = 0; 
foreach($detail->result() as $d){  
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_barang; ?></td>
    <td><?php echo $d->nama_barang; ?></td>
    <td><?php echo $d->jenis_barang; ?></td>
    <td align="center"><?php echo number_format($d->qty,'2',',','.'); ?></td>
    <td>
      <a href="#"  data-kodebarang="<?php echo $d->kode_barang; ?>" data-nama="<?php echo $d->nama_barang; ?>" data-jenis="<?php echo $d->jenis_barang; ?>"  data-qty="<?php echo $d->qty; ?>" class="btn btn-waring btn-sm edit">Edit</a>
    </td>
  </tr>
  <?php $no++; 
}  ?>

<script type="text/javascript">
  $(".edit").click(function(e){
    e.preventDefault();
    var kodebarang  = $(this).attr("data-kodebarang");
    var unit        = $(this).attr("data-unit");
    var qty         = $(this).attr("data-qty");
    var nama        = $(this).attr("data-nama");
    var jenis       = $(this).attr("data-jenis");
    $('#kode_barang2').html(kodebarang);
    $('#kode_barang').val(kodebarang);
    $('#qty').val(qty);
    $('#jenis_barang').html(jenis);
    $('#nama_barang').html(nama);
    $('#qty').focus();
  });
</script>