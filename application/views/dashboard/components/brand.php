<?php

$district_sale_arr = [];
foreach ($list_partner as $dd) {
    $list_apm = $ghApartment->get(['active' => 'YES', 'partner_id' => $dd['id']]);
    $sale_apm =  0;
    foreach ($list_apm as $apm) {
        $sale_apm += $libApartment->getSaleTotalFromApm($apm['id'], $from_time, $to_time);
    }
    $district_sale_arr[$dd['name']] = $sale_apm;
}


?>
<?php foreach ($district_sale_arr as $district => $sale): ?>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box shadow tilebox-one">
            <i class="icon-chart float-right text-muted"></i>
            <h6 class="text-muted text-uppercase mt-0">Doanh số <?= $district ?></h6>
            <h2 class="m-b-20">$<span data-plugin="counterup"><?= number_format($sale) ?></span></h2>
        </div>
    </div>
<?php endforeach; ?>