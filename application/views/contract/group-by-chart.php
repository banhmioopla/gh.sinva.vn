<div id="contract-chart">
    <div class="row">
        <div class="col-md-6 mb-2 col-12">
            <div id="consultant-chart"></div>
        </div>

        <div class="col-md-6 mb-2 col-12">
            <div id="district-chart"></div>
        </div>

        <div class="col-md-12 col-12">
            <div id="daily-chart"></div>
        </div>

        <div class="col-md-12  col-12">
            <div id="timeLine-chart"></div>
        </div>
    </div>


</div>

<script>
    commands.push(function () {
    ! function($){
        "use strict";

        var GoogleChart = function() {
            this.$body = $("#contract-chart");
        };
        GoogleChart.prototype.createColumnChart = function(selector, data, axislabel, colors, title) {
            var options = {
                title:title,
                fontName: 'Roboto',
                height: 500,
                fontSize: 12,

                tooltip: {
                    textStyle: {
                        fontName: 'Roboto',
                        fontSize: 12
                    }
                },
                vAxis: {
                    title: axislabel,
                    titleTextStyle: {
                        fontSize: 12,
                        italic: false
                    },
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
            var column_chart = new google.visualization.ColumnChart(selector);
            column_chart.draw(google_chart_data, options);
            return column_chart;
        },

        //init
        GoogleChart.prototype.init = function () {
            var $this = this;
            //creating column chart

            let contract_consultant_data;
            $.ajax({
                url: "/admin/ajax/contract/chart?groupBy=consultant",
                type: "POST",
                data: {groupBy: "Consultant"},
                dataType: "json",
                async: false,

            }).done(function(response) { // <--- notice the argument here
                console.log(response); // <---- this will be the data you want to work with
                contract_consultant_data = response;
            });

            $this.createColumnChart($('#consultant-chart')[0], contract_consultant_data, 'Doanh số', ['#02c0ce','#0acf97', '#ebeff2'], "Hiệu suất thành viên");

            $.ajax({
                url: "/admin/ajax/contract/chart?groupBy=district",
                type: "POST",
                data: {groupBy: "District"},
                dataType: "json",
                async: false,

            }).done(function(response) { // <--- notice the argument here
                console.log(response); // <---- this will be the data you want to work with
                contract_consultant_data = response;
            });
            $this.createColumnChart($('#district-chart')[0], contract_consultant_data, 'Doanh số', ['#02c0ce','#0acf97', '#ebeff2'], "Hiệu suất quận");


            $.ajax({
                url: "/admin/ajax/contract/chart?groupBy=TimeLine",
                type: "POST",
                data: {groupBy: "TimeLine"},
                dataType: "json",
                async: false,

            }).done(function(response) { // <--- notice the argument here
                console.log(response); // <---- this will be the data you want to work with
                contract_consultant_data = response;
            });
            $this.createColumnChart($('#timeLine-chart')[0], contract_consultant_data, 'Doanh số', ['#02c0ce','#0acf97', '#ebeff2'], "Time line " + '<?= date('Y') ?>');

            if($('#chart-apartment-group-district').length > 0){
                $.ajax({
                    url: "/admin/ajax/apartment/chart?groupBy=district",
                    type: "POST",
                    data: {groupBy: "District"},
                    dataType: "json",
                    async: false,
                }).done(function(response) { // <--- notice the argument here
                    contract_consultant_data = response;
                    console.log(response);
                });
                $this.createColumnChart($('#chart-apartment-group-district')[0], contract_consultant_data, null, ['#02c0ce','#0acf97', '#ebeff2'], "Số lượng dự án");

            }

        },
        //init GoogleChart
        $.GoogleChart = new GoogleChart, $.GoogleChart.Constructor = GoogleChart

        }(window.jQuery),
        //initializing GoogleChart

        function($) {
            "use strict";
            //loading visualization lib - don't forget to include this
            google.load("visualization", "1", {packages:["corechart"]});
            //after finished load, calling init method
            google.setOnLoadCallback(function() {$.GoogleChart.init();});
        }(window.jQuery);

    });

</script>