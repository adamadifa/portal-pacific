<?php
function uang($nilai)
{
  return number_format($nilai, '2', ',', '.');
}
?>
<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Ledger
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Ledger</h4>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>keuangan/ledger" autocomplete="off">
            <div class="form-group mb-3">
              <select class="form-control show-tick" id="bank" name="bank" data-error=".errorTxt1">
                <option value="">Semua Bank</option>
                <?php foreach ($lbank as $b) { ?>
                  <option <?php if ($bank == $b->kode_bank) {
                            echo "selected";
                          } ?> value="<?php echo $b->kode_bank; ?>"><?php echo $b->nama_bank; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group mb-3">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-icon">
                    <input id="dari" type="date" value="<?php echo $dari; ?>" placeholder="Dari" class="form-control" name="dari" />
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

                <div class="col-md-6">
                  <div class="input-icon">
                    <input id="sampai" type="date" value="<?php echo $sampai; ?>" placeholder="Sampai" class="form-control" name="sampai" />
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
            <div class="mb-3 d-flex justify-content-end">
              <button type="submit" name="submit" class="btn btn-primary btn-block mr-2" value="1"><i class="fa fa-search mr-2"></i>CARI</button>
            </div>
          </form>
          <hr>
          <a href="#" class="btn btn-danger mb-3" id="inputledger"><i class="fa fa-plus mr-2"></i> Tambah Data </a>
          <div class="table-responsive">
            <table class="table table-striped table-hover" style="font-size:11px">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>Tgl</th>
                  <th>No Bukti</th>
                  <th>No Ref</th>
                  <th>TGL Penerimaan</th>
                  <th>Pelanggan</th>
                  <th>Keterangan</th>
                  <th>Kode Akun</th>
                  <th>Akun</th>
                  <th>Debet</th>
                  <th>Kredit</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $saldo = 0;
                foreach ($result as $d) {
                  if ($d['status_dk'] == 'K') {
                    $kredit = $d['jumlah'];
                    $debet  = 0;
                    $jumlah = $d['jumlah'];
                  } else {
                    $debet  = $d['jumlah'];
                    $kredit = 0;
                    $jumlah = -$d['jumlah'];
                  }
                  $saldo = $saldo + $jumlah;
                  if ($d['no_ref'] != "") {
                    if ($d['kategori'] == 'PMB') {
                      $color = "#e0f8fd";
                      $text = "black";
                    } else if ($d['kategori'] == 'PNJ') {
                      $color = "#fddaec";
                      $text = "black";
                    } else {
                      if (!empty($d['kode_cr'])) {
                        $color = "#e6d5ae";
                        $text = "";
                      } else {
                        $color = "";
                        $text = "";
                      }
                    }
                  } else {
                    if (!empty($d['kode_cr'])) {
                      $color = "#e6d5ae";
                      $text = "";
                    } else {
                      $color = "";
                      $text = "";
                    }
                  }
                ?>
                  <tr style="background-color:<?php echo $color;  ?>; color:<?php echo $text; ?>">
                    <td><?php echo $no; ?></td>
                    <td><?php echo $d['tgl_ledger']; ?></td>
                    <td><?php echo $d['no_bukti']; ?></td>
                    <td><?php echo $d['no_ref']; ?></td>
                    <td><?php echo $d['tgl_penerimaan']; ?></td>
                    <td><?php echo $d['pelanggan']; ?></td>
                    <td style="width:12%"><?php echo $d['keterangan']; ?></td>
                    <td><?php echo $d['kode_akun']; ?></td>
                    <td><?php echo $d['nama_akun']; ?></td>
                    <td align="right"><?php if ($debet != 0) {
                                        echo uang($debet);
                                      } ?></td>
                    <td align="right"><?php if ($kredit != 0) {
                                        echo uang($kredit);
                                      } ?></td>
                    <td>
                      <?php if (empty($d['kategori'])) { ?>
                        <a href="#" class="btn btn-primary btn-sm edit" data-nobukti="<?php echo $d['no_bukti']; ?>" data-kodecr="<?php echo $d['kode_cr']; ?>"><i class="fa fa-pencil"></i></a>
                        <a href="<?php echo base_url(); ?>keuangan/hapusledger/<?php echo $d['no_bukti']; ?>/<?php echo $d['kode_cr']; ?>" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash-o"></i></a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php $no++;
                } ?>
              </tbody>
            </table>
          </div>


        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_keuangan_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="ledger" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-full-width  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Input Ledger</h5>
      </div>
      <div class="modal-body">
        <div id="loadledger"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="editledger" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit Ledger</h5>
      </div>
      <div class="modal-body">
        <div id="loadeditledger"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr(document.getElementById('dari'), {});
    flatpickr(document.getElementById('sampai'), {});
  });
</script>
<script>
  $(function() {
    $("#inputledger").click(function(e) {
      e.preventDefault();
      $("#ledger").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $("#loadledger").load("<?php echo base_url(); ?>keuangan/ledger_input");
    });

    $('.hapus').on('click', function() {
      var getLink = $(this).attr('href');
      swal({
        title: 'Yakin di Hapus ?',
        text: 'Data Ini Akan Terhapus !',
        html: true,
        confirmButtonColor: '#d43737',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
      return false;
    });

    $(".edit").click(function(e) {
      e.preventDefault();
      $("#editledger").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      var nobukti = $(this).attr("data-nobukti");
      var kodecr = $(this).attr("data-kodecr");

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>keuangan/ledger_edit',
        data: {
          nobukti: nobukti,
          kodecr: kodecr
        },
        cache: false,
        success: function(respond) {
          $("#loadeditledger").html(respond);
        }
      });
    });
  })
</script>