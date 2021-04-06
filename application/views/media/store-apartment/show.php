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
    'apartment' => $apartment_model
];
?>


<?php
include VIEWPATH . 'functions.php';
?>
<style>
    .portfolioFilter a.current{
        background: #fccf51;
        border-bottom: solid red 4px;
    }
    .portfolioFilter a:hover {
        background-color: #fccf51;
    }
</style>

<div class="wrapper mb-5">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="text-danger font-weight-bold"><?= $apartment_model['address_street'] ?></h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <?php $this->load->view('components/list-navigation'); ?>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-6 col-md-3">
                <div class="card-box">
                    <div class="upload-section">
                        <form method="post" enctype="multipart/form-data"
                              class='form-group row'
                              action="/admin/upload-image?apartment-id=<?= $this->input->get('apartment-id') ?>">
                            <div class="col-12">
                                <h4 class="font-weight-bold text-danger">Upload</h4>
                                <select class="custom-select mt-3 form-control"
                                        name="room_id">
                                    <?= $cb_room_code ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-12 choose-img">
                                <div class="demo-box">
                                    <div class="form-group">
                                        <p class="mb-2 mt-4 font-weight-bold text-muted">
                                            Chọn Ảnh Từ Máy</p>
                                        <input type="file"
                                               required
                                               class="filestyle"
                                               name="files[]" multiple
                                               data-input="false"
                                               data-btnClass="btn-danger ">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-12 btn-upload">
                                <button type="submit" name="fileSubmit" value="UPLOAD"
                                        class="w-100 btn btn-custom waves-effect waves-light">
                                    Up Ảnh
                                </button>
                            </div>
                        </form>
                    </div> <!-- end row -->
                </div> <!-- end card-box -->
            </div> <!-- end col -->
            <div class="col-6 col-md-3">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Danh Sách Bài Đăng Tư Vấn</h4>
                    <ul class="list-post">
                        <?php foreach ($list_post as $post):?>
                        <li>
                            <a href="/public/consulting-post-detail?id=<?= $post['id'] ?>" target="_blank"><?= $post['title'] ? $post['title']:"[không tiêu đề]" ?></a> -  <small>Ngày <?= date('d/m/Y', $post['time_create']) ?></small>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <div class="card">
                        <div class="card-header mt-0" role="tab" id="headingOne">
                            <h5 class="mb-0 mt-0">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="font-weight-bold text-danger" aria-expanded="true" aria-controls="collapseOne">
                                    Thông Tin Dịch Vụ
                                </a>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="card-body service-list" style="background-color: #faf0ac;">
                                <div id="carouselButton-<?= $apartment_model['id'] ?>" class="carousel slide" data-interval="false" data-ride="carousel">
                                    <div class="carousel-inner" style="font-size: 11px; line-height: .9">
                                        <?php $this->load->view('apartment/service', $view_service) ?>
                                    </div>
                                    <a class="carousel-control-prev"
                                       href="#carouselButton-<?= $apartment_model['id'] ?>"
                                       role="button"
                                       data-slide="prev"><i class="dripicons-chevron-left text-danger"></i> </a>
                                    <a class="carousel-control-next"
                                       href="#carouselButton-<?= $apartment_model['id'] ?>"
                                       role="button"
                                       data-slide="next"><i class="dripicons-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 ">
                <div class="portfolioFilter text-center gallery-second">
                    <a href="#" data-filter="*" class="current bg-light">Tất cả</a>
                    <?php
                    $i = 0;
                    foreach ($list_room_code as $room):
                        $status = '';
                        $status_text = ' - <i class="text-dark">' . view_money_format($room['price'], 1) . '</i>';
                        if ($room['status'] == 'Available') {
                            $status .= ' text-success';
                        } else {
                            $status .= ' text-dark';
                        }

                        if ($room['time_available'] > 0) {
                            $status_text .= ' <span class="text-warning"> ' . date('d/m/Y', $room['time_available']) . '</span>';
                        }

                        ?>
                        <a href="#" class="font-weight-bold <?= $status ?>"
                           id="roomcode-<?= $room['id'] ?>"
                           data-filter=".roomcode-<?= $room['id'] ?>"
                           data-room-id="<?= $room['id'] ?>">
                            <?= $room['code'] . $status_text ?>
                        </a>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-2 text-center">
                <button type="submit" class="btn m-1 btn-sm btn-outline-warning
                            btn-rounded waves-light waves-effect download-all">
                    <i class="mdi mdi-cloud-download"></i> Tải Về Tất Cả
                </button>
            </div>
        </div>
        <div class="row" id="create-post">
            <div class="col-md-6 offset-md-3">
                <div class="card-box">
                    <p>Bài đăng được tạo dành cho tư vấn khách hàng, để tạo bài đăng, vui lòng chọn hình bạn muốn gửi bằng cách check vào checkbox của hình đó, nhập tiêu đề, nội dung, và click  <small class="text-danger">Tạo Bài Tư Vấn</small></p>
                    <div class="form-group row">
                        <label class="col-4 col-form-label text-danger font-weight-bold text-right">Tiêu Đề Bài Tư Vấn</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="post_title"
                                value="">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-4 col-form-label text-danger font-weight-bold text-right">Mô Tả Thêm</label>
                        <div class="col-8">
                            <?php
                            $post_content = "";
                            ?>
                            <textarea class="form-control" id="post_content" placeholder="Mô tả thêm"><?= $post_content ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row d-none">
                        <label class="col-2 col-form-label text-danger font-weight-bold text-right">Mật Khẩu Xem Bài</label>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Mật Khẩu Xem Bài" id="post_password">
                            <input type="hidden" id="post_room_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12"><div id="notification"></div></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 text-center">
                            <button type="button" id="submit_consultant_post" class="btn btn-danger waves-effect waves-light">Tạo Bài Tư Vấn</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <form name="form-download" id="form-download" action="/admin/download-image-apartment" method="post">
            <div class="port">

                <div class="portfolioContainer">
                    <?php if ($list_img): ?>

                        <?php foreach ($list_img as $img): ?>
                            <div class="col-sm-6 col-md-2
                            <?= !empty($img['room_id']) ? 'roomcode-' . $img['room_id'] : '' ?> image-item">
                                <?php
                                $imgStatus = $img['status'] == 'Pending' ? 'warning' : '';

                                if (!in_array($img['file_type'], ['mp4', 'mov'])):
                                    ?>
                                    <input type="hidden" name="list_id[]"
                                           value="<?= $img['id'] ?>">
                                    <div class="portfolio-masonry-box"
                                         data-img-id="<?= $img['id'] ?>">
                                        <a href="<?= base_url() ?>media/apartment/<?= $img['name'] ?>"
                                           class="image-popup">
                                            <div class="portfolio-masonry-img border border-<?= $imgStatus ?>"
                                                 style="border-width:3px">
                                                <img src="<?= base_url() ?>media/apartment/<?= $img['name'] ?>"
                                                     class="thumb-img img-fluid"
                                                     alt="work-thumbnail">
                                            </div>
                                        </a>
                                        <div class="portfolio-masonry-detail">
                                            <h4 class="font-18"><?= date('d-m-Y', $img['time_insert']) ?></h4>
                                            <div class="d-flex justify-content-center">
                                                <?php if ($check_modify): ?>
                                                    <button type="button" data-img-id="<?= $img['id'] ?>"
                                                            class="btn m-1 btn-sm
                                                            btn-outline-danger btn-rounded
                                                            waves-light waves-effect
                                                            delete-img">
                                                    <i class="mdi mdi-delete"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <a data-img-id="<?= $img['id'] ?>" class="btn m-1 btn-sm btn-outline-warning
                                                   btn-rounded waves-light waves-effect
                                                   download-img"
                                                download="<?= $apartment_model['address_street'] . '.' . $img['file_type'] ?>"
                                                   href="<?= base_url() ?>media/apartment/<?= $img['name'] ?>">
                                                <i class="mdi mdi-cloud-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-right border border-bottom">
                                                <div class="checkbox checkbox-success p-2">
                                                    <input id="checkbox-<?= $img['id'] ?>" value="<?= $img['id'] ?>" name="post_imgs" type="checkbox">
                                                    <label for="checkbox-<?= $img['id'] ?>">
                                                        Chọn Ảnh
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php else: ?>
                                    <div class="card-box m-1 shadow"
                                         id="video-box-<?= $img['id'] ?>">
                                        <video width="100%" height="80%"
                                               controls="controls">
                                            <source src="<?php echo base_url() . 'media/apartment/' . $img['name'] ?>"
                                                    type="video/mp4"/>
                                        </video>
                                        <div class="d-flex justify-content-center">
                                            <?php if ($check_modify): ?>
                                                <button type="button" data-img-id=<?=
                                                $img['id']
                                                ?> class="btn m-1 btn-sm
                                                        btn-outline-danger btn-rounded
                                                        waves-light waves-effect
                                                        delete-img">
                                                <i class="mdi mdi-delete"></i>
                                                </button>
                                            <?php endif; ?>

                                            <a data-img-id=<?= $img['id'] ?> class="btn
                                               m-1 btn-sm btn-outline-warning btn-rounded
                                               waves-light waves-effect download-img"
                                            download="<?= $apartment_model['address_street'] . '.' . $img['file_type'] ?>
                                            " href="<?= base_url() ?>
                                            media/apartment/<?= $img['name'] ?>">
                                            <i class="mdi mdi-cloud-download"></i>
                                            </a>
                                        </div>
                                    </div>

                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>


            </div> <!-- End row -->
        </form>


    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function () {
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
            <?php if($this->input->get('room-id')): ?>
                let get_room_id = '<?= $this->input->get('room-id') ?>';
                $('#roomcode-'+get_room_id).trigger('click');
            <?php endif; ?>

            $('.custom-select').select2();
        });
        $(document).ready(function () {
            $('#submit_consultant_post').click(function () {
                let img_id = [];
                $('input[name=post_imgs]:checked').each(function(){
                    img_id.push($(this).val())
                });
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
            $('.delete-img').click(function () {
                console.log($(this).data('img-id'));
                var img_id = $(this).data('img-id');
                var this_btn = $(this);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/update-image',
                    data: {img_id: img_id, field_name: 'active', field_value: 'NO'},
                    success: function (response) {
                        this_btn.parents('.portfolio-masonry-box').remove();
                        $('#video-box-' + img_id).remove();
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
    });

</script>