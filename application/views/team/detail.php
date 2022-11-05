<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GH</a></li>
                            <li class="breadcrumb-item"><a href="#">Chi nhánh</a></li>
                            <li class="breadcrumb-item active"><?= $team['name'] ?></li>
                        </ol>
                    </div>
                    <h2 class="text-danger font-weight-bold">Team | <?= $team['name'] ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
        </div>
        <div class="district-alert"></div>
        <div class="row">
            <div class="col-xs-12 col-md-3 ">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Tổng Số Lượng Hợp Đồng</h6>
                    <h2 class="m-b-20"><span ><?= $libUser->getNumberContractByTeam($team['id'], $timeFrom, $timeTo) ?></span></h2>
                </div>
            </div>

            <div class="col-xs-12 col-md-3 ">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Tổng Doanh Số</h6>
                    <h2 class="m-b-20"><span ><?= $libUser->getTotalSaleByTeam($team['id'], $timeFrom, $timeTo) ?></span></h2>
                </div>
            </div>

            <div class="col-12">
                <div class="card-box">
                    <form>
                        <input type="hidden" name="id" value="<?= $team['id'] ?>">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <strong>Khoảng ngày Từ</strong>
                                <input type="text" class="form-control datepicker mt-1 mb-2" name="timeFrom" value="<?= $timeFrom ?>" >
                            </div>
                            <div class="col-md-3">
                                <strong>Khoảng ngày Đến</strong>
                                <input type="text" class="form-control datepicker mt-1 mb-2" name="timeTo" value="<?= $timeTo ?>">
                            </div>
                            <div class="col-12 float-right">
                                <button type="submit" class="btn btn-danger mt-2 pull-right mb-2">TÌM KIẾM</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h3 class="text-danger font-weight-bold"><?= $team['name'] ?> | Danh Sách Hợp Đồng</h3>
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
                        <?php foreach ($list_member as $member): ?>
                            <?php
                            $user = $this->ghUser->getFirstByAccountId($member['user_id']);
                            $user_list_contract = $this->ghContract->get([
                                'status <>' => 'Cancel',
                                'time_check_in >=' => strtotime($timeFrom),
                                'time_check_in <=' => strtotime($timeTo)+86399,
                                'consultant_id' => $user["account_id"]
                            ]);
                            ?>
                            <tr class="border border-warning mt-2">
                                <td colspan="3"><h4><?= $user["name"] ?></h4> <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <i class="mdi mdi-star-circle"></i> <?= $this->ghContract->getTotalRateStar($user["account_id"], $timeFrom, $timeTo) ?></span></td>
                                <td colspan="10"> <?= count($user_list_contract) ?> hợp đồng </td>
                            </tr>
                            <?php foreach($user_list_contract as $row ): ?>
                                <?php
                                $service = json_decode($row['service_set'], true);
                                $partial_amount = 0;
                                $list_partial = $this->ghContractPartial->get(['contract_id' => $row['id']]);
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
                                        <div><?= $this->libCustomer->getNameById($row['customer_id']).' - '. $this->libCustomer->getPhoneById($row['customer_id']) ?> </div>
                                        <div class="font-weight-bold text-warning"> <i class=" dripicons-home"></i>
                                            <?php
                                            $apartment = $this->ghApartment->get(['id' => $row['apartment_id']]);
                                            $room = $this->ghRoom->get(['id' => $row['room_id']]);
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
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h3 class="text-danger font-weight-bold">Thêm Thành Viên Mới</h3>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-team-user">
                        <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Thành Viên<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" required class="form-control"
                                        id="name" name="user_id">
                                    <?= $list_user ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                   <i class="fa fa-user-plus"></i> THÊM MỚI
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('select').select2();
            $('#table-member').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true
            });

            $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });

        });
    });
</script>