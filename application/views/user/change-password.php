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
                    <h3>Thông tin cá nhân</h3>
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
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h3>Quản lý mật khẩu</h3>
                    <form role="form" method="post" action="<?= base_url()?>admin/change-password-user">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Mật khẩu mới<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                        id="password" name="password" value="<?= $password ?>">
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