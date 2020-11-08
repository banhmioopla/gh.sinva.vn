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
            <div class="col-12 col-md-5 offset-md-1 ">
                <div class="card-box table-responsive shadow">
                    <h3 class="text-danger text-center">Thu Nhập Theo Hợp Đồng</h3>
                    <table id="table-district" class="table">
                        <thead>
                        <tr>
                            <th>Tên Thành Viên</th>
                            <th class="text-center" width="80px">Số Lượng Hợp Đồng</th>
                            <th class="text-right">Theo Cơ Chế</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_income as $account_id => $item ): ?>

                            <?php
                            $rank_color = '';
                            $rank_color = $item['income'] > 1000000 ? 'bg-warning text-light' :
                                $rank_color;
                            $rank_color = $item['income'] > 5000000 ? 'bg-info text-light' :
                                $rank_color;
                            $rank_color = $item['income'] > 8000000 ? 'bg-success text-light' :
                                $rank_color;

                            ?>
                            <tr class="<?= $rank_color ?>">
                                <td >
                                    <div> <?= $libUser->getNameByAccountid($account_id) ?> </div>
                                </td>
                                <td class="text-center"><?= number_format($item['contract_quantity']) ?></td>


                                <td class="text-right"><?= number_format($item['income']) ?> VNĐ</td>

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