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
                    <h2 class="text-danger font-weight-bold">Thành viên <?= $user['name'] ?></h2>
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
        <div class="user-alert"></div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card-box">

                    <form role="form" method="post">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Vai trò<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <select name="role_id" id="" class="form-control">
                                    <?php foreach ( $list_role as $role):
                                        $slc= '';
                                        if($user['role_code'] == $role['code']) {
                                            $slc= 'selected';
                                        }

                                        ?>
                                        <option <?= $slc ?> value="<?= $role['code']?>"><?= $role['name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Họ tên<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="password" name="password" value="<?= $user['name'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Ngày sinh<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control datepicker"
                                       id="password" name="password" value="<?= date("d-m-Y",$user['date_of_birth']) ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Phone<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="password" name="password" value="<?= $user['phone_number'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Email<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="password" name="password" value="<?= $user['email'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Ngày vào làm<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control datepicker"
                                       id="password" name="password" value="<?= date("d-m-Y",$user['time_joined']) ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" name="submitForm" value='ok' class="btn btn-custom waves-effect waves-light">
                                    Cập nhật
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>