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
                    <h3 class="page-title">Danh sách quận</h3>
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
            <div class="col-12 col-md-7">
                <div class="card-box table-responsive">
                    <table id="table-district" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Dự Án</th>
                            <th>Cũ</th>
                            <th class="text-center">Mới</th>
                            <th class="text-center">Hành Động</th>
                            <th class="text-center">Thời Gian</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list_track as $row ):
                            $old_content = json_decode($row['old_content'], true);
                            $new_content = json_decode($row['modified_content'], true);
                            $diff = array_diff($old_content,$new_content);
                            if(isset($diff['time_update'])) {
                                unset($diff['time_update']);
                            }

                            ?>
                            <tr>
                                <td>
                                    <div class="district-name"
                                         data-pk="<?= $row['id'] ?>"
                                         data-name="name">
                                        <?= $row['name'] ?>
                                    </div>
                                </td>
                                <td><i>-</i></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="checkbox checkbox-success is-active-district">
                                            <input id="district-<?= $row['id'] ?>"
                                                   value="<?= $row['active'] ?>"
                                                   type="checkbox"
                                                <?= $row['active'] =='YES' ? 'checked':'' ?>>
                                            <label for="district-<?= $row['id'] ?>">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary"><?= $row['note'] ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button id='district-del-<?= $row['id'] ?>' class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect delete-district">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0">Thêm mới</h4>
                    <form role="form" method="post" action="<?= base_url()?>admin/create-district">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Tên quận<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                       id="name" name="name" placeholder="Tên quận">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">CODE<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <input type="text" required class="form-control"
                                       id="code" name="code" placeholder="CODE">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở quận này<span class="text-danger">*</span></label>
                            <div class="col-8">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <input id="active" type="checkbox" value="YES" name="active">
                                        <label for="active">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Mô tả</label>
                            <div class="col-8">
                                <textarea class="form-control" rows="5" name="note" placeholder="Không bắt buộc"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
