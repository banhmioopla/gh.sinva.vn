<?php

$metric = [
    'quantity' => 0,
    'cd_general' => 0,
    'cd_high' => 0,
];
$user_birth_this_month = [];
$user_cd_high = [];
foreach ($list_user as $row) {
    if($row['active'] == "YES") {
        $metric['quantity']++;

        if(in_array($row['account_id'], $this->arr_general)) {
            $metric['cd_general']++;
        }


        if($libRole->isControlDepartment($row['role_code']) === true) {
            $metric['cd_high']++;
            $user_cd_high[] = $row['account_id'];
        }

        if($this->input->get('birthDay')) {
            $month = $this->input->get('birthDay');
            $user_month = date('m',$row['date_of_birth']);
            if($user_month == $month) {
                $user_birth_this_month[] = $row;

            }
        } else {
            redirect('/admin/list-user?birthDay='.date('m'));
        }
    }
}
?>


<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Thành Viên</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Thành Viên</h2>
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


        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <table class="table table-dark">
                        <tr>
                            <td colspan="2"><h4 class="text-center">TỔNG QUAN</h4></td>
                        </tr>
                        <tr>
                            <td><i class="mdi mdi-chevron-double-right text-warning"></i> Số Lượng Thành Viên</td>
                            <td class="text-right"><?= $metric['quantity'] ?></td>
                        </tr>
                        <tr>
                            <td><i class="mdi mdi-chevron-double-right text-warning"></i> VH. Chung</td>
                            <td class="text-right" width="350px">
                                <?= $metric['cd_general'] ?>
                                <hr class="border border-light">
                                <div class="text-left">
                                    <?php foreach ($this->arr_general as $item): ?>
                                        <strong><?= $libUser->getNameByAccountid($item) . ' | ' ?></strong>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td><i class="mdi mdi-chevron-double-right text-warning"></i> VH. Cấp Cao</td>
                            <td class="text-right" width="350px">
                                <?= $metric['cd_high'] ?>
                                <hr class="border border-light">
                                <div class="text-left">
                                    <?php foreach ($user_cd_high as $item): ?>
                                        <strong><?= $libUser->getNameByAccountid($item) . ' | ' ?></strong>
                                    <?php endforeach; ?>
                                </div>

                            </td>
                        </tr>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <strong>Tìm Sinh Nhật</strong>
                        <select name="" id="find-birthday" class="form-control mt-2">
                            <option value="">Chọn Tháng</option>
                            <?php for($i = 1; $i <= 12; $i++):?>
                                <option value="<?= $i ?>" <?= $this->input->get('birthDay') == $i ? 'selected':'' ?>>Tháng <?= $i ?></option>
                            <?php endfor;?>
                        </select>
                    </div>

                    <script>
                        commands.push(function () {
                            $('#find-birthday').change(function(){
                                window.location = '/admin/list-user?birthDay='+$(this).val();
                            });
                        });
                    </script>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card-box">
                    <?php if(count($user_birth_this_month)):
                        ?>

                        <table class="table table-dark">
                            <thead>
                            <tr class="font-weight-bold">
                                <td><h5>THÀNH VIÊN</h5></td>
                                <td class="text-center"><h5>SINH NHẬT</h5></td></tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($user_birth_this_month as $row):
                                ?>
                                <tr>
                                    <td>
                                        <i class="mdi mdi-chevron-double-right text-warning"></i> <?= $row['name'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?= date('d/m/Y',$row['date_of_birth']) ?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>

                        </table>
                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            Không có sinh nhật nào!
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="user-alert"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h3>Tất cả thành viên</h3>
                    <table class="table table-user table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Tên</th>

                            <th>Quyền</th>

                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Sinh nhật</th>
                            <th>Ngày Vào Làm</th>
                            <th>Người Tuyển</th>

                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Mở</th>
                            <!-- <th class="text-center">Tùy Chọn</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user as $row ): ?>
                            <tr>
                                <td>
                                    <u>
                                        <a target="_blank"
                                           class="text-danger"
                                           href="/admin/personal-profile?account_id=<?= $row['account_id'] ?>">
                                            <?= $row['account_id'] ?>
                                        </a>  </u>
                                </td>
                                <td>
                                    <div class="user-name user"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="name">
                                        <?= $row['name'] ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-role_code"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value = "<?= $row['role_code'] ?>"
                                         data-name="role_code">quyền <?= $libRole->getNameByCode($row['role_code']) ?></div>
                                </td>

                                <td>
                                    <div class="user-phone_number user"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="phone_number">
                                        <?= $row['phone_number'] ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-email user"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="email">
                                        <?= $row['email'] ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-date_of_birth user"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="date_of_birth"
                                         data-value ="<?= $row['date_of_birth'] > 0 ? date('d-m-Y',$row['date_of_birth']) :'' ?>">
                                        <?= $row['date_of_birth'] ? date('d/m/Y',$row['date_of_birth']) :'#' ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-time_joined user"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="time_joined"
                                         data-value ="<?= $row['time_joined'] > 0 ? date('d-m-Y',$row['time_joined']) :'' ?>">
                                        <?= $row['time_joined'] ? date('d/m/Y',$row['time_joined']) :'#' ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-user_refer_id user"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="user_refer_id"
                                         data-value="<?= $row['user_refer_id'] ?>">
                                        <?= $libUser->getNameByAccountid($row['user_refer_id']) ?>
                                    </div>
                                </td>


                                <td class="text-center">
                                    <?php
                                    $classStatus = 'secondary';
                                    $txtStatus = 'quá khứ';
                                    if($row['active'] =='YES') {
                                        $classStatus = 'success';
                                        $txtStatus = 'hiện tại';
                                    }
                                    ?>
                                    <div>
                                        <span style="font-size:100%" class=" badge badge-<?= $classStatus ?> badge-pill"><?= $txtStatus ?></span>
                                    </div>

                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-user">
                                            <input id="user-<?= $row['id'] ?>"
                                                   value="<?= $row['active'] ?>"
                                                   type="checkbox"
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="user-<?= $row['id'] ?>">
                                            </label>
                                        </div>
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
