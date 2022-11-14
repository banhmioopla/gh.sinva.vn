<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GH</a></li>
                            <li class="breadcrumb-item"><a href="#">Dự Án</a></li>
                            <li class="breadcrumb-item active">Danh Sách Thương Hiệu Hợp Tác</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Danh Sách Thương Hiệu Hợp Tác</h2>
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
        <div class="partner-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-partner" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th class="text-center">Số Dự Án Đang Mở</th>
                            <th class="text-center">Mở</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_partner as $row ):
                                $apm_counter = count($ghApartment->get(['partner_id' => $row['id'], 'active' => 'YES']));

                                ?>
                            <tr>
                                <td>
                                    <div class="partner-name" 
                                        data-pk="<?= $row['id'] ?>" 
                                        data-name="name">
                                            <?= $row['name'] ?>
                                    </div>
                                </td>

                                <td class="text-secondary"
                                    data-pk="<?= $row['id'] ?>"
                                    data-name="note"
                                    ><?= $row['note'] ?>
                                </td>

                                <td class="text-center" style="width:80px"><?= $apm_counter ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-partner">
                                            <input id="partner-<?= $row['id'] ?>"
                                                   value="<?= $row['active'] ?>"
                                                   type="checkbox"
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="partner-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button id='partner-del-<?= $row['id'] ?>' class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-partner">
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
                    <form role="form" method="post" action="<?= base_url()?>admin/create-partner">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Tên đối tác<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                        id="name" name="name" placeholder="Tên đối tác">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở</label>
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
                            <label class="col-md-4 col-12 col-form-label">Mô tả</label>
                            <div class="col-md-8 col-12">
                                <textarea class="form-control" name="note" rows="5" placeholder="Không bắt buộc"></textarea>
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
            $('#table-partner').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-partner input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var partner_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-partner',
                            data: {field_value: is_active, partner_id: partner_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                if(data.status == true) {
                                    $('.partner-alert').html(notify_html_success);
                                } else {
                                    $('.partner-alert').html(notify_html_fail);
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

                    $('.partner-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-partner-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.partner-alert').html(notify_html_success);
                            } else {
                                $('.partner-alert').html(notify_html_fail);
                            }
                        }
                    });

                    $('.delete-partner').click(function(){
                        var this_id = $(this).attr('id');
                        var this_click = $(this);
                        var matches = this_id.match(/(\d+)/);
                        var partner_id = matches[0];
                        if(partner_id > 0) {
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url() ?>admin/delete-partner',
                                data: {partner_id: partner_id},
                                success: function(response) {
                                    var data = JSON.parse(response);
                                    if(data.status == true) {
                                        $('.partner-alert').html(notify_html_success);
                                        this_click.parents('tr').remove();
                                    } else {
                                        $('.partner-alert').html(notify_html_fail);
                                    }
                                }
                            });
                        }
                    });
                }
            });
            

        });
    });
</script>