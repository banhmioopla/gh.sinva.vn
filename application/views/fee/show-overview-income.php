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
                            <li class="breadcrumb-item"><a href="#">gio hang</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Phòng Tài Chính</h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="district-alert"></div>
        <div class="row">
            <div class="col-12">
                <ul class="list-unstyled p-2 border border-danger card-box">
                    <li>- Bất cứ thành viên nào khi tuyển dụng được người thì người tuyển dụng được 05% doanh thu từ người được tuyển.</li>
                    <li>- Bất cứ ai cũng có quyền được lấy dự án về cho công ty. Người lấy dự án sẽ được nhận 03% tổng doanh thu từ các giao dịch đã được thực hiện từ toà nhà  nhận về trong tháng đầu tiên (không quan tâm người thực hiện giao dịch là ai).
                        <ul>
                            <li>Dự án được lấy về đã được đàm phán về các nội dung (hoa hồng, giá dịch vụ, cọc, thời gian giữ phòng,…)</li>
                            <li>Dự án được được chọn sau khi công ty thẩm định và ký hợp đồng kí gửi với đối tác</li>
                        </ul>
                    </li>

                    <li>- Trong trường hợp hai hoặc nhiều người cùng đi lấy dự án mới. Công ty sẽ chia hoa hồng cho người trực tiếp đàm phán để lấy dự án. Sau đó hai hoặc nhiều người tự thương lượng và chia hoa hồng với nhau nếu tất cả đều có công.</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card-box text-dark bg-white text-white shadow">

                    <div class="row">
                        <div class="col-12 bg-warning text-light">
                            <p class="text-uppercase font-600 text-center pt-3">Tùy Chọn </p>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="font-weight-bold text-danger">Báo Cáo Tháng ... (2021) </div>
                            <select name="" id="month" class="form-control">
                                <?php for ($i = 1; $i <= 12; $i++ ):?>
                                    <option value="<?= $i ?>"
                                    <?= $this->input->get('month') == $i ? "selected":"" ?>
                                    > Tháng <?= $i ?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <script>
                            commands.push(function(){
                                $('#month').change(function(){
                                    window.location = '/admin/list-fee-contract-income?month='+$('#month').val();
                                });

                            });
                        </script>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card-box text-dark bg-white text-white shadow">

                    <div class="row">
                        <div class="col-12 bg-dark text-light">
                            <p class="text-uppercase font-600 text-center pt-3">BỘ PHẬN KINH DOANH</p>
                        </div>

                        <div class="col-12">
                            <p>
                            <div class="mt-1 border-bottom">
                                <i class="mdi mdi-checkerboard"> Tổng Doanh Số Tháng
                                    <?= $this->input->get('month') ?>:</i>

                                <strong class="float-right">
                                    <?= number_format($total_sale) ?></strong>
                            </div>

                            <div class="mt-1 border-bottom">
                                <i class="mdi mdi-checkerboard"> Tổng So Luong Hop Dong Tháng
                                    <?= $this->input->get('month') ?>:</i>

                                <strong class="float-right">
                                    <?= $quantity_contract ?></strong>
                            </div>
                            </p>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card-box text-dark bg-white text-white shadow">

                    <div class="row">
                        <div class="col-12 bg-dark text-light">
                            <p class="text-uppercase font-600 text-center pt-3">BỘ PHẬN VẬN HÀNH </p>
                        </div>

                        <div class="col-12">
                            <p>
                            <div class="mt-1 border-bottom">
                                <i class="mdi mdi-checkerboard"> Tổng Doanh Số Tháng
                                    <?= $this->input->get('month') ?>:</i>

                                <strong class="float-right">
                                    <?= number_format($total_sale) ?></strong>
                            </div>

                            <div class="mt-1 border-bottom">
                                <i class="mdi mdi-checkerboard"> Tổng So Luong Hop Dong Tháng
                                    <?= $this->input->get('month') ?>:</i>

                                <strong class="float-right">
                                    <?= $quantity_contract ?></strong>
                            </div>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box table-responsive shadow">
                    <h3 class="text-danger font-weight-bold text-center">Bộ Phận Kinh Doanh</h3>
                    <table class="table table-hover table-income table-dark">
                        <thead>
                        <tr>
                            <th>Thành Viên</th>
                            <th class="text-center">Hợp Đồng</th>
                            <th class="text-center" width="80px">Chi Tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user_income as $account_id => $item ): 
                            if(!in_array($account_id, $arr_account_id_sale) ) {
                                continue;
                            }

                            if($item['quantity_contract'] == 0  && $item['total_sale'] == 0  && $item['total_personal_income'] == 0 ) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td >
                                    <div><i class="mdi
                            mdi-chevron-double-right text-info"></i> <?=
                                        $libUser->getNameByAccountid($account_id) ?> </div>
                                </td>
                                <td><div class="text-warning text-center"><?= number_format($item['quantity_contract']) ?></div></td>
                                <td>
                                    <div>
                                        <span class="text-primary"><?= number_format($item['total_sale']/1000) ?></span> |
                                        <span class="text-warning"><?= number_format($item['total_refer_income']/1000) ?></span> |
                                        <span class="text-success"><?= number_format($item['total_personal_income']/1000) ?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6 ">
                <div class="card-box table-responsive shadow">
                    <h3 class="text-danger font-weight-bold text-center">Bộ Phận Vận Hành</h3>
                    <table class="table table-hover table-income table-dark">
                        <thead>
                        <tr class="font-weight-bold">
                            <th>Thành Viên</th>
                            <th class="text-center">Hợp Đồng</th>
                            <th class="" width="80px">Chi Tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user_income as $account_id => $item ):
                            if(!in_array($account_id, $arr_account_id_cd)) {
                                continue;
                            }
                            if(!$item['quantity_contract'] &&  !$item['total_sale'] && !$item['total_personal_income']) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td >
                                    <div><i class="mdi
                            mdi-chevron-double-right text-info"></i> <?=
                                        $libUser->getNameByAccountid
                                        ($account_id) ?> </div>
                                </td>
                                <td><div class="text-warning text-center"><?= number_format($item['quantity_contract']) ?></div></td>
                                <td>
                                    <div>
                                        <span class="text-primary"><?= number_format($item['total_sale']/1000) ?></span> |
                                        <span class="text-warning"><?= number_format($item['total_refer_income']/1000) ?></span> |
                                        <span class="text-success"><?= number_format($item['total_personal_income']/1000) ?></span>
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

<script>

    commands.push(function(){
        $('.table-income').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            responsive: true,});
    });
</script>