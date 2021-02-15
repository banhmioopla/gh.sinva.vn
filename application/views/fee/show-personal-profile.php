<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
<?php
$data = array_values($list_user_income)[0];

?>

        <div class="row">
            <div class="col-md-4">
                <!-- Personal-Information -->
                <div class="card-box">
                    <h4 class="mt-0 m-b-20">Thông tin cá nhân</h4>
                    <div class="panel-body">
                        <p class="text-muted font-13">
                            #đang phát triển...
                        </p>

                        <hr/>

                        <div class="text-left">
                            <p class="text-muted font-13"><strong>Họ Tên :</strong> <span
                                        class="m-l-15"><?= $this->auth['name']
                                    ?></span></p>

                            <p class="text-muted font-13"><strong>Số điện thoại:
                                </strong><span
                                        class="m-l-15"><?= $this->auth['phone_number'] ?></span></p>

                            <p class="text-muted font-13"><strong>Email: </strong>
                                <span class="m-l-15"><?= $this->auth['email'] ?></span></p>

                        </div>

                        <ul class="social-links list-inline m-t-20 m-b-0">
                            <li class="list-inline-item">
                                <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Personal-Information -->

                <div class="card-box ribbon-box">
                    <div class="ribbon ribbon-primary">Thông báo</div>
                    <p>đang phát triển...</p>
                </div>

            </div>


            <div class="col-md-8">

                <div class="card-box">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="" id="month" class="form-control">
                                <?php for ($i = 1; $i <= 12; $i++ ):?>
                                    <option value="<?= $i ?>"
                                        <?= $this->input->get('from-month') == $i ? "selected":"" ?>
                                    > Đang Chọn Tháng <?= $i ?></option>
                                <?php endfor;?>
                            </select>
                            <script>
                                commands.push(function () {
                                    $('#month').change(function () {
                                        let current_url = window.location.href;
                                        let current_month = 'from-month=<?= $this->input->get("from-month") ?>';
                                        let select_month = 'from-month='+$('#month').val();
                                        let new_url = current_url.replace(current_month, select_month);
                                        window.location = new_url;
                                    });

                                });
                            </script>
                        </div>
                    </div>


                    <hr>
                    <div class="table-responsive">
                        <table class="table table-borderless m-b-0">
                            <tbody>
                            <tr>
                                <td>Số Lượng Hợp Đồng</td>
                                <td class="text-right"><?= $data['quantity_contract']
                                    ?></td>
                            </tr>
                            <tr>
                                <td>Tổng Doanh Số</td>
                                <td class="text-right"><?= number_format($data['total_sale']) ?></td>
                            </tr>
                            <tr>
                                <td>Tổng Thu Nhập Từ Hợp Đồng</td>
                                <td class="text-right"><?= number_format($data['total_personal_income']) ?></td>
                            </tr>
                            <tr>
                                <td>Tổng Thu Nhập Từ Tuyển Thành Viên </td>
                                <td class="text-right"><?= number_format($data['total_refer_income']) ?></td>
                            </tr>
                            <tr>
                                <td>Tổng Thu Nhập Từ Lấy Dự Án</td>
                                <td class="text-right"><?= number_format($data['total_get_new_apartment_total']) ?></td>
                            </tr>
                            <tr>
                                <td>Các Danh Mục Trừ Tiền</td>
                                <td class="text-right">
                                <?php

                                $pen_fee = 0;
                                $pen_rate = 0;
                                if(count($personal_penalty) > 0):?>
                                    <?php foreach ($personal_penalty as $p):
                                        $penalty_name = $libPenalty->getNameById($p['penalty_id']);

                                        ?>
                                        <p class="text-danger text-left font-weight-bold">
                                            <?= $penalty_name ?></p>
                                        <ul>

                                            <?php  if($p['fee'] > 0):  $pen_fee += $p['fee']; ?>
                                            <li>
                                                <?= $p['fee'] > 0 ? number_format($p['fee']) : '' ?>
                                            </li>
                                            <?php endif; ?>
                                            <?php  if($p['income_rate'] > 0): $pen_rate
                                             += $p['income_rate']   ?>
                                                <li>
                                                    <?= $p['income_rate'] . '%' ?>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <small class="text-info">không có khoản trừ tiền</small>
                                <?php endif; ?>

                                </td>
                            </tr>
                            <tr class="bg-dark text-success">
                                <th class="font-weight-bold">Tổng Thu Nhập</th>

                                <?php
                                $final = $data['total_personal_income'] - $pen_fee -
                                ($pen_rate/100*$data['total_personal_income'])

                                ?>
                                <th class="text-right font-weight-bold"><?= number_format($final) ?></th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- end col -->

        </div>
        <!-- end row -->

    </div> <!-- end container -->
</div>