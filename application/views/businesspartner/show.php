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
                    <h3 class="page-title">Danh sách đối tác kinh doanh</h3>
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
        <div class="businesspartner-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive shadow">
                    <table id="table-businesspartner" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Họ Tên</th>
                            <th class="text-center">Số Điện Thoại</th>
                            <th>Email</th>
                            <th>Dự Án</th>
                            <th>Ghi Chú</th>
                            <th class="text-center">Mở</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_businesspartner as $row ): ?>
                            <tr>
                                <td>
                                    <div class="businesspartner-name"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="name">
                                        <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="businesspartner-phone text-center"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="phone">
                                        <?= $row['phone'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="businesspartner-email"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="email">
                                        <?= $row['email'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="businesspartner-apartment_id"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="apartment_id"
                                         data-value="">
                                        -
                                    </div>
                                </td>
                                <td>
                                    <div class="businesspartner-note"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="note"
                                         data-value="<?= $row['note'] ?>">
                                        <?= $row['note'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-businesspartner">
                                            <input id="businesspartner-<?= $row['id'] ?>"
                                                   value="<?= $row['active'] ?>"
                                                   type="checkbox"
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="businesspartner-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card-box shadow">
                    <h4>Thêm Mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-business-partner">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Họ Tên Đối Tác<span
                                    class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                       id="name" name="name" placeholder="Họ Tên Đối Tác">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Số Điện
                                Thoại<span
                                    class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                       id="code" name="phone" placeholder="Số Điện Thoại">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Email<span
                                    class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                       id="code" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Ghi Chú</label>
                            <div class="col-8">
                                <textarea class="form-control"
                                          id="note" name="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở<span
                                    class="text-danger">*</span></label>
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
                            <label for="hori-pass1" class="col-4 col-form-label">Dự
                                Án Đối Tác Này Quản Lý<span
                                    class="text-danger">*</span></label>
                            <div class="col-8">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <select class="select2"
                                                name="apartment_id[]"
                                                multiple="multiple"></select>
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
            $('#table-businesspartner').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {
                    $('.is-active-businesspartner input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var businesspartner_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        console.log('hello');
                        console.log(is_active );
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-businesspartner',
                            data: {field_value: is_active, businesspartner_id: businesspartner_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                console.log(data);
                                if(data.status == true) {
                                    $('.businesspartner-alert').html(notify_html_success);
                                } else {
                                    $('.businesspartner-alert').html(notify_html_fail);
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
                    $('.businesspartner-name').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-businesspartner-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.businesspartner-alert').html(notify_html_success);
                            } else {
                                $('.businesspartner-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });

            $('.delete-businesspartner').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var businesspartner_id = matches[0];
                if(businesspartner_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-businesspartner',
                        data: {businesspartner_id: businesspartner_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.businesspartner-alert').html(notify_html_success);
                                this_click.parents('tr').remove();

                            } else {
                                $('.businesspartner-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });

            $(".select2").select2({
                placeholder: "Tìm Kiếm Dự Án",
                minimumInputLength: 1,
                ajax: {
                    url: "<?= base_url().'admin/search-business-partner-apartment' ?>",
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