<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-primary">Danh Sách Account Share</h2>
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
                            <table class="table table-dark">
                                <thead>
                                <th>Họ Tên</th>
                                <th>SDT</th>
                                <th>Email</th>
                                <th>UserName</th>
                                <th>Password</th>
                                <th>Loại User</th>
                                <th></th>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td><?= $item['name']?></td>
                                        <td><?= $item['phone_number']?></td>
                                        <td><?= $item['email']?></td>
                                        <td><?= $item['account']?></td>
                                        <td><?= $item['password']?></td>
                                        <td><?= $item['type']?></td>
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
                    <h3 class="text-primary">Thêm Share User Mới</h3>
                    <form role="form" method="post" action="<?= base_url()?>share/user/create">
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
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
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