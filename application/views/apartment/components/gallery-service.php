<!--Carousel Wrapper-->
<div id="gallery-service" class="carousel slide carousel-multi-item carousel-multi-item-2" data-ride="carousel">
    <div class="controls-top text-center mb-1 mt-1">
        <a class="black-text btn btn-sm btn-danger" href="#gallery-service" data-slide="prev"><i class="mdi mdi-chevron-double-left pr-3"></i></a>
        <a class="black-text btn btn-sm btn-danger" href="#gallery-service" data-slide="next"><i class=" mdi mdi-chevron-double-right pl-3"></i></a>
    </div>
    <!--/.Controls-->

    <!--Slides-->
    <div class="carousel-inner" id="gallery-service-container" role="listbox">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            Ảnh dịch vụ
        </div>
    </div>
    <!--/.Slides-->

</div>

<script>
    commands.push(function () {

        console.log("SERVICE");
        $.ajax({
            url:'/admin/ajax/gallery/show-img/service',
            method:'POST',
            dataType: 'json',
            data: {apartment_id: "<?= $current_apartment['id'] ?>"},
            success:function (res) {

                $('#gallery-service-container').html(res.html);
                $('#gallery-service-container').magnificPopup({
                    delegate: '.image-popup',
                    type: 'image',
                    gallery: {
                        enabled:true
                    },
                    callbacks:function (item) {
                        open: function() {
                            $('body').addClass('noscroll');
                        },
                        close: function() {
                            $('body').removeClass('noscroll');
                        }
                    }
                });
                $('#gallery-service-container .carousel-item').first().addClass('active');
            }
        });
    });
</script>
