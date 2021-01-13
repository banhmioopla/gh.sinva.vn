<?php if(isYourPermission('Apartment', 'showBySearch',$this->permission_set)):?>
<div class="card-box">
            <span id="listPrice">
                <span class="form-group row">
                    <span class="col-md-4 col-12 offset-0">
                        <div>Quận</div>
                        <select name="roomDistrict" id="roomDistrict" class="form-control">
                            <?php foreach ($list_district as $d): ?>
                                <option value="<?= $d['code'] ?>"><?= $d['name'] ?></option>
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
                    <span class="col-md-2 col-12 offset-0">
                        <div>Giá Max</div>
                        <select name="roomPriceMax" id="roomPriceMax" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPriceMax'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-2 col-12 offset-0">
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
            ;
        })
    });
</script>

<?php endif; ?>