<?php 
$check_edit = false;
if(isYourPermission($this->current_controller, 'updateEditable', $this->permission_set)){
    $check_edit = true;
}
$check_collapse = false;
if(isYourPermission($this->current_controller, 'isCollapse', $this->permission_set)){
    $check_collapse = true;
}

?>

<div class="wrapper">
<div class="sk-wandering-cubes" style="display:none" id="loader">
    <div class="sk-cube sk-cube1"></div>
    <div class="sk-cube sk-cube2"></div>
</div>
    <div class="container">

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
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($this->session->has_userdata('fast_notify')) {
                $flash_mess = $this->session->flashdata('fast_notify')['message'];
                $flash_status = $this->session->flashdata('fast_notify')['status'];
                unset($_SESSION['fast_notify']);
            }  
        ?>
        <div class="contract-alert"></div>
        <?php $this->load->view('components/list-navigation'); ?>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box table-responsive shadow">
                    <div>
                        <table class="table table-dark">
                            <tbody>
                            <tr>
                                <th scope="row"><i class="mdi mdi-chevron-double-right text-light"></i> Số Lượng Hợp Đồng </th>
                                <td class="text-right"><?= count($list_contract) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><i class="mdi mdi-chevron-double-right text-light"></i> Số Lượng Hợp Đồng Tháng <?= date('m/Y') ?> </th>
                                <td class="text-right">#dangcode</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php if(isYourPermission($this->current_controller,'syncStatusExpire', $this->permission_set)): ?>
                        <a href="/admin/contract/sync-status-expire" class="btn
                        btn-danger"><i>Duyệt Sang Hợp Đồng Hết Hạn</i></a>
                    <?php endif; ?>

                    <?php if(isYourPermission($this->current_controller, 'showAllTimeLine', $this->permission_set)):?>
                        <div class="form-group mt-3">
                            <select name="filterTime" class="form-control">
                                <option <?= $this->input->get('filterTime') == '' ? 'selected' : '' ?>
                                        value="ALL">Tất cả (NGÀY HẾT
                                    HẠN)
                                </option>
                                <option <?= $this->input->get('filterTime') == 'TODAY' ? 'selected' : '' ?>
                                        value="TODAY">Hôm nay
                                </option>
                                <option <?= $this->input->get('filterTime') == 'NEXT_7D' ? 'selected' : '' ?>
                                        value="NEXT_7D">7 Ngày Nữa
                                </option>
                                <option <?= $this->input->get('filterTime') == 'NEXT_15D' ? 'selected' : '' ?>
                                        value="NEXT_15D">15 Ngày Nữa
                                </option>
                                <option <?= $this->input->get('filterTime') == 'NEXT_30D' ? 'selected' : '' ?>
                                        value="NEXT_30D">30 Ngày Nữa
                                </option>
                                <option <?= $this->input->get('filterTime') == 'NEXT_45D' ? 'selected' : '' ?>
                                        value="NEXT_45D">45 Ngày Nữa
                                </option>
                                <option <?= $this->input->get('filterTime') == 'NEXT_60D' ? 'selected' : '' ?>
                                        value="NEXT_60D">60 Ngày Nữa
                                </option>
                                <option <?= $this->input->get('filterTime') == 'NEXT_1Y' ? 'selected' : '' ?>
                                        value="NEXT_1Y">1 Năm Nữa
                                </option>
                            </select>
                            <script>
                                commands.push(function () {
                                    $('select[name=filterTime]').on('change', function () {
                                        let filterTime = $(this).val();
                                        window.location = '/admin/list-contract?filterTime=' +
                                            filterTime;
                                    });
                                });
                            </script>
                        </div>

                    <?php endif; ?>
                </div>
            </div>


            <?php if(count($list_notification) > 0 && isYourPermission('Contract', 'approved', $this->permission_set) ):
            ?>
            <div class="col-12">

                <div class="card-box shadow table-responsive">
                    <h4 class="text-danger text-center" >Hợp Đồng Đang Chờ duyệt</h4>
                    
                    <table style="font-size: 13px;" id="listPending" class="
                    table-contract table ">
                        <thead>
                        <tr>
                            <th width="100px" class="text-center">ID Hợp Đồng</th>
                            <th>Nội dung</th>
                            <th width="100px" class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($list_notification as $row ):
                            ?>
                            <tr>
                                <td class="text-center"><a target = '_blank'
                                       href="/admin/detail-contract?id=<?= $row['object_id']
                                       ?>">#<?= 10000+ $row['object_id'] ?></a></td>
                                <td>
                                    <strong>
                                        <?= $row['message'] ?>
                                    </strong>
                                    <p><small><?= date('d/m/Y H:i', $row['time_insert'])
                                            ?></small></p>

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
            <?php endif; ?>

            <div class="col-12 col-md-12 mt-md-2">
                <?php $this->load->view('contract/show-current-month',
                        [
                            'check_collapse' => $check_collapse,
                            'list_contract' => $list_contract,
                            'label_apartment' => $label_apartment,
                            'ghRoom' => $ghRoom
                        ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card-box table-responsive shadow">
                <h4 class="text-danger text-center" <?= $check_collapse ? 'data-target="#listAll" data-toggle="collapse"' : '' ?>>Tất Cả Hợp Đồng</h4>
                    <table id="listAll" class="table-contract <?= $check_collapse ? 'collapse' :'' ?> table table-bordered">
                        <thead>
                        <tr>
                            <th># ID Hợp Đồng</th>
                            <th width="350px">Khách thuê</th>
                            <th>Giá thuê</th>
                            <th width="250px">Thành Viên Chốt</th>
                            <th>Ngày ký</th>
                            <th>Ngày hết hạn</th>
                            <th>Ngày Nhập</th>
                            <th class="text-center">Thời hạn</th>
                            <th class="text-center" width="100px">Trạng Thái</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_contract as $row ): ?>
                            <?php $service = json_decode($row['service_set'], true) ?>
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
                                <td>
                                    <div>
                                        <?=$row['time_insert'] ? date('d/m/Y',$row['time_insert']):'-' ?>
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
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
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
            
            

            $('.delete-contract').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var district_id = matches[0];
                if(district_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-contract',
                        data: {district_id: district_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.contract-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.contract-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>