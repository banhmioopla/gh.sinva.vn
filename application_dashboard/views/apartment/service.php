<?php
$hidden_service = count(json_decode($apartment['hidden_service'], true)) ? json_decode($apartment['hidden_service'], true) : [];

$counter_slide = 0;

$slide_1 = ['electricity', 'water', 'internet', 'parking', 'management_fee', 'extra_fee', 'deposit'];
$slide_2 = ['elevator', 'washing_machine', 'room_cleaning', 'number_of_people', 'kitchen', 'security', 'pet', 'car_park'];
$slide_3 = ['commission_rate', 'commission_rate_9m', 'commission_rate_6m', 'contract_long_term', 'contract_short_term'];
$active_slide_1 = $active_slide_2 = $active_slide_3 = 'active';


if(!array_diff($slide_1, $hidden_service)){
    $active_slide_1 = "";
}
if(empty($active_slide_1) && !array_diff($slide_2, $hidden_service)){
    $active_slide_2 = "";
}
if(empty($active_slide_1) && empty($active_slide_2) && !array_diff($slide_3, $hidden_service)){
    $active_slide_3 = "";
}
if(!empty($active_slide_1)){
    $active_slide_2 = $active_slide_3 = "";
}

if(!empty($active_slide_2)){
    $active_slide_1 = $active_slide_3 = "";
}
if(!empty($active_slide_3)){
    $active_slide_2 = $active_slide_1 = "";
}
?>

<div class="carousel-item <?= $active_slide_1 ?>">
    <ul class="list-group">
        <?php if(!in_array('electricity', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['electricity'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="electricity"
                 data-value="<?= $apartment['electricity'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['electricity'] ?>
            </div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('water', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['water'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="water"
                 data-value="<?= $apartment['water'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['water'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('internet', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['internet'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="internet"
                 data-value="<?= $apartment['internet'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['internet'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('parking', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['parking'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="parking"
                 data-value="<?= $apartment['parking'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['parking'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('management_fee', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['management_fee'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="management_fee"
                 data-value="<?= $apartment['management_fee'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['management_fee'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('extra_fee', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['extra_fee'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="extra_fee"
                 data-value="<?= $apartment['extra_fee'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['extra_fee'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('deposit', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['deposit'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="deposit"
                 data-value="<?= $apartment['deposit'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['deposit'] ?></div>
        </li>
        <?php endif; ?>

    </ul>
</div>

<div class="carousel-item <?= $active_slide_2 ?>">
    <ul class="list-group">
        <?php if(!in_array('elevator', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['elevator'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="elevator"
                 data-value="<?= $apartment['elevator'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['elevator'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('washing_machine', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['washing_machine'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="washing_machine"
                 data-value="<?= $apartment['washing_machine'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['washing_machine'] ?></div>
        </li>
        <?php endif; ?>


        <?php if(!in_array('room_cleaning', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['room_cleaning'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="room_cleaning"
                data-value="<?= $apartment['room_cleaning'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['room_cleaning'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('number_of_people', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['number_of_people'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="number_of_people"
                data-value="<?= $apartment['number_of_people'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['number_of_people'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('kitchen', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['kitchen'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="kitchen"
                data-value="<?= $apartment['kitchen'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['kitchen'] ?></div>
        </li>
        <?php endif; ?>


        <?php if(!in_array('security', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['security'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="security"
                 data-value="<?= $apartment['security'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['security'] ?></div>
        </li>
        <?php endif; ?>


        <?php if(!in_array('pet', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['pet'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="pet"
                 data-value="<?= $apartment['pet'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['pet'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('car_park', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['car_park'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="car_park"
                 data-value="<?= $apartment['car_park'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['car_park'] ?></div>
        </li>
        <?php endif; ?>
    </ul>
</div>
<div class="carousel-item <?= $active_slide_3 ?>">
    <ul class="list-group">
        <?php if($check_commission_rate):

            ?>
            <?php if(!in_array('commission_rate', $hidden_service)):
            ?>
            <li class="list-group-item">
                <i class="text-danger"><?= $label_apartment['commission_rate'] ?></i>
                <div class="text-right font-weight-bold"
                     data-name="commission_rate"
                     data-value="<?= $apartment['commission_rate'] ?>"
                     data-pk="<?= $apartment['id'] ?>"><?= $apartment['commission_rate'] ?>
                </div>
            </li>
            <?php endif; ?>


            <?php if(!in_array('commission_rate_9m', $hidden_service)): ?>
            <li class="list-group-item">
                <i class="text-danger"><?= $label_apartment['commission_rate_9m'] ?></i>
                <div class="text-right font-weight-bold"
                     data-name="commission_rate_9m"
                     data-value="<?= $apartment['commission_rate_9m'] ?>"
                     data-pk="<?= $apartment['id'] ?>"><?= $apartment['commission_rate_9m'] ?>
                </div>
            </li>
            <?php endif; ?>


            <?php if(!in_array('commission_rate_6m', $hidden_service)): ?>
            <li class="list-group-item">
                <i class="text-danger"><?= $label_apartment['commission_rate_6m'] ?></i>
                <div class="text-right font-weight-bold"
                     data-name="commission_rate_6m"
                     data-value="<?= $apartment['commission_rate_6m'] ?>"
                     data-pk="<?= $apartment['id'] ?>"><?= $apartment['commission_rate_6m'] ?>
                </div>
            </li>
            <?php endif; ?>

        <?php endif; ?>

        <?php if(!in_array('contract_long_term', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['contract_long_term'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="contract_long_term"
                 data-value="<?= $apartment['contract_long_term'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['contract_long_term'] ?></div>
        </li>
        <?php endif; ?>

        <?php if(!in_array('contract_short_term', $hidden_service)): ?>
        <li class="list-group-item">
            <i><?= $label_apartment['contract_short_term'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="contract_short_term"
                 data-value="<?= $apartment['contract_short_term'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['contract_short_term'] ?></div>
        </li>
        <?php endif; ?>
    </ul>
</div>


