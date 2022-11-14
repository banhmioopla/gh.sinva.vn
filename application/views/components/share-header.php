<?php
$js_plugins_path = base_url().'js-plugins/';
$assets_path  = base_url().'assets/';
?>
<?php
include VIEWPATH.'functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>ShareBoard | Sinva - và các Môi giới, Chủ Nhà </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $assets_path ?>images/favicon.png" />
    <!-- DataTables -->
    <link href="<?= $js_plugins_path ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom box css -->
    <link href="<?= $js_plugins_path ?>custombox/css/custombox.min.css" rel="stylesheet" />
    <link href="<?= $js_plugins_path ?>bootstrap4-editable/css/bootstrap-editable.css" rel="stylesheet" />
    <link href="<?= $js_plugins_path ?>sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Spinkit css -->
    <link href="<?= $js_plugins_path ?>spinkit/spinkit.css" rel="stylesheet" />
    <!-- SELECT2 -->
    <link href="<?= $js_plugins_path ?>select2/css/select2.min.css" rel="stylesheet" />
    <link href="<?= $js_plugins_path ?>switchery/switchery.min.css" rel="stylesheet" />
    <!-- datepicker -->
    <link href="<?= $js_plugins_path ?>bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- sweet -->
    <link href="<?= $js_plugins_path ?>sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />
    <!--venobox lightbox-->
    <link rel="stylesheet" href="<?= $js_plugins_path ?>magnific-popup/css/magnific-popup.css" />
    <!-- App css -->
    <link href="<?= $assets_path ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets_path ?>css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets_path ?>css/style.css?v=1" rel="stylesheet" type="text/css" />
    <link href="<?= $assets_path ?>css/custom.css?v=20201115" rel="stylesheet"
          type="text/css" />

    <link rel="stylesheet" href="<?= $assets_path ?>stories-board/zuck.css">

    <!-- lib skins -->
    <link rel="stylesheet" href="<?= $assets_path ?>stories-board/skins/snapgram.css">
    <link rel="stylesheet" href="<?= $assets_path ?>stories-board/skins/vemdezap.css">
    <link rel="stylesheet" href="<?= $assets_path ?>stories-board/skins/facesnap.css">
    <link rel="stylesheet" href="<?= $assets_path ?>stories-board/skins/snapssenger.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha512-aEe/ZxePawj0+G2R+AaIxgrQuKT68I28qh+wgLrcAJOz3rxCP+TwrK5SPN+E5I+1IQjNtcfvb96HDagwrKRdBw==" crossorigin="anonymous" />
    <script src="<?= $assets_path ?>js/modernizr.min.js"></script>
    <script src="<?= base_url() ?>js/custom-header.js"></script>
    <script>
        let commands = [];
    </script>
</head>
<body>
<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!-- <a href="index.html" class="logo"><span class="logo-small"><i class="mdi mdi-radar"></i></span><span class="logo-large"><i class="mdi mdi-radar"></i> Highdmin</span></a> -->
                <!-- Image Logo -->
                <div class="logo">
                    <div class="text-center">SHARE BOARD</div>
                </div>
            </div>
            <!-- End Logo container-->
            <div class="menu-extras topbar-custom">
                <ul class="list-unstyled topbar-right-menu float-right mb-0">
                    <li class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?= $assets_path ?>images/users/batman-anim-1.gif" alt="user" class="rounded-circle" />
                            <span class="ml-1 pro-user-name">
                                        <?= $this->session->auth['name'] ?>
                                <i class="mdi mdi-chevron-down"></i>
                                    </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <a class="text-danger" href="/">
                                    <h4 class="text-overflow">Đi đến <strong>GH</strong> </h4>
                                </a>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
            <!-- end menu-extras -->
            <div class="clearfix"></div>
        </div>
        <!-- end container -->
    </div>
    <!-- end topbar-main -->
    <?php $this->load->view('components/share-menu')?>
    <!-- end navbar-custom -->
    <div id="gh-loader">
        <div class="sk-wave">
            <div class="sk-rect sk-rect1"></div>
            <div class="sk-rect sk-rect2"></div>
            <div class="sk-rect sk-rect3"></div>
            <div class="sk-rect sk-rect4"></div>
            <div class="sk-rect sk-rect5"></div>
        </div>
    </div>
</header>


