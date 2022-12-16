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
                    <h2 class="font-weight-bold text-success">Tạo Dự Án Mới <small>đang code</small></h2>
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
                                        <strong class="col-form-strong">Đường</strong> <span class="text-danger">*</span>
                                        <input type="text" class="form-control"
                                               name="address_street" required
                                               value="" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <strong class="col-form-strong">Phường</strong> <span class="text-danger">*</span>
                                        <input type="text" name="address_ward" required class="form-control" value="" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <strong class="col-form-strong">Quận</strong> <span class="text-danger">*</span>
                                        <select name="district_code" required class="form-control">
                                            <?= $cbDistrictActive ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <strong class="col-form-strong">Hướng</strong> <span class="text-danger">*</span>
                                        <select name="direction" class="form-control">
                                            <option value="">Chọn Hướng</option>
                                            <option value="east">Đông</option>
                                            <option value="west">Tây</option>
                                            <option value="south">Nam</option>
                                            <option value="north">Bắc</option>
                                            <option value="east-south">Đông Nam</option>
                                            <option value="west-south">Tây Nam</option>
                                            <option value="east-north">Đông Bắc</option>
                                            <option value="west-south">Tây Bắc</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <strong class="col-form-strong">Người lấy dự án</strong> <span class="text-danger">*</span>

                                        <select name="user_collected_id" class="select2 mt-3 form-control">
                                            <?= $libUser->cb($this->auth['account_id'], 'YES') ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <strong class="col-form-strong">Thương Hiệu Hợp Tác</strong>
                                        <select name="partner_id" id="partner_id" class="form-control">
                                            <option value="">Cá nhân</option>
                                            <?php foreach ($list_brand as $brand):

                                                ?>
                                                <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <strong class="col-form-strong">Ngày Lấy Về</strong> <span class="text-danger">*</span>
                                        <input type="text"
                                               name="time_insert" required class="form-control datepicker"
                                               value="<?= date("d-m-Y", time()) ?>" >
                                    </div>

                                    <div class="form-group col-md-2">
                                        <strong class="col-form-strong">Mở / Đóng </strong> <span class="text-danger">*</span>
                                        <select required name="active" id=""  class="form-control">
                                            <option value="YES">Mở</option>
                                            <option value="NO">Đóng</option>
                                        </select>
                                    </div>

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
                                    <div class="form-group col-md-12">
                                        <strong class="col-form-strong">Mô Tả Dự Án</strong> <span class="text-danger">*</span>
                                        <textarea name="description" id="description" class="form-control"></textarea>
                                    </div>
                                    <!--<div class="form-group col-md-6">
                                        <strong class="col-form-strong">Ghi Chú</strong> <span class="text-danger">*</span>
                                        <textarea name="note" id="note" class="form-control" ></textarea>

                                    </div>-->
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
                                    <strong class="text-primary">Điện</strong> <span class="text-danger">*</span>
                                    <input  type="text" class="form-control" required
                                           name="electricity"
                                           value="">
                                    <small class="form-text text-muted">Yup! Xin Chào Bạn.</small>
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Nước</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="water"
                                           value="">

                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Internet</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="internet"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Giữ Xe</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="parking"
                                           value="">
                                </div>

                                <div class="form-group">
                                    <strong class="text-primary">Ra vào</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="management_fee"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Combo Phí</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="extra_fee"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Cọc Phòng</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="deposit"
                                           value="">
                                </div>

                                <div class="form-group">
                                    <strong class="text-primary">Số Lầu</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="number_of_floor"
                                           value="">
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="text-primary">Thang Máy</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="elevator"
                                           value="">
                                    <small class="form-text text-muted">Chúc Bạn Chốt Thật Nhiều Hợp Đồng!</small>
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Máy Giặt</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control"
                                           name="washing_machine" required
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Dọn Phòng</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control"
                                           name="room_cleaning" required
                                           value="">
                                </div>

                                <div class="form-group">
                                    <strong class="text-primary">Số Người Ở</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control"
                                           name="number_of_people" required
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Bếp</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="kitchen"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Bảo Vệ</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="security"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Thú Cưng</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="pet"
                                           value="">
                                </div>


                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="text-primary">Bãi Xe Ô Tô</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="car_park"
                                           value="">
                                    <small class="form-text text-muted">Giỏ Hàng SINVAHOME</small>
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Hoa Hồng 12 Tháng</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="commission_rate"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Hoa Hồng 9 Tháng</strong>
                                    <input type="text" class="form-control"
                                           name="commission_rate_9m"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Hoa Hồng 6 Tháng</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="commission_rate_6m"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <strong class="text-primary">Hợp Đồng Dài Hạn</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="contract_long_term"
                                           value="">
                                </div>

                                <div class="form-group">
                                    <strong class="text-primary">Hợp Đồng Ngắn Hạn</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="contract_short_term"
                                           value="">
                                </div>

                                <div class="form-group">
                                    <strong class="text-primary">KT3</strong> <span class="text-danger">*</span>
                                    <input type="text" class="form-control" required
                                           name="kt3"
                                           value="">
                                </div>


                            </div>
                            <div class="col-12">
                                <div class="form-row float-right">
                                    <button name="submit" type="submit" class="btn btn-danger">Thêm Mới</button>
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
            $('#description').summernote({
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

            $('.datepicker').datepicker({
                format: "dd-mm-yyyy",
                autoclose:true
            });
            $('#apartment_update_ready, #user_collected_id, #partner_id, .room-type, .select2').select2();

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
