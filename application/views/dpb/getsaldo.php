<?php
  $no = 1;
  foreach ($detail as $b) {

    //RETUR
    $jmldus = floor($b->saldoakhir/ $b->isipcsdus);
    if($b->saldoakhir !=0 ){
      $sisadus   = $b->saldoakhir % $b->isipcsdus;
    }else{
      $sisadus = 0;
    }
    if($b->isipack == 0){
      $jmlpack    = 0;
      $sisapack   = $sisadus;
      $s          = "A";
    }else{
      $jmlpack    = floor($sisadus / $b->isipcs);
      $sisapack   = $sisadus % $b->isipcs;
      $s          = "B";
    }
    $jmlpcs = $sisapack;

    // echo $sisadus."-".$s."-".$sisapack."-".$jmlpcs."<br>";

?>
  <tr>
    <td style="width:10px"><?php echo $no; ?></td>
    <td style="width:200px">
      <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $b->kode_produk;?>">
      <input type="hidden" name="isipcsdus<?php echo $no; ?>" value="<?php echo $b->isipcsdus;?>">
      <input type="hidden" name="isipack<?php echo $no; ?>" value="<?php echo $b->isipack;?>">
      <input type="hidden" name="isipcs<?php echo $no; ?>" value="<?php echo $b->isipcs;?>">
      <?php echo $b->nama_barang; ?>
    </td>
    <td style="width:100px">
      <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
        <div class="form-line">
          <input type="text" style="text-align:right" value="<?php if(!empty($jmldus)){ echo $jmldus; } ?>" id="jmldus" name="jmldus<?php echo $no; ?>" class="form-control"  data-error=".errorTxt19" />
        </div>
      </div>
    </td>
    <td style="width:50px"><?php echo $b->satuan; ?></td>
    <td style="width:100px">
      <?php if(!empty($b->isipack)){ ?>
        <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
          <div class="form-line">
            <input type="text" style="text-align:right" value="<?php if(!empty($jmlpack)){ echo $jmlpack; } ?>" id="jmlpack" name="jmlpack<?php echo $no; ?>" class="form-control"  data-error=".errorTxt19" />
          </div>
        </div>
      <?php } ?>
    </td>
    <td style="width:50px">Pack</td>
    <td style="width:100px">
      <div class="input-group demo-masked-input" style="margin-bottom:0px; !important" >
        <div class="form-line">
          <input type="text" style="text-align:right" value="<?php if(!empty($jmlpcs)){ echo $jmlpcs; } ?>" id="jmlpcs" name="jmlpcs<?php echo $no; ?>" class="form-control"  data-error=".errorTxt19" />
        </div>
      </div>
    </td>
    <td style="width:50px">Pcs</td>
  </tr>
<?php
    $no++;
    $jumproduk = $no-1;
  }
?>
<input type="hidden" value ="<?php echo $jumproduk; ?>" name="jumproduk">
