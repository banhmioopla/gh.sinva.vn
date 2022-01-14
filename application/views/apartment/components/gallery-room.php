<!--Carousel Wrapper-->
<div id="gallery-room" class="carousel slide carousel-multi-item carousel-multi-item-2" data-ride="carousel">

    <!--Controls-->
    <div class="controls-top text-center mb-1 mt-4">
        <a class="black-text btn btn-sm btn-danger" href="#gallery-room" data-slide="prev"><i class="mdi mdi-chevron-double-left  font-weight-bold pr-3"></i></a>
        <a class="black-text btn btn-sm btn-danger" href="#gallery-room" data-slide="next"><i class=" mdi mdi-chevron-double-right pl-3"></i></a>
    </div>
    <!--/.Controls-->

    <div class="carousel-inner" id="gallery-room-container" role="listbox">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            Ảnh phòng
        </div>
    </div>
</div>

<script>
    commands.push(function () {
        $('.room-code').click(function () {
            let room_id = $(this).data('id');
            $('.room-code').removeClass('current');
            $(this).addClass('current');
            $('#gh-loader').show();
            $.ajax({
                url:'/admin/ajax/gallery/show-img',
                method:'POST',
                dataType: 'json',
                data: {room_id:room_id},
                success:function (res) {
                    $('#gallery-room-container').html(res.html);
                    $('#gallery-room-container').magnificPopup({
                        delegate: '.image-popup',
                        type: 'image',
                        gallery: {
                            enabled:true,
                            navigateByImgClick: true,
                            preload: [0,1]
                        },
                        callbacks: {
                            elementParse: function(item) {
                                // the class name
                                console.log("magnificPopup");
                                console.log(item.el[0].className);
                                item.type = 'image';
                                if(item.el[0].className.includes("app-video") === true) {
                                    item.type = 'iframe';
                                }
                            }
                        },
                    });
                    $('#gallery-room-container .carousel-item').first().addClass('active');
                    setTimeout(function(){ $('#gh-loader').hide() }, 1000);
                }
            });
        });

        $('body').delegate(".btn-delete-img","click",function () {
            var img_id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '/admin/gallery/delete',
                data: {id:img_id},
                dataType:"json",
                success: function () {
                    $('#img-box-'+img_id).fadeOut( "slow", function() {
                        $('#img-box-'+img_id).remove();
                    });
                }
            });
        });
    });
</script>
