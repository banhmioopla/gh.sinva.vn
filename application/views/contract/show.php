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
                    <h3 class="page-title">Danh sách Hợp đồng</h3>
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
            <?php if(isYourPermission($this->current_controller,'syncStatusExpire', $this->permission_set)): ?>
                <div class="col-md-12">
                    <div class="card-box">
                        <a href="/admin/contract/sync-status-expire" class="btn btn-warning">Cập nhật trạng thái hợp đồng</a>
                    </div>
                    
                </div>
            <?php endif; ?>
            <div class="col-12 col-md-12 mt-md-2">
                <div class="card-box table-responsive">
                    <h4 class="text-danger" <?= $check_collapse ? 'data-target="#listPending" data-toggle="collapse"' : '' ?> >Chờ duyệt</h4>
                    
                    <table id="listPending" class="table-contract table table-bordered <?= $check_collapse ? 'collapse' :'' ?> ">
                        <thead>
                        <tr>
                            <th>Nội dung</th>
                            <th width="350px">Duyệt</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(count($list_notification) > 0 && isYourPermission('Contract', 'approved', $this->permission_set) ):
                                foreach($list_notification as $row ):
                            ?>
                            <tr>
                                <td>
                                    <div>
                                        <?= $row['message'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a href="/admin/contract/approved?contract-id=<?= $row['object_id'] ?>&id=<?= $row['id'] ?>"> Duyệt </a>
                                    </div>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                                <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class=" mt-md-2 card-box table-responsive">
                    <h4 class="text-danger" <?= $check_collapse ? 'data-target="#listThisMonth" data-toggle="collapse"' : '' ?>>DS - Ký tháng này</h4>
                    <table id="listThisMonth" class="table-contract table table-bordered <?= $check_collapse ? 'collapse' :'' ?>">
                        <thead>
                        <tr>
                            <th># ID Hợp Đồng</th>
                            <th width="350px">Khách thuê</th>
                            <th>Giá thuê</th>
                            <th>Ngày ký</th>
                            <th>Ngày hết hạn</th>
                            <th class="text-center">Thời hạn</th>
                            <th width="200px">Ghi chú HD</th>
                            <th class="text-center" width="200px">Tình trạng</th>
                            <th class="text-center">Hình Ảnh</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($list_contract as $row ):
                                    if($row['time_check_in'] < strtotime(date('01-m-Y'))) {
                                        continue;
                                    }
                            ?>
                            <?php $service = json_decode($row['service_set'], true) ?>
                            <tr>
                                <td>
                                    <div>
                                       <a target = '_blank' href="/admin/detail-contract?id=<?= $row['id'] ?>">#<?= (10000 + $row['id']) ?></a> 
                                    </div>
                                </td>
                                <td>
                                <div class="text-muted"><?= $libCustomer->getNameById($row['customer_id']).' - '. $libCustomer->getPhoneById($row['customer_id']) ?> </div>
                                <div class="font-weight-bold text-primary">
                                    <?php 
                                        $apartment = $ghApartment->get(['id' => $row['apartment_id']])
                                    ?>
                                        <?= $apartment ? $apartment[0]['address_street']:'' ?>
                                    </div>
                                    <h6 class="text-danger">
                                            <?= $row['room_code'] ? 'mã phòng: '.$row['room_code'] : null ?>
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
                                <td>
                                    <div class="contract-note"
                                        data-pk="<?= $row['id'] ?>"
                                        data-value="<?= $row['note'] ?>"
                                        data-name="note">
                                        <?=$row['note'] ?>
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
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?> badge-pill" style="font-size:100%">
                                    <?= $label_apartment['contract.'.$row['status']] ?>
                                    </span>
                                        
                                    </div>
                                </td>
                                
                                <?php 
                                    $image = $ghImage->getContract($row['id'])
                                ?>
                                <td>
                                <?php  if($image): ?>
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= '/media/contract/'.$image[0]['name'] ?>" target="_blank">
                                            Hình Ảnh
                                        </a>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card-box table-responsive">
                <h4 class="text-danger" <?= $check_collapse ? 'data-target="#listAll" data-toggle="collapse"' : '' ?>>Tất Cả</h4>
                    <table id="listAll" class="table-contract <?= $check_collapse ? 'collapse' :'' ?> table table-bordered">
                        <thead>
                        <tr>
                            <th># ID Hợp Đồng</th>
                            <th width="350px">Khách thuê</th>
                            <th>Giá thuê</th>
                            <th>Ngày ký</th>
                            <th>Ngày hết hạn</th>
                            <th class="text-center">Thời hạn</th>
                            <th width="200px">Ghi chú HD</th>
                            <th class="text-center" width="200px">Tình trạng</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_contract as $row ): ?>
                            <?php $service = json_decode($row['service_set'], true) ?>
                            <tr>
                                <td>
                                    <div>
                                        #<?= (10000 + $row['id']) ?>
                                    </div>
                                </td>
                                <td>
                                <div class="text-muted"><?= $libCustomer->getNameById($row['customer_id']).' - '. $libCustomer->getPhoneById($row['customer_id']) ?> </div>
                                <div class="font-weight-bold text-primary">
                                    <?php 
                                        $apartment = $ghApartment->get(['id' => $row['apartment_id']])
                                    ?>
                                        <?= $apartment ? $apartment[0]['address_street']:'' ?>
                                    </div>
                                    <h6 class="text-danger">
                                         <?= $row['room_code'] ? 'mã phòng: '.$row['room_code'] : null ?>
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
                                <td>
                                    <div class="contract-note"
                                        data-pk="<?= $row['id'] ?>"
                                        data-value="<?= $row['note'] ?>"
                                        data-name="note">
                                        <?=$row['note'] ?>
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
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?> badge-pill" style="font-size:100%">
                                    <?= $label_apartment['contract.'.$row['status']] ?>
                                    </span>
                                        
                                    </div>
                                </td>
                                <?php 
                                    $image = $ghImage->getContract($row['id'])
                                   
                                ?>
                                <td>
                                <?php  if($image): ?>
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= '/media/contract/'.$image[0]['name'] ?>" target="_blank">
                                            Hình Ảnh
                                        </a>
                                    </div>
                                </td>
                                <?php endif; ?>
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