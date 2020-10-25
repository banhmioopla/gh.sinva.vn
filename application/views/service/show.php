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
                    <h3 class="page-title">Danh sách danh mục chi phí - thủ công & tự động</h3>
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
        <div class="service-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-service" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tên Chi Phí</th>
                            <th class="text-center">Giá Cố Định</th>
                            <th class="text-center">Có Thể Tính Toán Tự động</th>
                            <th class="text-center">Mở</th>
                            <th class="text-center">Mô Tả</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_service as $row ): ?>
                            <tr>
                                <td>
                                    <div class="service-name text-<?= $row['auto'] =='YES' ? 'success':'' ?>"
                                        data-value="<?= $row['name'] ?>"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="service-default_price"
                                        data-value="<?= $row['default_price'] ?>"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="default_price">
                                            <?= number_format($row['default_price']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-auto-service">
                                            <input id="service-<?= $row['id'] ?>" 
                                                value="<?= $row['auto'] ?>"
                                                type="checkbox"
                                                disabled
                                                <?= $row['auto'] =='YES' ? 'checked':'' ?>>
                                            <label for="service-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-service">
                                            <input id="service-<?= $row['id'] ?>" 
                                                value="<?= $row['active'] ?>"
                                                type="checkbox" 
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="service-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary service-description"
                                        data-value="<?= $row['description'] ?>"
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="description"
                                ><?= $row['description'] ?></td>
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class=" m-t-0">Thêm danh mục mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-service">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tên chi phí<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="Tên chi phí">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở<span class="text-danger">*</span></label>
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
                            <label for="hori-pass1" class="col-4 col-form-label">Tự động tính toán<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <input id="auto" type="checkbox" value="YES" name="auto">
                                        <label for="auto">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="default_price" class="col-4 col-form-label">Giá cố định<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="number" class="form-control"
                                        id="default_price" name="default_price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Mô tả</label>
                            <div class="col-8">
                                <textarea class="form-control" rows="5" name="description" placeholder="Không bắt buộc"></textarea>
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
            $('#table-service').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-service input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var service_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-service',
                            data: {field_value: is_active, service_id: service_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                if(data.status == true) {
                                    $('.service-alert').html(notify_html_success);
                                } else {
                                    $('.service-alert').html(notify_html_fail);
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

                    $('.is-auto-service input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var service_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-service',
                            data: {field_value: is_active, service_id: service_id, field_name : 'auto'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                if(data.status == true) {
                                    $('.service-alert').html(notify_html_success);
                                } else {
                                    $('.service-alert').html(notify_html_fail);
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
                    // x editable
                    $('.service-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-service-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.service-alert').html(notify_html_success);
                            } else {
                                $('.service-alert').html(notify_html_fail);
                            }
                        }
                    });
                    
                    $('.service-default_price').editable({
                        type: "number",
                        url: '<?= base_url() ?>admin/update-service-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.service-alert').html(notify_html_success);
                            } else {
                                $('.service-alert').html(notify_html_fail);
                            }
                        }
                    });
                    
                    $('.service-description').editable({
                        type: "textarea",
                        url: '<?= base_url() ?>admin/update-service-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.service-alert').html(notify_html_success);
                            } else {
                                $('.service-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });
            
            

            $('.delete-service').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var service_id = matches[0];
                if(service_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-service',
                        data: {service_id: service_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.service-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.service-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>