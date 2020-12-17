<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-alpha.7
* @link https://github.com/tabler/tabler
* Copyright 2018-2019 The Tabler Authors
* Copyright 2018-2019 codecalm.net Paweł Kuna
* Licensed under MIT (https://tabler.io/license)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Portal Pacific - 2020</title>
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <meta name="msapplication-TileColor" content="#206bc4" />
  <meta name="theme-color" content="#206bc4" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="HandheldFriendly" content="True" />
  <meta name="MobileOptimized" content="320" />
  <meta name="robots" content="noindex,nofollow,noarchive" />


  <!-- CSS files -->


  <link href="<?php echo base_url(); ?>dist/libs/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>dist/libs/selectize/dist/css/selectize.css" rel="stylesheet" />
  <!-- Latest compiled and minified CSS -->

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-select.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

  <link href="<?php echo base_url(); ?>dist/libs/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>dist/libs/nouislider/distribute/nouislider.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>dist/css/tabler.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>dist/css/demo.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>dist/css/tabler-buttons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" />

  <link href="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
  <!-- Sweetalert Css -->
  <link href="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
  <style>
    body {
      display: none;
      font-family: Roboto, HelveticaNeue, Arial, sans-serif;
    }

    select[readonly]:-moz-read-only {
      /* For Firefox */
      pointer-events: none;
    }

    select[readonly]:read-only {
      pointer-events: none;
    }

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

    .navbar-fixed-top {
      top: 0;
      position: fixed;
      right: 0;
      left: 0;
      z-index: 1030;
    }

    .highcharts-figure,
    .highcharts-data-table table {
      min-width: 100%;
      max-width: 100%;
      margin: 1em auto;
    }

    .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #EBEBEB;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
    }

    .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
    }

    .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
      padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
      background: #f1f7ff;
    }
  </style>


  <!-- Libs JS -->
  <!-- Jquery Core Js -->

  <!-- Bootstrap Core Js -->

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/libs/autosize/dist/autosize.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/libs/imask/dist/imask.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/libs/selectize/dist/js/standalone/selectize.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/libs/flatpickr/dist/flatpickr.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/libs/flatpickr/dist/plugins/rangePlugin.js"></script>
  <script src="<?php echo base_url(); ?>dist/libs/nouislider/distribute/nouislider.min.js"></script>
  <!-- Tabler Core -->
  <script src="<?php echo base_url(); ?>dist/js/tabler.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.maskMoney.js"></script>
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

  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/series-label.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>

<body class="antialiased" style="zoom:90%">
  <div class="page">
    <header class="navbar navbar-expand-md navbar-dark ">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false" aria-controls="navbar-menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a href="." class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pr-0 pr-md-3">
          <img src="<?php echo base_url(); ?>assets/images/pac.png" alt="Tabler" class="navbar-brand-image">
        </a>
        <div class="navbar-nav flex-row order-md-last">
          <div class="nav-item dropdown d-none d-md-flex mr-3">
            <a href="#" class="nav-link px-0" data-toggle="dropdown" tabindex="-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                <path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
              <span class="badge bg-red"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-card">
              <div class="card">
                <div class="card-body">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                </div>
              </div>
            </div>
          </div>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-toggle="dropdown">
              <span class="avatar" style="background-image: url(<?php echo base_url(); ?>assets/images/user.png)"></span>
              <div class="d-none d-xl-block pl-2">
                <div><?php echo $this->session->userdata('nama_lengkap'); ?></div>
                <div class="mt-1 small text-muted"><?php echo $this->session->userdata('level_user'); ?></div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php echo base_url() ?>auth/logout"><i class="fa fa-power-off mr-2"></i>Log out</a>
            </div>
          </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">

            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url(); ?>">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" />
                      <polyline points="5 12 3 12 12 3 21 12 19 12" />
                      <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                      <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Home
                  </span>
                </a>
              </li>
              <?php
              $level = $this->session->userdata('level_user');
              $menu = $this->db->query("SELECT * FROM menu2 WHERE is_parent='0' AND is_active='1' AND role='$level'  ORDER BY id ASC");
              foreach ($menu->result() as $m) {
                $this->db->order_by('id', 'ASC');
                $submenu = $this->db->get_where('menu2', array('is_parent' => $m->id, 'is_active' => 1, 'role' => $this->session->userdata('level_user')));
                if ($submenu->num_rows() > 0) {

              ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-toggle="dropdown" role="button" aria-expanded="false">
                      <span class="nav-link-icon d-md-none d-lg-inline-block mr-2">
                        <i class="fa <?php echo $m->icon; ?> icon"></i>
                      </span>
                      <span class="nav-link-title">
                        <?php echo ucwords($m->name); ?>
                      </span>
                    </a>
                    <ul class="dropdown-menu">
                      <?php
                      foreach ($submenu->result() as $s) {
                      ?>
                        <li>
                          <a class="dropdown-item" href="<?php echo base_url() . $s->link; ?>">
                            <?php echo $s->name; ?>
                          </a>
                        </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                <?php
                } else {
                ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url() . $m->link; ?>">
                      <span class="nav-link-icon d-md-none d-lg-inline-block mr-2">
                        <i class="fa <?php echo $m->icon; ?> icon"></i>
                      </span>
                      <span class="nav-link-title">
                        <?php echo ucwords($m->name); ?>
                      </span>
                    </a>
                  </li>
              <?php
                }
              }
              ?>
            </ul>

          </div>
        </div>
      </div>
    </header>
    <div class="content">
      <div id="notifikasi"><?php echo $this->session->flashdata('msg'); ?></div>
      <div style="min-height: 850px;">
        <?php echo $contents; ?>
      </div>
      <footer class="footer footer-transparent">
        <div class="container">
          <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ml-lg-auto">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item"><a href="./docs/index.html" class="link-secondary">Documentation</a></li>
                <li class="list-inline-item"><a href="./faq.html" class="link-secondary">FAQ</a></li>
                <li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank" class="link-secondary">Source code</a></li>
              </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
              Copyright © 2020
              <a href="." class="link-secondary">Tabler</a>.
              All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>


  <script type="text/javascript">
    $(function() {

      $("#notifikasi").slideDown('slow').delay(3000).slideUp('slow');
      $("div").removeClass("bs-searchbox");

    });
  </script>
  <script>
    document.body.style.display = "block"
  </script>
  <script>
    function toggleZoomScreen() {
      document.body.style.zoom = "80%";
    }
    toggleZoomScreen();
  </script>
</body>

</html>