<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0 ">
                            <li class="breadcrumb-item text-danger"><a href="#" class="text-danger">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active font-weight-bold text-danger">Dẫn Khách</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Thống Kê Dẫn Khách</h2>
                </div>
            </div>
        </div>

        <?php
        if($this->session->has_userdata('fast_notify')):?>
            <div class="row">
                <div class="col-md-6 offset-md-3"><div class="alert alert-warning alert-dismissible fade show" role="alert">s
                        <?= $this->session->flashdata('fast_notify')['message'] ?>
                    </div></div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="row mb-2">
                        <div class="col-md-2 offset-md-3 offset-0">
                            <strong>Từ Ngày</strong>
                            <input type="text" id="timeFrom" class="form-control datepicker" value="<?= $time_from ?>">
                        </div>
                        <div class="col-md-2">
                            <strong>Đến Ngày</strong>
                            <input type="text" id="timeTo" class="form-control datepicker" value="<?= $time_to ?>">
                        </div>
                        <div class="col-2">
                            <strong>Biểu Đồ</strong>
                            <button class="btn btn-danger d-block" id="submitChart" type="button">Áp Dụng</button>
                        </div>
                        <div class="col-12 text-center mt-2">
                            Chọn Khoảng Tgian Và Click Click Vào "Áp Dụng" Để Hiển Thị[Biểu Đồ Thống Kê]
                        </div>
                    </div>
                    <div id="chart-overview"></div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form action="">
                    <div class="row">
                        <div class="col-md-2">
                            <strong>Từ Ngày</strong>
                            <input type="text" name="timeFrom" class="form-control datepicker" value="<?= $time_from ?>">
                        </div>
                        <div class="col-md-2">
                            <strong>Đến Ngày</strong>
                            <input type="text" name="timeTo" class="form-control datepicker" value="<?= $time_to ?>">
                        </div>
                        <div class="col-md-2">
                            <strong>Trạng Thái</strong>
                            <select name="status" id="" class="form-control">
                                <option value="">Tất Cả Trạng Thái</option>
                                <option value="Success">Thành Công</option>
                                <option value="Cancel">Boom</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <strong>Bộ Phận</strong>
                            <select name="department" id="" class="form-control">
                                <option value="">SINVA</option>
                                <option value="VH">Bộ Phận Vận Hành</option>
                                <option value="KD">Bộ Phận Kinh Doanh</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <strong>Quận</strong>
                            <select name="district" id="" class="form-control">
                                <?php echo $cb_district?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <strong>Thống Kê Dẫn Khách</strong>
                            <button type="submit" class="btn btn-danger form-control">Áp Dụng</button>
                        </div>
                    </div>
                    </form>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4 class="font-weight-bold text-danger">Thống Kê Dẫn Khách</h4>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <th>Ngày</th>
                                    <th>Thành Viên</th>
                                    <th>Khách Hàng</th>
                                    <th>Dự Án</th>
                                    <th>Phòng</th>
                                    <th>Ghi Chú</th>
                                    <th class="text-center">Trạng Thái</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($list_booking as $booking):
                                        $address = '';
                                        $apmModel = $ghApartment->getFirstById($booking['apartment_id']);
                                        if ($apmModel) {
                                            $address = $apmModel['address_street'];
                                        }
                                        $arr_room_id = json_decode($booking['room_id'], true);
                                        $text_detail_room_code = '';
                                        foreach ($arr_room_id as $r_id) {
                                            $roomModel = $ghRoom->getFirstById($r_id);
                                            if($roomModel) {
                                                $text_detail_room_code .= $roomModel['code'] . ' ';
                                            }

                                        }
                                        $apmModel = $ghApartment->getFirstById($booking['apartment_id']);

                                        $list_room_id = json_decode($booking['room_id'], true);
                                        $text_room_code = '';
                                        $js_list_room = implode(",", $list_room_id);
                                        if ($list_room_id && count($list_room_id) > 0) {
                                            foreach ($list_room_id as $room_id) {
                                                $roomModel = $ghRoom->getFirstById($room_id);
                                                if($roomModel) {
                                                    $text_room_code .= $roomModel['code'] . ' ';
                                                }
                                            }
                                        }

                                        $status = 'danger';
                                        if ($booking['status'] == 'Success') {
                                            $status = 'success';
                                        }
                                        if ($booking['status'] == 'Pending') {
                                            $status = 'warning';
                                        }

                                        ?>
                                        <tr>
                                            <td>
                                                <div class="form-inline">
                                                    <div class="booking-time_booking input-group"
                                                         data-pk="<?= $booking['id'] ?>"
                                                         data-name="time_booking"
                                                         data-value="<?= date('d/m/Y H:i', $booking['time_booking']) ?>">
                                                        <?= date('d/m/Y H:i', $booking['time_booking']) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>
                                            <td><?= $libCustomer->getNameById($booking['customer_id']) ?></td>
                                            <td><?= $address ?></td>
                                            <td class="booking-room-code"
                                                data-pk="<?= $booking['id'] ?>"
                                                data-name="room_id"
                                                data-value="<?= $js_list_room ?>"
                                                data-apartment-id="<?= $booking['apartment_id'] ?>"
                                            ><i class="text-success"><?= $text_room_code ?></i></td>
                                            <td><div class="booking-note"
                                                     data-pk="<?= $booking['id'] ?>"
                                                     data-name="note"
                                                     data-value="<?= $booking['note'] ?>"
                                                ><?= $booking['note'] ?></div></td>
                                            <td class="text-center"><div class="booking-status text-light badge badge-<?= $status ?>"
                                                                         data-pk="<?= $booking['id'] ?>"
                                                                         data-name="status"
                                                                         data-value="<?= $booking['status'] ?>">
                                                    <?= $label_apartment['booking.' . $booking['status']] ?>
                                                </div></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end container -->
</div>



<script>
    commands.push(function () {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });
        $('table').DataTable({
            "order": [],
            "fnDrawCallback": function () {
                $('.booking-note').editable({
                    type: "text",
                    url: '<?= base_url() ?>admin/update-consultant-booking-editable',
                    inputclass: ''
                });

                $('.booking-status').editable({
                    type: 'select',
                    url: '<?= base_url() ?>admin/update-consultant-booking-editable',
                    inputclass: '',
                    source: function () {
                        let data = [
                            {value: "Pending", text: "đang chờ"},
                            {value: "Success", text: "thành công"},
                            {value: "Cancel", text: "Boom"}
                        ];
                        return data;
                    }
                });

                $('.booking-room-code').editable({
                    type: 'checklist',
                    url: '<?= base_url() ?>admin/consultant-booking/get-room-id',
                    inputclass: '',
                    source: function () {
                        let data = [];
                        let apartment_id = $(this).data('apartment-id');
                        $.ajax({
                            url: '<?= base_url() ?>admin/consultant-booking/get-room-id?apartment_id=' + apartment_id,
                            dataType: 'json',
                            async: false,
                            success: function (res) {
                                data = res;
                                return res;
                            }
                        });
                        return data;
                    }
                });
                $('.booking-time_booking').editable({
                    placement: 'right',
                    type: 'combodate',
                    template: "D MM YYYY HH mm",
                    format: "DD-MM-YYYY HH:mm",
                    viewformat: "DD-MM-YYYY HH:mm",
                    mode: 'inline',
                    combodate: {
                        firstItem: 'name',
                        maxYear: '2022',
                        minYear: '2020',
                        customClass: 'form-control-sm mb-1'
                    },
                    mode: 'popup',
                    inputclass: 'form-control',
                    url: '<?= base_url() ?>admin/update-consultant-booking-editable',
                });
            }
        });



        google.charts.load('current', {'packages':['corechart']});

        let options = {
            title: 'Thống Kê Dẫn Khách',
            legend: { position: 'bottom' },
            series: {
                0: { color: '#3ae743', lineWidth: 4 },
                1: { color: '#e2431e', lineWidth: 4  },
                2: { color: '#949595', lineDashStyle: [14, 2, 2, 7] },
            }
        };
        $('#submitChart').click(function () {
            let timeFrom = $('#timeFrom').val();
            let timeTo = $('#timeTo').val();
            console.log(timeFrom, timeTo);
            $.ajax({
                url: '/admin/consultant-booking/chart',
                method: 'post',
                data: {timeFrom: timeFrom, timeTo: timeTo},
                success: function (res) {
                    let dataChart = JSON.parse(res);
                    google.charts.setOnLoadCallback(function () {
                        drawChart(dataChart);
                    });
                }
            });
        });

        function drawChart(dataChart) {
            console.log(dataChart);

            let pre_data = [['Ngày', 'Thành Công', 'Boom', 'Book']]; // success: [date => quantity],
            let dataRes = dataChart.data;
            for (let key in dataRes) {
                pre_data.push([key, dataRes[key]['success'], dataRes[key]['boom'], dataRes[key]['book']]);
            }


            let data = google.visualization.arrayToDataTable(pre_data);
            var chart = new google.visualization.LineChart(document.getElementById('chart-overview'));

            chart.draw(data, options);
        }
    });
</script>