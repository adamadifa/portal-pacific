<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>CV Pacific | 2018</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="<?php echo base_url(); ?>assets/css/font2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font3.css" rel="stylesheet">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <!-- Colorpicker Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/multi-select/css/multi-select.css" rel="stylesheet">

    <!-- Bootstrap Spinner Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">

    <!-- Bootstrap Tagsinput Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Sweetalert Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />
    <style>
        #notifikasi {
            cursor: pointer;
            position: fixed;
            right: 0px;
            z-index: 9999;
            bottom: 0px;
            margin-bottom: 22px;
            margin-right: 15px;
            min-width: 300px;
            max-width: 800px;
        }

        .form-group div.error {
            position: relative;
            top: 1rem;
            left: 0rem;
            font-size: 12px;
            color: #FF4081;
            -webkit-transform: translateY(0%);
            -ms-transform: translateY(0%);
            -o-transform: translateY(0%);
            transform: translateY(0%);
        }

        .form-group label.active {
            width: 100%;
        }

        .input-group div.error {
            position: relative;
            top: 1rem;
            left: 0rem;
            font-size: 12px;
            color: #FF4081;
            -webkit-transform: translateY(0%);
            -ms-transform: translateY(0%);
            -o-transform: translateY(0%);
            transform: translateY(0%);
        }

        .input-group label.active {
            width: 100%;
        }

        .left-alert input[type=text]+label:after,
        .left-alert input[type=password]+label:after,
        .left-alert input[type=email]+label:after,
        .left-alert input[type=url]+label:after,
        .left-alert input[type=time]+label:after,
        .left-alert input[type=date]+label:after,
        .left-alert input[type=datetime-local]+label:after,
        .left-alert input[type=tel]+label:after,
        .left-alert input[type=number]+label:after,
        .left-alert input[type=search]+label:after,
        .left-alert textarea.materialize-textarea+label:after {
            left: 0px;
        }

        .right-alert input[type=text]+label:after,
        .right-alert input[type=password]+label:after,
        .right-alert input[type=email]+label:after,
        .right-alert input[type=url]+label:after,
        .right-alert input[type=time]+label:after,
        .right-alert input[type=date]+label:after,
        .right-alert input[type=datetime-local]+label:after,
        .right-alert input[type=tel]+label:after,
        .right-alert input[type=number]+label:after,
        .right-alert input[type=search]+label:after,
        .right-alert textarea.materialize-textarea+label:after {
            right: 70px;
        }
    </style>



    <!-- Jquery Core Js -->
    <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/node-waves/waves.js"></script>
    <!--Form validation-->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Autosize Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/autosize/autosize.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Bootstrap Colorpicker Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <!-- Dropzone Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/dropzone/dropzone.js"></script>
    <!-- Input Mask Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <!-- Multi Select Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/multi-select/js/jquery.multi-select.js"></script>
    <!-- Jquery Spinner Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-spinner/js/jquery.spinner.js"></script>
    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <!-- SweetAlert Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.min.js"></script>
    <!-- Chart Plugins Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.bundle.js"></script>
    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/forms/advanced-form-elements.js"></script>
    <!-- Demo Js -->
    <script src="<?php echo base_url(); ?>assets/js/demo.js"></script>
</head>

<body class="theme-cyan">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url(); ?>dashboard"><img scr="<?php echo base_url('assets/images/pac.png'); ?>">CV PACIFIC</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <?php
                            // error_reporting(0);
                            $CI         = &get_instance();
                            $CI->load->model('Model_penjualan');
                            $jml = $CI->Model_penjualan->notifikasilimit();
                            ?>
                            <i class="material-icons">notifications</i>
                            <span class="label-count bg-red"> <?php echo $jml; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>penjualan/approvallimit">

                                            <div class="menu-info">

                                                <h4> <?php echo $jml; ?> Pengajuan Limit Belum Di Approve</h4>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->

                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url(); ?>assets/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('nama_lengkap'); ?> - <?php echo date('d M Y H:i:s'); ?></div>
                    <div class="email"><?php echo ucwords($this->session->userdata('level_user')); ?></div>

                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li><a href="<?php echo base_url(); ?>setting/ubah_password"><i class="material-icons">lock</i>Change Password</a></li>
                            <li><a href="<?php echo base_url(); ?>auth/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <?php
                    $level = $this->session->userdata('level_user');

                    $menu = $this->db->query("SELECT * FROM menu WHERE is_parent='0' AND is_active='1' AND role='$level'  ORDER BY id ASC");
                    foreach ($menu->result() as $m) {
                        //chek ada sub menu
                        $this->db->order_by('id', 'ASC');
                        $submenu = $this->db->get_where('menu', array('is_parent' => $m->id, 'is_active' => 1, 'role' => $this->session->userdata('level_user')));
                        if ($submenu->num_rows() > 0) {
                    ?>

                            <li>
                                <a href="javascript:void(0);" class="menu-toggle" id="mainmenu">
                                    <i class="material-icons"><?php echo $m->icon; ?></i>
                                    <span><?php echo ucwords($m->name); ?></span>
                                </a>
                                <ul class="ml-menu">
                                    <?php
                                    foreach ($submenu->result() as $s) {
                                        $submenusub = $this->db->order_by('id', 'ASC');
                                        $submenusub = $this->db->get_where('menu', array('is_parent' => $s->id, 'is_active' => 1, 'role' => $this->session->userdata('level_user')));
                                        if ($submenusub->num_rows() > 0) {
                                    ?>
                                            <li>
                                                <a href="javascript:void(0);" class="menu-toggle">
                                                    <span><?php echo $s->name; ?></span>
                                                </a>
                                                <ul class="ml-menu">
                                                    <?php foreach ($submenusub->result() as $ss) { ?>
                                                        <li>
                                                            <a href="<?php echo base_url() . $ss->link; ?>"><?php echo ucwords($ss->name); ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } else { ?>

                                            <li>
                                                <a href="<?php echo base_url() . $s->link; ?>">
                                                    <span><?php echo $s->name; ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>




                                </ul>
                            </li>

                        <?php
                        } else {
                        ?>

                            <a href="<?php echo base_url() . $m->link; ?>" id="mainmenu">
                                <i class="material-icons"><?php echo $m->icon; ?></i>
                                <span><?php echo ucwords($m->name); ?></span>
                            </a>
                        <?php } ?>
                    <?php


                    }
                    ?>




                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">IT - 2018</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div>
            <!-- #Footer -->
        </aside>

    </section>

    <section class="content">
        <div id="notifikasi"><?php echo $this->session->flashdata('msg'); ?></div>
        <?php echo $contents; ?>
    </section>
    <div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <b>Anda yakin ingin menghapus data ini ?</b><br><br>
                    <a class="btn bg-red waves-effect btn-ok"> Hapus</a>
                    <a class="btn bg-blue waves-effect" data-dismiss="modal"> Batal </a>

                </div>
            </div>
        </div>
    </div>
    <!-- Moment Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/momentjs/moment.js"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.list a[href~="' + location.href + '"]').parents('li').addClass('active');
            $('.ml-menu a[href~="' + location.href + '"]').parents('li').addClass('active');
            $('#konfirmasi_hapus').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
            $("#notifikasi").slideDown('slow').delay(3000).slideUp('slow');
            $("div").removeClass("bs-searchbox");
        });
    </script>

</body>

</html>