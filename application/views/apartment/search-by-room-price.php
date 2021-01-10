<?php if(isYourPermission('Apartment', 'showBySearch',$this->permission_set)):?>
<div class="card-box">
            <h4 class="text-danger text-center" >Tìm kiếm phòng đang trống</h4>
            <span id="listPrice">
                <span class="form-group row">
                    <span class="col-md-3 col-12 offset-0">
                        <div>Chọn Khoảng Giá Min</div>
                        <select name="roomPriceMin" id="roomPriceMin" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPriceMin'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-3 col-12 offset-0">
                        <div>Chọn Khoảng Giá Max</div>
                        <select name="roomPriceMax" id="roomPriceMax" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPriceMax'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-3 col-12 offset-0">
                        <div>Chọn Khoảng DT Min</div>
                        <select name="roomAreaMin" id="roomAreaMin" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomArea($this->input->get('roomAreaMin'))
                            ?>
                        </select>
                    </span>
                    <span class="col-md-3 col-12 offset-0">
                        <div>Chọn Khoảng DT Max</div>
                        <select name="roomAreaMax" id="roomAreaMax" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomArea($this->input->get('roomAreaMax'))
                            ?>
                        </select>
                    </span>

                    <span class="col-md-4 offset-md-4 mt-3 col-12 offset-0">
                        <button id="search" class="btn btn-warning w-100">Tìm Dự
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
            ;
        })
    });
</script>

<?php endif; ?>