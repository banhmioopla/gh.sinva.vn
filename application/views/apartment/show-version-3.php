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
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">test</a></li>
                        <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                        <li class="breadcrumb-item active">Starter</li>
                    </ol>
                </div>
                <h2 class="font-weight-bold text-danger">Dự án</h2>
            </div>
        </div>
    </div>
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
            <div class="card-box">
                <div class="row">
                    <div class="col-12"><h4 class="font-weight-bold text-danger">Hợp đồng sắp hết hạn (30 ngày)</h4></div>

                    <?php foreach($list_customer["customers"] as $row ):
                        $contract_checker = $this->ghCustomer->getCustomerOfExpireDays(30, $row['id'], $this->auth['account_id']);
                        if($contract_checker !== false):
                            $contract_apartment = $this->ghApartment->getFirstById($contract_checker['apartment_id']);
                            ?>
                            <div class="col-12 col-md-6">
                                <div class="alert alert-danger" role="alert">
                                    Hợp đồng sắp hết hạn <?= $contract_apartment['address_street'] ?>  - ngày hết hạn: <?= date("d/m/Y", $contract_checker['time_expire']) ?>,
                                    <a href="/admin/detail-contract?id=<?= $contract_checker['id'] ?>" target="_blank">Link hợp đồng</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-12"><h4 class="font-weight-bold text-danger">KH sắp đến sinh nhựt (10 ngày)</h4></div>

                    <?php foreach($list_customer["customers"] as $row ):
                        $customer_checker = $this->ghCustomer->getCustomerBirthDateOfRemainDays(10, $row['id']);
                        if($customer_checker !== false):

                            ?>
                            <div class="col-12 col-md-6">
                                <div class="alert alert-danger" role="alert">
                                    KH <?= $customer_checker['name'] ?>  - sinh nhật: <?= date("d/m/Y", $customer_checker['birthdate']) ?>,
                                    <a href="/admin/detail-customer?id=<?= $customer_checker['id'] ?>" target="_blank">Link KH</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card-box">
                <div class="col-12">
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
                </div>
                <div class="col-12">
                    <h4 class="font-weight-bold text-center text-danger">Danh sách dự án Q. <?= $this->libDistrict->getNameByCode($district_code) ?></h4>
                </div>

                <ul
                    class="list-unstyled slimscroll mb-0"
                    style="max-height: 300px"
                >
                    <?php foreach ($list_apartment as $apm): ?>
                    <li class="mb-3">
                        <h5 class="font-weight-bold"><a href="/admin/list-apartment?current_apm_id=<?= $apm['id'] ?>"><i class="mdi mdi-bookmark"></i> <?= $apm['address_street'] ?></a> </h5>
                        <div class="text-right text-muted"><i class="mdi mdi-clock"></i> <?= date('d/m/Y H:i', $this->ghApartment->getUpdateTimeByApm($apm['id'])) ?></div>
                        <div class="clearfix"></div>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12  mt-2 mb-1">
                        <div class="card m-b-30 bg-dark">
                            <h2 class="font-weight-bold pl-2 text-warning"><?= $current_apartment['address_street'] ?></h2>
                        </div>
                    </div>
                    <!--BUTTONS ACTioNS-->
                    <div class="col-12 list-action mt-2" >
                        <h4 class="font-weight-bold text-danger">Tuỳ chọn <i class="mdi mdi-settings"></i></h4>
                        <div class="text-md-right text-center">
                            <?php if($is_editable_apartment): ?>
                                <a class="m-1" href="/admin/apartment/duplicate?id=<?= $current_apartment['id'] ?>" >
                                    <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-credit-card-multiple"></i> Copy DA</button>
                                </a>
                                <a class="m-1" href="/admin/profile-apartment?id=<?= $current_apartment['id'] ?>" >
                                    <button class="btn btn-sm btn-outline-primary m-1 btn-rounded waves-light waves-effect"><i class="mdi mdi-lead-pencil"></i> DA</button>
                                </a>

                                <a href="/admin/room/show-create?apartment-id=<?= $current_apartment['id'] ?>">
                                    <button class="btn btn-sm btn-outline-primary m-1 btn-rounded waves-light waves-effect"><i class="mdi mdi-lead-pencil"></i> Phòng </button></a>

                            <?php endif;?>


                            <span class="m-1"><button data-address="<?= $current_apartment['address_street'] ?>"
                                                      data-apm="<?= $current_apartment['id'] ?>"
                                                      class="btn m-1 report-issue-apm-info btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-alert-box"></i></button></span>
                            <a href="/admin/download-all-image-apartment?apm=<?= $current_apartment['id'] ?>"><button class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-cloud-download"></i> Tải Full Ảnh</button></a>

                            <a class="m-1" href="/sale/apartment-export?id=<?= $current_apartment['id'] ?>" >
                                <button class="btn btn-sm m-1 btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-file-excel"></i> Excel</button>
                            </a>

                            <?php if($check_consultant_booking): ?>
                                <a href="<?= base_url() ?>admin/create-new-consultant-booking?apartment-id=<?= $current_apartment['id'] ?>&district-code=<?= $current_apartment['district_code'] ?>&mode=create">
                                    <button type="button" class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                        <i class="mdi mdi-car-hatchback"></i> Book
                                    </button>
                                </a>
                            <?php endif; ?>
                        </div>
                        <hr>
                    </div>
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Tổng quan</h4>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div> <i class="mdi mdi-cube"></i> Quản lý dự án</div>
                        <div class="font-weight-bold pl-2"><?= $this->libUser->getNameByAccountid($current_apartment['user_collected_id']) . " | ". $this->libUser->getPhoneByAccountid($current_apartment['user_collected_id']) ?></div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div> <i class="mdi mdi-cube"></i> Thời gian cập nhật</div>
                        <div class="font-weight-bold pl-2"><?= date("d/m/Y H:i",$this->ghApartment->getUpdateTimeByApm($current_apartment['id'])) ?></div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-2 col-4 text-success mb-4">
                                <div> <i class="mdi mdi-cube"></i> Trống</div>
                                <div class="font-weight-bold pl-2"><?= $this->ghRoom->getNumberByStatus($current_apartment['id'], "Available") ?></div>
                            </div>
                            <div class="col-md-2 col-4 text-danger mb-4">
                                <div> <i class="mdi mdi-cube"></i> Full</div>
                                <div class="font-weight-bold pl-2"><?= $this->ghRoom->getNumberByStatus($current_apartment['id'], "Full") ?></div>
                            </div>
                            <div class="col-md-2 col-4 text-warning mb-4">
                                <div> <i class="mdi mdi-cube"></i> Sắp trống</div>
                                <div class="font-weight-bold pl-2"><?= $this->ghRoom->getNumberByTimeavailable($current_apartment['id']) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Mô tả</h4>
                        <blockquote class="blockquote">
                            <?= $current_apartment['description'] ?>
                        </blockquote>
                    </div>
                    <?php
                    $list_promotion = $this->ghApartmentPromotion->get(['apartment_id' => $current_apartment['id'], 'end_time >=' => strtotime(date('d-m-Y'))]);
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
                        <h4 class="font-weight-bold text-danger" data-toggle="collapse" aria-expanded="true"
                            aria-controls="commission-info" href="#commission-info">Cọc & Hoa Hồng <i class="mdi mdi-arrow-down-drop-circle-outline"></i></h4>
                    </div>
                    <div class="col-12 collapse" id="commission-info" >
                        <div class="row">
                            <?php if(!in_array('deposit', $hidden_service)): ?>
                                <div class="col-md-3 col-6 mb-4">
                                    <div> <i class="mdi mdi-cube"></i> <?= $label_apartment['deposit'] ?></div>
                                    <div class="font-weight-bold pl-2"><?= $current_apartment['deposit'] ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if(!in_array('commission_rate', $hidden_service)): ?>
                                <div class="col-md-3 col-6 mb-4">
                                    <div><i class="mdi mdi-cube"></i> <?= $label_apartment['commission_rate'] ?>%</div>
                                    <div class="font-weight-bold pl-2"><?= $current_apartment['commission_rate'] ?>%</div>
                                </div>
                            <?php endif; ?>

                            <?php if(!in_array('commission_rate_9m', $hidden_service)): ?>
                                <div class="col-md-3 col-6 mb-4">
                                    <div><i class="mdi mdi-cube"></i> <?= $label_apartment['commission_rate_9m'] ?>%</div>
                                    <div class="font-weight-bold pl-2"><?= $current_apartment['commission_rate_9m'] ?>%</div>
                                </div>
                            <?php endif; ?>

                            <?php if(!in_array('commission_rate_6m', $hidden_service)): ?>
                                <div class="col-md-3 col-6 mb-4">
                                    <div><i class="mdi mdi-cube"></i> <?= $label_apartment['commission_rate_6m'] ?>%</div>
                                    <div class="font-weight-bold pl-2"><?= $current_apartment['commission_rate_6m'] ?>%</div>
                                </div>
                            <?php endif; ?>

                            <?php if(!in_array('contract_long_term', $hidden_service)): ?>
                                <div class="col-md-3 col-6 mb-4">
                                    <div><i class="mdi mdi-cube"></i> <?= $label_apartment['contract_long_term'] ?></div>
                                    <div class="font-weight-bold pl-2"><?= $current_apartment['contract_long_term'] ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if(!in_array('contract_short_term', $hidden_service)): ?>
                                <div class="col-md-3 col-6 mb-4">
                                    <div><i class="mdi mdi-cube"></i> <?= $label_apartment['contract_short_term'] ?></div>
                                    <div class="font-weight-bold pl-2"><?= $current_apartment['contract_short_term'] ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger" data-toggle="collapse" aria-expanded="true" aria-controls="service-info" href="#service-info">Dịch vụ <i class="mdi mdi-arrow-down-drop-circle-outline"></i></h4>
                    </div>
                    <div class="col-12">
                        <?php $this->load->view('apartment/components/service-info') ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Danh sách phòng</h4>
                    </div>
                    <div class="col-12">
                        <?php $this->load->view('apartment/room',[
                            'apartment' => $current_apartment,
                            'libRoom' => $this->libRoom,
                            'check_option' =>$check_option,
                            'check_contract' =>$check_contract,
                            'check_consultant_booking' => $check_consultant_booking,
                            'ghApartmentShaft' => $this->ghApartmentShaft
                        ]) ?>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Ảnh / Video | Dịch vụ & Tiện ích xung quanh </h4>
                        <form action="/admin/ajax/gallery/upload-img/service"
                              method="POST" enctype="multipart/form-data">
                            <div class="form-group m-b-0">
                                <div class="row">
                                    <div class="col-md-9 text-right">
                                        <input type="file" class="filestyle" name="files[]"
                                               required
                                               multiple
                                               data-placeholder="No file"
                                               data-btnClass="btn-light">
                                        <input type="hidden" name="apartment_id" value="<?= $current_apartment['id'] ?>" >
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-1 text-center">
                                        <button type="submit" class="btn btn-danger">Up Ảnh</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <?php $this->load->view('apartment/components/gallery-service') ?>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Ảnh / Video | Phòng</h4>
                        <form action="/admin/apartment/upload-img"
                              method="POST" enctype="multipart/form-data">
                            <div class="form-group m-b-0">
                                <div class="row">
                                    <div class="col-9 mb-2">
                                        <p class="mb-2 font-weight-bold text-danger">Vui lòng chọn mã phòng</p>
                                        <select name="room_id[]" required class="form-control select2-multiple" multiple="multiple">
                                            <option value="">Vui lòng chọn mã phòng...</option>
                                            <?php foreach ($cb_room as $index => $room): ?>
                                                <option value="<?= $room['value'] ?>"> <?= $room['text'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="col-9 text-right">
                                        <input type="file" class="filestyle" name="files[]" required multiple data-placeholder="No file"
                                               data-btnClass="btn-light">
                                        <input type="hidden" name="apartment_id" value="<?= $current_apartment['id'] ?>" >
                                    </div>
                                    <div class="col-3 text-center">
                                        <button type="submit" class="btn btn-danger">Up Ảnh</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <?php
                    $list_room = $this->libRoom->getByApartmentIdAndActive($current_apartment['id']);
                    ?>
                    <div class="col-md-12">
                    <?php foreach ($list_room as $_room):
                        $img_count = $this->ghImage->get([
                            'room_id' => $_room['id'],
                            'controller' => 'Apartment',
                            'active' => 'YES'
                        ]);
                        $img_count = count($img_count) > 0 ? ' ('.count($img_count).')': '';
                        ?>
                            <button type="button"
                                    data-id="<?= $_room['id'] ?>"
                                    class="btn m-1 btn-secondary waves-light room-code waves-effect"> <?= $_room['code'] . $img_count?></button>
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
        $('.select2-multiple').select2();
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
