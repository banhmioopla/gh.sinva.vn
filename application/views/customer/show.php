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
                    <h3 class="page-title">Danh sách khách hàng</h3>
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
        <div class="district-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-district" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Cmnd, Passport</th>
                            <th>Ngày sinh</th>
                            <th class="text-center">Nguồn</th>
                            <th class="text-center">Ghi chú</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_customer as $row ): ?>
                            <tr>
                                <td>
                                    <div class="customer-name" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-phone" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="phone">
                                            <?= $row['phone'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-phone" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="email">
                                            <?= $row['email'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-ID_card" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="ID_card">
                                            <?= $row['ID_card'] ?>
                                    </div>
                                </td>
                                <td class="text-secondary"><?= $row['note'] ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button id='district-del-<?= $row['id'] ?>' class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-district">
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
                    <form role="form" method="post" action="<?= base_url()?>admin/create-district">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tên quận<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="Tên quận">
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
                            <label for="hori-pass1" class="col-4 col-form-label">Mở quận này<span class="text-danger">*</span></label>
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
            $('#table-district').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    // x editable
                    $('.customer-data').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.customer-alert').html(notify_html_success);
                            } else {
                                $('.customer-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });
            
            

            $('.delete-district').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var district_id = matches[0];
                if(district_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-district',
                        data: {district_id: district_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.district-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.district-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>