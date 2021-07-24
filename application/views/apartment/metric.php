
<dl class="card-box">
    <h3 class="font-weight-bold text-danger">Dự Án Q. <?= $libDistrict->getNameByCode($district_code) ?></h3>
    <hr>
    <div class="row text-info font-weight-bold">
        <dt class="col-6"> <i class="mdi mdi-chevron-double-right"></i> Dự Án</dt>
        <dd class="col-6 text-right"><?= number_format($product_total) ?></dd>

        <dt class="col-6"> <i class="mdi mdi-chevron-double-right"></i> Phòng</dt>
        <dd class="col-6 text-right"><?= number_format($room_total) ?></dd>

        <dt class="col-6"> <i class="mdi mdi-chevron-double-right"></i> Phòng Trống</dt>
        <dd class="col-6 text-right"><?= number_format($available_room_total) ?></dd>

        <dt class="col-6"> <i class="mdi mdi-chevron-double-right"></i> Phòng Sắp Trống</dt>
        <dd class="col-6 text-right"><?= number_format($ready_room_total) ?></dd>
    </div>

</dl>

<div class="card-box">
    <h3 class="font-weight-bold text-danger">Phòng Trống</h3>
    <hr>
    <?php if($list_available_room_price): ?>
            <?php
            foreach($list_available_room_price as $room):
                ?>
                <span class="m-1 badge badge-success badge-pill"><a class="text-light" href="/admin/apartment/show-by-search?roomPriceMin=<?= $room['room_price'] ?>&roomDistrict=<?= $this->input->get('district-code') ?>"><?= strip_tags(number_format($room['room_price']))?> | <?= $room['object_counter'] ?> P</a> </span>
            <?php
            endforeach;
            ?>
    <?php endif; ?>
    <hr>
    <?php if($list_available_room_type):?>
        <?php
        foreach($list_available_room_type as $room):
            ?>
            <span style="font-size:85%" class="m-1 badge badge-success badge-pill"><a class="text-light" href="/admin/apartment/show-by-search?&roomType=<?= strip_tags(($room['room_type']))?>&roomDistrict=<?= $this->input->get('district-code') ?>"><?= strip_tags(($room['room_type']))?> | <?= $room['object_counter'] ?> P</a> </span>
        <?php
        endforeach;
        ?>
    <?php endif; ?>
</div>

<div class="card-box">
    <h3 class="font-weight-bold text-danger">Phòng Sắp Trống</h3>
    <hr>
    <?php if($list_ready_room_type):?>
        <?php
        foreach($list_ready_room_type as $room):
            ?>
            <span class="m-1 badge badge-warning badge-pill"><a class="text-light" href="/admin/apartment/show-by-search?&roomType=<?= strip_tags(($room['room_type']))?>&roomDistrict=<?= $this->input->get('district-code') ?>"><?= strip_tags(($room['room_type']))?> | <?= $room['object_counter'] ?> P</a> </span>
        <?php
        endforeach;
        ?>
    <?php endif; ?>
</div>

