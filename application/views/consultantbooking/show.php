<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
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
        <div class="d-flex justify-content-center flex-wrap">
            <?php $this->load->view('components/list-navigation');
            ?>
        </div>

        <?php
        $count_success = $count_pending = $count_cancel = 0;
        foreach ($list_booking as $item) {
            if ($item['status'] == 'Success') $count_success++;
            if ($item['status'] == 'Pending') $count_pending++;
            if ($item['status'] == 'Cancel') $count_cancel++;
        }
        ?>
        <?php if($flash_mess):?>
        <div class="row">
            <div class="col-md-6 offset-md-3"><div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?= $flash_mess ?>
                </div></div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card-box shadow bg-white border-white text-dark">
                    <p class="text-uppercase m-b-5 font-600"> Tổng số lượt dẫn:
                        <span style="font-size: 20px"><?= count($list_booking) ?></span>
                    </p>
                    <div class="d-block"><i class="mdi mdi-chevron-double-right text-danger"></i> Thành công: <span class="text-success"><?=
                            $count_success
                            ?></span>
                        | Đang chờ: <span class="text-warning"><?= $count_pending
                            ?></span> | Boom: <span class="text-danger"> <?= $count_cancel ?></span> </div>

                    <div class="d-block"><i class="mdi mdi-chevron-double-right text-danger"></i> Đã có lượt dẫn tại : <strong><?= $quantity['booking_district']
                            ?></strong> quận, <strong><?= $quantity['booking_apm'] ?></strong> dự án
                        </div>

                    <?php if($target === null): ?>
                        <hr>
                        <form action="/admin/create-user-target" method="POST">
                            <div class="form-group row text-uppercase m-b-5 ">
                                <label for="name" class="col-md-12 col-12
                            col-form-label font-600 ">
                                    Vui Lòng Đặt Mục Tiêu Dẫn Khách
                                    Tuần Này<span class="text-danger">*</span>
                                </label>
                                <div class="col-md-6 col-12">
                                    <input type="number" name="target" class="form-control
                                border
                                border-success">
                                </div>
                                <div class=" col-md-2 text-center">
                                    <button type="submit" class="btn btn-danger">Xác Nhận</button>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <hr>
                        <p class="text-uppercase m-b-5 font-600"> Mục Tiêu
                            Tuần Này Của Bạn:
                            <span style="font-size: 20px"><?= $target['target'] ?>
                                Lượt Dẫn</span>
                        </p>
                    <?php endif;?>

                    <?php if (isYourPermission($this->current_controller, 'showAllTimeLine', $this->permission_set)): ?>
                        <hr>
                        <div class="text-uppercase font-weight-bold text-danger">Lọc Dữ Liệu</div>
                        <select name="filterTime" class="form-control mt-2">
                            <option <?= $this->input->get('filterTime') == '' ? 'selected' : '' ?>
                                    value="ALL">Chọn khoảng thời gian (tất cả)
                            </option>
                            <option <?= $this->input->get('filterTime') == 'TODAY' ? 'selected' : '' ?>
                                    value="TODAY">Hôm nay
                            </option>
                            <option <?= $this->input->get('filterTime') == 'THIS_WEEK' ? 'selected' : '' ?>
                                    value="THIS_WEEK">Tuần Này
                            </option>
                            <option <?= $this->input->get('filterTime') == 'LAST_WEEK' ? 'selected' : '' ?>
                                    value="LAST_WEEK">Tuần Trước
                            </option>
                        </select>
                        <div class="text-center mt-2">
                            <?php if($time_from && $time_to):?>
                            <i class="text-info">Từ ngày (<?= date('d-m-Y', $time_from) ?> - <?= date('d-m-Y', $time_to) ?>)</i>
                            <?php endif; ?>
                        </div>
                        <div class="mt-5">
                            <div class="font-weight-bold text-danger mb-2">BẢNG</div>
                            <div class="checkbox checkbox-danger form-check-inline">
                                <input type="checkbox" id="table-1"
                                       <?= $this->input->get('tb1') == 1 ? 'checked':''?>
                                       value="1">
                                <label for="table-1"> Kinh Doanh </label>
                            </div>
                            <div class="checkbox checkbox-danger form-check-inline">
                                <input type="checkbox" id="table-2"
                                    <?= $this->input->get('tb2') == 2 ? 'checked':''?>
                                       value="2">
                                <label for="table-2"> Vận Hành </label>
                            </div>
                            <div class="checkbox checkbox-danger form-check-inline">
                                <input type="checkbox" id="table-3"
                                    <?= $this->input->get('tb3') == 3 ? 'checked':''?>
                                       value="3">
                                <label for="table-3"> Thành Công </label>
                            </div>
                            <div class="checkbox checkbox-danger form-check-inline">
                                <input type="checkbox" id="table-4"
                                    <?= $this->input->get('tb4') == 4 ? 'checked':''?>
                                       value="4">
                                <label for="table-4"> Boom </label>
                            </div>
                            <div class="checkbox checkbox-danger form-check-inline">
                                <input type="checkbox" id="table-5"
                                    <?= $this->input->get('tb5') == 5 ? 'checked':''?>
                                       value="5">
                                <label for="table-5"> Quận & Thành Viên </label>
                            </div>
                        </div>


                        <script>
                            commands.push(function () {
                                let current_url = '<?= $_SERVER['REQUEST_URI'] ?>';
                                let current_filter_time = '<?= $this->input->get("filterTime") ?>';
                                $('select[name=filterTime]').on('change', function () {
                                    let filterTime = $(this).val();
                                    let final_go_url = "";
                                    if(current_url.includes('booking?filterTime='+current_filter_time)) {
                                        final_go_url = current_url.replace('?filterTime='+current_filter_time, '?filterTime='+filterTime);
                                        window.location = final_go_url;
                                    } else {
                                        final_go_url = current_url.replace('&filterTime='+current_filter_time, '&filterTime='+filterTime);
                                        window.location = final_go_url;
                                    }
                                });


                                for(let i = 1; i <= 6; i++) {
                                    $('#table-'+i).click(function(){
                                        if($('#table-'+i).is(':checked')) {
                                            if(current_url.includes('?')) {
                                                window.location = current_url+'&tb'+i+'='+i;
                                            } else {
                                                window.location = current_url+'?tb'+i+'='+i;
                                            }
                                        } else {
                                            if(current_url.includes('tb'+i)) {
                                                if(current_url.includes('?tb'+i)) {
                                                    let final_url = current_url.replace('?tb'+i+'='+i,'');
                                                    if(final_url.includes('booking&')) {
                                                        final_url = final_url.replace('&', '?');
                                                    }
                                                    window.location = final_url;
                                                } else {
                                                    let final_url = current_url.replace('&tb'+i+'='+i,'');
                                                    if(final_url.includes('booking&')) {
                                                        final_url = final_url.replace('&', '?');
                                                    }
                                                    window.location = final_url;
                                                }
                                            }
                                        }
                                    });
                                }


                            });
                        </script>
                    <?php endif; ?>

                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card-box table-responsive shadow">
                    <h4>Mục Tiêu</h4>
                    <table class="table-hover table">
                        <thead class="thead-dark">
                        <tr>
                            <th>Thành Viên</th>
                            <th class="text-right">Mục Tiêu</th>
                        </tr>
                        </thead>

                        <?php foreach($list_target as $item): ?>
                            <tr>
                                <td><i class="mdi mdi-chevron-double-right text-danger"></i> <?= $libUser->getNameByAccountid($item['user_id']) ?></td>
                                <td class="text-right"><?= $item['target'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

            </div>
        </div>
        <?php if($this->input->get('tb1') == 1): ?>
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive shadow">
                    <h4>Lượt Dẫn: Bộ Phận Kinh Doanh</h4>
                    <table class=" table-data table table-bordered" style="font-size:12px">
                        <thead>
                        <tr>
                            <th>ID Lượt Book</th>
                            <th>Dự Án</th>
                            <th>Mã Phòng</th>
                            <th>Thời Gian Dẫn Khách</th>
                            <th>Thành Viên</th>
                            <th>Khách Được Dẫn</th>
                            <th>Ghi chú</th>
                            <th>Trạng Thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($list_booking) > 0): ?>
                        <?php foreach ($list_booking as $booking):
                                if(in_array($booking['booking_user_id'], $this->arr_general))
                                    continue;
                        $address = '';
                        $apmModel = $ghApartment->get(['id' => $booking['apartment_id']]);
                        if ($apmModel) {
                            $address = $apmModel[0]['address_street'];
                        }
                        $list_room_id = json_decode($booking['room_id'], true);
                        $text_room_code = '';

                        $js_list_room = implode(",", $list_room_id);
                        if ($list_room_id && count($list_room_id) > 0) {
                            foreach ($list_room_id as $room_id) {
                                $roomModel = $ghRoom->get(['id' => $room_id]);
                                $text_room_code .= $roomModel[0]['code'] . ' ';
                            }
                        }

                        $status = 'danger';
                        if ($booking['status'] == 'Success') {
                            $status = 'success';
                        }
                        if ($booking['status'] == 'Pending') {
                            $status = 'warning';
                        }
                        $hightlight = "";
                        if($booking['id'] == $list_booking[0]['id']) {
                            $hightlight = $flash_status;
                        }
                        ?>
                        <tr class="bg-<?= $hightlight ?>">
                            <td>#<?= 10000 + $booking['id'] ?>
                                <div class="font-weight-bold"><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></div>
                            </td>
                            <td><?= $address ?></td>
                            <td class="booking-room-code"
                                data-pk="<?= $booking['id'] ?>"
                                data-name="room_id"
                                data-value="<?= $js_list_room ?>"
                                data-apartment-id="<?= $booking['apartment_id'] ?>"
                            ><i class="text-success"><?= $text_room_code ?></i></td>
                            <td>
                                <div class="form-inline">
                                    <div class="booking-time_booking input-group"
                                         data-pk="<?= $booking['id'] ?>"
                                         data-name="time_booking"
                                         data-value="<?= date('d/m/Y H:i', $booking['time_booking']) ?>">
                                        <?= date('d/m/Y H:i', $booking['time_booking']) . ' - ' .$booking['time_booking'] ?>
                                    </div>
                                </div>

                            </td>
                            <td class="text-secondary"><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>
                            <td><?= $libCustomer->getNameById($booking['customer_id']) . ' - ' . $libCustomer->getPhoneById($booking['customer_id']) ?></td>
                            <td>
                                <div class="booking-note"
                                     data-pk="<?= $booking['id'] ?>"
                                     data-name="note"
                                     data-value="<?= $booking['note'] ?>"
                                >
                                <?= $booking['note'] ?></td>
                            <td>
                                <div class="booking-status text-<?= $status ?>"
                                     data-pk="<?= $booking['id'] ?>"
                                     data-name="status"
                                     data-value="<?= $booking['status'] ?>"
                                >
                                    <?= $label_apartment['booking.' . $booking['status']] ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($this->input->get('tb2') == 2): ?>
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive shadow">
                    <h4>Lượt Dẫn: Bộ Phận Vận Hành</h4>
                    <table class=" table-data table table-bordered" style="font-size:12px">
                        <thead>
                        <tr>
                            <th>ID Lượt Book</th>
                            <th>Dự Án</th>
                            <th>Mã Phòng</th>
                            <th>Thời Gian Dẫn Khách</th>
                            <th>Thành Viên</th>
                            <th>Khách Được Dẫn</th>
                            <th>Ghi chú</th>
                            <th>Trạng Thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($list_booking) > 0): ?>
                            <?php foreach ($list_booking as $booking):
                                if(!in_array($booking['booking_user_id'], $this->arr_general))
                                    continue;
                                $address = '';
                                $apmModel = $ghApartment->get(['id' => $booking['apartment_id']]);
                                if ($apmModel) {
                                    $address = $apmModel[0]['address_street'];
                                }
                                $list_room_id = json_decode($booking['room_id'], true);
                                $text_room_code = '';

                                $js_list_room = implode(",", $list_room_id);
                                if ($list_room_id && count($list_room_id) > 0) {
                                    foreach ($list_room_id as $room_id) {
                                        $roomModel = $ghRoom->get(['id' => $room_id]);
                                        $text_room_code .= $roomModel[0]['code'] . ' ';
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
                                    <td># <?= 10000 + $booking['id'] ?>
                                    <div class="font-weight-bold"><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></div>
                                    </td>
                                    <td><?= $address ?></td>
                                    <td class="booking-room-code"
                                        data-pk="<?= $booking['id'] ?>"
                                        data-name="room_id"
                                        data-value="<?= $js_list_room ?>"
                                        data-apartment-id="<?= $booking['apartment_id'] ?>"
                                    ><i class="text-success"><?= $text_room_code ?></i></td>
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
                                    <td class="text-secondary"><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>
                                    <td><?= $libCustomer->getNameById($booking['customer_id']) . ' - ' . $libCustomer->getPhoneById($booking['customer_id']) ?></td>
                                    <td>
                                        <div class="booking-note"
                                             data-pk="<?= $booking['id'] ?>"
                                             data-name="note"
                                             data-value="<?= $booking['note'] ?>"
                                        >
                                        <?= $booking['note'] ?></td>
                                    <td>
                                        <div class="booking-status text-<?= $status ?>"
                                             data-pk="<?= $booking['id'] ?>"
                                             data-name="status"
                                             data-value="<?= $booking['status'] ?>"
                                        >
                                            <?= $label_apartment['booking.' . $booking['status']] ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($this->input->get('tb3') == 3): ?>
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive shadow">
                    <h4 class="text-success">Thành Công</h4>
                    <table class=" table-data table table-bordered" style="font-size:12px">
                        <thead>
                        <tr>
                            <th>Dự Án</th>
                            <th>Mã Phòng</th>
                            <th>Thành viên</th>
                            <th>Thời Gian Dẫn Khách</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($list_booking) > 0): ?>
                            <?php foreach ($list_booking as $booking):
                                if ($booking['status'] !== 'Success') continue;

                                $arr_room_id = json_decode($booking['room_id'], true);
                                $text_detail_room_code = '';
                                foreach ($arr_room_id as $r_id) {
                                    $roomModel = $ghRoom->get(['id' => $r_id]);
                                    $text_detail_room_code .= $roomModel[0]['code'] . ' ';
                                }
                                $apmModel = $ghApartment->get(['id' => $booking['apartment_id']]);
                                ?>
                                <tr>
                                    <td><?= $apmModel['0']['address_street'] ?></td>
                                    <td><?= $text_detail_room_code ?></td>
                                    <td><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>
                                    <td>
                                        <div
                                                data-name="time_booking"
                                                data-pk="<?= $booking['id'] ?>"
                                                data-value="<?= date('d/m/Y H:i', $booking['time_booking'])
                                                ?>">
                                            <?= date('d/m/Y H:i', $booking['time_booking'])
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>


        <?php if($this->input->get('tb4') == 4): ?>
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive shadow">
                    <h4 class="text-danger">Boom</h4>
                    <table class=" table-data table table-bordered" style="font-size:12px">
                        <thead>
                        <tr>
                            <th>Dự Án</th>
                            <th>Mã Phòng</th>
                            <th>Thành viên</th>
                            <th>Thời Gian Dẫn Khách</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($list_booking) > 0): ?>
                            <?php foreach ($list_booking as $booking):
                                if ($booking['status'] !== 'Cancel') continue;

                                $arr_room_id = json_decode($booking['room_id'], true);
                                $text_detail_room_code = '';
                                foreach ($arr_room_id as $r_id) {
                                    $roomModel = $ghRoom->get(['id' => $r_id]);
                                    $text_detail_room_code .= $roomModel[0]['code'] . ' ';
                                }
                                $apmModel = $ghApartment->get(['id' => $booking['apartment_id']]);
                                ?>
                                <tr>
                                    <td><?= $apmModel['0']['address_street'] ?></td>
                                    <td><?= $text_detail_room_code ?></td>
                                    <td><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>
                                    <td><?= date('d/m/Y H:i', $booking['time_booking']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($this->input->get('tb5') == 5): ?>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card-box table-responsive shadow">
                    <h4>Quận</h4>
                    <table class=" table-data table ">
                        <thead>
                        <tr>
                            <th>Quận</th>
                            <th>Số Lượt</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($district_counter_booking) > 0): ?>
                            <?php foreach ($district_counter_booking as $d => $count):
                                ?>
                                <tr>
                                    <td>Quận <?= $libDistrict->getNameByCode($d) ?></td>
                                    <td><?= $count ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card-box table-responsive shadow">
                    <h4>Thành Viên</h4>
                    <table class=" table-data table table-bordered">
                        <thead>
                        <tr>
                            <th>Thành viên</th>
                            <th class="text-center">Số Lượt</th>
                            <th class="text-center text-success">Thành Công</th>
                            <th class="text-center text-danger">Boom</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($list_booking_groupby_user) > 0): ?>
                            <?php foreach ($list_booking_groupby_user as $booking):
                                ?>
                                <tr>
                                    <td><?= $libUser->getNameByAccountid($booking['booking_user_id']) ?></td>
                                    <td class="text-center"><?= $booking['counter'] ?></td>
                                    <td class="text-center text-success">
                                        <?php
                                        $turnSuccess =
                                            $ghConsultantBooking->getGroupByStatus
                                            ($time_from, $time_to, $booking['booking_user_id'], 'Success');
                                        ?>
                                        <?= $turnSuccess ? $turnSuccess[0]['counter'] : 0 ?>
                                    </td>
                                    <td class="text-center text-danger">
                                        <?php
                                        $turnSuccess =
                                            $ghConsultantBooking->getGroupByStatus
                                            ($time_from, $time_to, $booking['booking_user_id'], 'Cancel');
                                        ?>
                                        <?= $turnSuccess ? $turnSuccess[0]['counter'] : 0 ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>


<script>
    commands.push(function () {
        $(document).ready(function () {
            $('.table-data').DataTable({
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

        });
    });

</script>