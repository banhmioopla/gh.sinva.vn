<?php
$product_category = $this->product_category;
$list_OPEN_APARTMENT = $this->list_OPEN_APARTMENT;
$list_OPEN_DISTRICT = $this->list_OPEN_DISTRICT;


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
    .item-feature {
        display:none;
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
    body.noscroll {
        overflow-y: hidden!important;
    }

</style>
<div class="container-fluid mt-4">
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
    <div class="row">
        <div class="col-12 d-block d-md-none">
            <?php $this->load->view('apartment/components/circle-menu'); ?>
        </div>
    </div>
    <?php if($check_update_room): ?>
        <div class="row">
            <div class="col-md-12 d-block d-md-none mt-3">
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
    <?php endif;?>
    <div class="row">
        <div class="col-12 ">

                <?php if(!empty($list_contract_30d_remain)): ?>
                    <div class="card-box d-none d-md-block">
                        <div class="row">
                            <div class="col-12"><h4 class="font-weight-bold text-danger"><i class=" mdi mdi-bell-outline"></i> Hợp đồng sắp hết hạn (30 ngày)</h4></div>

                            <?php foreach($list_contract_30d_remain as $row ):
                                $apm_30d_checker = $this->ghApartment->getFirstById($row['apartment_id']);
                                $room_checker = $this->ghRoom->getFirstById($row['room_id']);
                                ?>

                                <div class="col-12 col-md-4 mb-2">
                                    <div class="card  text-white bg-dark text-xs-center">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote">
                                                <strong><?= $apm_30d_checker['address_street'] ?> (<?= $room_checker["code"] ?>)</strong> <?= date("d/m/Y", $row['time_expire']) ?>
                                                <footer class="mt-2"><a href="/admin/detail-contract?id=<?= $row['id'] ?>" target="_blank" class="float-right btn-danger btn-rounded btn text-white">Chi tiết</a></cite>
                                                </footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php endif; ?>


                <?php if(!empty($list_customer_birth_10d_remain)): ?>
                    <div class="card-box d-none d-md-block">
                        <div class="row">
                            <div class="col-12"><h4 class="font-weight-bold text-danger"><i class="mdi mdi-bell-outline"></i> Sinh nhật khách (10 ngày)</h4></div>
                            <?php foreach($list_customer_birth_10d_remain as $row ):
                                ?>

                                <div class="col-12 col-md-4 mb-2">
                                    <div class="card  text-white bg-dark text-xs-center">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote">
                                                <strong><?= $row['name'] ?></strong> (<?= date("d/m/Y", $row['birthdate']) ?>)
                                                <footer class="mt-2"><a href="/admin/detail-customer?id=<?= $row['id'] ?>" target="_blank" class="float-right btn-danger btn-rounded btn text-white">Chi tiết</a></cite>
                                                </footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if(!empty($list_customer_birth_10d_remain)): ?>
                    <div class="card-box d-none d-md-block">
                        <div class="row">
                            <div class="col-12"><h4 class="font-weight-bold text-danger"> <i class="mdi mdi-bell-outline"></i> Dự án sắp trống (30 ngày)</h4></div>

                            <?php foreach ($list_apm_30d_available as $apm_move):
                                $apm_checker = $this->ghApartment->getApmWithTimeAvailableRemain(30, $apm_move['id']);

                                $room_info = []; $apm_model = $this->ghApartment->getFirstById($apm_move['id']);
                                foreach ($apm_checker as $room_checker):

                                    $room_info []= $room_checker['code'] . ' ('. date("d/m/Y", $room_checker['time_available']) . ') ';
                                endforeach; ?>

                                <div class="col-12 col-md-4 mb-2">
                                    <div class="card  text-white bg-dark text-xs-center">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote">
                                                <strong><?= $apm_model['address_street'] ?>:</strong>
                                                <?= implode(", ", $room_info) ?>
                                                <footer class="mt-2"><a href="/admin/list-apartment?current_apm_id=<?= $room_checker['apartment_id'] ?>" target="_blank" class="float-right btn-danger btn-rounded btn text-white">Chi tiết</a></cite>
                                                </footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php endif; ?>

            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <?php  $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <div class="row">
        <div class="col-12">



        </div>

        <div class="col-lg-3 col-12 d-md-block d-none">
            <div class="card-box list-feature">
                <div class="d-flex justify-content-center flex-wrap ">
                    <?php foreach ($list_features as $feature_k => $feature_v):
                        $active_element = "";
                        if(!empty($this->input->get('feature')) && $this->input->get('feature') == $feature_k){
                            $active_element = "active";
                        }
                        ?>
                        <a href="<?= base_url().'admin/list-apartment?feature='.$feature_k ?>"
                           class="btn m-1 btn-sm item-feature btn-rounded btn-outline-danger <?= $active_element ?> waves-light waves-effect"> <?= $feature_v ?> </a>
                    <?php endforeach;?>

                    <?php
                    foreach($list_district as $district):
                        $active_element = "";
                        if(!empty($current_apartment) && $district['code'] == $current_apartment["district_code"]){
                            $active_element = "active";
                        }
                        ?>

                        <a href="<?= base_url().'admin/list-apartment?district-code='.$district['code'] ?>"
                           class="btn m-1 btn-sm item-feature btn-outline-success <?= $active_element ?> btn-rounded waves-light waves-effect">
                            Q. <?= $district['name'] ?> </a>

                    <?php endforeach; ?>


                </div>
                <div class="d-flex justify-content-center flex-wrap border-bottom mt-2 mb-3">
                    <div class="m-1 loadMore badge badge-pill badge-primary"> <i class="fa fa-arrow-circle-down"></i> Mở rộng</div>
                    <div class="m-1 showLess badge badge-pill badge-primary"> <i class="fa fa-arrow-circle-up"></i> Thu gọn</div>
                </div>

                <h4 class="font-weight-bold text-center text-danger">Danh sách dự án Q. <?= $this->libDistrict->getNameByCode($district_code) ?></h4>
                <input type="text" placeholder="Tìm kiếm dự án, vui lòng nhập địa chỉ..." class="form-control search-address border border-info">

                <ul
                        class="list-unstyled slimscroll mb-0 mt-1"
                        style="max-height: 300px"
                >
                    <?php foreach ($list_apartment as $apm):
                        $count_available =  $this->ghRoom->getNumberByStatus($apm['id'], 'Available') > 0 ? '<div class="badge badge-success font-weight-bold ">'.$this->ghRoom->getNumberByStatus($apm['id'], 'Available').'</div>' : '';
                        $partner_name = '<span class="badge badge-primary mb-2 ml-2">'.$this->ghPartner->getNameById($apm['partner_id']).'</span> ';
                        $is_full_ribbon = $this->ghRoom->getNumberByStatus($apm['id'], 'Available') > 0 ? '' : 'ribbon-box';
                        $is_full_ribbon_html = $this->ghRoom->getNumberByStatus($apm['id'], 'Available') > 0 ? '' : '<div class="ribbon ribbon-dark"><span>Full</span></div>';
                    ?>
                        <li class="mb-3 address-item mt-1 mb-1 <?= $is_full_ribbon ?> card-header click-view" data-apm="<?= $apm['id'] ?>">
                            <?= $is_full_ribbon_html ?>
                            <h5 class="font-weight-bold"><a href="/admin/list-apartment?current_apm_id=<?= $apm['id'] ?>"><i class="mdi mdi-arrow-right-bold-circle-outline"></i> <?= $apm['address_street'] ?></a> </h5>
                            <div class="text-right text-danger"> <?= $partner_name . $count_available ?> <i class="mdi mdi-tag"></i> <?= implode(" - ",array_map(function($val) { return ($val /1000); } , $this->ghApartment->getRoomPriceRange($apm['id']))) ?> </div>
                            <div class="clearfix"></div>
                        </li>
                    <?php endforeach;?>
                </ul>

            </div>

            <div class="card-box">
                <h4 class="font-weight-bold text-center text-danger">Online hôm nay</h4>
                <?= $this->ghUser->getOnlineToday() ?>
            </div>
            <?php if(false):?>
            <div class="card-box">
                <?php $this->load->view('apartment/components/five-days-ago',[
                    'check_profile' => $check_profile
                ]) ?>
            </div>
            <?php endif; ?>
        </div>
        <?php if(empty($current_apartment)): ?>
            <div class="col-md-9 col-12">
                <div class="card-box">
                    <div class="alert alert-danger" role="alert">
                        Rất tiếc, Không tồn tại dự án!
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php if(!empty($current_apartment)): ?>
        <div class="col-lg-9 col-12">
            <!--DETAIL CURRENT APARTMENT-->

            <?php
            $apartment_score = $this->ghApartmentComment->getScoreByApm($current_apartment['id'], $from_date, $to_date);
            $list_comment = $this->ghApartmentComment->get(['apartment_id' => $current_apartment['id']]);
            $surrounding_facilities = !empty($current_apartment['surrounding_facilities']) ? json_decode($current_apartment['surrounding_facilities'], true) : [];
            $following = $this->ghApartmentUserFollow->isFollowing($current_apartment['id'], $this->auth['account_id']);
            $apm_full_address = "{$current_apartment['address_street']}";
            if(!empty($current_apartment['address_ward'])){
                $apm_full_address .= ", phường {$current_apartment['address_ward']}";
            }
            $apm_full_address .= ", quận {$this->libDistrict->getNameByCode($current_apartment['district_code'])}";
            $following_number = $this->ghApartmentUserFollow->getNumberFollow($current_apartment['id']) ? '<span class="badge badge-danger ml-2"><i class="fa fa-heart"></i> '.$this->ghApartmentUserFollow->getNumberFollow($current_apartment['id']).' theo dõi</span>' : '';
            $visit_account = count($this->ghApartment->visitedAccount($current_apartment['id'], ""))  ? '<small class="text-muted">Tuần này <strong>'.implode(", ", $this->ghApartment->visitedAccount($current_apartment['id'], "")).'</strong> đã ghé thăm</small>' : '';
            $partner_name = '<span class="badge badge-primary ml-2">'.$this->ghPartner->getNameById($current_apartment['partner_id']).'</span>';
            $list_similar = $this->ghApartment->getListAvailableApartmentSimilarity($current_apartment["id"]);

            ?>

            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <div class="float-right">
                            <div class="btn-group mb-2 dropleft">
                                <button type="button"
                                        class="btn btn-danger waves-effect waves-light dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tuỳ Chọn
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/admin/apartment/create"><i class="mdi mdi-comment-plus-outline"></i> Tạo dự án mới</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#setting"><i class="fi-cog"></i> Cài đặt dự án</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12  mt-2 mb-1">
                        <div class="card">
                            <h2 id="address-full" class="font-weight-bold text-danger"><iclass=" mdi mdi-home-map-marker"></i>  <?= $apm_full_address ?>
                                <button data-apm_id="<?= $current_apartment['id'] ?>"
                                        data-status_following="<?= json_encode($following) ?>"
                                        id="apm-following"
                                        class="btn btn-sm <?= $following ? 'active':'' ?>  float-right btn-outline-danger btn-rounded waves-light waves-effect"><i class="fa fa-heart"></i></button>
                            </h2>
                            <div class="pl-2">
                                <?= $visit_account ?>
                            </div>
                            <div class="pl-2">
                                <span class="rating-score" data-score="<?= $apartment_score ?>" data-apm-id="<?=$current_apartment['id']?>"> <span class="text-danger">(<?= count($list_comment) ?> bình luận)</span> </span>
                                <?= $partner_name ?>
                                <?= $following_number ?>
                            </div>
                        </div>
                    </div>

                    <!--BUTTONS ACTioNS-->
                    <div class="col-12 list-action" >
                        <div class="text-md-right text-center">
                            <?php if($this->ghRoom->getNumberByStatus($current_apartment['id'], "Available")): ?>
                            <button id="copy-room-info" data-apartment-id="<?= $current_apartment['id'] ?>"
                                    class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class=" mdi mdi-content-copy"></i> Copy P.trống</button>
                            <?php endif;?>
                            <?php if(!empty($current_apartment['zalo_group_url'])): ?>
                                <a class="m-1" href="<?= $current_apartment['zalo_group_url'] ?>" target="_blank">
                                    <button class="btn btn-sm btn-outline-primary m-1 btn-rounded waves-light waves-effect"><i class="mdi mdi-share-variant"></i> Zalo Group</button>
                                </a>
                            <?php endif; ?>

                            <?php if($is_editable_apartment): ?>
                                <!--<a class="m-1" href="/admin/apartment/duplicate?id=<?/*= $current_apartment['id'] */?>" >
                                    <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-credit-card-multiple"></i> Copy DA</button>
                                </a>-->
                                <a class="m-1" href="/admin/profile-apartment?id=<?= $current_apartment['id'] ?>" >
                                    <button class="btn btn-sm btn-outline-primary m-1 btn-rounded waves-light waves-effect"><i class="mdi mdi-tooltip-edit"></i> DA</button>
                                </a>

                                <a href="/admin/room/show-create?apartment-id=<?= $current_apartment['id'] ?>">
                                    <button class="btn btn-sm btn-outline-primary m-1 btn-rounded waves-light waves-effect"><i class="mdi mdi-tooltip-edit"></i> Phòng </button></a>

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
                    <div class="col-md-8">
                        <?= $this->ghContract->getAlertNewestByApartment($current_apartment["id"]) ?>
                    </div>

                    <div class="col-md-8">
                        <?= $this->ghApartment->isEmptyRoomPrice($current_apartment["id"]) ?>
                    </div>

                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger"><i class="mdi mdi-tag"></i> Giá: <?= implode(" - ",array_map(function($val) { return number_format($val); } , $this->ghApartment->getRoomPriceRange($current_apartment['id']))) ?></h4>
                        <div><small> <strong><?= count($list_similar) ?></strong> Dự án <strong class="text-success">đang trống</strong> có mức giá tương đồng , Click để xem dự án </small></div>
                        <div class="list-similar">
                            <?php
                            foreach($list_similar as $similar_id):
                                $sim_apm = $this->ghApartment->getFirstById($similar_id);
                                ?>
                                <a href="/admin/list-apartment?current_apm_id=<?= $similar_id ?>"> <span class="badge badge-secondary m-1"># <?= $sim_apm['address_street'] ?> <span class="text-dark"><?= implode(" - ",array_map(function($val) { return number_format($val/1000); } , $this->ghApartment->getRoomPriceRange($similar_id))) ?></span> </span></a>

                            <?php endforeach;?>
                        </div>

                    </div>


                    <div class="col-12 col-md-6 mt-md-2 mt-5">
                        <div class="justify-content-md-center">
                            <table class="table font-weight-bold table-dark">
                                <tbody>
                                <tr class="text-white">
                                    <th scope="row"><i class="mdi mdi-checkbox-blank-circle"></i></th>
                                    <td>
                                        <?php if($current_apartment['user_collected_id']):?>
                                            <?= "(QLDA) ". $this->libUser->getNameByAccountid($current_apartment['user_collected_id'])  ?>
                                        <?php endif;?>
                                    </td>
                                    <td class="text-right">
                                        <?php if($current_apartment['user_collected_id']):?>
                                            <div class="text-right"><?= "<i class='mdi mdi-phone-classic'></i> ". $this->libUser->getPhoneByAccountid($current_apartment['user_collected_id']) ?></div>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr class="text-white">
                                    <th scope="row"><i class="mdi mdi-checkbox-blank-circle"></i></th>
                                    <td>Tgian cập nhật</td>
                                    <td class="text-right"><?= date("d/m/Y H:i",$this->ghApartment->getUpdateTimeByApm($current_apartment['id'])) ?></td>
                                </tr>
                                <tr class="text-white">
                                    <th scope="row"><i class="mdi mdi-checkbox-blank-circle"></i></th>
                                    <td>Ngày nhập</td>
                                    <td class="text-right"><?= $current_apartment["time_insert"] > 0 ? date("d/m/Y",$current_apartment["time_insert"]) : "..." ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mt-md-2 mt-5">
                        <div class="justify-content-md-center">
                            <table class="table font-weight-bold table-dark">
                                <tbody>
                                <tr class="text-success">
                                    <th scope="row"><i class="mdi mdi-square "></i></th>
                                    <td>Trống</td>
                                    <td class="text-right"><?= $this->ghRoom->getNumberByStatus($current_apartment['id'], "Available") ?></td>
                                </tr>
                                <tr class="text-danger">
                                    <th scope="row"><i class="mdi mdi-square text-danger"></i></th>
                                    <td>Full</td>
                                    <td class="text-right"><?= $this->ghRoom->getNumberByStatus($current_apartment['id'], "Full") ?></td>
                                </tr>
                                <tr class="text-warning">
                                    <th scope="row"><i class="mdi mdi-square text-warning"></i></th>
                                    <td>Sắp trống</td>
                                    <td class="text-right"><?= $this->ghRoom->getNumberByTimeavailable($current_apartment['id']) ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Mô tả</h4>
                        <blockquote class="blockquote border p-1" style="white-space: pre-line">
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
                    <div class="col-12">
                        <?php foreach ($surrounding_facilities as $uu):?>
                            <span class="ml-2 badge badge-danger"><?= $uu ?></span>
                        <?php endforeach;?>
                    </div>
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
                        <h4 class="font-weight-bold text-danger">Danh sách phòng
                                <?php if($is_editable_apartment): ?>
                                    <a href="/admin/room/show-create?apartment-id=<?= $current_apartment['id'] ?>">
                                <button class="btn btn-sm btn-outline-primary float-right btn-rounded waves-light waves-effect"><i class="mdi mdi-tooltip-edit"></i> Phòng </button></a>
                                <?php endif;?>
                        </h4>
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
                        <h4 class="font-weight-bold text-danger">Ảnh / Video | Phòng <span class="float-right"><a href="/admin/download-all-image-apartment?apm=<?= $current_apartment['id'] ?>"><button class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-cloud-download"></i> Tải Full Ảnh</button></a>
</span></h4>
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
                        if(count($img_count) == 0) continue;
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
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Hợp đồng tháng <?= date("m/Y", strtotime($this->timeFrom)) ?></h4>
                    </div>
                    <?php foreach ($list_contract as $contract):
                        $room_info = $this->ghRoom->getFirstById($contract["room_id"]);
                        ?>
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                Phòng <strong><?= $room_info["code"] ?></strong>  <span class="float-right"> <i class=" mdi mdi-tag"></i> <strong><?= number_format($contract["room_price"]) ?></strong> | ký ngày: <?= date("d/m/Y", $contract["time_check_in"]) ?></span>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-danger">Bình luận</h4>
                    </div>
                    <?php foreach ($list_comment as $rating): ?>
                        <div class="col-12 mt-2">
                            <div class="comment-list">
                                <div class="comment-box-item p-2 bg-comment">
                                    <div class="rated-star" data-score="<?= $rating['score'] ?>"></div>
                                    <p class="commnet-item-date"><?= date("d/m/Y H:i",$rating['time_insert']) ?></p>
                                    <h6 class="commnet-item-msg">
                                        <?= $rating['content'] ?>
                                    </h6>
                                    <p class="commnet-item-user"><i class="mdi mdi-account-circle"></i> <?= $randomName[array_rand($randomName, 1)]; ?></p>
                                </div>

                            </div>
                        </div>
                    <?php endforeach;?>


                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php $this->load->view('apartment/components/modals') ?>
</div>
<script>
    commands.push(function () {
        // item-feature
        let feature_size_li = $(".list-feature .item-feature").length;
        let feature_x=5;
        $('.list-feature .item-feature:lt('+feature_x+')').show();
        $('.list-feature .loadMore').click(function () {
            feature_x= (feature_x+5 <= feature_size_li) ? feature_x+5 : feature_size_li;
            $('.list-feature .item-feature:lt('+feature_x+')').show();
        });
        $('.list-feature .showLess').click(function () {
            feature_x=(feature_x-5<0) ? 5 : feature_x-5;
            $('.list-feature .item-feature').not(':lt('+feature_x+')').hide();
        });

        $('.search-address').on('keyup', function(){
            let value = $(this).val().toLowerCase();
            $(".address-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $('#apm-following').on('click', function () {
            let _this = $(this);
            let status = $(this).data('status_following');
            let apm_id = $(this).data('apm_id');
            console.log("status ", status);
            console.log("!status ", !status);
            console.log("apm_id ", apm_id);
            $.ajax({
                url: '/admin/apartment/following/update',
                type: "POST",
                dataType: 'json',
                data: {apm_id: apm_id, status: !status},
                success: function (res) {
                    console.log("res", res);
                    _this.data('status_following', !status);
                    _this.removeClass("active");
                    if(!status === true){
                        _this.addClass("active");
                    }

                    
                }
            });

        });

        $('.rated-star').raty({
            score: function () {
                return $(this).data('score');
            },
            readOnly: true,
            starOff: 'fa fa-star-o text-danger',
            starOn: 'fa fa-star text-danger',
        });
        $('.rating-score').raty({
            starOff: 'fa fa-star-o text-danger',
            starOn: 'fa fa-star text-danger',
            click:function (score, evt) {
                let apm_id = $(this).data('apm-id');
                swal({
                    title: 'Xin comment ạ',
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'Oke',
                    showLoaderOnConfirm: true,
                    confirmButtonClass: 'btn btn-confirm mt-2',
                    cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                    preConfirm: function (inputVal) {
                        return new Promise(function (resolve, reject) {
                            setTimeout(function () {
                                if (inputVal.length === 0) {
                                    reject('Không để trống bình luận')
                                } else {
                                    resolve()
                                }
                            }, 1000)
                        })
                    },
                    allowOutsideClick: false
                }).then(function (inputVal) {
                    let pack = {apm_id: apm_id, score: score, content: inputVal};


                    $.ajax({
                        url: '/admin/apartment/rating',
                        type: "POST",
                        dataType: 'json',
                        data: pack
                    });
                    swal({
                        type: 'success',
                        title: 'GH',
                        html: "Cám ơn nhiều nhaaa",
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    });
                })
            },
            score: function () {
                return $(this).data('score');
            },
        });

        $('#setting_default_district').change(function () {
            let _this = $(this);
            let keyword = _this.data('keyword');
            let account_id = _this.data('account_id');
            let value = _this.val();

            let data = {keyword: keyword, account_id: account_id, value: value};
            $.ajax({
                dataType : 'json',
                data: data,
                url: "/admin/user-setting/update",
                method: "POST",
                success: function (res) {
                    if(res.status === true){
                        $('#setting-msg').text(res.msg);
                    }
                }
            })
        });
        $("#update-pin-notification").click(function () {
            let content = $('#input-pin-notification').val();
            $.ajax({
                url: '/admin/update-apartment-editable',
                method: "POST",
                data: {mode: "pin_notification", value: content},
                dataType: 'json',
                success: function (res) {
                    if(res.status === true) {
                        $('#status-pin-notification').text(res.content);
                        $('#pin-notification').text(content);
                        $('#pin-notification-section').addClass("bg-success");
                        setTimeout(function () {
                            $('#pin-notification-section').removeClass("bg-success");
                        }, 2500);

                        $('#status-pin-notification').fadeOut(2500);
                    }
                }
            })
        });

        var copy_room_timer = 0;
        var copy_room_delay = 200;
        var copy_room_prevent = false;
        $('#copy-room-info').click(function (event) {
            let apartment_id  = $(this).data('apartment-id');
            copy_room_timer = setTimeout(function () {
                if(!copy_room_prevent){
                    $.ajax({
                        url: '/admin/room/copyClipboard',
                        dataType: 'json',
                        async: false,
                        type: 'POST',
                        data: {apartment_id: apartment_id},
                        success: function(data){
                            let copyFrom = document.createElement("textarea");
                            document.body.appendChild(copyFrom);
                            copyFrom.textContent = data;
                            copyFrom.select();
                            document.execCommand("copy");
                            copyFrom.remove();
                            console.log("toast");
                            $.toast({
                                heading: 'Đã copy phòng',
                                text: data,
                                position: 'top-right',
                                loaderBg: '#4ab583',
                                icon: 'info',
                                hideAfter: 3000,
                                stack: 1
                            });
                        }
                    });
                }
                copy_room_prevent = false;


            },copy_room_delay);

        }).dblclick(function () {
            clearTimeout(copy_room_timer);
            copy_room_prevent = true;
            let apartment_id  = $(this).data('apartment-id');

            $.ajax({
                url: '/admin/room/copyClipboard',
                dataType: 'json',
                async: false,
                type: 'POST',
                data: {apartment_id: apartment_id, more_field: "description"},
                success: function(data){
                    let copyFrom = document.createElement("textarea");
                    document.body.appendChild(copyFrom);
                    copyFrom.textContent = data;
                    copyFrom.select();
                    document.execCommand("copy");
                    copyFrom.remove();
                    console.log("double");
                    $.toast({
                        heading: 'Đã copy phòng & mô tả',
                        text: data,
                        position: 'top-right',
                        loaderBg: '#4ab583',
                        icon: 'info',
                        hideAfter: 3000,
                        stack: 1
                    });
                }
            });
        });



        $('#apartment_update_ready').change(function () {
            window.location = '/admin/room/show-create?apartment-id='+$(this).val();
        });

        $('.select2-multiple, #apartment_update_ready, #setting_default_district').select2();
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
            /*columnDefs: [
                { type: 'sort-numbers-ignore-text', targets : 0 }
            ],*/
            "aaSorting": [],
            pageLength: 5
        });

        function sortNumbersIgnoreText(a, b, high) {
            let reg = /[+-]?((\d+(\.\d*)?)|\.\d+)([eE][+-]?[0-9]+)?/;
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
        $('html, body').animate({scrollTop: $('#address-full').offset().top -150 }, 'slow');
    })
</script>
