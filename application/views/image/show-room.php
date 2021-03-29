<?php
$role_delete = ['product-manager', 'customer-care', 'business-manager'];
$check_modify = false;
if (isYourPermission($this->current_controller, 'update', $this->permission_set)) {
    $check_modify = true;
}
include VIEWPATH . 'functions.php';
?>

<div class="wrapper mb-5">
    <div class="container">

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
                    <h2 class="text-danger font-weight-bold">Hình Ảnh <?= $apartment_model['address_street'] ?></h2>
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

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="portfolioFilter text-center gallery-second">
                    <a href="#" data-filter="*" class="current bg-warning">Tất cả</a>
                    <?php
                    $i = 0;
                    foreach ($list_room_code as $room):
                        $status = 'border';
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
                <button type="submit" class="btn m-1 btn-sm btn-outline-danger
                            btn-rounded waves-light waves-effect download-all">
                    <i class="mdi mdi-cloud-download"></i> Tải Về Tất Cả
                </button>
            </div>
        </div>
        <div class="row d-none" id="create-post">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-danger font-weight-bold text-right">Tiêu Đề</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="post_title"
                                   value="<?= $apartment_model['address_street'] ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-2 col-form-label text-danger font-weight-bold text-right">Nội Dung</label>
                        <div class="col-8">
                            <?php
                            $post_content = $apartment_model['note'];
                            ?>
                            <textarea class="form-control" id="post_content" placeholder="Helping text"><?= $post_content ?></textarea>
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
                <div class="portfolioContainer" id="portfolioContainer"></div>
            </div> <!-- End row -->
        </form>


    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function () {
        $(window).on('load', function () {
            let $container = $('.portfolioContainer');
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

                let selector = $(this).attr('data-filter');
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

            console.log("LOAD IMG AJAX");
            let ajax_room_id = '<?= $this->input->get("room-id") ?>';
            let ajax_apartment_id = '<?= $this->input->get("apartment-id") ?>';
            $.ajax({
                url: '/ajax/get-room-images',
                data: {room_id : ajax_room_id, apartment_id: ajax_apartment_id},
                success: function(data){
                    let img_data = JSON.parse(data);
                    let html = ``;
                    for(let img of img_data.list) {
                        let img_room_id = "roomcode-"+ajax_room_id;
                        let img_name = "<?= base_url() ?>media/apartment/"+img.name;
                        let img_id = img.id;
                        html += `<div class="col-sm-6 col-md-2 ${img_room_id}
                             image-item">
                                 <input type="hidden" name="list_id[]"
                                               value="${img_id}">
                                 <a href="${img_name}" class="thumb-img img-fluid">
                                     <div class="portfolio-masonry-box"
                                             data-img-id="${img_id}">
                                         <img src="${img_name}" class="thumb-img img-fluid" />
                                     </div>
                                 </a>
                             </div>
                        `;
                    }
                    $('#portfolioContainer').append(html);
                }
            });

        });
    });

</script>