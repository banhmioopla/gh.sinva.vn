<div class="wrapper">
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
        <div class="row">
            <div class="col-md-3">
                <div class="card-box">
                    <img class="thumbnail bg-warning p-2 m-3" src="https://static.chotot.com/storage/marketplace/nha_white_logo.png" alt="">
                </div>

            </div>
            <div class="col-md-12">
                <div class="card-box table-responsive">
                    <table id="table-district" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Quận</th>
                            <th>Trang</th>
                            <th>Tiêu Đề</th>
                            <th>Giá </th>
                            <th class="text-center">Mô Tả Nhỏ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($chotot as $row ): ?>
                            <tr>
                                <td>
                                    <?= $row['district'] ?>
                                </td>
                                <td>
                                    <?= $row['page'] ?>
                                </td>
                                <td>
                                    <?= $row['title'] ?>
                                </td>
                                <td>
                                    <?= $row['price'] ?>
                                </td>
                                <td>
                                    ...
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('#table-district').DataTable();
        });
    });
</script>