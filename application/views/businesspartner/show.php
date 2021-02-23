<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Đối Tác Kinh Doanh</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Đối tác kinh doanh (quản lý, chủ nhà)</h2>
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
                            <th>Số Tài Khoản</th>
                            <th>Ghi Chú</th>
                            <th class="text-center">Mở</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_businesspartner as $row ): ?>
                            <?php
                            $list_apm = $ghMergeBusinessApartment->getByBusinessId($row['id']);
                            ?>
                            <tr>
                                <td>
                                    <div class="businesspartner-name font-weight-bold pb-1"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="name">
                                        <?= $row['name'] ?> <?= count($list_apm) ? "<small> - (".count($list_apm).")</small>" : "" ?>
                                    </div>
                                    <?php if(count($list_apm)): ?>
                                        <ul class="list-unstyled pt-1 border-top border-muted">
                                            <?php foreach ($list_apm as $apm):
                                                $this_apm = $ghApartment->getById($apm['apartment_id'])[0];

                                                ?>
                                                <li><i class="mdi mdi-tag-heart"></i> <small><?= $this_apm['address_street'] ?></small></li>
                                            <?php endforeach;?>
                                        </ul>
                                    <?php endif; ?>
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
                                    <div class="businesspartner-account_number"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="account_number">
                                        <?= $row['account_number'] ?>
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
                                <td>
                                    <div class="text-center  font-weight-bold">
                                        <a target="_blank" class="text-danger"
                                           href="/admin/business-partner/detail?id=<?= $row['id'] ?>">Chi tiết</a>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
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
                                <input type="text" class="form-control"
                                       id="code" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Số Tài Khoản<span
                                        class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" class="form-control"
                                       id="code" name="account_number" placeholder="Số Tài Khoản">
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
                    $('.businesspartner-name, .businesspartner-phone, .businesspartner-email, .businesspartner-account_number, .businesspartner-note').editable({
                        type: "text",
                        url: '<?= base_url() ?>admin/update-business-partner-editable',
                        inputclass: ''
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
        });
    });
</script>