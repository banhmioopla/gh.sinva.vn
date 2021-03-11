

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">giohang</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h4>Thống kê dẫn khách Tuần hiện tại</h4>
                </div>
            </div>
        </div>
<?php if ($this->input->get('mode') == 'create'): ?>
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2 offset-0">
            <div class="card-box">
                <?php
                $apartment_model = $ghApartment->get(['id' => $this->input->get('apartment-id')]);
                $room_model = $ghRoom->get(['active' => 'YES', 'apartment_id' => $this->input->get('apartment-id')]);
                ?>
                <h3 class="text-center text-danger"><?=
                    $apartment_model[0]['address_street'] ?></h3>
                <hr>
                <form novalidate action="/admin/create-new-consultant-booking?apartment-id=<?= $this->input->get('apartment-id')
                ?>&district-code=<?= $this->input->get('district-code')?>&mode=create"
                      method="post">
                    <input type="hidden" name='district_code'
                           value="<?= $this->input->get('district-code') ?>">
                    <input type="hidden" name='apartment_id'
                           value="<?= $this->input->get('apartment-id') ?>">
                    <input type="hidden" name='customer_id' value="">
                    <div class="form-group">
                        <div class="row">
                            <label for=""
                                   class="col-3 offset-2 text-right col-form-label">Chọn
                                mã phòng</label>
                            <div class="col-md-7">
                                <?php
                                foreach ($room_model as $item):
                                    $status = '';
                                    if ($item['status'] == 'Available') {
                                        $status = 'success';
                                    }
                                    ?>

                                    <div class="checkbox checkbox-success form-check-inline mr-5 pb-2">
                                        <input name="room_id[]" type="checkbox"
                                               id="room_<?= $item['id'] ?>"
                                               value="<?= $item['id'] ?>">
                                        <label class=" font-weight-bold text-<?= $status ?>"
                                               for="room_<?= $item['id'] ?>"> <?= $item['code'] ?> </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="time_booking"
                                   class="col-3 offset-2 text-right col-form-label">Chọn
                                thời gian dẫn khách<span class="text-danger">*</span></label>
                            <div class="col-12 col-md-7">
                                <input type="text" required
                                       class="form-control border-info datetimepicker"
                                       id="time_booking" name="time_booking">
                                <p class="msg-time_booking"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="row">
                            <label for="phone_number"
                                   class="col-3 offset-2 text-right col-form-label">Số
                                điện thoại khách hàng<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="text" required
                                       class="form-control border-info"
                                       id="phone_number" name="phone_number"
                                       placeholder="Số điện thoại khách hàng">
                                <p class="msg-phone"></p>
                                <?php if ($this->session->has_userdata('fast_notify')):
                                    $flash_mess = $this->session->flashdata('fast_notify')['message'];
                                    $flash_status = $this->session->flashdata('fast_notify')['status'];
                                    unset($_SESSION['fast_notify']);
                                    ?>
                                    <p class="text-center text-<?= $flash_status ?>"><?= $flash_mess ?></p>
                                <?php endif; ?>
                                <p class="font-weight-bold">Nhập xong số điện thoại, vui lòng click (bấm) bên ngoài form này để gh check thông tin SDT tồn tại hay chưa!</p>
                            </div>
                        </div>
                    </div>
                    <div class="next-input new-customer d-none">
                        <div class="form-group">
                            <div class="row">
                                <label for="customer_name"
                                       class="col-3 offset-2 text-right col-form-label">Họ
                                    tên khách hàng<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" required class="form-control"
                                           id="customer_name" name="customer_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="name"
                                       class="col-3 offset-2 text-right col-form-label">Giới
                                    tính<span class="text-danger">*</span></label>
                                <div class="col-5">
                                    <div class="radio radio-custom">
                                        <input type="radio" name="gender" checked
                                               id="gender-male" value="male">
                                        <label for="gender-male">
                                            Nam
                                        </label>
                                    </div>
                                    <div class="radio radio-custom">
                                        <input type="radio" name="gender"
                                               id="gender-female" value="female">
                                        <label for="gender-female">
                                            Nữ
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="birthdate"
                                       class="col-3 offset-2 text-right col-form-label">Ngày
                                    sinh<span class="text-danger">*</span></label>
                                <div class="col-5">
                                    <input type="text" name="birthdate"
                                           class="form-control datepicker"
                                           placeholder="mm/dd/yyyy">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="name"
                                       class="col-3 offset-2 text-right col-form-label">Email</label>
                                <div class="col-5">
                                    <input type="text" class="form-control"
                                           id="email" name="email"
                                           placeholder="Email">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-3 offset-2 text-right col-form-label">Nhu
                                    cầu giá</label>
                                <div class="col-5">
                                    <input type="number" name='demand_price'
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-3 offset-2 text-right col-form-label">Nhu
                                    cầu quận</label>
                                <div class="col-5">
                                    <select name="demand_district_code"
                                            class='form-control'>
                                        <?= $select_district ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-3 offset-2 text-right col-form-label">Nhu
                                    cầu thời gian</label>
                                <div class="col-5">
                                    <input type="text" name='demand_time'
                                           class="form-control datepicker">
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="source"
                                       class="col-3 offset-2 text-right col-form-label">**
                                    Nguồn<span class="text-danger">*</span></label>
                                <div class="col-5">
                                    <div class="radio radio-custom">
                                        <input type="radio" name="source"
                                               id="DepMarketing" value="DepMarketing">
                                        <label for="DepMarketing">
                                            Bộ phận marketing
                                        </label>
                                    </div>
                                    <div class="radio radio-custom">
                                        <input type="radio" name="source"
                                               id="DepCustomerCare"
                                               value="DepCustomerCare">
                                        <label for="DepCustomerCare">
                                            Bộ phận chăm sóc khách hàng
                                        </label>
                                    </div>
                                    <div class="radio radio-custom">
                                        <input type="radio" name="source" id="DepSale"
                                               value="DepSale" checked>
                                        <label for="DepSale">
                                            Sale
                                        </label>
                                    </div>
                                    <div class="radio radio-custom">
                                        <input type="radio" name="source"
                                               id="DepOldSale" value="DepOldSale">
                                        <label for="DepOldSale">
                                            Khách Hàng Cũ Của Sale
                                        </label>
                                    </div>
                                    <div class="radio radio-custom">
                                        <input type="radio" name="source"
                                               id="DepReferral" value="DepReferral">
                                        <label for="DepReferral">
                                            Khách được giới thiệu
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-md-7 offset-md-5">
                            <button type="submit"
                                    class="btn btn-custom waves-effect waves-light">
                                Thêm Mới
                            </button>
                            <p class="text-danger noenter" style="display: none">Không được enter!</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php endif; ?>

    </div>
</div>

<script>
    commands.push(function(){
        $(window).keydown(function(event){
            if(event.keyCode === 13) {
                event.preventDefault();
                $('.noenter').show();
                return false;
            }
        });
        $('input[name=phone_number]').focusout(function () {
            let phone = $(this).val();
            if (phone.length > 0) {
                $.ajax({
                    url: '<?= base_url()?>admin/search-customer?q=' + phone,
                    method: 'GET',
                    success: function (res) {
                        res = JSON.parse(res);
                        if (res.length > 0) {
                            $('.msg-phone').addClass('text-warning');
                            $('.msg-phone').removeClass('text-success');
                            $('.msg-phone').text(' khách ' + res[0]['text'] + ' này đã sẵn sàng để bạn dẫn');
                            $('input[name=customer_id]').val(res[0]['id']);
                            $('.next-input').addClass('d-none');
                        } else {
                            $('input[name=customer_id]').val("");
                            $('.msg-phone').addClass('text-success');
                            $('.msg-phone').removeClass('text-warning');
                            $('.msg-phone').text('Đây là khách mới <3');
                            $('.next-input').removeClass('d-none');
                        }

                    }
                });
            }
        });

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
        });
        $('.datetimepicker').datetimepicker({
            sideBySide: true,
            format: 'DD/MM/YYYY hh:mm a',
        });
    });


</script>
