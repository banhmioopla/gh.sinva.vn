<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container-fluid">
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
                    <h2 class="text-danger font-weight-bold">Phiếu thu hoa hồng</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <div class="card-box">
                    <input type="text" class="form-control" value="<?= $timeFrom ?>">
                    <input type="text" class="form-control" value="<?= $timeTo ?>">
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="card-box">
                    <h4 class="m-t-0 header-title">Danh sách hợp đồng</h4>
                    <table class="table table-dark">
                        <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th class="text-center">Ngày cọc</th>
                            <th class="text-center">Mã Phòng</th>
                            <th class="text-center">Giá Phòng</th>
                            <th class="text-center">Số tiền phải thanh toán</th>
                            <th class="text-center">Hoa Hồng</th>
                            <th class="text-center">Số Tháng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($list_apartment as $apartment):
                            $list_contract = $this->ghContract->get([
                                'time_check_in >=' => strtotime($timeFrom),
                                'time_check_in <=' => strtotime($timeTo)+86399,
                                'status <>' => 'Cancel',
                                "apartment_id" => $apartment['id'],
                            ]);
                            $total_billing_amount = 0;
                            foreach ($list_contract as $contract){
                                $total_billing_amount += $contract["room_price"]*$contract["commission_rate"]/100;
                            }
                            $stt = 1;
                            ?>
                            <tr scope="row" class="mt-2">
                                <td colspan="12" >
                                    <h3 class="ml-3"><?= $apartment["address_street"] ?> </h3>
                                    <div class="ml-3 text-warning">Tổng thanh toán: <span ><?= number_format($total_billing_amount) ?></span></div>
                                </td>
<!--                                <td colspan="2">--><?//= $public_url[$apartment['id']] ?><!--</td>-->
                            </tr>
                            <?php foreach ($list_contract as $contract):
                            $room = $this->ghRoom->getFirstById($contract['room_id']);


                            ?>
                                <tr  class="text-center">
                                    <th scope="row"><?= $stt ?></th>
                                    <td><?= date("d/m/Y",$contract['time_insert']) ?></td>
                                    <td><?= $room["code"] ?></td>
                                    <td><?= number_format($contract["room_price"]) ?></td>
                                    <td class="text-warning"><?= number_format($contract["room_price"]*$contract["commission_rate"]/100) ?></td>
                                    <td><?= $contract["commission_rate"] ?></td>
                                    <td><?= $contract["number_of_month"] ?></td>
                                </tr>
                            <?php $stt++; endforeach;?>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<script>

    commands.push(function() {
        $(function () {
            $('.select2').select2();
        });
    });
</script>