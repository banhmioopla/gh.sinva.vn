<?php
$check_delete = isYourPermission('Image', 'delete', $this->permission_set);
$check_approve = isYourPermission('Contract', 'approved', $this->permission_set);
$checkPartial = isYourPermission('Contract', 'approved', $this->permission_set);

$total_partial = 0;
foreach ($list_partial as $item) {
    $total_partial += $item['amount'];
}

$txt_partial = '';
if($total_partial >= ($contract['room_price']*$contract['commission_rate'])/100) {
    $txt_partial = '<span class="badge badge-primary font-weight-bold contract-status">đã thu đủ</span>';
}

?>
<?php
$customer = $ghCustomer->get(['id' => $contract['customer_id']]);
$customer  = $customer ? $customer[0] : null;
$room = $ghRoom->get(['id' => $contract['room_id']]);
$room = $room ? $room[0] : null;
$apartment = $ghApartment->get(['id' => $contract['apartment_id']]);
$apartment = $apartment ? $apartment[0] : null;
$service = $contract['service_set'] ? json_decode($contract['service_set'],true) : null;

$image = $ghImage->getContract($contract['id']);

?>

<?php
$status = 'muted'; $doc_type = "Cọc ";
if($contract['status'] == 'Active') {
    $status = 'success';
}
if($contract['status'] == 'Pending') {
    $status = 'warning';
    $doc_type .= " Chờ duyệt";
}

if(time() >= $contract["time_check_in"]){
    $status = "HĐ đã ký ";
}
if(time() >= $contract["time_expire"]){
    $doc_type = "HĐ hết hạn ";
    $status = 'secondary';
}
?>

<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item"><a href="#">Hợp Đồng</a></li>
                            <li class="breadcrumb-item active"># <?= $contract['id'] ?></li>
                        </ol>
                    </div>
                    <h4 class="font-weight-bold text-danger">Xác nhận</h4>
                </div>
            </div>


            <div class="col-12">
                <div class="card-box shadow">
                    <p><a href="/admin/detail-contract?id=<?= $contract['id'] ?>">Xem chi tiết</a></p>
                    <h4 class="font-weight-bold text-danger"><?= $apartment["address_street"] .", phường "
                        . $apartment["address_ward"] .", Quận "
                        . ($this->libDistrict->getNameByCode($apartment["district_code"])) . " | Phòng " . $room['code'] ?></h4>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td class="text-right" width="40%"><strong>Thành Viên Chốt Sale<strong></td>
                            <td>
                                <div class="consultant_id "
                                     data-pk="<?= $contract['id'] ?>"
                                     data-placement="top"
                                     data-name="consultant_id">
                                    <?= $contract['consultant_id'] >= 171020000 ?
                                        $libUser->getNameByAccountid($contract['consultant_id']) : '[không có thông tin]' ?> </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Tên Khách Thuê <strong></td>
                            <td>
                                <div><?= $customer['name'] ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Giá Thuê<strong></td>
                            <td>
                                <div class="contract-room_price w-50"
                                     data-name="room_price"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['room_price'] ?>"><?= number_format($contract['room_price']) . ' VND' ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Giá Cọc<strong></td>
                            <td>
                                <div class="contract-deposit_price w-50"
                                     data-name="deposit_price"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['deposit_price'] ?>"><?= number_format($contract['deposit_price']) . ' VND' ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Hoa Hồng Ký Gửi<strong></td>
                            <td>
                                <div class="contract-commission_rate w-50"
                                     data-name="commission_rate"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['commission_rate']
                                     ?>"><?= $contract['commission_rate'] ?>%</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Ký<strong></td>
                            <td>
                                <div class="contract-time_check_in w-50"
                                     data-name="time_check_in"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= date('d/m/Y', $contract['time_check_in']) ?>"><?= $contract['time_check_in'] > 0 ? date('d/m/Y', $contract['time_check_in']) : '' ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Thời Hạn<strong></td>
                            <td>
                                <div class="contract-number_of_month w-50"
                                     data-name="number_of_month"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['number_of_month'] ?>"><?= $contract['number_of_month'] . ' tháng' ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Hết Hạn<strong></td>
                            <td>
                                <div class="contract-time_expire w-50"
                                     data-name="time_expire"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= date('d/m/Y', $contract['time_expire'])
                                     ?>"><?= $contract['time_expire'] > 0 ? date('d/m/Y', $contract['time_expire']) : '' ?></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>

<script type="text/javascript">
    commands.push(function () {
        $(document).ready(function () {
            $('.logo .text-success').text("")

        });
    });
</script>