<?php

$metric = [
    'quantity' => 0,
    'cd_general' => 0,
    'cd_high' => 0,
];
$user_birth_this_month = [];
$user_cd_high = [];
foreach ($list_user as $row) {
    if($row['active'] == "YES") {
        $metric['quantity']++;

        if(in_array($row['account_id'], $this->arr_general)) {
            $metric['cd_general']++;
        }


        if($libRole->isControlDepartment($row['role_code']) === true) {
            $metric['cd_high']++;
            $user_cd_high[] = $row['account_id'];
        }

        if($this->input->get('birthDay')) {
            $month = $this->input->get('birthDay');
            $user_month = date('m',$row['date_of_birth']);
            if($user_month == $month) {
                $user_birth_this_month[] = $row;

            }
        } else {
            redirect('/admin/list-user?birthDay='.date('m'));
        }
    }
}
?>


<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Thành Viên</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Danh sách nhân sự</h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($this->session->has_userdata('fast_notify')) {
                $flash_mess = $this->session->flashdata('fast_notify')['message'];
                $flash_status = $this->session->flashdata('fast_notify')['status'];
                unset($_SESSION['fast_notify']);
            }  
        ?>

        <div class="row">
            <div class="col-12">
                <div class="user-alert"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="text-danger font-weight-bold">Danh sách nhân sự</h4>
                    <form class="row mb-3" method="GET">
                        <div class="col-md-3">
                            <select name="" id="" class="form-control select2">
                                <option value="">Chọn thành viên ...</option>
                                <?php foreach ($list_all_user as $uu): ?>
                                    <option value="<?= $uu['account_id'] ?>"><?= $uu['name'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="date_of_birth" id="" class="form-control">
                                <option value="">Tháng sinh nhật ...</option>
                                <?php for($i = 1; $i <=12; ++$i):?>
                                    <option value="<?= $i ?>">Tháng <?= str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="" id="" class="form-control">
                                <option value="">Ngày vào làm ...</option>
                            </select>
                        </div>
                        <div class="col-md-3">

                            <select name="active" class="form-control">
                                <option value="">Trạng thái</option>
                                <option value="YES">Mở </option>
                                <option value="NO">Đóng</option>
                            </select>
                        </div>
                    </form>
                    <table class="table table-user table-bordered mt-3">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Tên</th>

                            <th>Quyền</th>
                            <th>Thông tin</th>
                            <th>Người Tuyển</th>
                            <th class="text-center">Mở</th>
                            <th class="text-center">Tùy chọn</th>
                            <!-- <th class="text-center">Tùy Chọn</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user as $row ): ?>
                            <tr>
                                <td>
                                    <u>
                                        <a target="_blank"
                                           class="text-danger"
                                           href="/admin/personal-profile?account_id=<?= $row['account_id'] ?>">
                                            <?= $row['account_id'] ?>
                                        </a>
                                    </u>

                                </td>
                                <td>
                                    <div class="user-name user"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                        <?= $row['name'] ?>
                                    </div>
                                    <p><small></small></p>
                                </td>

                                <td>
                                <div class="user-role_code"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-value = "<?= $row['role_code'] ?>"
                                        data-name="role_code"><?= $libRole->getNameByCode($row['role_code']) ?></div>
                                </td>
                                <td>
                                    <ul>
                                        <li>Sinh nhật: <strong><?= $row['date_of_birth'] > 0 ? date('d-m-Y',$row['date_of_birth']) :'' ?></strong></li>

                                        <li>Phone: <strong class="user-phone_number" data-name="phone_number" data-value ="<?= $row['phone_number'] ?>" data-pk="<?= $row['id'] ?>"><?= $row['phone_number'] ?></strong></li>
                                        <li>Mail: <strong class="user-email" data-name="email" data-value ="<?= $row['email'] ?>" data-pk="<?= $row['id'] ?>"><?= $row['email'] ?></strong></li>
                                        <li>Ngày làm: <strong><?= $row['time_joined'] > 0 ? date('d-m-Y',$row['time_joined']) :'' ?></strong></li>
                                    </ul>
                                </td>

                                <td>
                                    <div class="user-user_refer_id user"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="user_refer_id"
                                         data-value="<?= $row['user_refer_id'] ?>">
                                        <?= $libUser->getNameByAccountid($row['user_refer_id']) ?>
                                    </div>
                                </td>
                                

                                <td class="text-center">
                                    <?php 
                                        $classStatus = 'danger';
                                        $txtStatus = 'đóng';
                                        if($row['active'] =='YES') {
                                            $classStatus = 'success';
                                            $txtStatus = 'mở';
                                        }
                                    ?>
                                    <div>
                                        <span style="" class=" badge badge-<?= $classStatus ?> badge-pill"><?= $txtStatus ?></span>
                                    </div>
                                    
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a class="btn m-1 btn-sm btn-outline-info btn-rounded waves-light waves-effect "
                                           target="_blank" href="/admin/user/edit?account_id=<?= $row['account_id'] ?>">Cập nhật</a>
                                    </div>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h3>Thêm mới</h3>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-user">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Tên Thành Viên<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="Họ tên thành viên">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_of_birth" class="col-md-4 col-12 col-form-label">Ngày Sinh<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control datepicker"
                                        id="date_of_birth" name="date_of_birth" placeholder="31/12/1999">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_joined" class="col-md-4 col-12 col-form-label">Ngày Vào Làm<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control datepicker"
                                        id="time_joined" name="time_joined" placeholder="<?= date('d/m/Y') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-12 col-form-label">Số điện thoại<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                        id="phone_number" name="phone_number" placeholder="0911123123">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="account_id" class="col-md-4 col-12 col-form-label">ID thành viên<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                        id="account_id" name="account_id" readonly value="<?= $max_account_id + 1 ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="user_refer_id" class="col-md-4 col-12 col-form-label">Thành Viên Tuyển<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <select type="number" class="form-control"
                                        id="user_refer_id" name="user_refer_id">
                                    <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở</label>
                            <div class="col-8">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <input id="active" type="checkbox" checked value="YES" name="active">
                                        <label for="active">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
                                    Thêm mới
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
        $('.select2').select2();


        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.buttons =
            '<div class="d-flex justify-content-center mt-2">' +
                '<button type="submit" class="btn btn-primary btn-sm editable-submit">'+
                    '<i class="fa fa-fw fa-check"></i>'+
                '</button>'+
                '<button type="button" class="btn btn-default btn-sm editable-cancel">'+
                    '<i class="fa fa-fw fa-times"></i>'+
                '</button>'+
            '</div>';

        /* =========== MODIFY DATA JS ========= */
        // if(modify_mode == false) return;

        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy"
            });
            $('#user_refer_id').select2();
            $('.table-user').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    
                    $('.user-date_of_birth, .user-time_joined').editable({
                        placement: 'right',
                        type: 'combodate',
                        template:"D / MM / YYYY",
                        format:"DD-MM-YYYY",
                        viewformat:"DD-MM-YYYY",
                        
                        mode: 'inline',
                        combodate: {
                            firstItem: 'name',
                            maxYear: '2025',
                            minYear: '1990'
                        },
                        inputclass: 'form-control-sm',
                        url: '<?= base_url()."admin/update-user-editable" ?>'
                    });
                    $('.is-active-user input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var user_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-user',
                            data: {field_value: is_active, user_id: user_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                if(data.status == false) {
                                    $('.user-alert').html(notify_html_fail);
                                } else {
                                    $('.user-alert').html(notify_html_success);
                                }
                            },
                            beforeSend: function(){
                                $('#loader').show();
                            },
                            complete: function(){
                                $('#loader').hide();
                            }
                        });
                    });

                    $('.user-name, .user-email, .user-phone_number, .user-user_refer_id').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-user-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.user-alert').html(notify_html_success);
                            } else {
                                $('.user-alert').html(notify_html_fail);
                            }
                        }
                    });
                    
                    $('.delete-user').click(function(){
                        var this_id = $(this).attr('id');
                        var this_click = $(this);
                        var matches = this_id.match(/(\d+)/);
                        var user_id = matches[0];
                        if(user_id > 0) {
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url() ?>admin/delete-user',
                                data: {user_id: user_id},
                                success: function(response) {
                                    var data = JSON.parse(response);
                                    console.log(data);
                                    if(data.status == true) {
                                        $('.user-alert').html(notify_html_success);
                                        this_click.parents('tr').remove();
                                    } else {
                                        $('.user-alert').html(notify_html_fail);
                                    }
                                    $('.user-alert').show();
                                    $('.user-alert').fadeOut(3000);
                                }
                            });
                        }
                        $('.user-alert').fadeOut(1000);
                    });

                    $('.user-role_code').click('.user-role_code', function(){
                        $(this).editable({
                            type: 'select',
                            url: '<?= base_url() ?>admin/get-user-role',
                            inputclass: '',
                            source: function() {
                                data = [];
                                $.ajax({
                                    url: '<?= base_url() ?>admin/get-user-role',
                                    dataType: 'json',
                                    async: false,
                                    success: function(res) {
                                        data = res;
                                        return res;
                                    }
                                });
                                console.log(data);
                                return data;
                            },
                            success: function(response) {
                                var data = JSON.parse(response);
                                if(data.status == true) {
                                    $('.user-alert').html(notify_html_success);
                                } else {
                                    $('.user-alert').html(notify_html_fail);
                                }
                                $('.user-alert').show();
                                $('.user-alert').fadeOut(3000);
                            }
                        });
                    });   
                }
            });
            
            
        });
    });
</script>