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
                    <h3 class="page-title">Danh sách Hợp đồng</h3>
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
        <div class="contract-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-contract" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Địa chỉ</th>
                            <th>Tên khách thuê</th>
                            <th>Thành viên tư vấn</th>
                            <th>Mã Phòng</th>
                            <th>Dịch vụ</th>
                            <th class="text-center">Tình trạng</th>
                            <th class="text-center">Mô tả</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_contract as $row ): ?>
                            <tr>
                                <td>
                                    <div class="contract-name" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td><i>-</i></td>
                                <td><i>-</i></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-contract">
                                            <input id="contract-<?= $row['id'] ?>" 
                                                value="<?= $row['status'] ?>"
                                                type="checkbox" 
                                                <?= $row['status'] =='YES' ? 'checked':'' ?>>
                                            <label for="contract-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary"><?= $row['note'] ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button id='contract-del-<?= $row['id'] ?>' class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-contract">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
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
                    <h4 class="header-title m-t-0">Thêm mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-contract">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">chọn thành viên<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">chọn khách<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">chọn khách<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Khách Hàng Mới<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                        id="code" name="code" placeholder="CODE">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">chọn quận<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">chọn dự án<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">chọn phòng<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <select type="text" class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
                                        <?= $select_user?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">CODE<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                        id="code" name="code" placeholder="CODE">
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Mô tả</label>
                            <div class="col-8">
                                <textarea class="form-control" rows="5" name="note" placeholder="Không bắt buộc"></textarea>
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
            $('#table-contract').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-contract input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var district_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        console.log('hello');
                        console.log(is_active );
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-contract',
                            data: {field_value: is_active, district_id: district_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                console.log(data);
                                if(data.status == true) {
                                    $('.contract-alert').html(notify_html_success);
                                } else {
                                    $('.contract-alert').html(notify_html_fail);
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
                    $('.contract-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-contract-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.contract-alert').html(notify_html_success);
                            } else {
                                $('.contract-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });
            
            

            $('.delete-contract').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var district_id = matches[0];
                if(district_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-contract',
                        data: {district_id: district_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.contract-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.contract-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>