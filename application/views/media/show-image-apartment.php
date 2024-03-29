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
$arr_room_no_shaft = [];


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
    <div class="container-fluid">

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
            <div class="col-12 text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
            <div class="col-12 mt-1">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-4">
                            <strong class="text-info">Xem hình các dự án khác</strong>
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
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="card-box bg-danger widget-flat border-danger text-white">
                                <i class="mdi mdi-folder-multiple-image"></i>
                                <h3 class="m-b-10"><?= $counter ?></h3>
                                <p class="text-uppercase mb-2 font-13 font-600">
                                    Số Lượng Hình Ảnh
                                </p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card-box bg-danger widget-flat border-danger text-white">
                                <i class="mdi mdi-folder-multiple-image"></i>
                                <h3 class="m-b-10"><?= count($list_post) ?></h3>
                                <a href="/admin/consultant-post/your-list" class="btn btn-secondary pull-right">Đi đến kho bài đăng</a>
                                <p class="text-uppercase mb-2 font-13 font-600">
                                    Bài Đăng Tư Vấn
                                </p>
                            </div>
                        </div>
                        <div class="col text-center">
                            <a href="/admin/apartment/upload-img?apartment_id=<?= $apartment['id']?>"
                               class="btn-danger float-md-right mt-1 mt-md-0 btn text-center">Upload Ảnh Mới <i class="mdi mdi-cloud-upload"></i></a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12 shadow-sm">
                            <h4 class="text-danger font-weight-bold">Quản lý dự án</h4>
                            <div class="mb-2" style="white-space: pre-wrap;"><?= $apartment['user_collected_id'] ?
                                    ''.$this->libUser->getNameByAccountid($apartment['user_collected_id'])." - ".$this->libUser->getPhoneByAccountid($apartment['user_collected_id']):"SINVA" ?></div>
                        </div>

                        <div class="col-md-6 col-12 shadow-sm">
                            <h4 class="text-danger font-weight-bold">Thời gian cập nhật</h4>
                            <div class="mb-2" style="white-space: pre-wrap;"><?= date('d/m/Y H:i', $this->ghApartment->getUpdateTimeByApm($apartment['id'])) ?></div>
                        </div>

                        <div class="col-md-6 col-12 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Mô Tả</p>
                                <div class="mb-2" style="white-space: pre-wrap;"><?= $apartment['description'] ?></div>
                            </div>

                        </div>
                        <div class="col-md-6 col-12 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Ghi Chú Dự Án</p>
                                <div class="mb-2 " style="white-space: pre-wrap;"><?= $apartment['note'] ?></div>
                            </div>

                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Điện</p>
                                <h4 class="mb-2 text-wrap"><?= $apartment['electricity'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Nước</p>
                                <h4 class="mb-2 text-wrap"><?= $apartment['water'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Internet</p>
                                <h4 class="mb-2"><?= $apartment['internet'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Giữ xe</p>
                                <h4 class="mb-2"><?= $apartment['parking'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger ">Ra vào</p>
                                <h4 class="mb-2"><?= $apartment['management_fee'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Combo Phí</p>
                                <h4 class="mb-2"><?= $apartment['extra_fee'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Cọc Phòng</p>
                                <h4 class="mb-2"><?= $apartment['deposit'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Thang máy</p>
                                <h4 class="mb-2"><?= $apartment['elevator'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Máy Giặt</p>
                                <h4 class="mb-2"><?= $apartment['washing_machine'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Dọn Phòng</p>
                                <h4 class="mb-2"><?= $apartment['room_cleaning'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Số Người Ở</p>
                                <h4 class="mb-2"><?= $apartment['number_of_people'] ?></h4>
                            </div>
                        </div>

                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Bếp</p>
                                <h4 class="mb-2"><?= $apartment['kitchen'] ?></h4>
                            </div>
                        </div>

                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Bảo vệ</p>
                                <h4 class="mb-2"><?= $apartment['security'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 shadow-sm">
                            <div class="mt-3">
                                <p class="mb-0 text-danger">Thú cưng</p>
                                <h4 class="mb-2"><?= $apartment['pet'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="alert alert-light alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button> Click vào tiêu đề để hiện form! </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <h4 class="text-danger font-weight-bold"
                                data-toggle="collapse"
                                href="#consultantPostForm"
                            >Tạo Bài Đăng Tư Vấn <i class="mdi mdi-arrow-down-drop-circle"></i></h4>
                            <div id="consultantPostForm" class="collapse">
                                <strong class="text-danger">Tiêu Đề Bài Đăng</strong>
                                <input type="text" required id="post_title" class="form-control">

                                <strong class="text-danger">Mô Tả </strong>
                                <textarea type="text" id="post_content" class="form-control" rows="2"></textarea>

                                <div class="checkbox checkbox-danger  mt-1 text-center">

                                    <input id="slc-all-img"type="checkbox">
                                    <label for="slc-all-img">
                                        <strong class="text-danger">Chọn Tất Cả Ảnh </strong>
                                    </label>
                                </div>

                                <div class="text-center" id="notification"></div>
                                <input type="hidden" id="post_password" value="">
                                <input type="hidden" id="post_room_id">
                                <div class="text-center m-1">
                                    <button type="button" id="submit_consultant_post" class="btn btn-danger waves-effect waves-light">Tạo Bài Tư Vấn <i class="mdi mdi-library-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <h4 class="text-danger font-weight-bold"
                                data-toggle="collapse"
                                href="#uploadImgForm">Upload Ảnh <i class="mdi mdi-arrow-down-drop-circle"></i></h4>
                            <div class="row collapse" id="uploadImgForm" >
                                <form action="/admin/apartment/upload-img?apartment_id=<?= $apartment['id'] ?>" class="col-md-12" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="mb-2 mt-4 font-weight-bold text-danger">Vui lòng chọn mã phòng</p>
                                            <select name="room_id[]" required id="" class="form-control select2-multiple" multiple="multiple">
                                                <option value="">Vui lòng chọn mã phòng...</option>
                                                <?php foreach ($cb_room as $index => $room): ?>
                                                    <option value="<?= $room['value'] ?>"> <?= $room['text'] ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="form-group col-12">
                                            <p class="mb-2 mt-4 font-weight-bold text-danger">Vui Lòng Chọn Ảnh Từ Máy</p>
                                            <input type="file" name="files[]" required multiple class="filestyle" data-buttontext="Select file"
                                                   data-btnClass="btn-light">
                                            <p class="text-success p-2 bg-dark mt-2 text-center" id="upload-msg"> 0 ảnh được chọn</p>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-success">Upload <i class="mdi mdi-cloud-upload"></i></button>
                                        </div>

                                    </div>
                                </form>
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
                                Click vào mã phòng phía dưới để xem ảnh! <?= $link_has_shaft ?>
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
                                <?php if($has_shaft): ?>
                                    <div class="row">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs">
                                            <?php if($any_empty_shaft): ?>
                                            <li class="nav-item">
                                                <a href="#any_empty_shaft" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    <i class="mdi mdi-arrange-send-to-back"></i> [Không có trục]
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                            <?php foreach ($list_shaft as $shaft):?>
                                            <li class="nav-item">
                                                <a href="#shaft-<?= $shaft['id'] ?>" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                    <i class="mdi mdi-arrange-send-to-back"></i> <?= $shaft['name'] ?>
                                                </a>
                                            </li>

                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                                    <div class="tab-content">
                                        <?php if($has_shaft): ?>

                                            <?php foreach ($list_shaft as $shaft):
                                                ?>
                                                <div class="tab-pane" id="shaft-<?= $shaft['id'] ?>">
                                                    <div class="row" >
                                                        <?php
                                                        $i = 0;

                                                        foreach ($chain_room as $room):

                                                            if(!($shaft['id'] == $room['shaft'])) {
                                                                if(empty($room['shaft']) && !in_array($room, $arr_room_no_shaft)){
                                                                    $arr_room_no_shaft[] = $room;
                                                                }
                                                                continue;
                                                            }
                                                            ?>
                                                            <div class="col-6 col-md-3 pl-1 pr-1" >
                                                                <a href="#" class="text-left w-100 font-weight-bold border border-warning border-3 room-code"
                                                                   id="room-id-<?= $room['value'] ?>"
                                                                   data-filter=".room-id-<?= $room['value'] ?>"
                                                                   data-room-id="<?= $room['value'] ?>"><?= $room['display'] ?></a>
                                                            </div>

                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                            <?php if($any_empty_shaft):?>
                                                <div class="tab-pane" id="any_empty_shaft">
                                                    <div class="row" >
                                                        <?php
                                                        $i = 0;

                                                        foreach ($arr_room_no_shaft as $room):
                                                            ?>
                                                            <div class="col-6 col-md-3 pl-1 pr-1" >
                                                                <a href="#" class="text-left w-100 font-weight-bold border border-warning border-3 room-code"
                                                                   id="room-id-<?= $room['value'] ?>"
                                                                   data-filter=".room-id-<?= $room['value'] ?>"
                                                                   data-room-id="<?= $room['value'] ?>"><?= $room['display'] ?></a>
                                                            </div>

                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif;?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if(!$has_shaft):?>
                                    <div class="row">
                                    <?php
                                    foreach ($chain_room as $room):
                                    ?>
                                    <div class="col-6 col-md-3 pl-1 pr-1" >
                                        <a href="#" class="text-left w-100 font-weight-bold border border-warning border-3 room-code"
                                           id="room-id-<?= $room['value'] ?>"
                                           data-filter=".room-id-<?= $room['value'] ?>"
                                           data-room-id="<?= $room['value'] ?>"><?= $room['display'] ?></a>
                                    </div>

                                    <?php endforeach; ?>
                                    </div>

                                <?php endif; ?>
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

            $('.select2-multiple').select2();
            $('input[type=file]').change(function () {
                var files = $(this)[0].files;
                $('#upload-msg').text(files.length + ' ảnh được chọn.');
                console.log(files.length);
            });

            $("#slc-all-img").change(function () {
               if($("#slc-all-img").is(':checked')){
                    $('input[name=post_imgs]').attr('checked', true);
               } else {
                   $('input[name=post_imgs]').attr('checked', false);
               }
            });


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
                        if(!(i.url.includes(".mp4") || i.url.includes(".MOV"))) {
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
                            let link = "";
                            if(i.url.includes(".MOV")){
                                link = `<a href='${i.url}'>Chrome ko hỗ trợ, click tui để tải nhé!</a>`;
                            }
                            html += `
                            <div class="col-6 bg-white pt-1 mt-1 col-md-3" id="img-box-${i.id}">
                                    ${link}
                                    <video width="100%" height="80%" class="border"  controls="controls">
                                    <source src="${i.url}" type="video/mp4">
                                    </video>
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
