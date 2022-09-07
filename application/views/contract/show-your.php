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
                    <h2 class="font-weight-bold text-danger">Hợp Đồng - <?= $this->auth['name'] ?></h2>
                </div>
            </div>
        </div>
        <div class="text-center">
            <?php $this->load->view('components/list-navigation')?>
        </div>



        <div class="row">
            <div class="col-12 card-box">
                <h4><strong class="text-danger">Tìm kiếm</strong></h4>
                <div class="row">

                    <div class="col-12">Chọn khoảng <strong>ngày ký</strong></div>
                    <div class="col-6">
                        <input type="text" class="form-control datepicker"
                               id="time_check_in_from"
                               value="<?= $timeCheckInFrom?>">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control datepicker"
                               id="time_check_in_to"
                               value="<?= $timeCheckInTo  ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4 offset-4">
                        <button id="search" class="btn btn-danger w-100">Áp Dụng</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one">
                    <i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Doanh số</h6>
                    <h2 class="m-b-20" data-plugin="counterup"><?= number_format($this->ghContract->getTotalSaleByUser($this->auth['account_id'], $timeCheckInFrom, $timeCheckInTo)) ?></h2>
                    <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <?= $this->ghContract->getTotalRateStar($this->auth['account_id'], $timeCheckInFrom, $timeCheckInTo) ?> </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 card-box">
                <table class="table-contract table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="350px">Khách thuê</th>
                        <th>Giá thuê <small>x1000</small></th>
                        <th>Giá cọc <small>x1000</small></th>
                        <th class="text-center"><span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <i class="mdi mdi-star-circle"></i> </span></th>
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
                                <?php
                                $supporter = [];
                                if(!empty($row['arr_supporter_id'])){
                                    $list_supporter = json_decode($row['arr_supporter_id'], true);
                                    foreach ($list_supporter as $item){
                                        $supporter [] = $libUser->getNameByAccountid($item);
                                    }
                                }

                                ?>
                                <div class="contract-room_price font-weight-bold"
                                     data-pk="<?= $row['id'] ?>"
                                     data-value="<?= $row['room_price'] ?>"
                                     data-name="room_price">
                                    <?= number_format($row['room_price']/1000) ?>
                                </div>
                                <?php if(count($supporter)): ?>
                                    <div class=" text-light font-weight-bold">
                                        (H.trợ: <?= implode(", ",$supporter) ?>)
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="font-weight-bold"><?= number_format($row["deposit_price"]/1000) ?></td>
                            <td class="font-weight-bold text-center"><?= $row["rate_type"] *1 ?></td>
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
            "pageLength": 10,
            'pagingType': "full_numbers",
            "aaSorting": [],
            "responsive": true,
        });

        $('#search').click(function(){
            let url = '/admin/list-personal-contract?'+
                '&timeCheckInFrom='+$('#time_check_in_from').val()+
                '&timeCheckInTo='+$('#time_check_in_to').val();
            window.location = url;

        });
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });
    });
</script>