
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GH</a></li>
                            <li class="breadcrumb-item"><a href="#">Bài Đăng Tư Vấn</a></li>
                            <li class="breadcrumb-item active">Chỉnh Sửa</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger"><?= $post['title'] ?></h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <?php
                if($this->session->has_userdata('fast_notify')):
                    ?>
                    <div class="alert alert-<?= $this->session->flashdata('fast_notify')['status']?> alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('fast_notify')['message']?>
                    </div>
                    <?php unset($_SESSION['fast_notify']); endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card-box">
                    <h4 class="text-danger font-weight-bold">Chọn bài đăng khác</h4>
                    <form action="">
                        <div class="form-group row">
                            <div class="col-md-9 col-12">
                                <select name="id" class="select2 form-control">
                                    <option value="" disabled> - Chỉnh Sửa Bài Đăng Khác - </option>
                                    <?php foreach ($list_post as $item): ?>
                                        <option value="<?= $item['id'] ?>"> <?= $item['title'] ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col ">
                                <button type="submit" class="btn btn-primary waves-effect pull-right waves-light">
                                    Chọn bài đăng
                                </button>
                            </div>
                        </div>
                        <hr>
                    </form>

                    <h4 class="text-danger mt-3 font-weight-bold">Sửa bài đăng: <?= $post['title'] ?></h4>
                    <form role="form" method="post" action="">
                        <div class="form-group row">
                            <label class="col-md-4 col-12 col-form-label font-weight-bold">Tiêu Đề</label>
                            <div class="col-md-12 col-12">
                                <input value="<?= $post['title'] ?>" type="text" class="form-control" required name="title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-12 col-form-label font-weight-bold">Mô Tả</label>
                            <div class="col-md-12 col-12">
                                <textarea name="content" rows="10" id="summernote"><?= $post['content'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col text-center">
                                <a href="/admin/consultant-post/your-list">
                                <button type="button" class="btn btn-secondary waves-effect waves-light">
                                    Danh Sách Bài Đăng Tư Vấn
                                </button>
                                </a>
                                <button type="submit" name="submit" class="btn btn-danger waves-effect waves-light">
                                    Cập Nhật
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>

                    <h4 class="text-danger mt-3 font-weight-bold">Thông tin phòng</h4>
                    <div class="form-row">
                        <div class="form-group col-md-4">

                            <div class="mt-2">
                                <label class="col-form-label">Mã phòng</label>
                                <input type="email" class="form-control" readonly value="<?= $room['code'] ?>">
                            </div>
                        </div>

                        <div class="form-group col-md-4">

                            <div class="mt-2">
                                <label class="col-form-label">Giá thuê</label>
                                <input type="email" class="form-control" readonly value="<?= $room['price'] ?>">
                            </div>
                        </div>
                    </div>
                    <hr>

                    <h4 class="text-danger mt-3 font-weight-bold">Thông tin dịch vụ - tự động thay đổi khi QLDA có điều chỉnh</h4>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="mt-2">
                                <label class="col-form-label">Điện</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['electricity'] ?>">
                            </div>
                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Nước</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['water'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Internet</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['internet'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Thang máy</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['elevator'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Máy giặt</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['washing_machine'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Dọn phòng</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['washing_machine'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Giữ xe</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['parking'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Giữ xe</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['parking'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Bãi Xe Ô Tô</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['car_park'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Bãi Xe Ô Tô</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['car_park'] ?>">
                            </div>

                        </div>
                        <div class="form-group col-md-4">
                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Phí Quản Lý</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['management_fee'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Combo Phí</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['extra_fee'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Cọc Phòng</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['deposit'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Hoa Hồng 12 Tháng</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['commission_rate'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Hoa Hồng 9 Tháng</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['commission_rate_9m'] ?>">
                            </div>

                            <div class="mt-2">
                                <label for="inputEmail4" class="col-form-label">Hoa Hồng 6 Tháng</label>
                                <input type="email" class="form-control" readonly value="<?= $apartment['commission_rate_6m'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">

    commands.push(function() {
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true
            });

            $('.select2').select2();

        });
    });
</script>