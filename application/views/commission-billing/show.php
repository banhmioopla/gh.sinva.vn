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
            <div class="col-md-12">
                <div class="card-box">
                    <form method="GET" class="row">
                        <div class="col-md-4 offset-md-2">
                            <strong>Ngày Ký Bắt Đầu</strong>
                            <input type="text" name="timeFrom" class="form-control" value="<?= $timeFrom ?>">
                        </div>
                        <div class="col-md-4">
                            <strong>Ngày Ký Kết Thúc</strong>
                            <input type="text" name="timeTo" class="form-control" value="<?= $timeTo ?>">
                        </div>
                        <div class="col-md-12 mt-2 text-center">
                            <button type="submit" class="btn btn-danger" id="submitTimeRange">Áp Dụng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">THÔNG TIN PHIẾU THU (<?= $timeFrom ?> đến <?= $timeTo ?>)</h4>
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
                            $total_partial_amount = 0;
                            foreach ($list_contract as $contract){
                                $total_billing_amount += $contract["room_price"]*$contract["commission_rate"]/100;
                                $total_partial_amount += $this->ghContractPartial->getTotalByContractId($contract['id']);
                            }
                            $stt = 1;
                            ?>
                            <tr scope="row" class="mt-3">
                                <td colspan="12" >
                                    <h3 class="ml-3"><?= $apartment["address_street"] .", phường " .$apartment["address_ward"] .", Quận ". ($this->libDistrict->getNameByCode($apartment["district_code"]))  ?> </h3>

                                    <div class="ml-3 text-warning">
                                        <a target="_blank" href="<?= $public_url[$apartment['id']] ?>"> <i class="mdi mdi-link"></i> Link gửi đối tác </a>
                                        <a href="javascript:void(0)"
                                           data-apartment_id="<?= $apartment["id"] ?>"
                                           data-time_from="<?= $timeFrom ?>"
                                           data-time_to="<?= $timeTo ?>"
                                           class="ml-3 update-full-contract-partial"> <i class="mdi mdi-cash-multiple"></i> Cập nhật doanh thu vào GH </a>
                                        <p class="msg-line text-success" id="msg-line-<?= $apartment["id"] ?>"></p>
                                    </div>


                                    <div class="ml-3 text-warning">Tổng thanh toán: <span ><?= number_format($total_billing_amount) ?></span></div>
                                    <div class="ml-3 text-warning" id="total-partial-amount-<?= $apartment["id"] ?>" >Tổng doanh thu: <span ><?= number_format($total_partial_amount) ?></span></div>

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
                                    <td><?= $contract["commission_rate"] ?>%</td>
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
            $('.update-full-contract-partial').click(function () {
               let apm_id = $(this).data("apartment_id");
               let time_from = $(this).data("time_from");
               let time_to = $(this).data("time_to");
               let _this = $(this);
               $.ajax({
                   url: '/admin/commission-billing/update-full-contract-partial',
                   method: "POST",
                   data: {apm_id: apm_id, time_from: time_from, time_to: time_to},
                   dataType: "json",
                   success: function (res) {
                       if(res.status === true){
                           $("#msg-line-"+apm_id).text(res.msg).fadeOut(4000);
                           $('#total-partial-amount-'+apm_id).text("Tổng doanh thu: "+res.amount);
                       }
                   }
               });
            });
        });
    });
</script>