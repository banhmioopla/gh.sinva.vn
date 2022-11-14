<?php 

$check_contract_value = in_array($this->auth['role_code'], ['customer-care', 'ceo', 'product-manager']);

?>

<div class="wrapper">
<div class="sk-wandering-cubes" style="display:none" id="loader">
    <div class="sk-cube sk-cube1"></div>
    <div class="sk-cube sk-cube2"></div>
</div>
    <div class="container-fluid">

        <h3 class="text-danger text-center">Bảng điều khiển</h3>
        <div class="text-center">
            <?php $this->load->view('components/list-navigation'); ?>
        </div>

        <div class="district-alert"></div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <strong>Đánh Giá Hoàn Thiện Thông Tin Dự Án: (<?= count($libApartment->listInfoComplete()) ?> mục) </strong>
                    <?php foreach ($libApartment->listInfoComplete() as $k => $v):?>
                        <?= $v . ' / '?>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <h3 class="text-danger text-center">Biểu đồ</h3>
            </div>
            <div class="col-md-3 offset-md-1">
                <div class="card-box shadow">
                    <div class="head-title font-600">Trống - Tổng Phòng</div>

                    <div id="pie-chart">
                        <div id="trong_full" class="flot-chart mt-5" style="height: 350px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card-box shadow">
                    <div class="head-title font-600">Trống - Full</div>

                    <div id="pie-chart">
                        <div id="ordered-bars-chart" class="flot-chart mt-5" style="height: 350px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 offset-md-1">
                <div id="chart-consultant-ColumnChart"></div>
            </div>
            <div class="col-md-10 offset-md-1">
                <div id="chart-contract-ColumnChart"></div>
            </div>
            <div class="col-md-10 offset-md-1">
                <h3 data-toggle="collapse" class="text-danger text-center"
                    href="#numberAvailable"><i class="mdi mdi-chevron-double-down"></i> Số lượng phòng trống tương ứng mức giá
                </h3>
                <p class="text-center">click vào <span data-toggle="collapse" href="#numberAvailable"
                                                       class="text-danger">tiêu đề</span>, tên quận để xổ xuống chi tiết</p>

                <div class="row collapse" id="numberAvailable">
                    <?php foreach($list_district as $d):
                        $list_room_price = $this->ghRoom->getPriceByDistrict($d['code'], 'gh_room.status = "Available" ', 'gh_room.price');
                        ?>
                        <div class="col-2">
                            <div class="card m-b-30">
                                <div data-toggle="collapse" href="#numberAvailable<?= $d['code'] ?>" class="card-body">
                                    <h5 class="card-title text-success btn btn-danger
                                    w-100">Quận <?= $d['name'] ?></h5>
                                    <p class="card-text"></p>

                                </div>
                                <ul id="numberAvailable<?= $d['code'] ?>" class="list-group list-group-flush collapse">
                                    <li class="list-group-item"><a href="<?= base_url() ?>admin/list-apartment?district-code=<?= $d['code'] ?>" class="btn btn-custom waves-effect waves-light w-100">Đi tới Quận <?= $d['name'] ?> </a></li>

                                    <?php $total = 0;
                                    if($list_room_price):
                                        foreach($list_room_price as $room):
                                            $total += $room['object_counter'];

                                            if($room['room_price'] !==  null):
                                                ?>

                                                <li class="list-group-item"><?= number_format($room['room_price']) . ' <i class="text-success font-weight-bold">('.$room['object_counter'] .')</i>' ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <li class="list-group-item font-weight-bold">Tổng Số Lượng: <?= $total ?></li>
                                    <?php else: ?>
                                        <li class="list-group-item text-danger">Không có phòng trống</li>
                                    <?php endif; ?>

                                </ul>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h3 class="text-danger text-center">Bộ Phận Dự Án</h3>
            </div>
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card-box text-dark bg-white text-white shadow">
                    <i class="fi-tag"></i>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-uppercase m-b-5 font-600">Số lượng
                                dự án:
                                <?= $total_apartment ?></p>
                        </div>
                        <div class="col-6">
                            <p class="text-uppercase m-b-5 font-600">Số lượng phòng: <?= $total_room ?></p>
                            <p>
                                <i class="mdi mdi-checkerboard"> SL Trống:</i>

                                <strong class="text-success">
                                    <?= $total_room_available ?></strong> <br>

                                <i class="mdi mdi-checkerboard"> SL Sắp Trống:</i>
                                     <strong class="text-warning"><?=
                                    $total_room_ready ?></strong> <br>

                                <i class="mdi mdi-checkerboard"> SL Full:</i>
                                 <strong class="text-danger"><?= $total_room - $total_room_available - $total_room_ready ?></strong>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end row -->

        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h3 class="text-danger text-center">Bộ Phận Chăm Sóc Khách Hàng</h3>
            </div>
            <?php
            $total_contract_this_month = 0;
            $total_contract_value_this_month = 0;
            $total_contract_value = 0;
            foreach($list_contract as $contract){
                if($contract['time_check_in'] > strtotime(date('01-m-Y'))){
                    $total_contract_this_month += 1;
                    if($contract['room_price'] < 100000) {
                        $total_contract_value_this_month += ($contract['room_price']*23000);
                    } else {
                        $total_contract_value_this_month += $contract['room_price'];
                    }
                }

                if($contract['room_price'] < 100000) {
                    $total_contract_value += ($contract['room_price']*23000);
                } else {
                    $total_contract_value += $contract['room_price'];
                }
            }?>
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card-box text-dark bg-white text-white shadow">
                    <i class="fi-tag"></i>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-uppercase m-b-5 font-600">Số Lượng Khách Hàng:
                                <?= $total_customer ?></p>
                        </div>
                        <div class="col-6">
                            <p class="text-uppercase m-b-5 font-600">Số Lượng Hợp Đồng:
                                <?= $total_contract ?></p>
                        </div>
                        <div class="col-12">
                            <p>
                                <div class="mt-1 border-bottom">
                                    <i class="mdi mdi-checkerboard"> SLHD Tháng <?= date('m')
                                        ?>:</i>

                                    <strong class="float-right"><?= $total_contract_this_month ?></strong>
                                </div>

                                <div class="mt-2 border-bottom">
                                    <i class="mdi mdi-checkerboard"> Tổng G.Trị HD:</i>
                                    <strong class="text-success bg-dark pl-1 pr-1
                                    float-right "><?=
                                        number_format
                                        ($total_contract_value) ?> vnđ</strong>
                                </div>

                                <div class="mt-2 border-bottom">
                                    <i class="mdi mdi-checkerboard"> Tổng G.Trị HD Tháng
                                        <?= date('m') ?>:</i>
                                    <strong class="text-success bg-dark float-right pl-1 pr-1"><?=
                                        number_format
                                        ($total_contract_value_this_month) ?> vnđ</strong>
                                </div>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h3 class="text-center text-danger">Bộ Phận Huấn Luyện Đào Tạo</h3>
            </div>

            <div class="col-12 col-md-6 offset-md-3 col-12">
                <div class="card-box text-dark bg-white text-white shadow">
                    <i class="fi-tag"></i>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <p class="text-uppercase m-b-5 font-600">Số Lượng Thành Viên:
                                <?= count($list_user) ?></p>
                        </div>
                        <?php
                        $time3m_ago = strtotime(date('d-m-Y', strtotime("-90 days")));
                        $time6m_ago = strtotime(date('d-m-Y',strtotime("-180 days")));
                        $time12m_ago = strtotime(date('d-m-Y',strtotime("-365 days")));

                        $total_user_3_month = 0;
                        $total_user_6_month = 0;
                        $total_user_12_month = 0;
                        $total_user_12plus_month = 0;
                        foreach($list_user as $user){
                            if($user['time_joined'] >= $time3m_ago){
                                $total_user_3_month += 1;
                            }
                            if($user['time_joined'] <= $time3m_ago && $user['time_joined'] >= $time6m_ago){
                                $total_user_6_month += 1;
                            }
                            if($user['time_joined'] <= $time6m_ago && $user['time_joined'] >= $time12m_ago){
                                $total_user_12_month += 1;
                            }

                            if($user['time_joined'] <= $time12m_ago && $user['time_joined'] > 0 ){
                                $total_user_12plus_month += 1;
                            }
                        }?>

                        <div class="col-12">
                            <p>
                            <div class="mt-1 border-bottom">
                                <i class="mdi mdi-checkerboard"> Số lượng thành viên dưới 3 tháng:</i>

                                <strong class="float-right">
                                    <?= $total_user_3_month ?></strong>
                            </div>

                            <div class="mt-2 border-bottom">
                                <i class="mdi mdi-checkerboard"> Số lượng thành viên từ 3-6 tháng:</i>
                                <strong class="float-right"><?= $total_user_6_month ?></strong>
                            </div>

                            <div class="mt-2 border-bottom">
                                <i class="mdi mdi-checkerboard"> Số lượng thành viên từ 6-12 tháng:</i>
                                <strong class="float-right"><?= $total_user_12_month ?></strong>
                            </div>

                            <div class="mt-2 border-bottom">
                                <i class="mdi mdi-checkerboard"> Số lượng thành viên từ
                                    + 12 tháng: </i>
                                <strong class=" float-right"><?= $total_user_12plus_month ?></strong>
                            </div>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div>
<script>
    commands.push(function() {
        ! function ($) {
            var FlotChart = function () {
                this.$body = $("body")
                this.$realData = []
            };
            //creates Pie Chart
                FlotChart.prototype.createPieGraph = function (selector, labels, datas, colors) {
                    var data = [{
                        label: labels[0],
                        data: datas[0]
                    }, {
                        label: labels[1],
                        data: datas[1]
                    },
                    {
                        label: labels[2],
                        data: datas[2]
                    }];
                    var options = {
                        series: {
                            pie: {
                                show: true,
                                innerRadius: 0.5,
                                label: {
                                    show: true,
                                    radius: 1,
                                    formatter: function (label, series) {
                                    return '<div class="font-weight-bold p-1 text-light">' + label + '<br/>' +   
                                    parseFloat(series.percent).toFixed(2) + '%</div>';
                                },
                                    background: {
                                        opacity: .8
                                    }
                                }
                            }
                        },
                        legend: {
                            show: false
                        },
                        grid: {
                            hoverable: true,
                            clickable: true
                        },
                        colors: colors,
                        tooltip: true,
                        tooltipOpts: {
                            content: "%s, %p.0%"
                        }
                    };

                    $.plot($(selector), data, options);
                },
                //initializing various charts and components
                FlotChart.prototype.init = function () {
                    //Pie graph data
                    var d_trong = <?= $total_room_available ?>;
                    var d_saptrong_full = <?= $total_room_ready ?>;
                    var d_full = <?= $total_room - $total_room_available - $total_room_ready?>;
                
                    var pielabels = ["Trống - " + d_trong, "Full - " + d_full, "Full (sắp trống) - " + d_saptrong_full];
                    
                    var datas = [d_trong, d_full, d_saptrong_full];
                    var colors = ['#2d7bf4', '#dc3545', '#f3e97a'];
                    this.createPieGraph("#trong_full", pielabels, datas, colors);

                    // Bar chart Room - District
                    
                    let chart_label = JSON.parse('<?= $chart_label ?>');
                    let d1 = JSON.parse('<?= $chart_data_trong ?>');
                    let d2 = JSON.parse('<?= $chart_data_total ?>');
                    let d3 = JSON.parse('<?= $chart_data_saptrong ?>');

                    var data = [
                                {label: "Trống", data: d1, bars: {fillColor: '#2d7bf4'}, color: "#2d7bf4"},
                                {label: "Sap Trong", data: d3, bars: {fillColor: '#e0e019'}, color: "#e0e019"},
                                {label: "Tổng Phòng", data: d2, bars: {fillColor: "#969696"}, color: "#969696"}
                            ];
                    var options = {
                        xaxis: {
                            min: 0,
                            max: 10,
                            mode: null,
                            ticks: chart_label,
                            tickLength: 0,
                            axisLabel: "Quận",
                            axisLabelUseCanvas: true,
                            axisLabelFontSizePixels: 12,
                            axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif",
                            axisLabelPadding: 5
                        }, yaxis: {
                            axisLabel: "Số Lượng Phòng",
                            tickDecimals: 0,
                            axisLabelUseCanvas: true,
                            axisLabelFontSizePixels: 12,
                            axisLabelFontFamily: "Verdana, Arial, Helvetica, Tahoma, sans-serif",
                            axisLabelPadding: 5
                        }, grid: {
                            hoverable: true,
                            clickable: true,
                            borderWidth: 0
                        }, legend: {
                            labelBoxBorderColor: "none", 
                            position: "right"
                        }, series: {
                            shadowSize: 1, 
                            bars: {
                                show: true, 
                                barWidth: 0.2, 
                                order: 1
                            }
                        },
                        colors: colors,
                        tooltip: true
                    };
                    $.plot($("#ordered-bars-chart"), data, options);
                
                },

                //init flotchart
                $.FlotChart = new FlotChart, $.FlotChart.Constructor =
                FlotChart
        }(window.jQuery),
        //initializing flotchart
        function ($) {
                "use strict";
                $.FlotChart.init()
            }(window.jQuery);



        // Google
        !function ($) {
            "use strict";

            var GoogleChart = function () {
                this.$body = $("body")
            };


            //creates bar graph
            GoogleChart.prototype.createColumnChart = function (selector, data, colors,
            title = '') {
                var options = {
                    fontName: 'Roboto',
                    height: 400,
                    fontSize: 12,
                    chartArea: {
                        left: '5%',
                        width: '100%',
                        height: '380px'
                    },
                    tooltip: {
                        textStyle: {
                            fontName: 'Roboto',
                            fontSize: 12
                        }
                    },
                    vAxis: {
                        gridlines: {
                            color: '#f5f5f5',

                        },

                    },
                    legend: {
                        position: 'bottom',
                        alignment: 'center',
                        textStyle: {
                            fontSize: 13
                        }
                    },
                    title: title,
                    colors: colors
                };

                var google_chart_data = google.visualization.arrayToDataTable(data);
                var bar_chart = new google.visualization.ColumnChart(selector);
                bar_chart.draw(google_chart_data, options);
                return bar_chart;
            },


                //init
                GoogleChart.prototype.init = function () {
                    var $this = this;

                    //creating line chart

                    //creating bar chart
                    var data_set = [
                        ['Ngày', "Số Lượt Dẫn Khách"]
                    ];
                    var data_consultant_booking = Object.entries(JSON.parse('<?= $chart_consultantbooking ?>'));
                    for (let item of data_consultant_booking) {
                        data_set.push(item);
                    }
                    $this.createColumnChart($('#chart-consultant-ColumnChart')[0], data_set,
                        ['#48eb88',
                        '#f2eb20'], 'Số lượt dẫn khách 30 ngày gần nhất');

                    var data_set = [
                        ['Ngày', "Số Lượng Hợp Đồng"]
                    ];

                    var data_contract = Object.entries(JSON.parse('<?=
                        $chart_contract ?>'));
                    for (let item of data_contract) {
                        data_set.push(item);
                    }
                    $this.createColumnChart($('#chart-contract-ColumnChart')[0], data_set,
                        ['#ebcb4d',
                            '#f2eb20'], 'Số lượng hợp đồng 30 ngày gần nhất');


                },
                //init GoogleChart
                $.GoogleChart = new GoogleChart, $.GoogleChart.Constructor = GoogleChart
        }(window.jQuery),

            //initializing GoogleChart
            function ($) {
                "use strict";
                //loading visualization lib - don't forget to include this
                google.load("visualization", "1", {packages: ["corechart"]});
                //after finished load, calling init method
                google.setOnLoadCallback(function () {
                    $.GoogleChart.init();
                });
            }(window.jQuery);

    });


</script>

