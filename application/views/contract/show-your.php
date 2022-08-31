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
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Hợp đồng của tôi</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Hợp Đồng Của <?= $this->auth['name'] ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php $this->load->view('components/list-navigation')?>
        </div>
        <?php if($flash_mess):?>
        <div class="row">
            <div class="col-md-8 offset-md-"><div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?= $flash_mess ?>
                </div></div>
        </div>
        <?php endif;?>
        <div class="row">
            <div class="col-12 card-box">
                <table class="table-contract table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="350px">Khách thuê</th>
                        <th>Giá thuê <small>x1000</small></th>
                        <th>Giá cọc <small>x1000</small></th>
                        <th>(*)</th>
                        <th>Ngày ký</th>
                        <th>Ngày hết hạn</th>
                        <th class="text-center">Thời hạn</th>
                        <th class="text-center" width="100px">Trạng Thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list_contract as $row ): ?>
                        <?php $service = json_decode($row['service_set'], true) ?>
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
                                <div class="font-weight-bold text-primary"> <i class=" dripicons-home"></i>
                                    <?php
                                    $apartment = $ghApartment->get(['id' => $row['apartment_id']]);
                                    $room = $ghRoom->get(['id' => $row['room_id']]);
                                    $room = $room ? $room[0]:null;
                                    ?>
                                    <?= $apartment ? $apartment[0]['address_street']:'' ?> <?= $room ? "(" . $room['code']. ")" : '[không có mp]' ?>
                                </div>
                            </td>
                            <td>
                                <div class="contract-room_price font-weight-bold"
                                     data-pk="<?= $row['id'] ?>"
                                     data-value="<?= $row['room_price'] ?>"
                                     data-name="room_price">
                                    <?= number_format($row['room_price']/1000) ?>
                                </div>
                                <?php if(!empty($row['consultant_support_id'])): ?>
                                    <div class="font-weight-bold">
                                        (H.trợ: <?= $libUser->getNameByAccountid($row['consultant_support_id']) ?>)
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="font-weight-bold"><?= number_format($row["deposit_price"]/1000) ?></td>
                            <td class="font-weight-bold"><?= $row["rate_type"] *1 ?></td>
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
                            <td class="text-right">
                                <div class="contract-number_of_month"
                                     data-pk="<?= $row['id'] ?>"
                                     data-value="<?= $row['number_of_month'] ?>"
                                     data-name="number_of_month">
                                    <?=$row['number_of_month'] ?> tháng
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
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?>
                                    font-weight-bold">
                                    <?=  $doc_type ?>
                                    </span>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    commands.push(function(){
        $('.table-contract').dataTable({
            "order": []
        });
    });
</script>