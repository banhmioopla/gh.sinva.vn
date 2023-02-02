
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
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Danh Sách Khách Hàng</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Danh Sách Khách Hàng</h2>
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
        <div class="customer-alert"></div>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <?php $this->load->view('components/list-navigation'); ?>
                </div>
            </div>
            <div class="col-12">
                <h4 class="text-danger font-weight-bold">Mô tả</h4>
                <ul>
                    <li>Danh sách khách hàng - Thống kê giúp bạn những khách hàng mà bạn đã ký hợp đồng, book xem phòng!</li>
                    <li>Cột STT là số thứ tự khi 1 thành viên tạo 1 khách hàng mới vào GH</li>
                    <li>Click vào STT để đá qua trang thông tin chi tiết của Khách Hàng</li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-center pb-1 border-bottom">Tìm Kiếm</h4>
                    <form>
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="time_check_in" class="font-weight-bold">Khoảng Tgian Ký Hợp Đồng (từ)</label>
                                    <input name="time_from" value="<?= $time_from ?>" type="text" class="form-control datepicker">
                                </div>

                                <div class="form-group">
                                    <label for="time_check_in" class="font-weight-bold">Khoảng Tgian Ký Hợp Đồng (đến)</label>
                                    <input name="time_to" value="<?= $time_to ?>" type="text" class="form-control datepicker">
                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="month_check_in_contract" class="font-weight-bold">Trạng Thái</label>
                                    <div class="radio radio-danger checkbox-circle">
                                        <input id="signed-YES" type="radio"
                                            <?= $this->input->get('signed') == "YES" ? 'checked':'' ?>
                                               name="signed" value="YES">
                                        <label for="signed-YES">
                                            Đã Ký (Hợp Đồng Còn Hạn)
                                        </label>
                                    </div>
                                    <div class="radio radio-danger checkbox-circle">
                                        <input id="signed-NO" type="radio"
                                            <?= $this->input->get('signed') == "NO" ? 'checked':'' ?>
                                               name="signed" value="NO">
                                        <label for="signed-NO">
                                            Đang Theo Dõi (Chưa Ký <small>hoặc</small> Hết Hạn)
                                        </label>
                                    </div>
                                    <div class="radio radio-danger checkbox-circle">
                                        <input id="signed-NONE" type="radio" name="signed" value=""
                                            <?= $this->input->get('signed') == "" ? 'checked':'' ?>
                                        >
                                        <label for="signed-NONE">
                                            Bỏ Chọn Cả 2
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 offset-md-3 offset-0 col-12">
                                <button type="submit" name="search" value="oke" class="btn w-75 btn-danger waves-light waves-effect">Tìm</button>
                                <a href="/admin/export-customer" name="search" value="oke" class="btn w-75 mt-1 btn-success waves-light waves-effect">Excel KH Ký Tháng Hiện Tại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12">
                <div class="card-box shadow" style="font-size: 13px">
                    <table class="table-data table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Số Lượng Hợp Đồng</th>
                            <th>Thành Viên</th>
                            <th>Giới tính</th>
                            <th>Số điện thoại</th>
                            <th class="text-center">Trạng Thái</th>
                            <th class="text-center">Nguồn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(count($list_customer) > 0): $i=1;?>
                            <?php foreach($list_customer["customers"] as $row ):
                                $NearestContract = $this->ghCustomer->getNearestContractByCustomerId($row['id']);
                                $ContractCounter = $this->ghCustomer->getNumberContract($row['id']);
                                $contract_count = $ContractCounter['counter'];
                                $consultant_name = '';

                                $isExpired = "success";
                                if($NearestContract['max_time_expire'] < strtotime(date('d-m-Y'))) {
                                    $isExpired = 'danger';
                                }
                                ?>
                                <tr>
                                    <td><a target="_blank"
                                           href="/admin/detail-customer?id=<?= $row['id'] ?>"><?= str_pad($i, 3, '0', STR_PAD_LEFT);  ?></a></td>
                                    <td>
                                        <div class=" font-weight-bold">
                                            <span class="text-<?= $isExpired ?>"><?=
                                                $row['name'] ?></span>
                                            <p class="mb-0 text-muted"> <small>Sinh Nhật: <?=
                                                    $row['birthdate'] !== null ? date('d/m/Y',$row['birthdate']) : '' ?></small></p>
                                        </div>
                                    </td>
                                    <td class="text-center font-weight-bold"><span class="text-<?= $isExpired ?>"><?= $contract_count ?></span></td>
                                    <td>
                                        <?php
                                        $list_contract = $this->ghContract->get(['customer_id' => $row['id']]); ?>
                                        <ul>
                                        <?php
                                        foreach ($list_contract as $contract):?>
                                            <li><?= $this->libUser->getNameByAccountid($contract['consultant_id']) ?></li><br>
                                        <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="customer-gender"
                                             data-pk="<?= $row['id'] ?>"
                                             data-name="gender">
                                            <?= $row['gender'] ? $label_apartment[$row['gender']] : '[chưa cập nhật]'?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="customer-data"
                                             data-pk="<?= $row['id'] ?>"
                                             data-value ="<?= $row['phone'] ?>"
                                             data-name="phone">
                                            <?= $row['phone'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $status = 'danger';
                                        $status_text= "đang theo dõi";
                                        if($isExpired == 'success'){
                                            $status = 'success';
                                            $status_text = "đã ký còn hạn";
                                        }

                                        ?>
                                        <div class="customer-source text-center text-<?= $status ?>">
                                            <strong><?= $status_text ?></strong>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="customer-source text-center text-muted">
                                            <?= $row['source'] ? $label_apartment[$row['source']] : '[chưa cập nhật]' ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                        <?php endif;?>
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
            $('.table-data').DataTable({
                "pageLength": 5,
                'pagingType': "full_numbers",
                responsive: true
            });

            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
            });


        });
    });
</script>
