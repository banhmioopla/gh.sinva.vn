
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
                    <h2 class="font-weight-bold text-danger">Thống Kê Lấy Dự Án Mới</h2>
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
                            <th class="text-center">Địa Chỉ</th>
                            <th>Quận</th>
                            <th>Ngày Nhập</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list_apartment as $a):?>
                            <tr>
                                <td><?= $a['address_street'] ?></td>
                                <td><?= $a['district_code'] ?></td>
                                <td><?= date('d-m-Y',$a['time_insert']) ?></td>
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
        $('#select-user').select2();
        $('#select-user').change(function(){
            window.location = '/admin/overview-get-new-apartment?account='+$(this).val();
        });
    });

</script>