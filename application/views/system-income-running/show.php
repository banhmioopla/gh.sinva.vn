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
                            <h4 class="text-danger font-weight-bold">Tìm kiếm theo ngày ký hợp đồng</h4>
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
                                <h2 class="m-b-20"><span ><?= number_format($sinva['total_sale']) ?></span></h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box shadow tilebox-one">
                                <i class="icon-chart float-right text-muted"></i>
                                <h6 class="text-muted text-uppercase mt-0">Phí do SINVA tuyển dụng</h6>
                                <h2 class="m-b-20"><span ><?= number_format($sinva['share_sale_by_ref']) ?></span></h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box shadow tilebox-one">
                                <i class="icon-chart float-right text-muted"></i>
                                <h6 class="text-muted text-uppercase mt-0">DT CÒN LẠI (TỔNG DT - SINVA tuyển dụng)</h6>
                                <h2 class="m-b-20"><span ><?= number_format($sinva['remain_sale']) ?></span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-primary" role="alert">
                            Thành viên do SINVA tuyển dụng, doanh thu share lại với (SINVA | ĐỘI NHÓM) là <strong>5%</strong> của <strong>3 HỢP ĐỒNG</strong> đầu tiên!
                        </div>
                    </div>
                    <div class="col-md-8 offset-md-2">
                        <div class="card-box">
                            <h4 class="header-title mb-4 text-center">Góc chia bánh | 75% | <?= number_format(0.75*$sinva['total_sale']) ?></h4>

                            <ul
                                    class="list-unstyled transaction-list border pl-2 pr-4 border-dark slimscroll mb-0"
                                    style="max-height: 200px"
                            >

                                <li>
                                    <i class=" fa fa-get-pocket text-success"></i>
                                    <span class="tran-text">Quỹ chung Sinva </span>
                                    <span class="pull-right text-success tran-price"><?= number_format($general_fund) ?></span>
                                    <span class="clearfix"></span>
                                </li>

                                <li>
                                    <i class=" fa fa-get-pocket text-success"></i>
                                    <span class="tran-text">Quỹ cố vấn </span>
                                    <span class="pull-right text-success tran-price"><?= number_format($consultant_boss_fund) ?></span>
                                    <span class="clearfix"></span>
                                </li>
                                <li>
                                    <i class=" fa fa-get-pocket text-success"></i>
                                    <span class="tran-text">Quỹ QLDA </span>
                                    <span class="pull-right text-success tran-price"><?= number_format($product_manager_fund) ?></span>
                                    <span class="clearfix"></span>
                                </li>

                                <li>
                                    <i class=" fa fa-get-pocket text-success"></i>
                                    <span class="tran-text">Quỹ đội nhóm </span>
                                    <span class="pull-right text-success tran-price"><?= number_format($team_fund) ?></span>
                                    <span class="clearfix"></span>
                                </li>

                                <li>
                                    <i class=" fa fa-get-pocket text-success"></i>
                                    <span class="tran-text">TN ch.viên </span>
                                    <span class="pull-right text-success tran-pricex"><?= number_format($total_income) ?></span>
                                    <span class="clearfix"></span>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8 offset-md-2">
                        <div class="card-box">
                            <div id="3d-exploded-chart"></div>
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
                                <h2 class="m-b-20"><span ><?= number_format($dd['total']) ?></span></h2>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2>DOANH SỐ | THU NHẬP CÁ NHÂN</h2>
            </div>
            <div class="col-md-6">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" role="alert">
                                Click vào tên để xem chi tiết!
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="accordion" role="tablist" aria-multiselectable="true" class="m-b-30">
                                <?php foreach ($data['user'] as $dd):?>
                                    <?php
                                    $income_pack = $dd["income_pack"];
                                    $refer_user_income = isset($refer_user_income_pack[$dd['account_id']]) ? $refer_user_income_pack[$dd['account_id']]: 0;
                                    $pro_manager_income = isset($pro_manager_pack[$dd['account_id']]) ? $pro_manager_pack[$dd['account_id']]: 0;

                                    $text_income = "text-success";
                                    if(empty($income_pack['total_income'])){
                                        $text_income = "text-warning";
                                    }

                                    ?>
                                    <div class="card">
                                        <div class="card-header" role="tab" id="headingThree">
                                            <h5 class="mb-0 mt-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <a class="collapsed text-danger" data-toggle="collapse"
                                                           href="#collapse-<?= $dd['account_id'] ?>" aria-expanded="false">
                                                            <i class="mdi mdi-account-circle"></i> <?= $dd['name'] ?>
                                                        </a>
                                                        <span class="pull-right text-primary pl-1"><?= round($income_pack['total_sale']/$sinva['total_sale'],3)*100 ?>% | <?= number_format($income_pack['total_sale']) ?></span>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <div class="text-primary bg-dark text-center p-1 rounded <?= $text_income ?>"><?= number_format($refer_user_income+$income_pack['total_income']) ?></div>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-12 m-b-20 text-center pl-md-2 mt-2">
                                                        <span class="badge badge-primary mb-1">sinva: <?= number_format($dd['fund']['sinva_fund']) ?></span>
                                                        <span class="badge badge-primary mb-1">HĐ: <?= count($dd['list_sale_item']) ?></span>
                                                    </div>
                                                </div>

                                            </h5>
                                        </div>
                                        <div id="collapse-<?= $dd['account_id'] ?>" class="collapse" role="tabpanel" >
                                            <div class="card-body">
                                                <h5>Doanh số từ hợp đồng</h5>
                                                <ol>
                                                    <?php foreach ($dd['list_sale_item'] as $item): ?>
                                                        <li><?= $item['description'] ?> <span class="pull-right text-primary"><?= number_format($item['total_sale']) ?></span></li>
                                                    <?php endforeach; ?>
                                                </ol>
                                                <hr>

                                                <div>
                                                    Được tuyển vào bởi: <?= $income_pack['refer_by'] ?>
                                                    <hr>
                                                </div>
                                                <h5>Chia bánh</h5>
                                                <ul>
                                                    <li>Gói 25% <span class="pull-right"><?= number_format($income_pack['total_sale']*0.25) ?></span> </li>
                                                    <li>Gói 75% <span class="pull-right"><?= number_format($income_pack['total_sale']*0.75) ?></span> </li>
                                                    <li>Quỹ team <?= $income_pack['team_name'] ?> <span class="pull-right"><?= number_format($income_pack['team_fund']) ?></span> </li>
                                                    <li>Cố vấn <span class="pull-right"><?= number_format($income_pack['consultant_boss_fund']) ?></span></li>
                                                    <li>
                                                        QLDA <span class="pull-right"><?= number_format($income_pack['product_manager_fund']) ?></span>
                                                        <?php if($income_pack['product_manager_fund'] > 0): ?>
                                                        <ul>
                                                            <?php foreach ($income_pack['product_manager_list'] as $pm_account => $pm_amount):?>
                                                                <li><?= $libUser->getNameByAccountid($pm_account) ." (". number_format($pm_amount) .")" ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <?php endif; ?>
                                                    </li>
                                                    <li>Quỹ Sinva <span class="pull-right"><?= number_format($income_pack['general_fund']) ?></span></li>
                                                    <li>Phí tuyển dụng  <span class="pull-right"><?= number_format($income_pack['refer_fund']) ?></span></li>

                                                </ul>
                                                <hr>
                                                <h5>Ăn tiền <span class="pull-right pl-2 pr-1 rounded <?= $text_income ?> bg-dark"><?= number_format($refer_user_income+$income_pack['total_income']) ?></span></h5>
                                                <ul>
                                                    <li>Ăn hợp đồng  <span class="pull-right pl-2 rounded pr-1 text-success bg-dark"><span class="text-warning">(<?= ($income_pack['income_rate']*100) ."%" ?>)</span> <?= number_format($income_pack['total_income']) ?></span></li>
                                                    <li class="mt-1">Ăn tuyển dụng  <span class="pull-right  <?= $text_income ?> bg-dark pl-2 pr-1"><?= number_format($refer_user_income) ?></span></li>
                                                    <li class="mt-1">Ăn QLDA  <span class="pull-right  <?= $text_income ?> bg-dark pl-2 pr-1"><?= number_format($pro_manager_income) ?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <div id="bar-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        ! function($) {
            let GoogleChart = function() {
                this.$body = $("body")
            };
            $.GoogleChart = new GoogleChart, $.GoogleChart.Constructor = GoogleChart;
            GoogleChart.prototype.createBarChart = function(selector, data, colors, lengthx) {
                let options = {
                    fontName: 'Roboto',
                    height: (80 * lengthx) + 100,
                    fontSize: 12,
                    chartArea: {
                        left: '8%',
                        width: '100%',
                        height: 80 * lengthx
                    },
                    tooltip: {
                        textStyle: {
                            fontName: 'Roboto',
                            fontSize: 12
                        }
                    },
                    vAxis: {
                        gridlines:{
                            color: '#f5f5f5',
                            count: 10
                        },
                        minValue: 0
                    },
                    legend: {
                        position: 'top',
                        alignment: 'center',
                        textStyle: {
                            fontSize: 13
                        }
                    },
                    colors: colors
                };

                var google_chart_data = google.visualization.arrayToDataTable(data);
                var bar_chart = new google.visualization.BarChart(selector);
                bar_chart.draw(google_chart_data, options);
                return bar_chart;
            },
            GoogleChart.prototype.createPieChart = function(selector, data, colors, is3D, issliced) {
                    var options = {
                        fontName: 'Roboto',
                        fontSize: 13,
                        height: 300,
                        chartArea: {
                            left: 0,
                            width: '100%',
                            height: '100%'
                        },
                        colors: colors
                    };

                    if(is3D) {
                        options['is3D'] = true;
                    }

                    if(issliced) {
                        options['is3D'] = true;
                        options['pieSliceText'] = 'label';
                        options['slices'] = {
                            2: {offset: 0.10},
                            5: {offset: 0.20}
                        };
                    }

                    var google_chart_data = google.visualization.arrayToDataTable(data);
                    var pie_chart = new google.visualization.PieChart(selector);
                    pie_chart.draw(google_chart_data, options);
                    return pie_chart;
                },
            GoogleChart.prototype.init = function () {
                var $this = this;
                //creating bar chart
                let post_data = {mode: "USER_WITH_SALE", timeFrom: $("input[name=timeFrom]").val(), timeTo: $("input[name=timeTo]").val()};

                $.ajax({
                    url: '/chart/get-data',
                    method: "POST",
                    dataType: "json",
                    data: post_data ,
                    success:function (res) {
                        console.log(res);
                        $this.createBarChart($('#bar-chart')[0], res, ['#4eb7eb', '#f2e778'], res.length);
                    }
                });

                var sliced_Data = [
                    ['Language', 'Speakers (in millions)'],
                    ['Thu nhập', 60],
                    ['Tuyển dụng', 5],
                    ['Quỹ Team', 2],
                    ['Cố vấn', 3],
                    ['Quỹ Chung Cty', 2],
                    ['QLDA', 5],
                    ['Chi phí cứng', 25]
                ];
                $this.createPieChart($('#3d-exploded-chart')[0], sliced_Data, ['#f59842', '#f5ec42','#f56342','#02c0ce', '#e3eaef', '#32c861',"#353d4a"], true, true);

            };

            google.load("visualization", "1", {packages:["corechart"]});
            //after finished load, calling init method
            google.setOnLoadCallback(function() {$.GoogleChart.init();});
        }(window.jQuery);


        $(document).ready(function() {
            $('select').select2();
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });

            //loading visualization lib - don't forget to include this


        });
    });
</script>