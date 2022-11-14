<?php

$team_sale_arr = [];
foreach ($list_team as $tt) {
    $team_sale_arr[$tt['name']] = $libUser->getTotalSaleByTeam($tt['id'], $from_time, $to_time);
}


?>
<?php foreach ($team_sale_arr as $name => $sale): ?>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box shadow tilebox-one">
            <i class="icon-chart float-right text-muted"></i>
            <h6 class="text-muted text-uppercase mt-0">Doanh số <?= $name ?></h6>
            <h2 class="m-b-20">$<span data-plugin="counterup"><?= number_format($sale) ?></span></h2>
        </div>
    </div>
<?php endforeach; ?>