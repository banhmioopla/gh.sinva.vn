<div class="wrapper">
    <div class="container-fluid">
        <style>
            .block-profile-header .bg-warning{
                opacity: .8;
            }
            .block-profile-header .profile-header{
                background-image: url(https://i.pinimg.com/originals/38/57/f2/3857f2282c6864671ff080348071189f.gif);
                background-position: center center;
                background-size: cover;
                opacity: 1;
                min-height: 265px;
            }
        </style>
        <div class="row block-profile-header">
            <div class="col-sm-12">
                <!-- meta -->
                <div class="profile-user-box card-box  profile-header">
                </div>
                <!--/ meta -->
            </div>
        </div>
<?php
$data = array_values($list_user_income)[0];

?>

        <div class="row">

            <div class="col-md-4">
                <div class="col-sm-12">
                    <div class="card-box tilebox-one">
                        <i class="icon-layers float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Hợp Đồng</h6>
                        <h2 class="m-b-20" ><?= count($list_contract) ?></h2>
                    </div>
                </div><!-- end col -->

                <div class="col-sm-12">
                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Số Khách Hàng</h6>
                        <h2 class="m-b-20"><span ><?= count($list_customer) ?></span></h2>
                    </div>
                </div><!-- end col -->

                <div class="col-sm-12">
                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Số Lượt Book</h6>
                        <h2 class="m-b-20"><span ><?= count($list_booking) ?></span></h2>
                    </div>
                </div><!-- end col -->

                <!-- Personal-Information -->
                <div class="card-box">
                    <h4 class="mt-0 m-b-20">Thông tin cá nhân</h4>
                    <div class="panel-body">
                        <p class="text-muted font-13">
                            #đang phát triển...
                        </p>

                        <hr/>

                        <div class="text-left">
                            <p class="text-muted "><strong>Họ Tên :</strong> <span
                                        class="m-l-15"><?= $user['name'] ?></span></p>

                            <p class="text-muted "><strong>Số điện thoại:
                                </strong><span
                                        class="m-l-15"><?= $libPhone->formatPhone($user['phone_number']) ?></span></p>

                            <p class="text-muted"><strong>Email: </strong>
                                <span class="m-l-15"><?= $user['email'] ?></span></p>

                        </div>

                        <ul class="social-links list-inline m-t-20 m-b-0">
                            <li class="list-inline-item">
                                <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Personal-Information -->

                <div class="card-box ribbon-box">
                    <div class="ribbon ribbon-primary">Thông báo</div>
                    <p>đang phát triển...</p>
                </div>

            </div>
            <div class="col-md-8">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="bg-dark card-box">
                            <span class="pull-left mr-3">
                                <img src="https://media2.giphy.com/media/H4DjXQXamtTiIuCcRU/giphy.gif" alt=""
                                                              class="thumb-lg rounded-circle img-thumbnail"></span>
                            <div class="media-body text-white text-center">
                                <h3 class="font-weight-bold text-warning"><?= $user['name'] ?></h3>
                                <div class="row pl-2">
                                    <div class="col-12 p-1"><i class="mdi mdi-account-box"></i> <?= $role['name'] ?></div>
                                    <div class="col-12 p-1"><i class="mdi mdi-cellphone-android"></i> <?= $libPhone->formatPhone($user['phone_number']) ?></div>

                                </div>
                            </div>
                        </div>

                    </div>



                </div>

                <div class="card-box">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <select name="" id="month" class="form-control">
                                <?php for ($i = 1; $i <= 12; $i++ ):?>
                                    <option value="<?= $i ?>"
                                        <?= $this->input->get('from-month') == $i ? "selected":"" ?>
                                    > Tổng Kết Tháng <?= $i ?></option>
                                <?php endfor;?>
                            </select>
                            <script>
                                commands.push(function () {
                                    $('#month').change(function () {
                                        let current_url = window.location.href;
                                        let current_month = 'from-month=<?= $this->input->get("from-month") ?>';
                                        let select_month = 'from-month='+$('#month').val();
                                        let new_url = current_url.replace(current_month, select_month);
                                        window.location = new_url;
                                    });

                                });
                            </script>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-bordered m-b-0">
                            <tbody>
                            <tr>
                                <td style="width: 40%"><i class="mdi mdi-chevron-double-right text-warning"></i> Số Lượng Hợp Đồng</td>
                                <td class="text-right font-weight-bold"><?= $data['quantity_contract']
                                    ?></td>
                            </tr>
                            <tr>
                                <td><i class="mdi mdi-chevron-double-right text-warning"></i> Tổng Doanh Số</td>
                                <td class="text-right font-weight-bold"><?= number_format($data['total_sale']) ?> vnđ</td>
                            </tr>
                            <tr>
                                <td><i class="mdi mdi-chevron-double-right text-warning"></i> Tổng Thu Nhập Từ Hợp Đồng</td>
                                <td class="text-right font-weight-bold"><?= number_format($data['total_personal_income']) ?> vnđ</td>
                            </tr>
                            <tr>
                                <td><i class="mdi mdi-chevron-double-right text-warning"></i> Tổng Thu Nhập Từ Tuyển Thành Viên </td>
                                <td class="text-right font-weight-bold"><?= number_format($data['total_refer_income']) ?> vnđ</td>
                            </tr>
                            <tr>
                                <td><i class="mdi mdi-chevron-double-right text-warning"></i> Tổng Thu Nhập Từ Lấy Dự Án Mới</td>
                                <td class="text-right"><?= number_format($data['total_get_new_apartment_total']) ?> vnđ</td>
                            </tr>
                            <tr>
                                <td><i class="mdi mdi-chevron-double-right text-warning"></i> Các Danh Mục Trừ Tiền</td>
                                <td class="text-right">
                                <?php

                                $pen_fee = 0;
                                $pen_rate = 0;
                                if(count($personal_penalty) > 0):?>
                                    <?php foreach ($personal_penalty as $p):
                                        $penalty_name = $libPenalty->getNameById($p['penalty_id']);

                                        ?>
                                        <p class="text-danger text-left font-weight-bold">
                                            <?= $penalty_name ?></p>
                                        <ul>

                                            <?php  if($p['fee'] > 0):  $pen_fee += $p['fee']; ?>
                                            <li>
                                                <?= $p['fee'] > 0 ? number_format($p['fee']) : '' ?>
                                            </li>
                                            <?php endif; ?>
                                            <?php  if($p['income_rate'] > 0): $pen_rate
                                             += $p['income_rate']   ?>
                                                <li>
                                                    <?= $p['income_rate'] . '%' ?>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <small class="text-info font-weight-bold">không có khoản trừ tiền</small>
                                <?php endif; ?>

                                </td>
                            </tr>
                            <tr class="bg-dark text-success">
                                <th class="font-weight-bold">Tổng Thu Nhập</th>

                                <?php
                                $final = $data['total_personal_income'] - $pen_fee -
                                ($pen_rate/100*$data['total_personal_income'])

                                ?>
                                <th class="text-right font-weight-bold"><?= number_format($final) ?></th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">Bảng Khách Hàng</h4>
                    <table class="table table-dark table-data">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Số Điện Thoại</th>
                            <th>Email</th>
                            <th>Ghi Chú</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_customer as $customer):

                            ?>
                            <tr>
                                <th scope="row"><u><a target = '_blank'
                                                      class="text-warning"
                                                      href="/admin/detail-customer?id=<?= $customer['id'] ?>"
                                                      ><?= $customer['id'] ?></a></u></th>
                                <td><?= $customer["name"] ? $customer["name"] : '<i>không có thông tin</i>' ?></td>
                                <td><?= $customer["phone"] ? $customer["phone"] : '<i>không có thông tin</i>' ?></td>
                                <td><?= $customer["email"] ? $customer["email"] : '<i>không có thông tin</i>' ?></td>
                                <td><?= $customer["note"] ? $customer["note"] : '<i>không có thông tin</i>' ?></td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-box">
                    <h4 class="text-danger font-weight-bold">Bảng Hợp Đồng</h4>
                    <table class="table table-dark table-data">
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
                                <th scope="row" style="width: 5%"><u><a target = '_blank'
                                                      class="text-warning"
                                                      href="/admin/detail-contract?id=<?= $contract['id']
                                                      ?>"><?= ($contract['id']) ?></a></u></th>
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
                    <h4 class="text-danger font-weight-bold">Bảng Dẫn Khách</h4>

                    <div class="table-responsive">
                        <table class="table table-dark">
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
                                        <div class="font-weight-bold"><?= $libCustomer->getNameById($booking['customer_id']) ?></div>
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
        <!-- end row -->

    </div> <!-- end container -->
</div>

<script>
    commands.push(function(){
        $('.table-data').DataTable();
    });
</script>