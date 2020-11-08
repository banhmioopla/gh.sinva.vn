<div class=" mt-2 card-box table-responsive shadow">
    <h4 class="text-danger text-center" <?= $check_collapse ? 'data-target="#listThisMonth" data-toggle="collapse"' : '' ?>>Hợp Đồng Ký Tháng <?= date('m/Y') ?></h4>
    <table id="listThisMonth" class="table-contract table table-bordered <?= $check_collapse ? 'collapse' :'' ?>">
        <thead>
        <tr>
            <th class="text-center" width="100px">ID Hợp Đồng</th>
            <th width="350px">Khách thuê</th>
            <th>Giá thuê</th>
            <th>Ngày ký</th>
            <th>Ngày hết hạn</th>
            <th class="text-center">Thời hạn</th>
            <th class="text-center" width="100px">Tình trạng</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($list_contract as $row ):
            if($row['time_check_in'] < strtotime(date('01-m-Y'))) {
                continue;
            }
            ?>
            <?php $service = json_decode($row['service_set'], true) ?>
            <tr>
                <td class="text-center" width="100px">
                    <div>
                        <a target = '_blank' href="/admin/detail-contract?id=<?= $row['id'] ?>">#<?= (10000 + $row['id']) ?></a>
                    </div>
                </td>
                <td>
                    <div class="text-muted"><?= $libCustomer->getNameById($row['customer_id']).' - '. $libCustomer->getPhoneById($row['customer_id']) ?> </div>
                    <div class="font-weight-bold text-primary">
                        <?php
                        $apartment = $ghApartment->get(['id' => $row['apartment_id']]);
                        $room = $ghRoom->get(['id' => $row['room_id']]);
                        $room = $room ? $room[0]:null;
                        ?>
                        <?= $apartment ? $apartment[0]['address_street']:'' ?>
                    </div>
                    <h6 class="text-danger">

                        <?= $room ? 'mã phòng: '.$room['code'] : '[không có thông tin]' ?>
                    </h6>
                </td>
                <td>
                    <div class="contract-room_price font-weight-bold"
                         data-pk="<?= $row['id'] ?>"
                         data-value="<?= $row['room_price'] ?>"
                         data-name="room_price">
                        <?= number_format($row['room_price']) ?>
                    </div>
                </td>
                <td>
                    <div class="contract-time_check_in"
                         data-pk="<?= $row['id'] ?>"
                         data-value="<?= date('d/m/Y',$row['time_check_in']) ?>"
                         data-name="time_check_in">
                        <?=$row['time_check_in'] ? date('d/m/Y',$row['time_check_in']):'-' ?>
                    </div>
                </td>
                <td>
                    <div class="contract-time_expire"
                         data-pk="<?= $row['id'] ?>"
                         data-value="<?= date('d/m/Y',$row['time_expire']) ?>"
                         data-name="time_expire">
                        <?=$row['time_expire'] ? date('d/m/Y',$row['time_expire']):'-' ?>
                    </div>
                </td>
                <td class="text-center">
                    <div class="contract-number_of_month"
                         data-pk="<?= $row['id'] ?>"
                         data-value="<?= $row['number_of_month'] ?>"
                         data-name="number_of_month">
                        <?=$row['number_of_month'] ?>
                    </div>
                </td>
                <td class="text-center">
                    <div>
                        <?php
                        $statusClass = 'muted';
                        if($row['status'] == 'Active') {
                            $statusClass = 'success';
                        }
                        if($row['status'] == 'Pending') {
                            $statusClass = 'warning';
                        }
                        if($row['status'] == 'Cancel') {
                            $statusClass = 'danger';
                        }
                        if($row['status'] == 'Expired') {
                            $statusClass = 'secondary';
                        }
                        ?>
                        <span class="badge badge-<?= $statusClass ?>
                                    font-weight-bold" >
                                    <?= $label_apartment['contract.'.$row['status']] ?>
                                    </span>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>