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
                    <h5 class="mb-3">Tổng Quan Tháng <?= date('m/Y') ?></h5>

                    <div class="table-responsive">
                        <table class="table table-bordered m-b-0">
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
                                <td>Tổng Thu Nhập Theo Hợp Đồng</td>
                                <td class="text-right"><?= number_format($data['total_personal_income']) ?></td>
                            </tr>
                            <tr class="text-muted">
                                <td>Các Danh Mục Trừ Tiền</td>
                                <td class="text-right"><small class="text-muted">đang phát triển
                                        ...</small></td>
                            </tr>
                            <tr class="bg-dark text-success">
                                <th class="font-weight-bold">Tổng Thu Nhập</th>
                                <th class="text-right font-weight-bold"><?= number_format($data['total_personal_income']) ?></th>
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