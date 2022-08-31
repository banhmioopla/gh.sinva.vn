<table class="table-contract  table table-dark table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th width="350px">Khách thuê</th>
        <th class="text-right">Giá thuê <small>x1000</small></th>
        <th class="text-right">Giá cọc <small>x1000</small></th>
        <th class="text-right"> <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <i class="mdi mdi-star-circle"></i> </span></th>

        <th width="250px">Thành Viên Chốt</th>
        <th>Ngày ký</th>
        <th>Ngày hết hạn</th>
        <th class="text-center">Thời hạn</th>
        <th class="text-center" width="100px">Trạng Thái</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list_contract as $row ): ?>
        <?php
        $service = json_decode($row['service_set'], true);
        $partial_amount = 0;
        $list_partial = $ghContractPartial->get(['contract_id' => $row['id']]);
        foreach ($list_partial as $item) {
            $partial_amount += $item['amount'];
        }

        ?>
        <tr>
            <td>
                <div>
                    <a target = '_blank'
                       href="/admin/detail-contract?id=<?= $row['id']
                       ?>">#<?= (10000 + $row['id']) ?></a>

                </div>
            </td>
            <td>
                <div><?= $libCustomer->getNameById($row['customer_id']).' - '. $libCustomer->getPhoneById($row['customer_id']) ?> </div>
                <div class="font-weight-bold text-warning"> <i class=" dripicons-home"></i>
                    <?php
                    $apartment = $ghApartment->get(['id' => $row['apartment_id']]);
                    $room = $ghRoom->get(['id' => $row['room_id']]);
                    $room = $room ? $room[0]:null;
                    ?>
                    <?= $apartment ? $apartment[0]['address_street']:'' ?> <?= $room ? "(" . $room['code']. ")" : '[không có mp]' ?>
                </div>
            </td>
            <td class="text-right">
                <div class="contract-room_price text-warning font-weight-bold"
                     data-pk="<?= $row['id'] ?>"
                     data-value="<?= $row['room_price'] ?>"
                     data-name="room_price">
                    <?= number_format($row['room_price']/1000) ?>
                </div>
            </td>
            <td class="font-weight-bold text-right"><?= number_format($row['deposit_price']/1000) ?></td>
            <td class="font-weight-bold text-center"> <?= (float) $row['rate_type'] ?></td>
            <td>
                <?php
                $supporter = [];
                if(!empty($row['arr_supporter_id'])){
                    $list_supporter = json_decode($row['arr_supporter_id'], true);
                    foreach ($list_supporter as $item){
                        $supporter [] = $libUser->getNameByAccountid($item);
                    }
                }

                ?>
                <div class="consultant_id text-warning font-weight-bold"
                     data-pk="<?= $row['id'] ?>"
                     data-value="<?= $row['consultant_id'] ?>"
                     data-name="consultant_id">
                    <?= $libUser->getNameByAccountid($row['consultant_id']) ?>
                </div>

                <?php if(count($supporter)): ?>
                    <div class=" text-light font-weight-bold">
                        (H.trợ: <?= implode(", ",$supporter) ?>)
                    </div>
                <?php endif; ?>
            </td>
            <td>
                <div class="contract-time_check_in text-warning"
                     data-pk="<?= $row['id'] ?>"
                     data-value="<?= date('d/m/Y',$row['time_check_in']) ?>"
                     data-name="time_check_in">
                    <?=$row['time_check_in'] ? date('d/m/Y',$row['time_check_in']):'-' ?>
                </div>
            </td>
            <td>
                <div class="contract-time_expire text-warning"
                     data-pk="<?= $row['id'] ?>"
                     data-value="<?= date('d/m/Y',$row['time_expire']) ?>"
                     data-name="time_expire">
                    <?=$row['time_expire'] ? date('d/m/Y',$row['time_expire']):'-' ?>
                </div>
            </td>
            <td class="text-center">
                <div class="contract-number_of_month text-warning"
                     data-pk="<?= $row['id'] ?>"
                     data-value="<?= $row['number_of_month'] ?>"
                     data-name="number_of_month">
                    <?=$row['number_of_month'] ?>
                </div>
            </td>
            <td class="text-center">
                <div>
                    <?php
                    $statusClass = 'muted'; $doc_type = "Cọc ";
                    if($row['status'] == 'Active') {
                        $statusClass = 'success';
                    }
                    if($row['status'] == 'Pending') {
                        $statusClass = 'warning';
                        $doc_type .= " Chờ duyệt";
                    }

                    if(time() >= $row["time_check_in"]){
                        $doc_type = "HĐ đã ký ";
                    }
                    if(time() >= $row["time_expire"]){
                        $doc_type = "HĐ hết hạn ";
                        $statusClass = 'secondary';
                    }

                    if($row['status'] == 'Cancel') {
                        $statusClass = 'warning';
                        $doc_type .= " Đã huỷ";
                    }
                    ?>
                    <span class="badge badge-<?= $statusClass ?> font-weight-bold"><?=  $doc_type ?></span>

                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>