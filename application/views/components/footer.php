<!-- Footer -->
<?php 
	$js_plugins_path = base_url().'js-plugins/';
	$assets_path  = base_url().'assets/';
?>
<!-- <footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center footer-notifier">
                <?//= date('Y') ?> © Giỏ hàng. - gh.sinva.vn
            </div>
        </div>
    </div>
</footer> -->
    <!-- End Footer -->
    <!-- jQuery  -->
    <script src="<?= $assets_path ?>js/jquery.min.js"></script>
    <script src="<?= $assets_path ?>js/popper.min.js"></script>
    <script src="<?= $assets_path ?>js/bootstrap.min.js"></script>
    <script src="<?= $assets_path ?>js/waves.js"></script>
    <script src="<?= $assets_path ?>js/jquery.slimscroll.js"></script>

    <!-- Required datatable js -->
    <script src="<?= $js_plugins_path ?>datatables/jquery.dataTables.min.js"></script>
    <script src="<?= $js_plugins_path ?>datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Bootstrap-editable -->
    <script src="<?= $js_plugins_path ?>bootstrap-xeditable/js/bootstrap-editable.min.js"></script>
    <script src="<?= $js_plugins_path ?>moment/moment.js" type="text/javascript"></script>
    <script src="<?= $js_plugins_path ?>bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script src="<?= $js_plugins_path ?>bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?= $js_plugins_path ?>isotope/js/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="<?= $js_plugins_path ?>magnific-popup/js/jquery.magnific-popup.min.js"></script>
    <!-- App js -->
    <script src="<?= $assets_path ?>js/jquery.core.js"></script>
    <script src="<?= $assets_path ?>js/jquery.app.js"></script>
    <script>
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.buttons =
        '<div class="d-flex justify-content-center mt-2">' +
            '<button type="submit" class="btn btn-primary btn-sm editable-submit">'+
                '<i class="fa fa-fw fa-check"></i>'+
            '</button>'+
            '<button type="button" class="btn btn-default btn-sm editable-cancel">'+
                '<i class="fa fa-fw fa-times"></i>'+
            '</button>'+
        '</div>';
    </script>
    <script>
        for (var __i = 0; __i < commands.length; __i++) {
            commands[__i]();
        }
    </script>
    <script src="<?= base_url() ?>js/custom.js"></script>
    </body>
</html>