<?php
$check_edit = false;
if(isYourPermission($this->current_controller, 'updateEditable', $this->permission_set)){
    $check_edit = true;
}
$check_collapse = false;
if(isYourPermission($this->current_controller, 'isCollapse', $this->permission_set)){
    $check_collapse = true;
}
$metric = [
    'quantity' => 0,
    'quantity_current_month' => 0,
    'total_room_price' => 0,
    'total_room_price_current_month' => 0
];

$current_month = strtotime(date('01-m-Y'));
foreach ($list_contract as $row) {
    $metric['quantity'] ++;
    $metric['total_room_price'] += $row['room_price'];

    if($row['time_check_in'] >= $current_month) {
        $metric['quantity_current_month'] ++;
        $metric['total_room_price_current_month'] += $row['room_price'];
    }


}

?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item"><a href="#">Khách & Hợp Đồng</a></li>
                            <li class="breadcrumb-item active">Hợp Đồng</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Tất Cả Hợp Đồng</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <table class="table-hover table table-dark">
                        <tr><td colspan="2" class="font-weight-bold text-center"><h3>TỔNG QUAN</h3></td></tr>
                        <tbody>
                        <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Số Lượng Hợp Đồng</td> <td class="text-right font-weight-bold"><?= $metric['quantity'] ?></td></tr>
                        <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Tổng Giá Trị Hợp Đồng (giá thuê)</td> <td class="text-right font-weight-bold"><?= number_format($metric['total_room_price']) ?> vnđ</td></tr>
                        <tr><td colspan="2" class="font-weight-bold text-center"><h3>THÁNG <?= date('m/Y') ?></h3></td></tr>
                        <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Số Lượng Hợp Đồng </td> <td class="text-right font-weight-bold"><?= $metric['quantity_current_month'] ?></td></tr>
                        <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Tổng Giá Trị Hợp Đồng </td> <td class="text-right font-weight-bold"><?= number_format($metric['total_room_price_current_month']) ?> vnđ</td></tr>
                        </tbody>
                    </table>
                    <div>
                        <div><strong>TÙY CHỌN</strong></div>
                        <div class="row mt-2">
                            <?php if(isYourPermission($this->current_controller,'syncStatusExpire', $this->permission_set)): ?>
                                <div class="col-6">
                                    <a href="/admin/contract/sync-status-expire" class="btn
                        btn-danger"><i>Quét Hợp Đồng Hết Hạn</i></a>
                                </div>

                            <?php endif; ?>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">Chọn khoảng <strong>ngày ký</strong></div>
                            <div class="col-6">
                                <input type="text" class="form-control datepicker"
                                       id="time_check_in_from"
                                       value="<?= $this->input->get('timeCheckInFrom')  ? $this->input->get('timeCheckInFrom') : ''?>">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control datepicker"
                                       id="time_check_in_to"
                                       value="<?= $this->input->get('timeCheckInTo') ? $this->input->get('timeCheckInTo') : ''  ?>">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">Chọn khoảng <strong>ngày hết hạn</strong></div>
                            <div class="col-6">
                                <input type="text"
                                       id="time_expire_from"
                                       class="form-control datepicker"
                                       value="<?= $this->input->get('timeExpireFrom') ?>">
                            </div>
                            <div class="col-6">
                                <input type="text"
                                       id="time_expire_to"
                                       class="form-control datepicker"
                                       value="<?= $this->input->get('timeExpireTo') ?>">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">Bộ Phận</div>
                            <div class="col-12">
                                <select id="department" class="form-control">
                                    <option value="">Tất cả</option>
                                    <option value="sale" <?= $this->input->get('department') == 'sale' ? 'selected':'' ?>>Bộ phận kinh doanh</option>
                                    <option value="cd" <?= $this->input->get('department') == 'cd' ? 'selected':'' ?>>Bộ phận vận hành</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6 offset-3">
                                <button id="search" class="btn btn-danger w-100">TÌM</button>
                            </div>
                        </div>

                        <script>
                            commands.push(function(){
                                $('#search').click(function(){
                                    let url = '/admin/list-contract?'+
                                    '&timeCheckInFrom='+$('#time_check_in_from').val()+
                                    '&timeCheckInTo='+$('#time_check_in_to').val()+
                                    '&timeExpireFrom='+$('#time_expire_from').val()+
                                    '&timeExpireTo='+$('#time_expire_to').val()+
                                    '&department='+$('#department').val();
                                    window.location = url;

                                });
                            });
                        </script>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <table class="table-hover table table-dark">
                                <tbody>
                                <tr><td colspan="2" class="font-weight-bold text-center"><h5>BỘ PHẬN KINH DOANH</h5></td></tr>
                                <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Số Lượng Hợp Đồng</td> <td class="text-right font-weight-bold">đang code</td></tr>

                                <tr><td colspan="2" class="font-weight-bold text-center"><h5>BỘ PHẬN VẬN HÀNH</h5></td></tr>
                                <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Số Lượng Hợp Đồng</td> <td class="text-right font-weight-bold">đang code</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if(count($list_notification) > 0
                        && isYourPermission('Contract', 'approved', $this->permission_set) ):
                        ?>
                        <div class="col-md-12">
                            <div class="card-box">
                                <!-- end page title end breadcrumb -->
                                <?php
                                if($this->session->has_userdata('fast_notify')) {
                                    $flash_mess = $this->session->flashdata('fast_notify')['message'];
                                    $flash_status = $this->session->flashdata('fast_notify')['status'];
                                    unset($_SESSION['fast_notify']);
                                    ?>

                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <?= $flash_mess ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <table style="font-size: 13px;" id="listPending" class="table table-dark">
                                    <thead>
                                    <tr class="">
                                        <th width="150px" class="text-center font-weight-bold">ID HỢP ĐỒNG</th>
                                        <th class="text-center font-weight-bold">NỘI DUNG</th>
                                        <th width="100px" class="text-center font-weight-bold">TÙY CHỌN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($list_notification as $row ):
                                        ?>
                                        <tr>
                                            <td class="text-center"><a target = '_blank'
                                                                       href="/admin/detail-contract?id=<?= $row['object_id']
                                                                       ?>">#<?= 1000+ $row['object_id'] ?></a></td>
                                            <td>
                                                <strong>
                                                    <?= $row['message'] ?>
                                                </strong>
                                                <p><small><?= date('d/m/Y H:i', $row['time_insert'])?></small></p>

                                            </td>
                                            <td class="text-center">
                                                <div>
                                                    <a class="btn btn-danger btn-sm"
                                                       href="/admin/contract/approved?contract-id=<?= $row['object_id'] ?>&id=<?= $row['id'] ?>">  Duyệt </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="font-weight-bold text-danger">THÔNG BÁO</h4>
                            <div class="alert alert-danger" role="alert">
                                Không có Hợp đồng nào đang chờ chờ duyệt!
                            </div>
                        </div>

                    </div>

                    <?php endif; ?>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <table class="table-contract table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th width="350px">Khách thuê</th>
                            <th>Giá thuê</th>
                            <th width="250px">Thành Viên Chốt</th>
                            <th>Ngày ký</th>
                            <th>Ngày hết hạn</th>
                            <th class="text-center">Thời hạn</th>
                            <th class="text-center" width="100px">Trạng Thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_contract as $row ): ?>
                            <?php


                            if($this->input->get('department')== 'sale') {
                                if(in_array($row['consultant_id'],$this->arr_general) || $row['is_control_department'] == "YES") {
                                    continue;
                                }
                            }

                            if($this->input->get('department')== 'cd') {
                                if(!in_array($row['consultant_id'],$this->arr_general)) {
                                    if($row['is_control_department'] == "NO")
                                        continue;
                                }
                            }




                            $service = json_decode($row['service_set'], true) ?>
                            <tr>
                                <td>
                                    <div>
                                        <a target = '_blank'
                                           href="/admin/detail-contract?id=<?= $row['id']
                                           ?>">#<?= (10000 + $row['id']) ?></a>

                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted"><?= $libCustomer->getNameById($row['customer_id']).' - '. $libCustomer->getPhoneById($row['customer_id']) ?> </div>
                                    <div class="font-weight-bold text-primary">
                                        <?php
                                        $apartment = $ghApartment->get(['id' => $row['apartment_id']]);
                                        $room = $ghRoom->get(['id' => $row['room_id']]);
                                        $room = $room ? $room[0]:null;
                                        ?>
                                        <?= $apartment ? $apartment[0]['address_street']:'' ?>
                                    </div>
                                    <h6 class="text-danger">
                                        <?= $room ? 'mã phòng: '.$room['code'] : '[không có thông tin]' ?>
                                    </h6>
                                </td>
                                <td>
                                    <div class="contract-room_price font-weight-bold"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= $row['room_price'] ?>"
                                         data-name="room_price">
                                        <?= number_format($row['room_price']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="consultant_id font-weight-bold"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= $row['consultant_id'] ?>"
                                         data-name="consultant_id">
                                        <?= $libUser->getNameByAccountid
                                        ($row['consultant_id']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="contract-time_check_in"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= date('d/m/Y',$row['time_check_in']) ?>"
                                         data-name="time_check_in">
                                        <?=$row['time_check_in'] ? date('d/m/Y',$row['time_check_in']):'-' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="contract-time_expire"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= date('d/m/Y',$row['time_expire']) ?>"
                                         data-name="time_expire">
                                        <?=$row['time_expire'] ? date('d/m/Y',$row['time_expire']):'-' ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="contract-number_of_month"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= $row['number_of_month'] ?>"
                                         data-name="number_of_month">
                                        <?=$row['number_of_month'] ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <?php
                                        $statusClass = 'muted';
                                        if($row['status'] == 'Active') {
                                            $statusClass = 'success';
                                        }
                                        if($row['status'] == 'Pending') {
                                            $statusClass = 'warning';
                                        }
                                        if($row['status'] == 'Cancel') {
                                            $statusClass = 'danger';
                                        }

                                        if($row['status'] == 'Expired') {
                                            $statusClass = 'secondary';
                                        }
                                        ?>
                                        <span class="badge badge-<?= $statusClass ?>
                                    font-weight-bold">
                                    <?= $label_apartment['contract.'.$row['status']] ?>
                                    </span>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    commands.push(function(){
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });

        $('.table-contract').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            responsive: true,
            "fnDrawCallback": function() {
                // x editable
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
                    mode: 'popup',
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

                $('.consultant_id').editable({
                    url: '<?= base_url() ?>admin/update-contract-editable',
                    inputclass: '',
                    type: 'select2',
                    mode: 'inline',
                    source: function() {
                        data = [];
                        $.ajax({
                            url: '<?= base_url() ?>admin/user/get-select',
                            dataType: 'json',
                            async: false,
                            success: function(res) {
                                data = res;
                                return res;
                            }
                        });
                        return data;
                    },
                    select2:{
                        placeholder: 'Chọn thành viên...',
                        minimumInputLength: 1
                    },
                });
                <?php endif; ?>
            } // end fnDrawCallback
        });
    });
</script>
