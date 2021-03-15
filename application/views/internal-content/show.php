<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container">

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
                    <h1 class="font-weight-bold text-success">CONTENT INTERNAL</h1>
                </div>
            </div>
        </div>
        <?php if(isset($flash_mess)): ?>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="alert alert-<?= $flash_status ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?= $flash_mess ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="district-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-district" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Key</th>
                            <th>Mở</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_content as $row ): ?>
                            <tr>
                                <td>
                                    <div class="district-name"
                                         data-pk="<?= $row['content_key'] ?>"
                                         data-name="content_key">
                                        <?= '<pre>'.($row['content_key']).'</pre>' ?>
                                    </div>
                                </td>
                                <td><?= '<textarea disabled class="w-100" rows=5>'.($libText->limit100($row['content'])).'</textarea>' ?></td>
                                <td>
                                    <div class=" d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-district">
                                            <input id="district-<?= $row['content_key'] ?>"
                                                   value="<?= $row['is_open'] ?>"
                                                   type="checkbox"
                                                <?= $row['is_open'] =='YES' ? 'checked':'' ?>>
                                            <label for="district-<?= $row['content_key'] ?>">
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
            <div class="col-12 col-md-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-success">Thêm mới</h4>
                    <hr>
                    <form role="form" method="post" action="<?= base_url()?>admin/internal-content/create">
                        <div class="form-group row">
                            <label for="content_key" class="col-3 col-form-label">content_key <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" required class="form-control"
                                       id="content_key" name="content_key" placeholder="content_key">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content" class="col-3 col-form-label">content<span class="text-danger">*</span></label>
                            <div class="col-9">
                                <textarea name="content" id="content" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-danger waves-effect waves-light">
                                    THÊM MỚI
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