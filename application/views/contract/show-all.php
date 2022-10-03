<?php
$check_edit = false;
if(isYourPermission($this->current_controller, 'updateEditable', $this->permission_set)){
    $check_edit = true;
}
$check_collapse = false;
if(isYourPermission($this->current_controller, 'isCollapse', $this->permission_set)){
    $check_collapse = true;
}
$metric = [
    'quantity' => 0,
    'total_sale' => 0,
];

$current_month = strtotime(date('01-m-Y'));
foreach ($list_contract as $row) {
    $metric['quantity'] ++;
    $metric['total_sale'] += $row['room_price']*$row['commission_rate']/100;
}
?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item"><a href="#">Khách & Hợp Đồng</a></li>
                            <li class="breadcrumb-item active">Hợp Đồng</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Tất Cả Hợp Đồng</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">

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
                        <div class="col-12">Chọn khoảng <strong>ngày hết hạn</strong></div>
                        <div class="col-6">
                            <input type="text"
                                   id="time_expire_from"
                                   class="form-control datepicker"
                                   value="<?= $this->input->get('timeExpireFrom') ?>">
                        </div>
                        <div class="col-6">
                            <input type="text"
                                   id="time_expire_to"
                                   class="form-control datepicker"
                                   value="<?= $this->input->get('timeExpireTo') ?>">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-4 offset-4">
                            <button id="search" class="btn btn-danger w-100">Áp Dụng</button>
                        </div>
                    </div>


                    <div class="row">


                        <div class="col-md-12">
                            <h4><strong class="text-danger">Chờ duyệt</strong></h4>
                            <div class="row">
                                <?php if(count($list_notification) > 0
                                    && isYourPermission('Contract', 'approved', $this->permission_set) ):
                                    ?>
                                    <div class="col-md-12 text-danger font-weight-bold" id="alert-msg"></div>
                                    <div class="col-md-12">
                                        <!-- end page title end breadcrumb -->
                                        <?php
                                        if($this->session->has_userdata('fast_notify')) {
                                            $flash_mess = $this->session->flashdata('fast_notify')['message'];
                                            $flash_status = $this->session->flashdata('fast_notify')['status'];
                                            unset($_SESSION['fast_notify']);
                                            ?>

                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <?= $flash_mess ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <table style="font-size: 13px;" id="listPending" class="table table-dark">
                                            <thead>
                                            <tr class="">
                                                <th width="150px" class="text-center font-weight-bold">ID HỢP ĐỒNG</th>
                                                <th class="text-center font-weight-bold">Nội dung</th>
                                                <th class="text-center font-weight-bold">Ngày tạo</th>
                                                <th width="100px" class="text-center font-weight-bold">TÙY CHỌN</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($list_notification as $row ):
                                                $contract_checker = $this->ghContract->get([
                                                        'id' => $row["object_id"],
                                                        'status <>' => 'Cancel',
                                                ]);
                                                if(!$contract_checker) continue;
                                                ?>
                                                <tr>
                                                    <td class="text-center"><a target = '_blank'
                                                                               href="/admin/detail-contract?id=<?= $row['object_id']
                                                                               ?>">#<?= 1000+ $row['object_id'] ?></a></td>
                                                    <td>
                                                        <strong>
                                                            <?= $row['message'] ?>
                                                        </strong>

                                                    </td>
                                                    <td class="text-center"><?= date('d/m/Y H:i', $row['time_insert'])?></td>
                                                    <td class="text-center w-25">
                                                        <div class="list-action">
                                                            <a class="m-1" href="/admin/contract/approved?contract-id=<?= $row['object_id'] ?>&id=<?= $row['id'] ?>" >
                                                                <button class="btn btn-sm btn-outline-light btn-rounded waves-light waves-effect">Duyệt</button>
                                                            </a>
                                                            <button data-contract-id="<?= $row['object_id'] ?>" class="contract-cancel btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect">Huỷ</button>
                                                        </div>
                                                        <div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <div class="card-box">
                                            <div class="alert alert-danger" role="alert">
                                                Không có Hợp đồng nào đang chờ chờ duyệt!
                                            </div>
                                        </div>

                                    </div>

                                <?php endif; ?>
                            </div>


                        </div>
                    </div>


                </div>
            </div>

            <div class="col-xs-12 col-md-3">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Số lượng</h6>
                    <h2 class="m-b-20"><span><?= $metric['quantity'] ?></span></h2>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Doanh số</h6>
                    <h2 class="m-b-20"><span><?= number_format($metric['total_sale']) ?></span></h2>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Doanh thu</h6>
                    <h2 class="m-b-20"><span>...</span></h2>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="card-box tilebox-one">
                    <i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">[...]</h6>
                    <h2 class="m-b-20"><span>...</span></h2>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card-box table-responsive">
                    <h4 class="font-weight-bold text-danger">Danh Sách Hợp Đồng Thuê Phòng</h4>
                    <?php $this->load->view("contract/head-navigation") ?>
                    <?php $this->load->view($partialGroup) ?>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
    commands.push(function(){
        $('#search').click(function(){
            let url = '/admin/list-contract?'+
                '&timeCheckInFrom='+$('#time_check_in_from').val()+
                '&timeCheckInTo='+$('#time_check_in_to').val()+
                '&timeExpireFrom='+$('#time_expire_from').val()+
                '&timeExpireTo='+$('#time_expire_to').val();
            window.location = url;

        });


        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });
        $('.contract-cancel').click(function(){
            let _this = $(this);
            let contract_id = $(this).data('contract-id');
            $.ajax({
                url: '<?= base_url() ?>admin/update-contract-editable',
                data: {value: 'Cancel', name: 'status', pk: contract_id},
                method: 'POST',
                success:function(){
                    $('#alert-msg').text("đã huỷ hợp đồng thành công!");
                    _this.closest("tr").remove();
                }
            });
        });
        $('.table-contract').DataTable({
            "pageLength": 10,
            'pagingType': "full_numbers",
            "aaSorting": [],
            responsive: true,
            "fnDrawCallback": function() {
                // x editable
                <?php if($check_edit): ?>

                $('.contract-time_check_in').editable({
                    placement: 'right',
                    type: 'combodate',
                    template:"D / MM / YYYY",
                    format:"DD-MM-YYYY",
                    viewformat:"DD-MM-YYYY",
                    mode: 'popup',
                    combodate: {
                        firstItem: 'name',
                        maxYear: '2030',
                        minYear: '2017'
                    },
                    inputclass: 'form-control-sm',
                    url: '<?= base_url() ?>admin/update-contract-editable',
                    success: function(response) {
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.contract-alert').html(notify_html_success);
                        } else {
                            $('.contract-alert').html(notify_html_fail);
                        }
                    }
                });

                <?php endif; ?>
            } // end fnDrawCallback
        });
    });
</script>
