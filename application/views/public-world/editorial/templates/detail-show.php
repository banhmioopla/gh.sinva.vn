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
    <link rel="shortcut icon" href="<?= $template_lib_path ?>favicon.png">

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

    <title>Append Free HTML Template by Untree.co</title>
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
        <div class="logo">
            <a href="#" class="text-white">SinvaHome - Chi tiết dự án<span class="text-black">.</span></a>
        </div>
    </nav> <!-- END nav -->

</div> <!-- END container -->


<div class="hero-slant overlay" data-stellar-background-ratio="0.5" style="background-image: url('<?= $template_lib_path ?>images/hero-min.jpg')">

    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-9 intro">
                <h1 class="text-white font-weight-bold mb-4" data-aos="fade-up" data-aos-delay="0"><?= $post['title'] ?></h1>
                <p class="text-white mb-4" data-aos="fade-up" data-aos-delay="100">SinvaHome - Slogan gì đấy quên rồi</p>
                <form action="#" class="sign-up-form d-flex" data-aos="fade-up" data-aos-delay="200">
                    <input type="text" class="form-control" readonly value="<?= $user["phone_number"] ?>">
                    <input type="button" class="btn btn-primary" value="<?= $user["name"] ?>">
                </form>

            </div>


        </div>


    </div>

    <div class="slant" style="background-image: url('<?= $template_lib_path ?>images/slant.svg');"></div>
</div>

<div class="py-3">
    <div class="container">

        <div class="owl-logos owl-carousel">
            <div class="item">
                NHÀ MẶT PHỐ
            </div>
            <div class="item">
                CHUNG CƯ MINI
            </div>
            <div class="item">
                VĂN PHÒNG
            </div>
            <div class="item">
                BIỆT THỰ MINI
            </div>
            <div class="item">
                SIÊU THỊ MINI
            </div>
        </div>

    </div>

</div>
<div class="features-lg ">
    <div class="container">
        <div class="row feature align-items-center justify-content-between">

            <div class="col-lg-7 section-title" data-aos="fade-up" data-aos-delay="100">

                <h2 class="font-weight-bold mb-4 heading"><?= $post['title'] ?></h2>
                <p class="mb-4"><?= $post['content'] ?></p>

            </div>

        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center"  data-aos="fade-up">
                <h2 class="heading font-weight-bold mb-3">Thông tin tiện ích</h2>
            </div>
        </div>
        <div class="row align-items-stretch">
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Modern Design</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>High Performance</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Flexible Layout</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
                        
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-layers"></span>
                    </div>
                    <div>
                        <h3>Free Support</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-shopping-bag"></span>
                    </div>
                    <div>
                        <h3>Cool Pricing</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="unit-4 d-flex">
                    <div class="unit-4-icon mr-4">
                        <span class="feather-smartphone"></span>
                    </div>
                    <div>
                        <h3>Mobile Apps</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="site-section overlay site-cover-2" style="background-image: url('<?= $template_lib_path ?>images/img_v_3-min.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="text-white mb-4">Hình Ảnh / Video Dự Án</h2>
            </div>
        </div>
    </div>
</div>




<div class="features-lg">
    <div class="container">

        <div class="row feature align-items-center justify-content-between">
            <div class="col-lg-7 mb-4 mb-lg-0 section-stack" data-aos="fade-up" data-aos-delay="0">
                <img src="<?= $template_lib_path ?>images/img_h_5-min.jpg" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-4 section-title" data-aos="fade-up" data-aos-delay="100">

                <h2 class="font-weight-bold mb-4">Far far away, behind the word mountains</h2>
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live.</p>
                <p><a href="#" class="btn btn-primary">Get Started</a></p>

            </div>

        </div>

    </div>
</div>



<div class="site-section bg-light" id="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-7 mb-4 position-relative text-center mx-auto">
                <h2 class="font-weight-bold text-center">Our Blog Posts</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>

        </div>
        <div class="row">


            <div class="col-md-6 mb-5 mb-lg-0 col-lg-4">
                <div class="blog_entry">
                    <a href="#"><img src="<?= $template_lib_path ?>images/img_h_3-min.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid"></a>
                    <div class="p-4 bg-white">
                        <h3><a href="#">Far far away, behind the word mountains</a></h3>
                        <span class="date">April 25, 2019</span>
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                        <p class="more"><a href="#">Continue reading...</a></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-5 mb-lg-0 col-lg-4">
                <div class="blog_entry">
                    <a href="#"><img src="<?= $template_lib_path ?>images/img_h_5-min.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid"></a>
                    <div class="p-4 bg-white">
                        <h3><a href="#">Far far away, behind the word mountains</a></h3>
                        <span class="date">April 25, 2019</span>
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                        <p class="more"><a href="#">Continue reading...</a></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-5 mb-lg-0 col-lg-4">
                <div class="blog_entry">
                    <a href="#"><img src="<?= $template_lib_path ?>images/img_h_7-min.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid"></a>
                    <div class="p-4 bg-white">
                        <h3><a href="#">Far far away, behind the word mountains</a></h3>
                        <span class="date">April 25, 2019</span>
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                        <p class="more"><a href="#">Continue reading...</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-4 mx-auto">
                <a href="#" class="btn btn-primary btn-block">See All Posts</a>
            </div>
        </div>
    </div>
</div>

<div class="site-section overlay site-cover-2" style="background-image: url('<?= $template_lib_path ?>images/img_v_4-min.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="text-white mb-4">Get this template for free! :)</h2>
                <p class="mb-0"><a href="https://untree.co/" rel="noopener" class="btn btn-primary">Get it for free!</a></p>
            </div>
        </div>
    </div>
</div>

<div class="site-footer">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-4">
                <div class="widget">
                    <h3>About</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live.</p>
                </div>
                <div class="widget">
                    <h3>Connect with us</h3>
                    <ul class="social list-unstyled">
                        <li><a href="#"><span class="icon-facebook"></span></a></li>
                        <li><a href="#"><span class="icon-twitter"></span></a></li>
                        <li><a href="#"><span class="icon-instagram"></span></a></li>
                        <li><a href="#"><span class="icon-dribbble"></span></a></li>
                        <li><a href="#"><span class="icon-linkedin"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <div class="widget">
                            <h3>Navigations</h3>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <div class="widget">
                            <ul class="links list-unstyled">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Work</a></li>
                                <li><a href="#">Process</a></li>
                                <li><a href="#">About Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <div class="widget">
                            <ul class="links list-unstyled">
                                <li><a href="#">Press</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Privacy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <div class="widget">
                            <ul class="links list-unstyled">
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Process</a></li>
                                <li><a href="#">About Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center text-center copyright">
            <div class="col-md-8">
                <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> <!-- License information: https://untree.co/license/ -->
                </p> </br>
                <p> Dsitributed by <a href="https://themewagon.com">themewagon</a> </p>
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
