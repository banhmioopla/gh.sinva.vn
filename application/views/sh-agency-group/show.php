
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
                    <h2 class="font-weight-bold text-primary">DS Đội Nhóm Môi Giới (Agency Group)</h2>
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
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="font-weight-bold text-primary">Danh Sách Đội Nhóm Môi Giới (Agency Group)</h4>
                            <table class="table">
                                <thead class="table-dark">
                                <th>Tên tổ chức</th>
                                <th>Chủ đại diện</th>
                                <th>Trạng thái</th>
                                <th>Ngày hết hạn</th>
                                <th>Tùy Chọn</th>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td><?= $item['name']?></td>
                                        <td>-</td>
                                        <td><?= $item['status']?></td>
                                        <td>-</td>
                                        <td>
                                            <a href="/share/user/show?group-id=<?= $item['uuid'] ?>">
                                            <button class="btn btn-sm btn-outline-info btn-rounded waves-light waves-effect">
                                                <i class="mdi mdi-account-multiple"></i> <span class="d-none d-md-inline">Thành Viên</span>
                                            </button></a>

                                            <a href="/share/agency-group-apartment/show?group-id=<?= $item['uuid'] ?>">
                                            <button class="btn btn-sm btn-outline-info btn-rounded waves-light waves-effect">
                                                <i class="mdi mdi-lead-pencil"></i> <span class="d-none d-md-inline">Dự Án</span></button></a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box">
                    <h3 class="text-primary">Thêm Đội Nhóm Môi Giới (Agency Group) Mới</h3>
                    <form role="form" method="post" action="<?= base_url()?>share/agency-group/create">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Tên Tổ Chức<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="name" name="name" placeholder="Tên Tổ Chức">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-12 col-form-label">Trạng Thái<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <select name="status" id="" class="form-control">
                                    <option value="Pending">Chờ Duyệt</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Thêm Mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div> <!-- end container -->
</div>