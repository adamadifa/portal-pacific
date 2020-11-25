<?php
if(!empty($pelanggan['foto'])){
  $foto = $pelanggan['foto'];
}else{
  $foto = "default.jpg";
}
//echo $foto;
?>


<img src="<?php echo base_url(); ?>upload/toko/<?php echo $foto; ?>" alt="" width="200px" height="200px">