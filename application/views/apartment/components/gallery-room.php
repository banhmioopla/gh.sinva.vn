<!--Carousel Wrapper-->
<div id="gallery-room" class="carousel slide carousel-multi-item carousel-multi-item-2" data-interval="false" data-ride="carousel">

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
                            },
                            open: function() {
                                $('body').addClass('noscroll');
                            },
                            close: function() {
                                $('body').removeClass('noscroll');
                            }
                        },
                    });
                    $('#gallery-room-container .carousel-item').first().addClass('active');
                    setTimeout(function(){ $('#gh-loader').hide() }, 1000);
                }
            });
        });

        $('.delete-media-in-room').click(function () {
        	let _this = $(this);
			swal({
				title: 'Bạn Muốn Xóa Tất Cả Ảnh Phòng ' + _this.data('room-code'),
				type: 'warning',
				showCancelButton: true,
				confirmButtonClass: 'btn btn-confirm mt-2',
				cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
				confirmButtonText: 'Xóa',
			}).then(function () {
				$.ajax({
					type: 'POST',
					url:'/admin/gallery/delete-by-room',
					data: {room_id: _this.data('id')},
					dataType:'json',
					success:function(response) {
						if(response.status === true) {
							for(const element of response.list_media_id){
								$('#img-box-'+element).fadeOut( "slow", function() {
									$('#img-box-'+element).remove();
								});
							}

						}
					}
				});
				swal({
					title: 'Đã Xóa Thành Công!',
					type: 'success',
					confirmButtonClass: 'btn btn-confirm mt-2'
				});
			})
		})

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
