<?php 
$check_create = in_array($this->auth['role_code'], ['customer-care']);
$check_editable  = in_array($this->auth['role_code'], ['customer-care']);

?>

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
        <div class="customer-alert"></div>
        <?php $this->load->view('components/list-navigation'); ?>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box shadow" style="font-size: 13px">
                    <h3 class="text-center text-danger">Khách Hàng Đã Ký</h3>
                    <table class="table-data table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Giới tính</th>
                            <th>Số điện thoại</th>
                            <th class="text-center">Nguồn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(count($list_customer) > 0):?>
                            <?php foreach($list_customer as $row ):
                                if($row['status'] !== "sinva-rented") continue;
                                ?>
                            <tr>
                                <td><a target="_blank"
                                       href="/admin/detail-customer?id=<?= $row['id'] ?>"><?=
                                        10000 +
                                        $row['id'] ?></a></td>
                                <td>
                                    <div class=" font-weight-bold">
                                            <?= $row['name'] ?>
                                        <p class="mb-0 text-muted"> <small>Sinh Nhật: <?=
                                                $row['birthdate'] !== null ? date('d/m/Y',$row['birthdate']) : ''  ?></small></p>
                                    </div>

                                </td>
                                <td>
                                    <div class="customer-gender" 
                                        data-pk="<?= $row['id'] ?>"
                                        data-name="gender">
                                            <?= $row['gender'] ? $label_apartment[$row['gender']] : ''?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-data" 
                                        data-pk="<?= $row['id'] ?>"
                                        data-value ="<?= $row['phone'] ?>"
                                        data-name="phone">
                                            <?= $row['phone'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-source text-center text-warning font-weight-bold">
                                        <?= $row['source'] ? $label_apartment[$row['source']] : '' ?>
                                    </div>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                                <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card-box shadow" style="font-size: 13px">
                    <h3 class="text-center text-danger">Khách Hàng Theo Dõi</h3>
                    <table class="table-data table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Giới tính</th>
                            <th>Số điện thoại</th>
                            <th class="text-center">Nguồn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(count($list_customer) > 0):?>
                            <?php foreach($list_customer as $row ):
                                if($row['status'] == "sinva-rented") continue;
                                ?>
                                <tr>
                                    <td><a target="_blank"
                                           href="/admin/detail-customer?id=<?= $row['id'] ?>"><?=
                                            10000 +
                                            $row['id'] ?></a></td>
                                    <td>
                                        <div class="font-weight-bold">
                                            <?= $row['name'] ?>
                                            <p class="mb-0 text-muted"> <small>Sinh Nhật: <?=
                                                    $row['birthdate'] !== null ? date('d/m/Y',$row['birthdate']) : ''  ?></small></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="customer-gender"
                                             data-pk="<?= $row['id'] ?>"
                                             data-name="gender">
                                            <?= $row['gender'] ? $label_apartment[$row['gender']] : ''?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="customer-data"
                                             data-pk="<?= $row['id'] ?>"
                                             data-value ="<?= $row['phone'] ?>"
                                             data-name="phone">
                                            <?= $row['phone'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="customer-source text-center text-warning font-weight-bold">
                                            <?= $row['source'] ? $label_apartment[$row['source']] : '' ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($check_create):?>
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card-box shadow">
                    <h4 class=" m-t-0 text-center text-danger">Thêm Mới Khách Hàng Tiềm
                        Năng</h4>
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
                            <input type="text" name="birthdate" class="form-control datepicker" placeholder="mm/dd/yyyy">
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
                            <label for="name" class="col-12 col-md-4 col-form-label">** Trạng thái (KH)<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" disabled="" name="status" id="status_rented" value="">
                                    <label for="status">
                                        Đã ký
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" id="status_follow" value="" checked>
                                    <label for="status_follow">
                                        Đang theo dõi
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Nhu cầu giá</label>
                            <div class="col-8">
                                <input type="number" name='demand_price' class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Nhu cầu quận</label>
                            <div class="col-8">
                                <select name="demand_district_code" class='form-control'>
                                    <?= $select_district ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Nhu cầu thời gian</label>
                            <div class="col-8">
                                <input type="text" name='demand_time' class="form-control datepicker">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">** Nguồn<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" name="source" id="DepMarketing" value="DepMarketing">
                                    <label for="DepMarketing">
                                        Bộ phận marketing
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source" id="DepCustomerCare" value="DepCustomerCare">
                                    <label for="DepCustomerCare">
                                        Bộ phận chăm sóc khách hàng
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source" id="DepSale" value="DepSale" checked>
                                    <label for="DepSale">
                                        Sale
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source" id="DepOldSale" value="DepOldSale">
                                    <label for="DepOldSale">
                                        Khách Hàng Cũ Của Sale
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="source" id="DepReferral" value="DepReferral">
                                    <label for="DepReferral">
                                        Khách được giới thiệu
                                    </label>
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
            <?php endif; ?>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<?php 
$check_edit = false;
if(isYourPermission($this->current_controller, 'updateEditable', $this->permission_set)){
    $check_edit = true;
}

?>
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('.table-data').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                
                "fnDrawCallback": function() {
                    // x editable
                    <?php if($check_edit):?>
                    $('.customer-data').editable({
                        type: "text",
                        emptytext: '',
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
                    $.fn.combodate.defaults.maxYear = 2025;
                    $.fn.combodate.defaults.minYear = 1940;
                    $('.customer-birthdate, .customer-demand_time').editable({
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        placement: 'right',
                        emptytext: 'rỗng',
                        type: 'combodate',
                        template:"D MM YYYY",
                        format:"DD-MM-YYYY",
                        viewformat:"DD-MM-YYYY",
                        mode: 'popup',
                        combodate: {
                            firstItem: 'name'
                        },
                        inputclass: 'form-control-sm',
                    });

                    $('.customer-demand_price').editable({
                        type: 'number',
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        inputclass: 'form-control-sm',
                    });
                    
                    $('.customer-note').editable({
                        type: 'textarea',
                        url: '<?= base_url() ?>admin/update-customer-editable',
                        inputclass: '',
                    });
                    $('.customer-demand_district_code').editable({
                        type: 'select',
                        url: '<?= base_url() ?>admin/customer-get-district',
                        inputclass: '',
                        source: function() {
                            data = [];
                            $.ajax({
                                url: '<?= base_url() ?>admin/customer-get-district',
                                dataType: 'json',
                                async: false,
                                success: function(res) {
                                    data = res;
                                    return res;
                                }
                            });
                            return data;
                        },
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
                    <?php endif;?>
                } // end fnDrawCallback
            });
            
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
            });
            
            
        });
    });
</script>