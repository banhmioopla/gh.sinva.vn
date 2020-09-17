<div class="table-responsive">
    <div class="d-flex justify-content-center">
        <button type="button" 
            data-apartment-id = "<?= $apartment['id'] ?>"
            class="btn m-1 btn-sm room-add btn-outline-success btn-rounded waves-light waves-effect">
            <i class="mdi mdi-credit-card-plus"></i>
        </button>
    </div>
    <table id="list-room-<?= $apartment['id'] ?>" class="table list-room table-bordered ">
        <thead>
        <tr>
            <th>Mã Phòng</th>
            <th>Loại Phòng</th>
            <th>Giá</th>
            <th>Diện Tích</th>
            <th>Trạng Thái</th>
            <th>Ng.Trống</th>
            <!-- <th>Dẫn khách</th> -->
            <th>Tùy Chọn</th>
        </tr>
        </thead>
        <tbody>
            <?php $list_room = $libRoom->getByApartmentIdAndActive($apartment['id'])?>
            <?php if(!empty($list_room)): ?>
                <?php foreach($list_room as $room): ?>
                <tr>
                    <td><div class="room-data" 
                            data-pk="<?= $room['id'] ?>"
                            data-value="<?= $room['code'] ?>"
                            data-name="code"
                            ><?= $room['code'] ? $room['code'] : '#' ?></div>
                            </td>
                    <td><div class="room-data" 
                            data-pk="<?= $room['id'] ?>"
                            data-value="<?= $room['type'] ?>"
                            data-name="type"
                            ><?= $room['type'] ? $room['type']: '#' ?></div></td>
                    <td><div class="room-price text-success" 
                            data-pk="<?= $room['id'] ?>"
                            data-value="<?= $room['price'] ?>"
                            data-name="price"><?= $room['price'] ? money_format11($room['price'],1): '#' ?></div></td>
                    <td><div class="room-area" 
                            data-pk= "<?= $room['id'] ?>"
                            data-value= "<?= $room['area'] ?>"
                            data-name="area"><?= $room['area'] > 0 ? $room['area']: '#' ?></div></td>
                    <td><div class="room-status text-primary" 
                            data-id="<?= $room['id'] ?>">
                            <?= $room['status'] ? $label_apartment[$room['status']] : '#' ?></div></td>
                    <td><div class="room-time_available text-success" 
                            data-pk="<?= $room['id'] ?>"
                            data-value="<?= date('d-m-Y',$room['time_available']) ?>"
                            data-name="time_available"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'#' ?></div></td>
                    <!-- <td><div class="room-consulting_user_id" 
                            data-pk="<?= $room['id'] ?>"
                            data-value="<?= $room['consulting_user_id'] ?>"
                            data-name="consulting_user_id"><?= $room['consulting_user_id'] ? $libUser->getNameByAccountid($room['consulting_user_id']) :'#' ?></div></td> -->
                    <td class="d-flex justify-content-center">
                        <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 room-delete btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>