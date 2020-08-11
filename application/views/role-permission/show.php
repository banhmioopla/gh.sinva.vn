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
                    <h3 class="page-title">Phân quyền <?= $role[0]['name']?></h3>
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
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-permission" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Controller</th>
                            <th>Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_permission as $controller_name => $list_action ): ?>
                                <?php foreach($list_action as $action_name): $checker = false; ?>
                                    <?php foreach($permission_role_model as $m_pr):?>
                                        <?php if($m_pr['permission_controller'] == $controller_name and $m_pr['permission_action'] == $action_name): $checker = true; break; ?>
                                        <?php endif; ?>  
                                    <?php endforeach; ?>
                                    <tr>
                                        <td>
                                            <div>
                                            <?= $controller_name.' <strong>'.$action_name.'</strong>' ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="checkbox checkbox-success is-active-permission">
                                                    <input 
                                                    id="permission-<?= $controller_name.$action_name ?>" 
                                                    type="checkbox"
                                                    <?= $checker == true ? 'checked': '' ?>
                                                    data-controller-name= "<?= $controller_name ?>"
                                                    data-action-name= "<?= $action_name ?>" >
                                                    <label for="permission-<?= $controller_name.$action_name ?>">
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
                var flag = 0;
                var this_checkbox = $(this);
                var this_checkbox_id = $(this).attr('id');
                var controller_name = $(this).data('controller-name');
                var action_name = $(this).data('action-name');
            
                if($('#' + this_checkbox_id).is(':checked') == true) {
                    flag = 1;
                }
                console.log(flag);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/update-role-rule',
                    data: {
                        flag: flag, 
                        action_name: action_name, 
                        controller_name: controller_name, 
                        role_id: '<?= $role[0]['id'] ?>'},
                    async: false,
                    success:function(response){
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.permission-alert').html(notify_html_success);
                            $('.permission-alert').fadeOut(3000);
                        } else {
                            $('.permission-alert').html(notify_html_fail);
                            $('.permission-alert').fadeOut(3000);
                        }
                    }
                });
            });
        });
    });
</script>