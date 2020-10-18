<div class="table-responsive">
    <table id="list-room-<?= $apartment['id'] ?>" class="table list-room table-bordered ">
        <thead>
        <tr>
        <?php if($this->auth['role_code'] == 'customer-care'): ?>
            <th># ID</th>
        <?php endif; ?>
            <th>Mã Phòng</th>
            <th>Loại Phòng</th>
            <th>Giá</th>
            <th>Diện Tích</th>
            <th>Trạng Thái</th>
            <th>Ng.Trống</th>
            <!-- <th>Dẫn khách</th> -->
            <?php if($check_option):?>
            <th>Tùy chọn</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
            <?php $list_room = $libRoom->getByApartmentIdAndActive($apartment['id'])?>
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
                <?php if($this->auth['role_code'] == 'customer-care'): ?>
                    <td>
                        <div class="text-danger">
                            <?= $room['id'] ?>
                        </div>
                    </td>
                <?php endif; ?>
                    <td>
                        <div>
                            <?= $room['code'] ?>
                        </div>
                    </td>
                    <td><div><?= $room['type'] ?></div></td>
                    <td><div class="font-weight-bold"><?= money_format11($room['price'],1) ?></div></td>
                    <td><div><?= $room['area'] ?></div></td>
                    <td class="text-center font-weight-bold <?= $color_for_available ?>"><div><?= $room['status'] ? $label_apartment[$room['status']] : '#' ?></div></td>
                    <td><div class="text-success"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?></div></td>
                    <!-- <td><div><?//= $room['consulting_user_id'] ? $libUser->getNameByAccountid($room['consulting_user_id']) :'' ?></div></td> -->
                    <?php if($check_option):?>
                        <td class="d-flex flex-column flex-md-row justify-content-center">
                        <?php if($check_contract):?>
                        <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $room['id'] ?>">
                            <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 room-delete btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-file-document"></i>
                            </button>
                        </a>
                        <?php endif;?>

                        <?php if($check_consultant_booking):?>
                            <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 room-delete btn-sm btn-outline-success consultant-booking btn-rounded waves-light waves-effect">
                                <i class="mdi mdi-car-hatchback"></i>
                            </button>
                        <?php endif;?>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>