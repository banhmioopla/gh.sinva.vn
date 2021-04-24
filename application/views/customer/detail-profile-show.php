<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- meta -->
                <div class="profile-user-box card-box bg-dark text-warning">
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="pull-left mr-3"><img src="https://ecommerce-platforms.com/wp-content/uploads/2018/05/mark-and-john-1549634879.gif" alt="" class="thumb-lg rounded-circle"></span>
                            <div class="media-body text-white">
                                <h4 class="mt-1 font-18"><?= $customer['name'] ?></h4>
                                <div class="row pl-2">
                                    <div class="col-12 p-1"><i class="mdi mdi-cake-variant"></i> <?= strlen($customer['birthdate']) ? date('d/m/Y',$customer['birthdate']): '' ?></div>
                                    <div class="col-12 p-1"><i class="mdi mdi-cellphone-android"></i> <?= $customer['phone'] ?></div>
                                    <div class="col-12 p-1"><i class="mdi mdi-email-open-outline"></i> <?= $customer['email'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card-box bg-dark border border-warning">
                                        <h6 class="text-uppercase mt-0">SL Hợp Đồng:</h6>
                                        <h2 class="m-b-20" ><?= count($list_contract) ?></h2>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="card-box bg-dark border border-warning">
                                        <h6 class="text-uppercase mt-0">SL Lượt Book</h6>
                                        <h2 class="m-b-20"><span ><?= count($list_booking) ?></span></h2>
                                    </div>
                                </div><!-- end col -->
                            </div>

                        </div>

                    </div>
                </div>
                <!--/ meta -->
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-md-4">
                <!-- Personal-Information -->
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger m-b-20">Thông Tin Khách Hàng </h4>
                    <div class="panel-body">
                        <table class="table table-borderless table-hover font-13">
                            <tr>
                                <td class="font-weight-bold">Họ & Tên </td>
                                <td class="text-right"><span class="customer-update"
                                          data-pk="<?= $customer['id'] ?>"
                                          data-value="<?= $customer['name'] ?>"
                                          data-name="name"
                                    ><?= $customer['name'] ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Sinh Nhật </td>
                                <td class="text-right"><span class="m-l-15 customer-time"
                                                             data-pk="<?= $customer['id'] ?>"
                                                             data-value="<?= strlen($customer['birthdate']) ? date('d-m-Y',$customer['birthdate']): '' ?>"
                                                             data-name="birthdate"
                                    ><?= strlen($customer['birthdate']) ? date('d-m-Y',$customer['birthdate']): '' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Giới Tính </td>
                                <td class="text-right"><span class="customer-gender"
                                                             data-pk="<?= $customer['id'] ?>"
                                                             data-value="<?= $customer['gender'] ?>"
                                                             data-name="gender"><?= $customer['gender'] ? $label_apartment[$customer['gender']]:'<i>không có thông tin</i>' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Số Điện Thoại </td>
                                <td class="text-right">
                                    <div class="customer-update"
                                         data-pk="<?= $customer['id'] ?>"
                                         data-value="<?= $customer['phone'] ?>"
                                         data-name="phone"><?= $customer['phone'] ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Email </td>
                                <td class="text-right">
                                    <div class="customer-update"
                                          data-pk="<?= $customer['id'] ?>"
                                          data-value="<?= $customer['email'] ?>"
                                          data-name="email"><?= $customer['email'] ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Nguồn </td>
                                <td class="text-right">
                                    <?= $customer['source'] ?  $label_apartment[$customer['source']] : '[chưa cập nhật]' ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Trạng Thái </td>
                                <td class="text-right">
                                    <span class="badge badge-info font-weight-bold contract-status"><?= $label_apartment[$customer['status']] ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Nhu Cầu Giá </td>
                                <td class="text-right">
                                    <span class="customer-update"
                                          data-pk="<?= $customer['id'] ?>"
                                          data-value="<?= $customer['demand_price'] ?>"
                                          data-name="demand_price"
                                    > <?= $customer['demand_price'] ?  number_format($customer['demand_price']) : '<i>không có thông tin</i>' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Nhu Cầu Quận </td>
                                <td class="text-right">
                                    <span class=" customer-demand_district_code"
                                          data-pk="<?= $customer['id'] ?>"
                                          data-value="<?= $customer['demand_district_code'] ?>"
                                          data-name="demand_district_code"
                                    > <?= $customer['demand_district_code'] ? "quận " . $customer['demand_district_code'] :'<i>không có thông tin</i>' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Nhu Cầu Thời Gian </td>
                                <td class="text-right">
                                    <span class="customer-time"
                                          data-pk="<?= $customer['id'] ?>"
                                          data-value="<?= $customer['demand_time'] > 0 ? date('d-m-Y',$customer['demand_time']):'' ?>"
                                          data-name="demand_time"
                                    > <?= $customer['demand_time'] > 0 ? date('d/m/Y',$customer['demand_time']) : '<i>không có thông tin</i>' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Ghi Chú </td>
                                <td class="text-left border border-secondary">
                                    <div class="customer-note"
                                          data-pk="<?= $customer['id'] ?>"
                                          data-value="<?= $customer['note'] ?>"
                                          data-name="note"> <?= $customer['note'] ? $customer['note'] : '<i>không có thông tin</i>' ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Ngày Nhập Vào GH </td>
                                <td class="text-right">
                                    <span class="customer-time"
                                          data-pk="<?= $customer['id'] ?>"
                                          data-value="<?= strlen($customer['time_insert']) > 0 ? date('d-m-Y',$customer['time_insert']): '' ?>"
                                          data-name="time_insert"
                                    ><?= strlen($customer['time_insert']) ? date('d/m/Y',$customer['time_insert']): '' ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
            <?php
            $check_edit = false;
            if (isYourPermission($this->current_controller, 'updateEditable', $this->permission_set)) {
                $check_edit = true;
            }

            ?>
            <script>
                commands.push(function(){
                    <?php if($check_edit): ?>
                    $('.customer-update').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        inputclass: '',
                    });
                    $('.customer-gender').editable({
                        type: 'select',
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        inputclass: '',
                        source: function() {
                            data = [
                                {value: '', text: "Vui lòng chọn"},
                                {value: 'male', text: "Nam"},
                                {value: 'female', text: "Nữ"}
                            ];

                            return data;
                        }
                    });

                    $('.customer-time').editable({
                        placement: 'top',
                        type: 'combodate',
                        template: "D / MM / YYYY",
                        format: "DD-MM-YYYY",
                        viewformat: "DD-MM-YYYY",
                        combodate: {
                            firstItem: 'name',
                            maxYear: '2030',
                            minYear: '1940'
                        },
                        mode:'inline',
                        inputclass: 'form-control-sm',
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data.status == true) {
                                $('.contract-alert').html(notify_html_success);
                            } else {
                                $('.contract-alert').html(notify_html_fail);
                            }
                        }
                    });

                    $('.customer-demand_district_code').editable({
                        type: 'select',
                        url: '<?= base_url() ?>admin/customer-get-district',
                        inputclass: '',
                        source: function() {
                            data = [];
                            $.ajax({
                                url: '<?= base_url() ?>admin/customer-get-district',
                                dataType: 'json',
                                async: false,
                                success: function(res) {
                                    data = res;
                                    return res;
                                }
                            });
                            return data;
                        },
                    });

                    $('.customer-note').editable({
                        placement: 'top',
                        type: "textarea",
                        mode:'inline',
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        inputclass: '',
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data.status == true) {
                                $('.contract-alert').html(notify_html_success);
                            } else {
                                $('.contract-alert').html(notify_html_fail);
                            }
                        }
                    });
                    <?php endif; ?>
                });
            </script>


            <div class="col-md-8">

                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">Bảng Hợp Đồng</h4>
                    <table class="table table-dark table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Địa Chỉ</th>
                            <th>Mã Phòng</th>
                            <th>Giá Thuê</th>
                            <th>Ngày Ký</th>
                            <th>Trạng Thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_contract as $contract):
                            $service_set = $contract['service_set'] ? json_decode($contract['service_set'], true) : null;
                            $room = $ghRoom->get(['id' => $contract['room_id']]);
                            $room = count($room) ? $room[0] : null;
                            if(!$service_set) {
                                if($room) {
                                    $apartment = $ghApartment->get(['id' => $room[0]['aparment_id']]);
                                    if(count($apartment)) {
                                        $service_set = $apartment[0];
                                    }
                                }
                            }


                            ?>
                        <tr>
                            <th scope="row"><u><a target = '_blank'
                                                  class="text-warning"
                                                  href="/admin/detail-contract?id=<?= $contract['id']
                                                  ?>"><?= $contract['id'] ?></a></u></th>
                            <td><?= $service_set ? $service_set['address_street'] : '<i>không có thông tin</i>' ?></td>
                            <td><?= $room ? $room['code'] : '<i>không có thông tin</i>' ?></td>
                            <td><?= number_format($contract['room_price']) ?></td>
                            <td><?= date('d-m-Y',$contract['time_check_in']) ?></td>
                            <td>
                                <div>
                                    <?php
                                    $statusClass = 'muted';
                                    if($contract['status'] == 'Active') {
                                        $statusClass = 'success';
                                    }
                                    if($contract['status'] == 'Pending') {
                                        $statusClass = 'warning';
                                    }
                                    if($contract['status'] == 'Cancel') {
                                        $statusClass = 'danger';
                                    }

                                    if($contract['status'] == 'Expired') {
                                        $statusClass = 'secondary';
                                    }
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?>
                                    font-weight-bold">
                                    <?= $label_apartment['contract.'.$contract['status']] ?>
                                    </span>

                                </div>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-box">
                    <h4 class="header-title mb-3">Bảng Dẫn Khách</h4>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ngày</th>
                                <th>Địa Chỉ</th>
                                <th>Phòng</th>
                                <th>Trạng Thái</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list_booking as $booking):

                                $address = '';
                                $apmModel = $ghApartment->get(['id' => $booking['apartment_id']]);
                                if ($apmModel) {
                                    $address = $apmModel[0]['address_street'];
                                }
                                $list_room_id = json_decode($booking['room_id'], true);
                                $text_room_code = '';

                                $js_list_room = implode(",", $list_room_id);
                                if ($list_room_id && count($list_room_id) > 0) {
                                    foreach ($list_room_id as $room_id) {
                                        $roomModel = $ghRoom->get(['id' => $room_id]);
                                        $text_room_code .= $roomModel[0]['code'] . ' ';
                                    }
                                }

                                $status = 'danger';
                                if ($booking['status'] == 'Success') {
                                    $status = 'success';
                                }
                                if ($booking['status'] == 'Pending') {
                                    $status = 'warning';
                                }
                                ?>
                                <tr>
                                    <td>#<?= 10000 + $booking['id'] ?>
                                        <div class="font-weight-bold"><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></div>
                                    </td>
                                    <td>
                                        <div class="form-inline">
                                            <div class="booking-time_booking input-group"
                                                 data-pk="<?= $booking['id'] ?>"
                                                 data-name="time_booking"
                                                 data-value="<?= date('d/m/Y H:i', $booking['time_booking']) ?>">
                                                <?= date('d/m/Y H:i', $booking['time_booking']) ?>
                                            </div>
                                        </div>

                                    </td>
                                    <td><?= $address ?></td>
                                    <td class="booking-room-code"
                                        data-pk="<?= $booking['id'] ?>"
                                        data-name="room_id"
                                        data-value="<?= $js_list_room ?>"
                                        data-apartment-id="<?= $booking['apartment_id'] ?>"
                                    ><i class="text-success"><?= $text_room_code ?></i></td>

                                    <td>
                                        <u class="booking-status text-<?= $status ?>"
                                             data-pk="<?= $booking['id'] ?>"
                                             data-name="status"
                                             data-value="<?= $booking['status'] ?>"
                                        >
                                            <?= $label_apartment['booking.' . $booking['status']] ?>
                                        </u>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- end col -->

        </div>
    </div>
</div>