<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Trang cá nhân</h2>
                </div>
            </div>
        </div>


        <div class="profile-user-box card-box bg-dark">

            <div class="row">
                <div class="col-sm-6">
                    <span class="pull-left mr-3"><img src="https://i.pinimg.com/originals/12/61/09/126109b6c6f18f91959f49c72ad3481e.png" alt="" class="thumb-lg rounded-circle"></span>
                    <div class="media-body text-white">
                        <h4 class="mt-1 mb-1 font-18"><?= $user['name'] ?></h4>
                        <p class="font-13 text-light"><?= $user['phone_number'] ?> | <?= date("d/m/Y", $user['date_of_birth']) ?></p>
                        <p class="text-light mb-0">- Ở bên anh, em bình yên đến lạ. Xa anh, em thấy lạ nhưng cũng khá bình yên.</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        <button type="button" class="btn btn-light waves-effect">
                            <i class="mdi mdi-account-settings-variant mr-1"></i> Cập Nhật
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card-box ribbon-box">
                    <div class="ribbon ribbon-dark">THU NHẬP</div>
                    <p class="m-b-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                </div>
            </div>
        </div>


    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
        });
    });
</script>