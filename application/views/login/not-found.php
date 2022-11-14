
<?php
$js_plugins_path = base_url().'js-plugins/';
$assets_path  = base_url().'assets/';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Highdmin - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?= $assets_path ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets_path ?>css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets_path ?>css/style.css?v=1" rel="stylesheet" type="text/css" />

    <script src="<?= $assets_path ?>js/modernizr.min.js"></script>

</head>

<body>


<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active">Error 404</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Error 404</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-sm-6 offset-3">
                <div class="text-center mt-5">
                    <h1 class="text-error">404</h1>
                    <h4 class="text-uppercase text-danger mt-3">Page Not Found</h4>
                    <p class="text-muted mt-3">It's looking like you may have taken a wrong turn. Don't worry...
                        it
                        happens to the best of us. Here's a
                        little tip that might help you get back on track.</p>

                    <a class="btn btn-md btn-custom waves-effect waves-light mt-3" href="index.html"> Return
                        Home</a>
                </div>

            </div><!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->


<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                2018 © Highdmin. - Coderthemes.com
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->


</body>

</html>