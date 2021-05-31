<?php
$role_delete = ['product-manager', 'customer-care', 'business-manager'];
$check_modify = false;
if (isYourPermission($this->current_controller, 'update', $this->permission_set)) {
    $check_modify = true;
}

$check_commission_rate = false;
if(isYourPermission('Apartment', 'showCommmissionRate', $this->permission_set)){
    $check_commission_rate = true;
}
$view_service = [
    'check_commission_rate' => $check_commission_rate,
    'apartment' => $apartment
];
?>


<?php
include VIEWPATH . 'functions.php';
?>
<style>
    .portfolioFilter a.current{
        background: #f9a50b;
        border-bottom: solid red 4px;
    }
    .portfolioFilter a:hover {
        background-color: #f9a50b;
    }
    .room-code .badge-danger{
        font-size: 70%;
        line-height: unset;
    }
    .noti-icon-badge {
        display: inline-block;
        position: absolute;
        top: 14px;
        right: 8px;
    }
    .img-apartment{
        max-height: 250px !important;
    }
    h5,h4 {
        white-space: normal!important;
    }
</style>


<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Gallery</li>
                        </ol>
                    </div>
                    <h2 class="text-danger font-weight-bold">Kho Ảnh: <i><?= $apartment['address_street'] ?></i>
                    </h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="card-box bg-danger widget-flat border-danger text-white">
                                <i class="mdi mdi-folder-multiple-image"></i>
                                <h3 class="m-b-10"><?= $counter ?></h3>
                                <p class="text-uppercase mb-2 font-13 font-600">
                                    Số Lượng Hình Ảnh
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <select id="search-apartment-id" class="form-control">
                                <option value="" disabled>Chọn Dự Án Khác</option>
                                <?php foreach ($list_apartment as $item):
                                    $select = "";
                                    if($this->input->get('apartment-id') == $item['id']) {
                                        $select = 'selected';
                                    }

                                    ?>
                                    <option
                                            <?= $select ?>
                                            value="<?= $item['id'] ?>"><?= $item['address_street'] . ' Ph.'.$item['address_ward'] ?></option>
                                <?php endforeach;?>
                            </select>
                            <script>
                                commands.push(function () {
                                    $('#search-apartment-id').select2();
                                    $('#search-apartment-id').change(function () {
                                        window.location = ('/admin/apartment/show-image?apartment-id='+$(this).val());
                                    });
                                })
                            </script>
                        </div>
                        <div class="col text-center">
                            <a href="/admin/apartment/upload-img?apartment_id=<?= $apartment['id']?>"
                               class="btn-danger float-md-right mt-1 mt-md-0 btn text-center">Upload Ảnh Mới <i class="mdi mdi-cloud-upload"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h3 class="text-danger font-weight-bold">Thông Tin Dịch Vụ</h3>
                                <div class="row">
                                    <div class="col-md-6 col-12 shadow-sm">
                                        <p class="mb-0 text-muted">Mô Tả</p>
                                        <h5 class="mb-2 text-wrap"><?= $apartment['description'] ?></h5>
                                    </div>
                                    <div class="col-md-6 col-12 shadow-sm">
                                        <p class="mb-0 text-muted">Ghi Chú Dự Án</p>
                                        <h5 class="mb-2 text-wrap"><?= $apartment['note'] ?></h5>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Điện</p>
                                            <h4 class="mb-2 text-wrap"><?= $apartment['electricity'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Nước</p>
                                            <h4 class="mb-2 text-wrap"><?= $apartment['water'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Internet</p>
                                            <h4 class="mb-2"><?= $apartment['internet'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Giữ xe</p>
                                            <h4 class="mb-2"><?= $apartment['parking'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted ">Phí Quản Lý</p>
                                            <h4 class="mb-2"><?= $apartment['management_fee'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Combo Phí</p>
                                            <h4 class="mb-2"><?= $apartment['extra_fee'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Cọc Phòng</p>
                                            <h4 class="mb-2"><?= $apartment['deposit'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Thang máy</p>
                                            <h4 class="mb-2"><?= $apartment['elevator'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Máy Giặt</p>
                                            <h4 class="mb-2"><?= $apartment['washing_machine'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Dọn Phòng</p>
                                            <h4 class="mb-2"><?= $apartment['room_cleaning'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Số Người Ở</p>
                                            <h4 class="mb-2"><?= $apartment['number_of_people'] ?></h4>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Bếp</p>
                                            <h4 class="mb-2"><?= $apartment['kitchen'] ?></h4>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Bảo vệ</p>
                                            <h4 class="mb-2"><?= $apartment['security'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 shadow-sm">
                                        <div class="mt-3">
                                            <p class="mb-0 text-muted">Thú cưng</p>
                                            <h4 class="mb-2"><?= $apartment['pet'] ?></h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card-box">
                                <h3 class="text-danger font-weight-bold">Tạo Bài Đăng Tư Vấn <i class="mdi mdi-arrow-down-drop-circle"></i></h3>
                                <strong class="text-danger">Tiêu Đề Bài Đăng</strong>
                                <input type="text" required id="post_title" class="form-control">
                                <strong class="text-danger">Mô Tả </strong>
                                <textarea type="text" id="post_content" class="form-control" rows="2"></textarea>
                                <div class="text-center" id="notification"></div>
                                <input type="hidden" id="post_password" value="">
                                <input type="hidden" id="post_room_id">
                                <div class="text-center m-1">
                                    <button type="button" id="submit_consultant_post" class="btn btn-danger waves-effect waves-light">Tạo Bài Tư Vấn <i class="mdi mdi-library-plus"></i></button>
                                </div>
                            </div>


                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2 ">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-light alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                Click vào mã phòng phía dưới để xem ảnh!
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form name="form-download" id="form-download" action="/admin/download-image-apartment" method="post">
                            <div class="portfolioFilter text-center gallery-second">
                                <div class="row">
                                    <div class="col-md-12 mb-2 text-center">
                                        <button type="submit" class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect download-all">
                                            <i class="mdi mdi-cloud-download"></i> Tải Về Tất Cả
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                <?php
                                $i = 0;
                                foreach ($chain_room as $room):
                                    ?>
                                    <div class="col-6 col-md-3 pl-1 pr-1">
                                        <a href="#" class="text-left w-100 font-weight-bold border border-warning border-3 room-code"
                                           id="room-id-<?= $room['value'] ?>"
                                           data-filter=".room-id-<?= $room['value'] ?>"
                                           data-room-id="<?= $room['value'] ?>"><?= $room['display'] ?></a>
                                    </div>

                                <?php endforeach; ?>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-md-12">
                <div class="port">
                    <div class="portfolioContainer">
                        <div id="list-img" class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end container -->
</div>

<script>
    commands.push(function () {
        $(document).ready(function () {
            $('#submit_consultant_post').click(function () {
                let img_id = [];
                let count_img = 0;
                $('input[name=post_imgs]:checked').each(function(){
                    img_id.push($(this).val());
                    count_img++;
                });
                if($('#post_title').val().length === 0) {
                    $('#notification').text('Bắt Buộc Nhập Tiêu Đề');
                    return;
                } else {
                    $('#notification').text('');
                }
                if(img_id.length === 0) {
                    $('#notification').text('Bắt Buộc Chọn Hình Ảnh');
                    return;
                } else {
                    $('#notification').text('');
                }
                let post_title = $('#post_title').val();
                let post_content = $('#post_content').val();
                let post_password = $('#post_password').val();
                let post_room_id = $('#post_room_id').val();

                $.ajax({
                    url:"/admin/ajax/create-consulting-post",
                    method: "POST",
                    data: {
                        img_id: img_id,
                        post_title: post_title,
                        post_content: post_content,
                        post_room_id: post_room_id,
                        post_password: post_password
                    },
                    success: function(res){
                        res = JSON.parse(res);
                        if(res.status === true) {
                            setTimeout(function(){window.location = '/public/consulting-post-detail?id='+res.post_id;}, 3000);
                            $("#notification").html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                ${res.content}
                            </div>`);
                            $('.list-post').append(`<li>
                                    <a href="/public/consulting-post-detail?id=${post_id}" target="_blank">Bài Viết Mới Nhất</a>
                                </li>`);
                        } else {
                            $("#notification").html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                Tạo Bài Viết Thất Bại
                            </div>`);
                        }
                    }
                });
            });

            $('.choose-img, .btn-upload').hide();
            $('select[name=room_id]').on('change', function () {
                if ($(this).val() == '0') {
                    $('.choose-img, .btn-upload').hide();
                } else {
                    $('.choose-img, .btn-upload').show();
                }
            });
            $('body').delegate('.delete-img','click',function () {
                var img_id = $(this).data('img-id');
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/update-image',
                    data: {img_id: img_id, field_name: 'active', field_value: 'NO'},
                    success: function () {
                        $('#img-box-'+img_id).fadeOut( "slow", function() {
                            $('#img-box-'+img_id).remove();
                        });
                    }
                });
            });
            $('.download-img-all').click(function () {
                $('.download-img').click();
            });
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

            $('.download-all').click(function (e) {
                let room_id = $('.portfolioFilter a.current').data('room-id');
                console.log(room_id);
                if(room_id > 0) {
                    $("#form-download").append('<input type="hidden" name="room-id" value="'+room_id+'"/>');
                    $("#form-download").submit();
                }
            });
            $(".download-all").hide();
            $("#create-post").hide();
            $('.portfolioFilter a').click(function(){
                if($(this).data('room-id') > 0) {
                    $(".download-all").show();
                    $(".download-all").html('<i class="mdi mdi-cloud-download"></i> Tải Mã '+ $(this).text());
                    $("#create-post").show();
                    $("#post_room_id").val($(this).data('room-id'));
                } else {
                    $(".download-all").hide();
                    $("#create-post").hide();
                }

            });

        });

        $('.room-code').click(function () {
            let room_id = $(this).data('room-id');
            $('.room-code').removeClass('current');
            $(this).addClass('current');
            $('#gh-loader').show();
            $.ajax({
                url:'/admin/ajax/apartment/show-img',
                method:'post',
                data: {room_id:room_id},
                success:function (res) {
                    let data = JSON.parse(res);
                    let html = "";
                    if(data.length > 0) {
                        $('#submit_consultant_post').show();

                    } else {
                        $('#submit_consultant_post').hide();
                    }
                    let delete_btn = "d-none";
                    <?php if($check_modify): ?>
                        delete_btn = " ";
                    <?php endif;?>
                    for(let i of data) {
                        if(!(i.url.includes(".mp4") || i.url.includes(".mov"))) {
                            html += `
                        <div class="col-6 mt-1 col-md-3" id="img-box-${i.id}">
                            <div class="pl-1 pr-1 pt-1 pb-2 bg-white rounded" >
                            <a href="${i.url}" class="image-popup">
                                <div class="portfolio-masonry-box pl-1 pr-1 mt-0 bg-white">
                                    <div class="portfolio-masonry-img">
                                        <img src="${i.url}"
                                         class="thumb-img img-fluid img-apartment"
                                         alt="work-thumbnail">
                                    </div>

                                </div>
                            </a>
                            <div class="row mt-2 pl-1 pr-1">
                                <div class="col">
                                    <i type="button"
                                    data-img-id="${i.id}"
                                    class="btn btn-icon fa fa-remove delete-img ${delete_btn} btn-sm waves-effect waves-light btn-danger"> </i>
                                </div>
                                <div class="col">
                                    <div class="checkbox text-right checkbox-danger">
                                        <input id="checkbox-${i.id}" type="checkbox" name="post_imgs" value="${i.id}" >
                                        <label for="checkbox-${i.id}"></label>
                                    </div>
                                </div>

                            </div>
                            </div>

                        </div>
                        `;
                        } else {
                            html += `
                            <div class="col-6 mt-1 col-md-3" id="img-box-${i.id}">
                                    <video width="100%" height="80%"
                                               controls="controls">
                                            <source src="${i.url}" type="video/mp4"/>
                                        </video>
                            </div>
                            `;
                        }

                    }
                    $('#list-img').html(html);




                    $('.portfolioContainer').each(function() { // the containers for all your galleries
                        $(this).magnificPopup({
                            delegate: 'a.image-popup', // the selector for gallery item
                            type: 'image',
                            gallery: {
                                enabled:true
                            }
                        });
                    });
                    setTimeout(function(){ $('#gh-loader').hide() }, 1500);
                }
            });
        });


    });
</script>