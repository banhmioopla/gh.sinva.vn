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
$hidden_service = !empty(json_decode($apartment['hidden_service'], true)) ? json_decode($apartment['hidden_service'], true) : [];

?>
<style>
    .bg-comment{
        background-color: #fcffd4;
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
                            <div id="carousel-apm" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="https://i.imgur.com/5eOsgoa.png" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="https://i.imgur.com/l5FwCIB.png" alt="Second slide">
                                    </div>
                                </div>

                                <a class="carousel-control-prev" href="#carousel-apm" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel-apm" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--BUTTONS ACTioNS-->
                    <div class="col-12 list-action  text-center text-md-right mt-2" >

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
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['deposit'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['deposit'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('commission_rate', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['commission_rate'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['commission_rate'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('commission_rate_9m', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['commission_rate_9m'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['commission_rate_9m'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('commission_rate_6m', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['commission_rate_6m'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['commission_rate_6m'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('contract_long_term', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['contract_long_term'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['contract_long_term'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('contract_short_term', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['contract_short_term'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['contract_short_term'] ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Dịch vụ</h4>
                    </div>
                    <?php if(!in_array('electricity', $hidden_service)): ?>
                    <div class="col-md-3 mb-4">
                        <div><?= $label_apartment['electricity'] ?></div>
                        <div class="font-weight-bold"><?= $current_apartment['electricity'] ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(!in_array('water', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['water'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['water'] ?></div>
                        </div>
                    <?php endif; ?>


                    <?php if(!in_array('internet', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['internet'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['internet'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('parking', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['parking'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['parking'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('management_fee', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['management_fee'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['management_fee'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('extra_fee', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['extra_fee'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['extra_fee'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('elevator', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['elevator'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['elevator'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('washing_machine', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['washing_machine'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['washing_machine'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('room_cleaning', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['room_cleaning'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['room_cleaning'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('number_of_people', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['number_of_people'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['number_of_people'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('kitchen', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['kitchen'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['kitchen'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('security', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['security'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['security'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('pet', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['pet'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['pet'] ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if(!in_array('car_park', $hidden_service)): ?>
                        <div class="col-md-3 mb-4">
                            <div><?= $label_apartment['car_park'] ?></div>
                            <div class="font-weight-bold"><?= $current_apartment['car_park'] ?></div>
                        </div>
                    <?php endif; ?>
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

            </div>
        </div>
    </div>

</div>
<script>
    commands.push(function () {
        var t_room = $('.list-room').DataTable({
            columnDefs: [
                { type: 'sort-numbers-ignore-text', targets : 0 }
            ],
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
