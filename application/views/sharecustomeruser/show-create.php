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
        <div class="district-alert"></div>
        <form method="post" action="/admin/create-share-customer-user">
        <div class="row">
            <div class="col-md-4 mt-3 col-12 offset-0">
                <div class="card-box shadow">
                    <button type="submit" id="search" class="btn btn-success w-100">
                    Cập Nhật Chia Sẻ Khách Hàng <i class="mdi mdi-share"></i></button>
                </div>
            </div>

            <div class="col-md-2 mt-3 col-12 offset-0">
                <div class="card-box shadow">
                    <a href="/admin/list-share-customer-user" class="btn btn-danger
                    w-100">
                        Danh Sách Chia Sẻ</a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box shadow table-responsive">
                    <table id="table-user" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Thành Viên</th>
                            <th>Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_user as $row ): ?>
                            <tr>
                                <td>
                                    <div >
                                        <?= $row['account_id'].' - ' . $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-district">
                                            <input id="u-<?= $row['id'] ?>"
                                                   value="<?= $row['account_id'] ?>"
                                                   name="user[]"
                                                   type="checkbox">
                                            <label for="u-<?= $row['id'] ?>">
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
            <div class="col-12 col-md-6">
                <div class="card-box shadow table-responsive">
                    <table id="table-customer" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Khách Hàng</th>
                            <th>Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_customer as $row ): ?>
                            <tr>
                                <td>
                                    <div >
                                        <?= $row['phone'].' - ' . $row['name'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-district">
                                            <input id="c-<?= $row['id'] ?>"
                                                   value="<?= $row['id'] ?>"
                                                   name="customer[]"
                                                   type="checkbox">
                                            <label for="c-<?= $row['id'] ?>">
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
        </div> <!-- end row -->
        </form>

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('#table-user, #table-customer').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
            });



        });
    });
</script>