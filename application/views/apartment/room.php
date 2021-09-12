<?php

$list_room = $libRoom->getByApartmentIdAndActive($apartment['id']);
$list_room_no_shaft = [];
$is_no_shaft = false;
$list_shaft = $ghApartmentShaft->get(['apartment_id' => $apartment['id']]);
if(count($list_shaft)) {
    foreach ($list_room as $rrr) {
        if(empty($rrr['shaft_id'])) {
            $is_no_shaft = true;break;
        }
    }
}

$arr_room_id = [];
?>


<div id="list-room-<?= $apartment['id'] ?>">
<ul class="nav nav-tabs">
    <?php if($is_no_shaft):?>
        <li class="nav-item">
            <a href="#no-shaft-room-apm-<?= $apartment['id'] ?>" data-toggle="tab" aria-expanded="false" class="nav-link">
                <i class="mdi mdi-arrange-send-to-back"></i> [không trục]
            </a>
        </li>
    <?php endif;?>

<?php



$has_shaft = false;
if(count($list_shaft)):
    $has_shaft = true;

    foreach ($list_shaft as $shaft):
?>


    <li class="nav-item">
        <a href="#shaft-room-<?= $shaft['id'] ?>" data-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-arrange-send-to-back"></i> <?= $shaft['name'] ?>
        </a>
    </li>

<?php endforeach; ?>
<?php endif; // end sharf?>

</ul>




<?php if(!$has_shaft): ?>
<div class="table-responsive mt-3">
    <table class="table list-room table-bordered ">
        <thead class="table-dark">
        <tr>
            <th>Mã Phòng</th>
            <th>Loại Phòng</th>
            <th>Giá <small>x1000</small></th>
            <th>Diện Tích</th>
            <th>Trạng Thái</th>
            <th>Ng.Trống</th>
            <?php if($check_option):?>
            <th>Tùy chọn</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>

            <?php if(!empty($list_room)): ?>
                <?php foreach($list_room as $room): ?>
                    <?php

                        if($room['status'] == 'Available') {
                            $bg_for_available = 'bg-gh-apm-card';
                            $color_for_available = 'text-primary';
                        }
                        else {
                            $bg_for_available = '';
                            $color_for_available = '';
                        }   
                    ?>
                <tr class='<?= $bg_for_available ?>'>
                    <td>
                        <div>
                            <?= $room['code'] ?>
                        </div>
                    </td>
                    <?php
                    $list_type_id = json_decode($room['room_type_id'], true);
                    $js_list_type = "";
                    $text_type_name = "";

                    $type_arr = [];
                    if($list_type_id) {
                        $js_list_type = implode(",", $list_type_id);
                        if ($list_type_id && count($list_type_id) > 0) {
                            foreach ($list_type_id as $type_id) {
                                $typeModel = $ghBaseRoomType->getFirstById($type_id);
                                $type_arr[]= $typeModel['name'];
                            }
                        }
                    }
                    $text_type_name = implode(", ",$type_arr );

                    $status_txt = '<span class="badge badge-danger">Full</span>';
                    if($room['status'] === 'Available'){
                        $status_txt = '<span class="badge badge-success">Trống</span>';
                    }


                    ?>
                    <td><div><?= $text_type_name ?></div></td>
                    <td><div class="font-weight-bold"><?= number_format($room['price']/1000) ?></div></td>
                    <td><div><?= $room['area'] ?></div></td>
                    <td class="text-center"><div><?= $status_txt ?></div></td>
                    <td class="text-center"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?></td>
                    <?php if($check_option):?>
                        <td class="d-flex flex-column flex-md-row justify-content-center">
                        <?php if($check_contract):?>
                        <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $room['id'] ?>">
                            <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-file-document"></i>
                            </button>
                        </a>
                        <?php endif;?>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <div class="tab-content">
    <?php foreach ($list_shaft as $shaft):?>
        <div class="table-responsive mt-3 tab-pane" id="shaft-room-<?= $shaft['id'] ?>">
            <h3><?= strtoupper($shaft['name']) ?> </h3>
            <table class="table list-room table-bordered ">
                <thead class="table-dark">
                <tr>
                    <th>Mã Phòng</th>
                    <th>Loại Phòng</th>
                    <th>Giá <small>x1000</small></th>
                    <th>Diện Tích</th>
                    <th>Trạng Thái</th>
                    <th>Ng.Trống</th>
                    <?php if($check_option):?>
                        <th>Tùy chọn</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>

                <?php if(!empty($list_room)): ?>
                    <?php foreach($list_room as $room): ?>
                        <?php
                        if(empty($room['shaft_id'])){
                            if(!in_array($room['id'], $arr_room_id))
                            $list_room_no_shaft[] = $room;
                            $arr_room_id[] = $room['id'];
                            continue;
                        }
                        if($room['shaft_id'] > 0) {
                            if(!($shaft['id'] == $room['shaft_id'])) {
                                continue;
                            }
                        }

                        if($room['status'] == 'Available') {
                            $bg_for_available = 'bg-gh-apm-card';
                            $color_for_available = 'text-primary';
                        }
                        else {
                            $bg_for_available = '';
                            $color_for_available = '';
                        }
                        ?>
                        <tr class='<?= $bg_for_available ?>'>
                            <td>
                                <div>
                                    <?= $room['code'] ?>
                                </div>
                            </td>
                            <?php
                            $list_type_id = json_decode($room['room_type_id'], true);
                            $js_list_type = "";
                            $text_type_name = "";

                            $type_arr = [];
                            if($list_type_id) {
                                $js_list_type = implode(",", $list_type_id);
                                if ($list_type_id && count($list_type_id) > 0) {
                                    foreach ($list_type_id as $type_id) {
                                        $typeModel = $ghBaseRoomType->getFirstById($type_id);
                                        $type_arr[]= $typeModel['name'];
                                    }
                                }
                            }
                            $text_type_name = implode(", ",$type_arr );

                            $status_txt = '<span class="badge badge-danger">Full</span>';
                            if($room['status'] === 'Available'){
                                $status_txt = '<span class="badge badge-success">Trống</span>';
                            }
                            ?>
                            <td><div><?= $text_type_name ?></div></td>
                            <td><div class="font-weight-bold"><?= number_format($room['price']/1000) ?></div></td>
                            <td><div><?= $room['area'] ?></div></td>
                            <td class="text-center"><div><?= $status_txt ?></div></td>
                            <td class="text-center"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?></td>
                            <?php if($check_option):?>
                                <td class="d-flex flex-column flex-md-row justify-content-center">
                                    <?php if($check_contract):?>
                                        <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $room['id'] ?>">
                                            <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                                <i class="mdi mdi-file-document"></i>
                                            </button>
                                        </a>
                                    <?php endif;?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

        <div class="table-responsive mt-3 tab-pane" id="no-shaft-room-apm-<?= $apartment['id'] ?>">
            <h3>Không có trục</h3>
            <table class="table list-room table-bordered ">
                <thead class="table-dark">
                <tr>
                    <th>Mã Phòng</th>
                    <th>Loại Phòng</th>
                    <th>Giá <small>x1000</small></th>
                    <th>Diện Tích</th>
                    <th>Trạng Thái</th>
                    <th>Ng.Trống</th>
                    <?php if($check_option):?>
                        <th>Tùy chọn</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list_room_no_shaft as $room): ?>
                    <?php

                    if($room['status'] == 'Available') {
                        $bg_for_available = 'bg-gh-apm-card';
                        $color_for_available = 'text-primary';
                    }
                    else {
                        $bg_for_available = '';
                        $color_for_available = '';
                    }
                    ?>
                    <tr class='<?= $bg_for_available ?>'>
                        <td>
                            <div>
                                <?= $room['code'] ?>
                            </div>
                        </td>
                        <?php
                        $list_type_id = json_decode($room['room_type_id'], true);
                        $js_list_type = "";
                        $text_type_name = "";

                        $type_arr = [];
                        if($list_type_id) {
                            $js_list_type = implode(",", $list_type_id);
                            if ($list_type_id && count($list_type_id) > 0) {
                                foreach ($list_type_id as $type_id) {
                                    $typeModel = $ghBaseRoomType->getFirstById($type_id);
                                    $type_arr[]= $typeModel['name'];
                                }
                            }
                        }
                        $text_type_name = implode(", ",$type_arr );

                        $status_txt = '<span class="badge badge-danger">Full</span>';
                        if($room['status'] === 'Available'){
                            $status_txt = '<span class="badge badge-success">Trống</span>';
                        }
                        ?>
                        <td><div><?= $text_type_name ?></div></td>
                        <td><div class="font-weight-bold"><?= number_format($room['price']/1000) ?></div></td>
                        <td><div><?= $room['area'] ?></div></td>
                        <td class="text-center"><div><?= $status_txt ?></div></td>
                        <td class="text-center"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?></td>
                        <?php if($check_option):?>
                            <td class="d-flex flex-column flex-md-row justify-content-center">
                                <?php if($check_contract):?>
                                    <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $room['id'] ?>">
                                        <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                            <i class="mdi mdi-file-document"></i>
                                        </button>
                                    </a>
                                <?php endif;?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>


    </div>
<?php endif; ?>

</div>
