
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Thành Viên</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Thống Kê Tuyển Thành Viên Mới</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <h5>Tùy Chọn</h5>
                    <select class="custom-select mt-3" id="select-user">
                        <?= $cb_user ?>
                    </select>
                </div>

            </div>
            <div class="col-md-12 mt-2">
                <div class="card-box">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">Họ Tên</th>
                            <th>ID</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Vào Làm</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_refer as $user):?>
                            <tr>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['account_id'] ?></td>
                                <td>
                                    <?php
                                    $classStatus = 'secondary';
                                    $txtStatus = 'quá khứ';
                                    if($user['active'] =='YES') {
                                        $classStatus = 'success';
                                        $txtStatus = 'hiện tại';
                                    }
                                    ?>
                                    <div>
                                        <span style="font-size:100%" class=" badge badge-<?= $classStatus ?> badge-pill"><?= $txtStatus ?></span>
                                    </div>
                                </td>
                                <td><?= date('d-m-Y',$user['time_joined']) ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $('.table').dataTable();
        $('#select-user').change(function(){
            window.location = '/admin/overview-refer-new-user?account='+$(this).val();
        });
    });

</script>