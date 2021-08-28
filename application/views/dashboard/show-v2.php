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
                    <h2 class="text-danger font-weight-bold">Bảng điều khiển V2</h2>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <!--['team', 'district','brand','member']-->
                        <a href="/admin/dashboard/show/sale?target=district"  class="nav-link <?= $target == 'district' ? 'active' : '' ?>">
                            <i class="fi-monitor mr-2"></i> Quận
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/dashboard/show/sale?target=brand"  class="nav-link <?= $target == 'brand' ? 'active' : '' ?>">
                            <i class="fi-monitor mr-2"></i> Thương hiệu hợp tác
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/dashboard/show/sale?target=team" class="nav-link <?= $target == 'team' ? 'active' : '' ?>">
                            <i class="fi-monitor mr-2"></i> Đội nhóm
                        </a>
                    </li>
                </ul>

                <div class="card-box ">
                    <div class="tab-content">
                        <div class="tab-pane show active">
                            <form class="row">
                                <input type="hidden" name="target" value="<?= $target ?>">
                                <div class="col-3">
                                    <input type="text" class="form-control datepicker" name="from_time" value="<?= $from_time ?>">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control datepicker" name="to_time" value="<?= $to_time ?>">
                                </div>
                                <div class="col-3">
                                    <button type="submit" class="btn btn-danger">Áp dụng</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>


        <div class="row">
            <?php $this->load->view($view_head1); ?>

        </div>
    </div>
</div>
<script>
    commands.push(function () {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy"
        });
    });
</script>