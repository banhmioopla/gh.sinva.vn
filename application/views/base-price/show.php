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
                    <h3 class="page-title">Danh sách giá phòng (GP)</h3>
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
        <div class="baseprice-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-baseprice" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Giá hiển thị</th>
                            <th>Giá trị</th>
                            <th>Số Lượng Phòng</th>
                            <th class="text-center">Mở</th>
                            <!-- <th class="text-center">Tùy Chọn</th> -->
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_baseprice as $row ): ?>
                            <tr>
                                <td>
                                    <div class="baseprice-name" 
                                        data-pk="<?= $row['id'] ?>"
                                        data-value="<?= $row['name'] ?>"
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="baseprice-name" 
                                        data-pk="<?= $row['id'] ?>"
                                        data-value="<?= $row['code'] ?>"
                                        data-name="code">
                                            <?= $row['code'] ?>
                                    </div>
                                </td>
                                <td><i>-</i></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-baseprice">
                                            <input id="baseprice-<?= $row['id'] ?>" 
                                                value="<?= $row['active'] ?>"
                                                type="checkbox" 
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="baseprice-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <!-- <td>
                                    <div class="d-flex justify-content-center">
                                        <button id='baseprice-del-<?//= $row['id'] ?>' class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-baseprice">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </td> -->
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0">Thêm mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-price">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tên GP<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="number" required class="form-control"
                                        id="name" name="name" placeholder="Nhập số, VD 6000000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở GP này<span class="text-danger">*</span></label>
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
            $('#table-baseprice').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-baseprice input[type=checkbox]').click(function() {
                    var is_active = 'NO';
                    var this_id = $(this).attr('id');
                    var matches = this_id.match(/(\d+)/);
                    var baseprice_id = matches[0];
                    if($(this).is(':checked')) {
                        is_active = 'YES';
                    }
                    $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-price',
                            data: {field_value: is_active, price_id: baseprice_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                if(data.status == true) {
                                    $('.baseprice-alert').html(notify_html_success);
                                } else {
                                    $('.baseprice-alert').html(notify_html_fail);
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

                    $('.baseprice-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-price-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.baseprice-alert').html(notify_html_success);
                            } else {
                                $('.baseprice-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
            
            

            $('.delete-baseprice').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var baseprice_id = matches[0];
                if(baseprice_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-price',
                        data: {price_id: baseprice_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.baseprice-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.baseprice-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>