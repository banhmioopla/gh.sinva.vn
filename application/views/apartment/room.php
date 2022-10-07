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

<div class="table-responsive mt-3">
    <div><small class="text-info">Cột mã phòng hiển thị hợp đồng của cá nhân nếu có!!!</small></div>
    <table class="table list-room table-bordered ">
        <thead class="table-dark">
        <tr>
            <th class="text-center">MP</th>
            <th>Loại Phòng</th>
            <th>Giá <small>x1000</small></th>
            <th class="text-center">Diện Tích</th>
<!--            <th class="text-center d-none d-md-table-cell">Trống</th>-->
<!--            <th>Ngày Trống</th>-->
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

                $list_type_id = json_decode($room['room_type_id'], true);
                $js_list_type = "";
                $text_type_name = "";

                $type_arr = [];
                if($list_type_id) {
                    $js_list_type = implode(",", $list_type_id);
                    if ($list_type_id && count($list_type_id) > 0) {
                        foreach ($list_type_id as $type_id) {
                            $typeModel = $this->ghBaseRoomType->getFirstById($type_id);
                            $type_arr[]= $typeModel['name'];
                        }
                    }
                }
                $text_type_name = implode(", ",$type_arr );

                $status_txt = '<span class="badge badge-danger">Full</span>';
                if($room['status'] === 'Available'){
                    $status_txt = '<span class="badge badge-success">Trống</span>';
                }

                $personal_contract = $this->ghContract->get([
                        'consultant_id' => $this->auth['account_id'],
                        'room_id' => $room['id']
                ]);
                $personal_contract_txt = [];
                foreach ($personal_contract as $con){
                    $personal_contract_txt[] ="<div><small class='text-info' > <i class='mdi mdi-file-document'></i> Hđ hết hạn ".  date('d/m/Y', $con['time_expire']) . "</small></div>";
                }
                ?>

                <tr class='<?= $bg_for_available ?>'>
                    <td class="text-center">
                        <?= $room['code'] ?> <div class="d-block d-md-none"><?= $status_txt ?></div>
                        <?= implode('', $personal_contract_txt) ?>
                    </td>

                    <td><div><?= $text_type_name ?></div> <div class="text-primary"><?= !empty($room['type']) ? $room['type'] : '' ?></div></td>
                    <td><div class="font-weight-bold"><?= number_format($room['price']/1000) ?></div></td>
                    <td class="text-center"><?= $room['area'] ?></td>
<!--                    <td class="text-center d-none d-md-table-cell"><div>--><?//= $status_txt ?><!--</div></td>-->
<!--                    <td class="text-center">--><?//= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?><!--</td>-->
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