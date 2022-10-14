<div class="container-fluid mt-4">
    <!-- Page-Title -->

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">test</a></li>
                        <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                        <li class="breadcrumb-item active">Starter</li>
                    </ol>
                </div>
                <h2 class="font-weight-bold text-danger">Bảng điều khiển</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                        <li class="breadcrumb-item active">Bảng điều khiển</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md text-center">
            <?php $this->load->view('components/list-navigation'); ?>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <h4>Giỏ Hàng - Hệ thống quản trị nội bộ <span class="text-danger font-weight-bold">SINVA</span> </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <a href="/admin/list-apartment">
                        <div class="card-box bg-danger tilebox-one">
                            <h2 class="text-white text-uppercase mt-0"> <i class="mdi mdi-arrow-right-bold-box"></i> Xem dự án</h2>
                        </div>
                    </a>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Dự án</h6>
                        <h2 class="m-b-20"><span><?= count($this->ghApartment->get(['active' => 'YES'])) ?></span></h2>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 ">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Nhân sự</h6>
                        <h2 class="m-b-20"><span ><?= count($this->ghUser->get(['active' => 'YES'])) ?></span></h2>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 ">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Hợp đồng <?= date('Y') ?></h6>
                        <h2 class="m-b-20"><span ><?= count($this->ghContract->get(['time_check_in >=' => strtotime(date('01-01-Y'))])) ?></span></h2>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 ">
                    <div class="card-box tilebox-one">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Khách thuê</h6>
                        <h2 class="m-b-20"><span ><?= count($this->ghCustomer->get([])) ?></span></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Doanh số (<?= $this->timeFrom . ' đến ' . $this->timeTo ?>)</h6>
                        <h2 class="m-b-20">
                            <span data-plugin="counterup"><?= number_format($total_sale_this_month) ?></span>
                        </h2>
                        <span class="badge badge-<?= ($total_sale_this_month)-$total_sale_previous_month > 0 ? 'success':'danger' ?>"> <?= ($total_sale_this_month-$total_sale_previous_month) > 0? "+" : ""  ?><?= (round(($total_sale_this_month-$total_sale_previous_month)*100/$total_sale_previous_month,2)) ?>%</span>
                        <span class="text-muted"> So với tháng trước: <?= number_format($total_sale_previous_month) ?></span>
                    </div>

                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Demo ???</h6>
                        <h2 class="m-b-20">
                            $<span data-plugin="counterup">...</span>
                        </h2>
                        <span class="badge badge-danger"> -...% </span>
                        <span class="text-muted">...</span>
                    </div>
                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Demo ???</h6>
                        <h2 class="m-b-20">
                            $<span data-plugin="counterup">...</span>
                        </h2>
                        <span class="badge badge-danger"> -...% </span>
                        <span class="text-muted">...</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Demo ???</h6>
                        <h2 class="m-b-20">
                            $<span data-plugin="counterup">...</span>
                        </h2>
                        <span class="badge badge-danger"> -...% </span>
                        <span class="text-muted">...</span>
                    </div>
                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Demo ???</h6>
                        <h2 class="m-b-20">
                            $<span data-plugin="counterup">...</span>
                        </h2>
                        <span class="badge badge-danger"> -...% </span>
                        <span class="text-muted">...</span>
                    </div>
                    <div class="card-box tilebox-one">
                        <i class="icon-paypal float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Demo ???</h6>
                        <h2 class="m-b-20">
                            $<span data-plugin="counterup">...</span>
                        </h2>
                        <span class="badge badge-danger"> -...% </span>
                        <span class="text-muted">...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php $this->load->view("contract/group-by-chart") ?>

    <div class="row mb-2">
        <div class="col-md-12">
            <div id="chart-apartment-group-district"></div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <section>
                <h4 class="text-danger">Xếp hạng doanh số theo phân khúc giá <?= $n_day ?> ngày</h4>
                <table class="table table-dark">
                    <thead>
                    <tr class="">
                        <th class="text-center font-weight-bold">Top</th>
                        <th class="text-center font-weight-bold">Phân khúc giá</th>
                        <th class="text-center font-weight-bold">Số lượng</th>
                        <th class="text-center font-weight-bold">Doanh số</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ranking_price_segment as $index => $item): ?>
                        <tr>
                            <td class="text-center"><?= $index+1 ?></td>
                            <td class="text-center"><?= $item['price_segment'] ?></td>
                            <td class="text-center"><?= $item['contract_number'] ?></td>
                            <td class="text-center"><?= number_format($item['contract_total_sale']) ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </section>
        </div>

        <div class="col-md-6">
            <section>
                <h4 class="text-danger">Xếp hạng doanh số theo phân khúc giá <?= $n_day ?> ngày</h4>
                <table class="table table-dark">
                    <thead>
                    <tr class="">
                        <th class="text-center font-weight-bold">Top</th>
                        <th class="text-center font-weight-bold">Loại phòng</th>
                        <th class="text-center font-weight-bold">Doanh số</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ranking_room_type as $index => $item): ?>
                        <tr>
                            <td class="text-center"><?= $index+1 ?></td>
                            <td class="text-center"><?= $item['type_name'] ?></td>
                            <td class="text-center"><?= number_format($item['total_sale']) ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
            <section>
                <h4 class="text-danger">TOP 10 dự án - số lượng hợp đồng <?= $n_day ?> ngày</h4>
                <table class="table table-dark">
                    <thead>
                    <tr class="">
                        <th class="text-center font-weight-bold">Top</th>
                        <th class="text-center font-weight-bold">Dự án</th>
                        <th class="text-center font-weight-bold">Số lượng</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ranking_apartment_total as $index => $item): ?>
                        <tr>
                            <td class="text-center"><?= $index+1 ?></td>
                            <td class="text-center"><?= $item['address_full'] ?></td>
                            <td class="text-center"><?= $item['contract_total'] ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </section>
        </div>

        <div class="col-md-6">
            <section>
                <h4 class="text-danger">TOP 10 dự án - doanh só <?= $n_day ?> ngày</h4>
                <table class="table table-dark">
                    <thead>
                    <tr class="">
                        <th class="text-center font-weight-bold">Top</th>
                        <th class="text-center font-weight-bold">Dự án</th>
                        <th class="text-center font-weight-bold">Doanh số</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ranking_apartment_total_sale as $index => $item):
                        ?>
                        <tr>
                            <td class="text-center"><?= $index+1 ?></td>
                            <td class="text-center"><?= $item['address_full'] ?></td>
                            <td class="text-center"><?= number_format($item['contract_total_sale']) ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6">
            <section>
                <h4 class="text-danger">TOP 10 số lượng hợp đồng <?= $n_day ?> ngày</h4>
                <table class="table table-dark">
                    <thead>
                    <tr class="">
                        <th class="text-center font-weight-bold">Top</th>
                        <th class="text-center font-weight-bold">Chuyên viên</th>
                        <th class="text-center font-weight-bold">Số lượng</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ranking_contract_total as $index => $item): ?>
                        <tr>
                            <td class="text-center"><?= $index+1 ?></td>
                            <td class="text-center"><?= $item['consultant_name'] ?></td>
                            <td class="text-center"><?= $item['contract_total'] ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </section>
        </div>
        <div class="col-md-6">
            <section>
                <h4 class="text-danger">TOP 10 doanh số <?= $n_day ?> ngày</h4>
                <table class="table table-dark">
                    <thead>
                    <tr class="">
                        <th class="text-center font-weight-bold">Top</th>
                        <th class="text-center font-weight-bold">Chuyên viên</th>
                        <th class="text-right font-weight-bold">(Doanh số)/ngày</th>
                        <th class="text-right font-weight-bold">Doanh số <small>x1000</small></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ranking_contract_total_sale as $index => $item): ?>
                        <tr>
                            <td class="text-center"><?= $index+1 ?></td>
                            <td class="text-center"><?= $item['consultant_name'] ?></td>
                            <td class="text-right"><?= number_format($item['contract_total_sale']/$n_day) ?></td>
                            <td class="text-right"><?= number_format($item['contract_total_sale']) ?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>