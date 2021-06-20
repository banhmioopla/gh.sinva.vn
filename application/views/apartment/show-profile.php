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
                                    <strong class="col-form-strong">Hướng</strong>
                                    <select name="direction" required class="form-control">
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
                                    <strong class="col-form-strong">Người Đàm Phán</strong>
                                    <select name="user_collected_id" id="user_collected_id" class="form-control">
                                        <?= $libUser->cb($apartment['user_collected_id']) ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <strong class="col-form-strong">Thương Hiệu Hợp Tác</strong>
                                    <select name="partner_id" id="partner_id" class="form-control">
                                        <option value="">Thương Hiệu Hợp Tác</option>
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
                                        <option value="YES">Mở</option>
                                        <option value="NO">Đóng</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
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

        <form action="/admin" method="post">
        <div class="row">
            <div class="col-md-12" id="block-room">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="font-weight-bold text-danger text-center">Phòng</h3>
                                <div class="col-md-8 offset-md-2 col-10 offset-1">
                                    <input type="text" placeholder="Tìm Mã Phòng, Giá, Diện Tích..." class="form-control search-room border border-info">
                                </div>
                            </div>
                            <?php foreach ($list_room as $room_item):
                                $list_type_id = json_decode($room_item['room_type_id'], true);
                                $text_type_name = "";
                                $type_name_arr = [];
                                if($list_type_id) {
                                    if ($list_type_id && count($list_type_id) > 0) {
                                        foreach ($list_type_id as $type_id) {
                                            $typeModel = $ghBaseRoomType->getFirstById($type_id);
                                            if($typeModel) {
                                                $type_name_arr[] = $typeModel['name'];
                                            }

                                        }
                                    }
                                }

                                $text_type_name = implode(', ', $type_name_arr);

                                $list_status = [
                                    'Available' => 'Trống',
                                    'Full' => 'Full'
                                ];

                                ?>
                                <div class="col-md-12 mt-2 list-room">
                                    <div class="form-row p-2">
                                        <div class="form-group col-md-3">
                                            <strong class="col-form-strong text-danger">MÃ PHÒNG <span class="text-info"><?= $room_item['code'] ?></span></strong>
                                            <input type="text" class="form-control"
                                                   name="code" required
                                                   value="<?= $room_item['code'] ?>" >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <strong class="col-form-strong">Giá Phòng <span class="text-info"><?= number_format($room_item['price']) ?></span></strong>
                                            <input type="number" class="form-control"
                                                   name="price" required
                                                   value="<?= $room_item['price'] ?>" >
                                        </div>

                                        <div class="form-group col-md-2">
                                            <strong class="col-form-strong">Trạng Thái <span class="text-info"><?= $room_item['status'] ?></span></strong>
                                            <select name="status" id="" class="form-control">
                                                <?php foreach ($list_status as $k => $stt):
                                                    $slc = '';
                                                    if($room_item['status'] == $k) {
                                                        $slc = 'selected';
                                                    }
                                                    ?>
                                                    <option value="<?= $k ?>" <?= $slc ?>><?= $stt ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <strong class="col-form-strong">Ngày Sắp Trống <span class="text-info"><?= $room_item['time_available'] > 0 ? date('d-m-Y',$room_item['time_available']) :'' ?></span></strong>
                                            <input type="text" value="<?= $room_item['time_available'] > 0 ? date('d-m-Y',$room_item['time_available']) :'' ?>" class="form-control datepicker">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <strong class="col-form-strong">Diện Tích <span class="text-info"><?= $room_item['area'] ?></span></strong>
                                            <input type="number" value="<?= $room_item['area']?>" class="form-control">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <strong class="col-form-strong">Loại Phòng: <span class="text-info"><?= $text_type_name ?></span> </strong>
                                            <select name="room_type_id[]" required id="" class="form-control room-type" multiple>
                                                <option value="">Chọn 1 hoặc nhiều loại phòng</option>
                                                <?php foreach ($list_room_type as $key => $name):
                                                        $slc = '';
                                                        if(in_array($key, $list_type_id)) {
                                                            $slc = 'selected';
                                                        }
                                                    ?>
                                                    <option <?= $slc ?> value="<?= $key ?>"><?= $name ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="form-group col d-none">
                                            <strong class="col-form-strong"> </strong>
                                            <div class="form-row float-right">
                                                <button name="submit" type="submit" class="btn btn-danger">Cập Nhật <strong><?= $room_item['code'] ?></strong></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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