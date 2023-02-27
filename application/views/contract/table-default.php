<table class="table-contract  table table-dark table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th width="270px">Khách thuê</th>
        <th width="250px">Thành Viên Chốt</th>
        <th class="text-right" >Giá <small>x1000</small></th>
        <th class="text-right">Cọc <small>x1000</small></th>
        <th class="text-right">DS <small>x1000</small></th>
        <th class="text-right">DT <small>x1000</small></th>
        <th class="text-right"> <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <i class="mdi mdi-star-circle"></i> </span></th>


        <th>Ngày ký</th>

        <th class="text-center" width="100px">Trạng Thái</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($list_contract as $row ): ?>
        <?php
        $service = json_decode($row['service_set'], true);
        $partial_amount = 0; $partial_status = "";
        $total_sale = $this->ghContract->getTotalSaleByContract($row['id']);
        $list_partial = $this->ghContractPartial->get(['contract_id' => $row['id']]);
        foreach ($list_partial as $item) {
            $partial_amount += $item['amount'];
        }

        if($partial_amount >= $total_sale){
            $partial_status = '<span>thu đủ</span>';
        } else {
            $partial_status = '<span class="text-danger">'.number_format(($partial_amount)/1000).'</span>';
        }


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

        <tr>
            <td>
                <div>
                    <a target = '_blank'
                       href="/admin/detail-contract?id=<?= $row['id']
                       ?>">#<?= (10000 + $row['id']) ?></a>

                </div>
            </td>
            <td>
                <div><?= $this->libCustomer->getNameById($row['customer_id']).' - '. $this->libCustomer->getPhoneById($row['customer_id']) ?> </div>
                <div class="font-weight-bold text-warning"> <i class=" dripicons-home"></i>
                    <?php
                    $apartment = $this->ghApartment->getFirstById($row['apartment_id']);
                    $room = $this->ghRoom->getFirstById($row['room_id']);
                    ?>
                    <?= $apartment ? $apartment['address_street']:'' ?> <?= $room ? "(" . $room['code']. ")" : '[không có mp]' ?>
                </div>
            </td>
            <td>
                <?php
                $supporter = [];
                if(!empty($row['arr_supporter_id'])){
                    $list_supporter = json_decode($row['arr_supporter_id'], true);
                    foreach ($list_supporter as $item){
                        $supporter [] = $this->libUser->getNameByAccountid($item);
                    }
                }

                ?>
                <div class="consultant_id text-warning font-weight-bold"
                     data-pk="<?= $row['id'] ?>"
                     data-value="<?= $row['consultant_id'] ?>"
                     data-name="consultant_id">
                    <?= $this->libUser->getNameByAccountid($row['consultant_id']) ?>
                </div>

                <?php if(count($supporter)): ?>
                    <div class=" text-light font-weight-bold">
                        (H.trợ: <?= implode(", ",$supporter) ?>)
                    </div>
                <?php endif; ?>
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
            <td class="font-weight-bold text-right"><?= number_format($total_sale/1000) ?></td>
            <td class="font-weight-bold text-right"><?= $partial_status ?></td>
            <td class="font-weight-bold text-center"> <?= (float) $row['rate_type'] ?></td>

            <td>
                <div class="contract-time_check_in text-warning"
                     data-pk="<?= $row['id'] ?>"
                     data-value="<?= date('d/m/Y',$row['time_check_in']) ?>"
                     data-name="time_check_in">
                    <?=$row['time_check_in'] ? date('d/m/Y',$row['time_check_in']):'-' ?>
                </div>
            </td>

            <td class="text-center">
                <div>

                    <span class="badge badge-<?= $statusClass ?> font-weight-bold"><?=  $doc_type ?></span>

                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
