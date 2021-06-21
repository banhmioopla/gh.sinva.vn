<div class="table-responsive">
    <table id="list-room-<?= $apartment['id'] ?>" class="table list-room table-bordered ">
        <thead class="table-dark">
        <tr>
        <?php if($this->auth['role_code'] == 'customer-care'): ?>
            <th># ID</th>
        <?php endif; ?>
            <th>Mã Phòng</th>
            <th>Loại Phòng</th>
            <th>Giá <small>x1000</small></th>
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
                    <!-- <td><div><?//= $room['consulting_user_id'] ? $libUser->getNameByAccountid($room['consulting_user_id']) :'' ?></div></td> -->
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