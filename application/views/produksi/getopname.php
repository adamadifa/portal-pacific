<?php
error_reporting(0);
$no = 1;
if(!empty($cek)){
  foreach ($detail as $b) {

    $qty = $b->saldoawal + $b->gudang + $b->seasoning + $b->trial - $b->pemakaian - $b->retur - $b->lainnya;
    
    ?>
    <tr>
      <td style="width:10px"><?php echo $no; ?></td>
      <td>
        <input type="hidden" name="kode_barang<?php echo $no; ?>" value="<?php echo $b->kode_barang;?>">
        <?php echo $b->kode_barang; ?>
      </td>
      <td>
        <?php echo $b->nama_barang; ?>
      </td>
      <td style="width:100px">
        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
          <div class="form-line">
            <input type="text" style="text-align:right" value="<?php if(!empty($qty)){ echo $qty; } ?>" id="qty" name="qty<?php echo $no; ?>" class="form-control rupiah"  data-error=".errorTxt19" />
          </div>
        </div>
      </td>
    </tr>
    <?php
    $no++;
    $jumproduk = $no-1;
  }
}else{
  foreach ($detail as $b) {

    $qty = $b->saldoawal + $b->gudang + $b->seasoning + $b->trial - $b->pemakaian - $b->retur - $b->lainnya;

    ?>
    <tr>
      <td style="width:10px"><?php echo $no; ?></td>
      <td>
        <input type="hidden" name="kode_barang<?php echo $no; ?>" value="<?php echo $b->kode_barang;?>">
        <?php echo $b->kode_barang; ?>
      </td>
      <td>
        <?php echo $b->nama_barang; ?>
      </td>
      <td style="width:100px">
        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
          <div class="form-line">
            <input type="text" style="text-align:right" value="<?php if(!empty($qty)){ echo $qty; } ?>" id="qty" name="qty<?php echo $no; ?>" class="form-control rupiah"  data-error=".errorTxt19" />
          </div>
        </div>
      </td>
    </tr>
    <?php
    $no++;
    $jumproduk = $no-1;
  }
}
?>
<tr>
  <td colspan="4" hidden=""><input type="text" name="jumproduk" id="jumproduk" value="<?php echo $jumproduk; ?>"></td>
</tr>
<script type="text/javascript">

  $(function(){

    function formatAngka(angka) {
      if (typeof(angka) != 'string') angka = angka.toString();
      var reg = new RegExp('([0-9]+)([0-9]{3})');
      while(reg.test(angka)) angka = angka.replace(reg, '$1,$2');
      return angka;
    }

    var jumproduk     = $('#jumproduk').val();
    $('#jumlahproduk').val(jumproduk*1);



  });
</script>