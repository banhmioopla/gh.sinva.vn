<?php 
	$js_plugins_path = base_url().'js-plugins/';
	$assets_path  = base_url().'assets/';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Giỏ hàng SINVA - Hệ thống quản trị nội bộ</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Giỏ hàng SINVA - Hệ thống quản trị nội bộ" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= $assets_path ?>images/favicon.png">

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
                            <div class="text-center">
                                <span><img src="<?= $assets_path ?>images/Gio-hang-logo.png" alt="" height="250"></span>
                            </div>

                            <form method="post" action="<?= base_url().'admin/login' ?>">
                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="account_id">Tài khoản</label>
                                        <input class="form-control" 
                                        type="number" 
                                        name="account_id"
                                        id="account_id" required="" placeholder="17102001">
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <label for="password">Mật Khẩu</label>
                                        <input class="form-control" 
                                        type="password" 
                                        name="password"
                                        required="" id="password" placeholder="Nhập mật khẩu">
                                    </div>
                                </div>

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-danger waves-effect waves-light"
                                        name='submit'
                                        type="submit">Đăng nhập</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="account-copyright"><?= date('Y') ?> © Gio Hang SINVA - gh.sinva.vn</p>
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