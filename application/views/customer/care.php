<?php

$is_btn_delete = $is_form = isYourPermission('Customer', 'care', $this->permission_set);
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
        <div class="district-alert"></div>
        <div class="row">
            <div class="col-md-12">
                <h3>Danh sách hợp đồng tháng hiện tại  </h3>
                <div class="card-box table-responsive">
                    <table id="table-contract" class="table table-bordered">
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
                                    <div>
                                        <?=$row['time_check_in'] ? date('d/m/Y',$row['time_check_in']):'-' ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?=$row['time_expire'] ? date('d/m/Y',$row['time_expire']):'-' ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <?=$row['number_of_month'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
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
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
        
            <div class="col-12 col-md-12">
            <h3>Báo cáo chăm sóc khách hàng</h3>
                <div class="card-box table-responsive">
                    <table id="table-district" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Thành viên tư vấn</th>
                            <th>Ngày</th>
                            <th>Ghi chú</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_data as $row ): ?>
                            <tr>
                                <td>
                                    <?= $libCustomer->getNameById($row['customer_id']) ?> - 
                                    <?= $libCustomer->getPhoneById($row['customer_id']) ?>
                                </td>
                                <td>
                                <?= $libUser->getNameByAccountid($row['user_id']) ?>
                                </td>
                                <td>
                                    <p><?= date('d/m/Y', $row['time_insert'])?></p>
                                </td>
                                <td>
                                    <p><?= $row['note']?></p>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-district">
                                            đang code
                                        </button>
                                    </div>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($is_form): ?>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="m-t-0">Thêm cuộc gọi mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-care-customer">
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Chọn Khách Hàng<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                            <select class="form-control select2" id="customer_id" name="customer_id">
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Ghi chú</label>
                            <div class="col-8">
                                <textarea class="form-control" rows="5" name="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end row -->
            <?php endif;?>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('#table-district').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-district input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var district_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        console.log('hello');
                        console.log(is_active );
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-district',
                            data: {field_value: is_active, district_id: district_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                console.log(data);
                                if(data.status == true) {
                                    $('.district-alert').html(notify_html_success);
                                } else {
                                    $('.district-alert').html(notify_html_fail);
                                }
                            },
                            beforeSend: function(){
                                $('#loader').show();
                            },
                            complete: function(){
                                $('#loader').hide();
                            }
                        });
                    });
                    // x editable
                    $('.district-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-district-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.district-alert').html(notify_html_success);
                            } else {
                                $('.district-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });
            
            $(".select2").select2({
                placeholder: "Search for an Item",
                minimumInputLength: 2,
                ajax: {
                    url: "<?= base_url().'admin/search-customer' ?>",
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });

        });
    });
</script>