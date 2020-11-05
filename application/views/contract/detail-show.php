<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card-box shadow">
                    <h3>Chi tiết hợp đồng</h3>
                    <table class="table table-bordered">
                    <?php 
                        $customer = $ghCustomer->get(['id' => $contract['customer_id']])[0];
                        $service = json_decode($contract['service_set'], true);

                        $room = $ghRoom->get(['id' => $contract['room_id']])[0];

                        $image = $ghImage->getContract($contract['id']);
                    
                    ?>
                        <tr class="d-none">
                            <td colspan="2" class="text-right"><div class="customer-name w-100" data-name="name">
                            <a class="btn btn-warning" href="#">Hình Ảnh</a>
                            <a class="btn btn-warning" href="#">Duyệt</a>
                            </div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Trạng Thái <strong></td>
                            <td><div class="customer-name w-100" data-name="name"><?= $contract['status'] ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Hình Ảnh <strong></td>
                            <td>
                                <?php if(count($image) > 0):?>
                            <?php foreach($image as $ii ):?>    
                            <a target = '_blank' href="<?= $image ? '/media/contract/'.$ii['name'] : '#' ?>"><?= $ii['name'] ?></a> <br>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Tên Khách Thuê <strong></td>
                            <td><div class="customer-name w-100" data-name="name"><?= $customer['name'] ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Sinh <strong></td>
                            <td ><div class="customer-name" data-name="name"><?= $customer['birthdate'] > 0 ? date('d/m/Y', $customer['birthdate']) : '' ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Số điện thoại <strong></td>
                            <td><div class="customer-name" data-name="name"><?= $customer['phone'] ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ghi Chú Khách Thuê <strong></td>
                            <td><div class="customer-name" data-name="name"><?= $customer['note'] ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Dự Án Thuê <strong></td>
                            <td><div class="customer-name" data-name="name"> <?= $service['address_street'] ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Mã Phòng <strong></td>
                            <td><div class="customer-name" data-name="name"> <?= $room['code'] ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Giá Thuê<strong></td>
                            <td><div class="customer-name" data-name="name"><?= number_format($contract['room_price']) . ' VND' ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Ký<strong></td>
                            <td><div class="customer-name" data-name="name"><?= $contract['time_check_in'] > 0 ? date('d/m/Y', $contract['time_check_in']) : '' ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Thời Hạn<strong></td>
                            <td><div class="customer-name" data-name="name"><?= $contract['number_of_month'] . ' tháng' ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Hết Hạn<strong></td>
                            <td><div class="customer-name" data-name="name"><?= $contract['time_expire'] > 0 ? date('d/m/Y', $contract['time_expire']) : '' ?></div></td>
                        </tr>
                        
                        <tr>
                            <td class="text-right"><strong>Ghi Chú Hợp Đồng <strong></td>
                            <td><div class="customer-name" data-name="name"><?= $contract['note'] ?></div></td>
                        </tr>
                        
                        <tr>
                            <td class="text-right"><strong>Dịch Vụ, Ghi Chú Tòa Nhà (tại thời điểm tạo HD) <strong></td>
                            <td><div class="customer-name" data-name="name">
                                <?php foreach($service as $k => $v):?>
                                    <?= isset($label[$k]) ? '<strong>'.$label[$k] .'</strong> : ('.$v.')<br>' :''  ?>
                                <?php endforeach; ?>
                            </div></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>