<?php 
	$js_plugins_path = base_url().'js-plugins/';
	$assets_path  = base_url().'assets/';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GH [demo] - Giỏ Hàng Mới Sinva</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Giỏ hàng Sinva - Web quản lý căn hộ tuyệt vời thấy mẹ luôn nha, quản lý Căn hộ, Khách hàng, +100 điểm nha" name="description" />
        <meta content="Chào Việt Nam, tôi là Quốc Bình, quê ở Long An" name="Quốc.Bình" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= $assets_path ?>images/favicon.ico">

        <!-- App css -->
        <link href="<?= $assets_path ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $assets_path ?>css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?= $assets_path ?>css/style.css" rel="stylesheet" type="text/css" />

        <script src="<?= $assets_path ?>js/modernizr.min.js"></script>

    </head>

    <body class="account-pages">

        <!-- Begin page -->
        <div class="accountbg" style="background: url('<?= $assets_path ?>images/bg-03.gif');background-size: cover;"></div>

        <div class="wrapper-page account-page-full">

            <div class="card">
                <div class="card-block">

                    <div class="account-box">

                        <div class="card-box p-5">
                            <h2 class="text-uppercase text-center pb-4">
                                <a href="index.html" class="text-success">
                                    <span><img src="<?= $assets_path ?>images/logo-gh.png" alt="" height="26"></span>
                                </a>
                            </h2>
                            <h6>
                                COOKIE của GH
                                <?php
                                var_dump($_COOKIE);
                                ?>
                            </h6>

                            <form class="" method="post" action="<?= base_url().'admin/login' ?>">

                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="account_id">ID Của Bạn</label>
                                        <input class="form-control" 
                                        type="number" 
                                        name="account_id"
                                        id="account_id" required="" placeholder="Nhập ID 17102001">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <a href="#" class="text-muted pull-right"><small>quên mật khẩu?</small></a>
                                        <label for="password">Mật Khẩu</label>
                                        <input class="form-control" 
                                        type="password" 
                                        name="password"
                                        required="" id="password" placeholder="Nhập mật khẩu">
                                    </div>
                                </div>

                                <!-- <div class="form-group row m-b-20">
                                    <div class="col-12">

                                        <div class="checkbox checkbox-custom">
                                            <input id="remember" type="checkbox" checked="">
                                            <label for="remember">
                                                Remember me
                                            </label>
                                        </div>

                                    </div>
                                </div> -->

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-custom waves-effect waves-light" 
                                        name='submit'
                                        type="submit">Sign In</button>
                                    </div>
                                </div>

                            </form>

                            <div class="row m-t-50">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">Bạn muốn tham gia hệ thống quản lý căn hộ? <br> <a href="#" class="text-dark m-l-5"><b>Đăng ký ngay</b></a></p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright"><?= date('Y') ?> © GH Mới [demo] - gh.sinva.vn</p>
            </div>

        </div>


        <!-- jQuery  -->
        <script src="<?= $assets_path ?>js/jquery.min.js"></script>
        <script src="<?= $assets_path ?>js/popper.min.js"></script>
        <script src="<?= $assets_path ?>js/bootstrap.min.js"></script>
        <script src="<?= $assets_path ?>js/waves.js"></script>
        <script src="<?= $assets_path ?>js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="<?= $assets_path ?>js/jquery.core.js"></script>
        <script src="<?= $assets_path ?>js/jquery.app.js"></script>

    </body>
</html>