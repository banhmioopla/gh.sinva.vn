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
            <?php if($this->auth['role_code'] == 'customer-care'):?>
            <th>Tùy chọn</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
            <?php $list_room = $libRoom->getByApartmentIdAndActive($apartment['id'])?>
            <?php if(!empty($list_room)): ?>
                <?php foreach($list_room as $room): ?>
                <tr>
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
                    <td><div class="text-success"><?= money_format11($room['price'],1) ?></div></td>
                    <td><div><?= $room['area'] ?></div></td>
                    <td class="text-center"><div><?= $room['status'] ? $label_apartment[$room['status']] : '#' ?></div></td>
                    <td><div class="text-success"><?= $room['time_available'] ? date('d-m-Y',$room['time_available']) :'' ?></div></td>
                    <!-- <td><div><?//= $room['consulting_user_id'] ? $libUser->getNameByAccountid($room['consulting_user_id']) :'' ?></div></td> -->
                    <?php if($this->auth['role_code'] == 'customer-care'):?>
                        <td class="d-flex justify-content-center">
                        <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $room['id'] ?>">
                            <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 room-delete btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                +<i class="mdi mdi-note-plus-outline"></i>
                            </button>
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>