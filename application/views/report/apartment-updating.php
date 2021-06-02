
<div class="wrapper">
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
                    <h2 class="text-danger font-weight-bold">Báo Cáo Tiến Độ Cập Nhật Dự Án / Quận</h2>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table">
                                <thead>
                                <th>Dự Án</th>
                                <th>% Hoàn Thiện Dịch Vụ</th>
                                </thead>
                                <tbody>
                                <?php foreach ($list_apartment as $apm): ?>
                                    <tr>
                                        <td><?= $apm['address_street'] ?> Q. <?= $apm['district_code'] ?></td>
                                        <td><?= $update_rate[$apm['id']] * 100 ?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-box">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table">
                                <thead>
                                <th>Quận</th>
                                <th>% Hoàn Thiện Dịch Vụ</th>
                                </thead>
                                <tbody>
                                <?php foreach ($update_rate_district as $key =>  $district):
                                    $counter = count($ghApartment->get(['district_code' =>$key, 'active' => 'YES' ]));

                                    ?>
                                    <tr>
                                        <td>Q. <?= $key ?></td>
                                        <td><?= $district / $counter ?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div>
<script>
    commands.push(function () {
        $('table').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            responsive: true
        });
    });
</script>
