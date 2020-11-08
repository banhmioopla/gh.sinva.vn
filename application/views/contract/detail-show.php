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
            <?php
            $customer = $ghCustomer->get(['id' => $contract['customer_id']])[0];
            $service = json_decode($contract['service_set'], true);

            $room = $ghRoom->get(['id' => $contract['room_id']])[0];

            $image = $ghImage->getContract($contract['id']);
            $status = 'warning';

            if($contract['status'] == 'Active') {
                $status = 'success';
            }
            if($contract['status'] == 'Pending') {
                $status = 'warning';
            }
            if($contract['status'] == 'Cancel') {
                $status = 'danger';
            }
            if($contract['status'] == 'Expired') {
                $status = 'secondary';
            }

            ?>
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card-box shadow">
                    <h3 class="text-center">Chi tiết hợp đồng</h3>
                    <p class="text-center text-dark"><?= $service['address_street'] ?></p>
                    <p class="text-center text-warning font-weight-bold">Mã Phòng: <?=
                        $room['code'] ?></p>
                    <p><a href="/admin/list-contract" class="text-danger">Quay Lại Danh
                            Sách</a></p>
                    <table class="table table-bordered">

                        <tr class="d-none">
                            <td colspan="2" class="text-right" width="250px"><div
                                        class="customer-name w-100" data-name="name">
                            <a class="btn btn-warning" href="#">Hình Ảnh</a>
                            <a class="btn btn-warning" href="#">Duyệt</a>
                            </div></td>
                        </tr>
                        <tr>
                            <td class="text-right" width="200px"><strong>Trạng Thái
                                    <strong></td>
                            <td><div class="customer-name w-100 "
                                     data-name="name"><span class="badge
                                     badge-<?= $status ?>"><?= $label['contract.'
                                     .$contract['status']]
                                        ?></span></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Thành Viên Chốt
                                    Sale <strong></td>
                            <td><div class="consultant_id w-100" data-name="name">
                                    <?= $libUser->getNameByAccountid($contract['consultant_id']) ?></div></td>
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
                            <td><div class="contract-room_price"
                                     data-name="room_price"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['room_price'] ?>"><?= number_format($contract['room_price']) . ' VND' ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Ký<strong></td>
                            <td><div class="contract-time_check_in"
                                     data-name="time_check_in"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= date('d/m/Y',$contract['time_check_in']) ?>"><?= $contract['time_check_in'] > 0 ? date('d/m/Y', $contract['time_check_in']) : '' ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Thời Hạn<strong></td>
                            <td><div class="contract-number_of_month"
                                     data-name="number_of_month"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['number_of_month'] ?>"><?= $contract['number_of_month'] . ' tháng' ?></div></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Hết Hạn<strong></td>
                            <td><div class="contract-time_expire"
                                     data-name="time_expire"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= date('d/m/Y',$contract['time_expire'])
                                     ?>"><?= $contract['time_expire'] > 0 ? date('d/m/Y', $contract['time_expire']) : '' ?></div></td>
                        </tr>
                        
                        <tr>
                            <td class="text-right"><strong>Ghi Chú Hợp Đồng <strong></td>
                            <td><div class="contract-note"
                                     data-name="note"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['note'] ?>"><?=
                                    $contract['note'] ?></div></td>
                        </tr>
                        
                        <tr>
                            <td class="text-right"><strong>Thông Tin Dịch Vụ, Ghi Chú Tòa
                                    Nhà <br>
                                    (tại thời điểm tạo HD) <strong></td>
                            <td><div class="customer-name" data-name="name">
                                <?php foreach($service as $k => $v):?>
                                    <?= isset($label[$k]) && $k != 'commission_rate' ? '<strong>'
                                        .$label[$k]
                                        .'</strong> : ('.$v.')<br>' :''  ?>
                                <?php endforeach; ?>
                            </div></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$check_edit = false;
if(isYourPermission($this->current_controller, 'updateEditable', $this->permission_set)){
    $check_edit = true;
}

?>
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            <?php if($check_edit): ?>
            $('.contract-room_price, .contract-number_of_month').editable({
                type: "number",
                url: '<?= base_url() ?>admin/update-contract-editable',
                inputclass: '',
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });
            $('.contract-note').editable({
                type: "textarea",
                url: '<?= base_url() ?>admin/update-contract-editable',
                inputclass: '',
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });
            $('.contract-time_expire, .contract-time_check_in').editable({
                placement: 'right',
                type: 'combodate',
                template:"D / MM / YYYY",
                format:"DD-MM-YYYY",
                viewformat:"DD-MM-YYYY",
                mode: 'inline',
                combodate: {
                    firstItem: 'name',
                    maxYear: '2030',
                    minYear: '2017'
                },
                inputclass: 'form-control-sm',
                url: '<?= base_url() ?>admin/update-contract-editable',
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });
            <?php endif; ?>
        });
    });
</script>