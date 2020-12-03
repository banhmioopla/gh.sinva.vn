<?php
$check_delete = isYourPermission('Image', 'delete', $this->permission_set);

?>


<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>

                </div>
            </div>

            <div class="col-12 col-md-8 offset-md-2">
                <div class="card-box shadow">
                    <h3 class="text-center">Chi tiết khách hàng</h3>
                    <p class="text-center text-dark"><?= $customer['name'] ?></p>
                    <p class="text-center text-warning font-weight-bold">Sinh Nhật: <?=
                        $customer['birthdate'] ? date('d/m/Y',$customer['birthdate']) :
                            '[không có thông tin]' ?></p>
                    <p><a href="/admin/list-customer" class="text-danger"><i class="mdi
                     mdi-arrow-left-bold-circle"></i> Quay Lại Danh Sách</a></p>
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-right"
                                width="200px"><strong>Trạng Thái
                                    <strong></td>
                            <td>
                                <div class="w-100 "
                                     data-name="status"><span class="badge
                                     badge-info font-weight-bold contract-status"><?=
                                        $label[$customer['status']]
                                        ?></span>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Họ Tên <strong></td>
                            <td>
                                <div class="customer-name w-50"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['name'] ?>"
                                     data-name="name"><?= $customer['name'] ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Ngày Sinh <strong></td>
                            <td>
                                <div class="customer-birthdate w-50"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['birthdate'] > 0 ? date('d/m/Y', $customer['birthdate']) : '' ?>"
                                     data-name="birthdate"><?= $customer['birthdate'] > 0 ? date('d/m/Y', $customer['birthdate']) : '' ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Giới Tính <strong></td>
                            <td>
                                <div class="customer-gender w-50"
                                     data-name="gender"><?= $customer['gender'] ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Số điện thoại <strong></td>
                            <td>
                                <div class="customer-phone w-50"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['phone'] ?>"
                                     data-name="phone"><?= $customer['phone'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Email <strong></td>
                            <td>
                                <div class="customer-email w-50"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['email'] ?>"
                                     data-name="email"><?= $customer['email'] ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Nguồn <strong></td>
                            <td>
                                <div class="customer-source w-50"
                                     data-name="source"><?= $customer['source'] ?
                                    $label[$customer['source']] : '[không có thông tin]'
                                    ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Ghi Chú Khách Thuê <strong>
                            </td>
                            <td>
                                <div class="customer-note w-50"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['note'] ?>"
                                     data-name="note"><?= $customer['note'] ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Nhu Cầu Giá<strong></td>
                            <td>
                                <div class="customer-demand_price w-50"
                                     data-name="room_price"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['demand_price'] ?>"><?=
                                    number_format($customer['demand_price']) . ' VND'
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Nhu Cầu Quận<strong></td>
                            <td>
                                <div class="customer-demand_district_code w-50"
                                     data-name="demand_district_code"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value=""><?= $customer['demand_district_code'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Nhu Cầu Thời Gian<strong></td>
                            <td>
                                <div class="customer-demand_time w-50"
                                     data-name="demand_time"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['demand_time'] > 0 ? date
                                     ('d/m/Y',$customer['demand_time']) : '' ?>">
                                    <?= $customer['demand_time'] > 0 ? date('d/m/Y',$customer['demand_time']) : ''
                                    ?></div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-right"><strong>Ngày Nhập<strong></td>
                            <td>
                                <div class="customer-time_insert w-50"
                                     data-name="time_insert"
                                     data-pk="<?= $customer['id'] ?>"
                                     data-value="<?= $customer['time_insert'] > 0 ? date
                                     ('d/m/Y',$customer['time_insert']) : '' ?>">
                                    <?= $customer['time_insert'] > 0 ? date('d/m/Y',$customer['time_insert']) : ''
                                    ?></div>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
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
            <?php if($check_edit): ?>

            $('.customer-phone, .customer-email, .customer-name').editable({
                type: "text",
                url: '<?= base_url() ?>admin/update-customer-editable',
                inputclass: '',
            });
            $('.customer-note').editable({
                placement: 'top',
                type: "textarea",
                url: '<?= base_url() ?>admin/update-customer-editable',
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
            $('.customer-time_insert').editable({
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
                url: '<?= base_url() ?>admin/update-customer-editable',
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });
            $('.customer-note').editable({
                type: 'textarea',
                url: '<?= base_url() ?>admin/update-customer-editable',
                inputclass: '',
            });
            $('.customer-demand_price').editable({
                type: 'number',
                url: '<?= base_url() ?>admin/update-customer-editable',
                inputclass: 'form-control-sm',
            });
            $('.customer-demand_district_code').editable({
                type: 'select',
                url: '<?= base_url() ?>admin/customer-get-district',
                inputclass: '',
                source: function() {
                    data = [];
                    $.ajax({
                        url: '<?= base_url() ?>admin/customer-get-district',
                        dataType: 'json',
                        async: false,
                        success: function(res) {
                            data = res;
                            return res;
                        }
                    });
                    return data;
                },
            });
            $('.customer-birthdate, .customer-demand_time').editable({
                url: '<?= base_url() ?>admin/update-customer-editable',
                placement: 'right',
                emptytext: 'rỗng',
                type: 'combodate',
                template:"D MM YYYY",
                format:"DD-MM-YYYY",
                viewformat:"DD-MM-YYYY",
                mode: 'popup',
                combodate: {
                    firstItem: 'name'
                },
                inputclass: 'form-control-sm',
            });
            <?php endif; ?>
        });
    });
</script>