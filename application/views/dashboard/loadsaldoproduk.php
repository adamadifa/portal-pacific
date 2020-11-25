<?php
function uang($nilai){
  return number_format($nilai,'2',',','.');
}
?>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Cabang</th>
      <th>Buffer Stok</th>
      <th>Stok</th>
    </tr>
  </thead>

<?php
foreach ($saldo as $r){
  if($r->saldoakhir <= 0){
    $color = "bg-red";
  }else{
    $color = "bg-green";
  }
 ?>
  <tr>
    <td><?php echo $r->nama_cabang; ?></td>
    <td align="right"><span class="badge bg-blue"><?php echo number_format($r->buffer/$isipcsdus,'2',',','.'); ?></span></td>
    <td align="right">
      <?php if(!empty($r->sabulanlalu)){ ?>
      <span class="badge <?php echo $color; ?>"><?php echo number_format($r->saldoakhir/$isipcsdus,'2',',','.'); ?>
      </span>
      <?php }else{ ?>
        <span class="badge bg-orange">Saldo Awal Belum di Setting
        </span>
      <?php } ?>
    </td>
  </tr>
<?php } ?>
</table>
