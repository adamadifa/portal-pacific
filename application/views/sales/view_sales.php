<div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <h2 class="page-title">
                    Data Sales
                </h2>
            </div>
        </div>
    </div>
    <!-- Content here -->
    <div class="row">
        <div class="col-md-10 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Sales</h4>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-danger mb-2" id="tambahsales"> <i class="fa fa-plus mr-2"></i> Tambah Data </a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID Sales</th>
                                    <th>Salesman</th>
                                    <th>No HP</th>
                                    <th>Cabang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales as $s) { ?>
                                    <tr>
                                        <td><?php echo $s->id_karyawan; ?></td>
                                        <td><?php echo strtoupper($s->nama_karyawan); ?></td>
                                        <td><?php echo $s->no_hp; ?></td>
                                        <td><?php echo strtoupper($s->nama_cabang); ?></td>
                                        <td>
                                            <a href="#" data-id="<?php echo $s->id_karyawan; ?>" class="btn btn-primary btn-sm edit"><i class="fa fa-pencil"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url("sales/hapus/" . $s->id_karyawan); ?>"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
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
<div class="modal modal-blur fade" id="inputsales" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title"><div class="title"></div></h5>
            </div>
            <div class="modal-body">
                <div class="body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white mr-auto" data-dismiss="modal">Close</button>
            </div>
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
<script>
    $(function() {
        $("#tambahsales").click(function() {
            $("#inputsales").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            $(".title").text("Input Data Sales");
            $(".body").load("<?php echo base_url(); ?>sales/inputsales");

        });

        $(".edit").click(function() {
            var id = $(this).attr("data-id");
            $("#inputsales").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            $(".title").text("Edit Data Sales");
            $(".body").load("<?php echo base_url(); ?>sales/inputsales/" + id);

        });

        $(".hapus").click(function() {
            var href = $(this).attr("data-href");
            //alert(href);
            $("#hapusdata").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            $(".delete").attr("href", href);
        });
        $('#mytable').DataTable({
            responsive: true
        });

    });
</script>