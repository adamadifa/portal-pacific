
<?php
error_reporting(0);
$no = 1;
foreach ($detail as $b) {
  echo number_format($b->qtypemasukan - $b->qtypengeluaran,2);
}
?>