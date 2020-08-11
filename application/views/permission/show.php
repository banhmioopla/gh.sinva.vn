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
                    <h3 class="page-title">Danh sách chức năng</h3>
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
        <div class="permission-alert"></div>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card-box">
                    <button type="button" class="btn btn-info waves-effect waves-light"> <i class="mdi mdi-cloud-sync m-r-5"></i> <span>Cập nhật tất cả chức năng - DB</span> </button>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-permission" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Controller</th>
                            <th>SL.TV</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_permission as $controller_name => $list_action ): ?>
                                <?php foreach($list_action as $action_name):?>
                                    <tr>
                                        <td>
                                            <div>
                                            <?= $controller_name.' <strong>'.$action_name.'</strong>' ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="checkbox checkbox-success is-active-permission">
                                                    <input id="permission" 
                                                        
                                                        type="checkbox" 
                                                        >
                                                    <label for="permission">
                                                    </label>
                                                </div>
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
                    <h4 class="header-title m-t-0">Thêm mới</h4>
                    <form permission="form" method="post" action="<?= base_url()?>admin/create-permission">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Tên chức năng<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="Tên chức năng">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở</label>
                            <div class="col-8">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <input id="active" type="checkbox" value="YES" name="active">
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
        $(document).ready(function() {
            $('#table-permission').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true
            });
            
            $('.is-active-permission input[type=checkbox]').click(function() {
                var is_active = 'NO';
                var this_id = $(this).attr('id');
                var matches = this_id.match(/(\d+)/);
                var permission_id = matches[0];
                if($(this).is(':checked')) {
                    is_active = 'YES';
                }
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/update-permission',
                    data: {field_value: is_active, permission_id: permission_id, field_name : 'active'},
                    async: false,
                    success:function(response){
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.permission-alert').html(notify_html_success);
                        } else {
                            $('.permission-alert').html(notify_html_fail);
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

            $('.permission-name').editable({
                type: "text",
                url: '<?= base_url() ?>admin/update-permission-editable',
                inputclass: '',
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.permission-alert').html(notify_html_success);
                    } else {
                        $('.permission-alert').html(notify_html_fail);
                    }
                }
            });

            $('.delete-permission').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var permission_id = matches[0];
                if(permission_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-permission',
                        data: {permission_id: permission_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.permission-alert').html(notify_html_success);
                                this_click.parents('tr').remove();
                            } else {
                                $('.permission-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>