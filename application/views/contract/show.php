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
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card-box table-responsive">
                    <table id="table-contract" class="table table-bordered">
                        <thead>
                        <tr>
                            <th># ID Hợp Đồng</th>
                            <th>Khách thuê</th>
                            <th>Địa chỉ</th>
                            <th>Mã Phòng</th>
                            <th>Giá thuê</th>
                            <th>Ngày ký</th>
                            <th>Số tháng ở</th>
                            <th>Ghi chú HD</th>
                            <th class="text-center">Tình trạng</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_contract as $row ): ?>
                            <?php $service = json_decode($row['service_set'], true) ?>
                            <tr>
                                <td>
                                    <div>
                                            #<?= (1000000 + $row['id']) ?>
                                    </div>
                                </td>
                                <td><?= $libCustomer->getNameById($row['customer_id']) ?></td>
                                <td>
                                    <div>
                                    <?php 
                                        $apartment = $ghApartment->get(['id' => $row['apartment_id']])
                                    ?>
                                        <?= $apartment ? $apartment[0]['address_street']:'' ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?//= isset($service['code']) ? $service['code']:'-' ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?= number_format($row['room_price']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?=$row['time_check_in'] ? date('d/m/Y',$row['time_check_in']):'#' ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?=$row['number_of_month'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?=$row['note'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?=$row['status'] ?>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn m-1 btn-sm btn-outline-muted btn-rounded waves-light waves-effect delete-contract">
                                            đang code
                                        </a>
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
            $('#table-contract').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-contract input[type=checkbox]').click(function() {
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
                            url: '<?= base_url() ?>admin/update-contract',
                            data: {field_value: is_active, district_id: district_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                console.log(data);
                                if(data.status == true) {
                                    $('.contract-alert').html(notify_html_success);
                                } else {
                                    $('.contract-alert').html(notify_html_fail);
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
                    $('.contract-name').editable({
                        type: "text",
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