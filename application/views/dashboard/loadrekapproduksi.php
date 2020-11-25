<?php
$no = 1;
foreach ($produksi as $d) {
?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $d->kode_produk; ?></td>
    <td align="right"><?php echo number_format($d->januari, '0', '', '.'); ?></td>
    <td align="right">
      <?php
      if ($d->februari > $d->januari) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->februari < $d->januari) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->februari, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->maret > $d->februari) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->maret < $d->februari) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->maret, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->april > $d->maret) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->april < $d->maret) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->april, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->mei > $d->april) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->mei < $d->april) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->mei, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->juni > $d->mei) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->juni < $d->mei) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->juni, '0', '', '.'); ?>
      </span>
    </td>

    <td align="right">
      <?php
      if ($d->juli > $d->juni) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->juli < $d->juni) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->juli, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->agustus > $d->juli) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->agustus < $d->juli) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->agustus, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->september > $d->agustus) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->september < $d->agustus) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->september, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->oktober > $d->september) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->oktober < $d->september) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->oktober, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->november > $d->oktober) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->november < $d->oktober) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>
        <?php echo number_format($d->november, '0', '', '.'); ?>
      </span>
    </td>
    <td align="right">
      <?php
      if ($d->desember > $d->november) {
        $color = "green";
        $icon = "fa-arrow-up";
      } else if ($d->desember < $d->november) {
        $color = "red";
        $icon = "fa-arrow-down";
      } else {
        $color = "blue";
        $icon = "fa-arrow-right";
      }
      ?>
      <span class="badge bg-<?php echo $color; ?>" style="margin-right:10px;">
        <i class="fa <?php echo $icon; ?> mr-2"></i>

        <?php echo number_format($d->desember, '0', '', '.'); ?>
      </span>
    </td>
  </tr>
<?php
  $no++;
}
?>