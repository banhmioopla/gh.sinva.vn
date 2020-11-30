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
                    <h3 class="page-title">Danh Sách Phòng Ban</h3>
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
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    Phòng Dự Án
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    Phòng Kinh Doanh
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    Phòng Chăm Sóc Khách Hàng
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    Phòng Nhân Sự
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    Phòng Đào Tạo
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    Phòng Marketing
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-box shadow">
                    Phòng Culi Công Nghệ
                </div>
            </div>

        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {

        });
    });
</script>