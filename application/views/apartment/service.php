<div class="carousel-item active">
    <ul class="list-group">
        <?php if($check_commission_rate): ?>
        <li class="list-group-item">
            <i class="text-danger"><?= $label_apartment['commission_rate'] ?></i>  
            <div class="text-right font-weight-bold" 
                data-name="commission_rate"
                data-value="<?= $apartment['commission_rate'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['commission_rate'] ?>
            </div>
        </li>
        <li class="list-group-item">
            <i class="text-danger"><?= $label_apartment['commission_rate_9m'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="commission_rate_9m"
                 data-value="<?= $apartment['commission_rate_9m'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['commission_rate_9m'] ?>
            </div>
        </li>
        <li class="list-group-item">
            <i class="text-danger"><?= $label_apartment['commission_rate_6m'] ?></i>
            <div class="text-right font-weight-bold"
                 data-name="commission_rate_6m"
                 data-value="<?= $apartment['commission_rate_6m'] ?>"
                 data-pk="<?= $apartment['id'] ?>"><?= $apartment['commission_rate_6m'] ?>
            </div>
        </li>
        <?php endif; ?>
        <li class="list-group-item">
            <i><?= $label_apartment['electricity'] ?></i>  
            <div class="text-right font-weight-bold" 
                data-name="electricity"
                data-value="<?= $apartment['electricity'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['electricity'] ?>
            </div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['water'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="water"
                data-value="<?= $apartment['water'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['water'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['internet'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="internet"
                data-value="<?= $apartment['internet'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['internet'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['elevator'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="elevator"
                data-value="<?= $apartment['elevator'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['elevator'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['washing_machine'] ?></i>  
            <div class="text-right font-weight-bold"
                data-name="washing_machine"
                data-value="<?= $apartment['washing_machine'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['washing_machine'] ?></div>
        </li>
    </ul>
</div>

<div class="carousel-item">
    <ul class="list-group">
        <li class="list-group-item">
            <i><?= $label_apartment['management_fee'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="management_fee"
                data-value="<?= $apartment['management_fee'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['management_fee'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['room_cleaning'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="room_cleaning"
                data-value="<?= $apartment['room_cleaning'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['room_cleaning'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['parking'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="parking"
                data-value="<?= $apartment['parking'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['parking'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['number_of_people'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="number_of_people"
                data-value="<?= $apartment['number_of_people'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['number_of_people'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['deposit'] ?></i>  
            <div class="text-right font-weight-bold" 
                data-name="deposit"
                data-value="<?= $apartment['deposit'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['deposit'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['kitchen'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="kitchen"
                data-value="<?= $apartment['kitchen'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['kitchen'] ?></div>
        </li>
    </ul>
</div>
<div class="carousel-item">
    <ul class="list-group">
        <li class="list-group-item">
            <i><?= $label_apartment['extra_fee'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="extra_fee"
                data-value="<?= $apartment['extra_fee'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['extra_fee'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['contract_long_term'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="contract_long_term"
                data-value="<?= $apartment['contract_long_term'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['contract_long_term'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['contract_short_term'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="contract_short_term"
                data-value="<?= $apartment['contract_short_term'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['contract_short_term'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['security'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="security"
                data-value="<?= $apartment['security'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['security'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['pet'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="pet"
                data-value="<?= $apartment['pet'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['pet'] ?></div>
        </li>
        <li class="list-group-item">
            <i><?= $label_apartment['car_park'] ?></i>
            <div class="text-right font-weight-bold"
                data-name="car_park"
                data-value="<?= $apartment['car_park'] ?>"
                data-pk="<?= $apartment['id'] ?>"><?= $apartment['car_park'] ?></div>
        </li>
    </ul>
</div>

