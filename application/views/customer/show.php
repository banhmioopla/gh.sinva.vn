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
        <div class="customer-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-customer" class="table table-bordered">
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
                                    <div class="customer-data" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-data" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="phone">
                                            <?= $row['phone'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-data" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="email">
                                            <?= $row['email'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-data" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="ID_card">
                                            <?= $row['ID_card'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-birthdate" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="birthdate">
                                            <?= date('d/m/Y', $row['birthdate']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-get-status	" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="status">
                                            <?= $row['status'] ?>
                                    </div>
                                </td>
                                <td class="text-secondary customer-data"
                                    data-pk="<?= $row['id'] ?>" 
                                    data-name="note"><?= $row['note'] ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button id='district-del-<?= $row['id'] ?>' class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-customer">
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
                    <form role="form" method="post" action="<?= base_url()?>admin/create-customer">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Họ tên<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="tên khách hàng">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Giới tính<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <div class="radio radio-custom">
                                    <input type="radio" name="gender" checked id="gender-male" value="male">
                                    <label for="gender-male">
                                        Nam
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="gender" id="gender-female" value="female">
                                    <label for="gender-female">
                                        Nữ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthdate" class="col-4 col-form-label">Ngày sinh<span class="text-danger">*</span></label>
                            <div class="col-8">
                            <input type="text" name="birthdate" class="form-control" placeholder="mm/dd/yyyy"
                                id="datepicker">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Số điện thoại<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="number" required class="form-control"
                                        id="phone" name="phone" placeholder="Số điện thoại">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Email</label>
                            <div class="col-8">
                                <input type="text" class="form-control"
                                        id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Cmnd, passport</label>
                            <div class="col-8">
                                <input type="text" class="form-control"
                                        id="ID_card" name="ID_card" placeholder="Cmnd, passport">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Nguồn<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" checked id="sinva-info-form" value="sinva-info-form">
                                    <label for="sinva-info-form">
                                        Form dắt khách
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="sinva-rented" value="sinva-rented">
                                    <label for="sinva-rented">
                                        Hợp đồng do sinva tư vấn
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="orther" value="orther">
                                    <label for="orther">
                                        Không rõ nguồn
                                    </label>
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
            $('#table-customer').DataTable({
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
                    
                    $('.customer-birthdate').editable({
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        placement: 'right',
                        type: 'combodate',
                        template:"D / MM / YYYY",
                        format:"DD-MM-YYYY",
                        viewformat:"DD-MM-YYYY",
                        mode: 'inline',
                        combodate: {
                            firstItem: 'name'
                        },
                        inputclass: 'form-control-sm',
                    });

                    $('.delete-customer').click(function(){
                        var this_id = $(this).attr('id');
                        var this_click = $(this);
                        var matches = this_id.match(/(\d+)/);
                        var district_id = matches[0];
                        if(district_id > 0) {
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url() ?>admin/delete-customer',
                                data: {district_id: district_id},
                                success: function(response) {
                                    var data = JSON.parse(response);
                                    if(data.status == true) {
                                        $('.customer-alert').html(notify_html_success);
                                        this_click.parents('tr').remove();

                                    } else {
                                        $('.customer-alert').html(notify_html_fail);
                                    }
                                }
                            });
                        }
                    });
                } // end fnDrawCallback
            });
            
            $('#datepicker').datepicker({
                format: "dd/mm/yyyy",
            });
            
            
        });
    });
</script>