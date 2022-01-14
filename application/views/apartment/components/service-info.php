<div class="row collapse" id="service-info" role="tabpanel">
    <?php if(!in_array('electricity', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['electricity'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['electricity'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('water', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['water'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['water'] ?></div>
        </div>
    <?php endif; ?>


    <?php if(!in_array('internet', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['internet'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['internet'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('parking', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['parking'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['parking'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('management_fee', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['management_fee'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['management_fee'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('extra_fee', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['extra_fee'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['extra_fee'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('elevator', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['elevator'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['elevator'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('washing_machine', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['washing_machine'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['washing_machine'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('room_cleaning', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['room_cleaning'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['room_cleaning'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('number_of_people', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['number_of_people'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['number_of_people'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('kitchen', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['kitchen'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['kitchen'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('security', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['security'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['security'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('pet', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['pet'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['pet'] ?></div>
        </div>
    <?php endif; ?>

    <?php if(!in_array('car_park', $hidden_service)): ?>
        <div class="col-md-3 col-6 mb-4">
            <div><i class="mdi mdi-cube"></i> <?= $label_apartment['car_park'] ?></div>
            <div class="font-weight-bold pl-2"><?= $current_apartment['car_park'] ?></div>
        </div>
    <?php endif; ?>
</div>
