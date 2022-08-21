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
    'total_sale' => 0,
];

$current_month = strtotime(date('01-m-Y'));
foreach ($list_contract as $row) {
    $metric['quantity'] ++;
    $metric['total_sale'] += $row['room_price']*$row['commission_rate']/100;
}
?>

<div class="wrapper">
    <div class="container-fluid">
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
            <div class="col-md text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-4">
                            <h4><strong class="text-danger">Tổng quan</strong></h4>
                            <table class="table-hover table table-dark">
                                <tbody>
                                <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Số lượng</td> <td class="text-right font-weight-bold"><?= $metric['quantity'] ?></td></tr>
                                <tr><td> <i class="mdi mdi-chevron-double-right text-warning"></i> Tổng doanh thu</td> <td class="text-right font-weight-bold"><?= number_format($metric['total_sale']) ?> vnđ</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-8">
                            <h4><strong class="text-danger">Chờ duyệt</strong></h4>
                            <div class="row">
                                <?php if(count($list_notification) > 0
                                    && isYourPermission('Contract', 'approved', $this->permission_set) ):
                                    ?>
                                    <div class="col-md-12 text-danger font-weight-bold" id="alert-msg"></div>
                                    <div class="col-md-12">
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
                                                <th class="text-center font-weight-bold">Nội dung</th>
                                                <th class="text-center font-weight-bold">Ngày tạo</th>
                                                <th width="100px" class="text-center font-weight-bold">TÙY CHỌN</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($list_notification as $row ):
                                                $contract_checker = $this->ghContract->get([
                                                        'id' => $row["object_id"],
                                                        'status <>' => 'Cancel',
                                                ]);
                                                if(!$contract_checker) continue;
                                                ?>
                                                <tr>
                                                    <td class="text-center"><a target = '_blank'
                                                                               href="/admin/detail-contract?id=<?= $row['object_id']
                                                                               ?>">#<?= 1000+ $row['object_id'] ?></a></td>
                                                    <td>
                                                        <strong>
                                                            <?= $row['message'] ?>
                                                        </strong>

                                                    </td>
                                                    <td class="text-center"><?= date('d/m/Y H:i', $row['time_insert'])?></td>
                                                    <td class="text-center w-25">
                                                        <div class="list-action">
                                                            <a class="m-1" href="/admin/contract/approved?contract-id=<?= $row['object_id'] ?>&id=<?= $row['id'] ?>" >
                                                                <button class="btn btn-sm btn-outline-light btn-rounded waves-light waves-effect">Duyệt</button>
                                                            </a>
                                                            <button data-contract-id="<?= $row['object_id'] ?>" class="contract-cancel btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect">Huỷ</button>
                                                        </div>
                                                        <div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
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
                    <h4><strong class="text-danger">Tìm kiếm</strong></h4>
                    <div class="row">

                        <div class="col-12">Chọn khoảng <strong>ngày ký</strong></div>
                        <div class="col-6">
                            <input type="text" class="form-control datepicker"
                                   id="time_check_in_from"
                                   value="<?= $timeCheckInFrom?>">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control datepicker"
                                   id="time_check_in_to"
                                   value="<?= $timeCheckInTo  ?>">
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
                        <div class="col-4 offset-4">
                            <button id="search" class="btn btn-danger w-100">Áp Dụng</button>
                        </div>
                    </div>

                    <script>
                        commands.push(function(){
                            $('#search').click(function(){
                                let url = '/admin/list-contract?'+
                                    '&timeCheckInFrom='+$('#time_check_in_from').val()+
                                    '&timeCheckInTo='+$('#time_check_in_to').val()+
                                    '&timeExpireFrom='+$('#time_expire_from').val()+
                                    '&timeExpireTo='+$('#time_expire_to').val();
                                window.location = url;

                            });
                        });
                    </script>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-box table-responsive">
                    <h4 class="font-weight-bold text-danger">Danh Sách Hợp Đồng Thuê Phòng</h4>
                    <table class="table-contract  table table-dark table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th width="350px">Khách thuê</th>
                            <th class="text-right">Giá thuê <small>x1000</small></th>
                            <th class="text-right">Giá cọc <small>x1000</small></th>
                            <th class="text-right">(*)</th>

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
                            $service = json_decode($row['service_set'], true);
                            $partial_amount = 0;
                            $list_partial = $ghContractPartial->get(['contract_id' => $row['id']]);
                            foreach ($list_partial as $item) {
                                $partial_amount += $item['amount'];
                            }

                            ?>
                            <tr>
                                <td>
                                    <div>
                                        <a target = '_blank'
                                           href="/admin/detail-contract?id=<?= $row['id']
                                           ?>">#<?= (10000 + $row['id']) ?></a>

                                    </div>
                                </td>
                                <td>
                                    <div><?= $libCustomer->getNameById($row['customer_id']).' - '. $libCustomer->getPhoneById($row['customer_id']) ?> </div>
                                    <div class="font-weight-bold text-warning"> <i class=" dripicons-home"></i>
                                        <?php
                                        $apartment = $ghApartment->get(['id' => $row['apartment_id']]);
                                        $room = $ghRoom->get(['id' => $row['room_id']]);
                                        $room = $room ? $room[0]:null;
                                        ?>
                                        <?= $apartment ? $apartment[0]['address_street']:'' ?> <?= $room ? "(" . $room['code']. ")" : '[không có mp]' ?>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="contract-room_price text-warning font-weight-bold"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= $row['room_price'] ?>"
                                         data-name="room_price">
                                        <?= number_format($row['room_price']/1000) ?>
                                    </div>
                                </td>
                                <td class="font-weight-bold"><?= number_format($row["deposit_price"]) ?></td>
                                <td class="font-weight-bold"><?= $row["rate_type"] *1 ?></td>
                                <td>
                                    <div class="consultant_id text-warning font-weight-bold"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= $row['consultant_id'] ?>"
                                         data-name="consultant_id">
                                        <?= $libUser->getNameByAccountid
                                        ($row['consultant_id']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="contract-time_check_in text-warning"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= date('d/m/Y',$row['time_check_in']) ?>"
                                         data-name="time_check_in">
                                        <?=$row['time_check_in'] ? date('d/m/Y',$row['time_check_in']):'-' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="contract-time_expire text-warning"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= date('d/m/Y',$row['time_expire']) ?>"
                                         data-name="time_expire">
                                        <?=$row['time_expire'] ? date('d/m/Y',$row['time_expire']):'-' ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="contract-number_of_month text-warning"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= $row['number_of_month'] ?>"
                                         data-name="number_of_month">
                                        <?=$row['number_of_month'] ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <?php
                                        $statusClass = 'muted'; $doc_type = "Cọc ";
                                        if($row['status'] == 'Active') {
                                            $statusClass = 'success';
                                        }
                                        if($row['status'] == 'Pending') {
                                            $statusClass = 'warning';
                                            $doc_type .= " Chờ duyệt";
                                        }

                                        if(time() >= $row["time_check_in"]){
                                            $doc_type = "HĐ đã ký ";
                                        }
                                        if(time() >= $row["time_expire"]){
                                            $doc_type = "HĐ hết hạn ";
                                            $statusClass = 'secondary';
                                        }

                                        if($row['status'] == 'Cancel') {
                                            $statusClass = 'warning';
                                            $doc_type .= " Đã huỷ";
                                        }
                                        ?>
                                        <span class="badge badge-<?= $statusClass ?> font-weight-bold"><?=  $doc_type ?></span>

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
        $('.contract-cancel').click(function(){
            let _this = $(this);
            let contract_id = $(this).data('contract-id');
            $.ajax({
                url: '<?= base_url() ?>admin/update-contract-editable',
                data: {value: 'Cancel', name: 'status', pk: contract_id},
                method: 'POST',
                success:function(){
                    $('#alert-msg').text("đã huỷ hợp đồng thành công!");
                    _this.closest("tr").remove();
                }
            });
        });
        $('.table-contract').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            "aaSorting": [],
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
