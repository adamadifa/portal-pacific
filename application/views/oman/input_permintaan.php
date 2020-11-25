<?php

function uang($nilai)
{

  return number_format($nilai, '0', '', '.');
}

$bulan  = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novemer", "Desember");

?>
<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          INPUT PERMINTAAN PRODUKSI
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="row">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Input Permintaan Produksi </h4>
          </div>
          <div class="card-body">
            <form name="autoSumForm" autocomplete="off" class="formValidate" id="formValidate" method="POST" action="<?php echo base_url(); ?>oman/input_permintaan">
              <div class="row">
                <div class="col-md-5">
                  <table class="table table-striped table-hover">
                    <tr>
                      <td><b>No Order</b></td>
                      <td>:</td>
                      <td>
                        <?php echo $oman['no_order']; ?>
                        <input type="hidden" name="no_order" value="<?php echo $oman['no_order']; ?>">
                      </td>
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
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-barcode"></i>
                    </span>
                    <input type="text" value="<?php echo $no_permintaan; ?>" readonly id="no_permintaan" name="no_permintaan" class="form-control" data-error=".errorTxt4" placeholder="No Permintaan Produksi" />
                  </div>
                </div>
                <div class="mb-3">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fa fa-calendar-o"></i>
                    </span>
                    <input type="text" value="<?php echo date('Y-m-d'); ?>" id="tgl_permintaan" name="tgl_permintaan" class="form-control" data-error=".errorTxt4" placeholder="Tanggal Order" />
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover" id="mytable">
                    <thead class="thead-dark">
                      <tr>
                        <th width="10px" style="vertical-align: middle;">No</th>
                        <th style="text-align: left !important; text-align: center;">Produk</th>
                        <th style="text-align: right !important">OMAN MKT</th>
                        <th style="text-align: right !important">Stok Gudang</th>
                        <th style="text-align:right !important;vertical-align: middle;">Total</th>
                        <th style="text-align: center">Buffer Stok</th>
                        <th style="text-align: center">Grand Total</th>
                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($produk as $p) {

                        $qtotalmkt  = "SELECT SUM(jumlah) as jumlah FROM detail_oman 
                                                            WHERE kode_produk ='$p->kode_produk' AND no_order = '$no_order'
                                                            GROUP BY kode_produk";
                        $totalmkt   =  $this->db->query($qtotalmkt)->row_array();

                        $qstokgudang = "SELECT 
                                                            SUM(IF(`inout`='IN' AND d.kode_produk='$p->kode_produk',jumlah,0)) -  
                                                            SUM(IF(`inout`='OUT' AND d.kode_produk='$p->kode_produk',jumlah,0))  as saldoakhir
                                                            FROM detail_mutasi_gudang d 
                                                            INNER JOIN mutasi_gudang_jadi m 
                                                            ON d.no_mutasi_gudang = m.no_mutasi_gudang";
                        $stokgudang = $this->db->query($qstokgudang)->row_array();
                      ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td>
                            <input type="hidden" name="kode_produk<?php echo $no; ?>" value="<?php echo $p->kode_produk; ?>">
                            <b><?php echo $p->nama_barang; ?></b>
                          </td>
                          <td align="right">
                            <?php echo uang($totalmkt['jumlah']);  ?>
                            <input type="hidden" name="oman_mkt<?php echo $no; ?>" value="<?php echo $totalmkt['jumlah']; ?>">
                          </td>
                          <td align="right">
                            <?php echo uang($stokgudang['saldoakhir']);  ?>
                            <input type="hidden" name="stok_gudang<?php echo $no; ?>" value="<?php echo $stokgudang['saldoakhir']; ?>">
                          </td>
                          <td align="right">
                            <?php echo uang($totalmkt['jumlah'] - $stokgudang['saldoakhir']);  ?>
                            <input type="hidden" id="totalpermintaan" class="totalpermintaan" name="totalpermintaan<?php echo $no; ?>" value="<?php echo $totalmkt['jumlah'] - $stokgudang['saldoakhir']; ?>">
                          </td>
                          <td style="width:120px">

                            <div class="form-line">
                              <input type="text" id="bufferstok" name="bufferstok<?php echo $no; ?>" class="form-control bufferstok" style="text-align:right" />
                            </div>

                          </td>
                          <td style="width:120px">

                            <div class="form-line">
                              <input type="text" readonly id="subtotal" name="subtotal<?php echo $no; ?>" class="form-control subtotal" style="text-align:right" />
                            </div>

                          </td>

                        </tr>
                      <?php $no++;
                        $jumproduk = $no - 1;
                      } ?>
                      <input type="hidden" value="<?php echo $jumproduk; ?>" name="jumproduk">

                    </tbody>
                  </table>
                </div>
                <div class="row ">
                  <div class="form-group">
                    <div class="d-flex justify-content-end">
                      <button type="submit" name="submit" class="btn btn-primary btn-block" value="1"><i class="fa fa-send mr-2"></i>SIMPAN</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  flatpickr(document.getElementById('tgl_permintaan'), {});
</script>
<script type="text/javascript">
  $(function() {

    var $tblrows = $("#mytable tbody tr");
    $tblrows.each(function(index) {
      var $tblrow = $(this);


      $tblrow.find('.bufferstok').on('input', function() {
        var totalpermintaan = $tblrow.find("[id=totalpermintaan]").val();
        var bufferstok = $tblrow.find("[id=bufferstok]").val();


        if (totalpermintaan.length === 0) {

          var totalpermintaan = 0;

        } else {
          var totalpermintaan = parseInt(totalpermintaan);
        }
        if (bufferstok.length === 0) {

          var bufferstok = 0;

        } else {
          var bufferstok = parseInt(bufferstok);
        }

        var subTotal = totalpermintaan + bufferstok;


        if (!isNaN(subTotal)) {

          $tblrow.find('.subtotal').val(subTotal);
          var grandTotal = 0;
          $(".subtotal").each(function() {
            var stval = parseInt($(this).val());
            grandTotal += isNaN(stval) ? 0 : stval;
          });

          //$('.grdtot').val(grandTotal.toFixed(2));
        }

      });

    });

  });
</script>