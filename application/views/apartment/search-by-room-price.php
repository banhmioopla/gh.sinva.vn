<div class="m-md-2 m-1 button-list">
    <?php if(isYourPermission('Apartment', 'showBySearch',$this->permission_set)):?>
            <h4 class="text-danger text-center" data-toggle="collapse" data-target="#listPrice">Tìm kiếm phòng đang trống</h4>
            <p class="text-center">click vào tiêu đề màu đỏ để hiển thị danh sách giá phòng</p>
            <span id="listPrice" class="collapse">
                <?php foreach ($list_price as $item): ?>

                    <a href="<?= base_url() ?>admin/apartment/show-by-search?roomPrice=<?= $item['room_price'] ?>">
                        <button type="button" class="btn btn-success waves-effect waves-light"> <span><?= number_format($item['room_price']) ?></span> </button>
                    </a>

                <?php endforeach;?>
            </span>



    <?php endif; ?>

</div>