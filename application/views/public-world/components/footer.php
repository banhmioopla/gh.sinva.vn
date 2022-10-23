<!-- Footer -->
<?php
$js_plugins_path = base_url().'js-plugins/';
$assets_path  = base_url().'assets/';
?>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                CÔNG TY CỔ PHẦN ĐỊA ỐC SINVA
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->


<!-- jQuery  -->
<script src="<?= $assets_path ?>js/jquery.min.js"></script>
<script src="<?= $assets_path ?>js/popper.min.js"></script>
<script src="<?= $assets_path ?>js/bootstrap.min.js"></script>
<script src="<?= $assets_path ?>js/waves.js"></script>
<script src="<?= $assets_path ?>js/jquery.slimscroll.js"></script>

<script type="text/javascript" src="<?= $js_plugins_path ?>isotope/js/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="<?= $js_plugins_path ?>magnific-popup/js/jquery.magnific-popup.min.js"></script>

<!-- App js -->
<script src="<?= $assets_path ?>js/jquery.core.js"></script>
<script src="<?= $assets_path ?>js/jquery.app.js"></script>

<script type="text/javascript">
    $(window).on('load', function () {
        var $container = $('.portfolioContainer');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });

        $('.portfolioFilter a').click(function () {
            $('.portfolioFilter .current').removeClass('current');
            $(this).addClass('current');

            var selector = $(this).attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });
    });
    $(document).ready(function () {
        $('.image-popup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-fade',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            }
        });
    });
</script>

</body>

</html>