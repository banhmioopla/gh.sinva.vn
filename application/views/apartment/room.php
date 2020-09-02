<div class="table-responsive">
    <table id="list-room-<?= $apartment['id'] ?>" class="table list-room table-bordered ">
        <thead>
        <tr>
            <th>Mã Phòng</th>
            <th>Loại Phòng</th>
            <th>Giá</th>
            <th>Giá*</th>
            <th>Diện Tích</th>
            <th>Trạng Thái</th>
            <th>Ng.Trống</th>
            <th>Ng.Trống*</th>
            <th>Dẫn khách</th>
        </tr>
        </thead>
        <tbody>
            <?php $list_room = $libRoom->getByApartmentIdAndActive($apartment['id'])?>
            <?php if(!empty($list_room)): ?>
                <?php foreach($list_room as $room): ?>
                <tr>
                    <td>
                        <div>
                            <?= $room['code'] ?>
                        </div>
                        <hr>
                            <i class="room-time_update text-warning font-weight-bold">
                                <?= $room['time_update'] ? date('d/m/Y H:m',$room['time_update']):'' ?>
                            </i>
                    </td>
                    <td><div><?= $room['type'] ?></div></td>
                    <td><div class="text-success"><?= money_format11($room['price'],1) ?></div></td>
                    <td><div><?= $room['temp_price'] ?></div></td>
                    <td><div><?= $room['area'] ?></div></td>
                    <td class="text-center"><div><?= $room['status'] ? $label_apartment[$room['status']] : '#' ?></div></td>
                    <td><div class="text-success"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?></div></td>
                    <td><div class="text-success"><?= $room['temp_time_checkout'] ? $room['temp_time_checkout'] :'' ?></div></td>
                    <td><div class="text-success"><?= $room['consulting_user_id'] ? $libUser->getNameByAccountid($room['consulting_user_id']) :'' ?></div></td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>