<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="text-danger font-weight-bold">Tổng quan DA - QLDA</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-center flex-wrap ">
                    <?php
                    foreach($list_district as $district):
                        $district_btn = 'btn-outline-success';
                        ?>

                        <a href="<?= base_url().'/admin/dashboard/show/user-collected-overview?district-current='.$district['code'] ?>"
                           class="btn m-1 btn-sm <?= $district_btn ?>
                        <?= $district_current == $district['code'] ? 'active':'' ?>
                        btn-rounded waves-light waves-effect">
                            Q. <?= $district['name'] ?> </a>

                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <div class="card-box  mt-2">
            <?php

            $list_apartment = $this->ghApartment->get(['active' => 'YES' , 'district_code' => $district_current]);

            ?>
            <div class="row">
                <div class="col-12">
                    <h3>Bảng thông tin</h3>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered tb-data">
                            <thead>
                            <th>Dự Án</th>
                            <th>QLDA</th>
                            <th>Số điện thoại</th>
                            </thead>
                            <tbody>
                            <?php foreach ($list_apartment as $apm):?>
                                <?php
                                $user = $this->ghUser->getFirstByAccountId($apm['user_collected_id']);
                                ?>
                                <tr>
                                    <td><?= $apm['address_street'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['phone_number'] ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    commands.push(function () {
       $('.tb-data').dataTable();
    });
</script>