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

        <form action="" method="POST">
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
                                    <strong class="col-form-strong">Người Đàm Phán</strong>
                                    <select name="user_collected_id" id="user_collected_id" class="form-control">
                                        <?= $libUser->cb($apartment['user_collected_id']) ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Ngày Lấy Về</strong>
                                    <input type="text"
                                           name="time_insert" required class="form-control datepicker"
                                           value="<?= date("d-m-Y", $apartment['time_insert']) ?>" >
                                </div>

                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong text-primary">Đi Đến Dự Án Khác</strong>
                                    <select id="apartment_update_ready" class="form-control">
                                        <option value="">Cập Nhật Dự Án Khác</option>
                                        <?php foreach ($list_apm as $apm): ?>
                                            <option value="<?= $apm['id'] ?>">Q.<?= $apm['district_code'] . ' ' . $apm['address_street'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
                            <h3 class="font-weight-bold text-danger text-center">Mô Tả / Ghi Chú</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <strong class="col-form-strong">Mô Tả Dự Án</strong>
                                    <textarea name="description" id="description" class="form-control"><?= $apartment['description'] ?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <strong class="col-form-strong">Ghi Chú</strong>
                                    <textarea name="note" id="note" class="form-control" ><?= $apartment['note'] ?></textarea>

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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="text-primary">Điện</strong>
                                <input type="text" class="form-control"
                                       name="electricity"
                                       value="<?= $apartment['electricity'] ?>">
                                <small class="form-text text-muted">Yup! Xin Chào Bạn.</small>
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Nước</strong>
                                <input type="text" class="form-control"
                                       name="water"
                                       value="<?= $apartment['water'] ?>">

                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Internet</strong>
                                <input type="text" class="form-control"
                                       name="internet"
                                       value="<?= $apartment['internet'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Giữ Xe</strong>
                                <input type="text" class="form-control"
                                       name="parking"
                                       value="<?= $apartment['parking'] ?>">
                            </div>

                            <div class="form-group">
                                <strong class="text-primary">Phí Quản Lý</strong>
                                <input type="text" class="form-control"
                                       name="management_fee"
                                       value="<?= $apartment['management_fee'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Combo Phí</strong>
                                <input type="text" class="form-control"
                                       name="extra_fee"
                                       value="<?= $apartment['extra_fee'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Cọc Phòng</strong>
                                <input type="text" class="form-control"
                                       name="deposit"
                                       value="<?= $apartment['deposit'] ?>">
                            </div>

                            <div class="form-group">
                                <strong class="text-primary">Số Lầu</strong>
                                <input type="text" class="form-control"
                                       name="number_of_floor"
                                       value="<?= $apartment['number_of_floor'] ?>">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="text-primary">Thang Máy</strong>
                                <input type="text" class="form-control"
                                       name="elevator"
                                       value="<?= $apartment['elevator'] ?>">
                                <small class="form-text text-muted">Chúc Bạn Chốt Thật Nhiều Hợp Đồng!</small>
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Máy Giặt</strong>
                                <input type="text" class="form-control"
                                       name="washing_machine"
                                       value="<?= $apartment['washing_machine'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Dọn Phòng</strong>
                                <input type="text" class="form-control"
                                       name="room_cleaning"
                                       value="<?= $apartment['room_cleaning'] ?>">
                            </div>

                            <div class="form-group">
                                <strong class="text-primary">Số Người Ở</strong>
                                <input type="text" class="form-control"
                                       name="number_of_people"
                                       value="<?= $apartment['number_of_people'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Bếp</strong>
                                <input type="text" class="form-control"
                                       name="kitchen"
                                       value="<?= $apartment['kitchen'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Bảo Vệ</strong>
                                <input type="text" class="form-control"
                                       name="security"
                                       value="<?= $apartment['security'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Thú Cưng</strong>
                                <input type="text" class="form-control"
                                       name="pet"
                                       value="<?= $apartment['pet'] ?>">
                            </div>


                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="text-primary">Bãi Xe Ô Tô</strong>
                                <input type="text" class="form-control"
                                       name="car_park"
                                       value="<?= $apartment['car_park'] ?>">
                                <small class="form-text text-muted">Giỏ Hàng SINVAHOME</small>
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hoa Hồng 12 Tháng</strong>
                                <input type="text" class="form-control"
                                       name="commission_rate"
                                       value="<?= $apartment['commission_rate'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hoa Hồng 9 Tháng</strong>
                                <input type="text" class="form-control"
                                       name="commission_rate_9m"
                                       value="<?= $apartment['commission_rate_9m'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hoa Hồng 6 Tháng</strong>
                                <input type="text" class="form-control"
                                       name="commission_rate_6m"
                                       value="<?= $apartment['commission_rate_6m'] ?>">
                            </div>
                            <div class="form-group">
                                <strong class="text-primary">Hợp Đồng Dài Hạn</strong>
                                <input type="text" class="form-control"
                                       name="contract_long_term"
                                       value="<?= $apartment['contract_long_term'] ?>">
                            </div>

                            <div class="form-group">
                                <strong class="text-primary">Hợp Đồng Ngắn Hạn</strong>
                                <input type="text" class="form-control"
                                       name="contract_short_term"
                                       value="<?= $apartment['contract_short_term'] ?>">
                            </div>

                            <div class="form-group">
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
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    commands.push(function() {
        $(document).ready(function() {
            $('#description, #note').summernote({
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true
            });

            $('.datepicker').datepicker({
                format: "dd-mm-yyyy",
                autoclose:true
            });
            $('#apartment_update_ready, #user_collected_id').select2();

            $('#apartment_update_ready').change(function () {
                window.location = '/admin/profile-apartment?id='+$(this).val();
            });
        });
    });
</script>