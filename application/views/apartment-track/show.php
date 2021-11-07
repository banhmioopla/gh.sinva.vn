<?php

$title_map = [
    'address_street' => 'địa chỉ',
    'address_ward'    => 'phường',
    'tag_id'    => 'tag',
    'description'    => 'mô tả',
    'active'    => 'Mở',
    'google_map'    => 'tọa độ',
    'electricity'    => 'điện',
    'water'    => 'nước',
    'internet'    => 'internet',
    'elevator'    => 'thang máy',
    'washing_machine'    => 'máy giặt',
    'room_cleaning'    => 'dọn phòng',
    'parking'    => 'đỗ xe',
    'commission'    => 'hoa hồng',
    'deposit'    => 'cọc',
    'number_of_people'    => 'số người ở',
    'kitchen'    => 'bếp',
    'car_park'    => 'bãi ô tô',
    'direction'    => 'hướng',
    'kt3'    => 'KT3',
    'status' => 'trạng thái',
    'time_update' => 'Tg. Cập nhật',
    'type' => 'loại phòng',
    'price' => 'giá',
    'Available' => "trống",
    'Full' => "full",
    'area' => 'diện tích',
    'code' => 'mã phòng',
    'pet' => 'pet',
    'extra_fee' => 'phí phụ',
    'security' => 'bảo vệ',
    'contract_long_term' => 'HD dài hạn',
    'contract_short_term' => 'HD ngắn hạn',
    'number_of_floor' => 'Số Lầu',
    'commission_rate' => 'HH 12th',
    'commission_rate_6m' => 'HH 6th',
    'commission_rate_9m' => 'HH 9th',
    'map_longitude' => ' Tọa độ 1',
    'map_latitude' => ' Tọa độ 2',
    'note' => 'ghi chú',
    'time_available' => 'ngày sắp trống',
    'user_collected_id' => 'QLDA',
];

$action_map = [
    "update" => "sửa",
    "create" => "thêm mới",
]

?>

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
            <div class="col-12">
                <div class="card-box">
                    <h2 class="page-title">Nhật Ký Dự Án</h2>
                <table class="table">
                    <thead>
                    <th>Ngày</th>
                    <th>Thành Viên</th>
                    <th>Hành Vi</th>
                    <th>Cũ</th>
                    <th>Mới</th>
                    </thead>
                    <tbody>
                    <?php foreach ($list_track as $row):?>

                        <?php
                        if($row['table_name'] != 'gh_apartment' && $row['table_name'] != 'gh_room') {
                            continue;
                        }

                        $old_content = json_decode($row['old_content'], true);
                        $new_content = json_decode($row['modified_content'], true);
                        $diff = array_diff_assoc($new_content,$old_content);
                        $col = "";
                        $val = "";
                        $title = "";

                        if($row['table_name'] == 'gh_apartment') {
                            $title = "DA: " . $old_content['address_street'];
                        }

                        if($row['table_name'] == 'gh_room') {
                            $apartment_id = $old_content['apartment_id'];
                            $apm = $ghApartment->get(['id' => $apartment_id])[0];
                            $title = "DA: " . $apm['address_street']. ' | Mã ' . $old_content['code'];

                        }

                        $timeline_icon_bg = 'bg-danger';
                        if($row['time_insert'] > strtotime('today')) {
                            $timeline_icon_bg = 'bg-warning';
                        } ?>

                    <?php
                        $content_des = "";
                        $content_old = "";
                        $content_new = "";
                        foreach ($diff as $k => $v):
                            $_old = $old_content[$k];
                            $_new = $new_content[$k];
                            if($k == 'time_update') {
                                continue;
                            }
                            if($k == 'time_available') {
                                $_old = $old_content[$k] > 0 ? date('d/m/Y H:i', $old_content[$k]) : '';
                                $_new = date('d/m/Y H:i', $new_content[$k]);
                            }

                            if($k == "user_collected_id") {
                                $_old = $this->ghUser->getFirstByAccountId($old_content[$k])['name'];
                                $_new = $this->ghUser->getFirstByAccountId($new_content[$k])['name'];
                            }

                            if($k == 'price') {
                                $_old = number_format($old_content[$k]);
                                $_new = number_format($new_content[$k]);
                            }

                            if($k == 'status') {
                                $_old = $title_map[$old_content[$k]];
                                $_new = $title_map[$new_content[$k]];
                            }
                            $content_des .= '<span class="badge badge-primary mr-1">';
                            $content_des .= isset($action_map[$row["action"]]) ? $action_map[$row["action"]]." " : '[rỗng]';
                            $content_des .= isset($title_map[$k]) ? $title_map[$k] : '[rỗng]';
                            $content_des .= '</span>';

                            $content_old .= isset($title_map[$k]) ? "<div><strong class='text-danger'>".$title_map[$k]."</strong></div>" : '[rỗng]';
                            $content_old .= !empty($_old) ? "<div>".$_old."</div>" : "[rỗng]";

                            $content_new .= isset($title_map[$k]) ? "<div><strong class='text-danger'>".$title_map[$k]."</strong></div>" : '[rỗng]';
                            $content_new .= !empty($_new) ? "<div>".$_new."</div>" : "[rỗng]";
                        ?>
                        <?php endforeach;?>
                        <tr>
                            <td><?= date('d/m/Y H:i', $row['time_insert']) ?></td>
                            <td><?= $libUser->getNameByAccountid($row['user_id']) ?></td>
                            <td><?= $title ?> <br> <?= $content_des ?></td>
                            <td><?= $content_old ?></td>
                            <td><?= $content_new ?></td>
                        </tr>

                    <?php endforeach;?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
