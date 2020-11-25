<?php
error_reporting(0);
$no = 1;
if(!empty($cek)){
  foreach ($detail as $b) {

      $qty_berat     = $b->qtyberatsa + $b->qtypemb2 + $b->qtylainnya2 - $b->qtyprod4 - $b->qtyseas4 - $b->qtypdqc4 - $b->qtylain4 - $b->qtysus4;
      $qty_unit      = $b->qtyunitsa + $b->qtypemb1 + $b->qtylainnya1 - $b->qtyprod3 - $b->qtyseas3 - $b->qtypdqc3 - $b->qtylain3 - $b->qtysus3;

    ?>
    <tr>
      <td style="width:10px"><?php echo $no; ?></td>
      <td>
        <input type="hidden" name="kode_barang<?php echo $no; ?>" value="<?php echo $b->kode_barang;?>">
        <?php echo $b->nama_barang; ?>
      </td>
      <td style="width:100px">
        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
          <div class="form-line">
            <input type="text" style="text-align:right" value="<?php if(!empty($qty_unit)){ echo $qty_unit; } ?>" id="qty_unit" name="qty_unit<?php echo $no; ?>" class="form-control rupiah"  data-error=".errorTxt19" />
          </div>
        </div>
      </td>
      <td style="width:100px">
        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
          <div class="form-line">
            <input type="text" style="text-align:right" value="<?php if(!empty($qty_berat)){ echo $qty_berat; } ?>" id="qty_berat" name="qty_berat<?php echo $no; ?>" class="form-control rupiah"  data-error=".errorTxt19" />
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

      $qty_berat     = $b->qtyberatsa + $b->qtypemb2 + $b->qtylainnya2 - $b->qtyprod4 -$b->qtyseas4 - $b->qtypdqc4 - $b->qtylain4 - $b->qtysus4;
      $qty_unit      = $b->qtyunitsa + $b->qtypemb1 + $b->qtylainnya1 - $b->qtyprod3 -$b->qtyseas3 - $b->qtypdqc3 - $b->qtylain3 - $b->qtysus3;

    ?>
    <tr>
      <td style="width:10px"><?php echo $no; ?></td>
      <td>
        <input type="hidden" name="kode_barang<?php echo $no; ?>" value="<?php echo $b->kode_barang;?>">
        <?php echo $b->nama_barang; ?>
      </td>
      <td style="width:100px">
        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
          <div class="form-line">
            <input type="text" style="text-align:right" value="<?php if(!empty($qty_unit)){ echo $qty_unit; } ?>" id="qty_unit" name="qty_unit<?php echo $no; ?>" class="form-control rupiah"  data-error=".errorTxt19" />
          </div>
        </div>
      </td>
      <td style="width:100px">
        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
          <div class="form-line">
            <input type="text" style="text-align:right" value="<?php if(!empty($qty_berat)){ echo $qty_berat; } ?>" id="qty_berat" name="qty_berat<?php echo $no; ?>" class="form-control rupiah"  data-error=".errorTxt19" />
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