<div class="table-responsive">
  <?php

  function uang($nilai)
  {

    return number_format($nilai, '0', '', '.');
  }

  $qmk1   = "SELECT * FROM detail_oman_cabang 
                   WHERE no_order = '$oman[no_order]' AND mingguke ='1'";
  $mk1    =  $this->db->query($qmk1)->row_array();

  $qmk2    = "SELECT * FROM detail_oman_cabang 
                    WHERE no_order = '$oman[no_order]' AND mingguke ='2'";
  $mk2     =  $this->db->query($qmk2)->row_array();

  $qmk3    = "SELECT * FROM detail_oman_cabang 
                    WHERE  no_order = '$oman[no_order]' AND mingguke ='3'";
  $mk3     =  $this->db->query($qmk3)->row_array();
  $qmk4    = "SELECT * FROM detail_oman_cabang 
                    WHERE no_order = '$oman[no_order]'  AND mingguke ='4'";
  $mk4     =  $this->db->query($qmk4)->row_array();

  $bulan  = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");
  ?>
  <table class="table table-striped table-hover" style="width: 50%">
    <tr>
      <td><b>No Order</b></td>
      <td>:</td>
      <td><?php echo $oman['no_order']; ?></td>
    </tr>
    <tr>
      <td><b>Bulan</b></td>
      <td>:</td>
      <td><?php echo $bulan[$oman['bulan']]; ?></td>
    </tr>
    <tr>
      <td><b>Tahun</b></td>
      <td>:</td>
      <td><?php echo $oman['tahun']; ?></td>
    </tr>
    <tr>
      <td><b>Cabang</b></td>
      <td>:</td>
      <td><?php echo $oman['kode_cabang']; ?></td>
    </tr>
  </table>
  <table class="table table-bordered table-striped table-hover" id="mytable">
    <thead class="thead-dark">
      <tr>
        <th width="10px" rowspan="3" style="vertical-align: middle;">No</th>
        <th rowspan="3" style="vertical-align: middle; text-align: center;">Produk</th>
        <th colspan="12" style="text-align: center">Jumlah Permintaan</th>
        <th rowspan="3" style="vertical-align: middle;">Total</th>
      </tr>
      <tr>
        <th colspan="3" style="text-align:center">M1</th>
        <th colspan="3" style="text-align:center">M2</th>
        <th colspan="3" style="text-align:center">M3</th>
        <th colspan="3" style="text-align:center">M4</th>
      </tr>
      <tr>
        <th>
          <?php echo substr($mk1['dari'], 8, 2); ?>
        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th>
          <?php echo substr($mk1['sampai'], 8, 2); ?>
        </th>

        <!-- Minggu Ke 2 -->
        <th>
          <?php echo substr($mk2['dari'], 8, 2); ?>
        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th>
          <?php echo substr($mk2['sampai'], 8, 2); ?>
        </th>

        <!-- Minggu Ke 3-->
        <th>
          <?php echo substr($mk3['dari'], 8, 2); ?>
        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th>
          <?php echo substr($mk3['sampai'], 8, 2); ?>
        </th>
        <!-- Minggu Ke 4-->
        <th>
          <?php echo substr($mk4['dari'], 8, 2); ?>

        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th>
          <?php echo substr($mk4['sampai'], 8, 2); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php


      $no = 1;
      foreach ($produk as $p) {

        $qm1    = "SELECT * FROM detail_oman_cabang 
                                   WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                   AND mingguke ='1'";
        $m1     =  $this->db->query($qm1)->row_array();

        $qm2    = "SELECT * FROM detail_oman_cabang 
                                    WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                    AND mingguke ='2'";
        $m2     =  $this->db->query($qm2)->row_array();

        $qm3    = "SELECT * FROM detail_oman_cabang 
                                    WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                    AND mingguke ='3'";
        $m3     =  $this->db->query($qm3)->row_array();

        $qm4    = "SELECT * FROM detail_oman_cabang 
                                    WHERE kode_produk ='$p->kode_produk' AND no_order = '$oman[no_order]'
                                    AND mingguke ='4'";
        $m4     =  $this->db->query($qm4)->row_array();

        $subtotal = $m1['jumlah'] + $m2['jumlah'] + $m3['jumlah'] + $m4['jumlah'];

      ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td>
            <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $p->kode_produk; ?>">
            <b><?php echo $p->nama_barang; ?></b>
          </td>
          <td colspan="3" align="right">

            <?php echo uang($m1['jumlah']); ?>


          </td>
          <td colspan="3" align="right">
            <?php echo uang($m2['jumlah']); ?>
          </td>
          <td colspan="3" align="right">
            <?php echo uang($m3['jumlah']); ?>
          </td align="right">
          <td colspan="3" align="right">
            <?php echo uang($m4['jumlah']); ?>
          </td>
          <td align="right">
            <?php echo uang($subtotal); ?>
          </td>

        </tr>
      <?php $no++;
        $jumproduk = $no - 1;
      } ?>
      <input type="hidden" value="<?php echo $jumproduk; ?>" name="jumproduk">
      <input type="hidden" name="status" id="status">
      <input type="hidden" name="no_order" value="<?php echo $oman['no_order']; ?>">
    </tbody>
  </table>

</div>