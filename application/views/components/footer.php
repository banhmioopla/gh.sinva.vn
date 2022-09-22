<!-- Footer -->
<?php 
	$js_plugins_path = base_url().'js-plugins/';
	$assets_path  = base_url().'assets/';
?>



 <footer class="footer mt-5" style="position: unset;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center footer-notifier">
                <?= date('Y') ?> © Giỏ hàng. - gh.sinva.vn
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
    <!-- Modal-Effect -->
    <script src="<?= $js_plugins_path ?>custombox/js/custombox.min.js"></script>
    <script src="<?= $js_plugins_path ?>custombox/js/legacy.min.js"></script>
    <script type="text/javascript" src="<?= $js_plugins_path ?>jquery-knob/excanvas.js"></script>
    <![endif]-->
    <script src="<?= $js_plugins_path ?>jquery-knob/jquery.knob.js"></script>
    <script src="<?= $js_plugins_path ?>jquery-toastr/jquery.toast.min.js"></script>
    <!-- Required datatable js -->
    <script src="<?= $js_plugins_path ?>datatables/jquery.dataTables.min.js"></script>
    <script src="<?= $js_plugins_path ?>datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Bootstrap-editable -->
    <script src="<?= $js_plugins_path ?>bootstrap4-editable/js/bootstrap-editable.min.js"></script>
    <script src="<?= $js_plugins_path ?>moment/moment.js" type="text/javascript"></script>
    <script src="<?= $js_plugins_path ?>bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script src="<?= $js_plugins_path ?>bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<!--    <script src="--><?//= $js_plugins_path ?><!--select2/js/select2.min.js" type="text/javascript"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?= $js_plugins_path ?>isotope/js/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="<?= $js_plugins_path ?>magnific-popup/js/jquery.magnific-popup.min.js"></script>

    <!-- chart -->
    <script src="<?= $js_plugins_path ?>switchery/switchery.min.js"></script>
    <script src="<?= $js_plugins_path ?>jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- sweetalert2 -->
    <script src="<?= $js_plugins_path ?>sweet-alert/sweetalert2.min.js"></script>
    <!-- rating -->
    <script src="<?= $js_plugins_path ?>raty-fa/jquery.raty-fa.js"></script>
    <!-- datepicker -->
    <script src="<?= $js_plugins_path ?>bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg==" crossorigin="anonymous"></script>
    <!-- App js -->
    <script src="<?= $assets_path ?>js/jquery.core.js"></script>
    <script src="<?= $assets_path ?>js/jquery.app.js?v=20201011"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $.fn.editable.defaults.mode = 'popup';
        $.fn.editableform.buttons =
        '<div class="d-flex justify-content-center mt-2">' +
            '<button type="submit" class="btn btn-primary btn-sm editable-submit">'+
                '<i class="fa fa-fw fa-check"></i>'+
            '</button>'+
            '<button type="button" class="btn btn-default btn-sm editable-cancel">'+
                '<i class="fa fa-fw fa-times"></i>'+
            '</button>'+
        '</div>';

        window.onload = function () {
            setTimeout(function(){ $('#gh-loader').hide() }, 1500);
        };
    </script>
    <script>
        for (var __i = 0; __i < commands.length; __i++) {
            commands[__i]();
        }
    </script>
    <script src="<?= base_url() ?>js/custom.js"></script>
    </body>
</html>