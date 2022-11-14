
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Share</a></li>
                            <li class="breadcrumb-item active"><a class="text-primary" href="/share/agency-group/show">DS Đội Nhóm Môi Giới (Agency Group)</a></li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-primary">Bảng Điều Khiển</h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php  if($this->session->has_userdata('fast_notify')): ?>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fast_notify')['message'] ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row text-center">
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box widget-flat border-danger bg-danger text-white">
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="/admin/list-apartment">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            Đội nhóm MG
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box bg-secondary widget-flat border-secondary text-white">
                    <i class="fi-archive"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="/home-town/show">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            User
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
                            ...
                        </p>
                    </a>

                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box bg-danger widget-flat border-danger text-white">
                    <i class="fi-delete"></i>
                    <h3 class="m-b-10">250</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">
                        ...
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="font-weight-bold text-primary"><a href="/share/agency-group/show">Đội nhóm</a> </h4>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <th>Tên Nhóm</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Tạo</th>
                        </thead>
                        <tbody>
                        <?php foreach ($list_agency_group as $group):?>
                            <tr>
                                <td><?= $group['name'] ?> <a target="_blank" href="/share/agency-group/dashboard/show-group-detail?id=<?= $group['id'] ?>"><i class="mdi mdi-gesture-double-tap"></i></a></td>
                                <td> - </td>
                                <td><?= date("d/m/Y",$group['time_create']) ?></td>
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
                    <h4 class="font-weight-bold text-primary">Danh sách quyền</h4>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <th>Tên Quyền</th>
                        <th>Mô Tả</th>
                        </thead>
                        <?php foreach ($list_role as $role):?>
                            <tr>
                                <td><?= $role['name'] ?></td>
                                <td><?= $role['description'] ?></td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="font-weight-bold text-primary">Gói Share</h4>
            </div>
            <div class="col-12">
                <div class="card-box">
                    <table class="table">
                        <thead class="thead-dark">
                        <th>Tên Gói</th>
                        <th>Mô Tả</th>
                        </thead>
                        <?php foreach ($list_pack as $pack):?>
                            <tr>
                                <td><?= $pack['name'] ?></td>
                                <td><?= $pack['description'] ?></td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>

        </div>

    </div> <!-- end container -->
</div>