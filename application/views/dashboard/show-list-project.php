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
                    <h2 class="text-danger font-weight-bold">Danh sách Sản Phẩm</h2>
                </div>
            </div>
        </div>


        <div class="row text-center">
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div
                    class="card-box widget-flat border-danger bg-danger text-white"
                >
                    <i class="fi-tag"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="/admin/list-apartment">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            Căn Hộ Dịch Vụ
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div
                    class="card-box bg-secondary widget-flat border-secondary text-white"
                >
                    <i class="fi-archive"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="/home-town/show">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            Nhà Phố
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div
                    class="card-box widget-flat border-primary bg-primary text-white"
                >
                    <i class="fi-help"></i>
                    <h3 class="m-b-10">9999</h3>
                    <a href="#">
                        <p class="text-uppercase text-light m-b-5 font-13 font-600">
                            Share
                        </p>
                    </a>

                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div
                    class="card-box bg-danger widget-flat border-danger text-white"
                >
                    <i class="fi-delete"></i>
                    <h3 class="m-b-10">250</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">
                        ...
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    commands.push(function () {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });

        $('.navbar-custom').hide();
    });
</script>