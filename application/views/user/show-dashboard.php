<div class="container-fluid mt-4">
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
                <h2 class="font-weight-bold text-danger">Bảng điều khiển</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#"><?= $this->auth['name'] ?></a></li>
                        <li class="breadcrumb-item active">Bảng điều khiển</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md text-center">
            <?php $this->load->view('components/list-navigation'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box bg-dark text-white ">
                        <h2 class="text-uppercase mt-0"> <?= $this->auth['name'] ?></h2>
                        <div class="mt-2 pl-2">
                            <div> <i class="mdi mdi-email-outline mr-2"></i> <?= $this->auth['email'] ?? "[chưa cập nhật]" ?></div>
                            <div> <i class="mdi mdi-phone mr-2"></i> <?= $this->auth['phone_number'] ?? "[chưa cập nhật]" ?></div>
                            <div> <i class="mdi mdi-calendar-range mr-2"></i> Sinh nhật <?= date("d/m/Y",$this->auth['date_of_birth']) ?? "[chưa cập nhật]" ?></div>
                            <div> <i class="mdi mdi-calendar-range mr-2"></i> Ngày vào làm <?= date("d/m/Y",$this->auth['time_joined']) ?? "[chưa cập nhật]" ?></div>
                            <div class="mt-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" required placeholder="Mật khẩu mới" aria-label="Mật khẩu mới" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light" type="button">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Doanh số tích luỹ</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($total_sale) ?></span></h2>
                        <span class="text-muted">Từ ngày tham gia hệ thống</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Hợp đồng</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= count($list_contract) ?></span></h2>
                        <span class="text-muted">Tất cả hợp đồng của bạn</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Khách thuê</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= count($list_customer) ?></span></h2>
                        <span class="text-muted">Tất cả khách thuê của bạn</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Doanh số tháng này</h6>
                        <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($this_month_total_sale) ?></span></h2>
                        <span class="badge badge-custom"> 0% </span>
                        <span class="text-muted">From previous period</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Doanh số tích luỹ</h6>
                        <h2 class="m-b-20">$<span data-plugin="counterup">15.9</span></h2>
                        <span class="badge badge-custom"> 0% </span>
                        <span class="text-muted">From previous period</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    commands.push(function() {
        $('#submit_change_password').click(function () {
            
        });

    });

</script>