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
                    <h2 class="font-weight-bold text-danger">Cập Nhật: <i><?= $apartment['address_street']?></i></h2>
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
                <div class="card-box bg-danger widget-flat border-danger text-white">
                    <i class="fi-delete"></i>
                    <h3 class="m-b-10"><?= count($list_room) ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Tổng Số Phòng</p>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="font-weight-bold text-danger text-center">Địa Chỉ</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Đường</strong>
                                    <input type="text" class="form-control"
                                           name="address_street"
                                           value="<?= $apartment['address_street'] ?>" >
                                </div>
                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Phường</strong>
                                    <input type="text" class="form-control" value="<?= $apartment['address_ward'] ?>" >
                                </div>
                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Quận</strong>
                                    <select name="district_code" class="form-control">
                                        <?= $cbDistrictActive ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row float-right">
                                <button type="submit" class="btn btn-danger">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="font-weight-bold text-danger text-center">Mô Tả / Ghi Chú</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <strong class="col-form-strong">Mô Tả Dự Án</strong>
                                    <textarea name="description" id="" class="form-control" cols="30" rows="5"><?= $apartment['description'] ?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <strong class="col-form-strong">Ghi Chú</strong>
                                    <textarea name="description" id="" class="form-control" cols="30" rows="5"><?= $apartment['note'] ?></textarea>

                                </div>
                            </div>
                            <div class="form-row float-right">
                                <button class="btn btn-danger">Cập Nhật</button>
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="text-primary">Điện</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['electricity'] ?>">
                                <small class="form-text text-muted">Yup! Xin Chào Bạn.</small>
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Nước</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['water'] ?>">

                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Internet</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['water'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Giữ Xe</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['parking'] ?>">
                            </div>

                            <div class="form-group">
                                <strong class="text-primary">Phí Quản Lý</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['management_fee'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Combo Phí</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['extra_fee'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Cọc Phòng</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['deposit'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="text-primary">Thang Máy</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['elevator'] ?>">
                                <small class="form-text text-muted">Chúc Bạn Chốt Thật Nhiều Hợp Đồng!</small>
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Máy Giặt</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['elevator'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Dọn Phòng</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['elevator'] ?>">
                            </div>

                            <div class="form-group">
                                <strong class="text-primary">Số Người Ở</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['number_of_people'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Bếp</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['number_of_people'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Bảo Vệ</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['security'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Thú Cưng</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['pet'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="text-primary">Bãi Xe Ô Tô</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['car_park'] ?>">
                                <small class="form-text text-muted">Giỏ Hàng SINVAHOME</small>
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hoa Hồng 12 Tháng</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['commission_rate'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hoa Hồng 9 Tháng</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['commission_rate_9m'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hoa Hồng 6 Tháng</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['commission_rate_6m'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hợp Đồng Dài Hạn</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['contract_long_term'] ?>">
                            </div>

                            <div class="form-group">
                                <strong class="text-primary">Hợp Đồng Ngắn Hạn</strong>
                                <input type="text" class="form-control"
                                       value="<?= $apartment['contract_short_term'] ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-row float-right">
                                <button class="btn btn-danger">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>