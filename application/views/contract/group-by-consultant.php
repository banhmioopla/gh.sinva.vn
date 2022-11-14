<?php
$list_user = $this->ghUser->get([
    "active" => "YES"
]);

$list_team = $this->ghTeam->get();
?>

<?php foreach ($list_team as $team):
    $list_user = $this->ghTeamUser->getByTeamId($team['id']);

    ?>
    <h4 class="font-weight-bold text-danger mt-md-2">Nhóm <?= $team["name"] ?></h4>
    <table class="table-contract  table table-dark table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th width="350px">Khách thuê</th>
            <th class="text-right">Giá thuê <small>x1000</small></th>
            <th class="text-right">Giá cọc <small>x1000</small></th>
            <th class="text-right"> <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <i class="mdi mdi-star-circle"></i> </span></th>

            <th>Ngày ký</th>
            <th>Ngày hết hạn</th>
            <th class="text-center">Thời hạn</th>
            <th class="text-center" width="100px">Trạng Thái</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list_user as $member): ?>
            <?php
            $user = $this->ghUser->getFirstByAccountId($member['user_id']);
            $user_list_contract = $this->ghContract->get([
                'status <>' => 'Cancel',
                'time_check_in >=' => strtotime($time_from),
                'time_check_in <=' => strtotime($time_to)+86399,
                'consultant_id' => $user["account_id"]
            ]);
            if(count($user_list_contract) == 0 ) continue;

            ?>
            <tr class="border border-warning mt-2">
                <td colspan="3"><h4><?= $user["name"] ?></h4> <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <i class="mdi mdi-star-circle"></i> <?= $this->ghContract->getTotalRateStar($user["account_id"], $time_from, $time_to) ?></span></td>
                <td colspan="10"> <?= count($user_list_contract) ?> hợp đồng </td>
            </tr>
            <?php foreach($user_list_contract as $row ): ?>
                <?php
                $service = json_decode($row['service_set'], true);
                $partial_amount = 0;
                $list_partial = $ghContractPartial->get(['contract_id' => $row['id']]);
                foreach ($list_partial as $item) {
                    $partial_amount += $item['amount'];
                }

                ?>
                <tr>
                    <td class="text-right">
                        <a target = '_blank'
                           href="/admin/detail-contract?id=<?= $row['id']
                           ?>">#<?= (10000 + $row['id']) ?></a>
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
                        <?php
                        $supporter = [];
                        if(!empty($row['arr_supporter_id'])){
                            $list_supporter = json_decode($row['arr_supporter_id'], true);
                            foreach ($list_supporter as $item){
                                $supporter [] = $libUser->getNameByAccountid($item);
                            }
                        }

                        ?>

                        <?php if(count($supporter)): ?>
                            <div class=" text-light text-right font-weight-bold">
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
                    <td class="font-weight-bold text-center"> <?= (float) $row['rate_type'] ?></td>
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

        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>
