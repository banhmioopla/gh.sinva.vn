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
        <title>SinvaTour | Hệ thống quản lý phòng nội bộ </title>
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
        <style type="text/css" media="screen">
            .apm-update-time {
                font-size: 0.85em;
            }
            .topbar-main .notification-list .noti-icon-badge {
                display: inline-block;
                position: absolute;
                top: 14px;
                right: 8px;
            }
            .topbar-main .badge-danger {
                background-color: #f1556c;
            }
            .topbar-main .badge {
                font-family: "Rubik", sans-serif;
                box-shadow: 0 0 24px 0 rgb(0 0 0 / 6%), 0 1px 0 0 rgb(0 0 0 / 2%);
                padding: .35em .5em;
                font-weight: 500;
            }
            .topbar-main .badge-danger {
                color: #fff;
                background-color: #dc3545;
            }
            .topbar-main .badge {
                display: inline-block;
                padding: .25em .4em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25rem;
            }
            .dropdown-menu{
                z-index: 1000;
            }
        </style>
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
                        <!--<a href="/admin/list-apartment/<?/*= $this->session->has_userdata("switch_product_type") ? $this->session->userdata("switch_product_type") : 1 */?>" class="logo">
                            <h3 class="text-danger font-weight-bold"><?/*= $this->ghApartment->getTitleProductType($this->product_type) */?></h3>
                        </a>-->
                        <a href="#" class="logo">
                            <h4 class="text-success bg-dark p-1 rounded font-weight-bold">Tn: <?= number_format($this->income_personal) ?></h4>
                        </a>
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

                            <li class="dropdown notification-list hide-phone">
                                <!--<a class="nav-link dropdown-toggle waves-effect nav-user"
                                   data-toggle="dropdown"
                                   href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <i class="mdi mdi-earth"></i> English
                                    <i class="mdi mdi-chevron-down"></i>
                                </a>-->
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                     <a href="javascript:void(0);" class="dropdown-item">
                                        Spanish
                                    </a>
                                    <!-- item-->
                                     <a href="javascript:void(0);" class="dropdown-item">
                                        Italian
                                    </a>
                                </div>
                            </li>
                            <li class="dropdown notification-list" id="bell-notification">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="fi-bell noti-icon"></i>
                                    <span class="badge badge-danger badge-pill noti-icon-badge"><?= count($this->list_report_issue) ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="m-0">
                                            <span class="float-right">
                                                <a href="" class="text-dark">
                                                    <small>x</small>
                                                </a>
                                            </span>
                                            Thông báo [đang code]
                                        </h6>
                                    </div>
                                    <div class="slimscroll" style="max-height: 230px;">
                                        <!-- item-->
                                        <?php foreach ($this->list_report_issue as $report): ?>
                                        <a href="/admin/report/apartment-updating?id=" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-danger">
                                                <i class="mdi mdi-alert"></i>
                                            </div>
                                            <p class="notify-details">
                                               <?= $report['message'] ?>
                                                <small class="text-muted"><?= date('d-m-Y', $report['time_insert']) ?> | <?= $this->libUser->getNameByAccountid($report['create_user_id']) ?></small>
                                            </p>
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- All-->
                                    <!--<a href="/notification/show" class="dropdown-item text-center text-primary notify-item notify-all">
                                        xem tất cả
                                        <i class="fi-arrow-right"></i>
                                    </a>-->
                                </div>
                            </li>
                            <li class="dropdown notification-list">
                                <!-- <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="fi-speech-bubble noti-icon"></i>
                                    <span class="badge badge-dark badge-pill noti-icon-badge">6</span>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="m-0">
                                            <span class="float-right">
                                                <a href="" class="text-dark">
                                                    <small>Clear All</small>
                                                </a>
                                            </span>
                                            Chat
                                        </h6>
                                    </div>
                                    <div class="slimscroll" style="max-height: 230px;">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/batman-anim-1.gif" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Cristina Pride</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Hi, How are you? What about our next meeting</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-3.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Sam Garret</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Yeah everything is fine</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Karen Robinson</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Wow that's great</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-5.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Sherry Marshall</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Hi, How are you? What about our next meeting</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-6.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Shawn Millard</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Yeah everything is fine</p>
                                        </a>
                                    </div>
                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View all
                                        <i class="fi-arrow-right"></i>
                                    </a>
                                </div>
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
                                        <?php if(isYourPermission('ShAgencyGroup', 'show', $this->permission_set)):?>
                                            <a class="text-danger" href="/share/agency-group/dashboard/show">
                                               <h4 class="text-overflow">Đi đến <strong>SHARE</strong> </h4>
                                            </a>
                                            <hr>
                                        <?php endif;?>
                                    </div>
                                    <!-- item-->
                                    <a href="/user/profile" class="dropdown-item notify-item">
                                        <i class="fi-head"></i>
                                        <span>Tài khoản</span>
                                    </a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fi-cog"></i>
                                        <span>Cài đặt</span>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= base_url().'admin/change-password-user'?>" class="dropdown-item notify-item">
                                        <i class="fi-help"></i>
                                        <span>Đổi mật khẩu</span>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= base_url().'admin/logout'?>" class="dropdown-item notify-item">
                                        <i class="fi-power"></i>
                                        <span>Đăng xuất</span>
                                    </a>
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
            <?php $this->load->view('components/menu')?>
            <div class="text-center" id="pin-notification-section">
                <span class="p-2 font-weight-bold text-danger" id="pin-notification"><?= $this->pin_notification['content'] ?></span>
            </div>
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


