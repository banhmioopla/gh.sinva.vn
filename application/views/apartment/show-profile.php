<?php
$short_fill = ["Miễn phí combo", "Tòa nhà nằm trong hẻm", "Nên nắm kỹ thông tin trước khi tư vấn để tránh sai sót."];

$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;

}

$check_create_promotion = false;
if(isYourPermission('ApartmentPromotion', 'create', $this->permission_set)){
    $check_create_promotion = true;
}
$hidden_service = count(json_decode($apartment['hidden_service'], true)) ? json_decode($apartment['hidden_service'], true) : [];

?>
<style>
    .hover-hidden-service{
        background-color: white;
        transition: .3s;
    }
    .hover-hidden-service:hover{
        background-color: rgba(255, 172, 0, 0.28);
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
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Cập Nhật Dịch Vụ | <i><?= $apartment['address_street']?></i></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= count($contract) ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Tổng Số Lượng Hợp Đồng</p>
                </div>
            </div>

            <div class="col-xs-6 col-sm-3">
                <div class="card-box bg-primary widget-flat border-primary text-white">
                    <i class="fi-delete"></i>
                    <h3 class="m-b-10"><?= count($list_room) ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Tổng Số Phòng</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                if($this->session->has_userdata('fast_notify')):
                    ?>
                    <div class="alert alert-<?= $this->session->flashdata('fast_notify')['status']?> alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fast_notify')['message']?>
                    </div>
                    <?php unset($_SESSION['fast_notify']); endif; ?>
            </div>
        </div>

        <form class="row" action="" method="POST">
            <div class="form-group col-md-4">
                <strong class="col-form-strong text-primary">Cập Nhật Thông Tin Dịch Vụ Dự Án Khác</strong>
                <select id="apartment_update_ready" class="form-control">
                    <option value="">Cập Nhật Dự Án Khác</option>
                    <?php foreach ($list_apm as $apm): ?>
                        <option value="<?= $apm['id'] ?>">Q.<?= $apm['district_code'] . ' ' . $apm['address_street'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="font-weight-bold text-danger text-center">Cập Nhật Vào Lúc: <?= date('d-m-Y h:i\'', $apartment['time_update']) ?></h3>
                            <div class="pull-right text-md text-center">
                                <?php if($this->session->has_userdata('current_district_code')):?>
                                    <a  href="<?= '/admin/list-apartment?district-code='.$this->session->userdata('current_district_code') ?>"><button type="button" class="btn btn-secondary m-1"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button></a>
                                <?php endif; ?>
                                <?php if($check_create_promotion): ?>
                                    <a class="" href="/admin/list-apartment-promotion?apartment-id=<?= $apartment['id'] ?>">
                                        <button class="btn btn-primary m-1"><i class="mdi mdi-gift"></i></button></a>
                                <?php endif; ?>
                                <?php if($check_consultant_booking): ?>
                                    <a href="/admin/create-new-consultant-booking?apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create">
                                        <button class="btn btn-danger m-1"><i class="mdi mdi-car-hatchback"></i></button></a>
                                <?php endif; ?>
                                <a href="/admin/apartment/upload-img?apartment_id=<?= $apartment['id'] ?>">
                                    <button type="button" class="btn btn-primary  m-1"><i class="mdi mdi-folder-multiple-image"></i></button></a>
                                <a href="/admin/room/show-create?apartment-id=<?= $apartment['id'] ?>"><button type="button" class="btn btn-primary m-1"><i class="mdi mdi-lead-pencil"></i> Phòng </button></a>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Đường</strong>
                                    <input type="text" class="form-control"
                                           name="address_street" required
                                           value="<?= $apartment['address_street'] ?>" >
                                </div>
                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Phường</strong>
                                    <input type="text" name="address_ward" required class="form-control" value="<?= $apartment['address_ward'] ?>" >
                                </div>
                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Quận</strong>
                                    <select name="district_code" required class="form-control">
                                        <?= $cbDistrictActive ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Hướng</strong>
                                    <select name="direction" class="form-control">
                                        <option value="">Chọn Hướng</option>
                                        <option <?= $apartment['direction'] == 'east' ? 'selected' :'' ?> value="east">Đông</option>
                                        <option <?= $apartment['direction'] == 'west' ? 'selected' :'' ?> value="west">Tây</option>
                                        <option <?= $apartment['direction'] == 'south' ? 'selected' :'' ?> value="south">Nam</option>
                                        <option <?= $apartment['direction'] == 'north' ? 'selected' :'' ?> value="north">Bắc</option>
                                        <option <?= $apartment['direction'] == 'east-south' ? 'selected' :'' ?> value="east-south">Đông Nam</option>
                                        <option <?= $apartment['direction'] == 'west-south' ? 'selected' :'' ?> value="west-south">Tây Nam</option>
                                        <option <?= $apartment['direction'] == 'east-north' ? 'selected' :'' ?> value="east-north">Đông Bắc</option>
                                        <option <?= $apartment['direction'] == 'west-south' ? 'selected' :'' ?> value="west-south">Tây Bắc</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Người lấy dự án</strong>
                                    <select name="user_collected_id" id="user_collected_id" class="form-control">
                                        <option value="">chọn lấy dự án</option>
                                        <?php foreach ($list_user as $uuu):
                                            $slc = "";
                                            if($apartment['user_collected_id'] == $uuu['account_id']){
                                                $slc = "selected";
                                            }
                                            ?>
                                            <option <?= $slc ?> value="<?= $uuu['account_id'] ?>"><?= $uuu['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Thương Hiệu Hợp Tác</strong>
                                    <select name="partner_id" id="partner_id" class="form-control">
                                        <option value="">Cá nhân</option>
                                        <?php foreach ($list_brand as $brand):
                                            $slc = '';
                                            if($brand['id'] == $apartment['partner_id']) {
                                                $slc = 'selected';
                                            }

                                            ?>
                                            <option value="<?= $brand['id'] ?>" <?= $slc ?>><?= $brand['name'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Ngày Lấy Về</strong>
                                    <input type="text"
                                           name="time_insert" required class="form-control datepicker"
                                           value="<?= date("d-m-Y", $apartment['time_insert']) ?>" >
                                </div>

                                <div class="form-group col-md-2">
                                    <strong class="col-form-strong">Mở / Đóng </strong>
                                    <select name="active" id=""  class="form-control">
                                        <option <?= $apartment['active'] == 'YES' ? 'selected': '' ?> value="YES">Mở</option>
                                        <option <?= $apartment['active'] == 'NO' ? 'selected': '' ?> value="NO">Đóng</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <strong class="col-form-strong">Tag </strong>
                                    <select name="tag_id"  class="form-control">
                                        <option value="">Gắn Tag</option>
                                        <?php foreach ($list_tag as $tag):
                                            $slc = '';
                                            if($apartment['tag_id'] == $tag['id']) {
                                                $slc = 'selected';
                                            }

                                            ?>
                                            <option <?= $slc ?> value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Zalo Group</strong>
                                    <input type="text" class="form-control"
                                           name="zalo_group_url"
                                           value="<?= $apartment['zalo_group_url'] ?>" >
                                </div>



                            </div>
                            <div class="form-row float-right">
                                <button name="submit" type="submit" class="btn btn-danger">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="font-weight-bold text-danger text-center">Mô Tả</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="mb-1">
                                        <?php foreach ($short_fill as $term): ?>
                                            <span class="fill-term-description badge badge-info"><?= $term ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <textarea name="description" id="description" class="form-control"><?= $apartment['description'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-row float-right">
                                <button name="submit" type="submit" class="btn btn-danger">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="font-weight-bold text-danger text-center">Thông Tin Dịch Vụ</h3>
                            <p class="text-center">để ẩn thông tin dịch vụ, click vào checkbox tương ứng</p>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Điện</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('electricity', $hidden_service) ? 'checked':'' ?> value="electricity">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="electricity"
                                       value="<?= $apartment['electricity'] ?>">
                                <!--                                <small class="form-text text-muted">Yup! Xin Chào Bạn.</small>-->
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Nước</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('water', $hidden_service) ? 'checked':'' ?> value="water">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="water"
                                       value="<?= $apartment['water'] ?>">

                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Internet</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('internet', $hidden_service) ? 'checked':'' ?> value="internet">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="internet"
                                       value="<?= $apartment['internet'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Giữ Xe</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('parking', $hidden_service) ? 'checked':'' ?> value="parking">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="parking"
                                       value="<?= $apartment['parking'] ?>">
                            </div>

                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Ra vào</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('management_fee', $hidden_service) ? 'checked':'' ?> value="management_fee">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="management_fee"
                                       value="<?= $apartment['management_fee'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Combo Phí</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('extra_fee', $hidden_service) ? 'checked':'' ?> value="extra_fee">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="extra_fee"
                                       value="<?= $apartment['extra_fee'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Cọc Phòng</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('deposit', $hidden_service) ? 'checked':'' ?> value="deposit">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="deposit"
                                       value="<?= $apartment['deposit'] ?>">
                            </div>

                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Số Lầu</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('number_of_floor', $hidden_service) ? 'checked':'' ?> value="number_of_floor">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="number_of_floor"
                                       value="<?= $apartment['number_of_floor'] ?>">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Thang Máy</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('elevator', $hidden_service) ? 'checked':'' ?> value="elevator">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="elevator"
                                       value="<?= $apartment['elevator'] ?>">
                                <!--                                <small class="form-text text-muted">Chúc Bạn Chốt Thật Nhiều Hợp Đồng!</small>-->
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Máy Giặt</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('washing_machine', $hidden_service) ? 'checked':'' ?> value="washing_machine">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="washing_machine"
                                       value="<?= $apartment['washing_machine'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Dọn Phòng</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('room_cleaning', $hidden_service) ? 'checked':'' ?> value="room_cleaning">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="room_cleaning"
                                       value="<?= $apartment['room_cleaning'] ?>">
                            </div>

                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Số Người Ở</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('number_of_people', $hidden_service) ? 'checked':'' ?> value="number_of_people">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="number_of_people"
                                       value="<?= $apartment['number_of_people'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Bếp</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('kitchen', $hidden_service) ? 'checked':'' ?> value="kitchen">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="kitchen"
                                       value="<?= $apartment['kitchen'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Bảo Vệ</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('security', $hidden_service) ? 'checked':'' ?> value="security">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="security"
                                       value="<?= $apartment['security'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Thú Cưng</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('pet', $hidden_service) ? 'checked':'' ?> value="pet">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="pet"
                                       value="<?= $apartment['pet'] ?>">
                            </div>


                        </div>
                        <div class="col-md-4">
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Bãi Xe Ô Tô</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('car_park', $hidden_service) ? 'checked':'' ?> value="car_park">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="car_park"
                                       value="<?= $apartment['car_park'] ?>">
                                <!--                                <small class="form-text text-muted">Giỏ Hàng SINVAHOME</small>-->
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Hoa Hồng 12 Tháng</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('commission_rate', $hidden_service) ? 'checked':'' ?> value="commission_rate">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="commission_rate"
                                       value="<?= $apartment['commission_rate'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Hoa Hồng 9 Tháng</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('commission_rate_9m', $hidden_service) ? 'checked':'' ?> value="commission_rate_9m">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="commission_rate_9m"
                                       value="<?= $apartment['commission_rate_9m'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Hoa Hồng 6 Tháng</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('commission_rate_6m', $hidden_service) ? 'checked':'' ?> value="commission_rate_6m">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="commission_rate_6m"
                                       value="<?= $apartment['commission_rate_6m'] ?>">
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Hợp Đồng Dài Hạn</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('contract_long_term', $hidden_service) ? 'checked':'' ?> value="contract_long_term">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="contract_long_term"
                                       value="<?= $apartment['contract_long_term'] ?>">
                            </div>

                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Hợp Đồng Ngắn Hạn</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('contract_short_term', $hidden_service) ? 'checked':'' ?> value="contract_short_term">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control"
                                       name="contract_short_term"
                                       value="<?= $apartment['contract_short_term'] ?>">
                            </div>

                            <div class="form-group p-2 hover-hidden-service">
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="hidden_cols[]" <?= in_array('kt3', $hidden_service) ? 'checked':'' ?> value="kt3">
                                    <label></label>
                                </div>
                                <strong class="text-primary">KT3</strong>
                                <input type="text" class="form-control"
                                       name="kt3"
                                       value="<?= $apartment['kt3'] ?>">
                            </div>


                        </div>
                        <div class="col-12">
                            <div class="form-row float-right">
                                <button name="submit" type="submit" class="btn btn-danger">Cập Nhật</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="font-weight-bold text-danger text-center">Tiện ích xung quanh</h3>
                        </div>
                        <?php
                        $surrounding_facilities = !empty($apartment['surrounding_facilities']) ? json_decode($apartment['surrounding_facilities'], true):[];

                        ?>
                        <div class="col-md-6">
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Phòng Gym</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" <?= in_array('Gym', $surrounding_facilities) ? 'checked':'' ?> name="surrounding_facilities[]"  value="Gym">
                                    <label></label>
                                </div>
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Trường học</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="surrounding_facilities[]" <?= in_array('Trường học', $surrounding_facilities) ? 'checked':'' ?> value="Trường học">
                                    <label></label>
                                </div>
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Công viên</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="surrounding_facilities[]" <?= in_array('Công viên', $surrounding_facilities) ? 'checked':'' ?> value="Công viên">
                                    <label></label>
                                </div>
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">Siêu thị</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="surrounding_facilities[]" <?= in_array('Siêu thị', $surrounding_facilities) ? 'checked':'' ?> value="Siêu thị">
                                    <label></label>
                                </div>
                            </div>
                            <div class="form-group p-2 hover-hidden-service">
                                <strong class="text-primary">View sông</strong>
                                <div class="checkbox checkbox-dark checkbox-single pull-right">
                                    <input type="checkbox" name="surrounding_facilities[]" <?= in_array('View sông', $surrounding_facilities) ? 'checked':'' ?> value="View sông">
                                    <label></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-row float-right">
                                <button name="submit" type="submit" class="btn btn-danger">Cập Nhật</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </form>

        <form action="/admin/create-apartment-promotion" method="POST" class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="font-weight-bold text-danger text-center">Quản lý ưu đãi</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group p-2">
                                <strong class="text-primary">Tiêu đề</strong>
                                <input type="text" class="form-control"
                                       name="title" required
                                       value="">
                                <input type="hidden" name="apartment_id" value="<?= $apartment['id'] ?>" >
                            </div>
                            <div class="form-group p-2">
                                <strong class="text-primary">Ngày bắt đầu</strong>
                                <input type="text" class="form-control datepicker"
                                       name="start_time" required
                                       value="">
                            </div>
                            <div class="form-group p-2">
                                <strong class="text-primary">Ngày kết thúc</strong>
                                <input type="text" class="form-control datepicker"
                                       name="end_time" required
                                       value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <strong class="col-form-strong">Mô tả ưu đãi</strong>
                            <textarea name="description" id="promotion_description" class="form-control" ></textarea>

                        </div>
                        <div class="col-12">
                            <div class="form-row float-right">
                                <button name="submit" type="submit" class="btn btn-danger">Cập Nhật</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        $list_promotion = $ghApartmentPromotion->get(['apartment_id' => $apartment['id'], 'end_time >=' => strtotime(date('d-m-Y'))]);

                        ?>
                        <?php foreach ($list_promotion as $promotion):?>
                        <div class="col-md-4 promotion-card">
                            <div class="card m-b-30">
                                <h5 class="card-header"><?= $promotion['title'] ?>
                                    <div class="form-row float-right">
                                        <button name="submit" type="button" data-id="<?= $promotion['id'] ?>" class="delete-promotion btn btn-danger">Xoá</button>
                                    </div>
                                </h5>
                                <div class="card-body">
                                    <div><?= date("d/m/Y",$promotion['start_time']) ." . " .date("d/m/Y",$promotion['end_time']) ?></div>
                                    <p><?= $promotion['description'] ?></p>
                                </div>
                            </div>
                        </div>

                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    commands.push(function() {
        $(document).ready(function() {
            $('.delete-promotion').click(function () {
                let _this = $(this);

                $.ajax({
                    url: '/admin/apartment-promotion/delete',
                    type: "POST",
                    dataType: "json",
                    data: {id:_this.data('id')},
                    success: function () {

                        let xx  = _this.closest(".promotion-card").remove();
                        console.log(xx);
                        console.log(123);
                    }
                })
            });

            $('#description, #note, #promotion_description').summernote({
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ]
            });
            $('.fill-term-description').click(function () {
                let source = $('#description').summernote('code');
                let term = " <p>" + ($(this).text().trim()) + '</p>';
                $('#description').summernote('code', source + term);
            });

            $('.fill-term-note').click(function () {
                let source = $('#note').summernote('code');
                let term = " <p>" + ($(this).text().trim()) + '</p>';
                $('#note').summernote('code', source + term);
            });

            $('.datepicker').datepicker({
                format: "dd-mm-yyyy",
                autoclose:true
            });
            $('#apartment_update_ready, #user_collected_id, #partner_id, .room-type').select2();

            $('.search-room').on('keyup', function(){
                var value = $(this).val().toLowerCase();
                $(".list-room").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });




            $('#apartment_update_ready').change(function () {
                window.location = '/admin/profile-apartment?id='+$(this).val();
            });
        });
    });
</script>
