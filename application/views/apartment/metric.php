<div class="card-box tilebox-one">
    <i class="icon-rocket float-right text-muted"></i>
    <h4 class="m-b-20" ><?= number_format($product_total) ?> dự án</h4>
</div>

<div class="card-box tilebox-one">
    <i class="icon-ghost float-right text-muted"></i>
    <h4 class="m-b-20" ><?= number_format($room_total) ?> phòng</h4>
</div>

<div class="card-box tilebox-one">
    <i class="icon-grid float-right text-success"></i>
    <h4 class="m-b-20 text-success" ><?= number_format($available_room_total) ?> phòng trống</h4>
</div>

<div class="card-box tilebox-one">
    <i class=" icon-flag float-right text-warning"></i>
    <h4 class="m-b-20 text-warning" ><?= number_format($ready_room_total) ?> phòng sắp trống</h4>
</div>

<?php if($list_available_room_type):?>
    <div class="card-box tilebox-one">
        <i class="mdi mdi-cat float-right text-success"></i>
        <ul class="font-weight-bold">
            <?php 
                foreach($list_available_room_type as $room): 
            ?>
            <li class="m-b-20 text-success" >
                <?= strip_tags(($room['room_type']))?> 
                <span class=" badge badge-success badge-pill">  <?= $room['object_counter'] ?> P</span>
            </li>
            <?php 
                endforeach;
            ?>
        </ul>
    </div>
<?php endif; ?>

<?php if($list_ready_room_type): ?>
    <div class="card-box tilebox-one">
        <i class="mdi mdi-cat float-right text-warning"></i>
        <ul class="font-weight-bold">
        <?php 
            foreach($list_ready_room_type as $room): 
        ?>
        <li class="m-b-20 text-warning" >
                <?= strip_tags(($room['room_type']))?> 
                <span class=" badge badge-warning badge-pill">  <?= $room['object_counter'] ?> P</span>
        </li>
        <?php 
            endforeach;
        ?>
        </ul>
        
    </div>

<?php endif; ?>