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
                    <h3 class="page-title">Danh sách Loại Dự Án</h3>
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
        <div class="baseapartmenttype-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-baseapartmenttype" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tên Loại DA</th>
                            <th>Số DA</th>
                            <th class="text-center">Mở</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_baseapartmenttype as $row ): ?>
                            <tr>
                                <td>
                                    <div class="baseapartmenttype-name" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td><i>-</i></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-baseapartmenttype">
                                            <input id="baseapartmenttype-<?= $row['id'] ?>" 
                                                value="<?= $row['active'] ?>"
                                                type="checkbox" 
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="baseapartmenttype-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button id='baseapartmenttype-del-<?= $row['id'] ?>' class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-baseapartmenttype">
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
                    <form role="form" method="post" action="<?= base_url()?>admin/create-apartment-type">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tên quận<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="Tên loại tòa nhà">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở quận này<span class="text-danger">*</span></label>
                            <div class="col-7">
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
            $('#table-baseapartmenttype').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true
            });
            
            $('.is-active-baseapartmenttype input[type=checkbox]').click(function() {
                var is_active = 'NO';
                var this_id = $(this).attr('id');
                var matches = this_id.match(/(\d+)/);
                var baseapartmenttype_id = matches[0];
                if($(this).is(':checked')) {
                    is_active = 'YES';
                }
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/update-apartment-type',
                    data: {field_value: is_active, baseapartmenttype_id: baseapartmenttype_id, field_name : 'active'},
                    async: false,
                    success:function(response){
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.baseapartmenttype-alert').html(notify_html_success);
                        } else {
                            $('.baseapartmenttype-alert').html(notify_html_fail);
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

            $('.baseapartmenttype-name').editable({
                type: "text",
                url: '<?= base_url() ?>admin/update-apartment-type-editable',
                inputclass: '',
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.baseapartmenttype-alert').html(notify_html_success);
                    } else {
                        $('.baseapartmenttype-alert').html(notify_html_fail);
                    }
                }
            });

            $('.delete-baseapartmenttype').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var baseapartmenttype_id = matches[0];
                if(baseapartmenttype_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-apartment-type',
                        data: {apartment_type_id: baseapartmenttype_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.baseapartmenttype-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.baseapartmenttype-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>