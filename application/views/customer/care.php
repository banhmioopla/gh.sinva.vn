<?php 

$is_form = $this->is_modify;
$is_btn_delete = '';
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
                    <h3>Báo cáo chăm sóc khách hàng</h3>
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
                            <th>Tên khách hàng</th>
                            <th>Thành viên tư vấn</th>
                            <th>Ngày</th>
                            <th>Ghi chú</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_data as $row ): ?>
                            <tr>
                                <td>
                                    <?= $libCustomer->getNameById($row['customer_id']) ?> - 
                                    <?= $libCustomer->getPhoneById($row['customer_id']) ?>
                                </td>
                                <td>
                                <?= $libUser->getNameByAccountid($row['user_id']) ?>
                                </td>
                                <td>
                                    <p><?= date('d/m/Y', $row['time_insert'])?></p>
                                </td>
                                <td>
                                    <p><?= $row['note']?></p>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-district">
                                            đang code
                                        </button>
                                    </div>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($is_form): ?>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0">Thêm cuộc gọi mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-care-customer">
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4 col-form-label">Chọn Khách Hàng<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                            <select class="form-control select2" id="customer_id" name="customer_id">
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Ghi chú</label>
                            <div class="col-8">
                                <textarea class="form-control" rows="5" name="note"></textarea>
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
            <?php endif;?>

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
                    $('.is-active-district input[type=checkbox]').click(function() {
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
                            url: '<?= base_url() ?>admin/update-district',
                            data: {field_value: is_active, district_id: district_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                console.log(data);
                                if(data.status == true) {
                                    $('.district-alert').html(notify_html_success);
                                } else {
                                    $('.district-alert').html(notify_html_fail);
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
                    $('.district-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-district-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.district-alert').html(notify_html_success);
                            } else {
                                $('.district-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });
            
            $(".select2").select2({
                placeholder: "Search for an Item",
                minimumInputLength: 2,
                ajax: {
                    url: "<?= base_url().'admin/search-customer' ?>",
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });

        });
    });
</script>