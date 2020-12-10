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

        <div class="district-alert"></div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h3 class="text-center text-danger">Thống Kê Doanh Số</h3>
            </div>

            <div class="col-12 col-md-6 offset-md-3 col-12">
                <div class="card-box text-dark bg-white text-white shadow">
                    <i class="fi-tag"></i>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <p class="text-uppercase m-b-5 font-600">Số Lượng Thành Viên:

                        </div>


                        <div class="col-12">
                            <p>
                            <div class="mt-1 border-bottom">
                                <i class="mdi mdi-checkerboard"> Tổng Doanh Số BPKD Tháng
                                    <?= date('m/Y') ?>:</i>

                                <strong class="float-right">
                                    <?= number_format($total_sale) ?></strong>
                            </div>

                            <div class="mt-1 border-bottom">
                                <i class="mdi mdi-checkerboard"> Tổng SLHĐ BPKD Tháng
                                    <?= date('m/Y') ?>:</i>

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
            <div class="col-12 col-md-5 offset-md-1 ">
                <div class="card-box table-responsive shadow">
                    <h3 class="text-danger text-center">Thống Kê Thu Nhập</h3>
                    <table id="table-district" class="table">
                        <thead>
                        <tr>
                            <th>Thành Viên</th>
                            <th class="text-center" width="80px">Số Lượng Hợp Đồng</th>
                            <th class="text-right">Tổng Doanh Số (x1000)</th>
                            <th class="text-right">Tổng Thu Nhập(x1000)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user_income as $account_id => $item ): ?>
                            <tr>
                                <td >
                                    <div> <?= $libUser->getNameByAccountid($account_id) ?> </div>
                                </td>
                                <td class="text-center"><?= number_format($item['quantity_contract']) ?></td>


                                <td class="text-right"><?= number_format($item['total_sale']/1000) ?></td>
                                <td class="text-right"><?= number_format($item['total_personal_income']/1000) ?></td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box table-responsive shadow">
                    <h3 class="text-danger text-center">Thu Nhập Từ Các Khoảng Thưởng</h3>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<script>

    commands.push(function(){
        $('#table-district').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            responsive: true,});
    });
</script>