<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Share</a></li>
                            <li class="breadcrumb-item"><a href="#"><?= $group['name'] ?> </a></li>
                            <li class="breadcrumb-item active"><a class="text-primary" href="/share/agency-group/show">DS Thành Viên - <?= $group['name'] ?></a> </li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-primary">DS Thành Viên - <?= $group['name'] ?> </h2>
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
                            <table class="table">
                                <thead class="table-dark">
                                <th>Họ Tên</th>
                                <th>SDT</th>
                                <th>Email</th>
                                <th>AccountID</th>
                                <th>Password</th>
                                <th>Vai Trò</th>
                                <th>Tùy Chọn </th>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td><?= $item['name']?></td>
                                        <td><?= $item['phone_number']?></td>
                                        <td><?= $item['email']?></td>
                                        <td><?= $item['account_id']?></td>
                                        <td><?= $item['password']?></td>
                                        <td><?= $shareRole->getNameById($item['role_id']) ?></td>
                                        <td>
                                            <a href="/share/user/show?group-id=<?= $item['uuid'] ?>">
                                                <button class="btn btn-sm btn-outline-info btn-rounded waves-light waves-effect">
                                                    <i class="mdi mdi-account-multiple"></i> <span class="d-none d-md-inline">Edit</span>
                                                </button></a>
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
                    <h4 class="text-primary font-weight-bold">Thêm Thành Viên Mới</h4>
                    <form role="form" autocomplete="off" method="post" action="/share/user/create">
                        <input type="hidden"  name="group_uuid" value="<?= $this->input->get('group-id')?>" >
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Họ Tên<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="name" name="name" placeholder="Họ Tên">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-12 col-form-label">Số Điện Thoại / UserName<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="phone_number" name="phone_number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-12 col-form-label">Vai Trò</label>
                            <div class="col-md-8 col-12">
                                <select name="role_id" id="" class="form-control">
                                    <option value="">Chọn vai trò</option>
                                    <?php foreach ($list_role as $role): ?>
                                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-12 col-form-label">Email<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="email" required class="form-control"
                                       id="email" name="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-12 col-form-label">Password<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" value="<?= rand(100000,999999) ?>" required class="form-control" readonly
                                       id="password" name="password">
                                <p class="text-warning font-weight-bold"> Password Được Tạo Ngẫu Nhiên</p>
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