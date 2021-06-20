<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Dự Án</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Duyệt Cập Nhật Dự Án (Sale, CTV)</h2>
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
                    <table id="request-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Quận</th>
                            <th>Phường</th>
                            <th class="text-center">Địa Chỉ</th>
                            <th>Thành Viên</th>
                            <th>Ngày</th>
                            <th class="text-center">Tùy Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_request as $row ):
                            $apm = $ghApartment->getFirstById($row['apartment_id']);
                            ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $apm['district_code'] ?></td>
                                <td><?= $apm['address_ward'] ?></td>
                                <td><?= $apm['address_street'] ?></td>
                                <td><?= $libUser->getNameByAccountid($row['account_id']) ?></td>
                                <td><?= date("d-m-Y",$row['time_update']) ?></td>
                                <td><a class="font-weight-bold" href="/sale/apartment-request/detail?id=<?= $row['id'] ?>">Review</a></td>
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

<script>
    commands.push(function () {
        $('#request-table').DataTable();
    });
</script>
