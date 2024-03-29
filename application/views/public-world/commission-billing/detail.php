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
                    <h5 class="text-danger font-weight-bold">SINVA | PHIẾU ĐỀ NGHỊ THANH TOÁN </h5>
                    <h1 class="text-danger font-weight-bold"><?= $apartment["address_street"] .", phường " .$apartment["address_ward"] .", Quận ". ($this->libDistrict->getNameByCode($apartment["district_code"]))  ?> </h1>
                </div>
            </div>
        </div>

        <div class="row">

            <!--<div class="col-md-4">
                <div class="card-box">
                    <img src='https://i.postimg.cc/MMjMnLDz/Sinva-vn-Logo-QB-updated.png' border='0' alt='Sinva-vn-Logo-QB-updated'/>
                </div>
            </div>-->
            <div class="col-md-4">
                <div class="card-box">
                    <ul>
                        <li>
                            Tài khoản giao dịch: <strong>Ngân hàng VPBank</strong>
                        </li>
                        <li>
                            Chủ tài khoản: <strong>Trần Thị Trâm Anh</strong>
                        </li>
                        <li>
                            STK: <strong>0888900704</strong>
                        </li>
                        <li>
                            Nội dung: <strong><?= $apartment_address_payment ?></strong>
                        </li>
                        <li >
                            Tổng thanh toán: <strong class="text-primary "><?= number_format($total_billing_amount) ?></strong>
                        </li>
                        <hr>
                        <li> Bộ Phận: <strong>Quản Lý Dự Án</strong> </li>
                        <li> Người đề nghị: <strong>Trần Thị Trâm Anh</strong> </li>
                        <li> Ngày: <strong><?= date("d/m/Y") ?></strong> </li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-danger">Danh sách chi tiết</h4>
					<div class="table-responsive">
						<table class="table  table-dark">
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

							$stt = 1;
							?>

							<?php foreach ($list_contract as $contract):
								$room = $this->ghRoom->getFirstById($contract['room_id']);
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
								<tr  class="text-center">
									<th scope="row"><?= $stt ?></th>
									<td><?= date("d/m/Y",$contract['time_insert']) ?></td>
									<td><?= $room["code"] ?></td>
									<td><?= number_format($contract["room_price"]) ?></td>
									<td class="text-warning"><?= $txt_contract_total_sale ?></td>
									<td><?= $contract["commission_rate"] ?></td>
									<td><?= $contract["number_of_month"] ?></td>
								</tr>
								<?php $stt++; endforeach;?>
							</tbody>
						</table>
					</div>

                </div>

            </div>
        </div>
    </div>
</div>
