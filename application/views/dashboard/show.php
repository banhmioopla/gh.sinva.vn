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
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="head-title font-600">Trống - Full</div>

                    <div id="pie-chart">
                        <div id="trong_full" class="flot-chart mt-5" style="height: 350px;">
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
        </div> <!-- end row -->

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
                    var d_saptrong_full = <?=$total_room_ready ?>;
                    var d_full = <?= $total_room - $total_room_available - $total_room_ready?>;
                
                    var pielabels = ["Trống - " + d_trong, "Full - " + d_full, "Full (sắp trống) - " + d_saptrong_full];
                    
                    var datas = [d_trong, d_full, d_saptrong_full];
                    var colors = ['#2d7bf4', '#dc3545', '#f3e97a'];
                    this.createPieGraph("#trong_full", pielabels, datas, colors);
                
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