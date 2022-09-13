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
                </div>

            </div>
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

            <div class="col-12">
                <div class="card-box shadow">
                    <h3 class="text-center">Chi tiết hợp đồng</h3>
                    <p class="text-center text-dark"><?= $apartment ? $apartment['address_street'] : '[không có thông tin]'
                        ?></p>
                    <p class="text-center text-warning font-weight-bold">Mã Phòng: <?=
                        $room ? $room['code'] : '[không có thông tin]' ?></p>
                    <p><a href="/admin/list-contract" class="text-danger"><i class="mdi
                     mdi-arrow-left-bold-circle"></i> Quay Lại Danh Sách</a></p>
                    <table class="table table-bordered table-hover">

                        <tr class="text-right">
                            <td colspan="2" class="text-right" width="250px">
                                <div class="customer-name w-100">
                                    <?php if($notification_object_id && $check_approve): ?>
                                    <a class="btn btn-danger mr-2"
                                       href="/admin/contract/approved?contract-id=<?= $notification_object_id ?>&id=<?= $contract['id'] ?>">Duyệt</a>
                                    <?php endif; ?>
                                    <button class="btn btn-danger contract-cancel"
                                            data-contract-id="<?= $contract['id'] ?>">Hủy Hợp Đồng</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"
                                width="200px"><strong>Trạng Thái
                                    <strong></td>
                            <td>
                                <div class=" w-100 "><span class="badge
                                     badge-<?= $status ?> font-weight-bold contract-status"><?= $doc_type ?></span> <?= $txt_partial ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Thành Viên Chốt Sale<strong></td>
                            <td>
                                <div class="consultant_id "
                                     data-pk="<?= $contract['id'] ?>"
                                     data-placement="top"
                                     data-name="consultant_id">
                                    <?= $contract['consultant_id'] >= 171020000 ?
                                        $libUser->getNameByAccountid($contract['consultant_id']) : '[không có thông tin]' ?> <span class="badge ml-2 badge-pill badge-primary font-weight-bold contract-status"> <i class="mdi mdi-star-circle"></i> <?= (float) $contract['rate_type'] ?></span></div>
                            </td>
                        </tr>
                        <tr>
                            <?php
                            $supporter = [];
                            if(!empty($contract['arr_supporter_id'])){
                                $list_supporter = json_decode($contract['arr_supporter_id'], true);
                                foreach ($list_supporter as $item){
                                    $supporter [] = $libUser->getNameByAccountid($item);
                                }
                            }

                            ?>
                            <td class="text-right"><strong>Thành Viên Hỗ Trợ (<?= count($supporter) ?>) <strong></td>
                            <td>

                                <div class="arr_supporter_id w-50"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-placement="top"
                                     data-name="arr_supporter_id">
                                    <?= count($supporter) > 0 ? implode(", ",$supporter): '[không có thông tin]' ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Hình Ảnh <strong></td>
                            <td>
                                <?php if (count($image) > 0): ?>

                                    <?php foreach ($image as $ii): ?>
                                        <div class="mb-3 xxx">
                                            <a target='_blank'
                                               href="<?= $image ? '/media/contract/'
                                                   . $ii['name'] : '#' ?>"><?= $ii['name'] ?></a>

                                            <?php
                                             if($check_delete):

                                            ?>
                                            <button class="btn btn-danger
                                                btn-sm delete-img float-md-right
                                                ml-3"
                                                    data-img-id="<?= $ii['id'] ?>"
                                                    data-img-name="<?= $ii['name'] ?>"
                                            ><i
                                                        class="dripicons-trash"
                                                        style="font-size: 10px;"
                                                ></i></button>
                                            <?php endif; ?>
                                            <br>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                <?php endif; ?>
                                <form method="post" enctype="multipart/form-data"
                                      class="form-group"
                                      action="/admin/create-contract?controller-name=Contract&&contract-id=<?= $contract['id'] ?>">
                                    <div class="choose-img" style="">
                                        <div class="demo-box row">
                                            <div class="form-group col-md-2">
                                                <input type="file"
                                                       required
                                                       class="filestyle"
                                                       name="files[]" multiple
                                                       data-input="false"
                                                       data-text="chọn ảnh..."
                                                       data-btnClass="btn-danger
                                                           btn-sm">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" name="fileSubmit"
                                                        value="UPLOAD" class=" btn
                                                    btn-custom waves-effect waves-light">
                                                    <i class="mdi mdi-upload"> thêm
                                                        mới</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Tên Khách Thuê <strong></td>
                            <td>
                                <div><?= $customer['name'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ngày Sinh <strong></td>
                            <td>
                                <div><?= $customer['birthdate'] > 0 ? date('d/m/Y', $customer['birthdate']) : '' ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Số điện thoại <strong></td>
                            <td>
                                <div><?= $customer['phone'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Ghi Chú Khách Thuê <strong>
                            </td>
                            <td>
                                <div><?= $customer['note'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Dự Án Thuê <strong></td>
                            <td>
                                <div> <?= $apartment ? $apartment['address_street'] : '[không có thông tin]'
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Mã Phòng <strong></td>
                            <td>
                                <div> <?= $room ? $room['code'] : '[không có thông tin]'
                                    ?></div>
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

                        <tr>
                            <td class="text-right"><strong>Ngày Nhập<strong></td>
                            <td>
                                <div
                                        class="contract-time_insert w-50"
                                        data-name="time_insert"
                                        data-pk="<?= $contract['id'] ?>"
                                        data-value="<?= date('d/m/Y', $contract['time_insert'])?>"
                                >
                                <?= $contract['time_insert'] > 0 ? date('d/m/Y', $contract['time_insert']) : '#' ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Ghi Chú Hợp Đồng <strong></td>
                            <td>
                                <div class="contract-note w-50"
                                     data-name="note"
                                     data-pk="<?= $contract['id'] ?>"
                                     data-value="<?= $contract['note'] ?>"><?=
                                    $contract['note'] ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Thông Tin Dịch Vụ, Ghi Chú Tòa
                                    Nhà <br>
                                    (tại thời điểm tạo HD) <strong></td>
                            <td>
                                <div class="customer-name" data-name="name">
                                    <?php if($service && count($service) > 0):?>
                                    <?php foreach ($service as $k => $v): ?>
                                        <?= isset($label[$k]) && $k != 'commission_rate' ? '<strong>'
                                            . $label[$k]
                                            . '</strong> : (' . $v . ')<br>' : '' ?>
                                    <?php endforeach; ?>
                                    <?php else: echo '[không có thông tin]'?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <?php
        if (isYourPermission($this->current_controller, 'deletePartial', $this->permission_set)){
            $this->load->view('contract/contract-partial');
        }
         ?>
    </div>
</div>
<?php
$check_edit = false;
if (isYourPermission($this->current_controller, 'updateEditable', $this->permission_set)) {
    $check_edit = true;
}

?>
<script type="text/javascript">
    commands.push(function () {
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy"
            });
            <?php if($check_edit): ?>
            $('.delete-img').click(function () {
                let this_btn = $(this);
                let img_id = $(this).data('img-id');
                let img_name = $(this).data('img-name');
                let controller_name = 'Contract';
                swal({
                    title: 'Xác nhận xóa vĩnh viễn ảnh này ',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-confirm mt-2',
                    cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                    confirmButtonText: 'Xóa',
                }).then(function () {
                    $.ajax({
                        url: '<?= base_url() ?>admin/delete-image',
                        method: 'post',
                        data: {
                            img_name: img_name,
                            img_id: img_id,
                            controller_name: controller_name
                        },
                        success: function () {
                            $(this).closest('div').remove();
                            console.log(this_btn.parents(".xxx").remove());
                        }
                    });
                    swal({
                        title: 'Đã Xóa Thành Công!',
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    });
                })
            });



            $('.consultant_support_id').editable({
                type: 'select',
                url: '<?= base_url() ?>admin/update-contract-editable',
                inputclass: '',
                source: function() {
                    data = [];
                    $.ajax({
                        url: '<?= base_url() ?>admin/user/get-select',
                        dataType: 'json',
                        async: false,
                        success: function(res) {
                            data = res;
                            return res;
                        }
                    });
                    return data;
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.apartment-alert').html(notify_html_success);
                    } else {
                        $('.apartment-alert').html(notify_html_fail);
                    }
                    $('.apartment-alert').show();
                    $('.apartment-alert').fadeOut(3000);
                }
            });

            $('.contract-room_price, .contract-deposit_price, .contract-number_of_month, .contract-commission_rate').editable({
                type: "text",
                url: '<?= base_url() ?>admin/update-contract-editable',
                inputclass: '',
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });
            $('.contract-note').editable({
                placement: 'top',
                type: "textarea",
                url: '<?= base_url() ?>admin/update-contract-editable',
                inputclass: '',
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });
            $('.contract-time_expire, .contract-time_check_in, .contract-time_insert').editable({
                placement: 'top',
                type: 'combodate',
                template: "D / MM / YYYY",
                format: "DD-MM-YYYY",
                viewformat: "DD-MM-YYYY",
                mode: 'popup',
                combodate: {
                    firstItem: 'name',
                    maxYear: '2030',
                    minYear: '2017'
                },
                inputclass: 'form-control-sm',
                url: '<?= base_url() ?>admin/update-contract-editable',
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });

            $('.contract-cancel').click(function(){
                let contract_id = $(this).data('contract-id');
                $.ajax({
                    url: '<?= base_url() ?>admin/update-contract-editable',
                    data: {value: 'Cancel', name: 'status', pk: contract_id},
                    method: 'POST',
                    success:function(){
                        $('.contract-status').text('đã hủy');
                        $('.contract-status').removeClass('badge-warning');
                        $('.contract-status').removeClass('badge-success');
                        $('.contract-status').removeClass('badge-secondary');
                        $('.contract-status').addClass('badge-danger');
                    }
                });
            });
            <?php endif; ?>

        });
    });
</script>