<div class="container-fluid mt-4">
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
                <h2 class="font-weight-bold text-danger">Bảng điều khiển</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#"><?= $this->auth['name'] ?></a></li>
                        <li class="breadcrumb-item active">Bảng điều khiển</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md text-center">
            <?php $this->load->view('components/list-navigation'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box bg-dark text-white ">
                        <h2 class="text-uppercase mt-0"> <?= $this->auth['name'] ?></h2>
                        <div class="mt-2 pl-2">
                            <div> <i class="mdi mdi-email-outline mr-2"></i> <?= $this->auth['email'] ?? "[chưa cập nhật]" ?></div>
                            <div> <i class="mdi mdi-phone mr-2"></i> <?= $this->auth['phone_number'] ?? "[chưa cập nhật]" ?></div>
                            <div> <i class="mdi mdi-calendar-range mr-2"></i> Sinh nhật <?= date("d/m/Y",$this->auth['date_of_birth']) ?? "[chưa cập nhật]" ?></div>
                            <div> <i class="mdi mdi-calendar-range mr-2"></i> Ngày vào làm <?= date("d/m/Y",$this->auth['time_joined']) ?? "[chưa cập nhật]" ?></div>
                            <div class="mt-2">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           id="input_change_password"
                                           required placeholder="Mật khẩu mới" aria-label="Mật khẩu mới" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light" id="submit_change_password" type="button">Cập nhật</button>
                                    </div>
                                </div>
                                <p class="text-success" id="change_password_msg"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Doanh số tháng này</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($this_month_total_sale) ?></span></h2>
                        <span class="badge badge-custom"> ...% </span>
                        <span class="text-muted">...</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Doanh số tích luỹ</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($total_sale) ?></span></h2>
                        <span class="text-muted">Từ ngày tham gia hệ thống</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Hợp đồng</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= count($list_contract) ?></span></h2>
                        <span class="text-muted">Tất cả hợp đồng của bạn</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Khách thuê</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= count($list_customer) ?></span></h2>
                        <span class="text-muted">Tất cả khách thuê của bạn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card-box">
                <h4 class="m-t-0 header-title">Bảng Hợp Đồng</h4>
                <table class="table data-table">
                    <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Dự Án</th>
                        <th class="text-right">Giá thuê <small>x1000</small></th>

                        <th class="text-center">Ngày ký</th>
                        <th class="text-center">Số tháng</th>
                        <th class="text-center">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($list_contract as $contract):
                        $apm = $this->ghApartment->getFirstById($contract['apartment_id']);
                        $room = $this->ghRoom->getFirstById($contract['room_id']);
                        $address = "[không thông tin]";
                        if(!empty($apm)){
                            $address = $apm['address_street'] . ", phường ". $apm['address_ward'];
                        }


                        $statusClass = 'muted'; $doc_type = "Cọc ";
                        if($contract['status'] == 'Active') {
                            $statusClass = 'success';
                        }
                        if($contract['status'] == 'Pending') {
                            $statusClass = 'warning';
                            $doc_type .= " Chờ duyệt";
                        }

                        if(time() >= $contract["time_check_in"]){
                            $doc_type = "HĐ đã ký ";
                        }
                        if(time() >= $contract["time_expire"]){
                            $doc_type = "HĐ hết hạn ";
                            $statusClass = 'secondary';
                        }

                        ?>
                        <tr>
                            <th scope="row"><a href="/admin/detail-contract?id=<?= $contract['id'] ?>"><?= $contract['id'] ?></a></th>
                            <td>
                                <div><?= "Phòng ".$room['code'] ?></div>
                                <div><small><?= $address ?></small></div>
                            </td>
                            <td class="text-right"><?= number_format($contract['room_price']/1000) ?></td>
                            <td class="text-center"><?= date('d/m/Y', $contract['time_check_in']) ?></td>
                            <td class="text-center"><?= $contract['number_of_month'] ?></td>
                            <td class="text-center"><span class="badge badge-<?= $statusClass ?> font-weight-bold"><?=  $doc_type ?></span></td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card-box">
                <h4 class="m-t-0 header-title">Khách thuê</h4>
                <table class="table data-table">
                    <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Họ & Tên</th>
                        <th class="text-right">Số HĐ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($list_customer as $customer):
                        $customer_list_contract = $this->ghContract->get(["id" => $customer['id']]);
                        ?>
                        <tr>
                            <th scope="row"><?= $customer['id'] ?></th>
                            <td>
                                <div><?= $customer['name'] ?></div>
                                <div> <small><?= $this->libCustomer->getPhoneById($customer['id']) ?></small></div>
                            </td>
                            <td class="text-right"><?= count($customer_list_contract) ?></td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    commands.push(function(){
        $('#submit_change_password').click(function () {
            let new_pass = $('#input_change_password').val();
            $.ajax({
                method: "POST",
                url: '/admin/change-password-user',
                data:{password:new_pass},
                dataType:"json",
                success:function (res) {
                    $('#change_password_msg').text("");
                    if(res.status === true){
                        $('#change_password_msg').text(res.msg);
                    }
                }
            });
            
        });


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
        $('.data-table').DataTable({
            "pageLength": 5,
            'pagingType': "full_numbers",
            "aaSorting": [],
            responsive: true
        });
    });
</script>
