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
                    <table class="table table-dark table-hover">
                        <tbody>
                        <?php

                        foreach ($list_apartment as $apartment):
                            $list_contract = $this->ghContract->get([
                                'time_check_in >=' => strtotime($timeFrom),
                                'time_check_in <=' => strtotime($timeTo)+86399,
                                'status <>' => 'Cancel',
                                "apartment_id" => $apartment['id'],
                            ]);

                            $total_partial_amount = 0;
                            $total_sale_amount = 0;
                            foreach ($list_contract as $contract){
                                $total_sale_amount += $contract["room_price"]*$contract["commission_rate"]/100;
                                $total_partial_amount += $this->ghContractPartial->getTotalByContractId($contract['id']);
                            }
                            $stt = 1;
                            $total_billing_amount = $total_sale_amount - $total_partial_amount;
                            ?>
                            <tr scope="row " class="mt-3">
                                <td colspan="15" >
                                    <h3 class="ml-3"><?= $apartment["address_street"] .", phường " .$apartment["address_ward"] .", Quận ". ($this->libDistrict->getNameByCode($apartment["district_code"]))  ?> </h3>

                                    <div class="ml-3 text-warning">
                                        <a target="_blank"
                                           id="billing-public-url-<?= $apartment["id"] ?>"
                                           data-public_url_origin="<?= $public_url[$apartment['id']] ?>"
                                           href="<?= $public_url[$apartment['id']] ?>"> <i class="mdi mdi-link"></i> Link gửi đối tác </a>
                                        <a href="javascript:void(0)"
                                           data-apartment_id="<?= $apartment["id"] ?>"
                                           data-time_from="<?= $timeFrom ?>"
                                           data-time_to="<?= $timeTo ?>"
                                           class="ml-3 update-full-contract-partial"> <i class="mdi mdi-cash-multiple"></i> Cập nhật doanh thu vào GH </a>
                                        <p class="msg-line text-success" id="msg-line-<?= $apartment["id"] ?>"></p>
                                    </div>



                                    <div class="ml-3" >Tổng doanh số: <span ><?= number_format($total_sale_amount) ?></span></div>
                                    <div class="ml-3" id="total-partial-amount-<?= $apartment["id"] ?>" >Tổng doanh thu: <span ><?= number_format($total_partial_amount) ?></span></div>
                                    <div class="ml-3">Tổng thanh toán: <span ><?= number_format($total_billing_amount) ?></span></div>

                                </td>
<!--                                <td colspan="2">--><?//= $public_url[$apartment['id']] ?><!--</td>-->
                            </tr>
                            <tr>
                                <th class="text-center">Chọn</th>
                                <th class="text-center">STT</th>
                                <th class="text-center">Ngày cọc</th>
                                <th class="text-center">Ngày ký</th>
                                <th class="text-center">Mã Phòng</th>
                                <th class="text-center">Giá Phòng</th>
                                <th class="text-center">Doanh Số</th>
                                <th class="text-center">Số tiền phải thanh toán</th>
                                <th class="text-center">Hoa Hồng</th>
                                <th class="text-center">Số Tháng</th>
                                <th class="text-left">Ghi Chú</th>
                                <th class="text-center">Trạng Thái</th>
                            </tr>
                            <?php foreach ($list_contract as $contract):
                            $room = $this->ghRoom->getFirstById($contract['room_id']);
                            $statusClass = 'muted'; $doc_type = "Cọc ";
                            if($contract['status'] == 'Active') {
                                $statusClass = 'success';
                            }
                            if($contract['status'] == 'Pending') {
                                $statusClass = 'warning';
                                $doc_type .= " Chờ duyệt";
                            }

                            if(time() >= $contract["time_check_in"]){
                                $doc_type = "HĐ đã ký ";
                            }
                            if(time() >= $contract["time_expire"]){
                                $doc_type = "HĐ hết hạn ";
                                $statusClass = 'secondary';
                            }

                            if($contract['status'] == 'Cancel') {
                                $statusClass = 'warning';
                                $doc_type .= " Đã huỷ";
                            }

                            $contract_total_sale = $this->ghContract->getTotalSaleByContract($contract['id']);
                            $contract_total_partial = $this->ghContractPartial->getTotalByContractId($contract['id']);
                            $txt_contract_total_sale = "<span>".number_format($contract_total_sale-$contract_total_partial)."</span>";
                            $list_partial_arr = []; $list_partial_txt = "";

                            if($contract_total_sale <= $contract_total_partial){
                                $txt_contract_total_sale = "<i class='mdi mdi-check-circle text-success'></i> <span class='text-success'>".number_format($contract_total_sale)."</span> <br> <small class='text-success'>thu đủ</small>";
                            } else {
                                $list_partial = $this->ghContractPartial->get(['contract_id' => $contract['id']]);

                                foreach ($list_partial as $p){
                                    $list_partial_arr []= number_format($p['amount']);
                                }
                                if(count($list_partial_arr)){
                                    $list_partial_txt = "<div class='text-success'>(".implode(" + ", $list_partial_arr) .")</div>";
                                }

                            }

                            ?>
                                <tr  class="text-center group-tr-apm_id-<?= $apartment["id"] ?>">
                                    <th scope="row">
                                        <div class="checkbox checkbox-warning checkbox-single">
                                            <input type="checkbox"
                                                   data-contract_id="<?= $contract['id'] ?>"
                                                   data-apm_id="<?= $apartment["id"] ?>" class="billing-check-box" value="<?= $contract['id'] ?>">
                                            <label></label>
                                        </div>
                                    </th>
                                    <td scope="row"><?= $stt ?></td>
                                    <td><?= date("d/m/Y",$contract['time_insert']) ?></td>
                                    <td><?= date("d/m/Y",$contract['time_check_in']) ?></td>
                                    <td><?= $room["code"] ?></td>
                                    <td><?= number_format($contract["room_price"]) ?></td>
                                    <td><?= number_format($contract_total_sale) ?></td>
                                    <td class="text-warning"><a target="_blank" href="/admin/detail-contract?id=<?= $contract['id'] ?>"> <i class="mdi mdi-open-in-new"></i> </a> <?= $txt_contract_total_sale ?> <?= $list_partial_txt ?></td>
                                    <td><?= $contract["commission_rate"] ?>%</td>
                                    <td><?= $contract["number_of_month"] ?></td>
                                    <td style="max-width: 280px" class="text-left"><i><?= trim($contract["note"]) ?></i></td>
                                    <td><span class="badge badge-<?= $statusClass ?> font-weight-bold"><?=  $doc_type ?></span></td>
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

            $('.billing-check-box').click(function () {
                let _this = $(this);
                let apm_id = _this.data("apm_id");
                let arr_contract_id = [];
                let public_url = $('#billing-public-url-'+apm_id).attr("href");
                let public_url_origin = $('#billing-public-url-'+apm_id).data("public_url_origin");

                let arr_billing_checked = $('.group-tr-apm_id-'+apm_id+' .billing-check-box');
                arr_billing_checked.each(function () {
                    let _bill_checked = $(this).is(":checked");
                    if(_bill_checked === true){
                        arr_contract_id.push($(this).data("contract_id"));
                    }
                    $(this).is(":checked");
                });


                public_url = public_url_origin +arr_contract_id.join(",");
                $('#billing-public-url-'+apm_id).attr("href", public_url);

                console.log("new url", $('#billing-public-url-'+apm_id).attr("href"));
            });
        });
    });
</script>