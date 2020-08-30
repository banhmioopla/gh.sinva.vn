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
        </tr>
        </thead>
        <tbody>
            <?php $list_room = $libRoom->getByApartmentIdAndActive($apartment['id'])?>
            <?php if(!empty($list_room)): ?>
                <?php foreach($list_room as $room): ?>
                <tr>
                    <td><div><?= $room['code'] ?></div></td>
                    <td><div><?= $room['type'] ?></div></td>
                    <td><div class="text-success"><?= $room['price'] ?></div></td>
                    <td><div><?= $room['temp_price'] ?></div></td>
                    <td><div><?= $room['area'] ?></div></td>
                    <td class="text-center"><div><?= $room['status'] ? $label_apartment[$room['status']] : '#' ?></div></td>
                    <td><div class="text-success"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?></div></td>
                    <td><div class="text-success"><?= $room['temp_time_checkout'] ? date('d-m-Y',$room['temp_time_checkout']) :'' ?></div></td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>