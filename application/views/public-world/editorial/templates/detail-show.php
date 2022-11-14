<!-- Footer -->
<?php
$template_lib_path = base_url()."editorial-asset/";



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="https://designimages.appypie.com/favicon/realestatefavicon-6-firstaid-symbol.jpg">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />


    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= $template_lib_path ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>fonts/feather/style.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>css/aos.css">
    <link rel="stylesheet" href="<?= $template_lib_path ?>css/style.css">

    <title><?= $post['title'] ?></title>
</head>
<body>


<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
            <span class="icofont-close js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<div class="container">


    <nav class="site-nav">
        <div class="logo ">
            <a href="#" class="text-white">SinvaHome - Chi tiết dự án<span class="text-black">.</span></a>
        </div>
    </nav> <!-- END nav -->

</div> <!-- END container -->


<div class="hero-slant overlay" data-stellar-background-ratio="0.5" style="background-image: url('<?= $template_lib_path ?>images/hero-min.jpg')">

    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-9 intro">
                <h1 class="text-white font-weight-bold mb-4" data-aos="fade-up" data-aos-delay="0"><?= $post['title'] ?></h1>
                <p class="text-white mb-4" data-aos="fade-up" data-aos-delay="100">SinvaHome - Uy tín của chúng tôi chắc như bê tông</p>
                <form action="#" class="sign-up-form d-flex" data-aos="fade-up" data-aos-delay="200">
                    <input type="text" class="form-control" readonly value="<?= $user["phone_number"] ?>">
                    <input type="button" class="btn btn-primary" value="<?= $user["name"] ?>">
                </form>
            </div>
        </div>
    </div>

    <div class="slant" style="background-image: url('<?= $template_lib_path ?>images/slant.svg');"></div>
</div>


<div >
    <div class="container">
        <div class="row feature align-items-center justify-content-between">

            <div class="col-lg-7 section-title" data-aos="fade-up" data-aos-delay="100">

                <h2 class="font-weight-bold mb-4 heading"><?= $post['title'] ?></h2>
                <p class="mb-4" style="white-space: pre-wrap"><?= $post['content'] ?></p>
            </div>
            <div class=" pricing-section  col-md-6 col-lg-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
                <div class="pricing-item shadow">
                    <h3>Phòng <?= $room["code"] . "" ?></h3>
                    <div class="description">
                        <p><?= $apartment["address_street"] ?></p>
                    </div>
                    <div class="period-change mb-4 d-block">
                        <div class="price-wrap">
                            <div class="price">
                                <div>
                                    <div><?= number_format($room["price"]) ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline-flex align-items-center text-center period-wrap">
                            <div class="d-inline-block mr-1">1 </div>
                            <div class="d-block text-left period">
                                <div>Tháng</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center"  data-aos="fade-up">
                <h2 class="heading font-weight-bold mb-3">Chi tiết</h2>
            </div>
        </div>
        <div class="row align-items-stretch">
            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Cọc</h3>
                        <p><?= $apartment["deposit"] ?></p>
                    </div>
                </div>
            </div>

            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Điện</h3>
                        <p><?= $apartment["electricity"] ?></p>
                    </div>
                </div>
            </div>

            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Nước</h3>
                        <p><?= $apartment["electricity"] ?></p>
                    </div>
                </div>
            </div>

            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Internet</h3>
                        <p><?= $apartment["electricity"] ?></p>
                    </div>
                </div>
            </div>

            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Giữ xe</h3>
                        <p><?= $apartment["parking"] ?></p>
                    </div>
                </div>
            </div>

            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Thang máy</h3>
                        <p><?= $apartment["elevator"] ?></p>
                    </div>
                </div>
            </div>

            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Máy giặt</h3>
                        <p><?= $apartment["washing_machine"] ?></p>
                    </div>
                </div>
            </div>

            <!--ITEM-->
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Dọn phòng</h3>
                        <p><?= $apartment["room_cleaning"] ?></p>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<div class="site-section" id="portfolio-section">
    <div class="container">
        <h2 class="font-weight-bold text-center">Ảnh/Video</h2>

        <div class="filters-content mb-5" data-aos="fade-up" data-aos-delay="200">
            <div class="row grid">

                <?php foreach ($list_img as $img):
                        $url_img ='media/apartment/'.$img['name'];
                        if(file_exists($url_img) == false){
                            continue;
                        }
                        $is_video = false;
                        if(in_array(strtoupper($img['file_type']), ["MP4", "MOV"])){
                            $is_video = true;
                        }

                    ?>

                    <?php if(!$is_video): ?>
                    <div class="isotope-card col-sm-4 all mockup">
                        <a href="<?= base_url().'media/apartment/'.$img['name'] ?>" data-fancybox="gal">
                            <img src="<?= base_url().'media/apartment/'.$img['name'] ?>" alt="Image" class="img-fluid">
                            <div class="contents">
                                <h3><?= $room["code"] ?></h3>
                            </div>
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="isotope-card col-sm-4 all mockup">
                        <a href="<?= base_url().'media/apartment/'.$img['name'] ?>" href="#vid-<?= $img['name'] ?>" data-fancybox="gal">
                            <img class="img-fluid" src="https://www.imcrc.org/wp-content/uploads/2017/06/video-placeholder.png" />
                        </a>
                        <video  controls id="vid-<?= $img['name'] ?>" style="display:none;">
                            <source src="<?= base_url().'media/apartment/'.$img['name'] ?>" type="video/mp4">
                            <source src="<?= base_url().'media/apartment/'.$img['name'] ?>" type="video/webm">
                            <source src="<?= base_url().'media/apartment/'.$img['name'] ?>" type="video/ogg">
                            Trình duyệt không hỗ trợ xem định dạng Video
                        </video>

                    </div>
                    <?php endif; ?>
                <?php endforeach;?>

            </div>
        </div>
    </div>
</div>


<div class="site-footer">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-4">
                <div class="widget">
                    <h3>SinvaHome</h3>
                    <p>Công ty cổ phần địa ốc SinvaHome</p>
                </div>
                <div class="widget">
                    <h3>Mạng xã hội</h3>
                    <ul class="social list-unstyled">
                        <li><a href="https://www.facebook.com/Sinvahome"><span class="icon-facebook"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row justify-content-center text-center copyright">
            <div class="col-md-8">
                <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="#">Sinva</a> <!-- License information: https://untree.co/license/ -->
                </p> </br>
            </div>
        </div>
    </div>
</div>


<div id="overlayer"></div>
<div class="loader">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<script src="<?= $template_lib_path ?>js/jquery-3.5.1.min.js"></script>
<script src="<?= $template_lib_path ?>js/jquery-migrate-3.0.0.min.js"></script>
<script src="<?= $template_lib_path ?>js/popper.min.js"></script>
<script src="<?= $template_lib_path ?>js/bootstrap.min.js"></script>
<script src="<?= $template_lib_path ?>js/owl.carousel.min.js"></script>
<script src="<?= $template_lib_path ?>js/aos.js"></script>
<script src="<?= $template_lib_path ?>js/imagesloaded.pkgd.js"></script>
<script src="<?= $template_lib_path ?>js/isotope.pkgd.min.js"></script>
<script src="<?= $template_lib_path ?>js/jquery.animateNumber.min.js"></script>
<script src="<?= $template_lib_path ?>js/jquery.stellar.min.js"></script>
<script src="<?= $template_lib_path ?>js/jquery.waypoints.min.js"></script>
<script src="<?= $template_lib_path ?>js/jquery.fancybox.min.js"></script>
<script src="<?= $template_lib_path ?>js/custom.js"></script>


</body>
</html>
