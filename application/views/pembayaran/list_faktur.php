<div class="container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Histori Data Penjualan
        </h2>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10">
      <div class="row">
        <div class="col-md-12">
          <!-- Content here -->
          <div class="row">
            <div class="col-md-6 col-xs-6">
              <div class="card d-flex flex-column">
                <?php
                if (!empty($pel['foto'])) {
                  $foto = $pel['foto'];
                } else {
                  $foto = "default.jpg";
                }
                //echo $d['foto'];
                ?>
                <a href="#">
                  <img class="card-img-top" src="<?php echo base_url(); ?>upload/toko/<?php echo $foto; ?>" alt="And this isn&#39;t my nose. This is a false one.">
                </a>
                <div class="card-body d-flex flex-column">
                  <table class="table">
                    <tr>
                      <td><b>Kode Pelanggan</b></td>
                      <td></td>
                      <td><?php echo $pel['kode_pelanggan']; ?></td>
                    </tr>
                    <tr>
                      <td><b>Nama Pelanggan</b></td>
                      <td></td>
                      <td><?php echo $pel['nama_pelanggan']; ?></td>
                    </tr>
                    <tr>
                      <td><b>Alamat</b></td>
                      <td></td>
                      <td><?php echo $pel['alamat_pelanggan']; ?></td>
                    </tr>
                    <tr>
                      <td><b>HP</b></td>
                      <td></td>
                      <td><?php echo $pel['no_hp']; ?></td>
                    </tr>
                    <tr>
                      <td><b>Pasar</b></td>
                      <td></td>
                      <td><?php echo $pel['pasar']; ?></td>
                    </tr>
                    <tr>
                      <td><b>Hari</b></td>
                      <td></td>
                      <td><?php echo $pel['hari']; ?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-sm">
                    <div class="card-body d-flex align-items-center">
                      <span class="bg-blue text-white stamp mr-3" style="height:9rem !important; min-width:8rem !important ">
                        <i class="fa f fa-shopping-cart" style="font-size: 4rem;"></i>
                      </span>
                      <div class="ml-3 lh-lg">
                        <div class="strong" style="font-size: 3rem;" id="grandtotal">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- Content here -->
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Histori Data Penjualan</h4>
                </div>
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>laporanpenjualan/exporthistori/<?php echo $pel['kode_pelanggan'];  ?>" class="btn btn-success mb-2"><i class="fa fa-download mr-2"></i>Export Excel</a>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="mytable">
                      <thead class="thead-dark">
                        <tr>
                          <th>No Faktur</th>
                          <th>Tanggal</th>
                          <th>Piutang</th>
                          <th>Jml Bayar</th>
                          <th>Sisa Bayar</th>
                          <th>Salesman</th>
                          <th>Ket</th>
                          <th>Aksi</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $totalallpiutang    = 0;
                        $totalallbayar      = 0;
                        $totalallsisabayar  = 0;
                        foreach ($pmb as $p) {

                          if ($p->sisabayar == 0) {
                            $color = "bg-green";
                            $ket   = "LUNAS";
                          } else {

                            $color = "bg-red";
                            $ket   = "BELUM LUNAS";
                          }

                          $totalallpiutang    = $totalallpiutang + $p->totalpiutang;
                          $totalallbayar      = $totalallbayar + $p->totalbayar;

                          $totalallsisabayar  = $totalallsisabayar + $p->sisabayar;

                          $cekretur = $this->db->get_where('retur', array('no_fak_penj' => $p->no_fak_penj));
                          $retur    = $cekretur->num_rows();
                        ?>
                          <tr>
                            <td><a href="<?php echo base_url(); ?>penjualan/detailfaktur/<?php echo $p->no_fak_penj; ?>"><?php echo $p->no_fak_penj; ?></a></td>
                            <td><?php echo $p->tgltransaksi; ?></td>
                            <td align="right"><?php echo  number_format($p->totalpiutang, '0', '', '.'); ?></td>
                            <td align="right"><?php echo  number_format($p->totalbayar, '0', '', '.'); ?></td>
                            <td align="right"><?php echo  number_format($p->sisabayar, '0', '', '.'); ?></td>

                            <td><?php echo ucwords($p->nama_karyawan); ?></td>
                            <td><span class="badge <?php echo $color ?>"><?php echo $ket; ?></span></td>
                            <td>
                              <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url(); ?>penjualan/hapus/<?php echo $p->no_fak_penj; ?>/<?php echo $pel['kode_pelanggan']; ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                          </tr>
                        <?php } ?>

                      </tbody>
                      <tr>
                        <td colspan="2"><b>TOTAL</b></td>
                        <td align="right" id="totalpiutang"><b><?php echo  number_format($totalallpiutang, '0', '', '.'); ?></b></td>
                        <td align="right"><b><?php echo  number_format($totalallbayar, '0', '', '.'); ?></b></td>
                        <td align="right"><b><?php echo  number_format($totalallsisabayar, '0', '', '.'); ?></b></td>
                        <td colspan="5"></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <?php $this->load->view('menu/menu_penjualan_administrator'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-title">
          Yakin Untuk Di Hapus ?
        </div>
        <div>Jika Di Hapus, Kamu Akan Kehilangan Data Ini !</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete">Yes, Hapus !</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function() {

    $('#mytable').DataTable({
      responsive: true,
      "order": [
        [1, "desc"]
      ]
    });

    function loadTotal() {
      $("#grandtotal").text($("#totalpiutang").text());
    }
    $(".hapus").click(function(e) {
      e.preventDefault();
      var href = $(this).attr("data-href");
      //alert(href);
      $("#hapusdata").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      $(".delete").attr("href", href);
    });
    loadTotal();
  });
</script>