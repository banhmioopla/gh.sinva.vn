<?php

$title_map = [
    'address_street' => 'địa chỉ',
    'address_ward'    => 'phường',
    'tag_id'    => 'tag',
    'description'    => 'mô tả',
    'active'    => 'Mở',
    'note'    => 'ghi chú: ',
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
    'status' => 'trạng thái',
    'time_update' => 'Tg. Cập nhật',
    'type' => 'Loại P'
];

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
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h3 class="page-title">Nhật Ký Dự Án</h3>
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
            <div class="timeline mt-md-2">

                <?php $alt = ''; foreach ($list_track as $row):

                    if($row['table_name'] != 'gh_apartment' && $row['table_name'] != 'gh_room') {
                        continue;
                    }

                    if($alt == 'alt')
                        $alt = '';
                    else {
                        $alt = 'alt';
                    }

                    $old_content = json_decode($row['old_content'], true);
                    $new_content = json_decode($row['modified_content'], true);
                    $diff = array_diff($old_content,$new_content);
                    $col = "";
                    $val = "";
                    $title = "";
                    foreach ($diff as $k => $v) {
                        $col = $k;
                        $val = $v;
                    }

                    if($row['table_name'] == 'gh_apartment') {
                        $title = $old_content['address_street'];
                    }

                    if($row['table_name'] == 'gh_room') {
                        $apartment_id = $old_content['apartment_id'];
                        $apm = $ghApartment->get(['id' => $apartment_id])[0];
                        $title = $apm['address_street'];

                    }
                    ?>
                    <article class="timeline-item <?= $alt ?>">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="timeline-box shadow">
                                    <span class="arrow-alt"></span>
                                    <span class="timeline-icon bg-danger"><i
                                                class="mdi mdi-adjust"></i></span>
                                    <h4 class="text-danger text-left">
                                        <?= $title ?>
                                    </h4>
                                    <p class="timeline-date text-left
                                    text-muted"><small><?= date('d/m/Y H:i', $row['time_insert'])
                                            ?> - <?= $libUser->getNameByAccountid($row['user_id']) ?></small></p>
                                    <hr>
                                    <div class="text-left">
                                        <?php foreach ($diff as $k => $v):
                                            $_old = $old_content[$k];
                                            $_new = $new_content[$k];
                                            if($k == 'time_update') {
                                                $_old = date('d/m/Y H:i', $old_content[$k]);
                                                $_new = date('d/m/Y H:i', $new_content[$k]);
                                            }

                                            ?>
                                            <strong><?= $title_map[$k] ?></strong><br>
                                            <ul>
                                                <li class="text-danger"><?=
                                                    $_old
                                                    ?></li>
                                                <li class="text-primary"><?=
                                                    $_new ?></li>
                                            </ul>
                                        <?php endforeach; ?></div>
                                </div>
                            </div>
                        </div>
                    </article>

                <?php endforeach; ?>

            </div>
        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
