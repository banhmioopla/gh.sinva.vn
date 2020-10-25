<?php 

$check_contract_value = in_array($this->auth['role_code'], ['customer-care', 'ceo', 'product-manager']);

?>
<div class="wrapper">
<div class="sk-wandering-cubes" style="display:none" id="loader">
    <div class="sk-cube sk-cube1"></div>
    <div class="sk-cube sk-cube2"></div>
</div>
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GioHang</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h3 class="page-title">Bảng điều khiển</h3>
                </div>
            </div>
        </div>
        
        <div class="district-alert"></div>
        <h3 class="page-title">Bộ Phận Dự Án</h3>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_apartment ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng dự án</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_room ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng phòng</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_room_available ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng phòng Trống</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_room_ready ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng phòng Sắp Trống</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_room - $total_room_available - $total_room_ready ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng phòng Full
                        <br>
                        <hr>
                        Số lượng phòng Full = (Tổng - (Trống + Sắp Trống))
                    </p>
                </div>
            </div>
        </div> <!-- end row -->
        <h3 class="page-title">Bộ Phận Chăm Sóc Khách Hàng</h3>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-custom bg-custom text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_customer ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng khách hàng</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-custom bg-custom text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_contract ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng hợp đồng</p>
                </div>
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
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-custom bg-custom text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_contract_this_month ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng hợp đồng tháng <?= date('m/Y') ?></p>
                </div>
            </div>
            <?php if($check_contract_value):?>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-custom bg-custom text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= number_format($total_contract_value) ?> vnđ</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Tổng giá trị hợp đồng </p>
                    <hr>
                    Nếu USD thì hệ số là x 23k VND
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-custom bg-custom text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= number_format($total_contract_value_this_month) ?> vnđ</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Tổng giá trị hợp đồng tháng <?= date('m/Y') ?></p>
                    <hr>
                    Nếu USD thì hệ số là x 23k VND
                </div>
            </div>
            <?php endif; ?>
        </div>
        <h3 class="page-title">Bộ Phận Huấn Luyện Đào Tạo</h3>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-warning bg-warning text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= count($list_user) ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng thành viên</p>
                </div>
            </div>
            <?php 
            $time3m_ago = strtotime(date('d-m-Y', strtotime("-90 days")));
            $time6m_ago = strtotime(date('d-m-Y',strtotime("-180 days")));
            $time12m_ago = strtotime(date('d-m-Y',strtotime("-365 days")));

            // echo strtotime(date('d-m-Y', strtotime("-90 days"))); echo "<br>";
            // echo strtotime(date('d-m-Y',strtotime("-180 days"))); die;
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
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-warning bg-warning text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_user_3_month ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng thành viên dưới 3 tháng</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-warning bg-warning text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_user_6_month ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng thành viên từ 3-6 tháng</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-warning bg-warning text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_user_12_month ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng thành viên từ 6-12 tháng</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card-box widget-flat border-warning bg-warning text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10"><?= $total_user_12plus_month ?></h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Số lượng thành viên từ + 12 tháng</p>
                </div>
            </div>
        </div>
        <h3 class="page-title">Biểu đồ</h3>
        <div class="row">
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="head-title font-600">Trống - Tổng Phòng</div>

                    <div id="pie-chart">
                        <div id="trong_full" class="flot-chart mt-5" style="height: 350px;">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card-box">
                    <div class="head-title font-600">Trống - Full</div>

                    <div id="pie-chart">
                        <div id="ordered-bars-chart" class="flot-chart mt-5" style="height: 350px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card-box">
                    <div class="head-title font-600">Thống Kê Phòng Trống</div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Quận</th>
                            <th scope="col">Danh Sách Giá - Số Lượng</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php foreach($list_district as $d):?>
                        <?php 
                        
                        $list_room_price = $this->ghRoom->getPriceByDistrict($d['code'], 'gh_room.status = "Available" ');    
                        ?>
                            <tr>
                                <td><?= $d['name'] ?></td>
                                <td class="text-left">
                                <div class="card-box tilebox-one">
                                    <?php 
                                        if($list_room_price):
                                            $total = 0;
                                        foreach($list_room_price as $room): 
                                            $total += $room['object_counter'];
                                    ?>
                                    <li class="m-b-20 text-success" >
                                    <span class=" badge badge-success badge-pill mr-2">  <?= $room['object_counter'] ?> P</span>
                                            <?= strip_tags(number_format($room['room_price']))?> 
                                    </li>
                                    <?php 
                                        endforeach;
                                        echo "<hr>
                                        <div class='font-weight-bold'>Tổng Số lượng:  ".$total."</div>";
                                    else: echo "<div class='text-danger'> Không có phòng trống<div>";
                                    endif;
                                    ?>
                                    
                                </div>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                    <div id="table">
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
                                    Math.round(series.percent) + '%</div>';
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

                    var data = [
                                {label: "Trống", data: d1, bars: {fillColor: '#2d7bf4'}, color: "#2d7bf4"},
                                {label: "Tổng Phòng", data: d2, bars: {fillColor: "#f5a742"}, color: "#f5a742"}
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
    });

</script>