<dl class="card-box">
    <div class="row text-info font-weight-bold">
        <div class="col-12">
            <h5 class="bg-dark text-warning p-3">NGỦ SUỐT 5 NGÀY</h5>
        </div>
        <?php foreach ($list_apm_5days as $apm5): ?>
        <!--ITEM -->
        <dt class="col-10"> <i class="mdi mdi-chevron-double-right"></i> <?= $apm5['address_street'] ?></dt>
        <dd class="col-2 text-right"><?= $libTime->calDay2Time($today, $apm5['time_update']) ?></dd>
        <?php endforeach; ?>
    </div>

</dl>