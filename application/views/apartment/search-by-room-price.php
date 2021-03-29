<?php if(isYourPermission('Apartment', 'showBySearch',$this->permission_set)):?>
<div class="card-box">
            <span id="listPrice">
                <span class="form-group row">
                    <span class="col-md-2 col-12 offset-0">
                        <div>Quận</div>
                        <select name="roomDistrict" id="roomDistrict" class="form-control">
                            <?php foreach ($list_district as $d):
                                $selected = "";
                                if($d['code'] == $this->input->get('roomDistrict')) {
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?= $d['code'] ?>" <?= $selected ?>><?= $d['name']
                                    ?></option>
                            <?php endforeach; ?>
                        </select>
                    </span>

                    <span class="col-md-2 col-12 offset-0">
                        <div>Loại Phòng</div>
                        <select name="roomType" id="roomType" class="form-control">
                            <option value="">Loại Phòng</option>
                            <?php foreach ($list_type as $d):
                                $selected = "";
                                if($this->input->get('roomType') == $d['room_type']) {
                                    $selected = "selected";
                                }


                                ?>
                                <option value="<?= $d['room_type'] ?>" <?= $selected ?>><?= $d['room_type'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </span>
                    <span class="col-md-2 col-12 offset-0">
                        <div>Giá Min</div>
                        <select name="roomPriceMin" id="roomPriceMin" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPriceMin'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-2 d-none col-12 offset-0">
                        <div>Giá Max</div>
                        <select name="roomPriceMax" id="roomPriceMax" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPriceMax'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-2 d-none col-12 offset-0">
                        <div>DT Min</div>
                        <select name="roomAreaMin" id="roomAreaMin" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomArea($this->input->get('roomAreaMin'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-2 col-12 offset-0">
                        <div>DT Max</div>
                        <select name="roomAreaMax" id="roomAreaMax" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomArea($this->input->get('roomAreaMax'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-2 col-12 offset-0">
                        <div>Trạng Thái </div>
                        <select name="roomStatus" id="roomStatus" class="form-control">
                            <option value="">Vui Lòng Chọn</option>
                            <option value="Available">Trống</option>
                            <option value="Full">Full</option>
                        </select>
                    </span>

                    <span class="col-md-2 col-12 offset-0">
                        <div>Thời Gian Trống</div>
                        <select name="roomTimeAvailable" id="roomTimeAvailable" class="form-control">
                            <option value="">Trống từ ngày ...</option>
                            <?php for($i = 1; $i <= 12; $i++):
                                $selected = "";
                                if($this->input->get('roomTimeAvailable') == "01-".$i."-2021") {
                                    $selected = "selected";
                                }
                                ?>
                                <option <?= $selected ?> value="01-<?= $i ?>-2021"> 1 - <?= $i?> - 2021</option>
                            <?php endfor;?>
                        </select>
                    </span>

                    <span class="col-md-4 offset-md-4 mt-3 col-12 offset-0">
                        <button id="search" class="btn btn-danger w-100">Tìm Dự
                            Án</button>
                    </span>
                </span>

            </span>

</div>

<script>
    commands.push(function(){
        $('#search').on('click', function(){
            window.location = '/admin/apartment/show-by-search?roomPriceMin='
                + $('#roomPriceMin').val()
                + '&roomPriceMax=' + $('#roomPriceMax').val()
                + '&roomAreaMin=' + $('#roomAreaMin').val()
                + '&roomAreaMax=' + $('#roomAreaMax').val()
                + '&roomDistrict=' + $('#roomDistrict').val()
                + '&roomType=' + $('#roomType').val()
                + '&roomTimeAvailable=' + $('#roomTimeAvailable').val()
                + '&roomStatus=' + $('#roomStatus').val()
            ;
        })
    });
</script>

<?php endif; ?>