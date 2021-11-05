<div class="wrapper">
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
                    <h2 class="text-danger font-weight-bold">SÂN CHƠI TÀI CHÍNH (bản mới)</h2>
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
        <div class="district-alert"></div>
        <div class="row">
            <div class="col-12 ">
                <div class="card-box">
                    <form method="GET" class="row">
                        <div class="col-12">
                            <h4 class="text-danger font-weight-bold">Tìm kiếm theo ngày nhập hợp đồng</h4>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Ngày nhập từ</label>
                                    <input type="text" name="timeFrom" class="form-control datepicker" value="<?= $timeFrom ?>" >
                                </div>
                                <div class="col-4">
                                    <label>Ngày nhập đến</label>
                                    <input type="text" name="timeTo" class="form-control datepicker" value="<?= $timeTo ?>">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button id="search" type="submit" class="btn pull-right btn-danger"> Tìm kiếm </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div> <!-- end row -->

        <div class="row">
            <div class="col-12">
                <h2>TỔNG QUAN</h2>
            </div>
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box shadow tilebox-one">
                                <i class="icon-chart float-right text-muted"></i>
                                <h6 class="text-muted text-uppercase mt-0">TỔNG DT</h6>
                                <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($sinva['total_sale']) ?></span></h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box shadow tilebox-one">
                                <i class="icon-chart float-right text-muted"></i>
                                <h6 class="text-muted text-uppercase mt-0">CHIA SẺ VỚI SALE</h6>
                                <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($sinva['share_sale_by_ref']) ?></span></h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box shadow tilebox-one">
                                <i class="icon-chart float-right text-muted"></i>
                                <h6 class="text-muted text-uppercase mt-0">DT CÒN LẠI</h6>
                                <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($sinva['remain_sale']) ?></span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>DOANH SỐ ĐỘI NHÓM</h2>
            </div>
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                    <?php foreach ($data['team'] as $dd):?>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box shadow tilebox-one">
                                <i class="icon-chart float-right text-muted"></i>
                                <h6 class="text-muted text-uppercase mt-0"><?= $dd['name'] ?></h6>
                                <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($dd['total']) ?></span></h2>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2>DOANH SỐ CÁ NHÂN</h2>
            </div>
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <?php foreach ($data['user'] as $dd):?>
                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box shadow tilebox-one">
                                    <i class="icon-chart float-right text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-0"><?= $dd['name'] ?></h6>
                                    <h2 class="m-b-20"><span data-plugin="counterup"><?= number_format($dd['total']) ?></span></h2>
                                    <?php if($dd['share_with_sinva']):?>
                                    <div class="m-b-20"><span class="badge badge-primary"><?= number_format($dd['share_with_sinva']) ?></span></div>
                                    <?php endif;?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('select').select2();
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });
        });
    });
</script>