<?php

$check_contract = in_array($this->auth['role_code'], ['human-resources','product-manager', 'ceo', 'customer-care']);
$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

$check_profile = false;
if(isYourPermission('Apartment', 'showProfile', $this->permission_set)){
    $check_profile = true;
}

$check_contract = false;
if(isYourPermission('Contract', 'createShow', $this->permission_set)){
    $check_contract = true;
}

$check_option = true;
$check_commission_rate = false;
$check_create_promotion = false;
if(isYourPermission('Apartment', 'showCommmissionRate', $this->permission_set)){
    $check_commission_rate = true;
}

if(isYourPermission('ApartmentPromotion', 'create', $this->permission_set)){
    $check_create_promotion = true;
}



$check_update_room = false;
if(isYourPermission('Room', 'updateEditable', $this->permission_set)){
    $check_update_room = true;

}
$show_sortable = false;
if(isYourPermission('Apartment', 'showSortable', $this->permission_set)){
    $show_sortable = true;
}

$check_modify = false;
if (isYourPermission($this->current_controller, 'update', $this->permission_set)) {
    $check_modify = true;
}

$randomName= ["Chôm chôm", "Đu đủ", "Su hào", "Nghé", "Nai", "Chuối Hột", "Sushi"];

$from_date = date("01-m-Y");
$to_month = date("m");
$to_year = date("Y");

$day_last = cal_days_in_month(CAL_GREGORIAN, $to_month, $to_year);
$to_date = $day_last."-".$to_month."-".$to_year;

$is_editable_apartment = false;
if($this->product_category === "APARTMENT_GROUP" && in_array($current_apartment["id"], $this->list_apartment_CRUD )){
    $is_editable_apartment = true;
}
if($this->product_category === "DISTRICT_GROUP" && in_array($current_apartment["district_code"], $this->list_district_CRUD )){
    $is_editable_apartment = true;
}

?>
<style>
    .bg-comment{
        background-color: #fcffd4;
    }

    @media (min-width: 768px) {
        .carousel-multi-item-2 .col-md-3 {
            float: left;
            width: 25%;
            max-width: 100%;
        }
    }

    .carousel-multi-item-2 .card img {
        border-radius: 2px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                        <li class="breadcrumb-item active">Danh sách dự án</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md text-center">
            <?php $this->load->view('components/list-navigation'); ?>
        </div>
    </div>

    <?php if($check_update_room): ?>
        <div class="row">
            <div class="col-md-12">
                <?php  $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?>
            </div>
            <div class="col-md-12  mt-3">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="text-primary"> <i class="mdi mdi-arrow-right-drop-circle-outline"></i> Cập nhật thông tin phòng</h4>
                            <div>
                                <select id="apartment_update_ready" class=" form-control">
                                    <option value="">Cập nhật thông tin phòng</option>
                                    <?php foreach ($list_apm_ready as $apm_move): ?>
                                        <option value="<?= $apm_move['id'] ?>"><?= $apm_move['address_street'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-primary"> <i class="mdi mdi-arrow-right-drop-circle-outline"></i> Ghim 1 Thông báo</h4>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" id="input-pin-notification" value="<?= $this->pin_notification['content'] ?>" class="form-control border border-info">
                                    <div class="text-success p-1" id="status-pin-notification"></div>
                                </div>
                                <div class="col-2">
                                    <button id="update-pin-notification" class="btn pull-right btn-danger waves-effect" >Ghim</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-primary"> <i class="mdi mdi-arrow-right-drop-circle-outline"></i>Tuỳ chọn khác... [?]</h4>
                            <div class="row">
                                <div class="col-12">
                                    <button id="update-time_available" class="btn btn-danger pull-right waves-effect" >Xoá ngày sắp trống <i>đã cũ</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <hr>
    <?php else: ?>
        <div class="row">
            <div class="col-md-12">
                <?php  $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?>
            </div>
        </div>

    <?php endif;?>

    <div class="row">
        <div class="col-12">
            <h2 class="font-weight-bold text-danger">Danh sách dự án Q. <?= $libDistrict->getNameByCode($district_code) ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card-box">
                <h4 class="header-title mb-4">Danh sách dự án</h4>

                <ul
                    class="list-unstyled slimscroll mb-0"
                    style="max-height: 370px"
                >
                    <?php foreach ($list_apartment as $apm): ?>
                    <li class="mb-3">
                        <h5 class="font-weight-bold"> <i class="mdi mdi-bookmark"></i><?= $apm['address_street'] ?></h5>
                        <div class="text-right text-muted"><?= date('d/m/Y H:i', $this->ghApartment->getUpdateTimeByApm($apm['id'])) ?></div>
                        <div class="clearfix"></div>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="col-md-9">

            <div class="card-box">
                <div class="d-flex justify-content-center flex-wrap ">
                    <?php
                    foreach($list_district as $district):
                        $district_btn = 'btn-outline-success';
                        ?>

                        <a href="<?= base_url().'admin/list-apartment?district-code='.$district['code'] ?>"
                           class="btn m-1 btn-sm <?= $district_btn ?>
                        <?= $district_code == $district['code'] ? 'active':'' ?>
                        btn-rounded waves-light waves-effect">
                            Q. <?= $district['name'] ?> </a>

                    <?php endforeach; ?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 mt-2 mb-1">
                        <div class="card m-b-30">
                            <h2 class="font-weight-bold text-danger"><?= $current_apartment['address_street'] ?></h2>
                        </div>
                    </div>
                    <!--BUTTONS ACTioNS-->
                    <div class="col-12 list-action mt-2" >
                        <h4 class="font-weight-bold text-danger">Tuỳ chọn</h4>
                        <div class="text-md-right text-center">
                            <?php if($is_editable_apartment): ?>
                                <a class="m-1" href="/admin/apartment/duplicate?id=<?= $current_apartment['id'] ?>" >
                                    <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-credit-card-multiple"></i> </button>
                                </a>
                                <a class="m-1" href="/admin/profile-apartment?id=<?= $current_apartment['id'] ?>" >
                                    <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-lead-pencil"></i> <span class="d-none d-md-inline"></span></button>
                                </a>


                                <a href="/admin/room/show-create?apartment-id=<?= $current_apartment['id'] ?>">
                                    <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-lead-pencil"></i> P </button></a>

                            <?php endif;?>


                            <span class="m-1"><button data-address="<?= $current_apartment['address_street'] ?>"
                                                      data-apm="<?= $current_apartment['id'] ?>"
                                                      class="btn report-issue-apm-info btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-alert-box"></i> <span class="d-none d-md-inline"></span></button></span>
                            <a href="/admin/download-all-image-apartment?apm=<?= $current_apartment['id'] ?>"><button class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-cloud-download"></i> Tải Full Ảnh</button></a>

                            <a class="m-1" href="/sale/apartment-export?id=<?= $current_apartment['id'] ?>" >
                                <button class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-file-excel"></i> <span class="d-none d-md-inline"></span></button>
                            </a>

                            <button type="button" class="btn m-1 apm-plus-view btn-sm btn-outline-danger btn-rounded waves-light waves-effect"
                                    data-toggle="collapse"
                                    data-apartment-id="<?=$current_apartment['id'] ?>"
                                    data-parent="#accordion"
                                    aria-controls="#modal-apartment-detail-<?=$current_apartment['id'] ?>"
                                    data-target="#modal-apartment-detail-<?=$current_apartment['id'] ?>">
                                <i class="mdi mdi-eye"></i> <span class="d-none d-md-inline"></span></button>

                            <a data-souce="image" href="/admin/apartment/show-image?apartment-id=<?= $current_apartment['id'] ?>" target="_blank">
                                <button type="button"
                                        data-apartment-id="<?=$current_apartment['id'] ?>"
                                        class="btn m-1 apm-plus-view  btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                    <i class="mdi mdi-folder-multiple-image"></i> <span class="d-none d-md-inline"></span>
                                </button>
                            </a>

                            <?php if($check_consultant_booking): ?>
                                <a href="<?= base_url() ?>admin/create-new-consultant-booking?apartment-id=<?= $current_apartment['id'] ?>&district-code=<?= $current_apartment['district_code'] ?>&mode=create">
                                    <button type="button" class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                        <i class="mdi mdi-car-hatchback"></i> <span class="d-none d-md-inline"></span>
                                    </button>
                                </a>
                            <?php endif; ?>
                        </div>
                        <hr>
                    </div>
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Mô tả</h4>
                        <blockquote class="blockquote">
                            <p class="mb-0"><?= $current_apartment['description'] ?></p>
                        </blockquote>
                    </div>
                    <?php
                    $list_promotion = $ghApartmentPromotion->get(['apartment_id' => $current_apartment['id'], 'end_time >=' => strtotime(date('d-m-Y'))]);
                    if(count($list_promotion) > 0): ?>
                        <div class="col-12">
                            <h4 class="font-weight-bold text-danger">Ưu đãi</h4>
                            <div class="mb-3"></div>
                            <?php foreach ($list_promotion as $promotion):  ?>
                                <div class="p-1 apm-description mb-1" style="white-space: pre-line; background:#fee69c">
                                    <h5 class="text-warning bg-dark p-2 text-center mb-0">
                                        <?= $promotion['title'] ?>
                                    </h5>
                                    <div class="text-center"><?= date("d/m/Y",$promotion['start_time']) ." . " .date("d/m/Y",$promotion['end_time']) ?></div>
                                    <?= $promotion['description'] ? $promotion['description'] : '' ?>

                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Cọc & Hoa Hồng</h4>
                    </div>
                    <?php if(!in_array('deposit', $hidden_service)): ?>
                        <div class="col-md-3 col-6 mb-4">
                            <div><?= $label_apartment['deposit'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['deposit'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('commission_rate', $hidden_service)): ?>
                        <div class="col-md-3 col-6 mb-4">
                            <div><?= $label_apartment['commission_rate'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['commission_rate'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('commission_rate_9m', $hidden_service)): ?>
                        <div class="col-md-3 col-6 mb-4">
                            <div><?= $label_apartment['commission_rate_9m'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['commission_rate_9m'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('commission_rate_6m', $hidden_service)): ?>
                        <div class="col-md-3 col-6 mb-4">
                            <div><?= $label_apartment['commission_rate_6m'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['commission_rate_6m'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('contract_long_term', $hidden_service)): ?>
                        <div class="col-md-3 col-6 mb-4">
                            <div><?= $label_apartment['contract_long_term'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['contract_long_term'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('contract_short_term', $hidden_service)): ?>
                        <div class="col-md-3 col-6 mb-4">
                            <div><?= $label_apartment['contract_short_term'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['contract_short_term'] ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Dịch vụ</h4>
                    </div>
                    <?php $this->load->view('apartment/components/service-info') ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Danh sách phòng</h4>
                    </div>
                    <div class="col-12">
                        <?php $this->load->view('apartment/room',[
                            'apartment' => $current_apartment,
                            'libRoom' => $libRoom,
                            'check_option' =>$check_option,
                            'check_contract' =>$check_contract,
                            'check_consultant_booking' => $check_consultant_booking,
                            'ghApartmentShaft' => $ghApartmentShaft
                        ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Ảnh / Video | Dịch vụ & Tiện ích xung quanh </h4>
                    </div>
                    <div class="col-12">
                        <?php $this->load->view('apartment/components/gallery-service') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Ảnh / Video | Phòng</h4>
                    </div>
                    <?php
                    $list_room = $libRoom->getByApartmentIdAndActive($current_apartment['id']);
                    ?>
                    <div class="col-md-12">
                    <?php foreach ($list_room as $_room):?>
                            <button type="button"
                                    data-id="<?= $_room['id'] ?>"
                                    class="btn m-1 btn-secondary waves-light room-code waves-effect"> <?= $_room['code'] ?> (10)</button>
                    <?php endforeach;?>
                    </div>
                    <div class="col-12">
                        <?php $this->load->view('apartment/components/gallery-room') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    commands.push(function () {
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

        $('.img-room-code').click(function () {
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

        $('.list-room').DataTable({
            columnDefs: [
                { type: 'sort-numbers-ignore-text', targets : 0 }
            ],
            pageLength: 5
        });
        function sortNumbersIgnoreText(a, b, high) {
            var reg = /[+-]?((\d+(\.\d*)?)|\.\d+)([eE][+-]?[0-9]+)?/;
            a = a.match(reg);
            a = a !== null ? parseFloat(a[0]) : high;
            b = b.match(reg);
            b = b !== null ? parseFloat(b[0]) : high;
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        }
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "sort-numbers-ignore-text-asc": function (a, b) {
                return sortNumbersIgnoreText(a, b, Number.POSITIVE_INFINITY);
            },
            "sort-numbers-ignore-text-desc": function (a, b) {
                return sortNumbersIgnoreText(a, b, Number.NEGATIVE_INFINITY) * -1;
            }
        });
    })
</script>
