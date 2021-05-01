<?php 

$this_controller =& get_instance();
$role_function = json_decode($role_function, true);
?>

<div class="wrapper">
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
            <div class="col-md-10 offset-md-1 mb-md-5">
            <form action="/admin/update-permission-role?role-code=<?= $this->input->get('role-code') ?>" method='post'>
                <div class="row">
                    <div class="col-md-3 mb-md-5">
                        <button type="submit" class="btn w-100 btn-primary waves-light waves-effect">Cập Nhật</button>
                    </div>
                    
                    <div class="col-md-3 mb-md-5">
                        <button type="button" id="selectAll" class="btn w-100 btn-warning waves-light waves-effect">Check Tất Cả</button>
                    </div>

                    <div class="col-md-3 mb-md-5">
                        <button type="button" id="unselectAll" class="btn w-100 btn-danger waves-light waves-effect">Hủy Check Tất Cả</button>
                    </div>
                </div>
                <div class="row">
                    <?php foreach($list_permission as $controller => $list_action ):?>
                        <div class="col-12 col-md-3">
                            <div class="card-box shadow">
                                <h5><?= $controller ?></h5>
                                <?php 
                                    foreach($list_action as $action ):
                                        $checked = '';
                                        if(isset($role_function[$controller]) && in_array($action, $role_function[$controller])) {
                                            $checked = 'checked';
                                        }
                                ?>
                                    <div class="checkbox checkbox-dark">
                                        <input name='<?= $controller ?>[]' value="<?= $action ?>" id="<?= $controller.'_'.$action ?>" type="checkbox" <?= $checked ?>>
                                        <label for="<?= $controller.'_'.$action ?>">
                                            <?= $action ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
                
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</div>


<script>
    commands.push(function(){
        $("#selectAll").click(function(){
            $('input:checkbox').prop('checked', true);
        });

        $("#unselectAll").click(function(){
            $('input:checkbox').prop('checked', false);
        });
    });

</script>
