<?php

$check_contract = in_array($this->auth['role_code'], ['human-resources','product-manager', 'ceo', 'customer-care']);
$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

$check_contract = false;
if(isYourPermission('Contract', 'createShow', $this->permission_set)){
    $check_contract = true;
}

?>

<div class="wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <!-- meta -->
                <div class="profile-user-box card-box bg-warning">
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="pull-left mr-3"><img src="https://i.pinimg.com/originals/94/26/01/942601fcae9bb10c21b0537a3750d65e.gif" alt="" class="thumb-lg rounded-circle"></span>
                            <div class="media-body text-white">
                                <h4 class="mt-1 font-18"><?= $profile['address_street'] ?>, Quận <?= $profile['district_code'] ?></h4>
                                <div class="row pl-2">
                                    <div class="col-12 p-1"> <?= $profile['description'] ?></div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!--/ meta -->
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <!-- Personal-Information -->
                <div class="card-box">
                    <h4 class="mt-0 m-b-20 text-danger">Thông tin chung</h4>
                    <div class="panel-body">
                        <p class="text-primary font-13" style="white-space: pre-line">
                            <?= $profile['note'] ?>
                        </p>

                        <hr/>

                        <div class="text-left">
                            <p class="text-primary font-13"><strong>Điện :</strong> <span
                                    class="m-l-15"><?= $profile['electricity'] ?></span></p>

                            <p class="text-primary font-13"><strong>Nước :</strong><span
                                    class="m-l-15"><?= $profile['water'] ?></span></p>

                            <p class="text-primary font-13"><strong>Internet :</strong>
                                <span class="m-l-15"><?= $profile['internet'] ?></span></p>
                            <p class="text-primary font-13"><strong>Thang máy :</strong>
                                <span class="m-l-15"><?= $profile['elevator'] ?></span></p>
                            <p class="text-primary font-13"><strong>Máy giặt :</strong>
                                <span class="m-l-15"><?= $profile['washing_machine'] ?></span></p>
                            <p class="text-primary font-13"><strong>Dọn Phòng :</strong>
                                <span class="m-l-15"><?= $profile['room_cleaning'] ?></span></p>
                            <p class="text-primary font-13"><strong>Giữ xe:</strong>
                                <span class="m-l-15"><?= $profile['parking'] ?></span></p>

                            <p class="text-primary font-13"><strong>Số người ở :</strong>
                                <span class="m-l-15"><?= $profile['number_of_people'] ?></span></p>

                            <p class="text-primary font-13"><strong>Bếp :</strong>
                                <span class="m-l-15"><?= $profile['kitchen'] ?></span></p>

                            <p class="text-primary font-13"><strong>Bãi Ô tô :</strong>
                                <span class="m-l-15"><?= $profile['car_park'] ?></span></p>

                            <p class="text-primary font-13"><strong>Hướng :</strong>
                                <span class="m-l-15"><?= $profile['direction'] ?></span></p>
                            <p class="text-primary font-13"><strong>KT3 :</strong>
                                <span class="m-l-15"><?= $profile['kt3'] ?></span></p>

                            <p class="text-primary font-13"><strong>PET :</strong>
                                <span class="m-l-15"><?= $profile['pet'] ?></span></p>

                            <p class="text-primary font-13"><strong>Chi phí phụ :</strong>
                                <span class="m-l-15"><?= $profile['extra_fee'] ?></span></p>

                            <p class="text-primary font-13"><strong>Bảo vệ :</strong>
                                <span class="m-l-15"><?= $profile['security'] ?></span></p>


                            <p class="text-primary font-13"><strong>Dài Hạn:</strong>
                                <span class="m-l-15"><?= $profile['contract_long_term'] ?></span></p>

                            <p class="text-primary font-13"><strong>Ngắn Hạn:</strong>
                                <span class="m-l-15"><?= $profile['contract_long_term'] ?></span></p>

                            <p class="text-primary font-13"><strong>Cọc :</strong>
                                <span class="m-l-15"><?= $profile['deposit'] ?></span></p>
                            <p class="text-primary font-13"><strong>Hoa Hồng 6m :</strong>
                                <span class="m-l-15"><?= $profile['commission_rate_6m'] ?></span></p>
                            <p class="text-primary font-13"><strong>Hoa Hồng 6m :</strong>
                                <span class="m-l-15"><?= $profile['commission_rate_9m'] ?></span></p>

                            <p class="text-primary font-13"><strong>Hoa Hồng 12m :</strong>
                                <span class="m-l-15"><?= $profile['commission_rate'] ?></span></p>

                            <p class="text-primary font-13"><strong>Cập nhật vào :</strong>
                                <span class="m-l-15"><?= date('d/m/Y',$profile['time_update'])
                                    ?></span></p>

                        </div>

                    </div>
                </div>
                <!-- Personal-Information -->

            </div>


            <div class="col-md-8">

                <div class="row">

                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="icon-layers float-right text-muted"></i>
                            <h5 class="text-danger mt-0">Hợp đồng</h5>
                            <h2 class="m-b-20" data-plugin="counterup"><?= count
                                ($contract) ?></h2>
                        </div>
                    </div><!-- end col -->

                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="icon-layers float-right text-muted"></i>
                            <h5 class="text-danger mt-0">Phòng</h5>
                            <h2 class="m-b-20" data-plugin="counterup"><?= count
                                ($room) ?></h2>
                        </div>
                    </div><!-- end col -->

                </div>
                <!-- end row -->

                <div class="card-box">
                    <h4 class="mb-3">Hợp Đồng</h4>

                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ngày Ký</th>
                                <th>Ngày Hết Hạn</th>
                                <th class="text-center">Thời Hạn</th>
                                <th>Phòng</th>
                                <th class="text-center">Khách Thuê</th>
                                <th class="text-center">Trạng Thái</th>
                                <th>Giá Thuê</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($contract as $c):
                                $statusClass = 'muted';
                                if($c['status'] == 'Active') {
                                    $statusClass = 'success';
                                }
                                if($c['status'] == 'Pending') {
                                    $statusClass = 'warning';
                                }
                                if($c['status'] == 'Cancel') {
                                    $statusClass = 'danger';
                                }

                                if($c['status'] == 'Expired') {
                                    $statusClass = 'secondary';
                                }
                                ?>
                            <tr>
                            <td><?= $c['id'] ?></td>
                            <td><?= date('d/m/Y',$c['time_check_in']) ?></td>
                            <td><?= date('d/m/Y',$c['time_expire']) ?></td>
                            <td class="font-weight-bold text-center"><?= $c['number_of_month']
                                ?></td>
                            <td><?= $c['room_code'] ?></td>
                            <td class="text-center">
                                <?= $libCustomer->getNameById($c['customer_id']) ?> <br>
                                <span class="font-weight-bold text-center"><?=
                                    $libCustomer->getPhoneById
                                    ($c['customer_id']) ?></span>

                            </td>
                            <td class="text-center"><span class="badge badge-<?= $statusClass ?>
                                    font-weight-bold">
                                    <?= $label_apartment['contract.'.$c['status']] ?>
                                    </span></td>
                            <td><?= number_format($c['room_price']) ?></td>
                            </tr>
                            <?php endforeach;?>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="card-box">
                    <h4 class="mb-3">Phòng</h4>

                    <div class="table-responsive">
                        <table class="table m-b-0 table-data">
                            <thead>
                            <tr>
                                <th>Mã Phòng</th>
                                <th>Loại Phòng</th>
                                <th>Giá</th>
                                <th>Diện Tích</th>
                                <th>Trạng Thái</th>
                                <th>Ngày Trống</th>
                                <th>Tùy Chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($room as $r):
                                $statusClass = 'muted';


                                if($r['status'] == 'Expired') {
                                    $statusClass = 'secondary';
                                }

                                if($r['status'] == 'Available') {
                                    $bg_for_available = 'bg-gh-apm-card';
                                    $color_for_available = 'text-primary';
                                }
                                else {
                                    $bg_for_available = '';
                                    $color_for_available = '';
                                }
                                ?>
                                <tr class='<?= $bg_for_available ?>'>
                                    <td><?= $r['code'] ?></td>
                                    <td><?= $r['type'] ?></td>
                                    <td><?= number_format($r['price']) ?></td>
                                    <td><?= $r['area'] ?></td>
                                    <td class="text-center font-weight-bold <?= $color_for_available ?>">
                                        <?= $r['status'] ? $label_apartment[$r['status']] : '#' ?>
                                    </td>
                                    <td><?= $r['time_available'] ? date('d-m-Y',$r['time_available']) :'' ?></td>
                                    <td>
                                        <?php if($check_contract):?>
                                            <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $r['id'] ?>">
                                                <button data-room-id="<?= $r['id'] ?>" type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                                    <i class="mdi mdi-file-document"></i>
                                                </button>
                                            </a>
                                        <?php endif;?>

                                    </td>
                                </tr>
                            <?php endforeach;?>

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
    commands.push(function() {
        $('.table-data').DataTable();
    });
</script>