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
                    <h3 class="page-title">Danh sách thành viên vi phạm</h3>
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
        <div class="userpenalty-alert"></div>
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-userpenalty" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Thành Viên Vi Phạm</th>
                            <th>Danh Mục</th>
                            <th>Ngày Vi Phạm</th>
                            <th>Phí Phạt</th>
                            <th>Trừ % Thu Nhập</th>
                            <th>Trạng Thái</th>
                            <th>Người Tạo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_userpenalty as $row ): ?>
                            <tr>
                                <td>
                                    <div class="userpenalty-user_penalty_id"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="user_penalty_id">
                                        <?= $row['user_penalty_id']. ' - '.
                                        $libUser->getNameByAccountid($row['user_penalty_id']) ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        $parent = $ghPenalty->get(['id' => $row['id']]);
                                        if(count($parent)) {
                                            $parent = $parent[0]['parent_id'];
                                        } else {
                                            $parent = 0;
                                        }


                                    ?>
                                    <div class="userpenalty-penalty_id"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="penalty_id">
                                        <?=  $libPenalty->getNameById
                                        ($parent). ' <i class="mdi mdi-menu-right"></i>'.$libPenalty->getNameById
                                        ($row['penalty_id']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="userpenalty-time_insert"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= date('d-m-Y',$row['time_insert']) ?>"
                                         data-name="time_insert">
                                        <?= date('d-m-Y',$row['time_insert']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="userpenalty-fee"
                                         data-pk="<?= $row['id'] ?>"
                                         data-value="<?= $row['fee'] ?>"
                                         data-name="fee">
                                        <?= $row['fee'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="userpenalty-income_rate"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="income_rate">
                                        <?= $row['income_rate'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="userpenalty-status"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="status">
                                        <?= $row['status'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="userpenalty-user_create_id"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="user_create_id">
                                        <?= $libUser->getNameByAccountid($row['user_create_id']) ?>
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
                    <h4 class="header-title m-t-0">Thêm Mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-userpenalty">
                        <div class="form-group row">
                            <label for="consultant_id" class="col-12 col-md-4
                            col-form-label">Thành viên vi phạm</label>
                                <div class="col-md-8 col-12">
                                    <select type="number" class="form-control" required
                                            id="user_penalty_id" name="user_penalty_id">
                                        <?= $libUser->cb(0,'YES')?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12
                            col-form-label">Danh Mục</label>
                            <div class="col-md-8 col-12">
                                <select name="penalty_id" id="penalty_id" required
                                        class="form-control" >
                                    <option value="">Vui lòng chọn Danh mục vi phạm...</option>
                                    <?php foreach ($list_penalty as $item):
                                        $item_name = "";
                                        $parent_name = "";
                                        if($item['parent_id'] > 0) {
                                            $parent_name = $ghPenalty->get(['id' =>
                                                $item['parent_id']])[0]['name'];
                                            $item_name = $parent_name. ' - '.$item['name'];
                                        } else {
                                            $item_name = $item['name'];
                                        }
                                        ?>
                                        <option value="<?= $item['id'] ?>"><?= $item_name ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4
                            col-form-label">Ngày Vi Phạm</label>
                            <div class="col-md-8 col-12">
                                <input type="text" class="form-control datepicker"
                                       id="time_insert" name="time_insert"
                                       value="<?= date('d-m-Y')?>">
                                <p class="msg-insert_time text-danger"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4
                            col-form-label">Trừ % Thu Nhập</label>
                            <div class="col-md-8 col-12">
                                <input type="number" class="form-control "
                                       id="income_rate" name="income_rate"
                                       value="0" min="0" max="100">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-12 col-md-4
                            col-form-label">Trạng Thái</label>
                            <div class="col-md-8 col-12">
                                <div class="radio radio-custom">
                                    <input type="radio" name="status" checked
                                           id="status_success" value="Success" checked>
                                    <label for="status_success">
                                        Thành Công
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status"
                                           id="status_pending" value="Pending" >
                                    <label for="status_pending">
                                        Đợi Duyệt
                                    </label>
                                </div>
                                <div class="radio radio-custom">
                                    <input type="radio" name="status"
                                           id="status_cancel" value="Cancel" >
                                    <label for="status_cancel">
                                        Hủy
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
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('#table-userpenalty').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "fnDrawCallback": function() {

                    // x editable
                    $('.userpenalty-fee, .userpenalty-income_rate').editable({
                        type: "number",
                        url: '<?= base_url() ?>admin/update-userpenalty-editable',
                        inputclass: '',
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.userpenalty-alert').html(notify_html_success);
                            } else {
                                $('.userpenalty-alert').html(notify_html_fail);
                            }
                        }
                    });
                } // end fnDrawCallback
            });

            $('.userpenalty-time_insert').editable({
                placement: 'right',
                type: 'combodate',
                template:"D / MM / YYYY",
                format:"DD-MM-YYYY",
                viewformat:"DD-MM-YYYY",
                mode: 'popup',
                combodate: {
                    firstItem: 'name',
                    maxYear: '2030',
                    minYear: '2017'
                },
                inputclass: 'form-control-sm',
                url: '<?= base_url() ?>admin/update-userpenalty-editable',
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.contract-alert').html(notify_html_success);
                    } else {
                        $('.contract-alert').html(notify_html_fail);
                    }
                }
            });

            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
            });
        });
    });
</script>