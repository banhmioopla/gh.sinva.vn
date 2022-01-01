<!--Carousel Wrapper-->
<div id="gallery-room" class="carousel slide carousel-multi-item carousel-multi-item-2" data-ride="carousel">

    <!--Controls-->
    <div class="controls-top text-center mb-1 mt-4">
        <a class="black-text btn btn-sm btn-danger" href="#gallery-room" data-slide="prev"><i class="mdi mdi-chevron-double-left  font-weight-bold pr-3"></i></a>
        <a class="black-text btn btn-sm btn-danger" href="#gallery-room" data-slide="next"><i class=" mdi mdi-chevron-double-right pl-3"></i></a>
    </div>
    <!--/.Controls-->

    <div class="carousel-inner" id="gallery-room-container" role="listbox"></div>
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
                            enabled:true
                        }
                    });
                    setTimeout(function(){ $('#gh-loader').hide() }, 1000);
                }
            });
        });
    });
</script>
