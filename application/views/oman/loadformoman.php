<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover" id="mytable">
    <thead class="thead-dark">
      <tr>
        <th width="10px" rowspan="3" style="vertical-align: middle;">No</th>
        <th rowspan="3" style="vertical-align: middle; text-align: center;">Produk</th>
        <th colspan="12" style="text-align: center">Jumlah Permintaan</th>
        <th rowspan="3" style="vertical-align: middle; width:10%">Total</th>
      </tr>
      <tr>
        <th colspan="3" style="text-align:center">M1</th>
        <th colspan="3" style="text-align:center">M2</th>
        <th colspan="3" style="text-align:center">M3</th>
        <th colspan="3" style="text-align:center">M4</th>
      </tr>
      <tr>
        <th style="width:60px">
          <div class="form-group">
            <div class="form-line">
              <input type="text" id="darim1" maxlength="2" name="darim1" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>
          </div>
        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th style="width:60px">
          <div class="form-group">
            <div class="form-line">
              <input type="text" id="sampaim1" maxlength="2" name="sampaim1" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>
          </div>
        </th>

        <!-- Minggu Ke 2 -->
        <th style="width:60px">
          <div class="form-group">

            <div class="form-line">
              <input type="text" id="darim2" maxlength="2" name="darim2" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>
          </div>

        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th style="width:60px">
          <div class="form-group">
            <div class="form-line">
              <input type="text" id="sampaim2" maxlength="2" name="sampaim2" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>
          </div>
        </th>

        <!-- Minggu Ke 3-->
        <th style="width:60px">
          <div class="form-group">
            <div class="form-line">
              <input type="text" id="darim3" maxlength="2" name="darim3" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>
          </div>
        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th style="width:60px">
          <div class="form-group">
            <div class="form-line">
              <input type="text" id="sampaim3" maxlength="2" name="sampaim3" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>
          </div>
        </th>
        <!-- Minggu Ke 4-->
        <th style="width:60px">
          <div class="form-group">
            <div class="form-line">
              <input type="text" id="darim4" maxlength="2" name="darim4" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>
          </div>

        </th>
        <th style="width:10px;vertical-align: middle;">
          s/d
        </th>
        <th style="width:60px">
          <div class="form-group">
            <div class="form-line">
              <input type="text" id="sampaim4" maxlength="2" name="sampaim4" style="color:black !important" class="form-control" data-error=".errorTxt4" />
            </div>

          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      foreach ($produk as $p) {

        $qm1    = "SELECT SUM(jumlah) as jumlah FROM detail_oman_cabang 
                  INNER JOIN oman_cabang ON detail_oman_cabang.no_order = oman_cabang.no_order
                  WHERE kode_produk ='$p->kode_produk' AND bulan = '$bulan' AND tahun ='$tahun' 
                  AND mingguke ='1'";
        $m1     =  $this->db->query($qm1)->row_array();

        $qm2    = "SELECT SUM(jumlah) as jumlah FROM detail_oman_cabang 
                  INNER JOIN oman_cabang ON detail_oman_cabang.no_order = oman_cabang.no_order
                  WHERE kode_produk ='$p->kode_produk' AND bulan = '$bulan' AND tahun ='$tahun' 
                  AND mingguke ='2'";
        $m2     =  $this->db->query($qm2)->row_array();

        $qm3    = "SELECT SUM(jumlah) as jumlah FROM detail_oman_cabang 
        INNER JOIN oman_cabang ON detail_oman_cabang.no_order = oman_cabang.no_order
        WHERE kode_produk ='$p->kode_produk' AND bulan = '$bulan' AND tahun ='$tahun' 
        AND mingguke ='3'";
        $m3     =  $this->db->query($qm3)->row_array();

        $qm4    = "SELECT SUM(jumlah) as jumlah FROM detail_oman_cabang 
        INNER JOIN oman_cabang ON detail_oman_cabang.no_order = oman_cabang.no_order
        WHERE kode_produk ='$p->kode_produk' AND bulan = '$bulan' AND tahun ='$tahun' 
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
          <td colspan="3">

            <div class="form-line">
              <input type="text" readonly id="jmlm1" name="jml<?php echo $no; ?>m1" class="form-control jmlm1" value="<?php if ($m1['jumlah'] != 0) {
                                                                                                                        echo $m1['jumlah'];
                                                                                                                      } ?>"" style=" text-align:right" />
            </div>


          </td>
          <td colspan="3">
            <div class="form-line">
              <input type="text" readonly id="jmlm2" name="jml<?php echo $no; ?>m2" class="form-control jmlm2" value="<?php if ($m2['jumlah'] != 0) {
                                                                                                                        echo $m2['jumlah'];
                                                                                                                      } ?>"" style=" text-align:right" />
            </div>
          </td>
          <td colspan="3">
            <div class="form-line">
              <input type="text" readonly id="jmlm3" name="jml<?php echo $no; ?>m3" class="form-control jmlm3" value="<?php if ($m3['jumlah'] != 0) {
                                                                                                                        echo $m3['jumlah'];
                                                                                                                      } ?>"" style=" text-align:right" />
            </div>
          </td>
          <td colspan="3">
            <div class="form-line">
              <input type="text" readonly id="jmlm4" name="jml<?php echo $no; ?>m4" class="form-control jmlm4" value="<?php if ($m4['jumlah'] != 0) {
                                                                                                                        echo $m4['jumlah'];
                                                                                                                      } ?>" style="text-align:right" />
            </div>
          </td>
          <td>
            <div class="form-line">
              <input type="text" readonly id="subtotal" value="<?php echo $subtotal; ?>" name="subtotal<?php echo $no; ?>" class="form-control subtotal" style="text-align:right" />
            </div>
          </td>

        </tr>
      <?php $no++;
        $jumproduk = $no - 1;
      } ?>
      <input type="hidden" value="<?php echo $jumproduk; ?>" name="jumproduk">
      <input type="hidden" name="status" id="status">

    </tbody>
  </table>
  <div class="mb-3 d-flex justify-content-end">
    <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-send mr-2"></i>Simpan</button>
  </div>
</div>