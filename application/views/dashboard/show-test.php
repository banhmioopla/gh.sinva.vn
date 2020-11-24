<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="bar-chart"></div>
            </div>
        </div>
    </div>
</div>


<script>
    commands.push(function () {


        !function ($) {
            "use strict";

            var GoogleChart = function () {
                this.$body = $("body")
            };


                //creates bar graph
                GoogleChart.prototype.createColumnChart = function (selector, data, colors) {
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
                                count: 10
                            },
                            minValue: 0
                        },
                        legend: {
                            position: 'bottom',
                            alignment: 'center',
                            textStyle: {
                                fontSize: 13
                            }
                        },
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
                    let data_consultant_booking = Object.entries(JSON.parse('<?= $chart_consultantbooking ?>'));
                    for (let item of data_consultant_booking) {
                        data_set.push(item);
                    }
                    $this.createColumnChart($('#bar-chart')[0], data_set, ['#48eb88', '#f2eb20']);


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