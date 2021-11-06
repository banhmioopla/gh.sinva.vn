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
                                <h6 class="text-muted text-uppercase mt-0">CHIA SẺ VỚI SALE</h6>
                                <h2 class="m-b-20"><span ><?= number_format($sinva['share_sale_by_ref']) ?></span></h2>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box shadow tilebox-one">
                                <i class="icon-chart float-right text-muted"></i>
                                <h6 class="text-muted text-uppercase mt-0">DT CÒN LẠI (TỔNG DT - CHIA SẺ VỚI SALE)</h6>
                                <h2 class="m-b-20"><span ><?= number_format($sinva['remain_sale']) ?></span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-primary" role="alert">
                            Thành viên do SINVA tuyển dụng, doanh thu share lại với SINVA là <strong>5%</strong> của <strong>3 HỢP ĐỒNG</strong> đầu tiên!
                        </div>
                        <div class="alert alert-primary" role="alert">
                            Thành viên do ĐỘI NHÓM tuyển dụng, doanh thu share lại với ĐỘI NHÓM là <strong>(n)%</strong> của <strong>MỖI HỢP ĐỒNG</strong> đầu tiên!
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
                <h2>DOANH SỐ CÁ NHÂN</h2>
            </div>
            <div class="col-6">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <div id="accordion" role="tablist" aria-multiselectable="true" class="m-b-30">
                                <?php foreach ($data['user'] as $dd):?>
                                    <div class="card">
                                        <div class="card-header" role="tab" id="headingThree">
                                            <h5 class="mb-0 mt-0">
                                                <a class="collapsed text-danger" data-toggle="collapse"
                                                   href="#collapse-<?= $dd['account_id'] ?>" aria-expanded="false">
                                                    <i class="mdi mdi-account-circle"></i> <?= $dd['name'] ?> <span class="text-primary pull-right"><?= number_format($dd['total']) ?></span>
                                                </a>
                                                <?php if($dd['share_with_sinva']):?>
                                                    <div class="m-b-20 pl-2 mt-2">
                                                        <span class="badge badge-primary">sinva: <?= number_format($dd['share_with_sinva']) ?></span>
                                                        <span class="badge badge-primary">HĐ: <?= count($dd['list_sale_item']) ?></span>
                                                    </div>
                                                <?php endif;?>
                                            </h5>
                                        </div>
                                        <div id="collapse-<?= $dd['account_id'] ?>" class="collapse" role="tabpanel" >
                                            <div class="card-body">
                                                <h5>Doanh số từ hợp đồng</h5>
                                                <ul>
                                                    <?php foreach ($dd['list_sale_item'] as $item): ?>
                                                        <li><?= $item['description'] ?> <span class="pull-right text-primary"><?= number_format($item['total_sale']) ?></span></li>
                                                    <?php endforeach; ?>
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

            GoogleChart.prototype.init = function () {
                var $this = this;
                //creating bar chart
                let post_data = {mode: "USER_WITH_SALE", timeFrom: $("input[name=timeFrom]").val(), timeTo: $("input[name=timeTo]").val()};
                console.log(post_data);
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