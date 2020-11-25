<div class="container-fluid">
  <!-- Page title -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <h2 class="page-title">
          Data Kendaraaan
        </h2>
      </div>
    </div>
  </div>
  <!-- Content here -->
  <div class="row">
    <div class="col-md-10 col-xs-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Data Kendaraaan</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <a href="<?php echo base_url(); ?>kendaraan/input_kendaraan" class="btn btn-danger waves-effect"> Tambah Data </a>
            <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="mytable" style="font-size:12px">
              <thead class="thead-dark">
                <tr>
                  <th width="10px">No</th>
                  <th>No Polisi</th>
                  <th>Type / Merk</th>
                  <th>Model</th>
                  <th>Tahun</th>
                  <th>No Mesin</th>
                  <!-- <th>No Rangka</th> -->
                  <!-- <th>No STNK</th>
                  <th>Pajak</th>
                  <th>Atas Nama</th>
                  <th>Keur</th>
                  <th>No Uji</th>
                  <th>KIR</th>
                  <th>STNK</th>
                  <th>SIPA</th> -->
                  <!-- <th>Pemakai</th> -->
                  <!-- <th>Jabatan</th> -->
                  <th>Keterangan</th>
                  <th>Cabang</th>
                  <th>Status</th>
                  <?php if ($leveluser == "Administrator") { ?>
                    <th>Aksi</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($kendaraan as $b) {
                ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $b->no_polisi; ?></td>
                    <td><?php echo $b->type; ?></td>
                    <td><?php echo $b->model; ?></td>
                    <td><?php echo $b->tahun; ?></td>
                    <td><?php echo $b->no_mesin; ?></td>
                    <!-- <td><?php echo $b->no_rangka; ?></td> -->
                    <!-- <td><?php echo $b->no_stnk; ?></td>
                    <td><?php echo $b->pajak; ?></td>
                    <td><?php echo $b->atas_nama; ?></td>
                    <td><?php echo $b->keur; ?></td>
                    <td><?php echo $b->no_uji; ?></td>
                    <td><?php echo $b->kir; ?></td>
                    <td><?php echo $b->stnk; ?></td>
                    <td><?php echo $b->sipa; ?></td> -->
                    <!-- <td><?php echo $b->pemakai; ?></td> -->
                    <!-- <td><?php echo $b->jabatan; ?></td> -->
                    <td><?php echo $b->keterangan; ?></td>
                    <td><?php echo $b->nama_cabang; ?></td>
                    <td><?php echo $b->status; ?></td>
                    <?php if ($leveluser == "Administrator") { ?>
                      <td>
                        <a href="#" data-id="<?php echo $b->id; ?>" class="btn btn-primary  btn-sm waves-effect detail">Detail</a>
                        <a href="<?php echo base_url(); ?>kendaraan/edit_kendaraan/<?php echo $b->id;?>" class="btn btn-warning  btn-sm waves-effect edit">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm waves-effect hapus" data-href="<?php echo base_url("kendaraan/hapus/" . $b->id); ?>">Hapus</a>
                      </td>
                    <?php } ?>
                  </tr>
                <?php $no++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-xs-12">
      <?php $this->load->view('menu/menu_masterpenjualan'); ?>
    </div>
  </div>
</div>
<div class="modal modal-blur fade" id="detailkendaraan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
      </div>
      <div class="modal-body">
        <div class="modal-content">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function() {

    $(".detail").click(function() {
      $id = $(this).attr('data-id');
      $("#detailkendaraan").modal("show");
      $(".modal-content").load("<?php echo base_url(); ?>kendaraan/detail_kendaraan/" + $id);
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