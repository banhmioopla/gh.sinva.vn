<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Share</a></li>
                            <li class="breadcrumb-item active"><a class="text-primary" href="/share/agency-group/dashboard/show-group-detail?id=<?= $group['id'] ?>"><?= $group["name"] ?></a></li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-primary"><?= $group["name"] ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary" role="alert">
                    Chủ group <strong>Nguyễn Châu Tuấn</strong> Oh yeah!
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="/admin/list-apartment">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            Dự Án
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box bg-primary widget-flat border-primary text-white">
                    <i class="fi-archive"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="/home-town/show">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            Thành Viên
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-help"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="#">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            Hợp Đồng
                        </p>
                    </a>

                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box bg-primary widget-flat border-primary text-white">
                    <i class="fi-delete"></i>
                    <h3 class="m-b-10">250</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">
                        Khách Thuê
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-primary"><a href="/share/agency-group/show">Gói đang sử dụng</a> </h4>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr><th>Tên</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                        </tr></thead>
                        <tbody>
                        <tr>
                            <td>Albus Home <a target="_blank" href="/share/agency-group/dashboard/show-group-detail?id=2"><i class="mdi mdi-gesture-double-tap"></i></a></td>
                            <td> - </td>
                            <td>01/07/2021</td>
                        </tr>
                        <tr>
                            <td>Google Home <a target="_blank" href="/share/agency-group/dashboard/show-group-detail?id=3"><i class="mdi mdi-gesture-double-tap"></i></a></td>
                            <td> - </td>
                            <td>27/10/2021</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-primary"><a href="/share/agency-group/show">Thành Viên</a> </h4>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr><th>Tên</th>
                            <th>Vai Trò</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                        </tr></thead>
                        <tbody>
                        <?php foreach ($list_user as $user):?>
                            <tr>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['role_id'] ?></td>
                                <td><?= ($user['status']) ?></td>
                                <td><?= date("d-m-Y",$user['time_create']) ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-primary"><a href="/share/agency-group/show">Dự Án</a> </h4>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr><th>Tên</th>
                            <th>Mở</th>
                            <th>Ngày Tạo</th>
                        </tr></thead>
                        <tbody>
                        <?php foreach ($list_apartment as $apm):?>
                            <tr>
                                <td><?= $apm['address_street'] ?></td>
                                <td><?= $apm['active'] ?></td>
                                <td><?= date("d-m-Y",$apm['time_insert']) ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-primary"><a href="/share/agency-group/show">Cập Nhật</a> </h4>

                </div>
            </div>
        </div>
    </div>
</div>