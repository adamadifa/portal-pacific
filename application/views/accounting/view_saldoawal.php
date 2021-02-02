<?php
function uang($nilai)
{
  return number_format($nilai, '0', '', '.');
}
?>

<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          DATA SALDOAWAL
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">DATA SALDOAWAL</h4>

        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>accounting/view_saldoawal" autocomplete="off">
            <div class="mb-3">
              <input type="text" value="<?php echo $kode_saldoawal_bb; ?>" id="kode_saldoawal_bb" name="kode_saldoawal_bb" class="form-control" placeholder="Kode Saldoawal" data-error=".errorTxt19" />
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-12">
                  <div class="input-icon">
                    <input type="text" value="<?php echo $tanggal; ?>" id="tanggal" name="tanggal" class="datepicker form-control date" placeholder="Tanggal" data-error=".errorTxt19" />
                    <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <rect x="4" y="5" width="16" height="16" rx="2" />
                        <line x1="16" y1="3" x2="16" y2="7" />
                        <line x1="8" y1="3" x2="8" y2="7" />
                        <line x1="4" y1="11" x2="20" y2="11" />
                        <line x1="11" y1="15" x2="12" y2="15" />
                        <line x1="12" y1="15" x2="12" y2="18" /></svg>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <select class="form-control selectoption" id="bulan" name="bulan">
                <option value="">Semua Bulan</option>
                <?php for ($a = 1; $a <= 12; $a++) { ?>
                  <option <?php if ($a == $bulan) {
                            echo "selected";
                          } ?> value="<?php echo $a;  ?>"><?php echo $bulans[$a]; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <select class="form-control selectoption" id="tahun" name="tahun">
                <option value="">Semua Tahun</option>
                <?php for ($t = 2019; $t <= $tahuns; $t++) { ?>
                  <option <?php if ($t == $tahun) {
                            echo "selected";
                          } ?> value="<?php echo $t;  ?>"><?php echo $t; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3 d-flex justify-content-end">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <a href="<?php echo base_url(); ?>accounting/input_saldoawal" class="btn btn-danger mb-3">Tambah Data</a>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="datatable">
              <thead class="thead-dark">
                <tr>
                  <th width="10px">No</th>
                  <th width="150px">No Bukti</th>
                  <th>Tanggal</th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th width="190px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no  = $row + 1;
                foreach ($result as $d) {
                  $kode_saldoawal_bb = str_replace("/", ".", $d['kode_saldoawal_bb']);
                ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $d['kode_saldoawal_bb']; ?></td>
                    <td><?php echo DateToIndo2($d['tanggal']); ?></td>
                    <td><?php echo $d['bulan']; ?></td>
                    <td><?php echo $d['tahun']; ?></td>
                    <td>
                      <!-- <a href="#" data-kode_saldoawal_bb="<?php echo $d['kode_saldoawal_bb']; ?>" class="btn btn-sm btn-primary detail">Detail</a> -->
                      <a href="#" data-href="<?php echo base_url(); ?>accounting/hapussaldoawal/<?php echo $kode_saldoawal_bb; ?>" class="btn btn-sm btn-danger hapus">Hapus</a>
                      <a href="<?php echo base_url(); ?>accounting/input_detailsaldoawal/<?php echo $kode_saldoawal_bb; ?>" class="btn btn-sm btn-primary">Detail / Input</a>
                    </td>
                  </tr>
                <?php
                  $no++;
                }
                ?>
              </tbody>
            </table>
            <div style='margin-top: 10px;'>
              <?php echo $pagination; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_accounting_administrator.php'); ?>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="detailsaldoawal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Detail</h5>
      </div>
      <div class="modal-body">
        <div id="loaddetailsaldoawal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('tanggal'), {});
  });
</script>

<script type="text/javascript">
  $(function() {

    $('.detail').click(function(e) {
      e.preventDefault();
      var kode_saldoawal_bb = $(this).attr('data-kode_saldoawal_bb');
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>accounting/detail_saldoawal',
        data: {
          kode_saldoawal_bb: kode_saldoawal_bb
        },
        cache: false,
        success: function(respond) {
          $("#loaddetailsaldoawal").html(respond);
          $("#detailsaldoawal").modal("show");
        }
      });
    });

    $(".hapus").click(function(e) {
      e.preventDefault();
      var getLink = $(this).attr('data-href');
      swal({
        title: 'Alert',
        text: 'Hapus Data ?',
        html: true,
        confirmButtonColor: '#d43737',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
    });

  });
</script>