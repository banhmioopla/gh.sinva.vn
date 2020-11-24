
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
        <div class="penalty-alert"></div>
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1">
                <div class="card-box shadow table-responsive">
                    <h3 class="text-danger text-center">Danh Mục Vi Phạm</h3>
                    <table class="table table-user table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Tên Loại Vi Phạm</th>
                            <th>Phí Phạt</th>
                            <th>Mô Tả</th>
                            <th>Mở</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_penalty as $row ):
                            $parent_name = '';
                            if($row['parent_id'] > 0) {
                                $parent_name =  '<span class = "text-danger">'
                                    .$ghPenalty->get(['id' =>
                                    $row['parent_id']])[0]['name'] . ' <i class="mdi mdi-menu-right"></i> </span>';
                            }
                            ?>
                            <tr>
                                <td>
                                    <div class="penalty-id text-center font-weight-bold">
                                        <?= $row['id'] ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="penalty-parent_id"
                                          data-pk="<?= $row['id'] ?>"
                                          data-name="parent_id"><?= $parent_name
                                        ?></span>
                                    <span class="penalty-name"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="name">
                                        <?= $row['name'] ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="penalty-fee"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value = "<?= $row['fee'] ?>"
                                         data-name="fee"><?= number_format($row['fee']) ?></div>
                                </td>



                                <td>
                                    <div class="penalty-description"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="description"
                                         data-value ="<?= $row['description'] > 0 ? $row['description'] :'' ?>">
                                        <?= $row['description'] ?>
                                    </div>
                                </td>



                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-penalty">
                                            <input id="penalty-<?= $row['id'] ?>"
                                                   value="<?= $row['active'] ?>"
                                                   type="checkbox"
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="penalty-<?= $row['id'] ?>">
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
            <div class="col-12 col-md-5 offset-md-1">
                <div class="card-box shadow">
                    <h3 class="text-center text-danger">Thêm danh mục mới</h3>
                    <form role="form" method="post" action="<?= base_url()
                    ?>admin/create-penalty">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12
                            col-form-label">Danh Mục Cha</label>
                            <div class="col-md-8 col-12">
                                <select name="parent_id" class="form-control" >
                                    <option value="">Vui lòng chọn Danh mục cha...
                                        (nếu có)</option>
                                    <?php foreach ($list_penalty as $item):?>
                                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12
                            col-form-label">Tên Loại Vi Phạm<span
                                        class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="name" name="name">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-12
                            col-form-label">Phí Phạt<span
                                        class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="fee" name="fee"
                                       placeholder="100000">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-12
                            col-form-label">Mô Tả<span
                                        class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <textarea class="form-control"
                                          id="description" name="description"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở</label>
                            <div class="col-8">
                                <div>
                                    <div class=" checkbox checkbox-success ">
                                        <input id="active" type="checkbox" checked value="YES" name="active">
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
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.buttons =
            '<div class="d-flex justify-content-center mt-2">' +
            '<button type="submit" class="btn btn-primary btn-sm editable-submit">'+
            '<i class="fa fa-fw fa-check"></i>'+
            '</button>'+
            '<button type="button" class="btn btn-default btn-sm editable-cancel">'+
            '<i class="fa fa-fw fa-times"></i>'+
            '</button>'+
            '</div>';

        /* =========== MODIFY DATA JS ========= */
        // if(modify_mode == false) return;

        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy"
            });
            $('.table-user').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {

                    $('.penalty-parent_id').editable({
                        emptytext: '___',
                        type: 'select',
                        url: '<?= base_url() ?>admin/get-penalty',
                        inputclass: '',
                        source: function() {
                            data = [];
                            $.ajax({
                                url: '<?= base_url() ?>admin/get-penalty',
                                dataType: 'json',
                                async: false,
                                success: function(res) {
                                    data = res;
                                    return res;
                                }
                            });
                            return data;
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.penalty-alert').html(notify_html_success);
                            } else {
                                $('.penalty-alert').html(notify_html_fail);
                            }
                            $('.penalty-alert').show();
                            $('.penalty-alert').fadeOut(3000);
                        }
                    });


                    $('.is-active-penalty input[type=checkbox]').click(function() {
                        var is_active = 'NO';
                        var this_id = $(this).attr('id');
                        var matches = this_id.match(/(\d+)/);
                        var user_id = matches[0];
                        if($(this).is(':checked')) {
                            is_active = 'YES';
                        }
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>admin/update-penalty',
                            data: {field_value: is_active, penalty_id: user_id, field_name : 'active'},
                            async: false,
                            success:function(response){
                                var data = JSON.parse(response);
                                if(data.status == true) {
                                    $('.penalty-alert').html(notify_html_success);
                                } else {
                                    $('.penalty-alert').html(notify_html_fail);
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

                    $('.penalty-name, .penalty-fee').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-penalty-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.penalty-alert').html(notify_html_success);
                            } else {
                                $('.penalty-alert').html(notify_html_fail);
                            }
                        }
                    });


                    $('.penalty-description').editable({
                        type: "textarea",
                        url: '<?= base_url() ?>admin/update-penalty-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.penalty-alert').html(notify_html_success);
                            } else {
                                $('.penalty-alert').html(notify_html_fail);
                            }
                        }
                    });




                }
            });


        });
    });
</script>