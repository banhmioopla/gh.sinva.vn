<!DOCTYPE html>
<html>

<?php
$js_plugins_path = base_url().'js-plugins/';
$assets_path  = base_url().'assets/';
?>

<head>
    <meta charset="utf-8" />
    <title><?= $title_page ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="<?= $post_title ?>" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta property="og:title" content="<?= $post_title ?>" />
    <meta property="og:image" content="https://scontent.fsgn8-2.fna.fbcdn.net/v/t39.30808-6/309063917_529384985854978_9051968886405929031_n.png?_nc_cat=111&ccb=1-7&_nc_sid=e3f864&_nc_ohc=MH5qyBMv39MAX8o1FmZ&tn=g_R21xJrPaUpKa6F&_nc_ht=scontent.fsgn8-2.fna&oh=00_AfD8VsbRIhCco5R1JvOLauNxZqCBz1t-5Ggk014T_LypMA&oe=636EE840" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $assets_path ?>images/favicon.png">

    <!--venobox lightbox-->
    <link rel="stylesheet" href="<?= $js_plugins_path ?>magnific-popup/css/magnific-popup.css" />

    <!-- App css -->
    <link href="<?= $assets_path ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets_path ?>css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets_path ?>css/style.css" rel="stylesheet" type="text/css" />

    <script src="<?= $assets_path ?>js/modernizr.min.js"></script>
    <script>
        let commands = [];
    </script>

</head>

<body>

<!-- Navigation Bar-->
<header id="topnav">

    <div class="topbar-main">
        <div class="container-fluid">
            <div class="menu-extras topbar-custom justify-content-center">
<!--                <img src='https://i.postimg.cc/MMjMnLDz/Sinva-vn-Logo-QB-updated.png' border='0' height="80" alt='Sinva-vn-Logo-QB-updated'/>-->
                <h1 class="text-center text-danger font-weight-bold">CÔNG TY CỔ PHẦN ĐỊA ỐC SINVA</h1>

            </div>
        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
</header>
<!-- End Navigation Bar-->
