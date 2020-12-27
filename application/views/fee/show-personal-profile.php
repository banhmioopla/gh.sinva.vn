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

                <div class="row">
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="icon-layers float-right text-muted"></i>
                            <h5 class="text-muted mt-0">Tổng Hợp Đồng</h5>
                            <h2 class="m-b-20" data-plugin="counterup">1,587</h2>
                            <span class="badge badge-custom"> +11% </span> <span class="text-muted">From previous period</span>
                        </div>
                    </div><!-- end col -->

                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="icon-paypal float-right text-muted"></i>
                            <h5 class="text-muted mt-0">Tổng Khách
                                Hàng</h5>
                            <h2 class="m-b-20">$<span data-plugin="counterup">46,782</span></h2>
                            <span class="badge badge-danger"> -29% </span> <span class="text-muted">From previous period</span>
                        </div>
                    </div><!-- end col -->

                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="icon-rocket float-right text-muted"></i>
                            <h5 class="text-muted mt-0">Thu Nhập Tháng
                                <?= date('m/Y') ?>
                            </h5>
                            <h2 class="m-b-20" data-plugin="counterup">1,890</h2>
                            <span class="badge badge-custom"> +89% </span> <span class="text-muted">Last year</span>
                        </div>
                    </div><!-- end col -->

                </div>
                <!-- end row -->


                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">Experience</h4>
                    <div class="">
                        <div class="">
                            <h5 class="text-custom m-b-5">Lead designer / Developer</h5>
                            <p class="m-b-0">websitename.com</p>
                            <p><b>2010-2015</b></p>

                            <p class="text-muted font-13 m-b-0">Lorem Ipsum is simply dummy text
                                of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the
                                1500s, when an unknown printer took a galley of type and
                                scrambled it to make a type specimen book.
                            </p>
                        </div>

                        <hr>

                        <div class="">
                            <h5 class="text-custom m-b-5">Senior Graphic Designer</h5>
                            <p class="m-b-0">coderthemes.com</p>
                            <p><b>2007-2009</b></p>

                            <p class="text-muted font-13">Lorem Ipsum is simply dummy text
                                of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the
                                1500s, when an unknown printer took a galley of type and
                                scrambled it to make a type specimen book.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="card-box">
                    <h4 class="header-title mb-3">My Projects</h4>

                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Assign</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Adminox Admin</td>
                                <td>01/01/2015</td>
                                <td>07/05/2015</td>
                                <td><span class="label label-info">Work in Progress</span></td>
                                <td>Coderthemes</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Adminox Frontend</td>
                                <td>01/01/2015</td>
                                <td>07/05/2015</td>
                                <td><span class="label label-success">Pending</span></td>
                                <td>Coderthemes</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Adminox Admin</td>
                                <td>01/01/2015</td>
                                <td>07/05/2015</td>
                                <td><span class="label label-pink">Done</span></td>
                                <td>Coderthemes</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Adminox Frontend</td>
                                <td>01/01/2015</td>
                                <td>07/05/2015</td>
                                <td><span class="label label-purple">Work in Progress</span></td>
                                <td>Coderthemes</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Adminox Admin</td>
                                <td>01/01/2015</td>
                                <td>07/05/2015</td>
                                <td><span class="label label-warning">Coming soon</span></td>
                                <td>Coderthemes</td>
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