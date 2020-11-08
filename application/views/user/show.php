
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
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
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
        <div class="user-alert"></div>
        <div class="row">
        <h3>Danh sách thành viên sinh tháng <?= date('m') ?></h3>
            <div class="col-md-12 col-12">
            <div class="card-box table-responsive">
                <table class="table table-user table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Sinh Nhật</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($list_user as $row ): 
                            if($row['active'] == "NO") continue;
                            if(date('m',$row['date_of_birth']) != date('m')) continue;
                    ?>
                    <tr>
                        <td><?= $row['account_id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= date('d/m/Y', $row['date_of_birth']) ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                </table>
            </div>
            </div>
        </div>
        <div class="row">
        <h3>Tất cả thành viên</h3>
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table class="table table-user table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Tên</th>

                            <th>Quyền</th>

                            <th>SĐT</th>

                            <th>Sinh nhật</th>


                            <th>Ngày Vào Làm</th>

                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Mở</th>
                            <!-- <th class="text-center">Tùy Chọn</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user as $row ): ?>
                            <tr>
                                <td>
                                    <div class="user-account_id text-center font-weight-bold" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="account_id">
                                            <?= $row['account_id'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-name user"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                        <?= $row['name'] ?>
                                    </div>
                                </td>

                                <td>
                                <div class="user-role_code"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-value = "<?= $row['role_code'] ?>"
                                        data-name="role_code">quyền <?= $libRole->getNameByCode($row['role_code']) ?></div>
                                </td>

                                <td>
                                    <div class="user-phone_number user"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="phone_number">
                                        <?= $row['phone_number'] ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-date_of_birth user"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="date_of_birth"
                                        data-value ="<?= $row['date_of_birth'] > 0 ? date('d-m-Y',$row['date_of_birth']) :'' ?>">
                                        <?= $row['date_of_birth'] ? date('d/m/Y',$row['date_of_birth']) :'#' ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="user-time_joined user"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="time_joined"
                                        data-value ="<?= $row['time_joined'] > 0 ? date('d-m-Y',$row['time_joined']) :'' ?>">
                                        <?= $row['time_joined'] ? date('d/m/Y',$row['time_joined']) :'#' ?>
                                    </div>
                                </td>
                                

                                <td class="text-center">
                                    <?php 
                                        $classStatus = 'secondary';
                                        $txtStatus = 'quá khứ';
                                        if($row['active'] =='YES') {
                                            $classStatus = 'success';
                                            $txtStatus = 'hiện tại';
                                        }
                                    ?>
                                    <div>
                                        <span style="font-size:100%" class=" badge badge-<?= $classStatus ?> badge-pill"><?= $txtStatus ?></span>
                                    </div>
                                    
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-user">
                                            <input id="user-<?= $row['id'] ?>" 
                                                value="<?= $row['active'] ?>"
                                                type="checkbox" 
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="user-<?= $row['id'] ?>">
                                            </label>
                                        </div>
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
                            maxYear: '2020',
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
                                if(data.status == true) {
                                    $('.user-alert').html(notify_html_success);
                                } else {
                                    $('.user-alert').html(notify_html_fail);
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
                    $('.is-authorised input[type=checkbox]').click(function() {
                        var this_id = $(this).attr('id');
                        var val = $(this).val();
                        var matches = this_id.match(/(\d+)/);
                        var user_id = matches[0];
                        var checked = '0';
                        if($(this).is(':checked')) {
                            checked = val;
                        }
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-user-editable',
                            data: {pk: val, name: 'authorised_user_id', value: checked},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                            }
                        });
                    })

                    $('.user-name, .user-phone_number').editable({
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