<div class="container-fluid">
    <!-- Page title -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <h2 class="page-title">
                    Data Cabang
                </h2>
            </div>
        </div>
    </div>
    <!-- Content here -->
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input Cabang</h4>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="cabangForm" method="POST" action="<?php echo base_url(); ?>cabang/insert_cabang">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Kode Cabang</label>
                                <div class="form-group">
                                    <input type="text" <?php if (!empty($getcabang['kode_cabang'])) {
                                                            echo "readonly";
                                                        } ?> value="<?php echo $getcabang['kode_cabang']; ?>" id="kodecabang" name="kodecabang" class="form-control" placeholder="Kode Cabang">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Nama Cabang</label>
                                <div class="form-group">
                                    <input type="text" value="<?php echo $getcabang['nama_cabang']; ?>" id="namacabang" name="namacabang" class="form-control" placeholder="Nama Cabang">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Alamat Cabang</label>
                                <div class="form-group">
                                    <input type="text" value="<?php echo $getcabang['alamat_cabang']; ?>" id="alamatcabang" name="alamatcabang" class="form-control" placeholder="Alamat Cabang">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Alamat Cabang</label>
                                <div class="form-group">
                                    <input type="text" value="<?php echo $getcabang['telepon']; ?>" id="teleponcabang" name="teleponcabang" class="form-control" placeholder="Telepon Cabang">
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" name="simpan" class="btn btn-primary" value="1"><i class="fa fa-save mr-2"></i>SIMPAN</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Cabang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kode Cabang</th>
                                    <th>Nama Cabang</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cabang as $c) { ?>
                                    <tr>
                                        <td><?php echo $c->kode_cabang; ?></td>
                                        <td><?php echo $c->nama_cabang; ?></td>
                                        <td><?php echo $c->alamat_cabang; ?></td>
                                        <td><?php echo $c->telepon; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('cabang/view_cabang/' . $c->kode_cabang); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm hapus" data-href="<?php echo base_url("cabang/hapus/" . $c->kode_cabang); ?>"><i class="fa fa-trash-o"></i></a>
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
<div class="modal modal-blur fade" id="hapusdata" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                   Yakin Untuk Di Hapus ?
                </div>
                <div>Data Akan Terhapus !</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary mr-auto" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger delete">Yes, delete</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.cabangForm').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                kodecabang: {

                    validators: {
                        notEmpty: {
                            message: 'Kode Cabang Harus Diisi !'
                        }


                    }
                },

                namacabang: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Cabang Harus Diisi !'
                        }


                    }
                },

                alamatcabang: {
                    validators: {
                        notEmpty: {
                            message: 'Alamat Cabang Harus Diisi !'
                        }


                    }
                },

                teleponcabang: {
                    validators: {
                        notEmpty: {
                            message: 'Telepon Cabang Harus Diisi !'
                        }


                    }
                },
            }
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

    });
</script>