<?php if(isYourPermission('Apartment', 'showBySearch',$this->permission_set)):?>
<div id="listPrice" class="card-box mb-1 mt-1">
    <h4 class="text-danger font-weight-bold">Tìm Dự Án</h4>
    <div class="form-group row">
        <span class="col-md-4 col-6 mb-2">
            <strong>Quận</strong>
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

        <div class="col-md-4 col-6 mb-2">
            <strong>Phường</strong>
            <select name="roomWard" id="roomWard" class="form-control">
                <option value="">Phường...</option>
                <?php foreach ($list_ward as $d):
                    $selected = "";
                    if($d['address_ward'] == $this->input->get('roomWard')) {
                        $selected = "selected";
                    }
                    ?>
                    <option value="<?= $d['address_ward'] ?>" <?= $selected ?>>Ph. <?= $d['address_ward']
                        ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4 col-12 offset-0 mb-2">
            <strong>Loại Phòng</strong>
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
        </div>
        <div class="col-md-3 col-6 mb-2">
            <strong>Giá Min</strong>
            <select name="roomPriceMin" id="roomPriceMin" class="form-control">
                <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPriceMin'))
                ?>
            </select>
        </div>
        <div class="col-md-3 col-6 mb-2">
            <strong>Giá Max</strong>
            <select name="roomPriceMax" id="roomPriceMax" class="form-control">
                <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPriceMax'))
                ?>
            </select>
        </div>

        <span class="col-md-3 col-6 offset-0 mb-2">
            <strong>Trạng Thái </strong>
            <select name="roomStatus" id="roomStatus" class="form-control">
                <option value="">Vui Lòng Chọn</option>
                <option value="Available" <?= $this->input->get('roomStatus') == 'Available' ? 'selected' :'' ?>>Trống</option>
                <option value="Full" <?= $this->input->get('roomStatus') == 'Full' ? 'selected' :'' ?>>Full</option>
            </select>
        </span>

        <span class="col-md-3 col-6 offset-0 mb-2">
            <strong>Thời Gian Trống</strong>
            <select name="roomTimeAvailable" id="roomTimeAvailable" class="form-control">
                <option value="">Trống từ ngày ...</option>
                <?php for($i = 1; $i <= 12; $i++):
                    $selected = "";
                    if($this->input->get('roomTimeAvailable') == "01-".$i."-2021") {
                        $selected = "selected";
                    }
                    ?>
                    <option <?= $selected ?> value="01-<?= $i ?>-2021"> 01/<?= str_pad($i,2,'0',STR_PAD_LEFT)?>/2021</option>
                <?php endfor;?>
            </select>
        </span>

        <span class="col-md-3 col-6 offset-0 mb-2">
            <strong>Kỳ hạn hợp đồng</strong>
            <select name="contractTerm" id="contractTerm" class="form-control">
                <option value="">Vui Lòng Chọn</option>
                <option value="long" <?= $this->input->get('contractTerm') == 'long' ? 'selected' :'' ?>>Dài hạn</option>
                <option value="short" <?= $this->input->get('contractTerm') == 'short' ? 'selected' :'' ?>>Ngắn hạn</option>
            </select>
        </span>

        <span class="col-md-3 col-6 offset-0 mb-2">
            <strong>24h - Giá P | Mô tả | Ưu đãi</strong>
            <select name="inUpdate24h" id="inUpdate24h" class="form-control">
                <option value="">Vui Lòng Chọn</option>
                <option value="true" <?= $this->input->get('inUpdate24h') == 'true' ? 'selected' :'' ?>>24h - Giá P | Mô tả | Ưu đãi</option>
            </select>
        </span>

    </div>

    <div class="form-group row">
        <span class="col-md mt-3 col-12 offset-0  text-center">
            <button id="search" class="btn btn-danger">Tìm Dự Án</button>
        </span>
    </div>
</div>
<script>
    commands.push(function(){
        $('#search').on('click', function(){
            window.location = '/admin/apartment/show-by-search?roomPriceMin='
                + $('#roomPriceMin').val()
                + '&roomPriceMax=' + $('#roomPriceMax').val()
                + '&roomDistrict=' + $('#roomDistrict').val()
                + '&roomType=' + $('#roomType').val()
                + '&roomTimeAvailable=' + $('#roomTimeAvailable').val()
                + '&roomStatus=' + $('#roomStatus').val()
                + '&roomWard=' + $('#roomWard').val()
                + '&contractTerm=' + $('#contractTerm').val()
                + '&inUpdate24h=' + $('#inUpdate24h').val()
            ;
        });
        $('#roomDistrict').change(function () {
            let district = $(this).val();
            $.ajax({
                url: '/admin/apartment-get-ward',
                method: "POST",
                data: {district:district},
                success:function (response) {
                    let html = "<option value=''>Chọn phường...</option>";
                    if(response.length) {
                        response = JSON.parse(response);
                        for(let i of response) {
                            html += "<option value='"+i.value+"'>"+i.text+"</option>";
                        }
                        $('#roomWard').html(html);
                    }

                }
            });
        });
    });
</script>

<?php endif; ?>